<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require('../config.php');
require('../connect.php');
//require_once('../functions.php');
require('../vendor/autoload.php');
$want = 'MANAGER';
require('check_user.php');



if(isset($_POST['name'])) {


    if($_POST['name']=='')
        header('Location: manage.php');
    else
        $name = $_POST['name'];

    $sql = "select * from product_type where TName = '$name';";
    $num = $mysql_db->query($sql);
    $num = $num->rowCount();
    if($num == 0 ){
        $sql = "INSERT INTO `product_type` (`TNo`, `TName`) VALUES (NULL, '$name')";
        $stmt = $mysql_db->query($sql);
    }else{
//        echo "HHHH";
//        exit();
    }


    header('Location: manage.php');


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
        <h1 class="page-header" align="center">Add new product type</h1>

    </div>
    <div class="col-lg-12 " >
        <form action="type_new.php" method="post" >

            <div class="form-group input-group" >
                <input style="font-size: 30px;min-height: 50px;text-align:center" type="text" class="form-control" name="name" placeholder="Type name" autocomplete="off">
                <span class="input-group-btn text_modal">
                    <button class="btn btn-success text_modal" style="min-height: 50px" type="submit">ADD</button>
                </span>
            </div>






        </form>
    </div>
</div>


</body>