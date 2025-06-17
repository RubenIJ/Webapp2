<?php session_start();

require_once '../components/config.php'; // Bevat jouw PDO-verbinding

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link rel="stylesheet" href="../css/styling.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
</head>
<body>
<header>
    <?php require("../components/admin-header.php"); ?>
</header>
<div class="containers">

<div class="index-indeling">
    <div class="index-indeling-blok">
        <div class="index-image-overlay">
            <img src="../fotos/vlucht.jpg" alt="Familievakantie">
            <a href="vlucht-beheer.php"><div class="index-overlay-text">
                    <h2>Vluchten beheer</h2>
                </div></a>
        </div>
    </div>

    <div class="index-indeling-blok">
        <div class="index-image-overlay">
            <img src="../fotos/account.png" alt="All Inclusive">
            <a href="account-beheer.php"> <div class="index-overlay-text">
                    <h2>Accounts beheren</h2>
                </div></a>
        </div>
    </div>
    <div class="index-indeling-blok">
        <div class="index-image-overlay">
            <img src="../fotos/contact.jpg" alt="All Inclusive">
            <a href="contact.php"> <div class="index-overlay-text">
                    <h2>Contact pagina</h2>
                </div></a>
        </div>
    </div>
    <div class="index-indeling-blok">
        <div class="index-image-overlay">
            <img src="../fotos/Vijf%20Sterren%20Beoordeling.png" alt="All Inclusive">
            <a href="reviews-validator.php"> <div class="index-overlay-text">
                    <h2>Review beheer</h2>
                </div></a>
        </div>
    </div>
</div>
</div>
</body>
</html>