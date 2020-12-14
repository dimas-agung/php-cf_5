<?php

$q_close 	= mysql_query("SELECT DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%m') AS `month`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y') AS `year`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y-%m') AS `fulltext` FROM `close`");

//CLASS FORM AWAL
$class_form 		= 'class="active"';
$class_pane_form	= 'class="tab-pane in active"';
$class_tab 			= "";
$class_pane_tab 	= 'class="tab-pane"';

$q_cabang = mysql_query("SELECT kode_cabang, nama nama_cabang FROM cabang WHERE aktif = '1'");

$q_cspk = mysql_query("SELECT ch.*, c.nama nama_cabang FROM cspk_hdr ch
						LEFT JOIN cabang c ON c.kode_cabang = ch.kode_cabang
						ORDER BY id_cspk_hdr ASC");

// TRACK
if(isset($_GET['action']) and $_GET['action'] == "track") {
	$kode_cspk = ($_GET['kode_cspk']);

    $q_cspk_hdr  = mysql_query("SELECT ch.*, c.nama nama_cabang FROM cspk_hdr ch
								LEFT JOIN cabang c ON c.kode_cabang = ch.kode_cabang
								WHERE kode_cspk='".$kode_cspk."' ");

    $q_cspk_material = mysql_query("SELECT kode_barang, nama_barang, standart_pemakaian, transfer_material, sisa_material FROM cspk_dtl where kode_cspk='".$kode_cspk."'");
    $q_cspk_produksi = mysql_query("SELECT kode_barang, nama_barang, standart_pemakaian, pemakaian_material, var, map, var_nominal, var_persen FROM cspk_dtl where kode_cspk='".$kode_cspk."'");
}

?>
