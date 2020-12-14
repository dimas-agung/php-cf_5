<?php

//CLASS FORM AWAL
$class_form='class="active"';
$class_pane_form='class="tab-pane in active"';
$class_tab="";
$class_tab1="";
$class_pane_tab='class="tab-pane"';
$class_pane_tab1='class="tab-pane"';

//cabang aktif
$q_kry_aktif = mysql_query("SELECT * FROM karyawan WHERE aktif='1'"); 

//dropdwon kategori karywn
$q_ddl_kat_kary = mysql_query("SELECT * FROM ddl_kategori_karyawan ORDER BY nama ASC"); 


// UBAH PENCARIAN BERDASAR STATUS DI db
if(isset($_POST['status'])) {
if($_POST['status']=='y'){
	$status='1';
}else if($_POST['status']=='n'){
	$status='0';
}
}

// Saat klik tombol cari
if(isset($_POST['cari'])) {
	//CLASS FORM SAAT KLIK TOMBOL CARI
	$class_tab='class="active"';
	$class_pane_tab='class="tab-pane in active"';
	$class_form="";
	$class_pane_form='class="tab-pane"';
	
	
	if(($_POST['status']=='y' OR $_POST['status']=='n')) {
		$q_kry = mysql_query("SELECT * FROM karyawan WHERE aktif='".$status."'"); 
	}else{
		$q_kry = mysql_query("SELECT * FROM karyawan");
	}
}else{
		$q_kry = mysql_query("SELECT * FROM karyawan"); 	
}


// Simpan ke database
if(isset($_POST['simpan'])) {
	
	//$_POST = array_map("strtoupper",$_POST);
	
	$sekarang = date("Y-m-d H:i:s");
	
	$kode_karyawan=mres($_POST['kode_karyawan']);
	$nama=mres($_POST['nama']);
	$alamat=mres($_POST['alamat']);
	$kelurahan=mres($_POST['kelurahan']);
	$kecamatan=mres($_POST['kecamatan']);
	$kota=mres($_POST['kota']);
	$tanda_pengenal=mres($_POST['tanda_pengenal']);
	$no_tanda_pengenal=mres($_POST['no_tanda_pengenal']);
	$no_kk=mres($_POST['no_kk']);
	$no_npwp=mres($_POST['no_npwp']);
	$bpjs_kesehatan=mres($_POST['bpjs_kesehatan']);
	$bpjs_tk=mres($_POST['bpjs_tk']);
	$ptkp=mres($_POST['ptkp']);
	$tgl_masuk=date("Y-m-d",strtotime($_POST['tanggal']));
	$tgl_resign=date("Y-m-d",strtotime($_POST['tanggal1']));
	
	$divisi=mres($_POST['divisi']);
	$jabatan=mres($_POST['jabatan']);
	$kategori=mres($_POST['kategori']);
	
	$nama_bank=mres($_POST['nama_bank']);
	$cabang=mres($_POST['cabang']);
	$atas_nama=mres($_POST['atas_nama']);
	$no_rekening=mres($_POST['no_rekening']);
	
	$foto_kary=$_FILES['foto_karyawan']['name'];
	$foto_tp=$_FILES['foto_tanda_pengenal']['name'];
	$foto_kk=$_FILES['foto_kk']['name']; 
	
	$direktori="pages/data/upload_foto_karyawan/"; //tempat upload foto
    $name_karyawan='foto_karyawan'; //name pada input type file
	$name_tp='foto_tanda_pengenal'; //name pada input type file
	$name_kk='foto_kk'; //name pada input type file 
	$namaBaru_karyawan='pic_karyawan_'.$foto_kary;
	$namaBaru_tp='pic_karyawan_'.$foto_tp;
	$namaBaru_kk='pic_karyawan_'.$foto_kk; 
	$quality=5; //konversi kualitas gambar dalam satuan %
	
	UploadCompress($namaBaru_karyawan,$name_karyawan,$direktori,$quality);
	UploadCompress($namaBaru_tp,$name_tp,$direktori,$quality);
	UploadCompress($namaBaru_kk,$name_kk,$direktori,$quality);  
	
	$sql	= "INSERT INTO karyawan SET 
						kode_karyawan 	='".$kode_karyawan."', 
						nama 			='".$nama."',
						alamat			='".$alamat."',
						kelurahan		='".$kelurahan."',
						kecamatan		='".$kecamatan."',
						kota			='".$kota."',
						tanda_pengenal	='".$tanda_pengenal."',
						no_tanda_pengenal='".$no_tanda_pengenal."',
						no_kk 			='".$no_kk."',
						no_npwp			='".$no_npwp."', 
						bpjs_kesehatan	='".$bpjs_kesehatan."',
						bpjs_tk			='".$bpjs_tk."', 
						ptkp			='".$ptkp."', 
						tgl_masuk		='".$tgl_masuk."', 
						tgl_resign		='".$tgl_resign."',
						divisi			='".$divisi."',
						jabatan			='".$jabatan."',
						kategori		='".$kategori."',
						nama_bank		='".$nama_bank."',
						cabang			='".$cabang."',
						atas_nama		='".$atas_nama."',
						no_rekening		='".$no_rekening."',
						foto_karyawan	='".$namaBaru_karyawan."',
						foto_tanda_pengenal	='".$namaBaru_tp."',
						foto_kk			='".$namaBaru_kk."',
						tgl_input		='".$sekarang."'";	
						
	$query = mysql_query ($sql) ;
	
	if ($query) {
		//echo "<meta http-equiv='refresh' content='0; url=".base_url()."?module=setting/cabang' />";
		$info = 'SIMPAN DATA SUKSES';
		echo("<script>location.href = '".base_url()."?page=master/karyawan&inputsukses';</script>");
	} else { 
		//$response = "99||Simpan data gagal. ".mysql_error(); 
		$warning = "SIMPAN DATA GAGAL"; 
	}
}

