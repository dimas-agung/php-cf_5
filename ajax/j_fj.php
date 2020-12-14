<?php
session_start();
require('../library/conn.php');
require('../library/helper.php');
require('../pages/data/script/fj.php');
date_default_timezone_set("Asia/Jakarta");

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "loadsj") {

    $kode_pelanggan = $_POST['kode_pelanggan'];

		$q_sj = mysql_query("SELECT
        DISTINCT(`sh`.`kode_sj`) AS `kode_sj`,
        `c`.`kode_cabang`,
        `c`.`nama` AS `nama_cabang`,
        `g`.`kode_gudang`,
        `g`.`nama` AS `nama_gudang`,
        `p`.`kode_pelanggan`,
        `p`.`nama` AS `nama_pelanggan`,
        CONCAT( `k`.`kode_karyawan`, ':', `k`.`nama` ) AS `salesman`
    FROM
        `sj_hdr` `sh`
        JOIN `sj_dtl` AS `sj` ON `sj`.`kode_sj` = `sh`.`kode_sj`
        JOIN `cabang` AS `c` ON `c`.`kode_cabang` = `sh`.`kode_cabang`
        JOIN `gudang` AS `g` ON `g`.`kode_gudang` = `sh`.`kode_gudang`
        JOIN `pelanggan` AS `p` ON `p`.`kode_pelanggan` = `sh`.`kode_pelanggan`
        JOIN `karyawan` AS `k` ON `k`.`kode_karyawan` = `p`.`salesman`
    WHERE
        `sh`.`kode_pelanggan` = '".$kode_pelanggan."'
        AND
        `sh`.`status` = '1'
        AND
        `sj`.`status_dtl` = '1'
    ORDER BY
        `sh`.`kode_sj` ASC");

		$num_rows = mysql_num_rows($q_sj);
		if($num_rows>0)
		{
			echo '<select id="kode_sj" name="kode_sj" class="select2">
					<option value="0">-- Pilih Kode SJ --</option>';

                	while($rowsj = mysql_fetch_array($q_sj)){

                        echo '<option
                        data-kode-cabang="'.$rowsj['kode_cabang'].'"
                        data-nama-cabang="'.$rowsj['nama_cabang'].'"
                        data-kode-gudang="'.$rowsj['kode_gudang'].'"
                        data-nama-gudang="'.$rowsj['nama_gudang'].'"
                        data-kode-pelanggan="'.$rowsj['kode_pelanggan'].'"
                        data-nama-pelanggan="'.$rowsj['nama_pelanggan'].'"
                        data-salesman="'.$rowsj['salesman'].'"
                        value="'.$rowsj['kode_sj'].'"
                        >
                        '.$rowsj['kode_sj'].'
                    </option>';

	 				}

         	echo '</select>';
		}else{
			echo '<select id="kode_sj" name="kode_sj" class="select2" disabled>
                  	<option value="0">-- Tidak Ada SJ--</option>
                  </select>';
		}
}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "loadjt") {

    $kode_sj = $_POST['kode_sj'];
    $tgl_fj = new DateTime($_POST['tgl_fj']);

    $q_jt = mysql_query("SELECT DATE_ADD(DATE_FORMAT('". $tgl_fj->format("Y-m-d") ."','%Y-%m-%d'), INTERVAL p.jatuh_tempo DAY) AS jatuh_tempo_fj FROM sj_hdr sh
								INNER JOIN pelanggan p ON p.kode_pelanggan = sh.kode_pelanggan
								WHERE sh.kode_sj = '$kode_sj' ");

    $num_rows = mysql_num_rows($q_jt);
    if ($num_rows > 0) {
        $rowjt = mysql_fetch_array($q_jt);
        $jatuh_tempo_fj = new DateTime($rowjt['jatuh_tempo_fj']);

        echo '<input type="text" name="tgl_jt_tempo" id="tgl_jt_tempo" class="form-control" placeholder="Pilih Dokumen SJ Dahulu ..." value="' . $jatuh_tempo_fj->format('m/d/Y') . '" readonly/><span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>';
    } else {

        echo '<input type="text" name="tgl_jt_tempo" id="tgl_jt_tempo" class="form-control" placeholder="Pilih Dokumen SJ Dahulu ..." value="" readonly/><span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>';
    }
}


if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "loaditem") {
    $kode_sj     = $_POST['kode_sj'];

    $q_dtl         = mysql_query("SELECT sd.*, i.fj_debet, i.fj_kredit FROM sj_dtl sd
									LEFT JOIN inventori i ON i.kode_inventori = sd.kode_inventori
									WHERE sd.kode_sj = '" . $kode_sj . "' AND sd.status_dtl = '1'
									GROUP BY sd.kode_inventori
									ORDER BY sd.kode_inventori ASC ");

    $num_rows     = mysql_num_rows($q_dtl);
    if ($num_rows > 0) {
        $no         = 0;

        $diskon     = 0;
        $subtotal     = 0;
        $diskon_all = 0;
        $ppn_all     = 0;
        $grand_total = 0;

        while ($rowdtl = mysql_fetch_array($q_dtl)) {

            if ($rowdtl['foc'] == '1') {
                $load_foc = '<span class="glyphicon glyphicon-check"> </span>';
                $stat_foc = '1';
            } else {
                $load_foc = '<span class="glyphicon glyphicon-unchecked"> </span>';
                $stat_foc = '0';
            }

            if ($rowdtl['ppn'] == '1') {
                $ppn       = '<input type="checkbox" name="ppn[]" id="ppn[]" data-id="ppn" data-group="' . $no . '" value="" style="height: 10px; width: 30px;" checked> ';
            } else {
                $ppn       = '<input type="checkbox" name="ppn[]" id="ppn[]" data-id="ppn" data-group="' . $no . '" value="" style="height: 10px; width: 30px;" >';
            }



            echo '<tr>
							<td style="text-align: center;">
								<input class="checkbox" type="checkbox" name="cb[]" id="cb[]" data-id="cb" data-group="' . $no . '" value="' . $no . '">
							</td>
							<td>' . $rowdtl['kode_inventori'] . '
								<input class="form-control" type="hidden" name="kode_inventori[]" id="kode_inventori[]" data-id="kode_inventori" data-group="' . $no . '" value="' . $rowdtl['kode_inventori'] . '" style="width: 7em" />
							</td>
							<td>' . $rowdtl['nama_inventori'] . '
								<input class="form-control" type="hidden" name="nama_inventori[]" id="nama_inventori[]" data-id="nama_inventori" data-group="' . $no . '" value="' . $rowdtl['nama_inventori'] . '" style="width: 7em" />
							</td>
							<td>' . $rowdtl['keterangan_dtl'] . '
								<input class="form-control" type="hidden" name="keterangan_dtl[]" id="keterangan_dtl[]" value="' . $rowdtl['keterangan_dtl'] . '" style="width: 7em" />
								<input class="form-control" type="hidden" name="fj_debet[]" id="fj_debet[]" value="' . $rowdtl['fj_debet'] . '" style="width: 7em" />
								<input class="form-control" type="hidden" name="fj_kredit[]" id="fj_kredit[]" value="' . $rowdtl['fj_kredit'] . '" style="width: 7em" />
							</td>
							<td style="text-align: center">' . $load_foc . '
								<input class="form-control" type="hidden" name="stat_foc[]" id="stat_foc[]" data-id="stat_foc" data-group="' . $no . '" value="' . $stat_foc . '" >
							</td>
							<td style="text-align:right;">' . number_format($rowdtl['qty_so1'], 2) . ' ' . ($rowdtl['satuan_qty_so1']) . ' | ' . number_format($rowdtl['qty_so2'], 2) . ' ' . ($rowdtl['satuan_qty_so2']) . ' | ' . number_format($rowdtl['qty_so3'], 2) . ' ' . ($rowdtl['satuan_qty_so3']) . '
								<input class="form-control" type="hidden" name="qty[]" id="qty[]" data-id="qty" data-group="' . $no . '" value="' . $rowdtl['qty_so3'] . '" style="width: 7em"  />
								<input class="form-control" type="hidden" name="satuan[]" id="satuan[]" data-id="satuan" data-group="' . $no . '" value="' . ($rowdtl['qty_so1']) . ':' . ($rowdtl['satuan_qty_so1']) . '|' . ($rowdtl['qty_so2']) . ':' . ($rowdtl['satuan_qty_so2']) . '|' . ($rowdtl['qty_so3']) . ':' . ($rowdtl['satuan_qty_so3']) . '" style="width: 7em"  />
							</td>
							<td style="text-align:right;">' . number_format($rowdtl['harga'], 2) . '
								<input class="form-control" type="hidden" name="harga[]" id="harga[]" data-id="harga" data-group="' . $no . '" value="' . ($rowdtl['harga']) . '" style="width: 7em"  />
							</td>
							<td style="width: 10%;">
								<input type="text" class="form-control" name="diskon1[]" id="diskon1[]" data-id="diskon1" data-group="' . $no . '" value="' . $rowdtl['diskon1'] . '" style="text-align:right;" autocomplete="off"/>
							</td>
							<td style="width: 10%;">
								<input type="text" class="form-control" name="diskon2[]" id="diskon2[]" data-id="diskon2" data-group="' . $no . '" value="' . $rowdtl['diskon2'] . '" style="text-align:right;" autocomplete="off"/>
							</td>
							<td style="width: 10%;">
								<input type="text" class="form-control" name="diskon3[]" id="diskon3[]" data-id="diskon3" data-group="' . $no . '" value="' . $rowdtl['diskon3'] . '" style="text-align:right;" autocomplete="off"/>
							</td>
							<td style="text-align: center;">' . $ppn . '
								<input class="form-control" type="hidden" name="stat_ppn[]" id="stat_ppn[]" data-id="stat_ppn" data-group="' . $no . '" value="">
							</td>
							<td style="width: 15%;">
								<input type="text" class="form-control" name="nominal[]" id="nominal[]" data-id="nominal" data-group="' . $no++ . '" value="0" style="text-align:right;" readonly/>
							</td>
					</tr>';
        }

        echo '<tr>
						<td colspan="11" style="text-align:right; font-weight:bold">Subtotal</td>
						<td style="width: 15%;">
							<input class="form-control" type="text" name="subtotal_all" id="subtotal_all" autocomplete="off" value="0" readonly style="font-weight:bold; text-align:right;"  />
						</td>
					</tr>

					<tr>
						<td colspan="11" style="text-align:right; font-weight:bold">PPN</td>
						<td style="width: 15%;">
							<input class="form-control" type="text" name="ppn_all" id="ppn_all" autocomplete="off" value="0" readonly style="font-weight:bold; text-align:right;"  />
						</td>
					</tr>

					<tr>
						<td colspan="11" style="text-align:right; font-weight:bold">Total</td>
						<td style="width: 15%;">
							<input class="form-control" type="text" name="grand_total" id="grand_total" autocomplete="off" value="0" readonly style="font-weight:bold; text-align:right;"  />
						</td>
					</tr>
			';
    } else {

        echo '<tr><td colspan="12" class="text-center">Barang di dalam transaksi ini telah terlunasi semua !</td></tr>';
    }
}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "save") {
    mysqli_autocommit($con, FALSE);

    $form                 = 'FJ';
    $thnblntgl             = date("ymd", strtotime($_POST['tgl_fj']));

    $ref                 = ($_POST['ref']);
    $kode_sj             = ($_POST['kode_sj']);
    $kode_cabang         = ($_POST['kode_cabang']);
    $kode_gudang         = ($_POST['kode_gudang']);
    $kode_pelanggan     = ($_POST['kode_pelanggan']);
    $salesman             = ($_POST['salesman']);
    $keterangan_hdr     = ($_POST['keterangan']);
    $tgl_buat             = date("Y-m-d", strtotime($_POST['tgl_fj']));
    $tgl_jth_tempo         = date("Y-m-d", strtotime($_POST['tgl_jt_tempo']));

    $subtotal             = ($_POST['subtotal_all']);
    $diskon_all         = ($_POST['diskon_all']);
    $ppn_all             = ($_POST['ppn_all']);
    $grand_total         = ($_POST['grand_total']);

    $user_pencipta      = $_SESSION['app_id'];
    $tgl_input             = date("Y-m-d H:i:s");

    $kode_fj             = buat_kode_fj($thnblntgl, $form, $kode_cabang);

    //DETAIL FJ
    $no_fj            = $kode_fj;
    $cb             = $_POST['cb'];
    $kode_barang     = $_POST['kode_inventori'];
    $nama_barang     = $_POST['nama_inventori'];
    $foc             = $_POST['stat_foc'];
    $satuan            = $_POST['satuan'];
    $qty            = $_POST['qty'];
    $harga            = $_POST['harga'];
    $diskon1        = $_POST['diskon1'];
    $diskon2        = $_POST['diskon2'];
    $diskon3        = $_POST['diskon3'];
    $ppn            = $_POST['stat_ppn'];
    $total_harga     = $_POST['nominal'];
    $subtotal_all     = $_POST['subtotal_all'];
    $ppn_all     = $_POST['ppn_all'];
    $grand_total     = $_POST['grand_total'];
    $keterangan_dtl    = $_POST['keterangan_dtl'];

    $fj_debet         = $_POST['fj_debet'];
    $fj_kredit        = $_POST['fj_kredit'];
    $count             = count($cb);

    $mySql1   = "INSERT INTO `fj_dtl` (`kode_fj`, `kode_barang`, `nama_barang`, `foc`, `satuan`, `qty`, `harga_jual`, `diskon1`, `diskon2`, `diskon3`, `ppn`, `total_harga`, `keterangan_dtl`) VALUES ";

    for ($i = 0; $i < $count; $i++) {

        $mySql1 .= $i > 0 ? ", " : '';
        $mySql1 .= "(
			'" . $no_fj . "',
			'" . $kode_barang[$cb[$i]] . "',
			'" . $nama_barang[$cb[$i]] . "',
			'" . $foc[$cb[$i]] . "',
			'" . $satuan[$cb[$i]] . "',
			'" . str_replace(',', null, $qty[$cb[$i]]) . "',
			'" . str_replace(',', null, $harga[$cb[$i]]) . "',
			'" . str_replace(',', null, $diskon1[$cb[$i]]) . "',
			'" . str_replace(',', null, $diskon2[$cb[$i]]) . "',
			'" . str_replace(',', null, $diskon3[$cb[$i]]) . "',
			'" . $ppn[$cb[$i]] . "',
			'" . str_replace(',', null, $total_harga[$cb[$i]]) . "',
			'" . $keterangan_dtl[$cb[$i]] . "'
		)";        
		
		$diskon1x = str_replace(',', null, $harga[$cb[$i]]) - (str_replace(',', null, $harga[$cb[$i]]) * (str_replace(',', null, $diskon1[$cb[$i]]) / 100));
		$diskon2x = $diskon1x - ($diskon1x * (str_replace(',', null, $diskon2[$cb[$i]]) / 100));
		$diskon3x = ($diskon2x - ($diskon2x * (str_replace(',', null, $diskon3[$cb[$i]]) / 100))) * str_replace(',', null, $qty[$cb[$i]]);
		
		if ($ppn[$cb[$i]]) {
			$nilai_ppn = ($diskon3x - ($diskon3x / 1.1));
		} else {
			$nilai_ppn = 0;
		}
		
		//INSERT JURNAL KREDIT
		$mySql3    = "INSERT INTO `jurnal` SET
							`kode_transaksi`			='" . $kode_fj . "',
							`tgl_buat`				='" . $tgl_buat . "',
							`tgl_input`				='" . $tgl_input . "',
							`kode_cabang`				='" . $kode_cabang . "',
							`kode_pelanggan`			='" . $kode_pelanggan . "',
							`keterangan_hdr`			='" . $keterangan_hdr . "',
							`ref`						='" . $ref . "',
							`kode_coa`				='" . $fj_kredit[$i] . "',
							`kredit`					='" . ($diskon3x - $nilai_ppn) . "',
							`user_pencipta`			='" . $user_pencipta . "';
						";
		$query3 = mysqli_query($con, $mySql3);

		//INSERT JURNAL DEBET
		$mySql4    = "INSERT INTO `jurnal` SET
							`kode_transaksi`			='" . $kode_fj . "',
							`tgl_buat`				='" . $tgl_buat . "',
							`tgl_input`				='" . $tgl_input . "',
							`kode_cabang`				='" . $kode_cabang . "',
							`kode_pelanggan`			='" . $kode_pelanggan . "',
							`keterangan_hdr`			='" . $keterangan_hdr . "',
							`ref`						='" . $ref . "',
							`kode_coa`				='" . $fj_debet[$i] . "',
							`debet`					='" . $diskon3x . "',
							`user_pencipta`			='" . $user_pencipta . "';
						";
		$query4 = mysqli_query($con, $mySql4);
		
		if ($nilai_ppn > 0) {
			//INSERT JURNAL PPN KREDIT
			$mySql6    = "INSERT INTO `jurnal` SET
								`kode_transaksi`			='" . $kode_fj . "',
								`tgl_buat`				='" . $tgl_buat . "',
								`tgl_input`				='" . $tgl_input . "',
								`kode_cabang`				='" . $kode_cabang . "',
								`kode_pelanggan`			='" . $kode_pelanggan . "',
								`keterangan_hdr`			='" . $keterangan_hdr . "',
								`ref`						='" . $ref . "',
								`kode_coa`				='2.01.07.03',
								`kredit`					='" . $nilai_ppn . "',
								`user_pencipta`			='" . $user_pencipta . "';
							";
			$query6 = mysqli_query($con, $mySql6);		
		}
		else {
			$query6 = true;
		}
		
        $mySql5    = "UPDATE `sj_dtl` SET `status_dtl` = '3' WHERE `kode_sj` = '" . $kode_sj . "' AND `kode_inventori` = '".$kode_barang[$cb[$i]]."'";
        $query5 = mysqli_query($con, $mySql5);
    }
	
    $mySql1 = rtrim($mySql1, ",");
    $query1 = mysqli_query($con, $mySql1);

    //KARTU PIUTANG
    $mySql2    = " INSERT INTO `kartu_piutang` SET
						`kode_transaksi` 	='" . $kode_fj . "',
						`debet` 			='" . str_replace(',', null, $grand_total) . "',
					    `kode_pelanggan` 	='" . $kode_pelanggan . "',
						`kode_cabang` 	='" . $kode_cabang . "',
						`tgl_buat` 		='" . $tgl_buat . "',
						`tgl_jth_tempo` 	='" . $tgl_jth_tempo . "',
						`user_pencipta` 	='" . $user_pencipta . "',
						`tgl_input`		='" . $tgl_input . "'
					";

    $query2 = mysqli_query($con, $mySql2);

    //HEADER FJ
    $mySql    = "INSERT INTO `fj_hdr` SET
						`kode_fj`					='" . $kode_fj . "',
						`ref`						='" . $ref . "',
						`kode_sj`					='" . $kode_sj . "',
						`kode_cabang`				='" . $kode_cabang . "',
						`kode_gudang`				='" . $kode_gudang . "',
						`kode_pelanggan`			='" . $kode_pelanggan . "',
						`salesman`				='" . $salesman . "',
						`keterangan_hdr`			='" . $keterangan_hdr . "',
						`tgl_buat`				='" . $tgl_buat . "',
						`tgl_jth_tempo`			='" . $tgl_jth_tempo . "',
						`subtotal`				='" . str_replace(',', null, $subtotal_all) . "',
						`ppn_all`					='" . str_replace(',', null, $ppn_all) . "',
						`grand_total`				='" . str_replace(',', null, $grand_total) . "',
						`user_pencipta`			='" . $user_pencipta . "',
						`tgl_input`				='" . $tgl_input . "'
					";
    $query = mysqli_query($con, $mySql);
	
    if ($query and $query1 and $query2 and $query3 and $query4 and $query5 and $query6) {

        // Commit transaction
        mysqli_commit($con);

        // Close connection
        mysqli_close($con);

        echo "00||" . $kode_fj;
        unset($_SESSION['data_fj']);
    } else {

        echo "Gagal query: " . mysql_error();
    }
}


