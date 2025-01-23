<?php
// Configuration de la base de données
$host = '149.102.154.90'; // ou l'adresse de votre serveur
$dbname = 'mhsc_assurance';
$username = 'mhsc_a_essaid'; // votre utilisateur MySQL
$password = 'e2f*qp@9%OE1wncJ'; // votre mot de passe MySQL

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifie si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupération des données du formulaire
        $prenom = htmlspecialchars($_POST['prenom']);
        $nom = htmlspecialchars($_POST['nom']);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $telephone = htmlspecialchars($_POST['telephone']);
        $type_assurance = htmlspecialchars($_POST['type_assurance']);
        $details = htmlspecialchars($_POST['details']);
        $date_rdv = !empty($_POST['preferred_date']) ? $_POST['preferred_date'] : null;

        // Validation des champs requis
        if (!$prenom || !$nom || !$email || !$telephone || !$type_assurance) {
            die("Tous les champs requis doivent être remplis !");
        }

        // Préparation de la requête SQL
        $sql = "INSERT INTO demandes_devis (prenom, nom, email, telephone, type_assurance, details, date_rdv)
                VALUES (:prenom, :nom, :email, :telephone, :type_assurance, :details, :date_rdv)";
        $stmt = $pdo->prepare($sql);

        // Exécution de la requête
        $stmt->execute([
            ':prenom' => $prenom,
            ':nom' => $nom,
            ':email' => $email,
            ':telephone' => $telephone,
            ':type_assurance' => $type_assurance,
            ':details' => $details,
            ':date_rdv' => $date_rdv,
        ]);

        // Préparation des informations pour l'envoi d'un e-mail
        $to = "gestion@mhscourtage.com"; // Remplacez par votre adresse e-mail
        $subject = "Nouvelle demande de devis";
        $message = "Vous avez reçu une nouvelle demande de devis.\n\n";
        $message .= "Détails :\n";
        $message .= "Prénom : $prenom\n";
        $message .= "Nom : $nom\n";
        $message .= "Email : $email\n";
        $message .= "Téléphone : $telephone\n";
        $message .= "Type d'assurance : $type_assurance\n";
        $message .= "Détails supplémentaires : $details\n";
        if ($date_rdv) {
            $message .= "Date préférée pour le RDV : $date_rdv\n";
        }

        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";

        // Envoi de l'e-mail
        if (mail($to, $subject, $message, $headers)) {
            echo "Votre demande de devis a été soumise avec succès.";
            header("Refresh: 3; url=/index.html");
        } else {
            echo "Votre demande de devis a été soumise, mais l'envoi de l'e-mail a échoué.";
            header("Refresh: 3; url=/index.html");
        }
    }
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>
