<?php
$act=isset($_GET['act'])?htmlspecialchars($_GET['act']):'infor';
if($act=='infor'){
	include_once("infor.php");
}else if($act=='login'){
	include_once("login.php");
}else if($act=='qlphim'){
	include_once("qlphim.php");
}else if($act=='qlxuatchieu'){
	include_once("qlxuatchieu.php");
}else if($act=='qlrapchieu'){
	include_once("qlrapchieu.php");
}else if($act=='qllichchieu'){
	include_once("qllichchieu.php");
}else if($act=='qlghe'){
	include_once("qlghe.php");
}else if($act=='qlloaighe'){
	include_once("qlloaighe.php");
}else if($act=='qlphimrap'){
	include_once("qlphimrap.php");
}else if($act=='qlve'){
	include_once("qlve.php");
}else if($act=='qlkhachhang'){
	include_once("qlkhachhang.php");
}else if($act=='qluser'){
	include_once("qluser.php");
}else if($act=='thongkedoanhthu'){
	include_once("thongkedoanhthu.php");
}else if($act=='thongkephim'){
	include_once("thongkephim.php");
}
?>