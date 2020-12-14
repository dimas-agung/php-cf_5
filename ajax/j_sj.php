<?php
session_start();
require('../library/conn.php');
require('../library/helper.php');
require('../pages/data/script/sj.php');
date_default_timezone_set("Asia/Jakarta");

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "loaditem") {
    $kode_pelanggan = mres($_POST['kode_pelanggan']);
    $kode_cabang     = mres($_POST['kode_cabang']);
    $kode_gudang     = mres($_POST['kode_gudang']);

    $grandtotal     = 0;
    $total             = 0;
	
	$q_dtl1 = "SELECT `sd`.`kode_so`, `sd`.`kode_barang`, `sd`.`nama_barang`, `sd`.`foc`, `sd`.`qty`, `sd`.`satuan`, `sd`.`konversi1`, `sd`.`satuan_jual`, `sd`.`konversi`, `sd`.`satuan_simpan`, `sd`.`harga`, `sd`.`diskon1`, `sd`.`diskon2`, `sd`.`diskon3`, `sd`.`total_harga`,	(SELECT IF(SUM(`sjd`.`qty_so1`) > 0, SUM(`sjd`.`qty_so1`), SUM(`sjd`.`qty_so2`)) FROM `sj_dtl` AS `sjd` INNER JOIN `sj_hdr` AS `sjh` ON `sjh`.`kode_sj` = `sjd`.`kode_sj` INNER JOIN `so_hdr` AS `oh` ON `oh`.`kode_so` = `sjd`.`kode_so` WHERE `sjd`.`kode_inventori` = `sd`.`kode_barang` AND `sjd`.`kode_so` = `sd`.`kode_so` AND `sjd`.`status_dtl` != '2') AS `qty_sj`,	`sd`.`ppn`, `i`.`sj_debet`, `i`.`sj_kredit`, (SELECT `tgl_buat` FROM `crd_stok_dtl` WHERE `kode_barang` = `sd`.`kode_barang` AND `kode_cabang` = `sh`.`kode_cabang` AND `kode_gudang` = `sh`.`kode_gudang` ORDER BY `tgl_buat` ASC LIMIT 1) AS `tgl_awal_stok_ada`, `sd`.`keterangan_dtl` FROM `so_dtl` AS `sd` INNER JOIN `so_hdr` AS `sh` ON `sh`.`kode_so` = `sd`.`kode_so`	LEFT JOIN `sj_dtl` AS `sjd` ON `sjd`.`kode_inventori` = `sd`.`kode_barang` AND `sjd`.`kode_so` = `sd`.`kode_so`	LEFT JOIN `sj_hdr` AS `sjh` ON `sjh`.`kode_sj` = `sjd`.`kode_sj` LEFT JOIN `inventori` AS `i` ON `i`.`kode_inventori` = `sd`.`kode_barang` WHERE SUBSTRING_INDEX(`sh`.`kode_pelanggan`, ' : ', 1) = '" . $kode_pelanggan . "' AND `sh`.`kode_cabang` = '" . $kode_cabang . "' AND `sh`.`kode_gudang` = '" . $kode_gudang . "' AND `sd`.`status_dtl` = '1' GROUP BY `sd`.`kode_so`, `sd`.`kode_barang` ORDER BY `sd`.`kode_so` ASC";
    $q_dtl = mysql_query($q_dtl1);
    $num_rows     = mysql_num_rows($q_dtl);
    if ($num_rows > 0) {
        $n     = 1;
        $no = 0;
        while ($rowdtl = mysql_fetch_array($q_dtl)) {

            $qty             = ($rowdtl['qty'] - $rowdtl['qty_sj']);
            $qty_maksimum     = $qty;
            $qty_maks         = ($qty_maksimum + $qty);

            // $qty2 			= (int)($qty*$rowdtl['konversi1']);
            // $qty3 			= (int)($qty2*$rowdtl['konversi']);

            if ($rowdtl['foc'] == '1') {
                $load_foc = '<span class="glyphicon glyphicon-check"> </span>
								 <input type="hidden" name="stat_foc[]" id="stat_foc" value="1">';
            } else {
                $load_foc = '<span class="glyphicon glyphicon-unchecked"> </span>
								 <input type="hidden" name="stat_foc[]" id="stat_foc" value="0">';
            }

            if (number_format($rowdtl['konversi1'], 2) > 0) {
                $qty_so1 = $qty;
                $satuan_qty_so1 = $rowdtl['satuan'];

                $qty_so2 = ($qty * $rowdtl['konversi1']);

                $qty_so3 = ($qty_so2 * $rowdtl['konversi']);
            } else {
                $qty_so1 = 0;
                $satuan_qty_so1 = '-';

                $qty_so2 = $qty;
                $qty_so3 = ($qty * $rowdtl['konversi']);
            }

            if (!empty($rowdtl['satuan'])) {
                $satuan = $rowdtl['satuan'];
            } else {
                $satuan = $rowdtl['satuan_jual'];
            }

            echo '<tr>
							<td style="width: 2%">
								<input style="text-align:center;" class="checkbox" type="checkbox" name="cb[]" id="cb[]" data-id="cb" data-group="' . $no . '" value="' . $no . '">
							</td>
							<td style="width: 150px">' . $rowdtl['kode_so'] . '
								<input class="form-control" type="hidden" name="kode_so[]" id="kode_so[]" data-id="kode_so" data-group="' . $no . '" value="' . $rowdtl['kode_so'] . '"/>
							</td>
							<td style="width: 100px">' . $rowdtl['kode_barang'] . ' - ' . $rowdtl['nama_barang'] . '
								<input class="form-control" type="hidden" name="kode_barang[]" id="kode_barang[]" data-id="kode_barang" data-group="' . $no . '" value="' . $rowdtl['kode_barang'] . '"/>
								<input class="form-control" type="hidden" name="sj_debet[]" id="sj_debet[]" data-id="sj_debet" data-group="' . $no . '" value="' . $rowdtl['sj_debet'] . '"/>
								<input class="form-control" type="hidden" name="sj_kredit[]" id="sj_kredit[]" data-id="sj_kredit" data-group="' . $no . '" value="' . $rowdtl['sj_kredit'] . '"/>
								<input class="form-control" type="hidden" name="nama_barang[]" id="nama_barang[]" data-id="nama_barang" data-group="' . $no . '" value="' . $rowdtl['nama_barang'] . '"/>
							</td>
							<td style="text-align: center; width: 3%">' . $load_foc . '</td>
							<td style="width: 10%">
	  							<input type="text" class="form-control" name="qty_so1[]" id="qty_so1[]" data-id="qty_so1" data-group="' . $no . '" placeholder=".. QTY .." style="font-size: 12px; text-align: center" value="' . $qty_so1 . '" readonly>
	  							<input type="text" class="form-control" name="satuan_qty_so1[]" id="satuan_qty_so1[]" data-id="satuan_qty_so1" data-group="' . $no . '" placeholder=".. Satuan .." style="font-size: 12px; text-align: center" value="' . $satuan_qty_so1 . '" readonly>
	  						</td>
							<td style="width: 10%">
								<input type="hidden" class="form-control" name="konversi1[]" id="konversi1[]" data-id="konversi1" data-group="' . $no . '" placeholder=".. KONVERSI 1 .." style="font-size: 12px; text-align: center" value="' . $rowdtl['konversi1'] . '" readonly>
								<input class="form-control" type="text" name="qty_so2[]" id="qty_so2[]" data-id="qty_so2" data-group="' . $no . '" placeholder=".. QTY .." style="font-size: 12px; text-align: center" value="' . $qty_so2 . '" readonly/>
								<input class="form-control" type="text" name="satuan_qty_so2[]" id="satuan_qty_so2[]" data-id="satuan_qty_so2" data-group="' . $no . '" placeholder=".. QTY .." style="font-size: 12px; text-align: center" value="' . $rowdtl['satuan_jual'] . '" readonly/>

								<input type="hidden" class="form-control" name="qty2[]" id="qty2[]" data-id="qty2" data-group="' . $no . '" value="' . $rowdtl['konversi1'] . '" readonly>
							</td>
							<td style="width: 10%">
								<input type="hidden" class="form-control" name="konversi[]" id="konversi[]" data-id="konversi" data-group="' . $no . '" placeholder=".. KONVERSI .." style="font-size: 12px; text-align: center" value="' . $rowdtl['konversi'] . '" readonly>
								<input type="text" class="form-control" name="qty_so3[]" id="qty_so3[]" data-id="qty_so3" data-group="' . $no . '" placeholder=".. QTY .." style="font-size: 12px; text-align: center" value="' . $qty_so3 . '" readonly>
	  							<input type="text" class="form-control" name="satuan_qty_so3[]" id="satuan_qty_so3[]" data-id="satuan_qty_so3" data-group="' . $no . '" placeholder=".. Satuan .." style="font-size: 12px; text-align: center" value="' . $rowdtl['satuan_simpan'] . '" readonly>

	  							<input type="hidden" class="form-control" name="qty3[]" id="qty3[]" data-id="qty3" data-group="' . $no . '" value="' . $rowdtl['konversi'] . '" readonly>
							</td>
							<td style="width: 10%">
								<div class="input-group">
									<input type="hidden" class="form-control" name="qty_saat_ini[]" id="qty_saat_ini[]" data-id="qty_saat_ini" data-group="' . $no . '" autocomplete="off" value="' . ($satuan_qty_so1 !== '-' ? $qty_so1 : $qty_so2) . '" style="font-size: 12px; text-align: center" readonly>
									<input type="text" class="form-control" placeholder="Qty Dikirim" ..." name="qty_dikirim[]" id="qty_dikirim[]" data-id="qty_dikirim" data-group="' . $no . '" autocomplete="off" value="' . $qty . '" style="font-size: 12px; text-align: center">
									<input type="text" class="form-control" name="satuan_dikirim[]" id="satuan_dikirim[]" data-id="satuan_dikirim" data-group="' . $no . '" placeholder=".. Satuan .." style="font-size: 12px; text-align: center" value="' . $satuan . '" readonly>

									<input class="form-control" type="hidden" name="qty_max[]" id="qty_max[]" data-id="qty_max" data-group="' . $no . '" value="' . $qty_maks . '"/>
									<input class="form-control" type="hidden" name="tgl_awal_stok_ada[]" id="tgl_awal_stok_ada[]" data-id="tgl_awal_stok_ada" data-group="' . $no . '" value="' . $rowdtl['tgl_awal_stok_ada'] . '"/>
									<input class="form-control" type="hidden" name="ppn[]" id="ppn[]" data-id="ppn" data-group="' . $no . '" value="' . $rowdtl['ppn'] . '"/>
									<input class="form-control" type="hidden" name="qty_dikirim_total[]" id="qty_dikirim_total[]" data-id="qty_dikirim_total" data-group="' . $no . '" value="' . $qty_so3 . '"/>
									<input class="form-control" type="hidden" name="harga[]" id="harga[]" data-id="harga" data-group="' . $no . '" value="' . $rowdtl['harga'] . '"/>
									<input class="form-control" type="hidden" name="diskon1[]" id="diskon1[]" data-id="diskon1" data-group="' . $no . '" value="' . $rowdtl['diskon1'] . '"/>
									<input class="form-control" type="hidden" name="diskon2[]" id="diskon2[]" data-id="diskon2" data-group="' . $no . '" value="' . $rowdtl['diskon2'] . '"/>
									<input class="form-control" type="hidden" name="diskon3[]" id="diskon3[]" data-id="diskon3" data-group="' . $no . '" value="' . $rowdtl['diskon3'] . '"/>
									<input class="form-control" type="hidden" name="total_harga[]" id="total_harga[]" data-id="total_harga" data-group="' . $no . '" value="' . $rowdtl['total_harga'] . '"/>
								</div>
							</td>
							<td>
								<textarea  class="form-control" name="keterangan_dtl[]" id="keterangan_dtl[]" placeholder="Keterangan..." data-id="keterangan_dtl" data-group="' . $no++ . '">' . $rowdtl['keterangan_dtl'] . '</textarea>
							</td>
					</tr>';
        }
        echo '<tr>
							<input type="hidden" value="0" name="grand_total" id="grand_total" />
					  </tr>';
    } else {

        echo '<tr><td colspan="10" class="text-center">Belum ada item</td></tr>';
    }
}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "save") {
    // Set autocommit to off
    mysqli_autocommit($con, FALSE);

    $form                 =    'SJ';
    $thnblntgl             =    date("ymd", strtotime(mres($_POST['tgl_buat'])));

    $alamat             =    mres($_POST['alamat_kirim']);
    $ref                 =    mres($_POST['ref']);
    $keterangan_hdr     =    mres($_POST['keterangan_hdr']);
    $tgl_buat             =    date("Y-m-d", strtotime(mres($_POST['tgl_buat'])));

    $kode_cabang         =    mres($_POST['kode_cabang']);
    $kode_gudang         =    mres($_POST['kode_gudang']);
    $kode_pelanggan     =    mres($_POST['kode_pelanggan']);

    $user_pencipta      =     $_SESSION['app_id'];
    $tgl_input             =     date("Y-m-d H:i:s");

    $kode_sj             =    buat_kode_sj($thnblntgl, $form, $kode_cabang);

    //DETAIL SJ
	
    $diskon1x     = 0;
    $diskon2x     = 0;
    $diskon3x     = 0;
    $dpp = 0;
	$ppn_n = 0;
    $subtot = 0;
    $subtotal = 0;
    $grandsubtotal = 0;
    $ppntotal = 0;
    $grandtotal = 0;
	    
	$angka = '';
    $satuan = '';

    $sj_debet            = $_POST['sj_debet'];
    $sj_kredit            = $_POST['sj_kredit'];

    $no_sj                = mres($kode_sj);
    $cb                 = $_POST['cb'];
    $kode_so            = $_POST['kode_so'];
    $kode_barang        = $_POST['kode_barang'];
    $nama_barang         = $_POST['nama_barang'];
    $foc                = $_POST['stat_foc'];

    $qty_so1             = $_POST['qty_so1'];
    $satuan_qty_so1        = $_POST['satuan_qty_so1'];
    $qty_so2             = $_POST['qty_so2'];
    $satuan_qty_so2        = $_POST['satuan_qty_so2'];
    $qty_so3             = $_POST['qty_so3'];
    $satuan_qty_so3        = $_POST['satuan_qty_so3'];
    $qty_saat_ini         = $_POST['qty_saat_ini'];
    $qty_dikirim         = $_POST['qty_dikirim'];
    $satuan_dikirim        = $_POST['satuan_dikirim'];
    $qty_dikirim_total     = $_POST['qty_dikirim_total'];
    $tgl_awal_stok_ada     = $_POST['tgl_awal_stok_ada'];
    $harga                = $_POST['harga'];
    $diskon1                = $_POST['diskon1'];
    $diskon2                = $_POST['diskon2'];
    $diskon3                = $_POST['diskon3'];
    $total                  = $_POST['total_harga'];
    $ppn                = $_POST['ppn'];
    $keterangan_dtl        = $_POST['keterangan_dtl'];
    $count                 = count($cb);

    $mySql1       = "INSERT INTO `sj_dtl` (`kode_sj`, `kode_so`, `kode_inventori`, `nama_inventori`, `foc`, `qty_so1`, `satuan_qty_so1`, `qty_so2`, `satuan_qty_so2`, `qty_so3`, `satuan_qty_so3`, `qty_dikirim`, `satuan_dikirim`, `harga`, `diskon1`, `diskon2`, `diskon3`, `ppn`, `subtot`, `total_harga_dtl`, `keterangan_dtl`) VALUES ";

    for ($i = 0; $i < $count; $i++) {
        $pisah = '';
		
		$diskon1x = (mres($harga[$cb[$i]]) - (mres($harga[$cb[$i]]) * (mres($diskon1[$cb[$i]]) / 100)));
		$diskon2x = ($diskon1x - ($diskon1x * (mres($diskon2[$cb[$i]]) / 100)));
		$diskon3x = ($diskon2x - ($diskon2x * (mres($diskon3[$cb[$i]]) / 100)));
        		
		$dpp = (mres(str_replace(',', null, $qty_so3[$cb[$i]])) * $diskon3x);

        if ($ppn[$cb[$i]] == '1') {
            $ppn_n = ($dpp - ($dpp / 1.1)); 
        } else {
            $ppn_n = 0;
        }

        $subtot =  ($dpp - $ppn_n);
        $subtotal =  ($subtot + $ppn_n);
		
        $mySql1 .= $i > 0 ? ", " : '';
		
		$mySql1 .= "(
			'" . mres($no_sj) . "',
			'" . mres($kode_so[$cb[$i]]) . "',
			'" . mres($kode_barang[$cb[$i]]) . "',
			'" . mres($nama_barang[$cb[$i]]) . "',
			'" . mres($foc[$cb[$i]]) . "',
			'" . mres(str_replace(',', null, $qty_so1[$cb[$i]])) . "',
			'" . mres($satuan_qty_so1[$cb[$i]]) . "',
			'" . mres(str_replace(',', null, $qty_so2[$cb[$i]])) . "',
			'" . mres($satuan_qty_so2[$cb[$i]]) . "',
			'" . mres(str_replace(',', null, $qty_so3[$cb[$i]])) . "',
			'" . mres($satuan_qty_so3[$cb[$i]]) . "',
			'" . mres(str_replace(',', null, $qty_dikirim[$cb[$i]])) . "',
			'" . mres($satuan_dikirim[$cb[$i]]) . "',
			'" . mres($harga[$cb[$i]]) . "',
			'" . mres($diskon1[$cb[$i]]) . "',
			'" . mres($diskon2[$cb[$i]]) . "',
			'" . mres($diskon3[$cb[$i]]) . "',
			'" . mres($ppn[$cb[$i]]) . "',
			'" . mres($subtot) . "',
			'" . mres($subtotal) . "',
			'" . mres($keterangan_dtl[$cb[$i]]) . "'
		)";
		
        $grandsubtotal += $subtot;
        $ppntotal +=  $ppn_n;
        $grandtotal += ($subtot + $ppn_n);

        //UNTUK CEK STOK DI BELAKANG TANGGAL BUAT
        $q_cek_stok_saat_itu = "SELECT IFNULL(SUM(`qty_in`) - SUM(`qty_out`), 0) AS `saldo_qty_saat_itu` FROM `crd_stok_dtl` WHERE `kode_barang` = '" . mres($kode_barang[$cb[$i]]) . "' AND `kode_cabang` = '" . $kode_cabang . "' AND `kode_gudang` = '" . $kode_gudang . "' AND `tgl_buat` <= '" . $tgl_buat . "'";

        $res_s_s_i    = mysql_query($q_cek_stok_saat_itu);
        $res_stok_saat_itu = mysql_fetch_array($res_s_s_i);

        $stok_saat_itu    = $res_stok_saat_itu['saldo_qty_saat_itu'];

        //CEK STOK SAAT INI
        $q_stok = "SELECT IFNULL(`saldo_qty`, 0) AS `saldo_qty` FROM `crd_stok` WHERE `kode_barang` = '" . mres($kode_barang[$cb[$i]]) . "' AND `kode_cabang` = '" . $kode_cabang . "' AND `kode_gudang` = '" . $kode_gudang . "'";
        $res_stok_sekarang    = mysql_query($q_stok);

        $num_rows = mysql_num_rows($res_stok_sekarang);
        if ($num_rows > 0) {
            $res_stok = mysql_fetch_array($res_stok_sekarang);
            $stok_sekarang    = $res_stok['saldo_qty'];
        }

        //JIKA JUMLAH QTY MELEBIHI DARI SALDO QTY SEKARANG
        if ($stok_sekarang < str_replace(',', null, $qty_so3[$cb[$i]])) {
            echo "99||STOK TIDAK MEMENUHI!! - " . $kode_barang[$cb[$i]];
            return false;
            //JIKA SALDO QTY SAAT TGL BUAT TSB BELUM ADA
        } elseif ($tgl_buat < $tgl_awal_stok_ada[$cb[$i]]) {
            echo "99||TANGGAL SURAT JALAN TERSEBUT TIDAK DIPERBOLEHKAN !!!";
            return false;
            //JIKA JUMLAH QTY MELEBIHI DARI SALDO QTY SAAT  TGL BUAT
        } elseif ($stok_saat_itu < str_replace(',', null, $qty_so3[$cb[$i]])) {
        	echo "99||STOK TERSEBUT TIDAK DIPERBOLEHKAN !! - " . $kode_barang[$cb[$i]];
        	return false;
        }

        //UNTUK UPDATE SO_DTL NYA JIKA QTY_SJ LEBIH BESAR SAMA DENGAN QTY_SO ALIAS CLOSE
        if (str_replace(',', null, $qty_dikirim[$cb[$i]]) >= str_replace(',', null, $qty_saat_ini[$cb[$i]])) {
            $mySql2 = "UPDATE `so_dtl` SET `status_dtl` = '3' WHERE `kode_so` = '" . mres($kode_so[$cb[$i]]) . "' AND `kode_barang` = '" . mres($kode_barang[$cb[$i]]) . "';";
        } else {
            $mySql2 = "UPDATE `so_dtl` SET `status_dtl` = '1' WHERE `kode_so` = '" . mres($kode_so[$cb[$i]]) . "' AND `kode_barang` = '" . mres($kode_barang[$cb[$i]]) . "';";
        }
        $query2 = mysqli_query($con, $mySql2);

        //INSERT JURNAL DEBET
        $mySql5    = "INSERT INTO `jurnal` SET
							`kode_transaksi`			='" . $kode_sj . "',
							`tgl_buat`				='" . $tgl_buat . "',
							`tgl_input`				='" . $tgl_input . "',
							`kode_cabang`				='" . $kode_cabang . "',
							`kode_pelanggan`			='" . $kode_pelanggan . "',
							`keterangan_hdr`			='" . $keterangan_hdr . "',
							`ref`						='" . $ref . "',
							`kode_coa`				='" . mres($sj_debet[$cb[$i]]) . "',
							`debet`					='" . $subtotal . "',
							`user_pencipta`			='" . $user_pencipta . "';
						";

        $query5 = mysqli_query($con, $mySql5);

        //INSERT JURNAL KREDIT
        $mySql6    = "INSERT INTO `jurnal` SET
							`kode_transaksi`			='" . $kode_sj . "',
							`tgl_buat`				='" . $tgl_buat . "',
							`tgl_input`				='" . $tgl_input . "',
							`kode_cabang`				='" . $kode_cabang . "',
							`kode_pelanggan`			='" . $kode_pelanggan . "',
							`keterangan_hdr`			='" . $keterangan_hdr . "',
							`ref`						='" . $ref . "',
							`kode_coa`				='" . mres($sj_kredit[$cb[$i]]) . "',
							`kredit`					='" . $subtotal . "',
							`user_pencipta`			='" . $user_pencipta . "';
						";

        $query6 = mysqli_query($con, $mySql6);

        //UNTUK CEK ITEM YANG MASUK KE STOK
        $kode_barang1 = mres($kode_barang[$cb[$i]]);
        $q_cekitem       = mysql_query("SELECT `kode_inventori` FROM `inventori` WHERE `kode_inventori` = '" . $kode_barang1 . "' AND `jenis_stok` = '1' AND `kategori` = 'ID'");
        $num_rows = mysql_num_rows($q_cekitem);
        if ($num_rows > 0) {
            //VARIABEL AWAL
            $qty_out_dtl     = mres($qty_dikirim_total[$cb[$i]]);
            $harga_out_dtl     = mres($harga[$cb[$i]]);
            $total_out_dtl     = $qty_out_dtl * $harga_out_dtl;
            $ref_untuk_crd     = 'surat jalan';

            //UNTUK CEK STOK
            $q_cekstok_hdr = mysql_query("SELECT * FROM `crd_stok` WHERE `kode_barang` = '" . $kode_barang1 . "' AND `kode_cabang` = '" . $kode_cabang . "' AND `kode_gudang` = '" . $kode_gudang . "'");
            $num_rows1 = mysql_num_rows($q_cekstok_hdr);
            //JIKA ADA STOK
            if ($num_rows1 > 0) {
                $rowstok_hdr = mysql_fetch_array($q_cekstok_hdr);

                $kd_barang         = $rowstok_hdr['kode_barang'];
                $kd_cabang         = $rowstok_hdr['kode_cabang'];
                $kd_gudang         = $rowstok_hdr['kode_gudang'];
                $qty_in         = $rowstok_hdr['qty_in'];
                $qty_out         = $rowstok_hdr['qty_out'];
                $saldo_qty         = $rowstok_hdr['saldo_qty'];
                $saldo_last_hpp = $rowstok_hdr['saldo_last_hpp'];
                $saldo_total     = $rowstok_hdr['saldo_total'];


                $q_keluar             = $qty_out + $qty_out_dtl;
                $saldo_q             = $qty_in - $q_keluar;
                $saldo_last_hpp1     = ($saldo_last_hpp);
                $saldo_total         = ($saldo_q * $saldo_last_hpp1);

                //UPDATE CRD STOK
                $mySql3 = "UPDATE `crd_stok` SET `tgl_input` = '" . $tgl_input . "', `qty_out` = '" . $q_keluar . "', `saldo_qty` = '" . $saldo_q . "', `saldo_last_hpp` = '" . $saldo_last_hpp1 . "', `saldo_total` = '" . $saldo_total . "' WHERE `kode_barang` = '" . $kode_barang1 . "' AND `kode_cabang` = '" . $kd_cabang . "' AND `kode_gudang` = '" . $kd_gudang . "'";
                $query3 = mysqli_query($con, $mySql3);

                //INSERT CRD STOK DTL
                $mySql4    = "INSERT INTO `crd_stok_dtl` SET
									`kode_barang`				='" . $kode_barang1 . "',
									`tgl_buat`				='" . $tgl_buat . "',
									`tgl_input`				='" . $tgl_input . "',
									`kode_cabang`				='" . $kd_cabang . "',
									`kode_gudang`			='" . $kd_gudang . "',
									`qty_out`					='" . $qty_out_dtl . "',
									`harga_out`				='" . $harga_out_dtl . "',
									`total_out`				='" . $total_out_dtl . "',
									`ref`						='" . $ref_untuk_crd . "',
									`note`					='" . $ref . "',
									`kode_transaksi`			='" . $kode_sj . "';
								";

                $query4 = mysqli_query($con, $mySql4);
            }
        }
    }

    $mySql1 = rtrim($mySql1, ",");
    $query1 = mysqli_query($con, $mySql1);

    //HEADER sj
    $mySql    = "INSERT INTO `sj_hdr` SET
						`kode_sj`					='" . $kode_sj . "',
						`ref`						='" . $ref . "',
						`alamat` 					='" . $alamat . "',
						`keterangan_hdr`			='" . $keterangan_hdr . "',
						`tgl_buat`				='" . $tgl_buat . "',
						`kode_cabang`				='" . $kode_cabang . "',
						`kode_gudang`				='" . $kode_gudang . "',
						`kode_pelanggan`			='" . $kode_pelanggan . "',
						`tgl_input`				='" . $tgl_input . "',
						`total_harga`				='" . $grandsubtotal . "',
						`total_ppn`				='" . $ppntotal . "',
						`user_pencipta`			='" . $user_pencipta . "',
						`subtotal`				='" . $grandtotal . "';
					";

    $query = mysqli_query($con, $mySql);

    if ($query and $query1 and $query2 and $query3 and $query4 and $query5 and $query6) {

        // Commit transaction
        mysqli_commit($con);

        // Close connection
        mysqli_close($con);

        echo "00||" . $kode_sj;
        unset($_SESSION['data_sj']);
        //unset($_SESSION['data_sj'.$id_form .'']);
        //echo "00|| $mySql";

    } else {

        echo "Gagal query: " . mysql_error();
    }
}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "pembatalan") {
    mysqli_autocommit($con, FALSE);

    $kode_sj        = $_POST['kode_sj_batal'];
    $kode_cabang    = $_POST['kode_cabang_batal'];
    $kode_gudang    = $_POST['kode_gudang_batal'];
    $alasan_batal    = $_POST['alasan_batal'];
    $tgl_batal         = date("Y-m-d");
	
	$cekFj = "SELECT `kode_sj` FROM `fj_hdr` WHERE `status` = '1' AND `kode_sj` = '".$kode_sj."'";
	$queryFj = mysqli_query($con, $cekFj);
	
	if (mysqli_num_rows($queryFj) > 0) {
		mysqli_commit($con);
		mysqli_close($con);
		echo "99||Kode SJ " . $kode_sj . " sudah Faktur Jual!";
		return false;
	}
	
    //UPDATE SJ_HDR
    $mySql1 = "UPDATE sj_hdr SET status ='2', alasan_batal = '" . $alasan_batal . "', user_batal = '" . $_SESSION['app_id'] . "', tgl_batal = '" . $tgl_batal . "' WHERE kode_sj='" . $kode_sj . "'";
    $query1 = mysqli_query($con, $mySql1);

    //UPDATE SJ_DTL
    $mySql2 = "UPDATE sj_dtl SET status_dtl ='2' WHERE kode_sj='" . $kode_sj . "'";
    $query2 = mysqli_query($con, $mySql2);

    //JIKA QTY >= QTY_SO STATUS_DTL = 1
    $kode_so = mysql_query("SELECT sd.kode_so, so.qty qty_so, qty_so1, qty_so2 FROM sj_dtl sd LEFT JOIN so_dtl so ON so.kode_so = sd.kode_so AND so.kode_barang = sd.kode_inventori WHERE sd.kode_sj = '" . $kode_sj . "'");
    $num_row_desc = mysql_num_rows($kode_so);

    if ($num_row_desc > 0) {
        while ($row_desc = mysql_fetch_array($kode_so)) {

            $kode     = $row_desc['kode_so'];
            $qty_so = $row_desc['qty_so'];

            if ($row_desc['qty_so1'] == '0') {
                $qty_sj = $row_desc['qty_so2'];
            } else {
                $qty_sj = $row_desc['qty_so1'];
            }

            if ($qty_sj >= $qty_so) {
                $mySql3 = "UPDATE so_dtl SET status_dtl ='1' WHERE kode_so = '" . $kode . "'";
                $query3 = mysqli_query($con, $mySql3);
            } else {
                $mySql3 = "UPDATE so_dtl SET status_dtl ='1' WHERE kode_so = '" . $kode . "'";
                $query3 = mysqli_query($con, $mySql3);
            }
        }
    }

    //INSERT CRD_STOK_DTL
    $kode_barang = mysql_query("SELECT kode_inventori FROM sj_dtl WHERE kode_sj = '" . $kode_sj . "'");
    $num_row_b   = mysql_num_rows($kode_barang);
    if ($num_row_b > 0) {
        while ($row_b = mysql_fetch_array($kode_barang)) {

            $kd_barang = $row_b['kode_inventori'];

            $crd_stok_dtl = mysql_query("SELECT qty_out, harga_out, total_out FROM crd_stok_dtl WHERE kode_barang = '" . $kd_barang . "' AND kode_cabang = '" . $kode_cabang . "' AND kode_gudang = '" . $kode_gudang . "' AND kode_transaksi = '" . $kode_sj . "'");
            $num_row_cd = mysql_num_rows($crd_stok_dtl);
            if ($num_row_cd > 0) {
                $row_cd = mysql_fetch_array($crd_stok_dtl);

                $qty_out   = $row_cd['qty_out'];
                $harga_out = $row_cd['harga_out'];
                $total_out = $row_cd['total_out'];
                $tgl_input = date("Y-m-d H:i:s");

                $mySql5 = "INSERT INTO crd_stok_dtl SET
									kode_barang 	='" . $kd_barang . "',
									tgl_input 		='" . $tgl_input . "',
									kode_cabang 	='" . $kode_cabang . "',
									kode_gudang 	='" . $kode_gudang . "',
									qty_in 			='" . $qty_out . "',
									harga_in 		='" . $harga_out . "',
									total_in 		='" . $total_out . "',
									ref  			='surat jalan batal',
									kode_transaksi  ='" . $kode_sj . "',
									tgl_buat 		='" . $tgl_batal . "'
							";
                $query5 = mysqli_query($con, $mySql5);
            }

            $crd_stok = mysql_query("SELECT * FROM crd_stok WHERE kode_barang = '" . $kd_barang . "' AND kode_cabang = '" . $kode_cabang . "' AND kode_gudang = '" . $kode_gudang . "'");
            $num_row_c = mysql_num_rows($crd_stok);
            if ($num_row_c > 0) {
                $row_c = mysql_fetch_array($crd_stok);

                $qty_masuk          = $row_c['qty_in'];
                $qty_keluar     = $row_c['qty_out'];
                $saldo_total     = $row_c['saldo_total'];
                $saldo_last_hpp = $row_c['saldo_last_hpp'];

                $qty_in         = ($qty_masuk + $qty_out);
                $saldo_qty         = ($qty_in - $qty_keluar);
                $saldo_total1     = ($saldo_qty * $saldo_last_hpp);

                $mySql6 = "UPDATE crd_stok SET
									kode_barang 	='" . $kd_barang . "',
									tgl_input 		='" . $tgl_input . "',
									kode_cabang 	='" . $kode_cabang . "',
									kode_gudang 	='" . $kode_gudang . "',
									qty_in 			='" . $qty_in . "',
									qty_out 		='" . $qty_keluar . "',
									saldo_qty 		='" . $saldo_qty . "',
									saldo_last_hpp 	='" . $saldo_last_hpp . "',
									saldo_total  	='" . $saldo_total1 . "'
									WHERE kode_barang = '" . $kd_barang . "' AND kode_cabang = '" . $kode_cabang . "' AND kode_gudang = '" . $kode_gudang . "'
							";
                $query6 = mysqli_query($con, $mySql6);
            }
        }
    }

    //INSERT JURNAL
    $jurnal = mysql_query("SELECT * FROM jurnal WHERE kode_transaksi = '" . $kode_sj . "'");
    $num_row_j  = mysql_num_rows($jurnal);

    if ($num_row_j > 0) {
        while ($row_j = mysql_fetch_array($jurnal)) {

            $kode_transaksi     = $row_j['kode_transaksi'];
            $ref                 = $row_j['ref'];
            $kode_supplier         = $row_j['kode_supplier'];
            $kode_pelanggan     = $row_j['kode_pelanggan'];
            $kode_coa             = $row_j['kode_coa'];
            $debet                 = $row_j['debet'];
            $kredit             = $row_j['kredit'];
            $keterangan_hdr     = $row_j['keterangan_hdr'];
            $keterangan_dtl     = $row_j['keterangan_dtl'];

            $mySql7 = "INSERT INTO jurnal SET
								kode_transaksi 	='" . $kode_transaksi . "',
								ref 			='" . $ref . "',
								tgl_buat 		='" . $tgl_batal . "',
								kode_cabang 	='" . $kode_cabang . "',
								kode_supplier 	='" . $kode_supplier . "',
								kode_pelanggan 	='" . $kode_pelanggan . "',
								kode_coa 		='" . $kode_coa . "',
								debet  			='" . $kredit . "',
								kredit  		='" . $debet . "',
								tgl_input 		='" . $tgl_input . "',
								keterangan_hdr 	='" . $keterangan_hdr . "',
								keterangan_dtl 	='" . $keterangan_dtl . "'
							";
            $query7 = mysqli_query($con, $mySql7);

            $mySql8 = "UPDATE jurnal SET status_jurnal ='1' WHERE kode_transaksi = '" . $kode_transaksi . "'";
            $query8 = mysqli_query($con, $mySql8);
        }
    }

    if ($query1 and $query2 and $query3 and $query5 and $query6 and $query7 and $query8) {

        mysqli_commit($con);
        mysqli_close($con);

        echo "00||" . $kode_sj;
    } else {
        echo "99||Gagal query: " . mysql_error();
    }
}
