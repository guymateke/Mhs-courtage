<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et nettoyage des données
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
    $message_content = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

    // Validation de l'email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Informations de l'email
        $to = "fichemhscourtage@mhscourtage.com"; // Remplacez par l'email du destinataire
        $subject_email = "Nouveau message de contact : " . $subject;
        
        $message = "Un nouvel utilisateur a envoyé un message de contact :\n\n";
        $message .= "Nom : " . $name . "\n";
        $message .= "Email : " . $email . "\n";
        $message .= "Sujet : " . $subject . "\n";
        $message .= "Message : " . $message_content . "\n";

        // En-têtes de l'email
        $headers = "From: no-reply@mhscourtage.com\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Envoi de l'email
        if (mail($to, $subject_email, $message, $headers)) {
            echo "Votre message a bien été envoyé.";
            exit(); // Arrête l'exécution pour éviter tout comportement inattendu
        } else {
            echo "Erreur : Le message n'a pas pu être envoyé.";
        }
    } else {
        echo "Erreur : Adresse email invalide.";
    }
}
?>