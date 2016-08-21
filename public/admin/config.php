<?php
include_once("../../../define.php");
ob_start();
session_start();
$root= HTTP_HOST.'admin/';
$params = array(
   'page' => 1,
   'per_page' => 20,
   'table_name' => '',
   );