// Update ke database
if(isset($_GET['action']) and $_GET['action'] == "edit") {
	$id_karyawan = mres($_GET['id_karyawan']);
	
	$q_edit_kry = mysql_query("SELECT * FROM karyawan WHERE id_karyawan = '".$id_karyawan."'");
	
	if(isset($_POST['update'])) {
		//$_POST = array_map("strtoupper",$_POST);
		
		$nama=mres($_POST['nama']);
		$alamat=mres($_POST['alamat']);
		$kelurahan=mres($_POST['kelurahan']);
		$kecamatan=mres($_POST['kecamatan']);
		$kota=mres($_POST['kota']);
		$tanda_pengenal=mres($_POST['tanda_pengenal']);
		$no_tanda_pengenal=mres($_POST['no_tanda_pengenal']);
		$no_kk=mres($_POST['no_kk']);
		$no_npwp=mres($_POST['no_npwp']);
		$bpjs_kesehatan=mres($_POST['bpjs_kesehatan']);
		$bpjs_tk=mres($_POST['bpjs_tk']);
		$ptkp=mres($_POST['ptkp']);
		$tgl_masuk=date("Y-m-d",strtotime($_POST['tanggal']));
		$tgl_resign=date("Y-m-d",strtotime($_POST['tanggal1']));
		
		$divisi=mres($_POST['divisi']);
		$jabatan=mres($_POST['jabatan']);
		$kategori=mres($_POST['kategori']);
		
		$nama_bank=mres($_POST['nama_bank']);
		$cabang=mres($_POST['cabang']);
		$atas_nama=mres($_POST['atas_nama']);
		$no_rekening=mres($_POST['no_rekening']);
		
		$kary1 = $_POST['foto_karyawan1'];
		$tp1 = $_POST['foto_tanda_pengenal1'];
		$kk1 = $_POST['foto_kk1'];
		
		$kary=$_FILES['foto_karyawan']['name'];
		$tp=$_FILES['foto_tanda_pengenal']['name'];
		$kk=$_FILES['foto_kk']['name']; 
		
		if($kary==''){
			$foto_kary = str_replace('pic_karyawan_', '', $kary1);
		}else{
			$foto_kary = $kary;
		}
		
		if($tp==''){
			$foto_tp = str_replace('pic_karyawan_', '', $tp1);
		}else{
			$foto_tp = $tp;
		}
		
		if($kk==''){
			$foto_kk = str_replace('pic_karyawan_', '', $kk1);
		}else{
			$foto_kk = $kk;
		}
		
		$direktori="pages/data/upload_foto_karyawan/"; //tempat upload foto
		$name_karyawan='foto_karyawan'; //name pada input type file
		$name_tp='foto_tanda_pengenal'; //name pada input type file
		$name_kk='foto_kk'; //name pada input type file 
		$namaBaru_karyawan='pic_karyawan_'.$foto_kary;
		$namaBaru_tp='pic_karyawan_'.$foto_tp;
		$namaBaru_kk='pic_karyawan_'.$foto_kk; 
		$quality=5; //konversi kualitas gambar dalam satuan %
		
		if($kary<>''){
			UploadCompress($namaBaru_karyawan,$name_karyawan,$direktori,$quality);
		}
		
		if($tp<>''){
			UploadCompress($namaBaru_tp,$name_tp,$direktori,$quality);
		}
		
		if($kk<>''){
			UploadCompress($namaBaru_kk,$name_kk,$direktori,$quality);		
		}
		$sql = "UPDATE karyawan 
					SET nama 			='".$nama."',
						alamat			='".$alamat."',
						kelurahan		='".$kelurahan."',
						kecamatan		='".$kecamatan."',
						kota			='".$kota."',
						tanda_pengenal	='".$tanda_pengenal."',
						no_tanda_pengenal='".$no_tanda_pengenal."',
						no_kk 			='".$no_kk."',
						no_npwp			='".$no_npwp."', 
						bpjs_kesehatan	='".$bpjs_kesehatan."',
						bpjs_tk			='".$bpjs_tk."', 
						ptkp			='".$ptkp."', 
						tgl_masuk		='".$tgl_masuk."', 
						tgl_resign		='".$tgl_resign."',
						divisi			='".$divisi."',
						jabatan			='".$jabatan."',
						kategori		='".$kategori."',
						nama_bank		='".$nama_bank."',
						cabang			='".$cabang."',
						atas_nama		='".$atas_nama."',
						no_rekening		='".$no_rekening."',
						foto_karyawan	='".$namaBaru_karyawan."',
						foto_tanda_pengenal	='".$namaBaru_tp."',
						foto_kk			='".$namaBaru_kk."' 
						WHERE id_karyawan = '".$id_karyawan."'";
		$query = mysql_query ($sql) ;
		
		if ($query) {
			//echo "<meta http-equiv='refresh' content='0; url=".base_url()."?page=karyawan' />";
			$info = 'UPDATE DATA SUKSES';
			echo("<script>location.href = '".base_url()."?page=master/karyawan&updatesukses';</script>");
		} else {
			//$response = "99||Update data gagal. ".mysql_error();
			$warning = "UPDATE DATA GAGAL"; 
		}
	}
}

