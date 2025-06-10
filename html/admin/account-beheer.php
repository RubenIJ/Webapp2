<?php
session_start();
require_once '../components/config.php';

$melding = '';

// Gebruiker verwijderen
if (isset($_GET['verwijder'])) {
    $id = intval($_GET['verwijder']);
    $stmt = $pdo->prepare("DELETE FROM gebruikers WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: gebruiker-beheer.php");
    exit;
}

// Gebruiker registreren
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['update'])) {
    $gebruikersnaam = $_POST['gebruikersnaam'] ?? '';
    $email = $_POST['email'] ?? '';
    $wachtwoord = $_POST['wachtwoord'] ?? '';
    $herhaal = $_POST['herhaal_wachtwoord'] ?? '';
    $admin = isset($_POST['admin']) ? 1 : 0;

    if ($gebruikersnaam && $email && $wachtwoord && $wachtwoord === $herhaal) {
        $hash = password_hash($wachtwoord, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO gebruikers (gebruikersnaam, email, wachtwoord, admin) VALUES (?, ?, ?, ?)");
        $stmt->execute([$gebruikersnaam, $email, $hash, $admin]);
        $melding = "Gebruiker succesvol toegevoegd.";
    } else {
        $melding = "Fout: controleer of alles is ingevuld en de wachtwoorden overeenkomen.";
    }
}

// Gebruiker bijwerken
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $email = $_POST['email'];
    $admin = isset($_POST['admin']) ? 1 : 0;

    $stmt = $pdo->prepare("UPDATE gebruikers SET gebruikersnaam=?, email=?, admin=? WHERE id=?");
    $stmt->execute([$gebruikersnaam, $email, $admin, $id]);
    header("Location: gebruiker-beheer.php");
    exit;
}

// Haal alle gebruikers op
$stmt = $pdo->query("SELECT * FROM gebruikers ORDER BY id ASC");
$gebruikers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Gebruikersbeheer</title>
    <link rel="stylesheet" href="../css/styling.css">
    <link rel="stylesheet" href="../css/xing.css">
    <link rel="stylesheet" href="../css/admin-gebruiker-beheer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
</head>
<body>
<header>
    <?php require("../components/admin-header.php"); ?>
</header>
<button id="toggleRegistreer">Toon/verberg registratieformulier</button>

<div class="registreer-container">
    <div class="registreer-box">
        <h2>Registreren</h2>
        <form method="POST" class="registreer-form">
            <input type="text" name="gebruikersnaam" placeholder="Gebruikersnaam" required>
            <input type="email" name="email" placeholder="E-mailadres" required>
            <input type="password" name="wachtwoord" placeholder="Wachtwoord" required>
            <input type="password" name="herhaal_wachtwoord" placeholder="Herhaal wachtwoord" required>

            <label style="margin: 10px 0;">
                <input type="checkbox" name="admin">
                Admin rechten geven
            </label>
        </form>

        <?php if (!empty($melding)): ?>
            <div class="registreer-melding"><?= htmlspecialchars($melding) ?></div>
        <?php endif; ?>
    </div>
</div>


<main class="admin-gebruikers-container">
    <h1>Gebruikers beheren</h1>

    <?php foreach ($gebruikers as $gebruiker): ?>
        <form method="post" class="admin-gebruiker-form">
            <input type="hidden" name="id" value="<?= htmlspecialchars($gebruiker['id']) ?>">

            <label>
                Gebruikersnaam:
                <input type="text" name="gebruikersnaam" value="<?= htmlspecialchars($gebruiker['gebruikersnaam']) ?>">
            </label>

            <label>
                E-mail:
                <input type="email" name="email" value="<?= htmlspecialchars($gebruiker['email']) ?>">
            </label>

            <label>
                Admin:
                <input type="checkbox" name="admin" <?= $gebruiker['admin'] ? 'checked' : '' ?>>
            </label>

            <div class="form-buttons">
                <button type="submit" name="update">Bijwerken</button>
                <a href="?verwijder=<?= $gebruiker['id'] ?>" onclick="return confirm('Weet je zeker dat je deze gebruiker wilt verwijderen?')">Verwijderen</a>
            </div>
        </form>
    <?php endforeach; ?>
</main>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('toggleRegistreer');
        const container = document.querySelector('.registreer-container');

        toggleBtn.addEventListener('click', function () {
            container.classList.toggle('verborgen');
            toggleBtn.textContent = container.classList.contains('verborgen')
                ? 'Toon registratieformulier'
                : 'Verberg registratieformulier';
        });
    });
</script>

</html>
