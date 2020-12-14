<?php

$q_close 	= mysql_query("SELECT DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%m') AS `month`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y') AS `year`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y-%m') AS `fulltext` FROM `close`");

//CLASS FORM AWAL
$class_form 		='class="active"';
$class_pane_form 	='class="tab-pane in active"';
$class_tab 			="";
$class_pane_tab 	='class="tab-pane"';

//DROPDOWN PELANGGAN
$q_pelanggan  		= mysql_query("SELECT kode_pelanggan, nama as nama_pelanggan FROM pelanggan WHERE aktif='1' " . searchKodeSales() . " ORDER BY kode_pelanggan ASC");

//LIST CABANG
$q_cabang  			= mysql_query("SELECT kode_cabang, nama as nama_cabang FROM cabang WHERE aktif='1' ORDER BY kode_cabang ASC");

$q_cabang_list  	= mysql_query("SELECT kode_cabang, nama as nama_cabang FROM cabang WHERE aktif='1' ORDER BY kode_cabang ASC");

//LIST GUDANG
$q_gudang  			= mysql_query("SELECT kode_gudang, nama as nama_gudang FROM gudang WHERE aktif='1' ORDER BY kode_gudang ASC");

//LIST PELANGGAN
$q_pelanggan_list	= mysql_query("SELECT kode_pelanggan, nama as nama_pelanggan FROM pelanggan WHERE aktif='1' " . searchKodeSales() . " ORDER BY kode_pelanggan ASC");

//LIST SURAT JALAN
$q_sj  		= mysql_query("SELECT sd.kode_sj, sh.tgl_buat, sh.ref, c.nama nama_cabang, g.nama nama_gudang, p.nama nama_pelanggan, sh.subtotal, sh.keterangan_hdr, sh.status FROM sj_dtl sd
							INNER JOIN sj_hdr sh ON sh.kode_sj = sd.kode_sj
							LEFT JOIN cabang c ON c.kode_cabang = sh.kode_cabang
							LEFT JOIN gudang g ON g.kode_gudang = sh.kode_gudang
							LEFT JOIN pelanggan p ON p.kode_pelanggan = sh.kode_pelanggan
							GROUP BY sd.kode_sj
							ORDER BY sd.id_sj_dtl ASC");

//LIST PENCARIAN
if(isset($_POST['cari'])){

	//CLASS FORM SAAT KLIK TOMBOL CARI
	$class_tab='class="active"';
	$class_pane_tab='class="tab-pane in active"';
	$class_form="";
	$class_pane_form='class="tab-pane"';

	$kode_so		= $_POST['kode_sj'];
	$ref			= $_POST['ref'];
	$cabang 		= $_POST['cabang'];
	$pelanggan 		= $_POST['pelanggan'];
	$tgl_awal		= date("Y-m-d",strtotime($_POST['tanggal_awal']));
	$tgl_akhir		= date("Y-m-d",strtotime($_POST['tanggal_akhir']));

	if( $_POST['status'] == '1'){
		$status = '1';
	}else{
		$status = '0';
	}

	$sql = ("SELECT sh.*, c.nama as nama_cabang, g.nama as nama_gudang, p.nama as nama_pelanggan FROM sj_hdr sh
							INNER JOIN sj_dtl sd ON sd.kode_sj = sh.kode_sj
							LEFT JOIN cabang c on c.kode_cabang = sh.kode_cabang
							LEFT JOIN gudang g on g.kode_gudang = sh.kode_gudang
							LEFT JOIN pelanggan p on p.kode_pelanggan = SUBSTRING_INDEX(sh.kode_pelanggan, ':', 1)
							WHERE sh.kode_sj LIKE '%".$kode_so."%' AND
								sh.ref LIKE '%".$ref."%' AND
								c.kode_cabang LIKE '%".$cabang."%' AND
								p.kode_pelanggan LIKE '%".$pelanggan."%' AND
								sh.status LIKE '%".$status."%' AND
								sh.tgl_buat BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."'
							GROUP BY sd.kode_sj
							ORDER BY id_sj_hdr ASC");

	$q_sj = mysql_query($sql)	;
	// echo $sql;
}

//REFRESH LIST
if(isset($_POST['refresh'])){
	//CLASS FORM SAAT KLIK TOMBOL REFRESH
	$class_tab='class="active"';
	$class_pane_tab='class="tab-pane in active"';
	$class_form="";
	$class_pane_form='class="tab-pane"';

	$_POST['kode_sj'] 	= "" ;
	$_POST['ref']		= "" ;
	$_POST['cabang']	= "" ;
	$_POST['pelanggan']	= "" ;
	$_POST['status']	= "" ;
}

// TRACK
if(isset($_GET['action']) and $_GET['action'] == "track") {

	$kode_sj = ($_GET['kode_sj']);

	$id_sj_hdr = mysql_query("SELECT id_sj_hdr FROM sj_hdr WHERE kode_sj = '".$kode_sj."'");
	$id = mysql_fetch_array($id_sj_hdr);

	$q_sj_prev = mysql_query("SELECT id_sj_hdr, kode_sj FROM sj_hdr WHERE id_sj_hdr = (select max(id_sj_hdr) FROM sj_hdr WHERE id_sj_hdr < ".$id['id_sj_hdr'].")");

	$q_sj_next = mysql_query("SELECT id_sj_hdr, kode_sj FROM sj_hdr WHERE id_sj_hdr = (select min(id_sj_hdr) FROM sj_hdr WHERE id_sj_hdr > ".$id['id_sj_hdr'].")");

	$status = mysql_query("SELECT kode_sj, status from sj_hdr WHERE kode_sj = '".$kode_sj."' ");

	$jurnal = mysql_query("SELECT a.kode_coa, a.debet, a.kredit, b.nama nama_coa FROM jurnal a LEFT JOIN coa b on a.kode_coa=b.kode_coa where kode_transaksi = '".$kode_sj."' AND status_jurnal = '0' ORDER BY a.tgl_input, a.debet, a.kredit, a.kode_coa, b.nama ASC");

	$q_sj_hdr = mysql_query("SELECT sh.*, p.nama nama_pelanggan, c.nama nama_cabang, g.nama nama_gudang  FROM sj_hdr sh
								LEFT JOIN cabang c ON c.kode_cabang = sh.kode_cabang
								LEFT JOIN gudang g ON g.kode_gudang = sh.kode_gudang
								LEFT JOIN pelanggan p ON p.kode_pelanggan = sh.kode_pelanggan
								WHERE sh.kode_sj = '".$kode_sj."' ");

	$q_sj_dtl = mysql_query("SELECT * FROM sj_dtl sd WHERE sd.kode_sj = '".$kode_sj."' GROUP BY kode_inventori ORDER BY kode_inventori ASC");

}

?>
