<?php

$q_close 	= mysql_query("SELECT DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%m') AS `month`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y') AS `year`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y-%m') AS `fulltext` FROM `close`");

//CLASS FORM AWAL
$class_form='class="active"';
$class_pane_form='class="tab-pane in active"';
$class_tab="";
$class_pane_tab='class="tab-pane"';

//DROPDOWN GUDANG
$q_gudang = mysql_query(" SELECT kode_gudang,nama AS nama_gudang, keterangan FROM gudang WHERE aktif='1' ORDER BY kode_gudang ASC");

//LIST BTB
$q_bj = mysql_query("SELECT bh.tgl_buat, bh.kode_btb, bh.ref, bd.kode_barang, s.nama AS nama_supplier, c.nama AS nama_cabang, g.nama AS nama_gudang, bd.qty, bd.status_dtl FROM btb_hdr bh
						INNER JOIN btb_dtl bd ON bd.kode_btb = bh.kode_btb
						LEFT JOIN cabang c ON c.kode_cabang = bh.kode_cabang
						LEFT JOIN gudang g ON g.kode_gudang = bh.kode_gudang
						LEFT JOIN supplier s ON s.kode_supplier = bh.kode_supplier
						ORDER BY id_btb_hdr ASC");
						
if(isset($_GET['action']) and $_GET['action'] == "spk_to_bj") {
	$kode_spk = ($_GET['kode_spk']);
	
	$spk_hdr = mysql_query("SELECT `spk_hdr`.`kode_spk`, `spk_hdr`.`ref`, `cabang`.`kode_cabang`, `cabang`.`nama` AS `nama_cabang`, `spk_hdr`.`keterangan_hdr`, `inventori`.`kode_inventori` AS `kode_barang`, `inventori`.`nama` AS `nama_barang`, `spk_hdr`.`qty`, `spk_hdr`.`kode_satuan`, `spk_hdr`.`status_hdr` FROM `spk_hdr` LEFT JOIN `cabang` ON `spk_hdr`.`kode_cabang` = `cabang`.`kode_cabang` LEFT JOIN `inventori` ON `spk_hdr`.`kode_barang` = `inventori`.`kode_inventori` WHERE `spk_hdr`.`kode_spk` = '".$kode_spk."'");
	
	$spk_hdr_f = ((mysql_num_rows($spk_hdr) > 0) ? mysql_fetch_array($spk_hdr) : null);
	
	$spk_dtl = mysql_query("SELECT `spk_hdr`.`kode_spk`, `inventori`.`kode_inventori`, `inventori`.`nama` AS `nama_barang`, `spk_dtl`.`kode_satuan`, `spk_dtl`.`kebutuhan` AS `qty`, IFNULL(SUM(`pm_dtl`.`qty`), 0) AS `qty_pm`, IFNULL(SUM(`pm_dtl`.`qty_pm_batal`), 0) AS `qty_pm_batal`, `spk_dtl`.`keterangan_dtl`, `spk_hdr`.`status_hdr`, `spk_dtl`.`status_dtl` FROM `spk_dtl` LEFT JOIN `spk_hdr` ON `spk_dtl`.`kode_spk` = `spk_hdr`.`kode_spk` LEFT JOIN `pm_hdr` ON `pm_hdr`.`kode_spk` = `pm_hdr`.`kode_spk` LEFT JOIN `pm_dtl` ON `pm_dtl`.`kode_pm` = `pm_hdr`.`kode_pm` AND `spk_dtl`.`kode_item_bom` = `pm_dtl`.`kode_inventori` LEFT JOIN `cabang` ON `spk_hdr`.`kode_cabang` = `cabang`.`kode_cabang` LEFT JOIN `inventori` ON `spk_dtl`.`kode_item_bom` = `inventori`.`kode_inventori` WHERE `spk_hdr`.`kode_spk` = '".(count($spk_hdr_f) > 0 ? $spk_hdr_f['kode_spk'] : null)."' AND `spk_hdr`.`status_hdr` = 'open' AND `spk_dtl`.`status_dtl` = 'open' GROUP BY `spk_dtl`.`kode_item_bom` ORDER BY `spk_dtl`.`id_spk_dtl` ASC");
	
	//DROPDOWN CABANG
	$q_cabang = mysql_query("SELECT `kode_cabang`, `nama` AS `nama_cabang` FROM `cabang` WHERE `kode_cabang` = '".(count($spk_hdr_f) > 0 ? $spk_hdr_f['kode_cabang'] : null)."' AND `aktif` = '1' ORDER BY `kode_cabang` ASC");
}
?>
