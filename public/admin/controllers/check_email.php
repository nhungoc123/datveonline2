<?php
include("../models/login_model.php");
$t=new ham();
if($_POST){
	$data = array(
		'email' => htmlspecialchars ( addslashes (trim($_POST['email'])))
		);
	$res = $t->check_email($data);
	if($res != 0){
		$kq = mysql_num_rows($res);
		if($kq>0){
			echo 1;
		}else{
			echo 0;
		}
	}else{
		echo 0;
	}
}else{
	echo 0;
}
?>