<?php

//CLASS FORM AWAL
$class_form='class="active"';
$class_pane_form='class="tab-pane in active"';
$class_tab="";
$class_pane_tab='class="tab-pane"';

//dropdown coa persediaan
$q_coa_pers_aktif = mysql_query("SELECT kode_coa,nama FROM coa WHERE level_coa=4 AND kode_coa LIKE '1.01.05%' AND aktif='1'"); 

//ddl PILIHAN STOK
$q_pilihan_stok = mysql_query("SELECT * FROM ddl_pilihan_stok "); 


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
		$q_ki = mysql_query("SELECT ki.*, pil.nama jenis FROM kategori_inventori ki INNER JOIN ddl_pilihan_stok pil ON ki.pilihan_stok=pil.id_pilihan_stok WHERE ki.aktif='".$status."' ORDER BY kode_kategori_inventori ASC"); 
	}else{
		$q_ki = mysql_query("SELECT ki.*, pil.nama jenis FROM kategori_inventori ki INNER JOIN ddl_pilihan_stok pil ON ki.pilihan_stok=pil.id_pilihan_stok ORDER BY kode_kategori_inventori ASC");
	}
}else{
		$q_ki = mysql_query("SELECT ki.*, pil.nama jenis FROM kategori_inventori ki INNER JOIN ddl_pilihan_stok pil ON ki.pilihan_stok=pil.id_pilihan_stok ORDER BY kode_kategori_inventori ASC"); 	
}


// Simpan ke database
if(isset($_POST['simpan'])) {
	
	$_POST = array_map("strtoupper",$_POST);
	
	$kode_kat_inv=mres($_POST['kode_kategori_inv']);
	$nama=mres($_POST['nama']);
	$pilihan_stok=mres($_POST['pilihan_stok']);
	$keterangan=mres($_POST['keterangan']);
	
	$sql = "INSERT INTO kategori_inventori (kode_kategori_inventori,nama,pilihan_stok,keterangan) VALUES ('".$kode_kat_inv."','".$nama."','".$pilihan_stok."','".$keterangan."')";
	$query = mysql_query ($sql) ;
	
	if ($query) {
		//echo "<meta http-equiv='refresh' content='0; url=".base_url()."?module=setting/cabang' />";
		$info = 'SIMPAN DATA SUKSES';
		echo("<script>location.href = '".base_url()."?page=setting/kat_inv&inputsukses&halaman= KATEGORI BARANG';</script>");
		
	} else { 
		//$response = "99||Simpan data gagal. ".mysql_error(); 
		$warning = "SIMPAN DATA GAGAL"; 
	}
}

// Update ke database
if(isset($_GET['action']) and $_GET['action'] == "edit") {
	$id_kat_inv = mres($_GET['id_kategori_inventori']);
	
	$q_edit_ki = mysql_query("SELECT * FROM kategori_inventori WHERE id_kategori_inventori = '".$id_kat_inv."'");
	
	if(isset($_POST['update'])) {
		$_POST = array_map("strtoupper",$_POST);
		
		$nama=mres($_POST['nama']);
		$pilihan_stok=mres($_POST['pilihan_stok']);
		$keterangan=mres($_POST['keterangan']);		
			
		$sql = "UPDATE kategori_inventori SET pilihan_stok = '".$pilihan_stok."',nama = '".$nama."', keterangan = '".$keterangan."' WHERE id_kategori_inventori = '".$id_kat_inv."'";
		$query = mysql_query ($sql) ;
		
		if ($query) {
			//echo "<meta http-equiv='refresh' content='0; url=".base_url()."?page=karyawan' />";
			$info = 'UPDATE DATA SUKSES';
			echo("<script>location.href = '".base_url()."?page=setting/kat_inv&updatesukses&halaman= KATEGORI BARANG';</script>");
		} else {
			//$response = "99||Update data gagal. ".mysql_error();
			$warning = "UPDATE DATA GAGAL"; 
		}
	}
}

// NON AKTIF DAN AKTIFKAN STATUS
if(isset($_GET['action']) and $_GET['action'] == "nonaktif") {
	$id_kat_inv = mres($_GET['id_kategori_inventori']);
	
		$sql = "UPDATE kategori_inventori SET aktif = '0' WHERE id_kategori_inventori = '".$id_kat_inv."'";
		$query = mysql_query ($sql) ;
		
		echo("<script>location.href = '".base_url()."?page=setting/kat_inv&halaman= KATEGORI BARANG';</script>");
	
}else if(isset($_GET['action']) and $_GET['action'] == "aktif"){
	$id_kat_inv = mres($_GET['id_kategori_inventori']);
	
		$sql = "UPDATE kategori_inventori SET aktif = '1' WHERE id_kategori_inventori = '".$id_kat_inv."'";
		$query = mysql_query ($sql) ;
		
		echo("<script>location.href = '".base_url()."?page=setting/kat_inv&halaman= KATEGORI BARANG';</script>");
}

// TRACK 
if(isset($_GET['action']) and $_GET['action'] == "track") {
	$id_kat_inv = ($_GET['id_kategori_inventori']);
	
	$q_ki_prev = mysql_query("SELECT id_kategori_inventori FROM kategori_inventori WHERE id_kategori_inventori = (select max(id_kategori_inventori) FROM kategori_inventori WHERE id_kategori_inventori < ".$id_kat_inv.")");
	
	$q_ki_next = mysql_query("SELECT id_kategori_inventori FROM kategori_inventori WHERE id_kategori_inventori = (select min(id_kategori_inventori) FROM kategori_inventori WHERE id_kategori_inventori > ".$id_kat_inv.")");
	
	$q_ki = mysql_query("SELECT ki.*, pil.nama jenis FROM kategori_inventori ki INNER JOIN ddl_pilihan_stok pil on ki.pilihan_stok=pil.id_pilihan_stok WHERE id_kategori_inventori = '".$id_kat_inv."'");
	
}



?>