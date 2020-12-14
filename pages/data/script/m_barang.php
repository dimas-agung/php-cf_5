<?php

//CLASS FORM AWAL
$class_form         = 'class="active"';
$class_pane_form    = 'class="tab-pane in active"';
$class_tab             = "";
$class_tab1         = "";
$class_tab2         = "";
$class_pane_tab     = 'class="tab-pane"';
$class_pane_tab1     = 'class="tab-pane"';
$class_pane_tab2     = 'class="tab-pane"';

$q_ddl_kat_inv         = mysql_query("SELECT kode_kategori_inventori, nama FROM kategori_inventori WHERE aktif='1' ORDER BY nama ASC");
$q_ddl_satuan_beli     = mysql_query("SELECT kode_satuan, nama FROM satuan WHERE aktif='1' ORDER BY nama ASC");
$q_ddl_satuan_jual     = mysql_query("SELECT kode_satuan, nama FROM satuan WHERE aktif='1' ORDER BY nama ASC");

// HARGA $ DISKON //
$q_inv_hrg_diskon     = mysql_query("SELECT kode_kategori_pelanggan, nama FROM kategori_pelanggan WHERE aktif='1' ORDER BY kode_kategori_pelanggan ASC");

// BOM //
$q_satuan_hdr = mysql_query("SELECT kode_satuan, nama nama_satuan FROM satuan where aktif='1' ORDER BY nama ASC");
$q_barang_dtl = mysql_query("SELECT kode_inventori, nama FROM inventori where aktif='1' AND kategori!='BS' ORDER BY nama ASC");
$q_satuan_dtl = mysql_query("SELECT kode_satuan, nama nama_satuan FROM satuan where aktif='1' ORDER BY nama ASC");

// ACCOUNTING //
$q_ddl_coa      = mysql_query("SELECT kode_coa, nama FROM coa WHERE level_coa='4' AND aktif='1' ORDER BY kode_coa ASC ");
$q_ddl_coa2  = mysql_query("SELECT kode_coa, nama FROM coa WHERE level_coa='4' AND aktif='1' ORDER BY kode_coa ASC ");
$q_ddl_coa3     = mysql_query("SELECT kode_coa, nama FROM coa WHERE level_coa='4' AND aktif='1' ORDER BY kode_coa ASC ");
$q_ddl_coa4  = mysql_query("SELECT kode_coa, nama FROM coa WHERE level_coa='4' AND aktif='1' ORDER BY kode_coa ASC ");
$q_ddl_coa5  = mysql_query("SELECT kode_coa, nama FROM coa WHERE level_coa='4' AND aktif='1' ORDER BY kode_coa ASC ");
$q_ddl_coa6  = mysql_query("SELECT kode_coa, nama FROM coa WHERE level_coa='4' AND aktif='1' ORDER BY kode_coa ASC ");
$q_ddl_coa7  = mysql_query("SELECT kode_coa, nama FROM coa WHERE level_coa='4' AND aktif='1' ORDER BY kode_coa ASC ");
$q_ddl_coa8  = mysql_query("SELECT kode_coa, nama FROM coa WHERE level_coa='4' AND aktif='1' ORDER BY kode_coa ASC ");
$q_ddl_coa9  = mysql_query("SELECT kode_coa, nama FROM coa WHERE level_coa='4' AND aktif='1' ORDER BY kode_coa ASC ");
$q_ddl_coa10 = mysql_query("SELECT kode_coa, nama FROM coa WHERE level_coa='4' AND aktif='1' ORDER BY kode_coa ASC ");
$q_ddl_coa11 = mysql_query("SELECT kode_coa, nama FROM coa WHERE level_coa='4' AND aktif='1' ORDER BY kode_coa ASC ");
$q_ddl_coa12 = mysql_query("SELECT kode_coa, nama FROM coa WHERE level_coa='4' AND aktif='1' ORDER BY kode_coa ASC ");

// LIST //
$q_inv = mysql_query("SELECT kode_inventori, nama, kategori, keterangan, aktif FROM inventori ORDER BY id_inventori ASC");

