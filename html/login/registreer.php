<?php
require_once '../components/config.php';

$registreer_melding = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $registreer_gebruikersnaam = $_POST['registreer_gebruikersnaam'];
    $registreer_email = $_POST['registreer_email'];
    $registreer_wachtwoord = $_POST['registreer_wachtwoord'];
    $registreer_wachtwoord_herhaal = $_POST['registreer_wachtwoord_herhaal'];

    if ($registreer_wachtwoord !== $registreer_wachtwoord_herhaal) {
        $registreer_melding = "Wachtwoorden komen niet overeen.";
    } else {
        $hashed_wachtwoord = password_hash($registreer_wachtwoord, PASSWORD_DEFAULT);

        $sql = "INSERT INTO gebruikers (gebruikersnaam, email, wachtwoord) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt->execute([$registreer_gebruikersnaam, $registreer_email, $hashed_wachtwoord])) {
            $registreer_melding = "Registratie gelukt! Je kunt nu <a href='login-pagina.php'>inloggen</a>.";
        } else {
            $registreer_melding = "Er is iets misgegaan. Misschien bestaat deze gebruiker of e-mail al.";
        }
    }
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
<div class="registreer-container">
    <div class="registreer-box">
    <h2>Registreren</h2>
    <form class="registreer-form" method="post">
        <input type="text" name="registreer_gebruikersnaam" placeholder="Gebruikersnaam" required>
        <input type="email" name="registreer_email" placeholder="E-mailadres" required>
        <input type="password" name="registreer_wachtwoord" placeholder="Wachtwoord" required>
        <input type="password" name="registreer_wachtwoord_herhaal" placeholder="Herhaal wachtwoord" required>
        <button type="submit">Registreer</button>
    </form>
    <?php if ($registreer_melding): ?>
        <div class="registreer-melding"><?= $registreer_melding ?></div>
    <?php endif; ?>
</div></div>

</body>
</html>
