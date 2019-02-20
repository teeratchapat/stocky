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
            $cond = 'WHERE Manage_Date LIKE CURDATE()';
            break;
        case 'MONTH':
            $cond = 'WHERE MONTH(Manage_Date) LIKE MONTH(CURDATE())';
            break;
        case 'YEAR':
            $cond = 'WHERE YEAR(Manage_Date) LIKE YEAR(CURDATE())';
            break;
        default :
            $cond = '';

    }
}
else if (isset($_GET['sdate']) && $_GET['sdate']!=''){

    $xx = $_GET['sdate'];

    $cond = "WHERE Manage_Date >= '$xx'";
    if (isset($_GET['edate']) && $_GET['edate']!='') {
        $yy = $_GET['edate'];
        $cond = $cond." AND Manage_Date <= '$yy' ";
    }
}
else if (isset($_GET['edate']) && $_GET['edate']!=''){
    $yy = $_GET['edate'];
    $cond = "WHERE Manage_Date <= '$yy'";
}
else
{
    $cond = '';
}

//echo '<br/>';

$sql = "SELECT Manage_No,Manage_Date,PName,Manage_Amount,nickname FROM `product_manage` LEFT JOIN product  ON product_manage.PNo=product.PNo  LEFT JOIN user  ON product_manage.PeoNo=user.userNo $cond ORDER BY Manage_No ASC";
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
        tr.minus  td {
            color: red;

        }
        tr.add  td {
            color: green;

        }


    </style>
</head>


<body>
<div id="wrapper">
    <?php include('header.php'); ?>

    <div id="page-wrapper">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" style="align-content: center"> MANAGE TRANSACTIONS </h1>
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
                            <col width="20%">
                            <col width="10%">
                            <col width="10%">

                            <thead>
                            <tr>
                                <th style="text-align:center">No</th>
                                <th style="text-align:center">Date</th>
                                <th style="text-align:center">Name</th>
                                <th style="text-align:center">Quantity</th>
                                <th style="text-align:center">Staff</th>



                            </tr>
                            </thead>

                            <tbody >
                            <?php foreach ($rows as $row) {
                                if($row['Manage_Amount'] > 0){ ?>
                                    <tr align="center" class="add">
                                <?php }else {?>
                                    <tr align="center" class="minus">
                                <?php } ?>
                                    <td style="text-align:center"><?= $row['Manage_No'] ?></td>
                                    <td style="text-align:center"><?= date_format(date_create($row['Manage_Date']), 'd M Y') ?></td>
                                    <td style="text-align:center"><?= $row['PName'] ?></td>
                                    <td align="right"><?= $row['Manage_Amount'] ?></td>
                                    <td style="text-align:center"><?= $row['nickname'] ?></td>

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