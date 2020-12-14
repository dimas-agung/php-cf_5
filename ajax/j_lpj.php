<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	date_default_timezone_set("Asia/Jakarta");

	#==================================================================================
	#							LAPORAN PEMBELIAN 
	#==================================================================================
	 
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "lpj-load" ){
		$tanggal_awal	= date("Y-m-d",strtotime($_POST['tgl_awal']));
		$tanggal_akhir	= date("Y-m-d",strtotime($_POST['tgl_akhir'])); 
		
		$page = (isset($_GET['page']))? $_GET['page'] : 1;
		$limit = 5; // Jumlah data per halamannya
		// Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database
		$limit_start = ($page - 1) * $limit;
		$query			= "SELECT sh.kode_pelanggan, p.nama nama_pelanggan, sd.kode_inventori kode_barang, sd.nama_inventori nama_barang, oh.tgl_buat tgl_so, sd.kode_so, sh.tgl_buat tgl_sj, 
							sh.kode_sj, fh.tgl_buat tgl_fj, fh.kode_fj, sd.satuan_qty_so3 satuan, sd.qty_so3 qty, sd.harga, sd.diskon FROM sj_hdr sh
							LEFT JOIN pelanggan p ON p.kode_pelanggan = sh.kode_pelanggan
							LEFT JOIN sj_dtl sd ON sd.kode_sj = sh.kode_sj
							LEFT JOIN so_hdr oh ON oh.kode_so = sd.kode_so
							LEFT JOIN fj_hdr fh ON fh.kode_sj = sh.kode_sj
							WHERE sh.kode_pelanggan LIKE '%".$_POST['pelanggan']."%' AND sd.kode_inventori LIKE '%".$_POST['barang']."%' AND sh.kode_cabang LIKE '%".$_POST['cabang']."%' AND sh.kode_gudang LIKE '%".$_POST['gudang']."%' AND sh.tgl_buat BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' 
							ORDER BY fh.kode_fj";
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
		
		$_SESSION['q_lap_pj'] = $query;
		$_SESSION['q_jdl_pj'] = $periode;
	}
	
	
	function view_pembelian($result, $periode){
	
		$n=1;
		$html = "";
		$html .= '<h3 style="text-align:center">LAPORAN PENJUALAN<br>'.$periode.'</h3>';
		$html .= '<table rules="cols">
					<thead>
						<tr> 
							<th>Pelanggan</th>
							<th colspan="2">Barang</th>
							<th>Tgl SO</th>
							<th>Kode SO</th>
							<th>Tgl SJ</th>
							<th>Kode SJ</th>
							<th>Tgl FJ</th>
							<th>Kode FJ</th>
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
					<td>'.$item['nama_pelanggan'].'</td>
					<td>'.$item['kode_barang'].'</td>
					<td>'.$item['nama_barang'].'</td>
					<td>'.tgl_indo($item['tgl_so']).'</td>
					<td><a href="'.base_url().'?page=penjualan/so_track&action=track&halaman=TRACK SALES ORDER&kode_so='.$item['kode_so'].'" target="_blank" >'.$item['kode_so'].'</a></td>
					<td>'.tgl_indo($item['tgl_sj']).'</td>
					<td><a href="'.base_url().'?page=logistik/sj_track&action=track&halaman=TRACK SURAT JALAN&kode_sj='.$item['kode_sj'].'" target="_blank" >'.$item['kode_sj'].'</a></td>
					<td>'.tgl_indo($item['tgl_fj']).'</td>
					<td><a href="'.base_url().'?page=penjualan/fj_track&action=track&halaman=TRACK FAKTUR PENJUALAN&kode_fj='.$item['kode_fj'].'" target="_blank" >'.$item['kode_fj'].'</a></td>
					<td>'.$item['satuan'].'</td>
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