<script>
/* Script written by Adam Khoury @ DevelopPHP.com */
/* Video Tutorial: http://www.youtube.com/watch?v=EraNFJiY0Eg */
function _(el){
	return document.getElementById(el);
}
function uploadFile(){
	$('#button_upload').button('loading');
	
	var email =  $("#inputbox1").val();
	var name =  $("#inputbox2").val();
	var group =  $("#inputbox3").val();
	var password = $("#inputbox4").val();
	
	//alert(file.name+" | "+file.size+" | "+file.type);
	var formdata = new FormData();
	formdata.append("email", email);
	formdata.append("name", name);
	formdata.append("group", group);
	formdata.append("password", password);
	var ajax = new XMLHttpRequest();
	ajax.upload.addEventListener("progress", progressHandler, false);
	ajax.addEventListener("load", completeHandler, false);
	ajax.addEventListener("error", errorHandler, false);
	ajax.addEventListener("abort", abortHandler, false);
	ajax.open("POST", "dashboard/add_user_process.php");
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
	_("loaded_n_total").innerHTML = "อัพโหลดแล้ว "+formatSizeUnits(event.loaded)+" / "+formatSizeUnits(event.total)+"<br>"+"ความเร็วอัพโหลด "+formatSizeUnits(speed_up)+" / วินาที"+"<br>"+"เสร็จสิ้นใน "+FormatSecondsAsDurationString(time_out)+" ชั่วโมง";
	_("status").innerHTML = Math.round(percent)+"% กำลังอัพโหลด...";
	old_size_up_c = event.loaded;
}
function completeHandler(event){
	if(event.target.responseText=="cant_add_user"){
		_("status").innerHTML = "move_uploaded_file() function failed";
		$("#process-upload").css("width","100%");
		$('#button_upload').button('reset');
		setstep(2);
	}else if(event.target.responseText=="success"){
		setstep(4);
	}else{
		$('#button_upload').button('reset');
		setstep(1);
	}
}
function errorHandler(event){_("status").innerHTML = "อัพโหลดไม่สำเร็จ";}
function abortHandler(event){_("status").innerHTML = "อัพโหลดผิดพลาด";}
</script>

<div class="box">
	<div class="box-header">
		<h3 class="box-title"><i class="glyphicon glyphicon-plus"></i> เพื่มบัญชี</h3>
        <div class="box-tools pull-right">                    
			<button type="button" class="btn btn-success btn-sm" onclick="javascript:window.location='?page=user';"><i class="glyphicon glyphicon-arrow-left"></i> กลับ</button>
		</div>
	</div><!-- /.box-header -->
	<div class="box-body table-responsive" id='box-step-1-2'>
		<table class="table">
			<tr>
				<td width="20%" valign="middle"><label for="inputbox1">อีเมล์</label></td>
				<td>
                	<input type="text" class="form-control" name="email" id="inputbox1" placeholder="ตัวอย่าง : exsample@test.me">
                </td>
			</tr>
			<tr>
				<td><label for="inputbox2">ชื่อ</label></td>
				<td><div class="input-group">
                	<div class="input-group-addon"><i class="fa fa-user"></i></div>
					<input type="text" id="inputbox2" class="form-control" name="name" placeholder="ตัวอย่าง : คน มนุษย์">
				</div></td>
			</tr>
			<tr>
				<td><label for="inputbox3">กลุ่มของบัญชี</label></td>
				<td>
					<select class="form-control input-sm" name="group" id="inputbox3">
					<?php
                        $q_g = $mysql->select('group','*',array(true,'query'),array(),array('name','ASC'));
                        while($v_g = mysql_fetch_array($q_g)){
                    ?>
                        <option value="<?php echo $v_g['name']?>"><?php echo $v_g['name']?></option>
                    <?php
                        }
                    ?>
                    </select>
				</td>
			</tr>
			<tr>
				<td><label for="inputbox4">รหัสผ่าน</label></td>
				<td>
					<input type="password" name="password" class="form-control button-uplad" id="inputbox4" placeholder="รหัสผ่าน">
				</td>
			</tr>
			<tr>
				<td colspan="2">
                	<div class="btn-group btn-group-justified" id='buttom-submit-step-1'>
                        <button type="submit" onclick="setstep(2);" style="width:100%;" class="btn btn-success">ยืนยันข้อมูล</button>
                    </div>
                    <div class="btn-group btn-group-justified" id='buttom-submit-step-2'>
                        <button type="submit" onclick="setstep(1);" style="width:50%;" class="btn btn-warning">แก้ไขข้อมุล</button>
                        <button type="submit" onclick="setstep(3);" style="width:50%;" class="btn btn-success">ยืนยันข้อมูล</button>
                	</div>
                </td>
			</tr>
		</table>
	</div><!-- /.box-body -->
    <div class="box-body table-responsive" id='box-step-3'>
		<div class="progress progress-striped">
			<div class="progress-bar progress-bar-primary active" id="process-upload" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
			</div>
		</div>
        <h4 id="status"></h4>
    </div>
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
			$("#box-step-3").hide(1);
		}else if(step === 2){
			$("#inputbox1").attr('disabled','disabled');
			$("#inputbox2").attr('disabled','disabled');
			$("#inputbox3").attr('disabled','disabled');
			$("#inputbox4").attr('disabled','disabled');
			$("#buttom-submit-step-1").hide(450,function(){
				$("#buttom-submit-step-2").show(450);
			});
		}else if(step === 3){
			$("#box-step-1-2").slideUp(1000,function(){
				$("#inputbox1").removeAttr('disabled');
				$("#inputbox2").removeAttr('disabled');
				$("#inputbox3").removeAttr('disabled');
				$("#inputbox4").removeAttr('disabled');
				$("#inputbox5").removeAttr('disabled');
				$("#box-step-3").slideDown(1000,function(){
					uploadFile();
				});
			});
		}else if(step === 4){
			window.location='?page=user';
		}else{
			setstep(1);	
		}
	}
	setstep(1);
</script>