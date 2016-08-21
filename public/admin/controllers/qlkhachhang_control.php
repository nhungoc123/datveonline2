<?php
include("../models/qlkhachhang_model.php");
$kh = new qlkhachhang();

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
$record = $kh->get_num_row($params);
$total_page = ceil($record / $params['per_page']);

$khachhang = isset($_GET['id'])?mysql_fetch_array($kh->get_khachhang(htmlspecialchars($_GET['id']))):null;
$khachhang_list = $kh->get_khachhang_list($params);


$code = isset($_GET['code'])?htmlspecialchars($_GET['code']):0;
$btn = "Thêm mới";
if($code == 0){
	//thêm
	if(isset($_POST['submit'])){
		$data = array(
			'id' => htmlspecialchars($_POST['id']),
			'name' => htmlspecialchars($_POST['name']),
			'tel' => htmlspecialchars($_POST['tel']),
			'email' => htmlspecialchars($_POST['email']),
			'today' => $today,
			);

		if($_POST['submit'] == 'add'){
			if($data['name']=='' || $data['tel']=='' || $data['email']==''){
				echo "<script>error('Trường gắn gấu (*) không được để trống','?act=qlkhachhang');</script>";
				exit();
			}
			$respone = $kh->add_khachhang($data);
			if($respone === false){
				echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlkhachhang');</script>";
				exit();
			}else{
				echo "<script>success('Thêm mới thành công','?act=qlkhachhang');</script>";
				exit();
			}
		}else if($_POST['submit'] == 'find'){
			$khachhang_list =  $kh->find_khachhang($data);
			$hide_pag = 'class="sr-only"';
			$btn_del_find = '<a href="?act=qlkhachhang"><button type="button" class="btn btn-default">Xóa Tìm Kiếm</button></a>';
			$khachhang = $data;
		}
	}
	
}else if($code == 1){
	//sửa
	if(isset($_POST['submit'])){
		$data = array(
			'id' => htmlspecialchars($_POST['id']),
			'name' => htmlspecialchars($_POST['name']),
			'tel' => htmlspecialchars($_POST['tel']),
			'email' => htmlspecialchars($_POST['email']),
			'today' => $today,
			);

		$respone = $kh->update_khachhang($data);
		if($respone === false){
			echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlkhachhang');</script>";
			exit();
		}else{
			echo "<script>success('Sửa thành công','?act=qlkhachhang');</script>";
			exit();
		}
	}

	$btn = "Cập nhật";
}else if($code == 2){
	//xóa
	$respone = $kh->khoa_khachhang(htmlspecialchars($_GET['id']));
	if($respone === false){
		echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlkhachhang');</script>";
		exit();
	}else{
		echo "<script>success('Xóa thành công','?act=qlkhachhang');</script>";
		exit();
	}
}

?>