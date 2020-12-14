<?php
session_start();
include "../../../../library/conn.php";
include "../../../../library/helper.php";

if($_POST) {
	$id_user = $_SESSION['app_id'];
	$id_penawaran = $_POST['id'];
	$tgl_hari_ini=date('Y-m-d');
	$alasan_batal = mres($_POST['alasan_batal']);
	if($alasan_batal==''){
		echo "<script type='text/javascript'>window.alert('ALASAN BATAL TIDAK BOLEH KOSONG!!!');</script>" ;
		$nav = base_url() . '?page=approval/detail&kode='.$id_penawaran.'';
		redirect($nav);
		return false;	
	}
	$update_cmd = "UPDATE penawaran_hdr SET status_app = '2', alasan_batal= '" . $alasan_batal . "', user_reject='".$id_user."', tgl_reject='".$tgl_hari_ini."' WHERE id_penawaran = " . $id_penawaran;
	$update = mysql_query($update_cmd);
	
	

	if(!$update) 
		die("Error query");
	else {
		$nav = base_url() . '?page=approval/index';
		redirect($nav);
	}
}