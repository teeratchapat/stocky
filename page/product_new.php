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

do{
    $rand = rand(0,9);

    for($i=0; $i<9; $i++) {
        $rand .= rand(0,9);
    }
    $sql = "select * from product where PNo like '$rand';";
    $num = $mysql_db->query($sql);
    $num = $num->rowCount();
}while( $num > 0);

$stmt = $mysql_db->query("SELECT * FROM product_type");
#get result
$type = $stmt->fetchAll();


if(isset($_POST['name'])) {


    $name = $_POST['name']  ;
    if($_POST['type']=='')
        $type = 'NULL';
    else
        $type = $_POST['type'];
    $price = $_POST['price'];
    $quan = $_POST['quan'];

    $sql = "INSERT INTO `product` (`PNo`, `PCode`, `PName`, `PPrice`, `PQuan`, `TNo` ) VALUES (NULL, '$rand', '$name', '$price', '$quan', $type);";
//    $sql = "INSERT INTO `product`  `PName` = '$name', `PPrice` = '$price', $type WHERE `product`.`PCode` = '$Pno';";
//    echo $sql;
//    exit();

    $stmt = $mysql_db->query($sql);
    $last_order_id = $mysql_db->lastInsertId();
    $sql = "INSERT INTO `product_manage` (`Manage_No`, `Manage_Date`, `PNo`, `PeoNo`, `Manage_Amount`) VALUES (NULL, CURRENT_DATE(), '$last_order_id', $ses_userNo, '$quan')";
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
        <h1 class="page-header" align="center">Add new product</h1>
        <img style="min-height: 50px;" src="data:image/png;base64,
        <?= base64_encode($generator->getBarcode($rand, $generator::TYPE_CODE_128))?>">
        <p style="font-size: 30px">  <?= $rand ?> </p>
    </div>
    <div class="col-lg-12 " >
        <form action="product_new.php" method="post" >
            <div class="form-group input-group" >
                <span style="font-size: 30px" class="input-group-addon">Name</span>
                <input  style="font-size: 30px;min-height: 50px" type="text" class="form-control" name="name" placeholder="name" autocomplete="off">
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
                <input  style="font-size: 30px;min-height: 50px" type="text" class="form-control" name="price" placeholder="price" autocomplete="off">
            </div>
            <div class="form-group input-group" >
                <span style="font-size: 30px" class="input-group-addon">Quantity</span>
                <input  style="font-size: 30px;min-height: 50px" type="text" class="form-control" name="quan" placeholder="quantity" autocomplete="off">
            </div>

            <button style="font-size: 25px" type="submit" class="btn btn-success btn-block">SUBMIT</button>


        </form>
    </div>
</div>


</body>

<script>

</script>