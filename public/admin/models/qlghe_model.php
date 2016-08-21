<?php
include_once("data.php");
class qlghe extends db{
	//lấy danh sách ghế
	function get_ghe_list($params = array()){
		if(array_key_exists("page",$params)){
			$kq = "SELECT s.id,s.created_at, s.updated_at,s.type,s.row,s.column,s.cinema_id,c.name as c_name FROM `dtb_seats` s
			left join `dtb_cinemas` c on c.id = s.cinema_id
			order by s.id desc limit ".$params['per_page']." offset ".($params['page']-1)*$params['per_page']."";
		}else{
			$kq = "SELECT s.id,s.created_at, s.updated_at,s.type,s.row,s.column,s.cinema_id,c.name as c_name FROM `dtb_seats` s
			left join `dtb_cinemas` c on c.id = s.cinema_id
			order by s.id desc ";
		}
		return db::getdata($kq);
	}

	function find_ghe($data = array()){
		$kq = "select s.id,s.created_at, s.updated_at,s.type,s.row,s.column,s.cinema_id,c.name as c_name FROM `dtb_seats` s
		left join `dtb_cinemas` c on c.id = s.cinema_id ";
		
		$kq = $kq." where ";
		if($data['type'] != ''){
			$kq = $kq." s.type like '%".$data['type']."%' and ";
		}
		if($data['cinema_id'] != ''){
			$kq = $kq." c.id = '".$data['cinema_id']."' and ";
		}
		if($data['column'] != ''){
			$kq = $kq." s.column like '%".$data['column']."%' and ";
		}
		if($data['row'] != ''){
			$kq = $kq." s.row like '%".$data['row']."%' and ";
		}

		$kq = $kq." 1=1 ";

		$kq=$kq." order by s.id desc ";
		return db::getdata($kq);
	}

		//lấy thông tin 1 ghế
	function get_ghe($data){
		$kq = "SELECT * FROM dtb_seats where id = '".$data."'";
		return db::getdata($kq);
	}

		//cập nhật thông tin ghế
	function update_ghe($data = array()){
		$kq = "update dtb_seats set `row` = '".$data['row']."',`column` = '".$data['column']."',`type` = '".$data['type']."',cinema_id = '".$data['cinema_id']."',updated_at = now() where id = '".$data['id']."'";
		return db::getdata($kq);
	}

		//thêm mới thông tin ghế
	function add_ghe($data = array()){
		$kq = "insert into dtb_seats (`row`,`column`,type,cinema_id,created_at) values ('".$data['row']."','".$data['column']."','".$data['type']."','".$data['cinema_id']."',now())";
		
		return db::getdata($kq);
	}

		//xóa phim
	function delete_ghe($data){
		$kq = "delete FROM dtb_seats where id = '".$data."'";
		return db::getdata($kq);
	}
}
?>