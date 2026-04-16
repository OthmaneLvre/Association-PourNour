📘 Documentation de déploiement — Projet Pour Nour
Auteur : Othmane Lecoeuvre

1️⃣ État actuel de l'application

    Le site Pour Nour est actuellement développé et testé en local, dans un environnement XAMPP.
    Le back-end fonctionne déjà (PHP + JSON), et toutes les fonctionnalités liées au formulaire ont été vérifiées localement.

    Le déploiement final en ligne est prévu dans les prochains mois, une fois que :

    la structure du site sera définitivement validée,

    les contenus seront finalisés,

    l’association sera prête à communiquer officiellement.

    Le site sera hébergé sur un hébergement mutualisé OVH, déjà prévu pour le projet.

2️⃣ Préparation du déploiement futur

    Même si le site n'est pas encore en ligne, j’ai déjà documenté les étapes nécessaires pour permettre son futur déploiement sans difficulté.

    🔹 Fonctionnement prévu sur OVH

    OVH supporte nativement :

    PHP 8.x

    Apache

    l’écriture de fichiers (JSON)

    le déploiement via FTP

    Cela rend le déploiement parfaitement compatible avec le système NoSQL choisi (fichier JSON).

3️⃣ Installation en local (environnement actuel)
    1. Lancer XAMPP

    Apache : ON

    2. Installer le projet dans :
    /xampp/htdocs/pour-nour/

    3. Créer le dossier de stockage des messages :
    /php/data/

    4. Créer le fichier JSON :
    /php/data/messages.json


    Contenu initial :

    []

    5. Vérifier les permissions (si nécessaire)
    chmod 755 data/
    chmod 666 messages.json

4️⃣ Structure de données (NoSQL JSON)

    Le choix du fichier JSON permet :

    une mise en place simple

    un déploiement facile

    une maintenance accessible à l’association

    Format d’un message enregistré :

    {
    "nom": "Marie",
    "email": "exemple@mail.com",
    "objet": "Information",
    "message": "Bonjour, j'aimerais en savoir plus.",
    "date": "2025-02-15 10:35:40"
    }

5️⃣ Étapes du déploiement futur (prévu pour OVH)
    1. Uploader le site sur OVH via FTP

    Dans le répertoire :

    /www/

    2. Recréer le dossier de données
    /php/data/

    3. Replacer le fichier JSON initial
    messages.json

    4. Vérifier les permissions d’écriture

    Essentiel pour que PHP puisse écrire les messages.

    5. Tester le formulaire en ligne

    envoi d’un message

    mise à jour du fichier JSON

    affichage d’un message de confirmation

    6. Vérifications finales

    fonctionnement en HTTPS

    compatibilité mobile

    réponses du serveur

    absence d’erreurs PHP

6️⃣ Conclusion

Le déploiement final du site Pour Nour est planifié mais pas encore effectué, ce qui est normal dans un projet associatif en cours de construction.
Toutefois, l’ensemble des étapes nécessaires au futur déploiement ont été identifiées, préparées et documentées pour garantir une mise en ligne fluide lorsque l’association sera prête.