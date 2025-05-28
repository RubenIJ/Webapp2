<?php
session_start();

// Check of gebruiker is ingelogd
if (!isset($_SESSION['gebruikersnaam'])) {
    header("Location: ../login/login.php");
    exit;
}

// Haal info uit sessie
$naam = htmlspecialchars($_SESSION['gebruikersnaam']);
$is_admin = $_SESSION['is_admin'] ?? false;
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Jouw Profiel</title>
    <link rel="stylesheet" href="../css/styling.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <style>
        .profiel-box {
            max-width: 500px;
            margin: 100px auto;
            background: #f2f2f2;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.15);
            text-align: center;
            font-family: 'Montserrat', sans-serif;
        }
        .profiel-box h1 {
            margin-bottom: 20px;
        }
        .profiel-box .admin-tag {
            background: #ff0066;
            color: white;
            padding: 5px 10px;
            border-radius: 8px;
            font-size: 0.9em;
        }
        .logout-button {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 20px;
            background: #333;
            color: white;
            border-radius: 6px;
            text-decoration: none;
        }
        .logout-button:hover {
            background: #555;
        }
    </style>
</head>
<body>

<div class="profiel-box">
    <h1>👋 Hallo, <?= $naam ?>!</h1>

    <?php if ($is_admin): ?>
        <p class="admin-tag">Je bent een admin! 🛡️</p>
    <?php else: ?>
        <p>Welkom terug op je profielpagina 😎</p>
    <?php endif; ?>

    <a href="../login/logout.php" class="logout-button">Uitloggen</a>
</div>

</body>
</html>
