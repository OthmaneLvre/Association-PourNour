<?php
$pageTitle = "Accueil | Pour Nour";
include 'partials/head.php';
include 'partials/header.php';
?>


<main class="page-home">
    <!-- ================= HERO ================= -->

    <section class="hero">
        <div class="hero-wrapper">

            <h1 class="hero-title">En mémoire, en amour, en lumière.</h1>

            <img src="/Association-PourNour/assets/logo/logo_WEBP_transparent.webp"
                alt="Pour Nour"
                class="hero-logo">

            <p class="hero-subtext">
                Une association créée pour honorer Nour et accompagner avec douceur les familles touchées par la perte périnatale.
            </p>

            <div class="hero-buttons">
                <a href="/Association-PourNour/adhesion.php" class="btn btn-secondary">Adhérer</a>
                <a href="/Association-PourNour/don.php" class="btn btn-primary">Faire un don</a>
            </div>

        </div>
    </section>

    <!-- ================= QUI SOMMES-NOUS ================= -->
    <section class="about-section">
        <div class="about-wrapper">

            <div class="about-text">
                <h2 class="about-title">Qui sommes-nous ?</h2>

                <p>
                    L’association Pour Nour est née d’un amour infini et d’un
                    besoin profond de donner du sens à l’inimaginable.
                    <br><br>
                    Nous accompagnons les familles touchées par la perte périnatale,
                    en offrant du soutien, de l’écoute, des ressources et des actions
                    de sensibilisation.
                    <br><br>
                    À travers cette association, nous souhaitons honorer la mémoire
                    de Nour et apporter de la douceur, de la lumière et de
                    l'humanité à celles et ceux qui traversent cette épreuve.
                </p>

                <a href="/Association-PourNour/association.php" class="btn btn-primary">
                    L’association
                </a>
            </div>

            <div class="about-image">
                <img src="/Association-PourNour/assets/images/illustration-main.webp" 
                    alt="Illustration main parent et bébé">
            </div>

        </div>
    </section>

    <!-- ================= NOTRE HISTOIRE ================= -->
    <section class="history-section">
        <div class="history-wrapper">

            <!-- Titre avec icône -->
            <div class="history-title-box">
                <img src="/Association-PourNour/assets/icons/book.webp" alt="Icône livre" class="history-icon">
                <h2 class="history-title">Notre histoire</h2>
            </div>

            <!-- Bloc de texte -->
            <div class="history-text-box">

                <p>
                    Notre histoire est celle d’une rencontre infiniment attendue, puis d’un amour qui a grandi au rythme des mois,
                    des battements, des mouvements, des rêves que nous partagions déjà avec notre petite fille, Nour.
                    <br><br>
                    Quinze jours avant le terme, lors de la dernière échographie, le monde s’est soudain arrêté. Une tumeur au cerveau a été
                    détectée, d’une gravité telle que la médecine n’offrait aucune possibilité de survie ni de soulagement pour notre bébé.
                    <br><br>
                    Guidés par l’amour et par le devoir de protéger notre fille de toute souffrance, nous avons dû prendre la décision la plus
                    douloureuse qui soit : une interruption médicale de grossesse. Nour est née et partie le même jour, dans une infinie douceur,
                    entourée de tout notre amour.
                    <br><br>
                    Dans le silence qui a suivi, une évidence s’est imposée : son passage, si court soit-il, ne pouvait pas rester sans lumière.
                    <br>
                    C’est de cette lumière qu’est née l’association Pour Nour.
                </p>

                <div class="history-quote">
                    <em>Pour honorer sa mémoire.</em><br>
                    <em>Pour soutenir les familles confrontées à la perte périnatale.</em><br>
                    <em>Pour que jamais l’amour, le courage et les histoires de ces enfants ne restent invisibles.</em><br>
                    <em>Pour transformer la douleur en douceur, et la douceur en force.</em>
                </div>

            </div>

            <a href="/Association-PourNour/boutique.php" class="btn btn-outline history-book-btn">
                Découvrir notre histoire
            </a>

        </div>
    </section>

    <!-- ================= NOS VALEURS ================= -->
    <section class="values-section">
        <div class="values-wrapper">

            <h2 class="values-title">Nos Valeurs</h2>

            <div class="values-cards">

                <!-- CARD 1 -->
                <div class="value-card">
                    <div class="value-header">
                        <img src="/Association-PourNour/assets/icons/heart.webp" alt="Icône coeur" class="value-icon">
                        <h3 class="value-heading">Amour</h3>
                    </div>

                    <p>
                        Parce que Nour est née de l'amour, et
                        que c'est cet amour qui nous guide pour
                        accompagner, soutenir et transmettre.
                    </p>
                </div>

                <!-- CARD 2 -->
                <div class="value-card">
                    <div class="value-header">
                        <img src="/Association-PourNour/assets/icons/mother.webp" alt="Icône parent" class="value-icon">
                        <h3 class="value-heading">Soutien</h3>
                    </div>

                    <p>
                        Nous offrons un espace d'écoute, de présence
                        et de bienveillance pour les familles traversant
                        l'épreuve de la perte périnatale.
                    </p>
                </div>

                <!-- CARD 3 -->
                <div class="value-card">
                    <div class="value-header">
                        <img src="/Association-PourNour/assets/icons/flame.webp" alt="Icône flamme" class="value-icon">
                        <h3 class="value-heading">Transmission</h3>
                    </div>

                    <p>
                        Partager, informer, sensibiliser : pour que le vécu
                        des parents ne soit jamais invisibilisé et que la
                        mémoire continue de briller.
                    </p>
                </div>

            </div>

        </div>
    </section>

    <!-- ================= SOUTENIR L'ASSOCIATION ================= -->
    <section class="support-section">
        <div class="support-wrapper">

            <h2 class="support-title">Soutenir l’association</h2>

            <div class="support-buttons">
                <a href="/adhesion.php" class="btn btn-secondary">Adhérer</a>
                <a href="/don.php" class="btn btn-primary">Faire un don</a>
            </div>

        </div>
    </section>

</main>

<?php
include 'partials/footer.php';
?>