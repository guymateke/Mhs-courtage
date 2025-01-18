<?php
// Configuration de la base de données
$host = 'localhost'; // ou l'adresse de votre serveur
$dbname = 'assurance';
$username = 'root'; // votre utilisateur MySQL
$password = ''; // votre mot de passe MySQL

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

        // Message de confirmation
        echo "Votre demande de devis a été soumise avec succès.";
    }
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>
