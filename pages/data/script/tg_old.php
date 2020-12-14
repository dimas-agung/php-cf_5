<?php

$q_close 	= mysql_query("SELECT DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%m') AS `month`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y') AS `year`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y-%m') AS `fulltext` FROM `close`");

//CLASS FORM AWAL
$class_form='class="active"';
$class_pane_form='class="tab-pane in active"';
$class_tab="";
$class_pane_tab='class="tab-pane"';

$q_cab_aktif = mysql_query("SELECT kode_cabang, nama nama_cabang FROM cabang WHERE aktif = '1' ORDER BY nama ASC");

$q_inv_aktif = mysql_query("SELECT kode_inventori kode_barang FROM inventori WHERE aktif = '1' AND kategori != 'BS' ");

$q_tg = mysql_query("SELECT kode_tg, th.tgl_buat, th.ref, c.nama nama_cabang, ga.nama gudang_asal, gt.nama gudang_tujuan FROM tg_hdr th
						LEFT JOIN cabang c ON c.kode_cabang = th.kode_cabang
						LEFT JOIN gudang ga ON ga.kode_gudang = th.kode_gudang_asal
						LEFT JOIN gudang gt ON gt.kode_gudang = th.kode_gudang_tujuan
						GROUP BY kode_tg
						ORDER BY id_tg_hdr ASC");

?>
