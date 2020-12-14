<?php

//CLASS FORM AWAL
$class_form = 'class="active"';
$class_pane_form = 'class="tab-pane in active"';
$class_tab = "";
$class_tab1 = "";
$class_pane_tab = 'class="tab-pane"';
$class_pane_tab1 = 'class="tab-pane"';

//DDL
$q_metode_penyusutan = mysql_query("SELECT * FROM ddl_metode_penyusutan ");
$q_masa_manfaat = mysql_query("SELECT * FROM ddl_masa_manfaat ");
$q_ddl_coa = mysql_query("SELECT * FROM coa WHERE level_coa='4' and aktif='1' ORDER BY kode_coa ASC ");
$q_ddl_coa2 = mysql_query("SELECT * FROM coa WHERE level_coa='4' and aktif='1' ORDER BY kode_coa ASC ");


// UBAH PENCARIAN BERDASAR STATUS DI db
if (isset($_POST['status'])) {
    if ($_POST['status'] == 'y') {
        $status = '1';
    } else if ($_POST['status'] == 'n') {
        $status = '0';
    }
}

// Saat klik tombol cari
if (isset($_POST['cari'])) {
    //CLASS FORM SAAT KLIK TOMBOL CARI
    $class_tab = 'class="active"';
    $class_pane_tab = 'class="tab-pane in active"';
    $class_form = "";
    $class_pane_form = 'class="tab-pane"';


    if (($_POST['status'] == 'y' or $_POST['status'] == 'n')) {
        $q_aset = mysql_query("SELECT * FROM kategori_aset WHERE aktif='" . $status . "' ORDER BY kode_kat_aset ASC");
    } else {
        $q_aset = mysql_query("SELECT * FROM kategori_aset ORDER BY kode_kat_aset ASC");
    }
} else {
    $q_aset = mysql_query("SELECT * FROM kategori_aset ORDER BY kode_kat_aset ASC");
}


// Simpan ke database
if (isset($_POST['simpan'])) {

    $_POST = array_map("strtoupper", $_POST);

    $kode_kat_aset = mres($_POST['kode_kat_aset']);
    $keterangan = mres($_POST['keterangan']);
    $metode_penyusutan = mres($_POST['metode_penyusutan']);
    $masa_manfaat = mres($_POST['masa_manfaat']);
    $coa_debet = mres($_POST['coa_debet']);
    $coa_kredit = mres($_POST['coa_kredit']);

    $sql = "INSERT INTO kategori_aset (kode_kat_aset,keterangan,metode_penyusutan,masa_manfaat,coa_debet,coa_kredit) VALUES ('" . $kode_kat_aset . "','" . $keterangan . "','" . $metode_penyusutan . "','" . $masa_manfaat . "','" . $coa_debet . "','" . $coa_kredit . "')";
    $query = mysql_query($sql);

    if ($query) {
        //echo "<meta http-equiv='refresh' content='0; url=".base_url()."?module=setting/cabang' />";
        $info = 'SIMPAN DATA SUKSES';
        echo ("<script>location.href = '" . base_url() . "?page=setting/kat_aset&inputsukses&halaman= KATEGORI ASET';</script>");
    } else {
        //$response = "99||Simpan data gagal. ".mysql_error();
        $warning = "SIMPAN DATA GAGAL";
    }
}

// Update ke database
if (isset($_GET['action']) and $_GET['action'] == "edit") {
    $id_kat_aset = mres($_GET['id_kat_aset']);

    $q_edit_aset = mysql_query("SELECT * FROM kategori_aset WHERE id_kat_aset = '" . $id_kat_aset . "'");

    if (isset($_POST['update'])) {
        $_POST = array_map("strtoupper", $_POST);

        $kode_kat_aset = mres($_POST['kode_kat_aset']);
        $keterangan = mres($_POST['keterangan']);
        $metode_penyusutan = mres($_POST['metode_penyusutan']);
        $masa_manfaat = mres($_POST['masa_manfaat']);
        $coa_debet = mres($_POST['coa_debet']);
        $coa_kredit = mres($_POST['coa_kredit']);

        $sql = "UPDATE kategori_aset SET kode_kat_aset = '" . $kode_kat_aset . "',keterangan = '" . $keterangan . "', metode_penyusutan = '" . $metode_penyusutan . "', masa_manfaat = '" . $masa_manfaat . "', coa_debet = '" . $coa_debet . "', coa_kredit = '" . $coa_kredit . "' WHERE id_kat_aset = '" . $id_kat_aset . "'";
        $query = mysql_query($sql);

        if ($query) {
            //echo "<meta http-equiv='refresh' content='0; url=".base_url()."?page=karyawan' />";
            $info = 'UPDATE DATA SUKSES';
            echo ("<script>location.href = '" . base_url() . "?page=setting/kat_aset&updatesukses&halaman= KATEGORI ASET';</script>");
        } else {
            //$response = "99||Update data gagal. ".mysql_error();
            $warning = "UPDATE DATA GAGAL";
        }
    }
}

// NON AKTIF DAN AKTIFKAN STATUS
if (isset($_GET['action']) and $_GET['action'] == "nonaktif") {
    $id_kat_aset = mres($_GET['id_kat_aset']);

    $sql = "UPDATE kategori_aset SET aktif = '0' WHERE id_kat_aset = '" . $id_kat_aset . "'";
    $query = mysql_query($sql);

    echo ("<script>location.href = '" . base_url() . "?page=setting/kat_aset&halaman= KATEGORI ASET';</script>");
} else if (isset($_GET['action']) and $_GET['action'] == "aktif") {
    $id_kat_aset = mres($_GET['id_kat_aset']);

    $sql = "UPDATE kategori_aset SET aktif = '1' WHERE id_kat_aset = '" . $id_kat_aset . "'";
    $query = mysql_query($sql);

    echo ("<script>location.href = '" . base_url() . "?page=setting/kat_aset&halaman= KATEGORI ASET';</script>");
}

// TRACK
if (isset($_GET['action']) and $_GET['action'] == "track") {
    $id_kat_aset = ($_GET['id_kat_aset']);

    $q_aset_prev = mysql_query("SELECT id_kat_aset FROM kategori_aset WHERE id_kat_aset = (select max(id_kat_aset) FROM kategori_aset WHERE id_kat_aset < " . $id_kat_aset . ")");

    $q_aset_next = mysql_query("SELECT id_kat_aset FROM kategori_aset WHERE id_kat_aset = (select min(id_kat_aset) FROM kategori_aset WHERE id_kat_aset > " . $id_kat_aset . ")");

    $q_aset = mysql_query("SELECT kategori_aset.*,coa_deb.nama coa_deb, coa_kred.nama coa_kred FROM kategori_aset INNER JOIN coa coa_deb ON coa_deb.kode_coa=kategori_aset.coa_debet INNER JOIN coa coa_kred ON coa_kred.kode_coa=kategori_aset.coa_kredit  WHERE id_kat_aset = '" . $id_kat_aset . "'");
}
