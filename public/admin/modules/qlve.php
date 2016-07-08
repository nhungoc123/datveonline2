<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
$today = date("Y-m-d H:i:s");

//code phân trang
if(isset($_GET['page']) && intval($_GET['page']) != 0){
	$params['page'] = intval($_GET['page']);
	$current_page = intval($_GET['page']);
}else{
	$current_page = 1;
}
$next_page = $current_page +1;
$prev_page = $current_page -1;
$params['table_name'] = 'dtb_tickets';
$record = $t->get_num_row($params);
$total_page = ceil($record / $params['per_page']);

$ve = isset($_GET['id'])?mysql_fetch_array($t->get_ve(htmlspecialchars($_GET['id']))):null;
$ve_list = $t->get_ve_list($params);
$lichchieu_list = $t->get_lichchieu_list();
$ghe_list = $t->get_ghe_list();
$phimrap_list = $t->get_phim_rap_list();
$rapchieu_list = $t->get_rap_list();

$code = isset($_GET['code'])?htmlspecialchars($_GET['code']):0;
$btn = "Thêm mới";
if($code == 0){
	//thêm
	if(isset($_POST['submit'])){
		$data = array(
			'id' => htmlspecialchars($_POST['id']),
			'showtime_id' => htmlspecialchars($_POST['showtime_id']),
			'seat_id' => htmlspecialchars($_POST['seat_id']),
			'customer_id' => htmlspecialchars($_POST['customer_id']),
			'status' => htmlspecialchars($_POST['status']),
			'date' => htmlspecialchars($_POST['date']),
			'today' => $today,
			);

		if($_POST['submit'] == 'add'){
			if($data['showtime_id']=='' || $data['seat_id']=='' || $data['date']=='' || $data['status']==''){
				echo "<script>error('Trường gắn gấu (*) không được để trống','?act=qlve');</script>";
				exit();
			}
			$respone = $t->add_ve($data);
			if($respone === false){
				echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlve');</script>";
				exit();
			}else{
				echo "<script>success('Thêm mới thành công','?act=qlve');</script>";
				exit();
			}
		}else if($_POST['submit'] == 'find'){
			$ve_list =  $t->find_ve($data);
			$hide_pag = 'class="sr-only"';
			$btn_del_find = '<a href="?act=qlve"><button type="button" class="btn btn-default">Xóa Tìm Kiếm</button></a>';
			$ve = $data;
		}
	}
	
}else if($code == 1){
	//sửa
	if(isset($_POST['submit'])){
		$data = array(
			'id' => htmlspecialchars($_POST['id']),
			'showtime_id' => htmlspecialchars($_POST['showtime_id']),
			'seat_id' => htmlspecialchars($_POST['seat_id']),
			'customer_id' => htmlspecialchars($_POST['customer_id']),
			'status' => htmlspecialchars($_POST['status']),
			'date' => htmlspecialchars($_POST['date']),
			'today' => $today,
			);
		$respone = $t->update_ve($data);
		if($respone === false){
			echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlve');</script>";
			exit();
		}else{
			echo "<script>success('Sửa thành công','?act=qlve');</script>";
			exit();
		}
	}

	$btn = "Cập nhật";
}else if($code == 2){
	//xóa
	$respone = $t->delete_ve(htmlspecialchars($_GET['id']));
	if($respone === false){
		echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlve');</script>";
		exit();
	}else{
		echo "<script>success('Xóa thành công','?act=qlve');</script>";
		exit();
	}
}

?>

<script type="text/javascript">
	
	function chon_phimrap(e,url,responid){
		$.ajax({
			type: "POST",
			url: url,
			dataType: "html",
			data:{
				movie_cinema_id: e.value,
			},
			success: function(result){
				if(result && result != 1) {
					$("#"+responid).html(result);
				}else{
					error('Phim rạp chưa có lịch chiếu, vui lòng chọn phim rạp khác','#');
					$("#"+responid).html('');
				}
			}
		});
	}
	function chon_rap(e,url,responid){
		$.ajax({
			type: "POST",
			url: url,
			dataType: "html",
			data:{
				cinema_id: e.value,
			},
			success: function(result){
				if(result && result != 1) {
					$("#"+responid).html(result);
				}else{
					error('Rạp chưa có ghế, vui lòng chọn rạp khác','#');
					$("#"+responid).html('');
				}
			}
		});
	}

