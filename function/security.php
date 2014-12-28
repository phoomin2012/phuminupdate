<?php
class Security{
	function StringProtect($string="",$max=NULL,$html=true,$sql=true){
		($html===true) ? $string = htmlspecialchars($string) : $string = $string;
		($sql===true) ? $string = addslashes($string) : $string = $string;
		$string = preg_replace('/(&#x[0-9]{4};)/', '', $string);
		$string = strip_tags($string);
		($max != NULL) ? $string = substr($string,$max) : $string = $string;
		if(get_magic_quotes_gpc()){$string = stripslashes($string);}
		return $string;	
	}
	function SQLProtect($sql="",$html=false){
		($html===true) ? $sql = htmlspecialchars($sql) : $sql = $sql;
		$sql = mysql_real_escape_string($sql);
		if(get_magic_quotes_gpc()){$sql = stripslashes($sql);}
		
		return $sql;
	}
	function ValueProtect($value){
		$value = $this->StringProtect($value);
		if (get_magic_quotes_gpc()){$value = stripslashes($value);}
		if (!is_numeric($value)){$value = "'" . mysql_real_escape_string($value) . "'";}
		return $value;
	}
}
?>