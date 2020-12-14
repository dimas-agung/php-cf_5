<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	require('../pages/data/script/gm.php');
	date_default_timezone_set("Asia/Jakarta");

// LOAD ITEM SAAT INSERT
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loaditem" ) {
		$kode_pelanggan	= $_POST['kode_pelanggan'];
		$kode_cabang	= $_POST['kode_cabang'];
		$id_form 		= $_POST['id_form'];

		$query			= "SELECT * FROM
							(SELECT kp.kode_transaksi, kp.kode_cabang, c.nama nama_cabang, kp.kode_pelanggan, p.nama nama_pelanggan,
							DATE_FORMAT(kp.tgl_jth_tempo, '%d-%m-%Y') AS jatuh_tempo, kp.kode_pelunasan,kp.lunas,
							SUM(debet) totdebet, SUM(kredit) totkredit, (SUM(debet)-SUM(kredit)) saldo,
							0 jumlah_bayar, 0 jumlah_lunas, '' ket_dtl, p.coa_kredit
							FROM kartu_piutang kp
							LEFT JOIN cabang c ON c.kode_cabang = kp.kode_cabang
							LEFT JOIN pelanggan p ON p.kode_pelanggan = kp.kode_pelanggan
							WHERE (kp.kode_transaksi IN (SELECT kode_transaksi FROM kartu_piutang WHERE lunas='0' AND status_batal = '0'))
							GROUP BY kp.kode_transaksi)
						 	AS tbl WHERE kode_cabang='".$kode_cabang."' AND kode_pelanggan='".$kode_pelanggan."' AND saldo <> 0";

		$result			= mysql_query($query);

		$query_coa		= "SELECT kode_coa, nama FROM coa where level_coa = '4' ORDER BY kode_coa ASC";
		$resultcoa		= mysql_query($query_coa);

		$array = array();
		if(mysql_num_rows($result) > 0) {
			while ($res = mysql_fetch_array($result)) {
				$array[] = array("deskripsi" => $res['kode_transaksi'],"jatuh_tempo" => $res['jatuh_tempo'],"saldo_transaksi" => $res['saldo'],"nominal_bayar" => $res['jumlah_bayar'],"nominal_pelunasan" => $res['jumlah_lunas'],"coa" => $res['coa_kredit'], "selisih" => '0', "keterangan_dtl" => $res['ket_dtl'], "id_form" => $id_form );
			}
		}

		$arraycoa = array();
		if(mysql_num_rows($resultcoa) > 0) {
			while ($res1 = mysql_fetch_array($resultcoa)) {
				$arraycoa[] = array("kode_coa" => $res1['kode_coa'],"nama_coa" => $res1['nama']);
			}
		}

		$_SESSION['load_gm'.$id_form.''] = $array;
		$_SESSION['load_coa'.$id_form.''] = $arraycoa;

		echo view_item_gm($array,$arraycoa);
	}

// TAMPILAN DETAIL TRANSAKSI SAAT INSERT
	function view_item_gm($array,$arraycoa) {
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
									<td>
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
										<input class="form-control" type="text" name="nominal_pelunasan[]" id="nominal_pelunasan[]" data-id="nominal_pelunasan" data-group="'.$n.'" value="'.($item['nominal_pelunasan']).'" readonly style="text-align:right"/>
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
								<input class="form-control a" type="text" name="tot_nom_pel" id="tot_nom_pel" autocomplete="off" value="0" readonly style="text-align:right; font-weight: bold;"/>
							</td>
							<td></td>
						</tr>';

				$html .= "<script>$('.hapus-gm').click(function(){
							var id =	$(this).attr('data-id');
							var id_form = $('#id_form').val();
							$.ajax({
								type: 'POST',
								url: '".base_url()."ajax/j_gm.php?func=hapus-gm',
								data: 'idhapus=' + id + '&id_form=' +id_form,
								cache: false,
								success:function(data){
									$('#detail_input_gm').html(data).show();
								 }
							  });
						  });
					     </script>";
		}else{
				$html .= '<tr> <td colspan="9" class="text-center"> Tidak ada item barang. </td></tr>';
		}

		return $html;
	}

