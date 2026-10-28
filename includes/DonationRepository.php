<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

final class DonationRepository
{
    public function create(
        string $firstName,
        string $lastName,
        string $email,
        int $amountEuros,
        string $submissionToken
    ): array {
        if (!preg_match('/\A[a-f0-9]{64}\z/D', $submissionToken)) {
            throw new InvalidArgumentException(
                'Jeton de soumission invalide.'
            );
        }

        if ($amountEuros <= 0) {
            throw new InvalidArgumentException(
                'Montant du don invalide.'
            );
        }

        $pdo = getDatabaseConnection();

        $existing = $this->findBySubmissionToken($submissionToken);

        if ($existing !== null) {
            return $this->existingDonationResult(
                $existing,
                $amountEuros,
                $firstName,
                $lastName,
                $email,
            );
        }

        $reference = 'DON-' . strtoupper(
            bin2hex(random_bytes(12))
        );

        try {
            $pdo->beginTransaction();

            $donor = $pdo->prepare(
                'INSERT INTO donors
                    (first_name, last_name, email)
                 VALUES
                    (:first_name, :last_name, :email)'
            );

            $donor->execute([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
            ]);

            $donorId = (int) $pdo->lastInsertId();

            $transaction = $pdo->prepare(
                'INSERT INTO transactions
                    (
                        reference,
                        transaction_type,
                        donor_id,
                        amount_cents,
                        currency,
                        payment_status,
                        submission_token
                    )
                 VALUES
                    (
                        :reference,
                        :transaction_type,
                        :donor_id,
                        :amount_cents,
                        :currency,
                        :payment_status,
                        :submission_token
                    )'
            );

            $transaction->execute([
                'reference' => $reference,
                'transaction_type' => 'donation',
                'donor_id' => $donorId,
                'amount_cents' => $amountEuros * 100,
                'currency' => 'EUR',
                'payment_status' => 'pending',
                'submission_token' => $submissionToken,
            ]);

            $transactionId = (int) $pdo->lastInsertId();

            $pdo->commit();

            return [
                'id' => $transactionId,
                'reference' => $reference,
                'amount_cents' => $amountEuros * 100,
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
                    return $this->existingDonationResult(
                        $existing,
                        $amountEuros,
                        $firstName,
                        $lastName,
                        $email
                    );
                }
            }

            throw $exception;
        }
    }

    public function findBySubmissionToken(string $token): ?array
    {
        $pdo = getDatabaseConnection();

        $stmt = $pdo->prepare(
            'SELECT
                t.id,
                t.reference,
                t.amount_cents,
                t.payment_status,
                t.transaction_type,
                d.first_name,
                d.last_name,
                d.email
             FROM transactions t
             LEFT JOIN donors d ON d.id = t.donor_id
             WHERE t.submission_token = :token
             LIMIT 1'
        );

        $stmt->execute([
            'token' => $token,
        ]);

        $result = $stmt->fetch();

        return $result ?: null;
    }

    private function existingDonationResult(
        array $existing,
        int $amountEuros,
        string $firstName,
        string $lastName,
        string $email
    ): array {
        if (
            $existing['transaction_type'] !== 'donation'
            || (int) $existing['amount_cents'] !== $amountEuros * 100
            || $existing['first_name'] !== $firstName
            || $existing['last_name'] !== $lastName
            || $existing['email'] !== $email
        ) {
            throw new RuntimeException(
                'Ce jeton est déjà associé à une autre opération.'
            );
        }

        return [
            'id' => (int) $existing['id'],
            'reference' => $existing['reference'],
            'amount_cents' => (int) $existing['amount_cents'],
            'status' => $existing['payment_status'],
        ];
    }

}
