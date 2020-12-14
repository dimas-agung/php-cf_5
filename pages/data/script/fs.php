<?php
$q_fs = mysql_query("select * from fs_hdr order by id_fs_hdr");


if(isset($_GET['action']) and $_GET['action'] == "link_to_survey") {
	$kode = mres($_GET['kode']);
	
	$q_link = mysql_query("SELECT * from permintaan_penawaran WHERE kode_pp='".$kode."' ");
	
}

// Ini untuk update ke database
if(isset($_GET['action']) and $_GET['action'] == "edit") {
	$kode = mres($_GET['kode']);
	$token = mres($_GET['token']);
	$id_form = mres($_GET['id_form']);
	
	$q_edit = mysql_query("SELECT * FROM fs_hdr WHERE kd_proyek = '$kode' AND token='".$token."'");
	//$q_edit_dtl = mysql_query("SELECT * FROM fs_dtl WHERE kd_proyek = '$kode' AND token='".$token."' ORDER BY kode_item ASC");
	
	$itemsf = "INSERT INTO fs_dtl_tmp (kode_item, lokasi, qty, satuan, id_form)
					SELECT kode_item, lokasi, qty, satuan, '".$id_form."' id_form 
					FROM fs_dtl WHERE kd_proyek = '".$kode."' AND token='".$token."' ORDER BY kode_item ASC ";										
	mysql_query($itemsf);
			
	$query			= "SELECT * FROM fs_dtl_tmp WHERE id_form='".$id_form."'";
	$result			= mysql_query($query);
			
	$array = array();		
	if(mysql_num_rows($result) > 0) {
		while($res = mysql_fetch_array($result)) {
			$array[$res['id_fs_dtl']] = array('id' => $res['id_fs_dtl'], 'kode_barang' => $res['kode_item'],'lokasi' => $res['lokasi'],'lokasi' => $res['lokasi'],'jumlah' => $res['qty'],'satuan' => $res['satuan'],'id_form' => $res['id_form']);
		}	
		$_SESSION['data_survey'] = $array;
	}
	
	/*if(isset($_POST['update'])) {
		    $id = $_POST['kd_proyek'];
			$tanggal = date("Y-m-d",strtotime($_POST['tanggal']));
			$mySql	= "UPDATE  fs_hdr SET 
						nama_proyek	='".$_POST['nama_proyek']."',
						alamat	    ='".$_POST['alamat']."',
						up	        ='".$_POST['up']."',
						jabatan	    ='".$_POST['jabatan']."',
						surveyor	='".$_POST['surveyor']."',
						keterangan	='".$_POST['keterangan']."',
						lokasi_hdr	='".$_POST['lokasi_hdr']."',
						tanggal		='".$tanggal."' WHERE kd_proyek ='".$id."' AND token='".$token."' ";	
	
		   $query = mysql_query ($mySql) ;
		
		if ($query) {
			
		//HAPUS DULU ITEM di fs_dtl_lokasi sebelumnya
		$delitemsqllokasi = "DELETE FROM fs_dtl_lokasi WHERE kd_proyek='".$id."' AND token='".$token."' ";
		mysql_query($delitemsqllokasi);	
			
		$array = $_POST['kode_item'];
		
			foreach($array as $key=>$item) {
				$kode_item= $_POST['kode_item'][$key];
				$location= $_POST['lokasi'][$key];
				$qty= $_POST['jumlah'][$key];
					
				/*--------------------------------------------------------*/
					//CEK LOKASI UDAH ADA DI fs_dtl APA BELUM?
							/*$cek_lokasi_ada = "SELECT COUNT(*) count_lokasi FROM fs_dtl WHERE lokasi='".$location."'";
								$result	= mysql_query($cek_lokasi_ada);
		
								while ($res = mysql_fetch_array($result)) {
									$lokasi_ada = $res['count_lokasi'];
										if($lokasi_ada=='0'){
											//TAMBAHKAN LOKASI DI TABLE fs_dtl_lokasi
											$tambahlokasi = "ALTER TABLE fs_dtl_lokasi ADD ".$location." INT (11) NOT NULL DEFAULT '0'";
											mysql_query($tambahlokasi);
											
											//CEK APAKAH KD_ITEM SDH ADA DI FS_DTL_LOKASI
											$cek_item_ada = "SELECT COUNT(*) count_item FROM fs_dtl_lokasi WHERE kode_item='".$kode_item."' AND kd_proyek='".$id."' ";
											$result2	= mysql_query($cek_item_ada);
											
											while ($res2 = mysql_fetch_array($result2)) {
											$item_ada = $res2['count_item'];
												
											
												if($item_ada=='0'){
													//TAMBAHKAN LOKASI DI TABLE fs_dtl_lokasi di LOKASI baru
													$itemsqllokasi = "INSERT INTO fs_dtl_lokasi SET 
																			kd_proyek 		= '".$id."',
																			kode_item 		= '".$kode_item."',
																			token			= '".$token."',
																			".$location."	= '".$qty."' ";
													mysql_query($itemsqllokasi);
												}else{
													//UPDATE lokasi_fs_dtl DI LOKASI BARU
													$itemsqllokasi = "UPDATE fs_dtl_lokasi SET 
																		".$location."	= '".$qty."' 
																		WHERE kode_item='".$kode_item."' AND kd_proyek='".$id."' AND token='".$token."' ";
													mysql_query($itemsqllokasi);														
												}
											}
											
													
										}else{
											//CEK APAKAH KD_ITEM SDH ADA DI FS_DTL_LOKASI
											$cek_item_ada = "SELECT COUNT(*) count_item FROM fs_dtl_lokasi WHERE kode_item='".$kode_item."' AND kd_proyek='".$id."' ";
											$result2	= mysql_query($cek_item_ada);
											
											while ($res2 = mysql_fetch_array($result2)) {
											$item_ada = $res2['count_item'];
												
												if($item_ada=='0'){
													$itemsqllokasi = "INSERT INTO fs_dtl_lokasi SET 
																		kd_proyek 		= '".$id."',
																		kode_item		= '".$kode_item."',
																		token			= '".$token."',
																		".$location."	= '".$qty."' ";
													mysql_query($itemsqllokasi);	
												}else{
													$itemsqllokasi = "UPDATE fs_dtl_lokasi SET 
																		".$location."	= '".$qty."' 
																		WHERE kode_item='".$kode_item."' AND kd_proyek='".$id."' AND token='".$token."' ";
													mysql_query($itemsqllokasi);	
												}
											}
											
													
										}
								}
				/*--------------------------------------------------------*/	
				
				/*$sql_a = "UPDATE fs_dtl SET 
											kode_item	='".$_POST['kode_item'][$key]."',
											lokasi      ='".$_POST['lokasi'][$key]."',
											qty		    ='".$_POST['jumlah'][$key]."',
											satuan		='".$_POST['satuan'][$key]."'
											WHERE id_fs_dtl ='".$_POST['id_fs_dtl'][$key]."' ";
				$query_a = mysql_query ($sql_a) ;
			}
			
		}
	echo("<script>location.href = '".base_url()."?page=form_survey';</script>");
	} else { 
		$response = "99||Simpan data gagal. ".mysql_error(); 
	} */
  
	
}

