<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	date_default_timezone_set("Asia/Jakarta");
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save" )
	{
		//Header master pelanggan
		if(isset($_POST['ppn'])){
			$ppn_stat='1';	
		}else{
			$ppn_stat='0';
		}
		
		$kode_pelanggan 	=mres($_POST['kode_pelanggan']);
		$nama 				=mres($_POST['nama']);
		$kategori_pelanggan =mres($_POST['kategori_pelanggan']);
		$alamat 			=mres($_POST['alamat']);
		$kecamatan 			=mres($_POST['kecamatan']);
		$kota 				=mres($_POST['kota']);
		$propinsi 			=mres($_POST['propinsi']);
		$negara 			=mres($_POST['negara']);
		$kontak 			=mres($_POST['kontak']);
		$telpon 			=mres($_POST['telpon']);
		$hp 				=mres($_POST['hp']);
		$email 				=mres($_POST['email']);
		$ppn 				=$ppn_stat;
		$npwp 				=mres($_POST['npwp']);
		$ktp 				=mres($_POST['ktp']);
		$salesman 			=mres($_POST['salesman']);
		$keterangan 		=mres($_POST['keterangan']);
		
		$plafon_kredit 		=mres($_POST['plafon_kredit']);
		$jatuh_tempo 		=mres($_POST['jatuh_tempo']);
		$bank 				=mres($_POST['bank']);
		$bank_an 			=mres($_POST['bank_an']);
		$bank_no_rek 		=mres($_POST['bank_no_rek']);
		$nama_penagihan 	=mres($_POST['nama_penagihan']);
		$alamat_penagihan 	=mres($_POST['alamat_penagihan']);
		$kota_penagihan 	=mres($_POST['kota_penagihan']);
		
		$coa_debet 			=mres($_POST['coa_debet']);
		$coa_kredit 		=mres($_POST['coa_kredit']);
		
		$tgl_input=date("Y-m-d H:i:s");
		
		
		$mySql	= "INSERT INTO pelanggan SET 
						kode_pelanggan		='".$kode_pelanggan."',
						nama				='".$nama."',
						kategori_pelanggan	='".$kategori_pelanggan."',
						alamat				='".$alamat."',
						kecamatan			='".$kecamatan."',
						kota				='".$kota."',
						propinsi			='".$propinsi."',
						negara				='".$negara."',
						kontak				='".$kontak."',
						telpon				='".$telpon."',
						hp					='".$hp."',
						email				='".$email."',
						PPn					='".$ppn."',
						npwp				='".$npwp."',
						ktp					='".$ktp."',
						salesman			='".$salesman."',
						keterangan			='".$keterangan."',
						
						plafon_kredit		='".$plafon_kredit."',
						jatuh_tempo			='".$jatuh_tempo."',
						bank				='".$bank."',
						bank_an				='".$bank_an."',
						bank_no_rek			='".$bank_no_rek."',
						nama_penagihan		='".$nama_penagihan."',
						alamat_penagihan	='".$alamat_penagihan."',
						kota_penagihan		='".$kota_penagihan."',
						
						coa_debet			='".$coa_debet."', 
						coa_kredit			='".$coa_kredit."',
						tgl_input			='".$tgl_input."' ";	
		
		$query = mysql_query ($mySql) ;
	
		if ($query) {
			
		} else { 
			echo "Gagal query: ".mysql_error();
		}				 
	}

?>	 
