<?php

	session_start();

	require('../library/conn.php');

	require('../library/helper.php');

	require('../pages/data/script/op.php'); 

	date_default_timezone_set("Asia/Jakarta");

	

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "addum" )

	{

		if(isset($_POST['um']) and (@$_POST['um'] != "" )){

			$um = $_POST['um'];

			$nominal = $_POST['nominal'];	

			$id_um = $_POST['id_um'];

			

			$array = array();

			if(!isset($_SESSION['data_um'])) {

							$array[$id_um] = array("id_um" => $id_um,"um" => $um, "nominal" => $nominal);

			} else {

							$array = $_SESSION['data_um'];

								$array[$id_um] = array("id_um" => $id_um,"um" => $um, "nominal" => $nominal);

			}

			

			$_SESSION['data_um'] = $array;

			echo view_item_um($array);

		

		}

	}

	

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "hapus-um" )

	{

		$id = $_POST['idhapus'];

		unset($_SESSION['data_um'][$id]);

		echo view_item_um($_SESSION['data_um']);

	}

	

	function view_item_um($data) {

		$n = 1;

		$html = "";

		$grandtotal = 0;

		$total= 0;

		if(count($data) > 0) {

			foreach($data as $key=>$item){

				

				$total += ($item['um']);

				$html .= '<div class="row">';

				$html .= '<div class="container">';

				$html .= '&nbsp;';

				$html .= '</div>';

				$html .= '</div>';

				$html .= '<div class="row">';

				$html .= '<div class="container">';

				$html .= '<label class="col-lg-2 control-label" style="text-align:left"></label>';

				

				$html .= '<div class="col-lg-3 col-md-3 col-xs-4">

						<input type="text" readonly name="um1[]" data-id="um1" data-group="'.$item['id_um'].'" class="form-control" placeholder="Uang Muka %" value="'.$item['um'].'%">

					</div>

					

					<div class="col-lg-3 col-md-3 col-xs-4">

						 <input type="text" readonly name="nominal[]" data-id="nominal1" data-group="'.$item['id_um'].'" class="form-control" placeholder="0" value="'.$item['nominal'].'" >	

					</div>

					

					<button class="btn btn-danger remove hapus-um col-lg-2 col-md-2 col-xs-" type="button" data-id="'.$key.'"><i class="glyphicon glyphicon-remove"></i> Hapus.</button>';

				$html .= '</div>';

				$html .= '</div>';

			}

			$html .= "<script>$('.hapus-um').click(function(){

						var id =	$(this).attr('data-id');

						$.ajax({

							type: 'POST',

							url: '".base_url()."ajax/j_op.php?func=hapus-um',

							data: 'idhapus=' + id ,

							cache: false,

							success:function(data){

								var html = $('.copy').html(data);

									$('.after-add-more').after(html);

									

									$('body').on('click','.remove',function(){ 

									  $(this).parents('.control-group').remove();

									});

									

									$('#um').focus();

							 }

						  });

					  });

				     </script>";

		}

		return $html;

	}



	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loadppn" )

	{
		$kode_supplier = mres($_POST['kode_supplier']);
		$q_ppn = mysql_query("SELECT `Ppn` FROM `supplier` WHERE `kode_supplier` = '" . $kode_supplier . "'");	
		$num_rows = mysql_num_rows($q_ppn);

		if($num_rows>0)
		{		
			$rowppn = mysql_fetch_array($q_ppn);
			if ($rowppn['Ppn'] === '1' || $rowppn['Ppn'] === 1) {
				echo '<input class="form-control" type="checkbox" name="ppn" id="ppn" checked><input class="form-control" type="hidden" name="stat_ppn" id="stat_ppn" value="1">';
			} else {
				echo '<input class="form-control" type="checkbox" name="ppn" id="ppn"><input class="form-control" type="hidden" name="stat_ppn" id="stat_ppn" value="0">';
			}
		}
		else {
			echo '<input class="form-control" type="checkbox" name="ppn" id="ppn"><input class="form-control" type="hidden" name="stat_ppn" id="stat_ppn" value="0">';			
		}
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loadhistory" )
	{
		$kd_barang = '';
		$kode_inventori = mres($_POST['kode_inventori']);
		if(!empty($kode_inventori))
		{
			$pisah=explode(":",$kode_inventori);
			$kd_barang=$pisah[0];
			$nm_barang=$pisah[1];
		}		

		$q_his = mysql_query("SELECT `opd`.`kode_op`, `opd`.`kode_barang`, `opd`.`qty`, `opd`.`ppn`, `opd`.`qty_i`, SUBSTRING_INDEX(`opd`.`satuan`, ':', 1) AS `satuan`, SUBSTRING_INDEX(`opd`.`satuan2`, ':', 1) AS `satuan2`, `opd`.`harga`,	`opd`.`diskon`,	`opd`.`diskon2`, `opd`.`diskon3` FROM `op_dtl` AS `opd`	LEFT JOIN `inventori` AS `inv` ON `inv`.`kode_inventori` = SUBSTRING_INDEX(`opd`.`kode_barang`, ':', 1) WHERE SUBSTRING_INDEX(`opd`.`kode_barang`, ':', 1) = '" . $kd_barang . "' GROUP BY `opd`.`kode_op` ORDER BY `opd`.`id_op_dtl` DESC LIMIT 0, 100");	

		$num_rows = mysql_num_rows($q_his);		

		if($num_rows>0)
		{
			$diskon1x = 0;
			$diskon2x = 0;
			$diskon3x = 0;
			$subtotal = 0;

			echo '<h5><b><center><u>'.$nm_barang.'</u></center></b></h5>';
			echo '<center><a href="#" class="btn-export-csv fa fa-download">Download CSV</a></center>';
			echo '<div style="overflow-x:auto">';
			echo '<table class="table table-striped table-bordered table-hover table-export-csv" width="100%" >
								<thead>
									<tr>
                                        <th>QTY</th>
                                        <th>Konversi</th>
                                        <th>Harga Beli</th>
										<th>Disc 1(%)</th>
										<th>Disc 2(%)</th>
										<th>Disc 3(%)</th>
										<th>PPn</th>
										<th>Harga Setelah Disc</th>
									</tr>
								</thead>
								<tbody>';

			$no=1;
			while ($rowhis = mysql_fetch_array($q_his)) {
				$diskon1x = ($rowhis['harga'] - ($rowhis['harga'] * ($rowhis['diskon'] / 100)));
				$diskon2x = ($diskon1x - ($diskon1x * ($rowhis['diskon2'] / 100)));
				$diskon3x = ($diskon2x - ($diskon2x * ($rowhis['diskon3'] / 100)));
				$subtotal = $diskon3x;
				if ($rowhis['ppn'] === '1' || $rowhis['ppn'] === 1) {
					$ppn = '<span class="glyphicon glyphicon-check"> </span>';
				} else {
					$ppn = '<span class="glyphicon glyphicon-unchecked"> </span>';
				}
				echo '<tr>
						<td style="text-align:right">' . number_format($rowhis['qty_i'], 2) . ' ' . $rowhis['satuan2'] . '</td>
						<td style="text-align:right">' . number_format($rowhis['qty'], 2) . ' ' . $rowhis['satuan'] . '</td>
						<td style="text-align:right">' . number_format($rowhis['harga'], 2) . '</td>
						<td style="text-align:right">' . number_format($rowhis['diskon'], 2) . '</td>
						<td style="text-align:right">' . number_format($rowhis['diskon2'], 2) . '</td>
						<td style="text-align:right">' . number_format($rowhis['diskon3'], 2) . '</td>
						<td style="text-align:right">' . $ppn . '</td>
						<td style="text-align:right">' . number_format($subtotal, 2) . '</td>
				</tr>';	 
			} 
         	echo '</tbody></table></div>';
		} else {
			echo '<b style="color:#F00">Belum ada history harga</b>';	
		}
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loadsatuan" )
	{
		$kd_barang = ''; //VARIABEL AWAL
		$kode_barang = mres($_POST['kode_barang']);
		$sat_beli = '- : -';
		$sat_jual = '- : -';
		$konversi = 0;
		if(!empty($kode_barang))
		{
			$pisah=explode(":",$kode_barang);
			$kd_barang=$pisah[0];
			$nm_barang=$pisah[1];
		}
		$q_sat = mysql_query("SELECT `kode_inventori`, `satuan_beli`, `satuan_jual`, `isi` FROM `inventori` WHERE `kode_inventori` = '".$kd_barang."'");	
		$num_rows = mysql_num_rows($q_sat);
		if($num_rows>0)
		{		
			$rowsat = mysql_fetch_array($q_sat);
			$satuan_beli= $rowsat['satuan_beli'];
			$pisah 		= explode(":",$satuan_beli);
			$satuan_beli= $pisah[1];
			$satuan_jual= $rowsat['satuan_jual'];
			$pisah2 	= explode(":",$satuan_jual);
			$satuan_jual= $pisah2[1];
			$sat_beli = $rowsat['satuan_beli'];
			$sat_jual = $rowsat['satuan_jual'];
			$konversi = $rowsat['isi'];
		}
		
		$response = array(
            'sat_beli'=>$sat_beli,
        	'sat_jual'=>$sat_jual,
			'konversi'=>$konversi,
        );  
		echo json_encode($response);
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loadstok" )
	{
		$kd_barang = ''; 
		$kd_gudang = '';
		$kode_cabang = mres($_POST['kode_cabang']);
		$kode_gudang = mres($_POST['kode_gudang']);
		$kode_barang = mres($_POST['kode_barang']);
		if(!empty($kode_gudang))
		{
			$pisah=explode(":",$kode_gudang);
			$kd_gudang=$pisah[0];
			$nm_gudang=$pisah[1];
		}

		if(!empty($kode_barang))
		{
			$pisah=explode(":",$kode_barang);
			$kd_barang=$pisah[0];
			$nm_barang=$pisah[1];
		}

		$q_stok = mysql_query("SELECT `saldo_qty` FROM `crd_stok` WHERE `kode_barang` = '".$kd_barang."' AND `kode_cabang`='".$kode_cabang."' AND `kode_gudang`='".$kd_gudang."'");	
		$num_rows = mysql_num_rows($q_stok);

		if($num_rows>0)
		{		
			$rowstok = mysql_fetch_array($q_stok);
			echo number_format($rowstok['saldo_qty'], 2);
		} else {
			echo 0;	
		}
	}

	if (isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "add" )
	{
		if(isset($_POST['kode_barang']) and @$_POST['kode_barang'] != ""){
			$id_form = mres($_POST['id_form']);
			$nama_satuan = explode(':', preg_replace('/\s+/', '', mres($_POST['satuan'])));
			$nama_satuan2 = explode(':', preg_replace('/\s+/', '', mres($_POST['satuan2'])));
			$kode_barang = mres($_POST['kode_barang']);
			$kd_session = explode(':', $kode_barang);
			$tgl_kirim = date("Y-m-d",strtotime(mres($_POST['tgl_kirim'])));
			$satuan = mres($_POST['satuan']);
			$qty = mres(str_replace(',', null, $_POST['qty']));
			$satuan2 = mres($_POST['satuan2']);
			$qty_i = mres(str_replace(',', null, $_POST['qty_i']));
			$kode_gudang = mres($_POST['kode_gudang']);
			$stok = mres(str_replace(',', null, $_POST['stok']));
			$harga = mres(str_replace(',', null, $_POST['harga']));
			$diskon = mres(str_replace(',', null, $_POST['diskon']));
			$diskon2 = mres(str_replace(',', null, $_POST['diskon2']));
			$diskon3 = mres(str_replace(',', null, $_POST['diskon3']));
			$ppn = mres(str_replace(',', null, $_POST['ppn']));
			$ppn_n = mres(str_replace(',', null, $_POST['ppn_n']));
			$subtot = mres(str_replace(',', null, $_POST['subtot']));
			$divisi = mres($_POST['divisi']);
			$keterangan_dtl = mres($_POST['keterangan_dtl']);
			$array = array();
			if (!isset($_SESSION['data_op_' . $id_form])) {
				$array[$kd_session[0]] = array(
					'id_form' => $id_form,
					'kode_gudang' => $kode_gudang,
					'kode_barang' => $kode_barang,
					'tgl_kirim' => $tgl_kirim,
					'satuan' => $satuan,
					'nama_satuan' => $nama_satuan[0],
					'satuan2' => $satuan2,
					'nama_satuan2' => $nama_satuan2[0],
					'qty' => $qty,
					'qty_i' => $qty_i,
					'stok' => $stok,
					'harga' => $harga,
					'diskon' => $diskon,
					'diskon2' => $diskon2,
					'diskon3' => $diskon3,
					'ppn' => $ppn,
					'ppn_n' => $ppn_n,
					'subtot' => $subtot,
					'divisi' => $divisi,
					'keterangan_dtl' => $keterangan_dtl,					
				);
			} else {
				$array = $_SESSION['data_op_' . $id_form];
				$array[$kd_session[0]] = array(
					'id_form' => $id_form,
					'kode_gudang' => $kode_gudang,
					'kode_barang' => $kode_barang,
					'tgl_kirim' => $tgl_kirim,
					'satuan' => $satuan,
					'nama_satuan' => $nama_satuan[0],
					'satuan2' => $satuan2,
					'nama_satuan2' => $nama_satuan2[0],
					'qty' => $qty,
					'qty_i' => $qty_i,
					'stok' => $stok,
					'harga' => $harga,
					'diskon' => $diskon,
					'diskon2' => $diskon2,
					'diskon3' => $diskon3,
					'ppn' => $ppn,
					'ppn_n' => $ppn_n,
					'subtot' => $subtot,
					'divisi' => $divisi,
					'keterangan_dtl' => $keterangan_dtl,					
				);
			}
			$_SESSION['data_op_' . $id_form] = $array;
			echo view_item_op($array);
		}
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "hapus-op" )
	{
		$id = mres($_POST['idhapus']);
		$id_form = mres($_POST['id_form']);
		unset($_SESSION['data_op_' . $id_form][$id]);
		echo view_item_op($_SESSION['data_op_' . $id_form]);
	}

	function view_item_op($data) {
		$n = 1;
		$diskon1x 		= 0;
		$diskon2x 		= 0;
		$diskon3x 		= 0;
		$ppn_n	 		= 0;
		$ppn_vn	 		= 0;
		$subtot 		= 0;
		$subtotal 		= 0;
		$grandtotal 	= 0;
		$html = "";
		if(count($data) > 0) {
			foreach($data as $key=>$item){

				if($item['ppn'] === '1'){
					$stat_ppn = '<span class="glyphicon glyphicon-check"> </span>';	
				} else{
					$stat_ppn = '<span class="glyphicon glyphicon-unchecked"> </span>';	
				}
				
				$nm_barang 	 = '';
				$kode_barang = $item['kode_barang'];

				if (!empty($kode_barang)) {
					$pisah=explode(":",$kode_barang);
					$nm_barang=$pisah[1];
				}

				$nm_gudang 	 = '';
				$kode_gudang = $item['kode_gudang'];

				if (!empty($kode_gudang)) {
					$pisah=explode(":",$kode_gudang);
					$nm_gudang=$pisah[1];
				}

				$nm_divisi 	 = '';
				$divisi = $item['divisi'];

				if (!empty($divisi)) {
					$pisah=explode(":",$divisi);
					$nm_divisi=$pisah[1];
				}

				$html .= '<tr>
							<td style="text-align:center; width: 10px;">
								' . $n++ . '
							</td>
							<td style="width: 100px;">' . $nm_gudang . '
								<input type="hidden" name="kode_gudang" id="kode_gudang" value="' . $item['kode_gudang'] . '" />
							</td>
							<td style="width: 180px;" colspan="2">
								' . $nm_barang . '
								<input type="hidden" name="kode_barang" id="kode_barang" value="' . $item['kode_barang'] . '" />
							</td>
							<td style="width: 100px;">
								' . date('m/d/Y', strtotime($item['tgl_kirim'])) . '
							</td>
							<td style="text-align:right; width: 100px;">
								' . number_format($item['qty_i'], 2) . ' ' . $item['nama_satuan2'] . '
							</td>
							<td style="text-align:right; width: 100px;">
								' . number_format($item['qty'], 2) . ' ' . $item['nama_satuan'] . '
							</td>
							<td style="text-align:right; width: 100px;">
								' . number_format($item['stok'], 2) . ' ' . $item['nama_satuan'] . '
							</td>
							<td style="text-align:right; width: 100px;">
								' . number_format($item['harga'], 2) . '
							</td>
							<td style="text-align:right; width: 100px;">
								' . number_format($item['diskon'], 2) . '
							</td>	
							<td style="text-align:right; width: 100px;">
								' . number_format($item['diskon2'], 2) . '
							</td>	
							<td style="text-align:right; width: 100px;">
								' . number_format($item['diskon3'], 2) . '
							</td>	
							<td style="text-align:center; width: 100px;">
								' . $stat_ppn . '
							</td>
							<td style="text-align:right; width: 100px;">
								' . number_format($item['subtot'], 2) . '
							</td>
							<td style="width: 100px">
								' . $nm_divisi . '
								<input type="hidden" name="divisi" id="divisi" value="' . $item['divisi'] . '" />
							</td>
							<td style="width: 200px">
								' . $item['keterangan_dtl'] . '
							</td>
							<td style="text-align:center">
								<a href="javascript:;" class="label label-danger hapus-op" title="hapus data" data-id="' . $key . '">
									<i class="fa fa-times"></i>
								</a>
							</td>
						</tr>
						';
						
						$qty = $item['qty'];
						$diskon1x = ($item['harga'] - ($item['harga'] * ($item['diskon'] / 100)));
						$diskon2x = ($diskon1x - ($diskon1x * ($item['diskon2'] / 100)));
						$diskon3x = ($diskon2x - ($diskon2x * ($item['diskon3'] / 100)));
						
						$subtot = ($diskon3x * $qty);
						
						if ($item['ppn'] === '1') {
							$ppn_n = ($subtot - ($subtot / 1.1));
						}
						else {
							$ppn_n = 0;
						}
						$subtotal += $subtot - $ppn_n;
						$ppn_vn += $ppn_n;
			}
						$grandtotal = $subtotal + $ppn_vn;
				$html .= '<tr>
								<td colspan="13" style="text-align:right"><b>DPP :</b></td>
								<td style="text-align:right"><b>'.number_format($subtotal, 2).'</b> <input type="hidden" name="total_harga" id="total_harga" autocomplete="off" value="'.$subtotal.'" /></td>
								<td align="right" colspan="3"></td>
							</tr>

							<tr>
								<td style="text-align:right" colspan="13"><b>PPn :</b></td>
								<td style="text-align:right"><b>'.number_format($ppn_vn, 2).'</b> <input type="hidden" name="total_ppn" id="total_ppn" autocomplete="off" value="'.$ppn_vn.'" /></td>
								<td align="right" colspan="3"></td>
							</tr>

							<tr>
								<td style="text-align:right" colspan="13"><b>Grand Total :</b></td>
								<td style="text-align:right"><b>'.number_format($grandtotal, 2).'</b> <input type="hidden" name="grandtotal" id="grandtotal" autocomplete="off" value="'.$grandtotal.'" /></td>
								<td align="right" colspan="3"></td>
							</tr>
					  ';			

			$html .= "<script>$('.hapus-op').click(function(){

						var id =	$(this).attr('data-id'); 

						var id_form = $('#id_form').val();

						$.ajax({

							type: 'POST',

							url: '".base_url()."ajax/j_op.php?func=hapus-op',

							data: 'idhapus=' + id + '&id_form=' +id_form,

							cache: false,

							success:function(data){

								$('#detail_input_op').html(data).show();

							 }

						  });

					  });

				     </script>";

				

		} else {

			$html .= '<tr> <td colspan="17" class="text-center">Tidak ada item barang.</td></tr>';
			$html .= '<tr id="total2">
						<td style="text-align:right" colspan="13" ><b>DPP :</b></td>
						<td style="text-align:right"><b>0</b> <input type="hidden" name="total_harga" id="total_harga" autocomplete="off" value="0" /></td>
						<td colspan="3"></td>
					</tr>
					<tr id="ppn">
						<td style="text-align:right" colspan="13"><b>PPn :</b></td>
						<td style="text-align:right"><b>0</b> <input type="hidden" name="total_ppn" id="total_ppn" autocomplete="off" value="0" /></td>
						<td style="text-align:right" colspan="3"></td>
					</tr>
					<tr id="grand_total">
						<td style="text-align:right" colspan="13"><b>Grand Total :</b></td>
						<td style="text-align:right"><b>0</b> <input type="hidden" name="grandtotal" id="grandtotal" autocomplete="off" value="0" /></td>
						<td style="text-align:right" colspan="3"></td>
					</tr>
					  ';

		}

		return $html;
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save" )
	{

		$form 			= 'OP';
		$thnblntgl 		= date("ymd",strtotime(mres($_POST['tanggal'])));
		$id_form			= mres($_POST['id_form']);
		$ref			= mres($_POST['ref']);
		$kode_cabang	= mres($_POST['kode_cabang']);
		$kode_supplier	= mres($_POST['kode_supplier']);
		$top			= mres($_POST['top']);
		$tgl_buat 		= date("Y-m-d",strtotime(mres($_POST['tanggal'])));
		$keterangan_hdr	= mres($_POST['keterangan_hdr']);
		$total_harga	= mres($_POST['total_harga']);
		$total_ppn		= mres($_POST['total_ppn']);
		$subtotal		= mres($_POST['grandtotal']);
		$user_pencipta  	= $_SESSION['app_id'];
		$tgl_input 			= date("Y-m-d H:i:s");	

		$kode_op = buat_kode_op($thnblntgl,$form,$kode_cabang);	

		//HEADER OP

		$mySql	= "INSERT INTO `op_hdr` SET 
						`kode_op`					='".mres($kode_op)."',
						`ref`						='".($ref)."',
						`kode_cabang`				='".($kode_cabang)."',
						`kode_supplier`			='".($kode_supplier)."',
						`top`						='".($top)."',
						`tgl_buat`				='".($tgl_buat)."',
						`tgl_input`				='".($tgl_input)."',
						`keterangan_hdr`			='".($keterangan_hdr)."',
						`user_pencipta`			='".($user_pencipta)."', 
						`total_harga`				='".(str_replace(',', null, $total_harga))."',
						`total_ppn`				='".(str_replace(',', null, $total_ppn))."',
						`subtotal`				='".(str_replace(',', null, $subtotal))."' ";
		$query = mysql_query ($mySql) ;		

		//DETAIL OP

		$array = $_SESSION['data_op_' . $id_form];

			foreach($array as $key=>$item){

					$kode_barang	= $item['kode_barang'];

					$tgl_kirim		=$item['tgl_kirim'];

					$satuan			=$item['satuan'];

					$qty			=$item['qty'];
					
					$satuan2			=$item['satuan2'];

					$qty_i			=$item['qty_i'];

					$stok			=$item['stok'];

					$kode_gudang	=$item['kode_gudang'];

					$harga			=$item['harga'];

					$diskon			=$item['diskon'];
					
					$diskon2			=$item['diskon2'];
					
					$diskon3			=$item['diskon3'];

					$ppn			=$item['ppn'];
					
					$ppn_n			=$item['ppn_n'];

					$subtot			=$item['subtot'];

					$divisi			=$item['divisi'];

					$keterangan_dtl	=$item['keterangan_dtl'];

					

					$mySql1 = "INSERT INTO `op_dtl` SET 
											`kode_op`				='".mres($kode_op)."',
											`kode_barang` 		='".mres($kode_barang)."',
											`tgl_kirim` 			='".mres($tgl_kirim)."',
											`satuan`				='".mres($satuan)."', 
											`qty`					='".mres(str_replace(',', null, $qty))."',										
											`satuan2`				='".mres($satuan2)."', 
											`qty_i`				='".mres(str_replace(',', null, $qty_i))."',
											`stok`				='".mres(str_replace(',', null, $stok))."',
											`kode_gudang`			='".mres($kode_gudang)."',
											`harga`				='".mres(str_replace(',', null, $harga))."',
											`diskon`				='".mres(str_replace(',', null, $diskon))."',
											`diskon2`				='".mres(str_replace(',', null, $diskon2))."',
											`diskon3`				='".mres(str_replace(',', null, $diskon3))."',
											`ppn`					='".mres($ppn)."',
											`subtot`				='".mres(str_replace(',', null, $subtot))."',
											`divisi`				='".mres($divisi)."',
											`keterangan_dtl`		='".mres($keterangan_dtl)."'";	
					$query1 = mysql_query ($mySql1) ;
		}

		if ($query AND $query1) {

			mysql_query("DELETE FROM `op_dtl_tmp` WHERE `id_form` ='".$_POST['id_form']."' ");

			echo "00||".$kode_op;

			if(isset($_SESSION['data_um']))
			{

				//DETAIL UM

				$array = $_SESSION['data_um'];

					foreach($array as $key=>$item){
							$termin		= $item['nominal'];
							$persen		= $item['um'];
							$mySql2 = "INSERT INTO `op_um` SET 
													`kode_op`		='".$kode_op."',
													`termin`		='".$termin."',
													`persen` 		='".$persen."'";
							$query2 = mysql_query ($mySql2) ;
					}
				unset($_SESSION['data_um']);
			}
			unset($_SESSION['data_op']);
		} else { 
			echo "Gagal query: ".mysql_error();
		}		 	
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "clsman" )
	{
		mysqli_autocommit($con,FALSE);
		$kode_op		= mres($_POST['kode_op']);
				
		//UPDATE OP_HDR 

		$mySql1 = "UPDATE `op_hdr` SET `status` = '3' WHERE `kode_op` = '".$kode_op."'";
		$query1 = mysqli_query ($con,$mySql1) ;
		
		$mySql2 = "UPDATE `op_dtl` SET `status_dtl` = '3' WHERE `kode_op` = '".$kode_op."'";
		$query2 = mysqli_query ($con,$mySql2) ;
		
		if ($query1 AND $query2 ) {
			mysqli_commit($con);
			mysqli_close($con);
			echo "00||".$kode_op;
		} else { 
			echo "Gagal query: ".mysql_error();
		}	
	}
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "pembatalan" )
	{
		mysqli_autocommit($con,FALSE);
		$kode_op		= mres($_POST['kode_op_batal']);
		$alasan_batal	= mres($_POST['alasan_batal']);
		$tgl_batal 		= date("Y-m-d");
		
		$cekBtb = "SELECT `kode_op`, `kode_btb` FROM `btb_hdr` WHERE `status` = '1' AND `kode_op` = '".$kode_op."'";
		$queryBtb = mysqli_query($con, $cekBtb);
		
		if (mysqli_num_rows($queryBtb) > 0) {
			$rowBtb = mysql_fetch_array($query_btb);
			mysqli_commit($con);
			mysqli_close($con);
			echo "99||Kode OP " . $kode_op . " sudah BTB! " . $rowBtb['kode_btb'] ;
			return false;
		}
		
		//UPDATE OP_HDR 

		$mySql1 = "UPDATE `op_hdr` SET `status` = '2', alasan_batal = '" . $alasan_batal . "', user_batal = '" . $_SESSION['app_id'] . "', tgl_batal = '" . $tgl_batal . "' WHERE `kode_op` = '".$kode_op."'";
		$query1 = mysqli_query ($con,$mySql1) ;

		//UPDATE OP_DTL

		$mySql2 = "UPDATE `op_dtl` SET `status_dtl` = '2' WHERE `kode_op` = '".$kode_op."' ";
		$query2 = mysqli_query ($con,$mySql2) ;

		if ($query1 AND $query2 ) {
			mysqli_commit($con);
			mysqli_close($con);
			echo "00||".$kode_op;
		} else { 
			echo "99||Gagal query: ".mysql_error();
		}	
	}
?>