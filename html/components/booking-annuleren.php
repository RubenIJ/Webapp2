<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['gebruiker_id'])) {
    header("Location: ../login/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['boeking_id'])) {
    $boeking_id = $_POST['boeking_id'];
    $gebruiker_id = $_SESSION['gebruiker_id'];

    // Check of de boeking van deze gebruiker is
    $check = $PDO->prepare("SELECT * FROM boekingen WHERE id = :id AND gebruiker_id = :gebruiker_id");
    $check->execute([
        'id' => $boeking_id,
        'gebruiker_id' => $gebruiker_id
    ]);

    $result = $check->fetch();

    if ($result) {
        // Annuleer de boeking
        $annuleer = $PDO->prepare("
             UPDATE boekingen 
               SET status = 'geannuleerd', geannuleerd_op = NOW(), geannuleerd_door = 'gebruiker'
             WHERE id = :id
");
        $annuleer->execute(['id' => $boeking_id]);
    }
}

header("Location: ../gebruiker-paginas/profiel.php");
exit;
?>