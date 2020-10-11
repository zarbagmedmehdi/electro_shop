<?php
include_once 'util/config1.php';
if (isset($_GET) & !empty($_GET)) {
    $id = $_GET['id'];
    if (isset($_GET['quant']) & !empty($_GET['quant'])) {
        $quant = $_GET['quant'];
    } else {
        $quant = 1;
    }
    if($quant> loadOne("SELECT QTESTOCK FROM stockproduit WHERE IDSTOCKPRODUIT=$id")['QTESTOCK']){
        header('location: single.php?msg=-1&id='.$id);
    }else{
        $_SESSION['cart'][$id] = array("quantity" => $quant);
        setcookie("cart[$id]","$quant",time()+3600*24*365);
        header('location: cart.php');
    }
} else {
     header('location: cart.php');
}
