<?php
//CLASS FORM AWAL
$class_form='class="active"';
$class_pane_form='class="tab-pane in active"';
$class_tab="";
$class_pane_tab='class="tab-pane"';

//require_once('ImageManipulator.php');
$q_lod = mysql_query("SELECT lod.*, u.nm_user teknisi FROM lod_hdr lod INNER JOIN user u ON u.kd_user=lod.petugas ORDER BY Id DESC");

if($_SESSION['app_level']=='9' ){
	$q_lod_petugas = mysql_query("SELECT lod.*, u.nm_user teknisi FROM lod_hdr lod 
INNER JOIN user u ON u.kd_user=lod.petugas WHERE petugas IN (SELECT kd_user FROM user WHERE level='8' UNION SELECT kd_user FROM user WHERE kd_user='".$_SESSION['app_id']."') ORDER BY Id DESC ");	
}else if($_SESSION['app_level']=='10'){
	$q_lod_petugas = mysql_query("SELECT lod.*, u.nm_user teknisi FROM lod_hdr lod 
INNER JOIN user u ON u.kd_user=lod.petugas WHERE petugas IN (SELECT kd_user FROM user WHERE level IN ('8','9') UNION SELECT kd_user FROM user WHERE kd_user='".$_SESSION['app_id']."') ORDER BY Id DESC ");	
}else{
	$q_lod_petugas = mysql_query("SELECT lod.*, u.nm_user teknisi FROM lod_hdr lod 
INNER JOIN user u ON u.kd_user=lod.petugas WHERE  petugas = '".$_SESSION['app_id']."' ");
}

//DDL
$q_ddl_petugas = mysql_query("SELECT * FROM user WHERE level IN ('3','4','5','8','9','10','12','13') ORDER BY nm_user ASC");
$q_ddl_no_lod = mysql_query("SELECT lod.*, u.nm_user teknisi FROM lod_hdr lod 
INNER JOIN user u ON u.kd_user=lod.petugas WHERE status='0' AND petugas = '".$_SESSION['app_id']."' ");	

if(isset($_GET['action']) and $_GET['action'] == "back"){
	//CLASS FORM SAAT KLIK TOMBOL BACK
	$class_tab='class="active"';
	$class_pane_tab='class="tab-pane in active"';
	$class_form="";
	$class_pane_form='class="tab-pane"';	
}


if(isset($_POST['simpan'])) {
	
	$no_proyek=mres($_POST['no_proyek']);
	$no_so=mres($_POST['no_so']);
	$tgl_buat=date("Y-m-d",strtotime($_POST['tanggal']));
	$nama_pelanggan=mres($_POST['nama_pelanggan']);
	$company=mres($_POST['company']);
	$address=mres($_POST['address']);
	$contact_person=mres($_POST['contact_person']);
	$petugas=mres($_POST['petugas']);
	$task=mres($_POST['task']);
	$start=mres($_POST['start']);
	$finish=mres($_POST['finish']);
	$note = mres($_POST['note']);
	$kategori = mres($_POST['kategori']);
	$tanggal=mres($_POST['tanggal']);
	$no_lod = buat_no_lod($kategori, $tanggal);
	
	$mySql	= "INSERT INTO lod_hdr SET 
						no_lod ='".$no_lod."', 
						no_proyek ='".$no_proyek."',
						no_so='".$no_so."',
						tgl_buat='".$tgl_buat."',
						nama_pelanggan='".$nama_pelanggan."',
						company='".$company."',
						address='".$address."',
						contact_person='".$contact_person."',
						task ='".$task."',
						timer_start='".$start."', 
						timer_finnis='".$finish."', 
						petugas_load='".$petugas."', 
						note='".$note."'";	
	
	$query = mysql_query ($mySql) ;
	
	if ($query) {
		
		echo("<script>location.href = '".base_url()."?page=lod2';</script>");
		
	} else { 
	   
		$response = "99||Simpan data gagal. ".mysql_error(); 
	}
}

if(isset($_POST['hitung_lembur'])) {
	$no_lod=mres($_POST['no_lod']);
	$kategori=mres($_POST['divisi']);
	$lembur_jam=mres($_POST['lembur_jam']);
	$lembur_menit=mres($_POST['lembur_menit']);
	
	//Berdasar kategori
	if($kategori=='sopir'){
		$duit_per_jam = 5000;
		$duit_per_set_jam = 2500;	
	}else{
		$duit_per_jam = 9000;
		$duit_per_set_jam = 4500;
	}
	
	//Berdasar jam
	$lembur_jm=strlen($lembur_jam);
	if($lembur_jm<2){
		$konversi_lembur_jam = '0'.$lembur_jam;	
	}else{
		$konversi_lembur_jam = $lembur_jam;	
	}
		
	$lembur = $konversi_lembur_jam.':'.$lembur_menit;
	
	//Berdasar menit
	if($lembur_menit<>'00'){
		$uang_menit = (int)$duit_per_set_jam;
	}else{
		$uang_menit = 0;
	}
	
	$uang_lembur = (int)($lembur_jam*$duit_per_jam)+($uang_menit);
		
	$mySql	= "UPDATE lod_hdr SET 
						actual_lembur ='".$lembur."',  
						uang_lembur='".$uang_lembur."'
						WHERE no_lod='".$no_lod."' ";	
	
	$query = mysql_query ($mySql) ;
	
	if ($query) {
		
		echo("<script>location.href = '".base_url()."?page=lod2';</script>");
		
	} else { 
	   
		$response = "99||Simpan data gagal. ".mysql_error(); 
	}
	
}

if(isset($_POST['cari'])) {
	
	$teknisi=mres($_POST['teknisi']);
	$tgl_awal=date("Y-m-d",strtotime($_POST['tgl_awal']));
	$tgl_akhir=date("Y-m-d",strtotime($_POST['tgl_akhir']));
	
	$q_cari = mysql_query("SELECT * FROM lod_hdr WHERE petugas = '".$teknisi."' AND tgl_buat BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."' ");
	
}

if(isset($_GET['action']) and $_GET['action'] == "jam_masuk") {
	
	$kode=$_GET['kode'];
	
    if(!empty($kode)){
        
		$sekarang = date("H:i:s");
		
		$sql = "UPDATE lod_hdr SET actual_start='".$sekarang."' WHERE no_lod ='".$kode."'";
		
		$query = mysql_query($sql) ;
		
		if ($query) {
		
			echo("<script>location.href = '".base_url()."?page=lod_petugas';</script>");
		
		} else { 
		   
			$response = "99||Simpan data gagal. ".mysql_error(); 
		}		
    }
}

if(isset($_GET['action']) and $_GET['action'] == "edit") {
	$kode = mres($_GET['kode']);
	
	$q_edit = mysql_query("SELECT * FROM lod_hdr WHERE no_lod = '".$kode."' ");

}

if(isset($_GET['action']) and $_GET['action'] == "lemburan") {
	$kode = mres($_GET['kode']);
	
	$q_lemburan = mysql_query("SELECT * FROM lod_hdr WHERE Id = '".$kode."' ");

}

if(isset($_POST['update_sopir'])) {
	$kode=$_POST['no_lod'];
	$note_petugas=$_POST['note_petugas'];
	$status_project=$_POST['status_project'];
	
	$sql = "UPDATE lod_hdr SET status_project='".$status_project."', note_petugas='".$note_petugas."' WHERE no_lod ='".$kode."'";
		
		$query = mysql_query($sql) ;
		
		if ($query) {
		
			echo("<script>location.href = '".base_url()."?page=lod_petugas';</script>");
		
		} else { 
		   
			$response = "99||Simpan data gagal. ".mysql_error(); 
	}
	
}

if(isset($_POST['update'])) {
	
	$kode=$_POST['no_lod'];
	$status_project=$_POST['status_project'];
	$note_petugas=$_POST['note_petugas'];
	
	$kegiatan1 = $_POST['kegiatan1'];
	$kegiatan2 = $_POST['kegiatan2'];
	$kegiatan3 = $_POST['kegiatan3'];
	$verifikasi = $_POST['verifikasi'];
	
	$keg1=$_FILES['foto_kegiatan1']['name'];
	$keg2=$_FILES['foto_kegiatan2']['name'];
	$keg3=$_FILES['foto_kegiatan3']['name'];
	$ver=$_FILES['foto_verifikasi']['name'];
	
	if($keg1==''){
		$file_kegiatan1 = str_replace('pic_lod_', '', $kegiatan1);
	}else{
		$file_kegiatan1 = $keg1;
	}
	
	if($keg2==''){
		$file_kegiatan2 = str_replace('pic_lod_', '', $kegiatan2);	
	}else{
		$file_kegiatan2 = $keg2;
	}
	
	if($keg3==''){
		$file_kegiatan3 = str_replace('pic_lod_', '', $kegiatan3);
	}else{
		$file_kegiatan3 = $keg3;
	}
	
	if($ver==''){
		$file_verifikasi = str_replace('pic_lod_', '', $verifikasi);
	}else{
		$file_verifikasi = $ver;
	}
	
    /*$file_kegiatan1=$_FILES['foto_kegiatan1']['name'];
	$file_kegiatan2=$_FILES['foto_kegiatan2']['name'];
	$file_kegiatan3=$_FILES['foto_kegiatan3']['name'];
	$file_verifikasi=$_FILES['foto_verifikasi']['name'];*/
	
    if(((!empty($file_kegiatan1) AND !empty($file_kegiatan2) AND !empty($file_kegiatan3)) AND !empty($file_verifikasi)) OR $status_lod=='2'){
        $direktori="upload_gambar/"; //tempat upload foto
        $name_kegiatan1='foto_kegiatan1'; //name pada input type file
		$name_kegiatan2='foto_kegiatan2'; //name pada input type file
		$name_kegiatan3='foto_kegiatan3'; //name pada input type file
		$name_verifikasi='foto_verifikasi'; //name pada input type file
        //$namaBaru='upload'.date('Y-m-d H-i-s'); //name pada input type file
		$namaBaru_kegiatan1='pic_lod_'.$file_kegiatan1;
		$namaBaru_kegiatan2='pic_lod_'.$file_kegiatan2;
		$namaBaru_kegiatan3='pic_lod_'.$file_kegiatan3;
		$namaBaru_verifikasi='pic_lod_'.$file_verifikasi;
        $quality=5; //konversi kualitas gambar dalam satuan %
		
		if($keg1<>''){
			UploadCompress($namaBaru_kegiatan1,$name_kegiatan1,$direktori,$quality);
		}
		
		if($keg2<>''){
			UploadCompress($namaBaru_kegiatan2,$name_kegiatan2,$direktori,$quality);
		}
		
		if($keg3<>''){
			UploadCompress($namaBaru_kegiatan3,$name_kegiatan3,$direktori,$quality);
		}
		
		if($ver<>''){
			UploadCompress($namaBaru_verifikasi,$name_verifikasi,$direktori,$quality); 
		}
		
		$sekarang = date("H:i:s");
		
		$sql = "UPDATE lod_hdr SET status_project='".$status_project."', foto_kegiatan1='".$namaBaru_kegiatan1."', foto_kegiatan2='".$namaBaru_kegiatan2."', foto_kegiatan3='".$namaBaru_kegiatan3."', foto_verifikasi='".$namaBaru_verifikasi."', note_petugas='".$note_petugas."' WHERE no_lod ='".$kode."'";
		
		$query = mysql_query($sql) ;
		
		if ($query) {
		
			echo("<script>location.href = '".base_url()."?page=lod_petugas';</script>");
		
		} else { 
		   
			$response = "99||Simpan data gagal. ".mysql_error(); 
		}
		
		
    }
}

if(isset($_GET['action']) and $_GET['action'] == "jam_keluar") {
	
	$kode=$_GET['kode'];
	
    if(!empty($kode)){
        
		$sekarang = date("H:i:s");
		
		$sql = "UPDATE lod_hdr SET actual_finish='".$sekarang."', status='1' WHERE no_lod ='".$kode."'";
		
		$query = mysql_query($sql) ;
		
		if ($query) {
		
			echo("<script>location.href = '".base_url()."?page=lod_petugas';</script>");
		
		} else { 
		   
			$response = "99||Simpan data gagal. ".mysql_error(); 
		}		
    }
}


// TRACK 
if(isset($_GET['action']) and $_GET['action'] == "track") {
	$id_lod = ($_GET['kode']);
	
	/*$q_fs_prev = mysql_query("SELECT id_fs_hdr FROM fs_hdr WHERE id_fs_hdr = (select max(id_fs_hdr) FROM fs_hdr WHERE id_fs_hdr < ".$id_fs.")");
	
	$q_fs_next = mysql_query("SELECT id_fs_hdr FROM fs_hdr WHERE id_fs_hdr = (select min(id_fs_hdr) FROM fs_hdr WHERE id_fs_hdr > ".$id_fs.")");*/
	
	$q_lod_hdr = mysql_query("SELECT * FROM lod_hdr WHERE Id = '".$id_lod."'");
	
}
	
	
	
  



?>