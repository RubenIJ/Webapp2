<?php
require_once '../components/config.php';
session_start();

if (!isset($_SESSION['gebruiker_id'])) {
    header("Location: ../login/login.php");
    exit;
}

$gebruiker_id = $_SESSION['gebruiker_id'];
$stmt = $PDO->prepare("
    SELECT plaatsen.* 
    FROM favorieten 
    JOIN plaatsen ON favorieten.reis_id = plaatsen.id 
    WHERE favorieten.gebruiker_id = :id
");
$stmt->bindValue(':id', $gebruiker_id, PDO::PARAM_INT);
$stmt->execute();
$favorieten = $stmt->fetchAll();

$stmt = $PDO->prepare("
    SELECT boekingen.*, plaatsen.locatie, plaatsen.prijs
    FROM boekingen 
    JOIN plaatsen ON boekingen.reis_id = plaatsen.id
    WHERE boekingen.gebruiker_id = :id
    ORDER BY geboekt_op DESC
");
$stmt->bindValue(':id', $gebruiker_id, PDO::PARAM_INT);
$stmt->execute();
$boekingen = $stmt->fetchAll();
$aantal_geannuleerd = 0; // ✅ Toegevoegd: voorkomt undefined warning

foreach ($boekingen as $b) {
    if ($b['status'] === 'geannuleerd') {
        $aantal_geannuleerd++;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_SESSION['gebruiker_id'];
    $gebruikersnaam = htmlspecialchars($_POST['gebruikersnaam']);
    $email = htmlspecialchars($_POST['email']);

    $stmt = $PDO->prepare("UPDATE gebruikers SET gebruikersnaam = ?, email = ? WHERE id = ?");
    $stmt->execute([$gebruikersnaam, $email, $id]);

    $_SESSION['gebruikersnaam'] = $gebruikersnaam;
    $_SESSION['email'] = $email;

    header("Location: ../gebruiker-paginas/profiel.php");
    exit;
}
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
<?php require("../components/header.php"); ?>

<div class="containers profiel-container">
    <h1 class="profiel-titel">Welkom terug, <?= htmlspecialchars($_SESSION['gebruikersnaam']) ?>!</h1>

    <button id="toggleRegistreer" onclick="toggleSection('persoonlijke-info')">👤 Persoonlijke gegevens</button>
    <div id="persoonlijke-info" style="display:none;">
        <form action="profiel.php" method="POST" >
            <ul class="boekingen-lijst">
                <li class="boeking-kaart">
                    <label for="gebruikersnaam"><strong>Gebruikersnaam:</strong></label><br>
                    <input class="profiel-aanpassen" type="text" name="gebruikersnaam" id="gebruikersnaam" value="<?= htmlspecialchars($_SESSION['gebruikersnaam']) ?>" required><br><br>

                    <label for="email"><strong>E-mailadres:</strong></label><br>
                    <input class="profiel-aanpassen" type="email" name="email" id="email" value="<?= htmlspecialchars($_SESSION['email']) ?>" required><br><br>

                    <div class="favoriet-actie">
                        <button type="submit" name="update" class="favoriet-btn">Wijzig gegevens</button>
                    </div>
                </li>
            </ul>
        </form>
    </div>


    <button  id="toggleRegistreer" onclick="toggleSection('vlucht-overzicht')">🛫 Uw geboekte reizen</button>
    <div id="vlucht-overzicht" style="display:none;">
        <?php if ($aantal_geannuleerd > 0): ?>
            <div class="cancel-melding">
                ⚠️ Je hebt <?= $aantal_geannuleerd ?> geannuleerde reis<?= $aantal_geannuleerd > 1 ? 'sen' : '' ?>. Bekijk ze hieronder.
            </div>
        <?php endif; ?>

        <?php if (count($boekingen) === 0): ?>
            <p class="geen-boekingen">U heeft nog geen reizen geboekt.</p>
        <?php else: ?>
            <ul class="boekingen-lijst">
                <?php foreach ($boekingen as $boeking): ?>
                    <li class="boeking-kaart">
                        <div><strong><?= htmlspecialchars($boeking['locatie']) ?></strong> – €<?= htmlspecialchars($boeking['prijs']) ?> – <?= htmlspecialchars($boeking['personen']) ?> personen</div>
                        <div>
                            📅 Vertrek: <?= date('d-m-Y', strtotime($boeking['vertrekdatum'])) ?> –
                            ↩️ Terug: <?= date('d-m-Y', strtotime($boeking['terugdatum'])) ?> –
                            📝 Geboekt op <?= date('d-m-Y', strtotime($boeking['geboekt_op'])) ?>
                        </div>

                        <?php if ($boeking['status'] === 'geannuleerd'): ?>
                            <div class="status-label geannuleerd">
                                Geannuleerd op <?= date('d-m-Y', strtotime($boeking['geannuleerd_op'])) ?> (<?= $boeking['geannuleerd_door'] === 'admin' ? 'systeem' : 'door jou' ?>)
                            </div>
                            <form action="../components/gebruiker-verwijder.php" method="POST" class="verwijder-form">
                                <input type="hidden" name="boeking_id" value="<?= $boeking['id'] ?>">
                                <button type="submit" class="verwijder-btn">Verwijder</button>
                            </form>
                        <?php else: ?>
                            <form action="../components/booking-annuleren.php" method="POST" class="annuleer-form">
                                <input type="hidden" name="boeking_id" value="<?= $boeking['id'] ?>">
                                <button type="submit" class="annuleer-btn">Annuleer</button>
                            </form>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <button  id="toggleRegistreer" onclick="toggleSection('favorieten-info')">⭐ Mijn favorieten</button>
    <div id="favorieten-info" style="display:block;">
        <?php if (empty($favorieten)): ?>
            <p class="geen-boekingen">Je hebt nog geen favorieten opgeslagen.</p>
        <?php else: ?>
            <ul class="boekingen-lijst">
                <?php foreach ($favorieten as $favoriet): ?>
                    <li class="boeking-kaart">
                        <strong><?= htmlspecialchars($favoriet['locatie']) ?></strong> –
                        <?= htmlspecialchars($favoriet['soort']) ?> –
                        €<?= htmlspecialchars($favoriet['prijs']) ?>
                        <div class="favoriet-actie">
                            <form method="POST" action="../booking/toggle-favorieten.php">
                                <input type="hidden" name="reis_id" value="<?= $favoriet['id'] ?>">
                                <input type="hidden" name="terug_url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                                <button type="submit" name="actie" value="verwijder" class="favoriet-btn verwijder">💔 Verwijder</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

</div>

<script>
    function toggleSection(id) {
        const el = document.getElementById(id);
        el.style.display = (el.style.display === 'none') ? 'block' : 'none';
    }
</script>
</body>

</html>
