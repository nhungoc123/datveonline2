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
$params['table_name'] = 'dtb_showtimes';
$record = $t->get_num_row($params);
$total_page = ceil($record / $params['per_page']);

$lichchieu = isset($_GET['id'])?mysql_fetch_array($t->get_lichchieu(htmlspecialchars($_GET['id']))):null;
$lichchieu_list = $t->get_lichchieu_list($params);
$phimrap_list = $t->get_phim_rap_list();
$xuatchieu_list = $t->get_xuatchieu_list();


$code = isset($_GET['code'])?htmlspecialchars($_GET['code']):0;
$btn = "Thêm mới";
if($code == 0){
	//thêm
	if(isset($_POST['submit'])){
		$data = array(
			'id' => htmlspecialchars($_POST['id']),
			'movie_cinema_id' => htmlspecialchars($_POST['movie_cinema_id']),
			'performance_id' => htmlspecialchars($_POST['performance_id']),
			'today' => $today,
			'status' => '',
			'price' => 0,
			);

		if($_POST['submit'] == 'add'){
			if($data['movie_cinema_id']=='' || $data['performance_id']==''){
				echo "<script>error('Trường gắn gấu (*) không được để trống','?act=qllichchieu');</script>";
				exit();
			}
			$respone = $t->add_lichchieu($data);
			if($respone['result'] == '1'){
				echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qllichchieu');</script>";
				exit();
			}else if($respone['result'] == '2'){
				echo "<script>error('Xuất chiếu tại rạp bị trùng giờ mới phim khác','?act=qllichchieu');</script>";
				exit();
			}else{
				echo "<script>success('Thêm mới thành công','?act=qllichchieu');</script>";
				exit();
			}
		}else if($_POST['submit'] == 'find'){
			$lichchieu_list =  $t->find_lichchieu($data);
			$hide_pag = 'class="sr-only"';
			$btn_del_find = '<a href="?act=qllichchieu"><button type="button" class="btn btn-default">Xóa Tìm Kiếm</button></a>';
			$lichchieu = $data;
		}
	}
	
}else if($code == 1){
	//sửa
	if(isset($_POST['submit'])){
		$data = array(
			'id' => htmlspecialchars($_POST['id']),
			'movie_cinema_id' => htmlspecialchars($_POST['movie_cinema_id']),
			'performance_id' => htmlspecialchars($_POST['performance_id']),
			'today' => $today,
			'status' => '',
			'price' => 0,
			);

		$respone = $t->update_lichchieu($data);
		if($respone['result'] == 1){
			echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qllichchieu');</script>";
			exit();
		}else if($respone['result'] == '2'){
			echo "<script>error('Xuất chiếu tại rạp bị trùng giờ mới phim khác','?act=qllichchieu');</script>";
			exit();
		}else{
			echo "<script>success('Sửa thành công','?act=qllichchieu');</script>";
			exit();
		}
	}

	$btn = "Cập nhật";
}else if($code == 2){
	//xóa
	$respone = $t->delete_lichchieu(htmlspecialchars($_GET['id']));
	if($respone === false){
		echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qllichchieu');</script>";
		exit();
	}else{
		echo "<script>success('Xóa thành công','?act=qllichchieu');</script>";
		exit();
	}
}

