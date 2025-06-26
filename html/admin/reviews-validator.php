<?php
require_once '../components/config.php';
session_start();

// Verwerk acceptatie van review
if (isset($_POST['update_review'])) {
    $review_id = (int)$_POST['review_id'];
    $nieuwe_status = (int)$_POST['nieuwe_status'];

    $update_stmt = $PDO->prepare("UPDATE reviews SET goedgekeurd = :status WHERE id = :id");
    $update_stmt->execute([':status' => $nieuwe_status, ':id' => $review_id]);
}

// Haal reviews op uit database
$stmt = $PDO->prepare("SELECT * FROM reviews ORDER BY geplaatst_op DESC");
$stmt->execute();
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Reviews</title>
    <link rel="stylesheet" href="../css/styling.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
</head>3
<body>

<?php require("../components/admin-header.php"); ?>

<div class="reviews-admin-container">
    <h2>Reviews Admin Overzicht</h2>

    <?php if (empty($reviews)): ?>
        <p>Geen reviews gevonden.</p>
    <?php else: ?>
        <table class="reviews-admin-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Beoordeling</th>
                <th>Review tekst</th>
                <th>Goedgekeurd</th>
                <th>Datum geplaatst</th>
                <th>Actie</th>
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
                    <td>
                        <form method="post">
                            <input type="hidden" name="review_id" value="<?= htmlspecialchars($review['id']) ?>">
                            <?php if ($review['goedgekeurd']): ?>
                                <button type="submit" name="update_review" value="1">Afkeuren</button>
                                <input type="hidden" name="nieuwe_status" value="0">
                            <?php else: ?>
                                <button type="submit" name="update_review" value="1">Accepteren</button>
                                <input type="hidden" name="nieuwe_status" value="1">
                            <?php endif; ?>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>

</body>
</html>