// UBAH PENCARIAN BERDASAR STATUS DI DB
if (isset($_POST['status'])) {
    if ($_POST['status'] == 'y') {
        $status = '1';
    } else if ($_POST['status'] == 'n') {
        $status = '0';
    }
}

// BOM //
$q_satuan_hdr = mysql_query("SELECT kode_satuan, nama nama_satuan FROM satuan where aktif='1' ORDER BY nama ASC");
$q_satuan_dtl = mysql_query("SELECT kode_satuan, nama nama_satuan FROM satuan where aktif='1' ORDER BY nama ASC");
$q_barang_dtl = mysql_query("SELECT kode_inventori, nama FROM inventori where aktif='1' AND kategori!='BS' ORDER BY nama ASC");

// END BOM //

// Saat klik tombol cari
if (isset($_POST['cari'])) {
    //CLASS FORM SAAT KLIK TOMBOL CARI
    $class_tab = 'class="active"';
    $class_pane_tab = 'class="tab-pane in active"';
    $class_form = "";
    $class_pane_form = 'class="tab-pane"';

    if (($_POST['status'] == 'y' or $_POST['status'] == 'n')) {
        $q_inv = mysql_query("SELECT kode_inventori, nama, kategori, keterangan, aktif FROM inventori WHERE aktif='" . $status . "' ORDER BY id_inventori ASC");
    } else {
        $q_inv = mysql_query("SELECT kode_inventori, nama, kategori, keterangan, aktif FROM inventori ORDER BY id_inventori ASC");
    }
} else {
    $q_inv = mysql_query("SELECT kode_inventori, nama, kategori, keterangan, aktif FROM inventori ORDER BY id_inventori ASC");
}

