<?php
session_start();
require('../library/conn.php');
require('../library/helper.php');
date_default_timezone_set("Asia/Jakarta");

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "loadkodecabang") {
    $kode_cabang    = $_POST['kode_cabang'];

    $query        = "SELECT kode_cabang FROM cabang WHERE kode_cabang='" . $kode_cabang . "' ";

    $result        = mysql_query($query);

    $num         = mysql_num_rows($result);

    if ($num > 0) {
        echo " <i class='fa fa-exclamation-triangle'></i> Kode Cabang Sudah Ada";
    }
}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "loadkodegudang") {
    $kode_gudang    = $_POST['kode_gudang'];

    $query        = "SELECT kode_gudang FROM gudang WHERE kode_gudang='" . $kode_gudang . "' ";

    $result        = mysql_query($query);

    $num         = mysql_num_rows($result);

    if ($num > 0) {
        echo " <i class='fa fa-exclamation-triangle'></i> Kode Gudang Sudah Ada";
    }
}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "loadkodecc") {
    $kode_cc    = $_POST['kode_cc'];

    $query        = "SELECT kode_cc FROM kategori_divisi WHERE kode_cc='" . $kode_cc . "' ";

    $result        = mysql_query($query);

    $num         = mysql_num_rows($result);

    if ($num > 0) {
        echo " <i class='fa fa-exclamation-triangle'></i> Kode Sudah Ada";
    }
}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "loadkodekat_coa") {
    $kode_kat_coa    = $_POST['kode_kat_coa'];

    $query        = "SELECT kode_kat_coa FROM kategori_coa WHERE kode_kat_coa='" . $kode_kat_coa . "' ";

    $result        = mysql_query($query);

    $num         = mysql_num_rows($result);

    if ($num > 0) {
        echo " <i class='fa fa-exclamation-triangle'></i> Kode Sudah Ada";
    }
}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "loadkodekat_cashflow") {
    $kode_kat_cashflow    = $_POST['kode_kat_cashflow'];

    $query        = "SELECT kode_kat_cashflow FROM kategori_cashflow WHERE kode_kat_cashflow='" . $kode_kat_cashflow . "' ";

    $result        = mysql_query($query);

    $num         = mysql_num_rows($result);

    if ($num > 0) {
        echo " <i class='fa fa-exclamation-triangle'></i> Kode Sudah Ada";
    }
}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "loadkodekat_aset") {
    $kode_kat_aset    = $_POST['kode_kat_aset'];

    $query        = "SELECT kode_kat_aset FROM kategori_aset WHERE kode_kat_aset='" . $kode_kat_aset . "' ";

    $result        = mysql_query($query);

    $num         = mysql_num_rows($result);

    if ($num > 0) {
        echo " <i class='fa fa-exclamation-triangle'></i> Kode Sudah Ada";
    }
}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "loadkodemst_aset") {
    $kode_mst_aset    = $_POST['kode_mst_aset'];

    $query        = "SELECT kode_mst_aset FROM mst_aset WHERE kode_mst_aset='" . $kode_mst_aset . "' ";

    $result        = mysql_query($query);

    $num         = mysql_num_rows($result);

    if ($num > 0) {
        echo " <i class='fa fa-exclamation-triangle'></i> Kode Sudah Ada";
    }
}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "loadkodekat_inv") {
    $kode_kategori_inv    = $_POST['kode_kategori_inv'];

    $query        = "SELECT kode_kategori_inventori FROM kategori_inventori WHERE kode_kategori_inventori='" . $kode_kategori_inv . "' ";

    $result        = mysql_query($query);

    $num         = mysql_num_rows($result);

    if ($num > 0) {
        echo " <i class='fa fa-exclamation-triangle'></i> Kode Sudah Ada";
    }
}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "loadkodekat_pelanggan") {
    $kode_kategori_pelanggan    = $_POST['kode_kategori_pelanggan'];

    $query        = "SELECT kode_kategori_pelanggan FROM kategori_pelanggan WHERE kode_kategori_pelanggan='" . $kode_kategori_pelanggan . "' ";

    $result        = mysql_query($query);

    $num         = mysql_num_rows($result);

    if ($num > 0) {
        echo " <i class='fa fa-exclamation-triangle'></i> Kode Sudah Ada";
    }
}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "loadkode_valas") {
    $kode_valas    = $_POST['kode_valas'];

    $query        = "SELECT kode_valas FROM valas WHERE kode_valas='" . $kode_valas . "' ";

    $result        = mysql_query($query);

    $num         = mysql_num_rows($result);

    if ($num > 0) {
        echo " <i class='fa fa-exclamation-triangle'></i> Kode Sudah Ada";
    }
}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "loadkode_satuan") {
    $kode_satuan    = $_POST['kode_satuan'];

    $query        = "SELECT kode_satuan FROM satuan WHERE kode_satuan='" . $kode_satuan . "' ";

    $result        = mysql_query($query);

    $num         = mysql_num_rows($result);

    if ($num > 0) {
        echo " <i class='fa fa-exclamation-triangle'></i> Kode Sudah Ada";
    }
}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "loadkode_karyawan") {
    $kode_karyawan    = $_POST['kode_karyawan'];

    $query        = "SELECT kode_karyawan FROM karyawan WHERE kode_karyawan='" . $kode_karyawan . "' ";

    $result        = mysql_query($query);

    $num         = mysql_num_rows($result);

    if ($num > 0) {
        echo " <i class='fa fa-exclamation-triangle'></i> Kode Sudah Ada";
    }
}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "loadkode_supplier") {
    $kode_supplier    = $_POST['kode_supplier'];

    $query        = "SELECT kode_supplier FROM supplier WHERE kode_supplier='" . $kode_supplier . "' ";

    $result        = mysql_query($query);

    $num         = mysql_num_rows($result);

    if ($num > 0) {
        echo " <i class='fa fa-exclamation-triangle'></i> Kode Sudah Ada";
    }
}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "loadkode_pelanggan") {
    $kode_pelanggan    = $_POST['kode_pelanggan'];

    $query        = "SELECT kode_pelanggan FROM pelanggan WHERE kode_pelanggan='" . $kode_pelanggan . "' ";

    $result        = mysql_query($query);

    $num         = mysql_num_rows($result);

    if ($num > 0) {
        echo " <i class='fa fa-exclamation-triangle'></i> Kode Sudah Ada";
    }
}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "loadkode_coa") {
    $kode_coa    = $_POST['kode_coa'];

    $query        = "SELECT kode_coa FROM coa WHERE kode_coa='" . $kode_coa . "' ";

    $result        = mysql_query($query);

    $num         = mysql_num_rows($result);

    if ($num > 0) {
        echo " <i class='fa fa-exclamation-triangle'></i> Kode Sudah Ada";
    }
}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "loadkode_inventori") {
    $kode_inventori    = $_POST['kode_inventori'];

    $query        = "SELECT kode_inventori FROM inventori WHERE kode_inventori='" . $kode_inventori . "' ";

    $result        = mysql_query($query);

    $num         = mysql_num_rows($result);

    if ($num > 0) {
        echo " <i class='fa fa-exclamation-triangle'></i> Kode Barang Sudah Ada";
    }
}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "loadkodepl") {
    $kode_pl    = $_POST['kode_pl'];

    $query        = "SELECT kode_pl_hdr FROM pl_hdr WHERE kode_pl_hdr='" . $kode_pl . "' ";

    $result        = mysql_query($query);

    $num         = mysql_num_rows($result);

    if ($num > 0) {
        echo " <i class='fa fa-exclamation-triangle'></i> Kode PL Sudah Ada";
    }
}
