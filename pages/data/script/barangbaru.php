<?php

//CLASS FORM AWAL
$class_form 		='class="active"';
$class_pane_form	='class="tab-pane in active"';
$class_tab 			="";
$class_tab1 		="";
$class_tab2 		="";
$class_pane_tab 	='class="tab-pane"';
$class_pane_tab1 	='class="tab-pane"';
$class_pane_tab2 	='class="tab-pane"';

$q_ddl_kat_inv 		= mysql_query("SELECT kode_kategori_inventori, nama FROM kategori_inventori WHERE aktif='1' ORDER BY nama ASC");
$q_ddl_satuan_beli 	= mysql_query("SELECT kode_satuan, nama FROM satuan WHERE aktif='1' ORDER BY nama ASC");
$q_ddl_satuan_jual 	= mysql_query("SELECT kode_satuan, nama FROM satuan WHERE aktif='1' ORDER BY nama ASC");

// HARGA $ DISKON //
$q_inv_hrg_diskon 	= mysql_query("SELECT kode_kategori_pelanggan, nama FROM kategori_pelanggan WHERE aktif='1' ORDER BY kode_kategori_pelanggan ASC");

// BOM //
$q_satuan_hdr = mysql_query("SELECT kode_satuan, nama nama_satuan FROM satuan where aktif='1' ORDER BY nama ASC");
$q_barang_dtl = mysql_query("SELECT kode_inventori, nama FROM inventori where aktif='1' AND kategori!='BS' ORDER BY nama ASC");
$q_satuan_dtl = mysql_query("SELECT kode_satuan, nama nama_satuan FROM satuan where aktif='1' ORDER BY nama ASC");

// ACCOUNTING //
$q_ddl_coa 	 = mysql_query("SELECT kode_coa, nama FROM coa WHERE level_coa='4' AND aktif='1' ORDER BY kode_coa ASC "); 
$q_ddl_coa2  = mysql_query("SELECT kode_coa, nama FROM coa WHERE level_coa='4' AND aktif='1' ORDER BY kode_coa ASC "); 
$q_ddl_coa3	 = mysql_query("SELECT kode_coa, nama FROM coa WHERE level_coa='4' AND aktif='1' ORDER BY kode_coa ASC "); 
$q_ddl_coa4  = mysql_query("SELECT kode_coa, nama FROM coa WHERE level_coa='4' AND aktif='1' ORDER BY kode_coa ASC "); 
$q_ddl_coa5  = mysql_query("SELECT kode_coa, nama FROM coa WHERE level_coa='4' AND aktif='1' ORDER BY kode_coa ASC "); 
$q_ddl_coa6  = mysql_query("SELECT kode_coa, nama FROM coa WHERE level_coa='4' AND aktif='1' ORDER BY kode_coa ASC "); 
$q_ddl_coa7  = mysql_query("SELECT kode_coa, nama FROM coa WHERE level_coa='4' AND aktif='1' ORDER BY kode_coa ASC "); 
$q_ddl_coa8  = mysql_query("SELECT kode_coa, nama FROM coa WHERE level_coa='4' AND aktif='1' ORDER BY kode_coa ASC "); 
$q_ddl_coa9  = mysql_query("SELECT kode_coa, nama FROM coa WHERE level_coa='4' AND aktif='1' ORDER BY kode_coa ASC "); 
$q_ddl_coa10 = mysql_query("SELECT kode_coa, nama FROM coa WHERE level_coa='4' AND aktif='1' ORDER BY kode_coa ASC "); 
$q_ddl_coa11 = mysql_query("SELECT kode_coa, nama FROM coa WHERE level_coa='4' AND aktif='1' ORDER BY kode_coa ASC "); 
$q_ddl_coa12 = mysql_query("SELECT kode_coa, nama FROM coa WHERE level_coa='4' AND aktif='1' ORDER BY kode_coa ASC "); 

// LIST //
$q_inv = mysql_query("SELECT kode_inventori, nama, kategori, keterangan, aktif FROM inventori ORDER BY id_inventori ASC");

// UBAH PENCARIAN BERDASAR STATUS DI DB
if(isset($_POST['status'])) {
	if($_POST['status']=='y'){
		$status='1';
	}else if($_POST['status']=='n'){
		$status='0';
	}
}

// BOM //
$q_satuan_hdr = mysql_query("SELECT kode_satuan, nama nama_satuan FROM satuan where aktif='1' ORDER BY nama ASC");
$q_satuan_dtl = mysql_query("SELECT kode_satuan, nama nama_satuan FROM satuan where aktif='1' ORDER BY nama ASC");
$q_barang_dtl = mysql_query("SELECT kode_inventori, nama FROM inventori where aktif='1' AND kategori!='BS' ORDER BY nama ASC");


?>