if(isset($_POST['batal'])) {
	$kode = mres($_POST['batal_fs']);
	$alasan_batal = mres ($_POST['alasan_batal']);
	
	define('LOG','log.txt');
			function write_log($log){  
			 $time = @date('[Y-d-m:H:i:s]');
			 $op=$time.' '.'Action for '.$log."\n".PHP_EOL;
			 $fp = @fopen(LOG, 'a');
			 $write = @fwrite($fp, $op);
			 @fclose($fp);
			}
    $user_posting = $_SESSION['app_user'];

	
	$sql = "update fs_hdr set status = '2' , alasan_batal = '$alasan_batal' where kd_proyek = '".$kode."'";
	
	if(mysql_query($sql)) {
						// Skrip Update stok
						$statusupdatesurvey = "UPDATE permintaan_penawaran SET status_blm_tdk_survey = '0' WHERE kode_pp ='".$kode."'";
						$query = mysql_query($statusupdatesurvey);
			}
	
		
		if ($query) {
			write_log("membatalkan PP User '".$user_posting ."' Sukses");
			echo("<script>location.href = '".base_url()."?page=form_survey';</script>");
		} else {
			write_log("membatalkan PP User '".$user_posting ."' Gagal");
			$response = "99||Update data gagal. ".mysql_error();
		}
	
	
}


// TRACK 
if(isset($_GET['action']) and $_GET['action'] == "track") {
	$id_fs = ($_GET['kode']);
	
	$q_fs_prev = mysql_query("SELECT id_fs_hdr FROM fs_hdr WHERE id_fs_hdr = (select max(id_fs_hdr) FROM fs_hdr WHERE id_fs_hdr < ".$id_fs.")");
	
	$q_fs_next = mysql_query("SELECT id_fs_hdr FROM fs_hdr WHERE id_fs_hdr = (select min(id_fs_hdr) FROM fs_hdr WHERE id_fs_hdr > ".$id_fs.")");
	
	$q_fs_hdr = mysql_query("SELECT fsh.*,IFNULL(p.status_app,0) status_app FROM fs_hdr fsh LEFT JOIN penawaran_hdr p ON fsh.kd_proyek=p.kode_penawaran WHERE fsh.id_fs_hdr = '".$id_fs."' ORDER BY id_penawaran DESC LIMIT 1");
	$q_fs_dtl = mysql_query("SELECT a.* FROM fs_dtl a INNER JOIN fs_hdr b on a.kd_proyek=b.kd_proyek and a.token=b.token  WHERE id_fs_hdr= '".$id_fs."'");
	
}
	
	
	
  



?>