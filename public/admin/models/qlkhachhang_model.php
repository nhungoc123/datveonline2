<?php
include_once("data.php");
class qlkhachhang extends db{

//lấy danh sách khach hang
	function get_khachhang_list($params = array()){
			//$kq = "SELECT  FROM dtb_movies order by id desc limit ".$params['per_page']." offset ".($params['page']-1)*$params['per_page']."";
		if(array_key_exists("page",$params)){
			$kq = "select * FROM `dtb_customer` order by id desc limit ".$params['per_page']." offset ".($params['page']-1)*$params['per_page']."";
		}else{
			$kq = "select * FROM `dtb_customer` order by id desc";
		}
		return db::getdata($kq);
	}

	function find_khachhang($data = array()){
		$kq = "select * FROM `dtb_customer` ";
		
		$kq = $kq." where ";
		if($data['name'] != ''){
			$kq = $kq." name like '%".$data['name']."%' and ";
		}
		if($data['email'] != ''){
			$kq = $kq." email like '%".$data['email']."%' and ";
		}
		if($data['tel'] != ''){
			$kq = $kq." tel like '%".$data['tel']."%' and ";
		}
		$kq = $kq." 1=1 ";

		$kq=$kq." order by id desc ";
		return db::getdata($kq);
	}

		//lấy thông tin 1 khach hang
	function get_khachhang($data){
		$kq = "select * FROM dtb_customer where id = '".$data."'";
		return db::getdata($kq);
	}

		//cập nhật thông tin phim
	function update_khachhang($data = array()){
		$kq = "update `dtb_customer` SET `name` = '".$data['name']."',`tel` = '".$data['tel']."',`email` = '".$data['email']."',`updated_at` = now() WHERE `id` = '".$data['id']."'";
		

		return db::getdata($kq);
	}

		//thêm mới thông tin phim
	function add_khachhang($data = array()){
		$kq = "INSERT INTO `dtb_customer`
		(`name`,`tel`,`email`,`created_at`)
		VALUES
		('".$data['name']."','".$data['tel']."','".$data['email']."',now())";
		return db::getdata($kq);
	}

		//xóa phim
	function khoa_khachhang($data){
		$kq = "delete FROM dtb_customer where id = '".$data."'";
		return db::getdata($kq);
	}

}

?>
