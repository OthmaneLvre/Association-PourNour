<?php 
$pageTitle = "Contact | Pour Nour";
include 'partials/head.php';
include 'partials/header.php';
?>

<main>
    <!-- SECTION 1 : Contact -->

    <section class="contact-section">
        <div class="contact-wrapper">

            <div class="contact-text">
                <h1 class="contact-title">Contactez-nous</h1>

                <p>
                    Nous sommes là pour vous écouter, vous accompagner et répondre à vos questions avec douceur.
                </p>

                <a href="/Association-PourNour/adherer.php" class="btn btn-secondary">
                    Contactez-nous
                </a>
            </div>
        </div>
    </section>

    <!-- SECTION 2 : Détails Contact -->

    <section class="details-contact">
        <div class="details-contact-wrapper">

            <!-- COLONNE EMAIL -->
            <div class="contact-col">
                <img src="/Association-PourNour/assets/icons/mail.svg" class="contact-icon">
                <h2>Email</h2>
                <p>contact@associationpournour.fr</p>
            </div>

            <!-- COLONNE TÉLÉPHONE -->
            <div class="contact-col">
                <img src="/Association-PourNour/assets/icons/phone.svg" class="contact-icon">
                <h2>Téléphone</h2>
                <p>07 00 00 00 00</p>
            </div>

            <!-- COLONNE ADRESSE -->
            <div class="contact-col">
                <img src="/Association-PourNour/assets/icons/location.svg" class="contact-icon">
                <h2>Adresse</h2>
                <p>123 Rue du Doux Souvenir<br>66000 Céret</p>
            </div>

        </div>
    </section>


            <!-- SECTION 3 : Formulaire contact -->

    <section class="form-contact-section">
        <div class="form-contact-wrapper">

            <div class="form-contact-text">
                <h2 class="form-contact-title">Formulaire d'adhésion</h2>



                <div class="card-form">
                    <form action="" method="post">
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

                        <!-- Sujet -->
                        <label for="type">Type d’adhésion</label>
                        <select id="type" name="type_adhesion" required>
                            <option value="">Sélectionner…</option>
                            <option value="information">Demande d'information</option>
                            <option value="encouragement">Encouragement</option>
                        </select>

                        <!-- Message -->
                        <label for="message">Message (optionnel)</label>
                        <textarea id="message" name="message"></textarea>

                        <!-- Bouton -->
                        <button type="submit" class="btn btn-secondary">Envoyer</button>

                        <p>
                            Vos informations resteront strictement confidentielles et ne seront utilisées que pour la gestion de votre adhésion.
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>

        <!-- SECTION 4 : SOUTENIR L'ASSOCIATION -->
    <section class="support-section">
        <div class="support-wrapper">
            <div class="support-text">
                <h2 class="support-title">Vous souhaitez soutenir l’association ?</h2>
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

