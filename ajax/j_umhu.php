<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	date_default_timezone_set("Asia/Jakarta");
	error_reporting(0);



	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "umhu-load" ){

		$kode_cabang	= mres($_POST['kode_cabang']);
		$kode_supplier	= mres($_POST['kode_supplier']);

		$query	= "SELECT `kh`.`kode_supplier`,	`sup`.`nama` AS `nama_supplier`,	`kh`.`kode_transaksi`, `kh`.`kredit` AS `nominal`, `kh`.`tgl_buat`, IFNULL(`kh`.`tgl_jth_tempo`, NOW()) AS `tgl_jth_tempo`, `kh`.`lunas`, `kh`.`status_batal`, IFNULL( SUM( `khu`.`kredit` - `khu`.`debet` ), 0 ) AS `sisa_hutang` FROM `kartu_hutang` AS `kh`	LEFT JOIN `fb_hdr` AS `fb` ON `fb`.`kode_fb` = `kh`.`kode_transaksi` LEFT JOIN `kartu_hutang` AS `khu` ON `khu`.`kode_transaksi` = `kh`.`kode_transaksi` AND `khu`.`kode_cabang` = `kh`.`kode_cabang` AND `khu`.`kode_supplier` = `kh`.`kode_supplier` AND `khu`.`id_krt_hutang` = `kh`.`id_krt_hutang` INNER JOIN `supplier` AS `sup` ON `sup`.`kode_supplier` = `kh`.`kode_supplier` WHERE `kh`.`kode_cabang` LIKE '%".$kode_cabang."%'  AND `kh`.`kode_supplier` LIKE '%".$kode_supplier."%' AND ( `kh`.`kode_transaksi` LIKE '%FB%' OR `kh`.`kode_transaksi` LIKE 'LS13%' ) AND `kh`.`status_batal` = '0' AND `kh`.`kode_transaksi` NOT IN ( SELECT `kode_transaksi` FROM `kartu_hutang` WHERE `kode_supplier` = `kh`.`kode_supplier` AND `kode_cabang` = `kh`.`kode_cabang` AND `lunas` = '1' ) GROUP BY `kh`.`kode_transaksi` DESC";
		
		/* echo $query;
		die(); */
		$result = mysql_query($query);
		
		$saldo_hutang = 0;
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
								Supplier
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
								Umur Hutang
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
			while ($row_umhu = mysql_fetch_array($result)) {
				$hutang = $row_umhu['sisa_hutang'];
				$start_date = strtotime($row_umhu['tgl_buat']); 
				$end_date = strtotime($row_umhu['tgl_jth_tempo']); 
				$umur_htg = ($end_date - $start_date)/60/60/24;
				switch (true) {
					case ($umur_htg >= 0 && $umur_htg <= 30):
						$a = 0;
						$b = $hutang;
						$c = 0;
						$d = 0;
						$e = 0;
						break;
					case ($umur_htg >= 31 && $umur_htg <= 45):
						$a = 0;
						$b = 0;
						$c = $hutang;
						$d = 0;
						$e = 0;
						break;
					case ($umur_htg >= 46 && $umur_htg <= 60):
						$a = 0;
						$b = 0;
						$c = 0;
						$d = $hutang;
						$e = 0;
						break;
					case ($umur_htg > 60):
						$a = 0;
						$b = 0;
						$c = 0;
						$d = 0;
						$e = $hutang;
						break;            
					default: 
						$a = $hutang;
						$b = 0;
						$c = 0;
						$d = 0;
						$e = 0;
				}
				$table .= '<tr>
								<td>'.$row_umhu['kode_supplier'].'</td>
								<td>'.$row_umhu['nama_supplier'].'</td>
								<td>'.$row_umhu['kode_transaksi'].'</td>
								<td>'.strftime("%A, %d %B %Y", strtotime($row_umhu['tgl_buat'])).'</td>
								<td>'.strftime("%A, %d %B %Y", strtotime($row_umhu['tgl_jth_tempo'])).'</td>
								<td style="text-align: right">'.number_format($row_umhu['nominal'], 2).'</td>
								<td style="text-align: right">'.number_format($a, 2).'</td>
								<td style="text-align: right">'.number_format($b, 2).'</td>
								<td style="text-align: right">'.number_format($c, 2).'</td>
								<td style="text-align: right">'.number_format($d, 2).'</td>
								<td style="text-align: right">'.number_format($e, 2).'</td>
							</tr>';
							
				$saldo_hutang += $hutang;
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
