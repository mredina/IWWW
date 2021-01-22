<?php
$thread = new Thread();

$owner = $thread->getOwnerOfThread($_GET['thread']);
if (Authentication::getInstance()->getIdentity()['id'] == $owner['userId'] || Authentication::getInstance()->isAdmin()) {

    if ($thread->deleteThread($_GET['thread'])) {
        $_SESSION['message'] = 'Vlákno bylo úspěšně smazáno';
    }

    exit(header('Location: ' . BASE_URL . '?page=discussion/discussion&category=' . $_GET['category']));

} else {

    exit(header('Location: ' . BASE_URL));
}