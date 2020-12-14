<?php
$q_penawaran = mysql_query("select * from penawaran_hdr order by id_penawaran");
$q_ktg= mysql_query("select * from kategori order by id_kategori");

if(isset($_GET['action']) and $_GET['action'] == "link_to_penawaran") {
	$kode = mres($_GET['kode']);
	$dari = mres($_GET['dari']);
	
	if($dari=='survey'){
		$q_link = mysql_query("SELECT * from fs_hdr WHERE kd_proyek='".$kode."' ORDER BY id_fs_hdr DESC LIMIT 1 ");
	}else{
		$q_link = mysql_query("SELECT *, tbl.kode_pp kd_proyek, tbl.nama_perusahaan nama_proyek FROM (SELECT * FROM permintaan_penawaran WHERE kode_pp='".$kode."' ORDER BY id_pp DESC LIMIT 1) AS tbl ");
	}
}

// Ini untuk update ke database
if(isset($_GET['action']) and $_GET['action'] == "edit") {
	$kode = mres($_GET['kode']);
	$token = mres($_GET['token']);
	$id_form = mres($_GET['id_form']);
	
	$q_edit = mysql_query("select * from penawaran_hdr where kode_penawaran = '$kode' AND token='".$token."'");
	$judul1 = mysql_query("select jenis_barang from penawaran_dtl where urutan_jb = '1' and kode_penawaran = '$kode' group by jenis_barang");
	$judul2 = mysql_query("select jenis_barang from penawaran_dtl where urutan_jb = '2' and kode_penawaran = '$kode' group by jenis_barang");
	$judul3 = mysql_query("select jenis_barang from penawaran_dtl where urutan_jb = '3' and kode_penawaran = '$kode' group by jenis_barang");
	$q_infra = mysql_query("select * from penawaran_dtl where urutan_jb = '1' and kode_penawaran = '$kode'");
	$q_material = mysql_query("select * from penawaran_dtl where urutan_jb = '2' and kode_penawaran = '$kode'");
	$q_jasa = mysql_query("select * from penawaran_dtl where urutan_jb = '3' and kode_penawaran = '$kode'");
	
	$iteminfra = "INSERT INTO infrastructure_dtl_tmp (model_item, description_item, qty, satuan, harga, harga_hpp, profit, diskon, id_profit, id_diskon, id_form)
					SELECT model_item, description_item, qty, satuan, harga, harga_hpp, profit, diskon, id_profit, id_diskon, '".$id_form."' id_form 
					FROM penawaran_dtl WHERE kode_penawaran = '".$kode."' AND token='".$token."' AND urutan_jb='1' ORDER BY model_item ASC ";										
	mysql_query($iteminfra);
			
	$query			= "SELECT * FROM infrastructure_dtl_tmp WHERE id_form='".$id_form."'";
	$result			= mysql_query($query);
			
	$array = array();		
	if(mysql_num_rows($result) > 0) {
		while($res = mysql_fetch_array($result)) {
			$array[$res['id_penawaran_dtl']] = array('id' => $res['id_penawaran_dtl'],'model' => $res['model_item'], 'description' => $res['description_item'], 'jumlah' => $res['qty'], 'satuan' => $res['satuan'], 'harga' => $res['harga'],'profit' => $res['profit'], 'diskon' => $res['diskon'],'note' => $res['note'],'id_form' => $res['id_form'], 'id_diskon' => $res['id_diskon'],'id_profit' => $res['id_profit']);
		}	
		$_SESSION['data_infrastructure'.$id_form.''] = $array;
	}
	
	$itemmat = "INSERT INTO material_dtl_tmp (description_item, qty, satuan, harga, harga_hpp, profit, diskon, id_profit, id_diskon, id_form)
					SELECT description_item, qty, satuan, harga, harga_hpp, profit, diskon, id_profit, id_diskon, '".$id_form."' id_form 
					FROM penawaran_dtl WHERE kode_penawaran = '".$kode."' AND token='".$token."' AND urutan_jb='2' ORDER BY description_item ASC ";										
	mysql_query($itemmat);
			
	$query2			= "SELECT * FROM material_dtl_tmp WHERE id_form='".$id_form."'";
	$result2		= mysql_query($query2);
			
	$array = array();		
	if(mysql_num_rows($result2) > 0) {
		while($res2 = mysql_fetch_array($result2)) {
			$array[$res2['id_penawaran_dtl']] = array('id' => $res2['id_penawaran_dtl'], 'description' => $res2['description_item'], 'jumlah' => $res2['qty'], 'satuan' => $res2['satuan'], 'harga' => $res2['harga'],'profit' => $res2['profit'], 'diskon' => $res2['diskon'],'note' => $res2['note'],'id_form' => $res2['id_form'], 'id_diskon' => $res2['id_diskon'],'id_profit' => $res2['id_profit']);
		}	
		$_SESSION['data_material'.$id_form.''] = $array;
	}
	
	$itemjasa = "INSERT INTO jasa_dtl_tmp (description_item, qty, satuan, harga, harga_hpp, profit, diskon, id_profit, id_diskon, id_form,kd_jasa)
					SELECT description_item, qty, satuan, harga, harga_hpp, profit, diskon, id_profit, id_diskon, '".$id_form."' id_form,kd_jasa 
					FROM penawaran_dtl WHERE kode_penawaran = '".$kode."' AND token='".$token."' AND urutan_jb='3' ORDER BY description_item ASC ";										
	mysql_query($itemjasa);
			
	$query3			= "SELECT * FROM jasa_dtl_tmp WHERE id_form='".$id_form."'";
	$result3		= mysql_query($query3);
			
	$array = array();		
	if(mysql_num_rows($result3) > 0) {
		while($res3 = mysql_fetch_array($result3)) {
			$array[$res3['id_penawaran_dtl']] = array('id' => $res3['id_penawaran_dtl'], 'description' => $res3['description_item'], 'jumlah' => $res3['qty'], 'satuan' => $res3['satuan'], 'harga' => $res3['harga'],'profit' => $res3['profit'], 'diskon' => $res3['diskon'],'note' => $res3['note'],'id_form' => $res3['id_form'], 'id_diskon' => $res3['id_diskon'],'id_profit' => $res3['id_profit'],'kd_jasa' => $res3['kd_jasa']);
		}	
		$_SESSION['data_jasa'.$id_form.''] = $array;
	}
	
	/*if(isset($_POST['update'])) {
		$versi=mysql_real_escape_string($_POST['versi']);
		$dengan_hormat=mysql_real_escape_string($_POST['dengan_hormat']);
		$tanggal = date("Y-m-d",strtotime($_POST['tanggal']));
		$nama_perusahaan=mysql_real_escape_string($_POST['nama_perusahaan']);
		$up=mysql_real_escape_string($_POST['up']);
		$perihal=mysql_real_escape_string($_POST['perihal']);
		$note=mysql_real_escape_string($_POST['note']);
		
		
		/*define('LOG','log.txt');
			function write_log($log){  
			 $time = @date('[Y-d-m:H:i:s]');
			 $op=$time.' '.'Action for '.$log."\n".PHP_EOL;
			 $fp = @fopen(LOG, 'a');
			 $write = @fwrite($fp, $op);
			 @fclose($fp);
			}
        $user_posting = $_SESSION['app_user']; */

		
			
	/*	$sql = "update penawaran_hdr set versi='".$versi."', dengan_hormat='".$dengan_hormat."', tanggal = '$tanggal', kepada = '$nama_perusahaan', Up = '$up', perihal = '$perihal', note = '$note'  where kode_penawaran = '".$kode."'";
		$query1 = mysql_query ($sql) ;
	
		/*if ($query1) {
		$array = $_POST['kode_penawaran_dtl1'];
		
			foreach($array as $key=>$item) {
				$sql_a = "UPDATE penawaran_dtl SET 
				                            jenis_barang	='".$_POST['judul1'][$key]."',
											urutan_jb	    ='1',
											model_item      ='".$_POST['model_item'][$key]."',
											description_item  ='".$_POST['description'][$key]."',
											qty		    ='".$_POST['jumlah'][$key]."',
											satuan		='".$_POST['satuan'][$key]."',
											note		='".$_POST['note'][$key]."',
											harga		='".$_POST['harga'][$key]."',
											profit		='".$_POST['profit'][$key]."',
											diskon		='".$_POST['diskon'][$key]."',
											total		='".$_POST['total'][$key]."'
											where kode_penawaran ='".$_POST['kode_penawaran_dtl1'][$key]."' ";
				$query_a = mysql_query ($sql_a) ;
			}
			
		
		$array = $_POST['kode_penawaran_dtl2'];
		
			foreach($array as $key=>$item) {
				$sql_b = "UPDATE penawaran_dtl SET 
				                            jenis_barang	='".$_POST['judul2'][$key]."',
											urutan_jb	    ='2',
											description_item  ='".$_POST['description2'][$key]."',
											qty		    ='".$_POST['jumlah2'][$key]."',
											satuan		='".$_POST['satuan2'][$key]."',
											note		='".$_POST['note2'][$key]."',
											harga		='".$_POST['harga2'][$key]."',
											profit		='".$_POST['profit2'][$key]."',
											diskon		='".$_POST['diskon2'][$key]."',
											total		='".$_POST['total2'][$key]."'
											where kode_penawaran ='".$_POST['kode_penawaran_dtl2'][$key]."' ";
				$query_b = mysql_query ($sql_b) ;
			}
			
		
		$array = $_POST['kode_penawaran_dtl3'];
		
			foreach($array as $key=>$item) {
				$sql_c = "UPDATE penawaran_dtl SET 
				                            jenis_barang	='".$_POST['judul3'][$key]."',
											urutan_jb	    ='3',
											description_item  ='".$_POST['description3'][$key]."',
											qty		    ='".$_POST['jumlah3'][$key]."',
											satuan		='".$_POST['satuan3'][$key]."',
											note		='".$_POST['note3'][$key]."',
											harga		='".$_POST['harga3'][$key]."',
											profit		='".$_POST['profit3'][$key]."',
											diskon		='".$_POST['diskon3'][$key]."',
											total		='".$_POST['total3'][$key]."'
											where kode_penawaran ='".$_POST['kode_penawaran_dtl3'][$key]."' ";
				$query_c = mysql_query ($sql_c) ;
			}
			
		}*/
		
	/*	if ($query1) {
			//write_log("Update penawaran User '".$user_posting ."' Sukses");
			echo("<script>location.href = '".base_url()."?page=penawaran';</script>");
		} else {
			//write_log("Update penawaran User '".$user_posting ."' Gagal");
			$response = "99||Update data gagal. ".mysql_error();
		}
	} */
}

