<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	require('../pages/data/script/fb.php'); 
	date_default_timezone_set("Asia/Jakarta");


if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loadjt" )
	{
		
		$kode_supplier = mres($_POST['kode_supplier']);
		$tgl_buat = date('Y-m-d', strtotime(mres($_POST['tgl_buat'])));
		
		$q_jt = mysql_query("SELECT DATE_ADD('".$tgl_buat."', INTERVAL `s`.`jatuh_tempo` DAY) AS `jatuh_tempo_fb` FROM `supplier` AS `s` WHERE `s`.`kode_supplier` = '".$kode_supplier."' ");	
		
		$num_rows = mysql_num_rows($q_jt);
		if($num_rows>0)
		{		
			$rowjt = mysql_fetch_array($q_jt);

			echo '<input type="text" name="tgl_jt_tempo" id="tgl_jt_tempo" class="form-control" placeholder="Pilih supplier dahulu ..." value="'.date('m/d/Y', strtotime($rowjt['jatuh_tempo_fb'])).'" readonly/><span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>';
		}else{

			echo '<input type="text" name="tgl_jt_tempo" id="tgl_jt_tempo" class="form-control" placeholder="Pilih supplier dahulu ..." value="'.date('m/d/Y').'" readonly/><span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>';
		}
	}

