<?php
class Plugins{
	public $name = 'Login';
	public $title = 'ระบบจัดการการเข้าสู่ระบบบน Launcher';
	private $content = '';
	private $post;
	private $get;
	
	public function genDatas($get=null,$post=null){
		$this->get = $get;
		$this->post = $post;
		return $this;
	}
	
	public function showcontent(){
		global $mysql,$configss;
		if($this->post){
			if($this->post['ac']=="config"){
				$configss->add('mysql_login_host',$this->post['mysql_login_host']);
				$configss->add('mysql_login_user',$this->post['mysql_login_user']);
				$configss->add('mysql_login_pass',$this->post['mysql_login_pass']);
				$configss->add('mysql_login_database',$this->post['mysql_login_database']);
				$configss->add('mysql_table_user',$this->post['mysql_login_table_user']);
				$configss->add('mysql_table_field_user',$this->post['mysql_login_table_field_user']);
				$configss->add('mysql_table_field_pass',$this->post['mysql_login_table_field_pass']);
				header("Location: ?page=plugin&pl=login");
			}
		}else{
			$theme = file_get_contents(dirname(__FILE__)."/template/config.txt");
			$theme = str_replace("{MYSQL_HOST}",$configss->get('mysql_login_host'),$theme);
			$theme = str_replace("{MYSQL_USER}",$configss->get('mysql_login_user'),$theme);
			$theme = str_replace("{MYSQL_PASS}",$configss->get('mysql_login_pass'),$theme);
			$theme = str_replace("{MYSQL_DATABASE}",$configss->get('mysql_login_database'),$theme);
			$theme = str_replace("{MYSQL_TABLE_USER}",$configss->get('mysql_table_user'),$theme);
			$theme = str_replace("{MYSQL_TABLE_FIELD_USER}",$configss->get('mysql_table_field_user'),$theme);
			$theme = str_replace("{MYSQL_TABLE_FIELD_PASS}",$configss->get('mysql_table_field_pass'),$theme);
			echo $theme;
		}
		
		
		$sql = "SELECT * FROM `atu_plugin_login_log` USE INDEX(`id`) ORDER BY `id` ASC";
		if(@mysql_num_rows(mysql_query($sql))==0){
			$data_log = "<tr><td colspan='2'><center>ยังไม่มีประวัติการเข้าสู่ระบบในขณะนี้</center><td></tr>";
		}else{
			$data_log = "";
			while($log = mysql_fetch_array(mysql_query($sql))){
				$data_log.="<tr>";
				$data_log.="<td>".$log['id']."</td>";
				$data_log.="<td>".$log['log']."</td>";
				$data_log.="</tr>";
			}
		}
		$theme2 = file_get_contents(dirname(__FILE__)."/template/log.txt");
		$theme2 = str_replace("{LOGIN_LOG_CONTENT}",$data_log,$theme2);
		echo $theme2;
	}
	
	private function getremoteip() {
		global $_SERVER;
		if (!empty($_SERVER["HTTP_CLIENT_IP"])){
		 //check for ip from share internet
			$remote_ip = $_SERVER["HTTP_CLIENT_IP"];
		}elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
		 // Check for the Proxy User
			$remote_ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}else{
			$remote_ip = $_SERVER["REMOTE_ADDR"];
		}
		return $remote_ip;
	}
	
	public function getLogin(){
		global $mysql,$configss;
		$connect = mysql_connect($configss->get('mysql_login_host'),$configss->get('mysql_login_user'),$configss->get('mysql_login_pass'));
		mysql_select_db($configss->get('mysql_login_database'),$connect);
		
		if(isset($this->get['u']) && isset($this->get['p']) && $this->get['login']=="yes"){
			if($this->checkPassword($this->get['u'],$this->get['p'],$connect)){
				$log = "[".date('H:i:s d-m-Y')."] <span class='text-green'>ผู้เล่น <b>".$this->get['u']."</b> ได้เข้าสู่ระบบผ่าน Launcher แล้ว</span>";
				mysql_query("INSERT INTO `atu_plugin_login_log` (`log`) VALUES ('".$log."');");
				echo "[{'user':'".$this->get['u']."','pass':'".$this->get['p']."'}]";
			}else{
				$log = "[".date('H:i:s d-m-Y')."] <span class='text-red'>ผู้เล่นที่อ้างชื่อว่า <b>".$this->get['u']."</b> ได้เข้าสู่ระบบผ่าน Launcher ไม่สำเร็จ</span>";
				mysql_query("INSERT INTO `atu_plugin_login_log` (`log`) VALUES ('".$log."');");
				echo "[{'error':'false'}]";
			}
		}else{
			$log = "[".date('H:i:s d-m-Y')."] <span class='text-yellow'>พบความผิดปกติที่ไม่ได้มาจาก Launcher จาก IP: ".$this->getremoteip()." หากไม่ต้องการพบความเสี่ยงโปรดแจ้งผู้ให้บริการ Launcher</span>";
			mysql_query("INSERT INTO `atu_plugin_login_log` (`log`) VALUES ('".$log."');");
		}
		
	}
	
	private function checkPassword($nickname,$password,$connection){
		global $mysql,$configss;
		$sql = "SELECT * FROM `".$configss->get('mysql_table_user')."` WHERE `".$configss->get('mysql_login_table_field_user')."`='".$nickname."'";
		$a = mysql_query($sql,$connection);
		if(@mysql_num_rows($a) == 1)
		{
			$password_info = mysql_fetch_array($a);
			$sha_info = explode("$",$password_info[0]);
		}
		else return false;
		if($sha_info[1] === "SHA")
		{
			$salt = $sha_info[2];
			$sha256_password = hash('sha256', $password);
			$sha256_password .= $sha_info[2];;
			if(strcasecmp(trim($sha_info[3]),hash('sha256', $sha256_password)) == 0) return true;
			else return false;
		}
	}
}
?>