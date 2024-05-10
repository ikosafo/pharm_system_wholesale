<?php
include('../../../config.php');

// Retrieve data from the POST request
$tsid = $_POST['tsid'];
$quantity = $_POST['quantity'];
$pricePerItem = $_POST['pricePerItem'];
$totalTempPrice = $pricePerItem * $quantity; // Calculate total temporary price
$datetime = date('Y-m-d H:i:s');

$customerName = $_POST['customerName'];
$customerTel = $_POST['customerTel'];
$amtPaid = $_POST['amtPaid'];
$changeGiven = $_POST['changeGiven'];
$totalPrice = $_POST['totalPrice'];

// Retrieve additional data from the database
$getGenid = $mysqli->query("SELECT * FROM `tempsales` WHERE tsid = '$tsid'");
$resGenid = $getGenid->fetch_assoc();
$genid = $resGenid['genid'];
$prodid = $resGenid['prodid'];
$quantitydb = $resGenid['quantitydb'];
$quantityLeft = $quantitydb - $quantity;

// Update quantity in products table
$mysqli->query("UPDATE `products` SET `quantity` = '$quantityLeft' WHERE `prodid` = '$prodid'");

// Update quantity and total price in tempsales table
$mysqli->query("UPDATE `tempsales` SET `quantity` = '$quantity', `price` = '$totalTempPrice' WHERE `tsid` = '$tsid'");

// Update customer details in sales table
$mysqli->query("UPDATE `sales`
    SET 
    `amountpaid` = '$amtPaid',
    `totalprice` = '$totalPrice',
    `change` = '$changeGiven',
    `customer` = '$customerName',
    `datetime` = '$datetime',
    `telephone` = '$customerTel'
    WHERE `newsaleid` = '$genid'");
