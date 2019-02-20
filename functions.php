<?php
/**
 * Created by PhpStorm.
 * User: bannok
 * Date: 11/15/16 AD
 * Time: 9:14 AM
 */



function cart_operation($db,$product_table,$action,$code){

    //echo "<pre>";
    //print_r($_SESSION["cart_product"]);
    //echo "</pre>";
    if (!empty($action)) {
        $stm = $db->query("SELECT * FROM $product_table WHERE PCode=".$code);

        $productByCode = $stm->fetch();
        //print_r($productByCode);


        $no = $productByCode["PNo"];
        switch ($action) {
            case "add":


                $itemArray =array(
                    'name' => $productByCode["PName"],
                    'no' => $productByCode["PNo"],
                    'code' => $productByCode["PCode"],
                    'price' => $productByCode["PPrice"],
                    'quantity' => 1);

                // if (empty($_SESSION["cart_product"])) {
                //     $_SESSION["cart_product"][$no] = $itemArray;
                // }else{
                //     if (empty($_SESSION["cart_product"][$no])) {
                //         $_SESSION["cart_product"][$no] = $itemArray;
                //     }
                // }


                if (empty($_SESSION["cart_product"][$no])) {
                    $_SESSION["cart_product"][$no] = $itemArray;
                }else{
                    $_SESSION["cart_product"][$no]['quantity'] += 1;

                }

                // $_SESSION["cart_product"][$no] = $itemArray;


                break;

            case "remove":
                if (!empty($_SESSION["cart_product"])) {
                    foreach ($_SESSION["cart_product"] as $k => $v) {
                        if ($no == $k)
                            unset($_SESSION["cart_product"][$k]);
                        if (empty($_SESSION["cart_product"]))
                            unset($_SESSION["cart_product"]);
                    }
                }
                break;

            case "empty":
                unset($_SESSION["cart_product"]);
                break;
        }
    }
    //echo "<pre>";
    //print_r($_SESSION["cart_product"]);
    //echo "</pre>";
}

function get_cart_products(){
    return isset($_SESSION['cart_product'])?$_SESSION['cart_product']:array();
}

function empty_cart(){
    unset($_SESSION["cart_product"]);
}

function to_display_date($mysql_date)
{
    $date = date_create($mysql_date);
    return DATE_FORMAT($date, "d/m/Y H:i");

}

function update_product($no,$quan)
{
//    $stm = $db->query("SELECT * FROM $product_table WHERE PNo=".$no);
//
//    $productByCode = $stm->fetch();
    //print_r($productByCode);

    if ($quan <= 0) {
        //echo('inhere');
        unset($_SESSION['cart_product'][$no]);
        return ;
    }



    if( !empty( $_SESSION['cart_product'][$no] ) )
    {
        $_SESSION['cart_product'][$no]['quantity'] = $quan;
//        $_SESSION["cart_product"][$no]['quantity'] = $_GET['qtn'.$no];
    }




}