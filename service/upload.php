<?php
/**
 * Created by PhpStorm.
 * User: MY.MEHDI
 * Date: 04/06/2019
 * Time: 21:43
 */
include_once 'ProduitService.php';

if($_FILES["file"]["name"] != '') {
    $test = explode('.', $_FILES["file"]["name"]);
    $ext ="jpg";
    $id=generateMax("produit", "IDPRODUIT")-1;
    $prod=findProduitById($id);
    $name = $prod->LIBELLE. '.' . $ext;

    $location = 'C:\\xampp\\htdocs\\electro\\uploads\\' . $name;

    $query = "UPDATE  produit SET" ;
        $query .= " IMAGE='" .   $name."'";
        $query.="where IDPRODUIT='".$id."'";

    if (execRequest($query)){
        move_uploaded_file($_FILES["file"]["tmp_name"], $location);

        return  1;
    }
    else return 0;
}
else return -1;