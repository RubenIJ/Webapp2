<?php session_start();
?>
=======
<?php
// review.php
$melding = "";
$success = false;

if (isset($_GET['fout'])) {
    if ($_GET['fout'] === 'leeg') {
        $melding = "Vul alle velden in.";
    } elseif ($_GET['fout'] === 'database') {
        $melding = "Opslaan in database mislukt.";
    } else {
        $melding = "Onjuiste aanvraag.";
    }
} elseif (isset($_GET['success'])) {
    $success = true;
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <title>Laat een review achter</title>
    <link rel="stylesheet" href="../css/styling.css" />
    <link rel="stylesheet" href="../css/xing.css" />
    <link rel="stylesheet" href="../css/ruben.css" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" />
</head>
<body>

<header><?php require_once '../components/header.php'; ?></header>

<div class="contact-container">
    <div class="contact-box">
        <h2 class="contact-title">Laat een review achter</h2>

        <?php if (!empty($melding)): ?>
            <div class="contact-melding"><?= htmlspecialchars($melding) ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="contact-melding" style="color: green;">Bedankt voor je review!</div>
        <?php endif; ?>

        <form action="../components/verwerk_review.php" method="post" class="contact-form">
            <div class="form-group">
                <label for="naam">Jouw naam:</label>
                <input type="text" name="naam" id="naam" required />
            </div>

            <div class="form-group">
                <label for="email">E-mailadres:</label>
                <input type="email" name="email" id="email" required />
            </div>

            <div class="form-group">
                <label for="beoordeling">Beoordeling (1 t/m 5):</label>
                <select name="beoordeling" id="beoordeling" required>
                    <option value="">-- Kies een cijfer --</option>
                    <option value="1">1 - Slecht</option>
                    <option value="2">2</option>
                    <option value="3">3 - Gemiddeld</option>
                    <option value="4">4</option>
                    <option value="5">5 - Uitstekend</option>
                </select>
            </div>

            <div class="form-group">
                <label for="review">Je review:</label>
                <textarea name="review" id="review" required></textarea>
            </div>

            <button type="submit" class="contact-button">Verstuur review</button>
        </form>
    </div>
</div>

<footer><?php require_once '../components/footer.php'; ?></footer>

</body>
</html>
