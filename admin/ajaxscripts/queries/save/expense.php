<?php
include('../../../config.php');
include("../../../functions.php");

$username = $_SESSION['username'];
$dateofexpense = mysqli_real_escape_string($mysqli, $_POST['dateofexpense']);
$amount = mysqli_real_escape_string($mysqli, $_POST['amount']);
$paymentmode = mysqli_real_escape_string($mysqli, $_POST['paymentmode']);
$expcategory = mysqli_real_escape_string($mysqli, $_POST['expcategory']);
$receipient = mysqli_real_escape_string($mysqli, $_POST['receipient']);
$approvedby = mysqli_real_escape_string($mysqli, $_POST['approvedby']);
$reasonforpayment = mysqli_real_escape_string($mysqli, $_POST['reasonforpayment']);
$description = mysqli_real_escape_string($mysqli, $_POST['description']);


                $saveconfig = $mysqli->query("INSERT INTO `expenses`
                (
                `expdate`,
                `amount`,
                `paymentmode`,
                `expcatid`,
                `receipient`,
                `approvedby`,
                `reason`,
                `description`,
                `user`,
                `datetime`)
                VALUES
                 (
                '$dateofexpense',
                '$amount',
                '$paymentmode',
                '$expcategory',
                '$receipient',
                '$approvedby',
                '$reasonforpayment',
                '$description',
                '$username',
                '$datetime')") or die(mysqli_error($mysqli));   
                
                
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
                'Expenses',
                'Added an expense of $amount using the date $dateofexpense',
                '$username',
                '$mac_address',
                '$ip_add',
                'Successful')") or die(mysqli_error($mysqli));

                                        echo 1; 


         
                    
                    
                   