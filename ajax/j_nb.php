<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	require('../pages/data/script/nb.php'); 
	date_default_timezone_set("Asia/Jakarta");

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loadppnsup" )
	{
		$kode_supplier = $_POST['kode_supplier'];
		
		$q_ppn = mysql_query("SELECT PPn FROM supplier WHERE kode_supplier='".$kode_supplier."'");	
		
		$num_rows = mysql_num_rows($q_ppn);
		if($num_rows>0)
		{		
			$rowppn = mysql_fetch_array($q_ppn);
			if($rowppn['PPn']=='1'){
				echo '<input class="form-control" type="checkbox" name="ppn" id="ppn" checked>
						<input class="form-control" type="hidden" name="stat_ppn" id="stat_ppn" value="1">
					 ';	
			}else{
				echo '<input class="form-control" type="checkbox" name="ppn" id="ppn">
						<input class="form-control" type="hidden" name="stat_ppn" id="stat_ppn" value="0">
					 ';	
			}
		}
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loadppnpel" )
	{
		$kode_pelanggan = $_POST['kode_pelanggan'];
		
		$q_ppn = mysql_query("SELECT PPn FROM pelanggan WHERE kode_pelanggan='".$kode_pelanggan."'");	
		
		$num_rows = mysql_num_rows($q_ppn);
		if($num_rows>0)
		{		
			$rowppn = mysql_fetch_array($q_ppn);
			if($rowppn['PPn']=='1'){
				echo '<input class="form-control" type="checkbox" name="ppn" id="ppn" checked>
						<input class="form-control" type="hidden" name="stat_ppn" id="stat_ppn" value="1">
					 ';	
			}else{
				echo '<input class="form-control" type="checkbox" name="ppn" id="ppn">
						<input class="form-control" type="hidden" name="stat_ppn" id="stat_ppn" value="0">
					 ';	
			}
		}
	}

	if (isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "add" )
	{

		if(isset($_POST['kode_coa']) and @$_POST['kode_coa'] != ""){

			$coa  	  = $_POST['kode_coa'];
			$kd_coa	  = explode(":", $coa);
			$kode_coa = $kd_coa[0];
			$nama_coa = $kd_coa[1];

			$id_form		= $_POST['id_form'];
			$itemnb 		= "INSERT INTO nb_dtl_tmp SET 
											kode_coa		='".$kode_coa."',
											nama_coa		='".$nama_coa."',
											harga			='".$_POST['harga']."',
											keterangan		='".$_POST['ket_dtl']."',
											id_form			='".$id_form."' ";
			// die($itemnb);
			mysql_query($itemnb);
			
			$query			= "SELECT * FROM nb_dtl_tmp WHERE id_form='".$id_form."'";
			$result			= mysql_query($query);
			
			$array = array();
			if(mysql_num_rows($result) > 0) {
				while ($res = mysql_fetch_array($result)) {
					
					if(!isset($_SESSION['data_nb'])) {
						$array[$res['id_nb_dtl']] = array("id" => $res['id_nb_dtl'],"kode_coa" => $res['kode_coa'],"nama_coa" => $res['nama_coa'],"harga" => $res['harga'],"ket_dtl" => $res['keterangan'], "id_form" => $res['id_form']);
					} else {
						$array = $_SESSION['data_nb'];
						$array[$res['id_nb_dtl']] = array("id" => $res['id_nb_dtl'],"kode_coa" => $res['kode_coa'],"nama_coa" => $res['nama_coa'],"harga" => $res['harga'],"ket_dtl" => $res['keterangan'], "id_form" => $res['id_form']);
					}
				   
				}
			} 
			$_SESSION['data_nb'] = $array;
			echo view_item_nb($array);
		}
	}


	function view_item_nb($data) {
		$n = 1;
		$html = "";
		if(count($data) > 0) {
			foreach($data as $key=>$item){

				$html .= '<tr>
							<td style="text-align: center">'.$n++.'</td>
							<td>'.$item['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$item['nama_coa'].'</td>
							<td style="text-align:right">'.number_format($item['harga'], 2).'</td>	
							<td>'.$item['ket_dtl'].'</td>
							<td style="text-align: center">
							<a href="javascript:;" class="label label-danger hapus-nb" title="hapus data" data-id="'.$key.'"><i class="fa fa-times"></i></a>           			
							</td>
						</tr>						
						';
			}
			
			$html .= "<script>$('.hapus-nb').click(function(){
						var id =	$(this).attr('data-id'); 
						var id_form = $('#id_form').val();
						$.ajax({
							type: 'POST',
							url: '".base_url()."ajax/j_nb.php?func=hapus-nb',
							data: 'idhapus=' + id + '&id_form=' +id_form,
							cache: false,
							success:function(data){
								$('#detail_input_nb').html(data).show();
							 }
						  });
					  });
				     </script>";
				
		} else {
			$html .= '<tr> <td colspan="5" class="text-center"> Tidak ada item barang. </td></tr>';
		}
		  
		return $html;
	}


	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "hapus-nb" )
	{
		$id = $_POST['idhapus'];
		$id_form = $_POST['id_form'];
		$itemdelete = "DELETE FROM nb_dtl_tmp WHERE id_nb_dtl = '".$id."'";
		mysql_query($itemdelete);
		unset($_SESSION['data_nb'][$id]);
		echo view_item_nb($_SESSION['data_nb']);
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save" )
	{
		mysqli_autocommit($con,FALSE);

		$form 			= 'NB';
		$thnblntgl 		= date("ymd",strtotime($_POST['tgl_buat']));
		
		$ref			= $_POST['ref'];
		$kode_cabang	= $_POST['kode_cabang'];
		$user			= $_POST['user'];
		$kode_user		= $_POST['kode_user'];
		$nama_user		= $_POST['nama_user'];
		$tgl_buat 		= date("Y-m-d",strtotime($_POST['tgl_buat']));
		$tgl_jth_tempo 	= date("Y-m-d",strtotime($_POST['tgl_jth_tempo']));
		$keterangan_hdr	= $_POST['keterangan'];
		
		$user_pencipta  = $_SESSION['app_id'];
		$tgl_input 		= date("Y-m-d H:i:s");
		
		$kode_nb = buat_kode_nb($thnblntgl,$form,$kode_cabang);
		
		//HEADER nb
		$mySql	= "INSERT INTO nb_hdr SET 
						kode_nb			='".$kode_nb."',
						ref				='".$ref."',
						kode_cabang		='".$kode_cabang."',
						kode_user		='".$kode_user."',
						nama_user		='".$nama_user."',
						tgl_buat		='".$tgl_buat."',
						tgl_jth_tempo	='".$tgl_jth_tempo."',
						tgl_input		='".$tgl_input."',
						keterangan		='".$keterangan_hdr."',
						user_pencipta	='".$user_pencipta."',
						status = '0',
						tipe = '".$user."'";	
						
		$query = mysqli_query ($con,$mySql) ;
		
		//DETAIL NB
		$total_harga1 = 0;
		$array = $_SESSION['data_nb'];
			foreach($array as $key=>$item){

					$no_nb 			= $kode_nb;
					$kode_coa		= $item['kode_coa'];
					$nama_coa		= $item['nama_coa'];
					$harga			= $item['harga'];
					$keterangan_dtl	= $item['ket_dtl'];

					$total_harga1 += $harga;
					
					$mySql1 = "INSERT INTO nb_dtl SET 
											kode_nb		='".$no_nb."',
											kode_coa 	='".$kode_coa."',
											nama_coa 	='".$nama_coa."',
											harga		='".$harga."',
											keterangan	='".$keterangan_dtl."' ";	
	
					$query1 = mysqli_query ($con,$mySql1) ;
					if ($user == 'pelanggan') {
						$mySql4    = "INSERT INTO `jurnal` SET
							`kode_transaksi`			='" . $no_nb . "',
							`tgl_buat`				='" . $tgl_buat . "',
							`tgl_input`				='" . $tgl_input . "',
							`kode_cabang`				='" . $kode_cabang . "',
							`kode_pelanggan`			='" . $kode_user . "',
							`keterangan_hdr`			='" . $keterangan_hdr . "',
							`ref`						='" . $ref . "',
							`kode_coa`				='" . $kode_coa . "',
							`kredit`					='" . $harga . "',
							`user_pencipta`			='" . $user_pencipta . "';
						";
						$query4 = mysqli_query($con, $mySql4);
					} else {
						$mySql4    = "INSERT INTO `jurnal` SET
							`kode_transaksi`			='" . $no_nb . "',
							`tgl_buat`				='" . $tgl_buat . "',
							`tgl_input`				='" . $tgl_input . "',
							`kode_cabang`				='" . $kode_cabang . "',
							`kode_supplier`			='" . $kode_user . "',
							`keterangan_hdr`			='" . $keterangan_hdr . "',
							`ref`						='" . $ref . "',
							`kode_coa`				='" . $kode_coa . "',
							`kredit`					='" . $harga . "',
							`user_pencipta`			='" . $user_pencipta . "';
						";
						$query4 = mysqli_query($con, $mySql4);
					}
		}

		if($user == 'pelanggan'){
			$mySql2	= "INSERT INTO kartu_piutang SET 
						kode_transaksi	='".$kode_nb."',
						debet			='".$total_harga1."',
						tgl_input		='".$tgl_input."',
						kode_pelanggan	='".$kode_user."',
						tgl_buat		='".$tgl_buat."',
						tgl_jth_tempo	='".$tgl_jth_tempo."',
						kode_cabang		='".$kode_cabang."', 
						user_pencipta   ='".$user_pencipta."' ";			
			$query2 = mysqli_query ($con,$mySql2) ;
			$mySql3    = "INSERT INTO `jurnal` SET
							`kode_transaksi`			='" . $no_nb . "',
							`tgl_buat`				='" . $tgl_buat . "',
							`tgl_input`				='" . $tgl_input . "',
							`kode_cabang`				='" . $kode_cabang . "',
							`kode_pelanggan`			='" . $kode_user . "',
							`keterangan_hdr`			='" . $keterangan_hdr . "',
							`ref`						='" . $ref . "',
							`kode_coa`				='1.01.03.01',
							`debet`					='" . $total_harga1 . "',
							`user_pencipta`			='" . $user_pencipta . "';
						";
						$query3 = mysqli_query($con, $mySql3);
		}elseif ($user == 'supplier') {
			$mySql2	= "INSERT INTO kartu_hutang SET 
						kode_transaksi	='".$kode_nb."',
						debet			='".$total_harga1."',
						tgl_input		='".$tgl_input."',
						kode_supplier	='".$kode_user."',
						tgl_buat		='".$tgl_buat."',
						tgl_jth_tempo	='".$tgl_jth_tempo."',
						kode_cabang		='".$kode_cabang."', 
						user_pencipta   ='".$user_pencipta."' ";		
			$query2 = mysqli_query ($con,$mySql2) ;
			$mySql3    = "INSERT INTO `jurnal` SET
							`kode_transaksi`			='" . $no_nb . "',
							`tgl_buat`				='" . $tgl_buat . "',
							`tgl_input`				='" . $tgl_input . "',
							`kode_cabang`				='" . $kode_cabang . "',
							`kode_supplier`			='" . $kode_user . "',
							`keterangan_hdr`			='" . $keterangan_hdr . "',
							`ref`						='" . $ref . "',
							`kode_coa`				='2.01.02.01',
							`debet`					='" . $total_harga1 . "',
							`user_pencipta`			='" . $user_pencipta . "';
						";
						$query3 = mysqli_query($con, $mySql3);
			
			
		}else{
			echo "Pilih Pelanggan / Supplier !!".mysql_error();
		}

		if ($query AND $query1 AND $query2) {
			mysqli_query($con,"DELETE FROM nb_dtl_tmp WHERE id_form ='".$_POST['id_form']."' ");

			// Commit transaction
			mysqli_commit($con);
			
			// Close connection
			mysqli_close($con);

			echo "00||".$kode_nb;
			unset($_SESSION['data_nb']);
			//unset($_SESSION['data_op'.$id_form .'']);
			//echo "00|| $mySql";
			
		} else { 
		   
			echo "Gagal query: ".mysql_error();
		}		 	
				
					 
	}
	
	
	if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "pembatalan") {
		mysqli_autocommit($con,FALSE);
		
		$kode_nb		= $_POST['kode_nb_batal'];
		$alasan_batal	= $_POST['alasan_batal'];
		$tgl_batal 		= date("Y-m-d");
		$tgl_input		= date("Y-m-d H:i:s");
		
		$checker = array();
		
		$cekBkk = "SELECT `deskripsi` FROM `bkk_dtl` WHERE `status_dtl` = '0' AND `deskripsi` = '".$kode_nb."'";
		$queryBkk = mysqli_query($con, $cekBkk);

		if (mysqli_num_rows($queryBkk) > 0) {
			mysqli_commit($con);
			mysqli_close($con);
			echo "Kode NB " . $kode_nb . " sudah Bukti Kas Keluar!";
			return false;
		}
		
		$cekGk = "SELECT `deskripsi` FROM `gk_dtl` WHERE `status_dtl` = '1' AND `deskripsi` = '".$kode_nb."'";
		$queryGk = mysqli_query($con, $cekGk);

		if (mysqli_num_rows($queryGk) > 0) {
			mysqli_commit($con);
			mysqli_close($con);
			echo "Kode NB " . $kode_nb . " sudah Giro Keluar!";
			return false;
		}
		
		$cekBkm = "SELECT `deskripsi` FROM `bkm_dtl` WHERE `status_dtl` = '0' AND `deskripsi` = '".$kode_nb."'";
		$queryBkm = mysqli_query($con, $cekBkm);

		if (mysqli_num_rows($queryBkm) > 0) {
			mysqli_commit($con);
			mysqli_close($con);
			echo "Kode NB " . $kode_nb . " sudah Bukti Kas Masuk!";
			return false;
		}
		
		$cekGm = "SELECT `deskripsi` FROM `gm_dtl` WHERE `status_dtl` = '1' AND `deskripsi` = '".$kode_nb."'";
		$queryGm = mysqli_query($con, $cekGm);

		if (mysqli_num_rows($queryGm) > 0) {
			mysqli_commit($con);
			mysqli_close($con);
			echo "Kode NB " . $kode_nb . " sudah Giro Masuk!";
			return false;
		}
		
		$selectNb = "SELECT * FROM nb_hdr WHERE kode_nb = '".$kode_nb."' AND status = '0'";
		$queryNb = mysqli_query($con, $selectNb);
		
		if (mysqli_num_rows($queryNb) > 0) {
			$dataNb = mysqli_fetch_array($queryNb);
			$selectNbDtl = "SELECT * FROM nb_dtl WHERE kode_nb = '".$kode_nb."' AND status_dtl = '0'";
			$queryNbDtl = mysqli_query($con, $selectNbDtl);
			
			if (mysqli_num_rows($queryNbDtl) > 0) {
				$dataNbDtl = mysqli_fetch_array($queryNbDtl);
				if ($dataNb['tipe'] == 'pelanggan') {
					$selectKHP = "SELECT * FROM kartu_piutang WHERE kode_transaksi = '" . $dataNb['kode_nb'] . "' AND status_batal = '0'";
					$queryKHP = mysqli_query($con, $selectKHP);
					if (mysqli_num_rows($queryKHP) > 0) {
						while ($rowKHP = mysqli_fetch_array($queryKHP)) {
							$insertKHPReverse = "INSERT INTO kartu_piutang SET kode_transaksi = '" . $dataNb['kode_nb'] . "', debet = '" . $rowKHP['kredit'] . "', kredit = '" . $rowKHP['debet'] . "', tgl_input = '" . $tgl_input . "', kode_pelanggan = '" . $dataNb['kode_user'] . "', tgl_buat = '" . $rowKHP['tgl_buat'] . "', tgl_jth_tempo = '" . $rowKHP['tgl_jth_tempo'] . "', kode_cabang = '" . $rowKHP['kode_cabang'] . "', user_pencipta = '" . $_SESSION['app_id'] . "', status_batal = '1', lunas = '0'";
							$queryInsertKHPReverse = mysqli_query($con, $insertKHPReverse);
							if ($queryInsertKHPReverse) {
								$checker[] = true;
								$updateKHPReverse = "UPDATE kartu_piutang SET lunas = '0' WHERE kode_transaksi = '" . $dataNB['kode_nb'] . "' AND tgl_input < '" . $tgl_input . "'";
								$queryUpdateKHPReverse = mysqli_query($con, $updateKHPReverse);
								if ($queryUpdateKHPReverse) {
									$checker[] = true;
								} else {
									$checker[] = mysqli_error($con);
								}
							} else {
								$checker[] = mysqli_error($con);
							}
						}
					}
				} else {
					$selectKHP = "SELECT * FROM kartu_hutang WHERE kode_transaksi = '" . $dataNb['kode_nb'] . "' AND status_batal = '0'";
					$queryKHP = mysqli_query($con, $selectKHP);					
					if (mysqli_num_rows($queryKHP) > 0) {
						while ($rowKHP = mysqli_fetch_array($queryKHP)) {
							$insertKHPReverse = "INSERT INTO kartu_hutang SET kode_transaksi = '" . $dataNb['kode_nb'] . "', debet = '" . $rowKHP['kredit'] . "', kredit = '" . $rowKHP['debet'] . "', tgl_input = '" . $tgl_input . "', kode_supplier = '" . $dataNb['kode_user'] . "', tgl_buat = '" . $rowKHP['tgl_buat'] . "', tgl_jth_tempo = '" . $rowKHP['tgl_jth_tempo'] . "', kode_cabang = '" . $rowKHP['kode_cabang'] . "', user_pencipta = '" . $_SESSION['app_id'] . "', status_batal = '1', lunas = '0'";
							$queryInsertKHPReverse = mysqli_query($con, $insertKHPReverse);
							if ($queryInsertKHPReverse) {
								$checker[] = true;
								$updateKHPReverse = "UPDATE kartu_hutang SET lunas = '0' WHERE kode_transaksi = '" . $dataNB['kode_nb'] . "' AND tgl_input < '" . $tgl_input . "'";
								$queryUpdateKHPReverse = mysqli_query($con, $updateKHPReverse);
								if ($queryUpdateKHPReverse) {
									$checker[] = true;
								} else {
									$checker[] = mysqli_error($con);
								}
							} else {
								$checker[] = mysqli_error($con);
							}
						}
					}
				}
				
				$selectJN = "SELECT * FROM jurnal WHERE kode_transaksi = '" . $dataNb['kode_nb'] . "' AND status_jurnal = '0'";			
				$queryJN = mysqli_query($con, $selectJN);
				if (mysqli_num_rows($queryJN) > 0) {
					while ($rowJN = mysqli_fetch_array($queryJN)) {
						$insertJNReverse = "INSERT INTO jurnal SET kode_transaksi = '" . $dataNb['kode_nb'] . "', ref = '" . $rowJN['ref'] . "', tgl_buat = '" . $rowJN['tgl_buat'] . "', kode_cabang = '" . $rowJN['kode_cabang'] . "', kode_supplier = '" . $rowJN['kode_supplier'] . "', kode_pelanggan = '" . $rowJN['kode_pelanggan'] . "', kode_coa = '" . $rowJN['kode_coa'] . "', debet = '" . $rowJN['kredit'] . "', kredit = '" . $rowJN['debet'] . "', tgl_input = '" . $tgl_input . "', keterangan_hdr = '" . $rowJN['keterangan_hdr'] . "', user_pencipta = '" . $_SESSION['app_id'] . "', keterangan_dtl = '" . $rowJN['keterangan_dtl'] . "', lawan_dari_coa = '" . $rowJN['lawan_dari_coa'] . "', coa_debet_lawan = '" . $rowJN['coa_kredit_lawan'] . "', coa_kredit_lawan = '" . $rowJN['coa_debet_lawan'] . "'";
						$queryInsertJNReverse = mysqli_query($con, $insertJNReverse);
						if ($queryInsertJNReverse) {
							$checker[] = true;
							$updateJNReverse = "UPDATE jurnal SET status_jurnal = '1' WHERE kode_transaksi = '" . $dataNb['kode_nb'] . "' AND tgl_input < '" . $tgl_input . "'";
							$queryUpdateJNReverse = mysqli_query($con, $updateJNReverse);
							if ($queryUpdateJNReverse) {
								$checker[] = true;
							} else {
								$checker[] = mysqli_error($con);
							}
						} else {
							$checker[] = mysqli_error($con);
						}
					}
				}
				
				$checkerUnique = array_unique($checker);
				if (count($checkerUnique) === 1 && $checkerUnique[0]) {
					mysqli_query($con, "UPDATE nb_hdr SET status = '1', alasan_batal = '" . $alasan_batal . "', user_batal = '" . $_SESSION['app_id'] . "', tgl_batal = '" . $tgl_batal . "' WHERE kode_nb = '" . $kode_nb . "'");
					mysqli_query($con, "UPDATE nb_dtl SET status_dtl = '1' WHERE kode_nb = '" . $kode_nb . "'");
					mysqli_commit($con);
					mysqli_close($con);
					echo "00||" . $kode_nb;
				} else {
					mysqli_rollback($con);
					mysqli_close($con);
					echo "99||Gagal query : " . json_encode($checker);
				}
			} else {
				echo "99||Data Detail tidak ditemukan";
			}			
		} else {
			echo "99||Kode sudah dibatalkan atau digunakan";
		}
		
	}


?>