<?php
/**
 * Created by PhpStorm.
 * User: MY.MEHDI
 * Date: 02/06/2019
 * Time: 11:07
 */

include_once '../util/config.php';
include_once '../util/utilService.php';

function findPropsOfProduit($data) {
    $query = "SELECT * FROM propriete  WHERE PRODUIT_IDPRODUIT='" . wrapParam('PRODUIT_IDPRODUIT', $data) . "'";
    return loadMultiple($query);
}
function findProduit($data) {
    $query = "SELECT * FROM produit WHERE IDPRODUIT='" . wrapParam('id', $data) . "'";
    return loadOne($query);
}
function findProduitById($id) {
    $query = "SELECT * FROM produit WHERE IDPRODUIT='" . $id . "'";
    return loadOne($query);
}

function findAllProduit() {
    $query = "SELECT * FROM produit";
    return loadMultiple($query);
}
///////////////////////
function findAllMarque() {
    $query = "SELECT * FROM marque";
    return loadMultiple($query);
}

function findAllCategorie() {
    $query = "SELECT * FROM categorie";
    return loadMultiple($query);
}
function findAllRevendeur() {
    $query = "SELECT * FROM revendeur";
    return loadMultiple($query);
}
/////////////
function deleteproduit($data) {
    $query = "DElETE FROM produit WHERE id='" . wrapParam('id', $data) . "'";
    return execRequest($query);
}

function updatepropriete($data) {
    $query = "UPDATE  propriete SET" ;
    $add=0;

    if (isset($data['VALEURPROPRIETE']) and $data['VALEURPROPRIETE'] != "") {
        $query .= " VALEURPROPRIETE='" . wrapParam('VALEURPROPRIETE', $data) . " '  ";
        $add = 1;
    }

    if (isset($data['TYPEPROPRIETE']) and $data['TYPEPROPRIETE'] != "") {
        if ($add == 1) $query .= " , ";
        $query .= "TYPEPROPRIETE='" . wrapParam('TYPEPROPRIETE', $data) . "'";
    }
    if (isset($data['LIBELLE']) and $data['LIBELLE'] != "") {
        if ($add == 1) $query .= " , ";
        $query .= "LIBELLE='" . wrapParam('LIBELLE', $data) . "'";
    }
    $query .= " WHERE IDPROPRIETE='" . wrapParam('IDPROPRIETE', $data) . "'";

    if (execRequest($query)){
        return  1;
    }
    else return 0;

}
function updateproduit($data) {
    $query = "UPDATE  produit SET" ;
    $add=0;

        if (isset($data['DESCRIPTION']) and $data['DESCRIPTION'] != "") {
            $query .= " DESCRIPTION='" . wrapParam('DESCRIPTION', $data) . "'";
            $add = 1;
        }

        if (isset($data['LIBELLE']) and $data['LIBELLE'] != "") {
            if ($add == 1) $query .= " , ";
            $query .= " LIBELLE='" . wrapParam('LIBELLE', $data) . "'";
        }
        $query .= " WHERE IDPRODUIT='" . wrapParam('id', $data) . "'";

        if (execRequest($query)){
          return  1;
        }
        else return 0;

}


function createproduit($data) {


    $id=generateMax("produit", "IDPRODUIT");
    $query = "INSERT INTO produit(IDPRODUIT, DESCRIPTION, LIBELLE, CATEGORIE_IDCATEGORIE, MARQUE_IDMARQUE)"
 ."VALUES('" . $id . "', '" . wrapParam('DESCRIPTION', $data) . "', '" . wrapParam('LIBELLE', $data).
         "', '" . wrapParam('CATEGORIE_IDCATEGORIE', $data) .
        "', '" . wrapParam('MARQUE_IDMARQUE', $data)."')";
     if(execRequest($query))
         return $id;
     else return 0;

}
function createPropriete($data){


        $query = "INSERT INTO  propriete(IDPROPRIETE, LIBELLE, TYPEPROPRIETE, VALEURPROPRIETE, PRODUIT_IDPRODUIT)"
            ."VALUES('" . generateMax("propriete", "IDPROPRIETE") . "', '" . wrapParam('LIBELLE', $data) . "', '" . wrapParam('TYPEPROPRIETE', $data).
            "', '" . wrapParam('VALEURPROPRIETE', $data) . "', '" . wrapParam('PRODUIT_IDPRODUIT', $data)  ."')";
         if (execRequest($query))
         return 1;
         else
             return 0;

}
function check1($data){
    if (isset($data['PRODUIT_IDPRODUIT']) and isset($data['REVENDEUR_IDREVENDEUR'])) {
        $query = "SELECT * FROM stockproduit where  1=1";
        $query .= addAttribute('PRODUIT_IDPRODUIT', wrapParam('PRODUIT_IDPRODUIT', $data), 'AND');
        $query .= addAttribute('REVENDEUR_IDREVENDEUR', wrapParam('REVENDEUR_IDREVENDEUR', $data), 'AND');
        if (loadMultiple($query) == NULL) {
         return "ajouter produit stock";
        }
        else {
            return "modifier produit stock";
        }
    }
}
function prodstockcheck($data){

    $query = "SELECT * FROM stockproduit where  1=1";
    $query .= addAttribute('PRODUIT_IDPRODUIT', wrapParam('PRODUIT_IDPRODUIT', $data), 'AND');
    $query .= addAttribute('REVENDEUR_IDREVENDEUR', wrapParam('REVENDEUR_IDREVENDEUR', $data), 'AND');
    if (loadMultiple($query)==NULL){
        $sql = "INSERT INTO stockproduit(PRIXUNITAIRE,QTESTOCK,PRODUIT_IDPRODUIT,REVENDEUR_IDREVENDEUR)"
            ." VALUES ('". wrapParam('PRIXUNITAIRE', $data) ."', '" . wrapParam('QTESTOCK', $data)
          .  "', '" . wrapParam('PRODUIT_IDPRODUIT', $data).  "', '" . wrapParam('REVENDEUR_IDREVENDEUR', $data)."')";

         if(execRequest($sql))
        echo" Un nouveau stock/produit a été enregistré";
      else echo "erreur dinsertion";
    }
    else {

        $sql="UPDATE stockproduit SET PRIXUNITAIRE='"
            . wrapParam('PRIXUNITAIRE', $data) ."',QTESTOCK='". wrapParam('QTESTOCK', $data) ."'  WHERE PRODUIT_IDPRODUIT='" . wrapParam('PRODUIT_IDPRODUIT', $data).  "'  and PRODUIT_IDPRODUIT='" . wrapParam('PRODUIT_IDPRODUIT', $data)."'";

         if(execRequest($sql))
        echo" le  stock/produit a été modifié";
else echo "erreur de modification";


    }
}

function findByCriteriaProduit($data) {
    $query = "SELECT * FROM produit WHERE 1=1";
    $query .= addAttribute('MARQUE_IDMARQUE', wrapParam('MARQUE_IDMARQUE', $data), 'AND');
    $query .= addAttribute('CATEGORIE_IDCATEGORIE', wrapParam('CATEGORIE_IDCATEGORIE', $data), 'AND');

  //  $query .= addAttributeMinMax('solde', wrapParam('soldeMin', $data), wrapParam('soldeMax', $data));

    return loadMultiple($query);
}