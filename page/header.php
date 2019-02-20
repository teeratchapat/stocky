<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if(isset($_SESSION['ses_id']))
    {

        $ses_id = $_SESSION['ses_id'];                                          //สร้าง session สำหรับเก็บค่า ID
        $ses_name = $_SESSION['ses_name'];
        $ses_stat = $_SESSION['ses_status'];
        if($ses_id <> session_id() || $ses_name ==""){
//            echo 'yes';
//            exit();
            header('Location: login.php');
        }
//        echo 'no';
//        exit();
    }
    else{
        header('Location: login.php');
    }
?>


<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">STOCKY</a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">

        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i><span><?= $ses_name?></span> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">

                <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse ">
            <ul class="nav" id="side-menu">

                <li>
                    <a href="index.php"><i class="fa fa-home fa-fw "></i> CASHIER</a>
                </li>

                <?php if(strcmp($ses_stat,'ADMIN') == 0 || strcmp($ses_stat,'MANAGER') == 0 ) { ?>
                    <li>
                        <a href="manage.php"><i class="fa fa-edit fa-fw"></i> MANAGE</a>
                    </li>
                <?php }?>
                <?php if(strcmp($ses_stat,'ADMIN') == 0) { ?>
                <li>
                    <a href="#"><i class="fa fa-table fa-fw"></i> TRANSACTIONS <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="trad-trans.php"> Trading transaction</a>
                        </li>
                        <li>
                            <a href="mang-trans.php"> Manage transaction</a>
                        </li>
                        <li>
                            <a href="report.php"> Report</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>

                    <li>
                        <a href="user.php"><i class="fa fa-users fa-fw "></i> USER</a>

                    </li>
                <?php }?>


            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>