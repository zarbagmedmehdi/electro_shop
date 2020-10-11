<?php
/**
 * Created by PhpStorm.
 * User: simob
 * Date: 04/06/2019
 * Time: 14:12
 */


    echo 1;
    if(isset($_FILES['image'])){
        $filename=$_FILES['image']['name'];
        $filetmp=$_FILES['image']['tmp_name'];
        echo "<h1>{$filename}</h1>";
        move_uploaded_file($filetmp,"uploads/".$filename);
    }


?>
<form method="post" action="test.php" enctype="multipart/form-data">
    <input type="file" name="image">
    <input type="submit" value="ok">
</form>