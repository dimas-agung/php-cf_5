<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	date_default_timezone_set("Asia/Jakarta");
	
	
	#==================================================================================
	#							Gross Profit
	#==================================================================================
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "gross_profit" ){
        $kode_cabang 	= $_POST['kode_cabang'];
		$tanggal_awal	= date("Y-m-d",strtotime($_POST['tgl_awal']));
		$page 			= (isset($_GET['page']))? $_GET['page'] : 1;
		$limit = 5; // Jumlah data per halamannya

		// Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database
		$limit_start = ($page - 1) * $limit;

		$query = "SELECT DISTINCT(a.kode_inventori), nama, kode_cabang, IFNULL((SELECT MIN(harga) FROM harga_inventori WHERE harga>0 AND kode_inventori = a.kode_inventori),0) harga_jual, IFNULL((c.saldo_last_hpp),0) map, IFNULL(MAX(a.tgl_input),'') tgl_input 
					FROM inventori a 
					LEFT JOIN harga_inventori b on a.kode_inventori=b.kode_inventori 
					LEFT JOIN crd_stok c on a.kode_inventori=c.kode_barang 
					WHERE jenis_stok LIKE '%1%' AND kode_cabang = '".$kode_cabang."'  
					GROUP BY a.kode_inventori";
		// die($query);
		$result = mysql_query($query);
		$periode = "";
		
		if(mysql_num_rows($result)>0) {
			echo view_gross_profit($result, $periode);
		} else {
			echo '<h2>Maaf!! Tidak ada data Laporan Gross Profit yang ditemukan.</h2>';
		}
    }

    function view_gross_profit($result, $periode){
        $html = "";
        /*
		$html .= '<h3 style="text-align:center"><br /> Neraca Percobaan <br /> '.$periode.' <br />						 
                      </h3>';*/
		$html .= '<table id="example1" class="table table-striped table-bordered table-hover" >
					<thead>
						<tr>
                            <th colspan="2">Inventory</th>
                            <th>Harga Jual</th>
                            <th>MAP</th>
                            <th>GP (%)</th>
						</tr>
					</thead>
					<tbody id="show-gros-profit">';

		$gp 		= 0;
		if(mysql_num_rows($result) > 0) {
			while ($item = mysql_fetch_array($result)){
                $gp  =@($item['harga_jual']/$item['map'])*100;

				$html .= '<tr>
						    <td>'.$item['kode_inventori'].'</td>
						    <td>'.$item['nama'].'</td>
							<td style="text-align: right">'.number_format($item['harga_jual']).'</td>
							<td style="text-align: right">'.number_format($item['map']).'</td>
							<td style="text-align: right">'.$gp.' %'.'</td>
						  </tr>';
			}
		} else { 
			$html = '<tr> <td colspan="10" class="text-center"> Tidak ada neraca. </td></tr>';
		}
		
		return $html;
	}
    	
?>