<?php

$q_close 	= mysql_query("SELECT DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%m') AS `month`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y') AS `year`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y-%m') AS `fulltext` FROM `close`");

//CLASS FORM AWAL
$class_form='class="active"';
$class_pane_form='class="tab-pane in active"';
$class_tab="";
$class_pane_tab='class="tab-pane"';

//LIST PM
$q_pm = mysql_query("SELECT `pm_hdr`.`kode_pm`, `pm_hdr`.`tgl_buat`, `pm_hdr`.`ref`, `cabang`.`nama` AS `nama_cabang`, CONCAT(`gudang`.`nama`, ' - ', `gudang`.`keterangan`) AS `nama_gudang_asal`, `pm_hdr`.`keterangan_hdr`, `pm_hdr`.`status_hdr` FROM `pm_hdr` LEFT JOIN `cabang` ON `pm_hdr`.`kode_cabang` = `cabang`.`kode_cabang` LEFT JOIN `gudang` ON `pm_hdr`.`kode_gudang_asal` = `gudang`.`kode_gudang`");

if(isset($_GET['action']) and $_GET['action'] == "spk_to_pm") {
	$kode_spk = ($_GET['kode_spk']);
	
	$spk_hdr = mysql_query("SELECT `spk_hdr`.`kode_spk`, `spk_hdr`.`ref`, `cabang`.`kode_cabang`, `cabang`.`nama` AS `nama_cabang`, `spk_hdr`.`keterangan_hdr`, `spk_hdr`.`status_hdr` FROM `spk_hdr` LEFT JOIN `cabang` ON `spk_hdr`.`kode_cabang` = `cabang`.`kode_cabang` WHERE `spk_hdr`.`kode_spk` = '".$kode_spk."' AND `spk_hdr`.`status_hdr` = 'open'");
	
	$spk_hdr_f = ((mysql_num_rows($spk_hdr) > 0) ? mysql_fetch_array($spk_hdr) : null);
	
	$spk_dtl = mysql_query("SELECT `spk_hdr`.`kode_spk`, `inventori`.`kode_inventori`, `inventori`.`nama` AS `nama_barang`, `spk_dtl`.`kode_satuan`, `spk_dtl`.`kebutuhan` AS `qty`, IFNULL(SUM(`pm_dtl`.`qty`), 0) AS `qty_pm`, IFNULL(SUM(`pm_dtl`.`qty_pm_batal`), 0) AS `qty_pm_batal`, `spk_dtl`.`keterangan_dtl`, `spk_hdr`.`status_hdr`, `spk_dtl`.`status_dtl` FROM `spk_dtl` LEFT JOIN `spk_hdr` ON `spk_dtl`.`kode_spk` = `spk_hdr`.`kode_spk` LEFT JOIN `pm_hdr` ON `pm_hdr`.`kode_spk` = `pm_hdr`.`kode_spk` LEFT JOIN `pm_dtl` ON `pm_dtl`.`kode_pm` = `pm_hdr`.`kode_pm` AND `spk_dtl`.`kode_item_bom` = `pm_dtl`.`kode_inventori` LEFT JOIN `cabang` ON `spk_hdr`.`kode_cabang` = `cabang`.`kode_cabang` LEFT JOIN `inventori` ON `spk_dtl`.`kode_item_bom` = `inventori`.`kode_inventori` WHERE `spk_hdr`.`kode_spk` = '".(count($spk_hdr_f) > 0 ? $spk_hdr_f['kode_spk'] : null)."' AND `spk_hdr`.`status_hdr` = 'open' AND `spk_dtl`.`status_dtl` = 'open' GROUP BY `spk_dtl`.`kode_item_bom` ORDER BY `spk_dtl`.`id_spk_dtl` ASC");
	
	//DROPDOWN CABANG
	$q_cabang = mysql_query("SELECT `kode_cabang`, `nama` AS `nama_cabang` FROM `cabang` WHERE `kode_cabang` = '".(count($spk_hdr_f) > 0 ? $spk_hdr_f['kode_cabang'] : null)."' AND `aktif` = '1' ORDER BY `kode_cabang` ASC");

	//DROPDOWN GUDANG A
	$q_gudang_a = mysql_query("SELECT `kode_gudang`, CONCAT(`nama`, ' ', `keterangan`) AS `nama_gudang` FROM `gudang` WHERE `aktif` = '1' AND `is_produksi` = 'no' ORDER BY `kode_gudang` ASC");

	//DROPDOWN GUDANG B
	$q_gudang_b = mysql_query("SELECT `kode_gudang`, CONCAT(`nama`, ' ', `keterangan`) AS `nama_gudang` FROM `gudang` WHERE `aktif` = '1' AND `is_produksi` = 'yes' ORDER BY `kode_gudang` ASC");
}

// TRACK
if(isset($_GET['action']) and $_GET['action'] == "track") {

	$kode_pm = ($_GET['kode_pm']);

	$id_pm_hdr = mysql_query("SELECT `id_pm_hdr` FROM `pm_hdr` WHERE `kode_pm` = '".$kode_pm."'");
	$id 	   = mysql_fetch_array($id_pm_hdr);

	$q_pm_prev = mysql_query("SELECT `id_pm_hdr`, `kode_pm` FROM `pm_hdr` WHERE `id_pm_hdr` = (SELECT MAX(`id_pm_hdr`) FROM `pm_hdr` WHERE `id_pm_hdr` < '".$id['id_pm_hdr']."')");
	
	$q_pm_next = mysql_query("SELECT `id_pm_hdr`, `kode_pm` FROM `pm_hdr` WHERE `id_pm_hdr` = (SELECT MIN(`id_pm_hdr`) FROM `pm_hdr` WHERE `id_pm_hdr` > '".$id['id_pm_hdr']."')");

	$status = mysql_query("SELECT `kode_pm`, `status_hdr` FROM `pm_hdr` WHERE `kode_pm` = '".$kode_pm."' ");

	$q_pm_hdr = mysql_query("SELECT `pm_hdr`.`kode_pm`, `pm_hdr`.`kode_spk`, `pm_hdr`.`tgl_buat`, `pm_hdr`.`ref`, `cabang`.`nama` AS `nama_cabang`, CONCAT(`gudang_a`.`nama`, ' - ', `gudang_a`.`keterangan`) AS `nama_gudang_asal`, CONCAT(`gudang_b`.`nama`, ' - ', `gudang_b`.`keterangan`) AS `nama_gudang_tujuan`, `pm_hdr`.`keterangan_hdr`, `pm_hdr`.`status_hdr` FROM `pm_hdr` LEFT JOIN `cabang` ON `pm_hdr`.`kode_cabang` = `cabang`.`kode_cabang` LEFT JOIN `gudang` AS `gudang_a` ON `pm_hdr`.`kode_gudang_asal` = `gudang_a`.`kode_gudang` LEFT JOIN `gudang` AS `gudang_b` ON `pm_hdr`.`kode_gudang_tujuan` = `gudang_b`.`kode_gudang` WHERE `pm_hdr`.`kode_pm` = '".$kode_pm."'");

	$q_pm_dtl = mysql_query("SELECT `inventori`.`kode_inventori`, `inventori`.`nama` AS `nama_barang`, `pm_dtl`.`qty`, `pm_dtl`.`kode_satuan`, `pm_dtl`.`keterangan_dtl`, `pm_dtl`.`status_dtl` FROM `pm_dtl` LEFT JOIN `inventori` ON `pm_dtl`.`kode_inventori` = `inventori`.`kode_inventori` WHERE `pm_dtl`.`kode_pm` = '".$kode_pm."'");
	
}

?>
