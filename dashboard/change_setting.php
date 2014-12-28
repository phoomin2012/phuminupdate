<?php
require_once("../config.php");
$BASEDIR = "../";
require_once("../function/include.php");

$serial = $_POST['serial'];
$serect = $_POST['serect'];
$registrykey = $_POST['registrykey'];
$basedir = $_POST['basedir'];
if($_POST){
	if($configss->add('serialkey',$serial)&&$configss->add('secretkey',$serect)&&$configss->add('registrykey',$registrykey)&&$configss->add('basedir',$basedir)){
		echo "success";
	}else{
		echo "error";
	}
}else{
	echo "Access Denind!";
	exit();
}
?>