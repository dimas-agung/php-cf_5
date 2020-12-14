<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	require('../pages/data/script/nk.php'); 
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
			$itemnk 		= "INSERT INTO nk_dtl_tmp SET 
											kode_coa		='".$kode_coa."',
											nama_coa		='".$nama_coa."',
											harga			='".$_POST['harga']."',
											keterangan		='".$_POST['ket_dtl']."',
											id_form			='".$id_form."' ";
			// die($itemnk);
			mysql_query($itemnk);
			
			$query			= "SELECT * FROM nk_dtl_tmp WHERE id_form='".$id_form."'";
			$result			= mysql_query($query);
			
			$array = array();
			if(mysql_num_rows($result) > 0) {
				while ($res = mysql_fetch_array($result)) {
					
					if(!isset($_SESSION['data_nk'])) {
						$array[$res['id_nk_dtl']] = array("id" => $res['id_nk_dtl'],"kode_coa" => $res['kode_coa'],"nama_coa" => $res['nama_coa'],"harga" => $res['harga'],"ppn" => $res['ppn'],"total_harga" => $res['total_harga'],"ket_dtl" => $res['keterangan'], "id_form" => $res['id_form']);
					} else {
						$array = $_SESSION['data_nk'];
						$array[$res['id_nk_dtl']] = array("id" => $res['id_nk_dtl'],"kode_coa" => $res['kode_coa'],"nama_coa" => $res['nama_coa'],"harga" => $res['harga'],"ppn" => $res['ppn'],"total_harga" => $res['total_harga'],"ket_dtl" => $res['keterangan'], "id_form" => $res['id_form']);
					}
				   
				}
			} 
			$_SESSION['data_nk'] = $array;
			echo view_item_nk($array);
		}
	}


	function view_item_nk($data) {
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
							<a href="javascript:;" class="label label-danger hapus-nk" title="hapus data" data-id="'.$key.'"><i class="fa fa-times"></i></a>           			
							</td>
						</tr>						
						';
			}
			
			$html .= "<script>$('.hapus-nk').click(function(){
						var id =	$(this).attr('data-id'); 
						var id_form = $('#id_form').val();
						$.ajax({
							type: 'POST',
							url: '".base_url()."ajax/j_nk.php?func=hapus-nk',
							data: 'idhapus=' + id + '&id_form=' +id_form,
							cache: false,
							success:function(data){
								$('#detail_input_nk').html(data).show();
							 }
						  });
					  });
				     </script>";
				
		} else {
			$html .= '<tr> <td colspan="5" class="text-center"> Tidak ada item barang. </td></tr>';
		}
		  
		return $html;
	}


	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "hapus-nk" )
	{
		$id = $_POST['idhapus'];
		$id_form = $_POST['id_form'];
		$itemdelete = "DELETE FROM nk_dtl_tmp WHERE id_nk_dtl = '".$id."'";
		mysql_query($itemdelete);
		unset($_SESSION['data_nk'][$id]);
		echo view_item_nk($_SESSION['data_nk']);
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save" )
	{
		mysqli_autocommit($con,FALSE);

		$form 			= 'NK';
		$thnklntgl 		= date("ymd",strtotime($_POST['tgl_buat']));
		
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
		
		$kode_nk = buat_kode_nk($thnklntgl,$form,$kode_cabang);
		
		//HEADER NK
		$mySql	= "INSERT INTO nk_hdr SET 
						kode_nk			='".$kode_nk."',
						ref				='".$ref."',
						kode_cabang		='".$kode_cabang."',
						kode_user		='".$kode_user."',
						nama_user		='".$nama_user."',
						tgl_buat		='".$tgl_buat."',
						tgl_jth_tempo	='".$tgl_jth_tempo."',
						tgl_input		='".$tgl_input."',
						keterangan		='".$keterangan_hdr."',
						user_pencipta	='".$user_pencipta."',
						status	='0',
						tipe = '".$user."'";	
						
		$query = mysqli_query ($con,$mySql) ;
		
		//DETAIL NK
		$total_harga1 = 0;
		$array = $_SESSION['data_nk'];
			foreach($array as $key=>$item){
					$no_nk 			= $kode_nk;
					$kode_coa		= $item['kode_coa'];
					$nama_coa		= $item['nama_coa'];
					$harga			= $item['harga'];
					$keterangan_dtl	= $item['ket_dtl'];
					
					$total_harga1 += $harga;

					$mySql1 = "INSERT INTO nk_dtl SET 
											kode_nk		='".$no_nk."',
											kode_coa 	='".$kode_coa."',
											nama_coa 	='".$nama_coa."',
											harga		='".$harga."',
											keterangan	='".$keterangan_dtl."' ";	
	
					$query1 = mysqli_query ($con,$mySql1) ;
					
					if ($user == 'pelanggan') {
						$mySql4    = "INSERT INTO `jurnal` SET
							`kode_transaksi`			='" . $no_nk . "',
							`tgl_buat`				='" . $tgl_buat . "',
							`tgl_input`				='" . $tgl_input . "',
							`kode_cabang`				='" . $kode_cabang . "',
							`kode_pelanggan`			='" . $kode_user . "',
							`keterangan_hdr`			='" . $keterangan_hdr . "',
							`ref`						='" . $ref . "',
							`kode_coa`				='" . $kode_coa . "',
							`debet`					='" . $harga . "',
							`user_pencipta`			='" . $user_pencipta . "';
						";
						$query4 = mysqli_query($con, $mySql4);
					} else {
						$mySql4    = "INSERT INTO `jurnal` SET
							`kode_transaksi`			='" . $no_nk . "',
							`tgl_buat`				='" . $tgl_buat . "',
							`tgl_input`				='" . $tgl_input . "',
							`kode_cabang`				='" . $kode_cabang . "',
							`kode_supplier`			='" . $kode_user . "',
							`keterangan_hdr`			='" . $keterangan_hdr . "',
							`ref`						='" . $ref . "',
							`kode_coa`				='" . $kode_coa . "',
							`debet`					='" . $harga . "',
							`user_pencipta`			='" . $user_pencipta . "';
						";
						$query4 = mysqli_query($con, $mySql4);
					}
		}

		if($user == 'pelanggan'){
			$mySql2	= "INSERT INTO kartu_piutang SET 
						kode_transaksi	='".$kode_nk."',
						kredit			='".$total_harga1."',
						tgl_input		='".$tgl_input."',
						kode_pelanggan	='".$kode_user."',
						tgl_buat		='".$tgl_buat."',
						tgl_jth_tempo	='".$tgl_jth_tempo."',
						kode_cabang		='".$kode_cabang."', 
						user_pencipta   ='".$user_pencipta."' ";			
		$query2 = mysqli_query ($con,$mySql2) ;
		
		$mySql3    = "INSERT INTO `jurnal` SET
							`kode_transaksi`			='" . $no_nk . "',
							`tgl_buat`				='" . $tgl_buat . "',
							`tgl_input`				='" . $tgl_input . "',
							`kode_cabang`				='" . $kode_cabang . "',
							`kode_pelanggan`			='" . $kode_user . "',
							`keterangan_hdr`			='" . $keterangan_hdr . "',
							`ref`						='" . $ref . "',
							`kode_coa`				='1.01.03.01',
							`kredit`					='" . $total_harga1 . "',
							`user_pencipta`			='" . $user_pencipta . "';
						";
						$query3 = mysqli_query($con, $mySql3);
		}elseif ($user == 'supplier') {
			$mySql2	= "INSERT INTO kartu_hutang SET 
						kode_transaksi	='".$kode_nk."',
						kredit			='".$total_harga1."',
						tgl_input		='".$tgl_input."',
						kode_supplier	='".$kode_user."',
						tgl_buat		='".$tgl_buat."',
						tgl_jth_tempo	='".$tgl_jth_tempo."',
						kode_cabang		='".$kode_cabang."', 
						user_pencipta   ='".$user_pencipta."' ";		
		$query2 = mysqli_query ($con,$mySql2) ;
		
		$mySql3    = "INSERT INTO `jurnal` SET
							`kode_transaksi`			='" . $no_nk . "',
							`tgl_buat`				='" . $tgl_buat . "',
							`tgl_input`				='" . $tgl_input . "',
							`kode_cabang`				='" . $kode_cabang . "',
							`kode_supplier`			='" . $kode_user . "',
							`keterangan_hdr`			='" . $keterangan_hdr . "',
							`ref`						='" . $ref . "',
							`kode_coa`				='2.01.02.01',
							`kredit`					='" . $total_harga1 . "',
							`user_pencipta`			='" . $user_pencipta . "';
						";
						$query3 = mysqli_query($con, $mySql3);
		}else{
			echo "Pilih Pelanggan / Supplier !!".mysql_error();
		}

		if ($query AND $query1 AND $query2) {
			mysqli_query($con,"DELETE FROM nk_dtl_tmp WHERE id_form ='".$_POST['id_form']."' ");

			// Commit transaction
			mysqli_commit($con);
			
			// Close connection
			mysqli_close($con);

			echo "00||".$kode_nk;
			unset($_SESSION['data_nk']);
			//unset($_SESSION['data_op'.$id_form .'']);
			//echo "00|| $mySql";
			
		} else { 
		   
			echo "Gagal query: ".mysql_error();
		}		 	
				
					 
	}

	if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "pembatalan") {
		mysqli_autocommit($con,FALSE);
		
		$kode_nk		= $_POST['kode_nk_batal'];
		$alasan_batal	= $_POST['alasan_batal'];
		$tgl_batal 		= date("Y-m-d");
		$tgl_input		= date("Y-m-d H:i:s");
		
		$checker = array();
		
		$cekBkk = "SELECT `deskripsi` FROM `bkk_dtl` WHERE `status_dtl` = '0' AND `deskripsi` = '".$kode_nk."'";
		$queryBkk = mysqli_query($con, $cekBkk);

		if (mysqli_num_rows($queryBkk) > 0) {
			mysqli_commit($con);
			mysqli_close($con);
			echo "Kode NK " . $kode_nk . " sudah Bukti Kas Keluar!";
			return false;
		}
		
		$cekGk = "SELECT `deskripsi` FROM `gk_dtl` WHERE `status_dtl` = '1' AND `deskripsi` = '".$kode_nk."'";
		$queryGk = mysqli_query($con, $cekGk);

		if (mysqli_num_rows($queryGk) > 0) {
			mysqli_commit($con);
			mysqli_close($con);
			echo "Kode NK " . $kode_nk . " sudah Giro Keluar!";
			return false;
		}
		
		$cekBkm = "SELECT `deskripsi` FROM `bkm_dtl` WHERE `status_dtl` = '0' AND `deskripsi` = '".$kode_nk."'";
		$queryBkm = mysqli_query($con, $cekBkm);

		if (mysqli_num_rows($queryBkm) > 0) {
			mysqli_commit($con);
			mysqli_close($con);
			echo "Kode NK " . $kode_nk . " sudah Bukti Kas Masuk!";
			return false;
		}
		
		$cekGm = "SELECT `deskripsi` FROM `gm_dtl` WHERE `status_dtl` = '1' AND `deskripsi` = '".$kode_nk."'";
		$queryGm = mysqli_query($con, $cekGm);

		if (mysqli_num_rows($queryGm) > 0) {
			mysqli_commit($con);
			mysqli_close($con);
			echo "Kode NK " . $kode_nk . " sudah Giro Masuk!";
			return false;
		}
		
		$selectNk = "SELECT * FROM nk_hdr WHERE kode_nk = '".$kode_nk."' AND status = '0'";
		$queryNk = mysqli_query($con, $selectNk);
		
		if (mysqli_num_rows($queryNk) > 0) {
			$dataNk = mysqli_fetch_array($queryNk);
			$selectNkDtl = "SELECT * FROM nk_dtl WHERE kode_nk = '".$kode_nk."' AND status_dtl = '0'";
			$queryNkDtl = mysqli_query($con, $selectNkDtl);
			
			if (mysqli_num_rows($queryNkDtl) > 0) {
				$dataNkDtl = mysqli_fetch_array($queryNkDtl);
				if ($dataNk['tipe'] == 'pelanggan') {
					$selectKHP = "SELECT * FROM kartu_piutang WHERE kode_transaksi = '" . $dataNk['kode_nk'] . "' AND status_batal = '0'";
					$queryKHP = mysqli_query($con, $selectKHP);
					if (mysqli_num_rows($queryKHP) > 0) {
						while ($rowKHP = mysqli_fetch_array($queryKHP)) {
							$insertKHPReverse = "INSERT INTO kartu_piutang SET kode_transaksi = '" . $dataNk['kode_nk'] . "', debet = '" . $rowKHP['kredit'] . "', kredit = '" . $rowKHP['debet'] . "', tgl_input = '" . $tgl_input . "', kode_pelanggan = '" . $dataNk['kode_user'] . "', tgl_buat = '" . $rowKHP['tgl_buat'] . "', tgl_jth_tempo = '" . $rowKHP['tgl_jth_tempo'] . "', kode_cabang = '" . $rowKHP['kode_cabang'] . "', user_pencipta = '" . $_SESSION['app_id'] . "', status_batal = '1', lunas = '0'";
							$queryInsertKHPReverse = mysqli_query($con, $insertKHPReverse);
							if ($queryInsertKHPReverse) {
								$checker[] = true;
								$updateKHPReverse = "UPDATE kartu_piutang SET lunas = '0' WHERE kode_transaksi = '" . $dataNK['kode_nk'] . "' AND tgl_input < '" . $tgl_input . "'";
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
					$selectKHP = "SELECT * FROM kartu_hutang WHERE kode_transaksi = '" . $dataNk['kode_nk'] . "' AND status_batal = '0'";
					$queryKHP = mysqli_query($con, $selectKHP);					
					if (mysqli_num_rows($queryKHP) > 0) {
						while ($rowKHP = mysqli_fetch_array($queryKHP)) {
							$insertKHPReverse = "INSERT INTO kartu_hutang SET kode_transaksi = '" . $dataNk['kode_nk'] . "', debet = '" . $rowKHP['kredit'] . "', kredit = '" . $rowKHP['debet'] . "', tgl_input = '" . $tgl_input . "', kode_supplier = '" . $dataNk['kode_user'] . "', tgl_buat = '" . $rowKHP['tgl_buat'] . "', tgl_jth_tempo = '" . $rowKHP['tgl_jth_tempo'] . "', kode_cabang = '" . $rowKHP['kode_cabang'] . "', user_pencipta = '" . $_SESSION['app_id'] . "', status_batal = '1', lunas = '0'";
							$queryInsertKHPReverse = mysqli_query($con, $insertKHPReverse);
							if ($queryInsertKHPReverse) {
								$checker[] = true;
								$updateKHPReverse = "UPDATE kartu_hutang SET lunas = '0' WHERE kode_transaksi = '" . $dataNK['kode_nk'] . "' AND tgl_input < '" . $tgl_input . "'";
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
				
				$selectJN = "SELECT * FROM jurnal WHERE kode_transaksi = '" . $dataNk['kode_nk'] . "' AND status_jurnal = '0'";			
				$queryJN = mysqli_query($con, $selectJN);
				if (mysqli_num_rows($queryJN) > 0) {
					while ($rowJN = mysqli_fetch_array($queryJN)) {
						$insertJNReverse = "INSERT INTO jurnal SET kode_transaksi = '" . $dataNk['kode_nk'] . "', ref = '" . $rowJN['ref'] . "', tgl_buat = '" . $rowJN['tgl_buat'] . "', kode_cabang = '" . $rowJN['kode_cabang'] . "', kode_supplier = '" . $rowJN['kode_supplier'] . "', kode_pelanggan = '" . $rowJN['kode_pelanggan'] . "', kode_coa = '" . $rowJN['kode_coa'] . "', debet = '" . $rowJN['kredit'] . "', kredit = '" . $rowJN['debet'] . "', tgl_input = '" . $tgl_input . "', keterangan_hdr = '" . $rowJN['keterangan_hdr'] . "', user_pencipta = '" . $_SESSION['app_id'] . "', keterangan_dtl = '" . $rowJN['keterangan_dtl'] . "', lawan_dari_coa = '" . $rowJN['lawan_dari_coa'] . "', coa_debet_lawan = '" . $rowJN['coa_kredit_lawan'] . "', coa_kredit_lawan = '" . $rowJN['coa_debet_lawan'] . "'";
						$queryInsertJNReverse = mysqli_query($con, $insertJNReverse);
						if ($queryInsertJNReverse) {
							$checker[] = true;
							$updateJNReverse = "UPDATE jurnal SET status_jurnal = '1' WHERE kode_transaksi = '" . $dataNk['kode_nk'] . "' AND tgl_input < '" . $tgl_input . "'";
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
					mysqli_query($con, "UPDATE nk_hdr SET status = '1', alasan_batal = '" . $alasan_batal . "', user_batal = '" . $_SESSION['app_id'] . "', tgl_batal = '" . $tgl_batal . "' WHERE kode_nk = '" . $kode_nk . "'");
					mysqli_query($con, "UPDATE nk_dtl SET status_dtl = '1' WHERE kode_nk = '" . $kode_nk . "'");
					mysqli_commit($con);
					mysqli_close($con);
					echo "00||" . $kode_nk;
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