// NON AKTIF DAN AKTIFKAN STATUS
if(isset($_GET['action']) and $_GET['action'] == "nonaktif") {
	$id_karyawan = mres($_GET['id_karyawan']);
	
		$sql = "UPDATE karyawan SET aktif = '0' WHERE id_karyawan = '".$id_karyawan."'";
		$query = mysql_query ($sql) ;
		
		echo("<script>location.href = '".base_url()."?page=master/karyawan';</script>");
	
}else if(isset($_GET['action']) and $_GET['action'] == "aktif"){
	$id_karyawan = mres($_GET['id_karyawan']);
	
		$sql = "UPDATE karyawan SET aktif = '1' WHERE id_karyawan = '".$id_karyawan."'";
		$query = mysql_query ($sql) ;
		
		echo("<script>location.href = '".base_url()."?page=master/karyawan';</script>");
}

// TRACK 
if(isset($_GET['action']) and $_GET['action'] == "track") {
	$id_karyawan = ($_GET['id_karyawan']);
	
	$q_kry_prev = mysql_query("SELECT id_karyawan FROM karyawan WHERE id_karyawan = (select max(id_karyawan) FROM karyawan WHERE id_karyawan < ".$id_karyawan.")");
	
	$q_kry_next = mysql_query("SELECT id_karyawan FROM karyawan WHERE id_karyawan = (select min(id_karyawan) FROM karyawan WHERE id_karyawan > ".$id_karyawan.")");
	
	$q_kry = mysql_query("SELECT * FROM karyawan WHERE id_karyawan = '".$id_karyawan."'");
	
}



?>