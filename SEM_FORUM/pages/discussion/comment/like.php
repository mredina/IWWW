<?php
$discussion = new Discussion();

$promenna = $discussion->selectLike(Authentication::getInstance()->getIdentity()['id'],$_GET['comment']);

if ($promenna['libiSe'] == 1){
    if ($discussion->insertDisLike($_GET['comment'], Authentication::getInstance()->getIdentity()['id'])){
    $_SESSION['message'] = 'Tento komentář se vám už nelíbí!';
}
}
elseif ($promenna['libiSe'] == 2){
    if ($discussion->updateLike($_GET['comment'], Authentication::getInstance()->getIdentity()['id'])) {
        $_SESSION['message'] = 'Tento komentář se vám líbí';
    }
}
else{
    if ($discussion->insertLike($_GET['comment'], Authentication::getInstance()->getIdentity()['id'])) {
        $_SESSION['message'] = 'Tento komentář se vám líbí';
    }

}

    exit(header('Location: ' . BASE_URL . '?page=discussion&category=' . $_GET['category'] . '&thread=' . $_GET['thread']));