if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loaditem" )
	{
		$kode_supplier 	= mres($_POST['kode_supplier']);
		$kode_cabang 	= mres($_POST['kode_cabang']);

		$q_dtl 		= mysql_query("SELECT `od`.`kode_barang` AS `barang`, `i`.`nama` AS `nama_barang`, `od`.`kode_op`, COALESCE(`bd`.`kode_btb`, '-') AS `kode_btb`, SUBSTRING_INDEX(`od`.`kode_barang`, ':', 1) AS `kode_barang`, `oh`.`keterangan_hdr`, `i`.`fb_debet`, `i`.`fb_kredit`,
									`od`.`status_dtl` AS `status_dtl_op`,
									IF(`bd`.`kode_btb` != 0, `bd`.`status_dtl`, `od`.`status_dtl`) AS `status_dtl`,
									IF(`bd`.`kode_btb` != 0, `bd`.`qty`, `od`.`qty`) AS `qty`, 
									IF(`bd`.`kode_btb` != 0, `bd`.`harga`, `od`.`harga`) AS `harga`, 
									IF(`bd`.`kode_btb` != 0, `bd`.`diskon`, `od`.`diskon`) AS `diskon`, 
									IF(`bd`.`kode_btb` != 0, `bd`.`diskon2`, `od`.`diskon2`) AS `diskon2`, 
									IF(`bd`.`kode_btb` != 0, `bd`.`diskon3`, `od`.`diskon3`) AS `diskon3`, 
									IF(`bd`.`kode_btb` != 0, `bd`.`ppn`, `od`.`ppn`) AS `ppn`, 
									IF(`bd`.`kode_btb` != 0, `bd`.`keterangan_dtl`, `od`.`keterangan_dtl`) AS `keterangan_dtl`
									FROM `op_dtl` AS `od`
									LEFT JOIN `op_hdr` AS `oh` ON `oh`.`kode_op` = `od`.`kode_op`
									LEFT JOIN `btb_hdr` AS `bh` ON `bh`.`kode_op` = `od`.`kode_op` AND `bh`.`kode_cabang` = `oh`.`kode_cabang` AND `bh`.`kode_supplier` = `oh`.`kode_supplier`  
									LEFT JOIN `btb_dtl` AS `bd` ON  `bd`.`kode_btb` = `bh`.`kode_btb` AND SUBSTRING_INDEX(`od`.`kode_barang`, ':', 1) = SUBSTRING_INDEX(`bd`.`kode_barang`, ':', 1)
									LEFT JOIN `inventori` AS `i` ON `i`.`kode_inventori` = SUBSTRING_INDEX(`od`.`kode_barang`, ':', 1)
									WHERE `oh`.`kode_cabang` = '".$kode_cabang."' AND `oh`.`kode_supplier` = '".$kode_supplier."' AND IF(`bd`.`kode_btb` != 2, `bd`.`status_dtl`, `od`.`status_dtl`) = '1'
									GROUP BY `kode_barang`, `kode_op`
									ORDER BY `kode_barang`, `kode_op`, `kode_btb` ASC");
		$num_rows 	= mysql_num_rows($q_dtl);
		if($num_rows>0)
		{		
			$no=0;
			$diskon1x	=	0;
			$diskon2x	=	0;
			$diskon3x	=	0;
			$diskon3x	=	0;
			while($rowdtl = mysql_fetch_array($q_dtl)){
				
				/* if ($rowdtl['status_dtl_op'] == '3') {
					continue;
				} */
				
				$diskon1x = ($rowdtl['harga'] - ($rowdtl['harga'] * ($rowdtl['diskon'] / 100)));
				$diskon2x = ($diskon1x - ($diskon1x * ($rowdtl['diskon2'] / 100)));
				$diskon3x = ($diskon2x - ($diskon2x * ($rowdtl['diskon3'] / 100)));
				
				$dpp = ($diskon3x * $rowdtl['qty']);
				
				if($rowdtl['ppn'] === '1') {
					$total_ppn = ($dpp - ($dpp / 1.1));
				}else{
					$total_ppn = 0;
				}
				
				$total_harga = ($dpp - $total_ppn);
				
				$subtotal = ($total_harga + $total_ppn);
				
				if ($subtotal > 0) {
					echo '<tr style="'.($rowdtl['status_dtl_op'] == '3' ? 'background-color: #ffccff' : '').'">
								<td><input class="checkbox"  type="checkbox" name="cb[]" id="cb[]" data-id="cb" data-group="'.$no.'" value="'.$no.'"></td>
								<td>'.$rowdtl['nama_barang'].'
									<input class="form-control" type="hidden" name="kode_barang[]" id="kode_barang[]" data-id="kode_barang" data-group="'.$no.'" value="'.$rowdtl['barang'].'" style="width: 7em"/>
								</td>
								<td>
									<a href="'.base_url().'?page=pembelian/op_track&action=track&halaman= TRACK ORDER PEMBELIAN&kode_op='.$rowdtl['kode_op'].'" target="_blank">'.$rowdtl['kode_op'].'</a> ' . ($rowdtl['status_dtl_op'] == '3' ? '(x)' : '') . '
									<input class="form-control" type="hidden" name="kode_op[]" id="kode_op[]" data-id="kode_op" data-group="'.$no.'" value="'.$rowdtl['kode_op'].'" style="width: 7em"/>
								</td>
								<td>
									'.($rowdtl['kode_btb'] != '-' ?'<a href="'.base_url().'?page=logistik/btb_track&action=track&halaman= TRACK BUKTI TERIMA BARANG&kode_btb='.$rowdtl['kode_btb'].'" target="_blank">'.$rowdtl['kode_btb'].'</a>'  : $rowdtl['kode_btb'] ).'
									<input class="form-control" type="hidden" name="kode_btb[]" id="kode_btb[]" data-id="kode_btb" data-group="'.$no.'" value="'.$rowdtl['kode_btb'].'" style="width: 7em"  />
								</td>
								<td style="text-align: right">'.number_format($total_harga, 2).' 
									<input class="form-control" type="hidden" name="harga[]" id="harga[]" data-id="harga" data-group="'.$no.'" value="'.$total_harga.'" style="width: 7em"/>
								</td>
								<td style="text-align: right">'.number_format($total_ppn, 2).' 
									<input class="form-control" type="hidden" name="ppn[]" id="ppn[]" data-id="ppn" data-group="'.$no.'" value="'.$total_ppn.'" style="width: 7em"/>
								</td>
								<td style="text-align: right">'.number_format($subtotal, 2).' 
									<input class="form-control" type="hidden" name="subtotal[]" id="subtotal[]" data-id="subtotal" data-group="'.$no.'" value="'.$subtotal.'" style="width: 7em"/>
								</td>
								<td>'.$rowdtl['keterangan_dtl'].' 
									<input class="form-control" type="hidden" name="fb_debet[]" id="fb_debet[]" data-id="fb_debet" data-group="'.$no.'" value="'.$rowdtl['fb_debet'].'" style="width: 7em"/>
									<input class="form-control" type="hidden" name="fb_kredit[]" id="fb_kredit[]" data-id="fb_kredit" data-group="'.$no.'" value="'.$rowdtl['fb_kredit'].'" style="width: 7em"/>
									<input class="form-control" type="hidden" name="keterangan_dtl[]" id="keterangan_dtl[]" data-id="keterangan_dtl" data-group="'.$no++.'" value="'.$rowdtl['keterangan_dtl'].'" style="width: 7em"/>
								</td>
								
						</tr>';
				}
			}

				echo'<tr>
						<td colspan="6" style="text-align:right">Subtotal</td>
						<td style="text-align:right; width: 0px">
							<input class="form-control" type="text" name="subtotal_all" id="subtotal_all" autocomplete="off" value="0" readonly style="text-align: right"/>
						</td>
						<td></td>
					</tr>
					
					<tr>
						<td colspan="6" style="text-align:right">PPn</td>
						<td style="text-align:right">
							<input class="form-control" type="text" name="ppn_all" id="ppn_all" autocomplete="off" value="0" readonly style="text-align: right"/>
						</td>
						<td></td>
					</tr>
					
					<tr>
						<td colspan="6" style="text-align:right; font-weight:bold">Total</td>
						<td style="text-align:right; font-weight:bold">
							<input class="form-control" type="text" name="grand_total" id="grand_total" autocomplete="off" value="0" readonly style="text-align: right"/>
						</td>
						<td></td>
					</tr>
			';
			
		}else{

			echo '<tr><td colspan="10" class="text-center">Belum ada item</td></tr>';

		}
		 				 
	}


if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save" )
	{
		mysqli_autocommit($con,FALSE);

		$form 				='FB';
		$thnblntgl 			=date("ymd",strtotime(mres($_POST['tgl_fb'])));
		
		$ref 				=mres($_POST['ref']);
		$kode_cabang 		=mres($_POST['kode_cabang']);
		$kode_supplier 		=mres($_POST['supplier']);
		$keterangan_hdr 	=mres($_POST['keterangan']);
		$tgl_buat 			=date("Y-m-d",strtotime(mres($_POST['tgl_fb'])));
		$tgl_jth_tempo 		=date("Y-m-d",strtotime(mres($_POST['tgl_jt_tempo'])));

		$subtotal_all 		= mres(str_replace(',', null, $_POST['subtotal_all']));
		$ppn_all 			= mres(str_replace(',', null, $_POST['ppn_all']));
		$grand_total 		= mres(str_replace(',', null, $_POST['grand_total']));
		
		$user_pencipta  	= $_SESSION['app_id'];
		$tgl_input 			= date("Y-m-d H:i:s");
		
		$kode_fb 			= buat_kode_fb($thnblntgl,$form,$kode_cabang);

		//DETAIL FB
		$no_fb			= $kode_fb;
		$cb 			= $_POST['cb'];
		$kode_op 		= $_POST['kode_op'];
		$kode_btb 		= $_POST['kode_btb'];
		$kode_barang 	= $_POST['kode_barang'];
		$deskripsi		= $_POST['keterangan_dtl'];
		$harga			= $_POST['harga']; 
		$ppn			= $_POST['ppn']; 
		$subtotal		= $_POST['subtotal']; 
		$keterangan_dtl	= $_POST['keterangan_dtl'];
		$fb_debet 		= $_POST['fb_debet'];
		$fb_kredit 		= $_POST['fb_kredit'];
		$count 			= count($cb);

		$mySql1   = "INSERT INTO `fb_dtl` (`kode_fb`, `kode_op`, `kode_btb`, `kode_barang`, `deskripsi`, `harga`, `nilai_ppn`, `subtot`, `keterangan_dtl`) VALUES ";

			for( $i=0; $i < $count; $i++ ){

				$mySql1 .= $i > 0 ? ", " : '';
				$mySql1 .= "(
					'" . mres($no_fb) . "',
					'" . mres($kode_op[$cb[$i]]) . "',
					'" . mres($kode_btb[$cb[$i]]) . "',
					'" . mres($kode_barang[$cb[$i]]) . "',
					'" . mres($deskripsi[$cb[$i]]) . "',
					'" . mres(str_replace(',', null, $harga[$cb[$i]])) . "',
					'" . mres(str_replace(',', null, $ppn[$cb[$i]])) . "',
					'" . mres(str_replace(',', null, $subtotal[$cb[$i]])) . "',
					'" . mres($keterangan_dtl[$cb[$i]]) . "'
				)";

				$kode_barang_td = mres($kode_barang[$cb[$i]]);
				$kode_btb_td 	= mres($kode_btb[$cb[$i]]);
				$kode_op_td 	= mres($kode_op[$cb[$i]]);

				//INSERT JURNAL DEBET
				$mySql3 = "INSERT INTO `jurnal` SET
							`kode_transaksi` 	='".mres($kode_fb)."', 
							`ref` 			='".mres($ref)."',
							`tgl_buat` 		='".mres($tgl_buat)."',
							`kode_cabang`		='".mres($kode_cabang)."',
							`kode_supplier`	='".mres($kode_supplier)."',
							`kode_coa`		='".mres($fb_debet[$cb[$i]])."',
							`debet` 			='".mres(str_replace(',', null, $harga[$cb[$i]]))."',
							`tgl_input` 		='".mres($tgl_input)."',
							`keterangan_hdr`	='".mres($keterangan_hdr)."',
							`keterangan_dtl`	='".mres($keterangan_dtl[$cb[$i]])."',
							`user_pencipta` 	='".$user_pencipta."'
							";
				$query3 = mysqli_query ($con,$mySql3) ;

				$ppn_dtl = mres(str_replace(',', null, $ppn[$cb[$i]]));
				if ($ppn_dtl > 0) {
					//PPN MASUKAN
					$mySql4 = "INSERT INTO `jurnal` SET
								`kode_transaksi` 	='".mres($kode_fb)."', 
								`ref` 			='".mres($ref)."',
								`tgl_buat` 		='".mres($tgl_buat)."',
								`kode_cabang`		='".mres($kode_cabang)."',
								`kode_supplier`	='".mres($kode_supplier)."',
								`kode_coa`		='1.01.15.01',
								`debet` 			='".mres(str_replace(',', null, $ppn[$cb[$i]]))."',
								`tgl_input` 		='".mres($tgl_input)."',
								`keterangan_hdr`	='".mres($keterangan_hdr)."',
								`keterangan_dtl`	='".mres($keterangan_dtl[$cb[$i]])."',
								`user_pencipta` 	='".$user_pencipta."'
							  "; 
					$query4 = mysql_query ($mySql4);
				} else {
					$query4 = true;
				}

				//INSERT JURNAL KREDIT
				$mySql5 = "INSERT INTO `jurnal` SET
							`kode_transaksi` 	='".mres($kode_fb)."', 
							`ref` 			='".mres($ref)."',
							`tgl_buat` 		='".mres($tgl_buat)."',
							`kode_cabang`		='".mres($kode_cabang)."',
							`kode_supplier`	='".mres($kode_supplier)."',
							`kode_coa`		='".mres($fb_kredit[$cb[$i]])."',
							`kredit` 			='".mres(str_replace(',', null, $subtotal[$cb[$i]]))."',
							`tgl_input` 		='".mres($tgl_input)."',
							`keterangan_hdr`	='".mres($keterangan_hdr)."',
							`keterangan_dtl`	='".mres($keterangan_dtl[$cb[$i]])."',
							`user_pencipta` 	='".$user_pencipta."'
						  ";  
				$query5 = mysqli_query ($con,$mySql5);

				if($kode_btb_td != '-'){
					//UPDATE BTB_DTL
					$mySql6	= " UPDATE `btb_dtl` SET `status_dtl` ='3' WHERE `kode_btb` = '".$kode_btb_td."' AND `kode_barang` = '".$kode_barang_td."'";
					$query6 = mysqli_query ($con,$mySql6) ;
				}else{
					//UPDATE OP_DTL
					$mySql6	= " UPDATE `op_dtl` SET `status_dtl` ='3' WHERE `kode_op` = '".$kode_op_td."' AND `kode_barang` = '".$kode_barang_td."'";
					$query6 = mysqli_query ($con,$mySql6) ;
				}
			}

		$mySql1 = rtrim($mySql1,",");
		$query1 = mysqli_query ($con,$mySql1) ;

		//KARTU HUTANG
		$mySql2	= " INSERT INTO `kartu_hutang` SET
						`kode_transaksi` 	='".mres($kode_fb)."', 
						`kredit` 			='".mres(str_replace(',', null, $grand_total))."',
					    `kode_supplier` 	='".mres($kode_supplier)."',
						`kode_cabang` 	='".mres($kode_cabang)."',
						`tgl_buat` 		='".mres($tgl_buat)."',
						`tgl_jth_tempo`   ='".mres($tgl_jth_tempo)."',
						`user_pencipta` 	='".$user_pencipta."',
						`tgl_input`		='".mres($tgl_input)."'
					";			
		$query2 = mysqli_query ($con,$mySql2) ;

		//HEADER FB
		$mySql	= "INSERT INTO `fb_hdr` SET 
						`kode_fb`			='".mres($kode_fb)."',
						`ref`				='".mres($ref)."',
						`kode_cabang`		='".mres($kode_cabang)."',
						`kode_supplier`	='".mres($kode_supplier)."',
						`keterangan_hdr`	='".mres($keterangan_hdr)."',
						`tgl_buat`		='".mres($tgl_buat)."',
						`tgl_jth_tempo`	='".mres($tgl_jth_tempo)."',
						`subtotal_all` 	='".mres(str_replace(',', null, $subtotal_all))."',
						`ppn_all` 		='".mres(str_replace(',', null, $ppn_all))."',
						`grand_total` 	='".mres(str_replace(',', null, $grand_total))."',
						`user_pencipta`	='".mres($user_pencipta)."',
						`tgl_input`		='".mres($tgl_input)."' 
					";	
		$query = mysqli_query ($con,$mySql) ;

		if ($query AND $query1 AND $query2 AND $query3 AND $query4 AND $query5 AND $query6) {

			mysqli_commit($con);
			
			mysqli_close($con);
			
			echo "00||".$kode_fb;
			unset($_SESSION['data_fb']);
			
		} else { 
		   
			echo "Gagal query: ".mysql_error();
		}		 	
				
					 
	}

