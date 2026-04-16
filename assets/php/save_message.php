<?php

// Réception des données du formulaire
$nom = trim($_POST['nom']);
$email = trim($_POST['email']);
$objet = trim($_POST['objet']);
$message = trim($_POST['message']);

// Validation simple
if (empty($nom) || empty($email) || empty($message)) {
    die("Erreur : certains champs obligatoires sont manquants.");
}

// Chemin vers le fichier JSON
$file = __DIR__ . '/data/messages.json';

// Lire le contenu existant
$messages = json_decode(file_get_contents($file), true);

// Créer le nouveau message
$newMessage = [
    "nom" => $nom,
    "email" => $email,
    "objet" => $objet,
    "message" => $message,
    "date" => date("Y-m-d H:i:s")
];

// Ajouter dans le tableau
$messages[] = $newMessage;

// Réécrire le JSON
file_put_contents($file, json_encode($messages, JSON_PRETTY_PRINT));

echo "Message enregistré avec succès.";

?>
