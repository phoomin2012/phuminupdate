<?php
class Logins{
	private $continues;
	private $timeStmp;
	private $secTok;
	private $email;
	private $password;
	private $url;
	
	function get(){
		$this->redirect_fail($this->check_get());
	}
	function check_get(){
		global $scu,$mysql;
		$i = 0;
		$_POST['Email'] = $scu->StringProtect($_POST['Email']);
		$_POST['Passwd'] = $scu->StringProtect($_POST['Passwd']);
		$timesnew=strtotime('-1 hours', strtotime(date('Y-M-d H:i:s')));
		if($_POST['continue'] != ""){
			$this->continues = $_POST['continue'];
			$i++;
		}else{
			$this->continues = $_SERVER['HTTP_USER_AGENT'];
			$i++;
		}
		if($_POST['timeStmp'] > $timesnew){
			$this->timeStmp = $_POST['timeStmp'];
			$i++;
		}
		if($_POST['secTok'] == $_SESSION['secTok'][0] && $_POST['secTok'] == $_COOKIE['secTok'] && $_SESSION['secTok'][0] == $_COOKIE['secTok']){
			$i++;
		}
		$login = $mysql->select("user","*",array(true,"array"),array('email'=>$_POST['Email']));
		$num_user = $mysql->select("user","*",array(true,"number"),array('email'=>$_POST['Email']));
		if($num_user == "1"){
			$i++;
		}
		$_POST['Passwds'] = hash('crc32',$_POST['Passwd']);
		if($_POST['Passwd']!=""&&$_POST['Passwds']==$login['password']){
			$i++;
		}
		return $i;
	}
	function redirect_fail($i){
		global $rdir,$mysql,$cookie;
		if($i == 5){
			$url = "dashboard.php" ;
			if(parse_url($_POST['self'])==$_SERVER['HTTP_HOST']){
				$url = $_POST['self'];
			}
			unset($_POST['signIn']);
			unset($_POST['action']);
			unset($_POST['Passwds']);
			unset($_POST['Passwd']);
			unset($_POST['fail']);
			
			$login = $mysql->select("user","*",array(true,"array"),array('email'=>$_POST['Email']));
			$group = $mysql->select("group","*",array(true,"array"),array('name'=>$login['group']));
			
			$cookie->add('email',$login['email']);
			$cookie->add('name',$login['name']);
			$cookie->add('premission',array(
				'update'=>array($group['update_list'],$group['update_add']),
				'user'=>array($group['user_list'],$group['user_add']),
				'group'=>array($group['group_list'],$group['group_add']),
				'setting'=>array($group['setting_view'],$group['setting_change'])
			));
			$_SESSION['email'] = base64_encode($login['email']);
			$cookie->add('Login_Result',time());
			
			$rdir->redirectByForm($url,$_POST,true,true,false,true);
		}else{
			$url = "admin.php";
			unset($_POST['signIn']);
			unset($_POST['action']);
			unset($_POST['Passwds']);
			unset($_POST['Passwd']);
			//echo "#2";
			$_POST['fail'] = "";
			$rdir->redirectByForm($url,$_POST,true,true,false,false);
		}
	}
	function getUser(){
		$login = $mysql->select("user","*",array(true,"array"),array('email'=>base64_decode($_SESSION['email'])));
		return (Object) $login;
	}
}

?>