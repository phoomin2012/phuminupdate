<script>
/* Script written by Adam Khoury @ DevelopPHP.com */
/* Video Tutorial: http://www.youtube.com/watch?v=EraNFJiY0Eg */
function _(el){
	return document.getElementById(el);
}
function uploadFile(){
	$('#button_upload').button('loading');
	
	var serial =  $("#inputbox1").val();
	var serect =  $("#inputbox2").val();
	var registykey = $("#inputbox3").val();
	var basedir = $("#inputbox0").val();
	
	//alert(file.name+" | "+file.size+" | "+file.type);
	var formdata = new FormData();
	formdata.append("serial", serial);
	formdata.append("serect", serect);
	formdata.append("registrykey", registykey);
	formdata.append("basedir",basedir);
	var ajax = new XMLHttpRequest();
	ajax.upload.addEventListener("progress", progressHandler, false);
	ajax.addEventListener("load", completeHandler, false);
	ajax.addEventListener("error", errorHandler, false);
	ajax.addEventListener("abort", abortHandler, false);
	ajax.open("POST", "dashboard/change_setting.php");
	ajax.send(formdata);
}

function formatSizeUnits(bytes){if(bytes>=1073741824){bytes=(bytes/1073741824).toFixed(2)+' GB';}else if (bytes>=1048576){bytes=(bytes/1048576).toFixed(2)+' MB';}else if (bytes>=1024){bytes=(bytes/1024).toFixed(2)+' KB';}else if (bytes>1){bytes=bytes+' ไบต์';}else if (bytes==1){bytes=bytes+' ไบต์';}else{bytes='0 ไบต์';}return bytes;}
function FormatSecondsAsDurationString( seconds ){var s = "";var days = Math.floor( ( seconds / 3600 ) / 24 );if ( days >= 1 ){s += days.toString() + " วัน" + ( ( days == 1 ) ? "" : "s" ) + " ";seconds -= days * 24 * 3600;}var hours = Math.floor( seconds / 3600 );s += GetPaddedIntString( hours.toString(), 2 ) + ":";seconds -= hours * 3600;var minutes = Math.floor( seconds / 60 );s += GetPaddedIntString( minutes.toString(), 2 ) + ":";seconds -= minutes * 60;s += GetPaddedIntString( Math.floor( seconds ).toString(), 2 );return s;}
function GetPaddedIntString( n, numDigits ){var nPadded = n;for ( ; nPadded.length < numDigits ; ){nPadded = "0" + nPadded;}return nPadded;}

var old_size_up_c = 0;
var new_size_up_c = 0;
var full_size_up  = 0;
function progressHandler(event){
	new_size_up_c = event.loaded;
	full_size_up = event.total;
	var speed_up = ((new_size_up_c - old_size_up_c)).toFixed(2);
	
	var percent = (event.loaded / event.total) * 100;
	$("#process-upload").css("width",(Math.round(percent)+0)+"%");
	var time_out = ((full_size_up - new_size_up_c)/(speed_up)).toFixed(0);
	old_size_up_c = event.loaded;
}
function completeHandler(event){
	if(event.target.responseText=="success"){
		setstep(4);
	}else{
		alert(event.target.responseText);
		setstep(1);
	}
}
function errorHandler(event){_("status").innerHTML = "อัพโหลดไม่สำเร็จ";}
function abortHandler(event){_("status").innerHTML = "อัพโหลดผิดพลาด";}
</script>
<div class="progress progress-striped" id='box-step-3' style="display:none;">
	<div class="progress-bar progress-bar-primary active" id="process-upload" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
