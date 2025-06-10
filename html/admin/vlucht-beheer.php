<?php
require_once '../components/config.php'; // Zorg dat $pdo beschikbaar is

// Verwijderen
if (isset($_GET['verwijder'])) {
    $id = intval($_GET['verwijder']);
    $stmt = $pdo->prepare("DELETE FROM plaatsen WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: vlucht-beheer.php");
    exit;
}

// Updaten
if (isset($_POST['update'])) {
    $stmt = $pdo->prepare("UPDATE plaatsen SET locatie=?, soort=?, tags=?, prijs=? WHERE id=?");
    $stmt->execute([
        $_POST['land'],
        $_POST['soort'],
        $_POST['tags'],
        $_POST['prijs'],
        $_POST['id']
    ]);
    header("Location: vlucht-beheer.php");
    exit;
}

// Toevoegen
if (isset($_POST['toevoegen'])) {
    $stmt = $pdo->prepare("INSERT INTO plaatsen (locatie, soort, tags, prijs) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $_POST['land'],
        $_POST['soort'],
        $_POST['tags'],
        $_POST['prijs']
    ]);
    header("Location: vlucht-beheer.php");
    exit;
}

// Ophalen van alle vluchten
$stmt = $pdo->query("SELECT * FROM plaatsen ORDER BY id ASC");
$plaatsen = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Admin Vluchtbeheer</title>
    <link rel="stylesheet" href="../css/styling.css">
    <link rel="stylesheet" href="../css/xing.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
</head>
<body>
<header>
    <?php require("../components/admin-header.php"); ?>
</header>

<main class="admin-vlucht-container">
    <h1 class="vluchten-text">Vluchten beheren</h1>

    <div class="vluchten-toevoegen">
        <h2 class="vluchten-text">Nieuwe vlucht toevoegen</h2>
        <form method="post" class="admin-vlucht-form">
            <label>
                Locatie:
                <input type="text" name="land" required>
            </label>
            <label>
                Soort:
                <input type="text" name="soort" required>
            </label>
            <label>
                Tags:
                <input type="text" name="tags">
            </label>
            <label>
                Prijs:
                <input type="number" name="prijs" required>
            </label>
            <button type="submit" name="toevoegen">Toevoegen</button>
        </form>
        <hr>
    </div>
<h2 class="vluchten-text">Vluchten aanpassen</h2>
    <?php foreach ($plaatsen as $plaats): ?>
        <form method="post" class="admin-vlucht-form">
            <input type="hidden" name="id" value="<?= htmlspecialchars($plaats['id']) ?>">
            <label>
                Locatie:
                <input type="text" name="land" value="<?= htmlspecialchars($plaats['locatie']) ?>">
            </label>
            <label>
                Soort:
                <input type="text" name="soort" value="<?= htmlspecialchars($plaats['soort']) ?>">
            </label>
            <label>
                Tags:
                <input type="text" name="tags" value="<?= htmlspecialchars($plaats['tags']) ?>">
            </label>
            <label>
                Prijs:
                <input type="number" name="prijs" value="<?= htmlspecialchars($plaats['prijs']) ?>">
            </label>
            <button type="submit" name="update">Bijwerken</button>
            <a href="?verwijder=<?= $plaats['id'] ?>" onclick="return confirm('Weet je zeker dat je deze vlucht wilt verwijderen?')">Verwijder</a>
        </form>
    <?php endforeach; ?>
</main>
</body>
</html>
