<?php
	if(isset($_GET['del'])&&$_GET['del']!=""){
		$mysql->delete('group',array('id'=>$_GET['del']));
		header('location: ?page=group');
		echo '<script>eval(\'window.location="?page=group";\');</script>';
	}
	if(isset($_GET['save'])&&$_GET['save']!=""){
		$chk = $mysql->update('group',array(
			'`name`'=>$_POST['name'],
			'`update_list`'=>$_POST['update_list'],
			'`update_add`'=>$_POST['update_add'],
			'`user_list`'=>$_POST['user_list'],
			'`user_add`'=>$_POST['user_add'],
			'`group_list`'=>$_POST['group_list'],
			'`group_add`'=>$_POST['group_add'],
			'`setting_view`'=>$_POST['setting_view'],
			'`setting_change`'=>$_POST['setting_change'],
			),array('`id`'=>$_GET['save']),array(),array(0,NULL),true);
			$chk2 = $mysql->update('user',array('`group`'=>$_POST['name']),array('`group`'=>$_POST['oldname']));
		if($chk&&$chk2){
			header('location: ?page=group&saved');
			echo '<script>eval(\'window.location="?page=group&saved";\');</script>';
		}else{
			echo '
				<div class="alert alert-danger alert-dismissable">
					<i class="fa fa-ban"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<b>แจ้งเตือน!</b> ทำการบันทึกไม่สำเร็จ กรุณาลองใหม่ภายหลัง<br>'.$mysql->sql.'<br>'.mysql_error().'
				</div>
			';
		}
	}
	if(isset($_GET['saved'])){
		echo '
			<div class="alert alert-success alert-dismissable">
				<i class="fa fa-check"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<b>แจ้งเตือน!</b> ทำการบันทึกสำเร็จ
			</div>
		';
	}
	function echopermission($f='0',$s='0'){
		if($f=='1'){echo '<font class="text-green">ดูได้</font>';}else{echo '<font class="text-red">ดูไม่ได้</font>';}
		if($s=='1'){echo '/<font class="text-green">แก้ไขได้</font>';}else{echo '/<font class="text-red">แก้ไขไม่ได้</font>';}
	}
