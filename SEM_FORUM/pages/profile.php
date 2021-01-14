<?php
// pokud neni uzivatel prihlasen presmeruje na prihlaseni
if (!Authentication::getInstance()->hasIdentity()) {
    exit(header('Location: ' . BASE_URL . '?page=login'));
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
    if (empty($errors)) {

            if (Authentication::getInstance()->updateUser($_POST['login'], $_POST['password'], Authentication::getInstance()->getIdentity()['id'])) {

                $success = 'Změna byla úspěšná';
            }
            else {
                array_push($errors, 'Tento login už je obsazený!');
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

echo '<h3 class="success-msg">' . $success . '</h3>';
// vypsani jmena a prijmeni aktualne prihlaseneho uzivatele
?>

<div class="card">

    <div class="card-title">
        <center><?php    echo '<h2> Vaše jméno: ' . Authentication::getInstance()->getIdentity()['name'] . '
<br> Vaše příjmení: ' . Authentication::getInstance()->getIdentity()['surname'] . ' <br> Váš nickname: ' . Authentication::getInstance()->getIdentity()['username'].' </h2>';?></center>
      <br> <h3>Zde můžete provést změnu některých údajů. </h3>
    </div>
    <div class="card-body">
        <form method="post">
            <div class="form-group">
                <label>Přihlašovací jméno:</label>
                <input type="text" name="login" placeholder="Login">
            </div>
            <div class="form-group">
                <label>Heslo:</label>
                <input type="password" name="password" placeholder="Heslo">
            </div>
            <div class="form-group">
                <label>Heslo znovu:</label>
                <input type="password" name="password_again" placeholder="Heslo znovu">
            </div>

            <div class="form-submit">
                <input type="submit" name="submit" value="Změnit">
            </div>
        </form>
    </div>
</div>