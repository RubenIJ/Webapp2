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

<?php require_once("frontend/header.php"); ?>

<div class="bigboy">Bigboy is zichtbaar!</div>

<?php require_once("frontend/footer.php"); ?>

</body>
</html>
