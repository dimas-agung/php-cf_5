<?php

$q_close 	= mysql_query("SELECT DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%m') AS `month`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y') AS `year`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y-%m') AS `fulltext` FROM `close`");
$q_cab_aktif 	= mysql_query("SELECT kode_cabang,nama FROM cabang WHERE aktif='1'");
$q_gud_aktif 	= mysql_query("SELECT kode_gudang,nama FROM gudang WHERE aktif='1'");
$q_sup_aktif 	= mysql_query("SELECT kode_supplier,nama,jatuh_tempo top FROM supplier WHERE aktif='1'");
$q_inv_aktif 	= mysql_query("SELECT kode_inventori,nama FROM inventori WHERE aktif='1' AND (kategori='ID' OR kategori='MT') ORDER BY kode_inventori ASC");
$q_ddl_divisi 	= mysql_query("SELECT kode_cc,nama FROM kategori_divisi WHERE aktif='1'");

//LIST
$q_op = mysql_query("SELECT * FROM op_hdr LEFT JOIN supplier ON supplier.kode_supplier = op_hdr.kode_supplier ORDER BY id_op_hdr ASC");

// UBAH PENCARIAN BERDASAR STATUS DI DATABASE
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

if(isset($_GET['action']) and $_GET['action'] == "copy") {
	$kode_op = mres($_GET['kode_op']);

	$q_copy_op_hdr = mysql_query("SELECT * FROM op_hdr WHERE kode_op = '".$kode_op."'");

	$q_copy_op_dtl = mysql_query("SELECT * FROM op_dtl WHERE kode_op = '".$kode_op."'");
}


// TRACK
if(isset($_GET['action']) and $_GET['action'] == "track") {
	$kode_op = ($_GET['kode_op']);

	$id_op_hdr 	= mysql_query("SELECT id_op_hdr FROM op_hdr WHERE kode_op = '".$kode_op."'");
	$id 		= mysql_fetch_array($id_op_hdr);

	$q_op_prev 	= mysql_query("SELECT id_op_hdr,kode_op FROM op_hdr WHERE id_op_hdr = (select max(id_op_hdr) FROM op_hdr WHERE id_op_hdr < ".$id['id_op_hdr'].")");

	$q_op_next 	= mysql_query("SELECT id_op_hdr,kode_op FROM op_hdr WHERE id_op_hdr = (select min(id_op_hdr) FROM op_hdr WHERE id_op_hdr > ".$id['id_op_hdr'].")");

	$status = mysql_query("SELECT kode_op, status from op_hdr WHERE kode_op = '".$kode_op."' ");

	$op_um 		= mysql_query("SELECT termin, persen FROM op_um WHERE kode_op = '".$kode_op."'");

	$q_op_hdr 	= mysql_query("SELECT oh.kode_op, oh.kode_supplier, s.nama AS nama_supplier, oh.ref, oh.tgl_buat, oh.kode_cabang, c.nama AS nama_cabang, oh.keterangan_hdr, jatuh_tempo top, oh.status FROM op_hdr oh
								LEFT JOIN cabang c ON c.kode_cabang = oh.kode_cabang
								LEFT JOIN supplier s ON s.kode_supplier = oh.kode_supplier
								WHERE oh.kode_op = '".$kode_op."' ");

	$q_op_dtl 	= mysql_query("SELECT * FROM op_dtl WHERE kode_op = '".$kode_op."'");

	$q_op_copy 	= mysql_query("SELECT id_form, kode_op FROM op_hdr WHERE kode_op = '".$kode_op."'");

}


?>
