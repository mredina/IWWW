<?php
$user = new User();

if ($user->deleteUser($_GET['user'])) {
    $_SESSION['message'] = 'Uživatel byl úspěšně smazán!';
}
exit(header('Location: ' . BASE_URL . '?page=admin/user'));

