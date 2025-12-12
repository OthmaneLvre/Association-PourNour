<?php
$pageTitle = "Faire un don – Association Pour Nour";
include 'partials/head.php';
include 'partials/header.php';
?>

<main class="page-don">

    <!-- HERO -->
    <section class="don-hero">
        <h1>Faire un don</h1>
        <p>Votre soutien nous permet d’accompagner les familles touchées par la perte périnatale.</p>
    </section>

    <!-- FORMULAIRE DE DON -->
    <section class="don-section">
        <div class="don-wrapper">

            <h2 class="don-title">Votre don</h2>

            <form action="choix-paiement.php" method="post" class="don-form">

                <!-- Montant -->
                <label for="montant">Montant du don</label>
                <input type="number" name="montant" id="montant" placeholder="Ex : 20" required>

                <!-- Type de don -->
                <label for="type_don">Type de don</label>
                <select name="type_don" id="type_don" required>
                    <option value="">Sélectionner…</option>
                    <option value="ponctuel">Don ponctuel</option>
                    <option value="mensuel">Don mensuel</option>
                </select>

                <!-- Nom -->
                <label for="nom">Votre nom</label>
                <input type="text" id="nom" name="nom" required>

                <!-- Prénomom -->
                <label for="prénom">Votre Prénom</label>
                <input type="text" id="prenom" name="prenom" required>

                <!-- Email -->
                <label for="email">Votre e-mail</label>
                <input type="email" id="email" name="email" required>

                <!-- Message -->
                <label for="message">Message (optionnel)</label>
                <textarea name="message" id="message"></textarea>

                <!-- Bouton -->
                <button type="submit" class="btn btn-primary">Procéder au paiement</button>

            </form>

        </div>
    </section>

</main>

<script src="https://js.stripe.com/v3/"></script>
<script src="/js/don.js"></script>

<?php include 'partials/footer.php'; ?>
