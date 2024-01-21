<?php
include('config.php');
include('admin/functions.php');

$fullname = mysqli_real_escape_string($mysqli, $_POST['fullname']);
$email = mysqli_real_escape_string($mysqli, $_POST['email']);
$phone = mysqli_real_escape_string($mysqli, $_POST['phone']);
$msg_subject = mysqli_real_escape_string($mysqli, $_POST['msg_subject']);
$message = mysqli_real_escape_string($mysqli, $_POST['message']);
$checkboxValue = mysqli_real_escape_string($mysqli, $_POST['checkboxValue']);


$saveconfig = $mysqli->query("INSERT INTO client_messages (fullname, email, phone, msg_subject, message, periodsent, checkboxValue) 
VALUES ('$fullname', '$email', '$phone', '$msg_subject', '$message', NOW(), '$checkboxValue')");

$mysqli->query("INSERT INTO `logs` (
`logdate`,
`section`,
`message`,
`user`,
`macaddress`,
`ipaddress`,
`action`)
VALUES (
'NOW()',
'Client Message',
'Client sent a message on contact form',
'',
'$mac_address',
'$ip_add',
'Successful')") or die(mysqli_error($mysqli));

echo 1;
