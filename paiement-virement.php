<?php
session_start();
if (!isset($_SESSION['don'])) {
    header("Location: don.php");
    exit;
}

$don = $_SESSION['don'];
?>

<?php include 'partials/head.php'; ?>
<?php include 'partials/header.php'; ?>

<main class="page-don">

    <section class="don-section virement">
        <h2>Virement bancaire</h2>

        <p>Merci <strong><?= htmlspecialchars($don["prenom"]) ?></strong> ❤️</p>
        <p>Pour finaliser votre don de <strong><?= $don["montant"] ?>€</strong>, veuillez effectuer un virement avec les informations suivantes :</p>

        <div class="rib-box">
            <p><strong>Titulaire :</strong> Association Pour Nour</p>
            <p><strong>IBAN :</strong> FR76 1234 5678 9123 4567 8901 234</p>
            <p><strong>BIC :</strong> AGRIFRPPXXX</p>
            <p><strong>Motif :</strong> Don <?= date("Y") ?> - <?= $don["nom"] ?></p>
        </div>

        <p>Une fois votre virement effectué, vous recevrez un email de confirmation.</p>

        <a href="paiement-success.php" class="btn btn-primary">J'ai réalisé le virement</a>

    </section>

</main>
