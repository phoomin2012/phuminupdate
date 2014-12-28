<?php
if(session_id()==""){session_start();}
(isset($BASEDIR)) ? ('') : ($BASEDIR='') ;
if($INSTALL!==true){require_once($BASEDIR."config.php");}
require_once($BASEDIR."function/mysql.php");
require_once($BASEDIR."function/login.php");
require_once($BASEDIR."function/redirect.php");
require_once($BASEDIR."function/generater.php");
require_once($BASEDIR."function/license.php");
require_once($BASEDIR."function/security.php");
require_once($BASEDIR."function/encrypt.php");
require_once($BASEDIR."function/cookie.php");
require_once($BASEDIR."function/config.php");

ini_set('output_buffering', 'On');
ini_set('register_global', 'On');
ini_set('display_errors', 'On');

$enc = new encrypt;
$cookie = new cookie;
$login = new Logins;
$rdir =  new Redirect;
$gen = new Generater;
$mysql = new Mysql(array(),Host_Database,User_Database,Password_Database,Database_Select,Prefix_Database);
$configss = new Config();
$scu = new Security;
$lic = new License();
?>