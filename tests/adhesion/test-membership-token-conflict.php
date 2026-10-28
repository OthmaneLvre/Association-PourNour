<?php
declare(strict_types=1);

require_once __DIR__ . '/../../includes/MembershipRepository.php';

$repository = new MembershipRepository();
$pdo = getDatabaseConnection();

$token = bin2hex(random_bytes(32));

$members = [
    [
        'first_name' => 'Test',
        'last_name' => 'TokenOriginal',
        'email' => 'test-token@example.com',
    ],
];

$first = $repository->create('solo', $members, $token);

$modifiedMembers = $members;
$modifiedMembers[0]['last_name'] = 'TokenModified';

$conflictRejected = false;

try {
    $repository->create('solo', $modifiedMembers, $token);
} catch (RuntimeException $exception) {
    $conflictRejected = true;
}

if (!$conflictRejected) {
    throw new RuntimeException(
        'ECHEC : le jeton a accepte des informations differentes.'
    );
}

$stmt = $pdo->prepare(
    'SELECT COUNT(*)
     FROM transactions
     WHERE submission_token = :token'
);

$stmt->execute(['token' => $token]);

if ((int) $stmt->fetchColumn() !== 1) {
    throw new RuntimeException(
        'ECHEC : plusieurs transactions utilisent le meme jeton.'
    );
}

$stmt = $pdo->prepare(
    'SELECT m.last_name
     FROM membership_members mm
     INNER JOIN members m ON m.id = mm.member_id
     WHERE mm.membership_id = :membership_id
       AND mm.member_role = :role'
);

$stmt->execute([
    'membership_id' => $first['membership_id'],
    'role' => 'primary',
]);

if ($stmt->fetchColumn() !== 'TokenOriginal') {
    throw new RuntimeException(
        'ECHEC : les donnees de l adherent ont ete modifiees.'
    );
}

echo "OK - Conflit de jeton refuse\n";
echo "OK - Une seule transaction\n";
echo "OK - Donnees initiales preservees\n";
