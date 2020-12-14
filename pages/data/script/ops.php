<?php

$q_close 	= mysql_query("SELECT DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%m') AS `month`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y') AS `year`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y-%m') AS `fulltext` FROM `close`");
$q_cab_aktif 	= mysql_query("SELECT kode_cabang, nama FROM cabang WHERE aktif='1' ORDER BY kode_cabang ASC");
$q_gud_aktif 	= mysql_query("SELECT kode_gudang, nama FROM gudang WHERE aktif='1' ORDER BY kode_gudang ASC");
$q_sup_aktif 	= mysql_query("SELECT kode_supplier, nama, jatuh_tempo top FROM supplier WHERE aktif='1' ORDER BY kode_supplier ASC");
$q_aset 		= mysql_query("SELECT kode_kat_aset, keterangan nama FROM kategori_aset WHERE aktif='1' ORDER BY kode_kat_aset ASC");
$q_ddl_divisi   = mysql_query("SELECT kode_cc, nama FROM kategori_divisi WHERE aktif='1' ORDER BY kode_cc ASC");

//LIST
$q_ops = mysql_query("SELECT * FROM ops_hdr ORDER BY id_ops_hdr ASC");


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

// TRACK
if(isset($_GET['action']) and $_GET['action'] == "track") {
	$kode_ops = ($_GET['kode_ops']);

	$id_ops_hdr = mysql_query("SELECT id_ops_hdr FROM ops_hdr WHERE kode_ops = '".$kode_ops."'");
	$id = mysql_fetch_array($id_ops_hdr);

	$q_ops_prev = mysql_query("SELECT id_ops_hdr,kode_ops FROM ops_hdr WHERE id_ops_hdr = (select max(id_ops_hdr) FROM ops_hdr WHERE id_ops_hdr < ".$id['id_ops_hdr'].")");

	$q_ops_next = mysql_query("SELECT id_ops_hdr,kode_ops FROM ops_hdr WHERE id_ops_hdr = (select min(id_ops_hdr) FROM ops_hdr WHERE id_ops_hdr > ".$id['id_ops_hdr'].")");

	$ops_um = mysql_query("SELECT termin, persen FROM ops_um WHERE kode_ops = '".$kode_ops."'");

	$q_ops_hdr = mysql_query("SELECT oh.kode_ops, oh.kode_supplier, s.nama AS nama_supplier, oh.ref, oh.tgl_buat, oh.kode_cabang, c.nama AS nama_cabang, oh.keterangan_hdr, oh.top FROM ops_hdr oh
								LEFT JOIN cabang c ON c.kode_cabang = oh.kode_cabang
								LEFT JOIN supplier s ON s.kode_supplier = oh.kode_supplier
								WHERE oh.kode_ops = '".$kode_ops."' ");

	$q_ops_dtl = mysql_query("SELECT * FROM ops_dtl WHERE kode_ops = '".$kode_ops."'");

}


?>