</script>
<div>
	<fieldset>
		<legend>Quản lý vé</legend>
		<form id="qlve-form" class="form" name="qlve_form" action="?act=qlve&code=<?=$code?>" method="post">
			<input type="text" class="sr-only" name="id" value="<?=$ve['id']?>">
			<div class="form-group">
				<label for="movie_cinema_id">Phim-Rạp</label>
				<select  id="movie_cinema_id" name="movie_cinema_id" onchange="chon_phimrap(this,'load_lich_chieu.php','showtime_id')" class="form-control"  style="width:365px">
					<option value="">Chọn phim - rạp</option>
					<?php
					while ($data = mysql_fetch_array($phimrap_list)) {
						echo"<option value='".$data['id']."'>".$data['m_name']." - ".$data['c_name']."</option>";
					}
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="showtime_id">Lịch chiếu (*)</label>
				<select  id="showtime_id" name="showtime_id" class="form-control"  style="width:365px">
					<option value="<?=$ve['showtime_id']?>">Chọn lịch chiếu</option>
				</select>
			</div>
			<div class="form-group">
				<label for="f_rap">Rạp chiếu</label>
				<select  id="f_rap" name="cinema_id" onchange="chon_rap(this,'load_ghe.php','seat_id')" class="form-control"  style="width:365px">
					<option value="">Chọn rạp chiếu</option>
					<?php
					while ($data = mysql_fetch_array($rapchieu_list)) {
						if($phimrap['cinema_id'] == $data['id']){
							echo"<option value='".$data['id']."' selected>".$data['name']."</option>";
						}else{
							echo"<option value='".$data['id']."'>".$data['name']."</option>";
						}
					}
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="seat_id">Ghế (*)</label>
				<select  id="seat_id" name="seat_id" class="form-control"  style="width:365px">
					<option value="<?=$ve['seat_id']?>">Chọn ghế</option>
				</select>
			</div>
			<div class="form-group">
				<label for="f_status">Trạng thái (*)</label>
				<input  type="text" class="form-control" id="f_status" name="status" value="<?=$ve['status']?>">
			</div>
			<div class="form-group">
				<label for="f_date">Ngày (*)</label>
				<input  type="text" class="form-control" id="f_date" name="date" value="<?=$ve['date']?>">
			</div>

			<div class="form-group">
				<label for="f_cus">Khách hàng</label>
				<input  type="number" class="form-control" id="f_cus" name="customer_id" value="<?=$ve['customer_id']?>">
			</div>

			<!-- <button type="submit" name="submit" value="add" class="btn btn-default"><?=$btn?></button> -->
			<button type="submit" name="submit" value="find" class="btn btn-default">Tìm</button>
			<?=isset($btn_del_find)? $btn_del_find: ''?>
		</form>
	</fieldset>

	<br><hr>
	<fieldset>
		<legend>Danh sách vé</legend>
		<div id="qlve-list" class="table-responsive">
			<table class="table table-striped">
				<tr>
					<th>ID</th>
					<th>Lịch chiếu</th>
					<th>Ghế</th>
					<th>Ngày</th>
					<th>Trạng thái</th>
					<th>Khách hàng</th>
					<th>Ngày tạo</th>
					<th>Lần sửa cuối</th>
					<th style="min-width:160px"></th>
				</tr>
				<?php
				if(isset($ve_list) && $ve_list !== false){
					while ($data = mysql_fetch_array($ve_list)) {
						echo"<tr>
						<td>".$data['id']."</td>
						<td>".$data['m_name']." - ".$data['c_name']." - ".$data['performance_time']."</td>
						<td>hàng ".$data['row']." cột ".$data['column']."</td>
						<td>".$data['date']."</td>
						<td>".$data['status']."</td>
						<td>".$data['customer_name']."</td>
						<td>".$data['created_at']."</td>
						<td>".$data['updated_at']."</td>
						<td><a href='?act=qlve&id=".$data['id']."&code=1'><button class='btn btn-default'>Sửa</button></a>
							<a onclick='xoa(event,\"vé ".$data['m_name']." - ".$data['c_name']." - ".$data['performance_time']." hàng ".$data['row']." cột ".$data['column']."\",\"?act=qlve&id=".$data['id']."&code=2\");' ><button class='btn btn-default sr-only'>Xóa</button></a> </td>
						</tr>";
					}
				}else{
					echo "<tr><td class='text-center' colspan='9'>Chưa có dữ liệu</td></tr>";
				}
				?>
			</table>
			<nav <?=isset($hide_pag)?$hide_pag:''?>>
				<ul class="pagination" style="float:right">
					<?php if($total_page != 1){?>
						<li <?php if($current_page == 1) echo "class='disabled'"; ?> >
							<a href="<?php if($current_page != 1) echo "?act=qlve&page=".$prev_page."" ?>"  aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						</li>
						<?php }	?>
						<?php
						if($total_page<7){
							for ($i=1; $i <= $total_page; $i++) { 
								if($i == $current_page){
									echo '<li class="active"><a href="?act=qlve&page='.$i.'">'.$i.'</a></li>';
								}else{
									echo '<li ><a href="?act=qlve&page='.$i.'">'.$i.'</a></li>';
								}
							}
						}else{
							if($current_page>2 && $current_page<=$total_page - 2){
								echo '<li ><a href="?act=qlve&page='.($current_page-2).'">'.($current_page-2).'</a></li>';
								echo '<li ><a href="?act=qlve&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qlve&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qlve&page='.($current_page+1).'">'.($current_page+1).'</a></li>';
								echo '<li ><a href="?act=qlve&page='.($current_page+2).'">'.($current_page+2).'</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qlve&page='.$total_page.'">'.$total_page.'</a></li>';
							}elseif($current_page==1){
								echo '<li class="active"><a href="?act=qlve&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qlve&page='.($current_page+1).'">'.($current_page+1).'</a></li>';
								echo '<li ><a href="?act=qlve&page='.($current_page+2).'">'.($current_page+2).'</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qlve&page='.$total_page.'">'.$total_page.'</a></li>';
							}elseif($current_page==2){
								echo '<li ><a href="?act=qlve&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qlve&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qlve&page='.($current_page+1).'">'.($current_page+1).'</a></li>';
								echo '<li ><a href="?act=qlve&page='.($current_page+2).'">'.($current_page+2).'</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qlve&page='.$total_page.'">'.$total_page.'</a></li>';
							}elseif($current_page==($total_page - 1)){
								echo '<li ><a href="?act=qlve&page=1">1</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qlve&page='.($current_page-2).'">'.($current_page-2).'</a></li>';
								echo '<li ><a href="?act=qlve&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qlve&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qlve&page='.($current_page+1).'">'.($current_page+1).'</a></li>';		
							}elseif($current_page==$total_page){
								echo '<li ><a href="?act=qlve&page=1">1</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qlve&page='.($current_page-2).'">'.($current_page-2).'</a></li>';
								echo '<li ><a href="?act=qlve&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qlve&page='.$current_page.'">'.$current_page.'</a></li>';	
							}
						}
						
						?>
						<?php if($total_page != 1){?>
							<li <?php if($current_page == $total_page) echo "class='disabled'" ?> >
								<a href="<?php if($current_page != $total_page) echo "?act=qlve&page=".$next_page."" ?>"  aria-label="Next">
									<span aria-hidden="true">&raquo;</span>
								</a>
							</li>
							<?php }	?>
						</ul>
					</nav>
				</div>
			</fieldset>
		</div>
		<script type="text/javascript">
			$('#f_date').datepicker({
				format: "yyyy-mm-dd"
			});
		</script>