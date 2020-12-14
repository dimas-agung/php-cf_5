<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	date_default_timezone_set("Asia/Jakarta");
	
	
	#==================================================================================
	#							Neraca Percobaan 
	#==================================================================================
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "nrc_prb" ){
        $kode_cabang 	= $_POST['kode_cabang'];
		$tgl_awal	= date("Y-m-d",strtotime($_POST['tgl_awal']));
		$tgl_akhir	= date("Y-m-d",strtotime($_POST['tgl_akhir']));

		$query  = "SELECT * FROM (SELECT `j`.`kode_coa`, IFNULL(`c`.`level_coa`, '') AS `level_coa`, IFNULL(`c`.`nama`, '') AS `nama`, SUM(`debet`) AS `debet`, SUM(`kredit`) AS `kredit`, IFNULL(`saldo_awal`, 0) AS `saldo_awal` FROM `jurnal` AS `j` LEFT JOIN (SELECT `kode_coa`, SUM(`debet` - `kredit`) AS `saldo_awal` FROM `jurnal` WHERE `kode_cabang` = '".$kode_cabang."' AND `tgl_buat` < '".$tgl_awal."' GROUP BY `kode_coa`) AS `sa` ON `sa`.`kode_coa` = `j`.`kode_coa` LEFT JOIN `coa` AS `c` ON `c`.`kode_coa` = `j`.`kode_coa` WHERE `kode_cabang` = '".$kode_cabang."' AND `tgl_buat` BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."' GROUP BY `j`.`kode_coa` UNION SELECT `c`.`kode_coa`, IFNULL(`c`.`level_coa`, '') AS `level_coa`, IFNULL(`c`.`nama`, '') AS `nama`, '0' AS `debet`, '0' AS `kredit`, IFNULL(`saldo_awal`, 0) AS `saldo_awal` FROM `coa` AS `c` LEFT JOIN (SELECT `kode_coa`, SUM(`debet` - `kredit`) AS `saldo_awal` FROM `jurnal` WHERE `tgl_buat` < '".$tgl_awal."' AND `kode_cabang` = '".$kode_cabang."' GROUP BY `kode_coa`) AS `sa` ON `sa`.`kode_coa` = `c`.`kode_coa` WHERE `c`.`level_coa` = '4' AND `c`.`kode_coa` NOT IN (SELECT `kode_coa` FROM `jurnal` WHERE `tgl_buat` BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."' GROUP BY `kode_coa`) GROUP BY `c`.`kode_coa`) AS `tbl` WHERE `kode_coa` <> '' ORDER BY `kode_coa` ASC";

		$result  = mysql_query($query);
		$periode = "";
		
		if(mysql_num_rows($result)>0) {
			if($_POST['tgl_awal'] != "" AND $_POST['tgl_akhir'] != "") { $periode = "Periode : ".tgl_indo($_POST['tgl_awal'])." - ".tgl_indo($_POST['tgl_akhir']);}

			echo view_neraca_prb($result, $periode);
		} else {
			echo '<h2>Maaf!! Tidak ada data Neraca ditemukan.</h2>';
		}
    }

    function view_neraca_prb($result, $periode){

		$ttlSaldoAwal 	=0;
		$ttlDebet 		=0;
		$ttlKredit 		=0;
		$ttlSaldoAkhir 	=0;

		$html = "";
		$html .= '<h3 style="text-align:center"><br /> Neraca Percobaan <br /> '.$periode.' <br />						 
                      </h3>';
		$html .= '<table id="example1" class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
                            <th>Kode Coa</th>
                            <th>Nama Coa</th>
                            <th>Saldo Awal</th>
                            <th>Debet</th>
                            <th>Kredit</th>
                            <th>Saldo Akhir</th>
						</tr>
					</thead>
					<tbody id="show-neraca-pecobaan">';
		if(mysql_num_rows($result) > 0) {
			while ($item = mysql_fetch_array($result)){
				$html .= '<tr>
						    <td>'.$item['kode_coa'].'</td>
							<td>'.$item['nama'].'</td>
							<td style="text-align: right">'.number_format($item['saldo_awal'], 2).'</td>
							<td style="text-align: right">'.number_format($item['debet'], 2).'</td>
		                    <td style="text-align: right">'.number_format($item['kredit'], 2).'</td>	
		                    <td style="text-align: right">'.number_format((($item['saldo_awal'] + $item['debet']) - $item['kredit']), 2).'</td>
						  </tr>';

				$ttlSaldoAwal 	+= $item['saldo_awal'];
				$ttlDebet 	  	+= $item['debet'];
				$ttlKredit 		+= $item['kredit'];
				$ttlSaldoAkhir 	+= ($item['saldo_awal'] + $item['debet']) - $item['kredit'];
			}

				$html.='<tr>
							<td></td>
							<td></td>
							<td style="text-align: right">Rp '.number_format($ttlSaldoAwal, 2).'</td>
							<td style="text-align: right">Rp '.number_format($ttlDebet, 2).'</td>
							<td style="text-align: right">Rp '.number_format($ttlKredit, 2).'</td>
							<td style="text-align: right">Rp '.number_format($ttlSaldoAkhir, 2).'</td>
						</tr>';
		} else { 
			$html = '<tr> <td colspan="10" class="text-center"> Tidak ada neraca. </td></tr>';
		}
		
		return $html;
	}
    	
?>