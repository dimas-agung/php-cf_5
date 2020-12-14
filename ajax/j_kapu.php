<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	date_default_timezone_set("Asia/Jakarta");
	error_reporting(0);



	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "kapu-load" ){

		$kode_cabang	= mres($_POST['kode_cabang']);
		$status	= mres($_POST['status']);
		$kode_pelanggan	= mres($_POST['kode_pelanggan']);
		
		if (searchKodeSales2() != '') {
			$queryPelanggan = "SELECT `kode_pelanggan` FROM `pelanggan` WHERE `salesman` = '" . searchKodeSales2() . "'";
			$resultPelanggan = mysql_query($queryPelanggan);
			
			$pelangganSales = [];
			$pelangganSales2 = "";
			if ($kode_pelanggan == '' && mysql_num_rows($resultPelanggan) > 0) {
				while ($rowSales2 = mysql_fetch_array($resultPelanggan)) {
					$pelangganSales[] = $rowSales2['kode_pelanggan'];
				}
				$pelangganSales2 = implode("','", $pelangganSales);
				
				$pelangganSales3 = "`kp`.`kode_pelanggan` IN ('" . $pelangganSales2 . "')";
			} else {
				$pelangganSales3 = "`kp`.`kode_pelanggan` = '".$kode_pelanggan."'";
			}
		} else {
			$pelangganSales3 = "`kp`.`kode_pelanggan` LIKE '%".$kode_pelanggan."%'";
		}
		
		if ($status === '-1' || $status === -1) {
			$lunas = "";
		} else {
			$lunas = "AND `kp`.`lunas` = '" . $status . "'";
		}

		$query	= "SELECT DISTINCT(`kp`.`kode_transaksi`) AS `kode_transaksi`, CASE	WHEN `fjh`.`kode_fj` LIKE '%FJ%' THEN `fjh`.`keterangan_hdr` ELSE NULL END AS `keterangan`,	`kp`.`tgl_buat`, `pel`.`kode_pelanggan`, IFNULL(`fjh`.`tgl_jth_tempo`, `kp`.`tgl_jth_tempo`) AS `tgl_jth_tempo`, `kp`.`kode_pelunasan`, `bkm`.`status` AS `status_bkm`, `kp`.`debet`, `kp`.`kredit`, `cab`.`nama` AS `nama_cabang`,	`pel`.`nama` AS `nama_pelanggan`, `kp`.`tgl_input`, `kp`.`lunas`, `kp`.`track` FROM `kartu_piutang` AS `kp`	LEFT JOIN `fj_hdr` AS `fjh` ON `fjh`.`kode_fj` = `kp`.`kode_transaksi` LEFT JOIN `jurnal` AS `j` ON `j`.`kode_transaksi` = `kp`.`kode_transaksi` LEFT JOIN `bkm_hdr` AS `bkm` ON `bkm`.`kode_bkm` = `kp`.`kode_pelunasan` INNER JOIN `cabang` AS `cab` ON `cab`.`kode_cabang` = `kp`.`kode_cabang` INNER JOIN `pelanggan` AS `pel` ON `pel`.`kode_pelanggan` = `kp`.`kode_pelanggan` WHERE " . $pelangganSales3 . " AND `kp`.`kode_cabang` = '".$kode_cabang."' AND `kp`.`tgl_buat` <= NOW() " . $lunas . " " . searchKodeSales('`pel`.') . " AND LOWER(`kp`.`kode_pelunasan`) NOT LIKE 'pembatalan%' ORDER BY `pel`.`kode_pelanggan`, `kp`.`kode_transaksi`,	`kp`.`tgl_input` ASC";
		/* echo $query;
		die(); */
		$result = mysql_query($query);
		
		$tot_debet = 0;
		$tot_kredit = 0;
		$saldo_cd = 0;
		$saldo_awal = 0;
		$table = '<table class="table-responsive table-striped table-bordered table-condensed">';
		$table .= '<thead>
						<tr>
							<th>
								Kode Pelanggan
							</th>
							<th>
								Nama
							</th>
							<th>
								Kode Transaksi
							</th>
							<th>
								Keterangan
							</th>
							<th>
								Tgl Transaksi
							</th>
							<th>
								Jatuh Tempo
							</th>
							<th>
								Kode Pelunasan
							</th>
							<th>
								Debet
							</th>
							<th>
								Kredit
							</th>
							<th>
								Saldo
							</th>
						</tr>
					</thead><tbody>';
		if (mysql_num_rows($result) > 0) {
			while ($row_kapu = mysql_fetch_array($result)) {
				$CmD = ($row_kapu['debet'] - $row_kapu['kredit']);
				$saldoSekarang = ($saldo_cd + $CmD); 
				$table .= '<tr>
							<td>
								' . $row_kapu['kode_pelanggan'] . '
							</td>
							<td>
								' . $row_kapu['nama_pelanggan'] . '
							</td>
							<td>
								' . $row_kapu['kode_transaksi'] . '
							</td>
							<td>
								' . $row_kapu['keterangan'] . '
							</td>
							<td>
								' . strftime("%A, %d %B %Y", strtotime($row_kapu['tgl_buat'])) . '
							</td>
							<td>
								' . strftime("%A, %d %B %Y", strtotime($row_kapu['tgl_jth_tempo'])) . '
							</td>
							<td>
								' . $row_kapu['kode_pelunasan'] . '
							</td>
							<td class="text-right">
								' . number_format($row_kapu['debet'], 2) . '
							</td>
							<td class="text-right">
								' . number_format($row_kapu['kredit'], 2) . '
							</td>
							<td class="text-right">
								' . number_format($saldoSekarang, 2) . '
							</td>							
							</tr>';
				$tot_debet += $row_kapu['debet'];
				$tot_kredit += $row_kapu['kredit'];
				$saldo_cd += $CmD;
			}
			$table .= '<tr>
						<td colspan="7" class="text-right">
							TOTAL
						</td>
						<td class="text-right">
							' . number_format($tot_debet, 2) . '
						</td>
						<td class="text-right">
							' . number_format($tot_kredit, 2) . '
						</td>
						<td class="text-right">
							-----
						</td>
						</tr>';
		} else {
			$table .= '<tr>
						<td colspan="10" class="text-center">
							Tidak ada data
						</td>
						</tr>';
		}
		$table .= '<tbody></table>';
		header('Content-type: application/json');
		echo json_encode([
			'table' => $table,
		]);
	}


?>