// LOAD PAYMENT GIRO SAAT PENGEMBALIAN
	if (isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "addgirotarik" )
	{
		if(isset($_POST['kode_gm']) and (@$_POST['kode_gm'] != "" )){

			$id_form	= $_POST['id_form'];
			$kode_gm 	= $_POST['kode_gm'];

			$payment_giro	= mysql_query("SELECT * FROM payment_giro where kode_giro = '".$kode_gm."'");

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

// INSER PAYMENT GIRO SAAT INSERT + PENGEMBALIAN
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

// TAMPILAN DETAIL PAYMENT GIRO SAAT INSERT + PEMNGEMBALIAN
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
								<input class="form-control" type="hidden" name="nominal[]" id="nominal[]" value="'.$item['nominal'].'"/>
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
								<input class="form-control" type="text" name="subtotal_giro" id="subtotal_giro" autocomplete="off" value="'.$subtotal.'" readonly style="text-align:right; font-weight: bold;"/>
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
								url: '".base_url()."ajax/j_gm.php?func=hapus-giro',
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

//HAPUS PAYMENT GIRO SAAT TAMBAH GIRO -> INSERT + PENGEMBALIAN
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "hapus-giro" )
	{
		$id = $_POST['idhapus'];
		unset($_SESSION['data_giro'][$id]);
		echo view_item_giro($_SESSION['data_giro']);
	}

// INSERT GIRO MASUK
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save" )
	{
		mysqli_autocommit($con,FALSE);

		$form 			= 'GM';
		$ref 			= $_POST['ref'];
		$tgl_buat 		= date("Y-m-d",strtotime($_POST['tgl_buat']));
		$kode_cabang 	= $_POST['kode_cabang'];
		$kode_pelanggan = $_POST['kode_pelanggan'];
		$keterangan_hdr = $_POST['keterangan_hdr'];
		$selisih 		= $_POST['selisih'];

		$kode_coa_selisih = $_POST['kode_coa_selisih'];
		$pisah			  = explode(":",$kode_coa_selisih);
		$kd_coa_selisih   = $pisah[0];

		$user_pencipta  = $_SESSION['app_id'];
		$tgl_input 		= date("Y-m-d H:i:s");

		$thnblntgl 		= date("ymd",strtotime($_POST['tgl_buat']));
		$kode_gm 		= buat_kode_gm($thnblntgl,$form,$kode_cabang);
		$id_form 		= $_POST['id_form'];

		//VARIABEL AWAL
		$subtotal 		= 0;
		$grand 			= 0;
		$tot_nom_pel 	= 0;
		$jumlah 		= 0;
		$subtotal_giro  = 0;

		if(isset($_SESSION['load_gm'.$id_form .'']) and count($_SESSION['load_gm'.$id_form .'']) > 0)
		{

			$mySql	= "INSERT INTO `gm_hdr` SET
							`kode_gm`			='".$kode_gm."',
							`ref`				='".$ref."',
							`tgl_buat`		='".$tgl_buat."',
							`kode_cabang` 	='".$kode_cabang."',
							`kode_pelanggan`	='".$kode_pelanggan."',
							`keterangan_hdr`	='".$keterangan_hdr."',
							`selisih` 		='".str_replace(',', null, $selisih)."',
							`kode_coa_selisih`='".$kode_coa_selisih."',
							`user_pencipta`	='".$user_pencipta."',
							`tgl_input`		='".$tgl_input."'
					  ";
			$query = mysqli_query ($con,$mySql) ;

			$mySql10	= "INSERT INTO `gm_hdr_history` SET
							`kode_gm`			='".$kode_gm."',
							`ref`				='".$ref."',
							`tgl_buat`		='".$tgl_buat."',
							`kode_cabang` 	='".$kode_cabang."',
							`kode_pelanggan`	='".$kode_pelanggan."',
							`keterangan_hdr`	='".$keterangan_hdr."',
							`selisih` 		='".str_replace(',', null, $selisih)."',
							`kode_coa_selisih`='".$kode_coa_selisih."',
							`user_pencipta`	='".$user_pencipta."',
							`tgl_input`		='".$tgl_input."'
					  ";
			$query10 = mysqli_query ($con,$mySql10) ;

			//DETAIL PEMBAYARAN GIRO
			$arraygiro = $_SESSION['data_giro'];
				foreach($arraygiro as $keygiro=>$itemgiro){

					$bank_giro 	= $itemgiro['bank_giro'];
					$no_giro 	= $itemgiro['no_giro'];
					$tgl_giro 	= date("Y-m-d",strtotime($itemgiro['tgl_giro']));
					$nominal 	= $itemgiro['nominal'];

					$mySql9 = "INSERT INTO `payment_giro` SET
								`kode_giro`   ='".$kode_gm."',
								`bank_giro` ='".$bank_giro."',
								`no_giro`   ='".$no_giro."',
								`tgl_giro`  ='".$tgl_giro."',
								`nominal`   ='".str_replace(',', null, $nominal)."' ";
					$query9 = mysqli_query ($con,$mySql9) ;
					
					$mySql7 = "INSERT INTO `jurnal` SET
								`kode_transaksi` 	='".$kode_gm."',
								`tgl_input` 		='".date('Y-m-d H:i:s')."',
								`tgl_buat` 		='".$tgl_buat."',
								`kode_pelanggan` 	='".$kode_pelanggan."',
								`kode_cabang` 	='".$kode_cabang."',
								`keterangan_hdr`  ='".$keterangan_hdr."',
								`keterangan_dtl`  ='".$keterangan_dtl."',
								`ref` 		 	='".$ref."',
								`kode_coa` 		='1.01.03.02',
								`debet` 			='".str_replace(',', null, $nominal)."',
								`user_pencipta` 	='".$_SESSION['app_id']."'";

					$query7 = mysqli_query ($con,$mySql7) ;
					
					//CREATE KARTU GIRO
					$mySql8 = "INSERT INTO `kartu_giro` SET
								`kode_transaksi` 	='".$kode_gm."',
								`inisial` 		='GM',
								`debet` 			='".str_replace(',', null, $nominal)."',
								`kode_pelanggan` 	='".$kode_pelanggan."',
								`kode_cabang` 	='".$kode_cabang."',
								`bank_giro` ='".$bank_giro."',
								`no_giro`   ='".$no_giro."',
								`tgl_buat` 		='".$tgl_buat."',
								`tgl_jth_tempo` 	='".$tgl_jatuh_tempo."',
								`user_pencipta` 	='".$_SESSION['app_id']."',
								`tgl_input`		='".date('Y-m-d H:i:s')."' ";

					$query8 = mysqli_query ($con,$mySql8) ;

					$mySql11 = "INSERT INTO `payment_giro_history` SET
								`kode_giro` ='".$kode_gm."',
								`bank_giro` ='".$bank_giro."',
								`no_giro`   ='".$no_giro."',
								`tgl_giro`  ='".$tgl_giro."',
								`nominal`   ='".str_replace(',', null, $nominal)."' ";
					$query11 = mysqli_query ($con,$mySql11) ;
			}

			$payment_giro  = mysql_query("SELECT SUM(nominal) subtotal_giro FROM payment_giro WHERE kode_giro = '".$kode_gm."'");
			$num_rows_pg = mysql_num_rows($payment_giro);
			if($num_rows_pg>0){
				$row_pg 	   = mysql_fetch_array($payment_giro);

				$subtotal_giro = (int)$row_pg['subtotal_giro'];
			}

			//DETAIL GIRO MASUK
			$array = $_SESSION['load_gm'.$id_form .''];
				foreach($array as $key=>$item){

					$no_gm 					= $kode_gm;
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
							$mySql1 = "INSERT INTO `gm_dtl` SET
										`kode_gm` 		  ='".$no_gm."',
										`deskripsi` 		  ='".$deskripsi."',
										`saldo_transaksi`   ='".str_replace(',', null, $saldo_transaksi)."',
										`nominal_bayar`	  ='".str_replace(',', null, $nominal_bayar)."',
										`nominal_pelunasan` ='".str_replace(',', null, $nominal_pelunasan)."',
										`tgl_input`		  ='".$tgl_input."',
										`tgl_jatuh_tempo`   ='".$tgl_jatuh_tempo."',
										`keterangan_dtl`	  ='".$keterangan_dtl."' ";

							$query1 = mysqli_query ($con,$mySql1) ;

							$mySql12 = "INSERT INTO `gm_dtl_history` SET
										`kode_gm` 		  ='".$no_gm."',
										`deskripsi` 		  ='".$deskripsi."',
										`saldo_transaksi`   ='".str_replace(',', null, $saldo_transaksi)."',
										`nominal_bayar`	  ='".str_replace(',', null, $nominal_bayar)."',
										`nominal_pelunasan` ='".str_replace(',', null, $nominal_pelunasan)."',
										`tgl_input`		  ='".$tgl_input."',
										`tgl_jatuh_tempo`   ='".$tgl_jatuh_tempo."',
										`keterangan_dtl`	  ='".$keterangan_dtl."' ";

							$query12 = mysqli_query ($con,$mySql12) ;

							//CREATE KARTU PIUTANG+
							$mySql2 = "INSERT INTO `kartu_piutang` SET
										`kode_transaksi` 	='".$deskripsi."',
										`kode_pelunasan` 	='".$no_gm."',
										`kredit` 			='".str_replace(',', null, $nominal_bayar)."',
										`lunas` 			='".$stat_lunas."',
										`kode_pelanggan` 	='".$kode_pelanggan."',
										`kode_cabang` 	='".$kode_cabang."',
										`tgl_buat` 		='".$tgl_buat."',
										`tgl_jth_tempo` 	='".$tgl_jatuh_tempo."',
										`user_pencipta` 	='".$_SESSION['app_id']."',
										`tgl_input`		='".date('Y-m-d H:i:s')."' ";

							$query2 = mysqli_query ($con,$mySql2) ;

							$fj = mysql_query("SELECT SUBSTRING(kode_transaksi,11,2) kode FROM kartu_piutang WHERE kode_transaksi= '".$deskripsi."'");
							$num_rows_fj = mysql_num_rows($fj);
								if($num_rows_fj>0){
									$row_fj = mysql_fetch_array($fj);

									if($row_fj['kode'] == 'FJ'){
										$mySql3 = "UPDATE fj_dtl SET status_dtl ='3' WHERE kode_fj = '".$deskripsi."'";
										$query3 = mysqli_query ($con,$mySql3) ;

										$mySql4 = "UPDATE fj_hdr SET status ='3' WHERE kode_fj = '".$deskripsi."'";
										$query4 = mysqli_query ($con,$mySql4) ;
									}elseif($row_fj['kode'] == 'RJ'){
										$mySql3 = "UPDATE rj_dtl SET status_dtl ='3' WHERE kode_rj = '".$deskripsi."'";
										$query3 = mysqli_query ($con,$mySql3) ;

										$mySql4 = "UPDATE rj_hdr SET status ='3' WHERE kode_rj = '".$deskripsi."'";
										$query4 = mysqli_query ($con,$mySql4) ;
									}else{
										$mySql3 = "UPDATE nb_dtl SET status_dtl ='3' WHERE kode_nb = '".$deskripsi."'";
										$query3 = mysqli_query ($con,$mySql3) ;
										
										$mySql4 = true;
										$query4 = true;
									}
								}

							$grand += str_replace(',', null, $nominal_bayar);

							//INSERT JURNAL KREDIT
						    $mySql5 = "INSERT INTO `jurnal` SET
										`kode_transaksi` 	='".$no_gm."',
										`tgl_input` 		='".date('Y-m-d H:i:s')."',
									    `tgl_buat` 		='".$tgl_buat."',
										`kode_pelanggan` 	='".$kode_pelanggan."',
										`kode_cabang` 	='".$kode_cabang."',
										`keterangan_hdr` 	='".$keterangan_hdr."',
									    `ref` 			='".$ref."',
										`kode_coa` 		='1.01.03.01',
									    `kredit`  			='".(str_replace(',', null, $nominal_pelunasan))."',
									    `user_pencipta` 	='".$_SESSION['app_id']."'";
							//die($mySql5);
							$query5 = mysqli_query ($con,$mySql5) ;

							//JURNAL JIKA ADA SELISIH
							if(str_replace(',', null, $selisih)>0){
								$mySql6 = "INSERT INTO `jurnal` SET
											`kode_transaksi` 	='".$no_gm."',
											`tgl_input` 		='".date('Y-m-d H:i:s')."',
											`tgl_buat` 		='".$tgl_buat."',
											`kode_pelanggan` 	='".$kode_pelanggan."',
											`kode_cabang` 	='".$kode_cabang."',
											`keterangan_hdr` 	='".$keterangan_hdr."',
											`ref` 			='".$ref."',
											`kode_coa` 		='".$kd_coa_selisih."',
											`debet` 			='".(str_replace(',', null, $selisih))."',
											`user_pencipta` 	='".$_SESSION['app_id']."'";

								$query6 = mysqli_query ($con,$mySql6) ;

							}elseif(str_replace(',', null, $selisih)<0){
								$mySql6 = "INSERT INTO `jurnal` SET
											`kode_transaksi` 	='".$no_gm."',
											`tgl_input` 		='".date('Y-m-d H:i:s')."',
											`tgl_buat` 		='".$tgl_buat."',
											`kode_pelanggan` 	='".$kode_pelanggan."',
											`kode_cabang` 	='".$kode_cabang."',
											`keterangan_hdr`	='".$keterangan_hdr."',
											`ref` 			='".$ref."',
											`kode_coa` 		='".$kd_coa_selisih."',
											`kredit` 			='".abs((str_replace(',', null, $selisih)))."',
											`user_pencipta` 	='".$_SESSION['app_id']."'";

								$query6 = mysqli_query ($con,$mySql6) ;

							}else{
								$mySql6 = "UPDATE jurnal SET user_pencipta ='".$_SESSION['app_id']."' WHERE kode_transaksi='".$no_gm."'";

								$query6 = mysqli_query ($con,$mySql6) ;

							}

					}
				}

				$mySql13 = "INSERT INTO `kartu_giro_history` SET
							`kode_transaksi` 	='".$no_gm."',
							`inisial` 		='GM',
							`debet` 			='".str_replace(',', null, $nominal)."',
							`kode_pelanggan` 	='".$kode_pelanggan."',
							`kode_cabang` 	='".$kode_cabang."',
							`tgl_buat` 		='".$tgl_buat."',
							`tgl_jth_tempo` 	='".$tgl_jatuh_tempo."',
							`user_pencipta` 	='".$_SESSION['app_id']."',
							`tgl_input`		='".date('Y-m-d H:i:s')."' ";

				$query13 = mysqli_query ($con,$mySql13) ;
			
			if ($query AND @$query1 AND $query2 AND $query3 AND $query4 AND $query5 AND $query6 AND $query7 AND $query8 AND $query9 AND $query10 AND $query11 AND $query12 AND $query13) {

				// Commit Transaction
				mysqli_commit($con);

				// Close connection
				mysqli_close($con);

				unset($_SESSION['load_gm'.$id_form .'']);
				unset($_SESSION['data_giro'.$id_form .'']);
				echo "00||$kode_gm";
			} else {
				echo "99||Gagal Input";
			}

		} else {
			echo "99|| Harap Pilih Giro Detail Terlebih Dahulu !";
		}

	}

