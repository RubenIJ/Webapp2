<?php
session_start();
require_once '../components/config.php';
$search = '';
if (isset($_POST['search'])) {
    $search = htmlspecialchars($_POST['query']);
    $sql = "SELECT * FROM plaatsen WHERE locatie LIKE :search OR soort LIKE :search OR tags LIKE :search";
    $stmt = $PDO->prepare($sql);
    $stmt->bindValue(':search', '%' . $search . '%');
    $stmt->execute();
} else {
    $sql = "SELECT * FROM plaatsen ORDER BY locatie ASC";
    $stmt = $PDO->query($sql);
}

$menu = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ons-aanbod</title>
    <link rel="stylesheet" href="../css/styling.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
</head>
<body>

<header>
    <?php require_once("../components/header.php") ?>
</header>
<div class="header-foto">

    <img src="../fotos/ons-aanbod.png" alt="">
</div>
<main class="allincl-content" id="locatie-allincl">
    <div class="knop-indeling-filter">
        <form method="POST" class="filter-zoek-combo">
            <input type="text" id="zoekQuery" placeholder="Zoek land, soort of tags..." aria-label="Zoeken">
            <button type="button" id="filterToggle">Filters</button>
        </form>
    </div>
    <?php require_once '../components/filter-bar.php'; ?>

    <?php if (!empty($menu)): ?><div class="vakantie-container" id="vakantie-blok">
        <?php foreach ($menu as $item): ?>
            <div class="vakantie-kaart">
                <h3 id="kaart-locatie"><?= htmlspecialchars(ucfirst($item['locatie'])) ?></h3>
                <p id="kaart-tags"><strong>Tags:</strong> <?= htmlspecialchars($item['tags']) ?></p>
                <p id="kaart-soort"><?= htmlspecialchars($item['soort']) ?></p>
                <p><strong>Prijs: €</strong> <?= htmlspecialchars($item['prijs']) ?></p>
                <a href="../booking/vluchtbekijken.php?id=<?= $item['id'] ?>" class="vlucht-btn">Bekijk reis</a>
            </div>
        <?php endforeach; ?>
        </div>

    <?php else: ?>
        <p>Geen resultaten gevonden.</p>
    <?php endif; ?>

</main>

<footer>
    <?php require_once("../components/footer.php") ?>
</footer>
<script>
    const zoekInput = document.getElementById('zoekQuery');
    const kaarten = document.querySelectorAll('.vakantie-kaart');

    zoekInput.addEventListener('input', function () {
        const zoekterm = this.value.toLowerCase();

        kaarten.forEach(kaart => {
            const locatie = kaart.querySelector('#kaart-locatie').textContent.toLowerCase();
            const tags = kaart.querySelector('#kaart-tags').textContent.toLowerCase();
            const soort = kaart.querySelector('#kaart-soort').textContent.toLowerCase();

            const zichtbaar = locatie.includes(zoekterm) || tags.includes(zoekterm) || soort.includes(zoekterm);
            kaart.style.display = zichtbaar ? 'block' : 'none';
        });
    });
</script>

</body>
</html>
