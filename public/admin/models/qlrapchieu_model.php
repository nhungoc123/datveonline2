<?php
include_once("data.php");
class qlrapchieu extends db{
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
		$kq = "delete FROM dtb_seats where cinema_id = '".$data."'";
		if(db::getdata($kq)){
			$kq = "delete FROM dtb_cinemas where id = '".$data."'";
			return db::getdata($kq);
		}else{
			return false;
		}
	}
}
?>