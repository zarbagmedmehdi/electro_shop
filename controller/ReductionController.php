<?php
/**
 * Created by PhpStorm.
 * User: MY.MEHDI
 * Date: 04/06/2019
 * Time: 03:42
 */


include_once '../util/utilService.php';
include_once '../util/utilControler.php';
include_once '../service/ReductionService.php';
$data = $_GET;
if (isset($data['method'])) {
    if ( $data['method'] == "findAllMarque") {

    }
    else if ( $data['method'] == "findAllCategorie") {
        $datas = findAllCategorie();

        echo encode(array("categories"=>$datas));
    }


}
else {
    $data = $_POST;
    if (isset($data['method'])) {


        if ($data['method'] == "createCoupon") {
            $datas = createCoupon($data);

            echo encode($datas);
        } else if (isset($data['method'])) {
            if ($data['method'] == "findReductions") {
                $datas = findReductions($data);

                echo encode(array("reductions"=>$datas));
            }
        }
    }
}