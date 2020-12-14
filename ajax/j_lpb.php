<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	date_default_timezone_set("Asia/Jakarta");

	#==================================================================================
	#							LAPORAN PEMBELIAN 
	#==================================================================================
	 
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "lpb-load" ){
		$tanggal_awal	= date("Y-m-d",strtotime($_POST['tgl_awal']));
		$tanggal_akhir	= date("Y-m-d",strtotime($_POST['tgl_akhir']));
		$supplier		= $_POST['supplier'];
		$sup 			= explode("-",$supplier);
		$supplier 		= $sup[0]; 
		
		$page = (isset($_GET['page']))? $_GET['page'] : 1;
		$limit = 5; // Jumlah data per halamannya
		// Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database
		$limit_start = ($page - 1) * $limit;
		$query			= "SELECT bh.kode_supplier, s.nama nama_supplier, SUBSTRING_INDEX(bd.kode_barang, ':',1) kode_barang, i.nama nama_barang, oh.tgl_buat tgl_op, bh.kode_op, bh.tgl_buat tgl_btb, bh.kode_btb, fh.tgl_buat tgl_fb, fh.kode_fb, SUBSTRING_INDEX(bd.satuan, ':', 1) kode_satuan, sat.nama nama_satuan, bd.qty, bd.harga, bd.diskon FROM btb_hdr bh
							LEFT JOIN supplier s ON s.kode_supplier = bh.kode_supplier
							LEFT JOIN op_hdr oh ON oh.kode_op = bh.kode_op 
							LEFT JOIN btb_dtl bd ON bd.kode_btb = bh.kode_btb 
							LEFT JOIN inventori i ON i.kode_inventori = SUBSTRING_INDEX(bd.kode_barang, ':',1) 
							LEFT JOIN fb_dtl fd ON fd.kode_btb = bh.kode_btb AND fd.kode_op = oh.kode_op
							LEFT JOIN fb_hdr fh ON fh.kode_fb = fd.kode_fb
							LEFT JOIN satuan sat ON sat.kode_satuan = SUBSTRING_INDEX(bd.satuan, ':', 1)
							WHERE bh.kode_supplier LIKE '%".$supplier."%' AND SUBSTRING_INDEX(bd.kode_barang, ':',1) LIKE '%".$_POST['barang']."%' AND bh.kode_cabang LIKE '%".$_POST['cabang']."%' AND bh.kode_gudang LIKE '%".$_POST['gudang']."%' AND bh.tgl_buat BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' 
							ORDER BY fh.kode_fb";
		// die($query);
		$src	= array("and a.tgl_transaksi between '' and ''");
		$rpl	= array("");
		$query 	= str_replace($src, $rpl, $query);
		$result = mysql_query($query);
		$periode = "";
		
		if(mysql_num_rows($result) > 0) {
			if($_POST['tgl_awal'] != "" and $_POST['tgl_akhir'] != "") { $periode = "Periode : ".tgl_indo($_POST['tgl_awal'])." - ".tgl_indo($_POST['tgl_akhir']);}
			
			echo view_pembelian($result, $periode);
		} else {
			echo '<center><h4>Tidak ada data pembelian ditemukan.</h4></center>';
		}
		
		$_SESSION['q_lap_pb'] = $query;
		$_SESSION['q_jdl_pb'] = $periode;
	}
	
	
	function view_pembelian($result, $periode){
	
		$n=1;
		$html = "";
		$html .= '<h3 style="text-align:center">LAPORAN PEMBELIAN<br>'.$periode.'</h3>';
		$html .= '<table rules="cols">
					<thead>
						<tr> 
							<th>Supplier</th>
							<th colspan="2">Barang</th>
							<th>Tgl OP</th>
							<th>Kode OP</th>
							<th>Tgl BTB</th>
							<th>Kode BTB</th>
							<th>Tgl FB</th>
							<th>Kode FB</th>
							<th>Sat</th>
							<th>Jumlah</th>
							<th>Harga Sat</th>
							<th>Diskon</th>
							<th>Nominal</th>
							 
						</tr>
					</thead>
					<tbody id="show-item-barang">';
		if(mysql_num_rows($result) > 0) {
			$n=1;
			$total=0;
			while ($item = mysql_fetch_array($result)){
				$total = ($item['harga'] * $item['qty'])-$item['diskon'];
				$html .= '<tr>
					<td>'.$item['nama_supplier'].'</td>
					<td>'.$item['kode_barang'].'</td>
					<td>'.$item['nama_barang'].'</td>
					<td>'.tgl_indo($item['tgl_op']).'</td>
					<td><a href="'.base_url().'?page=pembelian/op_track&action=track&halaman=TRACK ORDER PEMBELIAN&kode='.$item['kode_op'].'" target="_blank" >'.$item['kode_op'].'</a></td>
					<td>'.tgl_indo($item['tgl_btb']).'</td>
					<td><a href="'.base_url().'?page=logistik/btb_track&action=track&halaman=TRACK BUKTI TERIMA BARANG&kode_btb='.$item['kode_btb'].'" target="_blank" >'.$item['kode_btb'].'</a></td>
					<td>'.tgl_indo($item['tgl_fb']).'</td>
					<td><a href="'.base_url().'?page=keuangan/fb_track&action=track&halaman=TRACK FAKTUR PEMBELIAN&kode_fb='.$item['kode_fb'].'" target="_blank" >'.$item['kode_fb'].'</a></td>
					<td>'.$item['nama_satuan'].'</td>
					<td style="text-align:right">'.$item['qty'].'</td>
					<td style="text-align:right">'.number_format($item['harga']).'</td>
					<td style="text-align:right">'.number_format($item['diskon']).'</td>
					<td style="text-align:right">'.number_format($total).'</td>
				
				</tr>';
				
				
			}			
		} else { 
			$html = '<tr> <td colspan="14" class="text-center"> Tidak ada item barang. </td></tr>';
		}
		
		return $html;
	}
	
	
?>