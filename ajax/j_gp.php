<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	require('../pages/data/script/gp.php');
	date_default_timezone_set("Asia/Jakarta");
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loaditemgiro" ) {
		$kode_user		= mres($_POST['kode_user']);
		$kode_cabang	= mres($_POST['kode_cabang']);
        $id_form 		= mres($_POST['id_form']);
        $rad 		= mres($_POST['rad']);
		
		$query = mysql_query("SELECT DISTINCT(`gth`.`kode_gt`) AS `kode_giro` FROM `gt_hdr` AS `gth` LEFT JOIN `gt_dtl` AS `gtd` ON `gtd`.`kode_gt` = `gth`.`kode_gt` WHERE `gth`.`kode_cabang` = '".$kode_cabang."' AND `gth`.`kode_user` = '".$kode_user."' AND `gtd`.`status_dtl` = '1' AND `gtd`.`metode_dtl` = '2'");

		$num_rows 	= mysql_num_rows($query);
		if ($num_rows>0) {
			echo '<select name="kode_gt" id="kode_gt" class="select2">';
			echo '<option value="0">-- Pilih Kode Tolakan Giro --</option>';
			while($item = mysql_fetch_array($query)){
				echo '<option value="'. $item['kode_giro'] .'">' . $item['kode_giro'] . '</option>';
			}
			echo '</select>';
		} else {
			echo '<select name="kode_gt" id="kode_gt" class="select2" disabled>';
				echo '<option value="0">-- Tidak ada Kode Tolakan Giro --</option>';
			echo '</select>';
		}
	}
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loaditemuser" ) {
		$kode_user		= mres($_POST['kode_user']);
		$kode_cabang	= mres($_POST['kode_cabang']);
		$kode_gt	= mres($_POST['kode_gt']);
        $id_form 		= mres($_POST['id_form']);
        $rad 		= mres($_POST['rad']);
				
		$query = mysql_query("SELECT `gth`.`ref`, `coa`.`kode_coa`, `coa`.`nama` AS `nama_coa`, `gth`.`keterangan_hdr`, `gtd`.`bank_giro`, `gtd`.`no_giro`, `gtd`.`tgl_jth_giro` AS `tgl_giro`, `gtd`.`nominal`, `gtd`.`keterangan_dtl` FROM `gt_hdr` AS `gth` LEFT JOIN `coa` ON `coa`.`kode_coa` = `gth`.`bank_coa` LEFT JOIN `gt_dtl` AS `gtd` ON `gtd`.`kode_gt` = `gth`.`kode_gt` AND `gtd`.`no_giro` = `gtd`.`no_giro` AND `gtd`.`bank_giro` = `gtd`.`bank_giro` WHERE `gth`.`kode_cabang` = '".$kode_cabang."' AND `gth`.`kode_gt` = '".$kode_gt."' AND `gth`.`kode_user` = '".$kode_user."' AND `gtd`.`status_dtl` = '1' AND `gtd`.`metode_dtl` = '2' GROUP BY `gtd`.`bank_giro`, `gtd`.`no_giro`");		
		
		$num_rows 	= mysql_num_rows($query);
		$table = '';
		$kode_coa = '';
		$kn_coa = '';
		$ref = '';
		$keterangan_hdr = '';
		if($num_rows>0) {
			$n 	= 0;
			while($item = mysql_fetch_array($query)){
				$n++;
				$kode_coa = $item['kode_coa'];
				$kn_coa = $kode_coa . ' || ' . $item['nama_coa'];
				$ref = $item['ref'];
				$keterangan_hdr = $item['keterangan_hdr'];
				$table .= '<tr>
								<td width="235px">
									<input class="form-control" type="text" name="bank_giro[]" id="bank_giro_'.$n.'" data-id="'.$n.'" value="" >
								</td>
								<td width="235px">
									<input class="form-control" type="text" name="no_giro[]" id="no_giro_'.$n.'" data-id="'.$n.'" value="" >
								</td>
								<td width="130px">
									<input class="form-control date-picker" type="text" name="tgl_giro[]" id="tgl_giro_'.$n.'" data-id="'.$n.'" value="'.date('m/d/Y').'" readonly>
								</td>
								<td style="text-align:right; width:130px;">'.number_format($item['nominal'], 2).'
									<input type="hidden" name="nominal[]" id="nominal_'.$n.'" data-id="'.$n.'" value="'.$item['nominal'].'" >
								</td>
								<td>
									<textarea type="text" class="form-control" name="keterangan_dtl[]" id="keterangan_dtl_'.$n.'" data-id="'.$n.'">'.$keterangan_dtl.'</textarea>
								</td>
						  </tr>
					 ';
			}
		}else{
			$table = '<tr><td colspan="5" class="text-center">Belum ada item</td></tr>';
		}
		header('Content-type: application/json');
		echo json_encode([
			'table' => $table,
			'kode_coa' => $kode_coa,
			'nama_coa' => $kn_coa,
			'ref' => $ref,
			'keterangan_hdr' => $keterangan_hdr,
		]);
	}
	
	if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "save") {
		mysqli_autocommit($con, FALSE);
		
		$kode_gt = mres($_POST['kode_gt']);
		
		if (strpos(strtolower($kode_gt), 'tgk') !== false) {
			$form = 'GPK';
		} else {
			$form = 'GPM';
		}
		
		$tgl_buat = date('Y-m-d', strtotime(mres($_POST['tgl_buat'])));
		$thnblntgl = date("ymd", strtotime($tgl_buat));
		$tgl_input = date("Y-m-d H:i:s");

		$kode_cabang = mres($_POST['kode_cabang']);
		$user = mres($_POST['user']);
		$kode_user = mres($_POST['kode_user']);
		$nama_user = mres($_POST['nama_user']);
		$ref = mres($_POST['ref']);
		$kode_coa_save = mres($_POST['kode_coa_save']);
		$keterangan_hdr = mres($_POST['keterangan_hdr']);
		$kode_gp = buat_kode_gp($thnblntgl, $form, $kode_cabang);
		
		$no_gp = $kode_gp;
		$bank_giro = $_POST['bank_giro'];
		$no_giro = $_POST['no_giro'];
		$tgl_giro = $_POST['tgl_giro'];
		$nominal_asli = $_POST['nominal'];
		$keterangan_dtl = $_POST['keterangan_dtl'];
		$count = count($bank_giro);
		
		$mySql1 = "INSERT INTO `gp_dtl` (`kode_gp`, `bank_giro`, `no_giro`, `tgl_jth_giro`, `nominal`, `keterangan_dtl`, `tgl_input`, `status_dtl`) VALUES ";
		
		for($i = 0; $i < $count; $i++) {
			$nominal = str_replace(',', null, mres($nominal_asli[$i]));
			
			//$mySql1 .= $i > 0 ? ", " : '';
			$mySql1 .= "(
				'" . $no_gp . "',
				'" . mres($bank_giro[$i]) . "',
				'" . mres($no_giro[$i]) . "',
				'" . date('Y-m-d', strtotime(mres($tgl_giro[$i]))) . "',
				'" . $nominal . "',
				'" . mres($keterangan_dtl[$i]) . "',
				'" . $tgl_input . "',
				'1'
			),";
			
			$mySql2 = "UPDATE `gt_dtl` SET `status_dtl` = '2' WHERE `kode_gt` = '".$kode_gt."' AND `bank_giro` = '".$bank_giro[$i]."' AND `no_giro` = '".$no_giro[$i]."'; ";
			$query2 = mysqli_query ($con,$mySql2) ;
			
			if(strtolower($user) === 'pelanggan') {
				//INSERT KARTU GIRO TOLAKAN DEBET
				$mySql3 = "INSERT INTO `kartu_giro_tolakan` SET
							`kode_transaksi` 	='".$no_gp."',
							`inisial` ='".$form."',
							`debet`  			='".$nominal."',
							`lunas` = '0',
							`kode_cabang` 	='".$kode_cabang."',
							`kode_supplier` 	='".$kode_user."',
							`tgl_buat` 		='".$tgl_buat."',
							`tgl_jth_tempo` 		='" . date('Y-m-d', strtotime(mres($tgl_giro[$i]))) . "',
							`tgl_input` 		='".$tgl_input."',
							`bank_giro` = '".mres($bank_giro[$i])."',
							`no_giro` = '".mres($no_giro[$i])."',
							`user_pencipta` 	='".$_SESSION['app_id']."'";
				$query3 = mysqli_query ($con,$mySql3) ;
			} elseif(strtolower($user) === 'pelanggan') {
				//INSERT KARTU GIRO TOLAKAN KREDIT
				$mySql3 = "INSERT INTO `kartu_giro_tolakan` SET
							`kode_transaksi` 	='".$no_gp."',
							`inisial` ='".$form."',
							`kredit`  			='".$nominal."',
							`lunas` = '0',
							`kode_cabang` 	='".$kode_cabang."',
							`kode_supplier` 	='".$kode_user."',
							`tgl_buat` 		='".$tgl_buat."',
							`tgl_jth_tempo` 		='" . date('Y-m-d', strtotime(mres($tgl_giro[$i]))) . "',
							`tgl_input` 		='".$tgl_input."',
							`bank_giro` = '".mres($bank_giro[$i])."',
							`no_giro` = '".mres($no_giro[$i])."',
							`user_pencipta` 	='".$_SESSION['app_id']."'";
				$query3 = mysqli_query ($con,$mySql3) ;
			} else {
				$query3 = true;
			}
			/* if(strtolower($user) === 'pelanggan') {
				//INSERT JURNAL DEBET
				$mySql2 = "INSERT INTO `jurnal` SET
						`kode_transaksi` 	='".$no_gp."',
						`tgl_input` 		='".$tgl_input."',
						`tgl_buat` 		='".$tgl_buat."',
						`kode_pelanggan` 	='".$kode_user."',
						`kode_cabang` 	='".$kode_cabang."',
						`keterangan_hdr` 	='".$keterangan_hdr."',
						`keterangan_dtl`  ='".mres($keterangan_dtl[$i])."',
						`ref` 			='".$ref."',
						`kode_coa` 		='1.01.03.02',
						`debet`  			='".$nominal."',
						`user_pencipta` 	='".$_SESSION['app_id']."'";

				$query2 = mysqli_query ($con,$mySql2) ;

				//INSERT JURNAL KREDIT
				$mySql3 = "INSERT INTO `jurnal` SET
						`kode_transaksi` 	='".$no_gp."',
						`tgl_input` 		='".$tgl_input."',
						`tgl_buat` 		='".$tgl_buat."',
						`kode_pelanggan` 	='".$kode_user."',
						`kode_cabang` 	='".$kode_cabang."',
						`keterangan_hdr`  ='".$keterangan_hdr."',
						`keterangan_dtl`  ='".mres($keterangan_dtl[$i])."',
						`ref` 		 	='".$ref."',
						`kode_coa` 		='".$kode_coa_save."',
						`kredit` 			='".$nominal."',
						`user_pencipta` 	='".$_SESSION['app_id']."'";

				$query3 = mysqli_query ($con,$mySql3) ;
				
				
			} elseif(strtolower($user) === 'supplier') {
				//INSERT JURNAL DEBET
				$mySql2 = "INSERT INTO `jurnal` SET
							`kode_transaksi` 	='".$no_gp."',
							`tgl_input` 		='".$tgl_input."',
							`tgl_buat` 		='".$tgl_buat."',
							`kode_supplier` 	='".$kode_user."',
							`kode_cabang` 	='".$kode_cabang."',
							`keterangan_hdr` 	='".$keterangan_hdr."',
							`keterangan_dtl`  ='".mres($keterangan_dtl[$i])."',
							`ref` 			='".$ref."',
							`kode_coa` 		='".$kode_coa_save."',
							`debet`  			='".$nominal."',
							`user_pencipta` 	='".$_SESSION['app_id']."'";

				$query2 = mysqli_query ($con,$mySql2) ;

				//INSERT JURNAL KREDIT
				$mySql3 = "INSERT INTO `jurnal` SET
							`kode_transaksi` 	='".$no_gp."',
							`tgl_input` 		='".$tgl_input."',
							`tgl_buat` 		='".$tgl_buat."',
							`kode_supplier` 	='".$kode_user."',
							`kode_cabang` 	='".$kode_cabang."',
							`keterangan_hdr`  ='".$keterangan_hdr."',
							`keterangan_dtl`  ='".mres($keterangan_dtl[$i])."',
							`ref` 		 	='".$ref."',
							`kode_coa` 		='2.01.02.02',
							`kredit`  			='".$nominal."',
							`user_pencipta` 	='".$_SESSION['app_id']."'";
				$query3 = mysqli_query ($con,$mySql3) ;
			} else {
				$query2 = true;
				$query3 = true;
			} */

			/* if ((float)$nominal === (float)$nominal_asli[$i]) {
				$mySql4 = "UPDATE `gt_dtl` SET `status_dtl` = '4' WHERE `kode_gt` = '".$kode_gt."' AND `bank_giro` = '".$bank_giro[$i]."' AND `no_giro` = '".$no_giro[$i]."'; ";
				$query4 = mysqli_query ($con,$mySql4) ;
			} else {
				$mySql4 = "tidak update";
				$query4 = true;
			} */
		}
		
		$mySql1 = rtrim($mySql1,",");
		$query1 = mysqli_query ($con,$mySql1) ;
		
		//HEADER PELUNASAN GIRO
		$mySql	= "INSERT INTO `gp_hdr` SET
						`kode_gp`			='".$no_gp."',
						`kode_gt`			='".$kode_gt."',
						`ref`				='".$ref."',
						`bank_coa`		='".$kode_coa_save."',
						`kode_cabang`		='".$kode_cabang."',
						`kode_user`		='".$kode_user."',
						`nama_user`		='".$nama_user."',
						`keterangan_hdr`	='".$keterangan_hdr."',
						`tgl_buat`		='".$tgl_buat."',
						`tgl_input`		='".$tgl_input."',
						`user_pencipta`	='".$user_pencipta."',
						`status` 			='1'";
		$query = mysqli_query ($con,$mySql) ;
		  
		/* echo json_encode([
			$query,
			$query1,
			$query2,
			$query3,
			$query4,
			$mySql4,
			(float)$nominal_asli[0],
			(float)$nominal,
			((float)$nominal === (float)$nominal_asli[0]),
		]);
		
		die(); */
		
		if ($query AND $query1 AND $query2 AND $query3 /* AND $query4 */) {
			// Commit transaction
			mysqli_commit($con);

			// Close connection
			mysqli_close($con);

			echo "00||".$no_gp;
			unset($_SESSION['data_gt']);
		} else {
			echo "Gagal query: ".mysql_error();
		}
	} 