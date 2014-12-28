<?php
require_once('temp/superhead.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <?php require_once("install/htmlhead.php"); ?>
        <script>
		var page_global = 0;
		var active_menu = new Array();
		var head = new Array();
		head['title'] = new Array();
		var linkurl_global = '';
		var datas_post_send = '';
		var formdata = new FormData();
		var global_data = new Array();
		function pagelender(page){
			page_global = page;
			switch(page_global){
				case 0:{
					active_menu[0] = 'active';
					head['title'][0] = 'Welcome Install System';
					head['title'][1] = 'ยอมรับข้อตกลง';
					head['icon'] = '';
					window.history.replaceState("Null", "Phumin Autoupdate + Launcher :: Install System", "install.php");
					linkurl = 'install/template/welcome.php'
					$("#menu-step-1").addClass("active");
					$("#menu-step-2").removeClass("active");
				}break;
				case 1:{
					active_menu[1] = 'active';
					head['title'][0] = 'Install Step 1';
					head['title'][1] = 'ตรวจสอบการสั่งซื้อ';
					head['icon'] = '';
					window.history.replaceState("Null", "Phumin Autoupdate + Launcher :: Install System", "install/step1.php");
					linkurl = '../install/template/license.php';
					$("#menu-step-1").removeClass("active");
					$("#menu-step-2").addClass("active");
					$("#menu-step-3").removeClass("active");
				}break;
				case 2:{
					active_menu[2] = 'active';
					head['title'][0] = 'Install Step 2';
					head['title'][1] = 'ตรวจสอบระบบ';
					head['icon'] = '';
					window.history.replaceState("Null", "Phumin Autoupdate + Launcher :: Install System", "install/step2.php");
					linkurl = '../install/template/license.php'
					$("#menu-step-2").removeClass("active");
					$("#menu-step-3").addClass("active");
					$("#menu-step-4").removeClass("active");
				}break;
				case 3:{
					active_menu[3] = 'active';
					head['title'][0] = 'Install Step 3';
					head['title'][1] = 'ตั้งค่าพื้นฐาน';
					head['icon'] = '';
					window.history.replaceState("Null", "Phumin Autoupdate + Launcher :: Install System", "install/step3.php");
					linkurl = '../install/template/license.php'
					$("#menu-step-3").removeClass("active");
					$("#menu-step-4").addClass("active");
					$("#menu-step-5").removeClass("active");
				}break;
				case 4:{
					active_menu[4] = 'active';
					head['title'][0] = 'Install Step 4';
					head['title'][1] = 'สร้างฐานข้อมุล';
					head['icon'] = '';
					window.history.replaceState("Null", "Phumin Autoupdate + Launcher :: Install System", "install/step4.php");
					linkurl = '../install/template/license.php'
					$("#menu-step-4").removeClass("active");
					$("#menu-step-5").addClass("active");
					$("#menu-step-6").removeClass("active");
				}break;
				case 5:{
					active_menu[5] = 'active';
					head['title'][0] = 'Install Step 5';
					head['title'][1] = 'ตั้งค่าผู้ดูแลระบบ';
					head['icon'] = '';
					window.history.replaceState("Null", "Phumin Autoupdate + Launcher :: Install System", "install/step5.php");
					linkurl = '../install/template/license.php'
					$("#menu-step-5").removeClass("active");
					$("#menu-step-6").addClass("active");
					$("#menu-step-7").removeClass("active");
				}break;
				case 6:{
					active_menu[6] = 'active';
					head['title'][0] = 'Completed Install';
					head['title'][1] = 'เสร็จสิ้นการติดตั้ง';
					head['icon'] = '';
					window.history.replaceState("Null", "Phumin Autoupdate + Launcher :: Install System", "install/step6.php");
					linkurl = '../install/template/license.php'
					$("#menu-step-6").removeClass("active");
					$("#menu-step-7").addClass("active");
				}break;
				default:{
					active_menu[0] = 'actived';
					head['title'][0] = '404 Error';
					head['title'][1] = 'ไม่พบสิ่งที่คุณค้นหา';
					head['icon'] = '';
					window.history.replaceState("Null", "Phumin Autoupdate + Launcher :: Install System", "install/step7.php");
					linkurl = '../install/template/404ER.php'
					$("#menu-step-1").removeClass("active");
					$("#menu-step-2").removeClass("active");
					$("#menu-step-3").removeClass("active");
					$("#menu-step-4").removeClass("active");
					$("#menu-step-5").removeClass("active");
					$("#menu-step-6").removeClass("active");
					$("#menu-step-7").removeClass("active");
				}break;
			}
			var htmlhead = head['title'][0]+'<small>'+head['title'][1]+'</small>';
			$("#head-title-text").html(htmlhead);
			$("title").html('Autoupdate | '+head['title'][0]);
		}
		function loadpage(page){
			$('#progressbarstats').slideDown(500,function(){
				$("#main-content").slideUp(250);
				var percentComplete = new Array;
				percentComplete[0] = 0;
				percentComplete[1] = 0;
				pagelender(page);
				
				var ajax = new XMLHttpRequest();
				ajax.upload.addEventListener("progress", progressHandler, false);
				ajax.addEventListener("load", completeHandler, false);
				ajax.addEventListener("error", errorHandler, false);
				ajax.addEventListener("abort", abortHandler, false);
				ajax.open("POST", linkurl);
				ajax.send(formdata);
			});
		}
		var old_size_up_c = 0;
		var new_size_up_c = 0;
		var full_size_up  = 0;
		
		function progressHandler(event){
			new_size_up_c = event.loaded;
			full_size_up = event.total;
			var speed_up = ((new_size_up_c - old_size_up_c)).toFixed(2);
			
			var percent = (event.loaded / event.total) * 100;
			$("#progressouter").css("width",(Math.round(percent)+0)+"%");
			$("#progressouter").html((Math.round(percent)+0)+"%");
			var time_out = ((full_size_up - new_size_up_c)/(speed_up)).toFixed(0);
			old_size_up_c = event.loaded;
		}
		
		function errorHandler(event){alert("อัพโหลดไม่สำเร็จ");}
		function abortHandler(event){alert("อัพโหลดผิดพลาด");}
		
		function completeHandler(event){
			$("#progressbarstats").slideUp(500,function(){
				$("#progressouter").css("width","0%");
				$("#progressouter").html("0%");
			});
			$("#main-content").html(event.target.responseText);
			$("#main-content").slideDown(250);
		}

		
		/*$(window).bind('beforeunload', function(){
		  return 'คุณแน่ใจหรือไม่ว่าจะออกจากหน้านี้ คุณจะไม่สามารถกลับมายังขั้นตอนนี้ได้อีก?';
		});*/
		</script>
    </head>
    <body class="skin-blue" onLoad="loadpage(0);">
        <header class="header">
            <a href="" class="logo">
                Autoupdate System
            </a>
			<?php require_once("install/head_menu.php"); ?>
			<?php require_once("install/menu.php."); ?>
			            
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1 id="head-title-text">
                        <small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active"><?php echo $head['title'][0]; ?></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
					<div class="progress progress-striped active" id="progressbarstats">
                		<div class="progress-bar progress-bar-info" role="progressbar" aria-valuemin="0" aria-valuemax="100" id="progressouter">
                    	</div>
					</div>
                    <div id="main-content">
					<?php
						if($_GET['step']=="0"){
							require_once("install/template/welcome.php");
						}elseif($_GET['step']=="1"){
							require_once("install/template/license.php");
						}elseif($_GET['step']=="2"){
							require_once("install/template/premission.php");
						}elseif($_GET['step']=="3"){
							require_once("install/template/config.php");
						}elseif($_GET['step']=="4"){
							require_once("install/template/mysql.php");
						}elseif($_GET['step']=="5"){
							require_once("install/template/admin.php");
						}elseif($_GET['step']=="6"){
							require_once("install/template/final.php");
						}
					?>
                    </div>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
    </body>
</html>