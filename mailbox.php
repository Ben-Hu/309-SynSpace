<?php
    session_start();
    $user = $_SESSION['username'];
    include "php/database.php";
    include "php/profile_database.php";
    
       // Function for sending messages
    if (isset($_POST['sendcomp'])) {
           $sender = $user;
    	$recipient = $_POST['recipient'];
    	$subject = $_POST['subject'];
           $messagebody = $_POST['messagebody'];
           
           //Check for valid recipient (e.g. user exists)
    	$query = "SELECT * FROM users WHERE username='$recipient'";
    	$result = querydb($query);
    	$numrows = pg_num_rows($result);
    
    	if ($numrows == 0) {
    		echo "<script>alert('Not a valid recipient.')</script>";
    	} else {
               $send = "INSERT INTO messages (sender, recipient, subject, messagetext) VALUES ('$sender', '$recipient', '$subject', '$messagebody')";
               $result = querydb($send);
               if (!$result) {
                   echo "<script> alert('Failed to send message.'); </script>";
               } else {
                   echo "<script> alert('Message Sent.'); </script>";
               }
    	}
    }
    
       // Function for deleteing messages
    if (isset($_POST['delmessage'])) {
           $mid = $_POST['delmessage'];
    	//echo "<script>alert('$mid')</script>";
    	$query = "DELETE FROM messages WHERE messageid=$mid";
    	$result = querydb($query);
    	if (!$result){
    		echo "<script>alert('Failed to Delete.')</script>";
    	} else {
               echo "<script> alert('Message Deleted.'); </script>";
    	}
    }
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
    </head>
    <body class="skin-blue">
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
                        <li class="header">Recently Messaged</li>
                        <!-- Optionally, you can add icons to the links -->
                        <?php
                            $query = querydb("SELECT DISTINCT sender FROM messages WHERE sender IN (SELECT sender FROM messages WHERE recipient='$user' OR sender='$user' ORDER BY senton)");
                            while ($friend = pg_fetch_row($query)) {
                                if ($friend[0] != $user) {
                            echo "<li><a href='profile.php?user=$friend[0]'>$friend[0]</a></li>";
                                }
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
                        <?php echo "<a class=\"btn btn-primary\" type=\"button\" href=\"#\" data-toggle='modal' data-target='#composetoggle'>COMPOSE</a>"; ?>
                        <span style="float:right;">
                        <?php
                            if (isset($_SESSION['username']) && ($isFriend != 0)) {
                            echo "
                                <button class='btn btn-default likedislike' id='1'>
                                <span class='glyphicon glyphicon-thumbs-up'></span>
                                </button>
                                <button class='btn btn-default likedislike' id='0'>
                                <span class='glyphicon glyphicon-thumbs-down'></span>
                                </button>";
                            }       
                            ?></span>
                    </h1>
                </section>
                <!-- Main content -->
                <section class="content">
                    <!-- Page Content -->
                    <!-- Compose form -->
                    <div class="modal fade" id="composetoggle" tabindex="-1" role="dialog" aria-labelledby="composetoggle" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <!-- Close button -->
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove"></span>&nbsp;                               </button>
                                    <h4 class="modal-title">New Message</h4>
                                </div>
                                <div class="modal-body">
                                    <form method="post">
                                        <div>
                                            <input type="text" class="form-control" name="recipient" maxlength="25" placeholder="To">
                                            <input type="text" class="form-control" name="subject" maxlength="250" placeholder="Subject">
                                            <input type="text" class="form-control" name="messagebody" maxlength="10240" placeholder="Body">
                                            <br/>
                                            <br/>
                                            <button class="btn btn-primary" name="sendcomp" value="sendcomp" type="submit">Send</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Composition Form-->
                    <!-- Default box -->
                    <div class="box">
                        <div class="box-body">
                            <div class="box-group" id="accordion">
                                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                                <?php 
                                    $c_messagecount = 0;
                                    $query = "SELECT messageid, subject, DATE(senton), sender, messagetext FROM messages WHERE recipient = '$user'";
                                    $result = querydb($query);
                                    //echo "$user";
                                    while ($row = pg_fetch_row($result)) {
                                          $c_id = $row[0];
                                          $c_subject = $row[1];
                                          $c_senton = $row[2];
                                          $c_sender = $row[3];
                                          $c_messagetext = $row[4];
                                    
                                          //Date computations
                                          date_default_timezone_set('EDT');
                                          $date1 = date("Y-m-d"); 
                                          $date2 = "$c_senton";
                                          $diff = abs(strtotime($date2) - strtotime($date1));
                                          $years = floor($diff / (365*60*60*24));
                                          $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                          $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                                          $totaldays = $years*365 + months*30 + $days;
                                    
                                          $c_messagecount = $c_messagecount + 1;
                                          
                                          $read = "UPDATE messages SET read = 1 WHERE messageid = '$c_id'";
                                          $readresult = querydb($read);
                                        
                                          echo "<div class=\"panel box box-info\" id=\"$c_id\">
                                                    <div class=\"box-header with-border\">
                                                      <h4 class=\"box-title\">
                                                            <a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#description$c_id\">
                                                              $c_subject <small>from $c_sender</small>
                                                            </a>
                                                      </h4>
                                                      <div class=\"pull-right\">
                                                          <form method=\"post\">
                                                          <!-- <button class='btn btn-primary' name='delmessage' value='$c_id' type='submit'>DELETE</button> -->
                                                          <button type='submit' class='btn btn-primary' aria-hidden='true' name='delmessage' value='$c_id'><span class='glyphicon glyphicon-trash'></span>&nbsp;                               </button>
                                                          </form>
                                                      </div>
                                                    </div>
                                                    <div id=\"description$c_id\" class=\"panel-collapse collapse in\">
                                                      <div class=\"box-body\">
                                                          $c_messagetext
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <br/>";
                                    }
                                    ?>
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
        <script>
            var ifLiked = <?php echo json_encode($ifRated); ?>;
            var likedVal = <?php echo json_encode($likedVal[0]); ?>;
            var user = <?php echo json_encode($user); ?>;
            var curruser = <?php echo json_encode($curruser); ?>;
        </script>
        <script src="js/profile.js"></script>
                <script src="js/user_navigation.js"></script>
    </body>
</html>