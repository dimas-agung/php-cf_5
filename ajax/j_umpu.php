<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	date_default_timezone_set("Asia/Jakarta");
	error_reporting(0);



	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "umpu-load" ){

		$kode_cabang	= mres($_POST['kode_cabang']);
		$kode_pelanggan	= mres($_POST['kode_pelanggan']);

		$query	= "SELECT `kp`.`kode_pelanggan`,	`pel`.`nama` AS `nama_pelanggan`,	`kp`.`kode_transaksi`, `kp`.`kredit` AS `nominal`, `kp`.`tgl_buat`, IFNULL(`kp`.`tgl_jth_tempo`, NOW()) AS `tgl_jth_tempo`, `kp`.`lunas`, `kp`.`status_batal`, IFNULL( SUM( `kpu`.`debet` - `kpu`.`kredit` ), 0 ) AS `sisa_piutang` FROM `kartu_piutang` AS `kp`	LEFT JOIN `fj_hdr` AS `fj` ON `fj`.`kode_fj` = `kp`.`kode_transaksi` LEFT JOIN `kartu_piutang` AS `kpu` ON `kpu`.`kode_transaksi` = `kp`.`kode_transaksi` AND `kpu`.`kode_cabang` = `kp`.`kode_cabang` AND `kpu`.`kode_pelanggan` = `kp`.`kode_pelanggan` AND `kpu`.`id_krt_piutang` = `kp`.`id_krt_piutang` INNER JOIN `pelanggan` AS `pel` ON `pel`.`kode_pelanggan` = `kp`.`kode_pelanggan` WHERE `kp`.`kode_cabang` LIKE '%".$kode_cabang."%'  AND `kp`.`kode_pelanggan` LIKE '%".$kode_pelanggan."%' AND ( `kp`.`kode_transaksi` LIKE '%FJ%' OR `kp`.`kode_transaksi` LIKE 'LS23%' ) AND `kp`.`status_batal` = '0' " . searchKodeSales('`pel`.') . " AND `kp`.`kode_transaksi` NOT IN ( SELECT `kode_transaksi` FROM `kartu_piutang` WHERE `kode_pelanggan` = `kp`.`kode_pelanggan` AND `kode_cabang` = `kp`.`kode_cabang` AND `lunas` = '1' ) GROUP BY `kp`.`kode_transaksi` ORDER BY `kp`.`kode_pelanggan` ASC";
		
		/* echo $query;
		die(); */
		$result = mysql_query($query);
		
		$saldo_piutang = 0;
		$a = 0;
		$b = 0;
		$c = 0;
		$d = 0;
		$e = 0;
		$tot_a = 0;
		$tot_b = 0;
		$tot_c = 0;
		$tot_d = 0;
		$tot_e = 0;
		$table = '<table class="table-responsive table-striped table-bordered table-condensed">';
		$table .= '<thead>
						<tr>
							<th rowspan="2">
								Kode
							</th>
							<th rowspan="2">
								Pelanggan
							</th>
							<th rowspan="2">
								Transaksi
							</th>
							<th rowspan="2">
								Tgl Transaksi
							</th>
							<th rowspan="2">
								Tgl Jatuh Tempo
							</th>
							<th rowspan="2">
								Nominal
							</th>
							<th colspan="5">
								Umur Piutang
							</th>
						</tr>
						<tr>
							<th>
								Belum Jatuh Tempo
							</th>
							<th>
								Umur 0 - 30 Hari
							</th>
							<th>
								Umur 31 - 45 Hari
							</th>
							<th>
								Umur 46 - 60 Hari
							</th>
							<th>
								> 60 Hari
							</th>
						</tr>
					</thead><tbody>';
		if (mysql_num_rows($result) > 0) {
			while ($row_umpu = mysql_fetch_array($result)) {
				$piutang = $row_umpu['sisa_piutang'];
				$start_date = strtotime($row_umpu['tgl_buat']); 
				$end_date = strtotime($row_umpu['tgl_jth_tempo']); 
				$umur_ptg = ($end_date - $start_date)/60/60/24;
				switch (true) {
					case ($umur_ptg >= 0 && $umur_ptg <= 30):
						$a = 0;
						$b = $piutang;
						$c = 0;
						$d = 0;
						$e = 0;
						break;
					case ($umur_ptg >= 31 && $umur_ptg <= 45):
						$a = 0;
						$b = 0;
						$c = $piutang;
						$d = 0;
						$e = 0;
						break;
					case ($umur_ptg >= 46 && $umur_ptg <= 60):
						$a = 0;
						$b = 0;
						$c = 0;
						$d = $piutang;
						$e = 0;
						break;
					case ($umur_ptg > 60):
						$a = 0;
						$b = 0;
						$c = 0;
						$d = 0;
						$e = $piutang;
						break;            
					default: 
						$a = $piutang;
						$b = 0;
						$c = 0;
						$d = 0;
						$e = 0;
				}
				$table .= '<tr>
								<td>'.$row_umpu['kode_pelanggan'].'</td>
								<td>'.$row_umpu['nama_pelanggan'].'</td>
								<td>'.$row_umpu['kode_transaksi'].'</td>
								<td>'.strftime("%A, %d %B %Y", strtotime($row_umpu['tgl_buat'])).'</td>
								<td>'.strftime("%A, %d %B %Y", strtotime($row_umpu['tgl_jth_tempo'])).'</td>
								<td style="text-align: right">'.number_format($row_umpu['nominal'], 2).'</td>
								<td style="text-align: right">'.number_format($a, 2).'</td>
								<td style="text-align: right">'.number_format($b, 2).'</td>
								<td style="text-align: right">'.number_format($c, 2).'</td>
								<td style="text-align: right">'.number_format($d, 2).'</td>
								<td style="text-align: right">'.number_format($e, 2).'</td>
							</tr>';
							
				$saldo_piutang += $piutang;
				$tot_a += $a;
				$tot_b += $b;
				$tot_c += $c;
				$tot_d += $d;
				$tot_e += $e;
			}
			$table .= '<tr>
						<td colspan="6" class="text-right">
							TOTAL
						</td>
						<td class="text-right">
							' . number_format($tot_a, 2) . '
						</td>
						<td class="text-right">
							' . number_format($tot_b, 2) . '
						</td>
						<td class="text-right">
							' . number_format($tot_c, 2) . '
						</td>
						<td class="text-right">
							' . number_format($tot_d, 2) . '
						</td>
						<td class="text-right">
							' . number_format($tot_e, 2) . '
						</td>						
						</tr>';
		} else {
			$table .= '<tr>
						<td colspan="11" class="text-center">
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
