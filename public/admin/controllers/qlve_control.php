<?php
include("../models/qlve_model.php");
include("../models/qllichchieu_model.php");
include("../models/qlghe_model.php");
include("../models/qlphimrap_model.php");
include("../models/qlrapchieu_model.php");
$v = new qlve();
$lc = new qllichchieu();
$g = new qlghe();
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
$params['table_name'] = 'dtb_tickets';
$record = $v->get_num_row($params);
$total_page = ceil($record / $params['per_page']);

$ve = isset($_GET['id'])?mysql_fetch_array($v->get_ve(htmlspecialchars($_GET['id']))):null;
$ve_list = $v->get_ve_list($params);
$lichchieu_list = $lc->get_lichchieu_list();
$ghe_list = $g->get_ghe_list();
$phimrap_list = $pr->get_phim_rap_list();
$rapchieu_list = $rc->get_rap_list();

$code = isset($_GET['code'])?htmlspecialchars($_GET['code']):0;
$btn = "Thêm mới";
if($code == 0){
	//thêm
	if(isset($_POST['submit'])){
		$tmp_seat_id = isset($_POST['seat_id']) ? htmlspecialchars($_POST['seat_id']): "";
		$data = array(
			'id' => htmlspecialchars($_POST['id']),
			'showtime_id' => isset($_POST['showtime_id']) ? htmlspecialchars($_POST['showtime_id']): "",
			'seat_id' => $tmp_seat_id,
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
			$respone = $v->add_ve($data);
			if($respone === false){
				echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlve');</script>";
				exit();
			}else{
				echo "<script>success('Thêm mới thành công','?act=qlve');</script>";
				exit();
			}
		}else if($_POST['submit'] == 'find'){
			$ve_list =  $v->find_ve($data);
			$hide_pag = 'class="sr-only"';
			$btn_del_find = '<a href="?act=qlve"><button type="button" class="btn btn-default">Xóa Tìm Kiếm</button></a>';
			$ve = $data;
		}
	}
	
}else if($code == 1){
	//sửa
	if(isset($_POST['submit'])){
		$tmp_seat_id = isset($_POST['seat_id']) ? htmlspecialchars($_POST['seat_id']): "";
		$data = array(
			'id' => htmlspecialchars($_POST['id']),
			'showtime_id' => isset($_POST['showtime_id']) ? htmlspecialchars($_POST['showtime_id']): "",
			'seat_id' => $tmp_seat_id,
			'customer_id' => htmlspecialchars($_POST['customer_id']),
			'status' => htmlspecialchars($_POST['status']),
			'date' => htmlspecialchars($_POST['date']),
			'today' => $today,
			);
		$respone = $v->update_ve($data);
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
	$respone = $v->delete_ve(htmlspecialchars($_GET['id']));
	if($respone === false){
		echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlve');</script>";
		exit();
	}else{
		echo "<script>success('Xóa thành công','?act=qlve');</script>";
		exit();
	}
}

?>