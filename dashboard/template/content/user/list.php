<?php
	if(isset($_GET['del'])&&$_GET['del']!=""){
		$mysql->delete('user',array('id'=>$_GET['del']));
		header('location: ?page=user');
		echo '<script>eval(\'window.location="?page=user";\');</script>';
	}
	if(isset($_GET['save'])&&$_GET['save']!=""){
		$chk = $mysql->update('user',array(
			'`email`'=>$_POST['email'],
			'`name`'=>$_POST['name'],
			'`group`'=>$_POST['group']),array('`id`'=>$_GET['save']),array(),array(0,NULL),true);
		if($chk){
			//header('location: ?page=user&saved');
			/*echo '<script>eval(\'window.location="?page=user&saved";\');</script>';*/
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
?>
<div class="box">
    <div class="box-header">
        <h3 class="box-title">ข้อมูลบัญชีทั้งหมด</h3>    
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-success btn-sm <?php echo $disabled_menu['user'][1]; ?>" data-toggle="on" onclick="javascript:window.location='?page=user&add';">
                <i class="glyphicon glyphicon-plus"></i> เพิ่มบัญชี
            </button>
        </div>									
    </div><!-- /.box-header -->
    <div class="box-body table-responsive">
        <table id="example2" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th align="center">#</th>
                    <th align="center">อีเมล์</th>
                    <th align="center">ชื่อ</th>
                    <th align="center">กลุ่ม</th>
                    <th align="center">ตัวเลือก</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $q = $mysql->select('user','*',array(true,'query'),array(),array('id','ASC'));
                while($v = mysql_fetch_array($q)){
					if($v['email'] == "phoomin009@gmail.com" || $v['email'] == "demo@demo.demo"){}else
					{
                    	if(!isset($_GET['edit'])||$_GET['edit']==""||$_GET['edit']!=$v['id']){
            ?>
                <tr>
                    <td valign="middle"><?php echo $v['id']; ?></td>
                    <td valign="middle"><?php echo $v['email']; ?></td>
                    <td valign="middle"><?php echo $v['name']; ?></td>
                    <td valign="middle"><?php echo $v['group']; ?></td>
                    <td valign="middle" align="center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-warning <?php echo $disabled_menu['user'][1]; ?>"
                            onclick="window.location='?page=user&edit=<?php echo $v['id']; ?>';">
                                แก้ไข
                            </button>
                            <button type="button" class="btn btn-sm btn-danger <?php echo $disabled_menu['user'][1]; ?>"
                            onclick="window.location='?page=user&del=<?php echo $v['id']; ?>';">
                                ลบ
                            </button>
                        </div>
                    </td>
                </tr>
            <?php
                }else{
            ?>
                <tr>
                    <form action="?page=user&save=<?php echo $v['id']; ?>" enctype="multipart/form-data" method="post">
                        <td valign="middle"><?php echo $v['id']; ?></td>
                        <td valign="middle">
                        	<input type="email" class="form-control input-sm" name="email" value="<?php echo $v['email']; ?>" />
                        </td>
                        <td valign="middle">
                        	<input type="text" class="form-control input-sm" name="name" value="<?php echo $v['name']; ?>" />
                        </td>
                        <td valign="middle">
                        	<select class="form-control input-sm" name="group">
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
                        <td valign="middle" align="center">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-sm btn-success <?php echo $disabled_menu['user'][1]; ?>">
                                    บันทึก
                                </button>
                                <button type="button" class="btn btn-sm btn-danger"
                                onclick="window.location='?page=user';">
                                    ยกเลิก
                                </button>
                            </div>
                        </td>
                    </form>
                </tr>
            <?php
                }}}
            ?>
            </tbody>
            
            <tfoot>
                <tr>
                    <th align="center">#</th>
                    <th align="center">อีเมล์</th>
                    <th align="center">ชื่อ</th>
                    <th align="center">กลุ่ม</th>
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