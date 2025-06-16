<?php
session_start();
$servername = "db";
$username = "root";
$password = "rootpassword";

try {
    $conn = new PDO("mysql:host=$servername;dbname=Gebruikers", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

$search = '';
if (isset($_POST['search'])) {
    $search = htmlspecialchars($_POST['query']);
    $sql = "SELECT * FROM plaatsen WHERE land LIKE :search OR soort LIKE :search OR tags LIKE :search";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':search', '%' . $search . '%');
    $stmt->execute();
} else {
    $sql = "SELECT * FROM plaatsen ORDER BY locatie ASC";
    $stmt = $conn->query($sql);
}

$menu = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ons-aanbod</title>
    <link rel="stylesheet" href="../css/styling.css">
    <link rel="stylesheet" href="../css/xing.css">
    <link rel="stylesheet" href="../css/ruben.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
</head>
<body>

<header>
    <?php require_once("../components/header.php") ?>
</header>

<main class="allincl-content" id="locatie-allincl">
    <form method="POST">
        <input type="text" name="query" placeholder="Zoek land, soort of tags" value="<?= htmlspecialchars($search) ?>">
        <button type="submit" name="search">Zoeken</button>
    </form>

    <?php if (!empty($menu)): ?>
        <div class="vakantie-blok">
            <?php foreach ($menu as $item): ?>
                <div class="vakanties">
                    <h3><?= htmlspecialchars(ucfirst($item['locatie'])) ?></h3>
                    <p><strong>Tags:</strong> <?= htmlspecialchars($item['tags']) ?></p>
                    <p><strong>Prijs: €</strong> <?= htmlspecialchars($item['prijs']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Geen resultaten gevonden.</p>
    <?php endif; ?>

</main>

<footer>
    <?php require_once("../components/footer.php") ?>
</footer>

</body>
</html>
