<?php
	include_once("../../../require.php");
	ob_start();
	$root= HTTP_HOST.'admin/';
    include("../library/function.php");
    $t=new ham();
    
    $params = array(
    	'page' => 1,
    	'per_page' => 20,
    	'table_name' => '',
    );
