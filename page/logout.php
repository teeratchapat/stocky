<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    unset ( $_SESSION['sesid'] );
    unset ( $_SESSION['ses_name'] );
    unset ( $_SESSION['ses_status'] );
    session_destroy();
    header('Location: login.php');
?>