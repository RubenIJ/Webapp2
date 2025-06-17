<?php
session_start();
require_once '../components/config.php';

$melding = '';

// Gebruiker verwijderen
if (isset($_GET['verwijder'])) {
    $id = intval($_GET['verwijder']);
    $stmt = $PDO->prepare("DELETE FROM gebruikers WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: account-beheer.php");
    exit;
}

// Gebruiker registreren
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['update'])) {
    $gebruikersnaam = $_POST['gebruikersnaam'] ?? '';
    $email = $_POST['email'] ?? '';
    $wachtwoord = $_POST['wachtwoord'] ?? '';
    $herhaal = $_POST['herhaal_wachtwoord'] ?? '';
    $vraag = $_POST['vraag'] ?? '';
    $antwoord = $_POST['antwoord'] ?? '';
    $admin = isset($_POST['admin']) ? 1 : 0;

    if (!$gebruikersnaam || !$email || !$wachtwoord || !$herhaal || !$vraag || !$antwoord) {
        $melding = "❌ Vul alle velden in.";
    } elseif ($wachtwoord !== $herhaal) {
        $melding = "❌ Wachtwoorden komen niet overeen.";
    } else {
        try {
            // Check of e-mail al bestaat
            $checkStmt = $PDO->prepare("SELECT id FROM gebruikers WHERE email = :email");
            $checkStmt->execute(['email' => $email]);

            if ($checkStmt->rowCount() > 0) {
                $melding = "❌ Dit e-mailadres is al geregistreerd.";
            } else {
                $hash = password_hash($wachtwoord, PASSWORD_DEFAULT);
                $antwoord_hash = password_hash($antwoord, PASSWORD_DEFAULT);

                $stmt = $PDO->prepare("INSERT INTO gebruikers (gebruikersnaam, email, wachtwoord, vraag, antwoord_hash, admin) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$gebruikersnaam, $email, $hash, $vraag, $antwoord_hash, $admin]);

                $melding = "✅ Gebruiker succesvol toegevoegd.";
            }
        } catch (PDOException $e) {
            $melding = "⚠️ Fout bij registratie: " . $e->getMessage();
        }
    }
}

// Gebruiker bijwerken
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $email = $_POST['email'];
    $admin = isset($_POST['admin']) ? 1 : 0;

    $stmt = $PDO->prepare("UPDATE gebruikers SET gebruikersnaam=?, email=?, admin=? WHERE id=?");
    $stmt->execute([$gebruikersnaam, $email, $admin, $id]);
    header("Location: account-beheer.php");
    exit;
}

// Haal alle gebruikers op
$stmt = $PDO->query("SELECT * FROM gebruikers ORDER BY id ASC");
$gebruikers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Gebruikersbeheer</title>
    <link rel="stylesheet" href="../css/styling.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

</head>
<body>
<header>
    <?php require("../components/admin-header.php"); ?>
</header>

<main class="admin-gebruikers-container">
    <h1>Gebruikers beheren</h1>
    <button id="toggleRegistreer" class="toggle-button">Toon registratieformulier</button>

    <div class="registreer-container verborgen">
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

                <label style="margin: 10px 0;">
                    <input type="checkbox" name="admin">
                    Admin rechten geven
                </label>
                <button type="submit">Registreer</button>
            </form>

            <?php if (!empty($melding)): ?>
                <div class="registreer-melding"><?= htmlspecialchars($melding) ?></div>
            <?php endif; ?>
        </div>
    </div>

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
</body>
</html>

