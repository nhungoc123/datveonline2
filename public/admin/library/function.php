<?php
include("data.php");
class ham extends db{


		//đăng nhập
	function login($data = array()){
		$kq = "SELECT * FROM users where email = '".$data['email']."' and password = '".$data['password']."'";
		return db::getdata($kq);
	}

	function get_num_row($params = array()){
		$kq = "select * from ".$params['table_name']."";
		return mysql_num_rows(db::getdata($kq));
	}

	/**********************************rạp chiếu*******************************/
		//lấy danh sách rạp chiếu
	function get_rap_list($params = array()){
		if(array_key_exists("page",$params)){
			$kq = "SELECT * FROM dtb_cinemas order by id desc limit ".$params['per_page']." offset ".($params['page']-1)*$params['per_page']."";
		}else{
			$kq = "select * from dtb_cinemas";
		}
		return db::getdata($kq);
	}

	function find_rap($data = array()){
		$kq = "select * from dtb_cinemas c";
		
		$kq = $kq." where ";
		if($data['name'] != ''){
			$kq = $kq." c.name like '%".$data['name']."%' and ";
		}
		if($data['description'] != ''){
			$kq = $kq." c.description like '%".$data['description']."%' and ";
		}
		if($data['seat_in_row'] != ''){
			$kq = $kq." c.seat_in_row = '".$data['seat_in_row']."' and ";
		}
		if($data['total_seat'] != ''){
			$kq = $kq." c.total_seat = '".$data['total_seat']."' and ";
		}

		$kq = $kq." 1=1 ";

		$kq=$kq." order by c.id desc ";
		return db::getdata($kq);
	}

		//lấy thông tin 1 bộ rạp chiếu
	function get_rap($data){
		$kq = "SELECT * FROM dtb_cinemas where id = '".$data."'";
		return db::getdata($kq);
	}

		//cập nhật thông tin bộ rạp chiếu
	function update_rap($data = array()){
		//$kq = "update dtb_cinemas set name = '".$data['name']."',description = '".$data['description']."',seat_in_row = '".$data['seat_in_row']."',total_seat = '".$data['total_seat']."',updated_at = now() where id = '".$data['id']."'";
		//return db::getdata($kq);
		$row = intval($data['total_seat'])/intval($data['seat_in_row']);
		$kq = "call edit_cinemas('".$data['id']."','".$data['name']."','".$data['description']."','".$data['total_seat']."','".$data['seat_in_row']."',".$row.",@result)";
		db::getdata($kq);
		$kq = "select @result as result";
		$rs = db::fetchRow(db::getdata($kq));
		return $rs;
	}

		//thêm mới thông tin rạp chiếu
	function add_rap($data = array()){
		$row = intval($data['total_seat'])/intval($data['seat_in_row']);
		$kq = "call add_new_cinemas('".$data['name']."','".$data['description']."','".$data['total_seat']."','".$data['seat_in_row']."','".$row."',@result,@id)";
		db::getdata($kq);
		$kq = "select @result as result, @id as id";
		$rs = db::fetchRow(db::getdata($kq));
		return $rs;
	}

		//xóa rạp chiếu
	function delete_rap($data){
		$kq = "delete FROM dtb_cinemas where id = '".$data."'";
		return db::getdata($kq);
	}

	/**********************************xuất chiếu*******************************/

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

