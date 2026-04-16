<?php
$pageTitle = "Boutique solidaire - Association Pour Nour";
include 'partials/head.php';
include 'partials/header.php';
?>

<main class="page-boutique">

    <!-- HERO -->
    <section class="boutique-hero">
        <h1>Boutique solidaire</h1>
        <p>
            Chaque achat contribue à soutenir les actions de l'assocation Pour Nour
            et à accompagner les familles touchées par la perte périnatale.
        </p>
    </section>

    <!-- PRODUIT PRINCIPAL : LE LIVRE -->
    <section class="boutique-section">
        <div class="boutique-wrapper">

            <div class="product-card">

                <!-- Image (à remplacer par la vraie cover) -->
                <div class="product-image">
                    <img src="assets/images/livre-nour.jpg" alt="Livre Nour lumière de nos vies">
                </div>

                <!-- Infos -->
                <div class="product-content">
                    <h2>Nour, lumière de nos vies</h2>

                    <p class="product-description">
                        Un témoigage intime et bouleversant, né de notre histoire.
                        Ce livre rend hommage à Nour et apporte lumière, douceur et soutien
                        aux familles confrontées à la perte périnatale.
                    </p>

                    <p class="product-price">Prix : 20 €</p>

                    <!-- Bouton achat -->
                    <a href="achat-livre.php" class="btn btn-primary">
                        Acheter le livre
                    </a>
                </div>

            </div>

        </div>
    </section>

    <!-- FUTUR PRODUITS -->
    <section class="boutique-coming">
        <div class="coming-box">
            <h2>D'autres produits arrivent bientôt</h2>
            <p>
                Nous travaillons actuellement sur de nouveaux produits solidaires
                pour continuer à faire vivre l'association.
            </p>
        </div>
    </section>

</main>

<?php include 'partials/footer.php'; ?>