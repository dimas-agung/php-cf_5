<?php

$q_close 	= mysql_query("SELECT DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%m') AS `month`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y') AS `year`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y-%m') AS `fulltext` FROM `close`");

//CLASS FORM AWAL
$class_form='class="active"';
$class_pane_form='class="tab-pane in active"';
$class_tab="";
$class_pane_tab='class="tab-pane"';

$q_cab_aktif = mysql_query("SELECT kode_cabang, nama nama_cabang FROM cabang WHERE aktif = '1' ORDER BY id_cabang ASC");

$q_pel_aktif = mysql_query("SELECT kode_pelanggan, nama nama_pelanggan FROM pelanggan WHERE aktif = '1' ORDER BY id_pelanggan ASC");

$q_sup_aktif = mysql_query("SELECT kode_supplier, nama nama_supplier FROM supplier WHERE aktif = '1' ORDER BY id_supplier ASC");

$q_coa = mysql_query("SELECT kode_coa, nama nama_coa FROM coa  WHERE level_coa = '4' AND aktif='1' AND LEFT(kode_coa, 5) <> '11010' AND LEFT(kode_coa, 7) <> '1.01.01' AND LEFT(kode_coa, 7) <> '1.01.02' ORDER BY kode_coa ASC");

$q_nb = mysql_query("SELECT kode_nb, ref, tgl_buat, c.nama nama_cabang, nama_user FROM nb_hdr nh
INNER JOIN cabang c ON c.kode_cabang = nh.kode_cabang
ORDER BY kode_nb ASC");

// TRACK
if(isset($_GET['action']) and $_GET['action'] == "track") {

	$kode_nb = ($_GET['kode_nb']);

	$q_nb_hdr = mysql_query("SELECT nb.*, c.nama nama_cabang FROM nb_hdr nb LEFT JOIN cabang c ON c.kode_cabang = nb.kode_cabang
							WHERE kode_nb = '".$kode_nb."' ");

	$q_nb_dtl = mysql_query("SELECT * FROM nb_dtl WHERE kode_nb ='".$kode_nb."' ORDER BY id_nb_dtl ASC");

}

?>
