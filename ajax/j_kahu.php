<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	date_default_timezone_set("Asia/Jakarta");
	error_reporting(0);



	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "kahu-load" ){

		$kode_cabang	= mres($_POST['kode_cabang']);
		$status	= mres($_POST['status']);
		$kode_supplier	= mres($_POST['kode_supplier']);
		
		if ($status === '-1' || $status === -1) {
			$lunas = "";
		} else {
			$lunas = "AND `kh`.`lunas` = '" . $status . "'";
		}

		$query	= "SELECT DISTINCT (`kh`.`kode_transaksi`) AS `kode_transaksi`, CASE WHEN `fbh`.`kode_fb` LIKE '%FB%' THEN `fbh`.`keterangan_hdr` ELSE NULL	END AS `keterangan`, `kh`.`tgl_buat`, IFNULL(`fbh`.`tgl_jth_tempo`, `kh`.`tgl_jth_tempo`) AS `tgl_jth_tempo`, `kh`.`kode_pelunasan`, `bkk`.`status` AS `status_bkk`,	`kh`.`debet`, `kh`.`kredit`, `cab`.`nama` AS `nama_cabang`, `sup`.`nama` AS `nama_supplier`, `kh`.`tgl_input`,	`kh`.`lunas`, `kh`.`track` FROM `kartu_hutang` AS `kh` LEFT JOIN `fb_hdr` AS `fbh` ON `fbh`.`kode_fb` = `kh`.`kode_transaksi` LEFT JOIN `jurnal` AS `j` ON `j`.`kode_transaksi` = `kh`.`kode_transaksi` LEFT JOIN `bkk_hdr` AS `bkk` ON `bkk`.`kode_bkk` = `kh`.`kode_pelunasan` INNER JOIN `cabang` AS `cab` ON `cab`.`kode_cabang` = `kh`.`kode_cabang` INNER JOIN `supplier` AS `sup` ON `sup`.`kode_supplier` = `kh`.`kode_supplier` WHERE `kh`.`kode_supplier` = '".$kode_supplier."' AND `kh`.`kode_cabang` = '".$kode_cabang."' AND `kh`.`tgl_buat` <= NOW() ".$lunas." ORDER BY `kh`.`kode_transaksi`, `kh`.`tgl_input` ASC";
		$result = mysql_query($query);
		
		$tot_debet = 0;
		$tot_kredit = 0;
		$saldo_cd = 0;
		$saldo_awal = 0;
		$table = '<table class="table-responsive table-striped table-bordered table-condensed">';
		$table .= '<thead>
						<tr>
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
			while ($row_kahu = mysql_fetch_array($result)) {
				$CmD = ($row_kahu['kredit'] - $row_kahu['debet']);
				$saldoSekarang = ($saldo_cd + $CmD); 
				$table .= '<tr>
							<td>
								' . $row_kahu['kode_transaksi'] . '
							</td>
							<td>
								' . $row_kahu['keterangan'] . '
							</td>
							<td>
								' . strftime("%A, %d %B %Y", strtotime($row_kahu['tgl_buat'])) . '
							</td>
							<td>
								' . strftime("%A, %d %B %Y", strtotime($row_kahu['tgl_jth_tempo'])) . '
							</td>
							<td>
								' . $row_kahu['kode_pelunasan'] . '
							</td>
							<td class="text-right">
								' . number_format($row_kahu['debet'], 2) . '
							</td>
							<td class="text-right">
								' . number_format($row_kahu['kredit'], 2) . '
							</td>
							<td class="text-right">
								' . number_format($saldoSekarang, 2) . '
							</td>							
							</tr>';
				$tot_debet += $row_kahu['debet'];
				$tot_kredit += $row_kahu['kredit'];
				$saldo_cd += $CmD;
			}
			$table .= '<tr>
						<td colspan="5" class="text-right">
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
						<td colspan="8" class="text-center">
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
