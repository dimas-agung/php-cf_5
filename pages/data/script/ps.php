<?php

//pr aktif
$q_pr_aktif = mysql_query("SELECT ph.kode_pr FROM pr_hdr ph
							INNER JOIN pr_dtl pd ON pd.kode_pr=ph.kode_pr
							WHERE STATUS='1'
							GROUP BY ph.kode_pr ORDER BY id_pr_dtl DESC");
//cabang aktif
$q_cab_aktif = mysql_query("SELECT kode_cabang,nama FROM cabang WHERE aktif='1'");
//supplier aktif
$q_supp_aktif = mysql_query("SELECT kode_supplier,nama,alamat,kontak_person,telpon,jatuh_tempo FROM supplier WHERE aktif='1'");

//LIST
$q_ps = mysql_query("SELECT kode_ps,doc_pr,tgl_buat,ps_hdr.kode_cabang, cab.nama cabang,ref,keterangan_hdr,kode_supplier 
						FROM ps_hdr 
						INNER JOIN cabang cab ON cab.kode_cabang=ps_hdr.kode_cabang ORDER BY id_ps_hdr DESC"); 

// TRACK 
if(isset($_GET['action']) and $_GET['action'] == "track") {

	$kode_ps = ($_GET['kode_ps']);
	
	$q_ps_hdr = mysql_query("SELECT ph.kode_ps, ph.kode_supplier, ph.ref, ph.alamat, ph.tgl_buat, ph.cp, c.nama AS nama_cabang, ph.no_kontak, ph.doc_pr, ph.top, ph.keterangan_hdr FROM ps_hdr ph
								LEFT JOIN supplier s ON s.kode_supplier = ph.kode_supplier
								LEFT JOIN cabang c ON c.kode_cabang = ph.kode_cabang
								WHERE ph.kode_ps = '".$kode_ps."'
								ORDER BY id_ps_hdr ASC");
	
	$q_ps_dtl = mysql_query("SELECT kode_barang, tgl_kirim, satuan, qty, harga, disc, ppn, subtotal, keterangan_dtl FROM ps_dtl
								WHERE kode_ps = '".$kode_ps."' 
								GROUP BY kode_barang ASC");

	$q_um = mysql_query("SELECT persen, termin from ps_um WHERE kode_ps = '".$kode_ps."'");
	
}

?>