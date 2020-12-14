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
		$q_cc = mysql_query("SELECT * FROM kategori_divisi WHERE aktif='".$status."'"); 
	}else{
		$q_cc = mysql_query("SELECT * FROM kategori_divisi");
	}
}else{
		$q_cc = mysql_query("SELECT * FROM kategori_divisi"); 	
}


// Simpan ke database
if(isset($_POST['simpan'])) {
	
	$_POST = array_map("strtoupper",$_POST);
	
	$kode_cc=mres($_POST['kode_cc']);
	$nama=mres($_POST['nama']);
	$keterangan=mres($_POST['keterangan']);
	
	$sql = "INSERT INTO kategori_divisi (kode_cc,nama,keterangan) VALUES ('".$kode_cc."','".$nama."','".$keterangan."')";
	$query = mysql_query ($sql) ;
	
	if ($query) {
		//echo "<meta http-equiv='refresh' content='0; url=".base_url()."?module=setting/cabang' />";
		$info = 'SIMPAN DATA SUKSES';
		echo("<script>location.href = '".base_url()."?page=setting/kat_divisi&inputsukses&halaman= KATEGORI DIVISI';</script>");
		
	} else { 
		//$response = "99||Simpan data gagal. ".mysql_error(); 
		$warning = "SIMPAN DATA GAGAL"; 
	}
}

// Update ke database
if(isset($_GET['action']) and $_GET['action'] == "edit") {
	$id_cc = mres($_GET['id_cc']);
	
	$q_edit_cc = mysql_query("SELECT * FROM kategori_divisi WHERE id_cc = '".$id_cc."'");
	
	if(isset($_POST['update'])) {
		$_POST = array_map("strtoupper",$_POST);
		
		$nama=mres($_POST['nama']);
		$keterangan=mres($_POST['keterangan']);		
			
		$sql = "UPDATE kategori_divisi SET nama = '".$nama."', keterangan = '".$keterangan."' WHERE id_cc = '".$id_cc."'";
		$query = mysql_query ($sql) ;
		
		if ($query) {
			//echo "<meta http-equiv='refresh' content='0; url=".base_url()."?page=karyawan' />";
			$info = 'UPDATE DATA SUKSES';
			echo("<script>location.href = '".base_url()."?page=setting/kat_divisi&updatesukses&halaman= KATEGORI DIVISI';</script>");
		} else {
			//$response = "99||Update data gagal. ".mysql_error();
			$warning = "UPDATE DATA GAGAL"; 
		}
	}
}

// NON AKTIF DAN AKTIFKAN STATUS
if(isset($_GET['action']) and $_GET['action'] == "nonaktif") {
	$id_cc = mres($_GET['id_cc']);
	
		$sql = "UPDATE kategori_divisi SET aktif = '0' WHERE id_cc = '".$id_cc."'";
		$query = mysql_query ($sql) ;
		
		echo("<script>location.href = '".base_url()."?page=setting/kat_divisi&halaman= KATEGORI DIVISI';</script>");
	
}else if(isset($_GET['action']) and $_GET['action'] == "aktif"){
	$id_cc = mres($_GET['id_cc']);
	
		$sql = "UPDATE kategori_divisi SET aktif = '1' WHERE id_cc = '".$id_cc."'";
		$query = mysql_query ($sql) ;
		
		echo("<script>location.href = '".base_url()."?page=setting/kat_divisi&halaman= KATEGORI DIVISI';</script>");
}

// TRACK 
if(isset($_GET['action']) and $_GET['action'] == "track") {
	$id_cc = ($_GET['id_cc']);
	
	$q_cc_prev = mysql_query("SELECT id_cc FROM kategori_divisi WHERE id_cc = (select max(id_cc) FROM kategori_divisi WHERE id_cc < ".$id_cc.")");
	
	$q_cc_next = mysql_query("SELECT id_cc FROM kategori_divisi WHERE id_cc = (select min(id_cc) FROM kategori_divisi WHERE id_cc > ".$id_cc.")");
	
	$q_cc = mysql_query("SELECT * FROM kategori_divisi WHERE id_cc = '".$id_cc."'");
	
}



?>