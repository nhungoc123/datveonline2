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
$params['per_page'] = 10;
$next_page = $current_page +1;
$prev_page = $current_page -1;
$params['table_name'] = 'dtb_movies';
$record = $t->get_num_row($params);
$total_page = ceil($record / $params['per_page']);

$phim = isset($_GET['id'])?mysql_fetch_array($t->get_phim(htmlspecialchars($_GET['id']))):null;
$phim_list = $t->get_phim_list($params);
$code = isset($_GET['code'])?htmlspecialchars($_GET['code']):0;
$btn = "Thêm mới";

$upload_dir = "../../../public/common/images/upload"; // The directory for the images to be saved in
$upload_path = $upload_dir."/";				       // The path to where the image will be saved

$video_upload_dir = "../../../public/common/upload";
$video_upload_path = $video_upload_dir."/";

if(!is_dir($upload_dir)){
	mkdir($upload_dir, 0777);
	chmod($upload_dir, 0777);
}

if(!is_dir($video_upload_dir)){
	mkdir($video_upload_dir, 0777);
	chmod($video_upload_dir, 0777);
}
		try {

if($code == 0){
	//thêm
	if(isset($_POST['submit'])) {

		$data = array(
			'id' => htmlspecialchars($_POST['id']),
			'name' =>  htmlspecialchars($_POST['name']),
			'genre' => htmlspecialchars($_POST['genre']),
			'image' => '',
			'description' => htmlspecialchars ( addslashes (trim($_POST['description']))),
			'actor' => htmlspecialchars($_POST['actor']),
			'year' => htmlspecialchars($_POST['year']),
			'durations' => htmlspecialchars($_POST['durations']),
			'trailer' => '',
			'today' => $today,
			);
		$uploaded = 0;
		if(isset($_FILES["image"]) && $_FILES["image"]["name"] != ''){
			$target_dir = $upload_path;
			$uploadOk = 1;
			do{
				$imagename = microtime(true);	
				$target_file = $target_dir . basename($_FILES["image"]["name"]);
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
				$imagename = $imagename.".".$imageFileType;
				$target_file = $target_dir . $imagename;
				if (file_exists($target_file)) {
					$uploadOk = 0;
				}else{
					$uploadOk = 1;
				}
			}while($uploadOk == 0);

			$check = getimagesize($_FILES["image"]["tmp_name"]);
			if($check !== false) {
				$uploadOk = 1;
			} else {
				$uploadOk = 0;
			}


			// if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
			// 	$uploadOk = 0;
			// }
			if ($uploadOk == 0) {
			} else {
				if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
					$uploaded = 1;
				} else {
					$uploaded = 0;
				}
			}	
		}
		$uploaded2 = 0;

		if(isset($_FILES["trailer"]) && $_FILES["trailer"]["name"] != ''){
			$target_dir = $video_upload_path;
			$uploadOk = 1;
			do{
				$videoname = microtime(true);	
				$target_file = $target_dir . basename($_FILES["trailer"]["name"]);
				echo $target_file;
				exit;
				$videoFileType = pathinfo($target_file,PATHINFO_EXTENSION);
				$videoname = $videoname.".".$videoFileType;
				$target_file = $target_dir . $videoname;
				if (file_exists($target_file)) {
					$uploadOk = 0;
				}else{
					$uploadOk = 1;
				}
			}while($uploadOk == 0);
			
			if ($uploadOk == 0) {
				//fail
			} else {
				if (move_uploaded_file($_FILES["trailer"]["tmp_name"], $target_file)) {
					$uploaded2 = 1;
				} else {
					$uploaded2 = 0;
				}
			}
		}

		if($uploaded == 0){
			// exit();
		}else{
			$data['image'] = $imagename;
		}
		if($uploaded2 == 0){
			// exit();
		}else{
			$data['trailer'] = $videoname;
		}

		if($_POST['submit'] == 'add'){
			if($data['name']=='' || $data['image'] == ''){
				echo "<script>error('Trường gắn gấu (*) không được để trống','?act=qlphim');</script>";
				exit();
			}
			$respone = $t->add_phim($data);
			if($respone === false){
				echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlphim');</script>";
				exit();
			}else{
				echo "<script>success('Thêm mới thành công','?act=qlphim');</script>";
				exit();
			}
		}else if($_POST['submit'] == 'find'){
			$phim_list =  $t->find_phim($data);
			$hide_pag = 'class="sr-only"';
			$btn_del_find = '<a href="?act=qlphim"><button type="button" class="btn btn-default">Xóa Tìm Kiếm</button></a>';
			$phim = $data;
		}

	}

}else if($code == 1){
	//sửa
	if(isset($_POST['submit'])){
		$uploaded = 0;
		if(isset($_FILES["image"]) && $_FILES["image"]["name"] != ''){
			$target_dir = $upload_path;
			
			$uploadOk = 1;
			do{
				$imagename = microtime(true);	
				$target_file = $target_dir . basename($_FILES["image"]["name"]);
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
				$imagename = $imagename.".".$imageFileType;
				$target_file = $target_dir . $imagename;
				if (file_exists($target_file)) {
					$uploadOk = 0;
				}else{
					$uploadOk = 1;
				}
			}while($uploadOk == 0);
			
			$check = getimagesize($_FILES["image"]["tmp_name"]);
			if($check !== false) {
				$uploadOk = 1;
			} else {
				$uploadOk = 0;
			}

			if ($uploadOk == 0) {
			} else {
				if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
					$uploaded = 1;
				} else {
					$uploaded = 0;
				}
			}	
		}
		$uploaded2 = 0;
		if(isset($_FILES["trailer"]) && $_FILES["trailer"]["name"] != ''){
			$target_dir = $video_upload_path;
			
			$uploadOk = 1;
			
			do{
				$videoname = microtime(true);	
				$target_file = $target_dir . basename($_FILES["trailer"]["name"]);
				$videoFileType = pathinfo($target_file,PATHINFO_EXTENSION);
				$videoname = $videoname.".".$videoFileType;
				$target_file = $target_dir . $videoname;
				if (file_exists($target_file)) {
					$uploadOk = 0;
				}else{
					$uploadOk = 1;
				}
			}while($uploadOk == 0);
			
			if ($uploadOk == 0) {
			} else {
				if (move_uploaded_file($_FILES["trailer"]["tmp_name"], $target_file)) {
					$uploaded2 = 1;
				} else {
					$uploaded2 = 0;
				}
			}
		}

		if($uploaded == 0 && $uploaded2 == 0){
			$data = array(
				'id' => htmlspecialchars($_POST['id']),
				'name' =>  htmlspecialchars($_POST['name']),
				'genre' => htmlspecialchars($_POST['genre']),
				'description' => htmlspecialchars ( addslashes (trim(($_POST['description'])))),
				'actor' => htmlspecialchars($_POST['actor']),
				'year' => htmlspecialchars($_POST['year']),
				'durations' => htmlspecialchars($_POST['durations']),
				//'trailer' => $videoname,
				'today' => $today,
				);
		}else if($uploaded == 1 && $uploaded2 == 1){
			$data = array(
				'id' => htmlspecialchars($_POST['id']),
				'name' =>  htmlspecialchars($_POST['name']),
				'genre' => htmlspecialchars($_POST['genre']),
				'image' => $imagename,
				'description' => htmlspecialchars ( addslashes (trim(($_POST['description'])))),
				'actor' => htmlspecialchars ( addslashes (trim(($_POST['actor'])))),
				'year' => htmlspecialchars($_POST['year']),
				'durations' => htmlspecialchars($_POST['durations']),
				'trailer' => $videoname,
				'today' => $today,
				);
		}else if($uploaded == 1){
			$data = array(
				'id' => htmlspecialchars($_POST['id']),
				'name' =>  htmlspecialchars($_POST['name']),
				'genre' => htmlspecialchars($_POST['genre']),
				'image' => $imagename,
				'description' => htmlspecialchars ( addslashes (trim(($_POST['description'])))),
				'actor' => htmlspecialchars ( addslashes (trim(($_POST['actor'])))),
				'year' => htmlspecialchars($_POST['year']),
				'durations' => htmlspecialchars($_POST['durations']),
				//'trailer' => basename( $_FILES["trailer"]["name"]),
				'today' => $today,
				);
		}else if($uploaded2 == 1){
			$data = array(
				'id' => htmlspecialchars($_POST['id']),
				'name' =>  htmlspecialchars($_POST['name']),
				'genre' => htmlspecialchars($_POST['genre']),
				//'image' => $imagename,
				'description' => htmlspecialchars ( addslashes (trim(($_POST['description'])))),
				'actor' => htmlspecialchars ( addslashes (trim(($_POST['actor'])))),
				'year' => htmlspecialchars($_POST['year']),
				'durations' => htmlspecialchars($_POST['durations']),
				'trailer' => $videoname,
				'today' => $today,
				);
		}
		$respone = $t->update_phim($data);
		if($respone === false){
			echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlphim');</script>";
			exit();
		}else{
			echo "<script>success('Sửa thành công','?act=qlphim');</script>";
			exit();
		}
	}

	$btn = "Cập nhật";
}else if($code == 2){
	//xóa
	$respone = $t->delete_phim(htmlspecialchars($_GET['id']));
	if($respone === false){
		echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlphim');</script>";
		exit();
	}else{
		echo "<script>success('Xóa thành công','?act=qlphim');</script>";
		exit();
	}
}

		} catch (RuntimeException $e) {

		    echo $e->getMessage();

		}
