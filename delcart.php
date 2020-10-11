<?php
if (isset($_GET['id']) & !empty($_GET['id'])) {
    $id = $_GET['id'];
    setcookie("cart[$id]","");
    unset($_COOKIE["cart"][$id]);
    header('location: cart.php');
}
