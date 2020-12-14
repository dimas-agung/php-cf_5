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
		$q_coa = mysql_query("SELECT * FROM kategori_coa WHERE aktif='".$status."'"); 
	}else{
		$q_coa = mysql_query("SELECT * FROM kategori_coa");
	}
}else{
		$q_coa = mysql_query("SELECT * FROM kategori_coa"); 	
}


// Simpan ke database
if(isset($_POST['simpan'])) {
	
	$_POST = array_map("strtoupper",$_POST);
	
	$kode_kat_coa=mres($_POST['kode_kat_coa']);
	$nama=mres($_POST['nama']);
	
	$sql = "INSERT INTO kategori_coa (kode_kat_coa,nama) VALUES ('".$kode_kat_coa."','".$nama."')";
	$query = mysql_query ($sql) ;
	
	if ($query) {
		//echo "<meta http-equiv='refresh' content='0; url=".base_url()."?module=setting/cabang' />";
		$info = 'SIMPAN DATA SUKSES';
		echo("<script>location.href = '".base_url()."?page=setting/kat_coa&inputsukses&halaman= KATEGORI COA';</script>");
		
	} else { 
		//$response = "99||Simpan data gagal. ".mysql_error(); 
		$warning = "SIMPAN DATA GAGAL"; 
	}
}

// Update ke database
if(isset($_GET['action']) and $_GET['action'] == "edit") {
	$id_kat_coa = mres($_GET['id_kat_coa']);
	
	$q_edit_coa = mysql_query("SELECT * FROM kategori_coa WHERE id_kat_coa = '".$id_kat_coa."'");
	
	if(isset($_POST['update'])) {
		$_POST = array_map("strtoupper",$_POST);
		
		$nama=mres($_POST['nama']);
	
		$sql = "UPDATE kategori_coa SET nama = '".$nama."' WHERE id_kat_coa = '".$id_kat_coa."'";
		$query = mysql_query ($sql) ;
		
		if ($query) {
			//echo "<meta http-equiv='refresh' content='0; url=".base_url()."?page=karyawan' />";
			$info = 'UPDATE DATA SUKSES';
			echo("<script>location.href = '".base_url()."?page=setting/kat_coa&updatesukses&halaman= KATEGORI COA';</script>");
		} else {
			//$response = "99||Update data gagal. ".mysql_error();
			$warning = "UPDATE DATA GAGAL"; 
		}
	}
}

// NON AKTIF DAN AKTIFKAN STATUS
if(isset($_GET['action']) and $_GET['action'] == "nonaktif") {
	$id_kat_coa = mres($_GET['id_kat_coa']);
	
		$sql = "UPDATE kategori_coa SET aktif = '0' WHERE id_kat_coa = '".$id_kat_coa."'";
		$query = mysql_query ($sql) ;
		
		echo("<script>location.href = '".base_url()."?page=setting/kat_coa&halaman= KATEGORI COA';</script>");
	
}else if(isset($_GET['action']) and $_GET['action'] == "aktif"){
	$id_kat_coa = mres($_GET['id_kat_coa']);
	
		$sql = "UPDATE kategori_coa SET aktif = '1' WHERE id_kat_coa = '".$id_kat_coa."'";
		$query = mysql_query ($sql) ;
		
		echo("<script>location.href = '".base_url()."?page=setting/kat_coa&halaman= KATEGORI COA';</script>");
}

// TRACK 
if(isset($_GET['action']) and $_GET['action'] == "track") {
	$id_kat_coa = ($_GET['id_kat_coa']);
	
	$q_coa_prev = mysql_query("SELECT id_kat_coa FROM kategori_coa WHERE id_kat_coa = (select max(id_kat_coa) FROM kategori_coa WHERE id_kat_coa < ".$id_kat_coa.")");
	
	$q_coa_next = mysql_query("SELECT id_kat_coa FROM kategori_coa WHERE id_kat_coa = (select min(id_kat_coa) FROM kategori_coa WHERE id_kat_coa > ".$id_kat_coa.")");
	
	$q_coa = mysql_query("SELECT * FROM kategori_coa WHERE id_kat_coa = '".$id_kat_coa."'");
	
}



?>