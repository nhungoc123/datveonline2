<?php
include("../models/login_model.php");
$t=new ham();
if($_POST){
	$data = array(
		'email' => htmlspecialchars ( addslashes (trim($_POST['email']))),
		'password' => hash(HASH_ALGO, htmlspecialchars ( addslashes (trim($_POST['password']))))
		);
	$res = $t->login($data);
	if($res != 0){
		$kq = mysql_fetch_array($res);
		if($kq){
			if($kq['level'] == 99){
				echo "Tài khoản đã bị khóa";
			}else{
			$user = array('name' => $kq['name'],'id' => $kq['id'], 'email' => $kq['email']);
			$_SESSION['user'] = $user; 
			$_SESSION['level'] = $kq['level'];
			echo 1;
			}
		}else{
			echo "Tên đăng nhập or mật khẩu không hợp lệ";
		}
	}else{
		echo "Tên đăng nhập or mật khẩu không hợp lệ";
	}
}else{
	echo "Tên đăng nhập or mật khẩu không hợp lệ";
}
?>