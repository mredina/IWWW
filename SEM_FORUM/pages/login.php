<?php

if (Authentication::getInstance()->hasIdentity()) {
    exit(header('Location: ' . BASE_URL));
}
$errors = array();
if (isset($_POST['login'])) {
    if (empty(trim($_POST['username']))) {
        array_push($errors, 'Nebylo zadáno jméno');
    }
    if (empty(trim($_POST['password']))) {
        array_push($errors, 'Nebylo zadáno heslo');
    }
    if (empty($errors)) {
        // volani funkce login tridy Authentication
        if (Authentication::getInstance()->login($_POST['username'], $_POST['password'])) {
            exit(header('Location: ' . BASE_URL));
        } else {
            array_push($errors, 'Zadané špatné jméno nebo heslo');
        }
    }
}
if (!empty($errors)) {
    echo '<div class="card">';
    foreach ($errors as $error) {
        echo '<span class="error-msg">' . $error . '</span>';
    }
    echo '</div>';
    $errors = array();
}
?>
<div class="card">
    <div class="card-title">
        <h2>Přihlášení</h2>
    </div>
    <div class="card-body">
        <form method="post">
            <div class="form-group">
                <label>Přihlašovací jméno:</label>
                <input type="text" name="username" placeholder="Login">
            </div>
            <div class="form-group">
                <label>Heslo:</label>
                <input type="password" name="password" placeholder="Heslo">
            </div>
            <div class="form-submit">
                <input type="submit" value="Login" name="login">
            </div>
            
        </form>
    </div>
</div>
