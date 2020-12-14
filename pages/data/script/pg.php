<?php

$q_close 	= mysql_query("SELECT DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%m') AS `month`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y') AS `year`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y-%m') AS `fulltext` FROM `close`");

//CLASS FORM AWAL
$class_form 		='class="active"';
$class_pane_form	='class="tab-pane in active"';
$class_tab 			="";
$class_pane_tab 	='class="tab-pane"';

//DROPDOWN FORM
$q_cabang 		= mysql_query("SELECT kode_cabang,nama AS nama_cabang FROM cabang WHERE aktif='1' ORDER BY kode_cabang ASC");

$q_pel_aktif 	= mysql_query("SELECT kode_pelanggan, nama nama_pelanggan FROM pelanggan WHERE aktif = '1' ORDER BY id_pelanggan ASC");

$q_sup_aktif 	= mysql_query("SELECT kode_supplier, nama nama_supplier FROM supplier WHERE aktif = '1' ORDER BY id_supplier ASC");

$q_pembayaran 	= mysql_query("(SELECT '0' AS `group_coa`, `kode_coa`, `nama` AS `nama_coa`, LEFT(`kode_coa`, 7) AS `singkatan` FROM `coa` WHERE `kode_coa` LIKE '1.01.01.%' AND SUBSTRING(`kode_coa`, -1) >= 1	ORDER BY `kode_coa` ASC) UNION (SELECT '1' AS `group_coa`, `kode_coa`, `nama` AS `nama_coa`, LEFT(`kode_coa`, 7) AS `singkatan` FROM `coa` WHERE `kode_coa` LIKE '1.01.02.%' AND SUBSTRING(`kode_coa`, -1) >= 1	ORDER BY `kode_coa` ASC)");

//DROPDOWN LIST
$q_cabang_list 		= mysql_query("SELECT kode_cabang,nama AS nama_cabang FROM cabang WHERE aktif='1' ORDER BY kode_cabang ASC");

$q_user_list	= mysql_query("SELECT kode_pelanggan kode_user,nama nama_user FROM pelanggan
								UNION
								SELECT kode_supplier kode_user,nama nama_user FROM supplier
								WHERE aktif='1' ");

$q_pembayaran_list 	= mysql_query("SELECT kode_coa, nama nama_coa FROM coa c WHERE kode_coa LIKE '1.01.01.%' AND SUBSTRING(kode_coa, -1) >= 1
									UNION
									(SELECT kode_coa, nama nama_coa FROM coa WHERE kode_coa LIKE '1.01.02.%' AND SUBSTRING(kode_coa, -1) >= 1)
									ORDER BY kode_coa ASC ");

$q_pg = mysql_query("SELECT ph.kode_pg, ph.kode_giro, kode_user, nama_user, tgl_buat, pd.tgl_jth_giro, bank_coa, c.nama nama_bank_coa, pd.nominal, pd.status_dtl, ph.status FROM pg_hdr ph
						LEFT JOIN coa c ON c.kode_coa = ph.bank_coa
						LEFT JOIN pg_dtl pd ON pd.kode_pg = ph.kode_pg");

// TRACK
if(isset($_GET['action']) and $_GET['action'] == "track") {

	$kode_pg = ($_GET['kode_pg']);

	$id_pg_hdr = mysql_query("SELECT id_pg_hdr FROM pg_hdr WHERE kode_pg = '".$kode_pg."'");
	$id = mysql_fetch_array($id_pg_hdr);

	$q_pg_prev = mysql_query("SELECT id_pg_hdr, kode_pg FROM pg_hdr WHERE id_pg_hdr = (select max(id_pg_hdr) FROM pg_hdr WHERE id_pg_hdr < ".$id['id_pg_hdr'].")");

	$q_pg_next = mysql_query("SELECT id_pg_hdr, kode_pg FROM pg_hdr WHERE id_pg_hdr = (select min(id_pg_hdr) FROM pg_hdr WHERE id_pg_hdr > ".$id['id_pg_hdr'].")");

	$status = mysql_query("SELECT kode_pg, status from pg_hdr WHERE kode_pg = '".$kode_pg."' ");

	$jurnal = mysql_query("SELECT a.kode_coa, a.debet, a.kredit, b.nama nama_coa FROM jurnal a INNER JOIN coa b on a.kode_coa=b.kode_coa where kode_transaksi = '".$kode_pg."' AND status_jurnal = '0' ORDER BY a.tgl_input, a.debet, a.kredit, a.kode_coa, b.nama ASC");

	$q_pg_hdr = mysql_query("SELECT ph.kode_pg, ph.kode_giro, ref, bank_coa, co.nama nama_bank_coa, ph.kode_cabang, c.nama nama_cabang, kode_user, nama_user, tgl_buat, keterangan_hdr, ph.status FROM pg_hdr ph
							LEFT JOIN pg_dtl pd ON pd.kode_pg = ph.kode_pg
							LEFT JOIN coa co ON co.kode_coa = ph.bank_coa
							LEFT JOIN cabang c ON c.kode_cabang = ph.kode_cabang
							WHERE ph.kode_pg = '".$kode_pg."' ");

	$q_pg_dtl = mysql_query("SELECT * FROM pg_dtl pd WHERE pd.kode_pg ='".$kode_pg."' ");

}

// PENGEMBALIAN
if(isset($_GET['action']) and $_GET['action'] == "pengembalian") {

	$kode_pg = ($_GET['kode_pg']);

	$pg_hdr_back = mysql_query("SELECT ph.kode_pg, pd.kode_giro, ref, bank_coa, co.nama nama_bank_coa, ph.kode_cabang, c.nama nama_cabang, kode_user, nama_user, tgl_buat, keterangan_hdr, ph.status FROM pg_hdr ph
							LEFT JOIN pg_dtl pd ON pd.kode_pg = ph.kode_pg
							LEFT JOIN coa co ON co.kode_coa = ph.bank_coa
							LEFT JOIN cabang c ON c.kode_cabang = ph.kode_cabang
							WHERE ph.kode_pg = '".$kode_pg."' ");

	$q_pg_dtl = mysql_query("SELECT * FROM pg_dtl pd WHERE pd.kode_pg ='".$kode_pg."' ");

	$array_dtl_back = array();
		if(mysql_num_rows($q_pg_dtl) > 0) {
			while ($res = mysql_fetch_array($q_pg_dtl)) {
					$array_dtl_back[] = $res;

			}
		}

	$_SESSION['data_dtl_back'] = $array_dtl_back;

	$coa_back= mysql_query("SELECT kode_coa, nama nama_coa FROM coa where level_coa = '4' ORDER BY kode_coa ASC");

	$array = array();
		if(mysql_num_rows($coa_back) > 0) {
			while ($res = mysql_fetch_array($coa_back)) {
				$array[] = $res;
			}
		}
	$data_coa_back = $array;

}

?>
