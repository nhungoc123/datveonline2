<?php

include("../models/qlrapchieu_model.php");
$r = new qlrapchieu();

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
$record = $r->get_num_row($params);
$total_page = ceil($record / $params['per_page']);


$rapchieu = isset($_GET['id'])?mysql_fetch_array($r->get_rap(htmlspecialchars($_GET['id']))):null;
$rapchieu_list = $r->get_rap_list($params);


//$xuatchieu_list = $r->get_xuatchieu_list($params);
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
			$respone = $r->add_rap($data);
			if($respone['result'] === '1'){
				echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlrapchieu');</script>";
				exit();
			}else{
				echo "<script>success('Thêm mới thành công','?act=qlrapchieu');</script>";
				exit();
			}
		}else if($_POST['submit'] == 'find'){
			$rapchieu_list =  $r->find_rap($data);
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
		$respone = $r->update_rap($data);
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

	$respone = $r->delete_rap(htmlspecialchars($_GET['id']));
	if($respone === false){
		echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlrapchieu');</script>";
		exit();
	}else{
		echo "<script>success('Xóa thành công','?act=qlrapchieu');</script>";
		exit();
	}
}

?>