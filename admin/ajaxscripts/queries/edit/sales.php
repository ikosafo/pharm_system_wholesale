<?php
include('../../../config.php');

$tsid = $_POST['tsid'];
$quantity = $_POST['quantity'];
$getDetail = $mysqli->query("SELECT * FROM tempsales t JOIN sales s ON t.`genid` = s.`newsaleid` WHERE t.`tsid` = '$tsid'");
$resDetail = $getDetail->fetch_assoc();

$quantityLeft = $resDetail['quantitydb'] - $quantity;
if ($quantityLeft < 0) {
    echo 0;
} else {
    echo 1;
}
