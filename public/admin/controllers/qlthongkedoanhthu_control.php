<?php
include("../models/qlthongke_model.php");
include("../models/qlphim_model.php");
include("../models/qlrapchieu_model.php");
$tk = new qlthongke();
$p = new qlphim();
$rc = new qlrapchieu();

date_default_timezone_set('Asia/Ho_Chi_Minh');
$today = date("Y-m-d H:i:s");

$rapchieu_list = $rc->get_rap_list();
$phim_list = $p->get_phim_list();

//thêm
if(isset($_POST['submit'])){
	$data = array(
		'start' => htmlspecialchars($_POST['start']),
		'end' => htmlspecialchars($_POST['end']),
		'movie_id' => htmlspecialchars($_POST['movie_id']),
		'cinema_id' => htmlspecialchars($_POST['cinema_id']),
		);
	if($data['start']=='' && $data['end']=='' && $data['movie_id']=='' && $data['cinema_id']==''){
		echo "<script>error('Thống kê cần ít nhất một giá trị nhập vào','?act=thongkedoanhthu');</script>";
		exit();
	}

	$thongke = $tk->thongkedoanhthu($data);
	$sum = 0;
	$temp = $tk->thongkedoanhthu($data);
	while ($data = mysql_fetch_array($temp)) {
		$sum += intval($data['total']);
	}

}
function formatMoney($number, $fractional=false) { 
	if ($fractional) { 
		$number = sprintf('%.2f', $number); 
	} 
	while (true) { 
		$replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number); 
		if ($replaced != $number) { 
			$number = $replaced; 
		} else { 
			break; 
		} 
	} 
	return $number; 
} 
?>