<?php
// Configuration de la base de données
// $host = 'localhost'; // ou l'adresse de votre serveur
// $dbname = 'assurance';
// $username = 'root'; // votre utilisateur MySQL
// $password = ''; // votre mot de passe MySQL

// try {
    // Connexion à la base de données
    // $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifie si le formulaire a été soumis
    // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupération des données du formulaire
        // $nomcomplet = htmlspecialchars($_POST['nomcomplet']);
        // $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        // $telephone = htmlspecialchars($_POST['telephone']);
        // $objet = htmlspecialchars($_POST['objet']);
        // $message = htmlspecialchars($_POST['message']);

        // Validation des champs requis
        // if (!$nomcomplet || !$email || !$telephone || !$objet || !$message ) {
        //     die("Tous les champs requis doivent être remplis !");
        // }

        // Préparation de la requête SQL
        // $sql = "INSERT INTO contact (nomcomplet, email, telephone,objet,message)
        //         VALUES (:nomcomplet, :email, :telephone,:objet,:message)";
        // $stmt = $pdo->prepare($sql);

        // Exécution de la requête
        // $stmt->execute([

        //     ':nomcomplet' => $nomcomplet,
        //     ':email' => $email,
        //     ':telephone' => $telephone,
        //     ':objet' => $objet,
        //     ':message' => $message,
            
        // ]);

        // Message de confirmation
//         echo "Votre demande de devis a été soumise avec succès.";
//     }
// } catch (PDOException $e) {
//     die("Erreur : " . $e->getMessage());
// }

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
                $mail->Username = 'guymateke69@gmail.com'; // Votre email Gmail
                $mail->Password = 'Mamanannette1@'; // Votre mot de passe
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
