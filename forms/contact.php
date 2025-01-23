<?php
  
 
// Vérifier si le formulaire est soumis via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données soumises
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Valider les champs obligatoires
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo json_encode(["status" => "error", "message" => "Veuillez remplir tous les champs."]);
        exit;
    }

    // Vérifier que l'e-mail est valide
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => "error", "message" => "Adresse e-mail invalide."]);
        exit;
    }

    // Configuration de l'e-mail
    $to = "gestion@mhscourtage.com"; // Remplacez par votre adresse e-mail
    $email_subject = "Nouveau message : " . $subject;
    $email_body = "Nom : $name\n";
    $email_body .= "Email : $email\n\n";
    $email_body .= "Message :\n$message\n";

    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Envoyer l'e-mail
    if (mail($to, $email_subject, $email_body, $headers)) {
        echo json_encode(["status" => "success", "message" => "Votre message a été envoyé avec succès!"]);
        header("Refresh: 3; url=/index.html");

    } else {
        echo json_encode(["status" => "error", "message" => "Erreur lors de l'envoi du message. Réessayez."]);
        header("Refresh: 3; url=/contact.html");

    }
} else {
    echo json_encode(["status" => "error", "message" => "Méthode de requête invalide."]);
    header("Refresh: 3; url=/ObtenirDevis.html");

}




?>
