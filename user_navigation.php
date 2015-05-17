<?php
    include "php/user_information.php";
    $user = $_SESSION['username'];
    $fullname = $_SESSION['fullname'];
    
    if(isset($_GET['search-btn'])) {
       $getter = $_GET['q'];
       echo "<script> window.location.assign(\"http://ec2-52-10-10-25.us-west-2.compute.amazonaws.com/index.php?search=$getter\"); </script>";
    }
    
    ?>    
<!-- See requests from users who wish to join your listings -->
<div class="modal fade" id="add-multi-users" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!-- Close button -->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Manage requests</h4>
            </div>
            <div class="modal-body">
                <ul class="menu">
                    <?php while ($request = pg_fetch_row($getRequests)) {
                        echo "<li id='$request[0]'><button class='btn btn-xs btn-success accept' id='$request[0]-accept' name='$request[3]-accept'><i class='fa fa-check-circle'></i></button> <button class='btn btn-xs btn-danger reject' id='$request[0]-reject' name='$request[3]-reject'><i class='fa fa-times-circle'></i></button></button> <i class='fa fa-user text-aqua'></i> $request[3] wants to join $request[1] in $request[2] 				
                        </li>";
                        }
                        ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Main Header -->
<header class="main-header">
    <!-- Logo -->
    <a href="http://ec2-52-10-10-25.us-west-2.compute.amazonaws.com" class="logo"><b>Synergy</b>Space</a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li style="width: 400px;">
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" style="height:29px;" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                            <button type='submit' name='search-btn' style="height:29px;" id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>                                   </button>
                            </span>
                        </div>
                    </form>
                </li>
                <?php
                    if ($isAdmin != 0) {
                    echo "
                                                 <li><a href='admin.php'><i class='fa fa-cog'></i></a></li>";
                    }           
                    ?>
                <li class="dropdown messages-menu">
                    <!-- Menu toggle button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-envelope-o"></i>
                    <span class="label label-success">
                    <?php 
                        $c_messagecount = 0;
                        $query = "SELECT messageid, subject, DATE(senton), sender FROM messages WHERE recipient = '$user' AND read = 0";
                        $result = querydb($query);
                        //echo "$user";
                        while ($row = pg_fetch_row($result)) {
                            $c_messagecount = $c_messagecount + 1;
                        }
                        echo $c_messagecount;
                        ?>               
                    </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <!-- inner menu: contains the messages -->
                            <ul class="menu">
                                <?php 
                                    $query = "SELECT messageid, subject, DATE(senton), sender FROM messages WHERE recipient = '$user' AND read = 0";
                                    $result = querydb($query);
                                    //echo "$user";
                                    while ($row = pg_fetch_row($result)) {
                                          $c_id = $row[0];
                                          $c_subject = $row[1];
                                          $c_senton = $row[2];
                                          $c_sender = $row[3];
                                        
                                          //Date computations
                                          date_default_timezone_set('EDT');
                                          $date1 = date("Y-m-d"); 
                                          $date2 = "$c_senton";
                                          $diff = abs(strtotime($date2) - strtotime($date1));
                                          $years = floor($diff / (365*60*60*24));
                                          $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                          $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                                          $totaldays = $years*365 + months*30 + $days;
                                          
                                          echo "
                                            <li><!-- start message -->
                                              <a href=\"mailbox.php#$c_id\">
                                                <div class=\"pull-left\">
                                                  <!-- User Image -->
                                                  <img src=\"http://placehold.it/160x160\" class=\"img-circle\" alt=\"User Image\"/>
                                                </div>
                                                <!-- Message title and timestamp -->
                                                <h4>
                                                  $c_sender
                                                  <small><i class=\"fa fa-clock-o\"></i> $totaldays days ago</small>
                                                  <!-- Support Team -->
                                                </h4>
                                                <!-- The message -->
                                                <p> $c_subject </p>
                                                <!-- <p>Why not buy a new awesome theme?</p> -->
                                              </a>
                                            </li><!-- end message -->";
                                    }
                                    ?>              
                            </ul>
                            <!-- /.menu -->
                        <li class="footer"><a>You have 
                            <?php 
                                if ($c_messagecount != 1) {
                                     echo "$c_messagecount new messages";
                                } else {
                                    echo "$c_messagecount new message";
                                }
                                ?>
                            </a>
                        </li>
                        </li>
                        <li class="footer"><a href="mailbox.php?user=<?php echo "$user"?>">See All Messages</a></li>
                    </ul>
                </li>
                <!-- /.messages-menu -->
                <!-- Notifications Menu -->
                <li class="dropdown notifications-menu">
                    <!-- Menu toggle button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell-o"></i>
                    <span class="label label-warning"><?php echo "$numOfRequests"; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have <?php echo "$numOfRequests"; ?> requests</li>
                        <li>
                            <!-- Inner Menu: contains the notifications -->
                            <ul class="menu">
                                <?php while ($request = pg_fetch_row($getsomeRequests)) {
                                    echo "<li><a href='#' data-toggle='modal' data-target='#add-multi-users'><i class='fa fa-user text-aqua'></i> $request[3] wants to join $request[1] in $request[2]
                                    </a>					
                                    </li>";
                                    }
                                    ?>
                            </ul>
                        </li>
                        <li class="footer"><a href="#" data-toggle="modal" data-target="#add-multi-users">View all</a></li>
                    </ul>
                </li>
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="http://placehold.it/160x160" class="user-image" alt="User Image"/>
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs"><?php echo "$fullname"; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="http://placehold.it/160x160" class="img-circle" alt="User Image" />
                            <p>
                                <?php echo "$user"; ?>
                                <small><?php echo "$fullname"; ?></small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?php echo "<a href='profile.php?user=$user' class='btn btn-default btn-flat'>Profile</a>"; ?>
                            </div>
                            <div class="pull-right">
                                <a href="#" class="btn btn-default btn-flat" id="signout">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>