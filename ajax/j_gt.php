<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	require('../pages/data/script/gt.php');
	date_default_timezone_set("Asia/Jakarta");
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loaditemgiro" ) {
		$kode_user		= mres($_POST['kode_user']);
		$kode_cabang	= mres($_POST['kode_cabang']);
        $id_form 		= mres($_POST['id_form']);
        $rad 		= mres($_POST['rad']);
		
		$query = mysql_query("SELECT DISTINCT(`pgh`.`kode_pg`) AS `kode_giro` FROM `pg_hdr` AS `pgh` LEFT JOIN `pg_dtl` AS `pgd` ON `pgd`.`kode_pg` = `pgh`.`kode_pg` WHERE `pgh`.`kode_cabang` = '".$kode_cabang."' AND `pgh`.`kode_user` = '".$kode_user."' AND `pgd`.`status_dtl` = '2'");

		$num_rows 	= mysql_num_rows($query);
		if ($num_rows>0) {
			echo '<select name="kode_pg" id="kode_pg" class="select2">';
			echo '<option value="0">-- Pilih Kode Pelunasan Giro --</option>';
			while($item = mysql_fetch_array($query)){
				echo '<option value="'. $item['kode_giro'] .'">' . $item['kode_giro'] . '</option>';
			}
			echo '</select>';
		} else {
			echo '<select name="kode_pg" id="kode_pg" class="select2" disabled>';
				echo '<option value="0">-- Tidak ada Kode Pelunasan Giro --</option>';
			echo '</select>';
		}
	}
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loaditemuser" ) {
		$kode_user		= mres($_POST['kode_user']);
		$kode_cabang	= mres($_POST['kode_cabang']);
		$kode_pg	= mres($_POST['kode_pg']);
        $id_form 		= mres($_POST['id_form']);
        $rad 		= mres($_POST['rad']);
				
		$query = mysql_query("SELECT `pgh`.`ref`, `pgh`.`kode_giro`, `coa`.`kode_coa`, `coa`.`nama` AS `nama_coa`, `pgh`.`keterangan_hdr`, `pgd`.`bank_giro`, `pgd`.`no_giro`, `pgd`.`tgl_jth_giro` AS `tgl_giro`, `pgd`.`bank_giro`, `pgd`.`no_giro`, `pgd`.`nominal`, (`pgd`.`nominal` - IFNULL(SUM(`gtd`.`nominal`), 0)) AS `nominal_sisa`, `pgd`.`keterangan_dtl` FROM `pg_hdr` AS `pgh` LEFT JOIN `pg_dtl` AS `pgd` ON `pgd`.`kode_pg` = `pgh`.`kode_pg` LEFT JOIN `coa` ON `coa`.`kode_coa` = `pgh`.`bank_coa` LEFT JOIN `gt_hdr` AS `gth` ON `gth`.`kode_pg` = `pgh`.`kode_pg` LEFT JOIN `gt_dtl` AS `gtd` ON `gtd`.`kode_gt` = `gth`.`kode_gt` AND gtd.`no_giro`=pgd.`no_giro` AND gtd.`bank_giro`=pgd.`bank_giro` WHERE `pgh`.`kode_cabang` = '".$kode_cabang."' AND `pgh`.`kode_pg` = '".$kode_pg."' AND `pgh`.`kode_user` = '".$kode_user."' AND `pgd`.`status_dtl` = '2' GROUP BY `pgd`.`bank_giro`, `pgd`.`no_giro`");		
		
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
								<td width="130px" style="text-align:center;width:130px;">
									<input type="hidden" name="input_giro[]" id="input_cb_'.$n.'" data-id="'.$n.'" value="0" >
									<input type="checkbox" name="input_giro_'.$n.'" id="input_giro_'.$n.'" data-id="'.$n.'" value="1" style="width:40px;height:30px" >
								</td>
								<td width="235px">'.$item['bank_giro'].'
									<input type="hidden" name="kode_giro[]" id="kode_giro_'.$n.'" data-id="'.$n.'" value="'.$item['kode_giro'].'" >
									<input type="hidden" name="bank_giro[]" id="bank_giro_'.$n.'" data-id="'.$n.'" value="'.$item['bank_giro'].'" >
								</td>
								<td width="235px">'.($item['no_giro']).'
									<input type="hidden" name="no_giro[]" id="no_giro_'.$n.'" data-id="'.$n.'" value="'.$item['no_giro'].'" >
								</td>
								<td width="130px">'.(strftime("%A, %d %B %Y", strtotime($item['tgl_giro']))).'
									<input type="hidden" name="tgl_giro[]" id="tgl_giro_'.$n.'" data-id="'.$n.'" value="'.$item['tgl_giro'].'" >
								</td>
								<td style="text-align:right; width:130px;">'.number_format($item['nominal_sisa'], 2).'
									<input type="hidden" name="nominal_asli[]" id="nominal_asli_'.$n.'" data-id="'.$n.'" value="'.$item['nominal_sisa'].'" >
								</td>
								<td style="text-align:right; width:130px;">
									<input class="form-control" type="text" name="nominal_tolakan[]" id="nominal_tolakan_'.$n.'" data-id="'.$n.'" value="'.$item['nominal_sisa'].'" style="text-align:right" disabled >
								</td>
								<td style="text-align:right; width:130px;">
									<span id="text-nominal_sisa_'.$n.'" data-id="'.$n.'">
										0
									</span>
								</td>
								<td style="width:130px;">
									<select id="metode_dtl_'.$n.'" name="metode_dtl[]" data-id="'.$n.'" class="select2" style="width: 400px">
										<option value="0">Kas</option>
										<option value="1">Bank</option>
										<option value="2">Pengganti Giro</option>
									</select>
								</td>
								<td>
									<textarea type="text" class="form-control" name="keterangan_dtl[]" id="keterangan_dtl_'.$n.'" data-id="'.$n.'">'.$keterangan_dtl.'</textarea>
								</td>
						  </tr>
					 ';
			}
		}else{
			$table = '<tr><td colspan="9" class="text-center">Belum ada item</td></tr>';
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
		
		$kode_pg = mres($_POST['kode_pg']);
		
		if (strpos(strtolower($kode_pg), 'pgk') !== false) {
			$form = 'TGK';
		} else {
			$form = 'TGM';
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
		$kode_gt = buat_kode_gt($thnblntgl, $form, $kode_cabang);
		
		$no_gt = $kode_gt;
		$input_giro = $_POST['input_giro'];
		$kode_giro = $_POST['kode_giro'];
		$bank_giro = $_POST['bank_giro'];
		$no_giro = $_POST['no_giro'];
		$tgl_giro = $_POST['tgl_giro'];
		$nominal_asli = $_POST['nominal_asli'];
		$nominal_tolakan = $_POST['nominal_tolakan'];
		$metode_dtl = $_POST['metode_dtl'];
		$keterangan_dtl = $_POST['keterangan_dtl'];
		$count = count($bank_giro);
		
		$mySql1 = "INSERT INTO `gt_dtl` (`kode_gt`, `bank_giro`, `no_giro`, `tgl_jth_giro`, `nominal`, `keterangan_dtl`, `tgl_input`, `metode_dtl`, `status_dtl`) VALUES ";
		
		for($i = 0; $i < $count; $i++) {
			if ($input_giro[$i] === '1' || $input_giro[$i] === 1) {
				$nominal = str_replace(',', null, mres($nominal_tolakan[$i]));
				
				//$mySql1 .= $i > 0 ? ", " : '';
				$mySql1 .= "(
					'" . $no_gt . "',
					'" . mres($bank_giro[$i]) . "',
					'" . mres($no_giro[$i]) . "',
					'" . mres($tgl_giro[$i]) . "',
					'" . $nominal . "',
					'" . mres($keterangan_dtl[$i]) . "',
					'" . $tgl_input . "',
					'" . mres($metode_dtl[$i]) . "',
					'1'
				),";
				
				if(strtolower($user) === 'pelanggan') {
					//INSERT JURNAL DEBET
					$mySql2 = "INSERT INTO `jurnal` SET
							`kode_transaksi` 	='".$no_gt."',
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
							`kode_transaksi` 	='".$no_gt."',
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
					
					//INSERT KARTU GIRO KREDIT
					$mySql5 = "INSERT INTO `kartu_giro` SET
								`kode_transaksi` 	='".mres($kode_giro[$i])."',
								`kode_pelunasan` 	='".$no_gt."',
								`inisial` ='GM',
								`kredit`  			='".$nominal."',
								`lunas` = '0',
								`kode_cabang` 	='".$kode_cabang."',
								`kode_pelanggan` 	='".$kode_user."',
								`tgl_buat` 		='".$tgl_buat."',
								`tgl_jth_tempo` 		='".mres($tgl_giro[$i])."',
								`tgl_input` 		='".$tgl_input."',
								`bank_giro` = '".mres($bank_giro[$i])."',
								`no_giro` = '".mres($no_giro[$i])."',
								`user_pencipta` 	='".$_SESSION['app_id']."'";
					$query5 = mysqli_query ($con,$mySql5) ;
					
					if ($metode_dtl !== '2' || $metode_dtl[$i] !== 2) {
					//INSERT KARTU GIRO TOLAKAN DEBET
					$mySql6 = "INSERT INTO `kartu_giro_tolakan` SET
								`kode_transaksi` 	='".$no_gt."',
								`inisial` ='".$form."',
								`debet`  			='".$nominal."',
								`lunas` = '0',
								`kode_cabang` 	='".$kode_cabang."',
								`kode_pelanggan` 	='".$kode_user."',
								`tgl_buat` 		='".$tgl_buat."',
								`tgl_jth_tempo` 		='".mres($tgl_giro[$i])."',
								`tgl_input` 		='".$tgl_input."',
								`bank_giro` = '".mres($bank_giro[$i])."',
								`no_giro` = '".mres($no_giro[$i])."',
								`user_pencipta` 	='".$_SESSION['app_id']."'";
					$query6 = mysqli_query ($con,$mySql6) ;
					} else {
					$query6 = true;
					}
					
					
				} elseif(strtolower($user) === 'supplier') {
					//INSERT JURNAL DEBET
					$mySql2 = "INSERT INTO `jurnal` SET
								`kode_transaksi` 	='".$no_gt."',
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
								`kode_transaksi` 	='".$no_gt."',
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
					
					//INSERT KARTU GIRO DEBET
					$mySql5 = "INSERT INTO `kartu_giro` SET
								`kode_transaksi` 	='".mres($kode_giro[$i])."',
								`kode_pelunasan` 	='".$no_gt."',
								`inisial` ='GK',
								`debet`  			='".$nominal."',
								`lunas` = '0',
								`kode_cabang` 	='".$kode_cabang."',
								`kode_supplier` 	='".$kode_user."',
								`tgl_buat` 		='".$tgl_buat."',
								`tgl_jth_tempo` 		='".mres($tgl_giro[$i])."',
								`tgl_input` 		='".$tgl_input."',
								`bank_giro` = '".mres($bank_giro[$i])."',
								`no_giro` = '".mres($no_giro[$i])."',
								`user_pencipta` 	='".$_SESSION['app_id']."'";
					$query5 = mysqli_query ($con,$mySql5) ;
					
					if ($metode_dtl !== '2' || $metode_dtl[$i] !== 2) {
					//INSERT KARTU GIRO TOLAKAN KREDIT
					$mySql6 = "INSERT INTO `kartu_giro_tolakan` SET
								`kode_transaksi` 	='".$no_gt."',
								`inisial` ='".$form."',
								`kredit`  			='".$nominal."',
								`lunas` = '0',
								`kode_cabang` 	='".$kode_cabang."',
								`kode_supplier` 	='".$kode_user."',
								`tgl_buat` 		='".$tgl_buat."',
								`tgl_jth_tempo` 		='".mres($tgl_giro[$i])."',
								`tgl_input` 		='".$tgl_input."',
								`bank_giro` = '".mres($bank_giro[$i])."',
								`no_giro` = '".mres($no_giro[$i])."',
								`user_pencipta` 	='".$_SESSION['app_id']."'";
					$query6 = mysqli_query ($con,$mySql6) ;
					} else {
					$query6 = true;
					}
				} else {
					$query2 = true;
					$query3 = true;
					$query5 = true;
					$query6 = true;
				}

				if ((float)$nominal === (float)$nominal_asli[$i]) {
					$mySql4 = "UPDATE `pg_dtl` SET `status_dtl` = '4' WHERE `kode_pg` = '".$kode_pg."' AND `bank_giro` = '".$bank_giro[$i]."' AND `no_giro` = '".$no_giro[$i]."'; ";
					$query4 = mysqli_query ($con,$mySql4) ;
				} else {
					$mySql4 = "tidak update";
					$query4 = true;
				}
			}
		}
		
		$mySql1 = rtrim($mySql1,",");
		$query1 = mysqli_query ($con,$mySql1) ;
		
		//HEADER PELUNASAN GIRO
		$mySql	= "INSERT INTO `gt_hdr` SET
						`kode_gt`			='".$no_gt."',
						`kode_pg`			='".$kode_pg."',
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
			$query5,
			$query6,
		]);
		
		die(); */
		
		if ($query AND $query1 AND $query2 AND $query3 AND $query4 AND $query5 AND $query6) {
			// Commit transaction
			mysqli_commit($con);

			// Close connection
			mysqli_close($con);

			echo "00||".$no_gt;
			unset($_SESSION['data_gt']);
		} else {
			echo "Gagal query: ".mysql_error();
		}
	} 