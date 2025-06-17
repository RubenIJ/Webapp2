<?php
session_start();
require_once "../components/config.php";
$sql = "SELECT * FROM plaatsen WHERE locatie LIKE 'spanje'";
$stmt = $PDO->query($sql);
$SpaanseReizen = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Spanje</title>
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
<div class="spanje ruimte">
    <div class="spanje blok">
        <div class="spanje inhoud">
            <h1>Spaanse steden</h1>
            <p>De drukke steden van Spanje bruisen van leven, cultuur en eindeloze energie.</p>
            <p>In Barcelona hoor je het geroezemoes van toeristen langs de Ramblas, terwijl in Madrid de pleinen gevuld
                zijn met muziek, tapas en nachtelijke gesprekken.</p>
            <p>Valencia danst tussen traditie en moderniteit, met festivals die de straten vullen met vuur en kleur.</p>
            <p>Elke stad is een levend schilderij van hectiek, passie en Spaanse flair — een symfonie van mensen,
                kleuren en geluiden die nooit echt stopt.</p>
        </div>
        <div class="vakantie-fotos">
            <img src="../fotos/spanje-stad.jpg" alt="spaanse stad">
        </div>
    </div>
</div>
<div class="spanje ruimte">
    <div class="spanje blok">
        <div class="vakantie-fotos">
            <img src="../fotos/spanje-kust.jpg" alt="spaanse kust">
        </div>
        <div class="spanje inhoud">
            <h1>Spaanse kust</h1>
            <p>Langs de kust van Spanje kussen gouden stranden het azuurblauwe water van de Middellandse Zee.</p>
            <p>De zon straalt fel op de boulevards vol palmbomen, waar vissersbootjes deinen in de haven en de geur van
                zeevruchten zich mengt met zout en zon.</p>
            <p>Van de ruige kliffen van de Costa Brava tot de zachte golven van de Costa del Sol: de kust is een plek
                van vrijheid, zomeravonden en eindeloze horizon.</p>
            <p>Hier voelt elke ademhaling als vakantie.</p>
        </div>

    </div>
</div>
<div class="spanje ruimte">
    <div class="spanje blok">
        <div class="spanje inhoud">
            <h1>Spaanse natuur</h1>
            <p>De natuur van Spanje is ruig, veelzijdig en verrassend stil.</p>
            <p>Van de besneeuwde toppen van de Pyreneeën tot de uitgestrekte vlaktes van La Mancha — elke regio heeft
                zijn eigen ritme.</p>
            <p>Wandelend door nationale parken als Doñana of Picos de Europa ontdek je wilde paarden, flamingo's en
                diepe stilte tussen eeuwenoude bomen.</p>
            <p>In Spanje is de natuur geen achtergrond, maar een levendig decor vol leven, kleur en contrast.</p>
            <p>Een plek waar je ademhaling vertraagt en je je weer klein voelt onder een oneindige hemel.</p>
        </div>
        <div class="vakantie-fotos">
            <img src="../fotos/spanje-natuur.jpg" alt="spaanse natuur">
        </div>
    </div>
</div>
<div class="allincl-content" id="locatie-allincl">
    <div class="knop-indeling-filter">
        <h2>✈️ Beschikbare reizen naar Spanje</h2>

    </div>

    <?php if (!empty($SpaanseReizen)): ?>
        <div class="vakantie-container">
            <?php foreach ($SpaanseReizen as $reis): ?>
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
        <p style="text-align:center;">Er zijn momenteel geen beschikbare reizen naar Spanje.</p>
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