	/**********************************lịch chiếu*******************************/

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
		db::getdata($kq);
		$kq = "delete FROM dtb_showtimes where id = '".$data."'";
		return db::getdata($kq);
	}

	/**********************************ghế*******************************/

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

	/**********************************loại ghế*******************************/

		//lấy danh sách loại ghế
	function get_loaighe_list($params = array()){
		$kq = "SELECT * FROM seat_type order by id desc limit ".$params['per_page']." offset ".($params['page']-1)*$params['per_page']."";
		return db::getdata($kq);
	}

		//lấy thông tin 1 loại ghế
	function get_loaighe($data){
		$kq = "SELECT * FROM seat_type where id = '".$data."'";
		return db::getdata($kq);
	}

		//cập nhật thông tin loại ghế
	function update_loaighe($data = array()){
		$kq = "update seat_type set type = '".$data['type']."',updated_at = now() where id = '".$data['id']."'";
		return db::getdata($kq);
	}

		//thêm mới thông tin loại ghế
	function add_loaighe($data = array()){
		$kq = "insert into seat_type (type,created_at) values ('".$data['type']."',now())";
		return db::getdata($kq);
	}

		//xóa phim
	function delete_loaighe($data){
		$kq = "delete FROM seat_type where id = '".$data."'";
		return db::getdata($kq);
	}


	/**********************************phim*******************************/

	//lấy danh sách phim
	function get_phim_list($params = array()){
			//$kq = "SELECT  FROM dtb_movies order by id desc limit ".$params['per_page']." offset ".($params['page']-1)*$params['per_page']."";
		if(array_key_exists("page",$params)){
			$kq = "SELECT `id`, `name`, `image`, `genre`, left(`description`,100) as description, `actor`, `year`, `durations`, trailer, `created_at`, `updated_at` FROM `dtb_movies` order by id desc limit ".$params['per_page']." offset ".($params['page']-1)*$params['per_page']."";
		}else{
			$kq = "SELECT `id`, `name`, `image`, `genre`, left(`description`,100) as description, `actor`, `year`, `durations`,  trailer, `created_at`, `updated_at` FROM `dtb_movies` order by id desc ";
		}
		return db::getdata($kq);
	}

	function find_phim($data = array()){
		$kq = "SELECT `id`, `name`, `image`, `genre`, left(`description`,100) as description, `actor`, `year`, `durations`,  trailer, `created_at`, `updated_at` FROM `dtb_movies` ";
		
		$kq = $kq." where ";
		if($data['name'] != ''){
			$kq = $kq." name like '%".$data['name']."%' and ";
		}
		if($data['genre'] != ''){
			$kq = $kq." genre like '%".$data['genre']."%' and ";
		}
		if($data['description'] != ''){
			$kq = $kq." description like '%".$data['description']."%' and ";
		}
		if($data['actor'] != ''){
			$kq = $kq." actor like '%".$data['actor']."%' and ";
		}
		if($data['year'] != ''){
			$kq = $kq." year like '%".$data['year']."%' and ";
		}
		if($data['durations'] != ''){
			$kq = $kq." durations = '".$data['durations']."' and ";
		}

		$kq = $kq." 1=1 ";

		$kq=$kq." order by id desc ";
		return db::getdata($kq);
	}

		//lấy thông tin 1 phim
	function get_phim($data){
		$kq = "SELECT * FROM dtb_movies where id = '".$data."'";
		return db::getdata($kq);
	}

		//cập nhật thông tin phim
	function update_phim($data = array()){
		if(array_key_exists("image",$data) && array_key_exists("trailer",$data) ){
			$kq = "update dtb_movies set image = '".$data['image']."',name = '".$data['name']."',genre = '".$data['genre']."',description = '".$data['description']."',actor = '".$data['actor']."',year = '".$data['year']."',durations = '".$data['durations']."',trailer = '".$data['trailer']."',updated_at = now() where id = '".$data['id']."'";
		}else if(array_key_exists("trailer",$data) ){
			$kq = "update dtb_movies set name = '".$data['name']."',genre = '".$data['genre']."',description = '".$data['description']."',actor = '".$data['actor']."',year = '".$data['year']."',durations = '".$data['durations']."',trailer = '".$data['trailer']."',updated_at = now() where id = '".$data['id']."'";
		}else if(array_key_exists("image",$data) ){
			$kq = "update dtb_movies set image = '".$data['image']."',name = '".$data['name']."',genre = '".$data['genre']."',description = '".$data['description']."',actor = '".$data['actor']."',year = '".$data['year']."',durations = '".$data['durations']."',updated_at = now() where id = '".$data['id']."'";
		}else{
			$kq = "update dtb_movies set name = '".$data['name']."',genre = '".$data['genre']."',description = '".$data['description']."',actor = '".$data['actor']."',year = '".$data['year']."',durations = '".$data['durations']."',updated_at = now() where id = '".$data['id']."'";
		}
		return db::getdata($kq);
	}

		//thêm mới thông tin phim
	function add_phim($data = array()){
		$kq = "insert into dtb_movies (name,genre,description,image,actor,year,durations,trailer,created_at) values ('".$data['name']."','".$data['genre']."','".$data['description']."','".$data['image']."','".$data['actor']."','".$data['year']."','".$data['durations']."','".$data['trailer']."',now())";

		return db::getdata($kq);
	}

		//xóa phim
	function delete_phim($data){
		$kq = "delete FROM dtb_movies where id = '".$data."'";
		return db::getdata($kq);
	}


	/**********************************phim rạp*******************************/

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

	/**********************************vé phim*******************************/

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


	/**********************************khach hang*******************************/

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


	/**********************************user*******************************/

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
			$kq = "UPDATE `users` SET `name` = '".$data['name']."',`password` = '".$data['password']."',`email` = '".$data['email']."',`updated_at` = now() WHERE `id` = '".$data['id']."'";
		}else{
			$kq = "UPDATE `users` SET `name` = '".$data['name']."',`email` = '".$data['email']."',`updated_at` = now() WHERE `id` = '".$data['id']."'";
		}
		
		return db::getdata($kq);
	}

		//thêm mới thông tin phim
	function add_user($data = array()){
		if($data["password"] != "e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855"){
			$kq = "insert INTO `users`
			(`name`,`email`,`password`,`created_at`)
			VALUES
			('".$data['name']."','".$data['email']."','".$data['password']."',now())";
			return db::getdata($kq);
		}else{
			return false;
		}
	}

		//xóa phim
	function khoa_user($data){
		$kq = "delete FROM users where id = '".$data."'";
		return db::getdata($kq);
	}


	function thongkedoanhthu($data = array()){
		$kq="select t.`date`,c.`name` as c_name, m.`name` as m_name, sum(t.`price`) as total from `dtb_tickets` t
		left join `dtb_showtimes` st on t.showtime_id = st.id
		left join `dtb_movie_cinemas` mc on mc.id = st.movie_cinema_id
		left join `dtb_cinemas` c on c.id = mc.cinema_id
		left join `dtb_movies` m on m.id = mc.movie_id";
		$kq = $kq." where ";
		if($data['start'] != ''){
			$kq = $kq." t.`date` >= '".$data['start']."' and ";
		}
		if($data['end'] != ''){
			$kq = $kq." t.`date` <= '".$data['end']."' and ";
		}
		if($data['movie_id'] != ''){
			$kq = $kq." m.id = ".$data['movie_id']." and ";
		}
		if($data['cinema_id'] != ''){
			$kq = $kq." c.id = ".$data['cinema_id']." and ";
		}
		$kq = $kq." 1=1 ";
		$kq = $kq." group by t.`date`,c.`name`,m.`name` order by total desc limit 50";
		//return $kq;
		return db::getdata($kq);
	}

	function thongkephim($data = array()){
		$kq="select t.`date_rate`, m.`name` as m_name, sum(t.`rate`*t.`rate_times`) as total, sum(t.`rate_times`) as rate_time, sum(t.`rate`*t.`rate_times`)/sum(t.`rate_times`) as average from `dtb_rate` t
		left join `dtb_movies` m on m.id = t.movie_id";
		$kq = $kq." where ";
		if($data['start'] != ''){
			$kq = $kq." t.`date_rate` >= '".$data['start']."' and ";
		}
		if($data['end'] != ''){
			$kq = $kq." t.`date_rate` <= '".$data['end']."' and ";
		}
		if($data['movie_id'] != ''){
			$kq = $kq." m.id = ".$data['movie_id']." and ";
		}
		$kq = $kq." 1=1 ";
		$kq = $kq." group by m.`name` order by average desc limit 50";
		//return $kq;
		return db::getdata($kq);
	}
}