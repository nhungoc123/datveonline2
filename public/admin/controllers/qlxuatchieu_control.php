<?php
include("../models/qlxuatchieu_model.php");
$x = new qlxuatchieu();

date_default_timezone_set('Asia/Ho_Chi_Minh');
$today = date("Y-m-d H:i:s");
$xuatchieu = isset($_GET['id'])?mysql_fetch_array($x->get_xuatchieu(htmlspecialchars($_GET['id']))):null;
$xuatchieu_list = $x->get_xuatchieu_list($params);
$code = isset($_GET['code'])?htmlspecialchars($_GET['code']):0;
$btn = "Thêm mới";
if($code == 0){
	//thêm
	if(isset($_POST['submit'])){
		$data = array(
			'id' => htmlspecialchars($_POST['id']),
			'performance_time' => htmlspecialchars($_POST['performance_time']),
			'today' => $today,
			);

		if($_POST['submit'] == 'add'){
			if($data['performance_time']==''){
				echo "<script>error('Trường gắn gấu (*) không được để trống','?act=qlxuatchieu');</script>";
				exit();
			}
			$respone = $x->add_xuatchieu($data);
			if($respone === false){
				echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlxuatchieu');</script>";
				exit();
			}else{
				echo "<script>success('Thêm mới thành công','?act=qlxuatchieu');</script>";
				exit();
			}
		}else if($_POST['submit'] == 'find'){
			$xuatchieu_list =  $x->find_xuatchieu($data);
			$hide_pag = 'class="sr-only"';
			$btn_del_find = '<a href="?act=qlxuatchieu"><button type="button" class="btn btn-default">Xóa Tìm Kiếm</button></a>';
			$xuatchieu = $data;
		}
	}
	
}else if($code == 1){
	//sửa
	if(isset($_POST['submit'])){
		$data = array(
			'id' => htmlspecialchars($_POST['id']),
			'performance_time' => htmlspecialchars($_POST['performance_time']),
			'today' => $today,
			);

		$respone = $x->update_xuatchieu($data);
		if($respone === false){
			echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlxuatchieu');</script>";
			exit();
		}else{
			echo "<script>success('Sửa thành công','?act=qlxuatchieu');</script>";
			exit();
		}
	}

	$btn = "Cập nhật";
}else if($code == 2){
	//xóa
	$respone = $x->delete_xuatchieu(htmlspecialchars($_GET['id']));
	if($respone === false){
		echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qlxuatchieu');</script>";
		exit();
	}else{
		echo "<script>success('Xóa thành công','?act=qlxuatchieu');</script>";
		exit();
	}
}

?>