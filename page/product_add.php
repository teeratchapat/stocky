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
$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();


if(isset($_GET['no'])) {

    $no = $_GET['no'];

    $sql = "SELECT PName FROM `product` WHERE PCode LIKE '$no'";

    #excute statement
    $stmt = $mysql_db->query($sql);
    #get result
    $row = $stmt->fetch();


}
else{
    $bill = '';

    $rows = '';
}

if(isset($_POST['pno'])) {

    $pno = $_POST['pno'];
    if($_POST['quan']=='')
        header('Location: manage.php');
    else
        $quan = $_POST['quan'];
    $sql = "UPDATE `product` SET `PQuan` = PQuan+$quan WHERE `product`.`PCode` = $pno";
    $stmt = $mysql_db->query($sql);



    $date = date('Y-m-d');
    $sql ="SELECT PNo FROM Product WHERE PCode LIKE $pno";

    echo $sql;
    $pno = $mysql_db->query($sql);
    $pno = $pno->fetch();

//    echo $pno;
//    print_r($pno);
    $pno = $pno[0];
//    print_r($pno);
    $sql = "INSERT INTO `product_manage` (`Manage_No`, `Manage_Date`, `PNo`, `PeoNo`, `Manage_Amount`) VALUES (NULL, CURRENT_DATE(), '$pno', $ses_userNo, '$quan')";
//    echo $sql;
//    exit();
    $stmt = $mysql_db->query($sql);
//    $sql = "UPDATE `product` SET `PQuan` = PQuan + $quan WHERE `product`.`PNo` = $pno";
//    $stmt = $mysql_db->query($sql);
//    echo $sql;
//    exit();


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
        <h1 class="page-header" align="center">Add <?= $row['PName']?> quantity</h1>

    </div>
    <div class="col-lg-12 " >
        <form action="product_add.php" method="post" >

            <div class="form-group input-group" >
                <input name="pno" value="<?= $no ?>" hidden>
                <input style="font-size: 30px;min-height: 50px;text-align:center" type="number" class="form-control" name="quan" value="" >
                <span class="input-group-btn text_modal">
                    <button class="btn btn-success text_modal" style="min-height: 50px" type="submit">ADD</button>
                </span>
            </div>






        </form>
    </div>
</div>


</body>