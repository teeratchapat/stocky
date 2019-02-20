<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require('../config.php');
require('../connect.php');
require_once('../functions.php');
$want = 'ADMIN';
require('check_user.php');

$sql = "SELECT userNo,username,nickname,status FROM `user` ";

#excute statement
$stmt = $mysql_db->query($sql);
#get result
$rows = $stmt->fetchAll();

if(isset($_POST['username'])){
    $username = $_POST['username'];
    $name = $_POST['name'];
    $status = $_POST['status'];
    $pass = $_POST['pass'];


    $sql = "select nickname from user where username = '$username';";
    $num = $mysql_db->query($sql);
    $num = $num->rowCount();
    if($num == 0 ){
        $sql = "INSERT INTO `user` (`userNo`, `username`, `nickname`, `password`, `status`) VALUES (NULL, '$username', '$name', '$pass', '$status');";
        $stmt = $mysql_db->query($sql);
    }else{
//        echo "HHHH";
//        exit();
    }
    header('Location: user.php');
}



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
                <h1 class="page-header" style="align-content: center">USER MANAGER</h1>
                <form method="post">
                    <div class="form-group row">
                        <div class="col-xs-3">
                            <input class="form-control" name="username" placeholder="username" autocomplete="off">
                        </div>
                        <div class="col-xs-3">

                            <input class="form-control" name="name" placeholder="name" autocomplete="off">
                        </div>
                        <div class="col-xs-2">

                            <input class="form-control" type="password" name="pass" placeholder="password">
                        </div>
                        <div class="col-xs-2">

                            <select name="status" class="form-control" >

                                <option value="CASHIER" >CASHIER</option>
                                <option value="MANAGER" >MANAGER</option>
                                <option value="ADMIN" >ADMIN</option>
                            </select>
                        </div>
                        <button class="btn btn-info" onclick="click_add()" >ADD USER</button>
                    </div>
                </form>

                <div class="panel-body">







                </div>

            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">
                        <b>User list</b>
                    </div>
                    <div class="panel-body" >

                        <table width="100%" class="table table-striped table-bordered  hover-table "
                               id="user-table" >


                            <!--                            <col width="5%">-->

                            <thead>
                            <tr >
                                <th style="text-align:center">Username</th>

                                <th style="text-align:center">Name</th>
                                <th style="text-align:center">Status</th>



                            </tr>
                            </thead>

                            <tbody >
                            <?php foreach ($rows as $row) { ?>
                                <tr onclick="click_user(<?= $row['userNo'] ?>)">

                                    <td style="text-align:center"><?= $row['username'] ?></td>
                                    <td style="text-align:center"><?= $row['nickname'] ?></td>
                                    <td style="text-align:center"><?= $row['status'] ?></td>


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
<div class="modal fade" id="user-info">
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
        $('#user-table').DataTable(
            {
                responsive: true

            });
    });

    function click_user(x) {
        // alert("HELLO");
        // window.location.href = "product_manage.php?no=" + x;
        $('#user-info').modal('show').find('.modal-body').load('user_edit.php?no='+x);
    }
</script>
</body>
