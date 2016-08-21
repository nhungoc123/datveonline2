<?php
include("../models/qlphimrap_model.php");
include("../models/qlrapchieu_model.php");
include("../models/qlphim_model.php");
$p = new qlphim();
$pr = new qlphimrap();
$rc = new qlrapchieu();


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
$record = $pr->get_num_row($params);
$total_page = ceil($record / $params['per_page']);


$phimrap = isset($_GET['id'])?mysql_fetch_array($pr->get_phim_rap(htmlspecialchars($_GET['id']))):null;
$phimrap_list = $pr->get_phim_rap_list($params);
$rapchieu_list = $rc->get_rap_list();
$phim_list = $p->get_phim_list();

//$xuatchieu_list = $pr->get_xuatchieu_list($params);
$code = isset($_GET['code'])?htmlspecialchars($_GET['code']):0;
$btn = "Thêm mới";
if($code == 0){
	//thêm và tìm
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
			//thêm
			if($data['movie_id']=='' || $data['cinema_id']=='' || $data['start_date']=='' || $data['end_date']==''){
				echo "<script>error('Trường gắn gấu (*) không được để trống','?act=qlphimrap');</script>";
				exit();
			}
			$respone = $pr->add_phim_rap($data);
			if($respone === false){
				echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlphimrap');</script>";
				exit();
			}else{
				echo "<script>success('Thêm mới thành công','?act=qlphimrap');</script>";
				exit();
			}
		}else if($_POST['submit'] == 'find'){
			//tìm
			$phimrap_list =  $pr->find_phim_rap($data);
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
		$respone = $pr->update_phim_rap($data);
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

	$respone = $pr->delete_phim_rap(htmlspecialchars($_GET['id']));
	if($respone === false){
		echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlphimrap');</script>";
		exit();
	}else{
		echo "<script>success('Xóa thành công','?act=qlphimrap');</script>";
		exit();
	}
}

?>