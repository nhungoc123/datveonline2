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
$params['table_name'] = 'dtb_movie_cinemas';
$record = $t->get_num_row($params);
$total_page = ceil($record / $params['per_page']);


$phimrap = isset($_GET['id'])?mysql_fetch_array($t->get_phim_rap(htmlspecialchars($_GET['id']))):null;
$phimrap_list = $t->get_phim_rap_list($params);
$rapchieu_list = $t->get_rap_list();
$phim_list = $t->get_phim_list();

//$xuatchieu_list = $t->get_xuatchieu_list($params);
$code = isset($_GET['code'])?htmlspecialchars($_GET['code']):0;
$btn = "Thêm mới";
if($code == 0){
	//thêm
	if(isset($_POST['submit'])){
		$data = array(
			'id' => htmlspecialchars($_POST['id']),
			'movie_id' =>  htmlspecialchars($_POST['movie_id']),
			'cinema_id' => htmlspecialchars($_POST['cinema_id']),
			'start_date' => htmlspecialchars($_POST['start_date']),
			'end_date' => htmlspecialchars($_POST['end_date']),
			'today' => $today,
			);

		if($_POST['submit'] == 'add'){
			if($data['movie_id']=='' || $data['cinema_id']=='' || $data['start_date']=='' || $data['end_date']==''){
				echo "<script>error('Trường gắn gấu (*) không được để trống','?act=qlphimrap');</script>";
				exit();
			}
			$respone = $t->add_phim_rap($data);
			if($respone === false){
				echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlphimrap');</script>";
				exit();
			}else{
				echo "<script>success('Thêm mới thành công','?act=qlphimrap');</script>";
				exit();
			}
		}else if($_POST['submit'] == 'find'){
			$phimrap_list =  $t->find_phim_rap($data);
			$hide_pag = 'class="sr-only"';
			$btn_del_find = '<a href="?act=qlphimrap"><button type="button" class="btn btn-default">Xóa Tìm Kiếm</button></a>';
			$phimrap = $data;
		}
	}
	
}else if($code == 1){
	//sửa
	if(isset($_POST['submit'])){
		$data = array(
			'id' => htmlspecialchars($_POST['id']),
			'movie_id' =>  htmlspecialchars($_POST['movie_id']),
			'cinema_id' => htmlspecialchars($_POST['cinema_id']),
			'start_date' => htmlspecialchars($_POST['start_date']),
			'end_date' => htmlspecialchars($_POST['end_date']),
			'today' => $today,
			);
		$respone = $t->update_phim_rap($data);
		if($respone === false){
			echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlphimrap');</script>";
			exit();
		}else{
			echo "<script>success('Sửa thành công','?act=qlphimrap');</script>";
			exit();
		}
	}

	$btn = "Cập nhật";
}else if($code == 2){
	//xóa

	$respone = $t->delete_phim_rap(htmlspecialchars($_GET['id']));
	if($respone === false){
		echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlphimrap');</script>";
		exit();
	}else{
		echo "<script>success('Xóa thành công','?act=qlphimrap');</script>";
		exit();
	}
}

