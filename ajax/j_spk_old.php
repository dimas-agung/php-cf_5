<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	require('../pages/data/script/spk.php'); 
	date_default_timezone_set("Asia/Jakarta");

if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loaditem" )
	{
		$kode_barang = $_POST['kode_barang_jadi'];
		
		$q_dtl = mysql_query("SELECT b.*, i.qty_bom qty_besar FROM bom b LEFT JOIN inventori i ON i.kode_inventori = b.kode_inventori WHERE b.kode_inventori = '".$kode_barang."' ORDER BY id_bom ASC");

		$num_rows 	= mysql_num_rows($q_dtl);
		if($num_rows>0)
		{		
			$no = 1;			 	
			while($rowdtl = mysql_fetch_array($q_dtl)){

				$barang = $rowdtl['kode_barang_dtl'];
				$pisah = explode(":", $barang);
				$kd_barang = $pisah[0];
				$nm_barang = $pisah[1];

				$satuan = $rowdtl['satuan_dtl'];
				$pisah = explode(":", $satuan);
				$kd_satuan = $pisah[0];
				$nm_satuan = $pisah[1];

				$jumlah_qty = 0;
				$jumlah_qty = $rowdtl['qty_besar']*$rowdtl['qty_dtl'];
				
				echo '<tr>
							<td style="text-align: center">'.$kd_barang.'
								<input class="form-control" type="hidden" name="kode_barang_dtl[]" id="kode_barang_dtl[]" value="'.$kd_barang.'" style="width: 7em"/>
							</td>
							<td>'.$nm_barang.' 
								<input class="form-control" type="hidden" name="nama_barang[]" id="nama_barang[]" value="'.$nm_barang.'" style="width: 7em"/>
							</td>
							<td>'.$nm_satuan.' 
								<input class="form-control" type="hidden" name="satuan_dtl[]" id="satuan_dtl[]" value="'.$kd_satuan.'" style="width: 7em"  />
							</td>
							<td>'.$rowdtl['qty_dtl'].' 
								<input class="form-control a" type="hidden" name="qty_dtl[]" id="qty_dtl[]" value="'.$rowdtl['qty_dtl'].'" style="width: 7em"  />
							</td>
							<td>
								<input class="form-control c" type="number" name="jumlah_qty[]" id="jumlah_qty[]" value="'.$jumlah_qty.'" readonly/> 
							</td>
							<td>
								<textarea  class="form-control" rows="1" name="keterangan_dtl[]" id="keterangan_dtl[]" placeholder="Keterangan...">'.$rowdtl['keterangan_dtl'].'</textarea>
							</td>
					</tr>';

			}

				echo '<tr>
							<input type="hidden" value="0" name="grand_total" id="grand_total" />
					  </tr>';
			
		}else{

			echo '<tr><td colspan="7" class="text-center">Belum ada item</td></tr>';

		}
		 				 
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save" )
	{
		$form 			 ='SP';
		$thnblntgl 		 = date("ymd",strtotime($_POST['tgl_buat']));
		
		$ref			 = ($_POST['ref']);
		$kode_cabang	 = ($_POST['kode_cabang']);
		$kode_barang	 = ($_POST['kode_barang_jadi']);
		$tgl_buat 		 = date("Y-m-d",strtotime($_POST['tgl_buat']));
		$tgl_jth_tempo 	 = date("Y-m-d",strtotime($_POST['tgl_jatuh_tempo']));
		$qty	 		 = ($_POST['jumlah']);
		$satuan		 	 = ($_POST['satuan']);
		$keterangan      = ($_POST['keterangan_hdr']);
		
		$user_pencipta   = $_SESSION['app_id'];
		$tgl_input 		 = date("Y-m-d H:i:s");
		
		
		$kode_spk = buat_kode_spk($thnblntgl,$form,$kode_cabang);
		
		//HEADER SPK
		$mySql	= "INSERT INTO spk_hdr SET 
						kode_spk				='".$kode_spk."',
						ref						='".$ref."',
						kode_cabang				='".$kode_cabang."',
						kode_barang				='".$kode_barang."',
						tgl_buat				='".$tgl_buat."',
						tgl_jth_tempo			='".$tgl_jth_tempo."',
						qty 					='".$qty."',
						satuan 					='".$satuan."',
						tgl_input				='".$tgl_input."',
						keterangan 				='".$keterangan."',
						user_pencipta			='".$user_pencipta."'
				 ";	
						
		$query = mysql_query ($mySql) ;
		
		//DETAIL SPK
		$no_spk 		= $kode_spk;
		$kode_barang_dtl= $_POST['kode_barang_dtl'];
		$nama_barang	= $_POST['nama_barang'];
		$satuan_dtl		= $_POST['satuan_dtl'];
		$qty_dtl		= $_POST['qty_dtl'];
		$total_qty		= $_POST['jumlah_qty'];
		$keterangan_dtl = $_POST['keterangan_dtl'];
		$count 			= count($kode_barang_dtl);

		$mySql1 = "INSERT INTO spk_dtl (kode_spk,kode_barang,nama_barang,satuan,qty,total_qty,keterangan) VALUES ";

		for( $i=0; $i < $count; $i++ )
			{
				$mySql1 .= "('{$no_spk}','{$kode_barang_dtl[$i]}','{$nama_barang[$i]}','{$satuan_dtl[$i]}','{$qty_dtl[$i]}','{$total_qty[$i]}','{$keterangan_dtl[$i]}')";
				$mySql1 .= ",";
			}
		 
		$mySql1 = rtrim($mySql1,",");
		
		$query1 = mysql_query ($mySql1) ;
		
		if ($query AND $query1) {
			echo "00||".$kode_spk;
			unset($_SESSION['data_spk']);
			
		} else { 
		   
			echo "Gagal query: ".mysql_error();
		}		 	
				
					 
	}

?>