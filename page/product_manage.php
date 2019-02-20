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

    $sql = "SELECT PCode,PName,product.TNo,PPrice,PQuan,TName FROM `product` LEFT JOIN product_type ON product.TNo = product_type.TNo WHERE PCode LIKE '$no'";

    #excute statement
    $stmt = $mysql_db->query($sql);
    #get result
    $row = $stmt->fetch();
    $stmt = $mysql_db->query("SELECT * FROM product_type");
    #get result
    $type = $stmt->fetchAll();
//    print_r($type);

}
else{
    $bill = '';

    $rows = '';
}

if(isset($_POST['no'])) {

    $Pno = $_POST['no'];
    $name = $_POST['name'];
    if($_POST['type']=='')
        $type = '`TNo` = NULL';
    else
        $type = '`TNo` = '.$_POST['type'];
    $price = $_POST['price'];

    $sql = "UPDATE `product` SET `PName` = '$name', `PPrice` = '$price', $type WHERE `product`.`PCode` = '$Pno';";
//    echo $sql;
//    exit();

    $stmt = $mysql_db->query($sql);
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
        <h1 class="page-header" align="center">Product detail</h1>
        <img style="min-height: 50px;" src="data:image/png;base64,
        <?= base64_encode($generator->getBarcode($no, $generator::TYPE_CODE_128))?>">
        <p style="font-size: 30px">  <?= $no ?> </p>
    </div>
    <div class="col-lg-12 " >
        <form action="product_manage.php" method="post" >
            <div class="form-group input-group" >
                <span style="font-size: 30px" class="input-group-addon">Name</span>
                <input  style="font-size: 30px;min-height: 50px" type="text" class="form-control" name="name" value="<?= $row['PName'] ?>" autocomplete="off">
            </div>
            <div class="form-group input-group" >
                <span style="font-size: 30px" class="input-group-addon">Type</span>
                <select name="type" class="form-control" style="font-size: 30px;min-height: 50px">
                    <option value="">ไม่มีชนิดสินค้า</option>
                    <?php
                    foreach ($type as $t) {
                        if($t['TNo'] == $row['TNo'] ){?>
                            <option value="<?= $t['TNo']?>" selected><?= $t['TName']?></option>
                        <?php }else{ ?>
                            <option value="<?= $t['TNo']?>"><?= $t['TName']?></option>


                    <?php }} ?>
<!--                    <option value="1">1</option>-->
<!--                    <option value="2" selected>2</option>-->
<!--                    <option value="3">3</option>-->
<!--                    <option value="4">4</option>-->

                </select>
<!--                <input  style="font-size: 30px;min-height: 50px" type="text" class="form-control" name="type" value="--><?//= $row['TName'] ?><!--">-->
            </div>
            <div class="form-group input-group" >
                <span style="font-size: 30px" class="input-group-addon">Price</span>
                <input  style="font-size: 30px;min-height: 50px" type="text" class="form-control" name="price" value="<?= $row['PPrice'] ?>" autocomplete="off">
            </div>
            <div class="form-group input-group" >
                <span style="font-size: 30px" class="input-group-addon">Quantity</span>
                <input  style="font-size: 30px;min-height: 50px" type="text" class="form-control"  value="<?= $row['PQuan'] ?>" disabled>
            </div>

            <input name="no" value="<?= $no ?>" hidden>

            <button style="font-size: 25px" type="submit" class="btn btn-success btn-block">Update</button>
            <button style="font-size: 25px" type="button" onclick="click_add(<?= $no ?>)" class="btn btn-info btn-block">Add quantity</button>

        </form>
    </div>
</div>


</body>

<script>
    function click_add(x) {
        // window.location.href = "product_manage.php?no=" + x;
        $('#product_info').modal('show').find('.modal-body').load('product_add.php?no='+x);
    }
</script>