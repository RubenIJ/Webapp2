<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Contact</title>
    <link rel="stylesheet" href="../css/styling.css">
    <link rel="stylesheet" href="../css/xing.css">
    <link rel="stylesheet" href="../css/ruben.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>

</head>
<body>
<header>
    <?php require_once("../components/header.php") ?>
</header>
<main>
     <p>Stuur ons een E-Mail als je nog vragen hebt</p>
    <form class="contact-form" action="contact.php" method="post">
        <input type="text" name="name" placeholder="Naam">
        <input type="text" name="mail" placeholder="Jouw mail">
        <input type="text" name="subject" placeholder="Onderwerp">
        <textarea name="message" placeholder="Bericht"></textarea>
        <button type="Submit" name="Submit">Verstuur</button>
    </form>
</main>
<footer>
    <?php require_once("../components/footer.php") ?>
</footer>
<!-- test -->
</body>