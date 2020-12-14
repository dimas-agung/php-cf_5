<?php

$q_close 	= mysql_query("SELECT DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%m') AS `month`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y') AS `year`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y-%m') AS `fulltext` FROM `close`");

//CLASS FORM AWAL
$class_form='class="active"';
$class_pane_form='class="tab-pane in active"';
$class_tab="";
$class_pane_tab='class="tab-pane"';

//LIST TG
$q_tg = mysql_query("SELECT `tg_hdr`.`kode_tg`, `tg_hdr`.`tgl_buat`, `tg_hdr`.`ref`, `cabang`.`nama` AS `nama_cabang`, CONCAT(`gudang_a`.`nama`, ' ', `gudang_a`.`keterangan`) AS `nama_gudang_asal`, CONCAT(`gudang_b`.`nama`, ' ', `gudang_b`.`keterangan`) AS `nama_gudang_tujuan`, `tg_hdr`.`status_hdr`, `tg_dtl`.`status_dtl` FROM `tg_hdr` LEFT JOIN `cabang` ON `tg_hdr`.`kode_cabang` = `cabang`.`kode_cabang` LEFT JOIN `gudang` AS `gudang_a` ON `tg_hdr`.`kode_gudang_from` = `gudang_a`.`kode_gudang` LEFT JOIN `gudang` AS `gudang_b` ON `tg_hdr`.`kode_gudang_to` = `gudang_b`.`kode_gudang` LEFT JOIN `tg_dtl` ON `tg_hdr`.`kode_tg` = `tg_dtl`.`kode_tg` GROUP BY `tg_hdr`.`kode_tg` ORDER BY `tg_hdr`.`tgl_buat`");

if(isset($_GET['action']) and $_GET['action'] == "pm_to_tg") {
	$kode_pm = ($_GET['kode_pm']);
	
	$pm_hdr = mysql_query("SELECT `pm_hdr`.`kode_pm`, `pm_hdr`.`kode_spk`, `pm_hdr`.`ref`, `cabang`.`kode_cabang`, `cabang`.`nama` AS `nama_cabang`, `pm_hdr`.`kode_gudang_asal`, CONCAT(`gudang_a`.`nama`, ' - ', `gudang_a`.`keterangan`) AS `nama_gudang_asal`, `pm_hdr`.`kode_gudang_tujuan`, CONCAT(`gudang_b`.`nama`, ' - ', `gudang_b`.`keterangan`) AS `nama_gudang_tujuan`, `pm_hdr`.`keterangan_hdr`, `pm_hdr`.`status_hdr` FROM `pm_hdr` LEFT JOIN `cabang` ON `pm_hdr`.`kode_cabang` = `cabang`.`kode_cabang` LEFT JOIN `gudang` AS `gudang_a` ON `pm_hdr`.`kode_gudang_asal` = `gudang_a`.`kode_gudang` LEFT JOIN `gudang` AS `gudang_b` ON `pm_hdr`.`kode_gudang_tujuan` = `gudang_b`.`kode_gudang` WHERE `pm_hdr`.`kode_pm` = '".$kode_pm."' AND `pm_hdr`.`to_tg` = 'no'");
	
	$pm_hdr_f = ((mysql_num_rows($pm_hdr) > 0) ? mysql_fetch_array($pm_hdr) : null);
	
	$pm_dtl = mysql_query("SELECT `inventori`.`kode_inventori`, `inventori`.`nama` AS `nama_barang`, `pm_dtl`.`qty`, `pm_dtl`.`kode_satuan`, IFNULL(`crd_stok`.`saldo_qty`, 0) `stok`, IFNULL(`crd_stok`.`saldo_last_hpp`, 0) AS `rata`, `pm_dtl`.`keterangan_dtl`, `pm_dtl`.`status_dtl` FROM `pm_dtl` LEFT JOIN `pm_hdr` ON `pm_dtl`.`kode_pm` = `pm_hdr`.`kode_pm` LEFT JOIN `inventori` ON `pm_dtl`.`kode_inventori` = `inventori`.`kode_inventori` LEFT JOIN `crd_stok` ON `crd_stok`.`kode_barang` = `pm_dtl`.`kode_inventori` AND `crd_stok`.`kode_cabang` = `pm_hdr`.`kode_cabang` AND `crd_stok`.`kode_gudang` = `pm_hdr`.`kode_gudang_asal` WHERE `pm_hdr`.`kode_pm` = '".(count($pm_hdr_f) > 0 ? $pm_hdr_f['kode_pm'] : null)."'  AND `pm_dtl`.`status_dtl` = 'open' GROUP BY `pm_dtl`.`kode_inventori` ORDER BY `pm_dtl`.`id_pm_dtl` ASC");
	
	//DROPDOWN CABANG
	$q_cabang = mysql_query("SELECT `kode_cabang`, `nama` AS `nama_cabang` FROM `cabang` WHERE `kode_cabang` = '".(count($pm_hdr_f) > 0 ? $pm_hdr_f['kode_cabang'] : null)."' AND `aktif` = '1' ORDER BY `kode_cabang` ASC");

	//DROPDOWN GUDANG A
	$q_gudang_a = mysql_query("SELECT `kode_gudang`, CONCAT(`nama`, ' ', `keterangan`) AS `nama_gudang` FROM `gudang` WHERE `kode_gudang` = '".(count($pm_hdr_f) > 0 ? $pm_hdr_f['kode_gudang_asal'] : null)."' AND  `aktif` = '1' AND `is_produksi` = 'no' ORDER BY `kode_gudang` ASC");

	//DROPDOWN GUDANG B
	$q_gudang_b = mysql_query("SELECT `kode_gudang`, CONCAT(`nama`, ' ', `keterangan`) AS `nama_gudang` FROM `gudang` WHERE `kode_gudang` = '".(count($pm_hdr_f) > 0 ? $pm_hdr_f['kode_gudang_tujuan'] : null)."' AND  `aktif` = '1' AND `is_produksi` = 'yes' ORDER BY `kode_gudang` ASC");
}

