<header>
    <h1>Linux/Unix forum</h1>
    <nav>
        <a href="<?= BASE_URL ?>">Home</a>
        <?php if (Authentication::getInstance()->hasIdentity()) : ?>
            <a href="<?= BASE_URL . "?page=discussion" ?>">Diskuse</a>
            <a href="<?= BASE_URL . "?page=profile" ?>">Profil</a>
            <a href="<?= BASE_URL . "?page=logout" ?>">Logout</a>
        <?php else : ?>
            <a href="<?= BASE_URL . "?page=login" ?>">Login</a>
            <a href="<?= BASE_URL . "?page=registration" ?>">Registrace</a>
        <?php endif; ?>
    </nav>
    <a href="javascript:void(0);" class="navbar-icon" onclick="showMenu()">
        <i class="fa fa-bars"></i>
    </a>
</header>
<?php
