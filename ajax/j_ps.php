<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	require('../pages/data/script/ps.php'); 
	date_default_timezone_set("Asia/Jakarta");
	
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
				$html .= '<div class="control-group input-group" style="margin-top:10px">
                   <input type="text" style="width: 17em" readonly name="um1[]" data-id="um1" data-group="'.$item['id_um'].'" class="form-control" placeholder="Uang Muka %" value="'.$item['um'].'%">
             		<div class="input-group-btn"> 
                        <input type="text" style="width: 7em" readonly name="nominal[]" data-id="nominal1" data-group="'.$item['id_um'].'" class="form-control" placeholder="0" value="'.$item['nominal'].'" >	
                        <button class="btn btn-danger remove hapus-um" type="button" data-id="'.$key.'"><i class="glyphicon glyphicon-remove"></i> Hapus.</button>
             		</div>
             </div>';
				
			}
			$html .= "<script>$('.hapus-um').click(function(){
						var id =	$(this).attr('data-id');
						$.ajax({
							type: 'POST',
							url: '".base_url()."ajax/j_ps.php?func=hapus-um',
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
		
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loaditem" )
	{
		$kode_cabang = $_POST['kode_cabang'];
		$kode_pr = $_POST['kode_pr'];
		
		$q_dtl = mysql_query(" SELECT pd.*,ph.kode_cabang FROM pr_dtl pd INNER JOIN pr_hdr ph ON pd.kode_pr=ph.kode_pr WHERE pd.kode_pr='".$kode_pr."' AND ph.kode_cabang='".$kode_cabang."' ");	
		
		$num_rows = mysql_num_rows($q_dtl);
		if($num_rows>0)
		{		
			$no=1;			 	
			while($rowdtl = mysql_fetch_array($q_dtl)){
				echo '<tr>
				
				<td>'.$no++.'</td>
				<td>'.$rowdtl['kode_barang'].' <input class="form-control" type="hidden" name="kode_barang[]" id="kode_barang[]" data-id="kode_barang" data-group="'.$no.'" autocomplete="off" value="'.$rowdtl['kode_barang'].'" style="width: 7em"  /> <input class="form-control" type="hidden" name="kode_gudang[]" id="kode_gudang[]" data-id="kode_gudang" data-group="'.$no.'" autocomplete="off" value="'.$rowdtl['kode_gudang'].'" style="width: 7em"  /> <input class="form-control" type="hidden" name="divisi[]" id="divisi[]" data-id="divisi" data-group="'.$no.'" autocomplete="off" value="'.$rowdtl['divisi'].'" style="width: 7em"  /> </td>
				<td><input type="text" name="tanggal1[]" class="form-control" autocomplete="off" required value="'.date("d-m-Y",strtotime($rowdtl['tgl_kirim'])).'"/></td>
				<td>'.$rowdtl['satuan'].' <input class="form-control" type="hidden" name="satuan[]" id="satuan[]" data-id="satuan" data-group="'.$no.'" autocomplete="off" value="'.$rowdtl['satuan'].'" style="width: 7em"  /></td>
				<td><input class="form-control" type="number" name="qty[]" id="qty[]" data-id="qty" data-group="'.$no.'" autocomplete="off" value="'.$rowdtl['qty'].'" style="width: 7em"  /></td>
				<td><input class="form-control" type="number" name="harga[]" id="harga[]" data-id="harga" data-group="'.$no.'" autocomplete="off" value="0" style="width: 7em"  /></td>
				<td><input class="form-control" type="number" name="disc[]" id="disc[]" data-id="disc" data-group="'.$no.'" autocomplete="off" value="0" style="width: 7em"  /></td>
				<td><input class="form-control" type="checkbox" name="ppn[]" id="ppn[]" data-id="ppn" data-group="'.$no.'" checked><input class="form-control" type="hidden" name="stat_ppn[]" id="stat_ppn[]" data-id="stat_ppn" data-group="'.$no.'" value="1"></td>
				<td><input class="form-control" type="text" name="subtot[]" id="subtot[]" data-id="subtot" data-group="'.$no.'" readonly autocomplete="off" value="0" style="width: 7em"  /><input class="form-control" type="hidden" name="total_asli[]" id="total_asli[]" data-id="total_asli" data-group="'.$no.'" readonly autocomplete="off" value="0" style="width: 7em"  /><input class="form-control" type="hidden" name="total_ppn[]" id="total_ppn[]" data-id="total_ppn" data-group="'.$no.'" readonly autocomplete="off" value="0" style="width: 7em"  /></td>
				<td><textarea  class="form-control" rows="2" name="keterangan_dtl[]" id="keterangan_dtl[]" placeholder="Keterangan..."></textarea></td>
				
				</tr>';
			}
			
			echo '<tr><td colspan="8" style="text-align:right">Subtotal</td><td style="text-align:right"><input class="form-control" type="text" name="subtotal_all" id="subtotal_all" autocomplete="off" value="0" readonly style="width: 7em"  /></td><td></td></tr>
			
			<tr><td colspan="8" style="text-align:right">Discount</td><td style="text-align:right"><input class="form-control" type="text" name="diskon_all" id="diskon_all" autocomplete="off" value="0" readonly style="width: 7em"  /></td><td></td></tr>
			
			<tr><td colspan="8" style="text-align:right">Ppn</td><td style="text-align:right"><input class="form-control" type="text" name="ppn_all" id="ppn_all" autocomplete="off" value="0" readonly style="width: 7em"  /></td><td></td></tr>
			
			<tr><td colspan="8" style="text-align:right; font-weight:bold">Grand Total</td><td style="text-align:right; font-weight:bold"><input class="form-control" type="text" name="grandtotal" id="grandtotal" autocomplete="off" value="0" readonly style="width: 7em"  /></td><td></td></tr>
			';
		}else
		{
			echo '<tr><td colspan="10" class="text-center">Belum ada item</td></tr>';
		}
		 				 
	}
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save" )
	{
		$form='PS';
		$thnblntgl=date("ymd",strtotime($_POST['tanggal']));
		
		$kode_cabang = ($_POST['kode_cabang']);
		$doc_pr=($_POST['no_pr']);
		$ref=($_POST['ref']);
		$keterangan_hdr=($_POST['keterangan_hdr']);
		$tgl_buat=date("Y-m-d",strtotime($_POST['tanggal']));
		
		$kode_supplier=($_POST['kode_supplier']);
		$alamat=($_POST['alamat']);
		$cp=($_POST['cp']);
		$no_kontak=($_POST['no_kontak']);
		$top=($_POST['top']);
		
		$user_pencipta = $_SESSION['app_id'];
		$tgl_input = date("Y-m-d H:i:s");
		
		$kode_ps = buat_kode_ps($thnblntgl,$form,$kode_cabang);
		
		//HEADER PS
		$mySql	= "INSERT INTO ps_hdr SET 
						kode_ps					='".$kode_ps."',
						kode_cabang				='".$kode_cabang."',
						doc_pr					='".$doc_pr."',
						ref						='".$ref."',
						keterangan_hdr			='".$keterangan_hdr."',
						tgl_buat				='".$tgl_buat."',
						kode_supplier			='".$kode_supplier."',
						alamat					='".$alamat."',
						cp						='".$cp."',
						no_kontak				='".$no_kontak."',
						top						='".$top."',
						tgl_input				='".$tgl_input."',
						user_pencipta			='".$user_pencipta."' ";	
						
		$query = mysql_query ($mySql) ;
		
		//DETAIL PS
		$no_ps			= $kode_ps;
		$kode_barang  	= $_POST['kode_barang'];
		$kode_gudang  	= $_POST['kode_gudang']; 
		$qty			= $_POST['qty'];
		$harga			= $_POST['harga'];
		$disc			= $_POST['disc'];
		$ppn			= $_POST['stat_ppn'];
		$subtotal		= $_POST['subtot'];
		$divisi			= $_POST['divisi']; 
		$keterangan_dtl	= $_POST['keterangan_dtl'];
		$satuan			= $_POST['satuan'];
		$tgl_kirim		= $_POST['tanggal1'];
		$count 			= count($kode_barang);
		 
		$sql   = "INSERT INTO ps_dtl (kode_ps,kode_barang,kode_gudang,qty,harga,disc,ppn,subtotal,divisi,keterangan_dtl,satuan,tgl_kirim) VALUES ";
		 
			for( $i=0; $i < $count; $i++ )
			{
				$strtgl_kirim = (date("Y-m-d",strtotime($tgl_kirim[$i])));
				$sql .= "('{$no_ps}','{$kode_barang[$i]}','{$kode_gudang[$i]}','{$qty[$i]}','{$harga[$i]}','{$disc[$i]}','{$ppn[$i]}','{$subtotal[$i]}','{$divisi[$i]}','{$keterangan_dtl[$i]}','{$satuan[$i]}','{$strtgl_kirim}')";
				$sql .= ",";
			}
		 
		$sql = rtrim($sql,",");
		
		$query1 = mysql_query ($sql) ;
		
		//DETAIL UM
		$array = $_SESSION['data_um'];
			foreach($array as $key=>$item){
					$termin		= $item['nominal'];
					$persen		= $item['um'];
					//$termin 	=str_replace("%","",$nominal);
					
					$mySql2 = "INSERT INTO ps_um SET 
											kode_ps		='".$kode_ps."',
											termin		='".$termin."',
											persen 		='".$persen."' ";
											
					$query2 = mysql_query ($mySql2) ;
			}
		
		if ($query AND $query1 AND $query2) {
			//UPDATE STATUS DI pr_dtl
			/*$updkd_pr = "UPDATE pr_dtl SET status='2' WHERE kode_pr = '".$doc_pr."' ";
			mysql_query($updkd_pr);*/
			echo "00||".$kode_ps;
			unset($_SESSION['data_um']);
			//unset($_SESSION['data_op'.$id_form .'']);
			//echo "00|| $mySql";
			
		} else { 
		   
			echo "Gagal query: ".mysql_error();
		}		 	
				
					 
	}
?>	