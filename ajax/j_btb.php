<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	require('../pages/data/script/btb.php');
	date_default_timezone_set("Asia/Jakarta");

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loadop")
	{
		$kode_supplier = mres($_POST['kode_supplier']);
		$kode_cabang = mres($_POST['kode_cabang']);

		$q_op = mysql_query("SELECT `oph`.`kode_op`, `oph`.`kode_supplier`, `supp`.`nama` AS `nama_supplier`FROM `op_hdr` AS `oph` INNER JOIN `op_dtl` AS `opd` ON `opd`.`kode_op` = `oph`.`kode_op` INNER JOIN `supplier` AS `supp` ON `supp`.`kode_supplier` = `oph`.`kode_supplier` WHERE `oph`.`kode_supplier` = '".$kode_supplier."' AND `oph`.`kode_cabang` = '".$kode_cabang."' AND `opd`.`status_dtl` = '1' GROUP BY `oph`.`kode_op` ORDER BY `oph`.`kode_op` DESC");

		$num_rows = mysql_num_rows($q_op);
		if($num_rows>0)
		{
			echo '<select id="no_op" name="no_op" class="select2">
					<option value="0">-- Pilih No OP --</option>';

                	while($rowop = mysql_fetch_array($q_op)){

         	echo '<option value="'.$rowop['kode_op'].'" data-kode-supplier="'.$rowop['kode_supplier'].'" data-supplier="'.$rowop['kode_supplier'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowop['nama_supplier'].'" >'.$rowop['kode_op'].'</option>';

	 				}

         	echo '</select>';
		}else{
			echo '<select id="no_op" name="no_op" class="select2" disabled>
                  	<option value="0">-- Tidak Ada OP--</option>
                  </select>';
		}
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loadgudang" )
	{
		$kode_op = mres($_POST['kode_op']);

		$q_gud = mysql_query("SELECT `gud`.`kode_gudang`,`gud`.`nama` AS `nama_gudang` FROM `op_dtl` AS `opd` INNER JOIN `gudang` AS `gud` ON `gud`.`kode_gudang`=SUBSTRING_INDEX(`opd`.`kode_gudang`, ':', 1) WHERE `kode_op`='".$kode_op."' AND `status_dtl`='1' GROUP BY `gud`.`kode_gudang` ORDER BY `gud`.`kode_gudang` ASC");

		$num_rows = mysql_num_rows($q_gud);
		if($num_rows>0)
		{
			echo '<select id="kode_gudang" name="kode_gudang" class="select2">
					<option value="0">-- Pilih Gudang --</option>';

                	while($rowgud = mysql_fetch_array($q_gud)){

         	echo '<option value="'.$rowgud['kode_gudang'].'" >'.$rowgud['nama_gudang'].'</option>';

	 				}

         	echo '</select>';
		}else{
			echo '<select id="kode_gudang" name="kode_gudang" class="select2" disabled>
                  	<option value="0">-- Tidak Ada Gudang--</option>
                  </select>';
		}
	}


	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loaditem" )
	{
		$kode_op 		= mres($_POST['kode_op']);
		$kode_gudang	= mres($_POST['kode_gudang']);
		$grandtotal = 0;
		$total= 0;

		$q_dtl = mysql_query("SELECT `opd`.`kode_barang`, `opd`.`satuan`, `opd`.`qty` AS `qty_op`, `opd`.`satuan2`, `opd`.`qty_i`,
							(SELECT IFNULL(SUM(`qty`), 0) FROM `btb_dtl` AS `d` INNER JOIN `btb_hdr` AS `h` ON `h`.`kode_btb`=`d`.`kode_btb` INNER JOIN `op_hdr` AS `op` ON `h`.`kode_op`=`op`.`kode_op` WHERE `kode_barang`=`opd`.`kode_barang` AND `h`.`kode_op`=`opd`.`kode_op` AND `d`.`status_dtl` != '2') AS `qty_btb`,
							`opd`.`harga`, `opd`.`diskon`, `opd`.`diskon2`, `opd`.`diskon3`, `opd`.`ppn`, `tb_debet`, `tb_kredit`
							FROM `op_dtl` AS `opd`
							LEFT JOIN `btb_hdr` AS `tbh` ON `tbh`.`kode_op` = `opd`.`kode_op`
							LEFT JOIN `btb_dtl` AS `tbd` ON `tbd`.`kode_barang` = `opd`.`kode_barang` AND `tbd`.`kode_btb` = `tbh`.`kode_btb`
							LEFT JOIN `inventori` AS `inv` ON `inv`.`kode_inventori` = SUBSTRING_INDEX(`opd`.`kode_barang`, ':', 1)
							WHERE `opd`.`kode_op`='".$kode_op."' AND SUBSTRING_INDEX(`opd`.`kode_gudang`, ':', 1)='".$kode_gudang."' AND `opd`.`status_dtl`='1'
							GROUP BY `opd`.`kode_barang`
							ORDER BY `opd`.`kode_barang` ASC");

		$num_rows 	= mysql_num_rows($q_dtl);
		if($num_rows>0)
		{
			$no=0;
			$qty = 0;
			$qty_maksimum=0;
			$qty_maks=0;
			$qty_op=0;
			while($rowdtl = mysql_fetch_array($q_dtl)){
				
				$isian_qty 	  = ($rowdtl['qty_op']/$rowdtl['qty_i']);

				$qty_op   	  = ($rowdtl['qty_op']-$rowdtl['qty_btb']);
				$qty 		  = ($rowdtl['qty_op']-$rowdtl['qty_btb'])/$isian_qty;
				$qty_lbl	  = $rowdtl['qty_op']/$isian_qty;
				$qty_maks 	  = $qty;	

				$barang = $rowdtl['kode_barang'];
				$pisah = explode(":", $barang);
				$kd_barang = $pisah[0];
				$nm_barang = $pisah[1];
			
				$satuan = $rowdtl['satuan2'];
				$pisah = explode(":", $satuan);
				$kd_satuan = $pisah[0];
				$nm_satuan = $pisah[1];
				
				$no++;

				echo '<tr>
							<td style="text-align: center">
								'.$no.'
							</td>
							<td>
								'.$rowdtl['kode_barang']. ' - ' .$nm_barang.' 
								<input type="hidden" name="kode_barang[]" id="kode_barang_' . $no . '" data-id="' . $no . '" value="'.$rowdtl['kode_barang'].'" />
								<input type="hidden" name="tb_debet[]" id="tb_debet_' . $no . '" data-id="' . $no . '" value="'.$rowdtl['tb_debet'].'" />
								<input type="hidden" name="tb_kredit[]" id="tb_kredit_' . $no . '" data-id="' . $no . '" value="'.$rowdtl['tb_kredit'].'" />
							</td>
							<td style="text-align: right">
								'.number_format($qty_lbl, 2).'	'.$nm_satuan.'
								<input type="hidden" name="qty[]" id="qty_' . $no . '" data-id="' . $no . '" value="'.$qty.'" />
								<input type="hidden" name="qty_op[]" id="qty_op_' . $no . '"  data-id="' . $no . '" value="'.$qty_op.'" />
								<input type="hidden" name="satuan[]" id="satuan_' . $no . '" data-id="' . $no . '" value="'.$rowdtl['satuan'].'" />
								<input type="hidden" name="satuan2[]" id="satuan2_' . $no . '" data-id="' . $no . '" value="'.$rowdtl['satuan2'].'" />
							</td>
							<td style="text-align: right">
								<span id="text-qty_belum_' . $no . '" data-id="' . $no . '">'.number_format($qty, 2).'</span>'.$nm_satuan.'
								<button type="button" class="btn btn-info btn-sm move_qty" data-id="' . $no . '">
									<span class="fa fa-chevron-right"></span>
								</button>
							</td>
							<td>
								<div class="input-group">
									<span class="input-group-btn">
										<button type="button" class="btn btn-danger btn-sm reset_qty" data-id="' . $no . '">
											<span class="fa fa-close"></span>
										</button>
									</span>
									<input class="form-control" type="text" name="q_diterima[]" id="q_diterima_' . $no . '" autocomplete="off" value="0" data-id="' . $no . '" style="text-align: right" required />
									<span class="input-group-addon">' . $nm_satuan . '</span>
									<input type="hidden" name="qty_isi[]" id="qty_isi_' . $no . '" data-id="' . $no . '" value="'.$isian_qty.'" />
									<input type="hidden" name="harga[]" id="harga_' . $no . '" data-id="' . $no . '" value="'.$rowdtl['harga'].'" />
									<input type="hidden" name="diskon[]" id="diskon_' . $no . '" data-id="' . $no . '" value="'.$rowdtl['diskon'].'" />
									<input type="hidden" name="diskon2[]" id="diskon2_' . $no . '" data-id="' . $no . '" value="'.$rowdtl['diskon2'].'" />
									<input type="hidden" name="diskon3[]" id="diskon3_' . $no . '" data-id="' . $no . '" value="'.$rowdtl['diskon3'].'" />
									<input type="hidden" name="ppn[]" id="ppn_' . $no . '" data-id="' . $no . '" value="'.$rowdtl['ppn'].'" />
									<input type="hidden" name="qty_max[]" id="qty_max_' . $no . '" data-id="' . $no . '" value="'.$qty_maks.'" />
								</div>
							</td>
							<td>
								<textarea  class="form-control" name="keterangan_dtl[]" id="keterangan_dtl_' . $no . '" data-id="' . $no . '" placeholder="Keterangan..."></textarea>
							</td>
					</tr>';
			}

				echo '<tr>
							<input type="hidden" value="0" name="grand_total" id="grand_total" />
					  </tr>';

		}else{

			echo '<tr><td colspan="6" class="text-center">Belum ada item</td></tr>';

		}

	}


	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save" )
	{
		mysqli_autocommit($con,FALSE);

		$form 				=	'BTB';
		$thnblntgl 			=	date("ymd",strtotime(mres($_POST['tanggal'])));

		$ref 				=	mres($_POST['ref']);
		$kode_cabang 		=	mres($_POST['kode_cabang']);
		$keterangan_hdr 	=	mres($_POST['keterangan']);
		$tgl_buat 			=	date("Y-m-d",strtotime(mres($_POST['tanggal'])));

		$kode_op 			=	mres($_POST['no_op']);
		$kode_supplier 		=	mres($_POST['kode_supplier']);
		$kode_gudang 		=	mres($_POST['kode_gudang']);

		$user_pencipta  	= 	$_SESSION['app_id'];
		$tgl_input 			= 	date("Y-m-d H:i:s");

		$kode_btb 			=	buat_kode_btb($thnblntgl,$form,$kode_cabang);

		//DETAIL BTB
		$subtot 			= 0;
		$nilai_total_asli 	= 0;
		$nilai_ppn			= 0;
		$subtotal			= 0;
		$total_ppn			= 0;
		$total_harga		= 0;

		$qty 				= 0;

		$tb_debet		= $_POST['tb_debet'];
		$tb_kredit		= $_POST['tb_kredit'];

		$no_btb			= $kode_btb;
		$kode_barang	= $_POST['kode_barang'];
		$satuan			= $_POST['satuan'];
		$satuan2		= $_POST['satuan2'];
		$qty_op			= $_POST['qty_op'];
		$qty_diterima	= $_POST['q_diterima'];
		
		$qty_isi		= $_POST['qty_isi'];
		// $qty 			= ($qty_diterima*$qty_isi);
		$harga			= $_POST['harga'];
		$diskon			= $_POST['diskon'];
		$diskon2		= $_POST['diskon2'];
		$diskon3		= $_POST['diskon3'];
		$ppn			= $_POST['ppn'];
		$qty_max		= $_POST['qty_max'];
		$keterangan_dtl	= $_POST['keterangan_dtl'];
		$count 			= count($kode_barang);
		$diskon1x	=	0;
		$diskon2x	=	0;
		$diskon3x	=	0;

		$mySql1   	= "INSERT INTO `btb_dtl` (`kode_btb`, `kode_barang`, `satuan`, `qty_op`, `qty`, `harga`, `diskon`, `diskon2`, `diskon3`, `ppn`, `subtot`, `keterangan_dtl`, `qty_i`, `satuan2`) VALUES ";

			for( $i=0; $i < $count; $i++ ) {

				if(str_replace(',', null, $qty_diterima[$i]) > $qty_max[$i]){
					echo "99|| Qty yang diterima barang ".$kode_barang[$i]." Tidak Boleh Lebih dari OP yang Terbuka !";
					return false;
				}
				if(str_replace(',', null, $qty_diterima[$i]) > 0){
					$diskon1x = (mres($harga[$i]) - (mres($harga[$i]) * (mres($diskon[$i]) / 100)));
					$diskon2x = ($diskon1x - ($diskon1x * (mres($diskon2[$i]) / 100)));
					$diskon3x = ($diskon2x - ($diskon2x * (mres($diskon3[$i]) / 100)));
					
					$qty = (mres(str_replace(',', null, $qty_diterima[$i])) * mres($qty_isi[$i]));
					$nilai_total_asli = ($qty * $diskon3x);

					if($ppn[$i] === '1' || $ppn === 1){
						$nilai_ppn = ($nilai_total_asli - ($nilai_total_asli / 1.1));
					}else{
						$nilai_ppn = 0;
					}

					$subtot = $nilai_total_asli;

					//UNTUK BTB_HDR
					$total_harga 	+= $nilai_total_asli;
					$total_ppn 		+= $nilai_ppn;
					$subtotal 		+= $subtot;

					$pisah 		 = explode(":",mres($kode_barang[$i]));
					$code_barang = $pisah[0];

					// echo die($qty.' - '.$qty_max[$i]);

				

					$mySql1 .= "(
						'". mres($no_btb) ."',
						'". mres($kode_barang[$i]) ."',
						'" . mres($satuan[$i]) . "',
						'" . mres($qty_op[$i]) . "',
						'" . mres($qty) . "',
						'" . mres($harga[$i]) . "',
						'" . mres($diskon[$i]) . "',
						'" . mres($diskon2[$i]) . "',
						'" . mres($diskon3[$i]) . "',
						'" . mres($ppn[$i]) . "',
						'" . mres($subtot) . "',
						'" . mres($keterangan_dtl[$i]) . "',
						'" . mres(str_replace(',', null, $qty_diterima[$i])) . "',
						'" . mres($satuan2[$i]) . "'
					)";
					
					$mySql1 .= ",";
				

					//UNTUK UPDATE OP_DTL, JIKA QTY_BTB LEBIH BESAR / SAMA DENGAN QTY_OP = CLOSE
					if ($qty>=$qty_op[$i]) {
						$mySql2 = "UPDATE `op_dtl` SET `status_dtl`= '3' WHERE `kode_op` = '".$kode_op."' AND `kode_barang` = '" . mres($kode_barang[$i]) . "';";
					} else {
						$mySql2 = "UPDATE `op_dtl` SET `status_dtl`= '1' WHERE `kode_op` = '".$kode_op."' AND `kode_barang` = '" . mres($kode_barang[$i]) . "';";
					}

					$query2 = mysqli_query ($con,$mySql2);

					$mySql5	= "INSERT INTO `jurnal` SET
								`kode_transaksi`			='".mres($no_btb)."',
								`tgl_buat`				='".$tgl_buat."',
								`tgl_input`				='".$tgl_input."',
								`kode_cabang`				='".$kode_cabang."',
								`kode_supplier`			='".$kode_supplier."',
								`keterangan_hdr`			='".$keterangan_hdr."',
								`ref`						='".$ref."',
								`kode_coa`				='".mres($tb_debet[$i])."',
								`debet`					='".$subtot."',
								`user_pencipta`			='".$user_pencipta."';
							";		
					$query5 = mysqli_query ($con,$mySql5) ;

					//INSERT JURNAL KREDIT
					$mySql6	= "INSERT INTO `jurnal` SET
								`kode_transaksi`			='".mres($no_btb)."',
								`tgl_buat`				='".$tgl_buat."',
								`tgl_input`				='".$tgl_input."',
								`kode_cabang`				='".$kode_cabang."',
								`kode_supplier`			='".$kode_supplier."',
								`keterangan_hdr`			='".$keterangan_hdr."',
								`ref`						='".$ref."',
								`kode_coa`				='".mres($tb_kredit[$i])."',
								`kredit`					='".$subtot."',
								`user_pencipta`			='".$user_pencipta."';
							";
					$query6 = mysqli_query ($con,$mySql6) ;

					/*if($ppn[$i] == '1') {
						//INSERT JURNAL PPN DEBET
						$mySql7 = "INSERT INTO jurnal SET
									kode_transaksi 				='".$kode_btb."',
									tgl_input 					='".$tgl_input."',
									tgl_buat 					='".$tgl_buat."',
									kode_cabang					='".$kode_cabang."',
									kode_supplier				='".$kode_supplier."',
									keterangan_hdr				='".$keterangan_hdr."',
									ref 						='".$ref."',
									kode_coa					='1.01.16.01',
									debet 						='".$nilai_ppn."',
									user_pencipta 				='".$user_pencipta."'
								  ";
					}*/

					//UNTUK CEK ITEM YANG MASUK KE STOK
					$q_cekitem = mysql_query("SELECT `kode_inventori` FROM `inventori` WHERE `kode_inventori` = '".$code_barang."' AND `jenis_stok`='1'");

					$num_rows = mysql_num_rows($q_cekitem);
					if($num_rows>0) {
						//VARIABEL AWAL
						$qty_in_dtl 	= $qty;
						$harga_in_dtl 	= mres($harga[$i]);
						$total_in_dtl 	= $qty_in_dtl*$harga_in_dtl;
						$ref_untuk_crd 	= 'bukti terima barang';

						//UNTUK CEK STOK
						$q_cekstok_hdr = mysql_query("SELECT * FROM `crd_stok` WHERE `kode_barang`='".$code_barang."' AND `kode_cabang`='".$kode_cabang."' AND `kode_gudang`='".$kode_gudang."'");
						$num_rows1 = mysql_num_rows($q_cekstok_hdr);
						//JIKA ADA STOK
						if($num_rows1>0) {
							$rowstok_hdr = mysql_fetch_array($q_cekstok_hdr);

							$kd_barang 		= $rowstok_hdr['kode_barang'];
							$kd_cabang 		= $rowstok_hdr['kode_cabang'];
							$kd_gudang 		= $rowstok_hdr['kode_gudang'];
							$qty_in 		= $rowstok_hdr['qty_in'];
							$qty_out 		= $rowstok_hdr['qty_out'];
							$saldo_qty 		= $rowstok_hdr['saldo_qty'];
							$saldo_last_hpp = $rowstok_hdr['saldo_last_hpp'];
							$saldo_total 	= $rowstok_hdr['saldo_total'];

							$rumus_hpp 		= ($saldo_total+$total_in_dtl)/($saldo_qty+$qty_in_dtl);

							$q_masuk 		= $qty_in+$qty_in_dtl;
							$saldo_q 		= $q_masuk-$qty_out;
							$saldo_last_hpp = ($rumus_hpp);
							$saldo_total 	= ($saldo_q*$saldo_last_hpp);

							//UPDATE CRD STOK
							$mySql3 = " UPDATE `crd_stok` SET
											`tgl_input` 		='".$tgl_input."',
											`qty_in` 			='".$q_masuk."',
											`saldo_qty` 		='".$saldo_q."',
											`saldo_last_hpp` 	='".$saldo_last_hpp."',
											`saldo_total` 	='".$saldo_total."'
										WHERE `kode_barang`='".$code_barang."' AND `kode_cabang`='".$kd_cabang."' AND `kode_gudang`='".$kd_gudang."'";

							$query3 = mysqli_query ($con,$mySql3) ;

							//INSERT CRD STOK DTL
							$mySql4	= "INSERT INTO `crd_stok_dtl` SET
										`kode_barang`				='".$code_barang."',
										`tgl_buat`				='".$tgl_buat."',
										`tgl_input`				='".$tgl_input."',
										`kode_cabang`				='".$kd_cabang."',
										`kode_gudang`				='".$kd_gudang."',
										`qty_in`					='".$qty_in_dtl."',
										`harga_in`				='".$harga_in_dtl."',
										`total_in`				='".$total_in_dtl."',
										`ref`						='".$ref_untuk_crd."',
										`note`					='".$ref."',
										`kode_transaksi`			='".$kode_btb."';
									";

							$query4 = mysqli_query ($con,$mySql4) ;

						//JIKA BELUM ADA STOK
						}else{

							//INSERT CRD STOK
							$mySql3	= "INSERT INTO `crd_stok` SET
										`kode_barang`				='".$code_barang."',
										`tgl_input`				='".$tgl_input."',
										`kode_cabang`				='".$kode_cabang."',
										`kode_gudang`				='".$kode_gudang."',
										`qty_in`					='".$qty_in_dtl."',
										`saldo_qty`				='".$qty_in_dtl."',
										`saldo_last_hpp`			='".$harga_in_dtl."',
										`saldo_total`				='".$total_in_dtl."';
									";

							$query3 = mysqli_query ($con,$mySql3) ;

							//INSERT CRD STOK DTL
							$mySql4	= "INSERT INTO `crd_stok_dtl` SET
										`kode_barang`				='".$code_barang."',
										`tgl_buat`				='".$tgl_buat."',
										`tgl_input`				='".$tgl_input."',
										`kode_cabang`				='".$kode_cabang."',
										`kode_gudang`				='".$kode_gudang."',
										`qty_in`					='".$qty_in_dtl."',
										`harga_in`				='".$harga_in_dtl."',
										`total_in`				='".$total_in_dtl."',
										`ref`						='".$ref_untuk_crd."',
										`note`					='".$ref."',
										`kode_transaksi`			='".$kode_btb."';
									";

							$query4 = mysqli_query ($con,$mySql4) ;

						}

					}
					
					}
			}

		$mySql1 = rtrim($mySql1,",");

		// echo $mysql1; exit;
		
		$query1 = mysqli_query ($con,$mySql1) ;
		
		//HEADER BTB
		$mySql	= "INSERT INTO `btb_hdr` SET
						`kode_btb`				='".$kode_btb."',
						`ref`						='".$ref."',
						`kode_cabang`				='".$kode_cabang."',
						`keterangan_hdr`			='".$keterangan_hdr."',
						`tgl_buat`				='".$tgl_buat."',
						`kode_op`					='".$kode_op."',
						`kode_supplier`			='".$kode_supplier."',
						`kode_gudang`				='".$kode_gudang."',
						`user_pencipta`			='".$user_pencipta."',
						`tgl_input`				='".$tgl_input."',
						`total_harga`				='".$total_harga."',
						`total_ppn`				='".$total_ppn."',
						`subtotal`				='".$subtotal."';
					";
		$query = mysqli_query ($con,$mySql) ;

		if ($query AND $query1 AND $query2 AND $query3 AND $query4 and $query5 and $query6) {

			// Commit transaction
			mysqli_commit($con);

			// Close connection
			mysqli_close($con);

			echo "00||".$kode_btb;
			unset($_SESSION['data_btb']);
		} else {
			echo "Gagal query: ".mysqli_error();
		}
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "clsman" )
	{
		mysqli_autocommit($con,FALSE);
		$kode_op		= mres($_POST['kode_btb_batal']);
				
		//UPDATE OP_HDR 

		$mySql1 = "UPDATE `btb_hdr` SET `status` = '3' WHERE `kode_btb` = '".$kode_op."'";
		$query1 = mysqli_query ($con,$mySql1) ;
		
		$mySql2 = "UPDATE `btb_dtl` SET `status_dtl` = '3' WHERE `kode_btb`= '".$kode_op."'";
		$query2 = mysqli_query ($con,$mySql2) ;
		
		if ($query1 AND $query2 ) {
			mysqli_commit($con);
			mysqli_close($con);
			echo "00||".$kode_op;
		} else { 
			echo "Gagal query: ".mysql_error();
		}	
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "pembatalan" )
	{
		mysqli_autocommit($con,FALSE);

		$kode_btb		= $_POST['kode_btb_batal'];
		$kode_cabang	= $_POST['kode_cabang_batal'];
		$kode_gudang	= $_POST['kode_gudang_batal'];
		$alasan_batal	= $_POST['alasan_batal'];
		$tgl_batal 		= date("Y-m-d");
		
		$cekFb = "SELECT `kode_btb` FROM `fb_hdr` WHERE `status` = '1' AND `kode_btb` = '".$kode_btb."'";
		$queryFb = mysqli_query($con, $cekFb);
		
		if (mysqli_num_rows($queryFb) > 0) {
			mysqli_commit($con);
			mysqli_close($con);
			echo "99||Kode BTB " . $kode_fb . " sudah Faktur Beli!";
			return false;
		}

		//UPDATE BTB_HDR
		$mySql1 = "UPDATE btb_hdr SET status ='2', alasan_batal = '" . $alasan_batal . "', user_batal = '" . $_SESSION['app_id'] . "', tgl_batal = '" . $tgl_batal . "' WHERE kode_btb='".$kode_btb."' ";
		$query1 = mysqli_query ($con,$mySql1) ;

		//UPDATE BTB_DTL
		$mySql2 = "UPDATE btb_dtl SET status_dtl ='2' WHERE kode_btb='".$kode_btb."' ";
		$query2 = mysqli_query ($con,$mySql2) ;

		//JIKA QTY >= QTY_OP STATUS_DTL = 1
		$kode_op = mysql_query("SELECT bh.kode_op, bd.qty_op, bd.qty FROM btb_hdr bh LEFT JOIN btb_dtl bd ON bd.kode_btb = bh.kode_btb WHERE bh.kode_btb = '".$kode_btb."' ");
		$num_row_desc = mysql_num_rows($kode_op);
		if($num_row_desc > 0){
			while($row_desc = mysql_fetch_array($kode_op)){

				$kode 	= $row_desc['kode_op'];
				$qty_op = $row_desc['qty_op'];
				$qty 	= $row_desc['qty'];

				if($qty >= $qty_op){
					$mySql3 = "UPDATE op_dtl SET status_dtl ='1' WHERE kode_op = '".$kode."' ";
					$query3 = mysqli_query ($con,$mySql3) ;
				}else{
					$mySql3 = "UPDATE op_dtl SET status_dtl ='1' WHERE kode_op = '".$kode."' ";
					$query3 = mysqli_query ($con,$mySql3) ;
				}
			}
		}

		//INSERT CRD_STOK_DTL
		$kode_barang = mysql_query("SELECT kode_barang FROM btb_dtl WHERE kode_btb = '".$kode_btb."'");
		$num_row_b   = mysql_num_rows($kode_barang);
		if($num_row_b > 0){
			while($row_b = mysql_fetch_array($kode_barang)){

				$kd_barang 	 = '';
				$barang = $row_b['kode_barang'];
				if(!empty($barang)) {
					$pisah 		= explode(":",$barang);
					$kd_barang 	= $pisah[0];
				}

				$crd_stok_dtl = mysql_query("SELECT qty_in, harga_in, total_in FROM crd_stok_dtl WHERE kode_barang = '".$kd_barang."' AND kode_cabang = '".$kode_cabang."' AND kode_gudang = '".$kode_gudang."' AND kode_transaksi = '".$kode_btb."'");
				$num_row_cd = mysql_num_rows($crd_stok_dtl);
				if($num_row_cd > 0) {
					$row_cd = mysql_fetch_array($crd_stok_dtl);

						$qty_in   = $row_cd['qty_in'];
						$harga_in = $row_cd['harga_in'];
						$total_in = $row_cd['total_in'];
						$tgl_input= date("Y-m-d H:i:s");

						$mySql5 = "INSERT INTO crd_stok_dtl SET
									kode_barang 	='".$kd_barang."',
									tgl_input 		='".$tgl_input."',
									kode_cabang 	='".$kode_cabang."',
									kode_gudang 	='".$kode_gudang."',
									qty_out 		='".$qty_in."',
									harga_out 		='".$harga_in."',
									total_out 		='".$total_in."',
									ref  			='bukti terima barang batal',
									kode_transaksi  ='".$kode_btb."',
									tgl_buat 		='".$tgl_batal."'
							";
						$query5 = mysqli_query ($con,$mySql5) ;
				}

				$crd_stok = mysql_query("SELECT * FROM crd_stok WHERE kode_barang = '".$kd_barang."' AND kode_cabang = '".$kode_cabang."' AND kode_gudang = '".$kode_gudang."'");
				$num_row_c = mysql_num_rows($crd_stok);
				if($num_row_c > 0) {
					$row_c = mysql_fetch_array($crd_stok);

						$qty_masuk 	 	= $row_c['qty_in'];
						$qty_keluar 	= $row_c['qty_out'];
						$saldo_total 	= $row_c['saldo_total'];

						$qty_out 		= ($qty_keluar+$qty_in);
						$saldo_qty 		= ($qty_masuk-$qty_out);
						$hpp 	 		= ($saldo_total+$total_in)/($saldo_qty+$qty_in);
						$saldo_total1 	= ($saldo_qty*$hpp);

						$mySql6 = "UPDATE crd_stok SET
									kode_barang 	='".$kd_barang."',
									tgl_input 		='".$tgl_input."',
									kode_cabang 	='".$kode_cabang."',
									kode_gudang 	='".$kode_gudang."',
									qty_in 			='".$qty_masuk."',
									qty_out 		='".$qty_out."',
									saldo_qty 		='".$saldo_qty."',
									saldo_last_hpp 	='".$hpp."',
									saldo_total  	='".$saldo_total1."'
									WHERE kode_barang = '".$kd_barang."' AND kode_cabang = '".$kode_cabang."' AND kode_gudang = '".$kode_gudang."'
							";
						$query6 = mysqli_query ($con,$mySql6) ;
				}
			}
		}

		//INSERT JURNAL
		$jurnal = mysql_query("SELECT * FROM jurnal WHERE kode_transaksi = '".$kode_btb."' ");
		$num_row_j  = mysql_num_rows($jurnal);

		if($num_row_j > 0){
			while($row_j = mysql_fetch_array($jurnal)){

				$kode_transaksi 	= $row_j['kode_transaksi'];
				$ref 				= $row_j['ref'];
				$kode_supplier 		= $row_j['kode_supplier'];
				$kode_pelanggan 	= $row_j['kode_pelanggan'];
				$kode_coa 			= $row_j['kode_coa'];
				$debet 				= $row_j['debet'];
				$kredit 			= $row_j['kredit'];
				$keterangan_hdr 	= $row_j['keterangan_hdr'];
				$keterangan_dtl 	= $row_j['keterangan_dtl'];

				$mySql7 = "INSERT INTO jurnal SET
								kode_transaksi 	='".$kode_transaksi."',
								ref 			='".$ref."',
								tgl_buat 		='".$tgl_batal."',
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

				$mySql8 = "UPDATE jurnal SET status_jurnal ='1' WHERE kode_transaksi = '".$kode_transaksi."' ";
				$query8 = mysqli_query ($con,$mySql8) ;
			}
		}

		if ($query1 AND $query2 AND $query3 AND $query5 AND $query6 AND $query7 AND $query8) {

			mysqli_commit($con);
			mysqli_close($con);

			echo "00||".$kode_btb;
		} else {
			echo "99||Gagal query: ".mysql_error();
		}
	}


?>
