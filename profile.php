<?php
    session_start();
    $user = $_SESSION['username'];
    include "php/database.php";
    include "php/profile_database.php";
    ?>
<!DOCTYPE html>
<!--
    This is a starter template page. Use this page to start your new project from
    scratch. This page gets rid of all links and provides the needed markup only.
    -->
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
        <link href="css/bootstrap-tagsinput.css" rel="stylesheet" />
    </head>
    <body class="skin-blue">
        <!-- Modal for editing an idea -->
        <div class="modal fade" id="profile-edit" tabindex="-1" role="dialog" aria-labelledby="editIdea" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="editIdea">Edit profile</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" name="firstname-edit" required maxlength="25" placeholder="First Name"/>
                            <input type="text" class="form-control" name="lastname-edit" required maxlength="25" placeholder ="Last Name" />
                            <textarea rows="5" class="form-control" name="desc-edit" placeholder="Description" required></textarea>
                            <input type="text" class="form-control" name="tags-edit" placeholder="Comma-Separated Tags" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="save">Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="wrapper">
            <?php
                if (isset($_SESSION['username'])) {
                	include "user_navigation.php";
                } else {
                	include "php/guest_navigation.php";
                } 
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
                        <?php
                            if ($curruser == $user) {
                            	echo "<button class='btn btn-primary btn-block' id='edit-profile' data-toggle='modal' data-target='#profile-edit'>Edit profile</button>"; 
                            }
                            ?>
                        <li class="header"><?php echo "$userInfo[0]"; ?>'s Friends</li>
                        <!-- Optionally, you can add icons to the links -->
                        <?php while ($friend = pg_fetch_row($friends)) {
                            echo "<li><a href='profile.php?user=$friend[0]'>$friend[0]</a></li>";
                            }
                            ?>
                    </ul>
                    <!-- /.sidebar-menu -->
                </section>
                <!-- /.sidebar -->
            </aside>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1 style="text-align: left">
                        <?php echo "$userInfo[0]"; ?>
                        <small><?php echo "$userInfo[2] $userInfo[3]"; ?></small>
                        <span style="float:right;"><?php
                            if (isset($_SESSION['username']) && ($isFriend != 0)) {
                            	echo "
                            		<button class='btn btn-default likedislike' id='1'>
                            		<span class='glyphicon glyphicon-thumbs-up'></span>
                            		</button>
                            		<button class='btn btn-default likedislike' id='0'>
                            		<span class='glyphicon glyphicon-thumbs-down'></span>
                            		</button>";
                            } 
                            echo " <span id='rating'>$rating[0]</span>";
                            
                            ?></span>
                    </h1>
                </section>
                <!-- Main content -->
                <section class="content">
                    <!-- Your Page Content Here -->
                    <!-- Default box -->
                    <div class="box">
                        <div class="box-body">
                            <div class="box-group" id="accordion">
                                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                                <div class="panel box box-info">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#description">
                                            Description
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="description" class="panel-collapse collapse in">
                                        <div class="box-body">
                                            <?php echo "$userInfo[5]"; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel box box-success">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#owns">
                                            <?php echo "$userInfo[0]";?>'s Listings
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="owns" class="panel-collapse collapse">
                                        <div class="box-body">
                                            <ul>
                                                <?php
                                                    while ($listing = pg_fetch_row($owns)) {
                                                    	echo "<li><a href='listing.php?id=$listing[0]'>$listing[1] in $listing[2]</a></li>";
                                                    }
                                                    ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel box box-warning">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#tenant">
                                            Listings that <?php echo "$userInfo[0]"; ?> is a Tenant in 
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="tenant" class="panel-collapse collapse">
                                        <div class="box-body">
                                            <ul>
                                                <?php
                                                    while ($tenant = pg_fetch_row($tenantIn)) {
                                                    	echo "<li><a href='listing.php?id=$tenant[0]'>$tenant[1] in $tenant[2]</a></li>";
                                                    }
                                                    ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <div id="interests">
                                <?php while ($interest = pg_fetch_row($interests)) {
                                    echo "<button class='btn btn-xs' disabled>$interest[0]</button> ";	
                                    	} ?>
                            </div>
                        </div>
                        <!-- /.box-footer-->
                    </div>
                    <!-- /.box -->
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
        <script>
            var ifLiked = <?php echo json_encode($ifRated); ?>;
            var likedVal = <?php echo json_encode($likedVal[0]); ?>;
            var user = <?php echo json_encode($user); ?>;
            var curruser = <?php echo json_encode($curruser); ?>;
            var first = <?php echo json_encode($userInfo[2]); ?>;
            var last = <?php echo json_encode($userInfo[3]); ?>;
            var description = <?php echo json_encode($userInfo[5]); ?>;
        </script>
        <script src="js/bootstrap-tagsinput.min.js"></script>
        <script src="js/profile.js"></script>
                <script src="js/user_navigation.js"></script>
    </body>
</html>