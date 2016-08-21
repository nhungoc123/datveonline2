<?php
include_once("data.php");
class qllichchieu extends db{
	//lấy danh sách lịch chiếu
	function get_lichchieu_list($params = array()){
		if(array_key_exists("page",$params)){
			$kq = "select m.name as m_name, c.name as c_name, s.id , s.movie_cinema_id, s.performance_id, s.created_at, s.updated_at, p.performance_time FROM `dtb_showtimes` s
			left join `dtb_movie_cinemas` mc on mc.id = s.movie_cinema_id
			left join `dtb_movies` m on m.id = mc.movie_id
			left join `dtb_cinemas` c on c.id = mc.cinema_id
			left join `dtb_performances` p on p.id = s.performance_id
			order by s.id desc limit ".$params['per_page']." offset ".($params['page']-1)*$params['per_page']."";
		}else{
			$kq = "select m.name as m_name, c.name as c_name, s.id , s.movie_cinema_id, s.performance_id, s.created_at, s.updated_at, p.performance_time FROM `dtb_showtimes` s
			left join `dtb_movie_cinemas` mc on mc.id = s.movie_cinema_id
			left join `dtb_movies` m on m.id = mc.movie_id
			left join `dtb_cinemas` c on c.id = mc.cinema_id
			left join `dtb_performances` p on p.id = s.performance_id
			order by s.id desc";
		}
		return db::getdata($kq);
	}

	function find_lichchieu($data = array()){
		$kq = "select m.name as m_name, c.name as c_name, s.id , s.movie_cinema_id, s.performance_id, s.created_at, s.updated_at, p.performance_time FROM `dtb_showtimes` s
		left join `dtb_movie_cinemas` mc on mc.id = s.movie_cinema_id
		left join `dtb_movies` m on m.id = mc.movie_id
		left join `dtb_cinemas` c on c.id = mc.cinema_id
		left join `dtb_performances` p on p.id = s.performance_id ";
		
		$kq = $kq." where ";
		if($data['movie_cinema_id'] != ''){
			$kq = $kq." s.movie_cinema_id = '".$data['movie_cinema_id']."' and ";
		}
		if($data['performance_id'] != ''){
			$kq = $kq." s.performance_id = '".$data['performance_id']."' and ";
		}
		$kq = $kq." 1=1 ";

		$kq=$kq." order by s.id desc ";
		return db::getdata($kq);

	}

		//lấy thông tin 1 lịch chiếu
	function get_lichchieu($data){
		$kq = "SELECT * FROM dtb_showtimes where id = '".$data."'";
		return db::getdata($kq);
	}

		//cập nhật thông tin lịch chiếu
	function update_lichchieu($data = array()){
		//$kq = "update dtb_showtimes set movie_cinema_id = '".$data['movie_cinema_id']."',performance_id = '".$data['performance_id']."',updated_at = now() where id = '".$data['id']."'";
		

		//return $rs;

		$kq = "
		select count(*) as sum
		from dtb_showtimes s
		left join dtb_movie_cinemas mc on mc.id = s.movie_cinema_id
		left join dtb_showtimes s2 on s2.performance_id = s.performance_id
		left join dtb_movie_cinemas mc2 on mc2.id = s2.movie_cinema_id
		where 
		(
		(mc.start_date between mc2.start_date and mc2.end_date)
		or
		(mc.end_date between mc2.start_date and mc2.end_date)
		)
		and mc.movie_id = mc2.movie_id
		and mc.id = '".$data['movie_cinema_id']."' and s.performance_id = '".$data['performance_id']."'
		";
		$check = db::fetchRow(db::getdata($kq));
		if($check['sum'] == 0){
			$kq = "call edit_showtimes('".$data['id']."','".$data['movie_cinema_id']."','".$data['performance_id']."','".$data['status']."','".$data['price']."',@result)";

			db::getdata($kq);
			$kq = "select @result as result";
			$rs = db::fetchRow(db::getdata($kq));
		}else{
			$rs['result'] = '2';
		}
		return $rs;
	}

		//thêm mới thông tin lịch chiếu
	function add_lichchieu($data = array()){
		$kq = "
		select count(*) as sum
		from dtb_showtimes s
		left join dtb_movie_cinemas mc on mc.id = s.movie_cinema_id
		left join dtb_showtimes s2 on s2.performance_id = s.performance_id
		left join dtb_movie_cinemas mc2 on mc2.id = s2.movie_cinema_id
		where 
		(
		(mc.start_date between mc2.start_date and mc2.end_date)
		or
		(mc.end_date between mc2.start_date and mc2.end_date)
		)
		and mc.movie_id = mc2.movie_id
		and mc.id = '".$data['movie_cinema_id']."' and s.performance_id = '".$data['performance_id']."'
		";
		$check = db::fetchRow(db::getdata($kq));
		if($check['sum'] == 0){
			$kq = "call add_new_showtimes('".$data['movie_cinema_id']."','".$data['performance_id']."','".$data['status']."','".$data['price']."',@result,@id)";
			db::getdata($kq);
			$kq = "select @result as result, @id as id";
			$rs = db::fetchRow(db::getdata($kq));
		}else{
			$rs['result'] = '2';
		}
		return $rs;
		
	}

		//xóa phim
	function delete_lichchieu($data){
		$kq = "delete FROM dtb_tickets where showtime_id = '".$data."'";
		if(db::getdata($kq)){
			$kq = "delete FROM dtb_showtimes where id = '".$data."'";
			return db::getdata($kq);
		}else{
			return false;
		}
		
	}
}
?>