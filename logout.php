<?php 
	session_start();
	include "library/helper.php";
	session_destroy();
	redirect(base_url()."login.php");
?>