if(isset($_GET['action']) and $_GET['action'] == "opsi") {
	$kode = mres($_GET['kode']);
	$token = mres($_GET['token']);
	$id_form = mres($_GET['id_form']);
	$dari = mres($_GET['dari']);
	
	// mengambil nilai kode penawaran dari kode_pp
	if($dari=='survey'){
		$cmd = "SELECT DISTINCT p.kode_penawaran FROM penawaran_hdr p INNER JOIN fs_hdr s ON p.kode_pp=s.kd_proyek WHERE kode_pp='".$kode."'";
	}else{
		$cmd = "SELECT DISTINCT p.kode_penawaran FROM penawaran_hdr p INNER JOIN permintaan_penawaran pp ON p.kode_pp=pp.kode_pp WHERE p.kode_pp='".$kode."'";
	}
	
	$go = mysql_query($cmd);
	$resp = mysql_fetch_array($go);
	$kd_penawaran = $resp['kode_penawaran'];	
	
	$q_edit = mysql_query("select * from penawaran_hdr where kode_penawaran = '$kd_penawaran' AND token='".$token."'");
	$judul1 = mysql_query("select jenis_barang from penawaran_dtl where urutan_jb = '1' and kode_penawaran = '$kd_penawaran' group by jenis_barang");
	$judul2 = mysql_query("select jenis_barang from penawaran_dtl where urutan_jb = '2' and kode_penawaran = '$kd_penawaran' group by jenis_barang");
	$judul3 = mysql_query("select jenis_barang from penawaran_dtl where urutan_jb = '3' and kode_penawaran = '$kd_penawaran' group by jenis_barang");
	$q_infra = mysql_query("select * from penawaran_dtl where urutan_jb = '1' and kode_penawaran = '$kd_penawaran'");
	$q_material = mysql_query("select * from penawaran_dtl where urutan_jb = '2' and kode_penawaran = '$kd_penawaran'");
	$q_jasa = mysql_query("select * from penawaran_dtl where urutan_jb = '3' and kode_penawaran = '$kd_penawaran'");
	
	$iteminfra = "INSERT INTO infrastructure_dtl_tmp (model_item, description_item, qty, satuan, harga, harga_hpp, profit, diskon, id_profit, id_diskon, id_form)
					SELECT model_item, description_item, qty, satuan, harga, harga_hpp, profit, diskon, id_profit, id_diskon, '".$id_form."' id_form 
					FROM penawaran_dtl WHERE kode_penawaran = '".$kd_penawaran."' AND token='".$token."' AND urutan_jb='1' ORDER BY model_item ASC ";										
	mysql_query($iteminfra);
			
	$query			= "SELECT * FROM infrastructure_dtl_tmp WHERE id_form='".$id_form."'";
	$result			= mysql_query($query);
			
	$array = array();		
	if(mysql_num_rows($result) > 0) {
		while($res = mysql_fetch_array($result)) {
			$array[$res['id_penawaran_dtl']] = array('id' => $res['id_penawaran_dtl'],'model' => $res['model_item'], 'description' => $res['description_item'], 'jumlah' => $res['qty'], 'satuan' => $res['satuan'], 'harga' => $res['harga'],'profit' => $res['profit'], 'diskon' => $res['diskon'],'note' => $res['note'],'id_form' => $res['id_form'], 'id_diskon' => $res['id_diskon'],'id_profit' => $res['id_profit']);
		}	
		$_SESSION['data_infrastructure'.$id_form.''] = $array;
	}
	
	$itemmat = "INSERT INTO material_dtl_tmp (description_item, qty, satuan, harga, harga_hpp, profit, diskon, id_profit, id_diskon, id_form)
					SELECT description_item, qty, satuan, harga, harga_hpp, profit, diskon, id_profit, id_diskon, '".$id_form."' id_form 
					FROM penawaran_dtl WHERE kode_penawaran = '".$kd_penawaran."' AND token='".$token."' AND urutan_jb='2' ORDER BY description_item ASC ";										
	mysql_query($itemmat);
			
	$query2			= "SELECT * FROM material_dtl_tmp WHERE id_form='".$id_form."'";
	$result2		= mysql_query($query2);
			
	$array = array();		
	if(mysql_num_rows($result2) > 0) {
		while($res2 = mysql_fetch_array($result2)) {
			$array[$res2['id_penawaran_dtl']] = array('id' => $res2['id_penawaran_dtl'], 'description' => $res2['description_item'], 'jumlah' => $res2['qty'], 'satuan' => $res2['satuan'], 'harga' => $res2['harga'],'profit' => $res2['profit'], 'diskon' => $res2['diskon'],'note' => $res2['note'],'id_form' => $res2['id_form'], 'id_diskon' => $res2['id_diskon'],'id_profit' => $res2['id_profit']);
		}	
		$_SESSION['data_material'.$id_form.''] = $array;
	}
	
	$itemjasa = "INSERT INTO jasa_dtl_tmp (description_item, qty, satuan, harga, harga_hpp, profit, diskon, id_profit, id_diskon, id_form,kd_jasa)
					SELECT description_item, qty, satuan, harga, harga_hpp, profit, diskon, id_profit, id_diskon, '".$id_form."' id_form,kd_jasa 
					FROM penawaran_dtl WHERE kode_penawaran = '".$kd_penawaran."' AND token='".$token."' AND urutan_jb='3' ORDER BY description_item ASC ";										
	mysql_query($itemjasa);
			
	$query3			= "SELECT * FROM jasa_dtl_tmp WHERE id_form='".$id_form."'";
	$result3		= mysql_query($query3);
			
	$array = array();		
	if(mysql_num_rows($result3) > 0) {
		while($res3 = mysql_fetch_array($result3)) {
			$array[$res3['id_penawaran_dtl']] = array('id' => $res3['id_penawaran_dtl'], 'description' => $res3['description_item'], 'jumlah' => $res3['qty'], 'satuan' => $res3['satuan'], 'harga' => $res3['harga'],'profit' => $res3['profit'], 'diskon' => $res3['diskon'],'note' => $res3['note'],'id_form' => $res3['id_form'], 'id_diskon' => $res3['id_diskon'],'id_profit' => $res3['id_profit'],'kd_jasa' => $res3['kd_jasa']);
		}	
		$_SESSION['data_jasa'.$id_form.''] = $array;
	}
	
	
}


