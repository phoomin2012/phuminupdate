<?php
	if(isset($_GET['del'])&&$_GET['del']!=""){
		$v = mysql_fetch_array(mysql_query("SELECT * FROM `".Prefix_Database."version` WHERE `id`='".$_GET['del']."';"));
		$mysql->delete('version',array('id'=>$_GET['del']));
		unlink("fileupdate/".$v['name'].".zip");
		header('location: ?page=update_list');
		echo '<script>eval(\'window.location="?page=update_list";\');</script>';
	}
	if(isset($_GET['save'])&&$_GET['save']!=""){
		if($mysql->update('version',array('name'=>$_POST['name'],'date'=>$_POST['date'],'enabled'=>$_POST['enabled']),array('id'=>$_GET['save']))){
			header('location: ?page=update_list&saved');
			echo '<script>eval(\'window.location="?page=update_list&saved";\');</script>';
		}else{
			echo '
				<div class="alert alert-danger alert-dismissable">
					<i class="fa fa-ban"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<b>แจ้งเตือน!</b> ทำการบันทึกไม่สำเร็จ กรุณาลองใหม่ภายหลัง
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
        <h3 class="box-title">ข้อมูลการอัพเดรต</h3>    
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-success btn-sm <?php echo $disabled_menu['update'][1]; ?>" data-toggle="on" onclick="javascript:window.location='?page=update_add';">
                <i class="glyphicon glyphicon-plus"></i> เพิ่มเมนู
            </button>
        </div>									
    </div><!-- /.box-header -->
    <div class="box-body table-responsive">
        <table id="example2" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th align="center">#</th>
                    <th align="center">เวอร์ชั่น</th>
                    <th align="center">เวลาที่เริ่มใช้งาน</th>
                    <th align="center">สถานะ</th>
                    <th align="center">ตัวเลือก</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $q = $mysql->select('version','*',array(true,'query'),array(),array('id','ASC'));
                while($v = mysql_fetch_array($q)){
                    if(!isset($_GET['edit'])||$_GET['edit']==""||$_GET['edit']!=$v['id']){
            ?>
                <tr>
                    <td valign="middle"><?php echo $v['id']; ?></td>
                    <td valign="middle"><?php echo $v['name']; ?></td>
                    <td valign="middle"><?php echo $v['date']; ?></td>
                    <td valign="middle"><?php echo $v['enabled']; ?></td>
                    <td valign="middle" align="center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-warning <?php echo $disabled_menu['update'][1]; ?>"
                            onclick="window.location='?page=update_list&edit=<?php echo $v['id']; ?>';">
                                แก้ไข
                            </button>
                            <button type="button" class="btn btn-sm btn-danger <?php echo $disabled_menu['update'][1]; ?>"
                            onclick="window.location='?page=update_list&del=<?php echo $v['id']; ?>';">
                                ลบ
                            </button>
                        </div>
                    </td>
                </tr>
            <?php
                }else{
            ?>
                <tr>
                    <form action="?page=update_list&save=<?php echo $v['id']; ?>" enctype="application/x-www-form-urlencoded" method="post">
                        <td valign="middle"><?php echo $v['id']; ?></td>
                        <td valign="middle"><input type="text" class="form-control input-sm" name="name" value="<?php echo $v['name']; ?>" /></td>
                        <td valign="middle"><input type="text" class="form-control input-sm" name="date" value="<?php echo date('Y-m-d H:i:s'); ?>" /></td>
                        <td valign="middle">
                            <select name="enabled" class="form-control input-sm">
                                <option value="true" <?php if($v['enabled']=="true"){echo "selected=\"selected\"";} ?>>true</option>
                                <option value="false" <?php if($v['enabled']=="false"){echo "selected=\"selected\"";} ?>>false</option>
                            </select>
                        </td>
                        <td valign="middle" align="center">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-sm btn-success <?php echo $disabled_menu['update'][1]; ?>">
                                    บันทึก
                                </button>
                                <button type="button" class="btn btn-sm btn-danger"
                                onclick="window.location='?page=update_list';">
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
                    <th align="center">เวอร์ชั่น</th>
                    <th align="center">เวลาที่เริ่มใช้งาน</th>
                    <th align="center">สถานะ</th>
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