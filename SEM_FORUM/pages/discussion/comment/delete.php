<?php
$discussion = new Discussion();

$owner = $discussion->getOwnerOfComment($_GET['comment']);
if (Authentication::getInstance()->getIdentity()['id'] == $owner['users_id'] || Authentication::getInstance()->isAdmin()) {

    if ($discussion->deleteComment($_GET['comment'], $_GET['thread'])) {
        $_SESSION['message'] = 'Komentář byl smazán';
    }

    exit(header('Location: ' . BASE_URL . '?page=discussion&category=' . $_GET['category'] . '&thread=' . $_GET['thread']));
} else {

    exit(header('Location: ' . BASE_URL));
}
