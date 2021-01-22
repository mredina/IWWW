<?php
$comment = new Comment();

    if ($comment->deleteComment($_GET['comment'])) {
        $_SESSION['message'] = "Komentář byl smazán!";
    }

exit(header('Location: ' . BASE_URL . '?page=admin/report'));

