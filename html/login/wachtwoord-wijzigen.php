<?php
require_once '../components/config.php'; // $pdo
$melding = '';
$token = $_GET['token'] ?? '';

if (empty($token)) {
    die("❌ Geen token meegegeven.");
}

// Stap 1: Haal gebruiker op met geldige token
$stmt = $PDO->prepare("SELECT * FROM gebruikers WHERE reset_code = ? AND reset_code_verloop > NOW()");
$stmt->execute([$token]);
$gebruiker = $stmt->fetch();

if (!$gebruiker) {
    die("❌ Ongeldige of verlopen resetlink.");
}

// Stap 2: Als formulier is verzonden
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verander_wachtwoord'])) {
    $nieuw = $_POST['nieuw_wachtwoord'] ?? '';
    $herhaal = $_POST['herhaal_wachtwoord'] ?? '';

    if (strlen($nieuw) < 6) {
        $melding = "Wachtwoord moet minimaal 6 tekens zijn.";
    } elseif ($nieuw !== $herhaal) {
        $melding = "Wachtwoorden komen niet overeen.";
    } else {
        // Update wachtwoord
        $hash = password_hash($nieuw, PASSWORD_DEFAULT);
        $stmt = $PDO->prepare("UPDATE gebruikers SET wachtwoord = ?, reset_code = NULL, reset_code_verloop = NULL WHERE id = ?");
        $stmt->execute([$hash, $gebruiker['id']]);
        $melding = "✅ Je wachtwoord is succesvol gewijzigd. Je kunt nu <a href='login.php'>inloggen</a>.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Wachtwoord Reset</title>
    <link rel="stylesheet" href="../css/styling.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" />

</head>
<body>

<div class="login-container">
    <div class="login-box">
        <h2>Stel een nieuw wachtwoord in</h2>

        <?php if (!empty($melding)): ?>
            <p><?= $melding ?></p>
        <?php endif; ?>

        <form method="POST">
            <input type="password" name="nieuw_wachtwoord" placeholder="Nieuw wachtwoord" required>
            <input type="password" name="herhaal_wachtwoord" placeholder="Herhaal nieuw wachtwoord" required>
            <button type="submit" name="verander_wachtwoord">Wijzig wachtwoord</button>
        </form>
    </div>
</div>

</body>
</html>
