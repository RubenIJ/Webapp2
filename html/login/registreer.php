<?php
session_start();
require_once '../components/config.php'; // Hierin staat: $pdo = new PDO(...)

$melding = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $gebruikersnaam = $_POST['gebruikersnaam'] ?? '';
    $email = $_POST['email'] ?? '';
    $wachtwoord = $_POST['wachtwoord'] ?? '';
    $herhaal_wachtwoord = $_POST['herhaal_wachtwoord'] ?? '';

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
                // Hash het wachtwoord
                $hashed = password_hash($wachtwoord, PASSWORD_DEFAULT);

                // Voeg gebruiker toe met admin = false
                $insertStmt = $pdo->prepare("
                    INSERT INTO gebruikers (gebruikersnaam, email, wachtwoord, admin) 
                    VALUES (:gebruikersnaam, :email, :wachtwoord, 0)
                ");
                $insertStmt->execute([
                    'gebruikersnaam' => $gebruikersnaam,
                    'email' => $email,
                    'wachtwoord' => $hashed
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
            <input type="text" name="gebruikersnaam" placeholder="Gebruikersnaam" required>
            <input type="email" name="email" placeholder="E-mailadres" required>
            <input type="password" name="wachtwoord" placeholder="Wachtwoord" required>
            <input type="password" name="herhaal_wachtwoord" placeholder="Herhaal wachtwoord" required>
            <button type="submit">Registreer</button>
            <p class="login-register-link">Heb je al een account? <a href="login.php">Log hier in</a></p>

        </form>
        <?php if (!empty($melding)): ?>
            <div class="registreer-melding"><?= $melding ?></div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
