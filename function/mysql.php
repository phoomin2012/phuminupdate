<?php
class Mysql{
  private $host;
  private $user;
  private $passwd;
  private $database;
  private $prefix;
  public $sql;
  
  function __construct($request=array(),$host="localhost",$user="root",$pass="root",$database="",$prefix=""){
    if(count($request)!=6){
      $this->host = $host;
      $this->user = $user;
      $this->passwd = $pass;
      $this->database = $database;
      $this->prefix = $prefix;
    }else{
      $this->host = $request[0];
      $this->user = $request[1];
      $this->passwd = $request[2];
      $this->database = $request[3];
      $this->prefix = $request[5];
    }
  }
  
  function __destruct() {
    //$this->discon();
	//ทำงานสุดท้าย
  }
  
  private function con($debug=false){
    mysql_connect($this->host,$this->user,$this->passwd);
    mysql_select_db($this->database);
	mysql_query("SET NAMES UTF8");
	mysql_query("SET character_set_results=utf8");
	mysql_query("SET character_set_client=utf8");
	mysql_query("SET character_set_connection=utf8");
    ($debug===true) ? die(mysql_error()) : '';
  }
  private function discon(){
	mysql_close();
  }
  public function query($sql, $debug = false) {
    $this->con();
    $query = mysql_query($sql);
    return ($debug===true) ? die(mysql_error()) : $query;
    $this->discon();
  }
  public function select($table,$colum,$return=array(true,"query"),$where=array(),$order=array(),$limite=array(0,NULL),$debug=false){
    $this->con();
    $sql = "SELECT ".$colum." FROM ".$this->prefix.$table."";
    (count($where)!=0) ? $sql.=" WHERE".$this->_where($where)."" : '';
    (count($order)!=0) ? $sql.=" ORDER BY ".$order[0]." ".$order[1]."" : '';
    ($limite[1]!=NULL&&$limite[0]!=0) ? $sql.=" LIMIT ".$limite[0].",".($limite[1]) : '';
    $sql .= ";";
    $rt=mysql_query($sql);
    if($rt !== false) {
      if($return[0] === true) {
		switch($return[1]){
		  case 'query'	:	$rt=mysql_query($sql);						break;
		  case 'q'	:	$rt=mysql_query($sql);						break;
		  
		  case 'result'	:	$rt=mysql_result(mysql_query($sql));		break;
		  case 'res'	:	$rt=mysql_result(mysql_query($sql));		break;
		  
		  case 'array'	:	$rt=mysql_fetch_array(mysql_query($sql));	break;
		  case 'arr'	:	$rt=mysql_fetch_array(mysql_query($sql));	break;
		  
		  case 'number'	:	$rt=mysql_num_rows(mysql_query($sql));		break;
		  case 'num'	:	$rt=mysql_num_rows(mysql_query($sql));		break;
          default		:	$rt=true;									break;
		}
        return $rt;
      }else{
        return $rt;
	  }
    } else {
      $rt = false;
      return $rt;
    }
    if($debug === true) {
		echo '<br>'.$sql.'<br>';
		if(mysql_error())die(mysql_error());
    }
  }
  
  public function update($table,$value=array(),$where=array(),$order=array(),$limit=array(0,NULL),$debug=false){
	global $scu;
	$this->con();
	
	$sql = "UPDATE ".$this->prefix.$table." SET ";
	foreach($value as $k => $v) {
      $colun .= $k." = ".'\''.$scu->StringProtect($v).'\',';
    }
	$colun = substr($colun, 0, -1).'';
	$sql.= $colun;
	
	(count($where)!=0) ? $sql.=" WHERE".$this->_where($where)."" : '';
    (count($order)!=0) ? $sql.=" ORDER BY ".$order[0]." ".$order[1]."" : '';
	
	($limite[1]!==NULL&&$limite[0]!==0) ? $sql.=" LIMIT ".$limite[0].",".($limite[1]) : '';
    $sql .= ";";
	
	$this->sql=$sql;
    $q=mysql_query($sql);
	
	if($q !== false){return true;}else{return false;}
    if($debug === true) {
		echo '<br>'.$sql.'<br>';
		//if(mysql_error())die(mysql_error());
    }
  }
  
  public function delete($table,$where=array(),$debug=false){
    $this->con();
    $sql = "DELETE FROM ".$this->prefix.$table." WHERE ".$this->_where($where);
    $q = mysql_query($sql);
    ($debug===true) ? die(mysql_error()) : ($q !== false ? true:false);
  }
  
  public function add($table, $value = array(), $type = "INSERT", $debug = false) {
    global $scu;
    $this->con();
    
    $colun = "(";
    $values = 'VALUES (';
    foreach($value as $k => $v) {
      $colun .= $k.",";
      $values .= '\''.$scu->StringProtect($v).'\',';
    }
    $colun = substr($colun, 0, -1).')';
    $values = substr($values, 0, -1).')';
    $sql = $type.' INTO '.$this->prefix.$table.' '.$colun.' '.$values.';';
    $rt = mysql_query($sql);
    if($debug === true) {
		echo '<br>'.$sql.'<br>';
		if(mysql_error())die(mysql_error());
    } else {
      return $rt;
    }
  }
  
  private function _where($field, $value = NULL, $type = 'AND') {
    global $scu;
    $rt = '';
    if(!is_array($field)) {
      $field = array($field => $value);
    }
    
    foreach($field as $field1 => $value1) {
      $field1 = trim($field1);
      if(!$this->_checkOperator($field1)) {
        $field1 = $field1.' =';
      }
      $rt .= ' '.$field1.' \''.$value1.'\' '.$type.'';
    }
    $rt = substr($rt, 0, -1);
    $rt = trim($rt, $type);
    $rt = substr($rt, 0, -1).'';
    return $rt;
  }
  
  private function _order($field, $value = NULL, $type = 'AND'){
    
  }
  
  private function _checkOperator($str) {
    $str = trim($str);
    if(preg_match("/(\s|<|>|!|=|is null|is not null)/i", $str)) {
      return true;
    }
    return false;
  }
}
?>