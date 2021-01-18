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
    array_push($errors, 'Nebylo zadáno id');
} else {

    if (isset($_POST['edit'])) {
        if (empty(trim($_POST['name']))) {
            array_push($errors, 'Nebylo zadáno křestní jméno');
        }
        if (empty(trim($_POST['lastname']))) {
            array_push($errors, 'Nebylo zadánp příjmení');
        }
        if (empty(trim($_POST['password']))) {
            array_push($errors, 'Nebylo zadáno heslo');
        }
    
        if (empty($errors)) {
            // volani funkce login tridy Authentication
            if (Authentication::getInstance()->updateUser($_POST['name'], $_POST['password'], $_POST['lastname'], $_GET['id'])) {
                array_push($success, "Operace úspěšná");
            } else {
                array_push($errors, 'Operace selhala');
            }
        }
    } 

    $userToEdit = Authentication::getInstance()->selectUser($_GET['id']);
}



?>



<!DOCTYPE html>
<html lang="cs">
<head>
    <title>Titulek</title>
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
            <h2>Změna údajů</h2>
            <form method="post" action="edit.php?id=<?= $_GET['id'] ?>">
                <label>Jméno:
                    <input type="text" id="name" name="name" value="<?= $userToEdit['name'] ?>" required>
                </label><br />
                <label>Příjmení:
                    <input type="text"  id="lastname" name="lastname" value="<?= $userToEdit['lastname'] ?>" required>
                </label><br />
                <label>Heslo:
                    <input type="password"  id="password" name="password" required>
                </label><br />
                <input type="submit" value="Registrovat" name="edit" />
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
