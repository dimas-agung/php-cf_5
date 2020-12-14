<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	date_default_timezone_set("Asia/Jakarta");
	
	
	#==================================================================================
	#							Neraca
	#==================================================================================
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "neracaAktiva" ){
		$kode_cabang 	= mres($_POST['kode_cabang']);
		$awal_bulan1 	= date('Y-m-d', mktime(0,0,0,$_POST['bulan'],1, $_POST['tahun']));
		$akhir_bulan1 	= date('Y-m-t', strtotime($awal_bulan1));
		$awal_bulan2 	= date('Y-m-d', strtotime($awal_bulan1.'- 1 month'));
		$akhir_bulan2 	= date('Y-m-t', strtotime($awal_bulan1.'- 1 month'));
		$bulan 			= date('F', strtotime($awal_bulan1));
		$tahun	 		= date("Y",strtotime($awal_bulan1));
		$page 			= (isset($_GET['page']))? $_GET['page'] : 1;
		$limit = 5; // Jumlah data per halamannya

		// Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database
		$limit_start = ($page - 1) * $limit;

		$query = "SELECT `c`.`kode_coa`, IFNULL(`c`.`level_coa`, NULL) AS `level_coa`, IFNULL(`c`.`nama`, NULL) AS `nama_coa`,	IFNULL(`saldo_awal_now`, 0) AS `saldo_ini`,	IFNULL(`saldo_awal_past`, 0) AS `saldo_sebelum` FROM `coa` AS `c`	LEFT JOIN (SELECT `kode_coa`, SUM(`debet` - `kredit`) AS `saldo_awal_now` FROM `jurnal` WHERE `tgl_buat` <= '".$akhir_bulan1."' AND `kode_cabang` = '".$kode_cabang."' GROUP BY `kode_coa`) AS `sa_now` ON `sa_now`.`kode_coa` = `c`.`kode_coa`	LEFT JOIN (SELECT `kode_coa`, SUM(`debet` - `kredit`) AS `saldo_awal_past` FROM `jurnal` WHERE `tgl_buat` <= '".$akhir_bulan2."' AND `kode_cabang` = '".$kode_cabang."' GROUP BY `kode_coa`) AS `sa_past` ON `sa_past`.`kode_coa` = `c`.`kode_coa` WHERE `c`.`level_coa` = '4' AND `c`.`kode_coa` LIKE '1.%' GROUP BY	`c`.`kode_coa`";
		
		/* echo $query;
		die(); */
		
		$result = mysql_query($query);
		$periode = "";
		
		if(mysql_num_rows($result)>0) {
			if($_POST['bulan'] != "" and $_POST['tahun'] != "") { 
				$periode = "".$bulan." - ".$tahun;
			}

			echo view_neracaAktiva($result, $periode, $awal_bulan1);
		} else {
			echo '<h2>Maaf!! Tidak ada data Neraca ditemukan.</h2>';
		}
    }

    function view_neracaAktiva($result, $periode, $awal_bulan1){

		$html = "";
		$html .= '<table id="example1" class="table table-striped table-hover" >
					<thead>
						<tr>
                            <th>Aktiva</th>
                            <th>'.date('t F Y',strtotime($awal_bulan1)).'</th>
                            <th>'.date('t F Y',strtotime($awal_bulan1.'- 1 month')).'</th>
						</tr>
					</thead>
					<tbody id="show-neraca-pecobaan">';
		
		$totaliniaktiva = 0;
		$totalsbaktiva = 0;	
		$saldo_ini = 0;
		$saldo_sebelum = 0;		
		if(mysql_num_rows($result) > 0) {
			while ($item = mysql_fetch_array($result)){
				
				$saldo_ini = $item['saldo_ini'];
				$saldo_sebelum = $item['saldo_sebelum'];
				$totaliniaktiva += $saldo_ini;
				$totalsbaktiva += $saldo_sebelum;

				$html .= '<tr>
							<td>' . $item['kode_coa'] . ' '.$item['nama_coa'].'</td>
							<td>'.number_format($saldo_ini, 2).'</td>
							<td>'.number_format($saldo_sebelum, 2).'</td>
						  </tr>';
			}

				$html.='<tr>
							<td>Grand Total</td>
			                <td>'.number_format($totaliniaktiva, 2).'</td>
			                <td>'.number_format($totalsbaktiva, 2).'</td>
						</tr>';
		} else { 
			$html = '<tr> <td colspan="10" class="text-center"> Tidak ada neraca. </td></tr>';
		}
		
		return $html;
    }
    
    if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "neracaEkuitas" ){
        $kode_cabang 	= $_POST['kode_cabang'];
		$awal_bulan1 	= date('Y-m-d', mktime(0,0,0,$_POST['bulan'],1, $_POST['tahun']));
		$akhir_bulan1 	= date('Y-m-d', mktime(0,0,0,$_POST['bulan']+1,0, $_POST['tahun']));
		$awal_bulan2 	= date('Y-m-d', mktime(0,0,0,$_POST['bulan']-1,1, $_POST['tahun']));
		$akhir_bulan2 	= date('Y-m-d', mktime(0,0,0,$_POST['bulan'],0, $_POST['tahun']));
		$bulan 			= date('F', strtotime($awal_bulan1));
		$tahun			= date("Y",strtotime($awal_bulan1));
		$page = (isset($_GET['page']))? $_GET['page'] : 1;
		$limit = 5; // Jumlah data per halamannya

		// Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database
		$limit_start = ($page - 1) * $limit;

		$query = "SELECT
	`c`.`kode_coa`,
	IFNULL(`c`.`level_coa`, NULL) AS `level_coa`,
	IFNULL(`c`.`nama`, NULL) AS `nama_coa`,
	IFNULL(`saldo_awal_now`, 0) AS `saldo_ini`,
	IFNULL(`saldo_awal_past`, 0) AS `saldo_sebelum`
FROM
	`coa` AS `c`
	LEFT JOIN (SELECT `kode_coa`, SUM(`kredit` - `debet`) AS `saldo_awal_now` FROM `jurnal` WHERE `tgl_buat` <= '".$akhir_bulan1."' AND `kode_cabang` = '".$kode_cabang."' GROUP BY `kode_coa`) AS `sa_now` ON `sa_now`.`kode_coa` = `c`.`kode_coa`
	LEFT JOIN (SELECT `kode_coa`, SUM(`kredit` - `debet`) AS `saldo_awal_past` FROM `jurnal` WHERE `tgl_buat` <= '".$akhir_bulan2."' AND `kode_cabang` = '".$kode_cabang."' GROUP BY `kode_coa`) AS `sa_past` ON `sa_past`.`kode_coa` = `c`.`kode_coa`
WHERE
	`c`.`level_coa` = '4' 
	AND (`c`.`kode_coa` LIKE '2.%' OR `c`.`kode_coa` LIKE '3.%') 
	AND `c`.`kode_coa` NOT IN ('3.01.03.01', '3.01.03.02') 
GROUP BY
	`c`.`kode_coa` UNION
SELECT
	'3.01.03.01' AS `kode_coa`,
	'4' AS `level_coa`,
	'Laba periode lalu' AS `nama_coa`,
	SUM(`saldo_ini`) AS `saldo_ini`,
	SUM(`saldo_sebelum`) AS `saldo_sebelum` 
FROM
	(
	SELECT
		`c`.`kode_coa`,
		IFNULL(`c`.`level_coa`, NULL) AS `level_coa`,
		IFNULL(`c`.`nama`, NULL) AS `nama_coa`,
		IFNULL(`saldo_awal_now`, 0) AS `saldo_ini`,
		IFNULL(`saldo_awal_past`, 0 ) AS `saldo_sebelum`
	FROM
		`coa` AS `c`
		LEFT JOIN (SELECT `kode_coa`, SUM(`kredit` - `debet`) AS `saldo_awal_now` FROM `jurnal` WHERE `tgl_buat` < '".$awal_bulan1."' AND `kode_cabang` = '".$kode_cabang."' GROUP BY `kode_coa`) AS `sa_now` ON `sa_now`.`kode_coa` = `c`.`kode_coa`
		LEFT JOIN (SELECT `kode_coa`, SUM(`kredit` - `debet`) AS `saldo_awal_past` FROM `jurnal` WHERE `tgl_buat` < '".$awal_bulan2."' AND `kode_cabang` = '".$kode_cabang."' GROUP BY `kode_coa`) AS `sa_past` ON `sa_past`.`kode_coa` = `c`.`kode_coa` 
	WHERE
		`c`.`level_coa` = '4' 
		AND (
			`c`.`kode_coa` LIKE '4.%' 
			OR `c`.`kode_coa` LIKE '5.%' 
			OR `c`.`kode_coa` LIKE '6.%' 
			OR `c`.`kode_coa` LIKE '7.%' 
			OR `c`.`kode_coa` LIKE '8.%' 
		) 
	GROUP BY
		`c`.`kode_coa` 
	) AS `tbl_lb_ditahan` UNION
SELECT
	'3.01.03.02' AS `kode_coa`,
	'4' AS `level_coa`,
	'Laba (rugi) periode berjalan' AS `nama_coa`,
	SUM(`saldo_ini`) AS `saldo_ini`,
	SUM(`saldo_sebelum`) AS `saldo_sebelum`
FROM
	(
	SELECT
		`c`.`kode_coa`,
		IFNULL(`c`.`level_coa`, NULL) AS `level_coa`,
		IFNULL(`c`.`nama`, NULL) AS `nama_coa`,
		IFNULL(`saldo_awal_now`, 0 ) AS `saldo_ini`,
		IFNULL(`saldo_awal_past`, 0 ) AS `saldo_sebelum`
	FROM
		`coa` AS `c`
		LEFT JOIN (SELECT `kode_coa`, SUM(`kredit` - `debet`) AS `saldo_awal_now` FROM `jurnal` WHERE `tgl_buat` BETWEEN '".$awal_bulan1."' AND '".$akhir_bulan1."' AND `kode_cabang` = '".$kode_cabang."' GROUP BY `kode_coa`) AS `sa_now` ON `sa_now`.`kode_coa` = `c`.`kode_coa`
		LEFT JOIN (SELECT `kode_coa`, SUM(`kredit` - `debet`) AS `saldo_awal_past` FROM `jurnal` WHERE `tgl_buat` BETWEEN '".$awal_bulan2."' AND '".$akhir_bulan2."' AND `kode_cabang` = '".$kode_cabang."' GROUP BY `kode_coa`) AS `sa_past` ON `sa_past`.`kode_coa` = `c`.`kode_coa` 
	WHERE
		`c`.`level_coa` = '4' 
		AND (
			`c`.`kode_coa` LIKE '4.%' 
			OR `c`.`kode_coa` LIKE '5.%' 
			OR `c`.`kode_coa` LIKE '6.%' 
			OR `c`.`kode_coa` LIKE '7.%' 
			OR `c`.`kode_coa` LIKE '8.%' 
		) 
	GROUP BY
	`c`.`kode_coa`
	) AS `tbl_lb_berjalan`";
	
		/* echo $query;
		die(); */
		
		$result = mysql_query($query);
		$periode = "";
		
		if(mysql_num_rows($result)>0) {
			if($_POST['bulan'] != "" and $_POST['tahun'] != "") { $periode = "".tgl_indo($_POST['bulan'])." - ".tgl_indo($_POST['tahun']);}

			echo view_neracaEkuitas($result, $periode, $awal_bulan1);
		} else {
			echo '<h2>Maaf!! Tidak ada data Neraca ditemukan.</h2>';
		}
    }

    function view_neracaEkuitas($result, $periode, $awal_bulan1){

		$html = "";
		$html .= '<table id="example1" class="table table-striped table-hover" >
					<thead>
						<tr>
                            <th>Ekuitas</th>
                            <th>'.date('t F Y',strtotime($awal_bulan1)).'</th>
                            <th>'.date('t F Y',strtotime($awal_bulan1.'- 1 month')).'</th>
						</tr>
					</thead>
					<tbody id="show-neraca-pecobaan">';

		$totalinikjb = 0;
		$totalsbkjb = 0;
		$saldo_ini =0;
		$saldo_sebelum = 0;			
		if(mysql_num_rows($result) > 0) {
			while ($item = mysql_fetch_array($result)){

				$saldo_ini = $item['saldo_ini'];
				$saldo_sebelum = $item['saldo_sebelum'];
				$totalinikjb += $saldo_ini;
				$totalsbkjb += $saldo_sebelum;

				$html .= '<tr>
							<td>' . $item['kode_coa'] . ' '.$item['nama_coa'].'</td>
							<td>'.number_format($saldo_ini, 2).'</td>
							<td>'.number_format($saldo_sebelum, 2).'</td>
						</tr>';
			}
			$html.='<tr>
						<td>Grand Total</td>
		                <td>'.number_format($totalinikjb, 2).'</td>
		                <td>'.number_format($totalsbkjb, 2).'</td>
					</tr>';
		} else { 
			$html = '<tr> <td colspan="10" class="text-center"> Tidak ada neraca. </td></tr>';
		}
		
		return $html;
    }
    	
?>