<?php

$q_close 	= mysql_query("SELECT DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%m') AS `month`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y') AS `year`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y-%m') AS `fulltext` FROM `close`");

//CLASS FORM AWAL
$class_form 		='class="active"';
$class_pane_form	='class="tab-pane in active"';
$class_tab 			="";
$class_pane_tab 	='class="tab-pane"';

//DROPDOWN CABANG
$q_cabang 			= mysql_query("SELECT kode_cabang,nama AS nama_cabang FROM cabang WHERE aktif='1' ORDER BY nama_cabang ASC");

$q_cabang_list 		= mysql_query("SELECT kode_cabang,nama AS nama_cabang FROM cabang WHERE aktif='1' ORDER BY nama_cabang ASC");

//DROPDOWN COA FORM DETAIL
$q_coa 				= mysql_query("SELECT kode_coa, nama nama_coa FROM coa WHERE level_coa = '4' AND aktif = '1' order by kode_coa ASC");

//DROPDOWN COA EDIT
$q_coa_edit 		= mysql_query("SELECT kode_coa, nama nama_coa FROM coa WHERE level_coa = '4' AND aktif = '1' order by kode_coa ASC");

//LIST JM
$q_jm = mysql_query("SELECT jh.*, c.nama nama_cabang FROM jm_hdr jh
						LEFT JOIN cabang c ON c.kode_cabang = jh.kode_cabang
						ORDER BY id_jm_hdr ASC");

//LIST PENCARIAN
if(isset($_POST['cari'])){

	//CLASS FORM SAAT KLIK TOMBOL CARI
	$class_tab='class="active"';
	$class_pane_tab='class="tab-pane in active"';
	$class_form="";
	$class_pane_form='class="tab-pane"';

	$kode_jm		= $_POST['kode_jm'];
	$ref			= $_POST['ref'];
	$cabang 		= $_POST['cabang'];
	$tgl_awal		= date("Y-m-d",strtotime($_POST['tanggal_awal']));
	$tgl_akhir		= date("Y-m-d",strtotime($_POST['tanggal_akhir']));

	if( $_POST['status'] == '1'){
		$status = '1';
	}else{
		$status = '0';
	}

	$sql = ("SELECT jh.*, c.nama nama_cabang FROM jm_hdr jh
			LEFT JOIN cabang c ON c.kode_cabang = jh.kode_cabang
			WHERE jh.kode_jm LIKE '%".$kode_jm."%' AND
				jh.ref LIKE '%".$ref."%' AND
				c.kode_cabang LIKE '%".$cabang."%' AND
				jh.status LIKE '%".$status."%' AND
				jh.tgl_buat BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."'
			ORDER BY id_jm_hdr ASC");

	$q_jm = mysql_query($sql)	;
	// echo $sql;
}

//REFRESH LIST
if(isset($_POST['refresh'])){
	//CLASS FORM SAAT KLIK TOMBOL REFRESH
	$class_tab='class="active"';
	$class_pane_tab='class="tab-pane in active"';
	$class_form="";
	$class_pane_form='class="tab-pane"';

	$_POST['kode_jm'] 	= "" ;
	$_POST['ref'] 		= "" ;
	$_POST['cabang'] 	= "" ;
	$_POST['status']	= "" ;
}


// TRACK
if(isset($_GET['action']) and $_GET['action'] == "track") {

	$kode_jm = ($_GET['kode_jm']);
	
	$id_jm_hdr = mysql_query("SELECT id_jm_hdr FROM jm_hdr WHERE kode_jm = '" . $kode_jm . "'");
    $id = mysql_fetch_array($id_jm_hdr);
	
	$q_jm_prev = mysql_query("SELECT id_jm_hdr, kode_jm FROM jm_hdr WHERE id_jm_hdr = (select max(id_jm_hdr) FROM jm_hdr WHERE id_jm_hdr < " . $id['id_jm_hdr'] . ")");

    $q_jm_next = mysql_query("SELECT id_jm_hdr, kode_jm FROM jm_hdr WHERE id_jm_hdr = (select min(id_jm_hdr) FROM jm_hdr WHERE id_jm_hdr > " . $id['id_jm_hdr'] . ")");

    $jurnal = mysql_query("SELECT a.kode_coa, a.debet, a.kredit, b.nama nama_coa FROM jurnal a LEFT JOIN coa b on a.kode_coa = b.kode_coa WHERE kode_transaksi = '" . $kode_jm . "' AND status_jurnal != '1' ORDER BY a.tgl_input, a.debet, a.kredit, a.kode_coa, b.nama ASC");

	$q_jm_hdr = mysql_query("SELECT jm.*, c.nama nama_cabang FROM jm_hdr jm LEFT JOIN cabang c ON c.kode_cabang = jm.kode_cabang
							WHERE kode_jm = '".$kode_jm."' ");

	$q_jm_dtl = mysql_query("SELECT jm.*, o.nama nama_coa, jmh.subtotal_debet, jmh.subtotal_kredit FROM jm_dtl jm
								LEFT JOIN coa o ON o.kode_coa = jm.kode_coa
								LEFT JOIN jm_hdr jmh ON jmh.kode_jm = jm.kode_jm
							 	WHERE jm.kode_jm ='".$kode_jm."'
							 	ORDER BY id_jm_dtl ASC");

}

?>
