<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	require('../pages/data/script/rj.php'); 
	date_default_timezone_set("Asia/Jakarta");

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loadfj" )
	{
		$kode_cabang 	= $_POST['kode_cabang'];
		$kode_gudang 	= $_POST['kode_gudang'];
		$kode_pelanggan = $_POST['kode_pelanggan'];
		
		$q_fj = mysql_query("SELECT fd.kode_fj FROM fj_dtl fd
								LEFT JOIN fj_hdr fh ON fh.kode_fj = fd.kode_fj
								LEFT JOIN sj_dtl sjd ON sjd.kode_sj = fh.kode_sj
								LEFT JOIN so_dtl sd ON sd.kode_so = sjd.kode_so
								WHERE fh.kode_cabang = '".$kode_cabang."' AND fh.kode_pelanggan = '".$kode_pelanggan."'
								GROUP BY kode_fj
								ORDER BY kode_fj ASC");
		// die($q_fj);
		$num_rows = mysql_num_rows($q_fj);
		if($num_rows>0)
		{		
			echo '<select id="kode_fj" name="kode_fj" class="select2">
					<option value="0">-- Kode FJ --</option>';
					 	
                	while($rowfj = mysql_fetch_array($q_fj)){
                    
         	echo '<option value="'.$rowfj['kode_fj'].'">'.$rowfj['kode_fj'].'</option>';
		 
	 				}
  
         	echo '</select>';
		}else{
			echo '<select id="kode_fj" name="kode_fj" class="select2" disabled>
                  	<option value="0">-- Tidak Ada--</option>
                  </select>';	
		}
	}
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loaditem" )
	{
		$kode_fj 		= mres($_POST['kode_fj']);
		$kode_gudang 	= mres($_POST['kode_gudang']);
		$grandtotal = 0;
		$total= 0;
		
		if ($kode_gudang == '0') {
			echo '<tr><td colspan="6" class="text-center">Belum ada item</td></tr>';
			return false;
		}
		
		if ($kode_gudang == '02') {
			$q_dtl = mysql_query("SELECT	CASE 		WHEN REGEXP_REPLACE ( SUBSTRING_INDEX( `satuan_beli`, ':', 1 ), '[[:space:]]+', ' ' ) = 'LSN' THEN			`so_dtl`.`harga` / 12		WHEN REGEXP_REPLACE ( SUBSTRING_INDEX( `satuan_beli`, ':', 1 ), '[[:space:]]+', ' ' ) = 'GRS' THEN			`so_dtl`.`harga` / 144		ELSE 			`so_dtl`.`harga`	END AS `harga`,	`inventori`.`rj_debet`,	`inventori`.`rj_kredit`,	CASE 		WHEN REGEXP_REPLACE ( SUBSTRING_INDEX( `satuan_beli`, ':', 1 ), '[[:space:]]+', ' ' ) = 'LSN' THEN			CONCAT(REGEXP_REPLACE ( SUBSTRING_INDEX( `satuan_beli`, ':', 1 ), '[[:space:]]+', ' ' ), '/12')		WHEN REGEXP_REPLACE ( SUBSTRING_INDEX( `satuan_beli`, ':', 1 ), '[[:space:]]+', ' ' ) = 'GRS' THEN			CONCAT(REGEXP_REPLACE ( SUBSTRING_INDEX( `satuan_beli`, ':', 1 ), '[[:space:]]+', ' ' ), '/144')		ELSE 			REGEXP_REPLACE ( SUBSTRING_INDEX( `satuan_beli`, ':', 1 ), '[[:space:]]+', ' ' )	END AS `satuan`,	SUBSTRING_INDEX( `fj_dtl`.`kode_barang`, ':', 1 ) AS `kode_barang`,	SUBSTRING_INDEX( `fj_dtl`.`nama_barang`, ':', - 1 ) AS `nama_barang`,	`fj_hdr`.`tgl_jth_tempo` FROM	`fj_hdr`	LEFT JOIN `fj_dtl` ON `fj_dtl`.`kode_fj` = `fj_hdr`.`kode_fj`	LEFT JOIN `inventori` ON `inventori`.`kode_inventori` = SUBSTRING_INDEX( `fj_dtl`.`kode_barang`, ':', 1 )	LEFT JOIN `sj_dtl` ON `sj_dtl`.`kode_sj` = `fj_hdr`.`kode_sj`	LEFT JOIN `so_dtl` ON `so_dtl`.`kode_so` = `sj_dtl`.`kode_so` 	AND `so_dtl`.`kode_barang` = `sj_dtl`.`kode_inventori` WHERE	`fj_hdr`.`kode_fj` = '" . $kode_fj . "' GROUP BY	`so_dtl`.`harga`,	`so_dtl`.`kode_barang` ");
		} else {
			$q_dtl = mysql_query("SELECT `so_dtl`.`harga`, `inventori`.`rj_debet`, `inventori`.`rj_kredit`,	REGEXP_REPLACE ( SUBSTRING_INDEX( `satuan_beli`, ':', 1 ), '[[:space:]]+', ' ' ) AS `satuan`,	SUBSTRING_INDEX( `fj_dtl`.`kode_barang`, ':', 1 ) AS `kode_barang`,	SUBSTRING_INDEX( `fj_dtl`.`nama_barang`, ':', - 1 ) AS `nama_barang`,	`fj_hdr`.`tgl_jth_tempo` FROM	`fj_hdr`	LEFT JOIN `fj_dtl` ON `fj_dtl`.`kode_fj` = `fj_hdr`.`kode_fj`	LEFT JOIN `inventori` ON `inventori`.`kode_inventori` = SUBSTRING_INDEX( `fj_dtl`.`kode_barang`, ':', 1 )	LEFT JOIN `sj_dtl` ON `sj_dtl`.`kode_sj` = `fj_hdr`.`kode_sj`	LEFT JOIN `so_dtl` ON `so_dtl`.`kode_so` = `sj_dtl`.`kode_so` AND `so_dtl`.`kode_barang` = `sj_dtl`.`kode_inventori` WHERE	`fj_hdr`.`kode_fj` = '" . $kode_fj . "' GROUP BY `so_dtl`.`harga`, `so_dtl`.`kode_barang` ");
		}
		
		$num_rows 	= mysql_num_rows($q_dtl);
		if($num_rows>0)
		{
			$n=0;
			while($rowdtl = mysql_fetch_array($q_dtl)){
				
				$n++;
				if ($_SESSION['app_level'] != '6') {
				echo '<tr data-id="' . $n . '">
							<td width="30px">
								<div class="checkbox" style="text-align:right">
									<input type="checkbox" name="cb[]" id="cb_' . $n . '" data-id="' . $n . '" value="0" />
								</div>
								<input type="hidden" class="form-control" name="stat_cb[]" id="stat_cb_' . $n . '" value="0" data-id="' . $n . '" />
							</td>
							<td>
								<input type="hidden" value="' . $rowdtl['rj_debet'] . '" name="rj_debet[]" data-id="' . $n . '" />
								<input type="hidden" value="' . $rowdtl['rj_kredit'] . '" name="rj_kredit[]" data-id="' . $n . '" />
								<input type="hidden" value="' . $rowdtl['kode_barang'] . '" name="kode_barang[]" data-id="' . $n . '" />
								<input type="hidden" value="' . $rowdtl['satuan'] . '" name="satuan[]" data-id="' . $n . '" />
								<input type="hidden" value="' . $rowdtl['tgl_jth_tempo'] . '" name="tgl_jth_tempo[]" data-id="' . $n . '" />
								' . $rowdtl['nama_barang'] . '
							</td>
							<td>
								<div class="input-group">
									<input class="form-control" type="text" name="qty_retur[]" id="qty_retur_' . $n . '" autocomplete="off" value="0" style="text-align: right" data-id="' . $n . '" required />
									<span class="input-group-addon">' . $rowdtl['satuan'] . '</span>
								</div>
							</td>
							<td>
								<div class="input-group">
									<input class="form-control" type="text" name="harga_retur[]" id="harga_retur_' . $n . '" autocomplete="off" value="' . $rowdtl['harga'] . '" data-value="' . $rowdtl['harga'] . '" data-id="' . $n . '" style="text-align: right" required />
								</div>
							</td>
							<td>
								<div class="input-group">
									<input class="form-control" type="text" name="total_harga_retur[]" id="total_harga_retur_' . $n . '" autocomplete="off" value="0" data-id="' . $n . '" style="text-align: right" readonly />
								</div>
							</td>
							<td>
								<div class="input-group">
									<input class="form-control" type="text" name="ket_retur[]" id="ket_retur_' . $n . '" autocomplete="off" data-id="' . $n . '" />
								</div>
							</td>
					</tr>';
				} else {
					echo '<tr data-id="' . $n . '">
							<td width="30px">
								<div class="checkbox" style="text-align:right">
									<input type="checkbox" name="cb[]" id="cb_' . $n . '" data-id="' . $n . '" value="0" />
								</div>
								<input type="hidden" class="form-control" name="stat_cb[]" id="stat_cb_' . $n . '" value="0" data-id="' . $n . '" />
								<input type="hidden" class="form-control" name="harga_retur[]" id="harga_retur_' . $n . '" value="' . $rowdtl['harga'] . '" data-value="' . $rowdtl['harga'] . '" data-id="' . $n . '" />
								<input type="hidden" name="total_harga_retur[]" id="total_harga_retur_' . $n . '" value="0" data-id="' . $n . '" />
							</td>
							<td>
								<input type="hidden" value="' . $rowdtl['rj_debet'] . '" name="rj_debet[]" data-id="' . $n . '" />
								<input type="hidden" value="' . $rowdtl['rj_kredit'] . '" name="rj_kredit[]" data-id="' . $n . '" />
								<input type="hidden" value="' . $rowdtl['kode_barang'] . '" name="kode_barang[]" data-id="' . $n . '" />
								<input type="hidden" value="' . $rowdtl['satuan'] . '" name="satuan[]" data-id="' . $n . '" />
								<input type="hidden" value="' . $rowdtl['tgl_jth_tempo'] . '" name="tgl_jth_tempo[]" data-id="' . $n . '" />
								' . $rowdtl['nama_barang'] . '
							</td>
							<td>
								<div class="input-group">
									<input class="form-control" type="text" name="qty_retur[]" id="qty_retur_' . $n . '" autocomplete="off" value="0" style="text-align: right" data-id="' . $n . '" required />
									<span class="input-group-addon">' . $rowdtl['satuan'] . '</span>
								</div>
							</td>
							<td>
								<div class="input-group">
									<input class="form-control" type="text" name="ket_retur[]" id="ket_retur_' . $n . '" autocomplete="off" data-id="' . $n . '" />
								</div>
							</td>
					</tr>';
				}
			}

		}else{

			echo '<tr><td colspan="'.($_SESSION['app_level'] != '6' ? '6' : '4').'" class="text-center">Belum ada item</td></tr>';

		}

	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save" )
	{

		mysqli_autocommit($con,FALSE);
		
		$form 			= 'RJ';
		$thnblntgl 		= date("ymd",strtotime($_POST['tgl_buat']));
				
		$kode_cabang	= $_POST['kode_cabang'];
		$kode_gudang	= $_POST['kode_gudang'];
		$kode_pelanggan	= $_POST['kode_pelanggan'];

		$ref			= $_POST['ref'];
		$tgl_buat 		= date("Y-m-d",strtotime($_POST['tgl_buat']));
		$keterangan_hdr	= $_POST['keterangan_hdr'];

		$kode_fj		= $_POST['kode_fj'];
		$cb		= $_POST['cb'];
		$stat_cb		= $_POST['stat_cb'];
		$rj_debet		= $_POST['rj_debet'];
		$rj_kredit		= $_POST['rj_kredit'];
		$kode_barang		= $_POST['kode_barang'];
		$satuan		= $_POST['satuan'];
		$tgl_jth_tempo	= $_POST['tgl_jth_tempo'];
		$qty_retur	= $_POST['qty_retur'];
		$harga_retur	= $_POST['harga_retur'];
		$total_harga_retur	= $_POST['total_harga_retur'];
		$ket_retur	= $_POST['ket_retur'];
		
		$count                 = count($cb);
		
		$grandtotal = 0;
		
		$user_pencipta  = $_SESSION['app_id'];
		$tgl_input 		= date("Y-m-d H:i:s");
		
		
		$kode_rj = buat_kode_rj($thnblntgl,$form,$kode_cabang);
		
		for($i = 0; $i < $count; $i++) {
			if ($stat_cb[$cb[$i]] == '1' || $stat_cb[$cb[$i]] == 1) {
				$code_barang = $kode_barang[$cb[$i]];
				
				$mySql1 = "INSERT INTO `rj_dtl` (`kode_rj`, `kode_fj`, `kode_barang`, `satuan`, `jumlah_rj`, `harga`, `subtot`, `keterangan_dtl`) VALUES ";
				$mySql1 .= $i > 0 ? ", " : '';
				$mySql1 .= "(
					'" . $kode_rj . "',
					'" . $kode_fj . "',
					'" . $kode_barang[$cb[$i]] . "',
					'" . $satuan[$cb[$i]] . "',
					'" . str_replace(',', null, $qty_retur[$cb[$i]]) . "',
					'" . str_replace(',', null, $harga_retur[$cb[$i]]) . "',
					'" . str_replace(',', null, $total_harga_retur[$cb[$i]]) . "',
					'" . $ket_retur[$cb[$i]] . "'
				)";
				
				$grandtotal += $total_harga_retur[$cb[$i]];
				
				$tgl_jth_tempo = $tgl_jth_tempo[$cb[$i]];
				
				//INSERT JURNAL KREDIT
				$mySql5	= "INSERT INTO `jurnal` SET
							`kode_transaksi`			='".$kode_rj."',
							`tgl_buat`				='".$tgl_buat."',
							`tgl_input`				='".$tgl_input."',
							`kode_cabang`				='".$kode_cabang."',
							`kode_supplier`			='".$kode_supplier."',
							`keterangan_hdr`			='".$keterangan_hdr."',
							`ref`						='".$ref."',
							`kode_coa`				='".$rj_kredit[$cb[$i]]."',
							`kredit`					='".$total_harga_retur[$cb[$i]]."',
							`user_pencipta`			='".$user_pencipta."';
						";
				$query5 = mysqli_query ($con,$mySql5) ;

				//INSERT JURNAL DEBET
				$mySql6	= "INSERT INTO `jurnal` SET
							`kode_transaksi`			='".$kode_rj."',
							`tgl_buat`				='".$tgl_buat."',
							`tgl_input`				='".$tgl_input."',
							`kode_cabang`				='".$kode_cabang."',
							`kode_supplier`			='".$kode_supplier."',
							`keterangan_hdr`			='".$keterangan_hdr."',
							`ref`						='".$ref."',
							`kode_coa`			='".$rj_debet[$cb[$i]]."',
							`debet`					='".$total_harga_retur[$cb[$i]]."',
							`user_pencipta`			='".$user_pencipta."';
						";
				$query6 = mysqli_query ($con,$mySql6) ;
								
				//UNTUK CEK ITEM YANG MASUK KE STOK
				$q_cekitem = mysql_query("SELECT kode_inventori FROM inventori WHERE kode_inventori='".$kode_barang[$cb[$i]]."' AND jenis_stok='1'");
				
				$num_rows = mysql_num_rows($q_cekitem);
				if($num_rows>0)
				{
					//VARIABEL AWAL 
					$qty_in_dtl 	= $jumlah_rj;
					$harga_in_dtl 	= $harga;
					$total_in_dtl 	= ceil($qty_in_dtl*$harga_in_dtl);
					$ref_untuk_crd 	= 'nota retur penjualan'; 
					
					//UNTUK CEK STOK
					$q_cekstok_hdr = mysql_query("SELECT * FROM crd_stok WHERE kode_barang='".$kode_barang[$cb[$i]]."' AND kode_cabang='".$kode_cabang."' AND kode_gudang='".$kode_gudang."'");	
					$num_rows1 = mysql_num_rows($q_cekstok_hdr);
					//JIKA ADA STOK
					if($num_rows1>0)
					{
						$rowstok_hdr = mysql_fetch_array($q_cekstok_hdr);
						
						$kd_barang 		= $rowstok_hdr['kode_barang'];
						$kd_cabang 		= $rowstok_hdr['kode_cabang'];
						$kd_gudang 		= $rowstok_hdr['kode_gudang'];
						$qty_in 		= $rowstok_hdr['qty_in'];
						$qty_out 		= $rowstok_hdr['qty_out'];
						$saldo_qty 		= $rowstok_hdr['saldo_qty'];
						$saldo_last_hpp = $rowstok_hdr['saldo_last_hpp'];
						$saldo_total 	= $rowstok_hdr['saldo_total'];
						
						$rumus_hpp 		= ceil($saldo_total+$total_in_dtl)/($saldo_qty+$qty_in_dtl);
						
						$q_masuk 		= (int)$qty_in+$qty_in_dtl;
						$q_keluar 		= (int) $qty_out;
						$saldo_q 		= (int)$q_masuk-$q_keluar;
						$saldo_last_hpp = ceil($rumus_hpp); 
						$saldo_total 	= ceil($saldo_q*$saldo_last_hpp);
						
						//UPDATE CRD STOK
						$mySql3 = " UPDATE crd_stok SET tgl_input='".$tgl_input."', qty_in='".$q_masuk."', saldo_qty='".$saldo_q."', saldo_last_hpp='".$saldo_last_hpp."', saldo_total='".$saldo_total."' WHERE kode_barang='".$code_barang."' AND kode_cabang='".$kd_cabang."' AND kode_gudang='".$kd_gudang."' ";
						
						$query3 = mysqli_query ($con,$mySql3) ;
						
						//INSERT CRD STOK DTL
						$mySql4	= "INSERT INTO crd_stok_dtl SET 
									kode_barang			='".$code_barang."',
									tgl_buat				='".$tgl_buat."',
									tgl_input				='".$tgl_input."',
									kode_cabang				='".$kd_cabang."',
									kode_gudang				='".$kd_gudang."',
									qty_in					='".$qty_in_dtl."',
									harga_in				='".$harga_in_dtl."',
									total_in				='".$total_in_dtl."',
									ref						='".$ref_untuk_crd."',
									note					='".$ref."',
									kode_transaksi			='".$kode_rj."';
								";	
								
						$query4 = mysqli_query ($con,$mySql4) ;		
						
					//JIKA BELUM ADA STOK
					}else{
						
						//INSERT CRD STOK 
						$mySql3	= "INSERT INTO crd_stok SET 
									kode_barang			='".$code_barang."',
									tgl_input				='".$tgl_input."',
									kode_cabang				='".$kode_cabang."',
									kode_gudang				='".$kode_gudang."',
									qty_in					='".$qty_in_dtl."',
									saldo_qty				='".$qty_in_dtl."',
									saldo_last_hpp			='".$harga_in_dtl."',
									saldo_total				='".$total_in_dtl."';
								";	
								
						$query3 = mysqli_query ($con,$mySql3) ;
						
						//INSERT CRD STOK DTL
						$mySql4	= "INSERT INTO crd_stok_dtl SET 
									kode_barang			='".$code_barang."',
									tgl_buat				='".$tgl_buat."',
									tgl_input				='".$tgl_input."',
									kode_cabang				='".$kode_cabang."',
									kode_gudang				='".$kode_gudang."',
									qty_in					='".$qty_in_dtl."',
									harga_in				='".$harga_in_dtl."',
									total_in				='".$total_in_dtl."',
									ref						='".$ref_untuk_crd."',
									note					='".$ref."',
									kode_transaksi			='".$kode_rj."';
								";	
								
						$query4 = mysqli_query ($con,$mySql4) ;			
						
					}
					
				}	
				
				
			}
		}
				 
		$mySql1 = rtrim($mySql1,",");
		
		$query1 = mysqli_query ($con,$mySql1) ;

		//KARTU HUTANG
		$mySql7	= " INSERT INTO kartu_piutang SET
						kode_transaksi 	='".$kode_rj."', 
						kredit 			='".$grandtotal."',
					    kode_pelanggan 	='".$kode_pelanggan."',
						kode_cabang 	='".$kode_cabang."',
						tgl_buat 		='".$tgl_buat."',
						tgl_jth_tempo 	='".$tgl_jth_tempo."',
						user_pencipta 	='".$user_pencipta."',
						tgl_input		='".$tgl_input."'
					";	
								
		$query7 = mysqli_query ($con,$mySql7) ;
		
		//HEADER BTB
		$mySql	= "INSERT INTO rj_hdr SET 
						kode_rj			='".$kode_rj."',
						kode_cabang		='".$kode_cabang."',
						kode_gudang		='".$kode_gudang."',
						kode_pelanggan	='".$kode_pelanggan."',
						ref				='".$ref."',
						tgl_buat		='".$tgl_buat."',
						keterangan_hdr	='".$keterangan_hdr."',
						user_pencipta	='".$user_pencipta."', 
						total_harga		='".$total_harga."',
						total_ppn		='".$total_ppn."',
						grandtotal		='".$grandtotal."' 
				  ";	
						
		$query = mysqli_query ($con,$mySql) ;
		
		if ($query AND $query1 AND $query3 AND $query4 AND $query5 AND $query6 AND $query7) {
			
			// Commit transaction
			mysqli_commit($con);
			
			// Close connection
			mysqli_close($con);
			
			echo "00||".$kode_rj;
			unset($_SESSION['data_rj']);
			
		} else { 
			
			echo "Gagal query: ".$mySql3;
		}			
					 
	}

// PEMBATALAN NOTA RETUR PENJUALAN
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "pembatalan" )
	{
		mysqli_autocommit($con,FALSE);

		$kode_rj		= $_POST['kode_rj_batal'];
		$alasan_batal	= $_POST['alasan_batal'];
		$tgl_batal 		= date("Y-m-d");

		//UPDATE RJ_HDR 
		$mySql1 = "UPDATE rj_hdr SET status ='2', alasan_batal = '" . $alasan_batal . "', user_batal = '" . $_SESSION['app_id'] . "', tgl_batal = '" . $tgl_batal . "' WHERE kode_rj='".$kode_rj."' ";
		$query1 = mysqli_query ($con,$mySql1) ;

		//UPDATE RJ_DTL
		$mySql2 = "UPDATE rj_dtl SET status_dtl ='2' WHERE kode_rj='".$kode_rj."' ";
		$query2 = mysqli_query ($con,$mySql2) ;

		$kode_fj = mysql_query("SELECT kode_fj FROM rj_dtl WHERE kode_rj = '".$kode_rj."' "); 	
		$num_row_desc = mysql_num_rows($kode_fj);

		if($num_row_desc > 0){
			while($row_desc = mysql_fetch_array($kode_fj)){

				$kode = $row_desc['kode_fj'];

				$mySql3 = "UPDATE fj_hdr SET status ='1' WHERE kode_fj = '".$kode."' ";
				$query3 = mysqli_query ($con,$mySql3) ;

				$mySql4 = "UPDATE fj_dtl SET status_dtl ='1' WHERE kode_fj = '".$kode."' ";
				$query4 = mysqli_query ($con,$mySql4) ;

				//INSERT KARTU_PIUTANG
				$piutang = mysql_query("SELECT * FROM kartu_piutang WHERE kode_transaksi = '".$kode_rj."'"); 
				$num_row_p  = mysql_num_rows($piutang);

					if($num_row_p > 0){
						while($row_p = mysql_fetch_array($piutang)){
						
							$kode_transaksi 	= $row_p['kode_transaksi'];
							$kode_pelunasan 	= $row_p['kode_pelunasan'];
							$debet 				= $row_p['debet'];
							$kredit 			= $row_p['kredit'];
							$kode_cabang 		= $row_p['kode_cabang'];
							$kode_pelanggan 	= $row_p['kode_pelanggan'];
							$tgl_jth_tempo 		= $row_p['tgl_jth_tempo'];
							$tgl_input 			= date("Y-m-d H:i:s");

							$mySql5 = "INSERT INTO kartu_piutang SET
											kode_transaksi 	='".$kode_transaksi."',
											kode_pelunasan 	='".$kode_pelunasan."',
											debet 			='".$kredit."', 
											kredit 			='".$debet."',
											kode_cabang 	='".$kode_cabang."',
											kode_pelanggan 	='".$kode_pelanggan."',
											tgl_buat  		='".$tgl_batal."',
											tgl_jth_tempo  	='".$tgl_jth_tempo."',
											tgl_input 		='".$tgl_input."'
										";
							$query5 = mysqli_query ($con,$mySql5) ;	

							$mySql6 = "UPDATE kartu_piutang SET status_batal ='1' WHERE kode_transaksi = '".$kode_transaksi."'";			
							$query6 = mysqli_query ($con,$mySql6) ;	
						}
					}
				
			}
		}

		//INSERT CRD_STOK_DTL
		$kode_barang = mysql_query("SELECT rd.kode_barang, rh.kode_gudang FROM rj_dtl rd INNER JOIN rj_hdr rh ON rh.kode_rj = rd.kode_rj WHERE rd.kode_rj = '".$kode_rj."'");
		$num_row_b   = mysql_num_rows($kode_barang);
		if($num_row_b > 0){
			while($row_b = mysql_fetch_array($kode_barang)){

				$kode_gudang = $row_b['kode_gudang'];
				$barang = $row_b['kode_barang'];
				$pisah=explode(":",$barang);
				$kd_barang=$pisah[0];
				

				$crd_stok_dtl = mysql_query("SELECT qty_in, harga_in, total_in FROM crd_stok_dtl WHERE kode_barang = '".$kd_barang."' AND kode_cabang = '".$kode_cabang."' AND kode_gudang = '".$kode_gudang."' AND kode_transaksi = '".$kode_rj."'"); 
				if($num_row_cd > 0) {
					$row_cd = mysql_fetch_array($crd_stok_dtl);

						$qty_in_dtl   	= $row_cd['qty_in'];
						$harga_in 		= $row_cd['harga_in'];
						$total_in 		= $row_cd['total_in'];
						$tgl_input		= date("Y-m-d H:i:s");

						$mySql9 = "INSERT INTO crd_stok_dtl SET
									kode_barang 	='".$kd_barang."',
									tgl_input 		='".$tgl_input."', 
									kode_cabang 	='".$kode_cabang."',
									kode_gudang 	='".$kode_gudang."',
									qty_out 		='".$qty_in_dtl."',
									harga_out 		='".$harga_in."',
									total_out 		='".$total_in."',
									ref  			='nota retur penjualan batal',
									kode_transaksi  ='".$kode_rj."',
									tgl_buat 		='".$tgl_batal."'
							";	
						$query9 = mysqli_query ($con,$mySql9) ;	
				}

				$crd_stok = mysql_query("SELECT * FROM crd_stok WHERE kode_barang = '".$kd_barang."' AND kode_cabang = '".$kode_cabang."' AND kode_gudang = '".$kode_gudang."'"); 
				$num_row_c = mysql_num_rows($crd_stok);
				if($num_row_c > 0) {
					$row_c = mysql_fetch_array($crd_stok);

						$qty_masuk 	 	= $row_c['qty_in'];
						$qty_keluar 	= $row_c['qty_out'];
						$saldo_total 	= $row_c['saldo_total'];
						$saldo_last_hpp = $row_c['saldo_last_hpp'];

						$qty_in 		= ceil($qty_masuk - $qty_in_dtl);
						$saldo_qty 		= ceil($qty_in - $qty_keluar);
						$saldo_total1 	= ceil($saldo_qty*$saldo_last_hpp);

						$mySql10 = "UPDATE crd_stok SET
									kode_barang 	='".$kd_barang."',
									tgl_input 		='".$tgl_input."', 
									kode_cabang 	='".$kode_cabang."',
									kode_gudang 	='".$kode_gudang."',
									qty_in 			='".$qty_in."',
									qty_out 		='".$qty_keluar."',
									saldo_qty 		='".$saldo_qty."',
									saldo_last_hpp 	='".$saldo_last_hpp."',
									saldo_total  	='".$saldo_total1."'
									WHERE kode_barang = '".$kd_barang."' AND kode_cabang = '".$kode_cabang."' AND kode_gudang = '".$kode_gudang."'
							";
						$query10 = mysqli_query ($con,$mySql10) ;	
				}
			}
		}

		//INSERT JURNAL
		$jurnal = mysql_query("SELECT * FROM jurnal WHERE kode_transaksi = '".$kode_rj."' ");
		$num_row_j  = mysql_num_rows($jurnal);

		if($num_row_j > 0){
			while($row_j = mysql_fetch_array($jurnal)){
			
				$kode_transaksi 	= $row_j['kode_transaksi'];
				$ref 				= $row_j['ref'];
				$tgl_buat 			= $row_j['tgl_buat'];
				$kode_supplier 		= $row_j['kode_supplier'];
				$kode_coa 			= $row_j['kode_coa'];
				$debet 				= $row_j['debet'];
				$kredit 			= $row_j['kredit'];
				$tgl_input 			= date("Y-m-d H:i:s");
				$keterangan_hdr 	= $row_j['keterangan_hdr'];
				$keterangan_dtl 	= $row_j['keterangan_dtl'];

				$mySql7 = "INSERT INTO jurnal SET
								kode_transaksi 	='".$kode_transaksi."',
								ref 			='".$ref."', 
								tgl_buat 		='".$tgl_buat."',
								kode_cabang 	='".$kode_cabang."',
								kode_supplier 	='".$kode_supplier."',
								kode_pelanggan 	='".$kode_pelanggan."',
								kode_coa 		='".$kode_coa."',
								debet  			='".$kredit."',
								kredit  		='".$debet."',
								tgl_input 		='".$tgl_input."',
								keterangan_hdr 	='".$keterangan_hdr."',
								keterangan_dtl 	='".$keterangan_dtl."'
							";			
				$query7 = mysqli_query ($con,$mySql7) ;	

				$mySql8 = "UPDATE jurnal SET status_jurnal ='2' WHERE kode_transaksi = '".$kode_transaksi."' ";			
				$query8 = mysqli_query ($con,$mySql8) ;	
			}
		}

		if ($query1 AND $query2 AND $query3 AND $query4 AND $query5 AND $query6 AND $query7 AND $query8 AND $query9 AND $query10) {
			
			mysqli_commit($con);
			mysqli_close($con);
			
			echo "00||".$kode_rj;
		} else { 
			echo "Gagal query: ".mysql_error();
		}	
	}



?>