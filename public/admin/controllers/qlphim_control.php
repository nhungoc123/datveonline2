<?php

include("../models/qlphim_model.php");
$p = new qlphim();

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
$record = $p->get_num_row($params);
$total_page = ceil($record / $params['per_page']);

$phim = isset($_GET['id'])?mysql_fetch_array($p->get_phim(htmlspecialchars($_GET['id']))):null;
$phim_list = $p->get_phim_list($params);
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
				$data['trailer'] = htmlspecialchars($_POST['trailer2']);
			}else{
				$data['trailer'] = $videoname;
			}

			if($_POST['submit'] == 'add'){
				if($data['name']=='' || $data['image'] == ''){
					echo "<script>error('Trường gắn gấu (*) không được để trống','?act=qlphim');</script>";
					exit();
				}
				$respone = $p->add_phim($data);
				if($respone === false){
					echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlphim');</script>";
					exit();
				}else{
					echo "<script>success('Thêm mới thành công','?act=qlphim');</script>";
					exit();
				}
			}else if($_POST['submit'] == 'find'){
				$phim_list =  $p->find_phim($data);
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

			if($uploaded2 == 0){
				if(htmlspecialchars($_POST['trailer2']) != "" ){
					$uploaded2 = 1;
					$videoname = htmlspecialchars($_POST['trailer2']);
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
			$respone = $p->update_phim($data);
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
		$respone = $p->delete_phim(htmlspecialchars($_GET['id']));
		if($respone === false){
			echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlphim');</script>";
			exit();
		}else{
			echo "<script>success('Xóa thành công','?act=qlphim');</script>";
			exit();
		}
	}

} catch (RuntimeException $e) {

	echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlphim');</script>";
			exit();

}
?>