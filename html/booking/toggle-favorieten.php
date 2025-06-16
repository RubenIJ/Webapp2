<?php
session_start();
require_once '../components/config.php';

$gebruiker_id = $_SESSION['gebruiker_id'] ?? null;
$reis_id = $_POST['reis_id'] ?? null;
$actie = $_POST['actie'] ?? '';
$terug_url = $_POST['terug_url'] ?? '../index.php';

if ($gebruiker_id && $reis_id && is_numeric($reis_id)) {
    if ($actie === 'toevoegen') {
        $stmt = $PDO->prepare("INSERT IGNORE INTO favorieten (gebruiker_id, reis_id) VALUES (?, ?)");
        $stmt->execute([$gebruiker_id, $reis_id]);
    } elseif ($actie === 'verwijder') {
        $stmt = $PDO->prepare("DELETE FROM favorieten WHERE gebruiker_id = ? AND reis_id = ?");
        $stmt->execute([$gebruiker_id, $reis_id]);
    }
}

header("Location: " . $terug_url);
exit;