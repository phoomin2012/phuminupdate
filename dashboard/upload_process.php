<?php
$BASEDIR = "../";
require_once("../function/include.php");
ini_set('display_errors','On');
ini_set('upload_max_filesize','2048M');
ini_set('post_max_size', '3072M');

$fileName = $_FILES["upfile"]["name"]; // The file name
$fileTmpLoc = $_FILES["upfile"]["tmp_name"]; // File in the PHP tmp folder
$fileType = $_FILES["upfile"]["type"]; // The type of file it is
$fileSize = $_FILES["upfile"]["size"]; // File size in bytes
$fileErrorMsg = $_FILES["upfile"]["error"]; // 0 for false... and 1 for true
$name = htmlspecialchars(mysql_real_escape_string($_POST['name']));
$date = htmlspecialchars(mysql_real_escape_string($_POST['date']));
$enabled = htmlspecialchars(mysql_real_escape_string($_POST['enabled']));
if(isset($_POST)){
	if($fileName != "" && $fileTmpLoc != ""){
		if(preg_match("/(.*?)\.zip/i",$fileName,$name_file)){
			if (!$fileTmpLoc) { // if file not chosen
				echo "error_no_file_select";
				exit();
			}
			if(move_uploaded_file($fileTmpLoc, "../fileupdate/".$name.".zip")){
				echo "success";
				$mysql->add('version',array('name'=>$_POST['name'],'date'=>$_POST['date'],'enabled'=>$_POST['enabled']));
				exit();
			} else {
				echo "move_uploaded_file";
				exit();
			}
		}else{
			echo "zip : ".$name." | ".print_r($_FILES["upfile"]);
			exit();
		}
	}else{
		echo "select_file_emtpy | ";
		print_r($_FILES);
		echo " | ";
		print_r($_POST);
		exit();
	}
}else{
	echo "Access Denind!";
	exit();
}
?>