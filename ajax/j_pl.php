<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	require('../pages/data/script/sj.php');
	date_default_timezone_set("Asia/Jakarta");

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loadlistpl" )
	{
		$kode_pl		= $_POST['kode_pl'];

		/* $q_pl = mysql_query("SELECT pl.kode_so, sh.kode_pelanggan, sh.tgl_buat, pl.nama_barang, pl.qty, pl.satuan FROM packing_list pl
				LEFT JOIN so_hdr sh ON sh.kode_so = pl.kode_so
				WHERE pl.kode_pl = '".$kode_pl."' OR pl.plat_truck = '".$plat_truck."'
                ORDER BY sh.kode_pelanggan, nama_barang ASC"); */
        
        $q_pl = mysql_query("SELECT `pl_dtl`.`kode_so` AS `kode_so`, `pl_dtl`.`kode_sj` AS `kode_sj`, `pl_dtl`.`nama_barang` AS `nama_barang`, `pl_dtl`.`qty` AS `qty`, `pl_dtl`.`satuan` AS `satuan`, `pl_dtl`.`tgl_buat` AS `tgl_buat` FROM `pl_dtl` LEFT JOIN `pl_hdr` ON `pl_dtl`.`kode_pl` = `pl_hdr`.`kode_pl_hdr` WHERE `pl_hdr`.`kode_pl_hdr` = '".$kode_pl."' ORDER BY `pl_dtl`.`nama_barang` ASC");

		$array = array();
		if(mysql_num_rows($q_pl) > 0) {
			while ($res = mysql_fetch_array($q_pl)) {
				$array[] = $res;
			}
		}

		$_SESSION['load_list_pl'] = $array;

		echo view_list_pl($array);
	}

	function view_list_pl($array) {
		$n = 1;
		$html = "";
		$kd_pel="";
		$nm_pel="";

		if(count($array) > 0) {
			foreach($array as $key=>$item){

				/* $kode_pelanggan = $item['kode_pelanggan'];
				if(!empty($kode_pelanggan)) {
					$pisah=explode(":",$kode_pelanggan);
					$kd_pel=$pisah[0];
					$nm_pel=$pisah[1];
				} */

							$html .= '<tr>
										<td>'.$item['kode_so'].'</td>
										<td>'.$item['kode_sj'].'</td>
										<td>'.$item['nama_barang'].'</td>
										<td>'.$item['qty'].' '.$item['satuan'].'</td>
									  </tr>
									 ';
							$n++;
				}
		}else{
				$html .= '<tr> <td colspan="4" class="text-center"> Tidak ada item barang. </td></tr>';
		}

		return $html;

	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loaditem" )
	{
		$kode_pelanggan = $_POST['kode_pelanggan'];
		$kode_cabang 	= $_POST['kode_cabang'];
		$kode_gudang 	= $_POST['kode_gudang'];

		/* $q_dtl = mysql_query("SELECT sd.kode_so, sd.kode_barang, sd.nama_barang, sd.qty, sd.satuan_jual satuan_besar, sd.satuan satuan_ikat
								FROM so_dtl sd
								INNER JOIN so_hdr sh ON sh.kode_so = sd.kode_so
								WHERE sh.kode_cabang = '".$kode_cabang."' AND sh.kode_gudang = '".$kode_gudang."' AND SUBSTRING_INDEX(sh.kode_pelanggan, ':', 1) = '".$kode_pelanggan."'
								ORDER BY kode_so, kode_barang ASC
                                "); */

        $q_dtl = mysql_query("SELECT `sj_dtl`.`kode_so` AS `kode_so`, `sj_dtl`.`kode_sj` AS `kode_sj`, `sj_dtl`.`kode_inventori` AS `kode_barang`, `sj_dtl`.`nama_inventori` AS `nama_barang`, `sj_dtl`.`qty_dikirim` AS `qty`, `sj_dtl`.`satuan_dikirim` AS `satuan_besar` FROM `sj_hdr` INNER JOIN `sj_dtl` ON `sj_hdr`.`kode_sj` = `sj_dtl`.`kode_sj` WHERE `sj_hdr`.`kode_cabang` = '".$kode_cabang."' AND `sj_hdr`.`kode_gudang` = '".$kode_gudang."' AND `sj_hdr`.`kode_pelanggan` = '".$kode_pelanggan."' AND `sj_hdr`.`status` = '1' AND `sj_dtl`.`status_dtl` = '1'");

		$array = array();
		if(mysql_num_rows($q_dtl) > 0) {
			while ($res = mysql_fetch_array($q_dtl)) {
				$array[] = $res;
			}
		}

		$_SESSION['load_pl'] = $array;

		echo view_item_pl($array);
	}

	function view_item_pl($array) {

		$n = 1;
		$html = "";

		if(count($array) > 0) {
			foreach($array as $key=>$item){

				$cheked   = '';
				$stat_cb  = '0';

				/* if($item['satuan_ikat'] == ''){
					$satuan = $item['satuan_besar'];
				}else{
					$satuan = $item['satuan_ikat'];
                } */
                $satuan = $item['satuan_besar'];

							$html .= '<tr>
									<td>
										<div class="checkbox" style="text-align:right">
											<input type="checkbox" name="cb[]" id="cb[]" data-id="cb" data-group="'.$n.'" value="'.$n.'" '.$cheked.'>
										</div>
									</td>
									<td>'.$item['kode_so'].'
										<input class="form-control" type="hidden" name="kode_so[]" id="kode_so[]" data-id="kode_so" data-group="'.$n.'" value="'.$item['kode_so'].'" readonly/>
                                    </td>
                                    <td>'.$item['kode_sj'].'
										<input class="form-control" type="hidden" name="kode_sj[]" id="kode_sj[]" data-id="kode_sj" data-group="'.$n.'" value="'.$item['kode_sj'].'" readonly/>
									</td>
									<td>'.$item['kode_barang'].'
										<input class="form-control" type="hidden" name="kode_barang[]" id="kode_barang[]" data-id="kode_barang" data-group="'.$n.'" value="'.$item['kode_barang'].'" readonly/>
									</td>
									<td style="font-size: 12px">'.$item['nama_barang'].'
										<input class="form-control" type="hidden" name="nama_barang[]" id="nama_barang[]" data-id="nama_barang" data-group="'.$n.'" value="'.$item['nama_barang'].'" readonly/>
									</td>
									<td>
										<input type="hidden" class="form-control" name="qty_asli[]" id="qty_asli[]" data-id="qty_asli" data-group="'.$n.'" style="font-size: 12px; text-align: center" value="'.$item['qty'].'" readonly>
										<input type="text" class="form-control" name="qty[]" id="qty[]" data-id="qty" data-group="'.$n.'" placeholder=".. QTY .." style="font-size: 12px; text-align: center" value="'.$item['qty'].'" readonly>
		  								<input type="text" class="form-control" name="satuan[]" id="satuan[]" data-id="satuan" data-group="'.$n.'" placeholder=".. Satuan .." style="font-size: 12px; text-align: center" value="'.$satuan.'" readonly>
	  								</td>
								';
							$n++;
				}
		}else{
				$html .= '<tr> <td colspan="6" class="text-center"> Tidak ada item barang. </td></tr>';
		}

		return $html;
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loadpickup" )
	{
		$kode_so 		= $_POST['kode_so'];
		$kode_sj 		= $_POST['kode_sj'];
		$kode_barang 	= $_POST['kode_barang'];
		$nama_barang 	= $_POST['nama_barang'];
		$qty 			= $_POST['qty'];
		$satuan 		= $_POST['satuan'];

		$array =  (isset($_SESSION['data_pickup']) ? $_SESSION['data_pickup'] : array());

		if (isset($array[$kode_so.$kode_sj.$kode_barang])) {
			$array[$kode_so.$kode_sj.$kode_barang]["qty"] = $qty + $array[$kode_so.$kode_sj.$kode_barang]["qty"];
		}else{
			$array[$kode_so.$kode_sj.$kode_barang] = array("kode_so" => $kode_so,"kode_sj" => $kode_sj,"kode_barang" => $kode_barang, "nama_barang" => $nama_barang, "qty" => $qty, "satuan" => $satuan);
		}

		$_SESSION['data_pickup'] = $array;
		echo view_item_pickup($array);
	}

	function view_item_pickup($array) {

		$n = 0;
		$no = 1;
		$html = "";

		if(count($array) > 0) {
			foreach($array as $key=>$item){

				$html .= '<tr>
									<td style="text-align: center">'.$no++.'</td>
									<td>'.$item['kode_so'].'
										<input class="form-control" type="hidden" name="kode_so[]" id="kode_so[]" data-id="kode_so" data-group="'.$n.'" value="'.$item['kode_so'].'" readonly/>
                                    </td>
                                    <td>'.$item['kode_sj'].'
										<input class="form-control" type="hidden" name="kode_sj[]" id="kode_sj[]" data-id="kode_sj" data-group="'.$n.'" value="'.$item['kode_sj'].'" readonly/>
									</td>
									<td>'.$item['kode_barang'].'
										<input class="form-control" type="hidden" name="kode_barang[]" id="kode_barang[]" data-id="kode_barang" data-group="'.$n.'" value="'.$item['kode_barang'].'" readonly/>
									</td>
									<td style="font-size: 12px">'.$item['nama_barang'].'
										<input class="form-control" type="hidden" name="nama_barang[]" id="nama_barang[]" data-id="nama_barang" data-group="'.$n.'" value="'.$item['nama_barang'].'" readonly/>
									</td>
									<td style="text-align: right">'.$item['qty'].'&nbsp;&nbsp;'.$item['satuan'].'
										<input type="hidden" class="form-control" name="qty[]" id="qty[]" data-id="qty" data-group="'.$n.'" placeholder=".. QTY .." style="font-size: 12px; text-align: center" value="'.$item['qty'].'">
		  								<input type="hidden" class="form-control" name="satuan[]" id="satuan[]" data-id="satuan" data-group="'.$n.'" placeholder=".. SATUAN .." style="font-size: 12px; text-align: center" value="'.$item['satuan'].'">
	  								</td>
								';
							$n++;
				}
		}else{
				$html .= '<tr> <td colspan="6" class="text-center"> Tidak ada item barang. </td></tr>';
		}

		return $html;
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save" )
	{
		mysqli_autocommit($con,FALSE);

		$kode_pl 		= $_POST['kode_pl'];
		$plat_truck 	= $_POST['plat_truck'];
		$user_pencipta  = $_SESSION['app_id'];
        $tgl_buat 		= date("Y-m-d");
        
        $mySql1 = "INSERT INTO `pl_hdr` SET `kode_pl_hdr` = '".$kode_pl."', `plat_pl_hdr` = '".$plat_truck."', `user_pencipta` = '".$user_pencipta."', `tgl_buat` = '".$tgl_buat."'";
	    $query1 = mysqli_query ($con,$mySql1);

		if(isset($_SESSION['data_pickup']) and count($_SESSION['data_pickup']) > 0)
		{
			$array = $_SESSION['data_pickup'];
				foreach($array as $key=>$item){

					$kode_so 		= $item['kode_so'];
					$kode_sj 		= $item['kode_sj'];
					$kode_barang 	= $item['kode_barang'];
					$nama_barang 	= $item['nama_barang'];
					$qty 			= $item['qty'];
					$satuan 		= $item['satuan'];

                    $mySql2 = "INSERT INTO `pl_dtl` SET `kode_pl` = '".$kode_pl."', `kode_so` = '".$kode_so."', `kode_sj` = '".$kode_sj."', `kode_barang` = '".$kode_barang."', `nama_barang` = '".$nama_barang."', `qty` = '".$qty."', `satuan` = '".$satuan."', `user_pencipta` = '".$user_pencipta."', `tgl_buat` = '".$tgl_buat."'";
					$query2 = mysqli_query ($con,$mySql2);
				}


			if ($query1 && $query2) {

				// Commit Transaction
				mysqli_commit($con);

				// Close connection
				mysqli_close($con);

				unset($_SESSION['data_pickup']);
				echo "00||$kode_pl";
			} else {
				echo "99||Gagal Input";
			}
		}
	}

?>
