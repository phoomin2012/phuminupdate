<?php
ini_set('display_errors','On');
$BASEDIR = "../";
require_once("../function/include.php");

$email = $_POST['email'];
$name = $_POST['name'];
$group = $_POST['group'];
$password = hash('crc32',$_POST['password']);
if($_POST){
	if($mysql->add('user',array(
		'`email`'=>$email,
		'`name`'=>$name,
		'`group`'=>$group,
		'`password`'=>$password))){
		echo "success";
	} else {
		echo "cant_add_user";
	}
}else{
	echo "Access Denind!";
	exit();
}
?>