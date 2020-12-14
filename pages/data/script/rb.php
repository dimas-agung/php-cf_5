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

//DROPDOWN SUPPLIER
$q_sup_aktif = mysql_query("SELECT kode_supplier, nama nama_supplier, ppn from supplier where aktif='1' ORDER BY kode_supplier ASC");

//DROPDOWN BARANG BS
$q_invbs_aktif = mysql_query("SELECT kode_inventori, nama nama_invbs from inventori where aktif='1' ORDER BY kode_inventori ASC");

//LIST RB
$q_rb = mysql_query("SELECT kode_rb, rbh.tgl_buat, rbh.ref, c.nama nama_cabang, g.nama nama_gudang, s.nama nama_supplier, rbh.keterangan_hdr, rbh.status FROM rb_hdr rbh
						LEFT JOIN cabang c ON c.kode_cabang = rbh.kode_cabang
						LEFT JOIN gudang g ON g.kode_gudang = rbh.kode_gudang
						LEFT JOIN supplier s ON s.kode_supplier = rbh.kode_supplier
						ORDER BY id_rb_hdr ASC");

// TRACK
if(isset($_GET['action']) and $_GET['action'] == "track") {
	$kode_rb = ($_GET['kode_rb']);

	$id_rb_hdr = mysql_query("SELECT id_rb_hdr FROM rb_hdr WHERE kode_rb = '".$kode_rb."'");

	$id = mysql_fetch_array($id_rb_hdr);

	$q_rb_prev = mysql_query("SELECT id_rb_hdr,kode_rb FROM rb_hdr WHERE id_rb_hdr = (select max(id_rb_hdr) FROM rb_hdr WHERE id_rb_hdr < ".$id['id_rb_hdr'].")");

	$q_rb_next = mysql_query("SELECT id_rb_hdr,kode_rb FROM rb_hdr WHERE id_rb_hdr = (select min(id_rb_hdr) FROM rb_hdr WHERE id_rb_hdr > ".$id['id_rb_hdr'].")");

	$status = mysql_query("SELECT kode_rb, status from rb_hdr WHERE kode_rb = '".$kode_rb."' ");

	$jurnal = mysql_query("SELECT a.kode_coa, a.debet, a.kredit, b.nama nama_coa FROM jurnal a LEFT JOIN coa b on a.kode_coa=b.kode_coa where kode_transaksi = '".$kode_rb."' AND status_jurnal = '0' ORDER BY a.tgl_input, a.debet, a.kredit, a.kode_coa, b.nama ASC");

	$q_rb_hdr = mysql_query("SELECT kode_rb, ref, tgl_buat, keterangan_hdr, rh.kode_cabang, c.nama nama_cabang, rh.kode_gudang, g.nama nama_gudang, rh.kode_supplier, s.nama nama_supplier, rh.status FROM rb_hdr rh
								LEFT JOIN cabang c ON c.kode_cabang = rh.kode_cabang
								LEFT JOIN gudang g ON g.kode_gudang = rh.kode_gudang
								LEFT JOIN supplier s ON s.kode_supplier = rh.kode_supplier
								WHERE rh.kode_rb = '".$kode_rb."' ");

	$q_rb_dtl = mysql_query("SELECT * FROM rb_dtl WHERE kode_rb = '".$kode_rb."'");

}


?>
