<?php
/**
 * Created by PhpStorm.
 * User: MY.MEHDI
 * Date: 04/06/2019
 * Time: 16:35
 */
include_once '../util/config.php';
include_once '../util/utilService.php';
session_start();
if (!isset($_SESSION['email']) & empty($_SESSION['email'])) {
    header('location: speciaLogin.php');
}
else {

    if (isset($_GET['id']) & $_GET['id'] != null) {
        {
            $query = "UPDATE commande SET `STATUT` = 'commande validé' WHERE IDCOMMANDE='" . wrapParam("id", $_GET) . "'";
            echo $query;
            execRequest($query);

            header('location: ../validerCommandes.php');

        }
    }
}