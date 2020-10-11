<?php
/**
 * Created by PhpStorm.
 * User: simob
 * Date: 04/06/2019
 * Time: 13:13
 */
require_once 'util/config1.php';
session_start();

if (!isset($_SESSION['customer']) & empty($_SESSION['customer'])) {
    header('location: login.php');
} else {
    $uid = $_SESSION['customerid'];
}
if(isset($_POST) && !empty($_POST)){
    if(isset($_POST['passwd']) && isset($_POST['cpasswd'])){
        echo "<script>console.log(5)</script>";
        $password = $_POST['passwd'];
        $cpassword = $_POST['cpasswd'];
    }
    if ($password != null && $password != "" && $cpassword != null && $cpassword != "") {
        echo "<script>console.log(6)</script>";
        if ($password == $cpassword) {
            echo "<script>console.log(7)</script>";

            $sqlStatement1 = "UPDATE client SET PASSWORD=md5('$password') WHERE IDCLIENT=$uid";
            echo "$sqlStatement1";
            execRequest("UPDATE client SET PASSWORD=md5('$password') WHERE IDCLIENT=$uid");
            header("location: edit-address.php?message=success");
        } else {
            echo "<script>console.log(8)</script>";
            header("location: edit-address.php?message=warning");
        }
    }
}

echo "<script>console.log(9)</script>";
