<?php
session_start();
require_once '../components/config.php';

$melding = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $wachtwoord = $_POST['wachtwoord'] ?? '';

    try {
        $stmt = $PDO->prepare("SELECT * FROM gebruikers WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($gebruiker && password_verify($wachtwoord, $gebruiker['wachtwoord'])) {
            $_SESSION['gebruikersnaam'] = $gebruiker['gebruikersnaam'];
            $_SESSION['email'] = $gebruiker['email'];
            $_SESSION['is_admin'] = $gebruiker['admin'];
            $_SESSION['gebruiker_id'] = $gebruiker['id']; // Deze toevoegen

            if ($gebruiker['admin']) {
                header("Location: ../admin/admin.php");
            } else {
                header("Location: ../gebruiker-paginas/profiel.php");
            }
            exit;
        } else {
            $melding = "❌ Ongeldig e-mailadres of wachtwoord.";
        }
    } catch (PDOException $e) {
        $melding = "⚠️ Databasefout: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Inloggen</title>
    <link rel="stylesheet" href="../css/styling.css">
    <link rel="stylesheet" href="../css/xing.css">
    <link rel="stylesheet" href="../css/ruben.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
</head>

<body>
<header><?php require_once("../components/header.php"); ?></header>

<div class="login-container">
    <div class="login-box">
        <h2 class="login-title">Welkom Terug</h2>
        <form action="login.php" method="POST" class="login-form">
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
            <p class="login-register-link">Wachtwoord vergeten? <a href="wachtwoord-vergeten.php">Pas hier aan</a></p>

        </form>

        <?php if (!empty($melding)): ?>
            <div class="login-melding"><?= $melding ?></div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
