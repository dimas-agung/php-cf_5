<?php

//CLASS FORM AWAL
$class_form='class="active"';
$class_pane_form='class="tab-pane in active"';
$class_tab="";
$class_tab1="";
$class_tab2="";
$class_tab3="";
$class_pane_tab='class="tab-pane"';
$class_pane_tab1='class="tab-pane"';
$class_pane_tab2='class="tab-pane"';
$class_pane_tab3='class="tab-pane"';

//DDL

$q_ddl_salesman = mysql_query("SELECT * FROM karyawan WHERE kategori='salesman' AND aktif='1' ORDER BY nama ASC");
$q_ddl_kat_pel 	= mysql_query("SELECT * FROM kategori_pelanggan WHERE aktif='1' ORDER BY nama ASC");
$q_ddl_coa 		= mysql_query("SELECT * FROM coa WHERE level_coa='4' and aktif='1' ORDER BY kode_coa ASC "); 
$q_ddl_coa2 	= mysql_query("SELECT * FROM coa WHERE level_coa='4' and aktif='1' ORDER BY kode_coa ASC "); 


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
		$q_pel = mysql_query("SELECT * FROM pelanggan WHERE aktif='".$status."' ORDER BY id_pelanggan ASC"); 
	}else{
		$q_pel = mysql_query("SELECT * FROM pelanggan ORDER BY id_pelanggan ASC");
	}
}else{
		$q_pel = mysql_query("SELECT * FROM pelanggan ORDER BY id_pelanggan ASC"); 	
}

// Update ke database
if(isset($_GET['action']) and $_GET['action'] == "edit") {
	$id_pelanggan = mres($_GET['id_pelanggan']);
	$kode_kategori_pelanggan = mres($_GET['kode_kategori_pelanggan']);
	
	$q_edit_pel = mysql_query("SELECT * FROM pelanggan WHERE id_pelanggan = '".$id_pelanggan."'");
	
	if(isset($_POST['ppn'])){
			$ppn_stat='1';	
	}else{
			$ppn_stat='0';
	}
	
	if(isset($_POST['update'])) {
		//$_POST = array_map("strtoupper",$_POST);
		
		$kode_pelanggan=mres($_POST['kode_pelanggan']);
		$nama=mres($_POST['nama']);
		$kategori_pelanggan=mres($_POST['kategori_pelanggan']);
		$alamat=mres($_POST['alamat']);
		$kecamatan=mres($_POST['kecamatan']);
		$kota=mres($_POST['kota']);
		$propinsi=mres($_POST['propinsi']);
		$negara=mres($_POST['negara']);
		$kontak=mres($_POST['kontak']);
		$telpon=mres($_POST['telpon']);
		$hp=mres($_POST['hp']);
		$email=mres($_POST['email']);
		$ppn=$ppn_stat;
		$npwp=mres($_POST['npwp']);
		$ktp=mres($_POST['ktp']);
		$salesman=mres($_POST['salesman']);
		$keterangan=mres($_POST['keterangan']);
		
		$plafon_kredit=mres($_POST['plafon_kredit']);
		$jatuh_tempo=mres($_POST['jatuh_tempo']);
		$bank=mres($_POST['bank']);
		$bank_an=mres($_POST['bank_an']);
		$bank_no_rek=mres($_POST['bank_no_rek']);
		$nama_penagihan=mres($_POST['nama_penagihan']);
		$alamat_penagihan=mres($_POST['alamat_penagihan']);
		$kota_penagihan=mres($_POST['kota_penagihan']);
		
		$coa_debet=mres($_POST['coa_debet']);
		$coa_kredit=mres($_POST['coa_kredit']);	
		
		//Header 	
		$mySql	= "UPDATE pelanggan SET 
						kode_pelanggan		='".$kode_pelanggan."',
						nama				='".$nama."',
						kategori_pelanggan	='".$kategori_pelanggan."',
						alamat				='".$alamat."',
						kecamatan			='".$kecamatan."',
						kota				='".$kota."',
						propinsi			='".$propinsi."',
						negara				='".$negara."',
						kontak				='".$kontak."',
						telpon				='".$telpon."',
						hp					='".$hp."',
						email				='".$email."',
						PPn					='".$ppn."',
						npwp				='".$npwp."',
						ktp					='".$ktp."',
						salesman			='".$salesman."',
						keterangan			='".$keterangan."',
						
						plafon_kredit		='".$plafon_kredit."',
						jatuh_tempo			='".$jatuh_tempo."',
						bank				='".$bank."',
						bank_an				='".$bank_an."',
						bank_no_rek			='".$bank_no_rek."',
						nama_penagihan		='".$nama_penagihan."',
						alamat_penagihan	='".$alamat_penagihan."',
						kota_penagihan		='".$kota_penagihan."',
						
						coa_debet			='".$coa_debet."', 
						coa_kredit			='".$coa_kredit."'
						
						WHERE id_pelanggan	='".$id_pelanggan."' ";
						
		$query = mysql_query ($mySql) ;								
			
		if ($query) {
			$info = 'UPDATE DATA SUKSES';
			echo("<script>location.href = '".base_url()."?page=master/pelanggan&updatesukses&halaman= PELANGGAN';</script>");
		} else {
			//$response = "99||Update data gagal. ".mysql_error();
			$warning = "UPDATE DATA GAGAL"; 
		}
	}
}

// NON AKTIF DAN AKTIFKAN STATUS
if(isset($_GET['action']) and $_GET['action'] == "nonaktif") {
	$id_pelanggan = mres($_GET['id_pelanggan']);
	
		$sql = "UPDATE pelanggan SET aktif = '0' WHERE id_pelanggan = '".$id_pelanggan."'";
		$query = mysql_query ($sql) ;
		
		echo("<script>location.href = '".base_url()."?page=master/pelanggan&halaman= PELANGGAN';</script>");
	
}else if(isset($_GET['action']) and $_GET['action'] == "aktif"){
	$id_pelanggan = mres($_GET['id_pelanggan']);
	
		$sql = "UPDATE pelanggan SET aktif = '1' WHERE id_pelanggan = '".$id_pelanggan."'";
		$query = mysql_query ($sql) ;
		
		echo("<script>location.href = '".base_url()."?page=master/pelanggan&halaman= PELANGGAN';</script>");
}

// TRACK 
if(isset($_GET['action']) and $_GET['action'] == "track") {
	$id_pelanggan 			 = ($_GET['id_pelanggan']);
	$kode_kategori_pelanggan = ($_GET['kode_kategori_pelanggan']);

	$q_pel = mysql_query("SELECT * FROM pelanggan WHERE id_pelanggan = '".$id_pelanggan."'");
	
}



?>