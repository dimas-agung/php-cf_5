<?php
$q_fjasa = mysql_query("SELECT * FROM fjasa_hdr ORDER BY kd_jasa DESC");


// Ini untuk update ke database
if(isset($_GET['action']) and $_GET['action'] == "edit") {
	$kode = mres($_GET['kode']);
	$token = mres($_GET['token']);
	$id_form = mres($_GET['id_form']);
	
	$q_edit = mysql_query("SELECT * FROM fjasa_hdr WHERE kd_jasa = '".$kode."' AND token='".$token."' ");
	$q_edit_dtl = mysql_query("SELECT * FROM fjasa_dtl WHERE kd_jasa = '".$kode."' AND token='".$token."' ORDER BY description ASC");
	
	$itemjasa = "INSERT INTO fjasa_dtl_tmp (description, vol, hari, orang, unit, total, id_form)
					SELECT description, vol, hari, orang, unit, ((vol*hari*orang)*(unit)) total, '".$id_form."' id_form 
					FROM fjasa_dtl WHERE kd_jasa= '".$kode."' AND token='".$token."' ORDER BY description ASC ";										
	mysql_query($itemjasa);
			
	$query			= "SELECT * FROM fjasa_dtl_tmp WHERE id_form='".$id_form."'";
	$result			= mysql_query($query);
			
	$array = array();		
	if(mysql_num_rows($result) > 0) {
		while($res = mysql_fetch_array($result)) {

			$array[$res['id_fjasa_dtl']] = array('id' => $res['id_fjasa_dtl'], 'description' => $res['description'],'vol' => $res['vol'],'hari' => $res['hari'],'orang' => $res['orang'],'unit' => $res['unit'],'id_form' => $res['id_form'],'total' => $res['total']);
		}	
		$_SESSION['data_jasa'.$id_form.''] = $array;
	}
	
	/*if(isset($_POST['update'])) {
		    $id = $_POST['kd_jasa'];
			//$tanggal = date("Y-m-d",strtotime($_POST['tanggal']));
			$tgl_input = date("Y-m-d H:i:s");
			$mySql	= "UPDATE  fjasa_hdr SET 
						
						deskripsi	='".$_POST['deskripsi']."',
						tgl_input   ='".$tgl_input."',
						total	    ='".$_POST['grand_total']."',
						subtotal	='".$_POST['subtotal']."',
						profit10	='".$_POST['profit10']."',
						pph6		='".$_POST['pph6']."',
						tgl_input	='".$tgl_input."' WHERE kd_jasa ='".$id."' ";	
	
		   $query = mysql_query ($mySql) ;
		
		if ($query) {
		
			$id_fjasa = $_POST['id_fjasa_dtl'];
		
			foreach($id_fjasa as $key=>$val) {
				$vol= $_POST['vol'][$key];
				$hari= $_POST['hari'][$key];
				$orang= $_POST['orang'][$key];
				$unit= $_POST['unit'][$key];
				
				$sql_a = "UPDATE fjasa_dtl SET 
											vol		='".$vol."',
											hari   	='".$hari."',
											orang	='".$orang."',
											unit	='".$unit."'
											WHERE id_fjasa_dtl ='".$_POST['id_fjasa_dtl'][$key]."' ";
				$query_a = mysql_query ($sql_a) ;
			}
			
		}
	echo("<script>location.href = '".base_url()."?page=form_jasa';</script>");
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
	$id_fjasa = ($_GET['kode']);
	
	$q_fjasa_prev = mysql_query("SELECT id_fjasa_hdr FROM fjasa_hdr WHERE id_fjasa_hdr = (select max(id_fjasa_hdr) FROM fjasa_hdr WHERE id_fjasa_hdr < ".$id_fjasa.")");
	
	$q_fjasa_next = mysql_query("SELECT id_fjasa_hdr FROM fjasa_hdr WHERE id_fjasa_hdr = (select min(id_fjasa_hdr) FROM fjasa_hdr WHERE id_fjasa_hdr > ".$id_fjasa.")");
	
	$q_fjasa_hdr = mysql_query("SELECT * FROM fjasa_hdr WHERE id_fjasa_hdr = '".$id_fjasa."'");
	$q_fjasa_dtl = mysql_query("SELECT a.* FROM fjasa_dtl a INNER JOIN fjasa_hdr b on a.kd_jasa=b.kd_jasa and a.token=b.token  WHERE id_fjasa_hdr= '".$id_fjasa."'");
	
}
	
	
	
  



?>