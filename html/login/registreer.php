<?php
session_start();
require_once '../components/config.php'; // Hierin staat: $pdo = new PDO(...)

$melding = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $gebruikersnaam = $_POST['gebruikersnaam'] ?? '';
    $email = $_POST['email'] ?? '';
    $wachtwoord = $_POST['wachtwoord'] ?? '';
    $herhaal_wachtwoord = $_POST['herhaal_wachtwoord'] ?? '';
    $vraag = $_POST['vraag'] ?? '';
    $antwoord = $_POST['antwoord'] ?? '';

    // Check wachtwoorden
    if ($wachtwoord !== $herhaal_wachtwoord) {
        $melding = "❌ Wachtwoorden komen niet overeen.";
    } else {
        try {
            // Check of e-mail al bestaat
            $checkStmt = $pdo->prepare("SELECT id FROM gebruikers WHERE email = :email");
            $checkStmt->execute(['email' => $email]);

            if ($checkStmt->rowCount() > 0) {
                $melding = "❌ Dit e-mailadres is al geregistreerd.";
            } else {
                // Hash wachtwoord en antwoord
                $hashed = password_hash($wachtwoord, PASSWORD_DEFAULT);
                $antwoord_hash = password_hash($antwoord, PASSWORD_DEFAULT);

                // Voeg gebruiker toe
                $insertStmt = $pdo->prepare("
                    INSERT INTO gebruikers (gebruikersnaam, email, wachtwoord, vraag, antwoord_hash, admin) 
                    VALUES (:gebruikersnaam, :email, :wachtwoord, :vraag, :antwoord_hash, 0)
                ");
                $insertStmt->execute([
                    'gebruikersnaam' => $gebruikersnaam,
                    'email' => $email,
                    'wachtwoord' => $hashed,
                    'vraag' => $vraag,
                    'antwoord_hash' => $antwoord_hash
                ]);

                $melding = "✅ Registratie gelukt! <a href='login.php'>Log nu in</a>";
            }
        } catch (PDOException $e) {
            $melding = "⚠️ Fout bij registratie: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Registreren</title>
    <link rel="stylesheet" href="../css/styling.css">
    <link rel="stylesheet" href="../css/ruben.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
</head>
<body>
<header>
    <?php require_once("../components/header.php"); ?>
</header>

<div class="registreer-container">
    <div class="registreer-box">
        <h2>Registreren</h2>
        <form method="POST" class="registreer-form">
            <label for="gebruikersnaam">Gebruikersnaam:</label>
            <input type="text" name="gebruikersnaam" id="gebruikersnaam" required>

            <label for="email">E-mailadres:</label>
            <input type="email" name="email" id="email" required>

            <label for="wachtwoord">Wachtwoord:</label>
            <input type="password" name="wachtwoord" id="wachtwoord" required>

            <label for="herhaal_wachtwoord">Herhaal wachtwoord:</label>
            <input type="password" name="herhaal_wachtwoord" id="herhaal_wachtwoord" required>

            <label for="vraag">Beveiligingsvraag:</label>
            <input type="text" name="vraag" id="vraag" placeholder="Bijv. favorieten kleur" required>

            <label for="antwoord">Antwoord op beveiligingsvraag:</label>
            <input type="text" name="antwoord" id="antwoord" required>

            <button type="submit">Registreer</button>
            <p class="login-register-link">
                Heb je al een account? <a href="login.php">Log hier in</a>
            </p>
        </form>

        <?php if (!empty($melding)): ?>
            <div class="registreer-melding"><?= $melding ?></div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
