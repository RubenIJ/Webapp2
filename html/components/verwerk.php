<?php
require_once("configruben.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $naam = htmlspecialchars(trim($_POST["naam"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $bericht = htmlspecialchars(trim($_POST["bericht"]));

    if (empty($naam) || empty($email) || empty($bericht)) {
        header("Location: contact.php?fout=leeg");
        exit;
    }

    $sql = "INSERT INTO contact_berichten (naam, email, bericht) VALUES (:naam, :email, :bericht)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':naam', $naam);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':bericht', $bericht);

    try {
        $stmt->execute();
        header("Location: bedankt.php");
        exit;
    } catch (PDOException $e) {
        header("Location: contact.php?fout=database");
        exit;
    }

} else {
    header("Location: contact.php?fout=onjuist");
    exit;
}
