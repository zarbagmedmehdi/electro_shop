<?php

session_start();
require_once 'util/config1.php';
if (!isset($_SESSION['customer']) & empty($_SESSION['customer'])) {
    header('location: login.php');
}
$uid = $_SESSION['customerid'];

if (isset($_GET) & !empty($_GET)) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $ordupd = "UPDATE commande SET STATUT='annule' WHERE STATUT='commande envoye' AND IDCOMMANDE=$id";
        executeRequest($ordupd);
        header('location: my-account.php');
        echo "<script>console.log('xx')</script>";
}

