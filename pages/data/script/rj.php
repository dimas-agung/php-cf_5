<?php

$q_close 	= mysql_query("SELECT DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%m') AS `month`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y') AS `year`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y-%m') AS `fulltext` FROM `close`");

//CLASS FORM AWAL
$class_form 		='class="active"';
$class_pane_form	='class="tab-pane in active"';
$class_tab 			="";
$class_pane_tab 	='class="tab-pane"';

//DROPDOWN CABANG
$q_cab_aktif = mysql_query("SELECT kode_cabang, nama nama_cabang from cabang where aktif = '1' ORDER BY kode_cabang ASC");

//DROPDOWN gudang
$q_gud_aktif = mysql_query("SELECT kode_gudang, nama nama_gudang from gudang where aktif = '1' AND nama IN ('ID', 'BS') ORDER BY kode_gudang ASC");

//DROPDOWN PELANGGAN
$q_pel_aktif = mysql_query("SELECT kode_pelanggan, nama nama_pelanggan from pelanggan where aktif = '1' ORDER BY kode_pelanggan ASC");

//DROPDOWN BARANG BS
$q_invbs_aktif = mysql_query("SELECT kode_inventori, nama nama_invbs from inventori where aktif='1' ORDER BY kode_inventori ASC");

//LIST RJ
$q_rj = mysql_query("SELECT kode_rj, rjh.tgl_buat, rjh.ref, c.nama nama_cabang, g.nama nama_gudang, p.nama nama_pelanggan, rjh.keterangan_hdr, rjh.status FROM rj_hdr rjh
						LEFT JOIN cabang c ON c.kode_cabang = rjh.kode_cabang
						LEFT JOIN gudang g ON g.kode_gudang = rjh.kode_gudang
						LEFT JOIN pelanggan p ON p.kode_pelanggan = rjh.kode_pelanggan
						ORDER BY id_rj_hdr ASC");

// TRACK
if(isset($_GET['action']) and $_GET['action'] == "track") {
	$kode_rj = ($_GET['kode_rj']);

	$id_rj_hdr = mysql_query("SELECT id_rj_hdr FROM rj_hdr WHERE kode_rj = '".$kode_rj."'");

	$id = mysql_fetch_array($id_rj_hdr);

	$q_rj_prev = mysql_query("SELECT id_rj_hdr,kode_rj FROM rj_hdr WHERE id_rj_hdr = (select max(id_rj_hdr) FROM rj_hdr WHERE id_rj_hdr < ".$id['id_rj_hdr'].")");

	$q_rj_next = mysql_query("SELECT id_rj_hdr,kode_rj FROM rj_hdr WHERE id_rj_hdr = (select min(id_rj_hdr) FROM rj_hdr WHERE id_rj_hdr > ".$id['id_rj_hdr'].")");

	$status = mysql_query("SELECT kode_rj, status from rj_hdr WHERE kode_rj = '".$kode_rj."' ");

	$jurnal = mysql_query("SELECT a.kode_coa, a.debet, a.kredit, b.nama nama_coa FROM jurnal a LEFT JOIN coa b on a.kode_coa=b.kode_coa where kode_transaksi = '".$kode_rj."' AND status_jurnal = '0' ORDER BY a.tgl_input, a.debet, a.kredit, a.kode_coa, b.nama ASC");

	$q_rj_hdr = mysql_query("SELECT kode_rj, ref, tgl_buat, keterangan_hdr, rh.kode_cabang, c.nama nama_cabang, rh.kode_gudang, g.nama nama_gudang, rh.kode_pelanggan, p.nama nama_pelanggan, rh.status FROM rj_hdr rh
								LEFT JOIN cabang c ON c.kode_cabang = rh.kode_cabang
								LEFT JOIN gudang g ON g.kode_gudang = rh.kode_gudang
								LEFT JOIN pelanggan p ON p.kode_pelanggan = rh.kode_pelanggan
								WHERE rh.kode_rj = '".$kode_rj."' ");

	$q_rj_dtl = mysql_query("SELECT * FROM rj_dtl WHERE kode_rj = '".$kode_rj."'");

}


?>
