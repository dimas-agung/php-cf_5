<?php

$q_close 	= mysql_query("SELECT DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%m') AS `month`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y') AS `year`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y-%m') AS `fulltext` FROM `close`");

//CLASS FORM AWAL
$class_form='class="active"';
$class_pane_form='class="tab-pane in active"';
$class_tab="";
$class_pane_tab='class="tab-pane"';

//DROPDOWN CABANG
$q_cabang 		= mysql_query(" SELECT kode_cabang,nama AS nama_cabang FROM cabang WHERE aktif='1' ORDER BY kode_cabang ASC");
$q_cabang_list 	= mysql_query(" SELECT kode_cabang,nama AS nama_cabang FROM cabang WHERE aktif='1' ORDER BY kode_cabang ASC");

//DROPDOWN SUPPPLIER
$q_supplier 		= mysql_query(" SELECT kode_supplier,nama AS nama_supplier FROM supplier WHERE aktif='1' ORDER BY kode_supplier ASC");
$q_supplier_list 	= mysql_query(" SELECT kode_supplier,nama AS nama_supplier FROM supplier WHERE aktif='1' ORDER BY kode_supplier ASC");

//DROPDOWN INVENTORI
$q_inventori = mysql_query(" SELECT kode_inventori,nama AS nama_inventori FROM inventori WHERE aktif='1' ORDER BY kode_inventori ASC");

//LIST FB
$q_fb = mysql_query("SELECT fh.*, c.nama nama_cabang, s.nama nama_supplier, SUM(subtot) AS harga FROM fb_hdr fh
						LEFT JOIN cabang c ON c.kode_cabang = fh.kode_cabang
						LEFT JOIN supplier s ON s.kode_supplier = fh.kode_supplier
						LEFT JOIN fb_dtl fd ON fd.kode_fb = fh.kode_fb
						GROUP BY kode_fb
						ORDER BY id_fb_hdr ASC");


//LIST PENCARIAN
if(isset($_POST['cari'])){

	//CLASS FORM SAAT KLIK TOMBOL CARI
	$class_tab 		='class="active"';
	$class_pane_tab	='class="tab-pane in active"';
	$class_form 	="";
	$class_pane_form='class="tab-pane"';

	$kode_fb		= $_POST['kode_fb'];
	$ref			= $_POST['ref'];
	$harga 			= $_POST['nominal'];
	$cabang 		= $_POST['cabang'];
	$supplier 		= $_POST['supplier'];
	$tgl_awal		= date("Y-m-d",strtotime($_POST['tanggal_awal']));
	$tgl_akhir		= date("Y-m-d",strtotime($_POST['tanggal_akhir']));

	$sql = ("SELECT  fh.tgl_buat, fh.kode_fb, fh.ref, s.nama AS nama_supplier, c.nama AS nama_cabang, SUM(fd.harga) AS harga, fh.keterangan_hdr, fh.status FROM fb_hdr fh
							LEFT JOIN cabang c ON c.kode_cabang = fh.kode_cabang
							LEFT JOIN supplier s ON s.kode_supplier = fh.kode_supplier
							LEFT JOIN fb_dtl fd ON fd.kode_fb = fh.kode_fb
							WHERE fh.kode_fb LIKE '%".$kode_fb."%' AND
								fh.ref LIKE '%".$ref."%' AND
								fd.harga LIKE '%".$harga."%' AND
								c.kode_cabang LIKE '%".$cabang."%' AND
								s.kode_supplier LIKE '%".$supplier."%' AND
								fh.tgl_buat BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."'
							GROUP BY fh.kode_fb
							ORDER BY id_fb_hdr ASC");

	$q_fb = mysql_query($sql)	;
	// echo $sql;
}

//REFRESH LIST
if(isset($_POST['refresh'])){
	//CLASS FORM SAAT KLIK TOMBOL REFRESH
	$class_tab='class="active"';
	$class_pane_tab='class="tab-pane in active"';
	$class_form="";
	$class_pane_form='class="tab-pane"';

	$_POST['kode_fb'] 	= "" ;
	$_POST['ref']		= "" ;
	$_POST['nominal']	= "" ;
	$_POST['cabang']	= "" ;
	$_POST['supplier']	= "" ;
}

// TRACK
if(isset($_GET['action']) and $_GET['action'] == "track") {

	$kode_fb = ($_GET['kode_fb']);

	$id_fb_hdr = mysql_query("SELECT id_fb_hdr FROM fb_hdr WHERE kode_fb = '".$kode_fb."'");
	$id = mysql_fetch_array($id_fb_hdr);

	$q_fb_prev = mysql_query("SELECT id_fb_hdr, kode_fb FROM fb_hdr WHERE id_fb_hdr = (select max(id_fb_hdr) FROM fb_hdr WHERE id_fb_hdr < ".$id['id_fb_hdr'].")");

	$q_fb_next = mysql_query("SELECT id_fb_hdr, kode_fb FROM fb_hdr WHERE id_fb_hdr = (select min(id_fb_hdr) FROM fb_hdr WHERE id_fb_hdr > ".$id['id_fb_hdr'].")");

	$status = mysql_query("SELECT kode_fb, status from fb_hdr WHERE kode_fb = '".$kode_fb."' ");

	$jurnal = mysql_query("SELECT a.kode_coa, a.debet, a.kredit, b.nama nama_coa FROM jurnal a LEFT JOIN coa b on a.kode_coa=b.kode_coa where kode_transaksi = '".$kode_fb."' AND status_jurnal = '0' ORDER BY a.tgl_input, a.debet, a.kredit, a.kode_coa, b.nama ASC");

	$q_fb_hdr = mysql_query("SELECT fh.kode_fb, fh.kode_supplier, s.nama AS nama_supplier, fh.ref, fh.tgl_jth_tempo, fh.tgl_buat, fh.kode_cabang, c.nama AS nama_cabang, fh.keterangan_hdr, fh.status FROM fb_hdr fh
								LEFT JOIN cabang c ON c.kode_cabang = fh.kode_cabang
								LEFT JOIN supplier s ON s.kode_supplier = fh.kode_supplier
								WHERE fh.kode_fb = '".$kode_fb."' ");

	$q_fb_dtl = mysql_query("SELECT *, SUBSTRING_INDEX(`kode_barang`, ':', -1) AS `nama_barang` FROM fb_dtl WHERE kode_fb='".$kode_fb."' order by kode_btb ASC");

	$q_fb_dtl1 = mysql_query("SELECT SUM(harga) AS total_harga, SUM(nilai_ppn)  AS total_ppn, SUM(subtot) AS grand_total FROM fb_dtl WHERE kode_fb = '".$kode_fb."'");

}

?>
