<?php
declare(strict_types=1);

require_once __DIR__ . '/../../includes/MembershipRepository.php';

$repository = new MembershipRepository();

$token = bin2hex(random_bytes(32));

$members = [
    [
        'first_name' => 'Test',
        'last_name' => 'AdhesionSolo',
        'email' => 'test-solo@example.com',
        'phone' => null,
        'address_line1' => null,
        'address_line2' => null,
        'postal_code' => null,
        'city' => null,
        'contact_email_opt_in' => false,
        'contact_sms_opt_in' => false,
        'contact_postal_opt_in' => false,
    ],
];

$first = $repository->create('solo', $members, $token);
$second = $repository->create('solo', $members, $token);

if ($first !== $second) {
    throw new RuntimeException(
        'Échec : la seconde soumission a retourné un résultat différent.'
    );
}

$pdo = getDatabaseConnection();

$stmt = $pdo->prepare(
    'SELECT
        t.amount_cents,
        t.payment_status,
        t.transaction_type,
        m.membership_type,
        COUNT(mm.member_id) AS member_count
     FROM transactions t
     INNER JOIN memberships m ON m.id = t.membership_id
     INNER JOIN membership_members mm ON mm.membership_id = m.id
     WHERE t.id = :transaction_id
     GROUP BY
        t.id,
        t.amount_cents,
        t.payment_status,
        t.transaction_type,
        m.membership_type'
);

$stmt->execute([
    'transaction_id' => $first['id'],
]);

$result = $stmt->fetch();

if (
    !$result
    || $result['transaction_type'] !== 'membership'
    || $result['membership_type'] !== 'solo'
    || (int) $result['amount_cents'] !== 1000
    || $result['payment_status'] !== 'pending'
    || (int) $result['member_count'] !== 1
) {
    throw new RuntimeException(
        'Échec : données d’adhésion incohérentes.'
    );
}

echo "OK - Adhesion Solo 10 EUR\n";
echo "Transaction : {$first['reference']}\n";
echo "Adherents : {$result['member_count']}\n";
echo "Idempotence : OK\n";
