<?php
require '../config.php';
if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
	unset($_SESSION['user']);
	header("location:".$root."");
}else{
	header("location:".$root."");
}

?>