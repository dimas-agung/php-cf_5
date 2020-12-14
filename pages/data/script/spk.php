<?php

$q_close 	= mysql_query("SELECT DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%m') AS `month`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y') AS `year`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y-%m') AS `fulltext` FROM `close`");

//CLASS FORM AWAL
$class_form='class="active"';
$class_pane_form='class="tab-pane in active"';
$class_tab="";
$class_pane_tab='class="tab-pane"';

//DROPDOWN CABANG
$q_cabang = mysql_query(" SELECT kode_cabang,nama AS nama_cabang FROM cabang WHERE aktif='1' ORDER BY kode_cabang ASC");

//DROPDOWN INVENTORI
$q_inventori = mysql_query(" SELECT inventori.kode_inventori, nama AS nama_inventori FROM bom LEFT JOIN inventori ON inventori.kode_inventori = bom.kode_inventori WHERE aktif='1' AND kategori ='ID' GROUP BY inventori.kode_inventori ORDER BY kode_inventori ASC");

//LIST SPK
$q_spk = mysql_query("SELECT `spk_hdr`.`kode_spk`, `inventori`.`kode_inventori`, `inventori`.`nama` AS `nama_barang`, `spk_hdr`.`tgl_buat`, `spk_hdr`.`tgl_selesai`, `spk_hdr`.`ref`, `cabang`.`nama` AS `nama_cabang`, `spk_hdr`.`status_hdr` FROM `spk_hdr` LEFT JOIN `cabang` ON `spk_hdr`.`kode_cabang` = `cabang`.`kode_cabang` LEFT JOIN `gudang` ON `spk_hdr`.`kode_gudang` = `gudang`.`kode_gudang` LEFT JOIN `inventori` ON `spk_hdr`.`kode_barang` = `inventori`.`kode_inventori` WHERE `inventori`.`kategori` = 'ID'");

// TRACK
if(isset($_GET['action']) and $_GET['action'] == "track") {

	$kode_spk = ($_GET['kode_spk']);

	$id_spk_hdr = mysql_query("SELECT `id_spk_hdr` FROM `spk_hdr` WHERE `kode_spk` = '".$kode_spk."'");
	$id 	   = mysql_fetch_array($id_spk_hdr);

	$q_spk_prev = mysql_query("SELECT `id_spk_hdr`, `kode_spk` FROM `spk_hdr` WHERE `id_spk_hdr` = (SELECT MAX(`id_spk_hdr`) FROM `spk_hdr` WHERE `id_spk_hdr` < '".$id['id_spk_hdr']."')");

	$q_spk_next = mysql_query("SELECT `id_spk_hdr`, `kode_spk` FROM `spk_hdr` WHERE `id_spk_hdr` = (SELECT MIN(`id_spk_hdr`) FROM `spk_hdr` WHERE `id_spk_hdr` > '".$id['id_spk_hdr']."')");

	$status = mysql_query("SELECT `kode_spk`, `status_hdr` FROM `spk_hdr` WHERE `kode_spk` = '".$kode_spk."' ");

	$q_spk_hdr = mysql_query("SELECT `spk_hdr`.`kode_spk`, `spk_hdr`.`ref`, `spk_hdr`.`tgl_buat`, `spk_hdr`.`tgl_selesai`, `cabang`.`nama` AS `nama_cabang`, `inventori`.`kode_inventori`, `inventori`.`nama` AS `nama_barang`, `spk_hdr`.`qty`, `spk_hdr`.`kode_satuan`, `spk_hdr`.`keterangan_hdr`, `spk_hdr`.`to_pm`, `spk_hdr`.`to_fg`, `spk_hdr`.`to_retur`, `spk_hdr`.`to_bs`, `spk_hdr`.`status_hdr` FROM `spk_hdr` LEFT JOIN `cabang` ON `spk_hdr`.`kode_cabang` = `cabang`.`kode_cabang` LEFT JOIN `gudang` ON `spk_hdr`.`kode_gudang` = `gudang`.`kode_gudang` LEFT JOIN `inventori` ON `spk_hdr`.`kode_barang` = `inventori`.`kode_inventori` WHERE `spk_hdr`.`kode_spk` = '".$kode_spk."' AND `inventori`.`kategori` = 'ID'");

	$q_spk_dtl = mysql_query("SELECT `spk_hdr`.`kode_spk`, `inventori`.`kode_inventori`, `inventori`.`nama` AS `nama_barang`, `spk_dtl`.`base_qty` AS `q_std`, `spk_dtl`.`kebutuhan` AS `q_use`, `spk_dtl`.`qty_spk_app`, `spk_dtl`.`kode_satuan`, `spk_dtl`.`keterangan_dtl`, `spk_dtl`.`status_dtl` FROM `spk_dtl` LEFT JOIN `spk_hdr` ON `spk_dtl`.`kode_spk` = `spk_hdr`.`kode_spk` LEFT JOIN `inventori` ON `spk_dtl`.`kode_item_bom` = `inventori`.`kode_inventori` WHERE `spk_hdr`.`kode_spk` = '".$kode_spk."' AND `inventori`.`kategori` = 'MT' ORDER BY `inventori`.`kode_inventori` ASC");
	
	$q_konsumsi = mysql_query("SELECT `tg_hdr`.`kode_tg`, `tg_hdr`.`tgl_buat`, `tg_dtl`.`qty_tg_app`, `inventori`.`kode_inventori`, `inventori`.`nama` AS `nama_barang`, SUBSTRING_INDEX(`bom`.`satuan_dtl`, ':', 1) AS `kode_satuan` FROM `tg_dtl` LEFT JOIN `bom` ON `tg_dtl`.`kode_inventori` = SUBSTRING_INDEX(`bom`.`kode_barang_dtl`, ':', 1) LEFT JOIN `inventori` ON `tg_dtl`.`kode_inventori` = `inventori`.`kode_inventori` LEFT JOIN `tg_hdr` ON `tg_dtl`.`kode_tg` = `tg_hdr`.`kode_tg` LEFT JOIN `pm_hdr` ON `tg_hdr`.`kode_pm` = `pm_hdr`.`kode_pm` LEFT JOIN `spk_hdr` ON `pm_hdr`.`kode_spk` = `spk_hdr`.`kode_spk` WHERE `spk_hdr`.`kode_spk` = '".$kode_spk."' AND `pm_hdr`.`status_hdr` = 'close' ORDER BY `inventori`.`kode_inventori`, `tg_dtl`.`id_tg_dtl` ASC");
	
	$q_produksi = mysql_query("SELECT `spk_hdr`.`kode_spk`, `inventori`.`kode_inventori`, `inventori`.`nama` AS `nama_barang`, `spk_dtl`.`base_qty` AS `q_std`, `spk_dtl`.`kebutuhan` AS `q_use`, `spk_dtl`.`qty_spk_app`, `spk_dtl`.`kode_satuan`, `spk_dtl`.`keterangan_dtl`, `spk_dtl`.`status_dtl` FROM `spk_dtl` LEFT JOIN `spk_hdr` ON `spk_dtl`.`kode_spk` = `spk_hdr`.`kode_spk` LEFT JOIN `inventori` ON `spk_dtl`.`kode_item_bom` = `inventori`.`kode_inventori` WHERE `spk_hdr`.`kode_spk` = '".$kode_spk."' AND `inventori`.`kategori` = 'MT' ORDER BY `inventori`.`kode_inventori` ASC");
	
	$q_varian = "";
}

?>
