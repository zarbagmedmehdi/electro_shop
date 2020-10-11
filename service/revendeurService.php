<?php

include_once '../util/config.php';
include_once '../util/utilService.php';
include_once '../util/utilControler.php';

$data = $_POST;
if (isset($data['method'])) {
    //switch $data['method']
    if ( $data['method'] == "addRevendeur") {
        $datas = addRevendeur($data);

        echo encode($datas);
    }
    if ($data['method'] == "searchRevendeur") {
        $datas = searchRevendeur($data);

        echo encode(array("revendeur"=>$datas));
    }
    if ( $data['method'] == "modifyRevendeur") {
        $datas = modifyRevendeur($data);

        echo encode(array("modify"=>$datas));
    }        
    if ( $data['method'] == "deleteRevendeur") {
        $datas = deleteRevendeur($data);

        echo encode(array("delete"=>$datas));
    }
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function addRevendeur($data) {
    $query = "INSERT INTO `revendeur`(`IDREVENDEUR`, `NOM`,`TEL`, `EMAIL`, `PASSWORD`, `ADRESSE`, `REVENDEURDESCRIPTION`) VALUES (".generateMax("revendeur","IDREVENDEUR").",'".wrapParam("nom",$data)."', '".wrapParam("tel",$data)."', '".wrapParam("email",$data)."', '". md5(wrapParam("password",$data))."', '".wrapParam("adresse",$data)."', '".wrapParam("revendeurdescription",$data)."')";
    return execRequest($query);
}

function searchRevendeur($data) {
    $query = "SELECT  `ADRESSE` a, `EMAIL` e,`NOM` n, `PASSWORD` p, `RATING` rt, `REVENDEURDESCRIPTION` rd, `TEL` t FROM revendeur WHERE nom ='".wrapParam("nom",$data)."'";
    return loadOne($query);
     
}

function modifyRevendeur($data) {
    $query = "UPDATE revendeur SET `TEL` = '".wrapParam("tel",$data)."', `EMAIL` = '".wrapParam("email",$data)."', `PASSWORD` = '".md5(wrapParam("password",$data))."', `ADRESSE` = '".wrapParam("adresse",$data)."', `REVENDEURDESCRIPTION`= '".wrapParam("revendeurdescription",$data)."' WHERE nom ='".wrapParam("nom",$data)."'";
    return execRequest($query);
}

function deleteRevendeur($data) {
    $query = "DELETE From revendeur WHERE nom ='".wrapParam("nom",$data)."'";
    return execRequest($query);
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
