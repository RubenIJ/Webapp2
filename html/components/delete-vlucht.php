<?php
$reis_id = $_GET['id']; // of waar je het ID vandaan haalt

// Update boekingen die aan deze reis gekoppeld zijn
$updateStmt = $PDO->prepare("UPDATE boekingen SET status = 'geannuleerd' WHERE reis_id = :id");
$updateStmt->execute(['id' => $reis_id]);

// Dan pas verwijderen
$deleteStmt = $PDO->prepare("DELETE FROM plaatsen WHERE id = :id");
$deleteStmt->execute(['id' => $reis_id]);
?>