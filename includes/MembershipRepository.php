<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/membership-security.php';

final class MembershipRepository
{
    public function create(
        string $membershipType,
        array $members,
        string $submissionToken
    ): array {
        $amountCents = membershipAmountCents($membershipType);

        if ($amountCents === null) {
            throw new InvalidArgumentException(
                'Formule d’adhésion invalide.'
            );
        }

        $expectedCount = $membershipType === 'couple' ? 2 : 1;

        if (count($members) !== $expectedCount) {
            throw new InvalidArgumentException(
                'Nombre d’adhérents invalide pour cette formule.'
            );
        }

        if (!preg_match('/\A[a-f0-9]{64}\z/D', $submissionToken)) {
            throw new InvalidArgumentException(
                'Jeton de soumission invalide.'
            );
        }

        $validatedMembers = [];

        foreach (array_values($members) as $index => $member) {
            if (!is_array($member)) {
                throw new InvalidArgumentException(
                    'Données d’adhérent invalides.'
                );
            }

            $validatedMembers[] = $this->validateMember(
                $member,
                $index === 0
            );
        }


        $pdo = getDatabaseConnection();

        $existing = $this->findBySubmissionToken($submissionToken);

        if ($existing !== null) {
            return $this->existingMembershipResult(
                $existing,
                $membershipType,
                $amountCents,
                $validatedMembers
            );
        }

        $reference = 'ADH-' . strtoupper(bin2hex(random_bytes(12)));

        try {
            $pdo->beginTransaction();

            $membershipStmt = $pdo->prepare(
                'INSERT INTO memberships
                    (membership_type, amount_cents, status)
                VALUES
                    (:membership_type, :amount_cents, :status)'
            );

            $membershipStmt->execute([
                'membership_type' => $membershipType,
                'amount_cents' => $amountCents,
                'status' => 'pending',
            ]);

            $membershipId = (int) $pdo->lastInsertId();

            $memberStmt = $pdo->prepare(
                'INSERT INTO members (
                    first_name, last_name, email, phone,
                    address_line1, address_line2, postal_code,
                    city, country,
                    contact_email_opt_in, contact_sms_opt_in,
                    contact_postal_opt_in,
                    contact_preferences_updated_at
                ) VALUES (
                    :first_name, :last_name, :email, :phone,
                    :address_line1, :address_line2, :postal_code,
                    :city, :country,
                    :contact_email_opt_in, :contact_sms_opt_in,
                    :contact_postal_opt_in,
                    NOW()
                )'
            );

            $linkStmt = $pdo->prepare(
                'INSERT INTO membership_members
                    (membership_id, member_id, member_role)
                VALUES
                    (:membership_id, :member_id, :member_role)'
            );

            foreach ($validatedMembers as $index => $member) {
                $memberStmt->execute($member);

                $memberId = (int) $pdo->lastInsertId();

                $linkStmt->execute([
                    'membership_id' => $membershipId,
                    'member_id' => $memberId,
                    'member_role' => $index === 0
                        ? 'primary'
                        : 'secondary',
                ]);
            }

            $transactionStmt = $pdo->prepare(
                'INSERT INTO transactions (
                    reference, transaction_type, membership_id,
                    amount_cents, currency, payment_status,
                    submission_token
                ) VALUES (
                    :reference, :transaction_type, :membership_id,
                    :amount_cents, :currency, :payment_status,
                    :submission_token
                )'
            );

            $transactionStmt->execute([
                'reference' => $reference,
                'transaction_type' => 'membership',
                'membership_id' => $membershipId,
                'amount_cents' => $amountCents,
                'currency' => 'EUR',
                'payment_status' => 'pending',
                'submission_token' => $submissionToken,
            ]);

            $transactionId = (int) $pdo->lastInsertId();

            $pdo->commit();

