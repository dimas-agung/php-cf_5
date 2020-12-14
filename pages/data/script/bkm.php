<?php

$q_close 	= mysql_query("SELECT DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%m') AS `month`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y') AS `year`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y-%m') AS `fulltext` FROM `close`");

//CLASS FORM AWAL
$class_form 		='class="active"';
$class_pane_form	='class="tab-pane in active"';
$class_tab 			="";
$class_pane_tab 	='class="tab-pane"';

//DROPDOWN CABANG FORM
$q_cabang 		= mysql_query("SELECT kode_cabang,nama AS nama_cabang FROM cabang WHERE aktif='1' ORDER BY kode_cabang ASC");

//DROPDOWN METODE PEMBAYARAN FORM
$q_pembayaran 	= mysql_query("SELECT kode_coa, nama nama_coa, LEFT(nama, 3) singkatan FROM coa c WHERE (kode_coa LIKE '1.01.01.%' OR kode_coa LIKE '110101.%') AND level_coa = '4' UNION SELECT kode_coa, nama nama_coa, LEFT(nama, 3) singkatan FROM coa WHERE (kode_coa LIKE '1.01.02.%' OR kode_coa LIKE '110102.%') AND level_coa = '4' ORDER BY kode_coa ASC ");

//DROPDOWN PELANGGAN FORM
$q_pelanggan 		= mysql_query("SELECT kode_pelanggan,nama AS nama_pelanggan FROM pelanggan WHERE aktif='1' ORDER BY kode_pelanggan ASC");

//DROPDOWN COA FORM DETAIL
$q_coa 				= mysql_query("SELECT kode_coa, nama nama_coa FROM coa where level_coa = '4' order by kode_coa  ASC");

//DROPDOWN COA EDIT
$q_coa_edit 		= mysql_query("SELECT kode_coa, nama nama_coa FROM coa where level_coa = '4' order by kode_coa ASC");

//DROPDOWN CABANG LIST
$q_cabang_list 		= mysql_query("SELECT kode_cabang,nama AS nama_cabang FROM cabang WHERE aktif='1' ORDER BY kode_cabang ASC");

//DROPDOWN PELANGGAN LIST
$q_pelanggan_list	= mysql_query("SELECT kode_pelanggan,nama AS nama_pelanggan FROM pelanggan WHERE aktif='1' ORDER BY kode_pelanggan ASC");

//DROPDOWN COA LIST
$q_coa_list 		= mysql_query("SELECT kode_coa, nama nama_coa FROM coa WHERE aktif='1' AND level_coa = '4' order by kode_coa ASC");

