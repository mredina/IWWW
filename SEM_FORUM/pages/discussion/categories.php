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



if (isset($_POST['submit'])) {
    if (empty($_POST['category'])) {
        array_push($errors, 'Nebyl zadán název');
    }
    if (empty($errors)) {
        if ($discussion->insertCategory($_POST['category'])) {
            $success = 'Kategorie byla úspěšně vytvořena';
        } else {
            array_push($errors, 'Tento název kategorie je již používán');
        }
    }
}

$categories = $discussion->getAllCategories();
echo '<h2 class="title">Kategorie fóra</h2>';
echo '<ul class="categories">';
foreach ($categories as $category) {
    if (Authentication::getInstance()->isAdmin()) {
        echo '
    <table class="threads">
        <tr>
            <th>Název</th>
            <th>Smazat</th>
        </tr>';
        echo '
            <tr>
            
                <td><a href="' . CURRENT_URL . '&category=' . $category['id'] . '">' . $category['name'] . '</a></td>
               <td><a href="' . CURRENT_URL . '&category=' . $category['id'] . '&action=deleteK">Smazat</a></td>
          
            </tr>';

        echo '</table>';
    } else {
        echo '
    <table class="threads">
        <tr>
            <th>Název</th>
        </tr>';
        echo '
            <tr>
                <td><a href="' . CURRENT_URL . '&category=' . $category['id'] . '">' . $category['name'] . '</a></td>    
            </tr>';

        echo '</table>';
    }
}
echo '</ul>';


if (Authentication::getInstance()->isAdmin()) {
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
            <h2>Přidání kategorie</h2>
        </div>
        <div class="form-body">
            <form method="post">
                <label>Název kategorie:</label>
                <br>
                <input type="text" name="category" placeholder="Název kategorie">
                <br>
                <input type="submit" name="submit" value="Vytvořit">
            </form>
        </div>
    </div>
<?php


}
