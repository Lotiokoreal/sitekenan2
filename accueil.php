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
    die("La connexion a échoué. Veuillez réessayer plus tard.");
}

// Récupérer le texte de la base de données
$stmt = $conn->prepare("SELECT content FROM site_content WHERE section = ?");
$section = 'main_text';
$stmt->bind_param("s", $section);
$stmt->execute();
$stmt->bind_result($main_text);
$stmt->fetch();
$stmt->close();

if (empty($main_text)) {
    $main_text = "Texte non trouvé.";
}

// Mettre à jour le texte si le formulaire est soumis
if (isset($_POST['update_text']) && isset($_SESSION['username']) && $_SESSION['username'] == 'Lotioko') {
    $new_text = $_POST['main_text'];

    $stmt = $conn->prepare("UPDATE site_content SET content = ? WHERE section = ?");
    $stmt->bind_param("ss", $new_text, $section);

    if ($stmt->execute() === TRUE) {
        $main_text = $new_text;
    } else {
        echo "Erreur de mise à jour. Veuillez réessayer plus tard.";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Kenan</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="img/logoJeanMonnet.png" rel="icon" type="image/png" />
</head>

<body>
    <div class="background-overlay"></div> <!-- Overlay de fond pour le fondu -->
    <header>
        <div class="container header-left">
            <h1>Bienvenue sur mon site</h1>
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

    <main>
        <div class="container3">
            <h2>Activité : Création de Site WEB</h2>
            <p>
                <?php echo nl2br(htmlspecialchars($main_text)); ?>
            </p>
            <?php if(isset($_SESSION['username']) && $_SESSION['username'] == 'Lotioko'): ?>
                <div class="admin-content">
                    <h3>Modifier le contenu</h3>
                    <form method="post">
                        <textarea name="main_text" rows="10" cols="50"><?php echo htmlspecialchars($main_text); ?></textarea>
                        <br>
                        <button type="submit" name="update_text">Mettre à jour</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
        <aside class="right-article">
            <h3>Réalisé à l'ESIEA par</h3> 
            <h3>CROIZE Kenan</h3>
            <h4>Éleve du Lycée Jean-Monnet</h4>
            <a href="https://www.esiea.fr/" target="_blank">
                <img src="https://www.esiea.fr/wp-content/themes/esiea/img/logo-esiea.svg" alt="logo ESIEA" loading="lazy" width="auto" height="80">
            </a>
            <a href="https://lp-jean-monnet.fr/" target="_blank">
                <img src="img/logoJeanMonnet2.png" alt="logo Lycée Jean-Monnet" loading="lazy" width="auto" height="112">
            </a>
        </aside>
    </main>

    <footer>
        <div class="container2">
            <p>© 2024 Tous droits réservés</p>
        </div>
    </footer>
    <script src="javascript/sourisnav.js"></script>
    <script src="javascript/main.js"></script>
    <script src="javascript/dropdown.js"></script>
</body>
</html>
