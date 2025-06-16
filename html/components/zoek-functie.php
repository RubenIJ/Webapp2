<?php
require_once 'config.php';

$zoekterm = $_POST['query'] ?? '';

if ($zoekterm === '') {
    echo "<p>Typ iets om te zoeken.</p>";
    exit;
}

$stmt = $PDO->prepare("SELECT * FROM plaatsen WHERE locatie LIKE :zoek OR soort LIKE :zoek OR tags LIKE :zoek");
$stmt->execute(['zoek' => '%' . $zoekterm . '%']);
$resultaten = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($resultaten)) {
    echo "<p>Geen resultaten voor '<strong>" . htmlspecialchars($zoekterm) . "</strong>'.</p>";
} else {
    foreach ($resultaten as $plaats) {
        echo "<div class='zoek-item'>";
        echo "<h3>" . htmlspecialchars($plaats['locatie']) . "</h3>";
        echo "<p>Soort: " . htmlspecialchars($plaats['soort']) . "</p>";
        echo "<p>Tags: " . htmlspecialchars($plaats['tags']) . "</p>";
        echo "<p>Prijs: €" . htmlspecialchars($plaats['prijs']) . "</p>";
        echo "</div><hr>";
    }
}
?>
