<?php
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "rootaccess1568";
$dbname = "sitekenan";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

if (isset($_SESSION['username'])) {
    $username_actuelle = $_SESSION['username'];
} else {
    $username_actuelle = '';
}

// Récupérer le texte de la base de données
$sql = "SELECT content FROM site_content WHERE section = 'main_text'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $main_text = $row['content'];
} else {
    $main_text = "Texte non trouvé.";
}

// Mettre à jour le texte si le formulaire est soumis
if (isset($_POST['update_text']) && isset($_SESSION['username']) && $_SESSION['username'] == 'Lotioko') {
    $new_text = $conn->real_escape_string($_POST['main_text']);
    $sql = "UPDATE site_content SET content = '$new_text' WHERE section = 'main_text'";
    if ($conn->query($sql) === TRUE) {
        $main_text = $new_text;
    } else {
        echo "Erreur de mise à jour: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche de Contact</title>
    <link rel="stylesheet" href="css/style.css">
    
</head>
<body>
    <div class="background-overlay"></div> <!-- Overlay de fond pour le fondu -->
    <header>
        <div class="container header-left">
            <h1>Contactez nous</h1>
        </div>
        <div class="logo-container">
            <div class="logo">
                <img src="img/logoJeanMonnet.png" alt="Logo du lycée Jean Monnet à Foulayronnes" href="https://lp-jean-monnet.fr/nos-formations/">
            </div>
        </div>
        <div class="container header-right">
            <?php if(isset($_SESSION['username'])): ?>
                <p>Bonjour, <?php echo htmlspecialchars($_SESSION['username']); ?> !</p>
            <?php else: ?>
                <p></p>
            <?php endif; ?>
        </div>
    </header>

    <nav>
        <a href="accueil.php" class="navBack">Accueil</a>
        <a href="apropos.php" class="navBack">À propos</a>
        <a href="contact.php" class="navBack">Contact</a>
        <?php if(!isset($_SESSION['username'])): ?>
            <a href="html/inscription.html" class="navBack">S'inscrire</a>
            <a href="html/login.html" class="navBack">Connexion</a>
        <?php endif; ?>
        <?php if(isset($_SESSION['username'])): ?>
            <a href="logout.php" class="navBack">Déconnexion</a>
        <?php endif; ?>
    </nav>

    <div class="contact-card">
        <form action="EmailSend.php" method="post">
            <label for="name">Nom:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($username_actuelle); ?>" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4" required></textarea>
            
            <button type="submit">Envoyer</button>
        </form>
    </div>

    <footer>
        <div class="container2">
            <p>© 2024 Tous droits réservés</p>
        </div>
    </footer>
</body>
</html>