//LIST bkm
$q_bkm = mysql_query("SELECT bh.*, c.nama nama_cabang, p.nama nama_pelanggan, o.nama nama_coa FROM bkm_hdr bh
						LEFT JOIN bkm_dtl bd ON bd.kode_bkm = bh.kode_bkm
						LEFT JOIN cabang c ON c.kode_cabang = bh.kode_cabang
						LEFT JOIN pelanggan p ON p.kode_pelanggan = bh.kode_pelanggan
						LEFT JOIN coa o ON o.kode_coa = bh.rekening
						GROUP BY bh.kode_bkm
						ORDER BY id_bkm_hdr ASC");

//LIST PENCARIAN
if(isset($_POST['cari'])){

	//CLASS FORM SAAT KLIK TOMBOL CARI
	$class_tab='class="active"';
	$class_pane_tab='class="tab-pane in active"';
	$class_form="";
	$class_pane_form='class="tab-pane"';

	$kode_bkm		= $_POST['kode_bkm'];
	$ref			= $_POST['ref'];
	$kode_coa 		= $_POST['kode_coa'];
	$pelanggan 		= $_POST['pelanggan'];
	$tgl_awal		= date("Y-m-d",strtotime($_POST['tanggal_awal']));
	$tgl_akhir		= date("Y-m-d",strtotime($_POST['tanggal_akhir']));

	if( $_POST['status'] == '1'){
		$status = '1';
	}else{
		$status = '0';
	}

	$sql = ("SELECT bh.*, c.nama nama_cabang, p.nama nama_pelanggan, bd.nominal_bayar, o.nama nama_coa FROM bkm_hdr bh
						LEFT JOIN bkm_dtl bd ON bd.kode_bkm = bh.kode_bkm
						LEFT JOIN cabang c ON c.kode_cabang = bh.kode_cabang
						LEFT JOIN pelanggan p ON p.kode_pelanggan = bh.kode_pelanggan
						LEFT JOIN coa o ON o.kode_coa = bh.rekening
							WHERE bh.kode_bkm LIKE '%".$kode_bkm."%' AND
								bh.ref LIKE '%".$ref."%' AND
								bh.rekening LIKE '%".$kode_coa."%' AND
								c.kode_cabang LIKE '%".$cabang."%' AND
								bh.kode_pelanggan LIKE '%".$pelanggan."%' AND
								bh.status LIKE '%".$status."%' AND
								bh.tgl_buat BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."'
							ORDER BY id_bkm_hdr ASC");

	$q_bkm = mysql_query($sql)	;
	// echo $sql;
}

//REFRESH LIST
if(isset($_POST['refresh'])){
	//CLASS FORM SAAT KLIK TOMBOL REFRESH
	$class_tab='class="active"';
	$class_pane_tab='class="tab-pane in active"';
	$class_form="";
	$class_pane_form='class="tab-pane"';

	$_POST['kode_bkm'] 	= "" ;
	$_POST['ref'] 		= "" ;
	$_POST['kode_coa'] 	= "" ;
	$_POST['cabang'] 	= "" ;
	$_POST['pelanggan'] 	= "" ;
	$_POST['status']	= "" ;
}

// TRACK
if(isset($_GET['action']) and $_GET['action'] == "track") {

	$kode_bkm = ($_GET['kode_bkm']);

	$id_bkm_hdr = mysql_query("SELECT id_bkm_hdr FROM bkm_hdr WHERE kode_bkm = '".$kode_bkm."'");
	$id = mysql_fetch_array($id_bkm_hdr);

	$q_bkm_prev = mysql_query("SELECT id_bkm_hdr, kode_bkm FROM bkm_hdr WHERE id_bkm_hdr = (select max(id_bkm_hdr) FROM bkm_hdr WHERE id_bkm_hdr < ".$id['id_bkm_hdr'].")");

	$q_bkm_next = mysql_query("SELECT id_bkm_hdr, kode_bkm FROM bkm_hdr WHERE id_bkm_hdr = (select min(id_bkm_hdr) FROM bkm_hdr WHERE id_bkm_hdr > ".$id['id_bkm_hdr'].")");

	$jurnal = mysql_query("SELECT a.kode_coa, a.debet, a.kredit, b.nama nama_coa FROM jurnal a INNER JOIN coa b on a.kode_coa=b.kode_coa where kode_transaksi = '".$kode_bkm."'");

	$q_bkm_hdr = mysql_query("SELECT bh.*, c.nama nama_cabang, p.nama nama_pelanggan, o.nama nama_coa FROM bkm_hdr bh
							LEFT JOIN cabang c ON c.kode_cabang = bh.kode_cabang
							LEFT JOIN pelanggan p ON p.kode_pelanggan = bh.kode_pelanggan
							LEFT JOIN coa o ON o.kode_coa = bh.rekening
							WHERE bh.kode_bkm = '".$kode_bkm."' ");

	$q_bkm_dtl = mysql_query("SELECT bd.*, bh.subtotal, o.nama nama_coa FROM bkm_dtl bd
							 LEFT JOIN bkm_hdr bh ON bh.kode_bkm = bd.kode_bkm
							 LEFT JOIN coa o ON o.kode_coa = bd.kode_coa
							 WHERE bd.kode_bkm ='".$kode_bkm."' ");

}

?>
