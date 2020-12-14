<?php

//CLASS FORM AWAL
$class_form='class="active"';
$class_pane_form='class="tab-pane in active"';
$class_tab="";
$class_pane_tab='class="tab-pane"';

//cabang aktif
$q_cab_aktif = mysql_query("SELECT * FROM cabang WHERE aktif='1'"); 


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
		$q_gud = mysql_query("SELECT gud.*, cab.nama cabang FROM gudang gud INNER JOIN cabang cab on gud.kode_cabang=cab.kode_cabang WHERE gud.is_produksi = 'no' AND gud.aktif='".$status."'"); 
	}else{
		$q_gud = mysql_query("SELECT gud.*, cab.nama cabang FROM gudang gud INNER JOIN cabang cab on gud.kode_cabang=cab.kode_cabang WHERE gud.is_produksi = 'no'");
	}
}else{
		$q_gud = mysql_query("SELECT gud.*, cab.nama cabang FROM gudang gud INNER JOIN cabang cab on gud.kode_cabang=cab.kode_cabang WHERE gud.is_produksi = 'no'"); 	
}


// Simpan ke database
if(isset($_POST['simpan'])) {
	
	$_POST = array_map("strtoupper",$_POST);
	
	$kode_gudang=mres($_POST['kode_gudang']);
	$kode_cabang=mres($_POST['kode_cabang']);
	$nama=mres($_POST['nama']);
	$alamat=mres($_POST['alamat']);
	$kota=mres($_POST['kota']);
	$keterangan=mres($_POST['keterangan']);
	
	$sql = "INSERT INTO gudang (kode_gudang,kode_cabang,nama,alamat,kota,keterangan) VALUES ('".$kode_gudang."','".$kode_cabang."','".$nama."','".$alamat."','".$kota."','".$keterangan."')";
	$query = mysql_query ($sql) ;
	
	if ($query) {
		//echo "<meta http-equiv='refresh' content='0; url=".base_url()."?module=setting/cabang' />";
		$info = 'SIMPAN DATA SUKSES';
		echo("<script>location.href = '".base_url()."?page=setting/gudang&inputsukses&halaman= GUDANG';</script>");
		
	} else { 
		//$response = "99||Simpan data gagal. ".mysql_error(); 
		$warning = "SIMPAN DATA GAGAL"; 
	}
}

// Update ke database
if(isset($_GET['action']) and $_GET['action'] == "edit") {
	$id_gudang = mres($_GET['id_gudang']);
	
	$q_edit_gud = mysql_query("SELECT * FROM gudang WHERE id_gudang = '".$id_gudang."'");
	
	if(isset($_POST['update'])) {
		$_POST = array_map("strtoupper",$_POST);
		
		$kode_cabang=mres($_POST['kode_cabang']);
		$nama=mres($_POST['nama']);
		$alamat=mres($_POST['alamat']);
		$kota=mres($_POST['kota']);
		$keterangan=mres($_POST['keterangan']);		
			
		$sql = "UPDATE gudang SET kode_cabang = '".$kode_cabang."',nama = '".$nama."', alamat = '".$alamat."', kota = '".$kota."', keterangan = '".$keterangan."' WHERE id_gudang = '".$id_gudang."'";
		$query = mysql_query ($sql) ;
		
		if ($query) {
			//echo "<meta http-equiv='refresh' content='0; url=".base_url()."?page=karyawan' />";
			$info = 'UPDATE DATA SUKSES';
			echo("<script>location.href = '".base_url()."?page=setting/gudang&updatesukses&halaman= GUDANG';</script>");
		} else {
			//$response = "99||Update data gagal. ".mysql_error();
			$warning = "UPDATE DATA GAGAL"; 
		}
	}
}

// NON AKTIF DAN AKTIFKAN STATUS
if(isset($_GET['action']) and $_GET['action'] == "nonaktif") {
	$id_gudang = mres($_GET['id_gudang']);
	
		$sql = "UPDATE gudang SET aktif = '0' WHERE id_gudang = '".$id_gudang."'";
		$query = mysql_query ($sql) ;
		
		echo("<script>location.href = '".base_url()."?page=setting/gudang&halaman= GUDANG';</script>");
	
}else if(isset($_GET['action']) and $_GET['action'] == "aktif"){
	$id_gudang = mres($_GET['id_gudang']);
	
		$sql = "UPDATE gudang SET aktif = '1' WHERE id_gudang = '".$id_gudang."'";
		$query = mysql_query ($sql) ;
		
		echo("<script>location.href = '".base_url()."?page=setting/gudang&halaman= GUDANG';</script>");
}

// TRACK 
if(isset($_GET['action']) and $_GET['action'] == "track") {
	$id_gudang = ($_GET['id_gudang']);
	
	$q_gud_prev = mysql_query("SELECT id_gudang FROM gudang WHERE id_gudang = (select max(id_gudang) FROM gudang WHERE gud.is_produksi = 'no' AND id_gudang < ".$id_gudang.")");
	
	$q_gud_next = mysql_query("SELECT id_gudang FROM gudang WHERE id_gudang = (select min(id_gudang) FROM gudang WHERE gud.is_produksi = 'no' AND id_gudang > ".$id_gudang.")");
	
	$q_gud = mysql_query("SELECT gud.*, cab.nama cabang FROM gudang gud INNER JOIN cabang cab on gud.kode_cabang=cab.kode_cabang WHERE gud.is_produksi = 'no' AND id_gudang = '".$id_gudang."'");
	
}



?>