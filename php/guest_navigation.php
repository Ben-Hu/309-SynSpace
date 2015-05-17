<?php
        include "php/user_information.php";
       
       if(isset($_GET['search-btn'])) {
           $getter = $_GET['q'];
           echo "<script> window.location.assign(\"http://ec2-52-10-10-25.us-west-2.compute.amazonaws.com/index.php?search=$getter\"); </script>";
       }
    
    ?>    

<!-- Login form -->
<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!-- Close button -->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Login/Register</h4>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div>
                        <input type="text" class="form-control" name="user" maxlength="25" placeholder="Username" required>
                        <br />
                        <input type="password" class="form-control" name="pass" maxlength="25" placeholder="Password" required>
                        <br />
                        <button class="btn btn-primary" name="login" value="login" type="submit">Login</button>
                    </div>
                </form>
            </div>
            <!-- Register button -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#register">Register</button>
            </div>
        </div>
    </div>
</div>

<!-- Registration form -->
<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="register" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Register</h4>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div>
                        <input type="text" class="form-control" name="username" maxlength="25" placeholder="Username" required>
                        <br />
                        <input type="password" class="form-control" name="password" maxlength="25" placeholder="Password" required>
                        <br />
                        <input type="text" class="form-control" name="firstname" maxlength="20" placeholder="First name" required>
                        <br />
                        <input type="text" class="form-control" name="lastname" maxlength="20" placeholder="Last name" required>
                        <br />
                        <button class="btn btn-primary" name="register" value="register" type="submit">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Main Header -->
<header class="main-header">
    <!-- Logo -->
    <a href="index.php" class="logo"><b>Synergy</b>Space</a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li style="width: 450px;">
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" style="height:29px;" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                            <button type='submit' name='search-btn' style="height:29px;" id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="active"><a href="#" data-toggle="modal" data-target="#login">Login/Register</a></li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>

