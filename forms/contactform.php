<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require __DIR__ . '/../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomComplet = htmlspecialchars($_POST['nomcomplet'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $telephone = htmlspecialchars($_POST['telephone'] ?? '');
    $objet = htmlspecialchars($_POST['objet'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');

    if (!empty($nomComplet) && !empty($email) && !empty($telephone) && !empty($objet) && !empty($message)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $mail = new PHPMailer(true);
            try {
                // Configuration SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'gestion@mhscourtage.com'; // Votre email Gmail
                $mail->Password = ''; // Votre mot de passe
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Expéditeur et destinataire
                $mail->setFrom($email, $nomComplet);
                $mail->addAddress('admin@votre-site.com');

                // Contenu
                $mail->isHTML(false);
                $mail->Subject = "Nouveau message de contact : $objet";
                $mail->Body = "
                    Nom complet : $nomComplet
                    Email : $email
                    Téléphone : $telephone
                    Objet : $objet
                    Message : $message
                ";

                $mail->send();
                echo "Votre message a été envoyé avec succès.";
                header("Refresh: 3; url=/index.html");

            } catch (Exception $e) {
                echo "Erreur : {$mail->ErrorInfo}";
            }
        } else {
            echo "Adresse e-mail invalide.";
        }
    } else {
        echo "Tous les champs sont obligatoires.";
    }
}


?>
