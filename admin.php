<?php
session_start();
require_once('temp/superhead.php');

if($_POST && $_POST['action']=="login"){
	$login->get();
}else{
	unset($_COOKIE['secTok']);
	unset($_SESSION['secTok']);
	$key = $gen->generateRandomString();
	setcookie("secTok",$key,time()+3600,'/');
	$_SESSION['secTok'] = array($key,time()+3600);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: Admin System ::.</title>
<!--<link href="css/admin_log_o1pc.css" rev="stylesheet" rel="stylesheet" type="text/css" />-->
<?php eval("include_once('css/admin_log_o1pc.php');"); ?>
</head>

<body>
<div class="wrapper">
<div  class="google-header-bar  centered">
  <div class="header content clearfix"></div>
</div>
<div class="main content clearfix">
	<div class="card signin-card">
    <div class="banner">
		<h2>เข้าสู่ระบบเพื่อไปยังแผงจัดการ</h2>
	</div>
	<p class="profile-name"></p>
    <form method="post" enctype="multipart/form-data"
    action="<?php echo (file_exists(".htaccess")) ? $_SERVER['REQUEST_URI'] : basename($_SERVER['REQUEST_URI']) ; ?>"
    id="gaia_login_form">
    	<input name="action" value="login" type="hidden" />
		<input name="continue" type="hidden" value="https://www.google.co.th/">
		<input type="hidden" name="timeStmp" id="timeStmp" value="<?php echo time();?>">
		<input type="hidden" name="secTok" id="secTok" value="<?php echo $key; ?>">
		<input type="hidden" name="self" id="self" value="<?php echo $_SERVER['HTTP_REFERER']; ?>">
		<label class="hidden-label" for="Email">อีเมล</label>
		<input id="Email" name="Email" type="email" placeholder="อีเมล" spellcheck="false" class=""
        value="<?php if(isset($_POST)){echo $_POST['Email'];} ?>">
		<label class="hidden-label" for="Passwd">รหัสผ่าน</label>
		<input id="Passwd" name="Passwd" type="password" placeholder="รหัสผ่าน"
        <?php if(isset($_POST['fail'])){echo 'class="form-error"';} ?>>
        <?php if(isset($_POST['fail'])){ ?>
        <span role="alert" class="error-msg" id="errormsg_0_Passwd">
		อีเมลหรือรหัสผ่านที่ป้อนไม่ถูกต้อง
		<a href="" target="_blank" class="help-link">?</a>
		</span>
        <?php } ?>
		<input id="signIn" name="signIn" class="rc-button rc-button-submit" type="submit" value="ลงชื่อเข้าใช้">
    </form>
    </div>
</div>

<div class="google-footer-bar">
	<div class="footer content clearfix">
		<ul id="footer-list">
			<li> Auto Update Service Manager Panel </li>
			<li> License : <?php echo $lic->ShowLicense(); ?> </li>
			<li> Stats : <?php echo $lic->ShowStats(); ?></li>
		</ul>
	</div>
</div>
</body>
</html>