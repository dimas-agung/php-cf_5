<?php

$q_tp = mysql_query("SELECT * FROM (SELECT id,bulan,SUBSTRING(bulan,1,2) bul,SUBSTRING(bulan,4,4) thn FROM close) AS tbl ORDER BY thn ASC, bul ASC"); 	

// Simpan ke database
if(isset($_POST['simpan'])) {
	
	$_POST = array_map("strtoupper",$_POST);
	
	$bulan  = mres($_POST['bulan']);
	$tahun  = mres($_POST['tahun']);
	$bulantahun = $bulan.'-'.$tahun;
	
	$sql = "INSERT INTO close (bulan) VALUES ('".$bulantahun."')";
	$query = mysql_query ($sql) ;
	
	if ($query) {
		//echo "<meta http-equiv='refresh' content='0; url=".base_url()."?module=setting/cabang' />";
		$info = 'SIMPAN DATA SUKSES';
		echo("<script>location.href = '".base_url()."?page=setting/tutup_periode&inputsukses';</script>");
		
	} else { 
		//$response = "99||Simpan data gagal. ".mysql_error(); 
		$warning = "SIMPAN DATA GAGAL"; 
	}
}

// Ini untuk hapus data
if(isset($_GET['action']) and $_GET['action'] == "hapus") {
	$id = mres($_GET['id']);
	$query = mysql_query("DELETE FROM close WHERE id = '".$id."'");
			mysql_query($query);
	echo("<script>location.href = '".base_url()."?page=setting/tutup_periode&deletesukses';</script>");
}
?>