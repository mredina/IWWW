<?php

require_once 'config/config.php';
require_once 'classes/authentication.php';
require_once 'classes/connection.php';

$errors = array();
$success = array();

if (isset($_POST['registration'])) {
    if (empty(trim($_POST['email']))) {
        array_push($errors, 'Nebylo zadán email');
    }
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
        if (Authentication::getInstance()->register($_POST['email'], $_POST['password'], $_POST['name'], $_POST['lastname'])) {
            array_push($success, "Uspěšně registrován"); //exit(header('Location: ' . BASE_URL));
        } else {
            array_push($errors, 'Registrace selhala');
        }
    }
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
        <h2>Registrace</h2>
        <form method="post" action="registration.php">
            <label>Email:
                <input type="email"  id="email" name="email" required>
            </label><br />
            <label>Jméno:
                <input type="text"  id="name" name="name" required>
            </label><br />
            <label>Příjmení:
                <input type="text"  id="lastname" name="lastname" required>
            </label><br />
            <label>Heslo:
                <input type="password"  id="password" name="password" required>
            </label><br />
            <input type="submit" value="Registrovat" name="registration" />
        </form>
    </div>
</body>
</html>
