<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/donation-security.php';
require_once __DIR__ . '/includes/DonationRepository.php';

donationStartSession();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!donationValidateCsrf($_POST['csrf_token'] ?? null)) {
        http_response_code(403);
        exit('Session invalide. Rechargez le formulaire de don.');
    }

    $submissionToken = $_POST['submission_token'] ?? null;
    $sessionToken = $_SESSION['don_submission_token'] ?? null;

    if (
        !is_string($submissionToken)
        || !is_string($sessionToken)
        || !preg_match('/\A[a-f0-9]{64}\z/D', $submissionToken)
        || !hash_equals($sessionToken, $submissionToken)
    ) {
        http_response_code(403);
        exit('Jeton de soumission invalide.');
    }

    $montant = donationValidateAmount($_POST['montant'] ?? null);
    $nom = $_POST['nom'] ?? null;
    $prenom = $_POST['prenom'] ?? null;
    $email = $_POST['email'] ?? null;
    $message = $_POST['message'] ?? '';

    $validText = static function (
        mixed $value,
        int $maxLength
    ): bool {
        return is_string($value)
            && trim($value) !== ''
            && mb_strlen(trim($value), 'UTF-8') <= $maxLength;
    };

    $validEmail = is_string($email)
        && strlen($email) <= 254
        && filter_var($email, FILTER_VALIDATE_EMAIL) !== false;

    $validMessage = is_string($message)
        && mb_strlen($message, 'UTF-8') <= 2000;

    if (
        $montant === null
        || !$validText($nom, 100)
        || !$validText($prenom, 100)
        || !$validEmail
        || !$validMessage
    ) {
        http_response_code(422);
        exit('Données invalides. Retournez au formulaire de don.');
    }

    try {
        $repository = new DonationRepository();

        $transaction = $repository->create(
            trim($prenom),
            trim($nom),
            trim($email),
            $montant,
            $submissionToken
        );

        if ($transaction['status'] !== 'pending') {
            http_response_code(409);
            exit('Cette transaction ne peut plus être modifiée.');
        }

        $_SESSION['don'] = [
            'transaction_id' => $transaction['id'],
            'reference' => $transaction['reference'],
            'montant' => $montant,
            'nom' => trim($nom),
            'prenom' => trim($prenom),
            'email' => trim($email),
            'message' => trim($message),
        ];

        unset(
            $_SESSION['don_csrf'],
            $_SESSION['don_submission_token']
        );

        header('Location: choix-paiement.php', true, 303);
        exit;

    } catch (Throwable $exception) {
        error_log(
            'Erreur création don : ' . $exception->getMessage()
        );

        http_response_code(500);
        exit('Une erreur est survenue. Veuillez réessayer.');
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('Allow: GET, POST');
    http_response_code(405);
    exit('Méthode non autorisée.');
}

$don = $_SESSION['don'] ?? null;

if (
    !is_array($don)
    || !isset(
        $don['transaction_id'],
        $don['reference'],
        $don['montant']
    )
) {
    header('Location: don.php', true, 303);
    exit;
}

// Vérification serveur : la transaction doit toujours exister
// et être en attente avant d'afficher les moyens de paiement.
try {
    $pdo = getDatabaseConnection();

    $stmt = $pdo->prepare(
        'SELECT id, reference, amount_cents, payment_status
         FROM transactions
         WHERE id = :id
           AND transaction_type = :type
         LIMIT 1'
    );

    $stmt->execute([
        'id' => $don['transaction_id'],
        'type' => 'donation',
    ]);

    $storedTransaction = $stmt->fetch();

    if (
        !$storedTransaction
        || $storedTransaction['reference'] !== $don['reference']
        || (int) $storedTransaction['amount_cents']
            !== (int) $don['montant'] * 100
        || $storedTransaction['payment_status'] !== 'pending'
    ) {
        unset($_SESSION['don']);

        http_response_code(409);
        exit('Cette transaction n’est plus disponible.');
    }

} catch (Throwable $exception) {
    error_log(
        'Erreur vérification don : ' . $exception->getMessage()
    );

    http_response_code(500);
    exit('Impossible de vérifier la transaction.');
}

$pageTitle = 'Choisir le paiement – Pour Nour';

include_once __DIR__ . '/partials/head.php';
include_once __DIR__ . '/partials/header.php';
?>

<main class="page-choix-paiement">
    <section class="choix-wrapper">

        <h1>Choisissez votre moyen de paiement</h1>

        <p>
            Montant du don :
            <strong>
                <?= donationEscape((string) $don['montant']) ?> €
            </strong>
        </p>

        <p>
            Référence :
            <?= donationEscape($don['reference']) ?>
        </p>

        <div class="choix-buttons">
            <a href="paiement-stripe.php" class="btn btn-primary">
                💳 Stripe
            </a>

            <a href="paiement-paypal.php" class="btn btn-secondary">
                PayPal
            </a>
        </div>

    </section>
</main>

<?php include_once __DIR__ . '/partials/footer.php'; ?>
