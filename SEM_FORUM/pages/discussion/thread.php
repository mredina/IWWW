<?php
echo '<span><a href="' . BASE_URL . '?page=discussion&category=' . $_GET['category'] . '" class="back">Zpět na výpis vláken</a></span>';
$discussion = new Discussion();
$thread = $discussion->getThreadById($_GET['thread']);
echo '<h2 class="title">' . $thread['name'] . '</h2>';

if (isset($_SESSION['message'])) {
    $success = $_SESSION['message'];
    unset($_SESSION['message']);
} else {
    $success = '';
}
$errors = array();

if (isset($_POST['submit'])) {
    if (empty(trim($_POST['comment']))) {
        array_push($errors, 'Nelze vložit prázdný komentář');
    }
    if (empty($errors)) {
        $prom = $discussion->getAllThreadById($_GET['thread']);
        if ($prom['locked'] == 0){
        if ($discussion->insertComment($_POST['comment'], $_GET['thread'])) {
            $success = 'Komentář byl přidán';
        } else {
            array_push($errors, 'Při vkládání komentáře nastala chyba');
        }
        }
        else{
            array_push($errors, 'Vlákno je zamčené, nelze přidávat komentáře');

        }
    }
}

$comments = $discussion->getAllComments($_GET['thread']);

foreach ($comments as $comment) {
$promenna =  $discussion->selectLike(Authentication::getInstance()->getIdentity()['id'],$comment['id']);
   if ($promenna[0] == 2 || $promenna[0] == 0){
       echo '
    <div class="comment">
        <table>
            <tr>
                <td><b>Autor:<a href="' . CURRENT_URL . '&comment=' . $comment['id'] . '&action=zobrazit"></b> ' . $comment['name'] . ' ' . $comment['surname'] . '</a> </td>
                <td><b>Zveřejněno:</b> ' . $comment['created'] . '</td>
                 <td><b>Počet liků:</b></td>
                
            </tr>
            <tr>
             <td colspan="2" class="comment-text">' . htmlspecialchars($comment['text']) . '</td>
                <td colspan="2" class="comment-text">' . htmlspecialchars($comment['pocetLike']) . '</td>
                <td ><a href="' . CURRENT_URL . '&comment=' . $comment['id'] . '&action=nahlasit">Nahlásit</a></td>
                   <td><a href="' . CURRENT_URL . '&comment=' . $comment['id'] . '&action=like">Like</a></td>
            </tr>';
   }
   else{

       echo '
    <div class="comment">
        <table>
            <tr>
                <td><b>Autor:</b> ' . $comment['name'] . ' ' . $comment['surname'] . ' </td>
                <td><b>Zveřejněno:</b> ' . $comment['created'] . '</td>
                 <td><b>Počet liků:</b></td>
                
            </tr>
            <tr>
             <td colspan="2" class="comment-text">' . htmlspecialchars($comment['text']) . '</td>
                <td colspan="2" class="comment-text">' . htmlspecialchars($comment['pocetLike']) . '</td>
                <td ><a href="' . CURRENT_URL . '&comment=' . $comment['id'] . '&action=nahlasit">Nahlásit</a></td>
                   <td><a href="' . CURRENT_URL . '&comment=' . $comment['id'] . '&action=like">disLike</a></td>
            </tr>';
   }
    if (Authentication::getInstance()->getIdentity()['id'] == $comment['users_id']) {
        echo '
        <tr>
            <td><a href="' . CURRENT_URL . '&comment=' . $comment['id'] . '&action=delete">Smazat</a></td>
            <td><a href="' . CURRENT_URL . '&comment=' . $comment['id'] . '&action=update">Upravit</a></td>

	
        </tr>';
    } else if (Authentication::getInstance()->isAdmin()) {
        echo '
        <tr>
            <td colspan="2"><a href="' . CURRENT_URL . '&comment=' . $comment['id'] . '&action=delete">Smazat</a></td>

        </tr>';
    }
    echo '
        </table>
    </div>';
}
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo '<span class="error-msg">' . $error . '</span>';
    }
    $errors = array();
}
if (!empty($success)) {
    echo '<span class="success-msg">' . $success . '</span>';
    $success = '';
}
?>
<div class="form">
    <div class="form-title">
        <h2>Nový komentář</h2>
    </div>
    <div class="form-body">
        <form method="post">
            <textarea name="comment"></textarea>
            <br>
            <input type="submit" name="submit" value="Vytvořit">
        </form>
    </div>
</div>