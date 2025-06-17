<?php session_start();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Bedankt!</title>
    <link rel="stylesheet" href="../css/styling.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
</head>
<body>

<header>
    <?php require_once("../components/header.php"); ?>
</header>

<main class="containers profiel-container">
    <h1 class="profiel-titel">🎉 Bedankt voor je bericht!</h1>
    <p class="geen-boekingen" style="text-align: center;">We nemen zo snel mogelijk contact met je op.</p>
    <div style="text-align: center; margin-top: 30px;">
        <a href="../index.php" class="favorieten-filter-terug">← Terug naar homepagina</a>
    </div>
</main>

<footer>
    <?php require_once("../components/footer.php"); ?>
</footer>

</body>
</html>
