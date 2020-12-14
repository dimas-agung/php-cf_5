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
$q_pembayaran 	= mysql_query("SELECT kode_coa, nama nama_coa, LEFT(kode_coa, 7) singkatan FROM coa c WHERE kode_coa LIKE '1.01.01.0%' AND SUBSTRING(kode_coa, -1) >= 1
								UNION
								(SELECT kode_coa, nama nama_coa, LEFT(kode_coa, 7) singkatan FROM coa WHERE kode_coa LIKE '1.01.02.0%' AND SUBSTRING(kode_coa, -1) >= 1)
								ORDER BY kode_coa ASC ");

//DROPDOWN PELANGGAN FORM
$q_pelanggan 		= mysql_query("SELECT kode_pelanggan,nama AS nama_pelanggan FROM pelanggan WHERE aktif='1' ORDER BY kode_pelanggan ASC");

//DROPDOWN COA FORM DETAIL
$q_coa 				= mysql_query("SELECT kode_coa, nama nama_coa FROM coa where level_coa = '4' order by kode_coa  ASC");

//DROPDOWN CABANG LIST
$q_cabang_list 		= mysql_query("SELECT kode_cabang,nama AS nama_cabang FROM cabang WHERE aktif='1' ORDER BY kode_cabang ASC");

//DROPDOWN PELANGGAN LIST
$q_pelanggan_list	= mysql_query("SELECT kode_pelanggan,nama AS nama_pelanggan FROM pelanggan WHERE aktif='1' ORDER BY kode_pelanggan ASC");

//DROPDOWN COA LIST
$q_coa_list 		= mysql_query("SELECT kode_coa, nama nama_coa FROM coa order by kode_coa ASC");

//LIST GIRO MASUK
$q_gm = mysql_query("SELECT gh.kode_gm, gh.kode_pelanggan, p.nama nama_pelanggan, gh.tgl_buat, gd.tgl_jatuh_tempo, SUM(pg.nominal) nominal, gh.status FROM gm_hdr gh
						LEFT JOIN gm_dtl gd ON gd.kode_gm = gh.kode_gm
						LEFT JOIN payment_giro pg ON pg.kode_giro = gh.kode_gm
						LEFT JOIN pelanggan p ON p.kode_pelanggan = gh.kode_pelanggan
						GROUP BY gh.kode_gm
						ORDER BY id_gm_hdr ASC");

//LIST PENCARIAN
if(isset($_POST['cari'])){

	//CLASS FORM SAAT KLIK TOMBOL CARI
	$class_tab 		='class="active"';
	$class_pane_tab ='class="tab-pane in active"';
	$class_form 	="";
	$class_pane_form='class="tab-pane"';

	$kode_gm		= $_POST['kode_gm'];
	$ref			= $_POST['ref'];
	$kode_coa 		= $_POST['kode_coa'];
	$pelanggan 		= $_POST['pelanggan'];
	$cabang 		= $_POST['cabang'];
	$tgl_awal		= date("Y-m-d",strtotime($_POST['tanggal_awal']));
	$tgl_akhir		= date("Y-m-d",strtotime($_POST['tanggal_akhir']));

	if( $_POST['status'] == '1'){
		$status = '1';
	}else{
		$status = '0';
	}

	$sql = ("SELECT gh.kode_gm, gh.kode_pelanggan, p.nama nama_pelanggan, gh.tgl_buat, gd.tgl_jatuh_tempo, SUM(pg.nominal) nominal, gh.status FROM gm_hdr gh
			LEFT JOIN gm_dtl gd ON gd.kode_gm = gh.kode_gm
			LEFT JOIN payment_giro pg ON pg.kode_giro = gh.kode_gm
			LEFT JOIN pelanggan p ON p.kode_pelanggan = gh.kode_pelanggan
			WHERE gh.kode_gm LIKE '%".$kode_gm."%' AND
			gh.ref LIKE '%".$ref."%' AND
			gh.bank_coa LIKE '%".$kode_coa."%' AND
			gh.kode_cabang LIKE '%".$cabang."%' AND
			gh.kode_pelanggan LIKE '%".$pelanggan."%' AND
			gh.status LIKE '%".$status."%' AND
			gh.tgl_buat BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."'
			GROUP BY gh.kode_gm
			ORDER BY id_gm_hdr ASC");
	$q_gm = mysql_query($sql)	;
}

//REFRESH LIST
if(isset($_POST['refresh'])){
	//CLASS FORM SAAT KLIK TOMBOL REFRESH
	$class_tab='class="active"';
	$class_pane_tab='class="tab-pane in active"';
	$class_form="";
	$class_pane_form='class="tab-pane"';

	$_POST['kode_gm'] 	= "" ;
	$_POST['ref'] 		= "" ;
	$_POST['kode_coa'] 	= "" ;
	$_POST['cabang'] 	= "" ;
	$_POST['pelanggan'] 	= "" ;
	$_POST['status']	= "" ;
}

// TRACK
if(isset($_GET['action']) and $_GET['action'] == "track") {

	$kode_gm = ($_GET['kode_gm']);

	$id_gm_hdr = mysql_query("SELECT id_gm_hdr FROM gm_hdr WHERE kode_gm = '".$kode_gm."'");
	$id = mysql_fetch_array($id_gm_hdr);

	$q_gm_prev = mysql_query("SELECT id_gm_hdr, kode_gm FROM gm_hdr WHERE id_gm_hdr = (select max(id_gm_hdr) FROM gm_hdr WHERE id_gm_hdr < ".$id['id_gm_hdr'].")");

	$q_gm_next = mysql_query("SELECT id_gm_hdr, kode_gm FROM gm_hdr WHERE id_gm_hdr = (select min(id_gm_hdr) FROM gm_hdr WHERE id_gm_hdr > ".$id['id_gm_hdr'].")");

	$status = mysql_query("SELECT kode_gm, status from gm_hdr WHERE kode_gm = '".$kode_gm."' ");

	$jurnal = mysql_query("SELECT a.kode_coa, a.debet, a.kredit, b.nama nama_coa FROM jurnal a LEFT JOIN coa b on a.kode_coa=b.kode_coa where kode_transaksi = '".$kode_gm."' AND status_jurnal = '0' ORDER BY a.tgl_input, a.debet, a.kredit, a.kode_coa, b.nama ASC");

	$q_gm_hdr = mysql_query("SELECT kode_gm, ref, gh.kode_cabang, c.nama nama_cabang, gh.kode_pelanggan, p.nama nama_pelanggan, gh.tgl_buat, gh.selisih, gh.kode_coa_selisih, gh.keterangan_hdr, gh.status FROM gm_hdr gh
							LEFT JOIN cabang c ON c.kode_cabang = gh.kode_cabang
							LEFT JOIN pelanggan p ON p.kode_pelanggan = gh.kode_pelanggan
							WHERE gh.kode_gm = '".$kode_gm."'");

	$q_gm_dtl 	= mysql_query("SELECT * FROM gm_dtl WHERE kode_gm ='".$kode_gm."'");
	$q_giro 	= mysql_query("SELECT * FROM payment_giro WHERE kode_giro ='".$kode_gm."'");
}

//PENGEMBALIAN
if(isset($_GET['action']) and $_GET['action'] == "pengembalian") {

	$kode_gm = ($_GET['kode_gm']);

	$gm_hdr_back = mysql_query("SELECT kode_gm, ref, gh.kode_cabang, c.nama nama_cabang, gh.kode_pelanggan, p.nama nama_pelanggan, gh.tgl_buat, gh.selisih, gh.kode_coa_selisih, gh.keterangan_hdr, gh.status FROM gm_hdr gh
							LEFT JOIN cabang c ON c.kode_cabang = gh.kode_cabang
							LEFT JOIN pelanggan p ON p.kode_pelanggan = gh.kode_pelanggan
							WHERE gh.kode_gm = '".$kode_gm."' ");

	$gm_dtl_back = mysql_query("SELECT * FROM gm_dtl gd WHERE gd.kode_gm ='".$kode_gm."' ");

	$array_dtl_back = array();
		if(mysql_num_rows($gm_dtl_back) > 0) {
			while ($res = mysql_fetch_array($gm_dtl_back)) {
					$array_dtl_back[] = $res;

			}
		}

	$_SESSION['data_dtl_back'] = $array_dtl_back;

}

?>
