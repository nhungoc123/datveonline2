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
$params['table_name'] = 'dtb_customer';
$record = $t->get_num_row($params);
$total_page = ceil($record / $params['per_page']);

$user = isset($_GET['id'])?mysql_fetch_array($t->get_user(htmlspecialchars($_GET['id']))):null;
$user_list = $t->get_user_list($params);


$code = isset($_GET['code'])?htmlspecialchars($_GET['code']):0;
$btn = "Thêm mới";
if($code == 0){
	//thêm
	if(isset($_POST['submit'])){
		$data = array(
			'id' => htmlspecialchars($_POST['id']),
			'name' => htmlspecialchars($_POST['name']),
			'password' => hash(HASH_ALGO, htmlspecialchars ( addslashes (trim($_POST['password'])))),
			'email' => htmlspecialchars($_POST['email']),
			'today' => $today,
			);
		if($_POST['submit'] == 'add'){
			if($data['name']=='' || $data['password']=='' || $data['email']==''){
				echo "<script>error('Trường gắn gấu (*) không được để trống','?act=qluser');</script>";
				exit();
			}
			$respone = $t->add_user($data);
			if($respone === false){
				echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qluser');</script>";
				exit();
			}else{
				echo "<script>success('Thêm mới thành công','?act=qluser');</script>";
				exit();
			}
		}else if($_POST['submit'] == 'find'){
			$user_list =  $t->find_user($data);
			$hide_pag = 'class="sr-only"';
			$btn_del_find = '<a href="?act=qluser"><button type="button" class="btn btn-default">Xóa Tìm Kiếm</button></a>';
			$user = $data;
		}
	}
	
}else if($code == 1){
	//sửa
	if(isset($_POST['submit'])){
		$data = array(
			'id' => htmlspecialchars($_POST['id']),
			'name' => htmlspecialchars($_POST['name']),
			'password' => hash(HASH_ALGO, htmlspecialchars ( addslashes (trim($_POST['password'])))),
			'email' => htmlspecialchars($_POST['email']),
			'today' => $today,
			);
		$respone = $t->update_user($data);
		if($respone === false){
			echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qluser');</script>";
			exit();
		}else{
			echo "<script>success('Sửa thành công','?act=qluser');</script>";
			exit();
		}
	}

	$btn = "Cập nhật";
}else if($code == 2){
	//xóa
	$respone = $t->khoa_user(htmlspecialchars($_GET['id']));
	if($respone === false){
		echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qluser');</script>";
		exit();
	}else{
		echo "<script>success('Xóa thành công','?act=qluser');</script>";
		exit();
	}
}

?>
<div>
	<fieldset>
		<legend>Quản lý nhân viên</legend>
		<form id="qluser-form" class="form" name="qluser_form" action="?act=qluser&code=<?=$code?>" method="post">
			<input type="text" class="sr-only" name="id" value="<?=$user['id']?>">
			<div class="form-group">
				<label for="f_status">Tên (*)</label>
				<input  type="text" class="form-control" id="f_status" name="name" value="<?=$user['name']?>">
			</div>
			<div class="form-group">
				<label for="f_tel">Mật khẩu (*)</label>
				<input type="password" class="form-control" id="f_tel" name="password" value="">
			</div>
			<div class="form-group">
				<label for="f_email">Email (*)</label>
				<input  type="email" class="form-control" id="f_email" name="email" value="<?=$user['email']?>">
			</div>

			<button type="submit" name="submit" value="add" class="btn btn-default"><?=$btn?></button>
			<button type="submit" name="submit" value="find" class="btn btn-default">Tìm</button>
			<?=isset($btn_del_find)? $btn_del_find: ''?>
		</form>
	</fieldset>

	<br><hr>
	<fieldset>
		<legend>Danh sách nhân viên</legend>
		<div id="qluser-list" class="table-responsiuser">
			<table class="table table-striped">
				<tr>
					<th>ID</th>
					<th>Tên</th>
					<th>Email</th>
					<th>Ngày tạo</th>
					<th>Lần sửa cuối</th>
					<th></th>
				</tr>
				<?php
				if(isset($user_list) && $user_list !== false){
					while ($data = mysql_fetch_array($user_list)) {
						echo"<tr>
						<td>".$data['id']."</td>
						<td>".$data['name']."</td>
						<td>".$data['email']."</td>
						<td>".$data['created_at']."</td>
						<td>".$data['updated_at']."</td>
						<td><a href='?act=qluser&id=".$data['id']."&code=1'><button class='btn btn-default'>Sửa</button></a>
							- <a onclick='xoa(event,\"Khách hàng ".$data['name']."\",\"?act=qluser&id=".$data['id']."&code=2\");' ><button class='btn btn-default'>Khóa</button></a> </td>
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
							<a href="<?php if($current_page != 1) echo "?act=qluser&page=".$prev_page."" ?>"  aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						</li>
						<?php }	?>
						<?php
						if($total_page<7){
							for ($i=1; $i <= $total_page; $i++) { 
								if($i == $current_page){
									echo '<li class="active"><a href="?act=qluser&page='.$i.'">'.$i.'</a></li>';
								}else{
									echo '<li ><a href="?act=qluser&page='.$i.'">'.$i.'</a></li>';
								}
							}
						}else{
							if($current_page>2 && $current_page<=$total_page - 2){
								echo '<li ><a href="?act=qluser&page='.($current_page-2).'">'.($current_page-2).'</a></li>';
								echo '<li ><a href="?act=qluser&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qluser&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qluser&page='.($current_page+1).'">'.($current_page+1).'</a></li>';
								echo '<li ><a href="?act=qluser&page='.($current_page+2).'">'.($current_page+2).'</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qluser&page='.$total_page.'">'.$total_page.'</a></li>';
							}elseif($current_page==1){
								echo '<li class="active"><a href="?act=qluser&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qluser&page='.($current_page+1).'">'.($current_page+1).'</a></li>';
								echo '<li ><a href="?act=qluser&page='.($current_page+2).'">'.($current_page+2).'</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qluser&page='.$total_page.'">'.$total_page.'</a></li>';
							}elseif($current_page==2){
								echo '<li ><a href="?act=qluser&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qluser&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qluser&page='.($current_page+1).'">'.($current_page+1).'</a></li>';
								echo '<li ><a href="?act=qluser&page='.($current_page+2).'">'.($current_page+2).'</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qluser&page='.$total_page.'">'.$total_page.'</a></li>';
							}elseif($current_page==($total_page - 1)){
								echo '<li ><a href="?act=qluser&page=1">1</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qluser&page='.($current_page-2).'">'.($current_page-2).'</a></li>';
								echo '<li ><a href="?act=qluser&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qluser&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qluser&page='.($current_page+1).'">'.($current_page+1).'</a></li>';		
							}elseif($current_page==$total_page){
								echo '<li ><a href="?act=qluser&page=1">1</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qluser&page='.($current_page-2).'">'.($current_page-2).'</a></li>';
								echo '<li ><a href="?act=qluser&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qluser&page='.$current_page.'">'.$current_page.'</a></li>';	
							}
						}
						
						?>
						<?php if($total_page != 1){?>
							<li <?php if($current_page == $total_page) echo "class='disabled'" ?> >
								<a href="<?php if($current_page != $total_page) echo "?act=qluser&page=".$next_page."" ?>"  aria-label="Next">
									<span aria-hidden="true">&raquo;</span>
								</a>
							</li>
							<?php }	?>
						</ul>
					</nav>
				</div>
			</fieldset>
		</div>