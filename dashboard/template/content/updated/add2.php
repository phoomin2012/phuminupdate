<script>
function _(el){
	return document.getElementById(el);
}
function uploadFile(){
	$('#button_upload').button('loading');
	
	var serial =  $("#inputbox1").val();
	var serect =  $("#inputbox2").val();
	var registykey = $("#inputbox3").val();
	
	//alert(file.name+" | "+file.size+" | "+file.type);
	var formdata = new FormData();
	formdata.append("name", serial);
	formdata.append("date", serect);
	formdata.append("enabled", registykey);
	var ajax = new XMLHttpRequest();
	ajax.upload.addEventListener("progress", progressHandler, false);
	ajax.addEventListener("load", completeHandler, false);
	ajax.addEventListener("error", errorHandler, false);
	ajax.addEventListener("abort", abortHandler, false);
	ajax.open("POST", "dashboard/upload_setting.php");
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
	var res = event.target.responseText.match('/success/gi');
	if(res="success"){
		window.location='?page=update_add&s=1&'+event.target.responseText;
	}else{
		alert(event.target.responseText);
		setstep(1);
	}
}
function errorHandler(event){_("status").innerHTML = "อัพโหลดไม่สำเร็จ";}
function abortHandler(event){_("status").innerHTML = "อัพโหลดผิดพลาด";}
</script>
		<form id="form-insert-upload" name="form-insert-upload" method="post" enctype="multipart/form-data">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title"><i class="glyphicon glyphicon-plus"></i> เพิ่มเวอร์ชั่น</h3>
			        <div class="box-tools pull-right">                    
						<button type="button" class="btn btn-success btn-sm" onclick="javascript:window.location='?page=update_list';"><i class="glyphicon glyphicon-arrow-left"></i> กลับ</button>
					</div>
				</div><!-- /.box-header -->
				<div class="box-body table-responsive" id='box-step-1-2'>
					<table class="table">
						<tr>
							<td width="20%" valign="middle"><label for="inputbox1">ชื่อของเวอร์ชั่น</label></td>
							<td><input type="text" class="form-control" name="name" id="inputbox1" placeholder="ตัวอย่าง : 1.0.0.0"></td>
						</tr>
						<tr>
							<td><label for="inputbox2">เวลาเปิดใช้งาน</label></td>
							<td><div class="input-group">
								<input type="text" id="inputbox2" class="form-control" name="date" value="<?php echo date('Y-m-d H:i:s');?>">
								<div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
							</div></td>
						</tr>
						<tr>
							<td><label for="inputbox3">เวลาเปิดใช้งาน</label></td>
							<td>
								<select name="enabled" class="form-control" id="inputbox3">
									<option value="true">ใช้งาน</option>
									<option value="false">ไม่ใช้งาน</option>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="2">
			                	<div class="btn-group btn-group-justified" id='buttom-submit-step-1'>
			                        <button type="button" onclick="setstep(2);" style="width:100%;" class="btn btn-success">ยืนยันข้อมูล</button>
			                    </div>
			                    <div class="btn-group btn-group-justified" id='buttom-submit-step-2'>
			                        <button type="button" onclick="setstep(1);" style="width:50%;" class="btn btn-warning">แก้ไขข้อมุล</button>
			                        <button type="button" onclick="setstep(3);" style="width:50%;" class="btn btn-success">ยืนยันข้อมูล</button>
			                	</div>
			                </td>
						</tr>
					</table>
				</div><!-- /.box-body -->
			    <div class="box-body table-responsive" id='box-step-3'>
					<div class="progress progress-striped active">
						<div class="progress-bar progress-bar-primary" id="process-upload" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
						</div>
					</div>
			        <h4 id="status"></h4>
			    </div>
			</div><!-- /.box -->
		</form>
		<script>
			var step_upload = 1;
			function setstep(step){
				step_upload = step;
				if(step === 1){
					$("#inputbox1").removeAttr('disabled');
					$("#inputbox2").removeAttr('disabled');
					$("#inputbox3").removeAttr('disabled');
					$("#buttom-submit-step-2").hide(450,function(){
						$("#buttom-submit-step-1").show(450);
					});
					$("#box-step-3").hide(1);
				}else if(step === 2){
					$("#inputbox1").attr('disabled','disabled');
					$("#inputbox2").attr('disabled','disabled');
					$("#inputbox3").attr('disabled','disabled');
					$("#buttom-submit-step-1").hide(450,function(){
						$("#buttom-submit-step-2").show(450);
						/*if($('#inputbox4')[0].files[0].size > (1048576 * 80)){
							alert("สามารถอัพโหลด Patch ได้ขนาดสูงสุดครั้งละ 80 MB เท่านั้น");
							setstep(1);
						}*/
					});
					
				}else if(step === 3){
					$("#box-step-1-2").slideUp(1000,function(){
						$("#inputbox1").removeAttr('disabled');
						$("#inputbox2").removeAttr('disabled');
						$("#inputbox3").removeAttr('disabled');
						$("#box-step-3").slideDown(1000,function(){
							uploadFile();
						});
					});
				}else if(step === 4){
					window.location='?page=update_list';
				}else{
					setstep(1);	
				}
			}
			setstep(1);
		</script>
