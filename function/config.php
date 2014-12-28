<?php
class Config{
	private $hashs = 'sha1'; ////// Hash สำหรับ name
	private $keys = 'we3AA214wewe21Bkoithyewe3'; /// Key สำหรับนำหน้า Hash
	private $hashkeys = 'adler32'; ////// Hash สำหรับข้อมูล
	private $keya = '';	// ห้ามใส่ข้อความ
	
	private function __construt(){
		$type = $this->hashkeys;
		$str = $this->keys;
		if(!function_exists('hash')) {
			if(!function_exists($type)) {
				if($type == 'sha1') {
					$this->keya = $this->sha1($str);
				} else {
					$this->keya = md5($str);
				}
			} else {
				$this->keya = $type($str);
			}
		} else {
			$this->keya = hash($type, $str);
		}
	
	}
	public function get($name){
		global $mysql;		

		$config = $mysql->select('config','*',array(true,'array'),array('name'=>$this->__hash_name($name)));
		
		$config['datas'] = $this->_decode_data($config['datas']);
		
		return $config['datas'];
	}
	public function add($name,$data){
		global $mysql;
		
		$config = $mysql->add('config',array('name'=>$this->__hash_name($name),'datas'=>$this->_encode_data($data)),'REPLACE');
		return $config;
	}
	
	public function count($name){
		global $mysql;
		
		$count = $mysql->select('config','*',array(true,'number'),array('name'=>$this->__hash_name($name)));
		return $count;
	}
	
	private function __hash_name($name){
		$name = hash($this->hashs,$name);
		$name = $this->keya.$name;
		$name = hash($this->hashs,$name);
		return $name;
	}
	
	private function _decode_data($data){
		list($key,$string) = explode('?.',$data);
		if($key == $this->keya){
			$data = base64_decode($data);
		}
		return $data;
	}
	
	private function _encode_data($data){
		$data = base64_encode($data);
		$data = str_replace('=','',$data);
		$data = $this->keya.'?.'.$data;
		
		return $data;
		
		
	}
	
	public function sha1($str) {
    if(!function_exists('mhash')) {
      require_once('sha1.php');
      $sha1 = new SHA1;
      return $sha1->generate($str);
    } else {
      return bin2hex(mhash(MHASH_SHA1, $str));
    }
  }
}
?>