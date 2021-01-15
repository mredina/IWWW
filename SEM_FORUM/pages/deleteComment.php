<?php
$discussion = new Discussion();


$promenna = $discussion->getAllCommentById($_GET['comment']);
    if ($discussion->deleteComment($_GET['comment'], $promenna['threads_id'])) {
        $_SESSION['message'] = "Komentář byl smazán!";
    }

exit(header('Location: ' . BASE_URL . '?page=nahlasene'));

