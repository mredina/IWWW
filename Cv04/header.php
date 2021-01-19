<header>
    <nav>
        <ul>
            <li><a href="index.php">Domů</a></li>
            <?php if(!isset($_SESSION['identity'])): ?>
                <li><a href="login.php">Přihlášení</a></li>
            <?php else: ?>
                <li><a href="editme.php">Úprava profilu</a></li>
                <li><a href="profile.php">Detail profilu</a></li>
                <?php if(Authentication::getInstance()->isAdmin()): ?>
                    <li><a href="table.php">Uživatelé</a></li>
                <?php endif; ?> 

                <li><a href="logout.php">Odhlášení</a></li>   
            <?php endif; ?>
            <?php if( !isset($_SESSION['identity']) || Authentication::getInstance()->isAdmin()): ?>
                <li><a href="registration.php">Registrace</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>