// PEMBATALAN GIRO MASUK
	// if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "pembatalan" )
	// {
	// 	mysqli_autocommit($con,FALSE);

	// 	$kode_gm		= $_POST['kode_gm_batal'];
	// 	$kode_cabang	= $_POST['kode_cabang_batal'];
	// 	$kode_pelanggan	= $_POST['kode_pelanggan_batal'];
	// 	$alasan_batal	= $_POST['alasan_batal'];
	// 	$tgl_batal 		= date("Y-m-d");
	// 	$tgl_input 		= date("Y-m-d H:i:s");

	// 	$form 			= 'GMB';
	// 	$thnblntgl 		= date("ymd",strtotime($tgl_batal));
	// 	$kode_gm_action = buat_kode_gm($thnblntgl,$form,$kode_cabang);

	// 	//INSERT GM_HDR_HISTORY + UPDATE GM_HDR
	// 	$gm_hdr = mysql_query("SELECT * FROM gm_hdr WHERE kode_gm = '".$kode_gm."'");
	// 	$num_row_gm_hdr = mysql_num_rows($gm_hdr);

	// 	if($num_row_gm_hdr > 0){
	// 		while($row_gm_hdr = mysql_fetch_array($gm_hdr)){

	// 			$mySql10	= "INSERT INTO gm_hdr_history SET
	// 							kode_gm			='".$kode_gm."',
	// 							kode_gm_action	='".$kode_gm_action."',
	// 							ref				='".$row_gm_hdr['ref']."',
	// 							tgl_buat		='".$row_gm_hdr['tgl_buat']."',
	// 							kode_cabang 	='".$kode_cabang."',
	// 							kode_pelanggan	='".$kode_pelanggan."',
	// 							keterangan_hdr	='".$row_gm_hdr['keterangan_hdr']."',
	// 							selisih 		='".$row_gm_hdr['selisih']."',
	// 							kode_coa_selisih='".$row_gm_hdr['kode_coa_selisih']."',
	// 							user_pencipta	='".$row_gm_hdr['user_pencipta']."',
	// 							tgl_input		='".$tgl_input."',
	// 							status 			='2',
	// 							alasan_batal	='".$alasan_batal."',
	// 							tgl_batal		='".$tgl_batal."'
	// 					  ";
	// 			$query10 = mysqli_query ($con,$mySql10) ;

	// 		}
	// 	}

	// 	//AKTIF = 1 [NON AKTIF] UNTUK KODE GM YANG DIBATALKAN
	// 	$aktif1 = mysql_query("UPDATE gm_hdr_history SET aktif = '1' WHERE kode_gm = '".$kode_gm."'");

	// 	$mySql1 = "UPDATE gm_hdr SET status ='2', alasan_batal='".$alasan_batal."', tgl_batal='".$tgl_batal."' WHERE kode_gm ='".$kode_gm."' ";
	// 	$query1 = mysqli_query ($con,$mySql1) ;


	// 	//INSERT GM_DTL_HISTORY + UPDATE GM_DTL
	// 	$gm_dtl = mysql_query("SELECT * FROM gm_dtl WHERE kode_gm = '".$kode_gm."'");

	// 	$mySql11 = "INSERT INTO gm_dtl_history (kode_gm, kode_gm_action, deskripsi, saldo_transaksi, nominal_bayar, nominal_pelunasan, tgl_input, tgl_jatuh_tempo, keterangan_dtl) VALUES ";
	// 	while($row_gm_dtl = mysql_fetch_array($gm_dtl)){
	// 		$mySql11 .= "('{$kode_gm}','{$kode_gm_action}','{$row_gm_dtl['deskripsi']}','{$row_gm_dtl['saldo_transaksi']}','{$row_gm_dtl['nominal_bayar']}','{$row_gm_dtl['nominal_pelunasan']}','{$tgl_input}','{$row_gm_dtl['tgl_jatuh_tempo']}','{$row_gm_dtl['keterangan_dtl']}')";
	// 			$mySql11 .= ",";
	// 	}

	// 	$mySql11 = rtrim($mySql11,",");

	// 	$query11 = mysqli_query ($con,$mySql11) ;

	// 	$mySql2 = "UPDATE gm_dtl SET status_dtl ='2' WHERE kode_gm='".$kode_gm."' ";
	// 	$query2 = mysqli_query ($con,$mySql2) ;

	// 	//INSERT PAYMENT GIRO
	// 	$payment_giro = mysql_query("SELECT * FROM payment_giro WHERE kode_giro = '".$kode_gm."'");
	// 	$num_row_pg = mysql_num_rows($payment_giro);

	// 	if($num_row_pg > 0){
	// 		while($row_pg = mysql_fetch_array($payment_giro)){

	// 			$bank_giro 	= $row_pg['bank_giro'];
	// 			$no_giro 	= $row_pg['no_giro'];
	// 			$tgl_giro 	= $row_pg['tgl_giro'];
	// 			$nominal 	= $row_pg['nominal'];

	// 			$mySql11= "UPDATE payment_giro SET status_batal ='1' WHERE kode_giro = '".$kode_gm."'";
	// 			$query11 = mysqli_query ($con,$mySql11) ;
	// 		}
	// 	}

	// 	$kode_deskripsi = mysql_query("SELECT deskripsi FROM gm_dtl WHERE kode_gm = '".$kode_gm."' ");
	// 	$num_row_desc = mysql_num_rows($kode_deskripsi);

	// 	if($num_row_desc > 0){
	// 		while($row_desc = mysql_fetch_array($kode_deskripsi)){

	// 			$kode = $row_desc['deskripsi'];
	// 			$kd	  = SUBSTR($kode, -6, 2);

	// 			if($kd == 'FJ'){
	// 				$mySql3 = "UPDATE fj_hdr SET status ='1' WHERE kode_fj = '".$kode."' ";
	// 				$query3 = mysqli_query ($con,$mySql3) ;

	// 				$mySql4 = "UPDATE fj_dtl SET status_dtl ='1' WHERE kode_fj = '".$kode."' ";
	// 				$query4 = mysqli_query ($con,$mySql4) ;

	// 				//INSERT KARTU_PIUTANG
	// 				$piutang = mysql_query("SELECT * FROM kartu_piutang WHERE kode_transaksi = '".$kode."' AND kode_pelunasan = '".$kode_gm."'");
	// 				$num_row_p  = mysql_num_rows($piutang);

	// 				if($num_row_p > 0){
	// 					while($row_p = mysql_fetch_array($piutang)){

	// 						$kode_transaksi 	= $row_p['kode_transaksi'];
	// 						$kode_pelunasan 	= $row_p['kode_pelunasan'];
	// 						$debet 				= $row_p['debet'];
	// 						$kredit 			= $row_p['kredit'];
	// 						$kode_cabang 		= $row_p['kode_cabang'];
	// 						$tgl_jth_tempo 		= $row_p['tgl_jth_tempo'];

	// 						$mySql5 = "INSERT INTO kartu_piutang SET
	// 										kode_transaksi 	='".$kode_transaksi."',
	// 										kode_pelunasan 	='".$kode_pelunasan."',
	// 										debet 			='".$kredit."',
	// 										kredit 			='".$debet."',
	// 										kode_cabang 	='".$kode_cabang."',
	// 										kode_pelanggan 	='".$kode_pelanggan."',
	// 										tgl_buat  		='".$tgl_batal."',
	// 										tgl_jth_tempo  	='".$tgl_jth_tempo."',
	// 										tgl_input 		='".$tgl_input."'
	// 									";
	// 						$query5 = mysqli_query ($con,$mySql5) ;

	// 						$mySql6 = "UPDATE kartu_piutang SET status_batal = '1' WHERE kode_transaksi = '".$kode_transaksi."' AND kode_pelunasan = '".$kode_pelunasan."'";
	// 						$query6 = mysqli_query ($con,$mySql6) ;
	// 					}
	// 				}

	// 				//INSERT KARTU_GIRO
	// 				$giro = mysql_query("SELECT * FROM kartu_giro WHERE kode_transaksi = '".$kode_gm."'");
	// 				$num_row_g  = mysql_num_rows($giro);

	// 				if($num_row_g > 0){
	// 					while($row_g = mysql_fetch_array($giro)){

	// 						$kode_transaksi_giro 	= $row_g['kode_transaksi'];
	// 						$kode_pelunasan_giro 	= $row_g['kode_pelunasan'];
	// 						$debet_giro 			= $row_g['debet'];
	// 						$kredit_giro 			= $row_g['kredit'];

	// 						$mySql7 = "INSERT INTO kartu_giro SET
	// 										kode_transaksi 	='".$kode_transaksi_giro."',
	// 										kode_pelunasan 	='".$kode_pelunasan_giro."',
	// 										debet 			='".$kredit_giro."',
	// 										kredit 			='".$debet_giro."',
	// 										kode_cabang 	='".$kode_cabang."',
	// 										kode_pelanggan 	='".$kode_pelanggan."',
	// 										tgl_buat  		='".$tgl_batal."',
	// 										tgl_jth_tempo  	='".$tgl_jth_tempo."',
	// 										tgl_input 		='".$tgl_input."'
	// 									";
	// 						$query7 = mysqli_query ($con,$mySql7);

	// 						$mySql8 = "UPDATE kartu_giro SET status_batal ='1' WHERE kode_transaksi = '".$kode_gm."'";
	// 						$query8 = mysqli_query ($con,$mySql8) ;
	// 					}
	// 				}
	// 			}
	// 		}
	// 	}

	// 	//INSERT JURNAL
	// 	$jurnal = mysql_query("SELECT * FROM jurnal WHERE kode_transaksi = '".$kode_gm."' ");
	// 	$num_row_j  = mysql_num_rows($jurnal);

	// 	if($num_row_j > 0){
	// 		while($row_j = mysql_fetch_array($jurnal)){

	// 			$kode_transaksi 	= $row_j['kode_transaksi'];
	// 			$ref 				= $row_j['ref'];
	// 			$tgl_buat 			= $row_j['tgl_buat'];
	// 			$kode_supplier 		= $row_j['kode_supplier'];
	// 			$kode_coa 			= $row_j['kode_coa'];
	// 			$debet 				= $row_j['debet'];
	// 			$kredit 			= $row_j['kredit'];
	// 			$tgl_input 			= date("Y-m-d H:i:s");
	// 			$keterangan_hdr 	= $row_j['keterangan_hdr'];
	// 			$keterangan_dtl 	= $row_j['keterangan_dtl'];

	// 			$mySql9 = "INSERT INTO jurnal SET
	// 							kode_transaksi 	='".$kode_transaksi."',
	// 							ref 			='".$ref."',
	// 							tgl_buat 		='".$tgl_buat."',
	// 							kode_cabang 	='".$kode_cabang."',
	// 							kode_supplier 	='".$kode_supplier."',
	// 							kode_pelanggan 	='".$kode_pelanggan."',
	// 							kode_coa 		='".$kode_coa."',
	// 							debet  			='".$kredit."',
	// 							kredit  		='".$debet."',
	// 							tgl_input 		='".$tgl_input."',
	// 							keterangan_hdr 	='".$keterangan_hdr."',
	// 							keterangan_dtl 	='".$keterangan_dtl."'
	// 						";
	// 			$query9 = mysqli_query ($con,$mySql9) ;

	// 			$mySql10 = "UPDATE jurnal SET status_jurnal ='2' WHERE kode_transaksi = '".$kode_transaksi."' ";
	// 			$query10 = mysqli_query ($con,$mySql10) ;
	// 		}
	// 	}

	// 	if ($query1 AND $query2 AND $query3 AND $query4 AND $query5 AND $query6 AND $query7 AND $query8 AND $query9 AND $query10 AND $query11) {

	// 		mysqli_commit($con);
	// 		mysqli_close($con);

	// 		echo "00||".$kode_gm;
	// 	} else {
	// 		echo "Gagal query: ".mysql_error();
	// 	}
	// }

