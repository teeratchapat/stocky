<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require('../config.php');
require('../connect.php');
require_once('../functions.php');
$want = 'MANAGER';
require('check_user.php');
if(isset($_GET['bill'])) {

    $bill = $_GET['bill'];

    $sql = "SELECT sellNo ,product.PName, SellAmount FROM sell,product WHERE sell.PNo = product.PNo AND BillNo = $bill";

    #excute statement
    $stmt = $mysql_db->query($sql);
    #get result
    $rows = $stmt->fetchAll();

    $sql = "SELECT BillDate,BillTotal,BillDiscount,BillCash,BillNote,nickname FROM `bill` LEFT JOIN user ON bill.PeoNo=user.userNo WHERE BillNo = $bill";
    $bill_detail = $mysql_db->query($sql);

    $bill_detail = $bill_detail->fetch();


//    print_r($bill_detail);
//    exit();

}
else{
    $bill = '';

    $rows = '';
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('style.php'); ?>
    <style>
        ul.tran-detail-title-list {
            color: #999999;
            /*display: inline-block;*/
            float: left;

            font-size: 20px;
            font-weight: normal;
            line-height: 33px;
            list-style: none outside none;
            margin: auto auto auto 0;
            padding: 0;
            text-align: left;
            text-transform: uppercase;
            width: 120px;
        }

        ul.tran-detail-title-list-items {
            color: #333;
            display: inline-block;
            float: left;
            font-family: 'noto_sansregular','Lucida Grande',sans-serif;
            font-size: 20px;
            font-weight: normal;
            line-height: 33px;
            list-style: none outside none;
            margin: auto auto auto 0;
            padding: 0;
            text-align: left;
            width: auto;
        }
    </style>
</head>


<body>
<div id="wrapper">
    <?php include('header.php'); ?>

    <div id="page-wrapper">



        <div class="row">
            <div class="col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <a class="btn btn-info btn-block" href="trad-trans.php" >View all Transaction</a>
                        <h1 class="page-header">Bill no.<?= $bill?></h1>
                        <ul class="tran-detail-title-list">
                            <li>Seller</li>
                            <li>Date</li>
                            <li>Total</li>
                            <li>Discount</li>
                            <li>Cash</li>

                        </ul>
                        <ul class="tran-detail-title-list-items">
                            <li><span ><?= $bill_detail['nickname']?></span></li>
                            <li><span ><?= $bill_detail['BillDate']?></span></li>
                            <li><span ><?= $bill_detail['BillTotal']?></span></li>
                            <li><span ><?= $bill_detail['BillDiscount']?></span></li>
                            <li><span ><?= $bill_detail['BillCash']?></span></li>

                        </ul>




                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" style="font-size: 20px">
                        NOTE
                    </div>
                    <div class="panel-body">
                        <p style="font-size: 20px"><?= $bill_detail['BillNote']?></p>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">
                        Bill Detail
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" >
                                <thead>
                                    <tr >
                                        <th style="text-align:center">No.</th>
                                        <th style="text-align:center">Product name</th>
                                        <th style="text-align:center">Quantity</th>

                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($rows as $row) { ?>
                                    <tr align="center">
                                        <td><?= $row[0] ?></td>
                                        <td><?= $row[1] ?></td>
                                        <td><?= $row[2] ?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                </div>


            </div>
        </div>



    </div>
</div>


<!-- jQuery -->
<script src="../vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="../vendor/metisMenu/metisMenu.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="../vendor/raphael/raphael.min.js"></script>
<script src="../vendor/morrisjs/morris.min.js"></script>
<script src="../data/morris-data.js"></script>

<!-- Custom Theme JavaScript -->
<script src="../dist/js/sb-admin-2.js"></script>

<!-- DataTables JavaScript -->
<script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
</body>