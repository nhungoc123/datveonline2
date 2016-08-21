<?php
include_once("data.php");
class qlphim extends db{
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
}
?>
