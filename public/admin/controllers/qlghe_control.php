<?php

include("../models/qlrapchieu_model.php");
include("../models/qlghe_model.php");
$g = new qlghe();
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
$params['table_name'] = 'dtb_seats';
$record = $g->get_num_row($params);
$total_page = ceil($record / $params['per_page']);

$ghe = isset($_GET['id'])?mysql_fetch_array($g->get_ghe(htmlspecialchars($_GET['id']))):null;
$ghe_list = $g->get_ghe_list($params);
$rapchieu_list = $rc->get_rap_list();
//$loaighe_list = $g->get_loaighe_list($params);
$code = isset($_GET['code'])?htmlspecialchars($_GET['code']):0;
$btn = "Thêm mới";
if($code == 0){
	//thêm
	if(isset($_POST['submit'])){
		$data = array(
			'id' => htmlspecialchars($_POST['id']),
			'row' => htmlspecialchars($_POST['row']),
			'column' => htmlspecialchars($_POST['column']),
			'type' => htmlspecialchars($_POST['type']),
			'cinema_id' => htmlspecialchars($_POST['cinema_id']),
			'today' => $today,
			);
		
		if($_POST['submit'] == 'add'){
			if($data['row']=='' || $data['column']=='' || $data['type']=='' || $data['cinema_id']==''){
				echo "<script>error('Trường gắn gấu (*) không được để trống','?act=qlghe');</script>";
				exit();
			}
			$respone = $g->add_ghe($data);
			if($respone === false){
				echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlghe');</script>";
				exit();
			}else{
				echo "<script>success('Thêm mới thành công','?act=qlghe');</script>";
				exit();
			}
		}else if($_POST['submit'] == 'find'){
			$ghe_list =  $g->find_ghe($data);
			$hide_pag = 'class="sr-only"';
			$btn_del_find = '<a href="?act=qlghe"><button type="button" class="btn btn-default">Xóa Tìm Kiếm</button></a>';
			$ghe = $data;
		}
	}
}else if($code == 1){
	//sửa
	if(isset($_POST['submit'])){
		$data = array(
			'id' => htmlspecialchars($_POST['id']),
			'row' => htmlspecialchars($_POST['row']),
			'column' => htmlspecialchars($_POST['column']),
			'type' => htmlspecialchars($_POST['type']),
			'cinema_id' => htmlspecialchars($_POST['cinema_id']),
			'today' => $today,
			);
		$respone = $g->update_ghe($data);
		if($respone === false){
			echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlghe');</script>";
			exit();
		}else{
			echo "<script>success('Sửa thành công','?act=qlghe');</script>";
			exit();
		}
	}

	$btn = "Cập nhật";
}else if($code == 2){
	//xóa
	$respone = $g->delete_ghe(htmlspecialchars($_GET['id']));
	if($respone === false){
		echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlghe');</script>";
		exit();
	}else{
		echo "<script>success('Xóa thành công','?act=qlghe');</script>";
		exit();
	}
}

$type = array("NORMAL","VIP",);
?>