<link href="css/index.css" rel="stylesheet" type="text/css" />
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left info">
                <p><?php echo "$user"; ?></p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="treeview">
                <a href="#"><span>Listings I am in</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <?php
                        while ($listing = pg_fetch_row($getAllListings)) {
                        	echo "<li><a href='listing.php?id=$listing[0]'>$listing[1]</a></li>";
                        }
                        ?>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><span>My listings</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <?php
                        while ($listing = pg_fetch_row($getListing)) {
                        	echo "<li><a href='listing.php?id=$listing[0]'>$listing[1]</a></li>";
                        }
                        ?>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><span>Post</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <div class="box box-primary">
                        <form method='post' action='php/postdatabase.php'>
                            <input type='text' class='form-control' maxlength='25' name='address' placeholder='Address' required>
                            <input type='text' class='form-control' maxlength='25' name='city' placeholder='City' required>
                            <input type='text' class='form-control' maxlength='10240' name='description' placeholder='Description' required>
                            <input type='text' class='form-control' data-role='tagsinput' name='interests' placeholder='Comma-separated interests' required> 
                            <!-- upload
                                <form action="upload.php" method="post" enctype="multipart/form-data">
                                <span class="file-input btn btn-primary btn-file">
                                Browse&hellip; <input type="file" name="fileToUpload" id="fileToUpload">
                                </span>
                                <br/>
                                <br/>
                                <input class="btn btn-primary" type="submit" value="Upload Image" name="submit">
                                </form>
                                -->
                            <br/>
                            <div class="container">
                                <div class="span12">    
                                    <button class="btn btn-primary" type='submit' class='btn btn-default' name='post'>Post</button>
                                </div>
                            </div>
                        </form>
                        <br/>
                    </div>
                    <br/>     
                </ul>
            </li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>