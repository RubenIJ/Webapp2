<?php
session_start();
require_once '../components/config.php';

if (!isset($_SESSION['gebruiker_id'])) {
    header("Location: ../login/login.php");
    exit;
}

$gebruiker_id = $_SESSION['gebruiker_id'];
$reis_id = $_POST['reis_id'] ?? null;

if ($reis_id && is_numeric($reis_id)) {
    $stmt = $PDO->prepare("INSERT IGNORE INTO favorieten (gebruiker_id, reis_id) VALUES (?, ?)");
    $stmt->execute([$gebruiker_id, $reis_id]);
}

header("Location: ../gebruiker-paginas/profiel.php"); // Of terug naar vorige pagina
exit;
?>
