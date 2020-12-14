<?php

//CLASS FORM AWAL
$class_form = 'class="active"';
$class_pane_form = 'class="tab-pane in active"';
$class_tab = "";
$class_tab1 = "";
$class_pane_tab = 'class="tab-pane"';
$class_pane_tab1 = 'class="tab-pane"';

$q_kat_aset     = mysql_query("SELECT id_kat_aset, CONCAT(kode_kat_aset, ' || ', keterangan, ' || ', metode_penyusutan, ' || ',masa_manfaat, ' BULAN') AS kode_kat_aset FROM kategori_aset WHERE aktif='1'");
$q_supplier     = mysql_query("SELECT id_supplier, CONCAT(kode_supplier, ' || ', nama) AS kode_supplier FROM supplier WHERE aktif='1'");
$q_mst_aset     = mysql_query("SELECT `id_mst_aset`, `kode_mst_aset`, `nama_mst_aset`, `lokasi_mst_aset`, UPPER(`pembayaran_mst_aset`) AS `pembayaran_mst_aset`, `leasing_mst_aset`, `masa_mst_aset`, `bunga_mst_aset`, CONCAT(`supplier`.`kode_supplier`, ' || ', `supplier`.`nama`) AS `kode_supplier`, CONCAT(`kategori_aset`.`kode_kat_aset`, ' || ', `kategori_aset`.`keterangan`, ' || ', `kategori_aset`.`metode_penyusutan`, ' || ', `kategori_aset`.`masa_manfaat`, ' BULAN') AS `kode_kat_aset` FROM `mst_aset` INNER JOIN `supplier` ON `supplier_mst_aset` = `id_supplier` INNER JOIN `kategori_aset` ON `kat_mst_aset` = `id_kat_aset`");

// Simpan ke database
if (!is_null($request) && isset($request->simpan)) {

    $kode_mst_aset = !is_null($request) && isset($request->kode_mst_aset) ? mres($request->kode_mst_aset) : null;
    $nama_mst_aset = !is_null($request) && isset($request->nama_mst_aset) ? mres($request->nama_mst_aset) : null;
    $supplier_mst_aset = !is_null($request) && isset($request->supplier_mst_aset) ? mres($request->supplier_mst_aset) : null;
    $kat_mst_aset = !is_null($request) && isset($request->kat_mst_aset) ? mres($request->kat_mst_aset) : null;
    $lokasi_mst_aset = !is_null($request) && isset($request->lokasi_mst_aset) ? mres($request->lokasi_mst_aset) : null;
    $pembayaran_mst_aset = !is_null($request) && isset($request->pembayaran_mst_aset) ? strtolower(mres($request->pembayaran_mst_aset)) : null;
    $leasing_mst_aset = !is_null($request) && isset($request->leasing_mst_aset) ? mres($request->leasing_mst_aset) : null;
    $masa_mst_aset = !is_null($request) && isset($request->masa_mst_aset) ? mres($request->masa_mst_aset) : null;
    $bunga_mst_aset = !is_null($request) && isset($request->bunga_mst_aset) ? mres($request->bunga_mst_aset) : null;

    if ($pembayaran_mst_aset === 'kredit') {
        $insert = sprintf(
            'INSERT INTO `mst_aset` (`kode_mst_aset`, `nama_mst_aset`, `supplier_mst_aset`, `kat_mst_aset`, `lokasi_mst_aset`, `pembayaran_mst_aset`, `leasing_mst_aset`, `masa_mst_aset`, `bunga_mst_aset`, `status_mst_aset`) VALUES (\'%s\', \'%s\', \'%d\', \'%d\', \'%s\', \'%s\', \'%s\', \'%d\', \'%d\', \'%d\')',
            $kode_mst_aset,
            $nama_mst_aset,
            $supplier_mst_aset,
            $kat_mst_aset,
            $lokasi_mst_aset,
            $pembayaran_mst_aset,
            $leasing_mst_aset,
            $masa_mst_aset,
            $bunga_mst_aset,
            0
        );
    } else {
        $insert = sprintf(
            'INSERT INTO `mst_aset` (`kode_mst_aset`, `nama_mst_aset`, `supplier_mst_aset`, `kat_mst_aset`, `lokasi_mst_aset`, `pembayaran_mst_aset`, `status_mst_aset`) VALUES (\'%s\', \'%s\', \'%d\', \'%d\', \'%s\', \'%s\', \'%d\')',
            $kode_mst_aset,
            $nama_mst_aset,
            $supplier_mst_aset,
            $kat_mst_aset,
            $lokasi_mst_aset,
            $pembayaran_mst_aset,
            0
        );
    }

    $query = mysql_query($insert);

    if ($query) {
        $info = 'SIMPAN DATA SUKSES';
        echo ("<script>location.href = '" . base_url() . "?page=master/aset&inputsukses&halaman= ASET';</script>");
    } else {
        $warning = "SIMPAN DATA GAGAL";
    }
}

