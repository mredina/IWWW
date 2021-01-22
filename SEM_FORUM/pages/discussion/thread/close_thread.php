<?php
$thread = new Thread();
$prom = $thread->getAllThreadById($_GET['thread']);

if ($prom['locked'] == 0) {
    if ($thread->updateThread($_GET['thread'])) {
        $_SESSION['message'] = 'Vlákno bylo uzavřeno';
        exit(header('Location: ' . BASE_URL . '?page=discussion/discussion&category=' . $_GET['category']));

    }
}
else {
    if ($thread->updateThreadUnlocked($_GET['thread'])) {
        $_SESSION['message'] = 'Vlákno bylo odemčeno';
        exit(header('Location: ' . BASE_URL . '?page=discussion/discussion&category=' . $_GET['category']));
    }
}