<?php
include_once("../controllers/qlxuatchieu_control.php");

?>
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