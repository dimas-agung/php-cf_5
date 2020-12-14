<?php
$q_profil = mysql_query("SELECT * FROM pusat"); 

//JIKA EDIT
if(isset($_POST['upd_profil'])) {
		
		$_POST = array_map("strtoupper",$_POST);
		
		$kode_pusat=mres($_POST['kode_pusat']);
		$nama=mres($_POST['nama']);
		$telpon=mres($_POST['telpon']);
		$alamat=mres($_POST['alamat']);
	/*	$bank=mres($_POST['bank']);
		$ac_no=mres($_POST['ac_no']);
		$keterangan=mres($_POST['keterangan']);
		$an = mres($_POST['an']); */
					
		/*$sql = "UPDATE pusat SET nama = '".$nama."', 
			telpon = '".$telpon."',
			alamat = '".$alamat."', 
			bank = '".$bank."',
			ac_no = '".$ac_no."',
			an = '".$an."'
			where kode_pusat = '".$kode_pusat."'"; */
			
		$sql = "UPDATE pusat SET nama = '".$nama."', 
			    telpon = '".$telpon."',
			    alamat = '".$alamat."' 
			    WHERE kode_pusat = '".$kode_pusat."'";	
		
		$query = mysql_query($sql) ;
	
	if ($query) {
		
		//echo "<meta http-equiv='refresh' content='0; url=".base_url()."?module=setting/profil' />";
		$info = 'UPDATE DATA SUKSES';
		echo("<script>location.href = '".base_url()."?page=setting/profil&updatesukses&halaman= PROFIL PERUSAHAAN';</script>");
		
	} else { 
		//$warning = "Update data gagal. ".mysql_error();
		$warning = "UPDATE DATA GAGAL"; 
	}
}

?>	