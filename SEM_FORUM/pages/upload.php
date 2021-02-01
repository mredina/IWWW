<?php
session_start();

require '../config/config.php';
require '../classes/Connection.php';
require '../classes/Category.php';

$categoryDb = new Category();

$file_upload = $_FILES['file']['tmp_name'];
if ($file_upload) {
    $info = pathinfo($_FILES['file']['name']);
    $extension = $info['extension'];
    if($extension != 'json'){
        die('Invalid file');
    }
    $file = file_get_contents($file_upload);
    $allCat = json_decode($file,true);
    foreach($allCat as $cat){
        $categoryDb->insertCategory($cat['name']);
    }
    
}

$_SESSION['msg']='Importováno';
header('Location: ../index.php?page=json');

?>