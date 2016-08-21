<?php
include("../models/qlrapchieu_model.php");
include("../models/qlghe_model.php");
$g = new qlghe();
$rc = new qlrapchieu();

$data = array(
	'id' => '',
	'row' => '',
	'column' => '',
	'type' => '',
	'cinema_id' => htmlspecialchars($_POST['cinema_id']),
	);
$ghe_list =  $g->find_ghe($data);

if(isset($ghe_list) && $ghe_list !== false && $data['cinema_id'] != ''){
	while ($data = mysql_fetch_array($ghe_list)) {
		echo"<option value='".$data['id']."'>hàng ".$data['row']." cột ".$data['column']."</option>";
	}
}else{
	echo "1";
}

?>