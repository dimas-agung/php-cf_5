<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	require('../pages/data/script/gk.php'); 
	date_default_timezone_set("Asia/Jakarta");

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loaditem" ) {
		$kode_supplier	= $_POST['kode_supplier'];
		$kode_cabang	= $_POST['kode_cabang'];
		$id_form 		= $_POST['id_form'];

		$query			= "SELECT kh.kode_transaksi, kh.kode_cabang,fh.kode_supplier, s.nama nama_supplier,DATE_FORMAT(kh.tgl_jth_tempo, '%d-%m-%Y') AS jatuh_tempo,
							kh.kode_pelunasan,kh.lunas,SUM(debet) totdebet, SUM(kredit) totkredit, (SUM(kredit)-SUM(debet)) saldo, 0 jumlah_bayar, 0 jumlah_lunas, 
							'' ket_dtl FROM kartu_hutang kh 
							LEFT JOIN fb_hdr fh ON kh.kode_transaksi=fh.kode_fb  
							INNER JOIN supplier s ON s.kode_supplier=kh.kode_supplier 
							WHERE kh.kode_cabang='".$kode_cabang."' AND kh.kode_supplier='".$kode_supplier."' 
								AND kh.kode_transaksi NOT IN (SELECT kode_transaksi FROM kartu_hutang WHERE (status_batal='1' OR lunas='1') ) 
							GROUP BY kh.kode_transaksi";	
						 
		$result			= mysql_query($query);

		$query_coa		= "SELECT kode_coa, nama FROM coa where level_coa = '4' ORDER BY kode_coa ASC";
		$resultcoa		= mysql_query($query_coa);
		
		$array = array();
		if(mysql_num_rows($result) > 0) {
			while ($res = mysql_fetch_array($result)) {
				$array[] = array("deskripsi" => $res['kode_transaksi'],"jatuh_tempo" => $res['jatuh_tempo'],"saldo_transaksi" => $res['saldo'],"nominal_bayar" => $res['jumlah_bayar'],"nominal_pelunasan" => $res['jumlah_lunas'], "selisih" => '0', "keterangan_dtl" => $res['ket_dtl'], "id_form" => $id_form );
			}
		}
		
		$arraycoa = array();
		if(mysql_num_rows($resultcoa) > 0) {
			while ($res1 = mysql_fetch_array($resultcoa)) {
				$arraycoa[] = array("kode_coa" => $res1['kode_coa'],"nama_coa" => $res1['nama']);
			}
		}

		$_SESSION['load_gk'.$id_form.''] = $array;
		$_SESSION['load_coa'.$id_form.''] = $arraycoa;
		
		echo view_item_gk($array,$arraycoa);
	}

	function view_item_gk($array,$arraycoa) {
		$n = 1;
		$total = 0;
		$html = "";
		if(count($array) > 0) {
			foreach($array as $key=>$item){

				$cheked   = '';
					$stat_cb  = '0';
					$nominal_bayar = '0';
					$kode_coa_selisih = '';
					$keterangan_dtl = '';
					$id = '';

							$html .= '<tr>
									<td width="40px">
										<div class="checkbox" style="text-align:right">
											<input type="checkbox" name="cb[]" id="cb[]" data-id="cb" data-group="'.$n.'" value="'.$n.'" '.$cheked.'>
										</div> 
										<input type="hidden" class="form-control" name="stat_cb[]" id="stat_cb[]" data-id="stat_cb" data-group="'.$n.'" value="'.$stat_cb.'" style="width:100px">
									</td>
									<td>
										<input class="form-control" type="text" name="deskripsi[]" id="deskripsi[]" data-id="deskripsi" data-group="'.$n.'" value="'.$item['deskripsi'].'" readonly/>
										<input type="hidden" class="form-control" name="jatuh_tempo[]" id="jatuh_tempo[]" data-id="jatuh_tempo" data-group="'.$n.'" value="'.$item['jatuh_tempo'].'" >
										<input type="hidden" class="form-control" name="key[]" id="key[]" data-id="key" data-group="'.$n.'" value="'.$key.'" >
									</td>
									<td>
										<input class="form-control" type="text" name="saldo_transaksi[]" id="saldo_transaksi[]" data-id="saldo_transaksi" data-group="'.$n.'" value="'.($item['saldo_transaksi']).'" style="text-align:right" readonly/>
									</td>
									<td>
										<input class="form-control" type="text" name="nominal_bayar[]" id="nominal_bayar[]" data-id="nominal_bayar" data-group="'.$n.'" value="'.($item['saldo_transaksi']).'" style="text-align:right"/>
									</td>
									<td>
										<input class="form-control" type="text" name="nominal_pelunasan[]" id="nominal_pelunasan[]" data-id="nominal_pelunasan" data-group="'.$n.'" value="'.($item['nominal_pelunasan']).'" style="text-align:right" readonly/>
									</td>
									<td>
										<input type="text" class="form-control" name="keterangan_dtl[]" id="keterangan_dtl[]" data-id="keterangan_dtl" data-group="'.$n.'" placeholder="Keterangan ..." value="'.$item['keterangan_dtl'].'">
									</td>
								</tr>';	
							$total += $item['nominal_bayar'];
							$n++;
				}

				$html .= '<tr>
							<td colspan="3" style="text-align:right"><b>Subtotal :</b></td>
							<td>
								<input class="form-control" type="text" name="subtotal" id="subtotal" autocomplete="off" value="'.$total.'" readonly style="text-align:right; font-weight: bold;"/>
							</td>
							<td>
								<input class="form-control" type="text" name="tot_nom_pel" id="tot_nom_pel" autocomplete="off" value="0" readonly style="text-align:right; font-weight: bold;"/>
							</td>
							<td></td>
						</tr>';
		}else{
				$html .= '<tr> <td colspan="9" class="text-center"> Tidak ada item barang. </td></tr>';
		}
		  
		return $html;
	}

	if (isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "addgirotarik" )
	{
		if(isset($_POST['kode_gk']) and (@$_POST['kode_gk'] != "" )){

			$id_form	= $_POST['id_form'];
			$kode_gk 	= $_POST['kode_gk'];
			
			$payment_giro	= mysql_query("SELECT * FROM payment_giro where kode_giro = '".$kode_gk."'");
			
			$arraypg = array();
			$i=0;
			if(mysql_num_rows($payment_giro) > 0) {
				while ($p_giro = mysql_fetch_array($payment_giro)) {
					
					$arraypg[$i]['bank_giro'] = $p_giro['bank_giro'];
					$arraypg[$i]['no_giro'] = $p_giro['no_giro'];
					$arraypg[$i]['tgl_giro'] = date("d-m-Y",strtotime($p_giro['tgl_giro']));
					$arraypg[$i]['nominal'] = $p_giro['nominal'];
					$i++;
				}
			}

			$_SESSION['data_giro'] = $arraypg;
			echo view_item_giro($arraypg);

		}
	}

	if (isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "addgiro" )
	{
		if(isset($_POST['bank_giro']) and (@$_POST['bank_giro'] != "" )){

			$id_form	= $_POST['id_form'];

			$array = (isset($_SESSION['data_giro']) ? $_SESSION['data_giro'] : array());
			if(isset($_SESSION['data_giro'])) {
				$array[] = array('bank_giro' => $_POST['bank_giro'], 'no_giro' => $_POST['no_giro'], 'tgl_giro' => $_POST['tgl_giro'], 'nominal' => $_POST['nominal']);
			} else {
				$array[] = array('bank_giro' => $_POST['bank_giro'], 'no_giro' => $_POST['no_giro'], 'tgl_giro' => $_POST['tgl_giro'], 'nominal' => $_POST['nominal']);
			}

			$_SESSION['data_giro'] = $array;
			echo view_item_giro($array);

		}
	}

	function view_item_giro($data) {
		$html 	  = "";
		$subtotal = 0;
		if(count($data) > 0) {
			foreach($data as $key=>$item){

				$html .= '<tr>
							<td>'.$item['bank_giro'].'
								<input class="form-control" type="hidden" name="bank_giro[]" id="bank_giro[]" value="'.$item['bank_giro'].'"/>
							</td>
							<td>'.$item['no_giro'].'
								<input class="form-control" type="hidden" name="no_giro[]" id="no_giro[]" value="'.$item['no_giro'].'"/>
							</td>
							<td>'.$item['tgl_giro'].'
								<input class="form-control" type="hidden" name="tgl_giro[]" id="tgl_giro[]" value="'.$item['tgl_giro'].'"/>
							</td>
							<td style="text-align: right">'.number_format($item['nominal'], 2).'
								<input class="form-control" type="hidden" name="nominal[]" id="nominal[]" value="'.($item['nominal']).'" />
							</td>
							<td style="text-align: center">
								<a href="javascript:;" class="label label-danger hapus-giro" title="hapus data" data-nominal="'.$item['nominal'].'" data-id="'.$key.'"><i class="fa fa-times"></i></a>        			
							</td>
						</tr>						
						';
						$subtotal += $item['nominal'];

			}

			$html .= '	<tr>
							<td colspan="3" style="text-align:right"><b>Subtotal :</b></td>
							<td>
								<input class="form-control" type="text" name="subtotal_giro" id="subtotal_giro" autocomplete="off" value="'.($subtotal).'" readonly style="text-align:right; font-weight: bold;"/>
							</td>
							<td></td>
						</tr>
					  ';
			
			$html .= "<script>$('.hapus-giro').click(function(){
						var id 				= $(this).attr('data-id'); 
						var nominal 		= parseInt($(this).attr('data-nominal')) || 0; 
						var subtotal_giro 	= parseInt($('#subtotal_giro').val());
						var selisih 		= parseInt($('#selisih').val());	
							$.ajax({
								type: 'POST',
								url: '".base_url()."ajax/j_gk.php?func=hapus-giro',
								data: 'idhapus=' + id ,
								cache: false,
								success:function(data){
									$('#detail_giro').html(data).show();
									var subtotal = parseInt(subtotal_giro - nominal);
									var selisih1 = parseInt(selisih + nominal);

									$('#subtotal_giro').val(subtotal);
									$('#selisih').val(selisih1);
								}
							});
					  });


				     </script>";
				
		} else {
			$html .= '<tr> <td colspan="5" class="text-center"> Pembayaran Giro . </td></tr>';
		}
		  
		return $html;
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "hapus-giro" )
	{
		$id = $_POST['idhapus'];
		unset($_SESSION['data_giro'][$id]);
		echo view_item_giro($_SESSION['data_giro']);
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save" )
	{
		mysqli_autocommit($con,FALSE);

		$form 			= 'GK';
		$ref 			= $_POST['ref'];
		$tgl_buat 		= date("Y-m-d",strtotime($_POST['tgl_buat']));
		$kode_cabang 	= $_POST['kode_cabang'];
		$kode_supplier 	= $_POST['kode_supplier'];
		$keterangan_hdr = $_POST['keterangan_hdr'];

		$selisih 		= $_POST['selisih'];
		$kode_coa_selisih = $_POST['kode_coa_selisih'];
		
		$user_pencipta  = $_SESSION['app_id'];
		$tgl_input 		= date("Y-m-d H:i:s");
		
		$thnblntgl 		= date("ymd",strtotime($_POST['tgl_buat']));
		$kode_gk 		= buat_kode_gk($thnblntgl,$form,$kode_cabang);
		$id_form 		= $_POST['id_form'];

		// VARIABEL AWAL
		$subtotal 		= 0;
		$grand 			= 0;
		$tot_nom_pel 	= 0;
		
		if(isset($_SESSION['load_gk'.$id_form .'']) and count($_SESSION['load_gk'.$id_form .'']) > 0) 
		{

			$mySql	= "INSERT INTO `gk_hdr` SET 
							`kode_gk`			='".$kode_gk."',
							`ref`				='".$ref."',
							`tgl_buat`		='".$tgl_buat."',
							`kode_cabang` 	='".$kode_cabang."',
							`kode_supplier`	='".$kode_supplier."',
							`keterangan_hdr`	='".$keterangan_hdr."',
							`selisih` 		='".str_replace(',', null, $selisih)."',
							`kode_coa_selisih`='".$kode_coa_selisih."',
							`user_pencipta`	='".$user_pencipta."', 
							`tgl_input`		='".$tgl_input."'
					  ";			
			$query = mysqli_query ($con,$mySql) ;

			//DETAIL PEMBAYARAN GIRO 
			$arraygiro = $_SESSION['data_giro'];
				foreach($arraygiro as $keygiro=>$itemgiro){
								
					$bank_giro 	= $itemgiro['bank_giro'];
					$no_giro 	= $itemgiro['no_giro'];
					$tgl_giro 	= date("Y-m-d",strtotime($itemgiro['tgl_giro']));
					$nominal 	= str_replace(',', null, $itemgiro['nominal']);

					$mySql9 = "INSERT INTO `payment_giro` SET 
								`kode_giro`   ='".$kode_gk."',
								`bank_giro` ='".$bank_giro."',
								`no_giro`   ='".$no_giro."',
								`tgl_giro`  ='".$tgl_giro."', 
								`nominal`   ='".$nominal."' "; 	
					$query9 = mysqli_query ($con,$mySql9) ;
					
					//CREATE KARTU GIRO
					$mySql8 = "INSERT INTO `kartu_giro` SET
								`kode_transaksi` 	='".$kode_gk."',  
								`inisial` 		='GK',
								`kredit` 			='".$nominal."',
								`kode_supplier` 	='".$kode_supplier."',
								`kode_cabang` 	='".$kode_cabang."',
								`bank_giro`   ='".$bank_giro."',
								`no_giro`   ='".$no_giro."', 
								`tgl_buat` 		='".$tgl_buat."',
								`tgl_jth_tempo` 	='".$tgl_giro."',
								`user_pencipta` 	='".$_SESSION['app_id']."',
								`tgl_input`		='".date('Y-m-d H:i:s')."' ";
									
					$query8 = mysqli_query ($con,$mySql8) ;
					
					$mySql5 = "INSERT INTO `jurnal` SET
								`kode_transaksi` 	='".$kode_gk."', 
								`tgl_input` 		='".date('Y-m-d H:i:s')."',
							    `tgl_buat` 		='".$tgl_buat."',
								`kode_supplier` 	='".$kode_supplier."',
								`kode_cabang` 	='".$kode_cabang."',
								`keterangan_hdr` 	='".$keterangan_hdr."',
							    `ref` 			='".$ref."',
								`kode_coa` 		='2.01.02.02',
							    `kredit`  		='".$nominal."',
							    `user_pencipta` 	='".$_SESSION['app_id']."'";
					
					$query5 = mysqli_query ($con,$mySql5) ;	
				}
		
			//DETAIL GIRO KELUAR
			$array = $_SESSION['load_gk'.$id_form .''];
				foreach($array as $key=>$item){
						
					$no_gk 					= $kode_gk;
					$stat_cb 				= $_POST['stat_cb'][$key];
					$deskripsi 				= $item['deskripsi'];
					$saldo_transaksi 		= $item['saldo_transaksi'];
					$nominal_bayar			= $_POST['nominal_bayar'][$key];
					$nominal_pelunasan		= $_POST['nominal_pelunasan'][$key];
					$keterangan_dtl			= $_POST['keterangan_dtl'][$key];
					$tgl_jatuh_tempo 		= date("Y-m-d",strtotime($item['jatuh_tempo']));
					$tot_nom_pel			= $_POST['tot_nom_pel'];

					$nilai_total			= str_replace(',', null, $nominal_bayar) + str_replace(',', null, $selisih);
					$subtotal 				+= $item['saldo_transaksi'];

					//JIKA JUMLAH BAYAR >= SALDO
					if(str_replace(',', null, $nominal_bayar) >= str_replace(',', null, $saldo_transaksi)) {
						$stat_lunas='1';
					}else{
						$stat_lunas='0';
					}

					if($stat_cb=='1') {
							$mySql1 = "INSERT INTO `gk_dtl` SET 
										`kode_gk` 		  ='".$no_gk."',
										`deskripsi` 		  ='".$deskripsi."',
										`saldo_transaksi`   ='".str_replace(',', null, $saldo_transaksi)."',
										`nominal_bayar`	  ='".str_replace(',', null, $nominal_bayar)."', 
										`nominal_pelunasan` ='".str_replace(',', null, $nominal_pelunasan)."', 
										`tgl_input`		  ='".$tgl_input."',
										`tgl_jatuh_tempo`   ='".$tgl_jatuh_tempo."',
										`keterangan_dtl`	  ='".$keterangan_dtl."' ";	
								
							$query1 = mysqli_query ($con,$mySql1) ;

							//CREATE KARTU HUTANG
							$mySql2 = "INSERT INTO `kartu_hutang` SET
										`kode_transaksi` 	='".$deskripsi."', 
										`kode_pelunasan` 	='".$no_gk."', 
										`debet` 			='".str_replace(',', null, $nominal_bayar)."',
										`lunas` 			='".$stat_lunas."',
										`kode_supplier` 	='".$kode_supplier."',
										`kode_cabang` 	='".$kode_cabang."',
										`tgl_buat` 		='".$tgl_buat."',
										`tgl_jth_tempo` 	='".$tgl_jatuh_tempo."',
										`user_pencipta` 	='".$_SESSION['app_id']."',
										`tgl_input`		='".date('Y-m-d H:i:s')."' ";
								
							$query2 = mysqli_query ($con,$mySql2) ;

							$fb = mysql_query("SELECT SUBSTRING(kode_transaksi,11,2) kode_fb FROM kartu_hutang WHERE kode_transaksi= '".$deskripsi."'");
							$num_rows_fb = mysql_num_rows($fb);
								if($num_rows_fb>0){
									$row_fb = mysql_fetch_array($fb);

									if($row_fb['kode_fb'] == 'FB'){
										$mySql7 = "UPDATE fb_hdr SET status ='3' WHERE kode_fb = '".$deskripsi."'";
										$query7 = mysqli_query ($con,$mySql7) ; 

										$mySql3 = "UPDATE fb_dtl SET status_dtl ='3' WHERE kode_fb = '".$deskripsi."'";
										$query3 = mysqli_query ($con,$mySql3) ;
									}elseif($row_fb['kode_nk'] == 'NK'){
										$mySql3 = "UPDATE nk_dtl SET status_dtl ='3' WHERE kode_nk = '".$deskripsi."'";
										$query3 = mysqli_query ($con,$mySql3) ;
									}else{
										$mySql3 = "UPDATE nb_dtl SET status_dtl ='3' WHERE kode_nb = '".$deskripsi."'";
										$query3 = mysqli_query ($con,$mySql3) ;
									}
								}

							
									
							$grand += str_replace(',', null, $nominal_bayar); 

							//JURNAL JIKA ADA SELISIH
							if(str_replace(',', null, $selisih)>0){
								$mySql6 = "INSERT INTO `jurnal` SET
											`kode_transaksi` 	='".$no_gk."', 
											`tgl_input` 		='".date('Y-m-d H:i:s')."',
											`tgl_buat` 		='".$tgl_buat."',
											`kode_supplier` 	='".$kode_supplier."',
											`kode_cabang` 	='".$kode_cabang."',
											`keterangan_hdr` 	='".$keterangan_hdr."',
											`ref` 			='".$ref."',
											`kode_coa` 		='".$kode_coa_selisih."',
											`kredit` 			='".(str_replace(',', null, $selisih))."',
											`user_pencipta` 	='".$_SESSION['app_id']."'";
								
								$query6 = mysqli_query ($con,$mySql6) ;

							}elseif(str_replace(',', null, $selisih)<0){
								$mySql6 = "INSERT INTO `jurnal` SET
											`kode_transaksi` 	='".$no_gk."', 
											`tgl_input` 		='".date('Y-m-d H:i:s')."',
											`tgl_buat` 		='".$tgl_buat."',
											`kode_supplier` 	='".$kode_supplier."',
											`kode_cabang` 	='".$kode_cabang."',
											`keterangan_hdr`	='".$keterangan_hdr."',
											`ref` 			='".$ref."',
											`kode_coa` 		='".$kode_coa_selisih."',
											`debet` 			='".abs((str_replace(',', null, $selisih)))."',
											`user_pencipta` 	='".$_SESSION['app_id']."'";

								$query6 = mysqli_query ($con,$mySql6) ;

							}else{
								$mySql6 = "UPDATE jurnal SET user_pencipta ='".$_SESSION['app_id']."' WHERE kode_transaksi='".$no_gk."'";
								
								$query6 = mysqli_query ($con,$mySql6) ;
								
							}

							//INSERT JURNAL DEBET
							$mySql4 = "INSERT INTO `jurnal` SET
										`kode_transaksi` 	='".$no_gk."', 
										`tgl_input` 		='".date('Y-m-d H:i:s')."',
										`tgl_buat` 		='".$tgl_buat."',
										`kode_supplier` 	='".$kode_supplier."',
										`kode_cabang` 	='".$kode_cabang."',
										`keterangan_hdr`  ='".$keterangan_hdr."',
										`keterangan_dtl`  ='".$keterangan_dtl."',	
										`ref` 		 	='".$_POST['ref']."',
										`kode_coa` 		='2.01.02.01',
										`debet` 			='".str_replace(',', null, $nominal_pelunasan)."',
										`user_pencipta` 	='".$_SESSION['app_id']."'"; 
														
							$query4 = mysqli_query ($con,$mySql4) ;

						
					}
				}
			
			if ($query AND @$query1 AND $query2 AND $query3 AND $query4 AND $query5 AND $query6 AND $query7 AND $query8 AND $query9) {

				// Commit Transaction
				mysqli_commit($con);
				
				// Close connection
				mysqli_close($con);

				unset($_SESSION['load_gk'.$id_form .'']);
				unset($_SESSION['data_giro'.$id_form .'']);
				echo "00||$kode_gk";
				
			} else { 
				echo "99||Gagal Input";
			}

		} else {
			echo "99|| Harap Pilih Giro Detail Terlebih Dahulu !";			 	
		}

	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "pembatalan" )
	{
		mysqli_autocommit($con,FALSE);

		$kode_gk		= $_POST['kode_gk_batal'];
		$alasan_batal	= $_POST['alasan_batal'];
		$tgl_batal 		= date("Y-m-d");

		//UPDATE gk_HDR 
		$mySql1 = "UPDATE gk_hdr SET status ='2', alasan_batal='".$alasan_batal."', tgl_batal='".$tgl_batal."' WHERE kode_gk='".$kode_gk."' ";
		$query1 = mysqli_query ($con,$mySql1) ;

		//UPDATE gk_DTL
		$mySql2 = "UPDATE gk_dtl SET status_dtl ='2' WHERE kode_gk='".$kode_gk."' ";
		$query2 = mysqli_query ($con,$mySql2) ;

		//INSERT PAYMENT GIRO
		$payment_giro = mysql_query("SELECT * FROM payment_giro WHERE kode_giro = '".$kode_gk."'");
		$num_row_pg = mysql_num_rows($payment_giro);

		if($num_row_pg > 0){
			while($row_pg = mysql_fetch_array($payment_giro)){
						
				$bank_giro 	= $row_pg['bank_giro']; 
				$no_giro 	= $row_pg['no_giro'];
				$tgl_giro 	= $row_pg['tgl_giro'];
				$nominal 	= $row_pg['nominal'];

				$mySql11= "UPDATE payment_giro SET status_batal ='1' WHERE kode_giro = '".$kode_gk."'";		
				$query11 = mysqli_query ($con,$mySql11) ;	
			}
		}

		$kode_deskripsi = mysql_query("SELECT deskripsi FROM gk_dtl WHERE kode_gk = '".$kode_gk."' ");
		$num_row_desc = mysql_num_rows($kode_deskripsi);

		if($num_row_desc > 0){
			while($row_desc = mysql_fetch_array($kode_deskripsi)){

				$kode = $row_desc['deskripsi'];
				$kd	  = SUBSTR($kode, -6, 2);

				if($kd == 'FB'){
					$mySql3 = "UPDATE fb_hdr SET status ='1' WHERE kode_fb = '".$kode."' ";
					$query3 = mysqli_query ($con,$mySql3) ;

					$mySql4 = "UPDATE fb_dtl SET status_dtl ='1' WHERE kode_fb = '".$kode."' ";
					$query4 = mysqli_query ($con,$mySql4) ;

					//INSERT KARTU_HUATNG
					$hutang = mysql_query("SELECT * FROM kartu_hutang WHERE kode_transaksi = '".$kode."' AND kode_pelunasan = '".$kode_gk."'");
					$num_row_h  = mysql_num_rows($hutang);

					if($num_row_h > 0){
						while($row_h = mysql_fetch_array($hutang)){
						
							$kode_transaksi 	= $row_h['kode_transaksi'];
							$kode_pelunasan 	= $row_h['kode_pelunasan'];
							$debet 				= $row_h['debet'];
							$kredit 			= $row_h['kredit'];
							$kode_cabang 		= $row_h['kode_cabang'];
							$kode_supplier 	= $row_h['kode_supplier'];
							$tgl_jth_tempo 		= $row_h['tgl_jth_tempo'];
							$tgl_input 			= date("Y-m-d H:i:s");

							$mySql5 = "INSERT INTO kartu_hutang SET
											kode_transaksi 	='".$kode_transaksi."',
											kode_pelunasan 	='".$kode_pelunasan."',
											debet 			='".$kredit."', 
											kredit 			='".$debet."',
											kode_cabang 	='".$kode_cabang."',
											kode_supplier 	='".$kode_supplier."',
											tgl_buat  		='".$tgl_batal."',
											tgl_jth_tempo  	='".$tgl_jth_tempo."',
											tgl_input 		='".$tgl_input."'
										";
							$query5 = mysqli_query ($con,$mySql5) ;	

							$mySql6 = "UPDATE kartu_hutang SET status_batal ='1' WHERE kode_transaksi = '".$kode_transaksi."' AND kode_pelunasan = '".$kode_pelunasan."'";			
							$query6 = mysqli_query ($con,$mySql6) ;	
						}
					}

					//INSERT KARTU_GIRO
					$giro = mysql_query("SELECT * FROM kartu_giro WHERE kode_transaksi = '".$kode_gk."'");
					$num_row_g  = mysql_num_rows($giro);

					if($num_row_g > 0){
						while($row_g = mysql_fetch_array($giro)){
						
							$kode_transaksi_giro 	= $row_g['kode_transaksi'];
							$kode_pelunasan_giro 	= $row_g['kode_pelunasan'];
							$debet_giro 			= $row_g['debet'];
							$kredit_giro 			= $row_g['kredit'];
							$inisial 				= $row_g['inisial'];

							$mySql7 = "INSERT INTO kartu_giro SET
											kode_transaksi 	='".$kode_transaksi_giro."',
											kode_pelunasan 	='".$kode_pelunasan_giro."',
											inisial 		='".$inisial."',
											debet 			='".$kredit_giro."', 
											kredit 			='".$debet_giro."',
											kode_cabang 	='".$kode_cabang."',
											kode_supplier 	='".$kode_supplier."',
											tgl_buat  		='".$tgl_batal."',
											tgl_jth_tempo  	='".$tgl_jth_tempo."',
											tgl_input 		='".$tgl_input."'
										";							
							$query7 = mysqli_query ($con,$mySql7) ;	

							$mySql8 = "UPDATE kartu_giro SET status_batal ='1' WHERE kode_transaksi = '".$kode_gk."'";			
							$query8 = mysqli_query ($con,$mySql8) ;	
						}
					}
				}
			}
		}

		//INSERT JURNAL
		$jurnal = mysql_query("SELECT * FROM jurnal WHERE kode_transaksi = '".$kode_gk."' ");
		$num_row_j  = mysql_num_rows($jurnal);

		if($num_row_j > 0){
			while($row_j = mysql_fetch_array($jurnal)){
			
				$kode_transaksi 	= $row_j['kode_transaksi'];
				$ref 				= $row_j['ref'];
				$tgl_buat 			= $row_j['tgl_buat'];
				$kode_cabang 		= $row_j['kode_cabang'];
				$kode_supplier 		= $row_j['kode_supplier'];
				$kode_pelanggan 	= $row_j['kode_pelanggan'];
				$kode_coa 			= $row_j['kode_coa'];
				$debet 				= $row_j['debet'];
				$kredit 			= $row_j['kredit'];
				$tgl_input 			= date("Y-m-d H:i:s");
				$keterangan_hdr 	= $row_j['keterangan_hdr'];
				$keterangan_dtl 	= $row_j['keterangan_dtl'];

				$mySql9 = "INSERT INTO jurnal SET
								kode_transaksi 	='".$kode_transaksi."',
								ref 			='".$ref."', 
								tgl_buat 		='".$tgl_buat."',
								kode_cabang 	='".$kode_cabang."',
								kode_supplier 	='".$kode_supplier."',
								kode_pelanggan 	='".$kode_pelanggan."',
								kode_coa 		='".$kode_coa."',
								debet  			='".$kredit."',
								kredit  		='".$debet."',
								tgl_input 		='".$tgl_input."',
								keterangan_hdr 	='".$keterangan_hdr."',
								keterangan_dtl 	='".$keterangan_dtl."'
							";			
				$query9 = mysqli_query ($con,$mySql9) ;	

				$mySql10 = "UPDATE jurnal SET status_jurnal ='2' WHERE kode_transaksi = '".$kode_transaksi."' ";			
				$query10 = mysqli_query ($con,$mySql10) ;		
			}
		}

		if ($query1 AND $query2 AND $query3 AND $query4 AND $query5 AND $query6 AND $query7 AND $query8 AND $query9 AND $query10 AND $query11) {
			
			mysqli_commit($con);
			mysqli_close($con);
			
			echo "00||".$kode_gk;
		} else { 
			echo "Gagal query: ".mysql_error();
		}	
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save_back" )
	{
		mysqli_autocommit($con,FALSE);

		$kode_gk 		= $_POST['kode_gk'];
		$ref 			= $_POST['ref'];
		$tgl_buat 		= date("Y-m-d",strtotime($_POST['tgl_buat']));
		$kode_cabang 	= $_POST['kode_cabang'];
		$kode_supplier = $_POST['kode_supplier'];
		$keterangan_hdr = $_POST['keterangan_hdr'];

		$tgl_giro 		= date("Y-m-d",strtotime($_POST['tgl_giro']));
		$bank_giro 		= $_POST['bank_giro'];
		$no_giro 		= $_POST['no_giro'];
		$nominal 		= $_POST['nominal'];
		
		$user_pencipta  = $_SESSION['app_id'];
		$tgl_input 		= date("Y-m-d H:i:s");
		
		$thnblntgl 		= date("ymd",strtotime($_POST['tgl_buat']));

		//VARIABEL AWAL
		$subtotal 		= 0;
		$grand 			= 0;
		$tot_nom_pel 	= 0;
		$jumlah 		= 0;

			$mySql	= "UPDATE gk_hdr SET 
							ref				='".$ref."',
							tgl_buat		='".$tgl_buat."',
							kode_cabang 	='".$kode_cabang."',
							kode_supplier	='".$kode_supplier."',
							keterangan_hdr	='".$keterangan_hdr."',
							tgl_giro		='".$tgl_giro."',
							bank_giro 		='".$bank_giro."',
							no_giro 		='".$no_giro."',
							nominal 		='".$nominal."',
							user_pencipta	='".$user_pencipta."', 
							tgl_input		='".$tgl_input."',
							status 			='1',
							alasan_batal    ='',
							tgl_batal		=''
						WHERE kode_gk = '".$kode_gk."'
					  ";

			$query = mysqli_query ($con,$mySql) ;
		
			//DETAIL GIRO MASUK
			$array_dtl_back = $_SESSION['data_dtl_back'];
                foreach($array_dtl_back as $key=>$res_dtl){
						
					$no_gk 					= $kode_gk;
					$stat_cb 				= $_POST['stat_cb'][$key];
					$deskripsi 				= $res_dtl['deskripsi'];
					$saldo_transaksi 		= $res_dtl['saldo_transaksi'];
					$nominal_bayar			= $_POST['nominal_bayar'][$key];
					$nominal_pelunasan		= $_POST['nominal_pelunasan'][$key];
					$selisih				= $_POST['selisih'][$key];
					$kode_coa_selisih  		= $_POST['kode_coa'][$key];
					$keterangan_dtl			= $_POST['keterangan_dtl'][$key];
					$tot_nom_pel			= $_POST['tot_nom_pel'];
					$tgl_jatuh_tempo		= $res_dtl['tgl_jatuh_tempo'];
					$nilai_total			= (int)$nominal_bayar+$selisih;
					$subtotal 				+= $saldo_transaksi;
					
					//JIKA JUMLAH BAYAR >= SALDO
					if($nominal_bayar>=$saldo_transaksi) {
						$stat_lunas='1';
					}else{
						$stat_lunas='0';
					}

					if($stat_cb=='1') {
						if($tot_nom_pel == $nominal) {

							$mySql1 = "INSERT INTO gk_dtl SET 
										kode_gk 		  ='".$no_gk."',
										deskripsi 		  ='".$deskripsi."',
										saldo_transaksi   ='".$saldo_transaksi."',
										nominal_bayar	  ='".$nominal_bayar."', 
										nominal_pelunasan ='".$nominal_pelunasan."', 
										selisih			  ='".$selisih."',	
										kode_coa		  ='".$kode_coa_selisih."',
										tgl_input		  ='".$tgl_input."',
										tgl_jatuh_tempo   ='".$tgl_jatuh_tempo."',
										keterangan_dtl	  ='".$keterangan_dtl."',
										status_dtl 		  ='1' ";	
						
							$query1 = mysqli_query ($con,$mySql1) ;

							//CREATE KARTU HUTANG
							$mySql2 = "INSERT INTO kartu_hutang SET
										kode_transaksi 	='".$deskripsi."', 
										kode_pelunasan 	='".$no_gk."', 
										debet 			='".$nominal_bayar."',
										lunas 			='".$stat_lunas."',
										kode_supplier 	='".$kode_supplier."',
										kode_cabang 	='".$kode_cabang."',
										tgl_buat 		='".$tgl_buat."',
										tgl_jth_tempo 	='".$tgl_jatuh_tempo."',
										user_pencipta 	='".$_SESSION['app_id']."',
										tgl_input		='".date('Y-m-d H:i:s')."' ";
								
							$query2 = mysqli_query ($con,$mySql2) ;

							$fb = mysql_query("SELECT SUBSTRING(kode_transaksi,11,2) kode_fb FROM kartu_hutang WHERE kode_transaksi= '".$deskripsi."'");
							$num_rows_fb = mysql_num_rows($fb);
								if($num_rows_fb>0){
									$row_fb = mysql_fetch_array($fb);

									if($row_fb['kode_fb'] == 'FB'){
										$status = mysql_query("SELECT status_dtl FROM fb_dtl WHERE kode_fb= '".$deskripsi."'");
										$row_status = mysql_fetch_array($status);

										if($row_status['status_dtl'] != '1'){
											echo "99|| Faktur Pembelian ".$deskripsi." sudah di lunasi di Bukti Kas Keluar!";
											return false;
										}

										$mySql3 = "UPDATE fb_dtl SET status_dtl ='3' WHERE kode_fb = '".$deskripsi."'";
										$query3 = mysqli_query ($con,$mySql3) ;

										$mySql4 = "UPDATE fb_hdr SET status ='3' WHERE kode_fb = '".$deskripsi."'";
										$query4 = mysqli_query ($con,$mySql4) ;
									}else{
										$mySql3 = "UPDATE nk_dtl SET status_dtl ='3' WHERE kode_nk = '".$deskripsi."'";
										$query3 = mysqli_query ($con,$mySql3) ;
										
										$mySql4=true;
										$query4=true;
									}
								}

							$grand += $nominal_bayar; 

							//INSERT JURNAL DEBET
						    $mySql5 = "INSERT INTO jurnal SET
										kode_transaksi 	='".$no_gk."', 
										tgl_input 		='".date('Y-m-d H:i:s')."',
									    tgl_buat 		='".$tgl_buat."',
										kode_supplier 	='".$kode_supplier."',
										kode_cabang 	='".$kode_cabang."',
										keterangan_hdr 	='".$keterangan_hdr."',
									    ref 			='".$ref."',
										kode_coa 		='2.01.02.01',
									    debet  			='".($nominal_bayar)."',
									    user_pencipta 	='".$_SESSION['app_id']."'";
							
							$query5 = mysqli_query ($con,$mySql5) ;	

							//JURNAL JIKA ADA SELISIH
							if($selisih>0){
								$mySql6 = "INSERT INTO jurnal SET
											kode_transaksi 	='".$no_gk."', 
											tgl_input 		='".date('Y-m-d H:i:s')."',
											tgl_buat 		='".$tgl_buat."',
											kode_supplier 	='".$kode_supplier."',
											kode_cabang 	='".$kode_cabang."',
											keterangan_hdr 	='".$keterangan_hdr."',
											ref 			='".$ref."',
											kode_coa 		='".$kode_coa_selisih."',
											debet 			='".($selisih)."',
											user_pencipta 	='".$_SESSION['app_id']."'";
								
								$query6 = mysqli_query ($con,$mySql6) ;

							}elseif($selisih<0){
								$mySql6 = "INSERT INTO jurnal SET
											kode_transaksi 	='".$no_gk."', 
											tgl_input 		='".date('Y-m-d H:i:s')."',
											tgl_buat 		='".$tgl_buat."',
											kode_supplier 	='".$kode_supplier."',
											kode_cabang 	='".$kode_cabang."',
											keterangan_hdr	='".$keterangan_hdr."',
											ref 			='".$ref."',
											kode_coa 		='".$kode_coa_selisih."',
											kredit 			='".abs(($selisih))."',
											user_pencipta 	='".$_SESSION['app_id']."'";
								
								$query6 = mysqli_query ($con,$mySql6) ;

							}else{
								$mySql6 = "UPDATE jurnal SET user_pencipta ='".$_SESSION['app_id']."' WHERE kode_transaksi='".$no_gk."'";
								
								$query6 = mysqli_query ($con,$mySql6) ;
								
							}

							$mySql7 = "INSERT INTO jurnal SET
										kode_transaksi 	='".$no_gk."', 
										tgl_input 		='".date('Y-m-d H:i:s')."',
										tgl_buat 		='".$tgl_buat."',
										kode_supplier 	='".$kode_supplier."',
										kode_cabang 	='".$kode_cabang."',
										keterangan_hdr  ='".$keterangan_hdr."',
										keterangan_dtl  ='".$keterangan_dtl."',	
										ref 		 	='".$_POST['ref']."',
										kode_coa 		='2.01.04.01',
										kredit 			='".$nominal_pelunasan."',
										user_pencipta 	='".$_SESSION['app_id']."'";
														
							$query7 = mysqli_query ($con,$mySql7) ;

						}else{
							echo "99|| Nominal Pelunasan Melebihi/Kurang Batas Nominal !";	
						}
					}
			}

			//CREATE KARTU GIRO
				$mySql8 = "INSERT INTO kartu_giro SET
							kode_transaksi 	='".$no_gk."',  
							inisial 		='GK',
							kredit 			='".$nominal."',
							kode_supplier 	='".$kode_supplier."',
							kode_cabang 	='".$kode_cabang."',
							tgl_buat 		='".$tgl_buat."',
							tgl_jth_tempo 	='".$tgl_jatuh_tempo."',
							user_pencipta 	='".$_SESSION['app_id']."',
							tgl_input		='".date('Y-m-d H:i:s')."' ";
								
				$query8 = mysqli_query ($con,$mySql8) ;

			//HAPUS GK_DTL WHERE STATUS_DTL = 2
				$mySql8 = "DELETE FROM gk_dtl WHERE kode_gk = '".$no_gk."' and status_dtl = '2' ";
								
				$query8 = mysqli_query ($con,$mySql8) ;
				

			if ($query AND @$query1 AND $query2 AND $query3 AND $query4 AND $query5 AND $query6 AND $query7 AND $query8) {

				// Commit Transaction
				mysqli_commit($con);
				
				// Close connection
				mysqli_close($con);
				echo "00||$kode_gk";
			} else { 
				echo "99||Gagal Input";
			}

	}


?>