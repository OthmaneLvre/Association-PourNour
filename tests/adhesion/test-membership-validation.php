<?php
declare(strict_types=1);

require_once __DIR__ . '/../../includes/MembershipRepository.php';

$repository = new MembershipRepository();
$pdo = getDatabaseConnection();

$validMember = [
    'first_name' => 'Test',
    'last_name' => 'Validation',
    'email' => 'validation@example.com',
];

$token = static fn(): string => bin2hex(random_bytes(32));

$cases = [
    'Formule inconnue' => [
        'unknown', [$validMember], $token()
    ],
    'Solo avec deux adherents' => [
        'solo', [$validMember, $validMember], $token()
    ],
    'Couple avec un adherent' => [
        'couple', [$validMember], $token()
    ],
    'Email principal absent' => [
        'solo',
        [array_replace($validMember, ['email' => ''])],
        $token()
    ],
    'Email invalide' => [
        'solo',
        [array_replace($validMember, ['email' => 'invalide'])],
        $token()
    ],
    'Consentement invalide' => [
        'solo',
        [array_replace(
            $validMember,
            ['contact_sms_opt_in' => 'yes']
        )],
        $token()
    ],
    'Jeton invalide' => [
        'solo', [$validMember], 'invalid-token'
    ],
];

$before = (int) $pdo
    ->query('SELECT COUNT(*) FROM transactions')
    ->fetchColumn();

foreach ($cases as $label => [$type, $members, $submissionToken]) {
    try {
        $repository->create($type, $members, $submissionToken);

        throw new RuntimeException(
            'ECHEC : demande acceptee - ' . $label
        );
    } catch (InvalidArgumentException $exception) {
        echo "OK - {$label}\n";
    }
}

$after = (int) $pdo
    ->query('SELECT COUNT(*) FROM transactions')
    ->fetchColumn();

if ($before !== $after) {
    throw new RuntimeException(
        'ECHEC : des transactions ont ete creees.'
    );
}

echo "OK - Aucune transaction supplementaire\n";
