<?php

require_once 'config/config.php';
require_once 'classes/authentication.php';
require_once 'classes/connection.php';


Authentication::getInstance()->logout();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Odhlášení</title>
</head>
<body>
<?php include 'header.php'?>

<?php if(!isset($_SESSION['identity'])): ?>
       <h3> Odhlášen ze systému </h3>
<?php endif; ?>
</body>
