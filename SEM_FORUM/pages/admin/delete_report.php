<?php
$report = new ReportedComment();

if ($report->deleteReason($_GET['comment'])) {
    $_SESSION['message'] = 'Nahlášení bylo smazáno!';
}
else{

    $_SESSION['message'] = $_GET['comment'];
}

exit(header('Location: ' . BASE_URL . '?page=admin/report'));

