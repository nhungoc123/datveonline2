<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
$today = date("Y-m-d H:i:s");

$rapchieu_list = $t->get_rap_list();
$phim_list = $t->get_phim_list();

//thêm
if(isset($_POST['submit'])){
	$data = array(
		'start' => htmlspecialchars($_POST['start']),
		'end' => htmlspecialchars($_POST['end']),
		'movie_id' => htmlspecialchars($_POST['movie_id']),
		'cinema_id' => htmlspecialchars($_POST['cinema_id']),
		);
	if($data['start']=='' && $data['end']=='' && $data['movie_id']=='' && $data['cinema_id']==''){
		echo "<script>error('Thống kê cần ít nhất một giá trị nhập vào','?act=thongkedoanhthu');</script>";
		exit();
	}

	$thongke = $t->thongkedoanhthu($data);
	$sum = 0;
	$temp = $t->thongkedoanhthu($data);
	while ($data = mysql_fetch_array($temp)) {
		$sum += intval($data['total']);
	}

}
function formatMoney($number, $fractional=false) { 
	if ($fractional) { 
		$number = sprintf('%.2f', $number); 
	} 
	while (true) { 
		$replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number); 
		if ($replaced != $number) { 
			$number = $replaced; 
		} else { 
			break; 
		} 
	} 
	return $number; 
} 

?>


<div>
	<fieldset>
		<legend>Thống kê doanh thu</legend>
		<form id="qlghe-form" class="form" name="qlghe_form" action="?act=thongkedoanhthu" method="post">
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
			<div class="form-group">
				<label for="f_rap">Rạp chiếu</label>
				<select  id="f_rap" name="cinema_id" class="form-control"  style="width:365px">
					<option value="">Chọn rạp chiếu</option>
					<?php
					while ($data = mysql_fetch_array($rapchieu_list)) {
						if($_POST['cinema_id'] == $data['id']){
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
		<legend>Số liệu</legend>
		<div id="qlghe-list">
			<h4 class="text-center">Tổng doanh thu : <?=isset($sum)?formatMoney($sum):0?><sup>đ</sup></h4>
			<table class="table table-striped">
				<tr>
					<th>Ngày</th>
					<th>Phim</th>
					<th>Rạp chiếu</th>
					<th>Doanh thu</th>
				</tr>
				<?php
				if(isset($thongke) && $thongke !== false){
					while ($data = mysql_fetch_array($thongke)) {
						echo"<tr>
						<td>".$data['date']."</td>
						<td>".$data['m_name']."</td>
						<td>".$data['c_name']."</td>
						<td>".formatMoney($data['total'])."<sup>đ</sup></td>
					</tr>";
				}
			}else{
				echo "<tr><td class='text-center' colspan='4'>Chưa có số liệu thống kê</td></tr>";
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