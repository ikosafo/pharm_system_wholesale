<?php
include('../../../config.php');
include("../../../functions.php");

$username = $_SESSION['username'];
$theid = mysqli_real_escape_string($mysqli, $_POST['i_index']);
$amtPaid = mysqli_real_escape_string($mysqli, $_POST['amtPaid']);
$totalPrice = mysqli_real_escape_string($mysqli, $_POST['totalPrice']);

$getGenid = $mysqli->query("select * from tempsales where tsid = '$theid'");
$resGenid = $getGenid->fetch_assoc();
$genid = $resGenid["genid"];
$delPrice = $resGenid["price"];
$quantity = $resGenid["quantity"];
$prodid =  $resGenid["prodid"];

$getAmt = $mysqli->query("select * from sales where newsaleid = '$genid'");
$resAmt = $getAmt->fetch_assoc();
$updatedAmt = $resAmt["totalprice"] - $delPrice;

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
    'Deleting Sales',
    'Attempt to delete sales but amount paid entered was insufficient',
    '$username',
    '$mac_address',
    '$ip_add',
    'Failed')") or die(mysqli_error($mysqli)); 

    echo 2;
}
else {
    // Calculate for change given
    $changeGiven = $amtPaid - $updatedAmt;

    $updateSales = $mysqli->query("UPDATE `sales`
                                SET 
                                `amountpaid` = '$amtPaid',
                                `totalprice` = '$updatedAmt',
                                `change` = '$changeGiven'
                                WHERE `newsaleid` = '$genid'");

                            $updateQty = $mysqli->query("
                            UPDATE `products`
                            SET `quantity` = `quantity` + $quantity
                            WHERE `prodid` = '$prodid'");

 
                        $delTempSales = $mysqli->query("DELETE
                        FROM `tempsales`
                        WHERE `tsid` = '$theid'");


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
                            'Deleting Sales',
                            'Deleted sales on $genid',
                            '$username',
                            '$mac_address',
                            '$ip_add',
                            'Successful')") or die(mysqli_error($mysqli)); 
                                                        echo $changeGiven;

                    }