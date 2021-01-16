<?php
$discussion = new Discussion();

if ($discussion->deleteCategory($_GET['category'])) {
    $_SESSION['message'] = 'Kategorie byla smazána !';
}

exit(header('Location: ' . BASE_URL . '?page=discussion'));

