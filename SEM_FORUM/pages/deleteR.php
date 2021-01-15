<?php
$discussion = new Discussion();

$prom = $_GET['comment'];

if ($discussion->deleteReason($prom['id'])) {
    $_SESSION['message'] = 'Nahlášení bylo smazáno!';
}
else{

    $_SESSION['message'] = $_GET['comment'];
}

exit(header('Location: ' . BASE_URL . '?page=nahlasene'));

