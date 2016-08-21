<?php
include("../models/qlthongke_model.php");
include("../models/qlphim_model.php");
$tk = new qlthongke();
$p = new qlphim();

date_default_timezone_set('Asia/Ho_Chi_Minh');
$today = date("Y-m-d H:i:s");

$phim_list = $p->get_phim_list();

//thêm
if(isset($_POST['submit'])){
	$data = array(
		'start' => htmlspecialchars($_POST['start']),
		'end' => htmlspecialchars($_POST['end']),
		'movie_id' => htmlspecialchars($_POST['movie_id'])
		);
	if($data['start']=='' && $data['end']=='' && $data['movie_id']==''){
		echo "<script>error('Thống kê cần ít nhất một giá trị nhập vào','?act=thongkephim');</script>";
		exit();
	}
	$thongke = $tk->thongkephim($data);
}
?>