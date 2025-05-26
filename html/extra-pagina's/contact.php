<?php
$melding = "";

if (isset($_GET['fout'])) {
    if ($_GET['fout'] === 'leeg') {
        $melding = "Vul alle velden in.";
    } elseif ($_GET['fout'] === 'database') {
        $melding = "Opslaan in database mislukt.";
    } else {
        $melding = "Onjuiste aanvraag.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
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

<header><?php require_once'../components/header.php'?></header>

<div class="contact-container">
    <div class="contact-box">
        <h2 class="contact-title">Contacteer ons</h2>

        <?php if (!empty($melding)): ?>
            <div class="contact-melding"><?= $melding ?></div>
        <?php endif; ?>

        <form action="../components/verwerk.php" method="post" class="contact-form">
            <div class="form-group">
                <label for="naam">Naam:</label>
                <input type="text" name="naam" id="naam" required>
            </div>

            <div class="form-group">
                <label for="email">E-mailadres:</label>
                <input type="email" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label for="bericht">Bericht:</label>
                <textarea name="bericht" id="bericht" required></textarea>
            </div>

            <button type="submit" class="contact-button">Verstuur</button>
        </form>
    </div>
</div>

<footer><?php require_once'../components/footer.php'?></footer>

</body>
</html>
