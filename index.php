<?php
    session_start();
    
    $user = $_SESSION['username'];
    include "php/database.php";
    include "php/loginregistration.php";
    include "php/user_information.php";
    include "php/index_database.php";
    ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SynergySpace</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <link href="css/skins/skin-blue.min.css" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <link href="css/bootstrap-tagsinput.css" rel="stylesheet" />
    </head>
    <body class="skin-blue">
        <div class="wrapper">
            <?php
                // If a user is logged in, change the navigation bar.
                              if (isset($_SESSION['username'])) {
                              	include "user_navigation.php";
                              	include "sidebars/index_sidebar.php";
                              
                              } else {
                              	include "php/guest_navigation.php";
                              }
                                     ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Listings
                    </h1>
                </section>
                <!-- Main content -->
                <section class="content">
                    <!-- Your Page Content Here -->
                    <div class="box box-default">
                        <div class="box-body">
                            <div class="row">
                                <?php 
                                    // If the user has searched for something, display the results
                                    if(isset($_GET['search'])){
                                    while ($SearchListing = pg_fetch_row($SearchListings)) {
                                    echo "
                                    <div class='col-sm-4'>
                                    <div class='thumbnail'>
                                    <img src='http://placehold.it/320x150' alt='search-result'>
                                    
                                    <div class='caption'>
                                    <!-- Rating -->
                                    <h4 class='pull-right'>$SearchListing[3]</h4>
                                    <!-- Address -->
                                    <h4><a href='listing.php?id=$SearchListing[0]'>$SearchListing[1]</a></h4>
                                    <!-- City -->
                                    <p>$SearchListing[2]</p>
                                    </div>
                                    </div>
                                    </div>
                                    ";
                                    }
                                    } else { // Display the listings.
                                    while ($bestListing = pg_fetch_row($getBestListings)) {
                                    echo "
                                    <div class='col-sm-4'>
                                    <div class='thumbnail'>
                                    <img src='http://placehold.it/320x150' alt='listing'>
                                    
                                    <div class='caption'>
                                    <!-- Rating -->
                                    <h4 class='pull-right'>$bestListing[3]</h4>
                                    <!-- Address -->
                                    <h4><a href='listing.php?id=$bestListing[0]'>$bestListing[1]</a></h4>
                                    <!-- City -->
                                    <p>$bestListing[2]</p>
                                    </div>
                                    </div>
                                    </div>
                                    ";
                                    }
                                    }
                                    ?>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.wrapper -->
        <!-- REQUIRED JS SCRIPTS -->
        <!-- jQuery 2.1.3 -->
        <script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/app.min.js" type="text/javascript"></script>
        <script src="js/bootstrap-tagsinput.min.js"></script>
        <script src="js/user_navigation.js"></script>
    </body>
</html>