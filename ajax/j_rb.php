<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	require('../pages/data/script/rb.php');
	date_default_timezone_set("Asia/Jakarta");

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loadfb" )
	{
		$kode_cabang 	= $_POST['kode_cabang'];
		$kode_supplier 	= $_POST['kode_supplier'];

		$q_fb = mysql_query("SELECT fd.kode_fb FROM fb_dtl fd
								LEFT JOIN fb_hdr fh ON fh.kode_fb = fd.kode_fb
								LEFT JOIN op_dtl od ON od.kode_op = fd.kode_op
								LEFT JOIN btb_dtl bd ON bd.kode_btb = fd.kode_btb
								WHERE fh.kode_cabang = '".$kode_cabang."' AND fh.kode_supplier = '".$kode_supplier."'
								GROUP BY kode_fb
								ORDER BY kode_fb ASC");
		$num_rows = mysql_num_rows($q_fb);
		if($num_rows>0)
		{
			echo '<select id="kode_fb" name="kode_fb" class="select2">
					<option value="0">-- Kode FB --</option>';

                	while($rowfb = mysql_fetch_array($q_fb)){

         	echo '<option value="'.$rowfb['kode_fb'].'">'.$rowfb['kode_fb'].'</option>';

	 				}

         	echo '</select>';
		}else{
			echo '<select id="kode_fb" name="kode_fb" class="select2" disabled>
                  	<option value="0">-- Tidak Ada--</option>
                  </select>';
		}
	}
	
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loaditem" )
	{
		$kode_fb 		= mres($_POST['kode_fb']);
		$kode_gudang 	= mres($_POST['kode_gudang']);
		$grandtotal = 0;
		$total= 0;
		
		if ($kode_gudang == '0') {
			echo '<tr><td colspan="6" class="text-center">Belum ada item</td></tr>';
			return false;
		}
		
		if ($kode_gudang == '02') {
			$q_dtl = mysql_query("SELECT CASE			WHEN		REGEXP_REPLACE ( SUBSTRING_INDEX( `satuan_beli`, ':', 1 ), '[[:space:]]+', ' ' ) = 'LSN' THEN			`op_dtl`.`harga` / 12 			WHEN REGEXP_REPLACE ( SUBSTRING_INDEX( `satuan_beli`, ':', 1 ), '[[:space:]]+', ' ' ) = 'GRS' THEN			`op_dtl`.`harga` / 144 ELSE `op_dtl`.`harga` 		END AS `harga`,		`inventori`.`rb_debet`,		`inventori`.`rb_kredit`,	CASE						WHEN REGEXP_REPLACE ( SUBSTRING_INDEX( `satuan_beli`, ':', 1 ), '[[:space:]]+', ' ' ) = 'LSN' THEN			CONCAT( REGEXP_REPLACE ( SUBSTRING_INDEX( `satuan_beli`, ':', 1 ), '[[:space:]]+', ' ' ), '/12' ) 			WHEN REGEXP_REPLACE ( SUBSTRING_INDEX( `satuan_beli`, ':', 1 ), '[[:space:]]+', ' ' ) = 'GRS' THEN			CONCAT( REGEXP_REPLACE ( SUBSTRING_INDEX( `satuan_beli`, ':', 1 ), '[[:space:]]+', ' ' ), '/144' ) ELSE REGEXP_REPLACE ( SUBSTRING_INDEX( `satuan_beli`, ':', 1 ), '[[:space:]]+', ' ' ) 		END AS `satuan`,		SUBSTRING_INDEX( `fb_dtl`.`kode_barang`, ':', 1 ) AS `kode_barang`,		SUBSTRING_INDEX( `fb_dtl`.`kode_barang`, ':', - 1 ) AS `nama_barang`,		`fb_hdr`.`tgl_jth_tempo` 	FROM		`fb_hdr`		LEFT JOIN `fb_dtl` ON `fb_dtl`.`kode_fb` = `fb_hdr`.`kode_fb`		LEFT JOIN `inventori` ON `inventori`.`kode_inventori` = SUBSTRING_INDEX( `kode_barang`, ':', 1 )		LEFT JOIN `op_dtl` ON `op_dtl`.`kode_op` = `fb_dtl`.`kode_op` 		AND `op_dtl`.`kode_barang` = `fb_dtl`.`kode_barang` 	WHERE		`fb_hdr`.`kode_fb` = '" . $kode_fb . "' 	GROUP BY	`op_dtl`.`harga`,	`op_dtl`.`kode_barang` ");
		} else {
			$q_dtl = mysql_query("SELECT `op_dtl`.`harga`, `inventori`.`rb_debet`, `inventori`.`rb_kredit`, REGEXP_REPLACE(SUBSTRING_INDEX(`satuan_beli`, ':', 1), '[[:space:]]+', ' ') AS `satuan`, SUBSTRING_INDEX(`fb_dtl`.`kode_barang`, ':', 1) AS `kode_barang`, SUBSTRING_INDEX(`fb_dtl`.`kode_barang`, ':', -1) AS `nama_barang`, `fb_hdr`.`tgl_jth_tempo` FROM `fb_hdr` LEFT JOIN `fb_dtl` ON `fb_dtl`.`kode_fb` = `fb_hdr`.`kode_fb` LEFT JOIN `inventori` ON `inventori`.`kode_inventori` = SUBSTRING_INDEX(`kode_barang`, ':', 1) LEFT JOIN `op_dtl` ON `op_dtl`.`kode_op` = `fb_dtl`.`kode_op` AND `op_dtl`.`kode_barang` = `fb_dtl`.`kode_barang` WHERE `fb_hdr`.`kode_fb` = '" . $kode_fb . "'  GROUP BY `op_dtl`.`harga`, `op_dtl`.`kode_barang` ");
		}
		

		$num_rows 	= mysql_num_rows($q_dtl);
		if($num_rows>0)
		{
			$n=0;
			while($rowdtl = mysql_fetch_array($q_dtl)){
				
				$n++;

				echo '<tr data-id="' . $n . '">
							<td width="30px">
								<div class="checkbox" style="text-align:right">
									<input type="checkbox" name="cb[]" id="cb_' . $n . '" data-id="' . $n . '" value="0" />
								</div>
								<input type="hidden" class="form-control" name="stat_cb[]" id="stat_cb_' . $n . '" value="0" data-id="' . $n . '" />
							</td>
							<td>
								<input type="hidden" value="' . $rowdtl['rb_debet'] . '" name="rb_debet[]" data-id="' . $n . '" />
								<input type="hidden" value="' . $rowdtl['rb_kredit'] . '" name="rb_kredit[]" data-id="' . $n . '" />
								<input type="hidden" value="' . $rowdtl['kode_barang'] . '" name="kode_barang[]" data-id="' . $n . '" />
								<input type="hidden" value="' . $rowdtl['satuan'] . '" name="satuan[]" data-id="' . $n . '" />
								<input type="hidden" value="' . $rowdtl['tgl_jth_tempo'] . '" name="tgl_jth_tempo[]" data-id="' . $n . '" />
								' . $rowdtl['nama_barang'] . '
							</td>
							<td>
								<div class="input-group">
									<input class="form-control" type="text" name="qty_retur[]" id="qty_retur_' . $n . '" autocomplete="off" value="0" style="text-align: right" data-id="' . $n . '" required />
									<span class="input-group-addon">' . $rowdtl['satuan'] . '</span>
								</div>
							</td>
							<td>
								<div class="input-group">
									<input class="form-control" type="text" name="harga_retur[]" id="harga_retur_' . $n . '" autocomplete="off" value="' . $rowdtl['harga'] . '" data-value="' . $rowdtl['harga'] . '" data-id="' . $n . '" style="text-align: right" required />
								</div>
							</td>
							<td>
								<div class="input-group">
									<input class="form-control" type="text" name="total_harga_retur[]" id="total_harga_retur_' . $n . '" autocomplete="off" value="0" data-id="' . $n . '" style="text-align: right" readonly />
								</div>
							</td>
							<td>
								<div class="input-group">
									<input class="form-control" type="text" name="ket_retur[]" id="ket_retur_' . $n . '" autocomplete="off" data-id="' . $n . '" />
								</div>
							</td>
					</tr>';
			}

		}else{

			echo '<tr><td colspan="6" class="text-center">Belum ada item</td></tr>';

		}

	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save" )
	{

		mysqli_autocommit($con,FALSE);

		$form 			= 'RB';
		$thnblntgl 		= date("ymd",strtotime($_POST['tgl_buat']));

		$kode_cabang	= $_POST['kode_cabang'];
		$kode_gudang	= $_POST['kode_gudang'];
		$kode_supplier	= $_POST['kode_supplier'];

		$ref			= $_POST['ref'];
		$tgl_buat 		= date("Y-m-d",strtotime($_POST['tgl_buat']));
		$keterangan_hdr	= $_POST['keterangan_hdr'];

		$kode_fb		= $_POST['kode_fb'];
		$cb		= $_POST['cb'];
		$stat_cb		= $_POST['stat_cb'];
		$rb_debet		= $_POST['rb_debet'];
		$rb_kredit		= $_POST['rb_kredit'];
		$kode_barang		= $_POST['kode_barang'];
		$satuan		= $_POST['satuan'];
		$tgl_jth_tempo	= $_POST['tgl_jth_tempo'];
		$qty_retur	= $_POST['qty_retur'];
		$harga_retur	= $_POST['harga_retur'];
		$total_harga_retur	= $_POST['total_harga_retur'];
		$ket_retur	= $_POST['ket_retur'];
				
		$count                 = count($cb);
		
		$grandtotal = 0;

		$user_pencipta  = $_SESSION['app_id'];
		$tgl_input 		= date("Y-m-d H:i:s");

		$kode_rb = buat_kode_rb($thnblntgl,$form,$kode_cabang);
		
		for($i = 0; $i < $count; $i++) {
			if ($stat_cb[$cb[$i]] == '1' || $stat_cb[$cb[$i]] == 1) {
				$code_barang = $kode_barang[$cb[$i]];
				
				$mySql1 = "INSERT INTO `rb_dtl` (`kode_rb`, `kode_fb`, `kode_barang`, `satuan`, `jumlah_rb`, `harga`, `subtot`, `keterangan_dtl`) VALUES ";
				$mySql1 .= $i > 0 ? ", " : '';
				$mySql1 .= "(
					'" . $kode_rb . "',
					'" . $kode_fb . "',
					'" . $kode_barang[$cb[$i]] . "',
					'" . $satuan[$cb[$i]] . "',
					'" . str_replace(',', null, $qty_retur[$cb[$i]]) . "',
					'" . str_replace(',', null, $harga_retur[$cb[$i]]) . "',
					'" . str_replace(',', null, $total_harga_retur[$cb[$i]]) . "',
					'" . $ket_retur[$cb[$i]] . "'
				)";
				
				$grandtotal += $total_harga_retur[$cb[$i]];
				
				$tgl_jth_tempo = $tgl_jth_tempo[$cb[$i]];
				
				//INSERT JURNAL KREDIT
				$mySql5	= "INSERT INTO `jurnal` SET
							`kode_transaksi`			='".$kode_rb."',
							`tgl_buat`				='".$tgl_buat."',
							`tgl_input`				='".$tgl_input."',
							`kode_cabang`				='".$kode_cabang."',
							`kode_supplier`			='".$kode_supplier."',
							`keterangan_hdr`			='".$keterangan_hdr."',
							`ref`						='".$ref."',
							`kode_coa`				='".$rb_kredit[$cb[$i]]."',
							`kredit`					='".$total_harga_retur[$cb[$i]]."',
							`user_pencipta`			='".$user_pencipta."';
						";
				$query5 = mysqli_query ($con,$mySql5) ;

				//INSERT JURNAL DEBET
				$mySql6	= "INSERT INTO `jurnal` SET
							`kode_transaksi`			='".$kode_rb."',
							`tgl_buat`				='".$tgl_buat."',
							`tgl_input`				='".$tgl_input."',
							`kode_cabang`				='".$kode_cabang."',
							`kode_supplier`			='".$kode_supplier."',
							`keterangan_hdr`			='".$keterangan_hdr."',
							`ref`						='".$ref."',
							`kode_coa`			='".$rb_debet[$cb[$i]]."',
							`debet`					='".$total_harga_retur[$cb[$i]]."',
							`user_pencipta`			='".$user_pencipta."';
						";
				$query6 = mysqli_query ($con,$mySql6) ;
				
				//UNTUK CEK STOK ADA APA TIDAK
				$q_cek_stok_saat_itu = "SELECT IFNULL(SUM(qty_in-qty_out),0) saldo_qty_saat_itu FROM crd_stok_dtl WHERE kode_barang ='".$code_barang."' AND kode_cabang='".$kode_cabang."' AND kode_gudang='".$kode_gudang."' AND tgl_buat <= '".$tgl_buat."'";
				$res_s_s_i			= mysql_query($q_cek_stok_saat_itu);
				$res_stok_saat_itu 	= mysql_fetch_array($res_s_s_i);
				$stok_saat_itu		= $res_stok_saat_itu['saldo_qty_saat_itu'];

				//UNTUK CEK ITEM YANG MASUK KE STOK
				$q_cekitem = mysql_query("SELECT kode_inventori FROM inventori WHERE kode_inventori='".$code_barang."' AND jenis_stok='1'");

				$num_rows = mysql_num_rows($q_cekitem);
				if($num_rows>0)
				{
					//VARIABEL AWAL
					$qty_out_dtl 	= $jumlah_rb;
					$harga_out_dtl 	= $harga;
					$total_out_dtl 	= ($qty_out_dtl*$harga_out_dtl);
					$ref_untuk_crd 	= 'nota retur pembelian';

					//UNTUK CEK STOK
					$q_cekstok_hdr = mysql_query("SELECT * FROM crd_stok WHERE kode_barang='".$code_barang."' AND kode_cabang='".$kode_cabang."' AND kode_gudang='".$kode_gudang."'");
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

						$q_keluar 		 = $qty_out+$qty_out_dtl;
						$saldo_q 		 = $qty_in-$q_keluar;
						$saldo_last_hpp1 = ($saldo_last_hpp);
						$saldo_total 	 = ($saldo_q*$saldo_last_hpp1);

						//JIKA JUMLAH QTY MELEBIHI DARI QTY_OUT SEKARANG
						if(($jumlah_rb+$qty_out) > $qty_in){
							echo "99||STOK TIDAK MEMENUHI!!";
							return false;
						//JIKA CABANG TIDAK ADA DI DATABASE
						}else if($kode_cabang != $kd_cabang) {
				   			echo "99|| CABANG TIDAK TERDAFTAR DI DALAM DAFTAR ITEM BARANG TERSEBUT !!!";
							return false;
						//JIKA GUDANG TIDAK ADA DI DATABASE
						}else if($kode_gudang != $kd_gudang) {
				   			echo "99|| GUDANG TIDAK TERDAFTAR DI DALAM DAFTAR ITEM BARANG TERSEBUT !!!";
							return false;
						//JIKA JUMLAH QTY MELEBIHI DARI SALDO QTY SAAT  TGL BUAT
						}else if($stok_saat_itu < $jumlah_rb){
							echo "99||QUANTITY BERLEBIHAN!!";
							return false;
						//JIKA SALDO QTY SAAT TGL BUAT TSB BELUM ADA
						}
						// else if($tgl_buat < $tgl_awal_stok_ada) {
				  //  			echo "99||TANGGAL SURAT JALAN TERSEBUT TIDAK DIPERBOLEHKAN !!!";
						// 	return false;
						// }

						//UPDATE CRD STOK
						$mySql3 = " UPDATE crd_stok SET tgl_input='".$tgl_input."', qty_out='".$q_keluar."', saldo_qty='".$saldo_q."', saldo_last_hpp='".$saldo_last_hpp1."', saldo_total='".$saldo_total."' WHERE kode_barang='".$code_barang."' AND kode_cabang='".$kd_cabang."' AND kode_gudang='".$kd_gudang."' ";

						$query3 = mysqli_query ($con,$mySql3) ;

						//INSERT CRD STOK DTL
						$mySql4	= "INSERT INTO crd_stok_dtl SET
									kode_barang			='".$code_barang."',
									tgl_buat				='".$tgl_buat."',
									tgl_input				='".$tgl_input."',
									kode_cabang				='".$kd_cabang."',
									kode_gudang				='".$kd_gudang."',
									qty_out					='".$qty_out_dtl."',
									harga_out				='".$harga_out_dtl."',
									total_out				='".$total_out_dtl."',
									ref						='".$ref_untuk_crd."',
									note					='".$ref."',
									kode_transaksi			='".$kode_rb."';
								";

						$query4 = mysqli_query ($con,$mySql4) ;
					}

				}
			}
		}
		
		$mySql1 = rtrim($mySql1,",");

		$query1 = mysqli_query ($con,$mySql1) ;

		//KARTU HUTANG
		$mySql7	= " INSERT INTO kartu_hutang SET
						kode_transaksi 	='".$kode_rb."',
						debet 			='".$grandtotal."',
					    kode_supplier 	='".$kode_supplier."',
						kode_cabang 	='".$kode_cabang."',
						tgl_buat 		='".$tgl_buat."',
						tgl_jth_tempo 	='".$tgl_jth_tempo."',
						user_pencipta 	='".$user_pencipta."',
						tgl_input		='".$tgl_input."'
					";

		$query7 = mysqli_query ($con,$mySql7) ;

		//HEADER BTB
		$mySql	= "INSERT INTO rb_hdr SET
						kode_rb			='".$kode_rb."',
						kode_cabang		='".$kode_cabang."',
						kode_gudang		='".$kode_gudang."',
						kode_supplier	='".$kode_supplier."',
						ref				='".$ref."',
						tgl_buat		='".$tgl_buat."',
						keterangan_hdr	='".$keterangan_hdr."',
						user_pencipta	='".$user_pencipta."',
						total_harga		='".$grandtotal."',
						grandtotal		='".$grandtotal."'
				  ";

		$query = mysqli_query ($con,$mySql) ;
		
		if ($query AND $query1 AND $query3 /*AND $query4 AND $query5 AND $query6 AND $query7*/) {

			// Commit transaction
			mysqli_commit($con);

			// Close connection
			mysqli_close($con);

			echo "00||".$kode_rb;
			unset($_SESSION['data_rb']);

		} else {

			echo "Gagal query: ".mysqli_error($con);
		}

		/* 
		$mySql1 = "INSERT INTO rb_dtl (kode_rb, kode_fb, kode_barang, satuan, jumlah_rb, harga, ppn, subtot, keterangan_dtl) VALUES ";

		//DETAIL RB
		$array = $_SESSION['data_rb'];
			foreach($array as $key=>$item)
			{
				$no_rb 			= $kode_rb;
				$kode_barang	= $item['kode_barang'];
				$satuan			= $item['satuan'];
				$jumlah_rb		= $item['jumlah_rb'];
				$harga			= $item['harga'];
				$subtot			= $item['subtot'];
				$keterangan_dtl	= $item['keterangan_dtl'];

				$rb_debet 		= $item['rb_debet'];
				$rb_kredit 		= $item['rb_kredit'];
				$tgl_jth_tempo 	= $item['tgl_jth_tempo'];

				$pisah 			= explode(":",$kode_barang);
				$code_barang_bs = $pisah[0];
				$code_barang 	= substr($code_barang_bs, 0, 11);

				$mySql1 .= "('{$no_rb}','{$kode_fb}','{$kode_barang}','{$satuan}','{$jumlah_rb}','{$harga}','{$ppn}','{$subtot}','{$keterangan_dtl}')";
				$mySql1 .= ",";

				//INSERT JURNAL KREDIT
				$mySql5	= "INSERT INTO jurnal SET
							kode_transaksi			='".$kode_rb."',
							tgl_buat				='".$tgl_buat."',
							tgl_input				='".$tgl_input."',
							kode_cabang				='".$kode_cabang."',
							kode_supplier			='".$kode_supplier."',
							keterangan_hdr			='".$keterangan_hdr."',
							ref						='".$ref."',
							kode_coa				='".$rb_kredit."',
							kredit					='".$subtot."',
							user_pencipta			='".$user_pencipta."';
						";
				$query5 = mysqli_query ($con,$mySql5) ;

				//INSERT JURNAL DEBET
				$mySql6	= "INSERT INTO jurnal SET
							kode_transaksi			='".$kode_rb."',
							tgl_buat				='".$tgl_buat."',
							tgl_input				='".$tgl_input."',
							kode_cabang				='".$kode_cabang."',
							kode_supplier			='".$kode_supplier."',
							keterangan_hdr			='".$keterangan_hdr."',
							ref						='".$ref."',
							kode_coa				='".$rb_debet."',
							debet					='".$subtot."',
							user_pencipta			='".$user_pencipta."';
						";
				$query6 = mysqli_query ($con,$mySql6) ;

				//UNTUK CEK STOK ADA APA TIDAK
				$q_cek_stok_saat_itu = "SELECT IFNULL(SUM(qty_in-qty_out),0) saldo_qty_saat_itu FROM crd_stok_dtl WHERE kode_barang ='".$code_barang."' AND kode_cabang='".$kode_cabang."' AND kode_gudang='".$kode_gudang."' AND tgl_buat <= '".$tgl_buat."'";
				$res_s_s_i			= mysql_query($q_cek_stok_saat_itu);
				$res_stok_saat_itu 	= mysql_fetch_array($res_s_s_i);
				$stok_saat_itu		= $res_stok_saat_itu['saldo_qty_saat_itu'];

				// UNTUK CEL TGL AWAL STOK ADA
				// $q_cek_tgl = "SELECT tgl_buat FROM crd_stok_dtl WHERE kode_barang ='".$code_barang."' AND kode_cabang='".$kode_cabang."' AND kode_gudang='".$kode_gudang."' ORDER BY tgl_buat ASC LIMIT 1";
				// $res_tgl_ada 		= mysql_query($q_cek_tgl);
				// $res_c_t 			= mysql_fetch_array($res_tgl_ada);
				// $$tgl_awal_stok_ada	= $res_c_t['tgl_buat'];

				//UNTUK CEK ITEM YANG MASUK KE STOK
				$q_cekitem = mysql_query("SELECT kode_inventori FROM inventori WHERE kode_inventori='".$code_barang_bs."' AND jenis_stok='1'");

				$num_rows = mysql_num_rows($q_cekitem);
				if($num_rows>0)
				{
					//VARIABEL AWAL
					$qty_out_dtl 	= $jumlah_rb;
					$harga_out_dtl 	= $harga;
					$total_out_dtl 	= ceil($qty_out_dtl*$harga_out_dtl);
					$ref_untuk_crd 	= 'nota retur pembelian';

					//UNTUK CEK STOK
					$q_cekstok_hdr = mysql_query("SELECT * FROM crd_stok WHERE kode_barang='".$code_barang."' AND kode_cabang='".$kode_cabang."' AND kode_gudang='".$kode_gudang."'");
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

						$q_keluar 		 = (int)$qty_out+$qty_out_dtl;
						$saldo_q 		 = (int)$qty_in-$q_keluar;
						$saldo_last_hpp1 = ceil($saldo_last_hpp);
						$saldo_total 	 = ceil($saldo_q*$saldo_last_hpp1);

						//JIKA JUMLAH QTY MELEBIHI DARI QTY_OUT SEKARANG
						if(($jumlah_rb+$qty_out) > $qty_in){
							echo "99||STOK TIDAK MEMENUHI!!";
							return false;
						//JIKA CABANG TIDAK ADA DI DATABASE
						}else if($kode_cabang != $kd_cabang) {
				   			echo "99|| CABANG TIDAK TERDAFTAR DI DALAM DAFTAR ITEM BARANG TERSEBUT !!!";
							return false;
						//JIKA GUDANG TIDAK ADA DI DATABASE
						}else if($kode_gudang != $kd_gudang) {
				   			echo "99|| GUDANG TIDAK TERDAFTAR DI DALAM DAFTAR ITEM BARANG TERSEBUT !!!";
							return false;
						//JIKA JUMLAH QTY MELEBIHI DARI SALDO QTY SAAT  TGL BUAT
						}else if($stok_saat_itu < $jumlah_rb){
							echo "99||QUANTITY BERLEBIHAN!!";
							return false;
						//JIKA SALDO QTY SAAT TGL BUAT TSB BELUM ADA
						}
						// else if($tgl_buat < $tgl_awal_stok_ada) {
				  //  			echo "99||TANGGAL SURAT JALAN TERSEBUT TIDAK DIPERBOLEHKAN !!!";
						// 	return false;
						// }

						//UPDATE CRD STOK
						$mySql3 = " UPDATE crd_stok SET tgl_input='".$tgl_input."', qty_out='".$q_keluar."', saldo_qty='".$saldo_q."', saldo_last_hpp='".$saldo_last_hpp1."', saldo_total='".$saldo_total."' WHERE kode_barang='".$code_barang."' AND kode_cabang='".$kd_cabang."' AND kode_gudang='".$kd_gudang."' ";

						$query3 = mysqli_query ($con,$mySql3) ;

						//INSERT CRD STOK DTL
						$mySql4	= "INSERT INTO crd_stok_dtl SET
									kode_barang			='".$code_barang."',
									tgl_buat				='".$tgl_buat."',
									tgl_input				='".$tgl_input."',
									kode_cabang				='".$kd_cabang."',
									kode_gudang				='".$kd_gudang."',
									qty_out					='".$qty_out_dtl."',
									harga_out				='".$harga_out_dtl."',
									total_out				='".$total_out_dtl."',
									ref						='".$ref_untuk_crd."',
									note					='".$ref."',
									kode_transaksi			='".$kode_rb."';
								";

						$query4 = mysqli_query ($con,$mySql4) ;
					}

				}

			}

		$mySql1 = rtrim($mySql1,",");

		$query1 = mysqli_query ($con,$mySql1) ;

		//KARTU HUTANG
		$mySql7	= " INSERT INTO kartu_hutang SET
						kode_transaksi 	='".$kode_rb."',
						debet 			='".$grandtotal."',
					    kode_supplier 	='".$kode_supplier."',
						kode_cabang 	='".$kode_cabang."',
						tgl_buat 		='".$tgl_buat."',
						tgl_jth_tempo 	='".$tgl_jth_tempo."',
						user_pencipta 	='".$user_pencipta."',
						tgl_input		='".$tgl_input."'
					";

		$query7 = mysqli_query ($con,$mySql7) ;

		//HEADER BTB
		$mySql	= "INSERT INTO rb_hdr SET
						kode_rb			='".$kode_rb."',
						kode_cabang		='".$kode_cabang."',
						kode_gudang		='".$kode_gudang."',
						kode_supplier	='".$kode_supplier."',
						ref				='".$ref."',
						tgl_buat		='".$tgl_buat."',
						keterangan_hdr	='".$keterangan_hdr."',
						user_pencipta	='".$user_pencipta."',
						total_harga		='".$total_harga."',
						total_ppn		='".$total_ppn."',
						grandtotal		='".$grandtotal."'
				  ";

		$query = mysqli_query ($con,$mySql) ;

		if ($query AND $query1 AND $query3 AND $query4 AND $query5 AND $query6 AND $query7) {

			// Commit transaction
			mysqli_commit($con);

			// Close connection
			mysqli_close($con);

			echo "00||".$kode_rb;
			unset($_SESSION['data_rb']);

		} else {

			echo "Gagal query: ".$mySql3;
		}
		*/

	}

