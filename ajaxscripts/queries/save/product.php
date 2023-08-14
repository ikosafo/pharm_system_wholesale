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


//Check whether a staff already exists
if ($barcode != "" || $productname != "") {
    $check = $mysqli->query("select * from products where (barcode = '$barcode' OR productname = '$productname')");
    $getexist = mysqli_num_rows($check);

    if ($getexist == "0") {
        $saveconfig = $mysqli->query("INSERT INTO `products`
        (
        `barcode`,
        `productname`,
        `quantitysale`,
        `quantitystock`,
        `stockthreshold`,
        `sku`,
        `supplier`,
        `expirydate`,
        `isbn`,
        `category`,
        `subcategory`,
        `variation1`,
        `variation1spec`,
        `variation2`,
        `variation2spec`,
        `variation3`,
        `variation3spec`,
        `costprice`,
        `sellingpricewhole`,
        `username`,
        `datetime`)
        VALUES 
            (
            '$barcode',
            '$productname',
            '$quantitysale',
            '$quantitystock',
            '$stockthreshold',
            '$sku',
            '$supplier',
            '$expirydate',
            '$isbn',
            '$category',
            '$subcategory',
            '$variation1',
            '$variation1spec',
            '$variation2',
            '$variation2spec',
            '$variation3',
            '$variation3spec',
            '$costprice',
            '$sellingpricewhole',
            '$username',
            '$datetime')");

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
        'Added product $productname as product successfully',
        '$username',
        '$mac_address',
        '$ip_add',
        'Successful')") or die(mysqli_error($mysqli));

        echo 1;
    } else {
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
                            'Add Product error (Barcode already exists)',
                            '$username',
                            '$mac_address',
                            '$ip_add',
                            'Failed')") or die(mysqli_error($mysqli));

        echo 2;
    }
} else {
    $saveconfig = $mysqli->query("INSERT INTO `products`
    (
    `barcode`,
    `productname`,
    `quantitysale`,
    `quantitystock`,
    `stockthreshold`,
    `sku`,
    `supplier`,
    `expirydate`,
    `isbn`,
    `category`,
    `subcategory`,
    `variation1`,
    `variation1spec`,
    `variation2`,
    `variation2spec`,
    `variation3`,
    `variation3spec`,
    `costprice`,
    `sellingpricewhole`,
    `username`,
    `datetime`)
    VALUES 
        (
        '$barcode',
        '$productname',
        '$quantitysale',
        '$quantitystock',
        '$stockthreshold',
        '$sku',
        '$supplier',
        '$expirydate',
        '$isbn',
        '$category',
        '$subcategory',
        '$variation1',
        '$variation1spec',
        '$variation2',
        '$variation2spec',
        '$variation3',
        '$variation3spec',
        '$costprice',
        '$sellingpricewhole',
        '$username',
        '$datetime')");

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
    'Added product $productname as product successfully',
    '$username',
    '$mac_address',
    '$ip_add',
    'Successful')") or die(mysqli_error($mysqli));

    echo 1;
}
