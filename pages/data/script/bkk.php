<?php

$q_close 	= mysql_query("SELECT DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%m') AS `month`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y') AS `year`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y-%m') AS `fulltext` FROM `close`");

//CLASS FORM AWAL
$class_form         = 'class="active"';
$class_pane_form    = 'class="tab-pane in active"';
$class_tab             = "";
$class_pane_tab     = 'class="tab-pane"';


//DROPDOWN SUPPLIER FORM
$q_supplier         = mysql_query("SELECT kode_supplier,nama AS nama_supplier FROM supplier WHERE aktif='1' ORDER BY kode_supplier ASC");

//DROPDOWN DOC OP dan FB FORM
$q_doc                 = mysql_query("SELECT kode_fb kode FROM fb_hdr UNION SELECT kode_op kode FROM op_hdr ");

//DROPDOWN METODE PEMBAYARAN FORM
$q_pembayaran     = mysql_query("SELECT kode_coa, nama nama_coa, LEFT(nama, 3) singkatan FROM coa c WHERE (kode_coa LIKE '1.01.01.%' OR kode_coa LIKE '110101.%') AND level_coa = '4' UNION SELECT kode_coa, nama nama_coa, LEFT(nama, 3) singkatan FROM coa WHERE (kode_coa LIKE '1.01.02.%' OR kode_coa LIKE '110102.%') AND level_coa = '4' ORDER BY kode_coa ASC ");

//DROPDOWN CABANG FORM
$q_cabang             = mysql_query("SELECT kode_cabang,nama AS nama_cabang FROM cabang WHERE aktif='1' ORDER BY kode_cabang ASC");

//DROPDOWN COA FORM DETAIL
$q_coa                 = mysql_query("SELECT kode_coa, nama nama_coa FROM coa WHERE aktif='1' AND level_coa = '4' order by kode_coa ASC");

//DROPDOWN COA EDIT
$q_coa_edit         = mysql_query("SELECT kode_coa, nama nama_coa FROM coa order by kode_coa ASC");

//DROPDOWN CABANG LIST
$q_cabang_list         = mysql_query("SELECT kode_cabang,nama AS nama_cabang FROM cabang WHERE aktif='1' ORDER BY kode_cabang ASC");

//DROPDOWN SUPPLIER LIST
$q_supplier_list    = mysql_query("SELECT kode_supplier,nama AS nama_supplier FROM supplier WHERE aktif='1' ORDER BY nama_supplier ASC");

//DROPDOWN COA LIST
$q_coa_list         = mysql_query("SELECT kode_coa, nama nama_coa FROM coa WHERE aktif='1' AND level_coa = '4' order by nama_coa ASC");

