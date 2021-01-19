<?php

require_once 'config/config.php';
require_once 'classes/authentication.php';
require_once 'classes/connection.php';

if (Authentication::getInstance()->hasIdentity()) {
    exit(header('Location: ' . BASE_URL));
}

$errors = array();
$success = array();

if (isset($_POST['login_user'])) {
    if (empty(trim($_POST['email']))) {
        array_push($errors, 'Nebylo zadáno jméno');
    }
    if (empty(trim($_POST['password']))) {
        array_push($errors, 'Nebylo zadáno heslo');
    }
    if (empty($errors)) {
        // volani funkce login tridy Authentication
        if (Authentication::getInstance()->login($_POST['email'], $_POST['password'])) {
            array_push($success, "Uspěšně přihlášen");
        } else {
            array_push($errors, 'Zadané špatné jméno nebo heslo');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Přihlašení</title>
</head>
<body>
<?php include 'header.php'?>

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

<?php if(!isset($_SESSION['identity'])): ?>
    <div class="obsah">
        <form method="post" action="login.php">
            <h2>Login</h2>
            <label for="email">E-mail:
                <input type="email"  id="email" name="email"></label>
            <label for="password">Heslo:
                <input type="password" id="password" name="password"></label>
            <button type="submit" class="btn" name="login_user">Odeslat</button>
        </form>
    </div>
<?php endif; ?>
</body>
