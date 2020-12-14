<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	date_default_timezone_set("Asia/Jakarta");
	error_reporting(0);



	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "kartustok-load" ){

		$tgl_awal		= date("Y-m-d",strtotime($_POST['tgl_awal']));
		$tgl_akhir		= date("Y-m-d",strtotime($_POST['tgl_akhir']));
		$kode_cabang	= $_POST['kode_cabang'];
		$kode_gudang	= $_POST['kode_gudang'];
		$kode_barang	= $_POST['kode_barang'];

		$query	= " SELECT csd.kode_transaksi, csd.kode_barang, i.nama nama_barang, c.nama nama_cabang, g.nama nama_gudang, csd.qty_in, csd.harga_in, csd.total_in, csd.qty_out, csd.harga_out, csd.total_out, csh.saldo_last_hpp,
					(SELECT (DATE_FORMAT(csd.tgl_buat, '%d/%m/%Y'))) tgl_transaksi,
					(SELECT DISTINCT(j.status_jurnal) FROM jurnal j WHERE j.kode_transaksi = csd.kode_transaksi) status_batal, csd.tgl_buat, csd.note
					FROM crd_stok_dtl csd
					INNER JOIN crd_stok csh ON csh.kode_barang = csd.kode_barang
					LEFT JOIN cabang c ON c.kode_cabang = csh.kode_cabang AND c.kode_cabang = csd.kode_cabang
					LEFT JOIN gudang g ON g.kode_gudang = csh.kode_gudang AND g.kode_gudang = csd.kode_gudang
					LEFT JOIN inventori i ON i.kode_inventori = csh.kode_barang AND i.kode_inventori = csd.kode_barang
					WHERE csd.kode_barang = '".$kode_barang."' AND csd.kode_cabang = '".$kode_cabang."' AND csd.kode_gudang = '".$kode_gudang."' AND csd.tgl_buat BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."'
					GROUP BY id_crd_stok_dtl
					ORDER BY csd.tgl_buat, csd.tgl_input ASC ";
		$result = mysql_query($query);


		$queryhdr 	= " SELECT (SELECT nama FROM satuan WHERE kode_satuan = SUBSTRING_INDEX(i.satuan_jual, ':', 1)) satuan_jual,
						(SELECT nama FROM satuan WHERE kode_satuan = SUBSTRING_INDEX(i.satuan_beli, ':', 1)) satuan_beli,
						i.isi, i.nama nama_barang, c.nama AS nama_cabang, g.nama AS nama_gudang,
						(SELECT (DATE_FORMAT(csd.tgl_buat, '%d/%m/%Y'))) tgl_transaksi
						FROM crd_stok_dtl csd
						LEFT JOIN inventori i ON i.kode_inventori = csd.kode_barang
						LEFT JOIN satuan s ON s.kode_satuan = SUBSTRING_INDEX(i.satuan_jual, ':', 1) AND s.kode_satuan = SUBSTRING_INDEX(i.satuan_beli, ':', 1)
						LEFT JOIN cabang c ON c.kode_cabang = csd.kode_cabang
						LEFT JOIN gudang g ON g.kode_gudang = csd.kode_gudang
						WHERE csd.kode_barang = '".$kode_barang."' AND csd.kode_cabang = '".$kode_cabang."' AND csd.kode_gudang = '".$kode_gudang."'
						GROUP BY id_crd_stok_dtl
						ORDER BY tgl_transaksi ASC";
		$resulthdr 	= mysql_query($queryhdr);


		$saldo_awal	= "SELECT IFNULL(qty_in, 0) qty_in, IFNULL(qty, 0) qty, IFNULL(isi, 0) isi, IFNULL(total_qty, 0) total_qty, IFNULL(total_in, 0) total_in, IFNULL(map, 0) map, IFNULL(total, 0) total FROM (SELECT (SUM(qty_in)) qty_in, ((SUM(qty_in)-SUM(qty_out))/i.isi) qty, i.isi isi, (SUM(qty_in)-SUM(qty_out)) total_qty, (SUM(total_in)) total_in, (SUM(total_in)/SUM(qty_in)) map, ((SUM(qty_in)-SUM(qty_out))*(SUM(total_in)/SUM(qty_in))) total FROM crd_stok_dtl LEFT JOIN inventori i ON i.kode_inventori = crd_stok_dtl.kode_barang WHERE kode_barang = '".$kode_barang."' AND kode_cabang = '".$kode_cabang."' AND kode_gudang = '".$kode_gudang."' AND tgl_buat < '".$tgl_awal."' AND kategori = 'BJ' ) AS tbl ";

        $saldoawal 	= mysql_query($saldo_awal);

        $cariTglAwal = "SELECT MIN(`tgl_buat`) AS `tgl_buat` FROM `crd_stok_dtl` WHERE `kode_barang` = '".$kode_barang."' AND `kode_cabang` = '".$kode_cabang."' AND `kode_gudang` = '".$kode_gudang."'";
        $resultTglAwal = mysql_query($cariTglAwal);
        $tglAwal = null;

        if (mysql_num_rows($resultTglAwal) > 0) {
            while ($rowTglAwal = mysql_fetch_array($resultTglAwal)) {
                $tglAwal = $rowTglAwal['tgl_buat'];
            }
        }

        $oldAverageSA = [0];
        $currentAverageSA = 0;
        $currentQuantitySA = 0;
        $stokAwalSA = 0;
		if (!empty($tglAwal)) {
			$cariStokAwal = "SELECT `qty_in`, `qty_out`, `harga_in` FROM `crd_stok_dtl` WHERE `tgl_buat` BETWEEN '" . $tglAwal . "' AND '" . date('Y-m-d', strtotime('-1 day', strtotime($tgl_awal))) . "' AND `kode_barang` = '".$kode_barang."' AND `kode_cabang` = '".$kode_cabang."' AND `kode_gudang` = '".$kode_gudang."' ORDER BY `tgl_buat`,`tgl_input` ASC";
			//$stokAwalSA = $cariStokAwal;
			$resultStokAwal = mysql_query($cariStokAwal);
			$i = 0;
			if (mysql_num_rows($resultStokAwal)) {
				while ($rowStokAwal = mysql_fetch_array($resultStokAwal)) {
					$stokAwalSA += $rowStokAwal['qty_in']-$rowStokAwal['qty_out'];
					$quantitySA = $rowStokAwal['qty_in']-$rowStokAwal['qty_out'];
					$costPerItemSA = $rowStokAwal['harga_in'];
					if (!$currentAverageSA || !$currentQuantitySA) {
						$currentAverageSA = $costPerItemSA;
						$currentQuantitySA = $quantitySA;
						$oldAverageSA[$i] = $currentAverageSA;
					} else {
						if ($quantitySA > 0) {
							$currentAverageSA = calculateNewAverage($currentAverageSA, $currentQuantitySA, $quantitySA, $costPerItemSA);
							$oldAverageSA[$i] = $currentAverageSA;
						}
						$currentQuantitySA += $quantitySA;
					}
					$i++;
				}
			}
			//$stokAwalSA = end($oldAverageSA);

		}

	    $periode = "";
		if($_POST['tgl_awal'] != "" and $_POST['tgl_akhir'] != "") {
			$periode = strftime("%A, %d %B %Y", strtotime($_POST['tgl_awal'])) . ' => ' . strftime("%A, %d %B %Y", strtotime($_POST['tgl_akhir']));
		}
		if(mysql_num_rows($result) > 0) {
				echo view_kartu_stok($result, $resulthdr, $saldoawal, $periode, $stokAwalSA, end($oldAverageSA));
		}else{
			echo view_kartu_stok($result, $resulthdr, $saldoawal, $periode, $stokAwalSA, end($oldAverageSA));
		}

		$_SESSION['q_ks'] 	= $query;
		$_SESSION['q_jdl'] 	= $periode;

	}

	function view_kartu_stok($result, $resulthdr, $saldoawal, $periode, $stokAwalSA, $currentAverageSA) {
		$n = 1;
		$html = '';
	    $kode_cabang	= $_POST['kode_cabang'];
		$kode_gudang	= $_POST['kode_gudang'];
		$kode_barang	= $_POST['kode_barang'];

		if (mysql_num_rows($resulthdr) > 0) {
			while ($item = mysql_fetch_array($resulthdr)){
				$nama_barang	= $item['nama_barang'];
				$nama_cabang 	= $item['nama_cabang'];
				$nama_gudang 	= $item['nama_gudang'];
				$satuan_jual	= $item['satuan_jual'];
				$satuan_beli	= $item['satuan_beli'];
				$isi			= $item['isi'];
			}

			$_sodtl = 'SELECT `satuan` AS `satuan_ikat`, `konversi1` FROM `so_dtl` WHERE `kode_barang` = \'' . $kode_barang . '\'';
			$sodtl = mysql_query($_sodtl);
			$sodtl = mysql_num_rows($sodtl) > 0 ? mysql_fetch_array($sodtl) : array();
			$satuan_ikat = is_array($sodtl) && count($sodtl) > 0 ? $sodtl['satuan_ikat'] : null;
			$konversi1 = is_array($sodtl) && count($sodtl) > 0 ? $sodtl['konversi1'] : null;

			$_inventori = 'SELECT SUBSTRING_INDEX(REPLACE(REPLACE(REPLACE(`satuan_beli`, \' \', \'\'), \'\t\', \'\'), \'\n\', \'\'), \':\', -1) AS `satuan_kecil`, SUBSTRING_INDEX(REPLACE(REPLACE(REPLACE(`satuan_jual`, \' \', \'\'), \'\t\', \'\'), \'\n\', \'\'), \':\', -1) AS `satuan_besar`, `isi` AS `konversi` FROM `inventori` WHERE `kode_inventori` = \'' . $kode_barang . '\'';
			$inventori = mysql_query($_inventori);
			$inventori = mysql_num_rows($inventori) > 0 ? mysql_fetch_array($inventori) : array();
			$satuan_kecil = is_array($inventori) && count($inventori) > 0 ? $inventori['satuan_kecil'] : null;
			$satuan_besar = is_array($inventori) && count($inventori) > 0 ? $inventori['satuan_besar'] : null;
			$konversi = is_array($inventori) && count($inventori) > 0 ? $inventori['konversi'] : null;

			$html .= '
				  <div class="form-group row">
	                <label class="col-sm-1 control-label">Barang :</label>
	                    <div class="col-sm-5">
	                    	<input type="text" required class="form-control" value="'.$kode_barang . ' - ' . $nama_barang.'" readonly>
	                    </div>

					<label class="col-sm-1 control-label">Tanggal :</label>
	                    <div class="col-sm-5">
	                        <input type="text" required class="form-control" value="'.$periode.'" readonly>
	                    </div>
	              </div>

	              <div class="form-group row">
	                <label class="col-sm-1 control-label">Cabang :</label>
	                    <div class="col-sm-5">
	                       <input type="text" required class="form-control" value="'.$nama_cabang.'" readonly>
	                    </div>

					<label class="col-sm-1 control-label">Gudang :</label>
	                    <div class="col-sm-5">
	                       <input type="text" required class="form-control" value="'.$nama_gudang.'" readonly>
	                    </div>
	              </div>
			';
			while ($item2 = mysql_fetch_array($saldoawal)){
				$qty_awal 		= $item2['qty'];
				$isi_awal 		= $item2['isi'];
				$qty_in_awal 	= $item2['qty_in'] / $isi_awal;
				$total_qty_awal = $item2['total_qty'];

				$map_awal 		= $item2['map'];
				$total_awal1 	= $item2['total'];
				$total_awal 	= $map_awal * $total_qty_awal;
				$total_in_awal 	= $item2['total_in'];
			}
			$html .= '
				<table class="table-responsive table-striped table-bordered table-condensed">
					<thead>
						<tr>
							<th rowspan="2">
								Tanggal Transaksi
							</th>
							<th rowspan="2">
								Kode Transaksi
							</th>
							<th rowspan="2">
								Ref
							</th>
							<th colspan="2">
								Stok Masuk
							</th>
							<th>
								Stok Keluar
							</th>
							<th colspan="2">
								Saldo
							</th>
						</tr>
						<tr>
							<th>
								Q Masuk
                            </th>
                            <th>
								@Harga
							</th>
							<th>
								Q Keluar
							</th>
							<th>
								Jumlah
                            </th>
                            <th>
								HPP
							</th>
						</tr>
					</thead>

					<tbody>
			';
			$html .= '<tr>
						<td colspan="3" style="text-align: center;">
							<strong>Saldo Awal</strong>
						</td>
						<td style="text-align: right;">
							' . number_format($stokAwalSA, 2) . '
                        </td>
                        <td style="text-align: right;">
                            ' . number_format(($currentAverageSA), 2) . '
						</td>
						<td style="text-align: right;">
                            0
						</td>
                        <td style="text-align: right;">
							' . number_format($stokAwalSA, 2) . '
                        </td>
                        <td style="text-align: right;">
                            ' . number_format(($currentAverageSA), 2) . '
						</td>
					</tr>
            ';
            $currentAverage = $currentAverageSA;
            $currentQuantity = $stokAwalSA;
            $i = 0;
            $newAverage = [];
			while ($item3 = mysql_fetch_array($result)) {

                $saldo = ($stokAwalSA + $item3['qty_in']) - $item3['qty_out'];

                $quantity = $item3['qty_in'] - $item3['qty_out'];
                $costPerItem = $item3['harga_in'];
                if (!$currentAverage || !$currentQuantity) {
                    $currentAverage = $costPerItem;
                    $currentQuantity = $quantity;
                    $newAverage[$i] = $currentAverage;
                } else {
                    if ($quantity > 0) {
                        $currentAverage = calculateNewAverage($currentAverage, $currentQuantity, $quantity, $costPerItem);
                        $newAverage[$i] = $currentAverage;
                    } else {
                        $newAverage[$i] = $currentAverage;
                    }
                    $currentQuantity += $quantity;
                }


				if ($i == 0) {
					$saldoakhir = $saldo;
				}
				elseif ($i > 0) {
					$qty_saldo = $item3['qty_in'] - $item3['qty_out'];
					$saldoakhir = $saldoakhir + $qty_saldo;
				}
				
				if (strpos(strtolower($item3['kode_transaksi']), 'sj')) {
					$kdt = '<a href="'.base_url().'?page=logistik/sj_track&action=track&halaman= TRACK SURAT JALAN&kode_sj='.$item3['kode_transaksi'].'" target="_blank">'.$item3['kode_transaksi'].'</a>';
				} else {
					$kdt = $item3['kode_transaksi'];
				}

				$html .= '<tr>
								<td style="text-align: right;">
									' . $item3['tgl_transaksi'] . '
								</td>
								<td>
									' . $kdt . '
								</td>
								<td style="text-align: right;">
									' . $item3['note'] . '
								</td>
								<td style="text-align: right;">
									' . number_format(($item3['qty_in']), 2) . '&nbsp;&nbsp;' . $satuan_kecil . '
                                </td>
                                <td style="text-align: right;">
									' . number_format(($item3['harga_in']), 2) . '
								</td>
								<td style="text-align: right;">
									' . number_format(($item3['qty_out']), 2) . '&nbsp;&nbsp;' . $satuan_kecil . '
								</td>
								<td style="text-align: right;">
									' . number_format($saldoakhir, 2) . '&nbsp;&nbsp;' . $satuan_kecil . '
                                </td>
                                <td style="text-align: right;">
									' . number_format(($newAverage[$i]), 2) . '
								</td>
							</tr>
				';
				$i++;
			}
			$html .= '
					</tbody>
				</table>
			';
		}
		else {
			$html .= '<h3><center>Tidak ada data</center></h3>';
		}

		return $html;
	}

	function view_kartu_stok3($result, $resulthdr, $saldoawal, $periode){

		$n=1;
		$html = "";
	    $tgl_awal = date("Y-m-d");
	    $kode_cabang	= $_POST['kode_cabang'];
		$kode_gudang	= $_POST['kode_gudang'];
		$kode_barang	= $_POST['kode_barang'];

		while ($item = mysql_fetch_array($resulthdr)){
			$nama_barang	= $item['nama_barang'];
			$nama_cabang 	= $item['nama_cabang'];
			$nama_gudang 	= $item['nama_gudang'];
			$satuan_jual	= $item['satuan_jual'];
			$satuan_beli	= $item['satuan_beli'];
			$isi			= $item['isi'];
		}


	if(mysql_num_rows($resulthdr) > 0) {
		$html .= '
				  <div class="form-group row">
	                <label class="col-sm-1 control-label">Barang :</label>
	                    <div class="col-sm-5">
	                    	<input type="text" required class="form-control" value="'.$kode_barang.'&nbsp;&nbsp;||&nbsp;&nbsp;'.$nama_barang.'" readonly>
	                    </div>

					<label class="col-sm-1 control-label">Tanggal :</label>
	                    <div class="col-sm-5">
	                        <input type="text" required class="form-control" value="'.$periode.'" readonly>
	                    </div>
	              </div>

	              <div class="form-group row">
	                <label class="col-sm-1 control-label">Cabang :</label>
	                    <div class="col-sm-5">
	                       <input type="text" required class="form-control" value="'.$kode_cabang.'&nbsp;&nbsp;||&nbsp;&nbsp;'.$nama_cabang.'" readonly>
	                    </div>

					<label class="col-sm-1 control-label">Gudang :</label>
	                    <div class="col-sm-5">
	                       <input type="text" required class="form-control" value="'.$kode_gudang.'&nbsp;&nbsp;||&nbsp;&nbsp;'.$nama_gudang.'" readonly>
	                    </div>
	              </div> ';
	    $html .= '
				<table id="kartu_stok" class="" rules="all">
					<thead>
						<tr>
							<th colspan="3" style="width: 270px; font-size: 13px;"></th>
							<th colspan="3" style="width: 240px; font-size: 13px;">MASUK</th>
							<th colspan="3" style="width: 240px; font-size: 13px;">KELUAR</th>
							<th colspan="5" style="width: 330px; font-size: 13px;">SALDO</th>
						</tr>

						<tr>
							<th style="font-size: 12px;">TGL TRANSAKSI</th>
							<th style="font-size: 12px;">KODE TRANSAKSI</th>
							<th style="font-size: 12px;">REF</th>

							<th style="font-size: 12px;">'.$satuan_jual.'</th>
							<th style="font-size: 12px;">'.$satuan_jual.' / '.$satuan_beli.'</th>
							<th style="font-size: 12px;">'.$satuan_beli.'</th>

							<th style="font-size: 12px;">'.$satuan_jual.'</th>
							<th style="font-size: 12px;">'.$satuan_jual.' / '.$satuan_beli.'</th>
							<th style="font-size: 12px;">'.$satuan_beli.'</th>

							<th style="font-size: 12px;">'.$satuan_jual.'</th>
							<th style="font-size: 12px;">'.$satuan_jual.' / '.$satuan_beli.'</th>
							<th style="font-size: 12px;">'.$satuan_beli.'</th>
							<th style="font-size: 12px;">MAP</th>
							<th style="font-size: 12px;">TOTAL</th>
						</tr>
					</thead>

					<tbody>';
						while ($item2 = mysql_fetch_array($saldoawal)){
							$qty_awal 		= $item2['qty'];
							$isi_awal 		= $item2['isi'];
							$qty_in_awal 	= $item2['qty_in']/$isi_awal;
							$total_qty_awal = $item2['total_qty'];

							$map_awal 		= $item2['map'];
							$total_awal1 	= $item2['total'];
							$total_awal 	= $map_awal*$total_qty_awal;
							$total_in_awal 	= $item2['total_in'];
						}
						$html.='<tr>
									<td style="width: 70px"></td>
									<td style="width: 150px"></td>
									<td style="width: 50px"></td>

									<td style="text-align: right; width: 80px"></td>
									<td style="text-align: right; width: 80px"></td>
									<td style="text-align: right; width: 80px"></td>

									<td style="text-align: right; width: 80px"></td>
									<td style="text-align: right; width: 80px"></td>
									<td style="text-align: right; width: 80px"></td>

									<td style="text-align: right; width: 70px">'.$qty_awal.'</td>
									<td style="text-align: right; width: 70px">@  '.$isi_awal.'</td>
									<td style="text-align: right; width: 75px">'.$total_qty_awal.'
										<p hidden>Rp'.$total_in_awal.'</p>
									</td>
									<td style="text-align: right; width: 105px">Rp '.number_format($map_awal, 2).'</td>
									<td style="text-align: right; width: 110px">Rp '.number_format($total_awal, 2).'</td>
								</tr>';

						$i=-1;
						while ($item3 = mysql_fetch_array($result)){
							if($i<0){
								$total_qty_in	= $item3['qty_in'];
								$total_qty_out 	= $item3['qty_out'];

								$total_in 		= $item3['total_in'];

								$qty_in 		= $total_qty_in/$isi;
								$qty_out 		= $total_qty_out/$isi;

								$total_qtyy 	= $total_qty_awal+$total_qty_in-$total_qty_out;
								$saldo_qty		= $total_qtyy/$isi;
								$qtyy 			= $saldo_qty;


								$map2 			= ($total_in_awal+$total_in)/($total_qty_in+$total_qty_awal);
								$total_harga1	= $map2*$total_qtyy;

								$html.='<tr>
									<td style="width: 70px">'.$item3['tgl_transaksi'].'</td>
									<td style="width: 150px">'.$item3['kode_transaksi'].'</td>
									<td style="width: 50px">'.$item3['note'].'</td>

									<td style="text-align: right; width: 90px">'.$qty_in.'</td>
									<td style="text-align: right; width: 90px">@ '.$isi.'</td>
									<td style="text-align: right; width: 90px">'.$total_qty_in.'</td>


									<td style="text-align: right; width: 90px">'.$qty_out.'</td>
									<td style="text-align: right; width: 90px">@ '.$isi.'</td>
									<td style="text-align: right; width: 90px">'.$total_qty_out.'</td>

									<td style="text-align: right; width: 90px">'.$qtyy.'</td>
									<td style="text-align: right; width: 90px">@ '.$isi.'</td>
									<td style="text-align: right; width: 90px">'.($total_qtyy).'
										<p hidden>Rp'.$total_in.'</p>
									</td>

									<!-- UNTUK MENGHITUNG MOVING AVERAGES -->
									';

									$html.='
									<td style="text-align: right; width: 120px">Rp '.number_format($map2, 2).'</td>
									<td style="text-align: right; width: 120px">Rp '.number_format($total_harga1, 2).'</td>
								</tr>';
							}
							else {
								$total_saldo_qty=($item3['qty_in']-$item3['qty_out']);

								if($i==0){
									$total_qtyy2 = $total_qtyy + $total_saldo_qty;
								} else if ($i>0){
									$total_qtyy2 = $total_qtyy2 + $total_saldo_qty;
								}

								$qtyy2	=$total_qtyy2/$isi;

								$total_in1  	= $item3['total_in'];
								$qty_in1		= $item3['qty_in'];

								$total_in2 		= $total_in_awal+$total_in;
								$qty_in2 		= $total_qty_awal+$total_qty_in;

								$map3 			= ($total_in2+$total_in1)/($qty_in2+$qty_in1);
								$total_harga2	= $map3*$total_qtyy2;

								$html.='<tr>
									<td style="width: 70px">'.$item3['tgl_transaksi'].'</td>
									<td style="width: 150px">'.$item3['kode_transaksi'].'</td>
									<td style="width: 50px">'.$item3['note'].'</td>

									<td style="text-align: right; width: 90px">'.$item3['qty_in']/$isi.'</td>
									<td style="text-align: right; width: 90px">@ '.$isi.'</td>
									<td style="text-align: right; width: 90px">'.$item3['qty_in'].'</td>

									<td style="text-align: right; width: 90px">'.$item3['qty_out']/$isi.'</td>
									<td style="text-align: right; width: 90px">@ '.$isi.'</td>
									<td style="text-align: right; width: 90px">'.$item3['qty_out'].'</td>

									<td style="text-align: right; width: 90px">'.($qtyy2).'</td>
									<td style="text-align: right; width: 90px">@ '.$isi.'</td>
									<td style="text-align: right; width: 90px">'.($total_qtyy2).'
										<p hidden>Rp'.number_format($item3['total_in'], 2).'</p>
									</td>

									<!-- UNTUK MENGHITUNG MOVING AVERAGEZ -->
									';

									$html.='
									<td style="text-align: right; width: 90px">Rp '.number_format($map3, 2).'</td>
									<td style="text-align: right; width: 90px">Rp '.number_format($total_harga2, 2).'</td>
								</tr>';
							}
							$i++;
						}

						$html.='
					</tbody>
				</table>
		';
		}else{
			$html.='
				<h3><center>TIDAK ADA DATA BROOO ^^</center></h3>
		';
		}

		return $html;
	}

	?>
