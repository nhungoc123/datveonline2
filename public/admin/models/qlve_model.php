<?php
include_once("data.php");
class qlve extends db{
//lấy danh sách phim rạp
	function get_ve_list($params = array()){
			//$kq = "SELECT  FROM dtb_movies order by id desc limit ".$params['per_page']." offset ".($params['page']-1)*$params['per_page']."";
		if(array_key_exists("page",$params)){
			$kq = "select m.name as m_name, c.name as c_name, t.id ,t.showtime_id,t.seat_id,t.date,t.status,t.customer_id,ce.name as customer_name, s.movie_cinema_id, s.performance_id, t.created_at, t.updated_at, p.performance_time,se.row,se.column,se.type FROM `dtb_tickets` t
			left join `dtb_showtimes` s on s.id = t.showtime_id
			left join `dtb_movie_cinemas` mc on mc.id = s.movie_cinema_id
			left join `dtb_movies` m on m.id = mc.movie_id
			left join `dtb_customer` ce on ce.id = t.customer_id
			left join `dtb_cinemas` c on c.id = mc.cinema_id
			left join `dtb_performances` p on p.id = s.performance_id
			left join `dtb_seats` se on se.id = t.seat_id
			order by t.id desc limit ".$params['per_page']." offset ".($params['page']-1)*$params['per_page']."";
		}else{
			$kq = "select m.name as m_name, c.name as c_name, t.id ,t.showtime_id,t.seat_id,t.date,t.status,t.customer_id,ce.name  as customer_name, s.movie_cinema_id, s.performance_id, t.created_at, t.updated_at, p.performance_time,se.row,se.column,se.type FROM `dtb_tickets` t
			left join `dtb_showtimes` s on s.id = t.showtime_id
			left join `dtb_movie_cinemas` mc on mc.id = s.movie_cinema_id
			left join `dtb_movies` m on m.id = mc.movie_id
			left join `dtb_customer` ce on ce.id = t.customer_id
			left join `dtb_cinemas` c on c.id = mc.cinema_id
			left join `dtb_performances` p on p.id = s.performance_id
			left join `dtb_seats` se on se.id = t.seat_id
			order by t.id desc";
		}
		return db::getdata($kq);
	}

	function find_ve($data = array()){
		$kq = "select m.name as m_name, c.name as c_name, t.id ,t.showtime_id,t.seat_id,t.date,t.status,t.customer_id,ce.name  as customer_name, s.movie_cinema_id, s.performance_id, t.created_at, t.updated_at, p.performance_time,se.row,se.column,se.type FROM `dtb_tickets` t
		left join `dtb_showtimes` s on s.id = t.showtime_id
		left join `dtb_movie_cinemas` mc on mc.id = s.movie_cinema_id
		left join `dtb_movies` m on m.id = mc.movie_id
		left join `dtb_customer` ce on ce.id = t.customer_id
		left join `dtb_cinemas` c on c.id = mc.cinema_id
		left join `dtb_performances` p on p.id = s.performance_id
		left join `dtb_seats` se on se.id = t.seat_id ";
		
		$kq = $kq." where ";
		if($data['showtime_id'] != ''){
			$kq = $kq." t.showtime_id = '".$data['showtime_id']."' and ";
		}
		if($data['seat_id'] != ''){
			$kq = $kq." t.seat_id = '".$data['seat_id']."' and ";
		}
		if($data['customer_id'] != ''){
			$kq = $kq." t.customer_id = '".$data['customer_id']."' and ";
		}
		if($data['status'] != ''){
			$kq = $kq." t.status like '%".$data['status']."%' and ";
		}
		if($data['date'] != ''){
			$kq = $kq." t.date = '".$data['date']."' and ";
		}
		$kq = $kq." 1=1 ";

		$kq=$kq." order by t.id desc ";
		return db::getdata($kq);
	}

		//lấy thông tin 1 phim
	function get_ve($data){
		$kq = "SELECT * FROM dtb_tickets where id = '".$data."'";
		return db::getdata($kq);
	}

		//cập nhật thông tin phim
	function update_ve($data = array()){
		$kq = "update dtb_tickets set showtime_id = '".$data['showtime_id']."',seat_id = '".$data['seat_id']."',customer_id = '".$data['customer_id']."',date = '".$data['date']."',status = '".$data['status']."',updated_at = now() where id = '".$data['id']."'";
		
		return db::getdata($kq);
	}

		//thêm mới thông tin phim
	function add_ve($data = array()){
		$kq = "insert into dtb_tickets (showtime_id,seat_id,customer_id,date,status,created_at) values ('".$data['showtime_id']."','".$data['seat_id']."','".$data['customer_id']."','".$data['date']."','".$data['status']."',now())";

		return db::getdata($kq);
	}

		//xóa phim
	function delete_ve($data){
		$kq = "delete FROM dtb_tickets where id = '".$data."'";
		return db::getdata($kq);
	}
}
?>