<?php
include_once("config.php");
if($_POST){
	$data = array(
		'email' => htmlspecialchars ( addslashes (trim($_POST['email']))),
		'password' => hash(HASH_ALGO, htmlspecialchars ( addslashes (trim($_POST['password']))))
		);
	$res = $t->login($data);
	if($res != 0){
		$kq = mysql_fetch_array($res);
		if($kq){
			$user = array('name' => $kq['name']);
			$_SESSION['user'] = $user; 
			echo 1;
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