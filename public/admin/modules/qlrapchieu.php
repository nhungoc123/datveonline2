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
$params['table_name'] = 'dtb_cinemas';
$record = $t->get_num_row($params);
$total_page = ceil($record / $params['per_page']);


$rapchieu = isset($_GET['id'])?mysql_fetch_array($t->get_rap(htmlspecialchars($_GET['id']))):null;
$rapchieu_list = $t->get_rap_list($params);


//$xuatchieu_list = $t->get_xuatchieu_list($params);
$code = isset($_GET['code'])?htmlspecialchars($_GET['code']):0;
$btn = "Thêm mới";
if($code == 0){
	//thêm
	if(isset($_POST['submit'])){
		$data = array(
			'id' => htmlspecialchars($_POST['id']),
			'name' =>  htmlspecialchars($_POST['name']),
			'description' => htmlspecialchars($_POST['description']),
			'seat_in_row' => htmlspecialchars($_POST['seat_in_row']),
			'total_seat' => htmlspecialchars($_POST['total_seat']),
			'today' => $today,
			);
		
		if($_POST['submit'] == 'add'){
			if($data['name']=='' || $data['seat_in_row']=='' || $data['total_seat']==''){
				echo "<script>error('Trường gắn gấu (*) không được để trống','?act=qlrapchieu');</script>";
				exit();
			}
			$respone = $t->add_rap($data);
			if($respone['result'] === '1'){
				echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlrapchieu');</script>";
				exit();
			}else{
				echo "<script>success('Thêm mới thành công','?act=qlrapchieu');</script>";
				exit();
			}
		}else if($_POST['submit'] == 'find'){
			$rapchieu_list =  $t->find_rap($data);
			$hide_pag = 'class="sr-only"';
			$btn_del_find = '<a href="?act=qlrapchieu"><button type="button" class="btn btn-default">Xóa Tìm Kiếm</button></a>';
			$rapchieu = $data;
		}
	}
	
}else if($code == 1){
	//sửa
	if(isset($_POST['submit'])){
		$data = array(
			'id' => htmlspecialchars($_POST['id']),
			'name' =>  htmlspecialchars($_POST['name']),
			'description' => htmlspecialchars($_POST['description']),
			'seat_in_row' => htmlspecialchars($_POST['seat_in_row']),
			'total_seat' => htmlspecialchars($_POST['total_seat']),
			'today' => $today,
			);
		$respone = $t->update_rap($data);
		if($respone['result'] == '1'){
			echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlrapchieu');</script>";
			exit();
		}else{
			echo "<script>success('Sửa thành công','?act=qlrapchieu');</script>";
			exit();
		}
	}
	$btn = "Cập nhật";
}else if($code == 2){
	//xóa

	$respone = $t->delete_rap(htmlspecialchars($_GET['id']));
	if($respone === false){
		echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlrapchieu');</script>";
		exit();
	}else{
		echo "<script>success('Xóa thành công','?act=qlrapchieu');</script>";
		exit();
	}
}

