<?php
$discussion = new Discussion();

$owner = $discussion->getOwnerOfComment($_GET['comment']);
if (Authentication::getInstance()->getIdentity()['id'] == $owner['users_id']) {
    $errors = array();
    if (isset($_POST['submit'])) {
        if (empty(trim($_POST['comment']))) {
            array_push($errors, 'Komentář je prázdný');
        }
        if (empty($errors)) {
          
            if ($discussion->updateComment($_GET['comment'], $_POST['comment'])) {
                $_SESSION['message'] = 'Komentář byl upraven';
                exit(header('Location: ' . BASE_URL . '?page=discussion&category=' . $_GET['category'] . '&thread=' . $_GET['thread']));
            } else {
                array_push($errors, 'Při ukládání nastala chyba');
            }
        }
    }

    $comment = $discussion->getCommentById($_GET['comment']);
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo '<span class="error-msg">' . $error . '</span>';
        }
        $errors = array();
    }
?>
    <div class="form">
        <div class="form-title">
            <h2>Upravit komentář</h2>
        </div>
        <div class="form-body">
            <form method="post">
                <!--  funkce htmlspecialchars chrani proti XSS utoku (zmeni pripadne html tagy v textu na text) -->
                <textarea name="comment"><?= htmlspecialchars($comment['text']) ?></textarea>
                <br>
                <input type="submit" name="submit" value="Uložit">
            </form>
        </div>
    </div>
<?php
} else {


    exit(header('Location: ' . BASE_URL));
    
}