// PENGEMBALIAN GIRO MASUK
	// if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save_back" )
	// {
	// 	mysqli_autocommit($con,FALSE);

	// 	$kode_gm 		= $_POST['kode_gm'];
	// 	$ref 			= $_POST['ref'];
	// 	$tgl_buat 		= date("Y-m-d",strtotime($_POST['tgl_buat']));
	// 	$kode_cabang 	= $_POST['kode_cabang'];
	// 	$kode_pelanggan = $_POST['kode_pelanggan'];
	// 	$keterangan_hdr = $_POST['keterangan_hdr'];

	// 	$selisih 		= $_POST['selisih'];
	// 	$kode_coa_selisih = $_POST['kode_coa_selisih'];
	// 	$user_pencipta  = $_SESSION['app_id'];
	// 	$tgl_input 		= date("Y-m-d H:i:s");

	// 	$thnblntgl 		= date("ymd",strtotime($_POST['tgl_buat']));

	// 	//VARIABEL AWAL
	// 	$subtotal 		= 0;
	// 	$grand 			= 0;
	// 	$tot_nom_pel 	= 0;
	// 	$jumlah 		= 0;

	// 		$mySql	= "INSERT INTO gm_hdr SET
	// 						kode_gm			='".$kode_gm."',
	// 						ref				='".$ref."',
	// 						tgl_buat		='".$tgl_buat."',
	// 						kode_cabang 	='".$kode_cabang."',
	// 						kode_pelanggan	='".$kode_pelanggan."',
	// 						keterangan_hdr	='".$keterangan_hdr."',
	// 						selisih 		='".$selisih."',
	// 						kode_coa_selisih='".$kode_coa_selisih."',
	// 						user_pencipta	='".$user_pencipta."',
	// 						tgl_input		='".$tgl_input."'
	// 				  ";

	// 		$query = mysqli_query ($con,$mySql) ;

	// 		//DETAIL GIRO MASUK
	// 		$array_dtl_back = $_SESSION['data_dtl_back'];
 //                foreach($array_dtl_back as $key=>$res_dtl){

	// 				$no_gm 					= $kode_gm;
	// 				$stat_cb 				= $_POST['stat_cb'][$key];
	// 				$deskripsi 				= $res_dtl['deskripsi'];
	// 				$saldo_transaksi 		= $res_dtl['saldo_transaksi'];
	// 				$nominal_bayar			= $_POST['nominal_bayar'][$key];
	// 				$nominal_pelunasan		= $_POST['nominal_pelunasan'][$key];
	// 				$keterangan_dtl			= $_POST['keterangan_dtl'][$key];
	// 				$tot_nom_pel			= $_POST['tot_nom_pel'];
	// 				$tgl_jatuh_tempo		= $res_dtl['tgl_jatuh_tempo'];
	// 				$nilai_total			= (int)$nominal_bayar+$selisih;
	// 				$subtotal 				+= $saldo_transaksi;

	// 				//JIKA JUMLAH BAYAR >= SALDO
	// 				if($nominal_bayar>=$saldo_transaksi) {
	// 					$stat_lunas='1';
	// 				}else{
	// 					$stat_lunas='0';
	// 				}

	// 				if($stat_cb=='1') {

	// 						$mySql1 = "INSERT INTO gm_dtl SET
	// 									kode_gm 		  ='".$no_gm."',
	// 									deskripsi 		  ='".$deskripsi."',
	// 									saldo_transaksi   ='".$saldo_transaksi."',
	// 									nominal_bayar	  ='".$nominal_bayar."',
	// 									nominal_pelunasan ='".$nominal_pelunasan."',
	// 									tgl_input		  ='".$tgl_input."',
	// 									tgl_jatuh_tempo   ='".$tgl_jatuh_tempo."',
	// 									keterangan_dtl	  ='".$keterangan_dtl."'
	// 								";

	// 						$query1 = mysqli_query ($con,$mySql1) ;

	// 						//CREATE KARTU PIUTANG
	// 						$mySql2 = "INSERT INTO kartu_piutang SET
	// 									kode_transaksi 	='".$deskripsi."',
	// 									kode_pelunasan 	='".$no_gm."',
	// 									kredit 			='".$nominal_bayar."',
	// 									lunas 			='".$stat_lunas."',
	// 									kode_pelanggan 	='".$kode_pelanggan."',
	// 									kode_cabang 	='".$kode_cabang."',
	// 									tgl_buat 		='".$tgl_buat."',
	// 									tgl_jth_tempo 	='".$tgl_jatuh_tempo."',
	// 									user_pencipta 	='".$_SESSION['app_id']."',
	// 									tgl_input		='".date('Y-m-d H:i:s')."' ";

	// 						$query2 = mysqli_query ($con,$mySql2) ;

	// 						$fj = mysql_query("SELECT SUBSTRING(kode_transaksi,11,2) kode_fj FROM kartu_piutang WHERE kode_transaksi= '".$deskripsi."'");
	// 						$num_rows_fj = mysql_num_rows($fj);
	// 							if($num_rows_fj>0){
	// 								$row_fj = mysql_fetch_array($fj);

	// 								if($row_fj['kode_fj'] == 'FJ'){
	// 									$mySql3 = "UPDATE fj_dtl SET status_dtl ='3' WHERE kode_fj = '".$deskripsi."'";
	// 									$query3 = mysqli_query ($con,$mySql3) ;

	// 									$mySql4 = "UPDATE fj_hdr SET status ='3' WHERE kode_fj = '".$deskripsi."'";
	// 									$query4 = mysqli_query ($con,$mySql4) ;
	// 								}else{
	// 									$mySql3 = "UPDATE nb_dtl SET status_dtl ='3' WHERE kode_nb = '".$deskripsi."'";
	// 									$query3 = mysqli_query ($con,$mySql3) ;
	// 								}
	// 							}

	// 						$grand += $nominal_bayar;

	// 						//INSERT JURNAL DEBET
	// 					    $mySql5 = "INSERT INTO jurnal SET
	// 									kode_transaksi 	='".$no_gm."',
	// 									tgl_input 		='".date('Y-m-d H:i:s')."',
	// 								    tgl_buat 		='".$tgl_buat."',
	// 									kode_pelanggan 	='".$kode_pelanggan."',
	// 									kode_cabang 	='".$kode_cabang."',
	// 									keterangan_hdr 	='".$keterangan_hdr."',
	// 								    ref 			='".$ref."',
	// 									kode_coa 		='1.01.10.01',
	// 								    debet  			='".($nominal_bayar)."',
	// 								    user_pencipta 	='".$_SESSION['app_id']."'";

	// 						$query5 = mysqli_query ($con,$mySql5) ;

	// 						//JURNAL JIKA ADA SELISIH
	// 						if($selisih>0){
	// 							$mySql6 = "INSERT INTO jurnal SET
	// 										kode_transaksi 	='".$no_gm."',
	// 										tgl_input 		='".date('Y-m-d H:i:s')."',
	// 										tgl_buat 		='".$tgl_buat."',
	// 										kode_pelanggan 	='".$kode_pelanggan."',
	// 										kode_cabang 	='".$kode_cabang."',
	// 										keterangan_hdr 	='".$keterangan_hdr."',
	// 										ref 			='".$ref."',
	// 										kode_coa 		='".$kode_coa_selisih."',
	// 										debet 			='".($selisih)."',
	// 										user_pencipta 	='".$_SESSION['app_id']."'";

	// 							$query6 = mysqli_query ($con,$mySql6) ;

	// 						}elseif($selisih<0){
	// 							$mySql6 = "INSERT INTO jurnal SET
	// 										kode_transaksi 	='".$no_gm."',
	// 										tgl_input 		='".date('Y-m-d H:i:s')."',
	// 										tgl_buat 		='".$tgl_buat."',
	// 										kode_pelanggan 	='".$kode_pelanggan."',
	// 										kode_cabang 	='".$kode_cabang."',
	// 										keterangan_hdr	='".$keterangan_hdr."',
	// 										ref 			='".$ref."',
	// 										kode_coa 		='".$kode_coa_selisih."',
	// 										kredit 			='".abs(($selisih))."',
	// 										user_pencipta 	='".$_SESSION['app_id']."'";

	// 							$query6 = mysqli_query ($con,$mySql6) ;

	// 						}else{
	// 							$mySql6 = "UPDATE jurnal SET user_pencipta ='".$_SESSION['app_id']."' WHERE kode_transaksi='".$no_gm."'";

	// 							$query6 = mysqli_query ($con,$mySql6) ;

	// 						}

	// 						$mySql7 = "INSERT INTO jurnal SET
	// 									kode_transaksi 	='".$no_gm."',
	// 									tgl_input 		='".date('Y-m-d H:i:s')."',
	// 									tgl_buat 		='".$tgl_buat."',
	// 									kode_pelanggan 	='".$kode_pelanggan."',
	// 									kode_cabang 	='".$kode_cabang."',
	// 									keterangan_hdr  ='".$keterangan_hdr."',
	// 									keterangan_dtl  ='".$keterangan_dtl."',
	// 									ref 		 	='".$_POST['ref']."',
	// 									kode_coa 		='1.01.03.01',
	// 									kredit 			='".$nominal_pelunasan."',
	// 									user_pencipta 	='".$_SESSION['app_id']."'";

	// 						$query7 = mysqli_query ($con,$mySql7) ;


	// 				}
	// 		}

	// 		//PAYMENT GIRO MASUK
	// 		$sub_nominal = 0;
	// 		$array_giro = $_SESSION['data_giro'];
 //                foreach($array_giro as $key=>$res_g){

	// 				$bank_giro 	= $res_g['bank_giro'];
	// 				$no_giro 	= $res_g['no_giro'];
	// 				$tgl_giro	= $res_g['tgl_giro'];
	// 				$nominal 	= $res_g['nominal'];

	// 				$sub_nominal += $nominal;

	// 				$mySql8 = "INSERT INTO payment_giro SET
	// 						kode_giro 	='".$kode_gm."',
	// 						bank_giro 	='".$bank_giro."',
	// 						no_giro 	='".$no_giro."',
	// 						tgl_giro 	='".$tgl_giro."',
	// 						nominal 	='".$nominal."' ";

	// 				$query8 = mysqli_query ($con,$mySql8) ;

	// 			}

	// 		//CREATE KARTU GIRO
	// 			$mySql9 = "INSERT INTO kartu_giro SET
	// 						kode_transaksi 	='".$no_gm."',
	// 						inisial 		='GM',
	// 						debet 			='".$sub_nominal."',
	// 						kode_pelanggan 	='".$kode_pelanggan."',
	// 						kode_cabang 	='".$kode_cabang."',
	// 						tgl_buat 		='".$tgl_buat."',
	// 						tgl_jth_tempo 	='".$tgl_jatuh_tempo."',
	// 						user_pencipta 	='".$_SESSION['app_id']."',
	// 						tgl_input		='".date('Y-m-d H:i:s')."' ";

	// 			$query9 = mysqli_query ($con,$mySql9) ;

	// 		if ($query AND @$query1 AND $query2 AND $query3 AND $query4 AND $query5 AND $query6 AND $query7 AND $query8 AND $query9 AND $query10) {

	// 			// Commit Transaction
	// 			mysqli_commit($con);

	// 			// Close connection
	// 			mysqli_close($con);
	// 			echo "00||$kode_gm";
	// 		} else {
	// 			echo "99||Gagal Input";
	// 		}

	// }


?>
