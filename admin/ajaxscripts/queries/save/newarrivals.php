<?php
include('../../../config.php');
include("../../../functions.php");

$username = $_SESSION['username'];

$productid = mysqli_real_escape_string($mysqli, $_POST['product']);
$quantitysale = mysqli_real_escape_string($mysqli, $_POST['quantitysale']);
$quantitystock = mysqli_real_escape_string($mysqli, $_POST['quantitystock']);
$suppliername = mysqli_real_escape_string($mysqli, $_POST['supplier']);
$expirydate = mysqli_real_escape_string($mysqli, $_POST['expirydate']);
$costprice = mysqli_real_escape_string($mysqli, $_POST['costprice']);
$sellingpricewhole = mysqli_real_escape_string($mysqli, $_POST['sellingpricewhole']);
$productname = getProductName($productid);
//$suppliername = supplierName($supplierid);


$saveconfig = $mysqli->query("INSERT INTO `newarrivals`
                        (`prodid`,
                         `productname`,
                         `quantitysale`,
                         `quantitystock`,
                         `supplier`,
                         `expirydate`,
                         `costprice`,
                         `sellingpricewhole`,
                         `username`,
                         `datetime`)
                    VALUES ('$productid',
                            '$productname',
                            '$quantitysale',
                            '$quantitystock',
                            '$suppliername',
                            '$expirydate',
                            '$costprice',
                            '$sellingpricewhole',
                            '$username',
                            '$datetime')");

//update products

$getdetails = $mysqli->query("select * from `products` where prodid = '$productid'");
$resdetails = $getdetails->fetch_assoc();
$quantitysaleold = $resdetails['quantitysale'];
$quantitystockold = $resdetails['quantitystock'];
$updatequantitysale = $quantitysaleold + $quantitysale;
$updatequantitystock = $quantitystockold + $quantitystock;

if ($quantitysaleold == "0") {
    $saveconfig = $mysqli->query("UPDATE `products`
                            SET 
                            `quantitysale` = '$updatequantitysale',
                            `quantitystock` = '$updatequantitystock',
                            `costprice` = '$costprice',
                            `expirydate` = '$expirydate',
                            `supplier` = '$supplierid',
                            `sellingpricewhole` = '$sellingpricewhole'
                            
                            WHERE `prodid` = '$productid'");
} else {
    $saveconfig = $mysqli->query("UPDATE `products`
                            SET 
                            `quantitysale` = '$updatequantitysale',
                            `quantitystock` = '$updatequantitystock',
                            `costprice` = '$costprice',
                            `sellingpricewhole` = '$sellingpricewhole'
                            
                            WHERE `prodid` = '$productid'");
}

/*   $saveconfig = $mysqli->query("UPDATE `products`
                        SET 
                        `quantitysale` = '$updatequantitysale',
                        `quantitystock` = '$updatequantitystock',
                        `costprice` = '$costprice',
                        `sellingprice` = '$sellingprice',
                        `sellingpricewhole` = '$sellingpricewhole'
                        
                        WHERE `prodid` = '$productid'"); */

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
                        'New arrivals',
                        'Added product $productname as new arrival successfully',
                        '$username',
                        '$mac_address',
                        '$ip_add',
                        'Successful')") or die(mysqli_error($mysqli));

echo 1;
