<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	require('../pages/data/script/sm_script.php'); 
	date_default_timezone_set("Asia/Jakarta");

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loadsatuan" )
		{
			$kd_barang = ''; 

			$kode_barang = $_POST['kode_barang'];
			if(!empty($kode_barang)) {
				$pisah=explode(":",$kode_barang);
				$kd_barang=$pisah[0];
				$nm_barang=$pisah[1];
			}
			
			$q_sat = mysql_query("SELECT kode_inventori, satuan_beli FROM inventori WHERE kode_inventori = '".$kd_barang."'");	
			
			$num_rows = mysql_num_rows($q_sat);
			if($num_rows>0)
			{		
				$rowsat = mysql_fetch_array($q_sat);

				$kd_sat_beli= '';
				$nm_sat_beli= '';
				$satuan_beli= $rowsat['satuan_beli'];
				$pisah 		= explode(":",$satuan_beli);
				$kd_sat_beli= $pisah[0];
				$nm_sat_beli= $pisah[1];

				echo '<input style="text-align:center" class="form-control" type="text" name="satuan" id="satuan" value="'.$nm_sat_beli.'" readonly/>
					  <input style="text-align:center" class="form-control" type="hidden" name="kode_satuan" id="kode_satuan" value="'.$kd_sat_beli.'" readonly/>';
			}else{
				echo '<input class="form-control" type="text" name="satuan" id="satuan" value="" readonly/>';	
			}
		}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loadharga" )
		{
			$kode_cabang = $_POST['kode_cabang'];
			$kode_gudang = $_POST['kode_gudang'];

			$kd_barang = ''; 
			$kode_barang = $_POST['kode_barang'];
			if(!empty($kode_barang)) {
				$pisah=explode(":",$kode_barang);
				$kd_barang=$pisah[0];
				$nm_barang=$pisah[1];
			}
			
			$q_hrg = mysql_query("SELECT kode_barang, saldo_last_hpp harga FROM crd_stok WHERE kode_barang = '".$kd_barang."' AND kode_cabang ='".$kode_cabang."' AND kode_gudang ='".$kode_gudang."'");	
			
			$num_rows = mysql_num_rows($q_hrg);
			if($num_rows>0)
			{		
				$rowhrg = mysql_fetch_array($q_hrg);

				echo '<input style="text-align: right" class="form-control" type="text" name="harga" id="harga" value="'.$rowhrg['harga'].'"/>';
			}else{
				echo '<input style="text-align: right" class="form-control" type="text" name="harga" id="harga" value="0"/>';	
			}
		}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "add" )
	{
		if(isset($_POST['kode_barang']) and @$_POST['kode_barang'] != ""){
			
			$kode_barang = $_POST['kode_barang'];
			$id_form 	 = $_POST['id_form'];

			$qty1 = (is_numeric($_POST['qty']) ? $_POST['qty'] : "0");
			$qty1 = ($qty1 > 0 ? $qty1 : "0");

			$subtot1 = (is_numeric($_POST['subtot']) ? $_POST['subtot'] : "0");
			$subtot1 = ($subtot1 > 0 ? $subtot1 : "0");
			
			$array = array();

				if(!isset($_SESSION['data_sm'.$id_form.''])) {
					$array[$_POST['kode_barang']] = array('id_form' => $id_form , 'kode_barang' => $_POST['kode_barang'], 'kode_satuan' => $_POST['kode_satuan'], 'satuan' => $_POST['satuan'], 'harga' => $_POST['harga'], 'qty' => $_POST['qty'], 'subtot' => $_POST['subtot'],'coa_debet' => $_POST['coa_debet'],'coa_kredit' => $_POST['coa_kredit'], 'keterangan_dtl' => $_POST['keterangan_dtl']);
				} else {
					$array 	  = $_SESSION['data_sm'.$id_form.''];
					
					if( array_key_exists($_POST['kode_barang'] , $array)) {
						$array[$_POST['kode_barang']]['qty'] = ($array[$_POST['kode_barang']]['qty'] + $qty1);
						$array[$_POST['kode_barang']]['subtot'] = ($array[$_POST['kode_barang']]['subtot'] + $subtot1);
					}else{
						$array[$_POST['kode_barang'] ] = array('id_form' => $id_form , 'kode_barang' => $_POST['kode_barang'], 'kode_satuan' => $_POST['kode_satuan'], 'satuan' => $_POST['satuan'], 'harga' => $_POST['harga'], 'qty' => $_POST['qty'], 'subtot' => $_POST['subtot'],'coa_debet' => $_POST['coa_debet'],'coa_kredit' => $_POST['coa_kredit'], 'keterangan_dtl' => $_POST['keterangan_dtl']);
					}
				}

			$_SESSION['data_sm'.$id_form.''] = $array;
			echo view_item_sm($array);
		}
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "hapus-sm" )
	{
		$id 	 = $_POST['idhapus'];
		$id_form = $_POST['id_form'];
		unset($_SESSION['data_sm'.$id_form.''][$id]);
		echo view_item_sm($_SESSION['data_sm'.$id_form.'']);
	}
	
	function view_item_sm($data) {
		$n = 1;
		$html = "";
		
		$grandtotal = 1;

		if(count($data) > 0) {
			foreach($data as $key=>$item){

				$kd_barang 	= '';
				$nm_barang 	= '';
				$kode_barang = $item['kode_barang'];
					if(!empty($kode_barang)) {
						$pisah=explode(":",$kode_barang);
						$kd_barang=$pisah[0];
						$nm_barang=$pisah[1];
					}

				$kd_coa_debet 	 = '';
				$nm_coa_debet 	 = '';
				$coa_debet = $item['coa_debet'];
					if(!empty($coa_debet)) {
						$pisah=explode(":",$coa_debet);
						$kd_coa_debet=$pisah[0];
						$nm_coa_debet=$pisah[1];
					}

				$kd_coa_kredit 	 = '';
				$nm_coa_kredit 	 = '';
				$coa_kredit = $item['coa_kredit'];
					if(!empty($coa_kredit)) {
						$pisah=explode(":",$coa_kredit);
						$kd_coa_kredit=$pisah[0];
						$nm_coa_kredit=$pisah[1];
					}

				$html .= '<tr>
							<td style="text-align: center">'.$n++.'</td>
							<td>'.$kd_barang.'&nbsp;&nbsp;||&nbsp;&nbsp;'.$nm_barang.'
								<input class="form-control" type="hidden" name="kode_barang[]" id="kode_barang[]" value="'.$item['kode_barang'].'"/>
							</td>
							<td style="text-align: center">'.$item['satuan'].'
								<input class="form-control" type="hidden" name="kode_satuan[]" id="kode_satuan[]" value="'.$item['kode_satuan'].':'.$item['satuan'].'"/>
							</td>
							<td style="text-align: right">'.number_format($item['harga'], 2).'
								<input class="form-control" type="hidden" name="harga[]" id="harga[]" value="'.$item['harga'].'">
							</td>
							<td style="text-align: right">'.number_format($item['qty'], 2).'
								<input class="form-control" type="hidden" name="qty[]" id="qty[]" value="'.$item['qty'].'">
							</td>
							<td style="text-align: right">'.number_format($item['subtot'], 2).'
								<input class="form-control" type="hidden" name="subtot[]" id="subtot[]" value="'.$item['subtot'].'">
							</td>
							<td>'.$kd_coa_debet.'&nbsp;&nbsp;||&nbsp;&nbsp;'.$nm_coa_debet.'
								<input class="form-control" type="hidden" name="coa_debet[]" id="coa_debet[]" value="'.$coa_debet.'">
							</td>
							<td>'.$kd_coa_kredit.'&nbsp;&nbsp;||&nbsp;&nbsp;'.$nm_coa_kredit.'
								<input class="form-control" type="hidden" name="coa_kredit[]" id="coa_kredit[]" value="'.$coa_kredit.'">
							</td>
							<td>'.$item['keterangan_dtl'].'
								<input class="form-control" type="hidden" name="keterangan_dtl[]" id="keterangan_dtl[]" value="'.$item['keterangan_dtl'].'">
							</td>
							<td style="text-align: center">
								<a href="javascript:;" class="label label-danger hapus-cart-sm"  data-id="'.$key.'"><i class="fa fa-times"></i></a>
								<input type="hidden" name="id_form" id="id_form" value="'.$item['id_form'].'"/> 
			                </td>
						</tr>';

				$html .= "<script>$('.hapus-cart-sm').click(function(){
							var id 		= $(this).attr('data-id'); 
							var id_form = $('#id_form').val();	
							$.ajax({
								type: 'POST',
								url: '".base_url()."ajax/j_sm.php?func=hapus-sm',
								data: 'idhapus=' + id +'&id_form='+id_form,
								cache: false,
								success:function(data){
									$('#detail_input_sm').html(data).show();
								}
							});
						});
					  </script>";
			} 
		}else{
			$html .= '<tr> <td colspan="10" class="text-center"> Tidak ada item barang. </td></tr>';
		}

		return $html;
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save" )
	{
		// Set autocommit to off
		mysqli_autocommit($con,FALSE);

		$form 			= 'SM';
		$thnblntgl 		= date("ymd",strtotime($_POST['tgl_buat']));
		
		$ref 			= ($_POST['ref']);
		$kode_cabang 	= ($_POST['kode_cabang']);
		$kode_gudang 	= ($_POST['kode_gudang']);
		$keterangan_hdr = ($_POST['keterangan_hdr']);
		$tgl_buat 		= date("Y-m-d",strtotime($_POST['tgl_buat']));
		
		$user_pencipta  = $_SESSION['app_id'];
		$tgl_input 		= date("Y-m-d H:i:s");
		
		$kode_sm 		= buat_kode_sm($thnblntgl,$form,$kode_cabang);
		
		//DETAIL SM
		$no_sm			= $kode_sm;
		$kode_barang	= $_POST['kode_barang'];
		$satuan			= $_POST['kode_satuan'];
		$harga			= $_POST['harga'];
		$qty_sm			= $_POST['qty'];
		$total_harga	= $_POST['subtot'];
		$coa_debet		= $_POST['coa_debet'];
		$coa_kredit		= $_POST['coa_kredit'];
		$keterangan_dtl	= $_POST['keterangan_dtl'];
		$count 			= count($kode_barang);

		$total_harga_jurnal = 0;

		$mySql1   	= "INSERT INTO `sm_dtl` (`kode_sm`,`kode_barang`,`satuan`,`harga`,`qty_sm`,`total_harga`,`coa_debet`,`coa_kredit`,`keterangan_dtl`) VALUES ";
		 
			for($i=0; $i < $count; $i++)
			{
				$pisah 		 = explode(":",$kode_barang[$i]);
				$kd_barang 	 = $pisah[0];

				$pisah1 	 	= explode(":",$coa_debet[$i]);
				$kd_coa_debet	= $pisah1[0];

				$pisah2 	 	= explode(":",$coa_kredit[$i]);
				$kd_coa_kredit	= $pisah2[0];
				
				$mySql1 .= "(
					'" . $no_sm . "',
					'" . $kode_barang[$i] . "',
					'" . $satuan[$i] . "',
					'" . str_replace(',', null, $harga[$i]) . "',
					'" . str_replace(',', null, $qty_sm[$i]) . "',
					'" . str_replace(',', null, $total_harga[$i]) . "',
					'" . $coa_debet[$i] . "',
					'" . $coa_kredit[$i] . "',
					'" . $keterangan_dtl[$i] . "'
				)";
				$mySql1 .= ",";

				$total_harga_jurnal = str_replace(',', null, $total_harga[$i]);

				//INSERT JURNAL DEBET
				$mySql2	= "INSERT INTO `jurnal` SET 
							`kode_transaksi`			='".$kode_sm."',
							`tgl_buat`				='".$tgl_buat."',
							`tgl_input`				='".$tgl_input."',
							`kode_cabang`				='".$kode_cabang."',
							`keterangan_hdr`			='".$keterangan_hdr."',
							`ref`						='".$ref."',
							`kode_coa`				='".$kd_coa_debet."',
							`debet`					='".$total_harga_jurnal."',
							`user_pencipta`			='".$user_pencipta."';
						";								
				$query2 = mysqli_query ($con,$mySql2) ;	
				
				//INSERT JURNAL KREDIT
				$mySql3	= "INSERT INTO `jurnal` SET 
							`kode_transaksi`			='".$kode_sm."',
							`tgl_buat`				='".$tgl_buat."',
							`tgl_input`				='".$tgl_input."',
							`kode_cabang`				='".$kode_cabang."',
							`keterangan_hdr`			='".$keterangan_hdr."',
							`ref`						='".$ref."',
							`kode_coa`				='".$kd_coa_kredit."',
							`kredit`					='".$total_harga_jurnal."',
							`user_pencipta`			='".$user_pencipta."';
						";							
				$query3 = mysqli_query ($con,$mySql3) ;
				
				//UNTUK CEK ITEM YANG MASUK KE STOK
				$q_cekitem = mysql_query("SELECT kode_inventori FROM inventori WHERE kode_inventori='".$kd_barang."' AND jenis_stok='1'");
				
				$num_rows = mysql_num_rows($q_cekitem);
				if($num_rows>0)
				{
					//VARIABEL AWAL 
					$qty_in_dtl 	= str_replace(',', null, $qty_sm[$i]);
					$harga_in_dtl 	= str_replace(',', null, $harga[$i]);
					$total_in_dtl 	= str_replace(',', null, $total_harga[$i]);
					$ref_untuk_crd 	= 'stok masuk'; 
					
					//UNTUK CEK STOK
					$q_cekstok_hdr = mysql_query("SELECT * FROM crd_stok WHERE kode_barang='".$kd_barang."' AND kode_cabang='".$kode_cabang."' AND kode_gudang='".$kode_gudang."'");	
					$num_rows1 = mysql_num_rows($q_cekstok_hdr);
					//JIKA ADA STOK
					if($num_rows1>0)
					{
						$rowstok_hdr = mysql_fetch_array($q_cekstok_hdr);
						
						$kd_barang 		= $rowstok_hdr['kode_barang'];
						$kd_cabang 		= $rowstok_hdr['kode_cabang'];
						$kd_gudang 		= $rowstok_hdr['kode_gudang'];
						$qty_in 		= $rowstok_hdr['qty_in'];
						$qty_out 		= $rowstok_hdr['qty_out'];
						$saldo_qty 		= $rowstok_hdr['saldo_qty'];
						$saldo_last_hpp = $rowstok_hdr['saldo_last_hpp'];
						$saldo_total 	= $rowstok_hdr['saldo_total'];
						
						$rumus_hpp 		= ceil($saldo_total+$total_in_dtl)/($saldo_qty+$qty_in_dtl);
						
						$q_masuk 		= (int)$qty_in+$qty_in_dtl;
						$saldo_q 		= (int)$q_masuk-$qty_out;
						$saldo_last_hpp = ceil($rumus_hpp); 
						$saldo_total 	= ceil($saldo_q*$saldo_last_hpp);
						
						//UPDATE CRD STOK
						$mySql4 = " UPDATE crd_stok SET tgl_input='".$tgl_input."', qty_in='".$q_masuk."', saldo_qty='".$saldo_q."', saldo_last_hpp='".$saldo_last_hpp."', saldo_total='".$saldo_total."' WHERE kode_barang='".$kd_barang."' AND kode_cabang='".$kd_cabang."' AND kode_gudang='".$kd_gudang."' ";
						
						$query4 = mysqli_query ($con,$mySql4) ;
						
						//INSERT CRD STOK DTL
						$mySql5	= "INSERT INTO crd_stok_dtl SET 
									kode_barang				='".$kd_barang."',
									tgl_buat				='".$tgl_buat."',
									tgl_input				='".$tgl_input."',
									kode_cabang				='".$kd_cabang."',
									kode_gudang				='".$kd_gudang."',
									qty_in					='".$qty_in_dtl."',
									harga_in				='".$harga_in_dtl."',
									total_in				='".$total_in_dtl."',
									ref						='".$ref_untuk_crd."',
									note					='".$ref."',
									kode_transaksi			='".$kode_sm."';
								";	
								
						$query5 = mysqli_query ($con,$mySql5) ;		
						
					//JIKA BELUM ADA STOK
					}else{
						
						//INSERT CRD STOK 
						$mySql4	= "INSERT INTO crd_stok SET 
									kode_barang				='".$kd_barang."',
									tgl_input				='".$tgl_input."',
									kode_cabang				='".$kode_cabang."',
									kode_gudang				='".$kode_gudang."',
									qty_in					='".$qty_in_dtl."',
									saldo_qty				='".$qty_in_dtl."',
									saldo_last_hpp			='".$harga_in_dtl."',
									saldo_total				='".$total_in_dtl."';
								";	
								
						$query4 = mysqli_query ($con,$mySql4) ;
						
						//INSERT CRD STOK DTL
						$mySql5	= "INSERT INTO crd_stok_dtl SET 
									kode_barang				='".$kd_barang."',
									tgl_buat				='".$tgl_buat."',
									tgl_input				='".$tgl_input."',
									kode_cabang				='".$kode_cabang."',
									kode_gudang				='".$kode_gudang."',
									qty_in					='".$qty_in_dtl."',
									harga_in				='".$harga_in_dtl."',
									total_in				='".$total_in_dtl."',
									ref						='".$ref_untuk_crd."',
									note					='".$ref."',
									kode_transaksi			='".$kode_sm."';
								";	
								
						$query5 = mysqli_query ($con,$mySql5) ;			
						
					}
					
				}
				
			}
		 
		$mySql1 = rtrim($mySql1,",");
		
		$query1 = mysqli_query ($con,$mySql1) ;
		
		//HEADER sm
		$mySql	= "INSERT INTO sm_hdr SET 
						kode_sm			='".$kode_sm."',
						ref				='".$ref."',
						kode_cabang		='".$kode_cabang."',
						kode_gudang		='".$kode_gudang."',
						tgl_buat		='".$tgl_buat."',
						keterangan_hdr	='".$keterangan_hdr."',
						user_pencipta	='".$user_pencipta."',
						tgl_input		='".$tgl_input."';
					";	
						
		$query = mysqli_query ($con,$mySql) ;
		
		if ($query AND $query1 AND $query2 AND $query3 AND $query4 and $query5) {
			
			// Commit transaction
			mysqli_commit($con);
			
			// Close connection
			mysqli_close($con);
			
			echo "00||".$kode_sm;
			unset($_SESSION['data_sm']);
		} else { 
			
			echo "Gagal query: ".mysqli_error();
		}		 	
				
					 
	}



?>