// TRACK
if(isset($_GET['action']) and $_GET['action'] == "track") {

	$kode_tg = ($_GET['kode_tg']);

	$id_tg_hdr = mysql_query("SELECT `id_tg_hdr` FROM `tg_hdr` WHERE `kode_tg` = '".$kode_tg."'");
	$id 	   = mysql_fetch_array($id_tg_hdr);

	$q_tg_prev = mysql_query("SELECT `id_tg_hdr`, `kode_tg` FROM `tg_hdr` WHERE `id_tg_hdr` = (SELECT MAX(`id_tg_hdr`) FROM `tg_hdr` WHERE `id_tg_hdr` < '".$id['id_tg_hdr']."')");
	
	$q_tg_next = mysql_query("SELECT `id_tg_hdr`, `kode_tg` FROM `tg_hdr` WHERE `id_tg_hdr` = (SELECT MIN(`id_tg_hdr`) FROM `tg_hdr` WHERE `id_tg_hdr` > '".$id['id_tg_hdr']."')");

	$status = mysql_query("SELECT `kode_tg`, `status_hdr` FROM `tg_hdr` WHERE `kode_tg` = '".$kode_tg."' ");

	$q_tg_hdr = mysql_query("SELECT `tg_hdr`.`kode_tg`, `tg_hdr`.`kode_spk`, `tg_hdr`.`tgl_buat`, `tg_hdr`.`ref`, `cabang`.`kode_cabang`, `cabang`.`nama` AS `nama_cabang`, CONCAT(`gudang_a`.`nama`, ' - ', `gudang_a`.`keterangan`) AS `nama_gudang_from`, CONCAT(`gudang_b`.`nama`, ' - ', `gudang_b`.`keterangan`) AS `nama_gudang_to`, `tg_hdr`.`keterangan_hdr`, `tg_hdr`.`status_hdr` FROM `tg_hdr` LEFT JOIN `cabang` ON `tg_hdr`.`kode_cabang` = `cabang`.`kode_cabang` LEFT JOIN `gudang` AS `gudang_a` ON `tg_hdr`.`kode_gudang_from` = `gudang_a`.`kode_gudang` LEFT JOIN `gudang` AS `gudang_b` ON `tg_hdr`.`kode_gudang_to` = `gudang_b`.`kode_gudang` WHERE `tg_hdr`.`kode_tg` = '".$kode_tg."'");

	$q_tg_dtl = mysql_query("SELECT `inventori`.`kode_inventori`, `inventori`.`nama` AS `nama_barang`, `tg_dtl`.`qty`, `tg_dtl`.`qty_tg_app`, `tg_dtl`.`hpp`, (`tg_dtl`.`qty_tg_app` * `tg_dtl`.`hpp`) AS `total_app_qty`, `tg_dtl`.`keterangan_dtl`, `tg_dtl`.`status_dtl` FROM `tg_dtl` LEFT JOIN `inventori` ON `tg_dtl`.`kode_inventori` = `inventori`.`kode_inventori` WHERE `tg_dtl`.`kode_tg` = '".$kode_tg."'");
	
	$jurnal = mysql_query("SELECT `jurnal`.`kode_transaksi` AS `kode_tg`, `jurnal`.`debet`, `jurnal`.`kredit`, `coa`.`kode_coa`, `coa`.`nama` AS `nama_coa` FROM `jurnal` LEFT JOIN `coa` ON `coa`.`kode_coa` = `jurnal`.`kode_coa` WHERE `jurnal`.`kode_transaksi` = '".$kode_tg."' ORDER BY `jurnal`.`id_jurnal` ASC");
	
}

?>
