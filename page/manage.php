<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require('../config.php');
require('../connect.php');
require_once('../functions.php');
require('../vendor/autoload.php');
$want = 'MANAGER';
require('check_user.php');
$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
//$barcode = '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode('081231723897', $generator::TYPE_CODE_128)) . '">';

$sql = "SELECT PCode,PName,PPrice,PQuan,TName FROM `product` LEFT JOIN product_type ON product.TNo = product_type.TNo";

#excute statement
$stmt = $mysql_db->query($sql);
#get result
$rows = $stmt->fetchAll();
//print_r($rows);
//exit();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('style.php'); ?>
    <style>
        table.hover-table tr:hover td {
            color: #4cae4c;
            cursor: pointer;
        }

        .modal {
            text-align: center;
            padding: 0!important;
        }

        .modal:before {
            content: '';
            display: inline-block;
            height: 100%;
            vertical-align: middle;
            margin-right: -4px;
        }

        .modal-dialog {
            display: inline-block;
            text-align: left;
            vertical-align: middle;
        }


    </style>
</head>


<body>
<div id="wrapper">
    <?php include('header.php'); ?>

    <div id="page-wrapper">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" style="align-content: center">MANAGE</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <button class="btn btn-info btn-block" onclick="click_add()" >ADD NEW PRODUCT</button>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <button class="btn btn-info btn-block" onclick="click_type()">ADD NEW TYPE</button>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">
                        <b>Product list</b>
                    </div>
                    <div class="panel-body" >


                        <table width="100%" class="table table-striped table-bordered  hover-table"
                               id="product-table" >
                            <col width="20%">
                            <col width="20%">
                            <col width="10%">
                            <col width="10%">
                            <col width="10%">
<!--                            <col width="5%">-->

                            <thead>
                            <tr >
                                <th style="text-align:center">Barcode</th>

                                <th style="text-align:center">Name</th>
                                <th style="text-align:center">Type</th>
                                <th style="text-align:center">Price</th>
                                <th style="text-align:center">Quantity</th>


                            </tr>
                            </thead>

                            <tbody >
                            <?php foreach ($rows as $row) { ?>
                                <tr onclick="click_product(<?= $row['PCode'] ?>)">
                                    <td style="horiz-align:center;text-align:center">
                                        <img src="data:image/png;base64,<?= base64_encode($generator->getBarcode($row['PCode'], $generator::TYPE_CODE_128))?>
                                        "><p >  <?= $row['PCode'] ?> </p></td>
                                    <td style="vertical-align:middle;"><?= $row['PName'] ?></td>
                                    <td style="vertical-align:middle;"><?= $row['TName'] ?></td>
                                    <td style="vertical-align:middle;text-align:right"><?= $row['PPrice'] ?></td>
                                    <td style="vertical-align:middle;text-align:right"><?= $row['PQuan'] ?></td>


                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>


        </div>

    </div>
</div>

<div class="modal fade" id="product_info">
    <div class="modal-dialog ">
        <div class="modal-content">


            <!-- Modal Header -->
<!--            <div class="modal-header">-->
<!--                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
<!--                <h4 class="modal-title" id="myModalLabel">Product Detail</h4>-->
<!--            </div>-->
            <!-- Modal body -->
            <div class="modal-body " >


            </div>

            <!-- Modal footer -->


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

<script>
    $(document).ready(function() {
        $('#product-table').DataTable(
            {
                responsive: true

            });
    });

    function click_product(x) {
        // window.location.href = "product_manage.php?no=" + x;
        $('#product_info').modal('show').find('.modal-body').load('product_manage.php?no='+x);
    }

    function click_add() {
        // window.location.href = "product_manage.php?no=" + x;
        $('#product_info').modal('show').find('.modal-body').load('product_new.php');
    }

    function click_type() {
        // window.location.href = "product_manage.php?no=" + x;
        $('#product_info').modal('show').find('.modal-body').load('type_new.php');
    }


</script>
</body>