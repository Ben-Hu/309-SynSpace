<?php
    session_start();
    $user = $_SESSION['username'];
    include "php/database.php";
    include "php/admin.php";
    ?>
<!DOCTYPE html>
<!--
    This is a starter template page. Use this page to start your new project from
    scratch. This page gets rid of all links and provides the needed markup only.
    -->
<html>
    <head>
        <meta charset="UTF-8">
        <title>SynergySpace Admin</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
            page. However, you can choose any other skin. Make sure you
            apply the skin class to the body tag so the changes take effect.
            -->
        <link href="css/skins/skin-blue.min.css" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue">
        <div class="wrapper">
            <?php
                include "user_navigation.php";
                ?>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="http://placehold.it/160x160" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p><?php echo "$user"; ?></p>
                        </div>
                    </div>
                    <!-- Sidebar Menu -->
                    <ul class="sidebar-menu">
                        <li class="active"><a href="index.php">Home</a></li>
                    </ul>
                    <!-- /.sidebar-menu -->
                </section>
                <!-- /.sidebar -->
            </aside>
            <div class="modal fade" id="deleteuser" tabindex="-1" role="dialog" aria-labelledby="editIdea" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="editIdea">Delete user</h4>
                        </div>
                        <div class="modal-body">
                            Enter a username to delete:
                            <div class="form-group">
                                <input type="text" class="form-control" name="user" required maxlength="50" placeholder="Username" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="delete">Delete</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="deletelisting" tabindex="-1" role="dialog" aria-labelledby="editIdea" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="editIdea">Delete listing</h4>
                        </div>
                        <div class="modal-body">
                            Enter a listing ID to delete:
                            <div class="form-group">
                                <input type="number" class="form-control" name="listing" required />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="deletespace">Delete</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Administrative view
                    </h1>
                </section>
                <!-- Main content -->
                <section class="content">
                    <!-- Your Page Content Here -->
                    <div class="row">
                        <div class="col-md-4">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3><?php echo "$numusers[0]"; ?></h3>
                                    <p>Registered users</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3><?php echo "$numtenants[0]"; ?></h3>
                                    <p>Tenants</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3><?php echo "$numtenants[0]"; ?></h3>
                                    <p>Spaces</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteuser">Delete user</button>
                        <button class="btn btn-danger btn-block" data-toggle="modal" data-target="#deletelisting">Delete listing</button>
                        <br />
                        <div class="col-md-6">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab_1" data-toggle="tab">Highest rated users</a></li>
                                    <li><a href="#tab_2" data-toggle="tab">Lowest rated users</a></li>
                                    <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1">
                                        <ol>
                                            <?php while ($bestUser = pg_fetch_row($getbestUsers)) {
                                                echo "<li><a href='profile.php?user=$bestUser[0]'>$bestUser[0]</a></li>";
                                                }
                                                ?>
                                        </ol>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_2">
                                        <ol>
                                            <?php while ($worstUser = pg_fetch_row($getworstUsers)) {
                                                echo "<li><a href='profile.php?user=$worstUser[0]'>$worstUser[0]</a></li>";
                                                }
                                                ?>
                                        </ol>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div>
                            <!-- nav-tabs-custom -->
                        </div>
                        <div class="col-md-6">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#low" data-toggle="tab">Highest rated listings</a></li>
                                    <li><a href="#high" data-toggle="tab">Lowest rated listings</a></li>
                                    <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="low">
                                        <ol>
                                            <?php while ($bestListing = pg_fetch_row($getbestListings)) {
                                                echo "<li><a href='listing.php?id=$bestListing[0]'>$bestListing[1]</a></li>";
                                                }
                                                ?>
                                        </ol>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="high">
                                        <ol>
                                            <?php while ($worstListing = pg_fetch_row($getworstListings)) {
                                                echo "<li><a href='listing.php?id=$worstListing[0]'>$worstListing[1]</a></li>";
                                                }
                                                ?>
                                        </ol>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div>
                            <!-- nav-tabs-custom -->
                        </div>
                    </div>
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        </div>
        <!-- ./wrapper -->
        <!-- REQUIRED JS SCRIPTS -->
        <!-- jQuery 2.1.3 -->
        <script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/app.min.js" type="text/javascript"></script>
        <script src="js/admin.js"></script>
                <script src="js/user_navigation.js"></script>
    </body>
</html>