<?php

include("../models/qluser_model.php");
$u = new qluser();

if($_SESSION['level'] != 0){
	echo "<script>error('Bạn không có quyền truy cập trang này','?act=infor');</script>";
}else{
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
	$record = $u->get_num_row($params);
	$total_page = ceil($record / $params['per_page']);

	$user = isset($_GET['id'])?mysql_fetch_array($u->get_user(htmlspecialchars($_GET['id']))):null;

	$user_list = $u->get_user_list($params);


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
				'level' => htmlspecialchars($_POST['level']),
				);
			if($_POST['submit'] == 'add'){
				if($data['name']=='' || $data['password']=='' || $data['email']==''){
					echo "<script>error('Trường gắn gấu (*) không được để trống','?act=qluser');</script>";
					exit();
				}
				$respone = $u->add_user($data);
				if($respone === false){
					echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qluser');</script>";
					exit();
				}else{
					echo "<script>success('Thêm mới thành công','?act=qluser');</script>";
					exit();
				}
			}else if($_POST['submit'] == 'find'){
				$user_list =  $u->find_user($data);
				$hide_pag = 'class="sr-only"';
				$btn_del_find = '<a href="?act=qluser"><button type="button" class="btn btn-default">Xóa Tìm Kiếm</button></a>';
				$user = $data;
			}
		}else{
			//echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qluser');</script>";
		}

	}else if($code == 1){
	//sửa
		if(isset($_POST['submit'])){
			$data = array(
				'id' => htmlspecialchars($_POST['id']),
				'name' => htmlspecialchars($_POST['name']),
				'password' => hash(HASH_ALGO, htmlspecialchars ( addslashes (trim($_POST['password'])))),
				'email' => htmlspecialchars($_POST['email']),
				'level' => htmlspecialchars($_POST['level']),
				);
			$respone = $u->update_user($data);
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
	//khóa
		if($_GET['id'] == $_SESSION['user']['id']){
			echo "<script>error('Bạn không thể khóa tài khoản chính mình','?act=qluser');</script>";
			exit();
		}else{
			$respone = $u->khoa_user(htmlspecialchars($_GET['id']));
			if($respone === false){
				echo "<script>error('Có lỗi xảy ra, vui lòng thử lại sau','?act=qluser');</script>";
				exit();
			}else{
				echo "<script>success('Khóa thành công','?act=qluser');</script>";
				exit();
			}
		}
		
	}
}

?>