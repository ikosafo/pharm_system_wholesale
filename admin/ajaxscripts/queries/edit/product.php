<?php
include('../../../config.php');
include("../../../functions.php");

$username = $_SESSION['username'];
$barcode = mysqli_real_escape_string($mysqli, $_POST['barcode']);
$productname = mysqli_real_escape_string($mysqli, $_POST['productname']);
$quantitysale = mysqli_real_escape_string($mysqli, $_POST['quantitysale']);
$quantitystock = mysqli_real_escape_string($mysqli, $_POST['quantitystock']);
$stockthreshold = mysqli_real_escape_string($mysqli, $_POST['stockthreshold']);
$sku = mysqli_real_escape_string($mysqli, $_POST['sku']);
$supplier = mysqli_real_escape_string($mysqli, $_POST['supplier']);
$expirydate = mysqli_real_escape_string($mysqli, $_POST['expirydate']);
$isbn = mysqli_real_escape_string($mysqli, $_POST['isbn']);
$category = mysqli_real_escape_string($mysqli, $_POST['category']);
$subcategory = mysqli_real_escape_string($mysqli, $_POST['subcategory']);
$variation1 = mysqli_real_escape_string($mysqli, $_POST['variation1']);
$variation1spec = mysqli_real_escape_string($mysqli, $_POST['variation1spec']);
$variation2 = mysqli_real_escape_string($mysqli, $_POST['variation2']);
$variation2spec = mysqli_real_escape_string($mysqli, $_POST['variation2spec']);
$variation3 = mysqli_real_escape_string($mysqli, $_POST['variation3']);
$variation3spec = mysqli_real_escape_string($mysqli, $_POST['variation3spec']);
$costprice = mysqli_real_escape_string($mysqli, $_POST['costprice']);
$sellingpricewhole = mysqli_real_escape_string($mysqli, $_POST['sellingpricewhole']);
$theindex = mysqli_real_escape_string($mysqli, $_POST['theindex']);
$saletype = mysqli_real_escape_string($mysqli, $_POST['saletype']);


$editstaff = $mysqli->query("UPDATE `products`
  SET 
    `barcode` = '$barcode',
    `productname` = '$productname',
    `quantitysale` = '$quantitysale',
    `quantitystock` = '$quantitystock',
    `stockthreshold` = '$stockthreshold',
    `sku` = '$sku',
    `supplier` = '$supplier',
    `expirydate` = '$expirydate',
    `isbn` = '$isbn',
    `category` = '$category',
    `subcategory` = '$subcategory',
    `variation1` = '$variation1',
    `variation1spec` = '$variation1spec',
    `variation2` = '$variation2',
    `variation2spec` = '$variation2spec',
    `variation3` = '$variation3',
    `variation3spec` = '$variation3spec',
    `costprice` = '$costprice',
    `sellingpricewhole` = '$sellingpricewhole'

  WHERE `prodid` = '$theindex'");



$mysqli->query("INSERT INTO `logs`
              (
              `logdate`,
              `section`,
              `message`,
              `user`,
              `macaddress`,
              `ipaddress`,
              `action`)
              VALUES (
              '$datetime',
              'Product',
              'Update Product details by $username successfully',
              '$username',
              '$mac_address',
              '$ip_add',
              'Successful')") or die(mysqli_error($mysqli));

echo 1;