// PEMBATALAN NOTA RETUR PEMBELIAN
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "pembatalan" )
	{
		mysqli_autocommit($con,FALSE);

		$kode_rb		= $_POST['kode_rb_batal'];
		$alasan_batal	= $_POST['alasan_batal'];
		$tgl_batal 		= date("Y-m-d");

		//UPDATE RB_HDR
		$mySql1 = "UPDATE rb_hdr SET status ='2', alasan_batal = '" . $alasan_batal . "', user_batal = '" . $_SESSION['app_id'] . "', tgl_batal = '" . $tgl_batal . "' WHERE kode_rb='".$kode_rb."' ";
		$query1 = mysqli_query ($con,$mySql1) ;

		//UPDATE RB_DTL
		$mySql2 = "UPDATE rb_dtl SET status_dtl ='2' WHERE kode_rb='".$kode_rb."' ";
		$query2 = mysqli_query ($con,$mySql2) ;

		$kode_fb = mysql_query("SELECT kode_fb FROM rb_dtl WHERE kode_rb = '".$kode_rb."' ");
		$num_row_desc = mysql_num_rows($kode_fb);

		if($num_row_desc > 0){
			while($row_desc = mysql_fetch_array($kode_fb)){

				$kode = $row_desc['kode_fb'];

				$mySql3 = "UPDATE fb_hdr SET status ='1' WHERE kode_fb = '".$kode."' ";
				$query3 = mysqli_query ($con,$mySql3) ;

				$mySql4 = "UPDATE fb_dtl SET status_dtl ='1' WHERE kode_fb = '".$kode."' ";
				$query4 = mysqli_query ($con,$mySql4) ;

				//INSERT KARTU_HUTANG
				$hutang = mysql_query("SELECT * FROM kartu_hutang WHERE kode_transaksi = '".$kode_rb."'");
				$num_row_p  = mysql_num_rows($hutang);

					if($num_row_p > 0){
						while($row_p = mysql_fetch_array($hutang)){

							$kode_transaksi 	= $row_p['kode_transaksi'];
							$kode_pelunasan 	= $row_p['kode_pelunasan'];
							$debet 				= $row_p['debet'];
							$kredit 			= $row_p['kredit'];
							$kode_cabang 		= $row_p['kode_cabang'];
							$kode_supplier 		= $row_p['kode_supplier'];
							$tgl_jth_tempo 		= $row_p['tgl_jth_tempo'];
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

							$mySql6 = "UPDATE kartu_hutang SET status_batal ='1' WHERE kode_transaksi = '".$kode_transaksi."'";
							$query6 = mysqli_query ($con,$mySql6) ;
						}
					}
			}
		}

		$kode_barang = mysql_query("SELECT rd.kode_barang, rh.kode_gudang FROM rb_dtl rd INNER JOIN rb_hdr rh ON rh.kode_rb = rd.kode_rb WHERE rd.kode_rb = '".$kode_rb."'");
		$num_row_b   = mysql_num_rows($kode_barang);
		if($num_row_b > 0){
			while($row_b = mysql_fetch_array($kode_barang)){

				$kode_gudang = $row_b['kode_gudang'];
				$barang = $row_b['kode_barang'];
				$pisah=explode(":",$barang);
				$kd_barang=$pisah[0];


				$crd_stok_dtl = mysql_query("SELECT qty_out, harga_out, total_out FROM crd_stok_dtl WHERE kode_barang = '".$kd_barang."' AND kode_cabang = '".$kode_cabang."' AND kode_gudang = '".$kode_gudang."' AND kode_transaksi = '".$kode_rb."'");
				$num_row_cd   = mysql_num_rows($kode_barang);
				if($num_row_cd > 0) {
					$row_cd = mysql_fetch_array($crd_stok_dtl);

						$qty_out_dtl   	= $row_cd['qty_out'];
						$harga_out 		= $row_cd['harga_out'];
						$total_out 		= $row_cd['total_out'];
						$tgl_input 		= date("Y-m-d H:i:s");

						$mySql9 = "INSERT INTO crd_stok_dtl SET
									kode_barang 	='".$kd_barang."',
									tgl_input 		='".$tgl_input."',
									kode_cabang 	='".$kode_cabang."',
									kode_gudang 	='".$kode_gudang."',
									qty_in 			='".$qty_out_dtl."',
									harga_in 		='".$harga_out."',
									total_in 		='".$total_out."',
									ref  			='nota retur pembelian batal',
									kode_transaksi  ='".$kode_rb."',
									tgl_buat 		='".$tgl_batal."'
							";
						$query9 = mysqli_query ($con,$mySql9) ;
				}

				$crd_stok = mysql_query("SELECT * FROM crd_stok WHERE kode_barang = '".$kd_barang."' AND kode_cabang = '".$kode_cabang."' AND kode_gudang = '".$kode_gudang."'");
				$num_row_c = mysql_num_rows($crd_stok);
				if($num_row_c > 0) {
					$row_c = mysql_fetch_array($crd_stok);

						$qty_masuk 	 	= $row_c['qty_in'];
						$qty_keluar 	= $row_c['qty_out'];
						$saldo_total 	= $row_c['saldo_total'];
						$saldo_last_hpp = $row_c['saldo_last_hpp'];

						$qty_out 		= ceil($qty_keluar - $qty_out_dtl);
						$saldo_qty 		= ceil($qty_masuk - $qty_out);
						$saldo_total1 	= ceil($saldo_qty*$saldo_last_hpp);

						$mySql10 = "UPDATE crd_stok SET
									kode_barang 	='".$kd_barang."',
									tgl_input 		='".$tgl_input."',
									kode_cabang 	='".$kode_cabang."',
									kode_gudang 	='".$kode_gudang."',
									qty_in 			='".$qty_masuk."',
									qty_out 		='".$qty_out."',
									saldo_qty 		='".$saldo_qty."',
									saldo_last_hpp 	='".$saldo_last_hpp."',
									saldo_total  	='".$saldo_total1."'
									WHERE kode_barang = '".$kd_barang."' AND kode_cabang = '".$kode_cabang."' AND kode_gudang = '".$kode_gudang."'
							";
						$query10 = mysqli_query ($con,$mySql10) ;
				}
			}
		}

		//INSERT JURNAL
		$jurnal = mysql_query("SELECT * FROM jurnal WHERE kode_transaksi = '".$kode_rb."' ");
		$num_row_j  = mysql_num_rows($jurnal);

		if($num_row_j > 0){
			while($row_j = mysql_fetch_array($jurnal)){

				$kode_transaksi 	= $row_j['kode_transaksi'];
				$ref 				= $row_j['ref'];
				$tgl_buat 			= $row_j['tgl_buat'];
				$kode_coa 			= $row_j['kode_coa'];
				$debet 				= $row_j['debet'];
				$kredit 			= $row_j['kredit'];
				$tgl_input 			= date("Y-m-d H:i:s");
				$keterangan_hdr 	= $row_j['keterangan_hdr'];
				$keterangan_dtl 	= $row_j['keterangan_dtl'];

				$mySql7 = "INSERT INTO jurnal SET
								kode_transaksi 	='".$kode_transaksi."',
								ref 			='".$ref."',
								tgl_buat 		='".$tgl_buat."',
								kode_cabang 	='".$kode_cabang."',
								kode_supplier 	='".$kode_supplier."',
								kode_coa 		='".$kode_coa."',
								debet  			='".$kredit."',
								kredit  		='".$debet."',
								tgl_input 		='".$tgl_input."',
								keterangan_hdr 	='".$keterangan_hdr."',
								keterangan_dtl 	='".$keterangan_dtl."'
							";
				$query7 = mysqli_query ($con,$mySql7) ;

				$mySql8 = "UPDATE jurnal SET status_jurnal ='2' WHERE kode_transaksi = '".$kode_transaksi."' ";
				$query8 = mysqli_query ($con,$mySql8) ;
			}
		}

		if ($query1 AND $query2 AND $query3 AND $query4 AND $query5 AND $query6 AND $query7 AND $query8 AND $query9 AND $query10) {

			mysqli_commit($con);
			mysqli_close($con);

			echo "00||".$kode_rb;
		} else {
			echo "Gagal query: ".mysql_error();
		}
	}

?>
