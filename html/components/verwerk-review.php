<?php
session_start();

$servername = "db";
$username = "root";
$password = "rootpassword";
$dbname = "vliegmaatschapij";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    header("Location: ../extra-pagina's/reviews.php?fout=database");
    exit;
}

if (
    empty($_POST['naam']) ||
    empty($_POST['email']) ||
    empty($_POST['beoordeling']) ||
    empty($_POST['review'])
) {
    header("Location:../extra-pagina's/reviews.php?fout=leeg");
    exit;
}

$naam = htmlspecialchars(trim($_POST['naam']));
$email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
$beoordeling = intval($_POST['beoordeling']);
$review = htmlspecialchars(trim($_POST['review']));

if (!$email) {
    header("Location: ../extra-pagina's/reviews.php?fout=leeg");
    exit;
}

$gebruiker_id = isset($_SESSION['gebruiker_id']) ? $_SESSION['gebruiker_id'] : 1;

$sql = "INSERT INTO reviews (gebruiker_id, email, beoordeling, review_text) 
        VALUES (:gebruiker_id, :email, :beoordeling, :review_text)";
$stmt = $conn->prepare($sql);

$stmt->bindParam(':gebruiker_id', $gebruiker_id, PDO::PARAM_INT);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':beoordeling', $beoordeling, PDO::PARAM_INT);
$stmt->bindParam(':review_text', $review);

if ($stmt->execute()) {
    header("Location:../extra-pagina's/reviews.php?success=true");
    exit;
} else {
    header("Location: ../extra-pagina's/reviews.php?fout=database");
    exit;
}