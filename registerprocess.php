<?php
session_start();
require_once 'util/config1.php';
if (isset($_POST) & !empty($_POST)) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $userPass = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $userCPass= filter_var($_POST['passwordagain'], FILTER_SANITIZE_STRING);
    // Set the password using a hash.
    $hashPass = md5($userPass);
    $sqlsearch = "SELECT * FROM client WHERE EMAIL='$email'";
    $res = loadOne($sqlsearch);

    if ($res == null) {
        if($userCPass==$userPass) {
            $newID = generateMax("client", "IDCLIENT");
            $sql = "INSERT INTO client (IDCLIENT, EMAIL, PASSWORD) VALUES ($newID,'$email', '$hashPass')";
            $result = execRequest($sql);
            if ($result) {
                $_SESSION['customer'] = $email;
                $_SESSION['customerid'] = $newID;
                header("location: my-account.php");
            } else {
                header("location: login.php?message=2");
            }
        }else{
            header("location: login.php?message=2");
        }
    }else{
        header("location: login.php?message=4");
    }
}