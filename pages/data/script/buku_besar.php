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
$q_gdg =  mysql_query("select kode_gudang,nama from gudang where aktif='1' order by id_gudang");
$q_cab =  mysql_query("select kode_cabang,nama from cabang where aktif='1' order by id_cabang");
$q_rekawal = mysql_query("SELECT kode_coa, nama nama_coa FROM coa WHERE aktif = '1' AND level_coa = '4' ORDER BY kode_coa ASC");
$q_rekakhir = mysql_query("SELECT kode_coa, nama nama_coa FROM coa WHERE aktif = '1' AND level_coa = '4' ORDER BY kode_coa ASC");


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
?>