<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	require('../pages/data/script/bts.php'); 
	date_default_timezone_set("Asia/Jakarta");
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loadops")
	{
		$kode_cabang = $_POST['kode_cabang'];
		
		$q_ops = mysql_query("SELECT oph.kode_ops,oph.kode_supplier,supp.nama nama_supplier 
								FROM ops_hdr oph 
								INNER JOIN ops_dtl opd ON opd.kode_ops=oph.kode_ops
								INNER JOIN supplier supp ON supp.kode_supplier=oph.kode_supplier 
								WHERE kode_cabang='".$kode_cabang."' AND opd.status_dtl='0' GROUP BY oph.kode_ops ORDER BY id_ops_hdr DESC");	
		
		$num_rows = mysql_num_rows($q_ops);
		if($num_rows>0)
		{		
			echo '<select id="no_ops" name="no_ops" class="select2">
					<option value="0">-- Pilih No OPS --</option>';
					 	
                	while($rowops = mysql_fetch_array($q_ops)){
                    
         	echo '<option value="'.$rowops['kode_ops'].'" data-kode-supplier="'.$rowops['kode_supplier'].'" data-supplier="'.$rowops['kode_supplier'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowops['nama_supplier'].'" >'.$rowops['kode_ops'].'</option>';
		 
	 				}
  
         	echo '</select>';
		}else{
			echo '<select id="no_ops" name="no_ops" class="select2" disabled>
                  	<option value="0">-- Tidak Ada OPS--</option>
                  </select>';	
		}
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loaditem" )
	{
		$kode_ops 	= $_POST['kode_ops'];
		$grandtotal = 0;
		$total 		= 0;
		
		$q_dtl = mysql_query("SELECT opd.kode_kat_aset, opd.qty qty_ops, IFNULL(SUM(tbd.qty),0) qty_bts, opd.harga, opd.diskon, opd.ppn, coa_debet, coa_kredit, opd.divisi, opd.keterangan_dtl keterangan_ops FROM ops_dtl opd 
								LEFT JOIN bts_hdr tbh ON tbh.kode_ops = opd.kode_ops 
								LEFT JOIN bts_dtl tbd ON tbd.kode_kat_aset = opd.kode_kat_aset AND tbh.kode_bts = tbd.kode_bts
								LEFT JOIN kategori_aset ka ON ka.kode_kat_aset = SUBSTRING_INDEX(opd.kode_kat_aset, ':', 1)
								WHERE opd.kode_ops='".$kode_ops."' AND opd.status_dtl='0' 
								GROUP BY opd.kode_kat_Aset 
								ORDER BY opd.kode_kat_Aset ASC");	
		
		$num_rows 	= mysql_num_rows($q_dtl);
		if($num_rows>0)
		{		
			$no 			= 1;
			$qty  			= 0;
			$qty_maksimum 	= 0;
			$qty_maks 		= 0;			 	
			while($rowdtl = mysql_fetch_array($q_dtl)){
				
				$qty 		  = (int)($rowdtl['qty_ops']-$rowdtl['qty_bts']);
				$qty_maksimum = (int)$qty*0.1;
				$qty_maks 	  = ceil($qty_maksimum+($qty));

				$kat_aset = $rowdtl['kode_kat_aset'];
				$pisah = explode(":", $kat_aset);
				$kd_kat_aset = $pisah[0];
				$nm_kat_aset = $pisah[1];

				$kd_divisi 	 = '';
				$nm_divisi 	 = '';
				$divisi 	 = '';
				$divisi1 = $rowdtl['divisi'];
					if(!empty($divisi1)) {
					$pisah=explode(":",$divisi1);
					$kd_divisi=$pisah[0];
					$nm_divisi=$pisah[1];
					}
				
				if($kd_divisi != null) {
					$divisi = $kd_divisi.'&nbsp;&nbsp; || &nbsp;&nbsp;'.$nm_divisi;
				}else{
					$divisi = '-';
				}
				
				echo '<tr>
							<td style="text-align: center">'.$no++.'</td>
							<td>'.$kd_kat_aset.' 
								<input class="form-control" type="hidden" name="kode_kat_aset[]" id="kode_kat_aset[]" value="'.$rowdtl['kode_kat_aset'].'"/>
								<input class="form-control" type="hidden" name="tb_debet[]" id="tb_debet[]" value="'.$rowdtl['coa_debet'].'"/>
								<input class="form-control" type="hidden" name="tb_kredit[]" id="tb_kredit[]" value="'.$rowdtl['coa_kredit'].'"/>
							</td>
							<td>'.$nm_kat_aset.' </td>
							<td style="text-align: left">'.number_format($qty).' 
								<input class="form-control" type="hidden" name="qty_ops[]" id="qty_ops[]"  value="'.$qty.'"/>
							</td>
							<td><input class="form-control" type="number" name="q_diterima[]" id="q_diterima[]" autocomplete="off" value="'.$qty.'"/> 
								<input class="form-control" type="hidden" name="harga[]" id="harga[]"  value="'.$rowdtl['harga'].'"/> 
								<input class="form-control" type="hidden" name="diskon[]" id="diskon[]"  value="'.$rowdtl['diskon'].'"/> 
								<input class="form-control" type="hidden" name="ppn[]" id="ppn[]"  value="'.$rowdtl['ppn'].'"/> 
								<input class="form-control" type="hidden" name="qty_max[]" id="qty_max[]"  value="'.$qty_maks.'"  />
							</td>
							<td>'.$divisi.'
								<input class="form-control" type="hidden" name="divisi[]" id="divisi[]" value='.$divisi.'>
							</td>
							<td><input class="form-control" name="keterangan_dtl[]" id="keterangan_dtl[]" placeholder="Keterangan..." value='.$rowdtl['keterangan_ops'].'></input></td>
					</tr>';

			}

				echo '<tr>
							<input type="hidden" value="0" name="grand_total" id="grand_total" />
					  </tr>';
			
		}else{

			echo '<tr><td colspan="6" class="text-center">Belum ada item</td></tr>';

		}
		 				 
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save" )
	{
		// Set autocommit to off
		mysqli_autocommit($con,FALSE);

		$form 				=	'BTS';
		$thnblntgl 			=	date("ymd",strtotime($_POST['tanggal']));
		
		$ref 				=	($_POST['ref']);
		$kode_cabang 		=	($_POST['kode_cabang']);
		$keterangan_hdr 	=	($_POST['keterangan']);
		$tgl_buat 			=	date("Y-m-d",strtotime($_POST['tanggal']));
		
		$kode_ops 			=	($_POST['no_ops']);
		$kode_supplier 		=	($_POST['kode_supplier']);
		
		$user_pencipta  	= 	$_SESSION['app_id'];
		$tgl_input 			= 	date("Y-m-d H:i:s");
		
		$kode_bts 			=	buat_kode_bts($thnblntgl,$form,$kode_cabang);
		
		//DETAIL BTS
		$subtot 			= 0;
		$nilai_total_asli 	= 0;
		$nilai_ppn			= 0;
		$subtotal			= 0;
		$total_ppn			= 0;
		$total_harga		= 0;

		$tb_debet		= $_POST['tb_debet'];
		$tb_kredit		= $_POST['tb_kredit'];

		$no_bts			= $kode_bts;
		$kode_kat_aset	= $_POST['kode_kat_aset'];
		$qty_ops		= $_POST['qty_ops'];
		$qty			= $_POST['q_diterima'];
		$harga			= $_POST['harga']; 
		$diskon			= $_POST['diskon'];
		$ppn			= $_POST['ppn'];
		$divisi			= $_POST['divisi'];
		$keterangan_dtl	= $_POST['keterangan_dtl'];
		$count 			= count($kode_kat_aset);



		$mySql1   	= "INSERT INTO bts_dtl (kode_bts,kode_kat_aset,qty_ops,qty,harga,diskon,ppn,subtot,divisi,keterangan_dtl) VALUES ";
		 
			for( $i=0; $i < $count; $i++ )
			{
				$nilai_total_asli = ($qty[$i]*($harga[$i]-$diskon[$i]));

				if($qty_ops[$i] < $qty[$i]){
					echo "99||QTY Diterima melebihi QTY OPS !!";
						return false;
				}		

				if($ppn[$i]=='1'){
					$nilai_ppn = ($qty[$i]*($harga[$i]-$diskon[$i])) * 0.1;
				}else{
					$nilai_ppn = 0;
				}
				
				$subtot =  $nilai_total_asli + $nilai_ppn;
				
				$pisah = explode(":",$kode_kat_aset[$i]);
				$code_barang=$pisah[0];
				
				$mySql1 .= "('{$no_bts}','{$kode_kat_aset[$i]}','{$qty_ops[$i]}','{$qty[$i]}','{$harga[$i]}','{$diskon[$i]}','{$ppn[$i]}','{$subtot}','{$divisi[$i]}','{$keterangan_dtl[$i]}')";
				$mySql1 .= ",";
				
				$total_harga += $nilai_total_asli;	
				$total_ppn +=  $nilai_ppn;
				$subtotal += $subtot;

				if($qty[$i]>=$qty_ops[$i]){
					$mySql2 = " UPDATE ops_dtl SET status_dtl='3' WHERE kode_ops='".$kode_ops."' AND kode_kat_aset= '{$kode_kat_aset[$i]}' ";
				}else{
					$mySql2 = " UPDATE ops_dtl SET status_dtl='0' WHERE kode_ops='".$kode_ops."' AND kode_kat_aset= '{$kode_kat_aset[$i]}'; ";
				}
				// die($mySql2);
				$query2 = mysqli_query ($con,$mySql2) ;
				

				//INSERT JURNAL DEBET
				$mySql3	= "INSERT INTO jurnal SET 
							kode_transaksi			='".$kode_bts."',
							tgl_buat				='".$tgl_buat."',
							tgl_input				='".$tgl_input."',
							kode_cabang				='".$kode_cabang."',
							kode_supplier			='".$kode_supplier."',
							keterangan_hdr			='".$keterangan_hdr."',
							ref						='".$ref."',
							kode_coa				='{$tb_debet[$i]}',
							debet					='".$nilai_total_asli."',
							user_pencipta			='".$user_pencipta."';
						";								
				$query3 = mysqli_query ($con,$mySql3) ;	
				
				//INSERT JURNAL KREDIT
				$mySql4	= "INSERT INTO jurnal SET 
							kode_transaksi			='".$kode_bts."',
							tgl_buat				='".$tgl_buat."',
							tgl_input				='".$tgl_input."',
							kode_cabang				='".$kode_cabang."',
							kode_supplier			='".$kode_supplier."',
							keterangan_hdr			='".$keterangan_hdr."',
							ref						='".$ref."',
							kode_coa				='{$tb_kredit[$i]}',
							kredit					='".$nilai_total_asli."',
							user_pencipta			='".$user_pencipta."';
						";							
				$query4 = mysqli_query ($con,$mySql4) ;
					
				}
				
			
		 
		$mySql1 = rtrim($mySql1,",");
		// die($mySql1);
		$query1 = mysqli_query ($con,$mySql1) ;
		
		//HEADER bts
		$mySql	= "INSERT INTO bts_hdr SET 
						kode_bts				='".$kode_bts."',
						ref						='".$ref."',
						kode_cabang				='".$kode_cabang."',
						keterangan_hdr			='".$keterangan_hdr."',
						tgl_buat				='".$tgl_buat."',
						kode_ops				='".$kode_ops."',
						kode_supplier			='".$kode_supplier."',
						user_pencipta			='".$user_pencipta."',
						tgl_input				='".$tgl_input."',
						total_harga				='".$total_harga."',
						total_ppn				='".$total_ppn."',
						subtotal				='".$subtotal."';
					";	
						
		$query = mysqli_query ($con,$mySql) ;
		
		if ($query AND $query1 AND $query2 AND $query3 AND $query4) {
			
			// Commit transaction
			mysqli_commit($con);
			
			// Close connection
			mysqli_close($con);
			
			echo "00||".$kode_bts;
			unset($_SESSION['data_bts']);
			//unset($_SESSION['data_op'.$id_form .'']);
			//echo "00|| $mySql";
			
		} else { 
			
			echo "Gagal query: ".mysqli_error();
		}		 	
				
					 
	}

?>