<?php

require_once 'config/config.php';
require_once 'classes/authentication.php';
require_once 'classes/connection.php';


$errors = array();
$success = array();

if(!isset($_SESSION['identity'])){
    array_push($errors, 'Nikdo neni přihlašený');
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
            if (Authentication::getInstance()->updateUser($_POST['name'], $_POST['password'], $_POST['lastname'], $_SESSION['identity']['id'])) {
                array_push($success, "Operace úspěšná"); //exit(header('Location: ' . BASE_URL));
            } else {
                array_push($errors, 'Operace selhala');
            }
        }
    } 

    $userToEdit = $_SESSION['identity'];
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
        <?php if(isset($_SESSION['identity'])): ?>
            <h2>Změna mých údajů</h2>
            <form method="post" action="editme.php">
                <label>Jméno:
                    <input type="text" id="name" name="name" value="<?= $userToEdit['name'] ?>" required>
                </label><br />
                <label>Příjmení:
                    <input type="text"  id="lastname" name="lastname" value="<?= $userToEdit['lastname'] ?>" required>
                </label><br />
                <label>Heslo:
                    <input type="password"  id="password" name="password" required>
                </label><br />
                <input type="submit" value="Editovat" name="edit" />
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
