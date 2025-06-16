<?php
require_once '../components/config.php';
session_start();
$bestemming = isset($_GET['bestemming']) ? htmlspecialchars($_GET['bestemming']) : '';
$datum = isset($_GET['datum']) ? htmlspecialchars($_GET['datum']) : '';
$personen = isset($_GET['personen']) ? (int)$_GET['personen'] : 1;

$sql = "SELECT * FROM plaatsen WHERE locatie LIKE :bestemming";
$stmt = $PDO->prepare($sql);
$stmt->bindValue(':bestemming', '%' . $bestemming . '%');
$stmt->execute();

$resultaten = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Zoekresultaten</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styling.css">
    <link rel="stylesheet" href="../css/xing.css">
    <link rel="stylesheet" href="../css/ruben.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
</head>
<body>

<header>
    <?php require_once("../components/header.php") ?>
</header>


<main class="allincl-content" id="zoekresultaten">
    <h1 style="text-align: center; margin-bottom: 30px;">Zoekresultaten voor: <?= htmlspecialchars($bestemming) ?></h1>

    <?php if ($resultaten): ?>
        <div id="vakantie-blok">
            <?php foreach ($resultaten as $reis): ?>
                <div id="vakanties">
                    <h3 id="kaart-locatie"><?= htmlspecialchars(ucfirst($reis['locatie'])) ?></h3>
                    <p id="kaart-tags"><strong>Tags:</strong> <?= htmlspecialchars($reis['tags']) ?></p>
                    <p id="kaart-soort"><?= htmlspecialchars($reis['soort']) ?></p>
                    <p><strong>Prijs: €</strong> <?= htmlspecialchars($reis['prijs']) ?></p>
                    <a href="vluchtbekijken.php?id=<?= $reis['id'] ?>" class="vlucht-btn">Bekijk reis</a>
                </div>
            <?php endforeach; ?>

        </div>
        <div class="zoek-pagina-terug-container">
            <button onclick="history.back()" class="zoek-pagina-terugknop"><i class="fa-solid fa-arrow-left"></i> Terug
                naar vorige pagina</button>
        </div>

    <?php else: ?>
        <p style="text-align: center;">Geen vluchten gevonden.</p>
    <?php endif; ?>
</main>

<footer>
    <?php require_once("../components/footer.php") ?>
</footer>

</body>
</html>
