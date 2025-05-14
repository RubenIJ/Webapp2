<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/ruben.css">
    <link rel="stylesheet" href="../css/styling.css">

    <title>Contact</title>
</head>
<body>
<main>
    <p>Stuur ons een E-Mail als je vragen hebt :3</p>
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
</body>
</html>