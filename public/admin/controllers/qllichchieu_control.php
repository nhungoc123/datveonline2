<?php
include("../models/qlphimrap_model.php");
include("../models/qlxuatchieu_model.php");
include("../models/qllichchieu_model.php");
$lc = new qllichchieu();
$pr = new qlphimrap();
$xc = new qlxuatchieu();

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
$record = $lc->get_num_row($params);
$total_page = ceil($record / $params['per_page']);

$lichchieu = isset($_GET['id'])?mysql_fetch_array($lc->get_lichchieu(htmlspecialchars($_GET['id']))):null;
$lichchieu_list = $lc->get_lichchieu_list($params);
$phimrap_list = $pr->get_phim_rap_list();
$xuatchieu_list = $xc->get_xuatchieu_list();


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
			$respone = $lc->add_lichchieu($data);
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
			$lichchieu_list =  $lc->find_lichchieu($data);
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

		$respone = $lc->update_lichchieu($data);
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
	$respone = $lc->delete_lichchieu(htmlspecialchars($_GET['id']));
	if($respone === false){
		echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qllichchieu');</script>";
		exit();
	}else{
		echo "<script>success('Xóa thành công','?act=qllichchieu');</script>";
		exit();
	}
}

?>