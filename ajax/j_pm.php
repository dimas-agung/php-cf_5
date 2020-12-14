<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	require('../pages/data/script/pm.php'); 
	date_default_timezone_set("Asia/Jakarta");
	
if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save" )
	{

		$form 			= 'PM';
		$thnblntgl 		= date("ymd",strtotime(mres($_POST['tanggal'])));
		$id_form			= mres($_POST['id_form']);
		$kode_spk	= mres($_POST['kode_spk']);
		$ref	= mres($_POST['ref']);
		$tgl_buat 		= date("Y-m-d",strtotime(mres($_POST['tanggal'])));
		$kode_cabang	= mres($_POST['kode_cabang']);
		$kode_gudang_asal	= mres($_POST['kode_gudang_a']);
		$kode_gudang_tujuan	= mres($_POST['kode_gudang_b']);
		$keterangan_hdr	= mres($_POST['keterangan']);
		$user_pencipta  	= $_SESSION['app_id'];
		$tgl_input 			= date("Y-m-d H:i:s");	
		$kd_produk = $_POST['kd_produk'];
		$kd_satuan = $_POST['kd_satuan'];
		$qty = $_POST['qty'];
		$keterangan_dtl = $_POST['keterangan_dtl'];

		$kode_pm = buat_kode_pm($thnblntgl,$form,$kode_cabang);	

		$mySql	= "INSERT INTO `pm_hdr` SET 
						`kode_pm`					='".mres($kode_pm)."',
						`ref`						='".($ref)."',
						`kode_cabang`				='".($kode_cabang)."',
						`kode_spk`				='".($kode_spk)."',
						`kode_gudang_asal`				='".($kode_gudang_asal)."',
						`kode_gudang_tujuan`				='".($kode_gudang_tujuan)."',
						`tgl_buat`				='".($tgl_buat)."',
						`keterangan_hdr`				='".($keterangan_hdr)."',
						`user_id`				='".($user_pencipta)."',
						`tgl_input`				='".($tgl_input)."'";
		$query = mysql_query ($mySql) ;		
		
		if (count($kd_produk) > 0) {
			for ($i = 0; $i < count($kd_produk); $i++) {
				$mySql1	= "INSERT INTO `pm_dtl` SET 
						`kode_pm`					='".mres($kode_pm)."',
						`kode_inventori`						='".mres($kd_produk[$i])."',
						`kode_satuan`						='".mres($kd_satuan[$i])."',
						`qty`						='".mres($qty[$i])."',
						`keterangan_dtl`						='".mres($keterangan_dtl[$i])."'";
				$query1 = mysql_query ($mySql1) ;	
			}
		} else {
			$query1 = false;
		}
		

		if ($query AND $query1) {
			$mySql2 = "UPDATE `spk_hdr` SET `to_pm` = 'yes' WHERE `kode_spk` = '".($kode_spk)."'";
			$query2 = mysql_query($mySql2);
			echo "00||".$kode_pm;

		} else { 
			echo "99||Gagal query: ".mysql_error();
		}		 	
	}