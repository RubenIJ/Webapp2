<?php
require_once '../components/config.php';
session_start();

$gebruikerIngelogd = isset($_SESSION['gebruiker_id']);

// Als er een boekings-id is
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Ongeldig ID opgegeven.";
    exit;
}

$id = (int) $_GET['id'];

// Haal de reisinfo op
$stmt = $PDO->prepare("SELECT * FROM plaatsen WHERE id = :id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$reis = $stmt->fetch();

if (!$reis) {
    echo "Geen reis gevonden.";
    exit;
}

// Loginverwerking
$login_fout = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $wachtwoord = $_POST['wachtwoord'];

    $stmt = $PDO->prepare("SELECT * FROM gebruikers WHERE gebruikersnaam = :gebruikersnaam");
    $stmt->bindValue(':gebruikersnaam', $gebruikersnaam);
    $stmt->execute();
    $gebruiker = $stmt->fetch();

    if ($gebruiker && password_verify($wachtwoord, $gebruiker['wachtwoord'])) {
        $_SESSION['gebruiker_id'] = $gebruiker['id'];
        $_SESSION['gebruikersnaam'] = $gebruiker['gebruikersnaam'];
        $_SESSION['email'] = $gebruiker['email'];
        header("Location: boeken.php?id=" . $id);
        exit;
    } else {
        $login_fout = "Gebruikersnaam of wachtwoord onjuist.";
    }
}
?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Boeken</title>
    <link rel="stylesheet" href="../css/styling.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
</head>
<body>

<div class="boeken-wrapper">
    <div class="boeken-container">
        <h1 class="boeken-titel">Boek uw reis naar <?= htmlspecialchars($reis['locatie']) ?></h1>
        <p class="boeken-prijs"><strong>Prijs:</strong> €<?= htmlspecialchars($reis['prijs']) ?></p>

        <?php if ($gebruikerIngelogd): ?>
            <form method="POST" action="verwerk-booking.php" class="boeken-form">
                <input type="hidden" name="reis_id" value="<?= $reis['id'] ?>">

                <label for="naam">Uw naam:</label>
                <input type="text" name="naam" id="naam" value="<?= htmlspecialchars($_SESSION['gebruikersnaam']) ?>" required readonly>

                <label for="email">Uw e-mailadres:</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($_SESSION['email']) ?>" required readonly>

                <label for="personen">Aantal personen:</label>
                <input type="number" name="personen" id="personen" min="1" value="1" required>

                <label for="vertrekdatum">Vertrekdatum:</label>
                <input type="date" id="vertrekdatum" name="vertrekdatum" required>

                <label for="terugdatum">Terugkomstdatum:</label>
                <input type="date" id="terugdatum" name="terugdatum" required>

                <button type="submit" class="boeken-btn">Bevestig boeking</button>
            </form>
        <?php else: ?>
            <h2 class="boeken-subtitel">Log in om deze reis te boeken</h2>
            <?php if ($login_fout): ?>
                <p class="login-fout"><?= $login_fout ?></p>
            <?php endif; ?>
            <form method="POST" class="boeken-form">
                <label for="gebruikersnaam">Gebruikersnaam:</label>
                <input type="text" name="gebruikersnaam" id="gebruikersnaam" required>

                <label for="wachtwoord">Wachtwoord:</label>
                <input type="password" name="wachtwoord" id="wachtwoord" required>

                <button type="submit" name="login" class="boeken-btn">Inloggen</button>
            </form>
            <p class="boeken-register-link">Heb je nog geen account? <a href="../login/registreer.php">Registreer hier</a>.</p>
        <?php endif; ?>

        <a href="javascript:history.back()" class="boeken-terug">← Terug naar vorige pagina</a>
    </div>
</div>

</body>
</html>

