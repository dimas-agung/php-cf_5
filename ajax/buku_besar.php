<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	date_default_timezone_set("Asia/Jakarta");
	
	
	#==================================================================================
	#							Buku Besar 
	#==================================================================================
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "bb-load" ){
		$rekening_awal 	= $_POST['rekening_awal'];
		$rekening_akhir = $_POST['rekening_akhir'];
		$kode_cabang 	= $_POST['kode_cabang'];
		$rekening_awal	= $_POST['rekening_awal'];
		$rekening_akhir	= $_POST['rekening_akhir'];
		
		$tanggal_awal	= date("Y-m-d",strtotime($_POST['tgl_awal']));
		$tanggal_akhir	= date("Y-m-d",strtotime($_POST['tgl_akhir']));
		$page = (isset($_GET['page']))? $_GET['page'] : 1;

		// Jumlah data per halamannya
		$limit = 5; 

		// Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database
		$limit_start = ($page - 1) * $limit;

		$query	= "SELECT * FROM(
SELECT '1' urutan,'0' id_jurnal,b.kode_coa lawan_dari_coa,b.nama nama_coa, '0' tgl_buat, '' kode_transaksi, '' inisial, '' ref, '' nama_cabang, '' keterangan_dtl, '0' debet, '0' kredit, '' kode_coa, '' nama_coa_lawan, IFNULL((SELECT SUM(debet)-SUM(kredit) AS saldo_awal FROM jurnal WHERE kode_coa=b.kode_coa AND kode_cabang='".$kode_cabang."' AND tgl_buat < '".$tanggal_awal."'),0) saldo_awal FROM coa b WHERE b.kode_coa BETWEEN '".$rekening_awal."' AND '".$rekening_akhir."' 
UNION 
SELECT '2' urutan,id_jurnal,a.lawan_dari_coa, '' nama_coa, a.tgl_buat, a.kode_transaksi, SUBSTRING(a.kode_transaksi, -6, 2) inisial, a.ref, b.nama nama_cabang, a.keterangan_dtl, a.coa_debet_lawan debet, a.coa_kredit_lawan kredit, a.kode_coa, c.nama nama_coa_lawan, '0' saldo_awal FROM jurnal a 
LEFT JOIN cabang b ON b.kode_cabang=a.kode_cabang 
LEFT JOIN coa c ON c.kode_coa = a.kode_coa
WHERE a.kode_cabang = '".$kode_cabang."' AND lawan_dari_coa BETWEEN '".$rekening_awal."' AND '".$rekening_akhir."' AND a.tgl_buat BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' 
UNION 
SELECT '3' urutan,'' id_jurnal, lawan_dari_coa, '' nama_coa, '1' tgl_buat, '' kode_transaksi, '' inisial, '' ref, '' nama_cabang, '' keterangan_dtl, IFNULL(SUM(coa_debet_lawan),0) debet, IFNULL(SUM(coa_kredit_lawan),0) kredit, '' kode_coa, '' nama_coa_lawan, '0' saldo_awal 
FROM jurnal 
WHERE kode_cabang = '".$kode_cabang."' AND lawan_dari_coa BETWEEN '".$rekening_awal."' AND '".$rekening_akhir."' AND tgl_buat BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' GROUP BY lawan_dari_coa ) AS tbl ORDER BY lawan_dari_coa,urutan,tgl_buat,id_jurnal ASC";

		// die($query);
		$result = mysql_query($query);
		
		$periode = "";
		
		if(mysql_num_rows($result)>0) {
			if($_POST['tgl_awal'] != "" and $_POST['tgl_akhir'] != "") { $periode = "Periode : ".tgl_indo($_POST['tgl_awal'])." - ".tgl_indo($_POST['tgl_akhir']);}

			echo view_buku_besar($result, $periode, $rekening_awal, $rekening_akhir, $kode_cabang);
		} else {
			echo '<h2>Maaf!! Tidak ada data ditemukan.</h2>';
		}
    }

    function view_buku_besar($result, $periode, $rekening_awal, $rekening_akhir, $kode_cabang){
		$q_cab =  mysql_query("SELECT kode_cabang,nama FROM cabang ORDER BY id_cabang");
		while($res = mysql_fetch_array($q_cab)){
			if ($res['kode_cabang']==$kode_cabang){
				$nama_cabang = $res['nama'];
			}
		}

		$ttldeb_kred = 0;
		$ttlDebet 	 = 0;
		$ttlKredit 	 = 0;
		$totalgrand  = 0;

		$html = "";
		$html .= '<h3 style="text-align:center">
					<br /> Laporan Buku Besar 
					<br /> Cabang : '.$nama_cabang.'
					<br /> '.$periode.' <br />	 
			      </h3>';
		$html .= '<table id="example1" width="100%" class="table table-striped table-bordered table-hover" >
					<thead>
						<tr>
                            <th style="background:#00BFFF">Tanggal</th>
                            <th style="background:#00BFFF">Kode Transaksi</th>
                            <th style="background:#00BFFF">Ref</th>
							<th style="background:#00BFFF">Cabang</th>
                            <th style="background:#00BFFF">Lawan</th>
							<th style="background:#00BFFF">Keterangan</th>
							<th style="background:#00BFFF">Debet</th>
                            <th style="background:#00BFFF">Kredit</th>
                            <th style="background:#00BFFF">Saldo</th>
						</tr>
					</thead>
					<tbody>';

		if(mysql_num_rows($result) > 0) {

			$coa_saldo_awal	='0';
			$saldo_awal		='0';
			$gtotal_debet	='0';
			$gtotal_kredit	='0';
			$link			='';

			while ($item = mysql_fetch_array($result)){
				
				$coa_saldo_awal =$item['lawan_dari_coa'];
				$id_jurnal 		=$item['id_jurnal'];
				$tgl_buat 		=$item['tgl_buat'];
				$urutan 		=$item['urutan'];
				
				
				if($urutan==1){
					$saldo_awal=$item['saldo_awal'];
					$html.= '<tr>
						<td colspan="8" align="left" style="color:#00F">'.$coa_saldo_awal.' - '.$item['nama_coa'].'</td>
						<td align="right" style="color:#00F">'.number_format($saldo_awal).'</td>
						</tr>';
				}
				
				$kode = $item['kode_transaksi'];
				$kode_transaksi = $item['inisial']; 
                
                switch ($kode_transaksi) {
                    case "KM" : $link="?page=keuangan/bkm_track&action=track&kode_bkm=".$kode; break;
                    case "BM" : $link="?page=keuangan/bkm_track&action=track&kode_bkm=".$kode; break;
					case "KK" : $link="?page=keuangan/bkk_track&action=track&kode_bkk=".$kode; break;
                    case "BK" : $link="?page=keuangan/bkk_track&action=track&kode_bkk=".$kode; break;
                  
                }

                // die($kode_transaksi);
				
				if($coa_saldo_awal==$item['lawan_dari_coa'] AND $urutan==2){
					$ttlSaldo = (int)($saldo_awal+($item['debet'] - $item['kredit']));
					
					$html .= '<tr>
						<td style="background:#CCC">'.$item['tgl_buat'].'</td>
						<td style="background:#CCC"><a href='.base_url().''.$link.'>'.$item['kode_transaksi'].'</a></td>
						<td style="background:#CCC">'.$item['ref'].'</td>
						<td style="background:#CCC">'.$item['nama_cabang'].'</td>
						<td style="background:#CCC">'.$item['kode_coa'].' | '.$item['nama_coa_lawan'].'</td>
						<td style="background:#CCC">'.$item['keterangan_dtl'].'</td>
						<td style="background:#CCC" align="right">'.number_format($item['debet']).'</td>
						<td style="background:#CCC" align="right">'.number_format($item['kredit']).'</td>	
						<td style="background:#CCC" align="right">'.number_format($ttlSaldo).'</td>
					</tr>';
					
					$saldo_awal = $ttlSaldo;
				}
				
				if($urutan==3){
					
					$total_debet=$item['debet'];
					$total_kredit=$item['kredit'];
					
					$html.= '<tr>
						<td colspan="6" style="background:#90EE90"></td>
						<td align="right" style="background:#90EE90"><b>'.number_format($total_debet).'</b></td>
						<td align="right" style="background:#90EE90"><b>'.number_format($total_kredit).'</b></td>
						<td align="right" style="background:#90EE90"></td>
						</tr>';
						
					$gtotal_debet += $total_debet;
					$gtotal_kredit += $total_kredit;	
				
				}
				
			}
			
			$html.= '<tr>
						<td colspan="6" align="right" style="background:#00BFFF"><strong>TOTAL</strong></td>
						<td align="right" style="background:#00BFFF"><b>'.number_format($gtotal_debet).'</b></td>
						<td align="right" style="background:#00BFFF"><b>'.number_format($gtotal_kredit).'</b></td>
						<td align="right" style="background:#00BFFF"></td>
					</tr>';
			
			$html.='</table>';

		} else { 
			$html = '<tr> <td colspan="10" class="text-center"> Tidak ada neraca. </td></tr>';
		}
		
		return $html;
	}
    	
?>