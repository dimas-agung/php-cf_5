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

$q_pembayaran 	= mysql_query("SELECT kode_coa, nama nama_coa, LEFT(kode_coa, 7) singkatan FROM coa WHERE kode_coa LIKE '1.01.02.%' AND SUBSTRING(kode_coa, -1) >= 1
								ORDER BY kode_coa ASC ");

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

$q_gt = mysql_query("SELECT `gth`.`kode_gt`, `gth`.`nama_user`, `gth`.`tgl_buat`, `gtd`.`bank_giro`, `gtd`.`no_giro`, `gtd`.`tgl_jth_giro`, `gtd`.`nominal`, `gtd`.`status_dtl` AS `status`, `coa`.`kode_coa`, `coa`.`nama` AS `nama_coa` FROM `gt_hdr` AS `gth` LEFT JOIN `gt_dtl` AS `gtd` ON `gtd`.`kode_gt` = `gth`.`kode_gt` LEFT JOIN `coa` ON `coa`.`kode_coa` = `gth`.`bank_coa` ORDER BY `gth`.`kode_gt` DESC");

// TRACK
if(isset($_GET['action']) and $_GET['action'] == "track") {

	$kode_gt = ($_GET['kode_gt']);

	$id_gt_hdr = mysql_query("SELECT id_gt_hdr FROM gt_hdr WHERE kode_gt = '".$kode_gt."'");
	$id = mysql_fetch_array($id_gt_hdr);

	$q_gt_prev = mysql_query("SELECT id_gt_hdr, kode_gt FROM gt_hdr WHERE id_gt_hdr = (select max(id_gt_hdr) FROM gt_hdr WHERE id_gt_hdr < ".$id['id_gt_hdr'].")");

	$q_gt_next = mysql_query("SELECT id_gt_hdr, kode_gt FROM gt_hdr WHERE id_gt_hdr = (select min(id_gt_hdr) FROM gt_hdr WHERE id_gt_hdr > ".$id['id_gt_hdr'].")");

	$status = mysql_query("SELECT kode_gt, status from gt_hdr WHERE kode_gt = '".$kode_gt."' "); 

	$jurnal = mysql_query("SELECT a.kode_coa, a.debet, a.kredit, b.nama nama_coa FROM jurnal a INNER JOIN coa b on a.kode_coa=b.kode_coa where kode_transaksi = '".$kode_gt."' AND status_jurnal = '0' ORDER BY a.tgl_input, a.debet, a.kredit, a.kode_coa, b.nama ASC");
 
	$q_gt_hdr = mysql_query("SELECT `gth`.`kode_gt`, `gth`.`kode_pg`, `gth`.`ref`, `gth`.`nama_user`, `gth`.`tgl_buat`, `gth`.`keterangan_hdr`, `gth`.`status`, `coa`.`kode_coa`, `coa`.`nama` AS `nama_coa`, `cb`.`kode_cabang`, `cb`.`nama` AS `nama_cabang` FROM `gt_hdr` AS `gth` LEFT JOIN `coa` ON `coa`.`kode_coa` = `gth`.`bank_coa` LEFT JOIN `cabang` AS `cb` ON `cb`.`kode_cabang` = `gth`.`kode_cabang` WHERE `gth`.`kode_gt` = '".$kode_gt."'");

	$q_gt_dtl = mysql_query("SELECT * FROM `gt_dtl` AS `gtd` WHERE `gtd`.`kode_gt` ='".$kode_gt."' ");

}

// PENGEMBALIAN
if(isset($_GET['action']) and $_GET['action'] == "pengembalian") {

	$kode_gt = ($_GET['kode_gt']);

	$gt_hdr_back = mysql_query("SELECT ph.kode_gt, pd.kode_giro, ref, bank_coa, co.nama nama_bank_coa, ph.kode_cabang, c.nama nama_cabang, kode_user, nama_user, tgl_buat, keterangan_hdr, ph.status FROM gt_hdr ph
							LEFT JOIN gt_dtl pd ON pd.kode_gt = ph.kode_gt
							LEFT JOIN coa co ON co.kode_coa = ph.bank_coa
							LEFT JOIN cabang c ON c.kode_cabang = ph.kode_cabang
							WHERE ph.kode_gt = '".$kode_gt."' ");

	$q_gt_dtl = mysql_query("SELECT * FROM gt_dtl pd WHERE pd.kode_gt ='".$kode_gt."' ");

	$array_dtl_back = array();
		if(mysql_num_rows($q_gt_dtl) > 0) {
			while ($res = mysql_fetch_array($q_gt_dtl)) {
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
