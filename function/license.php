<?php
class License{
	private $license = array();
	public $expire = array();
	public $puchuse = false;
	private $cache_time = 0;
	protected $cache_file = "json.json";
	public $server = "";
	
	public function __construct(){
		global $mysql,$cookie,$configss,$disable_license;
		$this->license['stats'] = false;
		$this->license['lic'] = "";
		$this->cache_time = (60*60);
		$now = time();
		$interval = $now - @filemtime($this->cache_file);
		if(!file_exists(dirname(__FILE__)."\\".$this->cache_file) || ($interval > $this->cache_time)){
			$a = @file_get_contents("http://system-mc.com/license/check/server.json");
			$jqQE21 = json_decode(base64_decode($a));
			foreach($jqQE21 as $server){
				$url = "http://".$server."/license/check/server.json";
				$a = file_get_contents($url);
				if($a!=""){
					$this->server = $server;
					break;
				}
			}
		}else{
			$jqQE21 = @file_get_contents(dirname(__FILE__)."\\".$this->cache_file);
			$jqQE21 = json_decode(base64_decode($jqQE21));
			foreach($jqQE21 as $server){
				$url = "http://".$server."/license/check/server.json";
				$a = file_get_contents($url);
				if($a!=""){
					$this->server = $server;
					break;
				}
			}
		}
		file_put_contents(dirname(__FILE__)."\\".$this->cache_file,$a);
		
		$this->license['lic'] = $configss->get('serialkey');
		$url = "http://".$this->server."/license/check/product/".$configss->get('serialkey')."/".$configss->get('secretkey');
		$url.= "/".$configss->get('registrykey').".html";
		$content = @file_get_contents($url);
		
		if($content != false){
			$check = json_decode($content);
			if($check->product=="error:not_found_host"||$check->product=="error:not_this_key"){
				$this->license['error'] = $check->product;
				$this->license['host'] = $check->host;
				$this->ErrorLicense();
			}else{
				$this->license['host'] = $check->host;
				$this->license['ban'] = "";
				$this->license['up'] = "";
				$this->license['ver'] = "";
				$this->license['stats'] = true;
			}
		}else{
			$num_lic = $configss->count('license_expire');
			if($num_lic==1){
				$lic_ex['datas'] = $configss->get('license_expire');
				$timesnew=strtotime('-7 days', strtotime(date('Y-M-d H:i:s')));
				if($timesnew > $lic_ex['datas']){
					$this->ErrorLicense();
				}else{
					$timenow = time();
					$this->expire[0] = round(($lic_ex['datas'] - $timenow) / (60*60*24));
					$this->expire[1] = round(($this->expire[0] / 7) * 100);
					if($disable_license!==true){
						if($cookie->get('alert_license_expire')!==true){
							echo "<script>alert('โปรแกรมกำลังหมดอายุในอีก ".round(($lic_ex['datas'] - $timenow) / (60*60*24))." วัน\\nโปรดติดต่อ System-mc เพื่อต่ออายุระบบหรือซื้อระบบ\\nหากคุณคิดว่านี่คือปัญหา อาจจะเป็นได้หลายสาเหตุเช่น\\n - เซิฟเวอร์ของคุณไม่ได้เชื่อมต่ออินเทอร์เน็ต\\n - ไม่สามารถเชื่อมต่อกับระบบของ System-mc ได้\\nหากคุณคิดว่าปัญหาไม่เกิดจากสาเหตุเหล่านี้ ให้ติดไปที่ System-mc');</script>";
							$cookie->add('alert_license_expire',true);
						}
					}
				}
			}elseif($num_lic==0){
				$configss->add('license_expire',(time()+(3600*24*7)));
			}else{
				$this->ErrorLicense();
			}
		}
	}
	
	public function ShowLicense(){
		return '*****';//$this->license['lic'];
	}
	
	public function ShowStats(){
		if($this->license['stats']===true){
			return "Ok";
		}else{
			return "Error";
		}
	}
	
	public function CheckAuthLicense($l,$s,$r){
		$url = "http://".$this->server."/license/check/product/".$l."/".$s."/".$r.".css";
		$content = file_get_contents($url);
			
		if($content=="true"){
			return true;
		}else{
			return false;	
		}
	}
	
	public function Connect(){
		$url = "http://".$this->server."/license/check/connect.json";
		$content = file_get_contents($url);
			
		if($content=="true"){
			return true;
		}else{
			return false;
		}
	}
	
	private function ErrorLicense(){
		if(!isset($_GET['page'])){$_GET['page']='dashboard';}
		$old = $_GET['page'];
		if(basename($_SERVER["SCRIPT_NAME"])=="install.php"||basename($_SERVER["SCRIPT_NAME"])=="download.php"){
			$_GET['page'] = $old;
		}else{
			if($_GET['page']!="setting"){
				$_GET['page'] = "401ER";
			}
		}
	}
}
?>