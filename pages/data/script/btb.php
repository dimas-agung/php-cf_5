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
$q_inventori = mysql_query(" SELECT kode_inventori,nama AS nama_inventori FROM inventori WHERE aktif='1' AND kategori !='BS' ORDER BY kode_inventori ASC");

//DROPDOWN CABANG LIST
$q_cabang_list = mysql_query(" SELECT kode_cabang,nama AS nama_cabang FROM cabang WHERE aktif='1' ORDER BY kode_cabang ASC");

//DROPDOWN GUDANG
$q_gudang = mysql_query(" SELECT kode_gudang,nama AS nama_gudang FROM gudang WHERE aktif='1' ORDER BY kode_gudang ASC");

//DROPDOWN SUPPLIER
$q_supplier = mysql_query(" SELECT kode_supplier,nama AS nama_supplier FROM supplier WHERE aktif='1' ORDER BY kode_supplier ASC");

//DROPDOWN DOC OP
$q_doc_op = mysql_query(" SELECT od.kode_op, od.kode_barang, od.satuan, sat.nama nama_satuan, od.qty , s.kode_supplier, s.nama AS nama_supplier, od.kode_gudang FROM op_dtl od
						LEFT JOIN op_hdr oh ON od.kode_op=oh.kode_op
						LEFT JOIN inventori i ON i.kode_inventori=SUBSTRING_INDEX(od.kode_barang, ':', 1)
						LEFT JOIN supplier s ON s.kode_supplier=oh.kode_supplier
						LEFT JOIN satuan sat ON sat.kode_satuan=od.satuan
						WHERE status='1'
						GROUP BY od.kode_op ASC ");

//LIST BTB
$q_btb = mysql_query("SELECT bh.tgl_buat, bh.kode_btb, bh.ref, bd.kode_barang, s.nama AS nama_supplier, c.nama AS nama_cabang, g.nama AS nama_gudang, bd.qty, bd.status_dtl FROM btb_hdr bh
						INNER JOIN btb_dtl bd ON bd.kode_btb = bh.kode_btb
						LEFT JOIN cabang c ON c.kode_cabang = bh.kode_cabang
						LEFT JOIN gudang g ON g.kode_gudang = bh.kode_gudang
						LEFT JOIN supplier s ON s.kode_supplier = bh.kode_supplier
						ORDER BY id_btb_hdr ASC");


//LIST PENCARIAN
if(isset($_POST['cari'])){

	//CLASS FORM SAAT KLIK TOMBOL CARI
	$class_tab 		='class="active"';
	$class_pane_tab ='class="tab-pane in active"';
	$class_form 	="";
	$class_pane_form='class="tab-pane"';

	$kode_btb		= $_POST['kode_btb'];
	$ref			= $_POST['ref'];
	$inventori 		= $_POST['inventori'];
	$cabang 		= $_POST['cabang'];
	$gudang 		= $_POST['gudang'];
	$supplier 		= $_POST['supplier'];
	$tgl_awal		= date("Y-m-d",strtotime($_POST['tanggal_awal']));
	$tgl_akhir		= date("Y-m-d",strtotime($_POST['tanggal_akhir']));

	$sql = ("SELECT bh.tgl_buat, bh.kode_btb, bh.ref, bd.kode_barang, s.nama AS nama_supplier, c.nama AS nama_cabang, g.nama AS nama_gudang, bd.qty, bh.aktif, bd.status_dtl FROM btb_hdr bh
						INNER JOIN btb_dtl bd ON bd.kode_btb = bh.kode_btb
						LEFT JOIN cabang c ON c.kode_cabang = bh.kode_cabang
						LEFT JOIN gudang g ON g.kode_gudang = bh.kode_gudang
						LEFT JOIN supplier s ON s.kode_supplier = bh.kode_supplier
						LEFT JOIN inventori i ON i.kode_inventori = SUBSTRING_INDEX(bd.kode_barang, ':', 1)
						WHERE bh.kode_btb LIKE '%".$kode_btb."%' AND
							bh.ref LIKE '%".$ref."%' AND
							i.kode_inventori LIKE '%".$inventori."%' AND
							s.kode_supplier LIKE '%".$supplier."%' AND
							c.kode_cabang LIKE '%".$cabang."%' AND
							g.kode_gudang LIKE '%".$gudang."%' AND
							bh.tgl_buat BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."'
							GROUP by bd.kode_btb, bd.kode_barang
							ORDER BY id_btb_hdr ASC");

	$q_btb = mysql_query($sql)	;
	// echo $sql;
}

//REFRESH LIST
if(isset($_POST['refresh'])){
	//CLASS FORM SAAT KLIK TOMBOL REFRESH
	$class_tab='class="active"';
	$class_pane_tab='class="tab-pane in active"';
	$class_form="";
	$class_pane_form='class="tab-pane"';

	$_POST['kode_btb'] 	= "" ;
	$_POST['ref']		= "" ;
	$_POST['inventori']	= "" ;
	$_POST['cabang']	= "" ;
	$_POST['gudang']	= "" ;
	$_POST['supplier']	= "" ;
}

// TRACK
if(isset($_GET['action']) and $_GET['action'] == "track") {

	$kode_btb = ($_GET['kode_btb']);

	$id_btb_hdr = mysql_query("SELECT id_btb_hdr FROM btb_hdr WHERE kode_btb = '".$kode_btb."'");
	$id 	   = mysql_fetch_array($id_btb_hdr);

	$q_btb_prev = mysql_query("SELECT id_btb_hdr, kode_btb FROM btb_hdr WHERE id_btb_hdr = (select max(id_btb_hdr) FROM btb_hdr WHERE id_btb_hdr < ".$id['id_btb_hdr'].")");

	$q_btb_next = mysql_query("SELECT id_btb_hdr, kode_btb FROM btb_hdr WHERE id_btb_hdr = (select min(id_btb_hdr) FROM btb_hdr WHERE id_btb_hdr > ".$id['id_btb_hdr'].")");

	$status = mysql_query("SELECT kode_btb, status from btb_hdr WHERE kode_btb = '".$kode_btb."' ");

	$jurnal = mysql_query("SELECT a.kode_coa, a.debet, a.kredit, b.nama nama_coa FROM jurnal a LEFT JOIN coa b on a.kode_coa=b.kode_coa where kode_transaksi = '".$kode_btb."' AND status_jurnal = '0' ORDER BY a.tgl_input, a.debet, a.kredit, a.kode_coa, b.nama ASC");

	$q_btb_hdr = mysql_query("SELECT bh.kode_btb, bh.kode_supplier, s.nama AS nama_supplier, bh.ref, bh.kode_op, bh.tgl_buat, bh.kode_cabang, c.nama AS nama_cabang, bh.kode_gudang, g.nama AS nama_gudang, bh.keterangan_hdr, bh.status FROM btb_hdr bh
								LEFT JOIN op_hdr oh ON oh.kode_op = bh.kode_op
								LEFT JOIN cabang c ON c.kode_cabang = bh.kode_cabang
								LEFT JOIN supplier s ON s.kode_supplier = bh.kode_supplier
								LEFT JOIN gudang g ON g.kode_gudang = bh.kode_gudang
								WHERE bh.kode_btb = '".$kode_btb."' ");

	$q_btb_dtl = mysql_query("SELECT SUBSTRING_INDEX(bd.kode_barang, ':', 1) AS kode_barang, i.nama nama_barang, SUBSTRING_INDEX(bd.satuan2, ' : ', 1) AS kode_satuan, s.nama nama_satuan, qty_op, qty, keterangan_dtl, qty_i
								FROM btb_dtl bd
								LEFT JOIN satuan s ON s.kode_satuan = SUBSTRING_INDEX(bd.satuan2, ' : ', 1)
								LEFT JOIN inventori i ON i.kode_inventori = SUBSTRING_INDEX(bd.kode_barang, ':', 1)
								WHERE bd.kode_btb = '".$kode_btb."'
								GROUP BY bd.kode_barang
								ORDER BY bd.kode_barang ASC");
}

?>
