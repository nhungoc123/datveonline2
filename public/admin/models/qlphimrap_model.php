<?php
include_once("data.php");
class qlphimrap extends db{
	//lấy danh sách phim rạp
	function get_phim_rap_list($params = array()){
			//$kq = "SELECT  FROM dtb_movies order by id desc limit ".$params['per_page']." offset ".($params['page']-1)*$params['per_page']."";
		if(array_key_exists("page",$params)){
			$kq = "select m.name as m_name, c.name as c_name, mc.movie_id, mc.cinema_id, mc.start_date, mc.end_date, mc.created_at, mc.updated_at,mc.id FROM `dtb_movie_cinemas` mc
			left join `dtb_movies` m on m.id = mc.movie_id
			left join `dtb_cinemas` c on c.id = mc.cinema_id
			order by mc.id desc limit ".$params['per_page']." offset ".($params['page']-1)*$params['per_page']."";
		}else{
			$kq = "select m.name as m_name, c.name as c_name, mc.movie_id, mc.cinema_id, mc.start_date, mc.end_date, mc.created_at, mc.updated_at,mc.id FROM `dtb_movie_cinemas` mc
			left join `dtb_movies` m on m.id = mc.movie_id
			left join `dtb_cinemas` c on c.id = mc.cinema_id
			order by mc.id desc ";
		}
		return db::getdata($kq);
	}

	function find_phim_rap($data = array()){
		$kq = "select m.name as m_name, c.name as c_name, mc.movie_id, mc.cinema_id, mc.start_date, mc.end_date, mc.created_at, mc.updated_at,mc.id FROM `dtb_movie_cinemas` mc
		left join `dtb_movies` m on m.id = mc.movie_id
		left join `dtb_cinemas` c on c.id = mc.cinema_id ";
		
		$kq = $kq." where ";
		if($data['movie_id'] != ''){
			$kq = $kq." mc.movie_id = '".$data['movie_id']."' and ";
		}
		if($data['cinema_id'] != ''){
			$kq = $kq." mc.cinema_id = '".$data['cinema_id']."' and ";
		}
		if($data['start_date'] != ''){
			$kq = $kq." mc.start_date = '".$data['start_date']."' and ";
		}
		if($data['end_date'] != ''){
			$kq = $kq." mc.end_date =  '".$data['end_date']."' and ";
		}

		$kq = $kq." 1=1 ";

		$kq=$kq." order by mc.id desc ";
		return db::getdata($kq);
	}


		//lấy thông tin 1 phim
	function get_phim_rap($data){
		$kq = "SELECT * FROM dtb_movie_cinemas where id = '".$data."'";
		return db::getdata($kq);
	}

		//cập nhật thông tin phim
	function update_phim_rap($data = array()){
		$kq = "update dtb_movie_cinemas set movie_id = '".$data['movie_id']."',cinema_id = '".$data['cinema_id']."',start_date = '".$data['start_date']."',end_date = '".$data['end_date']."',updated_at = now() where id = '".$data['id']."'";
		
		return db::getdata($kq);
	}

		//thêm mới thông tin phim
	function add_phim_rap($data = array()){
		$kq = "insert into dtb_movie_cinemas (movie_id,cinema_id,start_date,end_date,created_at) values ('".$data['movie_id']."','".$data['cinema_id']."','".$data['start_date']."','".$data['end_date']."',now())";

		return db::getdata($kq);
	}

		//xóa phim
	function delete_phim_rap($data){
		$kq = "delete FROM dtb_movie_cinemas where id = '".$data."'";
		return db::getdata($kq);
	}

}
?>