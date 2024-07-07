<?php
include('../../../config.php');
include("../../../functions.php");

$username = $_SESSION['username'];
$theid = mysqli_real_escape_string($mysqli, $_POST['i_index']);
$amtPaid = mysqli_real_escape_string($mysqli, $_POST['amtPaid']);
$totalPrice = mysqli_real_escape_string($mysqli, $_POST['totalPrice']);
$selectProd = mysqli_real_escape_string($mysqli, $_POST['selectProd']);
$quantity = mysqli_real_escape_string($mysqli, $_POST['quantity']);

$getProdid = $mysqli->query("select * from products where prodid = '$selectProd'");
$resProdid = $getProdid->fetch_assoc();
$sellingPrice = $resProdid["sellingprice"];
$quantitydb = $resProdid["quantity"];

$getAmt = $mysqli->query("select * from sales where newsaleid = '$theid'");
$resAmt = $getAmt->fetch_assoc();
$updatedAmt = $resAmt["totalprice"] + ($sellingPrice * $quantity);

if ($quantitydb < $quantity) {
    // Quantity exceeded
    echo 2;
}
else {
    if ($updatedAmt > $amtPaid) {

        // Amount paid is insufficient
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
        'Adding to Existing Sales',
        'Attempt to add existing sales but amount paid entered was insufficient',
        '$username',
        '$mac_address',
        '$ip_add',
        'Failed')") or die(mysqli_error($mysqli)); 
    
        echo 3;
    }
    else {
        // Calculate for change given
        $changeGiven = $amtPaid - $updatedAmt;
        $updateQty = $quantitydb - $quantity;

        $updateSales = $mysqli->query("UPDATE `sales`
                                    SET 
                                    `amountpaid` = '$amtPaid',
                                    `totalprice` = '$updatedAmt',
                                    `change` = '$changeGiven'
                                    WHERE `newsaleid` = '$theid'");
    

        $updateProduct = $mysqli->query("UPDATE `products`
        SET `quantity` = '$updateQty' WHERE `prodid` = '$selectProd'");

     
            $insTempSales = $mysqli->query("INSERT INTO `tempsales`
                        (
                        `quantity`,
                        `price`,
                        `genid`,
                        `datetime`,
                        `prodid`,
                        `quantitydb`)
            VALUES (
                    '$quantity',
                    '$sellingPrice',
                    '$theid',
                    '$datetime',
                    '$selectProd',
                    '$quantitydb')");
    
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
                    'Added to existing Sales',
                    'Added sales to $theid',
                    '$username',
                    '$mac_address',
                    '$ip_add',
                    'Successful')") or die(mysqli_error($mysqli)); 
                                                echo $changeGiven;
    
                }

        }

