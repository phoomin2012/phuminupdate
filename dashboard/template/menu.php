<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas">                
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="img/avatar<?php echo rand(1,5);?>.png" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>ยินดีต้อนรับ, <?php echo 'ผู้จัดการระบบ';//$login->getUser->name; ?></p>

                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            
            
            <!-- Menu Bar Right Side -->
            <ul class="sidebar-menu">
                <li class="<?php echo $active_menu[0]; ?>">
                    <a href="?page=dashboard">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="<?php echo $active_menu[1]; ?>" <?php echo $disabled_menu['update'][0];?>>
                    <a href="?page=update_list">
                        <i class="fa fa-folder"></i> <span>Update Setting</span>
                    </a>
                </li>
                <li class="<?php echo $active_menu[2]; ?>" <?php echo $disabled_menu['news'][0];?>>
                	<a href="?page=news">
                    	<i class="fa fa-info-circle"></i> <span>News</span>
                    </a>
                </li>
                <li class="<?php echo $active_menu[3]; ?>" <?php echo $disabled_menu['user'][0];?>>
                	<a href="?page=user">
                    	<i class="fa fa-user"></i> <span>User</span>
                    </a>
                </li>
                <li class="<?php echo $active_menu[4]; ?>" <?php echo $disabled_menu['group'][0];?>>
                	<a href="?page=group">
                    	<i class="fa fa-users"></i> <span>Group User</span>
                    </a>
                </li>
                <li class="<?php echo $active_menu[5]; ?>" <?php echo $disabled_menu['setting'][0];?>>
                	<a href="?page=setting">
                    	<i class="fa fa-cog"></i> <span>Setting</span>
                    </a>
                </li>
				<?php
				if($plugin['login']['stats']===true){
				?>
				<li class="<?php echo $active_menu['plugins']['login']; ?>" <?php echo $disabled_menu['plugin']['login'][0];?>>
                	<a href="?page=plugin&pl=login">
                    	<i class="fa fa-users"></i> <span>Plugin : Login Log</span>
                    </a>
                </li>
				<?php
				}
				?>
                <li>
                    <a href="?page=logout">
                        <i class="fa fa-power-off"></i> <span>Logout</span>
                    </a>
                </li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>