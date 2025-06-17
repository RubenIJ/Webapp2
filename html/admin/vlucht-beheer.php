<?php
require_once '../components/config.php';
session_start();

// Vlucht annuleren (soft delete)
if (isset($_GET['verwijder'])) {
    $id = intval($_GET['verwijder']);
    $annuleer = $PDO->prepare("UPDATE boekingen SET status = 'geannuleerd', geannuleerd_op = NOW(), geannuleerd_door = 'admin' WHERE reis_id = :id");
    $annuleer->execute(['id' => $id]);

    $updateStmt = $PDO->prepare("UPDATE plaatsen SET actief = 0 WHERE id = ?");
    $updateStmt->execute([$id]);

    header("Location: vlucht-beheer.php");
    exit;
}

// Vlucht bijwerken
if (isset($_POST['update'])) {
    $stmt = $PDO->prepare("UPDATE plaatsen SET locatie=?, soort=?, tags=?, prijs=?, beschrijving=? WHERE id=?");
    $stmt->execute([
        $_POST['locatie'],
        $_POST['soort'],
        $_POST['tags'],
        $_POST['prijs'],
        $_POST['beschrijving'],
        $_POST['id']
    ]);
    header("Location: vlucht-beheer.php");
    exit;
}

// Vlucht toevoegen
if (isset($_POST['toevoegen'])) {
    $stmt = $PDO->prepare("INSERT INTO plaatsen (locatie, soort, tags, prijs, beschrijving) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['locatie'],
        $_POST['soort'],
        $_POST['tags'],
        $_POST['prijs'],
        $_POST['beschrijving']
    ]);
    header("Location: vlucht-beheer.php");
    exit;
}

// Haal vluchten op
$stmt = $PDO->query("SELECT * FROM plaatsen WHERE actief = 1 ORDER BY id ASC");
$plaatsen = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Haal geboekte reizen op
$stmt = $PDO->query("SELECT boekingen.*, plaatsen.locatie, plaatsen.prijs, gebruikers.gebruikersnaam, gebruikers.email FROM boekingen JOIN plaatsen ON boekingen.reis_id = plaatsen.id JOIN gebruikers ON boekingen.gebruiker_id = gebruikers.id ORDER BY boekingen.geboekt_op DESC");
$boekingen = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Admin Vluchtbeheer</title>
    <link rel="stylesheet" href="../css/styling.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
</head>
<body>
<header>
    <?php require("../components/admin-header.php"); ?>
</header>
<main class="admin-vlucht-container">
    <h1 class="vluchten-text">Vluchten beheren</h1>

    <button  id="toggleRegistreer" onclick="toggleSection('sectie-toevoegen')">➕ Nieuwe vlucht toevoegen</button>
    <div id="sectie-toevoegen" class="vluchten-toevoegen" style="display: none;">
        <h2 class="vluchten-text">Nieuwe vlucht toevoegen</h2>
        <form method="post" class="admin-vlucht-form">
            <label>Locatie:<input type="text" name="locatie" required></label>
            <label>Soort:<input type="text" name="soort" required></label>
            <label>Tags:<input type="text" name="tags"></label>
            <label>Prijs:<input type="number" name="prijs" required></label>
            <label>Beschrijving:<textarea name="beschrijving" rows="3" placeholder="Optioneel: beschrijving van deze vlucht..."></textarea></label>
            <button type="submit" name="toevoegen">Toevoegen</button>
        </form>
        <hr>
    </div>

    <button  id="toggleRegistreer" onclick="toggleSection('sectie-aanpassen')">✏️ Vluchten aanpassen</button>
    <div id="sectie-aanpassen" style="display: none;">
        <?php foreach ($plaatsen as $plaats): ?>
            <form method="post" class="admin-vlucht-form">
                <input type="hidden" name="id" value="<?= htmlspecialchars($plaats['id']) ?>">
                <label>Locatie:<input type="text" name="locatie" value="<?= htmlspecialchars($plaats['locatie']) ?>"></label>
                <label>Soort:<input type="text" name="soort" value="<?= htmlspecialchars($plaats['soort']) ?>"></label>
                <label>Tags:<input type="text" name="tags" value="<?= htmlspecialchars($plaats['tags']) ?>"></label>
                <label>Prijs:<input type="number" name="prijs" value="<?= htmlspecialchars($plaats['prijs']) ?>"></label>
                <label>Beschrijving:<textarea name="beschrijving" rows="3"><?= htmlspecialchars($plaats['beschrijving']) ?></textarea></label>
                <button type="submit" name="update">Bijwerken</button>
                <a href="?verwijder=<?= $plaats['id'] ?>" onclick="return confirm('Weet je zeker dat je deze vlucht wilt annuleren?')">Annuleer</a>
            </form>
        <?php endforeach; ?>
    </div>

    <button  id="toggleRegistreer" onclick="toggleSection('sectie-reizen')">📋 Geboekte reizen</button>
    <div id="sectie-reizen" class="admin-contact-tabel-wrapper" style="display: block;">
        <table class="admin-contact-tabel">
            <thead>
            <tr>
                <th>Gebruiker</th>
                <th>Email</th>
                <th>Bestemming</th>
                <th>Personen</th>
                <th>Vertrek</th>
                <th>Terug</th>
                <th>Geboekt op</th>
                <th>Status</th>
                <th>Actie</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($boekingen as $boeking): ?>
                <tr>
                    <td><?= htmlspecialchars($boeking['gebruikersnaam']) ?></td>
                    <td><?= htmlspecialchars($boeking['email']) ?></td>
                    <td><?= htmlspecialchars($boeking['locatie']) ?> (€<?= htmlspecialchars($boeking['prijs']) ?>)</td>
                    <td><?= htmlspecialchars($boeking['personen']) ?></td>
                    <td><?= date('d-m-Y', strtotime($boeking['vertrekdatum'])) ?></td>
                    <td><?= date('d-m-Y', strtotime($boeking['terugdatum'])) ?></td>
                    <td><?= date('d-m-Y', strtotime($boeking['geboekt_op'])) ?></td>
                    <td>
                        <?php if ($boeking['status'] === 'geannuleerd'): ?>
                            <span style="color:red;">Geannuleerd (door <?= $boeking['geannuleerd_door'] ?? 'onbekend' ?>)</span>
                        <?php else: ?>
                            Actief
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($boeking['status'] !== 'geannuleerd'): ?>
                            <form method="GET" onsubmit="return confirm('Weet je zeker dat je deze vlucht wilt annuleren?');">
                                <input type="hidden" name="verwijder" value="<?= $boeking['reis_id'] ?>">
                                <button type="submit" style="background-color: #c0392b; color: white; border: none; padding: 6px 10px; border-radius: 5px; cursor: pointer;">
                                    Annuleer
                                </button>
                            </form>
                        <?php else: ?>
                            —
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<script>
    function toggleSection(id) {
        const section = document.getElementById(id);
        section.style.display = (section.style.display === 'none') ? 'block' : 'none';
    }
</script>


</body>
</html>
