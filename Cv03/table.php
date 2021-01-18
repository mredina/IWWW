<?php

require_once 'config/config.php';
require_once 'classes/authentication.php';
require_once 'classes/connection.php';

$errors = array();
$success = array();

if(!(Authentication::getInstance()->isAdmin())){
    array_push($errors, 'Přihlášený uživatel neni admin!');
}

?>

<?php
if (!empty($errors)) {
    echo '<div class="card">';
    foreach ($errors as $error) {
        echo '<span class="error-msg">' . $error . '</span>';
    }
    echo '</div>';
    $errors = array();
}

if (!empty($success)) {
    echo '<div class="card">';
    foreach ($success as $suc) {
        echo '<span class="error-msg">' . $suc . '</span>';
    }
    echo '</div>';
    $success = array();
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <title>Titulek</title>
</head>
<body>
    <?php include 'header.php'?>

<?php if(empty($errors)): ?>
    <table>
        <thead>
            <tr>
                <td>id:</td>
                <td>name:</td>
                <td>lastname:</td>
                <td>email:</td>
                <td>role:</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach(Authentication::getInstance()->selectAllUzivatele() as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['lastname']) ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['role']) ?></td>
                    <td><a href="edit.php?id=<?= $user['id'] ?>">Upravit</a></td>
                    <td><a href="detail.php?id=<?= $user['id'] ?>">Detail</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

</body>
</html>
