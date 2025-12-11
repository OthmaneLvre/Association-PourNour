<?php 
$pageTitle = "Adhérer | Pour Nour";
include 'partials/head.php';
include 'partials/header.php';
?>

<main class="page-adherer">

    <!-- SECTION 1 : Adhérer -->

    <section class="join-section">
        <div class="join-wrapper">

            <div class="join-text">
                <h1 class="join-title">Adhérer à association</h1>

                <p>
                    Parce que la perte d’un bébé est une épreuve immense, souvent silencieuse, souvent invisible.<br>
                    Parce que trop de familles traversent ce moment sans accompagnement, sans ressources, sans même savoir vers qui se tourner.<br>
                    Pour Nour existe pour briser ce silence avec douceur, pour offrir un espace d’écoute, pour soutenir, informer et illuminer le chemin de celles et ceux touchés par la perte périnatale.<br><br>
                    Une association née pour que plus jamais aucune famille n’avance seule.
                </p>

                <a href="/Association-PourNour/adherer.php" class="btn btn-secondary">
                    Adhérer
                </a>
            </div>

        </div>
    </section>

    <!-- SECTION 2 : Pourquoi adhérer ? -->

    <section class="whyjoin-section">
        <div class="whyjoin-wrapper">

            <div class="whyjoin-text">
                <h2 class="whyjoin-title">Pourquoi adhérer ?</h2>

                <p>
                    Adhérer, c’est soutenir une mission d’amour et de lumière.<br>
                    <strong>Votre adhésion permet :</strong><br>
                    <ul class="list">
                        <li>d’accompagner les familles</li> 
                        <li>de créer des ressources et des actions de sensibilisation</li>
                        <li>de rendre visibles les histoires de ces bébés trop tôt partis</li>
                        <li>de maintenir une écoute bienveillante et accessible</li>                        
                    </ul>
                </p>


                <div class="adhesion-cards">

                <!-- CARD 1 -->
                <div class="adhesion-card">
                    <div class="adhesion-header">
                        <img src="/Association-PourNour/assets/icons/seul.webp" alt="Icône seul" class="adhesion-icon">
                        <h3 class="adhesion-heading">Adhésion Solo</h3>
                    </div>

                    <div class="adhesion-text">
                        <p class="label-price">
                            <strong>Prix :</strong>
                        </p>

                        <p class="price">
                            15 € / an
                        </p>
                        <a href="/Association-PourNour/adherer.php" class="btn btn-secondary">
                            Adhérer
                        </a>
                    </div>

                </div>

                <!-- CARD 2 -->
                <div class="adhesion-card">
                    <div class="adhesion-header">
                        <img src="/Association-PourNour/assets/icons/couple.webp" alt="Icône couple" class="adhesion-icon">
                        <h3 class="adhesion-heading">Adhésion Couple</h3>
                    </div>
                    <div class="adhesion-text">
                        <p class="label-price">
                            <strong>Prix :</strong>
                        </p>

                        <p class="price">
                            15 € / an
                        </p>
                        
                        <a href="/Association-PourNour/adherer.php" class="btn btn-secondary">
                            Adhérer
                        </a>
                    </div>

                </div>

                <!-- CARD 3 -->
                <div class="adhesion-card">
                    <div class="adhesion-header">
                        <img src="/Association-PourNour/assets/icons/bienfaiteur.webp" alt="Icône bienfaiteur" class="adhesion-icon">
                        <h3 class="adhesion-heading">Soutien Bienfaiteur</h3>
                    </div>

                    <div class="adhesion-text">
                        <p class="label-price">
                            <strong>Prix :</strong>
                        </p>

                        <p class="price">
                            A partir de 1 €
                        </p>
                        <a href="/Association-PourNour/don.php" class="btn btn-secondary">
                            Soutenir
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </section>

        <!-- SECTION 3 : Formulaire Adhésion -->

    <section class="form-adhesion-section">
        <div class="form-adhesion-wrapper">

            <div class="form-adhesion-text">
                <h2 class="form-adhesion-title">Formulaire d'adhésion</h2>

                <p>
                    Vos informations resteront strictement confidentielles et ne seront utilisées que pour la gestion de votre adhésion.
                </p>

                <div class="card-form">
                    <form action="adhesion-traitement.php" method="post">
                        <!-- Nom -->
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" required>

                        <!-- Prénom -->
                        <label for="prenom">Prénom</label>
                        <input type="text" id="prenom" name="prenom" required>

                        <!-- Email -->
                        <label for="email">Adresse e-mail</label>
                        <input type="email" id="email" name="email" required>

                        <!-- Téléphone -->
                        <label for="telephone">Téléphone (optionnel)</label>
                        <input type="text" id="telephone" name="telephone">

                        <!-- Adresse postale -->
                        <label for="adresse">Adresse postale (optionnel)</label>
                        <input type="text" id="adresse" name="adresse">

                        <!-- Type adhésion -->
                        <label for="type">Type d’adhésion</label>
                        <select id="type" name="type_adhesion" required>
                            <option value="">Sélectionner…</option>
                            <option value="solo">Seul</option>
                            <option value="duo">Couple</option>
                        </select>

                        <!-- Message -->
                        <label for="message">Message (optionnel)</label>
                        <textarea id="message" name="message"></textarea>

                        <!-- Bouton -->
                        <button type="submit" class="btn btn-secondary">Adhérer</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

        <!-- SECTION 4 : SOUTENIR L'ASSOCIATION -->
    <section class="support-adhesion-section">
        <div class="support-adhesion-wrapper">
            <div class="support-adhesion-text">
                <h2 class="support-adhesion-title">Merci pour votre soutien</h2>

                <p>
                    Grâce à vous, d’autres familles pourront être accompagnées avec douceur et lumière.
                </p>

            </div>

            <div class="support-adhesion-button">
                <a href="/adhesion.php" class="btn btn-secondary">Adhérer</a>
            </div>

        </div>
    </section>
    

</main>

<?php
include 'partials/footer.php'
?>
