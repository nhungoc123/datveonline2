<?php
include_once("data.php");
class ham extends db{
	//đăng nhập
	function login($data = array()){
		$kq = "SELECT * FROM users where email = '".$data['email']."' and password = '".$data['password']."'";
		return db::getdata($kq);
	}

	//đăng nhập
	function check_email($data = array()){
		$kq = "SELECT * FROM users where email = '".$data['email']."'";
		return db::getdata($kq);
	}
}
?>