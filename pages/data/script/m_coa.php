<?php

//CLASS FORM AWAL
$class_form='class="active"';
$class_pane_form='class="tab-pane in active"';
$class_tab="";
$class_pane_tab='class="tab-pane"';

//cabang aktif
$q_coa_aktif = mysql_query("SELECT * FROM coa WHERE aktif='1'"); 

//dropdwon kategori coa
$q_ddl_katcoa = mysql_query("SELECT * FROM kategori_coa WHERE aktif='1' ORDER BY nama ASC"); 

//dropdwon valas
$q_ddl_valas = mysql_query("SELECT * FROM valas WHERE aktif='1' ORDER BY kode_valas ASC"); 

//dropdwon kategori cashflow
$q_ddl_cf = mysql_query("SELECT * FROM kategori_cashflow WHERE aktif='1' ORDER BY nama ASC"); 


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
		$q_coa = mysql_query("SELECT coa.*, kat_coa.nama kategori_coa, val.keterangan nama_mata_uang, cf.nama cashflow FROM coa 
LEFT JOIN kategori_coa kat_coa ON kat_coa.kode_kat_coa=coa.kategori 
LEFT JOIN valas val ON val.kode_valas=coa.mata_uang
LEFT JOIN kategori_cashflow cf ON cf.kode_kat_cashflow=coa.kategori_cf
WHERE coa.aktif='".$status."' ORDER BY kode_coa ASC"); 
	}else{
		$q_coa = mysql_query("SELECT coa.*, kat_coa.nama kategori_coa, val.keterangan nama_mata_uang, cf.nama cashflow FROM coa 
LEFT JOIN kategori_coa kat_coa ON kat_coa.kode_kat_coa=coa.kategori 
LEFT JOIN valas val ON val.kode_valas=coa.mata_uang
LEFT JOIN kategori_cashflow cf ON cf.kode_kat_cashflow=coa.kategori_cf
ORDER BY kode_coa ASC");
	}
}else{
		$q_coa = mysql_query("SELECT coa.*, kat_coa.nama kategori_coa, val.keterangan nama_mata_uang, cf.nama cashflow FROM coa 
LEFT JOIN kategori_coa kat_coa ON kat_coa.kode_kat_coa=coa.kategori 
LEFT JOIN valas val ON val.kode_valas=coa.mata_uang
LEFT JOIN kategori_cashflow cf ON cf.kode_kat_cashflow=coa.kategori_cf
ORDER BY kode_coa ASC"); 	
}


// Simpan ke database
if(isset($_POST['simpan'])) {
	
	$_POST = array_map("strtoupper",$_POST);
	
	$kode_coa=mres($_POST['kode_coa']);
	$level_coa=mres($_POST['level_coa']);
	$nama=mres($_POST['nama']);
	//$keterangan=mres($_POST['keterangan']);
	$kategori=mres($_POST['kategori']);
	$mata_uang=mres($_POST['mata_uang']);
	$kategori_cf=mres($_POST['kategori_cf']);
	$dk=mres($_POST['dk']);
	
	$sql = "INSERT INTO coa (kode_coa,level_coa,nama,kategori,mata_uang,kategori_cf,dk) VALUES ('".$kode_coa."','".$level_coa."','".$nama."','".$kategori."','".$mata_uang."','".$kategori_cf."','".$dk."')";
	$query = mysql_query ($sql) ;
	
	if ($query) {
		//echo "<meta http-equiv='refresh' content='0; url=".base_url()."?module=setting/cabang' />";
		$info = 'SIMPAN DATA SUKSES';
		echo("<script>location.href = '".base_url()."?page=master/coa&inputsukses&halaman= COA';</script>");
		
	} else { 
		//$response = "99||Simpan data gagal. ".mysql_error(); 
		$warning = "SIMPAN DATA GAGAL"; 
	}
}

// Update ke database
if(isset($_GET['action']) and $_GET['action'] == "edit") {
	$id_coa = mres($_GET['id_coa']);
	
	$q_edit_coa = mysql_query("SELECT * FROM coa WHERE id_coa = '".$id_coa."'");
	
	if(isset($_POST['update'])) {
		$_POST = array_map("strtoupper",$_POST);
		
		$level_coa=mres($_POST['level_coa']);
		$nama=mres($_POST['nama']);
		//$keterangan=mres($_POST['keterangan']);		
		$kategori=mres($_POST['kategori']);
		$mata_uang=mres($_POST['mata_uang']);
		$kategori_cf=mres($_POST['kategori_cf']);
		$dk=mres($_POST['dk']);
			
		$sql = "UPDATE coa SET level_coa = '".$level_coa."',nama = '".$nama."', kategori = '".$kategori."', mata_uang = '".$mata_uang."', kategori_cf = '".$kategori_cf."', dk = '".$dk."' WHERE id_coa = '".$id_coa."'";
		$query = mysql_query ($sql) ;
		
		if ($query) {
			//echo "<meta http-equiv='refresh' content='0; url=".base_url()."?page=karyawan' />";
			$info = 'UPDATE DATA SUKSES';
			echo("<script>location.href = '".base_url()."?page=master/coa&updatesukses&halaman= COA';</script>");
		} else {
			//$response = "99||Update data gagal. ".mysql_error();
			$warning = "UPDATE DATA GAGAL"; 
		}
	}
}

// NON AKTIF DAN AKTIFKAN STATUS
if(isset($_GET['action']) and $_GET['action'] == "nonaktif") {
	$id_coa = mres($_GET['id_coa']);
	
		$sql = "UPDATE coa SET aktif = '0' WHERE id_coa = '".$id_coa."'";
		$query = mysql_query ($sql) ;
		
		echo("<script>location.href = '".base_url()."?page=master/coa&halaman= COA';</script>");
	
}else if(isset($_GET['action']) and $_GET['action'] == "aktif"){
	$id_coa = mres($_GET['id_coa']);
	
		$sql = "UPDATE coa SET aktif = '1' WHERE id_coa = '".$id_coa."'";
		$query = mysql_query ($sql) ;
		
		echo("<script>location.href = '".base_url()."?page=master/coa&halaman= COA';</script>");
}

// TRACK 
if(isset($_GET['action']) and $_GET['action'] == "track") {
	$id_coa = ($_GET['id_coa']);
	
	$q_coa_prev = mysql_query("SELECT id_coa FROM coa WHERE id_coa = (select max(id_coa) FROM coa WHERE id_coa < ".$id_coa.")");
	
	$q_coa_next = mysql_query("SELECT id_coa FROM coa WHERE id_coa = (select min(id_coa) FROM coa WHERE id_coa > ".$id_coa.")");
	
	$q_coa = mysql_query("SELECT coa.*, kat_coa.nama kategori_coa, val.keterangan nama_mata_uang, cf.nama cashflow FROM coa 
							LEFT JOIN kategori_coa kat_coa ON kat_coa.kode_kat_coa=coa.kategori 
							LEFT JOIN valas val ON val.kode_valas=coa.mata_uang
							LEFT JOIN kategori_cashflow cf ON cf.kode_kat_cashflow=coa.kategori_cf WHERE id_coa = '".$id_coa."'");
	
}



?>