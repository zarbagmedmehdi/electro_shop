<?php
/**
 * Created by PhpStorm.
 * User: MY.MEHDI
 * Date: 04/06/2019
 * Time: 03:42
 */
include_once '../util/config.php';
include_once '../util/utilService.php';

function findReductions($data) {
    $query = "SELECT * FROM reductioncoupon  WHERE 1=1  ";
    if( isset ($data['MONTANTREDUCTION']) and $data['MONTANTREDUCTION'])
        $query .= addAttribute('MONTANTREDUCTION', wrapParam('MONTANTREDUCTION', $data), 'AND');
    if( isset ($data['UTILISE']) and $data['UTILISE'])
        $query .= addAttribute('UTILISE', wrapParam('UTILISE', $data), 'AND');
     $res=loadMultiple($query);
     if( $res!=null){
         return $res;
     }
     else {
         return 0;
     }

}
function  createCoupon($data)
{
    $res = 0;
    for ($i = 0; $i < $data['nb']; $i++) {
        $ref = createReference();
        $query = "INSERT INTO reductioncoupon( MONTANTREDUCTION, REFERENCE, UTILISE)"
            . "VALUES('" . wrapParam('MONTANTREDUCTION', $data) . "', '" . $ref .
            "', '" . 0 . "')";

        if (execRequest($query)){

             $res+=1;}
        else $res= $res;

    }
    return $res;
}
function createReference(){
    $str="AZ56ERTY45UIOPQS123456789DFGHJ6789KLMWXCVBN";
    $ref="";
    for ($i=0;$i<10;$i++){
        $ref.=$str[rand(0,42)];
    }
    return $ref;

}