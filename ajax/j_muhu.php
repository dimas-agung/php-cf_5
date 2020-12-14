<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	date_default_timezone_set("Asia/Jakarta");
	error_reporting(0);



	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "muhu-load" ){

		$kode_cabang	= mres($_POST['kode_cabang']);
		$kode_supplier	= mres($_POST['kode_supplier']);
		$tgl_awal	= date('Y-m-d', strtotime(mres($_POST['tgl_awal'])));
		$tgl_akhir	= date('Y-m-d', strtotime(mres($_POST['tgl_akhir'])));
		
		if($kode_supplier <> '') {
			$union = '';
		} else {
			$union = "UNION
			SELECT `kh`.`kode_supplier`, `nama`, '0' AS `pelunasan`, '0' `pembelian`, IFNULL(`khu`.`saldo_awal`, 0) AS `saldo_awal`, `kh`.`kode_cabang` FROM `kartu_hutang` AS `kh` INNER JOIN `supplier` AS `s` ON `s`.`kode_supplier` = `kh`.`kode_supplier` LEFT JOIN (SELECT `kode_supplier`, IFNULL(SUM(`kredit`-`debet`), 0) AS `saldo_awal`, `kode_cabang`, `tgl_buat` FROM `kartu_hutang` WHERE `kode_cabang` = '".$kode_cabang."' AND `tgl_buat` < '".$tgl_awal."' GROUP BY `kode_supplier`) AS `khu` ON `khu`.`kode_supplier` = `kh`.`kode_supplier` WHERE `kh`.`kode_supplier` NOT IN (SELECT `kode_supplier` FROM `kartu_hutang` WHERE `kode_cabang` = '".$kode_cabang."' AND `tgl_buat` BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."') GROUP BY `kode_supplier`";
		}

		$query	= "SELECT `kode_supplier`, `nama` AS `nama_supplier`, `pembelian`, `pelunasan`, `saldo_awal` FROM (SELECT `kh`.`kode_supplier`, `nama`, IFNULL(SUM(`kh`.`debet`), 0) AS `pelunasan`, IFNULL(SUM(`kh`.`kredit`), 0) AS `pembelian`, IFNULL(`khu`.`saldo_awal`, 0) AS `saldo_awal`, `kh`.`kode_cabang` FROM `kartu_hutang` AS `kh` INNER JOIN `supplier` AS `s` ON `s`.`kode_supplier` = `kh`.`kode_supplier` LEFT JOIN (SELECT `kode_supplier`, IFNULL(SUM(`kredit`-`debet`), 0) AS `saldo_awal`, `kode_cabang`, `tgl_buat` FROM `kartu_hutang` WHERE `kode_cabang` = '".$kode_cabang."' AND `tgl_buat` < '".$tgl_awal."' GROUP BY `kode_supplier`) AS `khu` ON `khu`.`kode_supplier` = `kh`.`kode_supplier` WHERE `kh`.`kode_supplier` LIKE '%".$kode_supplier."%' AND `kh`.`kode_cabang` = '".$kode_cabang."' AND `kh`.`tgl_buat` BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."' GROUP BY `kode_supplier` ".$union.") AS `tbl` WHERE `kode_supplier` IS NOT NULL AND (`pembelian` <> 0 OR `pelunasan` <> 0 OR `saldo_awal` <> 0) GROUP BY `kode_supplier` ORDER BY `nama` ASC";
		
		/* echo $query;
		die(); */
		$result = mysql_query($query);
		
		$tot_s_awal = 0;
		$tot_pelunasan = 0;
		$tot_pembelian = 0;
		$tot_s_akhir = 0;
		$table = '<table class="table-responsive table-striped table-bordered table-condensed">';
		$table .= '<thead>
						<tr>
							<th>
								Kode
							</th>
							<th>
								Supplier
							</th>
							<th>
								Saldo Awal
							</th>
							<th>
								Pembelian
							</th>
							<th>
								Pelunasan
							</th>
							<th>
								Saldo Akhir
							</th>
						</tr>
					</thead><tbody>';
		if (mysql_num_rows($result) > 0) {
			while ($row_muhu = mysql_fetch_array($result)) {
				$saldo_akhir = (($row_muhu['saldo_awal']-$row_muhu['pelunasan']))+($row_muhu['pembelian']);
				$table .= '<tr>
								<td>'.$row_muhu['kode_supplier'].'</td>
								<td>'.$row_muhu['nama_supplier'].'</td>
								<td style="text-align: right">'.number_format($row_muhu['saldo_awal'], 2).'</td>
								<td style="text-align: right">'.number_format($row_muhu['pembelian'], 2).'</td>
								<td style="text-align: right">'.number_format($row_muhu['pelunasan'], 2).'</td>
								<td style="text-align: right">'.number_format($saldo_akhir, 2).'</td>
							</tr>';
							
				$tot_s_awal += $row_muhu['saldo_awal'];
				$tot_pelunasan += $row_muhu['pelunasan'];
				$tot_pembelian += $row_muhu['pembelian'];
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
							' . number_format($tot_pembelian, 2) . '
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