?>
<div class="box">
    <div class="box-header">
        <h3 class="box-title">ข้อมุลกลุ่มบัญชี</h3>    
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-success btn-sm" data-toggle="on" onclick="javascript:window.location='?page=group&add';">
                <i class="glyphicon glyphicon-plus <?php echo $disabled_menu['group'][1]; ?>"></i> เพิ่มกลุ่ม
            </button>
        </div>									
    </div><!-- /.box-header -->
    <div class="box-body table-responsive">
        <table id="example2" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th align="center">#</th>
                    <th align="center">กลุ่มบัญชี</th>
                    <th align="center">ดู/เพิ่มรายการอัพเดรต</th>
                    <th align="center">ดู/เพิ่มบัญชี</th>
                    <th align="center">ดู/เพิ่มกลุ่มบัญชี</th>
                    <th align="center">ดู/แก้ไขการตั้งค่าพื้นฐาน</th>
                    <th align="center">ตัวเลือก</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $q = $mysql->select('group','*',array(true,'query'),array(),array('id','ASC'));
                while($v = mysql_fetch_array($q)){
                    if(!isset($_GET['edit'])||$_GET['edit']==""||$_GET['edit']!=$v['id']){
            ?>
                <tr>
                    <td valign="middle"><?php echo $v['id']; ?></td>
                    <td valign="middle"><?php echo $v['name']; ?></td>
                    <td valign="middle"><?php echopermission($v['update_list'],$v['update_add']); ?></td>
                    <td valign="middle"><?php echopermission($v['user_list'],$v['user_add']); ?></td>
                    <td valign="middle"><?php echopermission($v['group_list'],$v['group_add']); ?></td>
                    <td valign="middle"><?php echopermission($v['setting_view'],$v['setting_change']); ?></td>
                    <td valign="middle" align="center">
                        <div class="btn-group">
                            <button class="btn btn-sm btn-warning <?php echo $disabled_menu['group'][1]; ?>"
                            onclick="javascript:window.location='?page=group&edit=<?php echo $v['id']; ?>';">
                                แก้ไข
                            </button>
                            <button class="btn btn-sm btn-danger <?php echo $disabled_menu['group'][1]; ?>"
                            onclick="javascript:window.location='?page=group&del=<?php echo $v['id']; ?>';">
                                ลบ
                            </button>
                        </div>
                    </td>
                </tr>
            <?php
                }else{
            ?>
                <tr>
                    <form action="?page=group&save=<?php echo $v['id']; ?>" enctype="multipart/form-data" method="post">
                        <td valign="middle"><?php echo $v['id']; ?></td>
                        <td valign="middle">
                        	<input type="text" class="form-control input-sm"
                            name="name" style="width:80px;" value="<?php echo $v['name']; ?>" />
                            <input type="hidden" name="oldname" value="<?php echo $v['name']; ?>" />
                        </td>
                        <td valign="middle">
                        	<select class="form-control input-sm" name="update_list">
                            	<option value="1" <?php if($v['update_list']=='1'){echo 'selected="selected"';} ?>>ดูได้</option>
                                <option value="0" <?php if($v['update_list']=='0'){echo 'selected="selected"';} ?>>ดูไม่ได้</option>
                            </select>
                            <select class="form-control input-sm" name="update_add">
                            	<option value="1" <?php if($v['update_add']=='1'){echo 'selected="selected"';} ?>>ดูได้</option>
                                <option value="0" <?php if($v['update_add']=='0'){echo 'selected="selected"';} ?>>ดูไม่ได้</option>
                            </select>
                        </td>
                        <td valign="middle">
                        	<select class="form-control input-sm" name="user_list">
                            	<option value="1" <?php if($v['user_list']=='1'){echo 'selected="selected"';} ?>>ดูได้</option>
                                <option value="0" <?php if($v['user_list']=='0'){echo 'selected="selected"';} ?>>ดูไม่ได้</option>
                            </select>
                            <select class="form-control input-sm" name="user_add">
                            	<option value="1" <?php if($v['user_add']=='1'){echo 'selected="selected"';} ?>>ดูได้</option>
                                <option value="0" <?php if($v['user_add']=='0'){echo 'selected="selected"';} ?>>ดูไม่ได้</option>
                            </select>
                        </td>
                        <td valign="middle">
                        	<select class="form-control input-sm" name="group_list">
                            	<option value="1" <?php if($v['group_list']=='1'){echo 'selected="selected"';} ?>>ดูได้</option>
                                <option value="0" <?php if($v['group_list']=='0'){echo 'selected="selected"';} ?>>ดูไม่ได้</option>
                            </select>
                            <select class="form-control input-sm" name="group_add">
                            	<option value="1" <?php if($v['group_add']=='1'){echo 'selected="selected"';} ?>>ดูได้</option>
                                <option value="0" <?php if($v['group_add']=='0'){echo 'selected="selected"';} ?>>ดูไม่ได้</option>
                            </select>
                        </td>
                        <td valign="middle">
                        	<select class="form-control input-sm" name="setting_view">
                            	<option value="1" <?php if($v['setting_view']=='1'){echo 'selected="selected"';} ?>>ดูได้</option>
                                <option value="0" <?php if($v['setting_view']=='0'){echo 'selected="selected"';} ?>>ดูไม่ได้</option>
                            </select>
                            <select class="form-control input-sm" name="setting_change">
                            	<option value="1" <?php if($v['setting_change']=='1'){echo 'selected="selected"';} ?>>ดูได้</option>
                                <option value="0" <?php if($v['setting_change']=='0'){echo 'selected="selected"';} ?>>ดูไม่ได้</option>
                            </select>
                        </td>
                        <td valign="middle" align="center">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-sm btn-success <?php echo $disabled_menu['group'][1]; ?>">
                                    บันทึก
                                </button>
                                <button type="button" class="btn btn-sm btn-danger"
                                onclick="window.location='?page=group';">
                                    ยกเลิก
                                </button>
                            </div>
                        </td>
                    </form>
                </tr>
            <?php
                }}
            ?>
            </tbody>
            
            <tfoot>
                <tr>
                    <th align="center">#</th>
                    <th align="center">กลุ่มบัญชี</th>
                    <th align="center">ดู/เพิ่มรายการอัพเดรต</th>
                    <th align="center">ดู/เพิ่มบัญชี</th>
                    <th align="center">ดู/เพิ่มกลุ่มบัญชี</th>
                    <th align="center">ดู/แก้ไขการตั้งค่าพื้นฐาน</th>
                    <th align="center">ตัวเลือก</th>
                </tr>
            </tfoot>
        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->
<script type="text/javascript">
    $('#example2').dataTable({
		"aaSorting": [ [0,'asc'], [1,'asc'] ],
		"bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": true
    });
</script>