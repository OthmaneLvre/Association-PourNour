<?php
session_start();

// Vérifier que le formulaire a bien envoyé des données
if (!isset($_POST["montant"])) {
    // Si quelqu'un arrive ici sans avoir passé le formulaire → retour à la page don
    header("Location: don.php");
    exit;
}

// Enregistrer les informations du don dans la session
$_SESSION["don"] = [
    "montant" => $_POST["montant"],
    "nom" => $_POST["nom"],
    "prenom" => $_POST["prenom"],
    "email" => $_POST["email"],
    "message" => $_POST["message"]
];

$pageTitle = "Choisir le paiement – Pour Nour";
include 'partials/head.php';
include 'partials/header.php';
?>

<main class="page-choix-paiement">

    <section class="choix-wrapper">
        <h1>Choisissez votre moyen de paiement</h1>

        <p>Montant du don : <strong><?= $_SESSION["don"]["montant"] ?> €</strong></p>

        <div class="choix-buttons">
            <a href="paiement-stripe.php" class="btn btn-primary">💳 Stripe</a>
            <a href="paiement-paypal.php" class="btn btn-secondary">🅿️ PayPal</a>
            <a href="paiement-virement.php" class="btn btn-secondary">🏦 Virement bancaire</a>
        </div>
    </section>

</main>

<?php include 'partials/footer.php'; ?>
