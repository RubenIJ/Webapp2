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
    $id = $_POST['id'];
    $land = $_POST['locatie'];
    $soort = $_POST['soort'];
    $tags = $_POST['tags'];
    $mensen = $_POST['prijs'];

    $stmt = $pdo->prepare("UPDATE plaatsen SET land=?, soort=?, tags=?, mensen=? WHERE id=?");
    $stmt->execute([$land, $soort, $tags, $mensen, $id]);
    header("Location: vlucht-beheer.php");
    exit;
}

// Ophalen van alle plaatsen
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
    <h1>Vluchten beheren</h1>

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
                <input type="number" name="mensen" value="<?= htmlspecialchars($plaats['prijs']) ?>">
            </label>
            <button type="submit" name="update">Bijwerken</button>
            <a href="?verwijder=<?= $plaats['id'] ?>" onclick="return confirm('Weet je zeker dat je deze vlucht wilt verwijderen?')">Verwijder</a>
        </form>
    <?php endforeach; ?>
</main>
</body>
</html>
