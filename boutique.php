<?php
$pageTitle = "Boutique solidaire - Association Pour Nour";
include 'partials/head.php';
include 'partials/header.php';
?>

<main class="page-boutique">

    <!-- HERO -->
    <section class="boutique-hero-section">
        <div class="boutique-hero-wrapper">
            <h1 class="boutique-hero-title">Boutique solidaire</h1>
            <p class="boutique-hero-text">
                Chaque achat contribue à soutenir les actions de l'assocation Pour Nour
                et à accompagner les familles touchées par la perte périnatale.
            </p>
        </div>

    </section>

    <!-- PRODUIT PRINCIPAL : LE LIVRE -->
    <section class="boutique-product-section">
        <div class="boutique-product-wrapper">
            
                <!-- Image (à remplacer par la vraie cover) -->
                <div class="boutique-product-image">
                    <img src="assets/images/livre-nour.jpg" alt="Livre Nour lumière de nos vies">
                </div>

                <!-- Infos -->
                <div class="boutique-product-content">
                    <h2 class="boutique-product-title">Nour, lumière de nos vies</h2>

                    <p class="boutique-product-description">
                        Un témoigage intime et bouleversant, né de notre histoire.
                        Ce livre rend hommage à Nour et apporte lumière, douceur et soutien
                        aux familles confrontées à la perte périnatale.
                    </p>

                    <p class="boutique-product-price">Prix : 20 €</p>

                    <!-- Bouton achat -->
                    <a href="achat-livre.php" class="btn btn-primary">
                        Acheter le livre
                    </a>
                </div>

            </div>

        
    </section>

    <!-- FUTUR PRODUITS -->
    <section class="boutique-coming-section">
        <div class="boutique-coming-wrapper">
            <h2 class="boutique-coming-title">D'autres produits arrivent bientôt</h2>
            <p class="boutique-coming-text">
                Nous travaillons actuellement sur de nouveaux produits solidaires
                pour continuer à faire vivre l'association.
            </p>
        </div>
    </section>

</main>

<?php include 'partials/footer.php'; ?>