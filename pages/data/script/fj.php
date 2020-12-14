<?php

$q_close 	= mysql_query("SELECT DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%m') AS `month`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y') AS `year`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y-%m') AS `fulltext` FROM `close`");

//CLASS FORM AWAL
$class_form='class="active"';
$class_pane_form='class="tab-pane in active"';
$class_tab="";
$class_pane_tab='class="tab-pane"';

//DROPDOWN PELANGGAN

$q_pelanggan = mysql_query("SELECT `p`.`kode_pelanggan`, `p`.`nama`  FROM `sj_hdr` AS `sj` INNER JOIN `sj_dtl` AS `sjd` ON `sjd`.`kode_sj` = `sj`.`kode_sj` INNER JOIN `pelanggan` AS `p` ON `p`.`kode_pelanggan` = `sj`.`kode_pelanggan` WHERE `sjd`.`status_dtl` = '1' AND `sj`.`status` = '1'  AND `p`.`aktif` = '1' GROUP BY `sj`.`kode_pelanggan`");

//DROPDOWN DOC SJ
$q_doc_sj 		= mysql_query("SELECT sh.kode_sj, c.kode_cabang, c.nama AS nama_cabang, g.kode_gudang, g.nama AS nama_gudang, p.kode_pelanggan, p.nama AS nama_pelanggan, CONCAT(k.kode_karyawan, ':', k.nama) as salesman FROM sj_hdr sh
								LEFT JOIN cabang c ON c.kode_cabang = sh.kode_cabang
								LEFT JOIN gudang g ON g.kode_gudang = sh.kode_gudang
								LEFT JOIN pelanggan p ON p.kode_pelanggan = sh.kode_pelanggan
								LEFT JOIN karyawan k ON k.kode_karyawan = p.salesman
								WHERE sh.status='1'
								GROUP BY sh.kode_sj
								ORDER BY kode_sj ASC");

// LIST FJ
$q_fj = mysql_query("SELECT fjh.*, c.nama AS nama_cabang, g.nama AS nama_gudang, p.nama AS nama_pelanggan from fj_hdr fjh
						LEFT JOIN cabang c ON c.kode_cabang = fjh.kode_cabang
						LEFT JOIN gudang g ON g.kode_gudang = fjh.kode_gudang
						LEFT JOIN pelanggan p ON p.kode_pelanggan = fjh.kode_pelanggan
						ORDER BY id_fj_hdr ASC");

// TRACK
if(isset($_GET['action']) and $_GET['action'] == "track") {

	$kode_fj = ($_GET['kode_fj']);

	$id_fj_hdr = mysql_query("SELECT id_fj_hdr FROM fj_hdr WHERE kode_fj = '".$kode_fj."'");
	$id = mysql_fetch_array($id_fj_hdr);

	$q_fj_prev = mysql_query("SELECT id_fj_hdr, kode_fj FROM fj_hdr WHERE id_fj_hdr = (select max(id_fj_hdr) FROM fj_hdr WHERE id_fj_hdr < ".$id['id_fj_hdr'].")");

	$q_fj_next = mysql_query("SELECT id_fj_hdr, kode_fj FROM fj_hdr WHERE id_fj_hdr = (select min(id_fj_hdr) FROM fj_hdr WHERE id_fj_hdr > ".$id['id_fj_hdr'].")");

	$status = mysql_query("SELECT kode_fj, status from fj_hdr WHERE kode_fj = '".$kode_fj."' ");

	$jurnal = mysql_query("SELECT a.kode_coa, a.debet, a.kredit, b.nama nama_coa FROM jurnal a LEFT JOIN coa b on a.kode_coa=b.kode_coa WHERE kode_transaksi = '".$kode_fj."' AND status_jurnal = '0' ORDER BY a.tgl_input, a.debet, a.kredit, a.kode_coa, b.nama ASC");

	$q_fj_hdr = mysql_query("SELECT fjh.*, c.nama AS nama_cabang, g.nama AS nama_gudang, p.nama AS nama_pelanggan from fj_hdr fjh
						LEFT JOIN cabang c ON c.kode_cabang = fjh.kode_cabang
						LEFT JOIN gudang g ON g.kode_gudang = fjh.kode_gudang
						LEFT JOIN pelanggan p ON p.kode_pelanggan = fjh.kode_pelanggan
						WHERE fjh.kode_fj = '".$kode_fj."' ");

	$q_fj_dtl = mysql_query("SELECT fjd.*, fjh.subtotal, fjh.diskon_all, fjh.ppn_all, fjh.grand_total FROM fj_dtl fjd
								LEFT JOIN fj_hdr fjh ON fjh.kode_fj = fjd.kode_fj
								WHERE fjd.kode_fj='".$kode_fj."'
								ORDER BY fjd.id_fj_dtl ASC");
}


?>
