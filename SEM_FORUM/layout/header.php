<header>
    <h1>Linux/Forum<h1>
    <nav>
        <a href="<?= BASE_URL ?>">Home</a>

        <?php if (Authentication::getInstance()->hasIdentity() && !Authentication::getInstance()->isAdmin()) : ?>
            <a href="<?= BASE_URL . "?page=discussion/discussion" ?>">Diskuse</a>
            <a href="<?= BASE_URL . "?page=profile" ?>">Profil</a>
            <a href="<?= BASE_URL . "?page=logout" ?>">Logout</a>
        <?php elseif(Authentication::getInstance()->isAdmin() && Authentication::getInstance()->hasIdentity()) : ?>
            <a href="<?= BASE_URL . "?page=discussion/discussion" ?>">Diskuse</a>
            <a href="<?= BASE_URL . "?page=profile" ?>">Profil</a>
            <a href="<?= BASE_URL . "?page=logout" ?>">Logout</a>
            <a href="<?= BASE_URL . "?page=admin/user" ?>">Uživatelé</a>
            <a href="<?= BASE_URL . "?page=admin/report" ?>">Nahlášené komentáře</a>
        <?php else : ?>
            <a href="<?= BASE_URL . "?page=login" ?>">Login</a>
            <a href="<?= BASE_URL . "?page=registration" ?>">Registrace</a>
        <?php endif; ?>
    </nav>
    <!-- ikonka pro mobilni hamburger menu, na kliknuti zavola funkci showMenu viz js/app.js -->
    <a href="javascript:void(0);" class="navbar-icon" onclick="showMenu()">
        <i class="fa fa-bars"></i>
    </a>
</header>
