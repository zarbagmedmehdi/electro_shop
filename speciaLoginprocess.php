<?php

include_once 'util/config.php';
if (isset($_POST) & !empty($_POST)) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    if (isset($_POST["type"])) {
        if ($_POST["type"] == 1) {
            $stat = connect()->prepare("SELECT * FROM revendeur WHERE EMAIL=:e");
        }
        else if ($_POST["type"] == 2) {
            $stat = connect()->prepare("SELECT * FROM admin WHERE EMAIL=:e");
        }
            $stat->execute(array(':e'=>$email));
            $count = $stat->rowCount();
            $r =$stat->fetch(PDO::FETCH_ASSOC);
            if ($count == 1){
                if (md5($password)==$r['PASSWORD']) {
                    session_start();
                    $_SESSION['email'] = $email;
                    $_SESSION['nom'] = $r['NOM'];
                    if ($_POST["type"] == 1) {
                        header("location: acceuilRevendeur.php");
                    }
                    else if ($_POST["type"] == 2) {
                        header("location: acceuilAdmin.php");
                    }

                } else {
                    header("location: speciaLogin.php?message=1");
                }
            }
            else {
                header("location: speciaLogin.php?message=3");
            }

        }
    }
 else {
    $stat = connect()->prepare("SELECT * FROM client WHERE EMAIL=:e");
    $stat->execute(array(':e'=>$email));
    $count = $stat->rowCount();
    $r =$stat->fetch(PDO::FETCH_ASSOC);
    if ($count == 1) {
        if (md5($password)==$r['PASSWORD']) {
            session_start();
            $_SESSION['customer'] = $email;
            $_SESSION['customerid'] = $r['IDCLIENT'];
            header("location: my-account.php");
        } else {
            header("location:login.php?message=1");
        }
    } else {
        header("location: login.php?message=3");
    }


}