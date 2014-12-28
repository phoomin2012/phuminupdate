<?php
session_start();
include_once('temp/superhead.php');
if($cookie->get('Login_Result')==""){
	header('Location: admin.php');
}
if(!isset($_GET['page']) || $_GET['page']==''){header('location:?page=dashboard');$_GET['page']='dashboard';}

$plugins = array();
$plugin = array('login'=>array('stats'=>''));
$login = $mysql->select("user","*",array(true,"array"),array('email'=>$cookie->get('email')));
$group = $mysql->select("group","*",array(true,"array"),array('name'=>$login['group']));
$cookie->add('email',$login['email']);
$cookie->add('name',$login['name']);
$cookie->add('premission',array(
	'update'=>array($group['update_list'],$group['update_add']),
	'news'=>array($group['news_list'],$group['news_add']),
	'user'=>array($group['user_list'],$group['user_add']),
	'group'=>array($group['group_list'],$group['group_add']),
	'setting'=>array($group['setting_view'],$group['setting_change'])
));

$premission = $cookie->get('premission');
$disabled_menu = array('update'=>array('',''),'news'=>array('',''),'user'=>array('',''),'group'=>array('',''),'setting'=>array('',''));
if($premission['update'][0]=='0'){$disabled_menu['update'][0] = 'style="display:none;"';}
if($premission['update'][1]=='0'){$disabled_menu['update'][1] = 'disabled';}
if($premission['news'][0]=='0'){$disabled_menu['news'][0] = 'style="display:none;"';}
if($premission['news'][1]=='0'){$disabled_menu['news'][1] = 'disabled';}
if($premission['user'][0]=='0'){$disabled_menu['user'][0] = 'style="display:none;"';}
if($premission['user'][1]=='0'){$disabled_menu['user'][1] = 'disabled';}
if($premission['group'][0]=='0'){$disabled_menu['group'][0] = 'style="display:none;"';}
if($premission['group'][1]=='0'){$disabled_menu['group'][1] = 'disabled';}
if($premission['setting'][0]=='0'){$disabled_menu['setting'][0] = 'style="display:none;"';}
if($premission['setting'][1]=='0'){$disabled_menu['setting'][1] = 'disabled';}

if(file_exists('plugins/login/function.php')){$plugin['login']['stats'] = true;}

switch($_GET['page']){
	case 'plugin':{
		if(file_exists('plugins/'.$_GET['pl'].'/function.php')){
			include_once('plugins/'.$_GET['pl'].'/function.php');
			$active_menu = array('plugins'=>array($_GET['pl']=>'active'));
			$plugins = new Plugins;
			$head = array('title'=>array('Plugin : '.$plugins->name,$plugins->title),'icon'=>'');
		}else{
			$active_menu = array('actived','','');
			$head = array('title'=>array('404 Error','ไม่พบสิ่งที่คุณค้นหา'),'icon'=>'');
		}
	}break;
	case 'dashboard':{
		$active_menu = array(0=>'active');
		$head = array('title'=>array('Dashboard','แผงหน้าปัดสถิติ'),'icon'=>'');
	}break;
	case 'update_add':{
		$active_menu = array(1=>'active');
		$head = array('title'=>array('Update Add','เพิ่มการอัพเดรต'),'icon'=>'');
	}break;
	case 'update_list':{
		$active_menu = array(1=>'active');
		$head = array('title'=>array('Update Setting','จัดการรายการอัพเดรต'),'icon'=>'');
	}break;
	case 'news':{
		$active_menu = array(2=>'active');
		$head = array('title'=>array('News Manges','จัดการข่าวสารที่จะนำเสนอบน Launcher'),'icon'=>'');
	}break;
	case 'user':{
		$active_menu = array(3=>'active');
		$head = array('title'=>array('User Setting','จัดการบัญชีที่สามารถเข้าถึงแผงควบคุมได้'),'icon'=>'');
	}break;
	case 'group':{
		$active_menu = array(4=>'active');
		$head = array('title'=>array('Group Setting','จัดการกลุ่มบัญชีที่สามารถเข้าถึงแผงควบคุมได้'),'icon'=>'');
	}break;
	case 'setting':{
		$active_menu = array(5=>'active');
		$head = array('title'=>array('Setting','ตั้งค่าโปรแกรม'),'icon'=>'');
	}break;
	case 'logout':{
		unset($_SESSION['Login_Result']);
		unset($_SESSION);
		header('location:admin.php');
	}break;
	case '401ER':{
		$active_menu = array('actived','','');
		$head = array('title'=>array('401 Error','โปรแกรมหมดอายุ'),'icon'=>'');
	}break;
	default:{
		$active_menu = array('actived','','');
		$head = array('title'=>array('404 Error','ไม่พบสิ่งที่คุณค้นหา'),'icon'=>'');
	}break;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Autoupdate | <?php echo $head['title'][0]; ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <?php include_once("temp/htmlhead.php"); ?>
    </head>
    <body class="skin-blue">
        <header class="header">
            <a href="" class="logo">
                Autoupdate System
            </a>
			<?php include_once("dashboard/template/head_menu.php"); ?>
			<?php include_once("dashboard/template/menu.php"); ?>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">                
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <?php echo $head['title'][0]; ?>
                        <small><?php echo $head['title'][1]; ?></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active"><?php echo $head['title'][0]; ?></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
					<?php
						if($_GET['page']=="dashboard"){
							include_once("dashboard/template/content/dashboard.php");
						}elseif($_GET['page']=="update_list"){
							if($premission['update'][0]=='1'){
								include_once("dashboard/template/content/updated/list.php");
							}else{
								include_once("dashboard/template/access.php");
							}
						}elseif($_GET['page']=="update_add"){
							if($premission['update'][1]=='1'){
								include_once("dashboard/template/content/updated/add.php");
							}else{
								include_once("dashboard/template/access.php");
							}
						}elseif($_GET['page']=="user"){
							if(isset($_GET['add'])){
								if($premission['user'][1]=='1'){
									include_once("dashboard/template/content/user/add.php");
								}else{
									include_once("dashboard/template/access.php");
								}
							}else{
								if($premission['user'][0]=='1'){
									include_once("dashboard/template/content/user/list.php");
								}else{
									include_once("dashboard/template/access.php");
								}
							}
						}elseif($_GET['page']=="group"){
							if(isset($_GET['add'])){
								if($premission['group'][1]=='1'){
									include_once("dashboard/template/content/group/add.php");
								}else{
									include_once("dashboard/template/access.php");
								}
							}else{
								if($premission['group'][0]=='1'){
									include_once("dashboard/template/content/group/list.php");
								}else{
									include_once("dashboard/template/access.php");
								}
							}
						}elseif($_GET['page']=="plugin"){
							$plugins->genDatas($_GET,$_POST)->showcontent();
						}elseif($_GET['page']=="setting"){
							if($premission['setting'][0]=='1'){
								include_once("dashboard/template/content/setting/list.php");
							}else{
								include_once("dashboard/template/access.php");
							}
						}elseif($_GET['page']=="401ER"){
							include_once("dashboard/template/401.php");
						}else{
							include_once("dashboard/template/404.php");
						}
					?>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
    </body>
</html>