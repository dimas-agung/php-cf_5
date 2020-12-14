<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	require('../pages/data/script/tg.php'); 
	date_default_timezone_set("Asia/Jakarta");

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loadgudang")
	{
		$kode_cabang = $_POST['kode_cabang'];
		
		$q_gud = mysql_query("SELECT ph.kode_gudang_asal, g.nama nama_gudang_asal FROM pm_hdr ph
								LEFT JOIN gudang g ON g.kode_gudang = ph.kode_gudang_asal
								WHERE ph.kode_cabang = '".$kode_cabang."'
								GROUP BY kode_gudang_asal 
								ORDER BY nama ASC");	
		
		$num_rows = mysql_num_rows($q_gud);
		if($num_rows>0)
		{		
			echo '<select id="gudang_asal" name="gudang_asal" class="select2">
					<option value="0">-- Pilih Gudang Asal --</option>';
					 	
                	while($rowgud = mysql_fetch_array($q_gud)){
                    
         	echo '<option value="'.$rowgud['kode_gudang_asal'].'">'.$rowgud['kode_gudang_asal'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowgud['nama_gudang_asal'].'</option>';
		 
	 				}
  
         	echo '</select>';
		}else{
			echo '<select id="gudang_asal" name="gudang_asal" class="select2" disabled>
                  	<option value="0">-- Tidak Ada Gudang--</option>
                  </select>';	
		}
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loadnamabarang" )
	{
	
		$kode_barang = $_POST['kode_barang'];
		
		$q_nm_barang = mysql_query("SELECT nama nama_barang FROM inventori WHERE kode_inventori = '".$kode_barang."'");	
		
		$num_rows = mysql_num_rows($q_nm_barang);
		if($num_rows>0)
		{		
			$rownmbarang = mysql_fetch_array($q_nm_barang);

			echo '<input class="form-control" type="text" name="nama_barang" id="nama_barang" value="'.$rownmbarang['nama_barang'].'" readonly/> ';
		}else{
			echo '<input class="form-control" type="text" name="nama_barang" id="nama_barang" value="-" readonly/>';	
		}
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loadsaldoqty" )
	{
	
		$kode_barang = $_POST['kode_barang'];
		$kode_cabang = $_POST['kode_cabang'];
		$kode_gudang = $_POST['kode_gudang'];

		$q_saldo_qty = mysql_query("SELECT saldo_qty FROM crd_stok WHERE kode_barang ='".$kode_barang."' AND kode_cabang ='".$kode_cabang."' AND kode_gudang ='".$kode_gudang."'");	
		
		$num_rows = mysql_num_rows($q_saldo_qty);
		if($num_rows>0)
		{		
			$rowsaldoqty = mysql_fetch_array($q_saldo_qty);

			echo '<input class="form-control" type="number" name="saldo_qty" id="saldo_qty" value="'.$rowsaldoqty['saldo_qty'].'" readonly/> ';
		}else{
			echo '<input class="form-control" type="number" name="saldo_qty" id="saldo_qty" value="0" readonly/>';	
		}
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loadhpp" )
	{
	
		$kode_barang = $_POST['kode_barang'];
		$kode_cabang = $_POST['kode_cabang'];
		$kode_gudang = $_POST['kode_gudang'];

		$q_hpp = mysql_query("SELECT saldo_last_hpp hpp FROM crd_stok WHERE kode_barang ='".$kode_barang."' AND kode_cabang ='".$kode_cabang."' AND kode_gudang ='".$kode_gudang."'");	
		
		$num_rows = mysql_num_rows($q_hpp);
		if($num_rows>0)
		{		
			$rowhpp = mysql_fetch_array($q_hpp);

			echo '<input class="form-control" type="number" name="hpp" id="hpp" value="'.$rowhpp['hpp'].'" readonly/> ';
		}else{
			echo '<input class="form-control" type="number" name="hpp" id="hpp" value="0" readonly/>';	
		}
	}

	if (isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "add" )
	{

		if(isset($_POST['kode_barang']) and @$_POST['kode_barang'] != ""){

			$id_form		= $_POST['id_form'];
			$itemtg 		= "INSERT INTO tg_dtl_tmp SET 
									kode_barang		='".$_POST['kode_barang']."',
									nama_barang		='".$_POST['nama_barang']."',
									saldo_qty		='".$_POST['saldo_qty']."',
									qty				='".$_POST['qty']."',
									hpp				='".$_POST['hpp']."',
									total_harga		='".$_POST['total_harga']."',
									ket_dtl 		='".$_POST['ket_dtl']."',
									id_form			='".$id_form."' ";
			mysql_query($itemtg);
			
			$query			= "SELECT * FROM tg_dtl_tmp WHERE id_form='".$id_form."'";
			$result			= mysql_query($query);
			
			$array = array();
			if(mysql_num_rows($result) > 0) {
				while ($res = mysql_fetch_array($result)) {
					
					if(!isset($_SESSION['data_tg'])) {
						$array[$res['id_tg_dtl']] = array("id" => $res['id_tg_dtl'],"kode_barang" => $res['kode_barang'], "nama_barang" => $res['nama_barang'],"saldo_qty" => $res['saldo_qty'],"qty" => $res['qty'],"hpp" => $res['hpp'],"total_harga" => $res['total_harga'],"ket_dtl" => $res['ket_dtl'], "id_form" => $res['id_form']);
					} else {
						$array = $_SESSION['data_tg'];
							$array[$res['id_tg_dtl']] = array("id" => $res['id_tg_dtl'],"kode_barang" => $res['kode_barang'], "nama_barang" => $res['nama_barang'],"saldo_qty" => $res['saldo_qty'],"qty" => $res['qty'],"hpp" => $res['hpp'],"total_harga" => $res['total_harga'],"ket_dtl" => $res['ket_dtl'], "id_form" => $res['id_form']);
					}
				   
				}
			} 
			$_SESSION['data_tg'] = $array;
			echo view_item_tg($array);
		}
	}


	function view_item_tg($data) {
		$n 				= 1;
		$total 			= 0;
		$ppn 			= 0;
		$total_ppn 		= 0;
		$total_diskon 	= 0;
		$subtot_asli 	= 0;
		$subtot_total 	= 0;
		$subtot_ppn 	= 0;
		$grand_total 	= 0;
		$html = "";
		if(count($data) > 0) {
			foreach($data as $key=>$item){

				$html .= '<tr>
							<td style=" text-align: center">'.$n++.'</td>
							<td>'.$item['kode_barang'].'</td>
							<td>'.$item['nama_barang'].'</td>
							<td style="text-align:right">'.$item['saldo_qty'].'</td>
							<td style="text-align:right">'.$item['qty'].'</td>
							<td style="text-align:right">'.$item['hpp'].'</td>	
							<td style="text-align:right">'.$item['total_harga'].'</td>
							<td>'.$item['ket_dtl'].'</td>
							<td style="text-align: center">
							<a href="javascript:;" class="label label-danger hapus-tg" title="hapus data" data-id="'.$key.'"><i class="fa fa-times"></i></a>           			
							</td>
						</tr>						
						';
				
			}
			
			$html .= "<script>$('.hapus-tg').click(function(){
						var id =	$(this).attr('data-id'); 
						var id_form = $('#id_form').val();
						$.ajax({
							type: 'POST',
							url: '".base_url()."ajax/j_tg.php?func=hapus-tg',
							data: 'idhapus=' + id + '&id_form=' +id_form,
							cache: false,
							success:function(data){
								$('#detail_input_tg').html(data).show();
							 }
						  });
					  });
				     </script>";
				
		} else {
			$html .= '<tr> <td colspan="9" class="text-center"> Tidak ada item barang. </td></tr>';
		}
		  
		return $html;
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save-link" ) 
	{
		mysqli_autocommit($con,FALSE);
			
		$form 			 ='TG';
		$thnblntgl 		 = date("ymd",strtotime($_POST['tgl_buat']));
			
		$ref			 	= $_POST['ref'];
		$kode_cabang	 	= $_POST['kode_cabang'];
		$kode_gudang_asal 	= $_POST['kode_gudang_asal'];
		$kode_gudang_tujuan	= $_POST['kode_gudang_tujuan'];
		$tgl_buat 		 	= date("Y-m-d",strtotime($_POST['tgl_buat']));
		$keterangan      	= $_POST['keterangan'];

		$user_pencipta   = $_SESSION['app_id'];
		$tgl_input 		 = date("Y-m-d H:i:s");	
			
		$kode_tg = buat_kode_tg($thnblntgl,$form,$kode_cabang);
			
		//DETAIL TG
		$no_tg 			= $kode_tg;
		$kode_barang 	= $_POST['kode_barang'];
		$nama_barang	= $_POST['nama_barang'];
		$saldo_qty1 	= $_POST['saldo_qty'];
		$qty			= $_POST['qty'];
		$hpp			= $_POST['hpp'];
		$total_harga	= $_POST['total_harga'];
		$keterangan_dtl = $_POST['keterangan_dtl'];
		$count 			= count($kode_barang);

		$mySql1 = "INSERT INTO tg_dtl (kode_tg,kode_barang,nama_barang,saldo_qty,qty,hpp,total_harga,keterangan) VALUES ";

		for( $i=0; $i < $count; $i++ )
		{

			$mySql1 .= "('{$no_tg}','{$kode_barang[$i]}','{$nama_barang[$i]}','{$saldo_qty1[$i]}','{$qty[$i]}','{$hpp[$i]}','{$total_harga[$i]}','{$keterangan_dtl[$i]}')";
			$mySql1 .= ",";

			//UNTUK CEK ITEM YANG MASUK KE STOK
			$q_cekitem = mysql_query("SELECT kode_inventori FROM inventori WHERE kode_inventori='".$kode_barang[$i]."' AND jenis_stok='1'");

			$num_rows = mysql_num_rows($q_cekitem);
			if($num_rows>0)	{

				//VARIABEL AWAL
				$qty_dtl 	= $qty[$i];
				$harga_dtl 	= $hpp[$i];
				$total_dtl 	= ceil($qty_dtl*$harga_dtl);
				$ref_untuk_crd 	= 'transfer gudang'; 
						
				/*----------------------------------- UNTUK CEK STOK SAAT OUT ------------------------------------*/
				$q_cekstok_hdr_out = mysql_query("SELECT * FROM crd_stok WHERE kode_barang='".$kode_barang[$i]."' AND kode_cabang='".$kode_cabang."' AND kode_gudang='".$kode_gudang_asal."'");	
				$num_rows_out = mysql_num_rows($q_cekstok_hdr_out);
				//JIKA ADA STOK
				if($num_rows_out>0)
				{
					$rowstok_hdr_out = mysql_fetch_array($q_cekstok_hdr_out);
							
					$kd_barang 		= $rowstok_hdr_out['kode_barang'];
					$kd_cabang 		= $rowstok_hdr_out['kode_cabang'];
					$kd_gudang 		= $rowstok_hdr_out['kode_gudang'];
					$qty_in 		= $rowstok_hdr_out['qty_in'];
					$qty_out 		= $rowstok_hdr_out['qty_out'];
					$saldo_qty 		= $rowstok_hdr_out['saldo_qty'];
					$saldo_last_hpp = $rowstok_hdr_out['saldo_last_hpp'];
					$saldo_total 	= $rowstok_hdr_out['saldo_total'];
							
					$q_masuk 		 = (int)$qty_in;
					$q_keluar 		 = (int)$qty_out+$qty_dtl;
					$saldo_q 		 = (int)$qty_in-$q_keluar;						
					$saldo_total 	 = ceil($saldo_q*$saldo_last_hpp);

					//CEK STOK SALDO TIDAK BOLEH MINUS
					if($saldo_q>0){
						//UPDATE CRD STOK
						$mySql3 = " UPDATE crd_stok SET tgl_input='".$tgl_input."', qty_out='".$q_keluar."', saldo_qty='".$saldo_q."', saldo_last_hpp='".$saldo_last_hpp."', saldo_total='".$saldo_total."' WHERE kode_barang='".$kd_barang."' AND kode_cabang='".$kd_cabang."' AND kode_gudang='".$kd_gudang."' ";
								
						$query3 = mysqli_query ($con,$mySql3) ;
								
						//INSERT CRD STOK DTL
						$mySql4	= "INSERT INTO crd_stok_dtl SET 
									kode_barang				='".$kd_barang."',
									tgl_buat				='".$tgl_buat."',
									tgl_input				='".$tgl_input."',
									kode_cabang				='".$kd_cabang."',
									kode_gudang				='".$kd_gudang."',
									qty_out					='".$qty_dtl."',
									harga_out				='".$harga_dtl."',
									total_out				='".$total_dtl."',
									ref						='".$ref_untuk_crd."',
									note					='".$ref."',
									kode_transaksi			='".$kode_tg."';
								";		
						$query4 = mysqli_query ($con,$mySql4) ;		
					}
				}

				/*----------------------------------- UNTUK CEK STOK SAAT IN ------------------------------------*/
				$q_cekstok_hdr_in = mysql_query("SELECT * FROM crd_stok WHERE kode_barang='".$kode_barang[$i]."' AND kode_cabang='".$kode_cabang."' AND kode_gudang='".$kode_gudang_tujuan."'");	
				$num_rows_in = mysql_num_rows($q_cekstok_hdr_in);
				//JIKA ADA STOK
				if($num_rows_in>0)
				{
					$rowstok_hdr_in = mysql_fetch_array($q_cekstok_hdr_in);
							
					$kd_barang 		= $rowstok_hdr_in['kode_barang'];
					$kd_cabang 		= $rowstok_hdr_in['kode_cabang'];
					$kd_gudang 		= $rowstok_hdr_in['kode_gudang'];
					$qty_in 		= $rowstok_hdr_in['qty_in'];
					$qty_out 		= $rowstok_hdr_in['qty_out'];
					$saldo_qty 		= $rowstok_hdr_in['saldo_qty'];
					$saldo_last_hpp = $rowstok_hdr_in['saldo_last_hpp'];
					$saldo_total 	= $rowstok_hdr_in['saldo_total'];
							
					$rumus_hpp = ceil($saldo_total+$total_dtl)/($saldo_qty+$qty_dtl);
							
					$q_masuk 		= (int)$qty_in+$qty_dtl;
					$q_keluar 		= (int)$qty_out;
					$saldo_q 		= (int)$q_masuk-$q_keluar;
					$saldo_last_hpp = ceil($rumus_hpp); 
					$saldo_total 	= ceil($saldo_q*$saldo_last_hpp);
							
					//UPDATE CRD STOK SAAT IN
					$mySql5 = " UPDATE crd_stok SET tgl_input='".$tgl_input."', qty_in='".$q_masuk."', saldo_qty='".$saldo_q."', saldo_last_hpp='".$saldo_last_hpp."', saldo_total='".$saldo_total."' WHERE kode_barang='".$kd_barang."' AND kode_cabang='".$kd_cabang."' AND kode_gudang='".$kd_gudang."' ";
							
					$query5 = mysqli_query ($con,$mySql5) ;
							
					//INSERT CRD STOK DTL
					$mySql6	= "INSERT INTO crd_stok_dtl SET 
								kode_barang		='".$kd_barang."',
								tgl_buat		='".$tgl_buat."',
								tgl_input		='".$tgl_input."',
								kode_cabang		='".$kd_cabang."',
								kode_gudang		='".$kd_gudang."',
								qty_in			='".$qty_dtl."',
								harga_in		='".$harga_dtl."',
								total_in		='".$total_dtl."',
								ref				='".$ref_untuk_crd."',
								note			='".$ref."',
								kode_transaksi	='".$kode_tg."';
							";	
									
					$query6 = mysqli_query ($con,$mySql6) ;		
							
				//JIKA BELUM ADA STOK
				}else{
							
					//INSERT CRD STOK 
					$mySql5	= "INSERT INTO crd_stok SET 
								kode_barang		='".$kode_barang[$i]."',
								tgl_input		='".$tgl_input."',
								kode_cabang		='".$kode_cabang."',
								kode_gudang		='".$kode_gudang_tujuan."',
								qty_in			='".$qty_dtl."',
								saldo_qty		='".$qty_dtl."',
								saldo_last_hpp	='".$harga_dtl."',
								saldo_total		='".$total_dtl."';
							";	
							
					$query5 = mysqli_query ($con,$mySql5) ;
							
					//INSERT CRD STOK DTL
					$mySql6	= "INSERT INTO crd_stok_dtl SET 
								kode_barang		='".$kode_barang[$i]."',
								tgl_buat		='".$tgl_buat."',
								tgl_input		='".$tgl_input."',
								kode_cabang		='".$kode_cabang."',
								kode_gudang		='".$kode_gudang_tujuan."',
								qty_in			='".$qty_dtl."',
								harga_in		='".$harga_dtl."',
								total_in		='".$total_dtl."',
								ref				='".$ref_untuk_crd."',
								note			='".$ref."',
								kode_transaksi	='".$kode_tg."';
							";	
											
					$query6 = mysqli_query ($con,$mySql6) ;			
							
				}
						
			}

		}
			 
		$mySql1 = rtrim($mySql1,",");	
		$query1 = mysqli_query ($con,$mySql1) ;
			
		//HEADER BTB
		$mySql	= "INSERT INTO tg_hdr SET 
					kode_tg				='".$kode_tg."',
					ref					='".$ref."',
					kode_cabang			='".$kode_cabang."',
					kode_gudang_asal	='".$kode_gudang_asal."',
					kode_gudang_tujuan	='".$kode_gudang_tujuan."',
					tgl_buat			='".$tgl_buat."',
					tgl_input			='".$tgl_input."',
					keterangan 			='".$keterangan."',
					user_pencipta		='".$user_pencipta."'
				";	
					
		$query = mysqli_query ($con,$mySql) ;
			
		if ($query AND $query1 AND $query3 AND $query4 AND $query5 AND $query6) {
				
			// Commit transaction
			mysqli_commit($con);
				
			// Close connection
			mysqli_close($con);
				
			echo "00||".$kode_tg;
			unset($_SESSION['data_tg']);
				
		} else { 

			if (!$query3) {
				echo "99||Stok Keluar Tidak Memenuhi";
			}else{
					echo "99||Query Gagal";
			}

		}
	}

if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save" ) {
	mysqli_autocommit($con,FALSE);
		
	$form 			 ='TG';
	$thnblntgl 		 = date("ymd",strtotime($_POST['tgl_buat']));
		
	$ref			 	= $_POST['ref'];
	$kode_cabang	 	= $_POST['kode_cabang'];
	$kode_gudang_asal 	= $_POST['gudang_asal'];
	$kode_gudang_tujuan	= $_POST['gudang_tujuan'];
	$tgl_buat 		 	= date("Y-m-d",strtotime($_POST['tgl_buat']));
	$keterangan      	= $_POST['keterangan'];
		
	$user_pencipta   = $_SESSION['app_id'];
	$tgl_input 		 = date("Y-m-d H:i:s");	
		
	$kode_tg = buat_kode_tg($thnblntgl,$form,$kode_cabang);
		
	$mySql1 = "INSERT INTO tg_dtl (kode_tg,kode_barang,nama_barang,saldo_qty,qty,hpp,total_harga,keterangan) VALUES ";
		
	//DETAIL TG
	$array = $_SESSION['data_tg'];
		foreach($array as $key=>$item) {
		//DETAIL TG
			$no_tg 			= $kode_tg;
			$kode_barang 	= $item['kode_barang'];
			$nama_barang	= $item['nama_barang'];
			$saldo_qty 		= $item['saldo_qty'];
			$qty			= $item['qty'];
			$hpp			= $item['hpp'];
			$total_harga	= $item['total_harga'];
			$keterangan_dtl = $item['ket_dtl'];

			$mySql1 .= "('{$no_tg}','{$kode_barang}','{$nama_barang}','{$saldo_qty}','{$qty}','{$hpp}','{$total_harga}','{$keterangan_dtl}')";
			$mySql1 .= ",";

			//UNTUK CEK ITEM YANG MASUK KE STOK
			$q_cekitem = mysql_query("SELECT kode_inventori FROM inventori WHERE kode_inventori='".$kode_barang."' AND jenis_stok='1'");

			$num_rows = mysql_num_rows($q_cekitem);
			if($num_rows>0)	{

				//VARIABEL AWAL
				$qty_dtl 	= $qty;
				$harga_dtl 	= $hpp;
				$total_dtl 	= ceil($qty_dtl*$harga_dtl);
				$ref_untuk_crd 	= 'transfer gudang'; 
					
				/*-----------------------------------
					UNTUK CEK STOK SAAT OUT
					------------------------------------*/
				$q_cekstok_hdr_out = mysql_query("SELECT * FROM crd_stok WHERE kode_barang='".$kode_barang."' AND kode_cabang='".$kode_cabang."' AND kode_gudang='".$kode_gudang_asal."'");	
				$num_rows_out = mysql_num_rows($q_cekstok_hdr_out);
					//JIKA ADA STOK
					if($num_rows_out>0)
					{
						$rowstok_hdr_out = mysql_fetch_array($q_cekstok_hdr_out);
						
						$kd_barang 		= $rowstok_hdr_out['kode_barang'];
						$kd_cabang 		= $rowstok_hdr_out['kode_cabang'];
						$kd_gudang 		= $rowstok_hdr_out['kode_gudang'];
						$qty_in 		= $rowstok_hdr_out['qty_in'];
						$qty_out 		= $rowstok_hdr_out['qty_out'];
						$saldo_qty 		= $rowstok_hdr_out['saldo_qty'];
						$saldo_last_hpp = $rowstok_hdr_out['saldo_last_hpp'];
						$saldo_total 	= $rowstok_hdr_out['saldo_total'];
						
						$q_masuk 		 = (int)$qty_in;
						$q_keluar 		 = (int)$qty_out+$qty_dtl;
						$saldo_q 		 = (int)$qty_in-$q_keluar;						
						$saldo_total 	 = ceil($saldo_q*$saldo_last_hpp);

						//CEK STOK SALDO TIDAK BOLEH MINUS
						if($saldo_q>0){
							//UPDATE CRD STOK
							$mySql3 = " UPDATE crd_stok SET tgl_input='".$tgl_input."', qty_out='".$q_keluar."', saldo_qty='".$saldo_q."', saldo_last_hpp='".$saldo_last_hpp."', saldo_total='".$saldo_total."' WHERE kode_barang='".$kd_barang."' AND kode_cabang='".$kd_cabang."' AND kode_gudang='".$kd_gudang."' ";
							
							$query3 = mysqli_query ($con,$mySql3) ;
							
							//INSERT CRD STOK DTL
							$mySql4	= "INSERT INTO crd_stok_dtl SET 
										kode_barang				='".$kd_barang."',
										tgl_buat				='".$tgl_buat."',
										tgl_input				='".$tgl_input."',
										kode_cabang				='".$kd_cabang."',
										kode_gudang				='".$kd_gudang."',
										qty_out					='".$qty_dtl."',
										harga_out				='".$harga_dtl."',
										total_out				='".$total_dtl."',
										ref						='".$ref_untuk_crd."',
										note					='".$ref."',
										kode_transaksi			='".$kode_tg."';
									";		
							$query4 = mysqli_query ($con,$mySql4) ;		
						}
						
					}

					/*----------------------------------- UNTUK CEK STOK SAAT IN ------------------------------------*/
					$q_cekstok_hdr_in = mysql_query("SELECT * FROM crd_stok WHERE kode_barang='".$kode_barang."' AND kode_cabang='".$kode_cabang."' AND kode_gudang='".$kode_gudang_tujuan."'");	
					$num_rows_in = mysql_num_rows($q_cekstok_hdr_in);
					//JIKA ADA STOK
					if($num_rows_in>0)
					{
						$rowstok_hdr_in = mysql_fetch_array($q_cekstok_hdr_in);
						
						$kd_barang 		= $rowstok_hdr_in['kode_barang'];
						$kd_cabang 		= $rowstok_hdr_in['kode_cabang'];
						$kd_gudang 		= $rowstok_hdr_in['kode_gudang'];
						$qty_in 		= $rowstok_hdr_in['qty_in'];
						$qty_out 		= $rowstok_hdr_in['qty_out'];
						$saldo_qty 		= $rowstok_hdr_in['saldo_qty'];
						$saldo_last_hpp = $rowstok_hdr_in['saldo_last_hpp'];
						$saldo_total 	= $rowstok_hdr_in['saldo_total'];
						
						$rumus_hpp = ceil($saldo_total+$total_dtl)/($saldo_qty+$qty_dtl);
						
						$q_masuk 		= (int)$qty_in+$qty_dtl;
						$q_keluar 		= (int)$qty_out;
						$saldo_q 		= (int)$q_masuk-$q_keluar;
						$saldo_last_hpp = ceil($rumus_hpp); 
						$saldo_total 	= ceil($saldo_q*$saldo_last_hpp);
						
						//UPDATE CRD STOK SAAT IN
						$mySql5 = " UPDATE crd_stok SET tgl_input='".$tgl_input."', qty_in='".$q_masuk."', saldo_qty='".$saldo_q."', saldo_last_hpp='".$saldo_last_hpp."', saldo_total='".$saldo_total."' WHERE kode_barang='".$kd_barang."' AND kode_cabang='".$kd_cabang."' AND kode_gudang='".$kd_gudang."' ";
						
						$query5 = mysqli_query ($con,$mySql5) ;
						
						//INSERT CRD STOK DTL
						$mySql6	= "INSERT INTO crd_stok_dtl SET 
									kode_barang			='".$kd_barang."',
									tgl_buat				='".$tgl_buat."',
									tgl_input				='".$tgl_input."',
									kode_cabang				='".$kd_cabang."',
									kode_gudang				='".$kd_gudang."',
									qty_in					='".$qty_dtl."',
									harga_in				='".$harga_dtl."',
									total_in				='".$total_dtl."',
									ref						='".$ref_untuk_crd."',
									note					='".$ref."',
									kode_transaksi			='".$kode_tg."';
								";	
								
						$query6 = mysqli_query ($con,$mySql6) ;		
						
					//JIKA BELUM ADA STOK
					}else{
						
						//INSERT CRD STOK 
						$mySql5	= "INSERT INTO crd_stok SET 
									kode_barang			='".$kd_barang."',
									tgl_input				='".$tgl_input."',
									kode_cabang				='".$kode_cabang."',
									kode_gudang				='".$kode_gudang_tujuan."',
									qty_in					='".$qty_dtl."',
									saldo_qty				='".$qty_dtl."',
									saldo_last_hpp			='".$harga_dtl."',
									saldo_total				='".$total_dtl."';
								";	
						
						$query5 = mysqli_query ($con,$mySql5) ;
						
						//INSERT CRD STOK DTL
						$mySql6	= "INSERT INTO crd_stok_dtl SET 
									kode_barang			='".$kd_barang."',
									tgl_buat				='".$tgl_buat."',
									tgl_input				='".$tgl_input."',
									kode_cabang				='".$kode_cabang."',
									kode_gudang				='".$kode_gudang_tujuan."',
									qty_in					='".$qty_dtl."',
									harga_in				='".$harga_dtl."',
									total_in				='".$total_dtl."',
									ref						='".$ref_untuk_crd."',
									note					='".$ref."',
									kode_transaksi			='".$kode_tg."';
								";	
										
						$query6 = mysqli_query ($con,$mySql6) ;			
						
					}
					
				}
				
			}
		 
		$mySql1 = rtrim($mySql1,",");

		$query1 = mysqli_query ($con,$mySql1) ;
		
		//HEADER BTB
		$mySql	= "INSERT INTO tg_hdr SET 
						kode_tg				='".$kode_tg."',
						ref					='".$ref."',
						kode_cabang			='".$kode_cabang."',
						kode_gudang_asal	='".$kode_gudang_asal."',
						kode_gudang_tujuan	='".$kode_gudang_tujuan."',
						tgl_buat			='".$tgl_buat."',
						tgl_input			='".$tgl_input."',
						keterangan 			='".$keterangan."',
						user_pencipta		='".$user_pencipta."'
				 ";	
				
		$query = mysqli_query ($con,$mySql) ;
		
		if ($query AND $query1 AND $query3 AND $query4 AND $query5 AND $query6) {
			
			// Commit transaction
			mysqli_commit($con);
			
			// Close connection
			mysqli_close($con);
			
			echo "00||".$kode_tg;
			unset($_SESSION['data_tg']);
			
		} else { 

			if (!$query3) {
				echo "99||Stok Keluar Tidak Memenuhi";
			}else{
				echo "99||Query Gagal";
			}

		}		 	
				
					 
	}

?>
	