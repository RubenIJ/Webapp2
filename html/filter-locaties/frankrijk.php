<?php
session_start();
require_once "../components/config.php";
$sql = "SELECT * FROM plaatsen WHERE locatie LIKE 'Frankrijk' OR locatie LIKE 'Parijs'";
$stmt = $PDO->query($sql);
$franseReizen = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Frankrijk</title>
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
<div class="frankrijk ruimte">
    <div class="frankrijk blok">
        <div class="frankrijk inhoud">
            <h1>Franse steden</h1>
            <p>Franse steden ademen elegantie, geschiedenis en stijl.</p>
            <p>In Parijs glinstert de Eiffeltoren boven brede boulevards, terwijl kunstenaars zich nestelen langs de
                Seine.</p>
            <p>Lyon charmeert met zijn oude straatjes en verfijnde gastronomie, en Marseille pulseert met Mediterrane
                warmte,</p>
            <p>kleurrijke markten en een mix van culturen.</p>
            <p>Elke stad is als een levend museum vol kunst, architectuur en dat ongrijpbare dat Frankrijk zo
                onweerstaanbaar maakt.</p>
        </div>
        <div class="vakantie-fotos">
            <img src="../fotos/frankrijk-stad.jpg" alt="frankrijk stad">
        </div>
    </div>
</div>
<div class="frankrijk ruimte">
    <div class="blok-omgedraaid">
        <div class="frankrijk inhoud">
            <h1>Franse kust</h1>
            <p>De Franse kust is puur poëzie in beweging.</p>
            <p>Aan de Côte d’Azur schittert de zon op het azuurblauwe water, waar jachten glijden langs mondaine
                badplaatsen als Nice en Cannes.</p>
            <p>Verder naar het westen dansen surfers op de golven van Biarritz en in Normandië breken de golven
                dramatisch tegen krijtrotsen onder grijze luchten vol mysterie.</p>
            <p>Elke kustlijn heeft haar eigen ritme: chique, wild of rustig maar altijd doordrenkt van zeezout,</p>
            <p>vrijheid en dat zachte Franse gevoel van leven zonder haast.</p>
        </div>
        <div class="vakantie-fotos">
            <img src="../fotos/frankrijk-kust.jpg" alt="frankrijk kust">
        </div>
    </div>
</div>
<div class="frankrijk ruimte">
    <div class="frankrijk blok">
        <div class="frankrijk inhoud">
            <h1>Franse dorpen</h1>
            <p>De Franse dorpjes zijn als scènes uit een dromerig schilderij.</p>
            <p>Denk aan steegjes geplaveid met keien, lavendelvelden tot aan de horizon, en oude stenen huizen met
                blauwgeverfde luiken.</p>
            <p>In de dorpen van de Provence ruik je versgebakken brood en hoor je het zachte geklik van pétanque op het
                dorpsplein.</p>
            <p>Hier leeft men langzaam, met wijn in de hand en zon op de huid.</p>
            <p>Elk dorp draagt een ziel vol charme, stilte en eeuwenoude verhalen die fluisteren door de muren.</p>
        </div>
        <div class="vakantie-fotos">
            <img src="../fotos/frankrijk-dorpje.jpg" alt="frankrijk dorp">
        </div>
    </div>
</div>
<div class="allincl-content" id="locatie-allincl">
    <div class="knop-indeling-filter">
        <h2>✈️ Beschikbare reizen naar Frankrijk</h2>

    </div>
    <?php if (!empty($franseReizen)): ?>
        <div class="vakantie-container">
            <?php foreach ($franseReizen as $reis): ?>
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
        <p style="text-align:center;">Er zijn momenteel geen beschikbare reizen naar Frankrijk.</p>
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