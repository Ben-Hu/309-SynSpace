<?php
    session_start();
    include "php/database.php";
    include "php/listing_database.php";
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
        <link href="css/bootstrap-tagsinput.css" rel="stylesheet">
    </head>
    <body class="skin-blue">
        <!-- Modal for editing an idea -->
        <div class="modal fade" id="listing-edit" tabindex="-1" role="dialog" aria-labelledby="editIdea" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="editIdea">Edit listing</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" name="addr-edit" required maxlength="50" />
                            <input type="text" class="form-control" name="city-edit" required maxlength="25" />
                            <textarea rows="5" class="form-control" name="desc-edit" required></textarea>
                            <input type="text" class="form-control" name="tags-edit" placeholder="Comma-separated tags" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="save" data-dismiss="modal">Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Delete tenant -->
        <div class="modal fade" id="deletetenant" tabindex="-1" role="dialog" aria-labelledby="editIdea" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="editIdea">Edit listing</h4>
                    </div>
                    <div class="modal-body">
                        Enter a tenant's username to delete:
                        <div class="form-group">
                            <input type="text" class="form-control" name="tenant" required maxlength="50" placeholder="Tenant's username" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="deleteuser">Delete</button>
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
                } ?>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel">
                        <div class="pull-left info">
                            <p><?php echo "$user"; ?></p>
                        </div>
                    </div>
                    <!-- Sidebar Menu -->
                    <ul class="sidebar-menu">
                        <?php 
                            if ($isOwner != 0) {
                            	echo "<li><button class='btn btn-danger btn-block' id='deletetenant' data-toggle='modal' data-target='#deletetenant'>Delete tenants</button></li>";
                            }
                            
                            echo "<li class='header'><a href='profile.php?user=$realOwner[1]'>Owner: $realOwner[1]</a></li>
                            ";
                            while ($tenant = pg_fetch_row($allTenants)) {
                            if ($tenant[0] != $realOwner[1]) {
                            echo "<li><a href='profile.php?user=$tenant[0]'>$tenant[0]</a></li>";
                            }
                            }
                            ?>
                        <!-- Optionally, you can add icons to the links -->
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
                        <?php echo "$info[1]"; ?>
                        <small><?php echo "$info[2]"; ?></small>
                        <span style="float:right;"><?php
                            if (isset($_SESSION['username']) && ($isTenant != 0)) {
                            	echo "
                            		<button class='btn btn-default likedislike' id='1'>
                            		<span class='glyphicon glyphicon-thumbs-up'></span>
                            		</button>
                            		<button class='btn btn-default likedislike' id='0'>
                            		<span class='glyphicon glyphicon-thumbs-down'></span>
                            		</button>";
                            } 
                            
                            echo " <span id='rating'>$info[3]</span>";
                            
                            ?></span>
                    </h1>
                </section>
                <!-- Main content -->
                <section class="content">
                    <!-- Your Page Content Here -->
                    <div class="box box-default">
                        <div class="box-body">
                            <div class="thumbnail">
                                <img src="http://placehold.it/1300x250">
                            </div>
                            <?php
                                if (isset($_SESSION['username']) && ($ifRequest != 0)) {
                                echo "<button class='btn btn-block' id='addme' disabled>You have already requested to be added to this listing</button>"; 
                                } elseif (isset($_SESSION['username']) && ($isOwner == 0) && ($isTenant == 0)) {
                                echo "<button class='btn btn-block' id='addme'>Request to be added to this listing</button>";
                                } elseif ($isOwner != 0) {
                                echo "	<button class='btn btn-success btn-block' id='edit-listing' data-toggle='modal' data-target='#listing-edit'>Edit</button>
                                	<button class='btn btn-danger btn-block' id='delete'>Delete</button>";
                                } elseif ($isTenant != 0) {
                                	echo "<button class='btn btn-danger btn-block' id='removetenant'>Leave the listing</button>";
                                }
                                ?>     
                            <?php echo "$info[4]"; ?>
                            <hr>
                            <div id="tags">
                                <?php while ($tag = pg_fetch_row($tags)) {
                                    echo "<button class='btn btn-xs' disabled>$tag[0]</button> ";	
                                    	} ?>
                            </div>
                        </div>
                        <!-- /.box-body -->
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
        <!-- Optionally, you can add Slimscroll and FastClick plugins. 
            Both of these plugins are recommended to enhance the 
            user experience -->
        <script>
            var user = <?php echo json_encode($user); ?>;
            var lid = <?php echo "$id"; ?>;
            var ifLiked = <?php echo "$liked"; ?>;
            var likedVal = <?php echo json_encode($likedResult[0]); ?>;
            var city = <?php echo json_encode($info[2]); ?>;
            var address = <?php echo json_encode($info[1]); ?>;
            var description = <?php echo json_encode($info[4]); ?>;
        </script>
        <script src="js/bootstrap-tagsinput.min.js"></script>
        <script src="js/listing.js"></script>
        <script src="js/user_navigation.js"></script>
    </body>
</html>