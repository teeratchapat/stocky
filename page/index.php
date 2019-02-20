<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require('../config.php');
require('../connect.php');
require_once('../functions.php');
$want = 'CASHIER';
require('check_user.php');
$sql = "SELECT PCode,PName FROM `product` ";

#excute statement
$stmt = $mysql_db->query($sql);
#get result
$rows = $stmt->fetchAll();

// var_dump($_SESSION["cart_product"][15]);
// exit();
//print_r($rows);
$item_total = 0;
//print ("After Sort");
//print_r($rows);
//exit();

if(isset($_GET['search'])){
    ?>
    <script>
        alert("<?= $_GET['search'] ?>")
    </script>
<?php
}
if(isset($_GET['opt']))
{
    if($_GET['opt']=='cart'){
        /*
         * process cart operation
         */
        $action = $_GET['action'];
        if ($action == 'empty') {
            empty_cart();
        } else if($action == 'add'){
            $code = $_GET['code'];
            cart_operation($mysql_db,'product',$action,$code);
            //empty_cart();
        } else if($action == 'remove'){

            $code = $_GET['code'];
            cart_operation($mysql_db,'product',$action,$code);
        } else if($action == 'update') {

            foreach ($_SESSION["cart_product"] as $item) {
                $no = $item['no'];

                update_product($no, $_GET['qtn'.$no]);
//            $_SESSION["cart_product"][$no]['quantity'] = $_GET['qtn'.$no];
            }
        }
    }

}

if(isset($_POST['opt']))
{
    if($_POST['opt']=='confirm'){
        $note="";
        if (isset($_POST['note'])) {
            $note = $_POST['note'];
        }

        $disc = $_POST['n_disc'];
        $cash = $_POST['n_cash'];
        //$date = 'CURDATE()';
        $total = $_POST['total'];
        //echo $item_total;
        $s = "INSERT INTO bill (BillNo, BillDate, PeoNo, BillNote, BillDiscount, BillTotal, BillCash) VALUES (NULL, CURRENT_DATE(), $ses_userNo, '$note', '$disc', '$total','$cash');";
//        var_dump($s);
//        print($s);
        $num = $mysql_db->query($s);

        $last_order_id = $mysql_db->lastInsertId();
        //echo $last_order_id;

        $prods = get_cart_products();
        $i = 0;
        foreach ( $prods as $prod) {
            $pid = $prod['no'];
            $qty = $prod['quantity'];
            $i=$i+1;


            $sql = "INSERT INTO `sell` (`SellNo`, `PNo`, `BillNo`, `SellAmount`) VALUES ($i, '$pid', '$last_order_id', '$qty');";
            $num = $mysql_db->exec($sql);

            $sql = "UPDATE `product` SET `PQuan` = PQuan - $qty WHERE `product`.`PNo` = $pid";
            $num = $mysql_db->exec($sql);
        }





        empty_cart();


}
}


