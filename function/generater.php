<?php
class Generater{
	public function generateRandomString($length = 30,$prefix='',$suffix='') {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return ".AG5f".$randomString."==";
	}
	public function generateRandomStringNew($length = 30,$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_') {
		$randomString = '';
		for($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
	public function generate($string) {
		$string = str_replace('A',$this->generateRandomStringNew(1,'ABCDEFGHIJKLMNOPQRSTUVWXYZ'));
		$string = str_replace('a',$this->generateRandomStringNew(1,'abcdefghijklmnopqrstuvwxyz'));
		$string = str_replace('9',$this->generateRandomStringNew(1,'0123456789'));
		return $string;
	}
	public function superreplace($string,$characters=array("*"=>"")){
		$len = strlen($string);
		$newstring = $string;
		foreach($characters as $old => $replace){
			if($old=="*"){
				$newstring = "";
				$string = "";
				for($i=0;$i<$len;$i++){
					$newstring .= $replace;
				}
			}else{
				$newstring = str_replace($old,$replace,$newstring);
			}
		}
		return $newstring;
	}
}
?>