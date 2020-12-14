<?php

//CLASS FORM AWAL
$class_form='class="active"';
$class_pane_form='class="tab-pane in active"';
$class_tab="";
$class_tab1="";
$class_tab2="";
$class_pane_tab='class="tab-pane"';
$class_pane_tab1='class="tab-pane"';
$class_pane_tab2='class="tab-pane"';

//DDL

$q_ddl_valas = mysql_query("SELECT * FROM valas WHERE aktif='1' ORDER BY keterangan ASC");
$q_ddl_coa = mysql_query("SELECT * FROM coa WHERE level_coa='4' and aktif='1' ORDER BY kode_coa ASC ");
$q_ddl_coa2 = mysql_query("SELECT * FROM coa WHERE level_coa='4' and aktif='1' ORDER BY kode_coa ASC ");


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
		$q_supp = mysql_query("SELECT * FROM supplier WHERE aktif='".$status."' ORDER BY kode_supplier ASC");
	}else{
		$q_supp = mysql_query("SELECT * FROM supplier ORDER BY kode_supplier ASC");
	}
}else{
		$q_supp = mysql_query("SELECT * FROM supplier ORDER BY kode_supplier ASC");
}


// Simpan ke database
if(isset($_POST['simpan'])) {

	if(isset($_POST['ppn'])){
		$ppn_stat='1';
	}else{
		$ppn_stat='0';
	}

	$_POST = array_map("strtoupper",$_POST);

	$kode_supplier=mres($_POST['kode_supplier']);
	$nama=mres($_POST['nama']);
	$alamat=mres($_POST['alamat']);
	$kecamatan=mres($_POST['kecamatan']);
	$kota=mres($_POST['kota']);
	$propinsi=mres($_POST['provinsi']);
	$negara=mres($_POST['negara']);
	$kontak_person=mres($_POST['kontak_person']);
	$telpon=mres($_POST['telpon']);
	$hp=mres($_POST['hp']);
	$email=mres($_POST['email']);
	$ppn=$ppn_stat;
	$npwp=mres($_POST['npwp']);
	$keterangan=mres($_POST['keterangan']);

	$plafon=mres($_POST['plafon']);
	$top=mres($_POST['top']);
	$mata_uang=mres($_POST['mata_uang']);
	$bank=mres($_POST['nama_bank']);
	$cabang=mres($_POST['cabang']);
	$atas_nama=mres($_POST['atas_nama']);
	$no_rekening=mres($_POST['no_rekening']);

	$coa_debet=mres($_POST['coa_debet']);
	$coa_kredit=mres($_POST['coa_kredit']);

	$tgl_input=date("Y-m-d H:i:s");

	$sql = "INSERT INTO supplier (kode_supplier,nama,alamat,kecamatan,kota,propinsi,negara,kontak_person,telpon,HP,email,PPn,NPWP,tgl_input,keterangan,plafon_kredit,jatuh_tempo,mata_uang,nama_bank,cabang,atas_nama,no_rekening,coa_debet,coa_kredit) VALUES ('".$kode_supplier."','".$nama."','".$alamat."','".$kecamatan."','".$kota."','".$propinsi."','".$negara."','".$kontak_person."','".$telpon."','".$hp."','".$email."','".$ppn."','".$npwp."','".$tgl_input."','".$keterangan."','".$plafon."','".$top."','".$mata_uang."','".$bank."','".$cabang."','".$atas_nama."','".$no_rekening."','".$coa_debet."','".$coa_kredit."')";
	$query = mysql_query ($sql) ;

	if ($query) {
		//echo "<meta http-equiv='refresh' content='0; url=".base_url()."?module=setting/cabang' />";
		$info = 'SIMPAN DATA SUKSES';
		echo("<script>location.href = '".base_url()."?page=master/supplier&inputsukses';</script>");

	} else {
		//$response = "99||Simpan data gagal. ".mysql_error();
		$warning = "SIMPAN DATA GAGAL";
	}
}

