<?php

//CLASS FORM AWAL
$class_form='class="active"';
$class_pane_form='class="tab-pane fade in active"';
$class_tab="";
$class_pane_tab='class="tab-pane fade"';


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
		$q_valas = mysql_query("SELECT * FROM valas WHERE aktif='".$status."'"); 
	}else{
		$q_valas = mysql_query("SELECT * FROM valas");
	}
}else{
		$q_valas = mysql_query("SELECT * FROM valas"); 	
}


// Simpan ke database
if(isset($_POST['simpan'])) {
	
	$_POST = array_map("strtoupper",$_POST);
	
	$kode_valas=mres($_POST['kode_valas']);
	$keterangan=mres($_POST['keterangan']);
	
	$sql = "INSERT INTO valas (kode_valas,keterangan) VALUES ('".$kode_valas."','".$keterangan."')";
	$query = mysql_query ($sql) ;
	
	if ($query) {
		//echo "<meta http-equiv='refresh' content='0; url=".base_url()."?module=setting/cabang' />";
		$info = 'SIMPAN DATA SUKSES';
		echo("<script>location.href = '".base_url()."?page=master/valas&inputsukses&halaman= VALAS';</script>");
		
	} else { 
		//$response = "99||Simpan data gagal. ".mysql_error(); 
		$warning = "SIMPAN DATA GAGAL"; 
	}
}

// Update ke database
if(isset($_GET['action']) and $_GET['action'] == "edit") {
	$id_valas = mres($_GET['id_valas']);
	
	$q_edit_valas = mysql_query("SELECT * FROM valas WHERE id_valas = '".$id_valas."'");
	
	if(isset($_POST['update'])) {
		$_POST = array_map("strtoupper",$_POST);
		
		$keterangan=mres($_POST['keterangan']);
	
		$sql = "UPDATE valas SET keterangan = '".$keterangan."' WHERE id_valas = '".$id_valas."'";
		$query = mysql_query ($sql) ;
		
		if ($query) {
			//echo "<meta http-equiv='refresh' content='0; url=".base_url()."?page=karyawan' />";
			$info = 'UPDATE DATA SUKSES';
			echo("<script>location.href = '".base_url()."?page=master/valas&updatesukses&halaman= VALAS';</script>");
		} else {
			//$response = "99||Update data gagal. ".mysql_error();
			$warning = "UPDATE DATA GAGAL"; 
		}
	}
}

// NON AKTIF DAN AKTIFKAN STATUS
if(isset($_GET['action']) and $_GET['action'] == "nonaktif") {
	$id_valas = mres($_GET['id_valas']);
	
		$sql = "UPDATE valas SET aktif = '0' WHERE id_valas = '".$id_valas."'";
		$query = mysql_query ($sql) ;
		
		echo("<script>location.href = '".base_url()."?page=master/valas&halaman= VALAS';</script>");
	
}else if(isset($_GET['action']) and $_GET['action'] == "aktif"){
	$id_valas = mres($_GET['id_valas']);
	
		$sql = "UPDATE valas SET aktif = '1' WHERE id_valas = '".$id_valas."'";
		$query = mysql_query ($sql) ;
		
		echo("<script>location.href = '".base_url()."?page=master/valas&halaman= VALAS';</script>");
}

// TRACK 
if(isset($_GET['action']) and $_GET['action'] == "track") {
	$id_valas = ($_GET['id_valas']);
	
	$q_valas_prev = mysql_query("SELECT id_valas FROM valas WHERE id_valas = (select max(id_valas) FROM valas WHERE id_valas < ".$id_valas.")");
	
	$q_valas_next = mysql_query("SELECT id_valas FROM valas WHERE id_valas = (select min(id_valas) FROM valas WHERE id_valas > ".$id_valas.")");
	
	$q_valas = mysql_query("SELECT * FROM valas WHERE id_valas = '".$id_valas."'");
	
}



?>