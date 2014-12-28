<?php
ini_set('display_errors','On');
$BASEDIR = "../";
require_once("../function/include.php");

$name = $_POST['name'];
$update_list = $_POST['update_list'];
$update_add = $_POST['update_add'];
$user_list = $_POST['user_list'];
$user_add = $_POST['user_add'];
$group_list = $_POST['group_list'];
$group_add = $_POST['group_add'];
$setting_view = $_POST['setting_view'];
$setting_change = $_POST['setting_change'];
if($_POST){
	
	($update_list)? $update_list='1':$update_list='0';
	($update_add)? $update_add='1':$update_add='0';
	($user_list)? $user_list='1':$user_list='0';
	($user_add)? $user_add='1':$user_add='0';
	($group_list)? $group_list='1':$group_list='0';
	($group_add)? $group_add='1':$group_add='0';
	($setting_view)? $setting_view='1':$setting_view='0';
	($setting_change)? $setting_change='1':$setting_change='0';
	
	if($mysql->add('group',array(
		'`name`'=>$name,
		'`update_list`'=>$update_list,
		'`update_add`'=>$update_add,
		'`user_list`'=>$user_list,
		'`user_add`'=>$user_add,
		'`group_list`'=>$group_list,
		'`group_add`'=>$group_add,
		'`setting_view`'=>$setting_view,
		'`setting_change`'=>$setting_change,))){
		echo "success";
	} else {
		echo "cant_add_group";
	}
}else{
	echo "Access Denide!";
	exit();
}
?>