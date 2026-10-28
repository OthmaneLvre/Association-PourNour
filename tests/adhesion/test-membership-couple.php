<?php
declare(strict_types=1);

require_once __DIR__ . '/../../includes/MembershipRepository.php';

$repository = new MembershipRepository();

$token = bin2hex(random_bytes(32));

$members = [
    [
        'first_name' => 'Test',
        'last_name' => 'CouplePrincipal',
        'email' => 'test-couple@example.com',
        'phone' => '0600000000',
        'address_line1' => '1 rue du Test',
        'postal_code' => '66400',
        'city' => 'Ceret',
        'contact_email_opt_in' => true,
        'contact_sms_opt_in' => false,
        'contact_postal_opt_in' => false,
    ],
    [
        'first_name' => 'Test',
        'last_name' => 'CoupleSecondaire',
        'email' => null,
        'phone' => null,
        'address_line1' => '1 rue du Test',
        'postal_code' => '66400',
        'city' => 'Ceret',
        'contact_email_opt_in' => false,
        'contact_sms_opt_in' => false,
        'contact_postal_opt_in' => false,
    ],
];

$first = $repository->create('couple', $members, $token);
$second = $repository->create('couple', $members, $token);

if ($first !== $second) {
    throw new RuntimeException(
        'Echec : double soumission non idempotente.'
    );
}

$pdo = getDatabaseConnection();

$stmt = $pdo->prepare(
    'SELECT
        t.transaction_type,
        t.amount_cents,
        t.payment_status,
        m.membership_type,
        COUNT(mm.member_id) AS member_count,
        SUM(mm.member_role = "primary") AS primary_count,
        SUM(mm.member_role = "secondary") AS secondary_count,
        SUM(mem.email IS NULL) AS null_email_count
     FROM transactions t
     INNER JOIN memberships m
        ON m.id = t.membership_id
     INNER JOIN membership_members mm
        ON mm.membership_id = m.id
     INNER JOIN members mem
        ON mem.id = mm.member_id
     WHERE t.id = :transaction_id
     GROUP BY
        t.id,
        t.transaction_type,
        t.amount_cents,
        t.payment_status,
        m.membership_type'
);

$stmt->execute([
    'transaction_id' => $first['id'],
]);

$result = $stmt->fetch();

if (
    !$result
    || $result['transaction_type'] !== 'membership'
    || $result['membership_type'] !== 'couple'
    || (int) $result['amount_cents'] !== 1500
    || $result['payment_status'] !== 'pending'
    || (int) $result['member_count'] !== 2
    || (int) $result['primary_count'] !== 1
    || (int) $result['secondary_count'] !== 1
    || (int) $result['null_email_count'] !== 1
) {
    throw new RuntimeException(
        'Echec : donnees Couple incoherentes.'
    );
}

echo "OK - Adhesion Couple 15 EUR\n";
echo "Transaction : {$first['reference']}\n";
echo "Adherents : {$result['member_count']}\n";
echo "Email secondaire facultatif : OK\n";
echo "Idempotence : OK\n";
