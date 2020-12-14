<?php

$q_close 	= mysql_query("SELECT DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%m') AS `month`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y') AS `year`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y-%m') AS `fulltext` FROM `close`");

//CLASS FORM AWAL
$class_form 		='class="active"';
$class_pane_form	='class="tab-pane in active"';
$class_tab 			="";
$class_pane_tab 	='class="tab-pane"';

//DROPDOWN CABANG
$q_cab_aktif = mysql_query("SELECT kode_cabang, nama nama_cabang from cabang where aktif='1' ORDER BY kode_cabang ASC");

//DROPDOWN GUDANG
$q_gud_aktif = mysql_query("SELECT kode_gudang, nama nama_gudang from gudang where aktif='1' ORDER BY kode_gudang ASC ");

//DROPDOWN BARANG
$q_inv_aktif = mysql_query("SELECT kode_inventori, nama nama_inv from inventori where aktif='1' ORDER BY kode_inventori ASC");

//DROPDOWN COA DEBET
$q_coa_debet = mysql_query("SELECT kode_coa, nama nama_coa FROM coa WHERE aktif='1' AND level_coa='4'");

//DROPDOWN COA KREDIT
// $q_coa_kredit = mysql_query("SELECT kode_coa, nama nama_coa FROM coa WHERE nama LIKE 'persediaan%' AND level_coa='4' AND aktif='1' ");
$q_coa_kredit = mysql_query("SELECT kode_coa, nama nama_coa FROM coa WHERE aktif='1' AND level_coa='4' ");

//LIST STOK MASUK
$q_sm 		 = mysql_query("SELECT kode_sm, sh.tgl_buat, sh.ref, sh.kode_cabang, c.nama nama_cabang, sh.kode_gudang, g.nama nama_gudang, sh.keterangan_hdr FROM sm_hdr sh
							LEFT JOIN cabang c ON c.kode_cabang = sh.kode_cabang
							LEFT JOIN gudang g ON g.kode_gudang = sh.kode_gudang
							ORDER BY id_sm_hdr ASC");

// TRACK
if(isset($_GET['action']) and $_GET['action'] == "track") {

	$kode_sm = ($_GET['kode_sm']);

	$q_sm_hdr = mysql_query("SELECT kode_sm, sh.ref, sh.tgl_buat, sh.kode_cabang, c.nama nama_cabang, sh.kode_gudang, g.nama nama_gudang, sh.keterangan_hdr FROM sm_hdr sh
								LEFT JOIN cabang c ON c.kode_cabang = sh.kode_cabang
								LEFT JOIN gudang g ON g.kode_gudang = sh.kode_gudang
								WHERE kode_sm = '".$kode_sm."' ");

	$q_sm_dtl = mysql_query("SELECT * FROM sm_dtl WHERE kode_sm='".$kode_sm."' order by kode_sm ASC");

	$jurnal    = mysql_query("SELECT a.kode_coa,a.debet,a.kredit,b.nama nama_coa FROM jurnal a LEFT JOIN coa b on a.kode_coa=b.kode_coa where kode_transaksi = '".$kode_sm."'");

}

?>
