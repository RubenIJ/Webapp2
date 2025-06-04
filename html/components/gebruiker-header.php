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
                <a href="../index.php"><img src="../fotos/logo.png" alt="Logo"></a>
            </div>
            <a href="../extra-pagina's/ons-aanbod.php">Ons Aanbod</a>
            <a href="../extra-pagina's/last-minute.php">Last Minute</a>
            <a href="../extra-pagina's/vragen-en-contact.php">Vragen & Contact</a>

            <?php if ($ingelogd): ?>
                <a href="../booking/booking.php">Booking</a>
            <?php endif; ?>
        </div>

        <div class="login-links">
            <?php if ($ingelogd): ?>
                <span style="margin-right: 15px;">Welkom, <?= $naam ?></span>
                <a href="../login/logout.php">Uitloggen</a>
            <?php else: ?>
                <a href="../login/login.php">Login</a>
                <a href="../login/registreer.php">Registreer</a>
            <?php endif; ?>
        </div>
    </nav>
</header>
