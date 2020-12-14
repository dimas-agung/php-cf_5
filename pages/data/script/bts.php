<?php

$q_close 	= mysql_query("SELECT DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%m') AS `month`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y') AS `year`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y-%m') AS `fulltext` FROM `close`");

//CLASS FORM AWAL
$class_form='class="active"';
$class_pane_form='class="tab-pane in active"';
$class_tab="";
$class_pane_tab='class="tab-pane"';

//DROPDOWN CABANG
$q_cabang = mysql_query(" SELECT kode_cabang,nama AS nama_cabang FROM cabang WHERE aktif='1' ORDER BY kode_cabang ASC");

//DROPDOWN ASET
$q_aset = mysql_query(" SELECT kode_kat_aset kode_aset,keterangan nama_aset FROM kategori_aset WHERE aktif='1' ORDER BY kode_kat_aset ASC");

//DROPDOWN CABANG LIST
$q_cabang_list = mysql_query(" SELECT kode_cabang,nama AS nama_cabang FROM cabang WHERE aktif='1' ORDER BY kode_cabang ASC");

//DROPDOWN SUPPLIER
$q_supplier = mysql_query(" SELECT kode_supplier,nama AS nama_supplier FROM supplier WHERE aktif='1' ORDER BY kode_supplier ASC");

//DROPDOWN DOC OP
$q_doc_ops = mysql_query(" SELECT od.kode_ops, od.kode_kat_aset, od.qty , s.kode_supplier, s.nama AS nama_supplier FROM ops_dtl od
						LEFT JOIN ops_hdr oh ON od.kode_ops =oh.kode_ops
						LEFT JOIN supplier s ON s.kode_supplier = oh.kode_supplier
						WHERE STATUS='0'
						GROUP BY od.id_ops_dtl ASC ");

//LIST BTS
$q_bts = mysql_query("SELECT bh.tgl_buat, bh.kode_bts, bh.kode_ops, bh.ref, a.keterangan AS nama_aset, s.nama AS nama_supplier, c.nama AS nama_cabang, bd.qty, bh.aktif FROM bts_hdr bh
						INNER JOIN bts_dtl bd ON bd.kode_bts = bh.kode_bts
						LEFT JOIN cabang c ON c.kode_cabang = bh.kode_cabang
						LEFT JOIN supplier s ON s.kode_supplier = bh.kode_supplier
						LEFT JOIN kategori_aset a ON a.kode_kat_aset = SUBSTRING_INDEX(bd.kode_kat_aset,':',1)
						ORDER BY id_bts_hdr ASC");


//LIST PENCARIAN
if(isset($_POST['cari'])){

	//CLASS FORM SAAT KLIK TOMBOL CARI
	$class_tab='class="active"';
	$class_pane_tab='class="tab-pane in active"';
	$class_form="";
	$class_pane_form='class="tab-pane"';

	$kode_bts		= $_POST['kode_bts'];
	$ref			= $_POST['ref'];
	$aset 			= $_POST['aset'];
	$cabang 		= $_POST['cabang'];
	$supplier 		= $_POST['supplier'];
	$tgl_awal		= date("Y-m-d",strtotime($_POST['tanggal_awal']));
	$tgl_akhir		= date("Y-m-d",strtotime($_POST['tanggal_akhir']));

	$sql = ("SELECT bh.tgl_buat, bh.kode_bts, bh.ref, a.keterangan AS nama_aset, s.nama AS nama_supplier, c.nama AS nama_cabang, bd.qty, bh.aktif FROM bts_hdr bh
						INNER JOIN bts_dtl bd ON bd.kode_bts = bh.kode_bts
						LEFT JOIN cabang c ON c.kode_cabang = bh.kode_cabang
						LEFT JOIN supplier s ON s.kode_supplier = bh.kode_supplier
						LEFT JOIN kategori_aset a ON a.kode_kat_aset = SUBSTRING_INDEX(bd.kode_kat_aset,':',1)
						WHERE bh.kode_bts LIKE '%".$kode_bts."%' AND
							bh.ref LIKE '%".$ref."%' AND
							a.kode_kat_aset LIKE '%".$aset."%' AND
							s.kode_supplier LIKE '%".$supplier."%' AND
							c.kode_cabang LIKE '%".$cabang."%' AND
							bh.tgl_buat BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."'
							ORDER BY id_bts_hdr ASC");

	$q_bts = mysql_query($sql)	;
	// echo $sql;
}

//REFRESH LIST
if(isset($_POST['refresh'])){
	//CLASS FORM SAAT KLIK TOMBOL REFRESH
	$class_tab='class="active"';
	$class_pane_tab='class="tab-pane in active"';
	$class_form="";
	$class_pane_form='class="tab-pane"';

	$_POST['kode_bts'] 	= "" ;
	$_POST['ref']		= "" ;
	$_POST['inventori']	= "" ;
	$_POST['cabang']	= "" ;
	$_POST['gudang']	= "" ;
	$_POST['supplier']	= "" ;
}

// TRACK
if(isset($_GET['action']) and $_GET['action'] == "track") {

	$kode_bts = ($_GET['kode_bts']);

	$q_bts_hdr = mysql_query("SELECT bh.kode_bts, bh.kode_supplier, s.nama AS nama_supplier, bh.ref, bh.kode_ops, bh.tgl_buat, bh.kode_cabang, c.nama AS nama_cabang, bh.keterangan_hdr FROM bts_hdr bh
								LEFT JOIN ops_hdr oh ON oh.kode_ops = bh.kode_ops
								LEFT JOIN cabang c ON c.kode_cabang = bh.kode_cabang
								LEFT JOIN supplier s ON s.kode_supplier = bh.kode_supplier
								WHERE bh.kode_bts = '".$kode_bts."' ");

	$q_bts_dtl = mysql_query("SELECT bd.*, SUBSTRING_INDEX(bd.kode_kat_aset, ':', 1) AS kode_kat_aset, i.keterangan AS nama_aset, bd.keterangan_dtl FROM bts_dtl bd
								INNER JOIN bts_hdr bh ON bh.kode_bts = bd.kode_bts
								LEFT JOIN ops_dtl od ON od.kode_ops = bh.kode_ops AND od.kode_kat_aset = bd.kode_kat_aset
								LEFT JOIN kategori_aset i ON i.kode_kat_aset = SUBSTRING_INDEX(bd.kode_kat_aset, ':', 1)
								WHERE bh.kode_bts = '".$kode_bts."'
								ORDER BY bd.kode_kat_aset ASC");

}

?>