if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "pembatalan" )
	{
		mysqli_autocommit($con,FALSE);

		$kode_fb		= $_POST['kode_fb_batal'];
		$alasan_batal	= $_POST['alasan_batal'];
		$tgl_batal 		= date("Y-m-d");
		
		$cekBkk = "SELECT `deskripsi` FROM `bkk_dtl` WHERE `status_dtl` = '0' AND `deskripsi` = '".$kode_fb."'";
		$queryBkk = mysqli_query($con, $cekBkk);

		if (mysqli_num_rows($queryBkk) > 0) {
			mysqli_commit($con);
			mysqli_close($con);
			echo "99||Kode FB " . $kode_fb . " sudah Bukti Kas Keluar!";
			return false;
		}
		
		$cekGk = "SELECT `deskripsi` FROM `gk_dtl` WHERE `status_dtl` = '1' AND `deskripsi` = '".$kode_fb."'";
		$queryGk = mysqli_query($con, $cekGk);

		if (mysqli_num_rows($queryGk) > 0) {
			mysqli_commit($con);
			mysqli_close($con);
			echo "99||Kode FB " . $kode_fb . " sudah Giro Keluar!";
			return false;
		}
		
		//UPDATE FB_HDR 
		$mySql1 = "UPDATE fb_hdr SET status ='2', alasan_batal = '" . $alasan_batal . "', user_batal = '" . $_SESSION['app_id'] . "', tgl_batal = '" . $tgl_batal . "' WHERE kode_fb='".$kode_fb."' ";
		$query1 = mysqli_query ($con,$mySql1) ;

		//UPDATE FB_DTL
		$mySql2 = "UPDATE fb_dtl SET status_dtl ='2' WHERE kode_fb='".$kode_fb."' ";
		$query2 = mysqli_query ($con,$mySql2) ;

		$kode_deskripsi = mysql_query("SELECT kode_op, kode_btb FROM fb_dtl WHERE kode_fb = '".$kode_fb."' ");
		$num_row_desc = mysql_num_rows($kode_deskripsi);

		if($num_row_desc > 0){
			while($row_desc = mysql_fetch_array($kode_deskripsi)){

				$kode_op = $row_desc['kode_op'];
				$kode_btb = $row_desc['kode_btb'];

				if($kode_btb != '-'){
					$mySql3 = "UPDATE btb_hdr SET status ='1' WHERE kode_btb = '".$kode_btb."' ";
					$query3 = mysqli_query ($con,$mySql3) ;

					$mySql4 = "UPDATE btb_dtl SET status_dtl ='1' WHERE kode_btb = '".$kode_btb."' ";
					$query4 = mysqli_query ($con,$mySql4) ;
				}else{
					$mySql3 = "UPDATE op_hdr SET status ='1' WHERE kode_op = '".$kode_op."' ";
					$query3 = mysqli_query ($con,$mySql3) ;

					$mySql4 = "UPDATE op_dtl SET status_dtl ='1' WHERE kode_op = '".$kode_op."' ";
					$query4 = mysqli_query ($con,$mySql4) ;
				}
			}
		}

		//INSERT KARTU_PIUTANG
		$hutang = mysql_query("SELECT * FROM kartu_hutang WHERE kode_transaksi = '".$kode_fb."'");
		$num_row_h  = mysql_num_rows($hutang);

		if($num_row_h > 0){
			while($row_h = mysql_fetch_array($hutang)){
			
				$kode_transaksi 	= $row_h['kode_transaksi'];
				$debet 				= $row_h['debet'];
				$kredit 			= $row_h['kredit'];
				$kode_cabang 		= $row_h['kode_cabang'];
				$kode_supplier 		= $row_h['kode_supplier'];
				$tgl_jth_tempo 		= $row_h['tgl_jth_tempo'];
				$tgl_input 			= date("Y-m-d H:i:s");

				$mySql5 = "INSERT INTO kartu_hutang SET
								kode_transaksi 	='".$kode_transaksi."',
								debet 			='".$kredit."', 
								kredit 			='".$debet."',
								kode_cabang 	='".$kode_cabang."',
								kode_supplier 	='".$kode_supplier."',
								tgl_buat  		='".$tgl_batal."',
								tgl_jth_tempo  	='".$tgl_jth_tempo."',
								tgl_input 		='".$tgl_input."'
							"; 
				$query5 = mysqli_query ($con,$mySql5) ;	

				$mySql6 = "UPDATE kartu_hutang SET status_batal ='1' WHERE kode_transaksi = '".$kode_transaksi."' ";
				$query6 = mysqli_query ($con,$mySql6) ;	
			}
		}

		//INSERT JURNAL
		$jurnal = mysql_query("SELECT * FROM jurnal WHERE kode_transaksi = '".$kode_fb."' ");
		$num_row_j  = mysql_num_rows($jurnal);

		if($num_row_j > 0){
			while($row_j = mysql_fetch_array($jurnal)){
			
				$kode_transaksi 	= $row_j['kode_transaksi'];
				$ref 				= $row_j['ref'];
				$tgl_buat 			= $row_j['tgl_buat'];
				$kode_cabang 		= $row_j['kode_cabang'];
				$kode_supplier 		= $row_j['kode_supplier'];
				$kode_pelanggan 	= $row_j['kode_pelanggan'];
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

				$mySql8 = "UPDATE jurnal SET status_jurnal ='1' WHERE kode_transaksi = '".$kode_transaksi."' ";			
				$query8 = mysqli_query ($con,$mySql8) ;	
			}
		}

		if ($query1 AND $query2 AND $query3 AND $query4 AND $query5  AND $query6 AND $query7 AND $query8) {
			
			mysqli_commit($con);
			mysqli_close($con);
			
			echo "00||".$kode_fb;
		} else { 
			echo "99||Gagal query: ".mysql_error();
		}	
	}


?>