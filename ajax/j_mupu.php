<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	date_default_timezone_set("Asia/Jakarta");
	error_reporting(0);



	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "mupu-load" ){

		$kode_cabang	= mres($_POST['kode_cabang']);
		$kode_pelanggan	= mres($_POST['kode_pelanggan']);
		$tgl_awal	= date('Y-m-d', strtotime(mres($_POST['tgl_awal'])));
		$tgl_akhir	= date('Y-m-d', strtotime(mres($_POST['tgl_akhir'])));
		
		if($kode_pelanggan <> '') {
			$union = '';
		} else {
			$union = "UNION
			SELECT `kp`.`kode_pelanggan`, `nama`, '0' AS `pelunasan`, '0' `penjualan`, IFNULL(`kpu`.`saldo_awal`, 0) AS `saldo_awal`, `kp`.`kode_cabang` FROM `kartu_piutang` AS `kp` INNER JOIN `pelanggan` AS `p` ON `p`.`kode_pelanggan` = `kp`.`kode_pelanggan` LEFT JOIN (SELECT `kode_pelanggan`, IFNULL(SUM(`debet`-`kredit`), 0) AS `saldo_awal`, `kode_cabang`, `tgl_buat` FROM `kartu_piutang` WHERE `kode_cabang` = '".$kode_cabang."' AND `tgl_buat` < '".$tgl_awal."' GROUP BY `kode_pelanggan`) AS `kpu` ON `kpu`.`kode_pelanggan` = `kp`.`kode_pelanggan` WHERE `kp`.`kode_pelanggan` NOT IN (SELECT `kode_pelanggan` FROM `kartu_piutang` WHERE `kode_cabang` = '".$kode_cabang."' AND `tgl_buat` BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."') " . searchKodeSales() . " GROUP BY `kode_pelanggan`";
		}

		$query	= "SELECT `kode_pelanggan`, `nama` AS `nama_pelanggan`, `penjualan`, `pelunasan`, `saldo_awal` FROM (SELECT `kp`.`kode_pelanggan`, `nama`, IFNULL(SUM(`kp`.`kredit`), 0) AS `pelunasan`, IFNULL(SUM(`kp`.`debet`), 0) AS `penjualan`, IFNULL(`kpu`.`saldo_awal`, 0) AS `saldo_awal`, `kp`.`kode_cabang` FROM `kartu_piutang` AS `kp` INNER JOIN `pelanggan` AS `p` ON `p`.`kode_pelanggan` = `kp`.`kode_pelanggan` LEFT JOIN (SELECT `kode_pelanggan`, IFNULL(SUM(`debet`-`kredit`), 0) AS `saldo_awal`, `kode_cabang`, `tgl_buat` FROM `kartu_piutang` WHERE `kode_cabang` = '".$kode_cabang."' AND `tgl_buat` < '".$tgl_awal."' GROUP BY `kode_pelanggan`) AS `kpu` ON `kpu`.`kode_pelanggan` = `kp`.`kode_pelanggan` WHERE `kp`.`kode_pelanggan` LIKE '%".$kode_pelanggan."%' AND `kp`.`kode_cabang` = '".$kode_cabang."' AND `kp`.`tgl_buat` BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."' " . searchKodeSales() . " GROUP BY `kode_pelanggan` ".$union.") AS `tbl` WHERE `kode_pelanggan` IS NOT NULL AND (`penjualan` <> 0 OR `pelunasan` <> 0 OR `saldo_awal` <> 0) GROUP BY `kode_pelanggan` ORDER BY `kode_pelanggan` ASC";
		
		/* echo $query;
		die(); */
		$result = mysql_query($query);
		
		$tot_s_awal = 0;
		$tot_pelunasan = 0;
		$tot_penjualan = 0;
		$tot_s_akhir = 0;
		$table = '<table class="table-responsive table-striped table-bordered table-condensed">';
		$table .= '<thead>
						<tr>
							<th>
								Kode
							</th>
							<th>
								Pelanggan
							</th>
							<th>
								Saldo Awal
							</th>
							<th>
								Penjualan
							</th>
							<th>
								Pelunasan
							</th>
							<th>
								Saldo Akpir
							</th>
						</tr>
					</thead><tbody>';
		if (mysql_num_rows($result) > 0) {
			while ($row_mupu = mysql_fetch_array($result)) {
				$saldo_akhir = (($row_mupu['saldo_awal']-$row_mupu['pelunasan']))+($row_mupu['penjualan']);
				$table .= '<tr>
								<td>'.$row_mupu['kode_pelanggan'].'</td>
								<td>'.$row_mupu['nama_pelanggan'].'</td>
								<td style="text-align: right">'.number_format($row_mupu['saldo_awal'], 2).'</td>
								<td style="text-align: right">'.number_format($row_mupu['penjualan'], 2).'</td>
								<td style="text-align: right">'.number_format($row_mupu['pelunasan'], 2).'</td>
								<td style="text-align: right">'.number_format($saldo_akhir, 2).'</td>
							</tr>';
							
				$tot_s_awal += $row_mupu['saldo_awal'];
				$tot_pelunasan += $row_mupu['pelunasan'];
				$tot_penjualan += $row_mupu['penjualan'];
				$tot_s_akhir += $saldo_akhir;
			}
			$table .= '<tr>
						<td colspan="2" class="text-right">
							TOTAL
						</td>
						<td class="text-right">
							' . number_format($tot_s_awal, 2) . '
						</td>
						<td class="text-right">
							' . number_format($tot_penjualan, 2) . '
						</td>
						<td class="text-right">
							' . number_format($tot_pelunasan, 2) . '
						</td>
						<td class="text-right">
							' . number_format($tot_s_akhir, 2) . '
						</td>						
						</tr>';
		} else {
			$table .= '<tr>
						<td colspan="6" class="text-center">
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
