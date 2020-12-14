<?php

$q_close 	= mysql_query("SELECT DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%m') AS `month`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y') AS `year`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y-%m') AS `fulltext` FROM `close`");

//CLASS FORM AWAL
$class_form 		= 'class="active"';
$class_pane_form	= 'class="tab-pane in active"';
$class_tab 			= "";
$class_pane_tab 	= 'class="tab-pane"';

$q_cab_aktif 	= mysql_query("SELECT kode_cabang,nama nama_cabang FROM cabang WHERE aktif='1'");
$q_barang 		= mysql_query("SELECT i.kode_inventori kode_barang,i.nama nama_barang, i.qty_bom qty, i.satuan_bom kode_satuan_bom, s.nama satuan_bom FROM inventori i
								LEFT JOIN satuan s ON s.kode_satuan = i.satuan_bom
								WHERE i.aktif='1' AND kategori !='BS'");

$q_spk = mysql_query("SELECT sh.*, c.nama nama_cabang, i.nama nama_barang FROM spk_hdr sh
						LEFT JOIN cabang c ON c.kode_cabang = sh.kode_cabang
						LEFT JOIN inventori i ON i.kode_inventori = sh.kode_barang
						ORDER BY id_spk_hdr ASC");

// TRACK
if(isset($_GET['action']) and $_GET['action'] == "track") {
	$kode_spk = ($_GET['kode_spk']);

    $q_spk_hdr = mysql_query("SELECT sh.*, c.nama nama_cabang, i.nama nama_barang_jadi FROM spk_hdr sh
								LEFT JOIN cabang c ON c.kode_cabang = sh.kode_cabang
								LEFT JOIN inventori i ON i.kode_inventori = sh.kode_barang
								WHERE sh.kode_spk = '".$kode_spk."' ");

    $q_spk_dtl = mysql_query("SELECT sd.*, s.nama nama_satuan FROM spk_dtl sd
                                LEFT JOIN satuan s ON s.kode_satuan = sd.satuan
                               	WHERE kode_spk = '".$kode_spk."' ORDER BY id_spk_dtl ASC");
}

?>
