<?php
$discussion = new Discussion();

if (true) {
    $errors = array();
    if (isset($_POST['submit'])) {
        if (empty(trim($_POST['comment']))) {
            array_push($errors, 'Důvod je prázdný');
        }
        if (empty($errors)) {
            $prom = $discussion->getCommentById($_GET['comment']);
            if ($discussion->insertReason($_GET['comment'], $_POST['comment'],$prom['text'],$_GET['category'],$_GET['thread'])) {
                $_SESSION['message'] = 'Komentář byl nahlášen';
                exit(header('Location: ' . BASE_URL . '?page=discussion&category=' . $_GET['category'] . '&thread=' . $_GET['thread']));
            } else {
                array_push($errors, 'Při nahlašování nastala chyba');
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
            <h2>Nahlásit komentář</h2>
        </div>
        <div class="form-body">
            <form method="post">

                <textarea name="comment"></textarea>
                <br>
                <input type="submit" name="submit" value="Nahlásit">
            </form>
        </div>
    </div>
<?php
} else {

    exit(header('Location: ' . BASE_URL));
}
