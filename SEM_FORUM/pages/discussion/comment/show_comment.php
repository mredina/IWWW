<h1>Komentáře uživatele</h1>

<?php


$comment = new Comment();
$id = $comment->getCommentById($_POST['comment']);
$comments = $comment->getAllCommentsByUser($_GET['id']);
$success = '';
$errors = array();
if (isset($_SESSION['message'])) {
    $success = $_SESSION['message'];
    unset($_SESSION['message']);
} else {
    $success = '';
}
if (!empty($success)) {
    echo '<span class="success-msg">' . $success . '</span>';
    $success = '';
}
if (!empty($comments)) {
    echo '
    <table class="threads">
        <tr>
            <th>ID</th>
            <th>Nick hlásícího</th>
            <th>Důvod</th>
             <th>Text komentáře</th>
            <th>Datum</th>
		<th class="nezobrazuj">Smazat komentář</th>
		<th class="nezobrazuj">Smazat hlášení</th>
		<th class="nezobrazuj">Zobrazit komentář</th>
        </tr>';
    foreach ($comments as $comment) {

        echo '
            <tr>
                <td>' . $comment['id'].'</td>
                <td>' . $comment['email'].'</td>
                <td>' . $comment['reason'] . '</td>
                <td>' . $comment['text'] . '</td>
                <td>' . $comment['datetime'] .'</td>
		 <td class="nezobrazuj"><a href="' . CURRENT_URL . '&comment=' . $comment['commentId'] . '&action=delete_comment">Smazat</a></td>
		  <td class="nezobrazuj"><a href="' . CURRENT_URL . '&comment=' . $comment['id'] . '&action=delete_report">Smazat</a></td>
		  <td class="nezobrazuj"><a href="' . BASE_URL.'?page=discussion/discussion&category='.$comment['threadId'].'&thread='.$comment['categoryId'].'">Zobrazit</a></td>
            </tr>';
    }
    echo '</table>';
} else {
    echo '<h3>Zatím zde nejsou žádné komentáře</h3>';
}
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'delete_report') {

        require './pages/admin/delete_report.php';


    }
    elseif ($_GET['action'] == 'delete_comment'){

        require 'delete_comment.php';
    }
}
?>