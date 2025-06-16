<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$ingelogd = isset($_SESSION['gebruikersnaam']);
$naam = $ingelogd ? htmlspecialchars($_SESSION['gebruikersnaam']) : '';
?>
<header>
    <nav class="nav">
        <div class="logo">
            <a href="../index.php"><img src="../fotos/logo.png" alt="Logo"></a>
        </div>

        <div class="hamburger" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <div class="links">
            <a href="../extra-pagina's/ons-aanbod.php">Ons Aanbod</a>
            <a href="../extra-pagina's/familie.php">Familie Vakanties</a>
            <a href="../extra-pagina's/all-inclusive.php">All Inclusive</a>
            <a href="../extra-pagina's/vragen-en-contact.php">Vragen & Contact</a>
            <?php if ($ingelogd): ?>
                <a href="../gebruiker-paginas/profiel.php">Profiel</a>
            <?php endif; ?>
        </div>

        <div class="login-links">
            <?php if ($ingelogd): ?>
                <span>Welkom, <?= $naam ?></span>
                <a href="../login/logout.php">Uitloggen</a>
            <?php else: ?>
                <a href="../login/login.php">Login</a>
                <a href="../login/registreer.php">Registreer</a>
            <?php endif; ?>
        </div>
    </nav>
</header>

<script>
    function toggleMenu() {
        document.querySelector('.links').classList.toggle('active');
        document.querySelector('.login-links').classList.toggle('active');
    }
</script>