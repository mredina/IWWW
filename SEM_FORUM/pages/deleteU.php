<?php
$discussion = new Discussion();

    if ($discussion->deleteUser($_GET['user'])) {
        $_SESSION['message'] = 'Uživatel byl úspěšně smazán!';
    }
exit(header('Location: ' . BASE_URL . '?page=uzivatele'));