if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "pembatalan") {
    mysqli_autocommit($con, FALSE);

    $kode_fj        = $_POST['kode_fj_batal'];
    $alasan_batal    = $_POST['alasan_batal'];
    $tgl_batal         = date("Y-m-d");
	
	$cekBkm = "SELECT `deskripsi` FROM `bkm_dtl` WHERE `status_dtl` = '0' AND `deskripsi` = '".$kode_fj."'";
	$queryBkm = mysqli_query($con, $cekBkm);

	if (mysqli_num_rows($queryBkm) > 0) {
		mysqli_commit($con);
		mysqli_close($con);
		echo "99||Kode FJ " . $kode_fj . " sudah Bukti Kas Masuk!";
		return false;
	}
	
	$cekGm = "SELECT `deskripsi` FROM `gm_dtl` WHERE `status_dtl` = '1' AND `deskripsi` = '".$kode_fj."'";
	$queryGm = mysqli_query($con, $cekGm);

	if (mysqli_num_rows($queryGm) > 0) {
		mysqli_commit($con);
		mysqli_close($con);
		echo "99||Kode FJ " . $kode_fj . " sudah Giro Masuk!";
		return false;
	}

    //UPDATE FJ_HDR
    $mySql1 = "UPDATE fj_hdr SET status ='2', alasan_batal = '" . $alasan_batal . "', user_batal = '" . $_SESSION['app_id'] . "', tgl_batal = '" . $tgl_batal . "' WHERE kode_fj='" . $kode_fj . "' ";
    $query1 = mysqli_query($con, $mySql1);

    //UPDATE FJ_DTL
    $mySql2 = "UPDATE fj_dtl SET status_dtl ='2' WHERE kode_fj='" . $kode_fj . "' ";
    $query2 = mysqli_query($con, $mySql2);

    $kode_sj = mysql_query("SELECT kode_sj FROM fj_hdr WHERE kode_fj = '" . $kode_fj . "'");
    $num_row_desc = mysql_num_rows($kode_sj);

    if ($num_row_desc > 0) {
        while ($row_desc = mysql_fetch_array($kode_sj)) {

            $kode     = $row_desc['kode_sj'];

            $mySql3 = "UPDATE sj_hdr SET status ='1' WHERE kode_sj = '" . $kode . "' ";
            $query3 = mysqli_query($con, $mySql3);

            $mySql4 = "UPDATE sj_dtl SET status_dtl ='1' WHERE kode_sj = '" . $kode . "' ";
            $query4 = mysqli_query($con, $mySql4);
        }
    }

    //INSERT KARTU_PIUTANG
    $piutang = mysql_query("SELECT * FROM kartu_piutang WHERE kode_transaksi = '" . $kode_fj . "'");
    $num_row_p  = mysql_num_rows($piutang);

    if ($num_row_p > 0) {
        while ($row_p = mysql_fetch_array($piutang)) {

            $kode_transaksi     = $row_p['kode_transaksi'];
            $debet                 = $row_p['debet'];
            $kredit             = $row_p['kredit'];
            $kode_cabang         = $row_p['kode_cabang'];
            $kode_pelanggan     = $row_p['kode_pelanggan'];
            $tgl_jth_tempo         = $row_p['tgl_jth_tempo'];
            $tgl_input             = date("Y-m-d H:i:s");

            $mySql5 = "INSERT INTO kartu_piutang SET
								kode_transaksi 	='" . $kode_transaksi . "',
								debet 			='" . $kredit . "',
								kredit 			='" . $debet . "',
								kode_cabang 	='" . $kode_cabang . "',
								kode_pelanggan 	='" . $kode_pelanggan . "',
								tgl_buat  		='" . $tgl_batal . "',
								tgl_jth_tempo  	='" . $tgl_jth_tempo . "',
								tgl_input 		='" . $tgl_input . "'
							";
            $query5 = mysqli_query($con, $mySql5);

            $mySql6 = "UPDATE kartu_piutang SET status_batal ='1' WHERE kode_transaksi = '" . $kode_transaksi . "' ";
            $query6 = mysqli_query($con, $mySql6);
        }
    }

    //INSERT JURNAL
    $jurnal = mysql_query("SELECT * FROM jurnal WHERE kode_transaksi = '" . $kode_fj . "' ");
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

            $mySql8 = "UPDATE jurnal SET status_jurnal ='1' WHERE kode_transaksi = '" . $kode_transaksi . "' ";
            $query8 = mysqli_query($con, $mySql8);
        }
    }

    if ($query1 and $query2 and $query3 and $query5 and $query6 and $query7 and $query8) {

        mysqli_commit($con);
        mysqli_close($con);

        echo "00||" . $kode_fj;
    } else {
        echo "99||Gagal query: " . mysql_error();
    }
}
