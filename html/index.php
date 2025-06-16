<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start()
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Hoofdpagina</title>
    <link rel="stylesheet" href="css/styling.css">
    <link rel="stylesheet" href="css/xing.css">
    <link rel="stylesheet" href="css/ruben.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>

</head>
<body>
<header><?php require_once("components/header.php") ?>
</header>

<div class="index-foto">
    <img src="fotos/indo.png" alt="">
</div>
<div class="index-form">
    <div class="index-formsearch">
<form method="GET" action="booking/zoek-pagina.php">
    <input type="text" name="bestemming" placeholder="Waar wil je naartoe?" required>
    <input type="text" name="datum" placeholder="Wanneer vertrek je?">
    <input type="text" name="datum" placeholder="Wanneer kom je terug?">
    <input type="number" name="personen" placeholder="Aantal personen" min="1">
    <button type="submit">Zoeken</button>
</form>
    </div>
</div>
<div class="containers">
<div class="index-indeling">
    <div class="index-indeling-blok">
        <div class="index-image-overlay">
            <img src="fotos/familie-foto.png" alt="Familievakantie">
            <a href="extra-pagina's/familie.php"><div class="index-overlay-text">
                 <h2>Beste Familie Vakanties</h2>
            </div></a>
        </div>
    </div>

    <div class="index-indeling-blok">
        <div class="index-image-overlay">
            <img src="fotos/all-inclusive-foto.jpg" alt="All Inclusive">
            <a href="extra-pagina's/all-inclusive.php"> <div class="index-overlay-text">
              <h2>All Inclusive</h2>
            </div></a>
        </div>
    </div>
</div>

<div class="index-populaire-locaties-indeling">
<div class="index-bigboy3">
    <h2>Populaire Locaties</h2>
    <div class="locatie-container">
        <div class="locatie-card">
            <img src="fotos/parijs.jpeg" alt="Frankrijk">
            <a href="extra-pagina's/filter%20locaties/frankrijk.php"><div class="locatie-overlay">Frankrijk</div></a>
          </div>
        <div class="locatie-card">
            <img src="fotos/barcelona.jpg" alt="Spanje">
            <a href="extra-pagina's/filter%20locaties/spanje.php"> <div class="locatie-overlay">Spanje</div></a>
        </div>
        <div class="locatie-card">
            <img src="fotos/noordpool.jpg" alt="Noordpool">
            <a href="extra-pagina's/filter%20locaties/noordpool.php"> <div class="locatie-overlay">Noordpool</div></a>
        </div>
    </div>
</div>
</div>
</div>
<footer>
    <?php require_once("components/footer.php") ?>

</footer>

</body>
</html>
