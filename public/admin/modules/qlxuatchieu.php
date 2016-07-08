<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
$today = date("Y-m-d H:i:s");
$xuatchieu = isset($_GET['id'])?mysql_fetch_array($t->get_xuatchieu(htmlspecialchars($_GET['id']))):null;
$xuatchieu_list = $t->get_xuatchieu_list($params);
$code = isset($_GET['code'])?htmlspecialchars($_GET['code']):0;
$btn = "Thêm mới";
if($code == 0){
	//thêm
	if(isset($_POST['submit'])){
		$data = array(
			'id' => htmlspecialchars($_POST['id']),
			'performance_time' => htmlspecialchars($_POST['performance_time']),
			'today' => $today,
			);

		if($_POST['submit'] == 'add'){
			if($data['performance_time']==''){
				echo "<script>error('Trường gắn gấu (*) không được để trống','?act=qlxuatchieu');</script>";
				exit();
			}
			$respone = $t->add_xuatchieu($data);
			if($respone === false){
				echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlxuatchieu');</script>";
				exit();
			}else{
				echo "<script>success('Thêm mới thành công','?act=qlxuatchieu');</script>";
				exit();
			}
		}else if($_POST['submit'] == 'find'){
			$xuatchieu_list =  $t->find_xuatchieu($data);
			$hide_pag = 'class="sr-only"';
			$btn_del_find = '<a href="?act=qlxuatchieu"><button type="button" class="btn btn-default">Xóa Tìm Kiếm</button></a>';
			$xuatchieu = $data;
		}
	}
	
}else if($code == 1){
	//sửa
	if(isset($_POST['submit'])){
		$data = array(
			'id' => htmlspecialchars($_POST['id']),
			'performance_time' => htmlspecialchars($_POST['performance_time']),
			'today' => $today,
			);

		$respone = $t->update_xuatchieu($data);
		if($respone === false){
			echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlxuatchieu');</script>";
			exit();
		}else{
			echo "<script>success('Sửa thành công','?act=qlxuatchieu');</script>";
			exit();
		}
	}

	$btn = "Cập nhật";
}else if($code == 2){
	//xóa
	$respone = $t->delete_xuatchieu(htmlspecialchars($_GET['id']));
	if($respone === false){
		echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlxuatchieu');</script>";
		exit();
	}else{
		echo "<script>success('Xóa thành công','?act=qlxuatchieu');</script>";
		exit();
	}
}

?>
<script>
</script>
<div>
	<fieldset>
		<legend>Quản lý xuất chiếu</legend>
		<form id="qlxuatchieu-form" class="form" name="qlxuatchieu_form" action="?act=qlxuatchieu&code=<?=$code?>" method="post">
			<input type="text" class="sr-only" name="id" value="<?=$xuatchieu['id']?>">
			<div class="form-group">
				<label for="f_performance_time">Thời gian chiếu (*)</label>
				<input type="text" class="form-control" id="f_performance_time" name="performance_time" value="<?=$xuatchieu['performance_time']?>">
			</div>
			<button type="submit" name="submit" value="add" class="btn btn-default"><?=$btn?></button>
			<button type="submit" name="submit" value="find" class="btn btn-default">Tìm</button>
			<?=isset($btn_del_find)? $btn_del_find: ''?>
		</form>
	</fieldset>

	<br><hr>
	<fieldset>
		<legend>Danh sách xuất chiếu</legend>
		<div id="qlxuatchieu-list">
			<table class="table table-striped">
				<tr>
					<th>ID</th>
					<th>Thời gian</th>
					<th>Ngày tạo</th>
					<th>Lần sửa cuối</th>
					<th></th>
				</tr>
				<?php
				if(isset($xuatchieu_list) && $xuatchieu_list !== false){
				while ($data = mysql_fetch_array($xuatchieu_list)) {
					echo"<tr>
					<td>".$data['id']."</td>
					<td>".$data['performance_time']."</td>
					<td>".$data['created_at']."</td>
					<td>".$data['updated_at']."</td>
					<td>
					<a href='?act=qlxuatchieu&id=".$data['id']."&code=1'><button class='btn btn-default'>Sửa</button></a>
					 - 
					<a onclick='xoa(event,\"xuất chiếu ".$data['performance_time']."\",\"?act=qlxuatchieu&id=".$data['id']."&code=2\");'><button class='btn btn-default'>Xóa</button></a> </td>
				</tr>";
			}
			}else{
					echo "<tr><td class='text-center' colspan='5'>Chưa có dữ liệu</td></tr>";
				}
			?>
		</table>
	</div>
</fieldset>
</div>