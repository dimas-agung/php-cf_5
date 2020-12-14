<?php

//CLASS FORM AWAL
$class_form='class="active"';
$class_pane_form='class="tab-pane in active"';
$class_tab="";
$class_pane_tab='class="tab-pane"';


// UBAH PENCARIAN BERDASAR STATUS DI db
if(isset($_POST['status'])) {
if($_POST['status']=='y'){
	$status='1';
}else if($_POST['status']=='n'){
	$status='0';
}
}

// Saat klik tombol cari
if(isset($_POST['cari'])) {
	//CLASS FORM SAAT KLIK TOMBOL CARI
	$class_tab='class="active"';
	$class_pane_tab='class="tab-pane in active"';
	$class_form="";
	$class_pane_form='class="tab-pane"';
	
	
	if(($_POST['status']=='y' OR $_POST['status']=='n')) {
		$q_sat = mysql_query("SELECT * FROM satuan WHERE aktif='".$status."'"); 
	}else{
		$q_sat = mysql_query("SELECT * FROM satuan");
	}
}else{
		$q_sat = mysql_query("SELECT * FROM satuan"); 	
}


// Simpan ke database
if(isset($_POST['simpan'])) {
	
	$_POST = array_map("strtoupper",$_POST);
	
	$kode_satuan=mres($_POST['kode_satuan']);
	$nama=mres($_POST['nama']);
	$keterangan=mres($_POST['keterangan']);
	
	$sql = "INSERT INTO satuan (kode_satuan,nama,keterangan) VALUES ('".$kode_satuan."','".$nama."','".$keterangan."')";
	$query = mysql_query ($sql) ;
	
	if ($query) {
		//echo "<meta http-equiv='refresh' content='0; url=".base_url()."?module=setting/cabang' />";
		$info = 'SIMPAN DATA SUKSES';
		echo("<script>location.href = '".base_url()."?page=master/satuan&inputsukses&halaman= SATUAN';</script>");
		
	} else { 
		//$response = "99||Simpan data gagal. ".mysql_error(); 
		$warning = "SIMPAN DATA GAGAL"; 
	}
}

// Update ke database
if(isset($_GET['action']) and $_GET['action'] == "edit") {
	$id_satuan = mres($_GET['id_satuan']);
	
	$q_edit_sat = mysql_query("SELECT * FROM satuan WHERE id_satuan = '".$id_satuan."'");
	
	if(isset($_POST['update'])) {
		$_POST = array_map("strtoupper",$_POST);
		
		$nama=mres($_POST['nama']);
		$keterangan=mres($_POST['keterangan']);		
			
		$sql = "UPDATE satuan SET nama = '".$nama."', keterangan = '".$keterangan."' WHERE id_satuan = '".$id_satuan."'";
		$query = mysql_query ($sql) ;
		
		if ($query) {
			//echo "<meta http-equiv='refresh' content='0; url=".base_url()."?page=karyawan' />";
			$info = 'UPDATE DATA SUKSES';
			echo("<script>location.href = '".base_url()."?page=master/satuan&updatesukses&halaman= SATUAN';</script>");
		} else {
			//$response = "99||Update data gagal. ".mysql_error();
			$warning = "UPDATE DATA GAGAL"; 
		}
	}
}

// NON AKTIF DAN AKTIFKAN STATUS
if(isset($_GET['action']) and $_GET['action'] == "nonaktif") {
	$id_satuan = mres($_GET['id_satuan']);
	
		$sql = "UPDATE satuan SET aktif = '0' WHERE id_satuan = '".$id_satuan."'";
		$query = mysql_query ($sql) ;
		
		echo("<script>location.href = '".base_url()."?page=master/satuan&halaman= SATUAN';</script>");
	
}else if(isset($_GET['action']) and $_GET['action'] == "aktif"){
	$id_satuan = mres($_GET['id_satuan']);
	
		$sql = "UPDATE satuan SET aktif = '1' WHERE id_satuan = '".$id_satuan."'";
		$query = mysql_query ($sql) ;
		
		echo("<script>location.href = '".base_url()."?page=master/satuan&halaman= SATUAN';</script>");
}

// TRACK 
if(isset($_GET['action']) and $_GET['action'] == "track") {
	$id_satuan = ($_GET['id_satuan']);
	
	$q_sat_prev = mysql_query("SELECT id_satuan FROM satuan WHERE id_satuan = (select max(id_satuan) FROM satuan WHERE id_satuan < ".$id_satuan.")");
	
	$q_sat_next = mysql_query("SELECT id_satuan FROM satuan WHERE id_satuan = (select min(id_satuan) FROM satuan WHERE id_satuan > ".$id_satuan.")");
	
	$q_sat = mysql_query("SELECT * FROM satuan WHERE id_satuan = '".$id_satuan."'");
	
}



?>