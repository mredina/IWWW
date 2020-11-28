<?php
ob_start();
session_start();
require 'config/config.php';

function __autoload($className)
{
    if (file_exists('./classes/' . $className . '.php')) {
        require_once './classes/' . $className . '.php';
        return true;
    }
    return false;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- link pro nacteni ikonky pro mobilni "hamburger" menu -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="style/layout.css">
    <link rel="stylesheet" type="text/css" href="style/responsive.css">
    <title>Linux/Unix forum</title>
</head>

<body>
<?php require 'layout/header.php'; ?>
<main>
    <?php
    if (!isset($_GET['page'])) {
        require 'pages/home.php';
    } else {
        $page = './pages/' . $_GET['page'] . '.php';
        if (file_exists($page)) {
            require $page;
        } else {
            require 'pages/page_not_found.php';
        }
    }
    ?>
</main>
<?php require 'layout/footer.php'; ?>
<script src="js/app.js"></script>
</body>

</html>

