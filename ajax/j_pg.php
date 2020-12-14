<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	require('../pages/data/script/pg.php');
	date_default_timezone_set("Asia/Jakarta");

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loaditemuser" ) {
		$kode_user		= mres($_POST['kode_user']);
		$kode_cabang	= mres($_POST['kode_cabang']);
		$kode_giro	= mres($_POST['kode_giro']);
		$kode_giro = explode(':', $kode_giro);
		$metode_dtl	= $kode_giro[1];
		$kode_giro = $kode_giro[0];
        $id_form 		= mres($_POST['id_form']);
        $rad 		= mres($_POST['rad']);
		
		if ($rad === '1' || $rad === 1) {
			$query          =  mysql_query("(SELECT `gm_hdr`.`kode_gm` AS `kode_giro`, '0' AS `kode_gt`, `payment_giro`.`bank_giro` AS `bank_giro`, `payment_giro`.`no_giro` AS `no_giro`, `payment_giro`.`tgl_giro` AS `tgl_giro`, `payment_giro`.`nominal` AS `nominal`, '1' AS `metode_dtl`, 'giro' AS `form_giro` FROM `gm_hdr` LEFT JOIN `payment_giro` ON `gm_hdr`.`kode_gm` = `payment_giro`.`kode_giro` WHERE `gm_hdr`.`kode_cabang` = '".$kode_cabang."' AND `gm_hdr`.`kode_pelanggan` = '".$kode_user."' AND `payment_giro`.`status` = '0' AND `gm_hdr`.`kode_gm` = '".$kode_giro."') UNION (SELECT `gth`.`kode_gt` AS `kode_giro`, '0' AS `kode_gt`, `gtd`.`bank_giro` AS `bank_giro`, `gtd`.`no_giro` AS `no_giro`, `gtd`.`tgl_jth_giro` AS `tgl_giro`, `gtd`.`nominal` AS `nominal`, `gtd`.`metode_dtl` AS `metode_dtl`, 'tolak_giro' AS `form_giro` FROM `gt_hdr` AS `gth` LEFT JOIN `gt_dtl` AS `gtd` ON `gtd`.`kode_gt` = `gth`.`kode_gt` WHERE `gth`.`kode_cabang` = '".$kode_cabang."' AND `gth`.`kode_user` = '".$kode_user."' AND `gtd`.`status_dtl` = '1' AND `gth`.`kode_gt` = '".$kode_giro."' AND `gtd`.`metode_dtl` = '".$metode_dtl."') UNION (SELECT `gph`.`kode_gp` AS `kode_giro`, `gph`.`kode_gt` AS `kode_gt`, `gpd`.`bank_giro` AS `bank_giro`, `gpd`.`no_giro` AS `no_giro`, `gpd`.`tgl_jth_giro` AS `tgl_giro`, `gpd`.`nominal` AS `nominal`, '1' AS `metode_dtl`, 'tolak_giro' AS `form_giro` FROM `gp_hdr` AS `gph` LEFT JOIN `gp_dtl` AS `gpd` ON `gpd`.`kode_gp` = `gph`.`kode_gp` WHERE `gph`.`kode_cabang` = '".$kode_cabang."' AND `gph`.`kode_user` = '".$kode_user."' AND `gpd`.`status_dtl` = '1' AND `gph`.`kode_gp` = '".$kode_giro."')");
		} elseif ($rad === '2' || $rad === 2) {
			$query          =  mysql_query("(SELECT `gk_hdr`.`kode_gk` AS `kode_giro`, '0' AS `kode_gt`, `payment_giro`.`bank_giro` AS `bank_giro`, `payment_giro`.`no_giro` AS `no_giro`, `payment_giro`.`tgl_giro` AS `tgl_giro`, `payment_giro`.`nominal` AS `nominal`, '1' AS `metode_dtl`, 'giro' AS `form_giro` FROM `gk_hdr` LEFT JOIN `payment_giro` ON `gk_hdr`.`kode_gk` = `payment_giro`.`kode_giro` WHERE `gk_hdr`.`kode_cabang` = '".$kode_cabang."' AND `gk_hdr`.`kode_supplier` = '".$kode_user."' AND `payment_giro`.`status` = '0' AND `gk_hdr`.`kode_gk` = '".$kode_giro."') UNION (SELECT `gth`.`kode_gt` AS `kode_giro`, '0' AS `kode_gt`, `gtd`.`bank_giro` AS `bank_giro`, `gtd`.`no_giro` AS `no_giro`, `gtd`.`tgl_jth_giro` AS `tgl_giro`, `gtd`.`nominal` AS `nominal`, `gtd`.`metode_dtl` AS `metode_dtl`, 'tolak_giro' AS `form_giro` FROM `gt_hdr` AS `gth` LEFT JOIN `gt_dtl` AS `gtd` ON `gtd`.`kode_gt` = `gth`.`kode_gt` WHERE `gth`.`kode_cabang` = '".$kode_cabang."' AND `gth`.`kode_user` = '".$kode_user."' AND `gtd`.`status_dtl` = '1' AND `gth`.`kode_gt` = '".$kode_giro."' AND `gtd`.`metode_dtl` = '".$metode_dtl."') UNION (SELECT `gph`.`kode_gp` AS `kode_giro`, `gph`.`kode_gt` AS `kode_gt`, `gpd`.`bank_giro` AS `bank_giro`, `gpd`.`no_giro` AS `no_giro`, `gpd`.`tgl_jth_giro` AS `tgl_giro`, `gpd`.`nominal` AS `nominal`, '1' AS `metode_dtl`, 'tolak_giro' AS `form_giro` FROM `gp_hdr` AS `gph` LEFT JOIN `gp_dtl` AS `gpd` ON `gpd`.`kode_gp` = `gph`.`kode_gp` WHERE `gph`.`kode_cabang` = '".$kode_cabang."' AND `gph`.`kode_user` = '".$kode_user."' AND `gpd`.`status_dtl` = '1' AND `gph`.`kode_gp` = '".$kode_giro."')");
		}
		
		$num_rows 	= mysql_num_rows($query);
		$table = '';
		if($num_rows>0) {
			$n 	= 0;
			while($item = mysql_fetch_array($query)){
				$n++;
				if ($item['form_giro'] !== 'tolak_giro') {
					$tolak_giro = '<input type="checkbox" name="tolak_giro_'.$n.'" id="tolak_giro_'.$n.'" data-id="'.$n.'" value="1" style="width:40px;height:30px" disabled>';
				} else {
					$tolak_giro = '-';
				}
				$table .= '<tr>
								<td width="130px" style="text-align:center;width:130px;">
									<input type="hidden" name="input_giro[]" id="input_cb_'.$n.'" data-id="'.$n.'" value="0" >
									<input type="hidden" name="kode_gt[]" id="kode_gt_'.$n.'" data-id="'.$n.'" value="'.$item['kode_gt'].'" >
									<input type="hidden" name="form_giro[]" id="form_giro_'.$n.'" data-id="'.$n.'" value="'.$item['form_giro'].'" >
									<input type="checkbox" name="input_giro_'.$n.'" id="input_giro_'.$n.'" data-id="'.$n.'" value="1" style="width:40px;height:30px" >
								</td>
								<td width="235px">'.$item['bank_giro'].'
									<input type="hidden" name="bank_giro[]" id="bank_giro_'.$n.'" data-id="'.$n.'" value="'.$item['bank_giro'].'" >
								</td>
								<td width="235px">'.($item['no_giro']).'
									<input type="hidden" name="no_giro[]" id="no_giro_'.$n.'" data-id="'.$n.'" value="'.$item['no_giro'].'" >
								</td>
								<td width="130px">'.(strftime("%A, %d %B %Y", strtotime($item['tgl_giro']))).'
									<input type="hidden" name="tgl_giro[]" id="tgl_giro_'.$n.'" data-id="'.$n.'" value="'.$item['tgl_giro'].'" >
								</td>
								<td width="130px" style="text-align:center;width:130px;">
									<input type="hidden" name="tolak_giro[]" id="tolak_giro_cb_'.$n.'" data-id="'.$n.'" value="0" >
									' . $tolak_giro . '
								</td>
								<td style="text-align:right; width:130px;">
									<span id="text-nominal_' . $n . '" data-id="' . $n . '">
										'.(number_format($item['nominal'], 2)).'
									</span>
									<input type="hidden" name="nominal_asli[]" id="nominal_asli_'.$n.'" data-id="'.$n.'" value="'.$item['nominal'].'" >
									<input type="hidden" name="nominal[]" id="nominal_'.$n.'" data-id="'.$n.'" value="'.$item['nominal'].'" >
								</td>
								<td style="text-align:right; width:130px;">
									<span id="text-nominal_tolakan_' . $n . '" data-id="' . $n . '">0</span>
									<input type="hidden" name="nominal_tolakan[]" id="nominal_tolakan_'.$n.'" data-id="'.$n.'" value="'.$item['nominal'].'" >
								</td>
								<td>
									<textarea type="text" class="form-control" name="keterangan_dtl[]" id="keterangan_dtl_'.$n.'" data-id="'.$n.'"></textarea>
								</td>
						  </tr>
					 ';
			}
		}else{
			$table = '<tr><td colspan="8" class="text-center">Belum ada item</td></tr>';
		}
		header('Content-type: application/json');
		echo json_encode([
			'table' => $table,
			'metode' => $metode,
		]);
	}
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loaditemgiro" ) {
		$kode_user		= mres($_POST['kode_user']);
		$kode_cabang	= mres($_POST['kode_cabang']);
        $id_form 		= mres($_POST['id_form']);
        $rad 		= mres($_POST['rad']);
		
		if ($rad === '1' || $rad === 1) {
			$query          =  mysql_query("(SELECT DISTINCT(`gm_hdr`.`kode_gm`) AS `kode_giro`, `gm_hdr`.`kode_gm` AS `label_giro`, '1' AS `metode_dtl` FROM `gm_hdr` LEFT JOIN `payment_giro` ON `gm_hdr`.`kode_gm` = `payment_giro`.`kode_giro` WHERE `gm_hdr`.`kode_cabang` = '".$kode_cabang."' AND `gm_hdr`.`kode_pelanggan` = '".$kode_user."' AND `payment_giro`.`status` = '0') UNION (SELECT DISTINCT(`gtd`.`kode_gt`) AS `kode_giro`, CONCAT(`gth`.`kode_gt`, ' (Tolakan Giro/', CASE WHEN `gtd`.`metode_dtl` = '0' THEN 'Kas' WHEN `gtd`.`metode_dtl` = '1' THEN 'Bank' ELSE '-' END, ') ') AS `label_giro`, `gtd`.`metode_dtl` AS `metode_dtl` FROM `gt_hdr` AS `gth` LEFT JOIN `gt_dtl` AS `gtd` ON `gtd`.`kode_gt` = `gth`.`kode_gt` WHERE `gth`.`kode_cabang` = '".$kode_cabang."' AND `gth`.`kode_user` = '".$kode_user."' AND `gtd`.`status_dtl` = '1' AND `gtd`.`metode_dtl` <> '2') UNION (SELECT DISTINCT(`gph`.`kode_gp`) AS `kode_giro`, CONCAT(`gph`.`kode_gp`, ' (Pengganti Giro/Bank)') AS `label_giro`, '1' AS `metode_dtl` FROM `gp_hdr` AS `gph` LEFT JOIN `gp_dtl` AS `gpd` ON `gpd`.`kode_gp` = `gph`.`kode_gp` WHERE `gph`.`kode_cabang` = '".$kode_cabang."' AND `gph`.`kode_user` = '".$kode_user."' AND `gpd`.`status_dtl` = '1')");
		} elseif ($rad === '2' || $rad === 2) {
			$query          =  mysql_query("(SELECT DISTINCT(`gk_hdr`.`kode_gk`) AS `kode_giro`, `gk_hdr`.`kode_gk` AS `label_giro`, '1' AS `metode_dtl` FROM `gk_hdr` LEFT JOIN `payment_giro` ON `gk_hdr`.`kode_gk` = `payment_giro`.`kode_giro` WHERE `gk_hdr`.`kode_cabang` = '".$kode_cabang."' AND `gk_hdr`.`kode_supplier` = '".$kode_user."' AND `payment_giro`.`status` = '0') UNION (SELECT DISTINCT(`gtd`.`kode_gt`) AS `kode_giro`, CONCAT(`gth`.`kode_gt`, ' (Tolakan Giro/', CASE WHEN `gtd`.`metode_dtl` = '0' THEN 'Kas' WHEN `gtd`.`metode_dtl` = '1' THEN 'Bank' ELSE '-' END, ') ') AS `label_giro`, `gtd`.`metode_dtl` AS `metode_dtl` FROM `gt_hdr` AS `gth` LEFT JOIN `gt_dtl` AS `gtd` ON `gtd`.`kode_gt` = `gth`.`kode_gt` WHERE `gth`.`kode_cabang` = '".$kode_cabang."' AND `gth`.`kode_user` = '".$kode_user."' AND `gtd`.`status_dtl` = '1' AND `gtd`.`metode_dtl` <> '2') UNION (SELECT DISTINCT(`gph`.`kode_gp`) AS `kode_giro`, CONCAT(`gph`.`kode_gp`, ' (Pengganti Giro/Bank)') AS `label_giro`, '1' AS `metode_dtl` FROM `gp_hdr` AS `gph` LEFT JOIN `gp_dtl` AS `gpd` ON `gpd`.`kode_gp` = `gph`.`kode_gp` WHERE `gph`.`kode_cabang` = '".$kode_cabang."' AND `gph`.`kode_user` = '".$kode_user."' AND `gpd`.`status_dtl` = '1')");
		}
		
		$num_rows 	= mysql_num_rows($query);
		if ($num_rows>0) {
			echo '<select name="kode_giro" id="kode_giro" class="select2">';
			echo '<option value="0:0">-- Pilih Kode Giro --</option>';
			while($item = mysql_fetch_array($query)){
				echo '<option value="' . $item['kode_giro'] . ':' . $item['metode_dtl'] . '">' . $item['label_giro'] . '</option>';
			}
			echo '</select>';
		} else {
			echo '<select name="kode_giro" id="kode_giro" class="select2" disabled>';
				echo '<option value="0:0">-- Tidak ada Kode Giro --</option>';
			echo '</select>';
		}
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save" )
	{
		mysqli_autocommit($con,FALSE);

		// VARIABEL HDR
				
		$kode_giro 			= mres($_POST['kode_giro']);
		$kode_giro = explode(':', $kode_giro);
		$kode_giro = $kode_giro[0];
		
		if (strpos(strtolower($kode_giro), 'gk') !== false || strpos(strtolower($kode_giro), 'pk') !== false) {
			$form = 'PGK';
		} else {
			$form = 'PGM';
		}
		
		$ref 			= mres($_POST['ref']);
		$tgl_buat 		= date("Y-m-d",strtotime(mres($_POST['tgl_buat'])));
		$bank_coa 		= mres($_POST['bank_coa']);
		$kode_cabang 	= mres($_POST['kode_cabang']);
		$user			= mres($_POST['user']);
		$kode_user		= mres($_POST['kode_user']);
		$nama_user		= mres($_POST['nama_user']);
		$keterangan_hdr = mres($_POST['keterangan_hdr']);

		$user_pencipta  = $_SESSION['app_id'];
		$tgl_input 		= date("Y-m-d H:i:s");

		$thnblntgl 		= date("ymd",strtotime(mres($_POST['tgl_buat'])));
		$kode_pg 		= buat_kode_pg($thnblntgl,$form,$kode_cabang);
		$id_form 		= $_POST['id_form'];

		// VARIABEL DTL
		$no_pg 			 = $kode_pg;
		$input_giro		 = $_POST['input_giro'];
		$kode_gt 		 = $_POST['kode_gt'];
		$bank_giro 		 = $_POST['bank_giro'];
		$no_giro		 = $_POST['no_giro'];
		$tgl_jth_giro 	 = $_POST['tgl_giro'];
		$tolak_giro		 = $_POST['tolak_giro'];
		$nominal		 = $_POST['nominal'];
		$nominal_tolakan = $_POST['nominal_tolakan'];
		$keterangan_dtl	 = $_POST['keterangan_dtl'];

		//$cb 			= $_POST['cb'];
		$count 			= count($input_giro);
		
		// echo json_encode($_POST);
		// die();
		$mySql1   = "INSERT INTO `pg_dtl` (`kode_pg`, `bank_giro`, `no_giro`, `tgl_jth_giro`, `nominal`, `keterangan_dtl`, `tgl_input`, `status_dtl`) VALUES ";

		for( $i=0; $i < $count; $i++ ){
			if ($input_giro[$i] === '1' || $input_giro[$i] === 1) {
				$mySql1 .= "(
					'" . $no_pg . "',
					'" . $bank_giro[$i] . "',
					'" . $no_giro[$i] . "',
					'" . $tgl_jth_giro[$i] . "',
					'" . (($tolak_giro[$i] === '1' || $tolak_giro[$i] === 1) ? $nominal_tolakan[$i]:$nominal[$i]) . "',
					'" . $keterangan_dtl[$i] . "',
					'" . $tgl_input . "',
					'" . (($tolak_giro[$i] === '1' || $tolak_giro[$i] === 1) ? '2' : '3') . "'
				),";
				
				//-----------CREATE JURNAL-----------------//
				if(strtolower($user) === 'pelanggan'){
					if ($tolak_giro[$i] === '0' || $tolak_giro[$i] === 0) {

						//INSERT JURNAL DEBET
						$mySql2 = "INSERT INTO `jurnal` SET
								`kode_transaksi` 	='".$no_pg."',
								`tgl_input` 		='".$tgl_input."',
								`tgl_buat` 		='".$tgl_buat."',
								`kode_pelanggan` 	='".$kode_user."',
								`kode_cabang` 	='".$kode_cabang."',
								`keterangan_hdr` 	='".$keterangan_hdr."',
								`ref` 			='".$ref."',
								`kode_coa` 		='".$bank_coa."',
								`debet`  			='".$nominal[$i]."',
								`user_pencipta` 	='".$_SESSION['app_id']."'";

						$query2 = mysqli_query ($con,$mySql2) ;

						//INSERT JURNAL KREDIT
						$mySql3 = "INSERT INTO `jurnal` SET
								`kode_transaksi` 	='".$no_pg."',
								`tgl_input` 		='".$tgl_input."',
								`tgl_buat` 		='".$tgl_buat."',
								`kode_pelanggan` 	='".$kode_user."',
								`kode_cabang` 	='".$kode_cabang."',
								`keterangan_hdr`  ='".$keterangan_hdr."',
								`keterangan_dtl`  ='".$keterangan_dtl[$i]."',
								`ref` 		 	='".$_POST['ref']."',
								`kode_coa` 		='1.01.03.02',
								`kredit` 			='".$nominal[$i]."',
								`user_pencipta` 	='".$_SESSION['app_id']."'";

						$query3 = mysqli_query ($con,$mySql3) ;
						if (strtolower(substr($kode_giro, 10, 3)) === 'tgm') {
							
							$mySql4 = "UPDATE `gt_hdr` SET `status` = '2' WHERE `kode_gt`= '".$kode_giro."' ";
							$query4 = mysqli_query ($con,$mySql4) ;
							
							$mySql5 = "UPDATE `gt_dtl` SET `status_dtl` = '2' WHERE `kode_gt` = '".$kode_giro."' AND `bank_giro` = '".$bank_giro[$i]."' AND `no_giro` = '".$no_giro[$i]."' AND `nominal` = '".$nominal[$i]."'";
							$query5 = mysqli_query ($con,$mySql5) ;
							
							$mySql6 = "INSERT INTO `kartu_giro_tolakan` SET
								`kode_transaksi` 	='".$kode_giro."',
								`kode_pelunasan` 	='".$no_pg."',
								`inisial` ='".substr($kode_giro, 10, 3)."',
								`kredit`  			='".$nominal[$i]."',
								`lunas` = '1',
								`kode_cabang` 	='".$kode_cabang."',
								`kode_pelanggan` 	='".$kode_user."',
								`tgl_buat` 		='".$tgl_buat."',
								`tgl_jth_tempo` 		='".mres($tgl_jth_giro[$i])."',
								`tgl_input` 		='".$tgl_input."',
								`bank_giro` = '".mres($bank_giro[$i])."',
								`no_giro` = '".mres($no_giro[$i])."',
								`user_pencipta` 	='".$_SESSION['app_id']."'";

							$query6 = mysqli_query ($con,$mySql6) ;

							$mySql7 = "UPDATE `kartu_giro_tolakan` SET `lunas` = '1' WHERE `kode_transaksi` = '".$kode_giro."' AND `debet` = '".$nominal[$i]."' AND `kode_pelanggan` = '".$kode_user."' AND `bank_giro` = '".$bank_giro[$i]."' AND `no_giro` = '".$no_giro[$i]."'";
							
							$query7 = mysqli_query($con, $mySql7);
						} elseif (strtolower(substr($kode_giro, 10, 3)) === 'gpm') {
							
							$mySql4 = "UPDATE `gp_hdr` SET `status` = '2' WHERE `kode_gp`= '".$kode_giro."' ";
							$query4 = mysqli_query ($con,$mySql4) ;
							
							$mySql5 = "UPDATE `gp_dtl` SET `status_dtl` = '2' WHERE `kode_gp` = '".$kode_giro."' AND `bank_giro` = '".$bank_giro[$i]."' AND `no_giro` = '".$no_giro[$i]."' AND `nominal` = '".$nominal[$i]."'";
							$query5 = mysqli_query ($con,$mySql5) ;
							
							$mySql6 = "INSERT INTO `kartu_giro_tolakan` SET
								`kode_transaksi` 	='".$kode_giro."',
								`kode_pelunasan` 	='".$no_pg."',
								`inisial` ='".substr($kode_giro, 10, 3)."',
								`kredit`  			='".$nominal[$i]."',
								`lunas` = '1',
								`kode_cabang` 	='".$kode_cabang."',
								`kode_pelanggan` 	='".$kode_user."',
								`tgl_buat` 		='".$tgl_buat."',
								`tgl_jth_tempo` 		='".mres($tgl_jth_giro[$i])."',
								`tgl_input` 		='".$tgl_input."',
								`bank_giro` = '".mres($bank_giro[$i])."',
								`no_giro` = '".mres($no_giro[$i])."',
								`user_pencipta` 	='".$_SESSION['app_id']."'";

							$query6 = mysqli_query ($con,$mySql6) ;

							$mySql7 = "UPDATE `kartu_giro_tolakan` SET `lunas` = '1' WHERE `kode_transaksi` = '".$kode_giro."' AND `debet` = '".$nominal[$i]."' AND `kode_pelanggan` = '".$kode_user."' AND `bank_giro` = '".$bank_giro[$i]."' AND `no_giro` = '".$no_giro[$i]."'";
							
							$query7 = mysqli_query($con, $mySql7);
						} else {
							$mySql4 = "UPDATE `gm_hdr` SET `status` = '3' WHERE `kode_gm`= '".$kode_giro."'";
							$query4 = mysqli_query ($con,$mySql4) ;
							
							$mySql5 = "UPDATE `gm_dtl` SET `status_dtl` = '3' WHERE `kode_gm` = '".$kode_giro."'";
							$query5 = mysqli_query ($con,$mySql5) ;
							
							$mySql6 = "INSERT INTO `kartu_giro` SET
										`kode_transaksi` 	='".$kode_gt[$i]."',
										`kode_pelunasan`  ='".$no_pg."',
										`inisial` 		='".substr($kode_giro, 10, 2)."',
										`kredit` 			='".$nominal[$i]."',
										`kode_pelanggan` 	='".$kode_user."',
										`kode_cabang` 	='".$kode_cabang."',
										`bank_giro` = '".$bank_giro[$i]."',
										`no_giro` = '".$no_giro[$i]."',
										`lunas` = '1',
										`tgl_buat` 		='".$tgl_buat."',
										`tgl_jth_tempo` 	='".$tgl_jth_giro[$i]."',
										`user_pencipta` 	='".$_SESSION['app_id']."',
										`tgl_input`		='".date('Y-m-d H:i:s')."' ";

							$query6 = mysqli_query ($con,$mySql6) ;

							$mySql7 = "UPDATE `kartu_giro` SET `lunas` = '1' WHERE `kode_transaksi` = '".$kode_giro."' AND `debet` = '".$nominal[$i]."' AND `kode_pelanggan` = '".$kode_user."' AND `bank_giro` = '".$bank_giro[$i]."' AND `no_giro` = '".$no_giro[$i]."'";
							
							$query7 = mysqli_query($con, $mySql7);
						}
					} else {
						$query2 = true;
						$query3 = true;
						$query4 = true;
						$query5 = true;
						$query6 = true;
						$query7 = true;
					}					
				} elseif (strtolower($user) === 'supplier') {
					if ($tolak_giro[$i] === '0' || $tolak_giro[$i] === 0) {
						//INSERT JURNAL DEBET
						$mySql2 = "INSERT INTO `jurnal` SET
									`kode_transaksi` 	='".$no_pg."',
									`tgl_input` 		='".$tgl_input."',
									`tgl_buat` 		='".$tgl_buat."',
									`kode_supplier` 	='".$kode_user."',
									`kode_cabang` 	='".$kode_cabang."',
									`keterangan_hdr` 	='".$keterangan_hdr."',
									`ref` 			='".$ref."',
									`kode_coa` 		='2.01.02.02',
									`debet`  			='".$nominal[$i]."',
									`user_pencipta` 	='".$_SESSION['app_id']."'";

						$query2 = mysqli_query ($con,$mySql2) ;

						//INSERT JURNAL KREDIT
						$mySql3 = "INSERT INTO `jurnal` SET
									`kode_transaksi` 	='".$no_pg."',
									`tgl_input` 		='".$tgl_input."',
									`tgl_buat` 		='".$tgl_buat."',
									`kode_supplier` 	='".$kode_user."',
									`kode_cabang` 	='".$kode_cabang."',
									`keterangan_hdr`  ='".$keterangan_hdr."',
									`keterangan_dtl`  ='".$keterangan_dtl[$i]."',
									`ref` 		 	='".$_POST['ref']."',
									`kode_coa` 		='".$bank_coa."',
									`kredit`  			='".$nominal[$i]."',
									`user_pencipta` 	='".$_SESSION['app_id']."'";

						$query3 = mysqli_query ($con,$mySql3) ;
						
						if (strtolower(substr($kode_giro, 10, 3)) === 'tgk') {
							
							$mySql4 = "UPDATE `gt_hdr` SET `status` = '2' WHERE `kode_gt` = '".$kode_giro."' ";
							$query4 = mysqli_query ($con,$mySql4) ;
							
							$mySql5 = "UPDATE `gt_dtl` SET `status_dtl` = '2' WHERE `kode_gt` = '".$kode_giro."' AND `bank_giro` = '".$bank_giro[$i]."' AND `no_giro` = '".$no_giro[$i]."' AND `nominal` = '".$nominal[$i]."'";
							$query5 = mysqli_query ($con,$mySql5) ;
							
							//CREATE KARTU GIRO
							$mySql6 = "INSERT INTO `kartu_giro_tolakan` SET
								`kode_transaksi` 	='".$kode_giro."',
								`kode_pelunasan` 	='".$no_pg."',
								`inisial` ='".substr($kode_giro, 10, 3)."',
								`debet`  			='".$nominal[$i]."',
								`lunas` = '1',
								`kode_cabang` 	='".$kode_cabang."',
								`kode_supplier` 	='".$kode_user."',
								`tgl_buat` 		='".$tgl_buat."',
								`tgl_jth_tempo` 		='".mres($tgl_jth_giro[$i])."',
								`tgl_input` 		='".$tgl_input."',
								`bank_giro` = '".mres($bank_giro[$i])."',
								`no_giro` = '".mres($no_giro[$i])."',
								`user_pencipta` 	='".$_SESSION['app_id']."'";

							$query6 = mysqli_query ($con,$mySql6) ;
							
							$mySql7 = "UPDATE `kartu_giro_tolakan` SET `lunas` = '1' WHERE `kode_transaksi` = '".$kode_giro."' AND`kredit` = '".$nominal[$i]."' AND `kode_supplier` = '".$kode_user."' AND `bank_giro` = '".$bank_giro[$i]."' AND `no_giro` = '".$no_giro[$i]."'";
							
							$query7 = mysqli_query($con, $mySql7);
							
						} elseif (strtolower(substr($kode_giro, 10, 3)) === 'gpk') {
							
							$mySql4 = "UPDATE `gp_hdr` SET `status` = '2' WHERE `kode_gp` = '".$kode_giro."' ";
							$query4 = mysqli_query ($con,$mySql4) ;
							
							$mySql5 = "UPDATE `gp_dtl` SET `status_dtl` = '2' WHERE `kode_gp` = '".$kode_giro."' AND `bank_giro` = '".$bank_giro[$i]."' AND `no_giro` = '".$no_giro[$i]."' AND `nominal` = '".$nominal[$i]."'";
							$query5 = mysqli_query ($con,$mySql5) ;
							
							//CREATE KARTU GIRO
							$mySql6 = "INSERT INTO `kartu_giro_tolakan` SET
								`kode_transaksi` 	='".$kode_giro."',
								`kode_pelunasan` 	='".$no_pg."',
								`inisial` ='".substr($kode_giro, 10, 3)."',
								`debet`  			='".$nominal[$i]."',
								`lunas` = '1',
								`kode_cabang` 	='".$kode_cabang."',
								`kode_supplier` 	='".$kode_user."',
								`tgl_buat` 		='".$tgl_buat."',
								`tgl_jth_tempo` 		='".mres($tgl_jth_giro[$i])."',
								`tgl_input` 		='".$tgl_input."',
								`bank_giro` = '".mres($bank_giro[$i])."',
								`no_giro` = '".mres($no_giro[$i])."',
								`user_pencipta` 	='".$_SESSION['app_id']."'";

							$query6 = mysqli_query ($con,$mySql6) ;
							
							$mySql7 = "UPDATE `kartu_giro_tolakan` SET `lunas` = '1' WHERE `kode_transaksi` = '".$kode_giro."' AND`kredit` = '".$nominal[$i]."' AND `kode_supplier` = '".$kode_user."' AND `bank_giro` = '".$bank_giro[$i]."' AND `no_giro` = '".$no_giro[$i]."'";
							
							$query7 = mysqli_query($con, $mySql7);
							
						} else {
						
							$mySql4 = "UPDATE `gk_hdr` SET `status` = '3' WHERE `kode_gk` = '".$kode_giro."' ";
							$query4 = mysqli_query ($con,$mySql4) ;
							
							$mySql5 = "UPDATE `gk_dtl` SET `status_dtl` = '3' WHERE `kode_gk` = '".$kode_giro."'";
							$query5 = mysqli_query ($con,$mySql5) ;

							//CREATE KARTU GIRO
							$mySql6 = "INSERT INTO `kartu_giro` SET
										`kode_transaksi` 	='".$kode_giro."',
										`kode_pelunasan`  ='".$no_pg."',
										`inisial` 		='".substr($kode_giro, 10, 2)."',
										`debet` 			='".$nominal[$i]."',
										`kode_supplier` 	='".$kode_user."',
										`kode_cabang` 	='".$kode_cabang."',
										`bank_giro` = '".$bank_giro[$i]."',
										`no_giro` = '".$no_giro[$i]."',
										`lunas` = '1',
										`tgl_buat` 		='".$tgl_buat."',
										`tgl_jth_tempo` 	='".$tgl_jth_giro[$i]."',
										`user_pencipta` 	='".$_SESSION['app_id']."',
										`tgl_input`		='".date('Y-m-d H:i:s')."' ";

							$query6 = mysqli_query ($con,$mySql6) ;
												
							$mySql7 = "UPDATE `kartu_giro` SET `lunas` = '1' WHERE `kode_transaksi` = '".$kode_giro."' AND`kredit` = '".$nominal[$i]."' AND `kode_supplier` = '".$kode_user."' AND `bank_giro` = '".$bank_giro[$i]."' AND `no_giro` = '".$no_giro[$i]."'";
							
							$query7 = mysqli_query($con, $mySql7);
						
						}
						
					} else {
						$query2 = true;
						$query3 = true;
						$query4 = true;
						$query5 = true;
						$query6 = true;
						$query7 = true;
					}
				
				}else{
					echo "Pilih Pelanggan / Supplier !!".mysql_error();
				}
				//----------- END CREATE KARTU PIUTANG / HUTANG-----------------//

				$mySql8 = "UPDATE `payment_giro` SET `status` = '" . ( $tolak_giro[$i] === '0' || $tolak_giro[$i] === 0 ? '1' : '2' ) . "' WHERE `bank_giro` = '" . $bank_giro[$i] . "' AND `no_giro` = '" . $no_giro[$i] . "' ";
				$query8 = mysqli_query ($con,$mySql8) ;
			}
		}
		$mySql1 = rtrim($mySql1,",");
		$query1 = mysqli_query ($con,$mySql1) ;

		//HEADER PELUNASAN GIRO
		$mySql	= "INSERT INTO `pg_hdr` SET
						`kode_pg`			='".$kode_pg."',
						`kode_giro`			='".$kode_giro."',
						`ref`				='".$ref."',
						`bank_coa`		='".$bank_coa."',
						`kode_cabang`		='".$kode_cabang."',
						`kode_user`		='".$kode_user."',
						`nama_user`		='".$nama_user."',
						`keterangan_hdr`	='".$keterangan_hdr."',
						`tgl_buat`		='".$tgl_buat."',
						`tgl_input`		='".$tgl_input."',
						`user_pencipta`	='".$user_pencipta."',
						`status` 			='3' ";


		$query = mysqli_query ($con,$mySql) ;
		
		/* echo json_encode([
			$query,
			$query1,
			$query2,
			$query3,
			$query4,
			$query5,
			$query6,
			$query7,
			$query8,
			$mySql1,
		]);
		
		die(); */
				
		if ($query AND $query1 AND $query2 AND $query3 AND $query4 AND $query5 AND $query6 AND $query7 AND $query8) {
			// Commit transaction
			mysqli_commit($con);

			// Close connection
			mysqli_close($con);

			echo "00||".$kode_pg;
			unset($_SESSION['data_pg']);
		} else {
			echo "Gagal query: ".mysql_error();
		}

	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "pembatalan" )
	{
		mysqli_autocommit($con,FALSE);

		$kode_pg		= $_POST['kode_pg_batal'];
		$alasan_batal	= $_POST['alasan_batal'];
		$tgl_batal 		= date("Y-m-d");

		//UPDATE PG_HDR
		$mySql1 = "UPDATE pg_hdr SET status ='2', alasan_batal='".$alasan_batal."', tgl_batal='".$tgl_batal."' WHERE kode_pg='".$kode_pg."' ";
		$query1 = mysqli_query ($con,$mySql1) ;

		//UPDATE PG_DTL
		$mySql2 = "UPDATE pg_dtl SET status_dtl ='2' WHERE kode_pg='".$kode_pg."' ";
		$query2 = mysqli_query ($con,$mySql2) ;

		$giro = mysql_query("SELECT kode_giro FROM pg_dtl WHERE kode_pg = '".$kode_pg."' ");
		$num_row_g  = mysql_num_rows($giro);

		if($num_row_g > 0){
			while($row_g = mysql_fetch_array($giro)){

				$kode_giro 	= $row_g['kode_giro'];
				$kd_giro 	= SUBSTR($kode_giro, -6, 2);

				if($kd_giro == 'GM'){
					$mySql3 = "UPDATE gm_hdr SET status ='1' WHERE kode_gm = '".$kode_giro."' ";
					$query3 = mysqli_query ($con,$mySql3) ;

					$mySql4 = "UPDATE gm_dtl SET status_dtl ='1' WHERE kode_gm = '".$kode_giro."' ";
					$query4 = mysqli_query ($con,$mySql4) ;

					$mySql7 = "UPDATE kartu_giro SET status_batal ='1' WHERE kode_transaksi = '".$kode_giro."' AND kode_pelunasan='".$kode_pg."'";
					$query7 = mysqli_query ($con,$mySql7) ;

				}elseif($kd_giro == 'GK') {
					$mySql3 = "UPDATE gk_hdr SET status ='1' WHERE kode_gk = '".$kode_giro."' ";
					$query3 = mysqli_query ($con,$mySql3) ;

					$mySql4 = "UPDATE gk_dtl SET status_dtl ='1' WHERE kode_gk = '".$kode_giro."' ";
					$query4 = mysqli_query ($con,$mySql4) ;

					$mySql7 = "UPDATE kartu_giro SET status_batal ='1' WHERE kode_transaksi = '".$kode_giro."' AND kode_pelunasan='".$kode_pg."'";
					$query7 = mysqli_query ($con,$mySql7) ;

				}else{
					$query3="";
					$query4="";
				}
			}
		}

		//INSERT JURNAL
		$jurnal = mysql_query("SELECT * FROM jurnal WHERE kode_transaksi = '".$kode_pg."' ");
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

				$mySql5 = "INSERT INTO jurnal SET
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
				$query5 = mysqli_query ($con,$mySql5) ;

				$mySql6 = "UPDATE jurnal SET status_jurnal ='2' WHERE kode_transaksi = '".$kode_transaksi."' ";
				$query6 = mysqli_query ($con,$mySql6) ;
			}
		}

		if ($query1 AND $query2 AND $query3 AND $query4 AND $query5 AND $query6 AND $query7) {

			mysqli_commit($con);
			mysqli_close($con);

			echo "00||".$kode_pg;
		} else {
			echo "Gagal query: ".mysql_error();
		}
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save_back" )
	{
		mysqli_autocommit($con,FALSE);

		$kode_pg 		= $_POST['kode_pg'];
		$ref 			= $_POST['ref'];
		$tgl_buat 		= date("Y-m-d",strtotime($_POST['tgl_buat']));
		$bank_coa 		= $_POST['bank_coa'];
		$kode_cabang 	= $_POST['kode_cabang'];
		$kode_user		= $_POST['kode_user'];
		$nama_user		= $_POST['nama_user'];
		$user			= $_POST['user'];
		$keterangan_hdr = $_POST['keterangan_hdr'];
		$tgl_input 		= date("Y-m-d H:i:s");
		$user_pencipta  = $_SESSION['app_id'];

		$mySql	= "UPDATE pg_hdr SET
						ref				='".$ref."',
						bank_coa		='".$bank_coa."',
						keterangan_hdr	='".$keterangan_hdr."',
						tgl_buat		='".$tgl_buat."',
						tgl_input		='".$tgl_input."',
						status 			='3',
						alasan_batal    ='',
						tgl_batal 		=''
					WHERE kode_pg = '".$kode_pg."'
						";

		$query = mysqli_query ($con,$mySql) ;

		$array_dtl_back = $_SESSION['data_dtl_back'];
            foreach($array_dtl_back as $key=>$res_dtl){

            	$stat_cb 		= $_POST['stat_cb'][$key];
            	$no_pg 			= $kode_pg;
				$kode_giro 		= $res_dtl['kode_giro'];
				$bank_giro 		= $res_dtl['bank_giro'];
				$no_giro		= $res_dtl['no_giro'];
				$tgl_jth_giro 	= date("Y-m-d",strtotime($res_dtl['tgl_jth_giro']));
				$nominal		= $res_dtl['nominal'];
				$keterangan_dtl	= $_POST['keterangan_dtl'][$key];

				if($stat_cb=='1') {
					$mySql1 = "INSERT INTO pg_dtl SET
								kode_pg 		= '".$no_pg."',
								kode_giro		= '".$kode_giro."',
								bank_giro 		= '".$bank_giro."',
								no_giro 		= '".$no_giro."',
								tgl_jth_giro 	= '".$tgl_jth_giro."',
								nominal 		= '".$nominal."',
								keterangan_dtl 	= '".$keterangan_dtl."',
								tgl_input 		= '".$tgl_input."'
							  ";
					$query1 = mysqli_query ($con,$mySql1) ;

					//-----------CREATE JURNAL-----------------//
					if($user == 'Pelanggan'){
						//INSERT JURNAL DEBET
						$mySql2 = "INSERT INTO jurnal SET
									kode_transaksi 	='".$no_pg."',
									tgl_input 		='".$tgl_input."',
									tgl_buat 		='".$tgl_buat."',
									kode_pelanggan 	='".$kode_user."',
									kode_cabang 	='".$kode_cabang."',
									keterangan_hdr 	='".$keterangan_hdr."',
									ref 			='".$ref."',
									kode_coa 		='".$bank_coa."',
									debet  			='".$nominal."',
									user_pencipta 	='".$_SESSION['app_id']."'";

						$query2 = mysqli_query ($con,$mySql2) ;

						//INSERT JURNAL KREDIT
						$mySql3 = "INSERT INTO jurnal SET
									kode_transaksi 	='".$no_pg."',
									tgl_input 		='".$tgl_input."',
									tgl_buat 		='".$tgl_buat."',
									kode_pelanggan 	='".$kode_user."',
									kode_cabang 	='".$kode_cabang."',
									keterangan_hdr  ='".$keterangan_hdr."',
									keterangan_dtl  ='".$keterangan_dtl."',
									ref 		 	='".$ref."',
									kode_coa 		='1.01.10.01',
									kredit 			='".$nominal."',
									user_pencipta 	='".$_SESSION['app_id']."'";

						$query3 = mysqli_query ($con,$mySql3) ;

						//CREATE KARTU GIRO
						$mySql6 = "INSERT INTO kartu_giro SET
							kode_transaksi 	='".$kode_giro."',
							kode_pelunasan  ='".$no_pg."',
							inisial 		='GM',
							kredit 			='".$nominal."',
							kode_pelanggan 	='".$kode_user."',
							kode_cabang 	='".$kode_cabang."',
							tgl_buat 		='".$tgl_buat."',
							tgl_jth_tempo 	='".$tgl_jth_giro."',
							user_pencipta 	='".$_SESSION['app_id']."',
							tgl_input		='".date('Y-m-d H:i:s')."' ";

						$query6 = mysqli_query ($con,$mySql6) ;

						$mySql4 = "UPDATE gm_hdr SET status ='3' WHERE kode_gm='".$kode_giro."' ";
						$query4 = mysqli_query ($con,$mySql4) ;

						$mySql5 = "UPDATE gm_dtl SET status_dtl ='3' WHERE kode_gm='".$kode_giro."' ";
						$query5 = mysqli_query ($con,$mySql5) ;

					}elseif ($user == 'Supplier') {

						//INSERT JURNAL DEBET
						$mySql2 = "INSERT INTO jurnal SET
									kode_transaksi 	='".$no_pg."',
									tgl_input 		='".$tgl_input."',
									tgl_buat 		='".$tgl_buat."',
									kode_supplier 	='".$kode_user."',
									kode_cabang 	='".$kode_cabang."',
									keterangan_hdr 	='".$keterangan_hdr."',
									ref 			='".$ref."',
									kode_coa 		='".$bank_coa."',
									debet  			='".$nominal."',
									user_pencipta 	='".$user_pencipta."'";

						$query2 = mysqli_query ($con,$mySql2) ;

						//INSERT JURNAL KREDIT
						$mySql3 = "INSERT INTO jurnal SET
									kode_transaksi 	='".$no_pg."',
									tgl_input 		='".$tgl_input."',
									tgl_buat 		='".$tgl_buat."',
									kode_supplier 	='".$kode_user."',
									kode_cabang 	='".$kode_cabang."',
									keterangan_hdr  ='".$keterangan_hdr."',
									keterangan_dtl  ='".$keterangan_dtl."',
									ref 		 	='".$ref."',
									kode_coa 		='2.01.04.01',
									kredit 			='".$nominal."',
									user_pencipta 	='".$user_pencipta."'";

						$query3 = mysqli_query ($con,$mySql3) ;

						//CREATE KARTU GIRO
						$mySql6 = "INSERT INTO kartu_giro SET
							kode_transaksi 	='".$kode_giro."',
							kode_pelunasan  ='".$no_pg."',
							inisial 		='GK',
							debet 			='".$nominal."',
							kode_supplier 	='".$kode_user."',
							kode_cabang 	='".$kode_cabang."',
							tgl_buat 		='".$tgl_buat."',
							tgl_jth_tempo 	='".$tgl_jth_giro."',
							user_pencipta 	='".$_SESSION['app_id']."',
							tgl_input		='".date('Y-m-d H:i:s')."' ";

						$query6 = mysqli_query ($con,$mySql6) ;

						$mySql4 = "UPDATE gk_hdr SET status ='3' WHERE kode_gk='".$kode_giro."' ";
						$query4 = mysqli_query ($con,$mySql4) ;

						$mySql5 = "UPDATE gk_dtl SET status_dtl ='3' WHERE kode_gk='".$kode_giro."' ";
						$query5 = mysqli_query ($con,$mySql5) ;

					}else{
						echo "Pilih Pelanggan / Supplier !!".mysql_error();
					}
					//----------- END CREATE JURNAL-----------------//

				}
            }

            //HAPUS PG_DTL WHERE STATUS_DTL = 2
			$mySql7 = "DELETE FROM pg_dtl WHERE kode_pg = '".$no_pg."' and status_dtl = '2' ";
			$query7 = mysqli_query ($con,$mySql7) ;

			//HAPUS KARTU_GIRO WHERE STATUS_BATAL = 1
			$mySql8 = "DELETE FROM kartu_giro WHERE kode_pelunasan = '".$no_pg."' and status_batal = '1' ";
			$query8 = mysqli_query ($con,$mySql8) ;

		if ($query AND $query1 AND $query2 AND $query3 AND $query4 AND $query5 AND $query6 AND $query7 AND $query8) {
			// Commit transaction
			mysqli_commit($con);

			// Close connection
			mysqli_close($con);

			echo "00||".$kode_pg;
			unset($_SESSION['data_pg']);
		} else {
			echo "Gagal query: ".mysql_error();
		}

	}

?>
