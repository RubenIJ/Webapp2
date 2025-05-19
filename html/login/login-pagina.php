<?php
session_start();
require_once '../components/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $wachtwoord = $_POST['wachtwoord'];

    try {
        $sql = "SELECT * FROM gebruikers WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        $gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($gebruiker && password_verify($wachtwoord, $gebruiker['wachtwoord'])) {
            // Inlog geslaagd
            $_SESSION['gebruiker_id'] = $gebruiker['id'];
            $_SESSION['gebruikersnaam'] = $gebruiker['gebruikersnaam'];
            header("Location: admin.php");
            exit();
        } else {
            // Onjuiste inloggegevens
            header("Location: login-pagina.php?error=1");
            exit();
        }
    } catch (PDOException $e) {
        echo "Fout bij inloggen: " . $e->getMessage();
    }
} else {
    header("Location: login-pagina.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Hoofdpagina</title>
    <link rel="stylesheet" href="../css/styling.css">
    <link rel="stylesheet" href="../css/xing.css">
    <link rel="stylesheet" href="../css/ruben.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>

</head>

<body>
<header><?php require_once("../components/header.php") ?>
</header>
<div class="login-container">
    <div class="login-box">
        <h2 class="login-title">Welkom Terug</h2>
        <form action="login-verwerk.php" method="POST" class="login-form">
            <div class="login-form-group">
                <label for="login-email">E-mail</label>
                <input type="email" id="login-email" name="email" required>
            </div>
            <div class="login-form-group">
                <label for="login-password">Wachtwoord</label>
                <input type="password" id="login-password" name="wachtwoord" required>
            </div>
            <button type="submit" class="login-button">Inloggen</button>
            <p class="login-register-link">Nog geen account? <a href="registreer.php">Registreer hier</a></p>
        </form>


    </div>
</div>
</body>
</html>
