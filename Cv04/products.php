<?php

require_once 'config/config.php';
require_once 'classes/authentication.php';
require_once 'classes/connection.php';

$errors = array();
$success = array();

if(!isset($_SESSION['identity'])){
    array_push($errors, 'Nikdo neni přihlašený.');
} else {
    if(isset($_GET['id'])){
        if(isset($_SESSION['basket'][$_GET['id']])){
            $_SESSION['basket'][$_GET['id']]++;
        } else {
            $_SESSION['basket'][$_GET['id']] = 1;
        }
        array_push($success, "Produkt byl přidán do košíku.");
    }
}

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <title>Katalog</title>
    <link rel="stylesheet" href="/style/style.css">
</head>
<body>
    <?php include 'header.php'?>
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
    <?php if(empty($errors)): ?>
        <table>
            <thead>
                <tr>
                    <td>id:</td>
                    <td>img:</td>
                    <td>name:</td>
                    <td>price:</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach(Authentication::getInstance()->selectAllProducts() as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['img']) ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['price']) ?></td>
                        <td><a href="products.php?id=<?= $user['id'] ?>">Koupit</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
