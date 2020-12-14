<?php

$q_user = mysql_query("SELECT u.*, r.nama jabatan FROM user u INNER JOIN mst_role_hdr r ON u.level=r.kode_role WHERE kode_role not in ('1','11') ORDER BY nm_user ASC"); 

//DDL
$q_ddl_level = mysql_query("SELECT * FROM mst_role_hdr WHERE kode_role not in ('1') ORDER BY kode_role ASC");

// Simpan ke database
if(isset($_POST['simpan'])) {
	
	//$_POST = array_map("strtoupper",$_POST);
	
	$nm_user=mres($_POST['nama']);
	$level=mres($_POST['jabatan']);
	$username=mres($_POST['username']);
	$password=mres($_POST['password']);
	
	//$tgl_input=date("Y-m-d H:i:s");
	
	$sql = "INSERT INTO user SET 
								nm_user 	= '".$nm_user."',
								username 	= '".$username."',
								password	= '".$password."',
								level		= '".$level."' ";
	$query = mysql_query ($sql) ;
	
	
	if ($query) {
		//echo "<meta http-equiv='refresh' content='0; url=".base_url()."?module=setting/cabang' />";
		$info = 'SIMPAN DATA SUKSES';
		echo ("	<script LANGUAGE='JavaScript'>
          			window.alert('SIMPAN DATA SUKSES!!!');
          			window.location.href='".base_url()."?page=user';
       				</script>");
		
	} else { 
		//$response = "99||Simpan data gagal. ".mysql_error();
		$warning = "SIMPAN DATA GAGAL"; 
	}
}

// Update ke database
if(isset($_GET['action']) and $_GET['action'] == "edit") {
	$kd_user = mres($_GET['kode']);
	
	$q_edit = mysql_query("SELECT * FROM user WHERE kd_user = '".$kd_user."'");
	
	if(isset($_POST['update'])) {
		//$_POST = array_map("strtoupper",$_POST);
		
		$nm_user=mres($_POST['nama']);
		$level=mres($_POST['jabatan']);
		$username=mres($_POST['username']);
		$password=mres($_POST['password']);
		$aktif=mres($_POST['aktif']);
	
		$sql = "UPDATE user SET nm_user = '".$nm_user."', level='".$level."', username='".$username."', password='".$password."', aktif='".$aktif."' WHERE kd_user = '".$kd_user."'";
		$query = mysql_query ($sql) ;
		
		if ($query) {
			//echo "<meta http-equiv='refresh' content='0; url=".base_url()."?page=karyawan' />";
			$info = ' UPDATE DATA SUKSES';
			echo ("	<script LANGUAGE='JavaScript'>
          			window.alert('UPDATE DATA SUKSES!!!');
          			window.location.href='".base_url()."?page=user';
       				</script>");
		} else {
			//$response = "99||Update data gagal. ".mysql_error();
			$warning = " UPDATE DATA GAGAL"; 
		}
	}
}

// NON AKTIF DAN AKTIFKAN STATUS
if(isset($_GET['action']) and $_GET['action'] == "nonaktif") {
	$kd_user = mres($_GET['kode']);
	
		$sql = "UPDATE user SET aktif = '0' WHERE kd_user = '".$kd_user."'";
		$query = mysql_query ($sql) ;
		
		echo("<script>location.href = '".base_url()."?page=user';</script>");
	
}else if(isset($_GET['action']) and $_GET['action'] == "aktif"){
	$kd_user = mres($_GET['kode']);
	
		$sql = "UPDATE user SET aktif = '1' WHERE kd_user = '".$kd_user."'";
		$query = mysql_query ($sql) ;
		
		echo("<script>location.href = '".base_url()."?page=user';</script>");
}


?>