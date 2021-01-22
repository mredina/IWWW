<?php
// overeni zda-li neni uzivatel prihlasen, pokud je tak presmeruje na hlavni stranku
if (Authentication::getInstance()->hasIdentity()) {
    exit(header('Location: ' . BASE_URL));
}

$errors = array();
$success = '';

if (isset($_POST['login'])) {
    if (empty(trim($_POST['login']))) {
        array_push($errors, 'Nebylo zadáno přihlašovací jméno');
    }
    if (empty(trim($_POST['password']))) {
        array_push($errors, 'Nebylo zadáno heslo');
    }
    if ($_POST['password'] != $_POST['password_again']) {
        array_push($errors, 'Zadaná hesla se neshodují');
    }
    if (empty(trim($_POST['name']))) {
        array_push($errors, 'Nebylo zadáno jméno');
    }
    if (empty(trim($_POST['surname']))) {
        array_push($errors, 'Nebylo zadáno příjmení');
    }
    if (empty($errors)) {

        if (Authentication::getInstance()->register($_POST['login'], $_POST['password'], $_POST['name'], $_POST['surname'])) {
            $success = 'Registrace byla dokončena';
        } else {
            array_push($errors, 'Tento login již někdo používá');
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

if (empty($success)) {
?>
    <div class="card">
        <div class="card-title">
            <h2>Registrace</h2>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="form-group">
                    <label>Přihlašovací jméno:</label>
                    <input type="email" name="login" placeholder="Login">
                </div>
                <div class="form-group">
                    <label>Heslo:</label>
                    <input type="password" name="password" placeholder="Heslo">
                </div>
                <div class="form-group">
                    <label>Heslo znovu:</label>
                    <input type="password" name="password_again" placeholder="Heslo znovu">
                </div>
                <div class="form-group">
                    <label>Jméno:</label>
                    <input type="text" name="name" placeholder="Jméno">
                </div>
                <div class="form-group">
                    <label>Příjmení:</label>
                    <input type="text" name="surname" placeholder="Příjmení">
                </div>
                <div class="form-submit">
                    <input type="submit" name="submit" value="Registrovat">
                </div>
            </form>
        </div>
    </div>
<?php

} else {
    echo '<h3 class="success-msg">' . $success . '</h3>';
    echo '<h3>Nyní se můžete <a href="' . BASE_URL . '?page=login">přihlásit</a>.</h3>';
}
