<?php 
$pageTitle = "L’association | Pour Nour";
include 'partials/head.php';
include 'partials/header.php';
?>

<main class="page-association">

    <!-- SECTION 1 : HERO -->
    <section class="asso-section">

        <div class="asso-wrapper">

            <div class="asso-text">
                <h1 class="asso-title">L’association</h1>

                <p>
                    Une association de l’amour, guidée par la lumière.<br><br>
                    Nous avons créé l’association Pour Nour pour accompagner, soutenir et sensibiliser 
                    les familles touchées par la perte périnatale.
                </p>

            </div>

            <div class="asso-image">
                <img src="/Association-Pournour/assets/images/etoileHero.webp" 
                    alt="étoile" 
                    class="asso-icon"
                    width="400"
                    height="400"
                >
            </div>

        </div>

    </section>

    <!-- SECTION 2 : POURQUOI ? -->

    <section class="why-section">
        <div class="why-wrapper">

            <div class="why-text">
                <h2 class="why-title">Pourquoi cette association ?</h2>

                <p>
                    Parce que la perte d’un bébé est une épreuve immense, souvent silencieuse, souvent invisible.<br>
                    Parce que trop de familles traversent ce moment sans accompagnement, sans ressources, sans même savoir vers qui se tourner.<br>
                    Pour Nour existe pour briser ce silence avec douceur, pour offrir un espace d’écoute, pour soutenir, informer et illuminer le chemin de celles et ceux touchés par la perte périnatale.<br>
                    Une association née pour que plus jamais aucune famille n’avance seule.
                </p>

                <a href="/Association-PourNour/adherer.php" class="btn btn-secondary">
                    Adhérer
                </a>
            </div>

        </div>
    </section>


    
    <!-- SECTION 3 : NOS MISSIONS -->
    <section class="mission-section">
        <div class="mission-wrapper">

            <h2 class="mission-title">Nos Missions</h2>

            <div class="mission-cards">

                <!-- CARD 1 -->
                <div class="mission-card">
                    <div class="mission-header">
                        <img src="/Association-PourNour/assets/icons/accompagner.webp" alt="Icône accompagner" class="mission-icon">
                        <h3 class="mission-heading">Accompagner</h3>
                    </div>

                    <p>
                        Offrir écoute, présence et soutien émotionnel aux familles touchées par la perte périnatale.
                        Leur permettre d’avancer sans solitude, avec douceur et bienveillance.
                    </p>
                </div>

                <!-- CARD 2 -->
                <div class="mission-card">
                    <div class="mission-header">
                        <img src="/Association-PourNour/assets/icons/etoile.webp" alt="Icône étoile" class="mission-icon">
                        <h3 class="mission-heading">Sensibiliser</h3>
                    </div>

                    <p>
                        Faire entendre les voix des parents. Briser les silences autour de la perte périnatale.
                        Pour que ces histoires, ces bébés, cet amour ne soient jamais invisibles.
                    </p>
                </div>

                <!-- CARD 3 -->
                <div class="mission-card">
                    <div class="mission-header">
                        <img src="/Association-PourNour/assets/icons/cercle.webp" alt="Icône cercle" class="mission-icon">
                        <h3 class="mission-heading">Transmettre</h3>
                    </div>

                    <p>
                        Partager ressources, informations, éclairages.
                        Aider les familles et leurs proches à comprendre, avancer, trouver du sens, étape après étape.
                    </p>
                </div>

            </div>

        </div>
    </section>

    <!-- SECTION 4 : SOUTENIR L'ASSOCIATION -->
    <section class="support-section">
        <div class="support-wrapper">
            <div class="support-text">
                <h2 class="support-title">Soutenir l’association</h2>

                <p>
                    Si vous souhaitez aider d’autres familles à traverser cette épreuve avec douceur et lumière,<br>
                    vous pouvez soutenir l’association <strong>Pour Nour</strong> en adhérant ou en faisant un don.<br><br>
                    <strong>Chaque geste compte, et chaque lumière éclaire un chemin.</strong>
                </p>

            </div>



            <div class="support-buttons">
                <a href="/adhesion.php" class="btn btn-secondary">Adhérer</a>
                <a href="/don.php" class="btn btn-primary">Faire un don</a>
            </div>

        </div>
    </section>

</main>

<?php
include 'partials/footer.php'
?>