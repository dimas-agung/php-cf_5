<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	date_default_timezone_set("Asia/Jakarta");
	
	
	#==================================================================================
	#							Laba Rugi
	#==================================================================================
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "lbrg" ){
		$kode_cabang 	= $_POST['kode_cabang'];
		$awal_bulan1	= date('Y-m-d', mktime(0,0,0,$_POST['bulan'],1, $_POST['tahun']));
		$akhir_bulan1	= date('Y-m-t', strtotime($awal_bulan1));
		$awal_bulan2	= date('Y-m-d', strtotime($awal_bulan1.'- 1 month'));
		$akhir_bulan2	= date('Y-m-t', strtotime($awal_bulan1.'- 1 month'));
		$bulan 			= date('F', strtotime($awal_bulan1));
		$tahun			= date("Y",strtotime($awal_bulan1));
		$page 			= (isset($_GET['page']))? $_GET['page'] : 1;
		$limit = 5; // Jumlah data per halamannya

		// Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database
		$limit_start = ($page - 1) * $limit;

		$akun1= "SELECT a.kode_coa,a.level_coa,IFNULL(tgl_buat,'".$awal_bulan1."') tgl_buat, nama,IFNULL(kode_cabang,'') cabang,
				(SELECT IFNULL(SUM(kredit-debet),0) saldo_bulan_ini  FROM coa f LEFT JOIN jurnal g ON f.kode_coa=g.kode_coa WHERE f.kode_coa = a.kode_coa AND a.level_coa ='4' AND kode_cabang = '".$kode_cabang."' AND tgl_buat BETWEEN '".$awal_bulan1."' AND '".$akhir_bulan1."') saldo_ini,
				(SELECT ifNULL(SUM(kredit-debet),0) saldo_bulan_sebelumnya  FROM coa d LEFT JOIN jurnal e ON d.kode_coa=e.kode_coa WHERE d.kode_coa = a.kode_coa AND a.level_coa ='4' AND kode_cabang = '".$kode_cabang."' AND tgl_buat BETWEEN '".$awal_bulan2."' AND '".$akhir_bulan2."') saldo_sebelumnya  
				FROM coa a LEFT JOIN jurnal b ON a.kode_coa=b.kode_coa 
				WHERE a.kode_coa LIKE '4.%' AND a.level_coa ='4'  
				GROUP BY a.kode_coa";
		$akun2= "SELECT a.kode_coa,a.level_coa,IFNULL(tgl_buat,'".$awal_bulan1."') tgl_buat, nama,IFNULL(kode_cabang,'') cabang,
				(SELECT IFNULL(SUM(kredit-debet),0) saldo_bulan_ini  FROM coa f LEFT JOIN jurnal g ON f.kode_coa=g.kode_coa WHERE f.kode_coa = a.kode_coa AND a.level_coa ='4' AND kode_cabang = '".$kode_cabang."' AND tgl_buat BETWEEN '".$awal_bulan1."' AND '".$akhir_bulan1."') saldo_ini,
				(SELECT ifNULL(SUM(kredit-debet),0) saldo_bulan_sebelumnya  FROM coa d LEFT JOIN jurnal e ON d.kode_coa=e.kode_coa WHERE d.kode_coa = a.kode_coa AND a.level_coa ='4' AND kode_cabang = '".$kode_cabang."' AND tgl_buat BETWEEN '".$awal_bulan2."' AND '".$akhir_bulan2."') saldo_sebelumnya  
				FROM coa a LEFT JOIN jurnal b ON a.kode_coa=b.kode_coa 
				WHERE a.kode_coa LIKE '5.%' AND a.level_coa ='4'  
				GROUP BY a.kode_coa";
		$akun3= "SELECT a.kode_coa,a.level_coa,IFNULL(tgl_buat,'".$awal_bulan1."') tgl_buat, nama,IFNULL(kode_cabang,'') cabang,
				(SELECT IFNULL(SUM(kredit-debet),0) saldo_bulan_ini  FROM coa f LEFT JOIN jurnal g ON f.kode_coa=g.kode_coa WHERE f.kode_coa = a.kode_coa AND a.level_coa ='4' AND kode_cabang = '".$kode_cabang."' AND tgl_buat BETWEEN '".$awal_bulan1."' AND '".$akhir_bulan1."') saldo_ini,
				(SELECT ifNULL(SUM(kredit-debet),0) saldo_bulan_sebelumnya  FROM coa d LEFT JOIN jurnal e ON d.kode_coa=e.kode_coa WHERE d.kode_coa = a.kode_coa AND a.level_coa ='4' AND kode_cabang = '".$kode_cabang."' AND tgl_buat BETWEEN '".$awal_bulan2."' AND '".$akhir_bulan2."') saldo_sebelumnya  
				FROM coa a LEFT JOIN jurnal b ON a.kode_coa=b.kode_coa 
				WHERE a.kode_coa LIKE '6.%' AND a.level_coa ='4'  
				GROUP BY a.kode_coa";
		$akun4= "SELECT a.kode_coa,a.level_coa,IFNULL(tgl_buat,'".$awal_bulan1."') tgl_buat, nama,IFNULL(kode_cabang,'') cabang,
				(SELECT IFNULL(SUM(kredit-debet),0) saldo_bulan_ini  FROM coa f LEFT JOIN jurnal g ON f.kode_coa=g.kode_coa WHERE f.kode_coa = a.kode_coa AND a.level_coa ='4' AND kode_cabang = '".$kode_cabang."' AND tgl_buat BETWEEN '".$awal_bulan1."' AND '".$akhir_bulan1."') saldo_ini,
				(SELECT ifNULL(SUM(kredit-debet),0) saldo_bulan_sebelumnya  FROM coa d LEFT JOIN jurnal e ON d.kode_coa=e.kode_coa WHERE d.kode_coa = a.kode_coa AND a.level_coa ='4' AND kode_cabang = '".$kode_cabang."' AND tgl_buat BETWEEN '".$awal_bulan2."' AND '".$akhir_bulan2."') saldo_sebelumnya  
				FROM coa a LEFT JOIN jurnal b ON a.kode_coa=b.kode_coa 
				WHERE a.kode_coa LIKE '7.%' AND a.level_coa ='4'  
				GROUP BY a.kode_coa";
		$akun5= "SELECT a.kode_coa,a.level_coa,IFNULL(tgl_buat,'".$awal_bulan1."') tgl_buat, nama,IFNULL(kode_cabang,'') cabang,
				(SELECT IFNULL(SUM(kredit-debet),0) saldo_bulan_ini  FROM coa f LEFT JOIN jurnal g ON f.kode_coa=g.kode_coa WHERE f.kode_coa = a.kode_coa AND a.level_coa ='4' AND kode_cabang = '".$kode_cabang."' AND tgl_buat BETWEEN '".$awal_bulan1."' AND '".$akhir_bulan1."') saldo_ini,
				(SELECT ifNULL(SUM(kredit-debet),0) saldo_bulan_sebelumnya  FROM coa d LEFT JOIN jurnal e ON d.kode_coa=e.kode_coa WHERE d.kode_coa = a.kode_coa AND a.level_coa ='4' AND kode_cabang = '".$kode_cabang."' AND tgl_buat BETWEEN '".$awal_bulan2."' AND '".$akhir_bulan2."') saldo_sebelumnya  
				FROM coa a LEFT JOIN jurnal b ON a.kode_coa=b.kode_coa 
				WHERE a.kode_coa LIKE '8.%' AND a.level_coa ='4'  
				GROUP BY a.kode_coa";

		$r1 = mysql_query($akun1);
		$r2 = mysql_query($akun2);
		$r3 = mysql_query($akun3);
		$r4 = mysql_query($akun4);
		$r5 = mysql_query($akun5);
		$periode = "";
		
		if(mysql_num_rows($r1)>0) {
			if($_POST['bulan'] != "" and $_POST['tahun'] != "") { 
				$periode = "".$bulan." - ".$tahun;
			}
			echo view_laba_rugi($r1, $r2, $r3, $r4, $r5, $periode, $awal_bulan1);
		} else {
			echo '<h2>Maaf!! Tidak ada data ditemukan.</h2>';
		}
    }

    function view_laba_rugi($r1, $r2, $r3, $r4, $r5, $periode, $awal_bulan1){
		$html = "";
		$html .= '<h3 style="text-align:center"><br /> Laba / Rugi <br /> Per '.$periode.' <br />						 
		</h3>';
		$html .= '<table id="example1" class="table table-striped table-bordered table-hover" >
					<thead>
						<tr>
                            <th>Kode COA</th>
                            <th>Nama COA</th>
                            <th>'.date('t F Y',strtotime($awal_bulan1)).'</th>
                            <th>'.date('t F Y',strtotime($awal_bulan1.'- 1 month')).'</th>
						</tr>
					</thead>
					<tbody id="show-neraca-pecobaan">';
		
    	$totalini1 = 0;
		$totalsb1  = 0;
   		while ($item = mysql_fetch_array($r1)){
			$totalini1 += $item['saldo_ini'];
			$totalsb1  += $item['saldo_sebelumnya'];

	        $html.='<tr>
		                <td>'.$item['kode_coa'].'</td>
		                <td style="text-align:left">'.$item['nama'].'</td>
		                <td style="text-align:right">'.number_format($item['saldo_ini']).'</td>
		                <td style="text-align:right">'.number_format($item['saldo_sebelumnya']).'</td>
	            	</tr>';
        }

	        $html.='<tr class="success">
		        		<b>
			                <td style="text-align:left" colspan="2">TOTAL PENDAPATAN :</td>
			                <td style="text-align:right">Rp '.number_format($totalini1).'</td>
			                <td style="text-align:right">Rp '.number_format($totalsb1).'</td>
		                </b>
	            	</tr>';
            
	        $html.='<tr>
		                <td colspan="4"></td>
	            	</tr>';

	    $totalini2 = 0;
		$totalsb2  = 0;
   		while ($item = mysql_fetch_array($r2)){
			$totalini2 += $item['saldo_ini'];
			$totalsb2  += $item['saldo_sebelumnya'];

	        $html.='<tr>
		                <td>'.$item['kode_coa'].'</td>
		                <td style="text-align:left">'.$item['nama'].'</td>
		                <td style="text-align:right">'.number_format($item['saldo_ini']).'</td>
		                <td style="text-align:right">'.number_format($item['saldo_sebelumnya']).'</td>
	            	</tr>';
        }

        	$html.='<tr class="success">
               			<b> 
               				<td style="text-align:left" colspan="2">TOTAL HPP :</td>
			                <td style="text-align:right">Rp '.number_format($totalini2).'</td>
			                <td style="text-align:right">Rp '.number_format($totalsb2).'</td>
              			</b>
            		</tr>';
            
            $html.='<tr class="success">
            			<b>
			                <td style="text-align:left" colspan="2">LABA KOTOR :</td>
			                <td style="text-align:right">Rp '.number_format($totalini1+$totalini2).'</td>
			                <td style="text-align:right">Rp '.number_format($totalsb1+$totalsb2).'</td>
             			</b>
              		</tr>';
            
	        $html.='<tr>
		                <td colspan="4"></td>
	            	</tr>';

	    $totalini3 = 0;
		$totalsb3  = 0;
   		while ($item = mysql_fetch_array($r3)){
			$totalini3 += $item['saldo_ini'];
			$totalsb3  += $item['saldo_sebelumnya'];

	        $html.='<tr>
		                <td>'.$item['kode_coa'].'</td>
		                <td style="text-align:left">'.$item['nama'].'</td>
		                <td style="text-align:right">'.number_format($item['saldo_ini']).'</td>
		                <td style="text-align:right">'.number_format($item['saldo_sebelumnya']).'</td>
	            	</tr>';
        }

        	$html.='<tr class="success">
               			<b> 
               				<td style="text-align:left" colspan="2">TOTAL BIAYA ADMIN & UMUM :</td>
			                <td style="text-align:right">Rp '.number_format($totalini3).'</td>
			                <td style="text-align:right">Rp '.number_format($totalsb3).'</td>
              			</b>
            		</tr>';
            
	        $html.='<tr>
		                <td colspan="4"></td>
	            	</tr>';

	    $totalini4 = 0;
		$totalsb4  = 0;
   		while ($item = mysql_fetch_array($r4)){
			$totalini4 += $item['saldo_ini'];
			$totalsb4  += $item['saldo_sebelumnya'];

	        $html.='<tr>
		                <td>'.$item['kode_coa'].'</td>
		                <td style="text-align:left">'.$item['nama'].'</td>
		                <td style="text-align:right">'.number_format($item['saldo_ini']).'</td>
		                <td style="text-align:right">'.number_format($item['saldo_sebelumnya']).'</td>
	            	</tr>';
        }

        	$html.='<tr class="success">
               			<b> 
               				<td style="text-align:left" colspan="2">TOTAL BIAYA SALES & MARKETING :</td>
			                <td style="text-align:right">Rp '.number_format($totalini4).'</td>
			                <td style="text-align:right">Rp '.number_format($totalsb4).'</td>
              			</b>
            		</tr>';
            
	        $html.='<tr>
		                <td colspan="4"></td>
	            	</tr>';

	    $totalini5 = 0;
		$totalsb5  = 0;
   		while ($item = mysql_fetch_array($r5)){
			$totalini5 += $item['saldo_ini'];
			$totalsb5  += $item['saldo_sebelumnya'];

	        $html.='<tr>
		                <td>'.$item['kode_coa'].'</td>
		                <td style="text-align:left">'.$item['nama'].'</td>
		                <td style="text-align:right">'.number_format($item['saldo_ini']).'</td>
		                <td style="text-align:right">'.number_format($item['saldo_sebelumnya']).'</td>
	            	</tr>';
        }

        	$html.='<tr class="success">
               			<b> 
               				<td style="text-align:left" colspan="2">TOTAL BIAYA LAIN-LAIN:</td>
			                <td style="text-align:right">Rp '.number_format($totalini5).'</td>
			                <td style="text-align:right">Rp '.number_format($totalsb5).'</td>
              			</b>
            		</tr>';
            
	        $html.='<tr>
		                <td colspan="4"></td>
	            	</tr>';

	        $html.='<tr class="success">
               			<b> 
               				<td style="text-align:left" colspan="2">LABA BERSIH :</td>
			                <td style="text-align:right">Rp '.number_format(($totalini1+$totalini2)+($totalini3+$totalini4+$totalini5)).'</td> 
			                <td style="text-align:right">Rp '.number_format(($totalsb1+$totalsb2)+($totalsb3+$totalsb4+$totalsb5)).'</td>
              			</b>
            		</tr>';

	   	return $html;
    }	
?>