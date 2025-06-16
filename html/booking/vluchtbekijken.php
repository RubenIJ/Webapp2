<?php
session_start();
require_once '../components/config.php';

$reis_id = $_GET['id'] ?? null;

if (!$reis_id || !is_numeric($reis_id)) {
    header("Location: ../extra-pagina's/ons-aanbod.php");
    exit;
}

// Haal reis op
$stmt = $PDO->prepare("SELECT * FROM plaatsen WHERE id = ?");
$stmt->execute([$reis_id]);
$item = $stmt->fetch();

if (!$item) {
    echo "Reis niet gevonden.";
    exit;
}

// Check favoriet
$is_favoriet = false;
$gebruiker_id = $_SESSION['gebruiker_id'] ?? null;

if ($gebruiker_id) {
    $stmt = $PDO->prepare("SELECT 1 FROM favorieten WHERE gebruiker_id = ? AND reis_id = ?");
    $stmt->execute([$gebruiker_id, $reis_id]);
    $is_favoriet = $stmt->fetch() !== false;
}
?>



<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ons-aanbod</title>
    <link rel="stylesheet" href="../css/styling.css">
    <link rel="stylesheet" href="../css/xing.css">
    <link rel="stylesheet" href="../css/ruben.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
</head>
<body>
<header> <?php require_once '../components/header.php' ?></header>
<div class="vluchten-booken-container">
    <h1><?= htmlspecialchars($item['locatie']) ?></h1>
    <div class="vluchten-booken-details">
        <p><strong>Soort:</strong> <?= htmlspecialchars($item['soort']) ?></p>
        <p><strong>Tags:</strong> <?= htmlspecialchars($item['tags']) ?></p>
        <p><strong>Prijs per persoon: €</strong> <?= htmlspecialchars($item['prijs']) ?></p>

        <p class="vluchten-booken-beschrijving"><strong>Info:</strong><br> <?= nl2br(htmlspecialchars($item['beschrijving'])) ?></p>
    </div>
    <div class="favorieten-filter-container">
        <a href="boeken.php?id=<?= $item['id'] ?>" class="favorieten-filter-boek">✈️ Boek deze reis</a>

        <a href="javascript:history.back()" class="favorieten-filter-terug">← Terug naar overzicht</a>

        <form method="POST" action="toggle-favorieten.php" class="favorieten-filter-form">
            <input type="hidden" name="reis_id" value="<?= $reis_id ?>">
            <input type="hidden" name="terug_url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">

            <?php if ($is_favoriet): ?>
                <button type="submit" name="actie" value="verwijder" class="favorieten-filter-btn verwijder">
                    💔 Verwijder uit favorieten
                </button>
            <?php else: ?>
                <button type="submit" name="actie" value="toevoegen" class="favorieten-filter-btn toevoegen">
                    ❤️ Voeg toe aan favorieten
                </button>
            <?php endif; ?>
        </form>
    </div>



</div>
</body>
<footer> <?php require_once '../components/footer.php' ?></footer>



</html>
