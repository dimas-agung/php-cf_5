<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	date_default_timezone_set("Asia/Jakarta");
	
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "kodeaktivitas" )
	{
		$kategori=$_POST['kategori'];
		
		$q_kode_akt = mysql_query("SELECT * FROM mst_kode_aktivitas WHERE kode_header = '".$kategori."' ");	
		
		echo '<label>Aktivitas</label>
				<select class="form-control" id="kode_aktivitas" name="kode_aktivitas" required>
					<option value="0">-- Pilih --</option>';
					 	
                	while($rowakt = mysql_fetch_array($q_kode_akt)){
                     
         echo    	'<option value="'.$rowakt['kode_detail'].'" >'.$rowakt['keterangan'].'</option>';
		 
	 				}
  
         echo   '</select>';
				
					 
	}
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save_admin" )
	{
		$kategori=$_POST['kategori'];
		$kode_aktivitas = ($_POST['kode_aktivitas']);
		$no_proyek=($_POST['no_proyek']);
		$no_so=($_POST['no_so']);
		$tgl_buat=date("Y-m-d",strtotime($_POST['tanggal']));
		$pelanggan=($_POST['pelanggan']);
		$perusahaan=($_POST['perusahaan']);
		$alamat=($_POST['alamat']);
		$petugas=($_POST['petugas']);
		$task=($_POST['task']);
		$rencana_start=($_POST['start']).':00';
		$rencana_finish=($_POST['finish']).':00';
		$note_admin = ($_POST['note_admin']);
		//$note_petugas = ($_POST['note_petugas']);
		$ref=($_POST['ref']);
		$tgl_input = date("Y-m-d H:i:s");
		$no_lod = buat_no_lod($kategori, $tgl_buat);
		
			//AMBIL DETAIL KODE AKTIVITAS 
			$aktivitas = "SELECT * FROM mst_kode_aktivitas WHERE kode_header='".$kategori."' AND kode_detail='".$kode_aktivitas."'";
			$q_akt = mysql_query($aktivitas);
			$det = mysql_fetch_array($q_akt); 
			
			$keterangan_aktivitas = $det['keterangan'];
			$nominal = $det['nominal'];
	
		$mySql	= "INSERT INTO lod_hdr SET 
						no_lod					='".$no_lod."',
						kategori				='".$kategori."',
						no_proyek				='".$no_proyek."',
						no_so					='".$no_so."',
						tgl_buat				='".$tgl_buat."',
						pelanggan				='".$pelanggan."',
						perusahaan				='".$perusahaan."',
						alamat					='".$alamat."',
						task					='".$task."',
						rencana_start			='".$rencana_start."',
						rencana_finish			='".$rencana_finish."',
						petugas					='".$petugas."',
						ref						='".$ref."',
						note_admin				='".$note_admin."',
						tgl_input				='".$tgl_input."',
						create_user				='".$_SESSION['app_id']."',
						kode_aktivitas			='".$kode_aktivitas."', 
						keterangan_aktivitas	='".$keterangan_aktivitas."',
						nominal					='".$nominal."' ";	
						
		$query = mysql_query ($mySql) ;
	
		if ($query) {
			

			//echo "00|| $mySql";
			
		} else { 
		   
			echo "Gagal query: ".mysql_error();
		}		 	
				
					 
	}
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "lod_petugas" )
	{
		$kode=$_POST['no_lod'];
		
		$q_lod_petugas = mysql_query("SELECT * FROM lod_hdr WHERE no_lod = '".$kode."' ");	
		$data = mysql_fetch_array($q_lod_petugas);
		$stat='';
		$kegiatan='';
		$verifikasi='';
		$actual_start = $data['actual_start'];
		$actual_finish = $data['actual_finish'];
		$foto_kegiatan = $data['foto_kegiatan'];
		$foto_verifikasi = $data['foto_verifikasi']; 
		$note_petugas = $data['note_petugas'];
		if($actual_start=='00:00:00'){
			$stat = 'disabled';
		}
		
		if($foto_kegiatan<>''){
			$kegiatan = '<div> <img src="'.base_url().'upload_gambar/'.$foto_kegiatan.'" width="250" height="250"><p> </div>';
		}
		
		if($foto_verifikasi<>''){
			$verifikasi = '<div> <img src="'.base_url().'upload_gambar/'.$foto_verifikasi.'" width="250" height="250"><p> </div>';
		}
		
		$html =	"";
		
		$html	.='		 
					<div class="form-group col-md-12 col-sm-2 col-xs-12">
						<label>Foto Pekerjaan </label> <label style="color:#F00"> (*Format yg diperbolehkan hanya gif,jpeg dan png</label>
						'.$kegiatan.'
                        <input '.$stat.' type="file" name="foto_kegiatan" id="foto_kegiatan" accept="image/x-png,image/gif,image/jpeg">						
					</div>
					
					<div class="form-group col-md-12 col-sm-2 col-xs-12">
						<label>Foto Verifikasi </label> <label style="color:#F00"> (*Format yg diperbolehkan hanya gif,jpeg dan png</label>
						'.$verifikasi.'
						<input '.$stat.' type="file" name="foto_verifikasi"  id="foto_verifikasi" accept="image/x-png,image/gif,image/jpeg">
					</div> 
                                                                                
                    <div class="form-group col-md-12 col-sm-2 col-xs-12">
						<label>Note Petugas</label>
						<div>
						<textarea '.$stat.' rows="10" class="form-control" name="note_petugas" id="note_petugas" placeholder="Note..." >'.$data["note_petugas"].'</textarea>
						</div>  
					</div>';
		
		echo $html;				 
	}
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "tombol_lod" )
	{
		$kode=$_POST['no_lod'];
		
		$q_lod_petugas = mysql_query("SELECT * FROM lod_hdr WHERE no_lod = '".$kode."' ");	
		$data = mysql_fetch_array($q_lod_petugas);
		$tombol='';
		$actual_start = $data['actual_start'];
		$actual_finish = $data['actual_finish'];
		if($actual_start=='00:00:00'){
			$tombol = '<button class="btn-lg btn btn-success" onClick="inForm(this)" value="'.$kode.'" id="masuk"><i class="fa fa-sign-in"></i> Masuk&nbsp;</button>';	
		}else{
			$tombol = '<button class="btn-lg btn btn-danger" onClick="outForm()" value="'.$kode.'" id="keluar"><i class="fa fa-sign-out"></i> Keluar&nbsp;</button>';
		}		
		
		$html =	"";
		
		$html	.='	
					'.$tombol.'	 
					
					<a href="'.base_url().'?page=lod_petugas" class="btn-lg btn btn-warning"><i class=" fa fa-reply"></i> Batal</a>
					';
		
		echo $html;				 
	}
	
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save_start" )
	{
		
		$kode=$_POST['no_lod'];
		$sekarang = date("H:i:s");
			
			$sql = "UPDATE lod_hdr SET actual_start='".$sekarang."' WHERE no_lod ='".$kode."'";
			
			$query = mysql_query($sql) ;
			
			if ($query) {
			
				echo "00|| $sql";
				/*echo("<script>location.href = '".base_url()."?page=lod_petugas';</script>");*/
			
			} else { 
			   
				echo "Gagal query: ".mysql_error();
			}	
	}
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save_finish" )
	{
		$kode=$_POST['no_lod'];
		$note_petugas=$_POST['note_petugas'];
		$kegiatan=$_POST['kegiatan'];
		$verifikasi=$_POST['verifikasi'];
		
		$file_kegiatan=substr($kegiatan, 12); 
		$file_verifikasi=substr($verifikasi, 12); 
		
		if(!empty($file_kegiatan) OR !empty($file_verifikasi)){
			$direktori="upload_gambar/"; //tempat upload foto
			$name_kegiatan='foto_kegiatan'; //name pada input type file
			$name_verifikasi='foto_verifikasi'; //name pada input type file
			//$namaBaru='upload'.date('Y-m-d H-i-s'); //name pada input type file
			$namaBaru_kegiatan=$file_kegiatan;
			$namaBaru_verifikasi=$file_verifikasi;
			$quality=20; //konversi kualitas gambar dalam satuan %
			
			UploadCompress($namaBaru_kegiatan,$name_kegiatan,$direktori,$quality);
			UploadCompress($namaBaru_verifikasi,$name_verifikasi,$direktori,$quality); 
			
			$sekarang = date("H:i:s");
			
			$sql = "UPDATE lod_hdr SET actual_finish='".$sekarang."', foto_kegiatan='".$file_kegiatan."', foto_verifikasi='".$file_verifikasi."', note_petugas='".$note_petugas."' WHERE no_lod ='".$kode."'";
			
			$query = mysql_query($sql) ;
			
			if ($query) {
			
				echo "00|| $sql";
			
			} else { 
			   
				echo "Gagal query: ".mysql_error();
			}
		}
	}
	
	 
?>	 
