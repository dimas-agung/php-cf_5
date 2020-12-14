<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	require('../pages/data/script/jm.php'); 
	date_default_timezone_set("Asia/Jakarta");

	if (isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "add" )
	{

		if(isset($_POST['kode_coa']) and @$_POST['kode_coa'] != ""){

			$coa = $_POST['kode_coa'];
			$kd_coa	= explode(":", $coa);
			$kode_coa = $kd_coa[0];
			$nama_coa = $kd_coa[1];

			$id_form		= $_POST['id_form'];
			$itemjm 		= "INSERT INTO jm_dtl_tmp SET 
											kode_coa		='".$kode_coa."',
											nama_coa		='".$nama_coa."',
											debet			='".$_POST['debet']."',
											kredit			='".$_POST['kredit']."',
											keterangan_dtl	='".$_POST['keterangan']."',
											id_form			='".$id_form."' ";
			mysql_query($itemjm);
			
			$query			= "SELECT * FROM jm_dtl_tmp WHERE id_form='".$id_form."'";
			$result			= mysql_query($query);
			
			$array = array();
			if(mysql_num_rows($result) > 0) {
				while ($res = mysql_fetch_array($result)) {
					
					if(!isset($_SESSION['data_jm'])) {
						$array[$res['id_jm_dtl']] = array("id" => $res['id_jm_dtl'],"kode_coa" => $res['kode_coa'],"nama_coa" => $res['nama_coa'],"kredit" => $res['kredit'],"debet" => $res['debet'],"keterangan_dtl" => $res['keterangan_dtl'], "id_form" => $res['id_form']);
					} else {
						$array = $_SESSION['data_jm'];
							$array[$res['id_jm_dtl']] = array("id" => $res['id_jm_dtl'],"kode_coa" => $res['kode_coa'],"nama_coa" => $res['nama_coa'],"kredit" => $res['kredit'],"debet" => $res['debet'],"keterangan_dtl" => $res['keterangan_dtl'], "id_form" => $res['id_form']);
					}
				   
				}
			} 
			$_SESSION['data_jm'] = $array;
			echo view_item_jm($array);
		}
	}


	function view_item_jm($data) {
		$n 					= 1;
		$subtotal_debet 	= 0;
		$subtotal_kredit 	= 0;
		$html = "";
		if(count($data) > 0) {
			foreach($data as $key=>$item){
				$html .= '<tr>
							<td style="text-align: center">'.$n++.'</td>
							<td>'.$item['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$item['nama_coa'].'</td>
							<td style="text-align:right">'.number_format($item['debet'], 2).'</td>	
							<td style="text-align:right">'.number_format($item['kredit'], 2).'</td>	
							<td>'.$item['keterangan_dtl'].'</td>
							<td style="text-align: center">
							<!-- <a href="javascript:;" class="label label-info edit_jm" data-toggle="modal" data-target="#edit_jm" data-id="'.$item['id'].'"><i class="fa fa-pencil"></i></a> -->
							<a href="javascript:;" class="label label-danger hapus-jm" title="hapus data" data-id="'.$key.'"><i class="fa fa-times"></i></a>           			
							</td>
						</tr>						
						';
						
						$sub_debet 	= $item['debet'];
						$sub_kredit = $item['kredit'];
						
						$subtotal_debet 	+= (int)($sub_debet);
						$subtotal_kredit 	+= (int)($sub_kredit);
						$grand_total		=(int)($subtotal_debet-$subtotal_kredit);
				
			}

				$html .= '<tr>
								<td style="text-align:right" colspan="2"><b>Subtotal :</b></td>
								<td style="text-align:right"><b>'.number_format($subtotal_debet, 2).'</b> <input class="form-control" type="hidden" name="subtotal_debet" id="subtotal_debet" autocomplete="off" value="'.$subtotal_debet.'" readonly style="width: 7em"  /></td>
								<td style="text-align:right"><b>'.number_format($subtotal_kredit, 2).'</b> <input class="form-control" type="hidden" name="subtotal_kredit" id="subtotal_kredit" autocomplete="off" value="'.$subtotal_kredit.'" readonly style="width: 7em"  /></td>
								<td style="text-align:right" colspan="3"></td>
							</tr>
					  ';
			
			$html .= "<script>$('.hapus-jm').click(function(){
						var id =	$(this).attr('data-id'); 
						var id_form = $('#id_form').val();
						$.ajax({
							type: 'POST',
							url: '".base_url()."ajax/j_jm.php?func=hapus-jm',
							data: 'idhapus=' + id + '&id_form=' +id_form,
							cache: false,
							success:function(data){
								$('#detail_input_jm').html(data).show();
							 }
						  });
					  });
				     </script>";
				
		} else {
			$html .= '<tr> <td colspan="15" class="text-center"> Tidak ada item barang. </td></tr>';
		}
		  
		return $html;
	}


	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "hapus-jm" )
	{
		$id = $_POST['idhapus'];
		$id_form = $_POST['id_form'];
		$itemdelete = "DELETE FROM jm_dtl_tmp WHERE id_jm_dtl = '".$id."'";
		mysql_query($itemdelete);
		unset($_SESSION['data_jm'][$id]);
		echo view_item_jm($_SESSION['data_jm']);
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "edit-jm" ){
		
		$id				= $_POST['id'];
		$query			= "SELECT * from jm_dtl_tmp WHERE id_jm_dtl = '$id' ";
		$result			= mysql_query($query);
		
		while ($res = mysql_fetch_array($result)) {

		echo ' <div class="col-md-12 pm-min">
                    <form role="form" method="post" action="" id="form-edit-jm">
                        <div class="col-md-12 pm-min-s">
                           
                           <div class="col-md-12 pm-min-s">
                            	<label class="control-label">DOC</label>
                            		<select id="kode_coa_edit" name="kode_coa_edit" class="select2" style="width: 100%;">
                            			<option value="">--PILIH COA--</option>';
										$row_coa = $res['kode_coa']; 
                            				while($rowcoa = mysql_fetch_array($q_coa_edit)){
		echo'		         						<option 
														data-nama="'.$rowcoa['nama_coa'].'"
														value='.$rowcoa['kode_coa'].' 
														'.(($rowcoa['kode_coa']==$row_coa)?'selected="selected"':"").' >
														'.$rowcoa['nama_coa'].'
													</option>';
										 	} 
		echo'		    		<input type="hidden" name="id_form_edit" id="id_form_edit" value='.$res['id_form'].' class="form-control" placeholder="Description..."/>	
								<input type="hidden" name="id_edit" value='.$res['id_jm_dtl'].' id="id_edit" class="form-control" placeholder="ID ..."/> 	
								<input type="hidden" name="nama_coa_edit" id="nama_coa_edit" value="" class="form-control" tabindex="3" />
									</select>
									</select>
                            </div>

                            <div class="col-md-6 pm-min-s">
                            	<label class="control-label">Debet</label>
                            	<input type="number" name="debet_edit" id="debet_edit" value="'.$res['debet'].'" class="form-control" value="0" tabindex="3"/>
                            </div>
                            
                            <div class="col-md-6 pm-min-s">
                            	<label class="control-label">Kredit</label>
                            	<input type="number" name="kredit_edit" id="kredit_edit" value="'.$res['kredit'].'" class="form-control" value="0" tabindex="3"/>
                            </div>

                            <div class="col-md-12 pm-min-s">
                            	<label class="control-label">Keterangan</label>
                            	<input type="text" name="keterangan_edit" id="keterangan_edit" value="'.$res['keterangan_dtl'].'" class="form-control" tabindex="3"/>
                            </div>
                        </div>
                    </form>
                </div>
				<div class="modal-footer">
                    <button type="button" name="submit" class="btn btn-success edit-to-jm" tabindex="4" data-dismiss="modal"><i class="fa fa-plus"></i> Update</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>';
				
	echo "<script>$('.edit-to-jm').click(function(){
						var id =	$(this).attr('data-id'); 
						$.ajax({
							type: 'POST',
							url: '".base_url()."ajax/j_jm.php?func=update-jm',
							data: $('#form-edit-jm').serialize(),
							cache: false,
							success:function(data){
								$('#detail_input_jm').html(data).show();
							}
						});
					});
				  </script>";
		}
		
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "update-jm" )
	{
	if(isset($_POST['kode_coa_edit']) and @$_POST['kode_coa_edit'] != ""){
			
			$id_form =$_POST['id_form_edit'];
			$itemeditjm = "UPDATE jm_dtl_tmp SET 
											kode_coa		='".$_POST['kode_coa_edit']."',
											nama_coa		='".$_POST['nama_coa_edit']."',
											debet			='".$_POST['debet_edit']."',
											kredit			='".$_POST['kredit_edit']."',
											keterangan_dtl	='".$_POST['keterangan_edit']."'
										 	WHERE id_jm_dtl ='".$_POST['id_edit']."' ";
			mysql_query($itemeditjm);
			
			$query			= "SELECT * FROM jm_dtl_tmp WHERE id_form='".$_POST['id_form_edit']."'";
			$result			= mysql_query($query);
			
			$array = array();
			if(mysql_num_rows($result) > 0) {
				while ($res = mysql_fetch_array($result)) {

							$array[$res['id_jm_dtl']] = array("id" => $res['id_jm_dtl'],"kode_coa" => $res['kode_coa'],"nama_coa" => $res['nama_coa'],"kredit" => $res['kredit'],"debet" => $res['debet'],"keterangan_dtl" => $res['keterangan_dtl'], "id_form" => $res['id_form']);
					
				}
			}

			$_SESSION['data_jm'] = $array;
			echo view_item_jm($array);			 
	}
		
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save" )
	{

		// Set autocommit to off
		mysqli_autocommit($con,FALSE);

		$form 				= 'JM';
		$thnblntgl 			= date("ymd",strtotime($_POST['tgl_buat']));
		
		$ref 				= ($_POST['ref']);
		$kode_cabang		= ($_POST['kode_cabang']);
		$tgl_buat 			= date("Y-m-d",strtotime($_POST['tgl_buat']));
		$keterangan_hdr		= ($_POST['keterangan_hdr']);
		
		$subtotal_debet 	= ($_POST['subtotal_debet']);
		$subtotal_kredit 	= ($_POST['subtotal_kredit']);	

		$user_pencipta  = $_SESSION['app_id'];
		$tgl_input 		= date("Y-m-d H:i:s");
		
		$kode_jm = buat_kode_jm($thnblntgl,$form,$kode_cabang);
		
		//HEADER jm
		$mySql	= "INSERT INTO jm_hdr SET 
						kode_jm				='".$kode_jm."',
						kode_cabang			='".$kode_cabang."',
						tgl_buat			='".$tgl_buat."',
						ref					='".$ref."',
						subtotal_debet		='".str_replace(',', null, $subtotal_debet)."',
						subtotal_kredit		='".str_replace(',', null, $subtotal_kredit)."', 
						keterangan_hdr		='".$keterangan_hdr."',
						user_pencipta		='".$user_pencipta."', 
						tgl_input			='".$tgl_input."'
				  ";	
						
		$query = mysqli_query ($con,$mySql) ;
		
		//DETAIL jm
		$array = $_SESSION['data_jm'];
			foreach($array as $key=>$item){
					$no_jm 			= $kode_jm;
					$kode_coa		= $item['kode_coa'];
					$debet 			= $item['debet'];
					$kredit 		= $item['kredit'];
					$keterangan_dtl	= $item['keterangan_dtl'];
					
					$mySql1 = "INSERT INTO `jm_dtl` SET 
											`kode_jm`				='".$kode_jm."',
											`kode_coa` 			='".$kode_coa."',
											`debet` 			='" . (str_replace(',', null, $debet) > 0 ? str_replace(',', null, $debet) : 0) . "',
											`kredit` 			='" . (str_replace(',', null, $kredit) > 0 ? str_replace(',', null, $kredit) : 0) . "',
											`keterangan_dtl`		='".$keterangan_dtl."' ";	
		$query1 = mysqli_query ($con,$mySql1) ;
		
		$mySql2 = "INSERT INTO `jurnal` SET
					`kode_transaksi` 	='" . $kode_jm . "',
					`tgl_input` 		='" . date('Y-m-d H:i:s') . "',
					`tgl_buat` 		='" . $tgl_buat . "',
					`kode_cabang` 	='" . $kode_cabang . "',
					`keterangan_hdr` 	='" . $keterangan_hdr . "',
					`keterangan_dtl` 	='" . $keterangan_dtl . "',
					`ref` 			='" . $ref . "',
					`kode_coa` 		='" . $kode_coa . "',
					`debet` 			='" . (str_replace(',', null, $debet) > 0 ? str_replace(',', null, $debet) : 0) . "',
					`kredit` 			='" . (str_replace(',', null, $kredit) > 0 ? str_replace(',', null, $kredit) : 0) . "',
					`user_pencipta`   ='" . $_SESSION['app_id'] . "'";

        $query2 = mysqli_query($con, $mySql2);
		}


		if ($query AND $query1 AND $query2) {
			mysqli_query($con,"DELETE FROM jm_dtl_tmp WHERE id_form ='".$_POST['id_form']."' ");

			// Commit transaction
			mysqli_commit($con);
			
			// Close connection
			mysqli_close($con);

			echo "00||".$kode_jm;
			unset($_SESSION['data_jm']);
			//unset($_SESSION['data_op'.$id_form .'']);
			//echo "00|| $mySql";
			
		} else { 
		   
			echo "Gagal query: ".mysql_error();
		}		 	
				
					 
	}
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "pembatalan" )
	{

		// Set autocommit to off
		mysqli_autocommit($con,FALSE);
		$kode_jm		= $_POST['kode_jm_batal'];
		$alasan_batal	= $_POST['alasan_batal'];
		$tgl_batal 		= date("Y-m-d");
		
		//UPDATE JM_HDR 
		$mySql1 = "UPDATE jm_hdr SET status ='1', alasan_batal = '" . $alasan_batal . "', user_batal = '" . $_SESSION['app_id'] . "', tgl_batal = '" . $tgl_batal . "' WHERE kode_jm='".$kode_jm."' ";
		$query1 = mysqli_query ($con,$mySql1) ;

		//UPDATE JM_DTL
		$mySql2 = "UPDATE jm_dtl SET status_dtl ='1' WHERE kode_jm='".$kode_jm."' ";
		$query2 = mysqli_query ($con,$mySql2) ;

		//INSERT JURNAL
		$jurnal = mysql_query("SELECT * FROM jurnal WHERE kode_transaksi = '".$kode_jm."' ");
		$num_row_j  = mysql_num_rows($jurnal);

		if($num_row_j > 0){
			while($row_j = mysql_fetch_array($jurnal)){
			
				$kode_transaksi 	= $row_j['kode_transaksi'];
				$ref 				= $row_j['ref'];
				$tgl_buat 			= $row_j['tgl_buat'];
				$kode_cabang 		= $row_j['kode_cabang'];
				$kode_supplier 		= $row_j['kode_supplier'];
				$kode_pelanggan 	= $row_j['kode_pelanggan'];
				$kode_coa 			= $row_j['kode_coa'];
				$debet 				= $row_j['debet'];
				$kredit 			= $row_j['kredit'];
				$tgl_input 			= date("Y-m-d H:i:s");
				$keterangan_hdr 	= $row_j['keterangan_hdr'];
				$keterangan_dtl 	= $row_j['keterangan_dtl'];

				$mySql3 = "INSERT INTO jurnal SET
								kode_transaksi 	='".$kode_transaksi."',
								ref 			='".$ref."', 
								tgl_buat 		='".$tgl_buat."',
								kode_cabang 	='".$kode_cabang."',
								kode_supplier 	='".$kode_supplier."',
								kode_pelanggan 	='".$kode_pelanggan."',
								kode_coa 		='".$kode_coa."',
								debet  			='".$kredit."',
								kredit  		='".$debet."',
								tgl_input 		='".$tgl_input."',
								keterangan_hdr 	='".$keterangan_hdr."',
								keterangan_dtl 	='".$keterangan_dtl."'
							";			
				$query3 = mysqli_query ($con,$mySql3) ;	

				$mySql4 = "UPDATE jurnal SET status_jurnal ='1' WHERE kode_transaksi = '".$kode_transaksi."' ";			
				$query4 = mysqli_query ($con,$mySql4) ;	
			}
		}

		if ($query1 AND $query2 AND $query3 AND $query4) {
			
			mysqli_commit($con);
			mysqli_close($con);
			
			echo "00||".$kode_jm;
		} else { 
			echo "Gagal query: ".mysql_error();
		}	
	}
	
?>