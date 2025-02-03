<?php


// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
// exit(); // Stoppe le script pour voir ce qui est reçu



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si les champs existent avant d'y accéder
    $nomcomplet = isset($_POST['nomcomplet']) ? filter_var($_POST['nomcomplet'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : "";
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    $telephone = isset($_POST['telephone']) ? filter_var($_POST['telephone'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : "";
    $objet = isset($_POST['objet']) ? filter_var($_POST['objet'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : "";
    $message_content = isset($_POST['message']) ? filter_var($_POST['message'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : "";

    // Debug : Voir les valeurs reçues
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";

    // Vérification de l'email
    if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Nettoyage de l'email après validation
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        // Informations de l'email
        $to = "fichemhscourtage@mhscourtage.com";
        $subject_email = "Nouveau message de contact : " . $objet;

        $message = "Un nouvel utilisateur a envoyé un message de contact :\n\n";
        $message .= "Nom complet : " . $nomcomplet . "\n";
        $message .= "Email : " . $email . "\n";
        $message .= "Téléphone : " . $telephone . "\n";
        $message .= "Objet : " . $objet . "\n";
        $message .= "Message : " . $message_content . "\n";

        // En-têtes de l'email
        $headers = "From: no-reply@mhscourtage.com\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Envoi de l'email
        if (mail($to, $subject_email, $message, $headers)) {
            echo "Votre message a bien été envoyé.";

            header("Refresh: 3; url=/index.html");
            exit();
        } else {
            echo "Erreur : Le message n'a pas pu être envoyé.";
        }
    } else {
        echo "Erreur : Adresse email invalide.";
    }
}
?>
