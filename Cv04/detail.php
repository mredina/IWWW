<?php

require_once 'config/config.php';
require_once 'classes/authentication.php';
require_once 'classes/connection.php';

$errors = array();
$success = array();

if(!(Authentication::isAdmin())){
    array_push($errors, 'Přihlášený uživatel neni admin!');
}

if(!isset($_GET['id'])){
    array_push($errors, 'Id uživatele nebylo zadáno');
} else {
    $userToEdit = Authentication::getInstance()->selectUser($_GET['id']);
}

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <title>Změna údajů</title>
</head>
<body>
    <?php include 'header.php'?>
    <div class="obsah">
    <?php
        if (!empty($errors)) {
            echo '<div class="card">';
            foreach ($errors as $error) {
                echo '<span class="error-msg">' . $error . '</span>';
            }
            echo '</div>';
            $errors = array();
        }

        if (!empty($success)) {
            echo '<div class="card">';
            foreach ($success as $suc) {
                echo '<span class="error-msg">' . $suc . '</span>';
            }
            echo '</div>';
            $success = array();
        }
        ?>
        <?php if(empty($errors)): ?>
            <h2>Moje údaje</h2>
            <form>
                <label>Email:
                    <input type="email" id="name" name="name" value="<?= $userToEdit['username'] ?>" disabled>
                </label><br />
                <label>Jméno:
                    <input type="text" id="name" name="name" value="<?= $userToEdit['name'] ?>" disabled>
                </label><br />
                <label>Příjmení:
                    <input type="text"  id="lastname" name="lastname" value="<?= $userToEdit['lastname'] ?>" disabled>
                </label><br />
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
