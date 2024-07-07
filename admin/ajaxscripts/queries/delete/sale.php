<?php
include('../../../config.php');
include("../../../functions.php");

$theid = mysqli_real_escape_string($mysqli, $_POST['i_index']);
$amtPaid = mysqli_real_escape_string($mysqli, $_POST['amtPaid']);
$totalPrice = mysqli_real_escape_string($mysqli, $_POST['totalPrice']);

$getGenid = $mysqli->query("select * from tempsales where tsid = '$theid'");
$resGenid = $getGenid->fetch_assoc();
$genid = $resGenid["genid"];
$delPrice = $resGenid["price"];

$getAmt = $mysqli->query("select * from sales where newsaleid = '$genid'");
$resAmt = $getAmt->fetch_assoc();
$updatedAmt = $resAmt["totalprice"] - $delPrice;
