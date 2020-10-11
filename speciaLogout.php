<?php
/**
 * Created by PhpStorm.
 * User: MY.MEHDI
 * Date: 04/06/2019
 * Time: 13:11
 */

session_start();

unset($_SESSION['email']);
unset($_SESSION['nom']);
session_destroy();
header('location: speciaLogin.php');