<?php
session_start();
include "../../../../library/conn.php";
include "../../../../library/helper.php";
 
if($_POST) {
	
	$id_penawaran = $_POST['id'];
	$tgl_hari_ini=date('Y-m-d');
        
	$id_user = $_SESSION['app_id'];
	
	$update_cmd = "UPDATE penawaran_hdr SET status_app = '1', user_app_1 = '" . $id_user . "', tgl_approve='".$tgl_hari_ini."' WHERE id_penawaran = " . $id_penawaran;
	$update = mysql_query($update_cmd);

	if(!$update) 
		die("Error query" . mysql_error());
	else {
		$nav = base_url() . '?page=approval/index';
		redirect($nav);
	}
	
}