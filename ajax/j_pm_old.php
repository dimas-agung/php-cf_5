<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	require('../pages/data/script/pm.php'); 
	date_default_timezone_set("Asia/Jakarta");

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save" )
	{
		$form 			 ='PM';
		$thnblntgl 		 = date("ymd",strtotime($_POST['tgl_buat']));
		
		$ref			 	= $_POST['ref'];
		$kode_spk 		 	= $_POST['kode_spk'];
		$kode_cabang	 	= $_POST['kode_cabang'];
		$kode_gudang_asal 	= $_POST['kode_gudang_asal'];
		$kode_gudang_tujuan	= $_POST['kode_gudang_tujuan'];
		$tgl_buat 		 	= date("Y-m-d",strtotime($_POST['tgl_buat']));
		$keterangan      	= $_POST['keterangan'];
		
		$user_pencipta   = $_SESSION['app_id'];
		$tgl_input 		 = date("Y-m-d H:i:s");
		
		
		$kode_pm = buat_kode_pm($thnblntgl,$form,$kode_cabang);
		
		//HEADER PM
		$mySql	= "INSERT INTO pm_hdr SET 
						kode_pm				='".$kode_pm."',
						kode_spk			='".$kode_spk."',
						ref					='".$ref."',
						kode_cabang			='".$kode_cabang."',
						kode_gudang_asal	='".$kode_gudang_asal."',
						kode_gudang_tujuan	='".$kode_gudang_tujuan."',
						tgl_buat			='".$tgl_buat."',
						tgl_input			='".$tgl_input."',
						keterangan 			='".$keterangan."',
						user_pencipta		='".$user_pencipta."'
				 ";	
						
		$query = mysql_query ($mySql) ;
		
		//DETAIL PM
		$no_pm 			= $kode_pm;
		$kode_barang 	= $_POST['kode_barang'];
		$nama_barang	= $_POST['nama_barang'];
		$satuan 		= $_POST['satuan'];
		$qty			= $_POST['qty'];
		$qty_dikirim	= $_POST['qty_dikirim'];
		$keterangan_dtl = $_POST['keterangan_dtl'];
		$count 			= count($kode_barang);

		$mySql1 = "INSERT INTO pm_dtl (kode_pm,kode_barang,nama_barang,satuan,qty,qty_ditransfer,keterangan) VALUES ";

		for( $i=0; $i < $count; $i++ )
			{
				$mySql1 .= "('{$no_pm}','{$kode_barang[$i]}','{$nama_barang[$i]}','{$satuan[$i]}','{$qty[$i]}','{$qty_dikirim[$i]}','{$keterangan_dtl[$i]}')";
				$mySql1 .= ",";
			}
		 
		$mySql1 = rtrim($mySql1,",");
		
		$query1 = mysql_query ($mySql1) ;
		
		if ($query AND $query1) {
			echo "00||".$kode_pm;
			unset($_SESSION['data_pm']);
			
		} else { 
		   
			echo "Gagal query: ".mysql_error();
		}		 	
				
					 
	}

?>