// Update ke database
if(isset($_GET['action']) and $_GET['action'] == "edit") {
	$id_supplier = mres($_GET['id_supplier']);

	$q_edit_supp = mysql_query("SELECT * FROM supplier WHERE id_supplier = '".$id_supplier."'");

	if(isset($_POST['ppn'])){
		$ppn_stat='1';
	}else{
		$ppn_stat='0';
	}

	if(isset($_POST['update'])) {
		$_POST = array_map("strtoupper",$_POST);

		$nama=mres($_POST['nama']);
		$alamat=mres($_POST['alamat']);
		$kecamatan=mres($_POST['kecamatan']);
		$kota=mres($_POST['kota']);
		$propinsi=mres($_POST['provinsi']);
		$negara=mres($_POST['negara']);
		$kontak_person=mres($_POST['kontak_person']);
		$telpon=mres($_POST['telpon']);
		$hp=mres($_POST['hp']);
		$email=mres($_POST['email']);
		$ppn=$ppn_stat;
		$npwp=mres($_POST['npwp']);
		$keterangan=mres($_POST['keterangan']);

		$plafon=mres($_POST['plafon']);
		$top=mres($_POST['top']);
		$mata_uang=mres($_POST['mata_uang']);
		$bank=mres($_POST['nama_bank']);
		$cabang=mres($_POST['cabang']);
		$atas_nama=mres($_POST['atas_nama']);
		$no_rekening=mres($_POST['no_rekening']);

		$coa_debet=mres($_POST['coa_debet']);
		$coa_kredit=mres($_POST['coa_kredit']);

		$sql = "UPDATE supplier SET nama = '".$nama."', alamat = '".$alamat."', kecamatan = '".$kecamatan."', kota = '".$kota."',propinsi = '".$propinsi."',negara = '".$negara."',kontak_person = '".$kontak_person."',telpon = '".$telpon."',HP = '".$hp."',email = '".$email."',PPn = '".$ppn."',NPWP = '".$npwp."',keterangan = '".$keterangan."',plafon_kredit = '".$plafon."',jatuh_tempo = '".$top."',mata_uang = '".$mata_uang."', nama_bank = '".$bank."', cabang = '".$cabang."', atas_nama = '".$atas_nama."', no_rekening = '".$no_rekening."', coa_debet = '".$coa_debet."', coa_kredit = '".$coa_kredit."' WHERE id_supplier = '".$id_supplier."'";
		$query = mysql_query ($sql) ;

		if ($query) {
			//echo "<meta http-equiv='refresh' content='0; url=".base_url()."?page=karyawan' />";
			$info = 'UPDATE DATA SUKSES';
			echo("<script>location.href = '".base_url()."?page=master/supplier&updatesukses';</script>");
		} else {
			//$response = "99||Update data gagal. ".mysql_error();
			$warning = "UPDATE DATA GAGAL";
		}
	}
}

// NON AKTIF DAN AKTIFKAN STATUS
if(isset($_GET['action']) and $_GET['action'] == "nonaktif") {
	$id_supplier = mres($_GET['id_supplier']);

		$sql = "UPDATE supplier SET aktif = '0' WHERE id_supplier = '".$id_supplier."'";
		$query = mysql_query ($sql) ;

		echo("<script>location.href = '".base_url()."?page=master/supplier';</script>");

}else if(isset($_GET['action']) and $_GET['action'] == "aktif"){
	$id_supplier = mres($_GET['id_supplier']);

		$sql = "UPDATE supplier SET aktif = '1' WHERE id_supplier = '".$id_supplier."'";
		$query = mysql_query ($sql) ;

		echo("<script>location.href = '".base_url()."?page=master/supplier';</script>");
}

// TRACK
if(isset($_GET['action']) and $_GET['action'] == "track") {
	$id_supplier = ($_GET['id_supplier']);

	$q_supp_prev = mysql_query("SELECT id_supplier FROM supplier WHERE id_supplier = (select max(id_supplier) FROM supplier WHERE id_supplier < ".$id_supplier.")");

	$q_supp_next = mysql_query("SELECT id_supplier FROM supplier WHERE id_supplier = (select min(id_supplier) FROM supplier WHERE id_supplier > ".$id_supplier.")");

	$q_supp = mysql_query("SELECT supp.*,val.keterangan mat_uang,deb.nama coa_deb,kred.nama coa_kred FROM supplier supp
LEFT JOIN valas val ON val.kode_valas=supp.mata_uang
LEFT JOIN coa deb ON deb.kode_coa=supp.coa_debet
LEFT JOIN coa kred ON kred.kode_coa=supp.coa_kredit WHERE id_supplier = '".$id_supplier."'");

}
