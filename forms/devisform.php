<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et nettoyage des données
    $prenom = filter_var($_POST['prenom'], FILTER_SANITIZE_STRING);
    $nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $telephone = filter_var($_POST['telephone'], FILTER_SANITIZE_STRING);
    $type_assurance = filter_var($_POST['type_assurance'], FILTER_SANITIZE_STRING);
    $details = filter_var($_POST['details'], FILTER_SANITIZE_STRING);
    $preferred_date = filter_var($_POST['preferred_date'], FILTER_SANITIZE_STRING);

    // Validation de l'email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Informations de l'email
        $to = "fichemhscourtage@mhscourtage.com"; // Remplacez par l'email du destinataire
        $subject = "Nouvelle demande de devis";
        
        $message = "Un nouvel utilisateur a soumis une demande de devis :\n\n";
        $message .= "Prénom : " . $prenom . "\n";
        $message .= "Nom : " . $nom . "\n";
        $message .= "Email : " . $email . "\n";
        $message .= "Téléphone : " . $telephone . "\n";
        $message .= "Type d'Assurance : " . $type_assurance . "\n";
        $message .= "Détails : " . $details . "\n";
        $message .= "Date d'effet souhaitée : " . $preferred_date . "\n";

        // En-têtes de l'email
        $headers = "From: no-reply@mhscourtage.com\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Envoi de l'email
        if (mail($to, $subject, $message, $headers)) {
            echo "Votre demande de devis a bien été envoyée.";
            header("Refresh: 3; url=/index.html");
            exit(); // Arrête l'exécution pour éviter tout comportement inattendu
        } else {
            echo "Erreur : Le devis n'a pas pu être envoyé.";
        }
    } else {
        echo "Erreur : Adresse email invalide.";
    }
}
?>