// Update ke database
if (!is_null($request) && isset($request->action) && strtolower($request->action) === 'edit') {
    $id_mst_aset = !is_null($request) && isset($request->id_mst_aset) ? mres($request->id_mst_aset) : null;

    if (!is_null($id_mst_aset) && filter_var($id_mst_aset, FILTER_VALIDATE_INT)) {
        $data = sprintf('SELECT * FROM `mst_aset` WHERE `id_mst_aset` = \'%d\'', $id_mst_aset);
        $q_edit_mst_aset = mysql_query($data);

        if (!is_null($request) && isset($request->update)) {

            $nama_mst_aset = !is_null($request) && isset($request->nama_mst_aset) ? mres($request->nama_mst_aset) : null;
            $supplier_mst_aset = !is_null($request) && isset($request->supplier_mst_aset) ? mres($request->supplier_mst_aset) : null;
            $kat_mst_aset = !is_null($request) && isset($request->kat_mst_aset) ? mres($request->kat_mst_aset) : null;
            $lokasi_mst_aset = !is_null($request) && isset($request->lokasi_mst_aset) ? mres($request->lokasi_mst_aset) : null;
            $pembayaran_mst_aset = !is_null($request) && isset($request->pembayaran_mst_aset) ? strtolower(mres($request->pembayaran_mst_aset)) : null;
            $leasing_mst_aset = !is_null($request) && isset($request->leasing_mst_aset) ? mres($request->leasing_mst_aset) : null;
            $masa_mst_aset = !is_null($request) && isset($request->masa_mst_aset) ? mres($request->masa_mst_aset) : null;
            $bunga_mst_aset = !is_null($request) && isset($request->bunga_mst_aset) ? mres($request->bunga_mst_aset) : null;

            if ($pembayaran_mst_aset === 'kredit') {
                $update = sprintf(
                    'UPDATE `mst_aset` SET `nama_mst_aset` = \'%s\', `supplier_mst_aset` = \'%d\', `kat_mst_aset` = \'%d\', `lokasi_mst_aset` = \'%s\', `pembayaran_mst_aset` = \'%s\', `leasing_mst_aset` = \'%s\', `masa_mst_aset` = \'%d\', `bunga_mst_aset` = \'%d\', `status_mst_aset` = \'%d\' WHERE `id_mst_aset` = \'%d\'',
                    $nama_mst_aset,
                    $supplier_mst_aset,
                    $kat_mst_aset,
                    $lokasi_mst_aset,
                    $pembayaran_mst_aset,
                    $leasing_mst_aset,
                    $masa_mst_aset,
                    $bunga_mst_aset,
                    1,
                    $id_mst_aset
                );
            } else {
                $update = sprintf(
                    'UPDATE `mst_aset` SET `nama_mst_aset` = \'%s\', `supplier_mst_aset` = \'%d\', `kat_mst_aset` = \'%d\', `lokasi_mst_aset` = \'%s\', `pembayaran_mst_aset` = \'%s\', `leasing_mst_aset` = NULL, `masa_mst_aset` = NULL, `bunga_mst_aset` = NULL, `status_mst_aset` = \'%d\' WHERE `id_mst_aset` = \'%d\'',
                    $nama_mst_aset,
                    $supplier_mst_aset,
                    $kat_mst_aset,
                    $lokasi_mst_aset,
                    $pembayaran_mst_aset,
                    1,
                    $id_mst_aset
                );
            }

            $query = mysql_query($update);

            if ($query) {
                $info = 'UPDATE DATA SUKSES';
                echo ("<script>location.href = '" . base_url() . "?page=master/aset&updatesukses&halaman= ASET';</script>");
            } else {
                $warning = "UPDATE DATA GAGAL";
            }
        }
    }
}
