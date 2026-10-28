<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/membership-security.php';

$pageTitle = "Adhérer | Pour Nour";

include_once 'partials/head.php';
include_once 'partials/header.php';
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

                <a href="#formulaire-adhesion" class="btn btn-secondary">
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
                            10 € / an
                        </p>
                        <a href="#formulaire-adhesion" class="btn btn-secondary">
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
                        
                        <a href="#formulaire-adhesion" class="btn btn-secondary">
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

    <section class="form-adhesion-section" id="formulaire-adhesion">
        <div class="form-adhesion-wrapper">

            <div class="form-adhesion-text">
                <h2 class="form-adhesion-title">Formulaire d'adhésion</h2>

                <p>
                    Vos informations resteront strictement confidentielles et ne seront utilisées que pour la gestion de votre adhésion.
                </p>

                <div class="card-form">
                    <form action="adhesion-traitement.php" method="post">

                        <input
                            type="hidden"
                            name="csrf_token"
                            value="<?= membershipEscape(membershipCsrfToken()) ?>"
                        >

                        <input
                            type="hidden"
                            name="submission_token"
                            value="<?= membershipEscape(membershipSubmissionToken()) ?>"
                        >

                        <fieldset class="adhesion-person">
                            <legend>Adhérent principal</legend>

                            <label for="primary_first_name">Prénom *</label>
                            <input
                                type="text"
                                id="primary_first_name"
                                name="members[0][first_name]"
                                maxlength="100"
                                autocomplete="given-name"
                                required
                            >

                            <label for="primary_last_name">Nom *</label>
                            <input
                                type="text"
                                id="primary_last_name"
                                name="members[0][last_name]"
                                maxlength="100"
                                autocomplete="family-name"
                                required
                            >

                            <label for="primary_email">Adresse e-mail *</label>
                            <input
                                type="email"
                                id="primary_email"
                                name="members[0][email]"
                                maxlength="254"
                                autocomplete="email"
                                required
                            >

                            <label for="primary_phone">Téléphone (facultatif)</label>
                            <input
                                type="tel"
                                id="primary_phone"
                                name="members[0][phone]"
                                maxlength="30"
                                autocomplete="tel"
                            >

                            <label for="primary_address">Adresse postale (facultative)</label>
                            <input
                                type="text"
                                id="primary_address"
                                name="members[0][address_line1]"
                                maxlength="255"
                                autocomplete="street-address"
                            >

                            <label for="primary_postal_code">Code postal (facultatif)</label>
                            <input
                                type="text"
                                id="primary_postal_code"
                                name="members[0][postal_code]"
                                maxlength="20"
                                autocomplete="postal-code"
                            >

                            <label for="primary_city">Ville (facultative)</label>
                            <input
                                type="text"
                                id="primary_city"
                                name="members[0][city]"
                                maxlength="150"
                                autocomplete="address-level2"
                            >

                            <div class="adhesion-consents">
                                <p>
                                    <strong>Préférences de communication</strong>
                                </p>

                                <p>
                                    Souhaitez-vous recevoir les actualités et informations
                                    de l'association Pour Nour ?
                                </p>

                                <label for="primary_consent_email">
                                    <input
                                        type="checkbox"
                                        id="primary_consent_email"
                                        name="members[0][contact_email_opt_in]"
                                        value="1"
                                    >
                                    Par e-mail
                                </label>

                                <label for="primary_consent_sms">
                                    <input
                                        type="checkbox"
                                        id="primary_consent_sms"
                                        name="members[0][contact_sms_opt_in]"
                                        value="1"
                                    >
                                    Par SMS
                                </label>

                                <label for="primary_consent_postal">
                                    <input
                                        type="checkbox"
                                        id="primary_consent_postal"
                                        name="members[0][contact_postal_opt_in]"
                                        value="1"
                                    >
                                    Par courrier postal
                                </label>

                                <p class="adhesion-consents-info">
                                    Ces choix sont facultatifs et indépendants de votre adhésion.
                                    Vous pourrez retirer votre consentement à tout moment.
                                </p>
                            </div>

                        </fieldset>

                        <!-- Type adhésion -->
                        <fieldset class="membership-choice">
                            <legend>Choisissez votre adhésion</legend>

                            <div class="membership-options">
                                <label class="membership-option">
                                    <input
                                        type="radio"
                                        name="type_adhesion"
                                        value="solo"
                                        checked
                                        required
                                    >

                                    <span class="membership-option-content">
                                        <strong>Solo</strong>
                                        <span class="membership-option-price">10 € / an</span>
                                        <small>Pour une personne</small>
                                    </span>
                                </label>

                                <label class="membership-option">
                                    <input
                                        type="radio"
                                        name="type_adhesion"
                                        value="couple"
                                        required
                                    >

                                    <span class="membership-option-content">
                                        <strong>Couple</strong>
                                        <span class="membership-option-price">15 € / an</span>
                                        <small>Pour deux personnes</small>
                                    </span>
                                </label>
                            </div>
                        </fieldset>

                        <fieldset class="adhesion-person" id="secondary-member" hidden disabled>
                            <legend>Deuxième adhérent</legend>

                            <label for="secondary_first_name">Prénom *</label>
                            <input
                                type="text"
                                id="secondary_first_name"
                                name="members[1][first_name]"
                                maxlength="100"
                                required
                            >

                            <label for="secondary_last_name">Nom *</label>
                            <input
                                type="text"
                                id="secondary_last_name"
                                name="members[1][last_name]"
                                maxlength="100"
                                required
                            >

                            <label for="secondary_email">Adresse e-mail (facultative)</label>
                            <input
                                type="email"
                                id="secondary_email"
                                name="members[1][email]"
                                maxlength="254"
                            >

                            <label for="secondary_phone">Téléphone (facultatif)</label>
                            <input
                                type="tel"
                                id="secondary_phone"
                                name="members[1][phone]"
                                maxlength="30"
                            >

                            <label for="same_address">
                                <input
                                    type="checkbox"
                                    id="same_address"
                                    name="same_address"
                                    value="1"
                                    checked
                                >
                                Même adresse postale que l'adhérent principal
                            </label>

                            <div id="secondary-address-fields" hidden>
                                <label for="secondary_address">Adresse postale</label>
                                <input
                                    type="text"
                                    id="secondary_address"
                                    name="members[1][address_line1]"
                                    maxlength="255"
                                >

                                <label for="secondary_postal_code">Code postal</label>
                                <input
                                    type="text"
                                    id="secondary_postal_code"
                                    name="members[1][postal_code]"
                                    maxlength="20"
                                >

                                <label for="secondary_city">Ville</label>
                                <input
                                    type="text"
                                    id="secondary_city"
                                    name="members[1][city]"
                                    maxlength="150"
                                >
                            </div>

                            <div class="adhesion-consents">
                                <p><strong>Préférences de communication</strong></p>

                                <p>
                                    Souhaitez-vous recevoir les actualités
                                    et informations de l'association Pour Nour ?
                                </p>

                                <label for="secondary_consent_email">
                                    <input
                                        type="checkbox"
                                        id="secondary_consent_email"
                                        name="members[1][contact_email_opt_in]"
                                        value="1"
                                    >
                                    Par e-mail
                                </label>

                                <label for="secondary_consent_sms">
                                    <input
                                        type="checkbox"
                                        id="secondary_consent_sms"
                                        name="members[1][contact_sms_opt_in]"
                                        value="1"
                                    >
                                    Par SMS
                                </label>

                                <label for="secondary_consent_postal">
                                    <input
                                        type="checkbox"
                                        id="secondary_consent_postal"
                                        name="members[1][contact_postal_opt_in]"
                                        value="1"
                                    >
                                    Par courrier postal
                                </label>

                                <p class="adhesion-consents-info">
                                    Ces choix sont facultatifs et indépendants de l'adhésion.
                                    Ils pourront être retirés à tout moment.
                                </p>
                            </div>
                        </fieldset>

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


    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const secondaryMember = document.getElementById('secondary-member');
        const sameAddress = document.getElementById('same_address');
        const secondaryAddressFields = document.getElementById(
            'secondary-address-fields'
        );

        function updateMembershipType() {
            const isCouple = document.querySelector(
                'input[name="type_adhesion"]:checked'
            )?.value === 'couple';

            secondaryMember.hidden = !isCouple;
            secondaryMember.disabled = !isCouple;

            updateAddressVisibility();
        }

        function updateAddressVisibility() {
            const useSameAddress = sameAddress.checked;

            secondaryAddressFields.hidden = useSameAddress;

            secondaryAddressFields
                .querySelectorAll('input')
                .forEach(input => {
                    input.disabled = useSameAddress;
                });
        }

        document.querySelectorAll('input[name="type_adhesion"]').forEach(input => {
            input.addEventListener('change', updateMembershipType);
        });
        sameAddress.addEventListener('change', updateAddressVisibility);

        updateMembershipType();
    });
    </script>


</main>

<?php
include_once 'partials/footer.php'
?>
