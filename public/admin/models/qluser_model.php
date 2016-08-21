<?php
include_once("data.php");
class qluser extends db{
	//lấy danh sách user
	function get_user_list($params = array()){
			//$kq = "SELECT  FROM users order by id desc limit ".$params['per_page']." offset ".($params['page']-1)*$params['per_page']."";
		if(array_key_exists("page",$params)){
			$kq = "select * FROM `users` order by id desc limit ".$params['per_page']." offset ".($params['page']-1)*$params['per_page']."";
		}else{
			$kq = "select * FROM `users` order by id desc";
		}
		return db::getdata($kq);
	}

	function find_user($data = array()){
		$kq = "select * FROM `users` ";
		
		$kq = $kq." where ";
		if($data['name'] != ''){
			$kq = $kq." name like '%".$data['name']."%' and ";
		}
		if($data['email'] != ''){
			$kq = $kq." email like '%".$data['email']."%' and ";
		}
		$kq = $kq." 1=1 ";

		$kq=$kq." order by id desc ";
		return db::getdata($kq);
	}

		//lấy thông tin 1 khach hang
	function get_user($data){
		$kq = "SELECT * FROM users where id = '".$data."'";
		return db::getdata($kq);
	}

		//cập nhật thông tin phim
	function update_user($data = array()){
		if($data["password"] != "e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855"){
			$kq = "UPDATE `users` SET `name` = '".$data['name']."',`password` = '".$data['password']."',`level` = '".$data['level']."',`email` = '".$data['email']."',`updated_at` = now() WHERE `id` = '".$data['id']."'";
		}else{
			$kq = "UPDATE `users` SET `name` = '".$data['name']."',`email` = '".$data['email']."',`level` = '".$data['level']."',`updated_at` = now() WHERE `id` = '".$data['id']."'";
		}
		
		return db::getdata($kq);
	}

		//thêm mới thông tin phim
	function add_user($data = array()){
		if($data["password"] != "e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855"){
			$kq = "insert INTO `users`
			(`name`,`email`,`password`,`level`,`created_at`)
			VALUES
			('".$data['name']."','".$data['email']."','".$data['password']."','".$data['level']."',now())";
			return db::getdata($kq);
		}else{
			return false;
		}
	}

		//xóa phim
	function khoa_user($data){
		$kq = "update users set level = 99 where id = '".$data."'";
		return db::getdata($kq);
	}
}

?>