<?php
$comment = new Comment();

$owner = $comment->getOwnerOfComment($_GET['comment']);
if (Authentication::getInstance()->getIdentity()['id'] == $owner['userId'] || Authentication::getInstance()->isAdmin()) {

    if ($comment->deleteComment($_GET['comment'], $_GET['thread'])) {
        $_SESSION['message'] = 'Komentář byl smazán';
    }

    exit(header('Location: ' . BASE_URL . '?page=discussion/discussion&category=' . $_GET['category'] . '&thread=' . $_GET['thread']));
} else {

    exit(header('Location: ' . BASE_URL));
}