//LIST BKK
$q_bkk = mysql_query("SELECT bh.*, c.nama nama_cabang, s.nama nama_supplier, o.nama nama_coa FROM bkk_hdr bh
						LEFT JOIN bkk_dtl bd ON bd.kode_bkk = bh.kode_bkk
						LEFT JOIN cabang c ON c.kode_cabang = bh.kode_cabang
						LEFT JOIN supplier s ON s.kode_supplier = bh.kode_supplier
						LEFT JOIN coa o ON o.kode_coa = bh.rekening
						GROUP BY bh.kode_bkk
						ORDER BY id_bkk_hdr ASC");

//LIST PENCARIAN
if (isset($_POST['cari'])) {

    //CLASS FORM SAAT KLIK TOMBOL CARI
    $class_tab = 'class="active"';
    $class_pane_tab = 'class="tab-pane in active"';
    $class_form = "";
    $class_pane_form = 'class="tab-pane"';

    $kode_bkk        = $_POST['kode_bkk'];
    $ref            = $_POST['ref'];
    $kode_coa         = $_POST['kode_coa'];
    $cabang         = $_POST['cabang'];
    $supplier         = $_POST['supplier'];
    $tgl_awal        = date("Y-m-d", strtotime($_POST['tanggal_awal']));
    $tgl_akhir        = date("Y-m-d", strtotime($_POST['tanggal_akhir']));

    if ($_POST['status'] == '1') {
        $status = '1';
    } else {
        $status = '0';
    }

    $sql = ("SELECT bh.*, c.nama nama_cabang, s.nama nama_supplier, bd.nominal_bayar, o.nama nama_coa FROM bkk_hdr bh
						LEFT JOIN bkk_dtl bd ON bd.kode_bkk = bh.kode_bkk
						LEFT JOIN cabang c ON c.kode_cabang = bh.kode_cabang
						LEFT JOIN supplier s ON s.kode_supplier = bh.kode_supplier
						LEFT JOIN coa o ON o.kode_coa = bh.rekening
							WHERE bh.kode_bkk LIKE '%" . $kode_bkk . "%' AND
								bh.ref LIKE '%" . $ref . "%' AND
								bh.rekening LIKE '%" . $kode_coa . "%' AND
								c.kode_cabang LIKE '%" . $cabang . "%' AND
								bh.kode_supplier LIKE '%" . $supplier . "%' AND
								bh.status LIKE '%" . $status . "%' AND
								bh.tgl_buat BETWEEN '" . $tgl_awal . "' AND '" . $tgl_akhir . "'
							ORDER BY id_bkk_hdr ASC");

    $q_bkk = mysql_query($sql);
    // echo $sql;
}

//REFRESH LIST
if (isset($_POST['refresh'])) {
    //CLASS FORM SAAT KLIK TOMBOL REFRESH
    $class_tab = 'class="active"';
    $class_pane_tab = 'class="tab-pane in active"';
    $class_form = "";
    $class_pane_form = 'class="tab-pane"';

    $_POST['kode_bkk']     = "";
    $_POST['ref']         = "";
    $_POST['kode_coa']     = "";
    $_POST['cabang']     = "";
    $_POST['supplier']     = "";
    $_POST['status']    = "";
}

// TRACK
if (isset($_GET['action']) and $_GET['action'] == "track") {

    $kode_bkk = ($_GET['kode_bkk']);

    $id_bkk_hdr = mysql_query("SELECT id_bkk_hdr FROM bkk_hdr WHERE kode_bkk = '" . $kode_bkk . "'");
    $id = mysql_fetch_array($id_bkk_hdr);

    $q_bkk_prev = mysql_query("SELECT id_bkk_hdr, kode_bkk FROM bkk_hdr WHERE id_bkk_hdr = (select max(id_bkk_hdr) FROM bkk_hdr WHERE id_bkk_hdr < " . $id['id_bkk_hdr'] . ")");

    $q_bkk_next = mysql_query("SELECT id_bkk_hdr, kode_bkk FROM bkk_hdr WHERE id_bkk_hdr = (select min(id_bkk_hdr) FROM bkk_hdr WHERE id_bkk_hdr > " . $id['id_bkk_hdr'] . ")");
	
	$status = mysql_query("SELECT kode_bkk, status from bkk_hdr WHERE kode_bkk = '".$kode_bkk."' ");

    $jurnal = mysql_query("SELECT a.kode_coa, a.debet, a.kredit, b.nama nama_coa FROM jurnal a LEFT JOIN coa b on a.kode_coa = b.kode_coa WHERE kode_transaksi = '" . $kode_bkk . "' AND status_jurnal != '1' ORDER BY a.tgl_input, a.debet, a.kredit, a.kode_coa, b.nama ASC");

    $q_bkk_hdr = mysql_query("SELECT bh.*, c.nama nama_cabang, s.nama nama_supplier, o.nama nama_coa FROM bkk_hdr bh
							LEFT JOIN cabang c ON c.kode_cabang = bh.kode_cabang
							LEFT JOIN supplier s ON s.kode_supplier = bh.kode_supplier
							LEFT JOIN coa o ON o.kode_coa = bh.rekening
							WHERE bh.kode_bkk = '" . $kode_bkk . "' ");

    $q_bkk_dtl = mysql_query("SELECT bd.*, o.nama nama_coa FROM bkk_dtl bd
							 LEFT JOIN coa o ON o.kode_coa = bd.kode_coa
							 WHERE bd.kode_bkk ='" . $kode_bkk . "' ");
}
