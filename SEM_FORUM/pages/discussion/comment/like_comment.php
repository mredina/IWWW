<?php
$comment = new Comment();

$promenna = $comment->selectLike(Authentication::getInstance()->getIdentity()['id'],$_GET['comment']);

if ($promenna['likeState'] == 1){
    if ($comment->insertDisLike($_GET['comment'], Authentication::getInstance()->getIdentity()['id'])){
    $_SESSION['message'] = 'Tento komentář se vám už nelíbí!';
}
}
elseif ($promenna['likeState'] == 2){
    if ($comment->updateLike($_GET['comment'], Authentication::getInstance()->getIdentity()['id'])) {
        $_SESSION['message'] = 'Tento komentář se vám líbí';
    }
}
else{
    if ($comment->insertLike($_GET['comment'], Authentication::getInstance()->getIdentity()['id'])) {
        $_SESSION['message'] = 'Tento komentář se vám líbí';
    }

}

    exit(header('Location: ' . BASE_URL . '?page=discussion/discussion&category=' . $_GET['category'] . '&thread=' . $_GET['thread']));

