<?php
include_once("data.php");
class qlxuatchieu extends db{
		//lấy danh sách xuất chiếu
	function get_xuatchieu_list($params = array()){
		if(array_key_exists("page",$params)){
			$kq = "SELECT * FROM dtb_performances order by id desc limit ".$params['per_page']." offset ".($params['page']-1)*$params['per_page']."";
		}else{
			$kq = "SELECT * FROM dtb_performances order by id desc";
		}
		
		return db::getdata($kq);
	}

	function find_xuatchieu($data = array()){
		$kq = "SELECT * FROM dtb_performances ";
		
		$kq = $kq." where ";
		if($data['performance_time'] != ''){
			$kq = $kq." performance_time = '".$data['performance_time']."' and ";
		}
		$kq = $kq." 1=1 ";

		$kq=$kq." order by id desc ";
		return db::getdata($kq);
	}

		//lấy thông tin 1 xuất chiếu
	function get_xuatchieu($data){
		$kq = "SELECT * FROM dtb_performances where id = '".$data."'";
		return db::getdata($kq);
	}

		//cập nhật thông tin xuất chiếu
	function update_xuatchieu($data = array()){
		$kq = "update dtb_performances set performance_time = '".$data['performance_time']."',updated_at = now() where id = '".$data['id']."'";
		return db::getdata($kq);
	}

		//thêm mới thông tin xuất chiếu
	function add_xuatchieu($data = array()){
		$kq = "insert into dtb_performances (performance_time,created_at) values ('".$data['performance_time']."',now())";
		return db::getdata($kq);
	}

		//xóa phim
	function delete_xuatchieu($data){
		$kq = "delete FROM dtb_performances where id = '".$data."'";
		return db::getdata($kq);
	}

}
?>