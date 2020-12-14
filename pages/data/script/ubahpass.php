<?php

// Update ke database
if(isset($_GET['action']) and $_GET['action'] == "edit") {
	$kd_user = mres($_GET['kode']);
	
	$q_edit = mysql_query("SELECT * FROM user WHERE kd_user = '".$kd_user."'");
	
	if(isset($_POST['update'])) {
		//$_POST = array_map("strtoupper",$_POST);
		
		$password_lama_asli=mres($_POST['pass_lama_asli']);
		$password_lama=mres($_POST['pass_lama']);
		$password=mres($_POST['pass_baru']);
		$password_ulang=mres($_POST['pass_ulang']);
		
		if($password_lama<>$password_lama_asli)
		{
			$warning = " PASSWORD LAMA SALAH!!!";
			return false; 	
		}
		
		if($password<>$password_ulang)
		{
			$warning = " ULANG PASSWORD TIDAK SAMA!!!";
			return false; 	
		}
	
		$sql = "UPDATE user SET password='".$password."' WHERE kd_user = '".$kd_user."'";
		$query = mysql_query ($sql) ;
		
			if ($query) {
				//echo "<meta http-equiv='refresh' content='0; url=".base_url()."?page=karyawan' />";
				$info = ' UPDATE DATA SUKSES';
				echo("<script>location.href = '".base_url()."logout.php';</script>");
			} else {
				//$response = "99||Update data gagal. ".mysql_error();
				$warning = " UPDATE DATA GAGAL"; 
			}
	}
}

?>