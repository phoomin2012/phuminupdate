<?php
ob_start();
class cookie {
  private $cookie = array();
  private $time_update = 300; // อัพเดต cookie ในแต่ละครั้งที่ refresh เป็นวินาที
  private $time_activity = 3600; // เวลาหมดอายุของ cookie เป็นวินาที
  private $all_field_request = array(
    'cookie_id',
    'ip_address',
    'user_agent',
    'last_activity'
  );
  
  public function __construct() {
    if($this->_read()) {
      $this->_update();
    } else {
      $this->_create();
    }
  }
  
  private function _create() {
    $id = '';
    while(strlen($id) < 32) {
      $id .= mt_rand(0, mt_getrandmax());
    }
    $id = $_SERVER['REMOTE_ADDR'];
	//$http_agent = substr($_SERVER['HTTP_USER_AGENT'], 0, 120);
	$http_agent = "";
    $value = array(
      'cookie_id' => md5(uniqid($id, true)),
      'ip_address' => $_SERVER['REMOTE_ADDR'],
      'user_agent' => $http_agent,
      'last_activity' => time()
    );
    $this->_set_cookie($value);
  }
  
  private function _read() {
    global $enc;
    if(!isset($_COOKIE['lib_cookie'])) {
      return false;
    }
    
    $value = $enc->decode($_COOKIE['lib_cookie']);
    $value = unserialize($value);
    
    if(count($value) <= 0 || !$this->_check_request_field($value)) {
      return false;
    }
    
    if(($value['last_activity'] + $this->time_activity) < time()) {
      return false;
    }
    
    if($value['ip_address'] != $_SERVER['REMOTE_ADDR']) {
      return false;
    }
    
    if($value['user_agent'] != "") {
      return false;
    }
    
    $this->cookie = $value;
    return true;
  }
  
  private function _update() {
    if(($this->cookie['last_activity'] + $this->time_update) >= time()) {
      return;
    }
    
    $this->cookie['ip_address'] = $_SERVER['REMOTE_ADDR'];
    $this->cookie['user_agent'] = substr($_SERVER['HTTP_USER_AGENT'], 0, 120);
    $this->cookie['last_activity'] = time();
    
    $this->_set_cookie();
  }
  
  private function _set_cookie($cookie = null) {
    global $enc;
    if(is_null($cookie)) {
      $cookie = $this->cookie;
    }
    
    setcookie('lib_cookie', $enc->encode(serialize($cookie)), 0, '/');
    $this->cookie = $cookie;
  }
  
  private function _check_request_field($array) {
    foreach($this->all_field_request as $value) {
      if(!array_key_exists($value, $array)) {
        return false;
      }
    }
    return true;
  }
  
  public function add($name, $value) {
    $this->cookie[$name] = $value;
    $this->_set_cookie();
  }
  
  public function chk($name) {
    return isset($this->cookie[$name]);
  }
  
  public function get($name) {
    return $this->chk($name) ? $this->cookie[$name]:'';
  }
  
  public function del($name) {
    unset($this->cookie[$name]);
    $this->_set_cookie();
  }
  
  public function getall() {
    return $this->cookie;
  }
}
?>