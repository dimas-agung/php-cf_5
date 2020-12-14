<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	require('../pages/data/script/bj.php');
	date_default_timezone_set("Asia/Jakarta");

if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save" )
	{

		$form 			= 'TG';
		$thnblntgl 		= date("ymd",strtotime(mres($_POST['tanggal'])));
		$id_form			= mres($_POST['id_form']);
		$kode_spk	= mres($_POST['kode_spk']);
		$ref	= mres($_POST['ref']);
		$tgl_buat 		= date("Y-m-d",strtotime(mres($_POST['tanggal'])));
		$kode_cabang	= mres($_POST['kode_cabang']);
		$kode_gudang	= mres($_POST['kode_gudang']);
		$keterangan_hdr	= mres($_POST['keterangan']);
		$user_pencipta  	= $_SESSION['app_id'];
		$tgl_input 			= date("Y-m-d H:i:s");	
		$kode_barang = $_POST['kode_barang'][0];
		$kode_satuan = $_POST['kode_satuan'][0];
		$qty = $_POST['qty'][0];

		$kode_fg = buat_kode_fg($thnblntgl,$form,$kode_cabang);	
		
		$mySql = "INSERT INTO `fg_hdr` (`kode_fg`, `ref`, `kode_spk`, `kode_cabang`, `kode_gudang`, `kode_inventori`, `kode_satuan`, `qty`, `tgl_buat`, `keterangan_hdr`, `user_id`, `tgl_input`) VALUES ('".$kode_fg."', '".$ref."', '".$kode_spk."', '".$kode_cabang."', '".$kode_gudang."', '".$kode_barang."', '".$kode_satuan."', '".$qty."', '".$tgl_buat."', '".$keterangan_hdr."', '".$user_pencipta."', '".$tgl_input."')";
		$query = mysql_query($mySql);
		
		$mySql1 = "SELECT `inventori`.`kode_inventori`, `inventori`.`nama` AS `nama_inventori`, '1.01.11.02' AS `kode_coa`, IFNULL(`crd_stok`.`saldo_last_hpp`, 0) AS `map` FROM `inventori` LEFT JOIN `crd_stok` ON `inventori`.`kode_inventori` = `crd_stok`.`kode_barang` AND `crd_stok`.`kode_cabang` = '".$kode_cabang."' AND `crd_stok`.`kode_gudang` = '".$kode_gudang."' WHERE `inventori`.`kode_inventori` = '".$kode_barang."'";
		$query1 = mysql_query($mySql1);
		
		if (mysql_num_rows($query1)) {
			while ($query1_res = mysql_fetch_array($query1)) {
				$kd_produk  = $query1_res['kode_inventori'];
				$nm_produk  = $query1_res['nama_inventori'];
				$hpp        = $query1_res['map'];
				$kode_coa = $query1_res['kode_coa'];
			
				$cekStokIn = "SELECT `crd_stok`.`kode_barang`, `crd_stok`.`kode_cabang`, `crd_stok`.`kode_gudang`, `crd_stok`.`qty_in`, `crd_stok`.`qty_out`, `crd_stok`.`saldo_qty`, `crd_stok`.`saldo_last_hpp`, `crd_stok`.`saldo_total` FROM `crd_stok` WHERE `crd_stok`.`kode_barang` = '".$kd_produk."' AND `crd_stok`.`kode_cabang` = '".$kode_cabang."' AND `crd_stok`.`kode_gudang` = '".$kode_gudang."'";
				$qCekStokIn = mysql_query($cekStokIn);
				
				if (mysql_num_rows($qCekStokIn)) {
					
					$resCekStokIn = mysql_fetch_array($qCekStokIn);
					
					$saldo_total = $resCekStokIn['saldo_total'];
                    $saldo_qty = $resCekStokIn['saldo_qty'];

                    $rumus_hpp= ($saldo_total+($hpp*$qty))/($saldo_qty+$qty);
                
                    $qty_i_in = $resCekStokIn['qty_in']+$qty;
                    $qty_i_out = $resCekStokIn['qty_out'];
                    $saldo_qty_i = $qty_i_in-$qty_i_out;
                    $saldo_last_hpp_i = ($rumus_hpp);
                    $saldo_total_i = ($saldo_qty_i*$saldo_last_hpp_i);
					
					$crdStokIn = "UPDATE `crd_stok` SET `saldo_qty` = '".$saldo_qty_i."', `saldo_last_hpp` = '".$saldo_last_hpp_i."', `saldo_total` = '".$saldo_total_i."', WHERE `kode_barang` = '".$kd_produk."' AND `kode_cabang` = '".$kode_cabang."' AND `kode_gudang` = '".$kode_gudang."'";
					$qCrdStokIn = mysql_query($crdStokin);
					
					$crdStokDIn = "INSERT INTO `crd_stok` (`kode_barang`, `tgl_buat`, `tgl_input`, `kode_cabang`, `kode_gudang`, `qty_in`, `harga_in`, `total_in`, `ref`, `note`, `kode_transaksi`) VALUES ('".$kd_produk."', '".$tgl_buat."', '".$tgl_input."', '".$kode_cabang."', '".$kode_gudang."', '".$qty."', '".$hpp."', '".($qty * $hpp)."', '".$ref."', '".$keterangan_hdr."', '".$kode_fg."')";
					$qCrdStokDIn = mysql_query($crdStokDin);
					
				} else {
					$crdStokIn = "INSERT INTO `crd_stok` (`kode_barang`, `tgl_input`, `kode_cabang`, `kode_gudang`, `qty_in`, `saldo_qty`, `saldo_last_hpp`, `saldo_total`) VALUES ('".$kd_produk."', '".$tgl_input."', '".$kode_cabang."', '".$kode_gudang."', '".$qty."', '".$qty."', '".$hpp."', '".($qty * $hpp)."')";
					$qCrdStokIn = mysql_query($crdStokin);
					
					$crdStokDIn = "INSERT INTO `crd_stok` (`kode_barang`, `tgl_buat`, `tgl_input`, `kode_cabang`, `kode_gudang`, `qty_in`, `harga_in`, `total_in`, `ref`, `note`, `kode_transaksi`) VALUES ('".$kd_produk."', '".$tgl_buat."', '".$tgl_input."', '".$kode_cabang."', '".$kode_gudang."', '".$qty."', '".$hpp."', '".($qty * $hpp)."', '".$ref."', '".$keterangan_hdr."', '".$kode_fg."')";
					$qCrdStokDIn = mysql_query($crdStokDin);
				}
				
				$jurnal_d = "INSERT INTO `jurnal` (`kode_transaksi`, `tgl_input`, `tgl_buat`, `kode_cabang`, `keterangan_hdr`, `ref`, `kode_coa`, `debet`, `user_pencipta`) VALUES ('".$kode_fg."', '".$tgl_input."', '".$tgl_buat."', '".$kode_cabang."', '".$keterangan_hdr."', '".$ref."', '".$kode_coa."', '".($qty * $hpp)."', '".$user_pencipta."')";
				$q_jurnal_d = mysql_query($jurnal_d);
				
				$kode_coa_2 = '5.01.01.04';
				$jurnal_k = "INSERT INTO `jurnal` (`kode_transaksi`, `tgl_input`, `tgl_buat`, `kode_cabang`, `keterangan_hdr`, `ref`, `kode_coa`, `kredit`, `user_pencipta`) VALUES ('".$kode_fg."', '".$tgl_input."', '".$tgl_buat."', '".$kode_cabang."', '".$keterangan_hdr."', '".$ref."', '".$kode_coa_2."', '".($qty * $hpp)."', '".$user_pencipta."')";
				$q_jurnal_k = mysql_query($jurnal_k);
				
			}
			
			$spkU = "UPDATE `spk_hdr` SET `to_fg` = 'yes' WHERE `kode_spk` = '".$kode_spk."'";
			$qSpkU = mysql_query($spkU);
			echo "00||".$kode_fg;
		} else {
			echo "99||Gagal query: ".$mySql1;
		}
	}
?>
