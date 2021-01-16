<?php
$discussion = new Discussion();

$owner = $discussion->getOwnerOfThread($_GET['thread']);
if (Authentication::getInstance()->getIdentity()['id'] == $owner['users_id'] || Authentication::getInstance()->isAdmin()) {

    if ($discussion->deleteThread($_GET['thread'])) {
        $_SESSION['message'] = 'Vlákno bylo úspěšně smazáno';
    }

    exit(header('Location: ' . BASE_URL . '?page=discussion&category=' . $_GET['category']));

} else {

    exit(header('Location: ' . BASE_URL));
}