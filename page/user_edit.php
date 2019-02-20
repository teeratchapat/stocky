<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require('../config.php');
require('../connect.php');
//require_once('../functions.php');
require('../vendor/autoload.php');
$want = 'ADMIN';
require('check_user.php');



if(isset($_GET['no'])) {

    $no = $_GET['no'];

    $sql = "SELECT userNo,username,nickname,status FROM `user` WHERE userNo = $no";

    #excute statement
    $stmt = $mysql_db->query($sql);
    #get result
    $row = $stmt->fetch();

//    print_r($type);

}
else{
    $bill = '';

    $rows = '';
}

if(isset($_POST['no'])) {

    $no=$_POST['no'];
    $username = $_POST['username'];
    $name = $_POST['name'];
    $status = $_POST['status'];
    $pass = $_POST['pass'];

    if($_POST['pass']=='')
        $pass = '';
    else
        $pass = ',`password` = '."'".$_POST['pass']."'";


    $sql = "UPDATE `user` SET `username` = '$username', `nickname` = '$name', `status` = '$status' $pass WHERE `userNo` = '$no';";
//    echo $sql;
//    exit();

    $stmt = $mysql_db->query($sql);
    header('Location: user.php');


}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('style.php'); ?>
    <style>

    </style>
</head>


<body>
<div class="row">
    <div class="col-lg-12 " style="vertical-align:middle;text-align:center">
        <h1 class="page-header" align="center">User detail</h1>

    </div>
    <div class="col-lg-12 " >
        <form action="user_edit.php" method="post" >
            <div class="form-group input-group" >
                <span style="font-size: 30px" class="input-group-addon">Username</span>
                <input  style="font-size: 30px;min-height: 50px" type="text" class="form-control" name="username" value="<?= $row['username'] ?>" autocomplete="off">
            </div>
            <div class="form-group input-group" >
                <span style="font-size: 30px" class="input-group-addon">Name</span>
                <input  style="font-size: 30px;min-height: 50px" type="text" class="form-control" name="name" value="<?= $row['nickname'] ?>" autocomplete="off">
            </div>
            <div class="form-group input-group" >
                <span style="font-size: 30px" class="input-group-addon">Type</span>
                <select name="status" class="form-control" style="font-size: 30px;min-height: 50px">

                    <option value="CASHIER" <?php if(strcmp($row['status'],'CASHIER') == 0)echo 'selected'?>>CASHIER</option>
                    <option value="MANAGER" <?php if(strcmp($row['status'],'MANAGER') == 0)echo 'selected'?>>MANAGER</option>
                    <option value="ADMIN" <?php if(strcmp($row['status'],'ADMIN') == 0)echo 'selected'?>>ADMIN</option>
                </select>
<!--                <input  style="font-size: 30px;min-height: 50px" type="text" class="form-control" name="type" value="--><?//= $row['TName'] ?><!--">-->
            </div>

            <div class="form-group input-group" >
                <span style="font-size: 30px" class="input-group-addon">Password</span>
                <input  name ="pass" style="font-size: 30px;min-height: 50px" type="password" class="form-control" placeholder="password">
            </div>

            <input name="no" value="<?= $no ?>" hidden>

            <button style="font-size: 25px" type="submit" class="btn btn-success btn-block">Update</button>

        </form>
    </div>
</div>



</body>

<script>

</script>