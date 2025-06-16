<?php session_start();
?>

<!doctype html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title></title>
    <link rel="stylesheet" href="../css/styling.css">
    <link rel="stylesheet" href="../css/xing.css">
    <link rel="stylesheet" href="../css/ruben.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
</head>

<body>
<header>
    <?php require_once("../components/header.php") ?>
</header>

<div class="containers">
    <div class="index-indeling">
        <div class="index-indeling-blok">
            <div class="index-image-overlay">
                <img src="../fotos/questions.jpg" alt="Familievakantie">
                <a href="faq.php"><div class="index-overlay-text">
                        <h2>Veel gestelde vragen</h2>
                    </div></a>
            </div>
        </div>

        <div class="index-indeling-blok">
            <div class="index-image-overlay">
                <img src="../fotos/contact.jpg" alt="All Inclusive">
                <a href="contact.php"> <div class="index-overlay-text">
                        <h2>Contact</h2>
                    </div></a>
            </div>
        </div>

    </div>

    <div class="index-indeling">
        <div class="index-indeling-blok">
            <div class="index-image-overlay">
                <img src="../fotos/Vijf%20Sterren%20Beoordeling.png" alt="Familievakantie">
                <a href="reviews.php"><div class="index-overlay-text">
                        <h2>Reviews</h2>
                    </div></a>
            </div>
        </div>

        <div class="index-indeling-blok">
            <div class="index-image-overlay">
                <img src="../fotos/beleid.jpg" alt="All Inclusive">
                <a href="ons-beleid.php"> <div class="index-overlay-text">
                        <h2>Ons Beleid</h2>
                    </div></a>
            </div>
        </div>

    </div>
</div>
<footer>
    <?php require_once("../components/footer.php") ?>

</footer>

</body>

=======
    <title>Document</title>
</head>
<body>

</body>
</html>