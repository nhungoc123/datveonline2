<?php
include_once("data.php");
class qlthongke extends db{

	function thongkedoanhthu($data = array()){
		$kq="select t.`date`,c.`name` as c_name, m.`name` as m_name, sum(t.`price`)*1000 as total,s.`type`,count(*) as tick_num, tt.tick_total from `dtb_tickets` t
		left join `dtb_showtimes` st on t.showtime_id = st.id
		left join `dtb_movie_cinemas` mc on mc.id = st.movie_cinema_id
		left join `dtb_cinemas` c on c.id = mc.cinema_id
		left join `dtb_movies` m on m.id = mc.movie_id
		left join `dtb_seats` s on s.id = t.seat_id
		left join (
		select count(*) as tick_total, ss.`cinema_id`, ss.`type`
		from `dtb_seats` ss 
		group by ss.cinema_id, ss.`type`
		) as tt on tt.cinema_id = mc.cinema_id and tt.`type` = s.`type` ";
		$kq = $kq." where t.price > 0 and ";
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
		$kq = $kq." group by t.`date`,c.`name`,m.`name`,s.`type` order by total desc limit 50;";
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