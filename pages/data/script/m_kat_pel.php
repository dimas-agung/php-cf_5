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
		$q_kp = mysql_query("SELECT * FROM kategori_pelanggan WHERE aktif='".$status."'"); 
	}else{
		$q_kp = mysql_query("SELECT * FROM kategori_pelanggan");
	}
}else{
		$q_kp = mysql_query("SELECT * FROM kategori_pelanggan"); 	
}


// Simpan ke database
if(isset($_POST['simpan'])) {
	
	$_POST = array_map("strtoupper",$_POST);
	
	$kode_kategori_pelanggan=mres($_POST['kode_kategori_pelanggan']);
	$nama=mres($_POST['nama']);
	$keterangan=mres($_POST['keterangan']);
	
	$sql = "INSERT INTO kategori_pelanggan (kode_kategori_pelanggan,nama,keterangan) VALUES ('".$kode_kategori_pelanggan."','".$nama."','".$keterangan."')";
	$query = mysql_query ($sql) ;
	
	if ($query) {
		//echo "<meta http-equiv='refresh' content='0; url=".base_url()."?module=setting/cabang' />";
		$info = 'SIMPAN DATA SUKSES';
		echo("<script>location.href = '".base_url()."?page=setting/kat_pel&inputsukses&halaman= KATEGORI PELANGGAN';</script>");
		
	} else { 
		//$response = "99||Simpan data gagal. ".mysql_error(); 
		$warning = "SIMPAN DATA GAGAL"; 
	}
}

// Update ke database
if(isset($_GET['action']) and $_GET['action'] == "edit") {
	$id_kategori_pelanggan = mres($_GET['id_kategori_pelanggan']);
	
	$q_edit_kp = mysql_query("SELECT * FROM kategori_pelanggan WHERE id_kategori_pelanggan = '".$id_kategori_pelanggan."'");
	
	if(isset($_POST['update'])) {
		$_POST = array_map("strtoupper",$_POST);
		
		$nama=mres($_POST['nama']);
		$keterangan=mres($_POST['keterangan']);		
			
		$sql = "UPDATE kategori_pelanggan SET nama = '".$nama."', keterangan = '".$keterangan."' WHERE id_kategori_pelanggan = '".$id_kategori_pelanggan."'";
		$query = mysql_query ($sql) ;
		
		if ($query) {
			//echo "<meta http-equiv='refresh' content='0; url=".base_url()."?page=karyawan' />";
			$info = 'UPDATE DATA SUKSES';
			echo("<script>location.href = '".base_url()."?page=setting/kat_pel&updatesukses&halaman= KATEGORI PELANGGAN';</script>");
		} else {
			//$response = "99||Update data gagal. ".mysql_error();
			$warning = "UPDATE DATA GAGAL"; 
		}
	}
}

// NON AKTIF DAN AKTIFKAN STATUS
if(isset($_GET['action']) and $_GET['action'] == "nonaktif") {
	$id_kategori_pelanggan = mres($_GET['id_kategori_pelanggan']);
	
		$sql = "UPDATE kategori_pelanggan SET aktif = '0' WHERE id_kategori_pelanggan = '".$id_kategori_pelanggan."'";
		$query = mysql_query ($sql) ;
		
		echo("<script>location.href = '".base_url()."?page=setting/kat_pel&halaman= KATEGORI PELANGGAN';</script>");
	
}else if(isset($_GET['action']) and $_GET['action'] == "aktif"){
	$id_kategori_pelanggan = mres($_GET['id_kategori_pelanggan']);
	
		$sql = "UPDATE kategori_pelanggan SET aktif = '1' WHERE id_kategori_pelanggan = '".$id_kategori_pelanggan."'";
		$query = mysql_query ($sql) ;
		
		echo("<script>location.href = '".base_url()."?page=setting/kat_pel&halaman= KATEGORI PELANGGAN';</script>");
}

// TRACK 
if(isset($_GET['action']) and $_GET['action'] == "track") {
	$id_kategori_pelanggan = ($_GET['id_kategori_pelanggan']);
	
	$q_kp_prev = mysql_query("SELECT id_kategori_pelanggan FROM kategori_pelanggan WHERE id_kategori_pelanggan = (select max(id_kategori_pelanggan) FROM kategori_pelanggan WHERE id_kategori_pelanggan < ".$id_kategori_pelanggan.")");
	
	$q_kp_next = mysql_query("SELECT id_kategori_pelanggan FROM kategori_pelanggan WHERE id_kategori_pelanggan = (select min(id_kategori_pelanggan) FROM kategori_pelanggan WHERE id_kategori_pelanggan > ".$id_kategori_pelanggan.")");
	
	$q_kp = mysql_query("SELECT * FROM kategori_pelanggan WHERE id_kategori_pelanggan = '".$id_kategori_pelanggan."'");
	
}



?>