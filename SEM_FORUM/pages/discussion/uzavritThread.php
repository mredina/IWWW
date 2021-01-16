<?php
$discussion = new Discussion();
$prom = $discussion->getAllThreadById($_GET['thread']);

if ($prom['locked'] == 0) {
    if ($discussion->updateThread($_GET['thread'])) {
        $_SESSION['message'] = 'Vlákno bylo uzavřeno';
        exit(header('Location: ' . BASE_URL . '?page=discussion&category=' . $_GET['category']));

    }
}
else {
    if ($discussion->updateThreadUnlocked($_GET['thread'])) {
        $_SESSION['message'] = 'Vlákno bylo odemčeno';
        exit(header('Location: ' . BASE_URL . '?page=discussion&category=' . $_GET['category']));
    }
}



