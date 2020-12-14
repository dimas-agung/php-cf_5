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
		$q_cab = mysql_query("SELECT * FROM cabang WHERE aktif='".$status."'"); 
	}else{
		$q_cab = mysql_query("SELECT * FROM cabang");
	}
}else{
		$q_cab = mysql_query("SELECT * FROM cabang"); 	
}


// Simpan ke database
if(isset($_POST['simpan'])) {
	
	$_POST = array_map("strtoupper",$_POST);
	
	$kode_cabang=mres($_POST['kode_cabang']);
	$nama=mres($_POST['nama']);
	$alamat=mres($_POST['alamat']);
	$keterangan=mres($_POST['keterangan']);
	
	$sql = "INSERT INTO cabang (kode_cabang,nama,alamat,keterangan) VALUES ('".$kode_cabang."','".$nama."','".$alamat."','".$keterangan."')";
	$query = mysql_query ($sql) ;
	
	if ($query) {
		//echo "<meta http-equiv='refresh' content='0; url=".base_url()."?module=setting/cabang' />";
		$info = 'SIMPAN DATA SUKSES';
		echo("<script>location.href = '".base_url()."?page=setting/cabang&inputsukses&halaman= CABANG';</script>");
		
	} else { 
		//$response = "99||Simpan data gagal. ".mysql_error(); 
		$warning = "SIMPAN DATA GAGAL"; 
	}
}

// Update ke database
if(isset($_GET['action']) and $_GET['action'] == "edit") {
	$id_cabang = mres($_GET['id_cabang']);
	
	$q_edit_cab = mysql_query("SELECT * FROM cabang WHERE id_cabang = '".$id_cabang."'");
	
	if(isset($_POST['update'])) {
		$_POST = array_map("strtoupper",$_POST);
		
		$nama=mres($_POST['nama']);
		$alamat=mres($_POST['alamat']);
		$keterangan=mres($_POST['keterangan']);		
			
		$sql = "UPDATE cabang SET nama = '".$nama."', alamat = '".$alamat."', keterangan = '".$keterangan."' WHERE id_cabang = '".$id_cabang."'";
		$query = mysql_query ($sql) ;
		
		if ($query) {
			//echo "<meta http-equiv='refresh' content='0; url=".base_url()."?page=karyawan' />";
			$info = 'UPDATE DATA SUKSES';
			echo("<script>location.href = '".base_url()."?page=setting/cabang&updatesukses&halaman= CABANG';</script>");
		} else {
			//$response = "99||Update data gagal. ".mysql_error();
			$warning = "UPDATE DATA GAGAL"; 
		}
	}
}

// NON AKTIF DAN AKTIFKAN STATUS
if(isset($_GET['action']) and $_GET['action'] == "nonaktif") {
	$id_cabang = mres($_GET['id_cabang']);
	
		$sql = "UPDATE cabang SET aktif = '0' WHERE id_cabang = '".$id_cabang."'";
		$query = mysql_query ($sql) ;
		
		echo("<script>location.href = '".base_url()."?page=setting/cabang&halaman= CABANG';</script>");
	
}else if(isset($_GET['action']) and $_GET['action'] == "aktif"){
	$id_cabang = mres($_GET['id_cabang']);
	
		$sql = "UPDATE cabang SET aktif = '1' WHERE id_cabang = '".$id_cabang."'";
		$query = mysql_query ($sql) ;
		
		echo("<script>location.href = '".base_url()."?page=setting/cabang&halaman= CABANG';</script>");
}

// TRACK 
if(isset($_GET['action']) and $_GET['action'] == "track") {
	$id_cabang = ($_GET['id_cabang']);
	
	$q_cab_prev = mysql_query("SELECT id_cabang FROM cabang WHERE id_cabang = (select max(id_cabang) FROM cabang WHERE id_cabang < ".$id_cabang.")");
	
	$q_cab_next = mysql_query("SELECT id_cabang FROM cabang WHERE id_cabang = (select min(id_cabang) FROM cabang WHERE id_cabang > ".$id_cabang.")");
	
	$q_cab = mysql_query("SELECT * FROM cabang WHERE id_cabang = '".$id_cabang."'");
	
}



?>