<?php
require_once '../components/config.php';
session_start();

// Haal reviews op uit database
$stmt = $PDO->prepare("SELECT * FROM reviews ORDER BY geplaatst_op DESC");
$stmt->execute();
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Jouw Profiel</title>
    <link rel="stylesheet" href="../css/styling.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
</head>
<body>

<?php require("../components/admin-header.php"); ?>

<div class="reviews-container">
    <h2>Reviews Overzicht</h2>

    <?php if (empty($reviews)): ?>
        <p>Geen reviews gevonden.</p>
    <?php else: ?>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Beoordeling</th>
                <th>Review tekst</th>
                <th>Goedgekeurd</th>
                <th>Datum geplaatst</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($reviews as $review): ?>
                <tr>
                    <td><?= htmlspecialchars($review['id']) ?></td>
                    <td><?= htmlspecialchars($review['email']) ?></td>
                    <td><?= htmlspecialchars($review['beoordeling']) ?></td>
                    <td><?= htmlspecialchars($review['review_text']) ?></td>
                    <td><?= $review['goedgekeurd'] ? 'Ja' : 'Nee' ?></td>
                    <td><?= htmlspecialchars($review['geplaatst_op']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>

</body>
</html>