            return [
                'id' => $transactionId,
                'membership_id' => $membershipId,
                'reference' => $reference,
                'amount_cents' => $amountCents,
                'status' => 'pending',
            ];
        } catch (Throwable $exception) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            if (
                $exception instanceof PDOException
                && $exception->getCode() === '23000'
            ) {
                $existing = $this->findBySubmissionToken(
                    $submissionToken
                );

                if ($existing !== null) {
                    return $this->existingMembershipResult(
                        $existing,
                        $membershipType,
                        $amountCents,
                        $validatedMembers
                    );
                }
            }

            throw $exception;
        }

    }

    private function validateMember(
        array $member,
        bool $isPrimary
    ): array {
        $requiredText = static function (
            string $key,
            int $maxLength
        ) use ($member): string {
            $value = $member[$key] ?? '';

            if (!is_string($value)) {
                throw new InvalidArgumentException(
                    'Champ invalide : ' . $key
                );
            }

            $value = trim($value);

            if (
                $value === ''
                || mb_strlen($value) > $maxLength
            ) {
                throw new InvalidArgumentException(
                    'Champ obligatoire invalide : ' . $key
                );
            }

            return $value;
        };

        $optionalText = static function (
            string $key,
            int $maxLength
        ) use ($member): ?string {
            $value = $member[$key] ?? '';

            if ($value === null || $value === '') {
                return null;
            }

            if (!is_string($value)) {
                throw new InvalidArgumentException(
                    'Champ invalide : ' . $key
                );
            }

            $value = trim($value);

            if (mb_strlen($value) > $maxLength) {
                throw new InvalidArgumentException(
                    'Champ trop long : ' . $key
                );
            }

            return $value !== '' ? $value : null;
        };

        $firstName = $requiredText('first_name', 100);
        $lastName = $requiredText('last_name', 100);
        $email = $optionalText('email', 254);

        if ($isPrimary && $email === null) {
            throw new InvalidArgumentException(
                'L’adresse e-mail du premier adhérent est obligatoire.'
            );
        }

        if (
            $email !== null
            && !filter_var($email, FILTER_VALIDATE_EMAIL)
        ) {
            throw new InvalidArgumentException(
                'Adresse e-mail invalide.'
            );
        }

        $phone = $optionalText('phone', 30);
        $addressLine1 = $optionalText('address_line1', 255);
        $addressLine2 = $optionalText('address_line2', 255);
        $postalCode = $optionalText('postal_code', 20);
        $city = $optionalText('city', 150);

        $consent = static function (string $key) use ($member): int {
            $value = $member[$key] ?? false;

            if (
                $value === true
                || $value === 1
                || $value === '1'
            ) {
                return 1;
            }

            if (
                $value === false
                || $value === 0
                || $value === '0'
                || $value === null
            ) {
                return 0;
            }

            throw new InvalidArgumentException(
                'Préférence de communication invalide : ' . $key
            );
        };

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'phone' => $phone,
            'address_line1' => $addressLine1,
            'address_line2' => $addressLine2,
            'postal_code' => $postalCode,
            'city' => $city,
            'country' => 'FR',
            'contact_email_opt_in' => $consent('contact_email_opt_in'),
            'contact_sms_opt_in' => $consent('contact_sms_opt_in'),
            'contact_postal_opt_in' => $consent('contact_postal_opt_in'),
        ];
    }

    private function findBySubmissionToken(string $token): ?array
    {
        $pdo = getDatabaseConnection();

        $stmt = $pdo->prepare(
            'SELECT
                t.id,
                t.reference,
                t.transaction_type,
                t.membership_id,
                t.amount_cents,
                t.payment_status,
                m.membership_type
            FROM transactions t
            LEFT JOIN memberships m
                ON m.id = t.membership_id
            WHERE t.submission_token = :token
            LIMIT 1'
        );

        $stmt->execute([
            'token' => $token,
        ]);

        $result = $stmt->fetch();

        return $result ?: null;
    }

    private function existingMembershipResult(
        array $existing,
        string $membershipType,
        int $amountCents,
        array $validatedMembers
    ): array {
        if (
            $existing['transaction_type'] !== 'membership'
            || $existing['membership_type'] !== $membershipType
            || (int) $existing['amount_cents'] !== $amountCents
            || $existing['membership_id'] === null
        ) {
            throw new RuntimeException(
                'Ce jeton est déjà associé à une autre opération.'
            );
        }

        $pdo = getDatabaseConnection();

        $stmt = $pdo->prepare(
            'SELECT
                m.first_name,
                m.last_name,
                m.email,
                m.phone,
                m.address_line1,
                m.address_line2,
                m.postal_code,
                m.city,
                m.country,
                m.contact_email_opt_in,
                m.contact_sms_opt_in,
                m.contact_postal_opt_in,
                mm.member_role
            FROM membership_members mm
            INNER JOIN members m ON m.id = mm.member_id
            WHERE mm.membership_id = :membership_id
            ORDER BY FIELD(mm.member_role, "primary", "secondary")'
        );

        $stmt->execute([
            'membership_id' => $existing['membership_id'],
        ]);

        $storedMembers = $stmt->fetchAll();

        if (count($storedMembers) !== count($validatedMembers)) {
            throw new RuntimeException(
                'Ce jeton est déjà associé à une autre opération.'
            );
        }

        foreach ($storedMembers as $index => $stored) {
            $expectedRole = $index === 0 ? 'primary' : 'secondary';

            if ($stored['member_role'] !== $expectedRole) {
                throw new RuntimeException(
                    'Incohérence dans les adhérents enregistrés.'
                );
            }

            foreach ($validatedMembers[$index] as $field => $value) {
                $storedValue = $stored[$field] ?? null;

                if (str_starts_with($field, 'contact_') && $field !== 'contact_preferences_updated_at') {
                    $storedValue = (int) $storedValue;
                }

                if ($storedValue !== $value) {
                    throw new RuntimeException(
                        'Ce jeton est déjà associé à des informations différentes.'
                    );
                }
            }
        }

        return [
            'id' => (int) $existing['id'],
            'membership_id' => (int) $existing['membership_id'],
            'reference' => $existing['reference'],
            'amount_cents' => (int) $existing['amount_cents'],
            'status' => $existing['payment_status'],
        ];
    }

}
