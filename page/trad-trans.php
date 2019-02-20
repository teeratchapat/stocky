<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require('../config.php');
require('../connect.php');
require_once('../functions.php');
$want = 'ADMIN';
require('check_user.php');
if(isset($_GET['date'])){
    $date = $_GET['date'];
    switch ($date){
        case 'TODAY':
            $cond = 'WHERE BillDate LIKE CURDATE()';
            break;
        case 'MONTH':
            $cond = 'WHERE MONTH(BillDate) LIKE MONTH(CURDATE())';
            break;
        case 'YEAR':
            $cond = 'WHERE YEAR(BillDate) LIKE YEAR(CURDATE())';
            break;
        default :
            $cond = '';

    }
}
else if (isset($_GET['sdate']) && $_GET['sdate']!=''){

    $xx = $_GET['sdate'];

    $cond = "WHERE BillDate >= '$xx'";
    if (isset($_GET['edate']) && $_GET['edate']!='') {
        $yy = $_GET['edate'];
        $cond = $cond." AND BillDate <= '$yy' ";
    }
}
else if (isset($_GET['edate']) && $_GET['edate']!=''){
    $yy = $_GET['edate'];
    $cond = "WHERE BillDate <= '$yy'";
}
else
{
    $cond = '';
}

//echo '<br/>';

$sql = "SELECT BillNo,BillDate,BillTotal,BillDiscount,BillCash,BillNote,nickname FROM `bill` LEFT JOIN user ON bill.PeoNo=user.userNo $cond ORDER BY BillNo ASC";
//echo $sql;
#excute statement
$stmt = $mysql_db->query($sql);
#get result
$rows = $stmt->fetchAll();



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


    </style>
</head>


<body>
<div id="wrapper">
    <?php include('header.php'); ?>

    <div id="page-wrapper">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" style="align-content: center"> TRADING TRANSACTIONS </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel-body ">
                    <form method="get">
                        <input class="btn btn-success" type="submit" name="date" value="ALL"/>
                        <input class="btn btn-success" type="submit" name="date" value="TODAY"/>
                        <input class="btn btn-success" type="submit" name="date" value="MONTH"/>
                        <input class="btn btn-success" type="submit" name="date" value="YEAR"/>
<!--                        <div class="form-group col-xs-2">-->
                            <span>Start date </span><input style="max-width: 100px" type="text" name='sdate' id="start-date" />
                            <span>End date </span><input style="max-width: 100px"  type="text" name="edate" id="end-date" />
<!--                        </div>-->


                        <button class="btn btn-success" type="submit" id="custom-date">CUSTOM</button>
                    </form>


                </div>

            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">
                        <b>Transactions</b>
                    </div>
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered  hover-table"
                               id="bill-table">
                            <col width="5%">
                            <col width="10%">
                            <col width="10%">
                            <col width="10%">
                            <col width="10%">
                            <col width="10%">

                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Discount</th>
                                <th>Cash</th>
                                <th>Seller</th>
                                <th>Note</th>


                            </tr>
                            </thead>

                            <tbody>
                            <?php foreach ($rows as $row) { ?>
                                <tr onclick="click_bill(<?= $row['BillNo'] ?>)" align="center">
                                    <td><?= $row['BillNo'] ?></td>
                                    <td><?= date_format(date_create($row['BillDate']), 'd M Y') ?></td>
                                    <td align="right"><?= $row['BillTotal'] ?></td>
                                    <td align="right"><?= $row['BillDiscount'] ?></td>
                                    <td align="right"><?= $row['BillCash'] ?></td>
                                    <td style="text-align: center;"><?=  $row['nickname']?></td>
                                    <td><?= $row['BillNote'] ?></td>
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

<script src="../vendor/datepicker/bootstrap-datepicker.js"></script>

<script>
    $(document).ready(function () {
        $('#bill-table').DataTable(
            {
                responsive: true

            });



        $('#start-date').datepicker({
            format : 'yyyy/mm/dd'

        });
        $('#end-date').datepicker({
            format : 'yyyy/mm/dd'
        });



    });

    $(document).on("click", "#custom-date", function () {

        $('#choose-date').modal();
    });

    function click_bill(x) {
        window.location.href = "bill_detail.php?bill=" + x;
    }


</script>
</body>
</html>