<?php

$discussion = new Discussion();
$success = '';
$errors = array();
if (isset($_SESSION['message'])) {
    $success = $_SESSION['message'];
    unset($_SESSION['message']);
} else {
    $success = '';
}
echo '<span><a href="' . BASE_URL . '?page=discussion" class="back">Zpět na výpis kategorií</a></span>';

$category = $discussion->getCategoryById($_GET['category']);
echo '<h2 class="title">' . $category['name'] . '</h2>';


$errors = array();

if (isset($_POST['submit'])) {
    if (empty(trim($_POST['thread']))) {
        array_push($errors, 'Nebyl zadán název');
    }
    if (empty($errors)) {
        if ($discussion->insertThread($_POST['thread'], $_GET['category'])) {
            $success = 'Vlákno bylo úspěšně vytvořeno';
        } else {
            array_push($errors, 'Tento název vlákna je již používán');
        }
    }
}
// vypsani vsech vlaken do tabulky
$threads = $discussion->getAllThreads($_GET['category']);
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo '<span class="error-msg">' . $error . '</span>';
    }
    $errors = array();
}

if (!empty($threads)) {

    echo '
    <table class="threads">
        <tr>
            <th>Název</th>
            <th>Autor</th>
            <th>Vytvořeno</th>
            <th>Poslední komentář</th>
            <th>Počet komentářů</th>
             <th>Uzavřít vlákno</th>
                     
        </tr>';
    foreach ($threads as $thread) {
        $prom = $discussion->getOwnerOfThread($thread['id']);


        if (Authentication::getInstance()->isAdmin()) {
                 if ($thread['locked'] == 0){
                     echo '
            <tr>
                <td><a href="' . CURRENT_URL . '&thread=' . $thread['id'] . '">' . $thread['name'] . '</a></td>
                <td>' . $thread['users_name'] . ' ' . $thread['users_surname'] . '</td>
                <td>' . $thread['created'] . '</td>
                <td>' . $thread['last_comment'] . '<br>' . $thread['last_comment_date'] . '</td>
                <td>' . $thread['number_of_comments'] . '</td>
                <td><a href="' . CURRENT_URL . '&thread=' . $thread['id'] . '&action=uzavrit">Uzavřít</a></td> 
                 <td><a href="' . CURRENT_URL . '&thread=' . $thread['id'] . '&action=deleteT">Smazat</a></td>
            </tr>';
                 }
                 else
                 {
                     echo '
            <tr>
                <td><a href="' . CURRENT_URL . '&thread=' . $thread['id'] . '">' . $thread['name'] . '</a></td>
                <td>' . $thread['users_name'] . ' ' . $thread['users_surname'] . '</td>
                <td>' . $thread['created'] . '</td>
                <td>' . $thread['last_comment'] . '<br>' . $thread['last_comment_date'] . '</td>
                <td>' . $thread['number_of_comments'] . '</td>
                <td><a href="' . CURRENT_URL . '&thread=' . $thread['id'] . '&action=uzavrit">Odemknout</a></td>
                         <td><a href="' . CURRENT_URL . '&thread=' . $thread['id'] . '&action=deleteT">Smazat</a></td>
            </tr>';

                 }
        }
        elseif ($prom[0] == Authentication::getInstance()->getIdentity()['id']){
            if ($thread['locked'] == 0){
            echo '
            <tr>
                <td><a href="' . CURRENT_URL . '&thread=' . $thread['id'] . '">' . $thread['name'] . '</a></td>
                <td>' . $thread['users_name'] . ' ' . $thread['users_surname'] . '</td>
                <td>' . $thread['created'] . '</td>
                <td>' . $thread['last_comment'] . '<br>' . $thread['last_comment_date'] . '</td>
                <td>' . $thread['number_of_comments'] . '</td>
                <td><a href="' . CURRENT_URL . '&thread=' . $thread['id'] . '&action=uzavrit">Uzavřít</a></td>
            </tr>';
            }
            else
            {
                echo '
            <tr>
                <td><a href="' . CURRENT_URL . '&thread=' . $thread['id'] . '">' . $thread['name'] . '</a></td>
                <td>' . $thread['users_name'] . ' ' . $thread['users_surname'] . '</td>
                <td>' . $thread['created'] . '</td>
                <td>' . $thread['last_comment'] . '<br>' . $thread['last_comment_date'] . '</td>
                <td>' . $thread['number_of_comments'] . '</td>
                <td><a href="' . CURRENT_URL . '&thread=' . $thread['id'] . '&action=uzavrit">Odemknout</a></td>
            </tr>';

            }

        }
        else{
            echo '
            <tr>
                <td><a href="' . CURRENT_URL . '&thread=' . $thread['id'] . '">' . $thread['name'] . '</a></td>
                <td>' . $thread['users_name'] . ' ' . $thread['users_surname'] . '</td>
                <td>' . $thread['created'] . '</td>
                <td>' . $thread['last_comment'] . '<br>' . $thread['last_comment_date'] . '</td>
                <td>' . $thread['number_of_comments'] . '</td>
            </tr>';

        }
    }
        echo '</table>';

} else {
    echo '<h3>Tato kategorie je zatím prázdná</h3>';
}
if (!empty($success)) {
    echo '<span class="success-msg">' . $success . '</span>';
    $success = '';
}
?>
<div class="form">
    <div class="form-title">
        <h2>Nové vlákno</h2>
    </div>
    <div class="form-body">
        <form method="post">
            <label>Název vlákna:</label>
            <br>
            <input type="text" name="thread" placeholder="Název vlákna">
            <br>
            <input type="submit" name="submit" value="Vytvořit">
        </form>
    </div>
</div>
<?php

?>