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

//DROPDOWN SUPPLIER FORM
$q_supplier 		= mysql_query("SELECT kode_supplier,nama AS nama_supplier FROM supplier WHERE aktif='1' ORDER BY kode_supplier ASC");

//DROPDOWN COA FORM DETAIL
$q_coa 				= mysql_query("SELECT kode_coa, nama nama_coa FROM coa where level_coa = '4' order by kode_coa  ASC");

//DROPDOWN CABANG LIST
$q_cabang_list 		= mysql_query("SELECT kode_cabang,nama AS nama_cabang FROM cabang WHERE aktif='1' ORDER BY kode_cabang ASC");

//DROPDOWN SUPPLIER LIST
$q_supplier_list	= mysql_query("SELECT kode_supplier,nama AS nama_supplier FROM supplier WHERE aktif='1' ORDER BY kode_supplier ASC");

//DROPDOWN COA LIST
$q_coa_list 		= mysql_query("SELECT kode_coa, nama nama_coa FROM coa order by kode_coa ASC");

//LIST GIRO MASUK
$q_gk = mysql_query("SELECT gh.kode_gk, gh.kode_supplier, p.nama nama_supplier, gh.tgl_buat, gd.tgl_jatuh_tempo, pg.nominal, gh.status FROM gk_hdr gh
						LEFT JOIN gk_dtl gd ON gd.kode_gk = gh.kode_gk
						LEFT JOIN supplier p ON p.kode_supplier = gh.kode_supplier
						LEFT JOIN payment_giro pg ON pg.kode_giro = gh.kode_gk
						GROUP BY gh.kode_gk
						ORDER BY id_gk_hdr ASC");

//LIST PENCARIAN
if(isset($_POST['cari'])){

	//CLASS FORM SAAT KLIK TOMBOL CARI
	$class_tab 		='class="active"';
	$class_pane_tab ='class="tab-pane in active"';
	$class_form 	="";
	$class_pane_form='class="tab-pane"';

	$kode_gk		= $_POST['kode_gk'];
	$ref			= $_POST['ref'];
	$kode_coa 		= $_POST['kode_coa'];
	$supplier 		= $_POST['supplier'];
	$cabang 		= $_POST['cabang'];
	$tgl_awal		= date("Y-m-d",strtotime($_POST['tanggal_awal']));
	$tgl_akhir		= date("Y-m-d",strtotime($_POST['tanggal_akhir']));

	if( $_POST['status'] == '1'){
		$status = '1';
	}else{
		$status = '0';
	}

	$sql = ("SELECT gh.kode_gk, gh.kode_supplier, p.nama nama_supplier, gh.tgl_buat, gd.tgl_jatuh_tempo, pg.nominal, gh.status FROM gk_hdr gh
			LEFT JOIN gk_dtl gd ON gd.kode_gk = gh.kode_gk
			LEFT JOIN supplier p ON p.kode_supplier = gh.kode_supplier
			LEFT JOIN payment_giro pg ON pg.kode_giro = gh.kode_gk
			WHERE gh.kode_gk LIKE '%".$kode_gk."%' AND
			gh.ref LIKE '%".$ref."%' AND
			gh.bank_coa LIKE '%".$kode_coa."%' AND
			gh.kode_cabang LIKE '%".$cabang."%' AND
			gh.kode_supplier LIKE '%".$supplier."%' AND
			gh.status LIKE '%".$status."%' AND
			gh.tgl_buat BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."'
			GROUP BY gh.kode_gk
			ORDER BY id_gk_hdr ASC");
	$q_gk = mysql_query($sql)	;
}

//REFRESH LIST
if(isset($_POST['refresh'])){
	//CLASS FORM SAAT KLIK TOMBOL REFRESH
	$class_tab='class="active"';
	$class_pane_tab='class="tab-pane in active"';
	$class_form="";
	$class_pane_form='class="tab-pane"';

	$_POST['kode_gk'] 	= "" ;
	$_POST['ref'] 		= "" ;
	$_POST['kode_coa'] 	= "" ;
	$_POST['cabang'] 	= "" ;
	$_POST['supplier'] 	= "" ;
	$_POST['status']	= "" ;
}

// TRACK
if(isset($_GET['action']) and $_GET['action'] == "track") {

	$kode_gk = ($_GET['kode_gk']);

	$id_gk_hdr = mysql_query("SELECT id_gk_hdr FROM gk_hdr WHERE kode_gk = '".$kode_gk."'");
	$id = mysql_fetch_array($id_gk_hdr);

	$q_gk_prev = mysql_query("SELECT id_gk_hdr, kode_gk FROM gk_hdr WHERE id_gk_hdr = (select max(id_gk_hdr) FROM gk_hdr WHERE id_gk_hdr < ".$id['id_gk_hdr'].")");

	$q_gk_next = mysql_query("SELECT id_gk_hdr, kode_gk FROM gk_hdr WHERE id_gk_hdr = (select min(id_gk_hdr) FROM gk_hdr WHERE id_gk_hdr > ".$id['id_gk_hdr'].")");

	$jurnal = mysql_query("SELECT a.kode_coa, a.debet, a.kredit, b.nama nama_coa FROM jurnal a INNER JOIN coa b on a.kode_coa=b.kode_coa where kode_transaksi = '".$kode_gk."' AND status_jurnal = '0' ORDER BY a.tgl_input, a.debet, a.kredit, a.kode_coa, b.nama ASC");

	$status = mysql_query("SELECT kode_gk, status from gk_hdr WHERE kode_gk = '".$kode_gk."' ");

	$q_gk_hdr = mysql_query("SELECT kode_gk, ref, gh.kode_cabang, c.nama nama_cabang, gh.kode_supplier, p.nama nama_supplier, gh.tgl_buat, gh.selisih, gh.kode_coa_selisih, gh.keterangan_hdr, gh.status FROM gk_hdr gh
							LEFT JOIN cabang c ON c.kode_cabang = gh.kode_cabang
							LEFT JOIN supplier p ON p.kode_supplier = gh.kode_supplier
							WHERE gh.kode_gk = '".$kode_gk."' ");

	$q_gk_dtl = mysql_query("SELECT * FROM gk_dtl WHERE kode_gk ='".$kode_gk."' ");

	$q_giro 	= mysql_query("SELECT * FROM payment_giro WHERE kode_giro ='".$kode_gk."' ");

}

//PENGEMBALIAN
if(isset($_GET['action']) and $_GET['action'] == "pengembalian") {

	$kode_gk = ($_GET['kode_gk']);

	$id_gk_hdr = mysql_query("SELECT id_gk_hdr FROM gk_hdr WHERE kode_gk = '".$kode_gk."'");
	$id = mysql_fetch_array($id_gk_hdr);

	$gk_hdr_back = mysql_query("SELECT kode_gk, ref, gh.kode_cabang, c.nama nama_cabang, gh.kode_supplier, p.nama nama_supplier, gh.tgl_buat,  selisih, kode_coa_selisih, gh.keterangan_hdr, gh.status FROM gk_hdr gh
							LEFT JOIN cabang c ON c.kode_cabang = gh.kode_cabang
							LEFT JOIN supplier p ON p.kode_supplier = gh.kode_supplier
							WHERE gh.kode_gk = '".$kode_gk."' ");

	$gk_dtl_back = mysql_query("SELECT * FROM gk_dtl WHERE kode_gk ='".$kode_gk."' ");

	$array_dtl_back = array();
		if(mysql_num_rows($gk_dtl_back) > 0) {
			while ($res = mysql_fetch_array($gk_dtl_back)) {
					$array_dtl_back[] = $res;

			}
		}

	$_SESSION['data_dtl_back'] = $array_dtl_back;
}

?>
