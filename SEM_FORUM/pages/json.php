<h1>Import export kategorií</h1>

<?php

$categoryDb = new Category();
if(isset($_GET['action']))
{
    if($_GET['action'] == 'import'){
        $json = file_get_contents('category.json');
        $allCat = json_decode($json,true);
        foreach($allCat as $cat){
            $categoryDb->insertCategory($cat['name']);
        }
        
        echo 'importovano';
    }

    if($_GET['action'] == 'export'){
        $allCat = $categoryDb->getAllCategories();
        $json = json_encode($allCat);
        ob_clean();
        $tmp = file_put_contents('category.json', $json);
        header('Content-disposition: attachment; filename=file.json');
        header('Content-type: application/json');
        echo $json;
        die();  
    }
}
echo '
<table class="threads">
<tr>
    <th></th>
    <th></th>
</tr>';
echo '
<td><a href="' . BASE_URL . '?page=json&action=import"> Import</a></td>
<td><a href="' . BASE_URL . '?page=json&action=export"> Export</a></td>
';
echo '</table>';

?>

