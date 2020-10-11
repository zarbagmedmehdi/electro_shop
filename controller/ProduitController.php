<?php
/**
 * Created by PhpStorm.
 * User: MY.MEHDI
 * Date: 04/06/2019
 * Time: 01:00
 */


include_once '../util/utilService.php';
include_once '../util/utilControler.php';
include_once '../service/ProduitService.php';
$data = $_GET;
if (isset($data['method'])) {
    if ( $data['method'] == "findAllMarque") {
        $datas = findAllMarque();

        echo encode(array("marques"=>$datas));
    }
    else if ( $data['method'] == "findAllCategorie") {
        $datas = findAllCategorie();

        echo encode(array("categories"=>$datas));
    }
    else if ( $data['method'] == "findAllRevendeur") {
        $datas = findAllRevendeur();

        echo encode(array("revendeurs"=>$datas));
    }
    else if ( $data['method'] == "findByCriteriaProduit") {
        $datas = findByCriteriaProduit($data);

        echo encode(array("produits"=>$datas));
    }
    else if ($data['method'] == "findProduit") {
        $datas = findProduit($data);

        echo encode(array("produit" => $datas));
    }
    else if ($data['method'] == "findPropsOfProduit") {
        $datas = findPropsOfProduit($data);

        echo encode(array("props" => $datas));
    }


}
else {
    $data = $_POST;
    if (isset($data['method'])) {
        if ($data['method'] == "prodstockcheck") {
            $datas = prodstockcheck($data);

            echo encode($datas);
        }
        else   if ($data['method'] == "prodstockcheck") {
            $datas = prodstockcheck($data);

            echo encode($datas);
        }
        else  if ( $data['method'] == "check1") {


            echo encode(  check1($data));
        }
        else if ( $data['method'] == "createproduit") {


            echo encode(  createproduit($data));
        }
        else if ( $data['method'] == "createPropriete") {


            echo encode(  createPropriete($data));
        }
        else if ( $data['method'] == "updateproduit") {


            echo encode(updateproduit($data));
        }
        else if ( $data['method'] == "updatepropriete") {


            echo encode(updatepropriete($data));
        }

        else if ( $data['method'] == "upload") {


            echo encode(upload($data));
        }


    }
}