if(isset($_POST['batal_penawaran'])) {
	$kode = mres($_POST['kode_penawaran']);
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

	
	$sql = "update penawaran_hdr set status = '1', alasan_batal = '$alasan_batal' where kode_penawaran = '".$kode."'";
		$query = mysql_query ($sql) ;
		
		if ($query) {
			write_log("membatalkan penawaran User '".$user_posting ."' Sukses");
			echo("<script>location.href = '".base_url()."?page=penawaran';</script>");
		} else {
			write_log("membatalkan penawaran User '".$user_posting ."' Gagal");
			$response = "99||Update data gagal. ".mysql_error();
		}
	
	
}


// TRACK 
if(isset($_GET['action']) and $_GET['action'] == "track") {
	$id_penawaran = ($_GET['kode']);
	
	$q_penawaran_prev = mysql_query("SELECT id_penawaran FROM penawaran_hdr WHERE id_penawaran = (select max(id_penawaran) FROM penawaran_hdr WHERE id_penawaran < ".$id_penawaran.")");
	
	$q_penawaran_next = mysql_query("SELECT id_penawaran FROM penawaran_hdr WHERE id_penawaran = (select min(id_penawaran) FROM penawaran_hdr WHERE id_penawaran > ".$id_penawaran.")");
	
	$penawaran_hdr = mysql_query("SELECT pen.*,pp.kategori FROM penawaran_hdr pen INNER JOIN permintaan_penawaran pp ON pp.kode_pp=pen.kode_pp WHERE id_penawaran = '".$id_penawaran."' ORDER BY id_pp DESC LIMIT 1");
	$judul1 = mysql_query("SELECT dtl.jenis_barang FROM penawaran_hdr hdr INNER JOIN penawaran_dtl dtl on hdr.kode_penawaran=dtl.kode_penawaran where dtl.urutan_jb = '1' and hdr.id_penawaran  = '".$id_penawaran."' group by dtl.jenis_barang");
	$judul2 = mysql_query("SELECT dtl.jenis_barang FROM penawaran_hdr hdr INNER JOIN penawaran_dtl dtl on hdr.kode_penawaran=dtl.kode_penawaran where dtl.urutan_jb = '2' and hdr.id_penawaran  = '".$id_penawaran."' group by dtl.jenis_barang");
	$judul3 = mysql_query("SELECT dtl.jenis_barang FROM penawaran_hdr hdr INNER JOIN penawaran_dtl dtl on hdr.kode_penawaran=dtl.kode_penawaran where dtl.urutan_jb = '3' and hdr.id_penawaran  = '".$id_penawaran."' group by dtl.jenis_barang");
	$infrastructure = mysql_query("SELECT dtl.*,hdr.id_penawaran FROM penawaran_hdr hdr INNER JOIN penawaran_dtl dtl ON hdr.kode_penawaran=dtl.kode_penawaran AND hdr.token=dtl.token WHERE dtl.urutan_jb = '1' AND hdr.id_penawaran  = '".$id_penawaran."'");
	$material = mysql_query("SELECT dtl.*,hdr.id_penawaran FROM penawaran_hdr hdr INNER JOIN penawaran_dtl dtl ON hdr.kode_penawaran=dtl.kode_penawaran AND hdr.token=dtl.token WHERE dtl.urutan_jb = '2' AND hdr.id_penawaran = '".$id_penawaran."'");
	$jasa = mysql_query("SELECT dtl.*,hdr.id_penawaran FROM penawaran_hdr hdr INNER JOIN penawaran_dtl dtl ON hdr.kode_penawaran=dtl.kode_penawaran AND hdr.token=dtl.token WHERE dtl.urutan_jb = '3' AND hdr.id_penawaran = '".$id_penawaran."'");
	
}


?>