?>
<div>
	<fieldset>
		<legend>Quản lý rạp chiếu</legend>
		<form id="qlrapchieu-form" class="form" name="qlrapchieu_form" action="?act=qlrapchieu&code=<?=$code?>" method="post">
			<input type="text" class="sr-only" name="id" value="<?=$rapchieu['id']?>">
			<div class="form-group">
				<label for="f_name">Tên rạp (*)</label>
				<input type="text" class="form-control" id="f_name" name="name" value="<?=$rapchieu['name']?>">
			</div>
			<div class="form-group">
				<label for="f_desc">Mô tả</label>
				<textarea class="form-control" name="description" id="f_desc" style="width:365px"><?=$rapchieu['description']?></textarea>
			</div>
			<div class="form-group">
				<label for="f_seat">Tổng số ghế (*)</label>
				<input  type="number" class="form-control" id="f_seat" name="total_seat" value="<?=$rapchieu['total_seat']?>">
			</div>
			<div class="form-group">
				<label for="f_seat_in_row">Số ghế trên một hàng (*)</label>
				<input  type="number" class="form-control" id="f_seat_in_row" name="seat_in_row" value="<?=$rapchieu['seat_in_row']?>">
			</div>
			<button type="submit" name="submit" value="add" class="btn btn-default"><?=$btn?></button>
			<button type="submit" name="submit" value="find" class="btn btn-default">Tìm</button>
			<?=isset($btn_del_find)? $btn_del_find: ''?>
		</form>
	</fieldset>

	<br><hr>
	<fieldset>
		<legend>Danh sách rạp chiếu</legend>
		<div id="qlrapchieu-list" class="table-responsive">
			<table class="table table-striped">
				<tr>
					<th>ID</th>
					<th>Tên rạp chiếu</th>
					<th>Mô tả</th>
					<th>Tổng ghế</th>
					<th>Số ghế trên một hàng</th>
					<th>Ngày tạo</th>
					<th>Lần sửa cuối</th>
					<th style="min-width:160px"></th>
				</tr>
				<?php
				if(isset($rapchieu_list) && $rapchieu_list !== false){
					while ($data = mysql_fetch_array($rapchieu_list)) {
						//$xuatchieu_list = $t->get_xuatchieu_list($params);
						echo"<tr>
						<td>".$data['id']."</td>
						<td>".$data['name']."</td>
						<td>".$data['description']."</td>
						<td>".$data['total_seat']."</td>
						<td>".$data['seat_in_row']."</td>
						<td>".$data['created_at']."</td>
						<td>".$data['updated_at']."</td>
						<td>
							<a href='?act=qlrapchieu&id=".$data['id']."&code=1'><button class='btn btn-default'>Sửa</button></a>
							- 
							<a onclick='xoa(event,\"rạp chiếu ".$data['name']."\",\"?act=qlrapchieu&id=".$data['id']."&code=2\");'><button class='btn btn-default'>Xóa</button></a> </td>
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
							<a href="<?php if($current_page != 1) echo "?act=qlrapchieu&page=".$prev_page."" ?>"  aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						</li>
						<?php }	?>
						<?php
						if($total_page<7){
							for ($i=1; $i <= $total_page; $i++) { 
								if($i == $current_page){
									echo '<li class="active"><a href="?act=qlrapchieu&page='.$i.'">'.$i.'</a></li>';
								}else{
									echo '<li ><a href="?act=qlrapchieu&page='.$i.'">'.$i.'</a></li>';
								}
							}
						}else{
							if($current_page>2 && $current_page<=$total_page - 2){
								echo '<li ><a href="?act=qlrapchieu&page='.($current_page-2).'">'.($current_page-2).'</a></li>';
								echo '<li ><a href="?act=qlrapchieu&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qlrapchieu&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qlrapchieu&page='.($current_page+1).'">'.($current_page+1).'</a></li>';
								echo '<li ><a href="?act=qlrapchieu&page='.($current_page+2).'">'.($current_page+2).'</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qlrapchieu&page='.$total_page.'">'.$total_page.'</a></li>';
							}elseif($current_page==1){
								echo '<li class="active"><a href="?act=qlrapchieu&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qlrapchieu&page='.($current_page+1).'">'.($current_page+1).'</a></li>';
								echo '<li ><a href="?act=qlrapchieu&page='.($current_page+2).'">'.($current_page+2).'</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qlrapchieu&page='.$total_page.'">'.$total_page.'</a></li>';
							}elseif($current_page==2){
								echo '<li ><a href="?act=qlrapchieu&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qlrapchieu&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qlrapchieu&page='.($current_page+1).'">'.($current_page+1).'</a></li>';
								echo '<li ><a href="?act=qlrapchieu&page='.($current_page+2).'">'.($current_page+2).'</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qlrapchieu&page='.$total_page.'">'.$total_page.'</a></li>';
							}elseif($current_page==($total_page - 1)){
								echo '<li ><a href="?act=qlrapchieu&page=1">1</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qlrapchieu&page='.($current_page-2).'">'.($current_page-2).'</a></li>';
								echo '<li ><a href="?act=qlrapchieu&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qlrapchieu&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qlrapchieu&page='.($current_page+1).'">'.($current_page+1).'</a></li>';		
							}elseif($current_page==$total_page){
								echo '<li ><a href="?act=qlrapchieu&page=1">1</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qlrapchieu&page='.($current_page-2).'">'.($current_page-2).'</a></li>';
								echo '<li ><a href="?act=qlrapchieu&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qlrapchieu&page='.$current_page.'">'.$current_page.'</a></li>';	
							}
						}
						
						?>
						<?php if($total_page != 1){?>
							<li <?php if($current_page == $total_page) echo "class='disabled'" ?> >
								<a href="<?php if($current_page != $total_page) echo "?act=qlrapchieu&page=".$next_page."" ?>"  aria-label="Next">
									<span aria-hidden="true">&raquo;</span>
								</a>
							</li>
							<?php }	?>
						</ul>
					</nav>
				</div>
			</fieldset>
		</div>