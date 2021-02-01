<h1>Import export kategorií</h1>

<?php

$categoryDb = new Category();
if(isset($_GET['action']))
{

    if($_GET['action'] == 'export'){
        $allCat = $categoryDb->getAllCategories();
        $json = json_encode($allCat);
        ob_clean();
        $tmp = file_put_contents('category.json', $json);
        header('Content-disposition: attachment; filename=file.json');
        header('Content-type: application/json');
        echo $json;
        $_SESSION['msg'] = 'Exportováno';
        die();  
    }
}
if(!empty($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

echo '
<table class="threads">
<tr>
    <th></th>
    <th></th>
</tr>';
echo '

<td><form action="./pages/upload.php" method="post" enctype="multipart/form-data">
Importovat:<br>
<input type="file" name="file"><br>
<input type="submit" value="Importovat" name="submit">
</form></td>

<td><a href="' . BASE_URL . '?page=json&action=export"> Export</a></td>
';
echo '</table>';
?>

