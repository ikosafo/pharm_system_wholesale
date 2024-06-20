<?php
include('../../../config.php');
include("../../../functions.php");

$username = $_SESSION['username'];
$currentpassword = md5($_POST['currentpassword']);
$newpassword = md5($_POST['newpassword']);
$confirmpassword = $_POST['confirmpassword'];

$getmainuser = $mysqli->query("select * from system_config where username = '$username'");

//if user is admin
if (mysqli_num_rows($getmainuser) == '1') {
 
        $resmainuser = $getmainuser->fetch_assoc();
        $currpassword = $resmainuser['password'];

        //if password for admin is same
        if ($currpassword == $currentpassword) {

                $editpassword = $mysqli->query("UPDATE `system_config`
                SET `password` = '$newpassword' WHERE `username` = '$username'");

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
                'Reset Admin Password',
                '$username updated password successfully',
                '$username',
                '$mac_address',
                '$ip_add',
                'Successful')") or die(mysqli_error($mysqli));  

                echo 1;
        }

        //if password for admin is not equal
        else {
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
                        'Reset Admin Password',
                        'Reset Admin Password error',
                        '$username',
                        '$mac_address',
                        '$ip_add',
                        'Failed')") or die(mysqli_error($mysqli));  
                echo 2;
        }
        
} 

// if user is not admin but staff
else {
 
        $checkpassword = $mysqli->query("select * from staff where username = '$username'");
        $respassword = $checkpassword->fetch_assoc();
        $currpassword = $respassword['password'];

        // if password is equal
        if ($currpassword == $currentpassword) {

                $editpassword = $mysqli->query("UPDATE `staff`
                SET `password` = '$newpassword' WHERE `username` = '$username'");

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
                        'Reset Password',
                        '$username updated password successfully',
                        '$username',
                        '$mac_address',
                        '$ip_add',
                        'Successful')") or die(mysqli_error($mysqli));  
                echo 1;
        }

        // if password is not equal
        else {
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
                        'Reset Password',
                        'Reset Password error',
                        '$username',
                        '$mac_address',
                        '$ip_add',
                        'Failed')") or die(mysqli_error($mysqli));  
                echo 2;
        }
        
}












        
