<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$ingelogd = isset($_SESSION['gebruikersnaam']);
$naam = $ingelogd ? htmlspecialchars($_SESSION['gebruikersnaam']) : '';
?>

<header>
    <nav class="nav">
        <div class="links">
            <div class="logo">
                <a href="../admin/admin.php"><img src="../fotos/logo.png" alt="Logo"></a>
            </div>
            <a href="../admin/vlucht-beheer.php">Vlucht beheer</a>
            <a href="../admin/account-beheer.php">Account beheer</a>
            <a href="../admin/contact.php">Contact</a>
            <a href="../admin/reviews-validator.php">Review beheer</a>
        </div>
        <div class="login-links">
            <?php if ($ingelogd): ?>
                <span style="margin-right: 15px;">Welkom, <?= $naam ?></span>
            <?php endif; ?>
            <a href="../login/logout.php">Uitloggen</a>
        </div>
    </nav>
</header>
