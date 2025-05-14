<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

</head>
<body>
<header>
    <nav class="nav">
        <div class="links">
            <div class="logo">
                <img src="../fotos/logo.png" alt="Logo">
            </div>
            <a href="../extra%20pagina's/ons%20aanbod.php">Ons Aanbod</a>
            <a href="../extra%20pagina's/last%20minute.php">Last Minute</a>
            <a href="../extra%20pagina's/vragen%20en%20contact.php">Vragen & Contact</a>
        </div>
        <div class="login-links">
            <a href="../login/login-pagina.php">Login</a>
            <a href="../login/registreer.php">Registreer</a>
        </div>
    </nav>
</header>
<div class="index-foto">
    <img src="fotos/image%205.png" alt="">
</div>
<div class="index-form">
    <div class="index-formsearch">
        <form action="">
            <input type="text" placeholder="Waar wil je naartoe?">
            <input type="text" placeholder="Wanneer vertrek je?">
            <input type="text" placeholder="Aantal personen">
            <button type="submit">Zoeken</button>
        </form>
    </div></div>

<div class="index-">

</div>
<footer>
    <?php require_once("components/footer.php") ?>

</footer>

</body>
</html>
