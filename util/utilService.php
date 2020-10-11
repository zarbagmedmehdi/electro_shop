<?php

function addAttributeMinMax($attribute_name, $min_value, $max_value) {
    $query = "";
    if ($min_value != NULL) {
        $query .= " AND $attribute_name >= '$min_value'";
    }
    if ($max_value != NULL) {
        $query .= " AND $attribute_name <= '$max_value'";
    }
    return $query;
}

function addAttribute($attribute_name, $attribute_value,$opeartor) {
    $query = "";
    if ($attribute_value != NULL && $attribute_value != "") {
      if($opeartor=='AND'){        $query .= " AND $attribute_name = '$attribute_value'";
         }else{
        $query .= " AND  $attribute_name LIKE '%$attribute_value%'";
        }
    }
    return $query;
}

function addAttributeForUpdate($attribute_name, $attribute_value) {
    $query = "";
    if ($attribute_value != NULL && $attribute_value != "") {
        $query .= " , $attribute_name = '$attribute_value'";
    }
    return $query;
}

function wrapParam($param, $tab) {
    if (isset($tab[$param]) && $tab[$param] != NULL && $tab[$param] != "") {
        return $tab[$param];
    }
    return NULL;
}

function addOrConstraint($data, $attributRequestName, $attributeName) {
    $query = "";
    $myData = wrapParam($attributRequestName, $data);
    $i = 0;
    if ($myData != NULL) {
        $query = " AND (";
        $extractDatas = explode(',', $myData);
        foreach ($extractDatas as $extractData) {
            if ($i == 0) {
                $query .= "$attributeName = '$extractData'";
            } else {
                $query .= " OR $attributeName = '$extractData'";
            }
            $i++;
        }
        $query .= ")";
    }
    return $query;
}

function printQuery($query) {
    echo "<br></br>$query<br></br>";
}

function printDataAndQuery($data, $query) {
    printQuery($query);
    echo json_encode(($data), JSON_UNESCAPED_UNICODE);
    echo "<br></br><br></br>";
    return 1;
}
