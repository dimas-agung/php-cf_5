<?php

$q_close 	= mysql_query("SELECT DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%m') AS `month`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y') AS `year`, DATE_FORMAT(STR_TO_DATE(`bulan`, '%m-%Y'), '%Y-%m') AS `fulltext` FROM `close`");

//CLASS FORM AWAL
$class_form         = 'class="active"';
$class_pane_form     = 'class="tab-pane in active"';
$class_tab             = "";
$class_pane_tab     = 'class="tab-pane"';

//DROPDOWN CABANG
$q_cabang              = mysql_query("SELECT kode_cabang, nama as nama_cabang FROM cabang WHERE aktif='1'");

//LIST CABANG
$q_cabang_list      = mysql_query("SELECT kode_cabang, nama as nama_cabang FROM cabang WHERE aktif='1'");

//DROPDOWN GUDANG
$q_gudang              = mysql_query("SELECT kode_gudang, nama as nama_gudang FROM gudang WHERE aktif='1'");

//DROPDOWN PELANGGAN
$q_pel                 = mysql_query("SELECT `pelanggan`.`kode_pelanggan`, `pelanggan`.`nama` as `nama_pelanggan`, `pelanggan`.`alamat`, CONCAT(`karyawan`.`kode_karyawan`, ':', `karyawan`.`nama`) AS `salesman`, `jatuh_tempo` AS `top`, CONCAT(`kp`.`kode_kategori_pelanggan`, ':', `kp`.`nama`) AS `nama_kategori` FROM `pelanggan` LEFT JOIN `kategori_pelanggan` AS `kp` ON `kategori_pelanggan`  = `kp`.`kode_kategori_pelanggan` LEFT JOIN `karyawan` ON `pelanggan`.`salesman` = `karyawan`.`kode_karyawan` WHERE `pelanggan`.`aktif` = '1' AND `karyawan`.`aktif` = '1' " . searchKodeSales() . " ORDER BY `pelanggan`.`kode_pelanggan`");

//DROPDOWN SATUAN DTL
$q_sat_dtl             = mysql_query("SELECT kode_satuan,  nama nama_satuan FROM satuan WHERE aktif='1'");

//BARANG DI FORM LIST
$q_barang              = mysql_query("SELECT `i`.`kode_inventori` AS `kode_barang`, `i`.`nama` AS `nama_barang`, `kategori`, `satuan_beli`, `satuan_jual`, `isi` FROM `inventori` AS `i` WHERE `i`.`aktif` = '1' AND `kategori` = 'ID'");

//LIST PELANGGAN
$q_pelanggan_list    = mysql_query("SELECT kode_pelanggan, nama as nama_pelanggan FROM pelanggan WHERE aktif='1'" . searchKodeSales());

