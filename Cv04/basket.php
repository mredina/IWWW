<?php

require_once 'config/config.php';
require_once 'classes/authentication.php';
require_once 'classes/connection.php';

$errors = array();
$success = array();

if(isset($_GET['finish'])){
    Authentication::getInstance()->finishOrder($_SESSION['basket']);

    $_SESSION['basket'] = array();
    array_push($success, "Objednávka se dokončila");
}

if(isset($_GET['clean'])){
    $_SESSION['basket'] = array();
    array_push($success, "Košík se vyprázdnil");
}

if( isset($_GET['dep']) && 
    isset($_SESSION['basket'][$_GET['dep']]) && 
    $_SESSION['basket'][$_GET['dep']] > 1 ){
    $_SESSION['basket'][$_GET['dep']]--;
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
    <title>Košík</title>
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
                    <td><b>mnozstvi:</b></td>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php foreach($_SESSION['basket'] as $product => $qu): ?>
                <?php 
                    $user = Authentication::getInstance()->selectProduct($product);
                    $total = $total + intval($user['price']);
                ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['img']) ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['price']) ?></td>
                        <td><?= $qu ?></td>
                        <td><a href="basket.php?dep=<?= $user['id'] ?>">Snizit mnozstvi</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?= "Total price: " . $total ?>
        <?php if(count($_SESSION['basket']) > 0): ?>
            <a href="basket.php?finish=true">Dokončit objednávku</a>
            <a href="basket.php?clean=true">Vyprazdnit košík</a>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>