<?php
$disable_license = true;
require_once("config.php");
require_once("function/include.php");
ini_set('display_errors','Off');
//########## ตั้งค่าพื้นฐาน ##########//
$mysqls['host'] = Host_Database;			//ที่อยู่ของ Mysql
$mysqls['uesrname'] = User_Database;		//บัญชี Mysql
$mysqls['password'] = Password_Database;	//รหัสผ่าน Mysql
$mysqls['database'] = Database_Select;		//ชื่อฐานข้อมูล
$mysqls['prefix'] = Prefix_Database;		//คำนำหน้าตารางฐานข้อมุล
//############################//
mysql_connect($mysqls['host'],$mysqls['uesrname'],$mysqls['password']) or die(mysql_error());
mysql_select_db($mysqls['database']) or die(mysql_error());
mysql_query("SET NAMES UTF8");
mysql_query("SET character_set_results=utf8");
mysql_query("SET character_set_client=utf8");
mysql_query("SET character_set_connection=utf8");
//############################//

/*header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="download.txt"');
header('Content-Transfer-Encoding: binary');
header('Connection: Keep-Alive');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($file));*/

function scan_dir($path){
    $ite=new RecursiveDirectoryIterator($path);

    $bytestotal=0;
    $nbfiles=0;
	$files=array();
    foreach (new RecursiveIteratorIterator($ite) as $filename=>$cur) {
        $filesize=$cur->getSize();
        $bytestotal+=$filesize;
        $nbfiles++;
        $files[] = $filename;
    }

    $bytestotal=number_format($bytestotal);

    return array('total_files'=>$nbfiles,'total_size'=>$bytestotal,'files'=>$files);
}
$sc = scan_dir($configss->get('basedir'));
if(isset($_GET['c'])){
	echo $sc['total_files'];//."|".$sc['total_size'];
	header("Content-Type:text/plain");
}elseif(isset($_GET['cv'])){
	if($_GET['cv']=="0.0.0.0"){
		$vc_q = mysql_query("SELECT * FROM `".$mysqls['prefix']."version` WHERE `name`='".$_GET['cv']."'");
		if(@mysql_num_rows($vc_q)!=0){
			$vc = mysql_fetch_array($vc_q);
		}else{
			$vc['id'] = "0";
		}
	}else{
		$vc_q = mysql_query("SELECT * FROM `".$mysqls['prefix']."version` WHERE `name`='".$_GET['cv']."'");
		$vc = mysql_fetch_array($vc_q);
	}
	$i = 0;
	$list_v_new = mysql_query("SELECT * FROM `".$mysqls['prefix']."version` WHERE `id` > '".$vc['id']."' AND `enabled`='true' ORDER BY `id` ASC");
	$num_list_v_new = mysql_num_rows($list_v_new);
	if ($num_list_v_new == 0){
		echo "false";
	}else{
		while($lv = mysql_fetch_array($list_v_new)){
			$i++;
			if($i==1){
				if($num_list_v_new==1){
					echo $lv['name'];
					echo "|";
				}else{
					echo $lv['name'];
					echo "|";
				}
			}elseif($i==$num_list_v_new){
				echo $lv['name'];
			}else{
				echo $lv['name'];
				echo "|";
			}
		}
	}
	header("Content-Type:text/plain");
}elseif(isset($_GET['f'])){
	$file = (($configss->get('basedir')=="")?'fileupdate':$configss->get('basedir'))."/".$_GET['f'].".zip";												
	if (file_exists($file) && $_GET['l']=="true"){
		//ini_set("","");
		//header('location : '.$file);
		//exit;
		/*header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($file));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		ob_clean();
		flush();
		readfile($file);*/
		echo "http://".$_SERVER['SERVER_NAME']."/autoupdate/".$file;
		header("Content-Type:text/plain");
		exit;
	}else{
		echo '<link rel="stylesheet" href="css/bootstrap.css"  /><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><style>body{background-color:#eeeeee;font-size:12px;font-family:Tahoma, Geneva, sans-serif;}.modal {position: fixed;top: 10%;left: 50%;z-index: 1050;width: 560px;margin-left: -280px;background-color: #ffffff;border: 1px solid #999;border: 1px solid rgba(0, 0, 0, 0.3);-webkit-border-radius: 6px;-moz-border-radius: 6px;border-radius: 6px;outline: none;-webkit-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);-moz-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);-webkit-background-clip: padding-box;-moz-background-clip: padding-box;background-clip: padding-box;}</style><div class="modal"><center><br><img src="img/lock.png" width="70%" /><br /><br /><font color="#FF0000"><u>ไม่พบไฟล์สำหรับผลิตภัณฑ์นี้ สาเหตุอาจมาจากผลิตภัณฑ์ยังไม่เปิดให้ดาวห์โหลดหรือคุณยังไม่ได้ทำการซื้อ</u></font><br>File request : '.$file.'<br><br></center></div>';
	}

}elseif(isset($_GET['login'])){
	if(file_exists('plugins/login/function.php')){
		include_once('plugins/login/function.php');
		$plugins = new Plugins;
		$plugins->genDatas($_GET,$_POST)->getLogin();
	}
}else{
	foreach ($sc['files'] as $key=>$file){
		echo str_replace('\\','/',$file);
		echo "\r\n";
		//echo "<br>";
	}
	header("Content-Type:text/plain");
}
//header('Content-Length: ' . round_byte(strlen(ob_get_contents())));

?>