</div>
<div class="box">
	<div class="box-header">
		<h3 class="box-title"><i class="glyphicon glyphicon-cog"></i> การตั้งค่า</h3>
	</div><!-- /.box-header -->
	<div class="box-body table-responsive" id='box-step-1-2'>
		<table class="table">
        	<tr>
            	<td width="20%" valign="middle">ที่อยู่ฐานข้อมุล</td>
                <td><?php echo Host_Database; ?></td>
            </tr>
            <tr>
            	<td width="20%" valign="middle">Username ฐานข้อมุล</td>
                <td><?php echo User_Database; ?></td>
            </tr>
            <tr>
            	<td width="20%" valign="middle">รหัสผ่านฐานข้อมุล</td>
                <td><?php echo Password_Database; ?></td>
            </tr>
            <tr>
            	<td width="20%" valign="middle">ตารางฐานข้อมุล</td>
                <td><?php echo Database_Select; ?></td>
            </tr>
            <tr>
            	<td width="20%" valign="middle">คำนำหน้าตาราง</td>
                <td><?php echo Prefix_Database; ?></td>
            </tr>
            <tr>
            	<td valign="middle"><label for="inputbox0">ที่อยู่หลัก</label></td>
                <td>
                	<input type="text" class="form-control" name="basedir" id="inputbox0" maxlength="50" placeholder="ค่าหลัก : fileupdate" value="<?php echo $configss->get('basedir'); ?>" />
                </td>
            </tr>
			<tr>
				<td valign="middle"><label for="inputbox1">License Key</label></td>
				<td>
                	<input type="text" class="form-control" name="serialkey" id="inputbox1" placeholder="ตัวอย่าง : XXXXX-XXXXX-XXXXX-XXXXX" value="<?php echo ($premission['setting'][1]==0)?($gen->superreplace($configss->get('serialkey'),array("*"=>"*"))):($configss->get('serialkey'));?>">
                </td>
			</tr>
			<tr>
				<td><label for="inputbox4">Secret Key</label></td>
				<td>
					<input type="text" name="secretkey" class="form-control button-uplad" id="inputbox2" placeholder="ตัวอย่าง : XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" value="<?php echo ($premission['setting'][1]==0)?($gen->superreplace($configss->get('secretkey'),array("*"=>"*"))):($configss->get('secretkey'));?>">
				</td>
			</tr>
            <tr>
				<td><label for="inputbox4">Registry Key</label></td>
				<td>
					<input type="text" name="registrykey" class="form-control button-uplad" id="inputbox3" placeholder="ไม่มีตัวอย่าง" value="<?php echo ($premission['setting'][1]==0)?($gen->superreplace($configss->get('registrykey'),array("*"=>"*"))):($configss->get('registrykey'));?>">
				</td>
			</tr>
			<tr>
				<td colspan="2">
                	<div class="btn-group btn-group-justified" id='buttom-submit-step-1'>
                        <button type="submit" onclick="setstep(2);" style="width:100%;" class="btn btn-success <?php echo $disabled_menu['setting'][1];?>">ยืนยันข้อมูล</button>
                    </div>
                    <div class="btn-group btn-group-justified" id='buttom-submit-step-2'>
                        <button type="submit" onclick="setstep(1);" style="width:50%;" class="btn btn-warning<?php echo $disabled_menu['setting'][1];?>">แก้ไขข้อมุล</button>
                        <button type="submit" onclick="setstep(3);" style="width:50%;" class="btn btn-success<?php echo $disabled_menu['setting'][1];?>">ยืนยันข้อมูล</button>
                	</div>
                </td>
			</tr>
		</table>
	</div><!-- /.box-body -->
</div><!-- /.box -->

<script>
	var step_upload = 1;
	function setstep(step){
		step_upload = step;
		if(step === 1){
			$("#inputbox1").removeAttr('disabled');
			$("#inputbox2").removeAttr('disabled');
			$("#inputbox3").removeAttr('disabled');
			$("#inputbox4").removeAttr('disabled');
			$("#buttom-submit-step-2").hide(450,function(){
				$("#buttom-submit-step-1").show(450);
			});
			$("#box-step-3").slideUp(1000);
		}else if(step === 2){
			$("#inputbox1").attr('disabled','disabled');
			$("#inputbox2").attr('disabled','disabled');
			$("#inputbox3").attr('disabled','disabled');
			$("#inputbox4").attr('disabled','disabled');
			$("#buttom-submit-step-1").hide(450,function(){
				$("#buttom-submit-step-2").show(450);
			});
		}else if(step === 3){
			//$("#box-step-1-2").slideUp(1000,function(){
				$("#inputbox1").removeAttr('disabled');
				$("#inputbox2").removeAttr('disabled');
				$("#inputbox3").removeAttr('disabled');
				$("#inputbox4").removeAttr('disabled');
				$("#inputbox5").removeAttr('disabled');
				$("#box-step-3").slideDown(1000,function(){
					uploadFile();
				});
			//});
		}else if(step === 4){
			$("#process-upload").css("width","0%");
			$("#box-step-3").slideUp(1000,function(){
				setstep(1);
			});
		}else{
			$("#box-step-3").slideUp(1000,function(){
				setstep(1);
			});
		}
	}
	setstep(1);
</script>