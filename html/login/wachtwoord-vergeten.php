<?php
require_once '../components/config.php';
session_start();
$melding = '';
$stap = 1;
$vraag = '';
$email = $_POST['email'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['controleer_email'])) {
        // Stap 1: Vraag ophalen
        $stmt = $pdo->prepare("SELECT * FROM gebruikers WHERE email = ?");
        $stmt->execute([$email]);
        $gebruiker = $stmt->fetch();

        if ($gebruiker && $gebruiker['vraag'] && $gebruiker['antwoord_hash']) {
            $vraag = $gebruiker['vraag'];
            $stap = 2;
        } else {
            $melding = "Geen account gevonden of geen beveiligingsvraag ingesteld.";
        }
    }

    if (isset($_POST['controleer_vraag'])) {
        // Stap 2: Antwoord controleren
        $antwoord = trim($_POST['antwoord'] ?? '');

        $stmt = $pdo->prepare("SELECT * FROM gebruikers WHERE email = ?");
        $stmt->execute([$email]);
        $gebruiker = $stmt->fetch();

        if ($gebruiker && password_verify($antwoord, $gebruiker['antwoord_hash'])) {
            $token = bin2hex(random_bytes(32));
            $verloop = date("Y-m-d H:i:s", strtotime('+1 hour'));

            $stmt = $pdo->prepare("UPDATE gebruikers SET reset_code = ?, reset_code_verloop = ? WHERE email = ?");
            $stmt->execute([$token, $verloop, $email]);

            $link = "http://localhost:8000/login/wachtwoord-wijzigen.php?token=" . $token;
            $melding = "✅ Resetlink is gegenereerd: <a href='$link'>$link</a>";
        } else {
            $vraag = $gebruiker['vraag'] ?? '';
            $melding = "❌ Onjuist antwoord op de beveiligingsvraag.";
            $stap = 2;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Wachtwoord vergeten</title>
    <link rel="stylesheet" href="../css/styling.css">
    <link rel="stylesheet" href="../css/xing.css">
    <link rel="stylesheet" href="../css/ruben.css">
</head>
<body>
<header><?php require_once("../components/header.php"); ?></header>

<div class="login-container">
    <div class="login-box">
        <h2 class="login-title">Wachtwoord vergeten</h2>

        <?php if ($stap === 1): ?>
            <form method="POST" class="login-form">
                <div class="login-form-group">
                    <label for="email">E-mailadres</label>
                    <input type="email" name="email" required>
                </div>
                <button type="submit" name="controleer_email" class="login-button">Volgende</button>
            </form>
        <?php endif; ?>

        <?php if ($stap === 2): ?>
            <form method="POST" class="login-form">
                <div class="login-form-group">
                    <label><?= htmlspecialchars($vraag) ?></label>
                    <input type="text" name="antwoord" required>
                    <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
                </div>
                <button type="submit" name="controleer_vraag" class="login-button">Bevestigen</button>
            </form>
        <?php endif; ?>

        <?php if (!empty($melding)): ?>
            <div class="login-melding"><?= $melding ?></div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
