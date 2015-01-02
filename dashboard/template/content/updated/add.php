<script>
		(function($) {
			$.fn.serializefiles = function() {
				var obj = $(this);
				/* ADD FILE TO PARAM AJAX */
				var formData = new FormData();
				$.each($(obj).find("input[type='file']"), function(i, tag) {
					$.each($(tag)[0].files, function(i, file) {
						formData.append(tag.name, file);
					});
				});
				var params = $(obj).serializeArray();
				$.each(params, function (i, val) {
					formData.append(val.name, val.value);
				});
				return formData;
			};
		})(jQuery);
	
		function uploadFile() {
			$('#button_upload').button('loading');
			var serial =  $("#inputbox1")[0].files;
			var serect =  $("#inputbox2").val();
			var formdata = new FormData();
			formdata.append("upfile", serial);
			formdata.append("id", serect);
			var ajax = new XMLHttpRequest();
			ajax.upload.addEventListener("progress", progressHandler, false);
			ajax.addEventListener("load", completeHandler, false);
			ajax.addEventListener("error", errorHandler, false);
			ajax.addEventListener("abort", abortHandler, false);
			ajax.open("POST", "dashboard/upload_process.php");
			ajax.send($("#form-insert-upload").serializefiles());
		}

		function formatSizeUnits(bytes){
			if(bytes>=1073741824){
				bytes=(bytes/1073741824).toFixed(2)+' GB';
			}else if (bytes>=1048576){
				bytes=(bytes/1048576).toFixed(2)+' MB';
			}else if (bytes>=1024){
				bytes=(bytes/1024).toFixed(2)+' KB';
			}else if (bytes>1){
				bytes=bytes+' B';
			}else if (bytes==1){
				bytes=bytes+' B';
			}else{
				bytes='0 B';
			}
			return bytes;
		}
		
		function FormatSecondsAsDurationString( seconds ){
			var s = "";
			var days = Math.floor( ( seconds / 3600 ) / 24 );
			if ( days >= 1 ){
				s += days.toString() + " วัน" + ( ( days == 1 ) ? "" : "s" ) + " ";
				seconds -= days * 24 * 3600;
			}
			var hours = Math.floor( seconds / 3600 );
			s += GetPaddedIntString( hours.toString(), 2 ) + ":";
			seconds -= hours * 3600;
			var minutes = Math.floor( seconds / 60 );
			s += GetPaddedIntString( minutes.toString(), 2 ) + ":";
			seconds -= minutes * 60;
			s += GetPaddedIntString( Math.floor( seconds ).toString(), 2 );return s;
		}
		function GetPaddedIntString( n, numDigits ){
			var nPadded = n;
			for ( ; nPadded.length < numDigits ; ){
				nPadded = "0" + nPadded;
			}
			return nPadded;
		}

		var old_size_up_c = 0;
		var new_size_up_c = 0;
		var full_size_up  = 0;
		var title_web = $("title").html();
		
		var counttime_run = 0;
		var timeever_run = 0;
		var uppacksize = 0;
		var time_outs = 0;
		var speed_ups = 0;
		var maxs_calculatertime = 0;
		
		
		function calculatertimerun(up,maxs){
			maxs_calculatertime = maxs;
			uppacksize = uppacksize + up;
			if(counttime_run==0){
				setInterval(calculatertimerunmode1,1000);
				setInterval(calculatertimerunmode2,1000);
				counttime_run = 1;
			}
			timeever_run++;
			uppacksize = 0;
		}
		
		function calculatertimerunmode2(){
			if(timeever_run==0){
				return null;
			}else{
				return ((maxs_calculatertime - uppacksize)/((new_size_up_c - old_size_up_c)).toFixed(2)).toFixed(0);
			}
		}
		
		function calculatertimerunmode1(){
			if(timeever_run==0){
				return null;
			}else{
				return uppacksize.toFixed(2);
			}
		}
		
		var upload_size_in_second = 0;
		
		function ChangeStats(){
			
		}
	
		function progressHandler(event){
			upload_size_in_second = upload_size_in_second + event.loaded;
			new_size_up_c = event.loaded;
			full_size_up = event.total;
			var speed_up = ((new_size_up_c - old_size_up_c)).toFixed(2);
			var percent = (event.loaded / event.total) * 100;
			
			$("title").html("("+percent.toFixed(2)+"%)"+title_web);
			
			$("#process-upload").css("width",(percent)+"%");
			var time_out = ((full_size_up - new_size_up_c)/(speed_up)).toFixed(0);
			
			time_outs = calculatertimerun(event.loaded,event.total);
			speed_ups = calculatertimerun(event.loaded,event.total);
			
			$("#loaded_n_total").html("อัพโหลดแล้ว "+
				formatSizeUnits(event.loaded)+" / "+
				formatSizeUnits(event.total)+"<br>"+"ความเร็วอัพโหลด "+
				formatSizeUnits(speed_ups)+" / วินาที"+"<br>"+"เสร็จสิ้นใน "+
				FormatSecondsAsDurationString(time_out)+" ชั่วโมง"
			);
			$("#status").html(percent.toFixed(2)+"% กำลังอัพโหลด...");
			
			old_size_up_c = event.loaded;
			
		}
		function completeHandler(event){
			var res = event.target.responseText;
			if(res == "move_uploaded_file") {
				$("#status").html("การอัพโหลดไฟล์มีปัญหา");
				$("#process-upload").css("width", "100%");
				setstep(2);
			} else if(res == "zip") {
				$("#status").html("กรุณาอัพโหลดไฟล์ Zip");
				$("#process-upload").css("width", "100%");
				setstep(2);
			} else if(res == "error_no_file_select") {
				$("#status").html("กรุณาเลือกไฟล์ก่อน");
				$("#process-upload").css("width", "100%");
				setstep(2);
			} else if(res == "success") {
				setstep(4);
			} else {
				console.log(res);
				setstep(1);
			}
		}
		function errorHandler(event){$("#status").innerHTML = "อัพโหลดไม่สำเร็จ";}
		function abortHandler(event){$("#status").innerHTML = "อัพโหลดผิดพลาด";}
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
							<td><label for="inputbox4">เลือกไฟล์</label></td>
							<td>
								<input type="file" name="upfile" class="" id="inputbox1" accept="application/x-zip-compressed">
								<input type="hidden" name="id" class="" id="inputbox2" value="<?php echo $_GET['success'];?>">
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
					<p id="loaded_n_total"></p>
					<p id="loaded_n"></p>
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
						$("#inputbox4").removeAttr('disabled');
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
