<?php
include('../../../config.php');
include("../../../functions.php");

$username = $_SESSION['username'];
$companyname = mysqli_real_escape_string($mysqli, $_POST['companyname']);
$tagline = mysqli_real_escape_string($mysqli, $_POST['tagline']);
$telephone = mysqli_real_escape_string($mysqli, $_POST['telephone']);
$emailaddress = mysqli_real_escape_string($mysqli, $_POST['emailaddress']);
$currency = mysqli_real_escape_string($mysqli, $_POST['currency']);
$address = mysqli_real_escape_string($mysqli, $_POST['address']);
$sysconid = mysqli_real_escape_string($mysqli, $_POST['sysconid']);
$theid = mysqli_real_escape_string($mysqli, $_POST['theid']);


$saveconfig = $mysqli->query("UPDATE `system_config`
                            
                            SET `companyname` = '$companyname',
                            `tagline` = '$tagline',
                            `address` = '$address',
                            `emailaddress` = '$emailaddress',
                            `telephone` = '$telephone',
                            `currency` = '$currency' WHERE sysid = '$theid'");

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
                            'Store Config',
                            'Updated System Config successfully',
                            '$username',
                            '$mac_address',
                            '$ip_add',
                            'Successful')") or die(mysqli_error($mysqli));

echo 1;