?>
<div>
	<fieldset>
		<legend>Quản lý rạp chiếu - phim</legend>
		<form id="qlphimrap-form" class="form" name="qlphimrap_form" action="?act=qlphimrap&code=<?=$code?>" method="post">
			<input type="text" class="sr-only" name="id" value="<?=$phimrap['id']?>">
			<div class="form-group">
				<label for="f_phim">Phim (*)</label>
				<select  id="f_phim" name="movie_id" class="form-control"  style="width:365px">
					<option value="">Chọn phim</option>
					<?php
					while ($data = mysql_fetch_array($phim_list)) {
						if($phimrap['movie_id'] == $data['id']){
							echo"<option value='".$data['id']."' selected>".$data['name']."</option>";
						}else{
							echo"<option value='".$data['id']."'>".$data['name']."</option>";
						}
					}
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="f_rap">Rạp chiếu (*)</label>
				<select  id="f_rap" name="cinema_id" class="form-control"  style="width:365px">
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
				<label for="f_start">Ngày bắt đầu (*)</label>
				<input   type="text" class="form-control" id="f_start" name="start_date" value="<?=$phimrap['start_date']?>">
			</div>
			<div class="form-group">
				<label for="f_end">Ngày kết thúc (*)</label>
				<input   type="text" class="form-control" id="f_end" name="end_date" value="<?=$phimrap['end_date']?>">
			</div>
			<button type="submit" name="submit" value="add" class="btn btn-default"><?=$btn?></button>
			<button type="submit" name="submit" value="find" class="btn btn-default">Tìm</button>
			<?=isset($btn_del_find)? $btn_del_find: ''?>
		</form>
	</fieldset>

	<br><hr>
	<fieldset>
		<legend>Danh sách rạp chiếu - phim</legend>
		<div id="qlphimrap-list" class="table-responsive">
			<table class="table table-striped">
				<tr>
					<th>ID</th>
					<th>Tên phim</th>
					<th>Tên rạp</th>
					<th>Ngày bắt đầu</th>
					<th>Ngày kết thúc</th>
					<th>Ngày tạo</th>
					<th>Lần sửa cuối</th>
					<th style="min-width:160px"></th>
				</tr>
				<?php
				if(isset($phimrap_list) && $phimrap_list !== false){
					while ($data = mysql_fetch_array($phimrap_list)) {
						echo"<tr>
						<td>".$data['id']."</td>
						<td>".$data['m_name']."</td>
						<td>".$data['c_name']."</td>
						<td>".$data['start_date']."</td>
						<td>".$data['end_date']."</td>
						<td>".$data['created_at']."</td>
						<td>".$data['updated_at']."</td>
						<td>
							<a href='?act=qlphimrap&id=".$data['id']."&code=1'><button class='btn btn-default'>Sửa</button></a>
							- 
							<a onclick='xoa(event,\"phim ".$data['m_name']." - rạp ".$data['c_name']."\",\"?act=qlphimrap&id=".$data['id']."&code=2\");'><button class='btn btn-default'>Xóa</button></a> </td>
						</tr>";
					}
				}else{
					echo "<tr><td class='text-center' colspan='8'>Chưa có dữ liệu</td></tr>";
				}
				?>
			</table>
			<nav <?=isset($hide_pag)?$hide_pag:''?>>
				<ul class="pagination" style="float:right">
					<?php if($total_page != 1){?>
						<li <?php if($current_page == 1) echo "class='disabled'"; ?> >
							<a href="<?php if($current_page != 1) echo "?act=qlphimrap&page=".$prev_page."" ?>"  aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						</li>
						<?php }	?>
						<?php
						if($total_page<7){
							for ($i=1; $i <= $total_page; $i++) { 
								if($i == $current_page){
									echo '<li class="active"><a href="?act=qlphimrap&page='.$i.'">'.$i.'</a></li>';
								}else{
									echo '<li ><a href="?act=qlphimrap&page='.$i.'">'.$i.'</a></li>';
								}
							}
						}else{
							if($current_page>2 && $current_page<=$total_page - 2){
								echo '<li ><a href="?act=qlphimrap&page='.($current_page-2).'">'.($current_page-2).'</a></li>';
								echo '<li ><a href="?act=qlphimrap&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qlphimrap&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qlphimrap&page='.($current_page+1).'">'.($current_page+1).'</a></li>';
								echo '<li ><a href="?act=qlphimrap&page='.($current_page+2).'">'.($current_page+2).'</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qlphimrap&page='.$total_page.'">'.$total_page.'</a></li>';
							}elseif($current_page==1){
								echo '<li class="active"><a href="?act=qlphimrap&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qlphimrap&page='.($current_page+1).'">'.($current_page+1).'</a></li>';
								echo '<li ><a href="?act=qlphimrap&page='.($current_page+2).'">'.($current_page+2).'</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qlphimrap&page='.$total_page.'">'.$total_page.'</a></li>';
							}elseif($current_page==2){
								echo '<li ><a href="?act=qlphimrap&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qlphimrap&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qlphimrap&page='.($current_page+1).'">'.($current_page+1).'</a></li>';
								echo '<li ><a href="?act=qlphimrap&page='.($current_page+2).'">'.($current_page+2).'</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qlphimrap&page='.$total_page.'">'.$total_page.'</a></li>';
							}elseif($current_page==($total_page - 1)){
								echo '<li ><a href="?act=qlphimrap&page=1">1</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qlphimrap&page='.($current_page-2).'">'.($current_page-2).'</a></li>';
								echo '<li ><a href="?act=qlphimrap&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qlphimrap&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qlphimrap&page='.($current_page+1).'">'.($current_page+1).'</a></li>';		
							}elseif($current_page==$total_page){
								echo '<li ><a href="?act=qlphimrap&page=1">1</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qlphimrap&page='.($current_page-2).'">'.($current_page-2).'</a></li>';
								echo '<li ><a href="?act=qlphimrap&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qlphimrap&page='.$current_page.'">'.$current_page.'</a></li>';	
							}
						}
						
						?>
						<?php if($total_page != 1){?>
							<li <?php if($current_page == $total_page) echo "class='disabled'" ?> >
								<a href="<?php if($current_page != $total_page) echo "?act=qlphimrap&page=".$next_page."" ?>"  aria-label="Next">
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
			$('#f_end').datepicker({
				format: "yyyy-mm-dd"
			});
			$('#f_start').datepicker({
				format: "yyyy-mm-dd"
			});
		</script>