//LIST SO
$q_so                = mysql_query("SELECT sh.*, c.nama as nama_cabang, g.nama as nama_gudang, p.nama as nama_pelanggan FROM so_hdr sh
									LEFT JOIN cabang c on c.kode_cabang = sh.kode_cabang
									LEFT JOIN gudang g on g.kode_gudang = sh.kode_gudang
									LEFT JOIN pelanggan p on p.kode_pelanggan = SUBSTRING_INDEX(sh.kode_pelanggan, ':', 1)
									GROUP BY kode_so
									ORDER BY tgl_buat DESC");

//LIST PENCARIAN
if (isset($_POST['cari'])) {

    eval($helper->createClassFormCari());

    $kode_so        = $_POST['kode_so'];
    $ref            = $_POST['ref'];
    $cabang         = $_POST['cabang'];
    $pelanggan         = $_POST['pelanggan'];
    $tgl_awal        = date("Y-m-d", strtotime($_POST['tanggal_awal']));
    $tgl_akhir        = date("Y-m-d", strtotime($_POST['tanggal_akhir']));

    if ($_POST['status'] == '1') {
        $status = '1';
    } else {
        $status = '0';
    }

    $sql = ("SELECT sh.*, c.nama as nama_cabang, g.nama as nama_gudang, p.nama as nama_pelanggan FROM so_hdr sh
							LEFT JOIN cabang c on c.kode_cabang = sh.kode_cabang
							LEFT JOIN gudang g on g.kode_gudang = sh.kode_gudang
							LEFT JOIN pelanggan p on p.kode_pelanggan = SUBSTRING_INDEX(sh.kode_pelanggan, ':', 1)
							WHERE sh.kode_so LIKE '%" . $kode_so . "%' AND
								sh.ref LIKE '%" . $ref . "%' AND
								c.kode_cabang LIKE '%" . $cabang . "%' AND
								p.kode_pelanggan LIKE '%" . $pelanggan . "%' AND
								sh.status LIKE '%" . $status . "%' AND
								sh.tgl_buat BETWEEN '" . $tgl_awal . "' AND '" . $tgl_akhir . "'
							ORDER BY id_so_hdr ASC");

    $q_so = mysql_query($sql);
    // echo $sql;
}

//REFRESH LIST
if (isset($_POST['refresh'])) {
    //CLASS FORM SAAT KLIK TOMBOL REFRESH
    $class_tab = 'class="active"';
    $class_pane_tab = 'class="tab-pane in active"';
    $class_form = "";
    $class_pane_form = 'class="tab-pane"';

    $_POST['kode_so']     = "";
    $_POST['ref']        = "";
    $_POST['cabang']    = "";
    $_POST['pelanggan']    = "";
    $_POST['status']    = "";
}

// TRACK
if (isset($_GET['action']) and $_GET['action'] == "track") {

    $kode_so = mres($_GET['kode_so']);

    $id_so_hdr = mysql_query("SELECT `id_so_hdr` FROM `so_hdr` WHERE `kode_so` = '" . $kode_so . "'");
    $id = mysql_fetch_array($id_so_hdr);

    $q_so_prev = mysql_query("SELECT `id_so_hdr`, `kode_so` FROM `so_hdr` WHERE `id_so_hdr` = (SELECT MAX(`id_so_hdr`) FROM `so_hdr` WHERE `id_so_hdr` < " . $id['id_so_hdr'] . ")");

    $q_so_next = mysql_query("SELECT `id_so_hdr`, `kode_so` FROM `so_hdr` WHERE `id_so_hdr` = (SELECT MIN(`id_so_hdr`) FROM `so_hdr` WHERE `id_so_hdr` > " . $id['id_so_hdr'] . ")");

    $status = mysql_query("SELECT `kode_so`, `status` FROM `so_hdr` WHERE `kode_so` = '" . $kode_so . "' ");

    $q_so_hdr = mysql_query("SELECT `sh`.`kode_so`, SUBSTRING_INDEX(`sh`.`kode_pelanggan`, ':', 1) AS `kode_pelanggan`, `p`.`nama` AS `nama_pelanggan`, `sh`.`tgl_buat`, `sh`.`alamat`, `sh`.`ref`, `sh`.`alamat_kirim`, `sh`.`kode_cabang`, `c`.`nama` AS `nama_cabang`, `sh`.`tgl_kirim`, `sh`.`kode_gudang`, `g`.`nama` AS `nama_gudang`, `sh`.`top`, `k`.`nama` AS `kode_salesman`, `sh`.`keterangan_hdr`, `sh`.`status` FROM `so_hdr` AS `sh` LEFT JOIN `cabang` AS `c` ON `c`.`kode_cabang` = `sh`.`kode_cabang` LEFT JOIN `gudang` AS `g` ON `g`.`kode_gudang` = `sh`.`kode_gudang` LEFT JOIN `pelanggan` AS `p` ON `p`.`kode_pelanggan` = SUBSTRING_INDEX(`sh`.`kode_pelanggan`, ':', 1) LEFT JOIN `karyawan` AS `k` ON `sh`.`kode_salesman` = `k`.`kode_karyawan` LEFT JOIN `so_um` AS `u` ON `u`.`kode_so` = `sh`.`kode_so` WHERE `sh`.`kode_so` = '" . $kode_so . "' ");

    $q_so_dtl = mysql_query("SELECT `nama_barang`, `foc`, IF(`konversi1` > 0, `satuan`, `satuan_jual`) AS `satuan`, `satuan_simpan`, `qty`, `konversi`, `konversi1`, `harga`, `total_harga`, `diskon1`, `diskon2`, `diskon3`, `ppn`, `keterangan_dtl` FROM `so_dtl` WHERE `kode_so` = '" . $kode_so . "' ORDER BY `id_so_dtl` ASC");

    $so_um = mysql_query("SELECT * FROM `so_um` WHERE `kode_so` = '" . $kode_so . "' ORDER BY `id_um` DESC");
}
