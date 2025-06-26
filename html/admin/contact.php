<?php
session_start();
require_once '../components/config.php';

try {
    $stmt = $PDO->prepare("SELECT * FROM contact_berichten ORDER BY verzonden_op DESC");
    $stmt->execute();
    $berichten = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Fout bij ophalen berichten: " . $e->getMessage());
}
?>

<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Contact</title>
    <link rel="stylesheet" href="../css/styling.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
</head>
<body>
<header>
    <?php require("../components/admin-header.php"); ?>
</header>

<main class="admin-contact-container">
    <h1>Contactberichten</h1>

    <?php if (count($berichten) > 0): ?>
        <table class="admin-contact-tabel">
            <thead>
            <tr>
                <th>ID</th>
                <th>Naam</th>
                <th>Email</th>
                <th>Bericht</th>
                <th>Verzonden op</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($berichten as $bericht): ?>
                <tr>
                    <td><?= htmlspecialchars($bericht['id']) ?></td>
                    <td><?= htmlspecialchars($bericht['naam']) ?></td>
                    <td><?= htmlspecialchars($bericht['email']) ?></td>
                    <td><?= nl2br(htmlspecialchars($bericht['bericht'])) ?></td>
                    <td><?= htmlspecialchars($bericht['verzonden_op']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Er zijn nog geen berichten verzonden.</p>
    <?php endif; ?>
</main>
</body>



</html>
