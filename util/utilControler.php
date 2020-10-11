<?php
function encode($data) {
    return json_encode(($data), JSON_UNESCAPED_UNICODE);
}

function printEncode($data) {
    echo encode($data);
}

function decode($num) {
    if ($num == 1)
        return $_GET;
    else if ($num == 2)
        return $_POST;
    else
        return json_decode(file_get_contents('php://input'), true);
}
function forward($pageToForward) {
    header("location:$pageToForward");
    exit();
}

?>
