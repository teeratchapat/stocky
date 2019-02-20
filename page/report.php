<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require('../config.php');
require('../connect.php');
require_once('../functions.php');
$want = 'MANAGER';
require('check_user.php');
$sql = "SELECT YEAR(bill.BillDate) Year, SUM(bill.BillTotal) Total,SUM(bill.BillDiscount) Discount FROM bill GROUP BY YEAR(bill.BillDate)";
//echo $sql;
#excute statement
$stmt = $mysql_db->query($sql);
#get result
$year_rows = $stmt->fetchAll();

$sql = "SELECT YEAR(bill.BillDate) Year, MONTH(bill.BillDate) Month, SUM(bill.BillTotal) Total,SUM(bill.BillDiscount) Discount FROM bill GROUP BY YEAR(bill.BillDate), MONTH(bill.BillDate) ORDER BY 1,2";
//echo $sql;
#excute statement
$stmt = $mysql_db->query($sql);
#get result
$month_rows = $stmt->fetchAll();

$sql = "SELECT BillDate,SUM(BillTotal)BillTotal,SUM(BillDiscount)BillDiscount From bill GROUP BY bill.BillDate";
//echo $sql;
#excute statement
$stmt = $mysql_db->query($sql);
#get result
$day_rows = $stmt->fetchAll();


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('style.php'); ?>
</head>


<body>
<div id="wrapper">
    <?php include('header.php'); ?>

    <div id="page-wrapper">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" style="align-content: center">Report</h1>

            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" align="center">
                                <b>Year</b>
                            </div>
                            <div class="panel-body">
                                <table width="100%" class="table table-striped table-bordered  hover-table">
                                    <col width="20%">
                                    <col width="40%">
                                    <col width="40%">

                                    <thead>
                                    <tr>
                                        <th style="text-align:center">Year</th>
                                        <th style="text-align:center">Total</th>
                                        <th style="text-align:center">Discount</th>

                                    </tr>
                                    </thead>

                                    <tbody >
                                    <?php foreach ($year_rows as $row) { ?>

                                        <td style="text-align:center"><?= $row['Year'] ?></td>
                                        <td style="text-align:center"><?= $row['Total'] ?></td>
                                        <td style="text-align:center"><?= $row['Discount'] ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" align="center">
                                <b>Month</b>
                            </div>
                            <div class="panel-body">
                                <table width="100%" class="table table-striped table-bordered  hover-table">
                                    <col width="20%">
                                    <col width="20%">
                                    <col width="30%">
                                    <col width="30%">

                                    <thead>
                                    <tr>
                                        <th style="text-align:center">Year</th>
                                        <th style="text-align:center">Month</th>
                                        <th style="text-align:center">Total</th>
                                        <th style="text-align:center">Discount</th>

                                    </tr>
                                    </thead>

                                    <tbody >
                                    <?php foreach ($month_rows as $row) { ?>

                                        <td style="text-align:center"><?= $row['Year'] ?></td>
                                        <td style="text-align:center"><?= $row['Month'] ?></td>
                                        <td style="text-align:center"><?= $row['Total'] ?></td>
                                        <td style="text-align:center"><?= $row['Discount'] ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">
                        <b>Date</b>
                    </div>
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered  hover-table"
                               id="day_report">
                            <col width=30%">
                            <col width="35%">
                            <col width="35%">

                            <thead>
                            <tr>
                                <th style="text-align:center">Date</th>
                                <th style="text-align:center">Total</th>
                                <th style="text-align:center">Discount</th>

                            </tr>
                            </thead>

                            <tbody >
                            <?php foreach ($day_rows as $row) { ?>

                                <td style="text-align:center"><?= $row['BillDate'] ?></td>
                                <td style="text-align:center"><?= $row['BillTotal'] ?></td>
                                <td style="text-align:center"><?= $row['BillDiscount'] ?></td>
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

        $('#day_report').DataTable(
            {
                responsive: true

            });

</script>
</body>