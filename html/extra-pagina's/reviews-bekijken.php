<?php
session_start();
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

<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <title>Reviews Bekijken</title>
    <link rel="stylesheet" href="../css/styling.css" />
    <link rel="stylesheet" href="../css/xing.css" />
    <link rel="stylesheet" href="../css/ruben.css" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" />

</head>
<body>

<header><?php require_once '../components/header.php'; ?></header>

<div class="contact-container review-pagina">
    <h2 class="contact-title">Goedgekeurde reviews</h2>


</div>
<?php if (count($reviews) === 0): ?>
    <p class="geen-boekingen">Er zijn nog geen goedgekeurde reviews.</p>
<?php else: ?>
    <ul class="boekingen-lijst">
        <?php foreach ($reviews as $review): ?>
            <li class="boeking-kaart">
                <div class="review-header">
                    <strong><?= htmlspecialchars($review['naam'] ?? 'Anoniem') ?></strong><br>
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

</body>
</html>
