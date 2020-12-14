<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	require('../pages/data/script/cls_spk.php'); 
	date_default_timezone_set("Asia/Jakarta");
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loadspk")
	{
		$kode_cabang = $_POST['kode_cabang'];
		$tgl_buat 	 = date("Y-m-d",strtotime($_POST['tgl_buat']));
		
		$q_spk = mysql_query("SELECT kode_spk FROM spk_hdr WHERE kode_cabang='".$kode_cabang."' AND tgl_buat='".$tgl_buat."' ORDER BY kode_spk ASC");	
		
		$num_rows = mysql_num_rows($q_spk);
		if($num_rows>0)
		{		
			echo '<select id="doc_spk" name="doc_spk" class="select2">
					<option value="0">-- Pilih DOC SPK --</option>';
					 	
                	while($rowspk = mysql_fetch_array($q_spk)){
                    
         	echo '<option value="'.$rowspk['kode_spk'].'">'.$rowspk['kode_spk'].'</option>';
		 
	 				}
  
         	echo '</select>';
		}else{
			echo '<select id="doc_spk" name="doc_spk" class="select2" disabled>
                  	<option value="0">-- Tidak Ada DOC SPK--</option>
                  </select>';	
		}
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loaddtl" )
	{
		$kode_spk 	= $_POST['kode_spk'];
		$grandtotal = 0;
		$total 		= 0;
		
		$q_dtl = mysql_query("SELECT kode_spk, kode_barang, i.nama nama_barang, satuan, qty rencana_produksi FROM spk_hdr 
								LEFT JOIN inventori i ON i.kode_inventori = spk_hdr.kode_barang
								WHERE kode_spk = '".$kode_spk."' ");	
		
		$num_rows 	= mysql_num_rows($q_dtl);
		if($num_rows>0)
		{					 	
			while($rowdtl = mysql_fetch_array($q_dtl)){
				
				echo '<tr>
							<td>'.$rowdtl['kode_spk'].' 
								<input class="form-control" type="hidden" name="kode_spk" id="kode_spk" value="'.$rowdtl['kode_spk'].'"/>
							</td>
							<td>'.$rowdtl['kode_barang'].' 
								<input class="form-control" type="hidden" name="kode_barang" id="kode_barang" value="'.$rowdtl['kode_barang'].'"/>
							</td>
							<td>'.$rowdtl['nama_barang'].' 
								<input class="form-control" type="hidden" name="nama_barang" id="nama_barang" value="'.$rowdtl['nama_barang'].'"/>
							</td>
							<td style="text-align:center">'.$rowdtl['satuan'].' 
								<input class="form-control" type="hidden" name="satuan" id="satuan" value="'.$rowdtl['satuan'].'" />
							</td>
							<td>
								<input class="form-control" type="text" name="rencana_produksi" id="rencana_produksi"  value="'.number_format($rowdtl['rencana_produksi']).'" style="text-align:right" readonly/>
							</td>
							<td>
								<input class="form-control" type="number" name="realisasi_produksi" id="realisasi_produksi" autocomplete="off" value="0" required style="text-align:right"/> 
							</td>
							<td>
								<div class="input-group">
									<input type="text" class="form-control" name="persen" id="persen" autocomplete="off" value="" aria-describedby="basic-addon2" style="font-size: 13px; text-align: right" readonly>
									<span class="input-group-addon" id="basic-addon2"><b>%</b></span>
								</div>
							</td>
					</tr>';

			}
			
		}else{

			echo '<tr><td colspan="7" class="text-center">Belum ada item</td></tr>';

		}
		 				 
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loadmaterial" )
	{
		$kode_spk 		= $_POST['kode_spk'];
		
		$q_material = mysql_query("SELECT kode_barang, nama_barang, qty standart_pemakaian, total_qty transfer_material FROM spk_dtl
									WHERE kode_spk = '".$kode_spk."'
									ORDER BY kode_barang ASC");	
		
		$num_rows 	= mysql_num_rows($q_material);
		if($num_rows>0)
		{		

			while($rowmaterial = mysql_fetch_array($q_material)){
				
				echo '<tr>
							<td>'.$rowmaterial['kode_barang'].' 
								<input class="form-control" type="hidden" name="kode_barang_material[]" id="kode_barang_material[]" value="'.$rowmaterial['kode_barang'].'" style="width: 7em"/>
							</td>
							<td>'.$rowmaterial['nama_barang'].' 
								<input class="form-control" type="hidden" name="nama_barang_material[]" id="nama_barang_material[]" value="'.$rowmaterial['nama_barang'].'" style="width: 7em"/>
							</td>
							<td style="text-align:right">'.$rowmaterial['standart_pemakaian'].' 
								<input class="form-control" type="hidden" name="standart_pemakaian[]" id="standart_pemakaian[]" value="'.$rowmaterial['standart_pemakaian'].'"/>
							</td>
							<td style="text-align:right">'.$rowmaterial['transfer_material'].' 
								<input class="form-control" type="hidden" name="transfer_material[]" id="transfer_material[]" value="'.$rowmaterial['transfer_material'].'"/>
							</td>
							<td>
								<input class="form-control a" type="number" style="text-align:right" name="sisa_material[]" id="sisa_material[]" autocomplete="off" value="0" required onkeyup="hitungdetail();"/> 
							</td>
					</tr>';

			}
			
		}else{

			echo '<tr><td colspan="5" class="text-center">Belum ada item</td></tr>';

		}
		 				 
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loadproduksi" )
	{
		$kode_spk 		= $_POST['kode_spk'];
		$kode_cabang 	= $_POST['kode_cabang'];
		
		$q_produksi = mysql_query("SELECT kode_spk, sd.kode_barang, sd.nama_barang, sd.qty standart, sd.total_qty transfer_material, cs.saldo_last_hpp map FROM spk_dtl sd
											LEFT JOIN crd_stok cs ON cs.kode_barang = sd.kode_barang
											WHERE sd.kode_spk = '".$kode_spk."' AND cs.kode_cabang='".$kode_cabang."' AND kode_gudang='WH02'
											ORDER BY sd.kode_barang ASC");	
		
		$num_rows 	= mysql_num_rows($q_produksi);
		if($num_rows>0)
		{		

			while($rowproduksi = mysql_fetch_array($q_produksi)){
				
				echo '<tr>
							<td>'.$rowproduksi['kode_barang'].' 
								<input class="form-control" type="hidden" name="kode_barang_produksi[]" id="kode_barang_produksi[]" value="'.$rowproduksi['kode_barang'].'" style="width: 7em"/>
							</td>
							<td>'.$rowproduksi['nama_barang'].' 
								<input class="form-control" type="hidden" name="nama_barang_produksi[]" id="nama_barang_produksi[]" value="'.$rowproduksi['nama_barang'].'" style="width: 7em"/>
							</td>
							<td style="text-align:right">'.$rowproduksi['standart'].' 
								<input class="form-control e" type="hidden" name="standart[]" id="standart[]" value="'.$rowproduksi['standart'].'"/>
							</td>
							<td>
								<input class="form-control d" type="number" style="text-align:right" name="pemakaian_material[]" id="pemakaian_material[]" autocomplete="off" value="0" required readonly/> 
								
								<input class="form-control c" type="hidden" style="text-align:right" name="transfer_material_produksi[]" id="transfer_material_produksi[]" value="'.$rowproduksi['transfer_material'].'" readonly/> 
							
								<input class="form-control b" type="hidden" style="text-align:right" name="sisa_material_produksi[]" id="sisa_material_produksi[]" value"0" readonly /> 
							</td>
							<td>
								<input class="form-control f" type="number" style="text-align:right" name="variance[]" id="variance[]" autocomplete="off" value="0" required readonly/> 
							</td>
							<td style="text-align:right">'.$rowproduksi['map'].' 
								<input class="form-control g" type="hidden" name="map[]" id="map[]" value="'.$rowproduksi['map'].'"/>
							</td>
							<td>
								<input class="form-control h" type="number" style="text-align:right" name="var_nominal[]" id="var_nominal[]" autocomplete="off" value="0" required readonly/> 
							</td>
							<td>
								<div class="input-group">
									<input type="text" class="form-control i" name="var_persen[]" id="var_persen[]" autocomplete="off" value="" aria-describedby="basic-addon2" style="font-size: 13px; text-align: right" readonly>
									<span class="input-group-addon" id="basic-addon2"><b>%</b></span>
								</div>
							</td>
					</tr>';
			}
		}else{

			echo '<tr><td colspan="8" class="text-center">Belum ada item</td></tr>';

		}
		 				 
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save" )
	{
		mysqli_autocommit($con,FALSE);

		$form 				= 'CSP';
		$thnblntgl 			= date("ymd",strtotime($_POST['tgl_buat']));
		
		$ref 				= ($_POST['ref']);
		$kode_cabang 		= ($_POST['kode_cabang']);
		$kode_spk 			= ($_POST['doc_spk']);
		$keterangan_hdr 	= ($_POST['keterangan_hdr']);
		$tgl_buat 			= date("Y-m-d",strtotime($_POST['tgl_buat']));
		
		$kode_barang 		= ($_POST['kode_barang']);
		$nama_barang 		= ($_POST['nama_barang']);
		$satuan 			= ($_POST['satuan']);
		$rencana_produksi 	= ($_POST['rencana_produksi']);
		$realisasi_produksi = ($_POST['realisasi_produksi']);
		$persen_produksi 	= ($_POST['persen']);
		
		$user_pencipta  	= $_SESSION['app_id'];
		$tgl_input 			= date("Y-m-d H:i:s");
		
		$kode_cspk 			= buat_kode_cspk($thnblntgl,$form,$kode_cabang);
		
		//DETAIL CSPK
		$no_cspk				= $kode_cspk;
		$kode_barang_material	= $_POST['kode_barang_material'];
		$nama_barang_material	= $_POST['nama_barang_material'];
		$standart_pemakaian		= $_POST['standart_pemakaian'];
		$transfer_material		= $_POST['transfer_material'];
		$sisa_material			= $_POST['sisa_material'];
		$pemakaian_material		= $_POST['pemakaian_material']; 
		$variance				= $_POST['variance'];
		$map					= $_POST['map'];
		$var_nominal			= $_POST['var_nominal'];
		$var_persen				= $_POST['var_persen'];

		$count 	= count($kode_barang_material);

		$mySql1   	= "INSERT INTO cspk_dtl (kode_cspk,kode_barang,nama_barang,standart_pemakaian,transfer_material,sisa_material,pemakaian_material,var,map,var_nominal,var_persen) VALUES ";
		 
			for( $i=0; $i < $count; $i++ )
			{
				
				$mySql1 .= "('{$no_cspk}','{$kode_barang_material[$i]}','{$nama_barang_material[$i]}','{$standart_pemakaian[$i]}','{$transfer_material[$i]}','{$sisa_material[$i]}','{$pemakaian_material[$i]}','{$variance[$i]}','{$map[$i]}','{$var_nominal[$i]}','{$var_persen[$i]}')";
				$mySql1 .= ",";

				// //INSERT JURNAL DEBET
				// $mySql5	= "INSERT INTO jurnal SET 
				// 			kode_transaksi			='".$kode_cspk."',
				// 			tgl_buat				='".$tgl_buat."',
				// 			tgl_input				='".$tgl_input."',
				// 			kode_cabang				='".$kode_cabang."',
				// 			keterangan_hdr			='".$keterangan_hdr."',
				// 			ref						='".$ref."',
				// 			kode_coa				='',
				// 			debet					='".$nilai_total_asli."',
				// 			user_pencipta			='".$user_pencipta."';
				// 		";								
				// $query5 = mysqli_query ($con,$mySql5) ;	
				
				// //INSERT JURNAL KREDIT
				// $mySql6	= "INSERT INTO jurnal SET 
				// 			kode_transaksi			='".$kode_cspk."',
				// 			tgl_buat				='".$tgl_buat."',
				// 			tgl_input				='".$tgl_input."',
				// 			kode_cabang				='".$kode_cabang."',
				// 			keterangan_hdr			='".$keterangan_hdr."',
				// 			ref						='".$ref."',
				// 			kode_coa				='',
				// 			kredit					='".$nilai_total_asli."',
				// 			user_pencipta			='".$user_pencipta."';
				// 		";							
				// $query6 = mysqli_query ($con,$mySql6) ;
				
				// UNTUK CEK ITEM YANG MASUK KE STOK
				$q_cekitem = mysql_query("SELECT kode_inventori FROM inventori WHERE kode_inventori='".$kode_barang_material[$i]."' AND jenis_stok='1'");
				
				$num_rows = mysql_num_rows($q_cekitem);
				if($num_rows>0)
				{
					//VARIABEL AWAL 
					$qty_in_dtl 	= $sisa_material[$i];
					$harga_in_dtl 	= $map[$i];
					$total_in_dtl 	= ceil($qty_in_dtl*$harga_in_dtl);
					$ref_untuk_crd 	= 'close surat perintah kerja'; 
					
					//UNTUK CEK STOK
					$q_cekstok_hdr = mysql_query("SELECT * FROM crd_stok WHERE kode_barang='".$kode_barang_material[$i]."' AND kode_cabang='".$kode_cabang."' AND kode_gudang='WH02'");	
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
						$saldo_q 		= (int)$q_masuk-$qty_out;
						$saldo_last_hpp = ceil($rumus_hpp); 
						$saldo_total 	= ceil($saldo_q*$saldo_last_hpp);
						
						//UPDATE CRD STOK
						$mySql3 = " UPDATE crd_stok SET tgl_input='".$tgl_input."', qty_in='".$q_masuk."', saldo_qty='".$saldo_q."', saldo_last_hpp='".$saldo_last_hpp."', saldo_total='".$saldo_total."' WHERE kode_barang='".$kd_barang."' AND kode_cabang='".$kd_cabang."' AND kode_gudang='".$kd_gudang."' ";
						
						$query3 = mysqli_query ($con,$mySql3) ;
						
						//INSERT CRD STOK DTL
						$mySql4	= "INSERT INTO crd_stok_dtl SET 
									kode_barang				='".$kd_barang."',
									tgl_buat				='".$tgl_buat."',
									tgl_input				='".$tgl_input."',
									kode_cabang				='".$kd_cabang."',
									kode_gudang				='".$kd_gudang."',
									qty_in					='".$qty_in_dtl."',
									harga_in				='".$harga_in_dtl."',
									total_in				='".$total_in_dtl."',
									ref						='".$ref_untuk_crd."',
									note					='".$ref."',
									kode_transaksi			='".$no_cspk."';
								";	
								
						$query4 = mysqli_query ($con,$mySql4) ;		
						
					//JIKA BELUM ADA STOK
					}else{
						
						//INSERT CRD STOK 
						$mySql3	= "INSERT INTO crd_stok SET 
									kode_barang				='".$kd_barang."',
									tgl_input				='".$tgl_input."',
									kode_cabang				='".$kd_cabang."',
									kode_gudang				='".$kd_gudang."',
									qty_in					='".$qty_in_dtl."',
									saldo_qty				='".$qty_in_dtl."',
									saldo_last_hpp			='".$harga_in_dtl."',
									saldo_total				='".$total_in_dtl."';
								";	
								
						$query3 = mysqli_query ($con,$mySql3) ;
						
						//INSERT CRD STOK DTL
						$mySql4	= "INSERT INTO crd_stok_dtl SET 
									kode_barang				='".$kd_barang."',
									tgl_buat				='".$tgl_buat."',
									tgl_input				='".$tgl_input."',
									kode_cabang				='".$kd_cabang."',
									kode_gudang				='".$kd_gudang."',
									qty_in					='".$qty_in_dtl."',
									harga_in				='".$harga_in_dtl."',
									total_in				='".$total_in_dtl."',
									ref						='".$ref_untuk_crd."',
									note					='".$ref."',
									kode_transaksi			='".$no_cspk."';
								";	
								
						$query4 = mysqli_query ($con,$mySql4) ;			
						
					}
					
				}
				
			}
		 
		$mySql1 = rtrim($mySql1,",");
		$query1 = mysqli_query ($con,$mySql1) ;
		
		//HEADER cspk
		$mySql	= "INSERT INTO cspk_hdr SET 
						kode_cspk			='".$kode_cspk."',
						ref					='".$ref."',
						kode_cabang			='".$kode_cabang."',
						kode_spk			='".$kode_spk."',
						keterangan_hdr		='".$keterangan_hdr."',
						tgl_buat			='".$tgl_buat."',
						kode_barang			='".$kode_barang."',
						nama_barang			='".$nama_barang."',
						satuan				='".$satuan."',
						rencana_produksi	='".$rencana_produksi."',
						persen_produksi		='".$persen_produksi."',
						realisasi_produksi	='".$realisasi_produksi."',
						user_pencipta		='".$user_pencipta."',
						tgl_input			='".$tgl_input."';
					";	
						
		$query = mysqli_query ($con,$mySql) ;
		
		if ($query AND $query1 ) {
			
			// Commit transaction
			mysqli_commit($con);
			
			// Close connection
			mysqli_close($con);
			
			echo "00||".$kode_cspk;
			unset($_SESSION['data_cspk']);
			//unset($_SESSION['data_op'.$id_form .'']);
			//echo "00|| $mySql";
			
		} else { 
			
			echo "Gagal query: ".mysqli_error();
		}		 	
				
					 
	}

?>