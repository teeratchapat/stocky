<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION['ses_status']) && isset($want) )
{
    $ses_stat = $_SESSION['ses_status'];
    $ses_userNo = $_SESSION['ses_userNo'];
    switch ($want){
        case 'MANAGER' :
            if(strcmp($ses_stat,'CASHIER') == 0){
                header('Location: index.php');
            }
            break;
        case 'ADMIN' :
            if(strcmp($ses_stat,'CASHIER') == 0 || strcmp($ses_stat,'MANAGER') == 0){
                header('Location: index.php');
            }
            break;
    }
}
else{
    header('Location: login.php');
}
?>