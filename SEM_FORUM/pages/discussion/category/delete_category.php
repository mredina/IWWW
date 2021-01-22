<?php
$category = new Category();

if ($category->deleteCategory($_GET['category'])) {
    $_SESSION['message'] = 'Kategorie byla smazána !';
}

exit(header('Location: ' . BASE_URL . '?page=discussion/discussion'));