//print_r($_SESSION["cart_product"]);
//exit();

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <?php include('style.php'); ?>

    <style>

        table.hover-table  tr:hover td {
            color: #4cae4c;
            cursor: pointer;
        }



        .grandtotal {
            background-color: #333;
            height: 100%;
            min-width: 270px;
            padding: 11px 10px 10px;
            float: right;
            text-align: left;
            margin-right: 118px;
            -webkit-border-radius: 3px;
            border-radius: 3px;
            position: relative;

        }

        .grandtotal h2 {
            color: #999999;
            float: left;
            font-family: 'noto_sansregular','Lucida Grande',sans-serif;
            font-size: 16px;
            font-weight: normal;
            line-height: 18px;
            margin: auto auto auto auto;
            padding-left: 5px;
            padding-top: 1px;
            text-align: left;
            width: 45px;
        }

        .grandtotal h1 {
            color: #fff;
            font-family: 'noto_sansregular', 'Lucida Grande', sans-serif;
            font-size: 40px;
            line-height: 100%;
            font-weight: normal;
            text-transform: uppercase;
            margin: auto;
            text-align: center;

            margin-top: -2px;
            float: left;

        }

        .pay-button1 {
            background-color: #20BF25;
            border: 0 none;
            border-radius: 3px;
            color: #FFFFFF;
            cursor: pointer;
            float: right;
            font-family: 'noto_sansregular', 'Lucida Grande', sans-serif;
            font-size: 21px;
            font-weight: normal;
            font-style: normal;
            height: 38px;
            line-height: 21px;
            outline: medium none;
            padding: 8px 9px 10px 10px;
            /*position: absolute;*/
            right: 10px;
            text-align: center;
            text-decoration: none;
            text-transform: uppercase;
            top: 10px;

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

        .text_modal{

            font-size: 30px;
        }

        .payinput{
            font-size: 40px;
            min-height: 60px;
            text-align: right;
        }
    </style>
</head>

<body>

    <div id="wrapper">
        <?php include('header.php'); ?>

        <div id="page-wrapper">

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header" style="align-content: center">CASHIER</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6" >
                    <div class="panel panel-default">
                        <div class="panel-heading" align="center">
                            <b>Product list</b>
                        </div>
                        <div class="panel-body" >


                            <table width="100%" class="table table-striped table-bordered  hover-table"
                                   id="product-table" >
                                <col width="20%">
                                <col width="80%">
                                <thead>
                                <tr>
                                    <th>Barcode</th>
                                    <th>Name</th>

                                </tr>
                                </thead>

                                <tbody >
                                <?php foreach ($rows as $row) { ?>

                                    <tr onclick="click_product(<?= $row['PCode'] ?>)">
                                        <td><?= $row['PCode'] ?></td>
                                        <td><?= $row['PName'] ?></td>
                                    </tr>
                                <?php } ?>

                                <!-- <?php foreach ($rows as $row) { 
                                    echo "
                                    <tr >
                                        <td>{$row['PCode']}</td>
                                        <td>{$row['PName']}</td>
                                    </tr>";
                                } ?> -->
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                <!-- end product list -->

                <div class="col-lg-6" >
                    <div class="row" >
                        <div class="col-lg-12" ">
                            <div class="panel panel-default" >
                                <div class="panel-heading" align="center">
                                    <b>Order list</b>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">

                                        <table class="table table-striped" style="alignment: center;margin-bottom: 0px">

                                            <col width="30%">
                                            <col width="35%">
                                            <col width="15%">
                                            <col width="15%">
                                            <col width="5%">
                                            <form method="get" >
                                                <input type="hidden" name="opt" value="cart">
                                                <input type="hidden" name="action" value="update">
                                            <thead>
                                            <tr >
                                                <th>Barcode</th>
                                                <th style="text-align:left">Name</th>
                                                <th style="text-align:right">Price</th>
                                                <th style="text-align:center">Quantity</th>
                                                <th></th>
                                            </tr>
                                            </thead>

                                            <tbody>

                                            <?php
                                            if (isset($_SESSION["cart_product"])) {
                                                $item_total = 0;
                                                foreach ($_SESSION["cart_product"] as $item) {
                                                    $item_total += $item["quantity"]*$item['price'];
                                                    if (true) {?>
                                                        <tr >
                                                            <td style="vertical-align:middle;"><?= $item['code']?></td>
                                                            <td style="vertical-align:middle;"><?= $item['name']?></td>
                                                            <td style="vertical-align:middle;" align=right><?= $item['price']?></td>
                                                            <td align="center">

                                                                <input style="text-align:center;width: 50%;padding-right: 0px" type="number"
                                                                       class="form-control" name="qtn<?= $item['no'] ?>" autocomplete="off"
                                                                       value="<?= $item['quantity']?>" min="0">


                                                            </td>
<!--                                                            <td style="vertical-align:middle;" align=center>--><?//= $item['quantity']?><!--</td>-->
                                                            <td style="vertical-align:middle;" align=left><button onclick="remove_product(<?= $item['code']?>)" type="button" class="btn btn-danger btn-circle"><i class="fa fa-times"></i>
                                                                </button></td>
                                                        </tr>
                                                    <?php }} ?>
                                                <tfoot>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td style="vertical-align:middle;" align=middle><button  type="submit" class="btn btn-info">Update <i class="fa fa-refresh"></i>
                                                        </button></td>
                                                    <td style="vertical-align:middle;" align=left><button onclick="empty()" type="button" class="btn btn-danger"><i class="fa fa-trash"></i>
                                                        </button></td>
                                                </tr>
                                                </tfoot>
                                           <?php } ?>



                                            </form>
                                            </tbody>


                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>


                            </div>
                        </div>
                        <div class="col col-lg-12" style="margin-top: 0px;padding-top: 0px ;">

                            <div class="panel panel-default" >
                                <form method="get">
                                    <div class="panel-body">
                                        <div class="form-group input-group ">
                                            <span id="TEST_TOTAL"class="input-group-addon text_modal" >TOTAL</span>
                                            <input id="total"type="number" class="form-control payinput" style="color: ;" value="<?= $item_total?>" disabled>
                                        </div>

                                        <div class="form-group input-group" >
                                            <span class="input-group-addon text_modal" >DISCOUNT</span>
                                            <input name="discount" type="number" id="discount"class="form-control payinput" min="0" value="0">
                                        </div>

                                        <div class="form-group input-group" >
                                            <span class="input-group-addon text_modal" >CASH</span>
                                            <input name="cash" type="number" id="cash" class="form-control payinput" min="0" value="0" placeholder="">
                                            <span class="input-group-btn text_modal" >
                                                <button id="exact" class="btn btn-secondary text_modal" style="min-height: 60px" type="button">Exact</button>

                                            </span>
                                        </div>

                                        <button type="button" id="click-pay" class="btn pay-button1" style="min-width: 200px" >
                                            PAY
                                        </button>
                                    </div>



                                </form>




                            </div>







                            <div class="modal fade" id="paymodal">
                                <div class="modal-dialog ">
                                    <div class="modal-content">


                                        <!-- Modal Header -->


                                        <!-- Modal body -->
                                        <div class="modal-body " >

                                            <form method="post" >
                                            <div class="row">

                                                <div class="col-lg-6">
                                                    <h2 >Total: <?= $item_total?></h2>
                                                    <h2 id="modal_disc" >Discount: </h2>
                                                    <h2 id="modal_cash">Cash: </h2>
                                                    <h2 id="modal_balance">Balance: </h2>

                                                </div>
                                                <div class="col-lg-6">
                                                    <h2 style="font-size: 20px">NOTE</h2>
                                                    <textarea class="form-control" rows="7" name="note"></textarea>
                                                    <input type="hidden" name="opt" value="confirm">
                                                    <input type="hidden" id="i_disc" name="n_disc" >
                                                    <input type="hidden" id="i_cash" name="n_cash" >
                                                    <input type="hidden"  name="total" value="<?= $item_total ?>" >
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 text-center" style="min-width: 200px">
                                                    <button  type="submit" class="btn btn-success" style="background-color: #20BF25;">CONFIRM</button>
                                                </div>
                                            </div>

                                            </form>







                                        </div>

                                        <!-- Modal footer -->


                                    </div>
                                </div>
                            </div>

                        </div>




<!--                        <div class="col col-lg-12">-->
<!--                            <div class="panel panel-default" >-->
<!---->
<!--                                --><?php //print_r($_SESSION["cart_product"]) ;echo($item_total)?>
<!--                            </div>-->
<!--                        </div>-->


                    </div>


                </div>
                <!-- end order list -->



            </div>
            <!-- end row -->

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

        $(document).on("click", "#click-pay", function () {


            var discount = parseInt($('#discount').val());
            var cash = parseInt($('#cash').val());
            var total = parseInt($('#total').val());

            var balance = cash-total+discount;
            $('#modal_disc').text("Discount: "+discount);
            $('#i_disc').val(discount);
            $('#modal_cash').text("Cash: "+cash);
            $('#i_cash').val(cash);
            $('#modal_balance').text("Balance: "+(balance));


            if(balance >= 0)
            {
                $('#paymodal').modal();
            }
            else
            {
                alert("จำนวนเงินไม่เพียงพอ");
            }
        });

        $(document).on("click", "#exact", function () {
            var discount = $('#discount').val();
            var total = $('#total').val();

            $('#cash').val(total-discount);

        });

        function click_product(x) {
            window.location.href = "?opt=cart&action=add&code="+x;
        }

        function remove_product(x) {
            window.location.href = "?opt=cart&action=remove&code="+x;
        }

        function empty() {
            window.location.href = "?opt=cart&action=empty";
        }







    </script>

    <script type="text/javascript">
        var x =<?php echo $item_total; ?>;
        document.getElementById("cash").innerText(x);

    </script>
</body>

</html>