<?php
session_start();
require_once "../components/config.php";
$sql = "SELECT * FROM plaatsen WHERE locatie LIKE 'Noordpool' OR locatie LIKE 'De noorden van de polen'";
$stmt = $PDO->query($sql);
$koudeReizen = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Noordpool</title>
    <link rel="stylesheet" href="../css/styling.css">

    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>

</head>
<body>
<header>
    <?php require_once("../components/header.php") ?>
</header>
<div class="naamgeving">
    <h1>Populaire locaties</h1>
</div>
<button id="toggleRegistreer"  class="locatie-toggle-knop">📍 Toon/verberg populaire locaties</button>

<div class="index-populaire-locaties-indeling" id="locatieBlok" style="display: none">
    <div class="locatie-container">
        <div class="locatie-card">
            <img src="../fotos/parijs.jpeg" alt="Frankrijk">
            <a href="frankrijk.php"><div class="locatie-overlay">Frankrijk</div></a>
        </div>
        <div class="locatie-card">
            <img src="../fotos/barcelona.jpg" alt="Spanje">
            <a href="spanje.php"> <div class="locatie-overlay">Spanje</div></a>
        </div>
        <div class="locatie-card">
            <img src="../fotos/noordpool.jpg" alt="Noordpool">
            <a href="noordpool.php"> <div class="locatie-overlay">Noordpool</div></a>
        </div>
    </div>
</div>
<div class="noordpool ruimte">
    <div class="noordpool blok">
        <div class="noordpool inhoud">
            <h1>Noordpools landschap</h1>
            <p>Het Noordpoollandschap is een adembenemend wit paradijs van uitgestrekte ijsvlaktes en bevroren
                zeeën.</p>
            <p>Overal zover het oog reikt zie je glinsterend zee-ijs en enorme ijsschotsen die langzaam drijven.</p>
            <p>In de zomer zorgen smeltende ijsvelden voor spiegelende waterpoelen, terwijl in de winter het ijs bijna
                oneindig uitstrekt onder het magische noorderlicht.</p>
            <p>Dit ruige, ongerepte landschap vormt het hart van een fragiel ecosysteem en biedt een unieke ervaring van
                pure natuur en stilte.</p>
        </div>
        <div class="vakantie-fotos">
            <img src="../fotos/noordpool.jpg" alt="noordpool landschap">
        </div>
    </div>
</div>
<div class="noordpool ruimte">
    <div class="blok-omgedraaid">
        <div class="noordpool inhoud">
            <h1>Noordpoolse hotels</h1>
            <p>Hotels op de Noordpool zijn bijzonder en uniek hier vind je geen grote resorts, maar vooral speciale
                lodges en onderzoeksstations die comfort combineren met avontuur.</p>
            <p>Veel accommodaties zijn duurzaam gebouwd om de natuur te beschermen en bieden een intieme ervaring midden
                in het ijs.</p>
            <p>Denk aan glazen koepels om het noorderlicht te bewonderen vanuit je bed, of warme tenten met luxe
                faciliteiten.</p>
            <p>Overnachten op de Noordpool is vooral voor avontuurlijke reizigers die dicht bij de natuur willen zijn,
                ver weg van de drukte.</p>
        </div>
        <div class="vakantie-fotos">
            <img src="../fotos/noordpool-hotel.jpg" alt="noordpool hotel">
        </div>
    </div>
</div>
<div class="noordpool ruimte">
    <div class="noordpool blok">
        <div class="noordpool inhoud">
            <h1>Noordpoolse dieren</h1>
            <p>De pooldieren zijn echte overlevers in het extreme koude klimaat van de Arctis.</p>
            <p>IJsberen zijn de koning van het ijs en jagen voornamelijk op zeehonden. Poolvossen hebben een dikke vacht
                die in de winter wit wordt, zodat ze perfect kunnen opgaan in de
                sneeuw.</p>
            <p>Walrussen gebruiken hun krachtige slagtanden om zich op het ijs te hijsen en verzamelen zich vaak in
                grote groepen.</p>
            <p>In het koude water leven bijzondere dieren zoals narwals, bekend om hun lange, spiraalvormige slagtand,
                en beluga’s, die ook wel de ‘witte walvissen’ worden genoemd.</p>
            <p>Deze dieren vormen samen een fragiel maar sterk ecosysteem dat nauw verbonden is met het unieke
                Noordpoollandschap.</p>
        </div>
        <div class="vakantie-fotos">
            <img src="../fotos/noordpool-dieren.jpg" alt="noordpool dieren">
        </div>
    </div>
</div>

<div class="allincl-content" id="locatie-allincl">
    <div class="knop-indeling-filter">
        <h2>✈️ Beschikbare reizen naar Noordpool</h2>

    </div>
    <?php if (!empty($koudeReizen)): ?>
        <div class="vakantie-container">
            <?php foreach ($koudeReizen as $reis): ?>
                <div class="vakantie-kaart">
                    <h3><?= htmlspecialchars($reis['locatie']) ?></h3>
                    <p><strong>Soort:</strong> <?= htmlspecialchars($reis['soort']) ?></p>
                    <p><strong>Tags:</strong> <?= htmlspecialchars($reis['tags']) ?></p>
                    <p><strong>Prijs: €</strong> <?= htmlspecialchars($reis['prijs']) ?></p>
                    <a href="../booking/vluchtbekijken.php?id=<?= $reis['id'] ?>" class="vlucht-btn">Bekijk reis</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Er zijn momenteel geen beschikbare reizen naar Noordpool.</p>
    <?php endif; ?>
</div>
    <footer>
    <?php require_once("../components/footer.php") ?>
</footer>
<script>
    document.getElementById('toggleRegistreer').addEventListener('click', function () {
        const locatieSectie = document.getElementById('locatieBlok');
        if (locatieSectie.style.display === 'none' || locatieSectie.style.display === '') {
            locatieSectie.style.display = 'block';
            this.textContent = '📍 Verberg populaire locaties';
        } else {
            locatieSectie.style.display = 'none';
            this.textContent = '📍 Toon populaire locaties';
        }
    });
</script>

</body>
</html>