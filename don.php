<?php
$pageTitle = "Faire un don – Association Pour Nour";
include 'partials/head.php';
include 'partials/header.php';
?>

<main class="page-don">

    <!-- HERO -->
    <section class="don-hero">
        <h1>Faire un don</h1>
        <p>Votre soutien nous permet d’accompagner les familles touchées par la perte périnatale
            et de faire vivre les actions de l'association.</p>
    </section>

    <!-- FORMULAIRE DE DON -->
    <section class="don-section">
        <div class="don-wrapper">

            <h2 class="don-title">Votre don</h2>

            <form action="choix-paiement.php" method="post" class="don-form">

                <!-- Montant  fixe du don -->
                <label for="montant">Choisissez le montant de votre don</label>
                <select name="montant" id="montant" required>
                    <option value="">Sélectionner un montant…</option>
                    <option value="1">1 €</option>
                    <option value="2">2 €</option>
                    <option value="5">5 €</option>
                    <option value="10">10 €</option>
                    <option value="20">20 €</option>
                    <option value="50">50 €</option>
                    <option value="100">100 €</option>
                    <option value="200">200€</option>
                </select>

                <!-- Nom -->
                <label for="nom">Votre nom</label>
                <input type="text" id="nom" name="nom" required>

                <!-- Prénom -->
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

    <!-- BLOC VERS LA BOUTIQUE -->
    <section class="don-support-section">
        <div class="don-support-box">
            <h2>Soutenir autrement l'association</h2>
            <p>
                Vous pouvez également soutenir Pour Nour en découvrant notre boutique solidaire et le livre <strong>"Nour, lumière de nos vies"</strong>.
            </p>
            <a href="boutique.php" class="btn btn-secondary">Découvrir la boutique</a>
        </div>
    </section>

</main>

<script src="https://js.stripe.com/v3/"></script>
<script src="/js/don.js"></script>

<?php include 'partials/footer.php'; ?>
