<?php

//CLASS FORM AWAL
$class_form='class="active"';
$class_pane_form='class="tab-pane in active"';
$class_tab="";
$class_pane_tab='class="tab-pane"';

//DDL
$q_header = mysql_query("SELECT * FROM ddl_header_cf "); 


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
		$q_cf = mysql_query("SELECT kc.*,header.keterangan ket_header FROM kategori_cashflow kc INNER JOIN ddl_header_cf header ON header.kode_header=kc.header WHERE aktif='".$status."' ORDER BY kc.kode_kat_cashflow ASC"); 
	}else{
		$q_cf = mysql_query("SELECT kc.*,header.keterangan ket_header FROM kategori_cashflow kc INNER JOIN ddl_header_cf header ON header.kode_header=kc.header ORDER BY kc.kode_kat_cashflow ASC");
	}
}else{
		$q_cf = mysql_query("SELECT kc.*,header.keterangan ket_header FROM kategori_cashflow kc INNER JOIN ddl_header_cf header ON header.kode_header=kc.header ORDER BY kc.kode_kat_cashflow ASC"); 	
}


// Simpan ke database
if(isset($_POST['simpan'])) {
	
	$_POST = array_map("strtoupper",$_POST);
	
	$kode_kat_cashflow=mres($_POST['kode_kat_cashflow']);
	$nama=mres($_POST['nama']);
	$header=mres($_POST['header']);
	
	$sql = "INSERT INTO kategori_cashflow (kode_kat_cashflow,nama,header) VALUES ('".$kode_kat_cashflow."','".$nama."','".$header."')";
	$query = mysql_query ($sql) ;
	
	if ($query) {
		//echo "<meta http-equiv='refresh' content='0; url=".base_url()."?module=setting/cabang' />";
		$info = 'SIMPAN DATA SUKSES';
		echo("<script>location.href = '".base_url()."?page=setting/kat_cashflow&inputsukses&halaman= KATEGORI CHASHFLOW';</script>");
		
	} else { 
		//$response = "99||Simpan data gagal. ".mysql_error(); 
		$warning = "SIMPAN DATA GAGAL"; 
	}
}

// Update ke database
if(isset($_GET['action']) and $_GET['action'] == "edit") {
	$id_kat_cashflow = mres($_GET['id_kat_cashflow']);
	
	$q_edit_cf = mysql_query("SELECT * FROM kategori_cashflow WHERE id_kat_cashflow = '".$id_kat_cashflow."'");
	
	if(isset($_POST['update'])) {
		$_POST = array_map("strtoupper",$_POST);
		
		$nama=mres($_POST['nama']);
		$header=mres($_POST['header']);
	
		$sql = "UPDATE kategori_cashflow SET nama = '".$nama."', header = '".$header."' WHERE id_kat_cashflow = '".$id_kat_cashflow."'";
		$query = mysql_query ($sql) ;
		
		if ($query) {
			//echo "<meta http-equiv='refresh' content='0; url=".base_url()."?page=karyawan' />";
			$info = 'UPDATE DATA SUKSES';
			echo("<script>location.href = '".base_url()."?page=setting/kat_cashflow&updatesukses&halaman= KATEGORI CHASHFLOW';</script>");
		} else {
			//$response = "99||Update data gagal. ".mysql_error();
			$warning = "UPDATE DATA GAGAL"; 
		}
	}
}

// NON AKTIF DAN AKTIFKAN STATUS
if(isset($_GET['action']) and $_GET['action'] == "nonaktif") {
	$id_kat_cashflow = mres($_GET['id_kat_cashflow']);
	
		$sql = "UPDATE kategori_cashflow SET aktif = '0' WHERE id_kat_cashflow = '".$id_kat_cashflow."'";
		$query = mysql_query ($sql) ;
		
		echo("<script>location.href = '".base_url()."?page=setting/kat_cashflow&halaman= KATEGORI CHASHFLOW';</script>");
	
}else if(isset($_GET['action']) and $_GET['action'] == "aktif"){
	$id_kat_cashflow = mres($_GET['id_kat_cashflow']);
	
		$sql = "UPDATE kategori_cashflow SET aktif = '1' WHERE id_kat_cashflow = '".$id_kat_cashflow."'";
		$query = mysql_query ($sql) ;
		
		echo("<script>location.href = '".base_url()."?page=setting/kat_cashflow&halaman= KATEGORI CHASHFLOW';</script>");
}

// TRACK 
if(isset($_GET['action']) and $_GET['action'] == "track") {
	$id_kat_cashflow = ($_GET['id_kat_cashflow']);
	
	$q_cf_prev = mysql_query("SELECT id_kat_cashflow FROM kategori_cashflow WHERE id_kat_cashflow = (select max(id_kat_cashflow) FROM kategori_cashflow WHERE id_kat_cashflow < ".$id_kat_cashflow.")");
	
	$q_cf_next = mysql_query("SELECT id_kat_cashflow FROM kategori_cashflow WHERE id_kat_cashflow = (select min(id_kat_cashflow) FROM kategori_cashflow WHERE id_kat_cashflow > ".$id_kat_cashflow.")");
	
	$q_cf = mysql_query("SELECT kc.*,header.keterangan ket_header FROM kategori_cashflow kc INNER JOIN ddl_header_cf header ON header.kode_header=kc.header WHERE id_kat_cashflow = '".$id_kat_cashflow."'");
	
}



?>