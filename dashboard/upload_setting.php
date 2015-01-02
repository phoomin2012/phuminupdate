<?php
session_start();
ini_set('display_errors','Off');
$BASEDIR = "../";
require_once("../function/include.php");

$name = $scu->StringProtect($_POST['name']);
$date = $scu->StringProtect($_POST['date']);
$enabled = $scu->StringProtect($_POST['enabled']);
if($_POST){
	if($mysql->add('version',array('name'=>$_POST['name'],'date'=>$_POST['date'],'enabled'=>$_POST['enabled']))){
		echo "success=".mysql_insert_id();
	} else {
		echo "cant_add_version";
	}
}else{
	echo "Access Denind!\n";
	exit();
}
?>