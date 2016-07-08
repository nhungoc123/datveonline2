<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
$today = date("Y-m-d H:i:s");

$phim_list = $t->get_phim_list();

//thêm
if(isset($_POST['submit'])){
	$data = array(
		'start' => htmlspecialchars($_POST['start']),
		'end' => htmlspecialchars($_POST['end']),
		'movie_id' => htmlspecialchars($_POST['movie_id'])
		);
	if($data['start']=='' && $data['end']=='' && $data['movie_id']==''){
		echo "<script>error('Thống kê cần ít nhất một giá trị nhập vào','?act=thongkephim');</script>";
		exit();
	}
	$thongke = $t->thongkephim($data);
}

?>


<div>
	<fieldset>
		<legend>Thống kê doanh thu</legend>
		<form id="qlghe-form" class="form" name="qlghe_form" action="?act=thongkephim" method="post">
			<div class="form-group">
				<label for="f_row">Từ ngày</label>
				<input  type="text" class="form-control" id="f_row" name="start" value="<?=isset($_POST['start'])?$_POST['start']:''?>">
			</div>
			<div class="form-group">
				<label for="f_col">Đến ngày</label>
				<input  type="text" class="form-control" id="f_col" name="end" value="<?=isset($_POST['end'])?$_POST['end']:''?>">
			</div>
			<div class="form-group">
				<label for="f_phim">Phim</label>
				<select  id="f_phim" name="movie_id" class="form-control"  style="width:365px">
					<option value="">Chọn phim</option>
					<?php
					while ($data = mysql_fetch_array($phim_list)) {
						if($_POST['movie_id'] == $data['id']){
							echo"<option value='".$data['id']."' selected>".$data['name']."</option>";
						}else{
							echo"<option value='".$data['id']."'>".$data['name']."</option>";
						}
					}
					?>
				</select>
			</div>
			<button type="submit" name="submit" value="add" class="btn btn-default">Thống kê</button>
		</form>
	</fieldset>

	<br><hr>
	<fieldset>
		<legend>Số liệu (top 50 phim hot)</legend>
		<div id="qlghe-list">
			<table class="table table-striped">
				<tr>
					<th>Phim</th>
					<th>Tổng số lần rating</th>
					<th>Trung bình rating</th>
				</tr>
				<?php
				if(isset($thongke) && $thongke !== false){
					while ($data = mysql_fetch_array($thongke)) {
						echo"<tr><td>".$data['m_name']."</td>
						<td>".$data['rate_time']."</td>
						<td>".round($data['average'],2)."</td>
					</tr>";
				}
			}else{
				echo "<tr><td class='text-center' colspan='3'>Chưa có số liệu thống kê</td></tr>";
			}
		?>
	</table>

</div>
</fieldset>
</div>
<script type="text/javascript">
	$('#f_row').datepicker({
		format: "yyyy-mm-dd"
	});
	$('#f_col').datepicker({
		format: "yyyy-mm-dd"
	});
</script>