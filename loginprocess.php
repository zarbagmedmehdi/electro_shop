<?php
include_once 'util/config1.php';

if (isset($_POST) & !empty($_POST)) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $stat = connect()->prepare("SELECT * FROM client WHERE EMAIL=:e");
    $stat->execute(array(':e'=>$email));
    $count = $stat->rowCount();
    $r =$stat->fetch(PDO::FETCH_ASSOC);

    if ($count == 1) {
        if (md5($password)==$r['PASSWORD']) {
            session_start();
            $_SESSION['customer'] = $email;
            $_SESSION['customerid'] = $r['IDCLIENT'];
            $_SESSION['status']="Active";
            header("location: my-account.php");
        } else {
            header("location: login.php?message=1");
        }
    } else {
        header("location: login.php?message=3");
    }
}
