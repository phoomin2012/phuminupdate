<script>
/* Script written by Adam Khoury @ DevelopPHP.com */
/* Video Tutorial: http://www.youtube.com/watch?v=EraNFJiY0Eg */
function _(el){
	return document.getElementById(el);
}
function uploadFile(){
	$('#button_upload').button('loading');
	
	var name =  $("#inputbox1").val();
	var update_list =  $("#inputbox3").val();
	var update_add =  $("#inputbox4").val();
	var user_list =  $("#inputbox5").val();
	var user_add =  $("#inputbox6").val();
	var group_list =  $("#inputbox7").val();
	var group_add =  $("#inputbox8").val();
	var setting_view =  $("#inputbox9").val();
	var setting_change =  $("#inputbox10").val();
	
	//alert(file.name+" | "+file.size+" | "+file.type);
	var formdata = new FormData();
	formdata.append("name", name);
	formdata.append("update_list", update_list);
	formdata.append("update_add", update_add);
	formdata.append("user_list", user_list);
	formdata.append("user_add", user_add);
	formdata.append("group_list", group_list);
	formdata.append("group_add", group_add);
	formdata.append("setting_view", setting_view);
	formdata.append("setting_change", setting_change);
	var ajax = new XMLHttpRequest();
	ajax.upload.addEventListener("progress", progressHandler, false);
	ajax.addEventListener("load", completeHandler, false);
	ajax.addEventListener("error", errorHandler, false);
	ajax.addEventListener("abort", abortHandler, false);
	ajax.open("POST", "dashboard/add_group_process.php");
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
	if(event.target.responseText=="cant_add_group"){
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
		<h3 class="box-title"><i class="glyphicon glyphicon-plus"></i> เพิ่มกลุ่มบัญชี</h3>
        <div class="box-tools pull-right">                    
			<button type="button" class="btn btn-success btn-sm" onclick="javascript:window.location='?page=group';"><i class="glyphicon glyphicon-arrow-left"></i> กลับ</button>
		</div>
	</div><!-- /.box-header -->
	<div class="box-body table-responsive" id='box-step-1-2'>
		<table class="table">
			<tr>
				<td width="20%" valign="middle"><label for="inputbox1">ชื่อกลุ่ม</label></td>
				<td>
                	<input type="text" class="form-control" name="name" id="inputbox1" placeholder="ตัวอย่าง : owner">
                </td>
			</tr>
			<tr>
            	<td>ดูอัพเดรต<br />แก้ไขอัพเดรต</td>
				<td>
                    <select class="form-control input-sm" name="update_list" id="inputbox3">
                        <option value="1">ดูได้</option>
                        <option value="0">ดูไม่ได้</option>
                    </select>
                    <select class="form-control input-sm" name="update_add" id="inputbox4">
                        <option value="1">ดูได้</option>
                        <option value="0">ดูไม่ได้</option>
                    </select>
                </td>
            </tr>
            <tr>
            	<td>ดูบัญชี<br />แก้ไขบัญชี</td>
                <td>
                    <select class="form-control input-sm" name="user_list" id="inputbox5">
                        <option value="1">ดูได้</option>
                        <option value="0">ดูไม่ได้</option>
                    </select>
                    <select class="form-control input-sm" name="user_add" id="inputbox6">
                        <option value="1">ดูได้</option>
                        <option value="0">ดูไม่ได้</option>
                    </select>
                </td>
			</tr>
            <tr>
            	<td>ดูกลุ่มบัญชี<br />แก้ไขกลุ่มบัญชี</td>
                <td>
                    <select class="form-control input-sm" name="group_list" id="inputbox7">
                        <option value="1">ดูได้</option>
                        <option value="0">ดูไม่ได้</option>
                    </select>
                    <select class="form-control input-sm" name="group_add" id="inputbox8">
                        <option value="1">ดูได้</option>
                        <option value="0">ดูไม่ได้</option>
                    </select>
                </td>
            </tr>
            <tr>
            	<td>ดูการตั้งค่า<br />แก้ไขการตั้งค่า</td>
                <td>
                    <select class="form-control input-sm" name="setting_view" id="inputbox9">
                        <option value="1">ดูได้</option>
                        <option value="0">ดูไม่ได้</option>
                    </select>
                    <select class="form-control input-sm" name="setting_change" id="inputbox10">
                        <option value="1">ดูได้</option>
                        <option value="0">ดูไม่ได้</option>
                    </select>
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
			$("#inputbox3").removeAttr('disabled');
			$("#inputbox4").removeAttr('disabled');
			$("#inputbox5").removeAttr('disabled');
			$("#inputbox6").removeAttr('disabled');
			$("#inputbox7").removeAttr('disabled');
			$("#inputbox8").removeAttr('disabled');
			$("#inputbox9").removeAttr('disabled');
			$("#inputbox10").removeAttr('disabled');
			$("#buttom-submit-step-2").hide(450,function(){
				$("#buttom-submit-step-1").show(450);
			});
			$("#box-step-3").hide(1);
		}else if(step === 2){
			$("#inputbox1").attr('disabled','disabled');
			$("#inputbox3").attr('disabled','disabled');
			$("#inputbox4").attr('disabled','disabled');
			$("#inputbox5").attr('disabled','disabled');
			$("#inputbox6").attr('disabled','disabled');
			$("#inputbox7").attr('disabled','disabled');
			$("#inputbox8").attr('disabled','disabled');
			$("#inputbox9").attr('disabled','disabled');
			$("#inputbox10").attr('disabled','disabled');
			$("#buttom-submit-step-1").hide(450,function(){
				$("#buttom-submit-step-2").show(450);
			});
		}else if(step === 3){
			$("#box-step-1-2").slideUp(1000,function(){
				$("#inputbox1").removeAttr('disabled');
				$("#inputbox3").removeAttr('disabled');
				$("#inputbox4").removeAttr('disabled');
				$("#inputbox5").removeAttr('disabled');
				$("#inputbox6").removeAttr('disabled');
				$("#inputbox7").removeAttr('disabled');
				$("#inputbox8").removeAttr('disabled');
				$("#inputbox9").removeAttr('disabled');
				$("#inputbox10").removeAttr('disabled');
				$("#box-step-3").slideDown(1000,function(){
					uploadFile();
				});
			});
		}else if(step === 4){
			window.location='?page=group';
		}else{
			setstep(1);	
		}
	}
	setstep(1);
</script>