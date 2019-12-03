<nav class="navbar navbar-dark sticky-top bg-custom-nav navbar-expand-sm">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="https://s3.eu-central-1.amazonaws.com/bootstrapbaymisc/blog/24_days_bootstrap/logo_white.png" width="30" height="30" alt="logo">
            Mismatch
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-list-7" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbar-list-7">
            <ul class="navbar-nav">
                <li <?php echo basename($_SERVER['PHP_SELF']) == "index.php" ? "class='nav-item active'" : "class='nav-item'" ?>>
                    <a class="nav-link" href="index.php">Inicio</a>
                </li>
                <li <?php echo basename($_SERVER['PHP_SELF']) == "profiles.php" || basename($_SERVER['PHP_SELF']) == "profile.php" ? "class='nav-item active'" : "class='nav-item'" ?>>
                    <a class="nav-link" href="profiles.php">Perfiles</a>
                </li>
                <li <?php echo basename($_SERVER['PHP_SELF']) == "edit.php" ? "class='nav-item active'" : "class='nav-item'" ?>>
                    <a class="nav-link" href="edit.php">Editar perfil</a>
                </li>
                <li <?php echo basename($_SERVER['PHP_SELF']) == "questions.php" ? "class='nav-item active'" : "class='nav-item'" ?>>
                    <a class="nav-link" href="questions.php">Cuestionario</a>
                </li>
                <li <?php echo basename($_SERVER['PHP_SELF']) == "mismatch.php" ? "class='nav-item active'" : "class='nav-item'" ?>>
                    <a class="nav-link" href="mismatch.php">Emparejamiento</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li <?php echo basename($_SERVER['PHP_SELF']) == "logout.php" ? "class='nav-item active'" : "class='nav-item'" ?>>
                    <a class="nav-link" href="logout.php"><span class="fas fa-sign-in-alt"></span> Cerrar sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>