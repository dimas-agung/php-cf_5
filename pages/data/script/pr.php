<?php

//cabang aktif
$q_cab_aktif = mysql_query("SELECT kode_cabang,nama FROM cabang WHERE aktif='1'");
//gudang aktif
$q_gud_aktif = mysql_query("SELECT kode_gudang,nama FROM gudang WHERE aktif='1'"); 
//barang aktif
$q_ddl_item = mysql_query("SELECT kode_inventori,nama FROM inventori WHERE aktif='1'");
//divisi aktif
$q_ddl_divisi = mysql_query("SELECT kode_cc,nama FROM kategori_divisi WHERE aktif='1'"); 

//LIST
$q_pr = mysql_query("SELECT kode_pr,doc_so,doc_pq,tgl_buat,pr_hdr.kode_cabang, cab.nama cabang,ref,keterangan_hdr 
FROM pr_hdr 
INNER JOIN cabang cab ON cab.kode_cabang=pr_hdr.kode_cabang ORDER BY id_pr_hdr DESC"); 

// TRACK 
if(isset($_GET['action']) and $_GET['action'] == "track") {
	$kode_pr = ($_GET['kode']);
	
	$q_pr_hdr = mysql_query("SELECT kode_pr,doc_so,doc_pq,tgl_buat,pr_hdr.kode_cabang, cab.nama cabang,ref,keterangan_hdr 
FROM pr_hdr INNER JOIN cabang cab ON cab.kode_cabang=pr_hdr.kode_cabang WHERE kode_pr = '".$kode_pr."'");
	
	$q_pr_dtl = mysql_query("SELECT * FROM pr_dtl WHERE kode_pr='".$kode_pr."' ORDER BY kode_barang ASC");
	
}

?>