?>
<div>
	<fieldset>
		<legend>Quản lý phim</legend>
		<form id="qlphim-form"  class="form" name="qlphim_form" action="?act=qlphim&code=<?=$code?>" method="post" enctype="multipart/form-data">
			<input type="text" class="sr-only" name="id" value="<?=$phim['id']?>">
			<div class="form-group">
				<label for="f_name">Tên phim (*)</label>
				<input  type="text" class="form-control" id="f_name" name="name" value="<?=$phim['name']?>">
			</div>
			<div class="form-group">
				<label for="f_genre">Thể loại</label>
				<input  type="text" class="form-control" id="f_genre" name="genre" value="<?=$phim['genre']?>">
			</div>
			<div class="form-group">
				<label for="f_desc">Mô tả</label>
				<textarea class="form-control" name="description" id="f_desc" style="width:365px"><?=$phim['description']?></textarea>
			</div>
			<div class="form-group">
				<label for="f_image">Ảnh phim (*)</label>
				<input  type="file" class="form-control" name="image" accept=".jpg,.png,.gif" id="f_image" style="width:365px"/>
			</div>
			<div class="form-group">
				<label for="f_actor">Diễn viên</label>
				<input  type="text" class="form-control" id="f_actor" name="actor" value="<?=$phim['actor']?>">
			</div>
			<div class="form-group">
				<label for="f_year">Năm</label>
				<input  type="text" class="form-control" id="f_year" name="year" value="<?=$phim['year']?>">
			</div>
			<div class="form-group">
				<label for="f_durations">Thời lượng (phút)</label>
				<input  type="text" class="form-control" id="f_durations" name="durations" value="<?=$phim['durations']?>">
			</div>
			<div class="form-group">
				<label for="f_trailer">Trailer</label>
				<input  type="file" class="form-control" id="f_trailer" accept=".mp4,.mkv,.avi" name="trailer" style="width:365px">
			</div>
			<button type="submit" name="submit" value="add" class="btn btn-default"><?=$btn?></button>
			<button type="submit" name="submit" value="find" class="btn btn-default">Tìm</button>
			<?=isset($btn_del_find)? $btn_del_find: ''?>
		</form>
	</fieldset>

	<br><hr>
	<fieldset>
		<legend>Danh sách phim</legend>
		<div id="qlphim-list" class="table-responsive">
			<table class="table table-striped">
				<tr>
					<th>ID</th>
					<th>Tên phim</th>
					<th>Thể loại</th>
					<th>Mô tả</th>
					<th>Ảnh phim</th>
					<th>Diễn viên</th>
					<th>Năm</th>
					<th>Thời lượng</th>
					<th style="max-width:200px; overflow:hidden">Trailer</th>
					<th>Ngày tạo</th>
					<th>Lần sửa cuối</th>
					<th style="min-width:160px"></th>
				</tr>
				<?php
				if(isset($phim_list) && $phim_list !== false){
					while ($data = mysql_fetch_array($phim_list)) {
						echo"<tr>
						<td>".$data['id']."</td>
						<td>".$data['name']."</td>
						<td>".$data['genre']."</td>
						<td>".$data['description']."</td>
						<td>".$data['image']."</td>
						<td>".$data['actor']."</td>
						<td>".$data['year']."</td>
						<td>".$data['durations']."</td>
						<td>".$data['trailer']."</td>
						<td>".$data['created_at']."</td>
						<td>".$data['updated_at']."</td>
						<td><a href='?act=qlphim&id=".$data['id']."&code=1'><button class='btn btn-default'>Sửa</button></a>
							- <a onclick='xoa(event,\"phim ".$data['name']."\",\"?act=qlphim&id=".$data['id']."&code=2\");' ><button class='btn btn-default'>Xóa</button></a> </td>
						</tr>";
					}}else{
						echo "<tr><td class='text-center' colspan='12'>Chưa có dữ liệu</td></tr>";
					}
					?>
				</table>
				<nav <?=isset($hide_pag)?$hide_pag:''?>>
				<ul class="pagination" style="float:right">
					<?php if($total_page != 1){?>
						<li <?php if($current_page == 1) echo "class='disabled'"; ?> >
							<a href="<?php if($current_page != 1) echo "?act=qlphim&page=".$prev_page."" ?>"  aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						</li>
						<?php }	?>
						<?php
						if($total_page<7){
							for ($i=1; $i <= $total_page; $i++) { 
								if($i == $current_page){
									echo '<li class="active"><a href="?act=qlphim&page='.$i.'">'.$i.'</a></li>';
								}else{
									echo '<li ><a href="?act=qlphim&page='.$i.'">'.$i.'</a></li>';
								}
							}
						}else{
							if($current_page>2 && $current_page<=$total_page - 2){
								echo '<li ><a href="?act=qlphim&page='.($current_page-2).'">'.($current_page-2).'</a></li>';
								echo '<li ><a href="?act=qlphim&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qlphim&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qlphim&page='.($current_page+1).'">'.($current_page+1).'</a></li>';
								echo '<li ><a href="?act=qlphim&page='.($current_page+2).'">'.($current_page+2).'</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qlphim&page='.$total_page.'">'.$total_page.'</a></li>';
							}elseif($current_page==1){
								echo '<li class="active"><a href="?act=qlphim&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qlphim&page='.($current_page+1).'">'.($current_page+1).'</a></li>';
								echo '<li ><a href="?act=qlphim&page='.($current_page+2).'">'.($current_page+2).'</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qlphim&page='.$total_page.'">'.$total_page.'</a></li>';
							}elseif($current_page==2){
								echo '<li ><a href="?act=qlphim&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qlphim&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qlphim&page='.($current_page+1).'">'.($current_page+1).'</a></li>';
								echo '<li ><a href="?act=qlphim&page='.($current_page+2).'">'.($current_page+2).'</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qlphim&page='.$total_page.'">'.$total_page.'</a></li>';
							}elseif($current_page==($total_page - 1)){
								echo '<li ><a href="?act=qlphim&page=1">1</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qlphim&page='.($current_page-2).'">'.($current_page-2).'</a></li>';
								echo '<li ><a href="?act=qlphim&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qlphim&page='.$current_page.'">'.$current_page.'</a></li>';
								echo '<li ><a href="?act=qlphim&page='.($current_page+1).'">'.($current_page+1).'</a></li>';		
							}elseif($current_page==$total_page){
								echo '<li ><a href="?act=qlphim&page=1">1</a></li>';
								echo '<li ><a disabled>...</a></li>';
								echo '<li ><a href="?act=qlphim&page='.($current_page-2).'">'.($current_page-2).'</a></li>';
								echo '<li ><a href="?act=qlphim&page='.($current_page-1).'">'.($current_page-1).'</a></li>';
								echo '<li class="active"><a href="?act=qlphim&page='.$current_page.'">'.$current_page.'</a></li>';	
							}
						}
						
						?>
						<?php if($total_page != 1){?>
							<li <?php if($current_page == $total_page) echo "class='disabled'" ?> >
								<a href="<?php if($current_page != $total_page) echo "?act=qlphim&page=".$next_page."" ?>"  aria-label="Next">
									<span aria-hidden="true">&raquo;</span>
								</a>
							</li>
							<?php }	?>
						</ul>
					</nav>
					</div>
				</fieldset>
			</div>