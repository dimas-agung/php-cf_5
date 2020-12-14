<?php

$q_app_op =  mysql_query("SELECT kode_op, tgl_buat , oh.kode_supplier, s.nama nama_supplier, status, user_pencipta, nm_user
							FROM op_hdr oh
							INNER JOIN supplier s ON s.kode_supplier = oh.kode_supplier														INNER JOIN user u ON u.kd_user = oh.user_pencipta
							WHERE status = '0'
							ORDER BY kode_op ASC");

// TRACK 
if(isset($_GET['action']) and $_GET['action'] == "approval") {
	$kode_op = ($_GET['kode_op']);
	
	$id_op_hdr 	= mysql_query("SELECT id_op_hdr FROM op_hdr WHERE kode_op = '".$kode_op."'");
	$id 		= mysql_fetch_array($id_op_hdr);
	
	$q_op_hdr 	= mysql_query("SELECT oh.kode_op, oh.kode_supplier, s.nama AS nama_supplier, oh.ref, oh.tgl_buat, oh.kode_cabang, c.nama AS nama_cabang, oh.keterangan_hdr, jatuh_tempo top, oh.user_pencipta, u.nm_user nama_user FROM op_hdr oh
								LEFT JOIN user u ON u.level = oh.user_pencipta
								LEFT JOIN cabang c ON c.kode_cabang = oh.kode_cabang
								LEFT JOIN supplier s ON s.kode_supplier = oh.kode_supplier 
								WHERE oh.kode_op = '".$kode_op."' ");
	
	$q_op_dtl 	= mysql_query("SELECT * FROM op_dtl WHERE kode_op = '".$kode_op."'");

	$op_um 		= mysql_query("SELECT termin, persen FROM op_um WHERE kode_op = '".$kode_op."'");
	
}

// SETUJU /  TOLAK
if(isset($_GET['action']) and $_GET['action'] == "setuju") {
	$kode_op = mres($_GET['kode_op']);
	$user 	 = mres($_GET['user']);
	
	$op_hdr = "update op_hdr set status = '1' , user_approve ='".$user."' where kode_op = '".$kode_op."'";
	$op_hdr_1 = mysql_query ($op_hdr) ;
		
	if ($op_hdr_1) {
		$op_dtl = "update op_dtl set status_dtl = '1' where kode_op = '".$kode_op."'";
		$op_dtl_1 = mysql_query ($op_dtl) ;
	}
		
	echo("<script>location.href = '".base_url()."?page=pembelian/pp&pesan=$kode_op telah di Approval';</script>");
} 

if(isset($_GET['action']) and $_GET['action'] == "tolak") {
	$kode_op = mres($_GET['kode_op']);
	$user 	 = mres($_GET['user']);
	$alasan_batal = mres($_POST['alasan_batal']);
	$tgl_batal = date("Y-m-d");
	if($alasan_batal != ''){
		$op_hdr = "update op_hdr set status = '2' , user_batal ='".$user."', alasan_batal ='".$alasan_batal."', tgl_batal='" . $tgl_batal . "' where kode_op = '".$kode_op."'";
		$op_hdr_2 = mysql_query ($op_hdr) ;
		
		if ($op_hdr_2) {
			$op_dtl = "update op_dtl set status_dtl = '2' where kode_op = '".$kode_op."'";
			$op_dtl_2 = mysql_query ($op_dtl) ;
		}
		if ($op_dtl_2) {
			echo("<script>location.href = '".base_url()."?page=pembelian/pp&kode_op=$kode_op&pembatalan=telah di batalkan';</script>");
		}
		else {
			echo("<script>location.href = '".base_url()."?page=pembelian/pp';</script>");
		}
	}else{
		echo("<script>location.href = '".base_url()."?page=approval/pp_form&action=approval&halaman=PERMINTAAN PEMBELIAN&kode_op={$kode_op}&pesan=Harap isi Alasan Batal terlebih dahulu !!'; alert('Harap isi Alasan Batal terlebih dahulu !!');</script>");
	}
}

?>