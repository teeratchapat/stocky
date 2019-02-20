<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$want = 'ADMIN';
require('check_user.php');
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
                <h1 class="page-header" style="align-content: center">CASHIER</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

            </div>

        </div>

    </div>
</div>
</body>