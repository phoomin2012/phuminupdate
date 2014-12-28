<nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- Tasks: style can be found in dropdown.less -->
                        <li class="dropdown tasks-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-tasks"></i>
                                <?php if($lic->puchuse===false){?>
                                	<span class="label label-danger"><?php echo $lic->expire[0]; ?></span>
                                <?php } ?>
                            </a>
                            <ul class="dropdown-menu">
                            	<li class="header">สถานะต่างๆ</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
										<li><a href="#"><h3>License : <?php echo $lic->ShowStats(); ?></h3></a></li>
										<?php if($lic->puchuse===false){?>
										<li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    คุณเหลือเวลาใช้งานอีก <?php echo $lic->expire[0]; ?> วัน
                                                    <small class="pull-right"><?php echo $lic->expire[1]; ?>%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-red" style="width: <?php echo $lic->expire[1]; ?>%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">80% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li><!-- end task item -->
										<?php } ?>
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>ข้อมูลเซิฟเวอร์
                                                    <small class="pull-right">Server Infomation</small>
                                                </h3>
                                                <div style="color:#000;">
                                                	<ul>
                                                    	<li>Server Name : <?=$_SERVER['SERVER_NAME'];?></li>
                                                        <li>Server Port : <?=$_SERVER['SERVER_PORT'];?></li>
                                                        <li>Status Host : <?=($_SERVER['SERVER_NAME']!="localhost")?'False':'True';?></li>
                                                    </ul>
                                                </div>
                                            </a>
                                        </li><!-- end task item -->
                                        
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>