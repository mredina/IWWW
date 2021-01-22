<h1>Správa uživatelů</h1>

<?php
$user = new User();
$users = $user->getAllUsers();
$success = '';
$errors = array();

if (isset($_SESSION['message'])) {
    $success = $_SESSION['message'];
    unset($_SESSION['message']);
} else {
    $success = '';
}

if (!empty($success)) {
    echo '<span class="success-msg">' . $success . '</span>';
    $success = '';
}

if (!empty($users)) {
    echo '
    <table class="threads">
        <tr>
            <th>ID</th>
            <th>E-mail</th>
            <th>Jméno</th>
            <th>Přijmení</th>
		<th>Smazat</th>
        </tr>';
    foreach ($users as $user) {
        echo '
            <tr>
                <td>' . $user['id'].'</td>
                <td>' . $user['email'].'</td>
                <td>' . $user['name'] . '</td>
                <td>' . $user['surname'] .'</td>
		 <td><a href="' . CURRENT_URL . '&user=' . $user['id'] . '&action=delete_user">Smazat</a></td>
            </tr>';
    }
    echo '</table>';
} else {
    echo '<h3>Nejsou zde žádní uživatelé</h3>';
}

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'delete_user') {

        require 'delete_user.php';


    }
}
?>