// Update ke database
if (isset($_GET['action']) and $_GET['action'] == "edit") {
    $kode_inventori = mres($_GET['kode_inventori']);

    $q_edit_inv = mysql_query("SELECT * FROM inventori WHERE kode_inventori = '" . $kode_inventori . "'");

    $q_id_form_bom = mysql_query("SELECT id_form FROM bom WHERE kode_inventori = '" . $kode_inventori . "'");
    $id_form = mysql_fetch_array($q_id_form_bom);

    $q_bom_edit = mysql_query("INSERT INTO bom_tmp (id_bom_dtl, kode_barang_dtl, satuan_dtl, qty_satuan_dtl, keterangan_dtl, id_form)
							SELECT id_bom, kode_barang_dtl, satuan_dtl, qty_dtl, keterangan_dtl, '" . $id_form['id_form'] . "' FROM bom
							WHERE kode_inventori = '" . $kode_inventori . "' ");

    $q_bom_edit1 = mysql_query("SELECT * FROM bom_tmp WHERE id_form = '" . $id_form['id_form'] . "' ");

    $q_inv_hrg_diskon = mysql_query("SELECT id_harga_inventori,inv.kode_inventori,inv.nama item,harga,diskon, hrg.kode_kategori_pelanggan,kat.nama pelanggan,'asli' asli FROM harga_inventori hrg INNER JOIN inventori inv ON inv.kode_inventori=hrg.kode_inventori INNER JOIN kategori_pelanggan kat ON hrg.kode_kategori_pelanggan=kat.kode_kategori_pelanggan WHERE inv.kode_inventori='" . $kode_inventori . "'
										UNION SELECT '' id_harga_inventori,(SELECT kode_inventori FROM inventori WHERE kode_inventori='" . $kode_inventori . "') kode_inventori,(SELECT nama FROM inventori WHERE kode_inventori='" . $kode_inventori . "') nama, 0 harga, 0 diskon, kode_kategori_pelanggan, nama, 'palsu' FROM kategori_pelanggan WHERE kode_kategori_pelanggan NOT IN (SELECT kat.kode_kategori_pelanggan FROM harga_inventori hrg LEFT JOIN kategori_pelanggan kat ON hrg.kode_kategori_pelanggan=kat.kode_kategori_pelanggan WHERE kode_inventori='" . $kode_inventori . "')
                                        ORDER BY kode_kategori_pelanggan ASC");
    $q_inv_hrg_diskon_x = "SELECT id_harga_inventori,inv.kode_inventori,inv.nama item,harga,diskon, hrg.kode_kategori_pelanggan,kat.nama pelanggan,'asli' asli FROM harga_inventori hrg INNER JOIN inventori inv ON inv.kode_inventori=hrg.kode_inventori INNER JOIN kategori_pelanggan kat ON hrg.kode_kategori_pelanggan=kat.kode_kategori_pelanggan WHERE inv.kode_inventori='" . $kode_inventori . "'
    UNION SELECT '' id_harga_inventori,(SELECT kode_inventori FROM inventori WHERE kode_inventori='" . $kode_inventori . "') kode_inventori,(SELECT nama FROM inventori WHERE kode_inventori='" . $kode_inventori . "') nama, 0 harga, 0 diskon, kode_kategori_pelanggan, nama, 'palsu' FROM kategori_pelanggan WHERE kode_kategori_pelanggan NOT IN (SELECT kat.kode_kategori_pelanggan FROM harga_inventori hrg LEFT JOIN kategori_pelanggan kat ON hrg.kode_kategori_pelanggan=kat.kode_kategori_pelanggan WHERE kode_inventori='" . $kode_inventori . "')
    ORDER BY kode_kategori_pelanggan ASC";

    if (isset($_POST['jenis_stok'])) {
        $jenis_stok_stat = '1';
    } else {
        $jenis_stok_stat = '0';
    }
}

// NON AKTIF DAN AKTIFKAN STATUS
if (isset($_GET['action']) and $_GET['action'] == "nonaktif") {
    $id_inventori = mres($_GET['kode_inventori']);

    $sql = "UPDATE inventori SET aktif = '0' WHERE kode_inventori = '" . $id_inventori . "'";
    $query = mysql_query($sql);

    echo ("<script>location.href = '" . base_url() . "?page=master/barang';</script>");
} else if (isset($_GET['action']) and $_GET['action'] == "aktif") {
    $id_inventori = mres($_GET['kode_inventori']);

    $sql = "UPDATE inventori SET aktif = '1' WHERE kode_inventori = '" . $id_inventori . "'";
    $query = mysql_query($sql);

    echo ("<script>location.href = '" . base_url() . "?page=master/barang';</script>");
}

// TRACK
if (isset($_GET['action']) and $_GET['action'] == "track") {
    $kode_inventori = ($_GET['kode_inventori']);

    $id_inv = mysql_query("SELECT id_inventori FROM inventori WHERE kode_inventori = '" . $kode_inventori . "'");
    $id = mysql_fetch_array($id_inv);

    $q_inv_prev = mysql_query("SELECT id_inventori, kode_inventori FROM inventori WHERE id_inventori = (select max(id_inventori) FROM inventori WHERE id_inventori < " . $id['id_inventori'] . ")");


    $q_inv_next = mysql_query("SELECT id_inventori, kode_inventori FROM inventori WHERE id_inventori = (select min(id_inventori) FROM inventori WHERE id_inventori > " . $id['id_inventori'] . ")");

    $q_inv = mysql_query("SELECT * FROM inventori WHERE kode_inventori = '" . $kode_inventori . "'");

    $q_bom = mysql_query("SELECT * from bom WHERE kode_inventori = '" . $kode_inventori . "'");

    $q_inv_hrg_diskon = mysql_query("SELECT hi.*, kp.nama kat_pelanggan FROM harga_inventori hi
										INNER JOIN inventori inv ON hi.kode_inventori = inv.kode_inventori
										INNER JOIN kategori_pelanggan kp ON kp.kode_kategori_pelanggan=hi.kode_kategori_pelanggan
										WHERE inv.kode_inventori='" . $kode_inventori . "' GROUP BY kode_kategori_pelanggan ORDER BY kode_kategori_pelanggan ASC");
}
