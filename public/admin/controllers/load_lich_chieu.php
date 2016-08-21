<?php
include("../models/qllichchieu_model.php");
$lc = new qllichchieu();

$data = array(
	'id' => "",
	'movie_cinema_id' => htmlspecialchars($_POST['movie_cinema_id']),
	'performance_id' => '',
	);
$lichchieu_list = $lc->find_lichchieu($data);
if(isset($lichchieu_list) && $lichchieu_list !== false && $data['movie_cinema_id'] != ''){
	while ($data = mysql_fetch_array($lichchieu_list)) {
		echo"<option value='".$data['id']."'>".$data['m_name']." - ".$data['c_name']." - ".$data['performance_time']."</option>";
	}
}else{
	echo "1";
}


?>