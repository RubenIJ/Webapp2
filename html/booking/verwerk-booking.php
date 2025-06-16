<?php
require_once '../components/config.php';
session_start();

if (!isset($_SESSION['gebruiker_id'])) {
    header("Location: ../login/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gebruiker_id = $_SESSION['gebruiker_id'];
    $reis_id = $_POST['reis_id'];
    $personen = $_POST['personen'];
    $vertrekdatum = $_POST['vertrekdatum'];
    $terugdatum = $_POST['terugdatum'];

    $stmt = $PDO->prepare("
        INSERT INTO boekingen (gebruiker_id, reis_id, personen, vertrekdatum, terugdatum)
        VALUES (:gebruiker_id, :reis_id, :personen, :vertrekdatum, :terugdatum)
    ");
    $stmt->execute([
        'gebruiker_id' => $gebruiker_id,
        'reis_id' => $reis_id,
        'personen' => $personen,
        'vertrekdatum' => $vertrekdatum,
        'terugdatum' => $terugdatum
    ]);

    header("Location: ../gebruiker-paginas/profiel.php");
    exit;
}
?>
