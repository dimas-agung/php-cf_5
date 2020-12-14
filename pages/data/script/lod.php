<?php
//require_once('ImageManipulator.php');
$q_lod = mysql_query("select * from lod_hdr where status = '0' order by Id");

if(isset($_POST['simpan'])) {
	$no_lod=mres($_POST['no_lod']);
	$no_proyek=mres($_POST['no_proyek']);
	$no_so=mres($_POST['no_so']);
	$tanggal=date("Y-m-d",strtotime($_POST['tanggal']));
	$nama_pelanggan=mres($_POST['nama_pelanggan']);
	$company=mres($_POST['company']);
	$address=mres($_POST['address']);
	$contact_person=mres($_POST['contact_person']);
	$petugas=mres($_POST['petugas']);
	$task=mres($_POST['task']);
	$start=mres($_POST['start']);
	$finish=mres($_POST['finish']);
	$note = mres($_POST['note']);
	
	$sql = "insert into lod_hrd value ('','$no_lod','$no_proyek','$no_so',
			'$tanggal','$nama_pelanggan', '$company', '$address','$contact_person', '$task','$start','$finish','$petugas','','$note','0')";
	
	$query = mysql_query ($sql) ;
	
	if ($query) {
		
		echo("<script>location.href = '".base_url()."?page=lod';</script>");
	} else { 
	   
		$response = "99||Simpan data gagal. ".mysql_error(); 
	}
	

}




// TRACK 
if(isset($_GET['action']) and $_GET['action'] == "track") {
	$id_fs = ($_GET['kode']);
	
	$q_fs_prev = mysql_query("SELECT id_fs_hdr FROM fs_hdr WHERE id_fs_hdr = (select max(id_fs_hdr) FROM fs_hdr WHERE id_fs_hdr < ".$id_fs.")");
	
	$q_fs_next = mysql_query("SELECT id_fs_hdr FROM fs_hdr WHERE id_fs_hdr = (select min(id_fs_hdr) FROM fs_hdr WHERE id_fs_hdr > ".$id_fs.")");
	
	$q_fs_hdr = mysql_query("SELECT * FROM fs_hdr WHERE id_fs_hdr = '".$id_fs."'");
	$q_fs_dtl = mysql_query("SELECT a.* FROM fs_dtl a INNER JOIN fs_hdr b on a.kd_proyek=b.kd_proyek  WHERE id_fs_hdr= '".$id_fs."'");
	
}
	
	
	
  



?>