<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	require('../pages/data/script/tg.php'); 
	date_default_timezone_set("Asia/Jakarta");
	
if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save_pm" )
	{

		$form 			= 'TG';
		$thnblntgl 		= date("ymd",strtotime(mres($_POST['tanggal'])));
		$id_form			= mres($_POST['id_form']);
		$kode_pm	= mres($_POST['kode_pm']);
		$kode_spk	= mres($_POST['kode_spk']);
		$ref	= mres($_POST['ref']);
		$tgl_buat 		= date("Y-m-d",strtotime(mres($_POST['tanggal'])));
		$kode_cabang	= mres($_POST['kode_cabang']);
		$kode_gudang_asal	= mres($_POST['kode_gudang_a']);
		$kode_gudang_tujuan	= mres($_POST['kode_gudang_b']);
		$keterangan_hdr	= mres($_POST['keterangan']);
		$user_pencipta  	= $_SESSION['app_id'];
		$tgl_input 			= date("Y-m-d H:i:s");	
		$kd_produk = $_POST['kd_produk'];
		$kd_satuan = $_POST['kd_satuan'];
		$stok = $_POST['stok'];
		$qty = $_POST['qty'];
		$qty_i = $_POST['qty_i'];
		$rata = $_POST['rata'];
		$total = $_POST['total'];
		$keterangan_dtl = $_POST['keterangan_dtl'];

		$kode_tg = buat_kode_tg($thnblntgl,$form,$kode_cabang);	
		
		$cek_1 = [];
		$cek_2 = [];
		$cek_3 = [];
		
		$query = false;
		$query1 = false;
		$query2 = false;
		$query3 = false;
		$query4 = false;
		$query5 = false;
		
		if (count($kd_produk) > 0) {
			for ($i = 0; $i < count($kd_produk); $i++) {
				if ($qty[$i] > 0) {					
					$stok_out = "SELECT `inventori`.`nama` AS `nama_barang`, `crd_stok`.`kode_barang`, `crd_stok`.`qty_in`, `crd_stok`.`qty_out`, `crd_stok`.`saldo_last_hpp`, `crd_stok`.`saldo_qty` FROM `crd_stok` LEFT JOIN `inventori` ON `crd_stok`.`kode_barang` = `inventori`.`kode_inventori` WHERE `crd_stok`.`kode_barang` = '".$kd_produk[$i]."' AND `crd_stok`.`kode_cabang` = '".$kode_cabang."' AND `crd_stok`.`kode_gudang` = '".$kode_gudang_asal."'";
					$q_stok_out = mysql_query($stok_out);
					
					if (mysql_num_rows($q_stok_out) > 0) {
						while ($rQso = mysql_fetch_array($q_stok_out)) {
							$nama_barang = $rQso['nama_barang'];
							$kode_barang = $rQso['kode_barang'];
							$saldo_qty = $rQso['saldo_qty'];
							
							if ($qty[$i] > $saldo_qty) {
								$cek_1[] = false;
								$cek_2[] = false;
								$cek_3[] = false;
								echo "99||Stok ".$nama_barang." sisa ".number_format($saldo_qty, 2);
							} else {
								$tgl_awal_stok = "SELECT `crd_stok_dtl`.`tgl_buat` FROM `crd_stok_dtl` WHERE `crd_stok_dtl`.`kode_barang` = '".$kode_barang."' AND `crd_stok_dtl`.`kode_cabang` = '".$kode_cabang."' AND `crd_stok_dtl`.`kode_gudang` = '".$kode_gudang_asal."' ORDER BY `crd_stok_dtl`.`tgl_buat`, `crd_stok_dtl`.`id_crd_stok_dtl` ASC LIMIT 1";
								$q_tgl_awal_stok = mysql_query($tgl_awal_stok);
								
								if (mysql_num_rows($q_tgl_awal_stok) > 0) {
									$tgl_awal_x = mysql_fetch_array($q_tgl_awal_stok);
									if ($tgl_buat < $tgl_awal_x['tgl_buat']) {
										$cek_1[] = true;
										$cek_2[] = false;
										$cek_3[] = false;
										echo "99||Stok awal ".$nama_barang." tanggal ".$tgl_awal_x['tgl_buat'];
									} else {
										$stok_saat_itu = "SELECT SUM(`qty_in` - `qty_out`) AS `stok` FROM `crd_stok_dtl` WHERE `crd_stok_dtl`.`kode_barang` = '".$kode_barang."' AND `crd_stok_dtl`.`kode_cabang` = '".$kode_cabang."' AND `crd_stok_dtl`.`kode_gudang` = '".$kode_gudang_asal."' AND `crd_stok_dtl`.`tgl_buat` <= '".$tgl_buat."' GROUP BY `crd_stok_dtl`.`kode_barang`";
										$q_stok_saat_itu = mysql_query($stok_saat_itu);
										
										if (mysql_num_rows($q_stok_saat_itu) > 0) {
											$stok_saat_itu_x = mysql_fetch_array($q_stok_saat_itu);
											if ($qty[$i] > $stok_saat_itu_x) {
												$cek_1[] = true;
												$cek_2[] = true;
												$cek_3[] = false;
												echo "99||Stok ".$nama_barang." di tanggal ".$tgl_buat." sisa ".$stok_saat_itu_ada;
											} else {
												$cek_1[] = true;
												$cek_2[] = true;
												$cek_3[] = true;
												
												$qty_out        = $rQso['qty_out']+$qty[$i];
												$saldo_qty      = $rQso['qty_in']-$qty_out;
												$saldo_last_hpp = $rQso['saldo_last_hpp'];
												$saldo_total    = $saldo_qty * $saldo_last_hpp;
																								
												$mySql1 = "UPDATE `crd_stok` SET `crd_stok`.`qty_out` = '".$qty_out."', `crd_stok`.`saldo_qty` = '".$saldo_qty."', `crd_stok`.`saldo_last_hpp` = '".$saldo_last_hpp."', `crd_stok`.`saldo_total` = '".$saldo_total."' WHERE `crd_stok`.`kode_barang` = '".$kd_produk[$i]."' AND `crd_stok`.`kode_cabang` = '".$kode_cabang."' AND `crd_stok`.`kode_gudang` = '".$kode_gudang_asal."'";
												$query1 = mysql_query($mySql1);
																								
												$mySql2 = "INSERT INTO `crd_stok_dtl` (`kode_barang`, `tgl_buat`, `tgl_input`, `kode_cabang`, `kode_gudang`, `qty_out`, `harga_out`, `total_out`, `ref`, `note`, `kode_transaksi`) VALUES ('".$kd_produk[$i]."', '".$tgl_buat."', '".$tgl_input."', '".$kode_cabang."', '".$kode_gudang_asal."', '".$qty_out."', '".$rata[$i]."', '".($qty[$i] * $rata[$i])."', '".$ref."', '".$keterangan_dtl[$i]."', '".$kode_tg."')";
												$query2 = mysql_query($mySql2);
												
												$kode_coa_3 = '1.01.11.02';
												
												$mySql3 = "INSERT INTO `jurnal` (`kode_transaksi`, `tgl_input`, `tgl_buat`, `kode_cabang`, `keterangan_hdr`, `keterangan_dtl`, `ref`, `kode_coa`, `kredit`, `user_pencipta`) VALUES ('".$kode_tg."', '".$tgl_input."', '".$tgl_buat."', '".$kode_cabang."', '".$keterangan_hdr."', '".$keterangan_dtl[$i]."', '".$ref."', '".$kode_coa_3."', '".($qty[$i] * $rata[$i])."', '".$user_pencipta."')";
												$query3 = mysql_query($mySql3);
												
												$cek_stok_in = "SELECT `crd_stok`.`qty_in`, `crd_stok`.`qty_out` FROM `crd_stok` WHERE `crd_stok`.`kode_barang` = '".$kd_produk[$i]."' AND `crd_stok`.`kode_cabang` = '".$kode_cabang."' AND `crd_stok`.`kode_gudang` = '".$kode_gudang_tujuan."'";
												$q_cek_stok_in = mysql_query($cek_stok_in);
												
												if (mysql_num_rows($q_cek_stok_in) > 0) {
													while ($rQsi = mysql_fetch_array($q_cek_stok_in)) {
														
														$rumus_hpp = ($saldo_total + ($qty[$i] * $rata[$i])) / ($saldo_qty + $qty[$i]);
                                
														$qty_i_in = $rQsi['qty_in'] + $qty[$i];
														$qty_i_out = $rQsi['qty_out'];
														$saldo_qty_i = $qty_i_in - $qty_i_out;
														$saldo_last_hpp_i = ($rumus_hpp);
														$saldo_total_i = ($saldo_qty_i * $saldo_last_hpp_i);
														
														$insert_sh_in = "UPDATE `crd_stok` SET `qty_in` = '".$qty_i_in."', `saldo_qty` = '".$saldo_qty_i."', `saldo_last_hpp` = '".$saldo_last_hpp_i."', `saldo_total` = '".$saldo_total_i."' WHERE `kode_barang` = '".$kd_produk[$i]."' AND `kode_cabang` = '".$kode_cabang."' AND `kode_gudang` = '".$kode_gudang_tujuan."'";
														$q_insert_sh_in = mysql_query($insert_sh_in);
														
														$data_stokdtl_in = "INSERT INTO `crd_stok_dtl` (`kode_barang`, `tgl_buat`, `tgl_input`, `kode_cabang`, `kode_gudang`, `qty_in`, `harga_in`, `total_in`, `ref`, `note`, `kode_transaksi`) VALUES ('".$kd_produk[$i]."', '".$tgl_buat."', '".$tgl_input."', '".$kode_cabang."', '".$kode_gudang_tujuan."', '".$qty[$i]."', '".$rata[$i]."', '".($qty[$i] * $rata[$i])."', '".$ref."', '".$keterangan_dtl[$i]."', '".$kode_tg."')";
														$q_data_stokdtl_in = mysql_query($data_stokdtl_in);
														
													}
												} else {
													$insert_sh_in = "INSERT INTO `crd_stok` (`kode_barang`, `tgl_input`, `kode_cabang`, `kode_gudang`, `qty_in`, `saldo_qty`, `saldo_last_hpp`, `saldo_total`) VALUES ('".$kd_produk[$i]."', '".$tgl_input."', '".$kode_cabang."', '".$kode_gudang_tujuan."', '".$qty[$i]."', '".$qty[$i]."', '".$rata[$i]."', '".($qty[$i] * $rata[$i])."')";
													$q_insert_sh_in = mysql_query($insert_sh_in);
														
													$data_stokdtl_in = "INSERT INTO `crd_stok_dtl` (`kode_barang`, `tgl_buat`, `tgl_input`, `kode_cabang`, `kode_gudang`, `qty_in`, `harga_in`, `total_in`, `ref`, `note`, `kode_transaksi`) VALUES ('".$kd_produk[$i]."', '".$tgl_buat."', '".$tgl_input."', '".$kode_cabang."', '".$kode_gudang_tujuan."', '".$qty[$i]."', '".$rata[$i]."', '".($qty[$i] * $rata[$i])."', '".$ref."', '".$keterangan_dtl[$i]."', '".$kode_tg."')";
													$q_data_stokdtl_in = mysql_query($data_stokdtl_in);
												}
												
												$kode_coa_4 = '1.01.11.02';
												
												$mySql4 = "INSERT INTO `jurnal` (`kode_transaksi`, `tgl_input`, `tgl_buat`, `kode_cabang`, `keterangan_hdr`, `keterangan_dtl`, `ref`, `kode_coa`, `debet`, `user_pencipta`) VALUES ('".$kode_tg."', '".$tgl_input."', '".$tgl_buat."', '".$kode_cabang."', '".$keterangan_hdr."', '".$keterangan_dtl[$i]."', '".$ref."', '".$kode_coa_4."', '".($qty[$i] * $rata[$i])."', '".$user_pencipta."')";
												$query4 = mysql_query($mySql4);
											}
										} else {
											$cek_1[] = true;
											$cek_2[] = true;
											$cek_3[] = false;
											echo "99||Stok ".$nama_barang." di tanggal ".$tgl_buat." tidak ada";
										}
									}
								} else {
									$cek_1[] = true;
									$cek_2[] = false;
									$cek_3[] = false;
									echo "99||Stok ".$nama_barang." belum pernah ada";
								}
							}
						}
					} else {
						$cek_1[] = false;
						$cek_2[] = false;
						$cek_3[] = false;
						echo "99||Stok ".$nama_barang." belum pernah ada";
					}
					
					$tgDtl = "INSERT INTO `tg_dtl` (`kode_tg`, `kode_inventori`, `qty`, `hpp`, `total`, `keterangan_dtl`, `qty_tg_app`, `status_dtl`) VALUES ('".$kode_tg."', '".$kd_produk[$i]."', '".$qty_i[$i]."', '".$rata[$i]."', '".$total[$i]."', '".$keterangan_dtl[$i]."', '".$qty[$i]."', 'close')";
					$q_tgDtl = mysql_query($tgDtl);
				}
			}
			$cek_1s = array_unique($cek_1);
			$cek_2s = array_unique($cek_2);
			$cek_3s = array_unique($cek_3);
			if (count($cek_1s) === 1 && $cek_1s[0] && count($cek_2s) === 1 && $cek_2s[0] && count($cek_3s) === 1 && $cek_3s[0]) {
				$mySql	= "INSERT INTO `tg_hdr` SET 
						`kode_tg`					='".mres($kode_tg)."',
						`kode_pm`					='".mres($kode_pm)."',
						`kode_spk`					='".mres($kode_spk)."',
						`ref`						='".($ref)."',
						`kode_cabang`				='".($kode_cabang)."',
						`kode_gudang_from`				='".($kode_gudang_asal)."',
						`kode_gudang_to`				='".($kode_gudang_tujuan)."',
						`tgl_buat`				='".($tgl_buat)."',
						`keterangan_hdr`				='".($keterangan_hdr)."',
						`user_id`				='".($user_pencipta)."',
						`tgl_input`				='".($tgl_input)."',
						`status_hdr`				='close',
						`user_approve`				='".($user_pencipta)."',
						`tgl_approve`				='".($tgl_input)."'";
				$query = mysql_query($mySql);	
			} else {
				$query = false;
			}
		}
		

		if ($query AND $query1 AND $query2 AND $query3 AND $query4) {
			$mySql20 = "UPDATE `pm_hdr` SET `to_tg` = 'yes', `status_hdr` = 'close' WHERE `kode_pm` = '".($kode_pm)."'";
			$query20 = mysql_query($mySql20);
			
			$mySql30 = "UPDATE `pm_dtl` SET `status_dtl` = 'close' WHERE `kode_pm` = '".($kode_pm)."'";
			$query30 = mysql_query($mySql30);
			echo "00||".$kode_tg;

		} else { 
			echo "99||Gagal query: ".mysql_error();
		}		 	
	}
	
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save_retur" )
	{

		$form 			= 'TG';
		$thnblntgl 		= date("ymd",strtotime(mres($_POST['tanggal'])));
		$id_form			= mres($_POST['id_form']);
		$kode_pm	= mres($_POST['kode_pm']);
		$ref	= mres($_POST['ref']);
		$tgl_buat 		= date("Y-m-d",strtotime(mres($_POST['tanggal'])));
		$kode_cabang	= mres($_POST['kode_cabang']);
		$kode_gudang_asal	= mres($_POST['kode_gudang_a']);
		$kode_gudang_tujuan	= mres($_POST['kode_gudang_b']);
		$keterangan_hdr	= mres($_POST['keterangan']);
		$user_pencipta  	= $_SESSION['app_id'];
		$tgl_input 			= date("Y-m-d H:i:s");	
		$kd_produk = $_POST['kd_produk'];
		$kd_satuan = $_POST['kd_satuan'];
		$stok = $_POST['stok'];
		$qty = $_POST['qty'];
		$rata = $_POST['rata'];
		$total = $_POST['total'];
		$keterangan_dtl = $_POST['keterangan_dtl'];

		$kode_tg = buat_kode_tg($thnblntgl,$form,$kode_cabang);	
		
		$cek_1 = [];
		$cek_2 = [];
		$cek_3 = [];
		
		$query = false;
		$query1 = false;
		$query2 = false;
		$query3 = false;
		$query4 = false;
		$query5 = false;
		
		if (count($kd_produk) > 0) {
			for ($i = 0; $i < count($kd_produk); $i++) {
				if ($qty[$i] > 0) {					
					$stok_out = "SELECT `inventori`.`nama` AS `nama_barang`, `crd_stok`.`kode_barang`, `crd_stok`.`qty_in`, `crd_stok`.`qty_out`, `crd_stok`.`saldo_last_hpp`, `crd_stok`.`saldo_qty` FROM `crd_stok` LEFT JOIN `inventori` ON `crd_stok`.`kode_barang` = `inventori`.`kode_inventori` WHERE `crd_stok`.`kode_barang` = '".$kd_produk[$i]."' AND `crd_stok`.`kode_cabang` = '".$kode_cabang."' AND `crd_stok`.`kode_gudang` = '".$kode_gudang_asal."'";
					$q_stok_out = mysql_query($stok_out);
					
					if (mysql_num_rows($q_stok_out) > 0) {
						while ($rQso = mysql_fetch_array($q_stok_out)) {
							$nama_barang = $rQso['nama_barang'];
							$kode_barang = $rQso['kode_barang'];
							$saldo_qty = $rQso['saldo_qty'];
							
							if (number_format($qty[$i], 2) > number_format($saldo_qty, 2)) {
								$cek_1[] = false;
								$cek_2[] = false;
								$cek_3[] = false;
								echo "99||Stok ".$nama_barang." sisa ".number_format($saldo_qty, 2);
							} else {
								$tgl_awal_stok = "SELECT `crd_stok_dtl`.`tgl_buat` FROM `crd_stok_dtl` WHERE `crd_stok_dtl`.`kode_barang` = '".$kode_barang."' AND `crd_stok_dtl`.`kode_cabang` = '".$kode_cabang."' AND `crd_stok_dtl`.`kode_gudang` = '".$kode_gudang_asal."' ORDER BY `crd_stok_dtl`.`tgl_buat`, `crd_stok_dtl`.`id_crd_stok_dtl` ASC LIMIT 1";
								$q_tgl_awal_stok = mysql_query($tgl_awal_stok);
								
								if (mysql_num_rows($q_tgl_awal_stok) > 0) {
									$tgl_awal_x = mysql_fetch_array($q_tgl_awal_stok);
									if ($tgl_buat < $tgl_awal_x) {
										$cek_1[] = true;
										$cek_2[] = false;
										$cek_3[] = false;
										echo "99||Stok awal ".$nama_barang." tanggal ".$tgl_awal_x;
									} else {
										$stok_saat_itu = "SELECT SUM(`qty_in` - `qty_out`) AS `stok` FROM `crd_stok_dtl` WHERE `crd_stok_dtl`.`kode_barang` = '".$kode_barang."' AND `crd_stok_dtl`.`kode_cabang` = '".$kode_cabang."' AND `crd_stok_dtl`.`kode_gudang` = '".$kode_gudang_asal."' AND `crd_stok_dtl`.`tgl_buat` <= '".$tgl_buat."' GROUP BY `crd_stok_dtl`.`kode_barang`";
										$q_stok_saat_itu = mysql_query($stok_saat_itu);
										
										if (mysql_num_rows($q_stok_saat_itu) > 0) {
											$stok_saat_itu_x = mysql_fetch_array($q_stok_saat_itu);
											if ($qty[$i] > $stok_saat_itu_x) {
												$cek_1[] = true;
												$cek_2[] = true;
												$cek_3[] = false;
												echo "99||Stok ".$nama_barang." di tanggal ".$tgl_buat." sisa ".$stok_saat_itu_ada;
											} else {
												$cek_1[] = true;
												$cek_2[] = true;
												$cek_3[] = true;
												
												$qty_out        = $rQso['qty_out']+$qty[$i];
												$saldo_qty      = $rQso['qty_in']-$qty_out;
												$saldo_last_hpp = $rQso['saldo_last_hpp'];
												$saldo_total    = $saldo_qty * $saldo_last_hpp;
																								
												$mySql1 = "UPDATE `crd_stok` SET `crd_stok`.`qty_out` = '".$qty_out."', `crd_stok`.`saldo_qty` = '".$saldo_qty."', `crd_stok`.`saldo_last_hpp` = '".$saldo_last_hpp."', `crd_stok`.`saldo_total` = '".$saldo_total."' WHERE `crd_stok`.`kode_barang` = '".$kd_produk[$i]."' AND `crd_stok`.`kode_cabang` = '".$kode_cabang."' AND `crd_stok`.`kode_gudang` = '".$kode_gudang_asal."'";
												$query1 = mysql_query($mySql1);
																								
												$mySql2 = "INSERT INTO `crd_stok_dtl` (`kode_barang`, `tgl_buat`, `tgl_input`, `kode_cabang`, `kode_gudang`, `qty_out`, `harga_out`, `total_out`, `ref`, `note`, `kode_transaksi`) VALUES ('".$kd_produk[$i]."', '".$tgl_buat."', '".$tgl_input."', '".$kode_cabang."', '".$kode_gudang_asal."', '".$qty_out."', '".$rata[$i]."', '".($qty[$i] * $rata[$i])."', '".$ref."', '".$keterangan_dtl[$i]."', '".$kode_tg."')";
												$query2 = mysql_query($mySql2);
												
												$kode_coa_3 = '1.01.11.02';
												
												$mySql3 = "INSERT INTO `jurnal` (`kode_transaksi`, `tgl_input`, `tgl_buat`, `kode_cabang`, `keterangan_hdr`, `keterangan_dtl`, `ref`, `kode_coa`, `kredit`, `user_pencipta`) VALUES ('".$kode_tg."', '".$tgl_input."', '".$tgl_buat."', '".$kode_cabang."', '".$keterangan_hdr."', '".$keterangan_dtl."', '".$ref."', '".$kode_coa_3."', '".($qty[$i] * $rata[$i])."', '".$user_pencipta."')";
												$query3 = mysql_query($mySql3);
												
												$cek_stok_in = "SELECT `crd_stok`.`qty_in`, `crd_stok`.`qty_out` FROM `crd_stok` WHERE `crd_stok`.`kode_barang` = '".$kd_produk[$i]."' AND `crd_stok`.`kode_cabang` = '".$kode_cabang."' AND `crd_stok`.`kode_gudang` = '".$kode_gudang_tujuan."'";
												$q_cek_stok_in = mysql_query($cek_stok_in);
												
												if (mysql_num_rows($q_cek_stok_in) > 0) {
													while ($rQsi = mysql_fetch_array($q_cek_stok_in)) {
														
														$rumus_hpp = ($saldo_total + ($qty[$i] * $rata[$i])) / ($saldo_qty + $qty[$i]);
                                
														$qty_i_in = $rQsi['qty_in'] + $qty[$i];
														$qty_i_out = $rQsi['qty_out'];
														$saldo_qty_i = $qty_i_in - $qty_i_out;
														$saldo_last_hpp_i = ($rumus_hpp);
														$saldo_total_i = ($saldo_qty_i * $saldo_last_hpp_i);
														
														$insert_sh_in = "UPDATE `crd_stok` SET `qty_in` = '".$qty_i_in."', `saldo_qty` = '".$saldo_qty_i."', `saldo_last_hpp` = '".$saldo_last_hpp_i."', `saldo_total` = '".$saldo_total_i."' WHERE `kode_barang` = '".$kd_produk[$i]."' AND `kode_cabang` = '".$kode_cabang."' AND `kode_gudang` = '".$kode_gudang_tujuan."'";
														$q_insert_sh_in = mysql_query($insert_sh_in);
														
														$data_stokdtl_in = "INSERT INTO `crd_stok_dtl` (`kode_barang`, `tgl_buat`, `tgl_input`, `kode_cabang`, `kode_gudang`, `qty_in`, `harga_in`, `total_in`, `ref`, `note`, `kode_transaksi`) VALUES ('".$kd_produk[$i]."', '".$tgl_buat."', '".$tgl_input."', '".$kode_cabang."', '".$kode_gudang_tujuan."', '".$qty[$i]."', '".$rata[$i]."', '".($qty[$i] * $rata[$i])."', '".$ref."', '".$keterangan_dtl[$i]."', '".$kode_tg."')";
														$q_data_stokdtl_in = mysql_query($data_stokdtl_in);
														
													}
												} else {
													$insert_sh_in = "INSERT INTO `crd_stok` (`kode_barang`, `tgl_input`, `kode_cabang`, `kode_gudang`, `qty_in`, `saldo_qty`, `saldo_last_hpp`, `saldo_total`) VALUES ('".$kd_produk[$i]."', '".$tgl_input."', '".$kode_cabang."', '".$kode_gudang_tujuan."', '".$qty[$i]."', '".$qty[$i]."', '".$rata[$i]."', '".($qty[$i] * $rata[$i])."')";
													$q_insert_sh_in = mysql_query($insert_sh_in);
														
													$data_stokdtl_in = "INSERT INTO `crd_stok_dtl` (`kode_barang`, `tgl_buat`, `tgl_input`, `kode_cabang`, `kode_gudang`, `qty_in`, `harga_in`, `total_in`, `ref`, `note`, `kode_transaksi`) VALUES ('".$kd_produk[$i]."', '".$tgl_buat."', '".$tgl_input."', '".$kode_cabang."', '".$kode_gudang_tujuan."', '".$qty[$i]."', '".$rata[$i]."', '".($qty[$i] * $rata[$i])."', '".$ref."', '".$keterangan_dtl[$i]."', '".$kode_tg."')";
													$q_data_stokdtl_in = mysql_query($data_stokdtl_in);
												}
												
												$kode_coa_4 = '1.01.11.02';
												
												$mySql4 = "INSERT INTO `jurnal` (`kode_transaksi`, `tgl_input`, `tgl_buat`, `kode_cabang`, `keterangan_hdr`, `keterangan_dtl`, `ref`, `kode_coa`, `debet`, `user_pencipta`) VALUES ('".$kode_tg."', '".$tgl_input."', '".$tgl_buat."', '".$kode_cabang."', '".$keterangan_hdr."', '".$keterangan_dtl[$i]."', '".$ref."', '".$kode_coa_4."', '".($qty[$i] * $rata[$i])."', '".$user_pencipta."')";
												$query4 = mysql_query($mySql4);
											}
										} else {
											$cek_1[] = true;
											$cek_2[] = true;
											$cek_3[] = false;
											echo "99||Stok ".$nama_barang." di tanggal ".$tgl_buat." tidak ada";
										}
									}
								} else {
									$cek_1[] = true;
									$cek_2[] = false;
									$cek_3[] = false;
									echo "99||Stok ".$nama_barang." belum pernah ada";
								}
							}
						}
					} else {
						$cek_1[] = false;
						$cek_2[] = false;
						$cek_3[] = false;
						echo "99||Stok ".$nama_barang." belum pernah ada";
					}
					
					$tgDtl = "INSERT INTO `tg_dtl` (`kode_tg`, `kode_inventori`, `qty`, `hpp`, `total`, `keterangan_dtl`, `qty_tg_app`, `status_dtl`) VALUES ('".$kode_tg."', '".$kd_produk[$i]."', '".$stok[$i]."', '".$rata[$i]."', '".$total[$i]."', '".$keterangan_dtl[$i]."', '".$qty[$i]."', 'close')";
					$q_tgDtl = mysql_query($tgDtl);
				}
			}
			$cek_1s = array_unique($cek_1);
			$cek_2s = array_unique($cek_2);
			$cek_3s = array_unique($cek_3);
			if (count($cek_1s) === 1 && $cek_1s[0] && count($cek_2s) === 1 && $cek_2s[0] && count($cek_3s) === 1 && $cek_3s[0]) {
				$mySql	= "INSERT INTO `tg_hdr` SET 
						`kode_tg`					='".mres($kode_tg)."',
						`kode_pm`					='".mres($kode_pm)."',
						`ref`						='".($ref)."',
						`kode_cabang`				='".($kode_cabang)."',
						`kode_gudang_from`				='".($kode_gudang_asal)."',
						`kode_gudang_to`				='".($kode_gudang_tujuan)."',
						`tgl_buat`				='".($tgl_buat)."',
						`keterangan_hdr`				='".($keterangan_hdr)."',
						`user_pencipta`				='".($user_pencipta)."',
						`tgl_input`				='".($tgl_input)."',
						`status_hdr`				='close',
						`user_approve`				='".($user_pencipta)."',
						`tgl_approve`				='".($tgl_input)."'";
				$query = mysql_query($mySql);	
			} else {
				$query = false;
			}
		}
		

		if ($query AND $query1 AND $query2 AND $query3 AND $query4 AND $query5) {
			$mySql20 = "UPDATE `pm_hdr` SET `to_tg` = 'yes', `status_hdr` = 'close' WHERE `kode_pm` = '".($kode_pm)."'";
			$query20 = mysql_query($mySql20);
			
			$mySql30 = "UPDATE `pm_dtl` SET `status_dtl` = 'close' WHERE `kode_pm` = '".($kode_pm)."'";
			$query30 = mysql_query($mySql30);
			echo "00||".$kd_tg;

		} else { 
			echo "99||Gagal query: ".mysql_error();
		}		 	
	}