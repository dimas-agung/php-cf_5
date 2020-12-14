<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	require('../pages/data/script/pr.php'); 
	date_default_timezone_set("Asia/Jakarta");
	
    
	
		
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loaditem" )
	{
		$kode_gudang = $_POST['kode_gudang'];
		
		/*$q_kode_akt = mysql_query("SELECT * FROM mst_kode_aktivitas WHERE kode_header = '".$kategori."' ");	
		
		echo '<label>Aktivitas</label>
				<select class="form-control" id="kode_aktivitas" name="kode_aktivitas" required>
					<option value="0">-- Pilih --</option>';
					 	
                	while($rowakt = mysql_fetch_array($q_kode_akt)){
                     
         echo    	'<option value="'.$rowakt['kode_detail'].'" >'.$rowakt['keterangan'].'</option>';
		 
	 				}
  
         echo   '</select>';*/
		 
		 echo '<input type="text" class="form-control" name="stok" id="stok" placeholder="Sisa stok..." value="100" readonly>';
		 				 
	}
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "input_pr" )
	{
		
		 
		
		 //GUDANG
		 echo 	'<td>
		 		<select id="kode_gudang" name="kode_gudang"  class="form-control" required>
				<option value="0">-- Pilih Gudang --</option>';
						while($rowgudang = mysql_fetch_array($q_gud_aktif)) {
		 echo	'<option value="'.$rowgudang['kode_gudang'].' - '.$rowgudang['nama'].'" >'.$rowgudang['nama'].' </option>';
						}
		 echo	'</select>	
		 		</td>';
		 
		 //BARANG
		 echo 	'<td>
		 		<select id="kode_barang" name="kode_barang"  class="select2" required>
				<option value="0">-- Pilih Barang --</option>';
						while($rowitem = mysql_fetch_array($q_ddl_item)) {
		 echo	'<option value="'.$rowitem['kode_inventori'].' - '.$rowitem['nama'].'" >'.$rowitem['nama'].' </option>';
						}
		 echo	'</select>	
		 		</td>';
				
		
		 
		 				 
	}
	
	if (isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "add" )
	{
		

		if(isset($_POST['kode_barang']) and @$_POST['kode_barang'] != ""){
			$tgl_kirim = date("Y-m-d",strtotime($_POST['tgl_kirim']));
			$id_form=$_POST['id_form'];
			$itemsf = "INSERT INTO pr_dtl_tmp SET 
											kode_barang		='".$_POST['kode_barang']."',
											kode_gudang     ='".$_POST['kode_gudang']."',
											divisi			='".$_POST['divisi']."',
											tgl_kirim		='".$tgl_kirim."',
											stok			='".$_POST['stok']."',
											qty		    	='".$_POST['qty']."',
											satuan			='".$_POST['satuan']."',
											keterangan_dtl  ='".$_POST['keterangan_dtl']."',
											id_form			='".$id_form."' ";
			mysql_query($itemsf);
			
			$query			= "SELECT * FROM pr_dtl_tmp WHERE id_form='".$id_form."'";
			$result			= mysql_query($query);
			
			$array = array();
			if(mysql_num_rows($result) > 0) {
				while ($res = mysql_fetch_array($result)) {
					
					if(!isset($_SESSION['data_pr'])) {
						$array[$res['id_pr_dtl']] = array("id" => $res['id_pr_dtl'],"kode_barang" => $res['kode_barang'], "kode_gudang" => $res['kode_gudang'],"divisi" => $res['divisi'],"tgl_kirim" => $res['tgl_kirim'],"stok" => $res['stok'],"qty" => $res['qty'], "satuan" => $res['satuan'],"keterangan_dtl" => $res['keterangan_dtl'], "id_form" => $res['id_form']);
					} else {
						$array = $_SESSION['data_pr'];
							$array[$res['id_pr_dtl']] = array("id" => $res['id_pr_dtl'],"kode_barang" => $res['kode_barang'],  "kode_gudang" => $res['kode_gudang'],"divisi" => $res['divisi'],"tgl_kirim" => $res['tgl_kirim'],"stok" => $res['stok'],"qty" => $res['qty'], "satuan" => $res['satuan'],"keterangan_dtl" => $res['keterangan_dtl'], "id_form" => $res['id_form']);
					}
				   
				}
			} 
			
			
				$_SESSION['data_pr'] = $array;
				echo view_item_pr($array);
			 
		}
		
	}
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "hapus-pr" )
	{
		$id = $_POST['idhapus'];
		$id_form = $_POST['id_form'];
		$itemdelete = "delete from pr_dtl_tmp where id_pr_dtl = '".$id."'";
		mysql_query($itemdelete);
		unset($_SESSION['data_pr'][$id]);
		echo view_item_pr($_SESSION['data_pr']);
	}
	
	function view_item_pr($data) {
		$n = 1;
		$html = "";
		$grandtotal = 0;
		$total= 0;
		if(count($data) > 0) {
			foreach($data as $key=>$item){
				
				$total += ($item['qty']);
				$html .= '<tr><td>'.$item['kode_gudang'].'</td>
					<td>'.$item['kode_barang'].'<input type="hidden" data-id="id_form" value='.$item['id_form'].' class="form-control" placeholder="id_form..."/></td>
					<td>'.$item['tgl_kirim'].'</td>
					<td>'.$item['satuan'].'</td>
					<td class="jumlah_barang">'.$item['qty'].'</td>
					<td>'.$item['stok'].'</td>
					<td>'.$item['divisi'].'</td>
					<td>'.$item['keterangan_dtl'].'</td>
					<td>
<!--					<a href="" class="label label-primary" data-toggle="modal"  data-target="#tambah_survey"><i class="fa fa-plus-circle"></i></a> 
					<a href="javascript:;" class="label label-info edit_survey" data-toggle="modal" data-target="#edit_pr" data-id="'.$item['id'].'"><i class="fa fa-pencil"></i></a> -->
					<a href="javascript:;" class="label label-danger hapus-pr" title="hapus data" data-id="'.$key.'"><i class="fa fa-times"></i></a>           			
					</td></tr>';
				
			}
			$html .= '<tr><td colspan="9">&nbsp;<input type="hidden" value="'.$total.'" id="b_grand_total"></td></tr>';
			$html .= "<script>$('.hapus-pr').click(function(){
						var id =	$(this).attr('data-id'); 
						var id_form = $('#id_form').val();
						$.ajax({
							type: 'POST',
							url: '".base_url()."ajax/j_pr.php?func=hapus-pr',
							data: 'idhapus=' + id + '&id_form=' +id_form,
							cache: false,
							success:function(data){
								$('#detail_input_pr').html(data).show();
							 }
						  });
					  });
				     </script>";
				
		} else {
			$html .= '<tr> <td colspan="9" class="text-center"> Tidak ada item barang. </td></tr>';
		}
		
		/*$html  .= "<script>$('.edit_survey').click(function(){
						var id =	$(this).attr('data-id'); 
						var id_form = $('#id_form').val();
						$.ajax({
							type: 'POST',
							url: '".base_url()."ajax/r_fs.php?func=edit_survey',
							data: 'id=' +id + '&id_form=' +id_form,
							cache: false,
							success:function(data){
								$('#show-item-edit').html(data).show();
							}
						});
					});
				  </script>";	*/	  
		return $html;
	}
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save" )
	{
		$form='PR';
		$thnblntgl=date("ymd",strtotime($_POST['tanggal']));
		
		$kode_cabang = ($_POST['kode_cabang']);
		$doc_so=($_POST['doc_so']);
		$doc_pq=($_POST['doc_pq']);
		$ref=($_POST['ref']);
		$keterangan_hdr=($_POST['keterangan_hdr']);
		$tgl_buat=date("Y-m-d",strtotime($_POST['tanggal']));
		
		$user_pencipta = $_SESSION['app_id'];
		$tgl_input = date("Y-m-d H:i:s");
		
		$kode_pr = buat_kode_pr($thnblntgl,$form,$kode_cabang);
		
		//HEADER PR
		$mySql	= "INSERT INTO pr_hdr SET 
						kode_pr					='".$kode_pr."',
						kode_cabang				='".$kode_cabang."',
						doc_so					='".$doc_so."',
						doc_pq					='".$doc_pq."',
						ref						='".$ref."',
						keterangan_hdr			='".$keterangan_hdr."',
						tgl_buat				='".$tgl_buat."',
						tgl_input				='".$tgl_input."',
						user_pencipta			='".$user_pencipta."' ";	
						
		$query = mysql_query ($mySql) ;
		
		//DETAIL PR
		$array = $_SESSION['data_pr'];
			foreach($array as $key=>$item){
					$kode_barang	= $item['kode_barang'];
					$kode_gudang	=$item['kode_gudang'];
					$stok			=$item['stok'];
					$qty			=$item['qty'];
					$divisi			=$item['divisi'];
					$keterangan_dtl	=$item['keterangan_dtl'];
					$satuan			=$item['satuan'];
					$tgl_kirim		=$item['tgl_kirim'];
					
					$mySql1 = "INSERT INTO pr_dtl SET 
											kode_pr				='".$kode_pr."',
											kode_barang			='".$kode_barang."',
											kode_gudang 		='".$kode_gudang."',
											stok 				='".$stok."',
											qty		    		='".$qty."',
											satuan				='".$satuan."',
											divisi 				='".$divisi."',
											tgl_kirim			='".$tgl_kirim."',
											keterangan_dtl		='".$keterangan_dtl."' ";
											
					$query1 = mysql_query ($mySql1) ;
			}
	
		if ($query AND $query1) {
			mysql_query("DELETE FROM pr_dtl_tmp WHERE id_form ='".$_POST['id_form']."' ");
			echo "00||".$kode_pr;
			unset($_SESSION['data_pr']);
			//unset($_SESSION['data_op'.$id_form .'']);
			//echo "00|| $mySql";
			
		} else { 
		   
			echo "Gagal query: ".mysql_error();
		}		 	
				
					 
	}
	 
?>	 