?>
<div>
	<fieldset>
		<legend>Quản lý lịch chiếu</legend>
		<form id="qllichchieu-form" class="form" name="qllichchieu_form" action="?act=qllichchieu&code=<?=$code?>" method="post">
			<input type="text" class="sr-only" name="id" value="<?=$lichchieu['id']?>">
			<div class="form-group">
				<label for="f_phimrap">Phim-Rạp (*)</label>
				<select  id="f_phimrap" name="movie_cinema_id" class="form-control"  style="width:365px">
					<option value="">Chọn phim - rạp</option>
					<?php
					while ($data = mysql_fetch_array($phimrap_list)) {
						if($lichchieu['movie_cinema_id'] == $data['id']){
							echo"<option value='".$data['id']."' selected>".$data['m_name']." - ".$data['c_name']."</option>";
						}else{
							echo"<option value='".$data['id']."'>".$data['m_name']." - ".$data['c_name']."</option>";
						}
					}
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="f_perf">Xuất chiếu (*)</label>
				<select  id="f_perf" name="performance_id" class="form-control"  style="width:365px">
					<option value="">Chọn xuất chiếu</option>
					<?php
					while ($data = mysql_fetch_array($xuatchieu_list)) {
						if($lichchieu['performance_id'] == $data['id']){
							echo"<option value='".$data['id']."' selected>".$data['performance_time']."</option>";
						}else{
							echo"<option value='".$data['id']."'>".$data['performance_time']."</option>";
						}
					}
					?>
				</select>
			</div>
			<button type="submit" name="submit" value="add" class="btn btn-default"><?=$btn?></button>
			<button type="submit" name="submit" value="find" class="btn btn-default">Tìm</button>
			<?=isset($btn_del_find)? $btn_del_find: ''?>
		</form>
	</fieldset>

	<br><hr>
	<fieldset>
		<legend>Danh sách lịch chiếu</legend>
		<div id="qllichchieu-list" class="table-responsive">
			<table class="table table-striped">
				<tr>
					<th>ID</th>
					<th>Phim - Rạp</th>
					<th>Xuất chiếu</th>
					<th>Ngày tạo</th>
					<th>Lần sửa cuối</th>
					<th></th>
				</tr>
				<?php
				if(isset($lichchieu_list) && $lichchieu_list !== false){
					while ($data = mysql_fetch_array($lichchieu_list)) {
						echo"<tr>
						<td>".$data['id']."</td>
						<td>".$data['m_name']." - ".$data['c_name']."</td>
						<td>".$data['performance_time']."</td>
						<td>".$data['created_at']."</td>
						<td>".$data['updated_at']."</td>
						<td><a href='?act=qllichchieu&id=".$data['id']."&code=1'><button class='btn btn-default'>Sửa</button></a>
							- <a onclick='xoa(event,\"phim ".$data['m_name']." - rạp ".$data['c_name']." - xuất ".$data['performance_time']."\",\"?act=qllichchieu&id=".$data['id']."&code=2\");' ><button class='btn btn-default'>Xóa</button></a> </td>
						</tr>";
					}
				}else{
					echo "<tr><td class='text-center' colspan='6'>Chưa có dữ liệu</td></tr>";
				}
				?>
			</table>
			<nav <?=isset($hide_pag)?$hide_pag:''?>>
				<ul class="pagination" style="float:right">
					<?php if($total_page != 1){?>
						<li <?php if($current_page == 1) echo "class='disabled'"; ?> >
							<a href="<?php if($current_page != 1) echo "?act=qllichchieu&page=".$prev_page."" ?>"  aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						</li>
						<?php }	?>
						<?php
						if($total_page<7){
							for ($i=1; $i <= $total_page; $i++) { 
								if($i == $current_page){
									echo '<li class="active"><a href="?act=qllichchieu&page='.$i.'">'.$i.'</a></li>';
								}else{
									echo '<li ><a href="?act=qllichchieu&page='.$i.'">'.$i.'</a></li>';
								}
							}
						}else{
							if($current_page>2 && $current_page<=$total_page - 2){
								echo '<li ><a href="?act=qllichchieu&page='.($current_page-2).'">'.($current_page-2).'</a></li>';
								echo '<li ><a href="?act=qllichchieu&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qllichchieu&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qllichchieu&page='.($current_page+1).'">'.($current_page+1).'</a></li>';
								echo '<li ><a href="?act=qllichchieu&page='.($current_page+2).'">'.($current_page+2).'</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qllichchieu&page='.$total_page.'">'.$total_page.'</a></li>';
							}elseif($current_page==1){
								echo '<li class="active"><a href="?act=qllichchieu&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qllichchieu&page='.($current_page+1).'">'.($current_page+1).'</a></li>';
								echo '<li ><a href="?act=qllichchieu&page='.($current_page+2).'">'.($current_page+2).'</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qllichchieu&page='.$total_page.'">'.$total_page.'</a></li>';
							}elseif($current_page==2){
								echo '<li ><a href="?act=qllichchieu&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qllichchieu&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qllichchieu&page='.($current_page+1).'">'.($current_page+1).'</a></li>';
								echo '<li ><a href="?act=qllichchieu&page='.($current_page+2).'">'.($current_page+2).'</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qllichchieu&page='.$total_page.'">'.$total_page.'</a></li>';
							}elseif($current_page==($total_page - 1)){
								echo '<li ><a href="?act=qllichchieu&page=1">1</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qllichchieu&page='.($current_page-2).'">'.($current_page-2).'</a></li>';
								echo '<li ><a href="?act=qllichchieu&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qllichchieu&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qllichchieu&page='.($current_page+1).'">'.($current_page+1).'</a></li>';		
							}elseif($current_page==$total_page){
								echo '<li ><a href="?act=qllichchieu&page=1">1</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qllichchieu&page='.($current_page-2).'">'.($current_page-2).'</a></li>';
								echo '<li ><a href="?act=qllichchieu&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qllichchieu&page='.$current_page.'">'.$current_page.'</a></li>';	
							}
						}
						
						?>
						<?php if($total_page != 1){?>
							<li <?php if($current_page == $total_page) echo "class='disabled'" ?> >
								<a href="<?php if($current_page != $total_page) echo "?act=qllichchieu&page=".$next_page."" ?>"  aria-label="Next">
									<span aria-hidden="true">&raquo;</span>
								</a>
							</li>
							<?php }	?>
						</ul>
					</nav>
				</div>
			</fieldset>
		</div>