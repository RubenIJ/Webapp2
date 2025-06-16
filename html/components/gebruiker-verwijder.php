<?php
require_once '../components/config.php';
session_start();

if (!isset($_SESSION['gebruiker_id'])) {
    header("Location: ../login/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['boeking_id'])) {
    $boeking_id = $_POST['boeking_id'];
    $gebruiker_id = $_SESSION['gebruiker_id'];

    // Alleen verwijderen als hij van de gebruiker is én geannuleerd is
    $stmt = $PDO->prepare("DELETE FROM boekingen WHERE id = :id AND gebruiker_id = :gebruiker_id AND status = 'geannuleerd'");
    $stmt->execute([
        'id' => $boeking_id,
        'gebruiker_id' => $gebruiker_id
    ]);
}

header("Location: ../gebruiker-paginas/profiel.php");
exit;
?>