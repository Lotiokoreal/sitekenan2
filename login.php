<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Connexion à la base de données
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    // Vérification de la connexion
    if ($conn->connect_error) {
        die("Connexion échouée : " . $conn->connect_error);
    }

    // Préparation de la requête SQL
    $stmt = $conn->prepare("SELECT password FROM utilisateurs WHERE username = ?");
    if ($stmt === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Vérification si l'utilisateur existe
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Vérification du mot de passe
        if (password_verify($password, $hashed_password)) {
            // Mot de passe correct
            $_SESSION['username'] = $username;
            header('Location: accueil.php');
        } else {
            // Mot de passe incorrect
            echo "Identifiants incorrects.";
        }
    } else {
        // Utilisateur non trouvé
        echo "Identifiants incorrects.";
    }

    // Fermeture de la connexion
    $stmt->close();
    $conn->close();
}
?>
