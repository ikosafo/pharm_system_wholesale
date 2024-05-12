<?php
include('../../../config.php');

$tsid = $_POST['tsid'];
$newQty = $_POST['quantity'];
$getDetail = $mysqli->query("SELECT * FROM tempsales t JOIN sales s ON t.`genid` = s.`newsaleid` WHERE t.`tsid` = '$tsid'");
$resDetail = $getDetail->fetch_assoc();
$productid = $resDetail['prodid'];
$purQty = $resDetail['quantity'];

$getProd = $mysqli->query("select * from products where prodid = '$productid'");
$resProd = $getProd->fetch_assoc();
$curQty = $resProd['quantity'];

$quantityLeft = ($purQty + $curQty) - $newQty;

//$quantityLeft = $resDetail['quantitydb'] - $quantity;
if ($quantityLeft < 0) {
    echo 0;
} else {
    echo 1;
}
