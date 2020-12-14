<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	require('../pages/data/script/ops.php'); 
	date_default_timezone_set("Asia/Jakarta");

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loadppn" )
	{
		$kode_supplier = $_POST['kode_supplier'];
		
		$q_ppn = mysql_query("SELECT Ppn FROM supplier WHERE kode_supplier='".$kode_supplier."'");	
		
		$num_rows = mysql_num_rows($q_ppn);
		if($num_rows>0)
		{		
			$rowppn = mysql_fetch_array($q_ppn);
			if($rowppn['Ppn']=='1'){
				echo '<input class="form-control" type="checkbox" name="ppn" id="ppn" checked><input class="form-control" type="hidden" name="stat_ppn" id="stat_ppn" value="1">';	
			}else{
				echo '<input class="form-control" type="checkbox" name="ppn" id="ppn"><input class="form-control" type="hidden" name="stat_ppn" id="stat_ppn" value="0">';	
			}
		}
	}		

	if (isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "add" )
	{

		if(isset($_POST['kode_kat_aset']) and @$_POST['kode_kat_aset'] != ""){

			$id_form		= $_POST['id_form'];
			$itemops 		= "INSERT INTO ops_dtl_tmp SET 
											kode_kat_aset		='".$_POST['kode_kat_aset']."',
											tgl_kirim		='".date("Y-m-d",strtotime($_POST['tgl_kirim']))."',
											qty				='".$_POST['qty']."',
											harga			='".$_POST['harga']."',
											diskon			='".$_POST['diskon']."',
											ppn				='".$_POST['ppn']."',
											subtot			='".$_POST['subtot']."',
											divisi			='".$_POST['divisi']."',
											keterangan_dtl	='".$_POST['keterangan_dtl']."',
											id_form			='".$id_form."' ";
			mysql_query($itemops);
			
			$query			= "SELECT * FROM ops_dtl_tmp WHERE id_form='".$id_form."'";
			$result			= mysql_query($query);
			
			$array = array();
			if(mysql_num_rows($result) > 0) {
				while ($res = mysql_fetch_array($result)) {
					
					if(!isset($_SESSION['data_ops'])) {
						$array[$res['id_ops_dtl']] = array("id" => $res['id_ops_dtl'],"kode_kat_aset" => $res['kode_kat_aset'], "tgl_kirim" => $res['tgl_kirim'],"qty" => $res['qty'],"harga" => $res['harga'],"diskon" => $res['diskon'],"ppn" => $res['ppn'],"subtot" => $res['subtot'],"divisi" => $res['divisi'],"keterangan_dtl" => $res['keterangan_dtl'], "id_form" => $res['id_form']);
					} else {
						$array = $_SESSION['data_ops'];
							$array[$res['id_ops_dtl']] = array("id" => $res['id_ops_dtl'],"kode_kat_aset" => $res['kode_kat_aset'], "tgl_kirim" => $res['tgl_kirim'],"qty" => $res['qty'],"harga" => $res['harga'],"diskon" => $res['diskon'],"ppn" => $res['ppn'],"subtot" => $res['subtot'],"divisi" => $res['divisi'],"keterangan_dtl" => $res['keterangan_dtl'], "id_form" => $res['id_form']);
					}
				   
				}
			} 
				$_SESSION['data_ops'] = $array;
				echo view_item_ops($array);

			 
		}
		
	}
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loadhistory" )
	{
		$kd_aset = ''; 
		
		$kode_kat_aset = $_POST['kode_kat_aset'];
		if(!empty($kode_kat_aset))
		{
		$pisah=explode(":",$kode_kat_aset);
		$kd_aset=$pisah[0];
		$nm_aset=$pisah[1];
		}
		
		$q_his = mysql_query("SELECT ops.kode_kat_aset,kode_ops,qty,harga,diskon FROM ops_dtl ops 
								LEFT JOIN inventori inv ON inv.kode_inventori=SUBSTRING_INDEX(ops.kode_kat_aset, ':', 1) 
								WHERE SUBSTRING_INDEX(ops.kode_kat_aset, ':', 1) = '".$kd_aset."'
								GROUP BY kode_ops
								ORDER BY id_ops_dtl ");	
		$num_rows = mysql_num_rows($q_his);
		if($num_rows>0)
		{
			echo '<h5><b><center><u>'.$kode_kat_aset.'</u></center></b></h5>';		
			echo '<center><a href="#" class="btn-export-csv fa fa-download">Download CSV</a></center>';
			echo '<table class="table table-striped table-bordered table-hover table-export-csv" width="100%" >
								<thead>
									<tr>
                                        <th width="5%">No</th>
										<th>Kode OPS</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
										<th>Diskon</th>
									</tr>
								</thead>
								<tbody>';
					 	
                	$no=1;
					while($rowhis = mysql_fetch_array($q_his)){
                    
         	echo '<tr>
						<td style="text-align:center">'.$no++.'</td>
						<td>'.$rowhis['kode_ops'].'</td>
						<td style="text-align:right">'.number_format($rowhis['qty']).'</td>
						<td style="text-align:right">'.number_format($rowhis['harga']).'</td>
						<td style="text-align:right">'.number_format($rowhis['diskon']).'</td>
				</tr>';
		 
	 				}
  
         	echo '</tbody></table>';
		}else{
			echo '<b style="color:#F00">Belum ada history aset</b>';	
		}
		
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "hapus-ops" )
	{
		$id = $_POST['idhapus'];
		$id_form = $_POST['id_form'];
		$itemdelete = "DELETE FROM ops_dtl_tmp WHERE id_ops_dtl = '".$id."'";
		mysql_query($itemdelete);
		unset($_SESSION['data_ops'][$id]);
		echo view_item_ops($_SESSION['data_ops']);
	}
	
	function view_item_ops($data) {
		$n = 1;
		$dpp 		= 0;
		$diskon = 0;
		$total_ppn 		= 0;
		$subtot_asli	= 0;
		$subtot_ppn 	= 0;
		$grandtotal 	= 0;
		$html = "";
		if(count($data) > 0) {
			foreach($data as $key=>$item){
				if($item['ppn']=='1'){
					$stat_ppn = '<span class="glyphicon glyphicon-check"> </span>';	
				}else{
					$stat_ppn = '<span class="glyphicon glyphicon-unchecked"> </span>';	
				}

				$kd_kat_aset 	 = '';
				$nm_kat_aset 	 = '';
				$kode_kat_aset = $item['kode_kat_aset'];
					if(!empty($kode_kat_aset)) {
					$pisah=explode(":",$kode_kat_aset);
					$kd_kat_aset=$pisah[0];
					$nm_kat_aset=$pisah[1];
					}

				$kd_divisi 	 = '';
				$nm_divisi 	 = '';
				$divisi = $item['divisi'];
					if(!empty($divisi)) {
					$pisah=explode(":",$divisi);
					$kd_divisi=$pisah[0];
					$nm_divisi=$pisah[1];
					}

				$html .= '<tr>
							<td style="text-align:center; width: 10px;">'.$n++.'</td>
							<td>'.$kd_kat_aset.'&nbsp;&nbsp; || &nbsp;&nbsp;'.$nm_kat_aset.'
								<input class="form-control" type="hidden" name="kode_kat_aset" id="kode_kat_aset" value='.$item['kode_kat_aset'].'/>
							</td>
							<td style="text-align:center;">'.$item['tgl_kirim'].'</td>
							<td style="text-align:right;">'.number_format($item['qty']).'</td>
							<td style="text-align:right;">'.number_format($item['harga']).'</td>		
							<td style="text-align:right;">'.number_format($item['diskon']).'</td>	
							<td style="text-align:center">'.$stat_ppn.'</td>
							<td style="text-align:right">'.number_format($item['subtot']).'</td>
							<td >'.$kd_divisi.'&nbsp;&nbsp; || &nbsp;&nbsp;'.$nm_divisi.'
								<input class="form-control" type="hidden" name="divisi" id="divisi" value='.$item['divisi'].'/>
							</td>
							<td>'.$item['keterangan_dtl'].'</td>
							<td style="text-align:center">
								<a href="javascript:;" class="label label-danger hapus-ops" title="hapus data" data-id="'.$key.'"><i class="fa fa-times"></i>
								</a>           			
							</td>
						</tr>						
						';
						
						$diskon += $item['harga']*($item['diskon']/100);
						
						$dpp += $item['qty']*($item['harga']-$diskon);

						if($item['ppn']=='1'){
							$subtot_ppn = $dpp*0.1;
						}else{
							$subtot_ppn = 0;
						}
						
						$total_ppn 		+= $subtot_ppn;
						$grandtotal	    += $item['subtot'];
				
			}

				$html .= '<tr>
								<td colspan="7" style="text-align:right"><b>DPP :</b></td>
								<td style="text-align:right"><b>'.number_format($dpp).'</b> <input class="form-control" type="hidden" name="total_harga" id="total_harga" autocomplete="off" value="'.$dpp.'" readonly style="width: 7em"  /></td>
								<td align="right" colspan="3"></td>
							</tr>
							<tr>
								<td style="text-align:right" colspan="7"><b>PPn :</b></td>
								<td style="text-align:right"><b>'.number_format($total_ppn).'</b> <input class="form-control" type="hidden" name="total_ppn" id="total_ppn" autocomplete="off" value="'.$total_ppn.'" readonly style="width: 7em"  /></td>
								<td align="right" colspan="3"></td>
							</tr>
							<tr>
								<td style="text-align:right" colspan="7"><b>Grand Total :</b></td>
								<td style="text-align:right"><b>'.number_format($grandtotal).'</b> <input class="form-control" type="hidden" name="grandtotal" id="grandtotal" autocomplete="off" value="'.$grandtotal.'" readonly style="width: 7em"  /></td>
								<td align="right" colspan="3"></td>
							</tr>
					  ';
			
			$html .= "<script>$('.hapus-ops').click(function(){
						var id =	$(this).attr('data-id'); 
						var id_form = $('#id_form').val();
						$.ajax({
							type: 'POST',
							url: '".base_url()."ajax/j_ops.php?func=hapus-ops',
							data: 'idhapus=' + id + '&id_form=' +id_form,
							cache: false,
							success:function(data){
								$('#detail_input_ops').html(data).show();
							 }
						  });
					  });
				     </script>";
				
		} else {
			$html .= '<tr> <td colspan="11" class="text-center"> Tidak ada data. </td></tr>';
		}
		  
		return $html;
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "addum" )
	{
		if(isset($_POST['um']) and (@$_POST['um'] != "" )){
		$um = $_POST['um'];
		$nominal = $_POST['nominal'];	
		$id_um = $_POST['id_um'];
		
		$array = array();
		if(!isset($_SESSION['data_um'])) {
						$array[$id_um] = array("id_um" => $id_um,"um" => $um, "nominal" => $nominal);
		} else {
						$array = $_SESSION['data_um'];
							$array[$id_um] = array("id_um" => $id_um,"um" => $um, "nominal" => $nominal);
		}
		
		$_SESSION['data_um'] = $array;
		echo view_item_um($array);
		
		}
	}
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "hapus-um" )
	{
		$id = $_POST['idhapus'];
		unset($_SESSION['data_um'][$id]);
		echo view_item_um($_SESSION['data_um']);
	}
	
	function view_item_um($data) {
		$n = 1;
		$html = "";
		$grandtotal = 0;
		$total= 0;
		if(count($data) > 0) {
			foreach($data as $key=>$item){
				
				$total += ($item['um']);
				$html .= '<div class="row">';
				$html .= '<div class="container">';
				$html .= '&nbsp;';
				$html .= '</div>';
				$html .= '</div>';
				$html .= '<div class="row">';
				$html .= '<div class="container">';
				$html .= '<label class="col-lg-2 control-label" style="text-align:left"></label>';
				
				$html .= '<div class="col-lg-3 col-md-3 col-xs-4">
						<input type="text" readonly name="um1[]" data-id="um1" data-group="'.$item['id_um'].'" class="form-control" placeholder="Uang Muka %" value="'.$item['um'].'%">
					</div>
					
					<div class="col-lg-3 col-md-3 col-xs-4">
						 <input type="text" readonly name="nominal[]" data-id="nominal1" data-group="'.$item['id_um'].'" class="form-control" placeholder="0" value="'.$item['nominal'].'" >	
					</div>
					
					<button class="btn btn-danger remove hapus-um col-lg-2 col-md-2 col-xs-" type="button" data-id="'.$key.'"><i class="glyphicon glyphicon-remove"></i> Hapus.</button>';
				$html .= '</div>';
				$html .= '</div>';
				
			}
			$html .= "<script>$('.hapus-um').click(function(){
						var id =	$(this).attr('data-id');
						$.ajax({
							type: 'POST',
							url: '".base_url()."ajax/j_ops.php?func=hapus-um',
							data: 'idhapus=' + id ,
							cache: false,
							success:function(data){
								var html = $('.copy').html(data);
									$('.after-add-more').after(html);
									
									$('body').on('click','.remove',function(){ 
									  $(this).parents('.control-group').remove();
									});
									
									$('#um').focus();
							 }
						  });
					  });
				     </script>";
		}
		return $html;
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save" )
	{
		$form 			='OPS';
		$thnblntgl 		=date("ymd",strtotime($_POST['tanggal']));
		
		$ref			=($_POST['ref']);
		$kode_cabang	=($_POST['kode_cabang']);
		$kode_supplier	=($_POST['kode_supplier']);
		$top			=($_POST['top']);
		$tgl_buat 		=date("Y-m-d",strtotime($_POST['tanggal']));
		$keterangan_hdr	=($_POST['keterangan_hdr']);
		$total_harga	=($_POST['total_harga']);
		$total_ppn		=($_POST['total_ppn']);
		$subtotal		=($_POST['grandtotal']);
		
		$user_pencipta  = $_SESSION['app_id'];
		$tgl_input 		= date("Y-m-d H:i:s");
		
		
		$kode_ops = buat_kode_ops($thnblntgl,$form,$kode_cabang);
		
		//HEADER OP
		$mySql	= "INSERT INTO ops_hdr SET 
						kode_ops				='".$kode_ops."',
						ref						='".$ref."',
						kode_cabang				='".$kode_cabang."',
						kode_supplier			='".$kode_supplier."',
						top						='".$top."',
						tgl_buat				='".$tgl_buat."',
						tgl_input				='".$tgl_input."',
						keterangan_hdr			='".$keterangan_hdr."',
						user_pencipta			='".$user_pencipta."', 
						total_harga				='".$total_harga."',
						total_ppn				='".$total_ppn."',
						subtotal				='".$subtotal."' ";	
						
		$query = mysql_query ($mySql) ;
		
		//DETAIL OP
		$array = $_SESSION['data_ops'];
			foreach($array as $key=>$item){
					$kode_kat_aset	= $item['kode_kat_aset'];
					$tgl_kirim		=$item['tgl_kirim'];
					$qty			=$item['qty'];
					$harga			=$item['harga'];
					$diskon			=$item['diskon'];
					$ppn			=$item['ppn'];
					$subtot			=$item['subtot'];
					$divisi			=$item['divisi'];
					$keterangan_dtl	=$item['keterangan_dtl'];
					
					$mySql1 = "INSERT INTO ops_dtl SET 
											kode_ops			='".$kode_ops."',
											kode_kat_aset 		='".$kode_kat_aset."',
											tgl_kirim 			='".$tgl_kirim."', 
											qty					='".$qty."',
											harga				='".$harga."',
											diskon				='".$diskon."',
											ppn					='".$ppn."',
											subtot				='".$subtot."',
											divisi				='".$divisi."',
											keterangan_dtl		='".$keterangan_dtl."' ";	
					$query1 = mysql_query ($mySql1) ;
		}
	
		if ($query AND $query1 ) {
			mysql_query("DELETE FROM ops_dtl_tmp WHERE id_form ='".$_POST['id_form']."' ");
			echo "00||".$kode_ops;

			//DETAIL UM
			$array = $_SESSION['data_um'];
				foreach($array as $key=>$item){
						$termin		= $item['nominal'];
						$persen		= $item['um'];
						//$termin 	=str_replace("%","",$nominal);
						
						$mySql2 = "INSERT INTO ops_um SET 
												kode_ops	='".$kode_ops."',
												termin		='".$termin."',
												persen 		='".$persen."' ";
												
						$query2 = mysql_query ($mySql2) ;
				}

			unset($_SESSION['data_ops']);
		} else { 
		   
			echo "Gagal query: ".mysql_error();
		}		 	
				
					 
	}

?>