<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
$today = date("Y-m-d H:i:s");
$loaighe = isset($_GET['id'])?mysql_fetch_array($t->get_loaighe(htmlspecialchars($_GET['id']))):null;
$loaighe_list = $t->get_loaighe_list($params);
$code = isset($_GET['code'])?htmlspecialchars($_GET['code']):0;
$btn = "Thêm mới";
if($code == 0){
	//thêm
	if(isset($_POST['submit'])){
		$data = array(
			'id' => htmlspecialchars($_POST['id']),
			'type' => htmlspecialchars($_POST['type']),
			'today' => $today,
			);
		$t->add_loaighe($data);
		header('Location: '.$root.'modules/index.php?act=qlloaighe');
		exit();
	}
	
}else if($code == 1){
	//sửa
	if(isset($_POST['submit'])){
		$data = array(
			'id' => htmlspecialchars($_POST['id']),
			'type' => htmlspecialchars($_POST['type']),
			'today' => $today,
			);
		$t->update_loaighe($data);
		header('Location: '.$root.'modules/index.php?act=qlloaighe');
		exit();
	}

	$btn = "Cập nhật";
}else if($code == 2){
	//xóa
	$t->delete_loaighe(htmlspecialchars($_GET['id']));
	header('Location: '.$root.'modules/index.php?act=qlloaighe');
	exit();
}

?>
<script>
	function(){
	}
</script>
<div>
	<fieldset>
		<legend>Quản lý loại ghế</legend>
		<form id="qlloaighe-form" class="form" name="qlloaighe_form" action="?act=qlloaighe&code=<?=$code?>" method="post">
			<input type="text" class="sr-only" name="id" value="<?=$loaighe['id']?>">
			<div class="form-group">
				<label for="f_name">Tên loại</label>
				<input required type="text" class="form-control" id="f_name" name="type" value="<?=$loaighe['type']?>">
			</div>
			<button type="submit" name="submit" class="btn btn-default"><?=$btn?></button>
		</form>
	</fieldset>

	<br><hr>
	<fieldset>
		<legend>Danh sách loại ghế</legend>
		<div id="qlloaighe-list">
			<table class="table table-striped">
				<tr>
					<th>ID</th>
					<th>Tên loại</th>
					<th>Ngày tạo</th>
					<th>Lần sửa cuối</th>
					<th></th>
				</tr>
				<?php
				while ($data = mysql_fetch_array($loaighe_list)) {
					echo"<tr>
					<td>".$data['id']."</td>
					<td>".$data['type']."</td>
					<td>".$data['created_at']."</td>
					<td>".$data['updated_at']."</td>
					<td><a href='?act=qlloaighe&id=".$data['id']."&code=1'><button class='btn btn-default'>Sửa</button></a> - <a href='?act=qlloaighe&id=".$data['id']."&code=2'><button class='btn btn-default'>Xóa</button></a> </td>
				</tr>";
			}
			?>
		</table>
	</div>
</fieldset>
</div>