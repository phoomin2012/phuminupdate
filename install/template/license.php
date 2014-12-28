<?php
	$INSTALL = true;
	$BASEDIR = '../../';
	require_once('../../temp/superhead.php');
	if($lic->Connect()===true){
?>
<script>
var ssl = $("#inputbox1").val();
var sss = $("#inputbox2").val();
var ssr = $("#inputbox3").val();
function checklicense(){
	ssl = $("#inputbox1").val();
	sss = $("#inputbox2").val();
	ssr = $("#inputbox3").val();
	$.ajax({
		type: "POST",
		url: "http://<?php echo $lic->server;?>/license/check/product/"+ssl+"/"+sss+"/"+ssr+".css",
		cache: false,
		dataType: "json",
		success: function(msg){
			alert( "Data Call : " + msg);
			$("p").append(msg);
			if(msg["product"] != "error:not_this_key"){
				global_data['license'] = new Array();
				global_data['license'][0] = ssl;
				global_data['license'][1] = sss;
				global_data['license'][2] = ssr;
				loadpage(3);
			}else{
				$("#inputbox1").removeAttr("disabled");
				$("#inputbox2").removeAttr("disabled");
				$("#inputbox3").removeAttr("disabled");
			}
		},
		error: function (res,stats){
			alert("Error : "+stats);
			console.log(res);
		},
		process: function(data){
			$("#inputbox1").attr('disabled','disabled');
			$("#inputbox2").attr('disabled','disabled');
			$("#inputbox3").attr('disabled','disabled');
		},
	});
}
$(window).unload(function(){
	var answer = confirm("do you want to check our other products");
    if (answer){
        alert("bye");
    }else{
        window.location = "../install.php";
    }
});
</script>
<div class="box box-solid box-primary">
	<div class="box-header">
    	<div class="box-title">
        	<h3>ตรวจสอบการ License Key</h3>
        </div>
    </div>
    <div class="box-body">
    	<table class="table">
        	<tr>
            	<td width="20%"><label for="inputbox1">License Key</label></td>
                <td><input type="text" class="form-control" name="serialkey" id="inputbox1" maxlength="255" placeholder="ตัวอย่าง : XXXXX-XXXXX-XXXXX-XXXXX"></td>
            </tr>
            <tr>
            	<td><label for="inputbox4">Secret Key</label></td>
                <td><input type="text" name="secretkey" class="form-control button-uplad" id="inputbox2" maxlength="255" placeholder="ตัวอย่าง : XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX"></td>
            </tr>
            <tr>
            	<td><label for="inputbox4">Registry Key</label></td>
                <td><input type="text" name="registrykey" class="form-control button-uplad" maxlength="100" id="inputbox3" placeholder="ไม่มีตัวอย่าง"></td>
            </tr>
            <tr>
            	<td colspan="2"><button type="submit" onclick="checklicense()" class="btn btn-block btn-success">ยืนยัน</button></td>
            </tr>
        </table>
	</div>
</div>
<?php
	}else{
?>
<div class="box box-solid box-danger">
	<div class="box-header">
		<h3 class="box-title">ตรวจสอบการ License Key</h3>
	</div>
	<div class="box-body">
    	ไม่สามารถเชื่อต่อกับเซิฟเวอร์ของ System-mc ได้อาจเกิดได้จาก 2 สาเหตุดังนี้<br />
        <code>1. ไม่สามารถเชื่อมต่อกับเซิฟเวอร์หลักของ System-mc ได้, กรุณาติดต่อ System-mc</code><br />
        <code>2. เว็บเบราเซอร์ของคุณใช้เวลา Request นานเกินไป หรือ เซิฟเวอร์ของคุณไม่สามารถเชื่อมต่อกับเซิฟเวอร์ของ System-mc ได</code>้
        
	</div>
</div>
<?php
	}
?>
