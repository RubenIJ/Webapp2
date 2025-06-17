<?php
session_start();
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
<?php
require_once "../components/config.php";

try {
    $PDO = new PDO("mysql:host=db;dbname=vliegmaatschapij;charset=utf8mb4", "root", "rootpassword");
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database verbinding mislukt: " . $e->getMessage());
}

$sql = "SELECT email, beoordeling, review_text, geplaatst_op, goedgekeurd
        FROM reviews 
        WHERE goedgekeurd = 1 
        ORDER BY geplaatst_op DESC";

$stmt = $PDO->prepare($sql);
$stmt->execute();

$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" />
</head>
<body>

<header><?php require_once '../components/header.php'; ?></header>
<button id="toggleRegistreer"  class="locatie-toggle-knop">📍 Toon/verberg review achter laten</button>

<div class="contact-container"  >
    <div class="contact-box" id="locatieBlok" style="display: block">
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
                <select name="beoordeling" id="beoordeling" class="input-select" required>
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
<?php if (count($reviews) === 0): ?>
    <p class="geen-boekingen">Er zijn nog geen goedgekeurde reviews.</p>
<?php else: ?>
    <ul class="boekingen-lijst">
        <?php foreach ($reviews as $review): ?>
            <li class="boeking-kaart">
                <div class="review-header">
                    <strong><?= htmlspecialchars($review['email']) ?></strong><br>
                    <small><?= date('d-m-Y', strtotime($review['geplaatst_op'])) ?></small>
                </div>
                <div class="review-beoordeling">
                    <?php
                    $stars = intval($review['beoordeling']);
                    for ($i = 0; $i < 5; $i++) {
                        echo $i < $stars
                            ? '<i class="fas fa-star star"></i>'
                            : '<i class="far fa-star star"></i>';
                    }
                    ?>
                </div>
                <p class="review-text"><?= nl2br(htmlspecialchars($review['review_text'])) ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>



<footer><?php require_once '../components/footer.php'; ?></footer>
<script>
    document.getElementById('toggleRegistreer').addEventListener('click', function () {
        const locatieSectie = document.getElementById('locatieBlok');
        if (locatieSectie.style.display === 'none' || locatieSectie.style.display === '') {
            locatieSectie.style.display = 'block';
            this.textContent = '📍 Verberg review achter laten';
        } else {
            locatieSectie.style.display = 'none';
            this.textContent = '📍 Toon review achter laten';
        }
    });
</script>
</body>
</html>
