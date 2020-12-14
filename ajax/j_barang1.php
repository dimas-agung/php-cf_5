<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	require('../pages/data/script/m_barang.php'); 
	date_default_timezone_set("Asia/Jakarta");

	if (isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "add" )
	{

		if(isset($_POST['kode_barang_dtl']) and @$_POST['kode_barang_dtl'] != ""){

			$id_form		= $_POST['id_form'];
			$itembom 		= "INSERT INTO bom_tmp SET 
											kode_barang_dtl	='".$_POST['kode_barang_dtl']."',
											satuan_dtl		='".$_POST['satuan_dtl']."',
											qty_satuan_dtl	='".$_POST['qty_dtl']."',
											keterangan_dtl	='".$_POST['ket_dtl']."',
											id_form			='".$id_form."' ";
			mysql_query($itembom);
			if (mysql_error()) {
				// echo "33||"."Kode Barang : ".$_POST['kode_barang_dtl']." Tidak Boleh Sama !";
				echo "33||"."Barang Tidak Boleh Sama !";
				exit ;
			}
			
			$query			= "SELECT * FROM bom_tmp WHERE id_form='".$id_form."'";
			$result			= mysql_query($query);
			
			$array = array();
			if(mysql_num_rows($result) > 0) {
				while ($res = mysql_fetch_array($result)) {
					
				if(!isset($_SESSION['data_barang'])) {
					$array[$res['id_bom_dtl']] = array("id" => $res['id_bom_dtl'],"kode_barang_dtl" => $res['kode_barang_dtl'],"satuan_dtl" => $res['satuan_dtl'],"qty_satuan_dtl" => $res['qty_satuan_dtl'],"keterangan_dtl" => $res['keterangan_dtl'], "id_form" => $res['id_form']);
				}else{
					$array = $_SESSION['data_barang'];
					$array[$res['id_bom_dtl']] = array("id" => $res['id_bom_dtl'],"kode_barang_dtl" => $res['kode_barang_dtl'],"satuan_dtl" => $res['satuan_dtl'],"qty_satuan_dtl" => $res['qty_satuan_dtl'],"keterangan_dtl" => $res['keterangan_dtl'], "id_form" => $res['id_form']);
					}
				   
				}
			} 
				$_SESSION['data_barang'] = $array;
				echo view_item_bom($array);
			 
		}
		
	}

	function view_item_bom($data) {
		$n = 1;
		$html = "";
		if(count($data) > 0) {
			foreach($data as $key=>$item){

				$kode_barang = $item['kode_barang_dtl'];
					if(!empty($kode_barang)) {
					$pisah=explode(":",$kode_barang);
					$nm_barang=$pisah[1];
					}

				$kode_satuan = $item['satuan_dtl'];
					if(!empty($kode_satuan)) {
					$pisah=explode(":",$kode_satuan);
					$nm_satuan=$pisah[1];
					}

				$html .= '<tr>
							<td style="text-align:center;">'.$n++.'</td>
							<td>'.$nm_barang.'
								<input class="form-control" type="hidden" name="kode_barang_dtl" id="kode_barang_dtl" value='.$item['kode_barang_dtl'].'/>
							</td>
							<td>'.$nm_satuan.'
								<input class="form-control" type="hidden" name="satuan_dtl" id="satuan_dtl" value='.$item['satuan_dtl'].'/>
							</td>
							<td style="text-align:right;">'.number_format($item['qty_satuan_dtl']).'</td>
							<td>'.$item['keterangan_dtl'].'</td>
							<td style="text-align:center">
								<a href="javascript:;" class="label label-danger hapus-bom" title="hapus data" data-id="'.$key.'"><i class="fa fa-times"></i>
								</a>           			
							</td>
						</tr>						
						';
			}
			
			$html .= "<script>$('.hapus-bom').click(function(){
						var id =	$(this).attr('data-id'); 
						var id_form = $('#id_form').val();
						$.ajax({
							type: 'POST',
							url: '".base_url()."ajax/j_barang.php?func=hapus-bom',
							data: 'idhapus=' + id + '&id_form=' +id_form,
							cache: false,
							success:function(data){
								$('#show_input_barang').html(data).show();
							 }
						  });
					  });
				     </script>";
				
		} else {
			$html .= '<tr> <td colspan="15" class="text-center"> Tidak ada item barang. </td></tr>';
		}
		  
		return $html;
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "hapus-bom" )
	{
		$id = $_POST['idhapus'];
		$id_form = $_POST['id_form'];
		$itemdelete = "DELETE FROM bom_tmp WHERE id_bom = '".$id."'";
		mysql_query($itemdelete);
		unset($_SESSION['data_barang'][$id]);
		echo view_item_bom($_SESSION['data_barang']);
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loadbomedit" )
	{
		$kode_inventori = $_POST['kode_inventori'];
		
		$q_bom__edit = mysql_query("SELECT * FROM bom WHERE kode_inventori ='".$kode_inventori."' ORDER id_bom ASC");	
		
		$num_rows 	= mysql_num_rows($q_bom__edit);
		if($num_rows>0)
		{		
			$no=1;			 	
			while($rowdtl = mysql_fetch_array($q_bom__edit)){

				$barang = $rowdtl['kode_barang_dtl'];
				$pisah = explode(":", $barang);
				$kd_barang = $pisah[0];
				$nm_barang = $pisah[1];

				$satuan = $rowdtl['satuan_dtl'];
				$pisah = explode(":", $satuan);
				$kd_satuan = $pisah[0];
				$nm_satuan = $pisah[1];
				
				echo '<tr>
							<td style="text-align: center">'.$no++.'</td>
							<td>'.$nm_barang.' 
								<input class="form-control" type="hidden" name="kode_barang_dtl[]" id="kode_barang_dtl[]" value="'.$rowdtl['kode_barang_dtl'].'" style="width: 7em"/>
							</td>
							<td>'.$nm_satuan.' 
								<input class="form-control" type="hidden" name="satuan_dtl[]" id="satuan_dtl[]" value="'.$rowdtl['satuan_dtl'].'" style="width: 7em"  />
							</td>
							<td>'.number_format($rowdtl['qty_dtl']).' 
								<input class="form-control" type="hidden" name="qty_dtl[]" id="qty_dtl[]"  value="'.$rowdtl['qty_dtl'].'" style="width: 7em"  />
							</td>
							<td><textarea  class="form-control" rows="1" name="ket_dtl[]" id="ket_dtl[]" placeholder="Keterangan...">'.$rowdtl['keterangan_dtl'].'</textarea></td>
					</tr>';

			}
			
		}else{

			echo '<tr><td colspan="5" class="text-center">Belum ada item</td></tr>';

		}
		 				 
	}

	if (isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "add-edit" )
	{

		if(isset($_POST['kode_barang_dtl']) and @$_POST['kode_barang_dtl'] != ""){

			$id_form = $_POST['id_form'];

			$query_bom		 = mysql_query("SELECT * FROM bom_tmp WHERE kode_barang_dtl='".$_POST['kode_barang_dtl']."' AND id_form='".$id_form."'");
			if(mysql_num_rows($query_bom) > 0) {
				while ($res = mysql_fetch_array($query_bom)) {
					$qty = $res['qty_satuan_dtl'];
					$kode_barang_bom = $res['kode_barang_dtl'];
					
					if($kode_barang_bom == $_POST['kode_barang_dtl']){
						$qty1 = $qty+$_POST['qty_dtl'];
						$hapus_bom = mysql_query("DELETE FROM bom_tmp WHERE kode_barang_dtl = '".$_POST['kode_barang_dtl']."' and id_form = '".$id_form."'");
					}else{
						$qty1 = $_POST['qty_dtl'];
					}
				}
			}else{
				$qty1 = $_POST['qty_dtl'];
			}

			$itembom 		= "INSERT INTO bom_tmp SET 
											kode_barang_dtl	='".$_POST['kode_barang_dtl']."',
											satuan_dtl		='".$_POST['satuan_dtl']."',
											qty_satuan_dtl	='".$qty1."',
											keterangan_dtl	='".$_POST['ket_dtl']."',
											id_form			='".$id_form."' ";
			mysql_query($itembom);
			
			$query			= "SELECT * FROM bom_tmp WHERE id_form='".$id_form."'";
			$result			= mysql_query($query);
			
			$array = array();
			if(mysql_num_rows($result) > 0) {
				while ($res = mysql_fetch_array($result)) {
					
				if(!isset($_SESSION['data_barang_edit'])) {
					$array[$res['kode_barang_dtl']] = array("id" => $res['id_bom_dtl'],"kode_barang_dtl" => $res['kode_barang_dtl'],"satuan_dtl" => $res['satuan_dtl'],"qty_satuan_dtl" => $res['qty_satuan_dtl'],"keterangan_dtl" => $res['keterangan_dtl'], "id_form" => $res['id_form']);
				}else{
					$array = $_SESSION['data_barang_edit'];
					$array[$res['kode_barang_dtl']] = array("id" => $res['id_bom_dtl'],"kode_barang_dtl" => $res['kode_barang_dtl'],"satuan_dtl" => $res['satuan_dtl'],"qty_satuan_dtl" => $res['qty_satuan_dtl'],"keterangan_dtl" => $res['keterangan_dtl'], "id_form" => $id_form);
					}
				   
				}
			} 
				$_SESSION['data_barang_edit'] = $array;
				echo view_item_bom_edit($array);
			 
		}
		
	}

	function view_item_bom_edit($data) {
		$n = 1;
		$html = "";
		if(count($data) > 0) {
			foreach($data as $key=>$item){

				$kode_barang = $item['kode_barang_dtl'];
					if(!empty($kode_barang)) {
					$pisah=explode(":",$kode_barang);
					$nm_barang=$pisah[1];
					}

				$kode_satuan = $item['satuan_dtl'];
					if(!empty($kode_satuan)) {
					$pisah=explode(":",$kode_satuan);
					$nm_satuan=$pisah[1];
					}

				$html .= '<tr>
							<td style="text-align:center;">'.$n++.'
								<input class="form-control" type="hidden" name="id_form_edit1" id="id_form_edit1" value='.$item['id_form'].'/>
							</td>
							<td>'.$nm_barang.'
								<input class="form-control" type="hidden" name="kode_barang_dtl" id="kode_barang_dtl" value='.$item['kode_barang_dtl'].'/>
							</td>
							<td>'.$nm_satuan.'
								<input class="form-control" type="hidden" name="satuan_dtl" id="satuan_dtl" value='.$item['satuan_dtl'].'/>
							</td>
							<td style="text-align:right;">'.number_format($item['qty_satuan_dtl']).'</td>
							<td>'.$item['keterangan_dtl'].'</td>
							<td style="text-align:center">
								<a href="javascript:;" class="label label-danger hapus-bom" title="hapus data" data-id="'.$key.'"><i class="fa fa-times"></i>
								</a>           			
							</td>
						</tr>						
						';
			}
			
			$html .= "<script>$('.hapus-bom').click(function(){
						var id =	$(this).attr('data-id'); 
						var id_form = $('#id_form_edit1').val();
						$.ajax({
							type: 'POST',
							url: '".base_url()."ajax/j_barang.php?func=hapus-bom-edit',
							data: 'idhapus=' + id + '&id_form=' +id_form,
							cache: false,
							success:function(data){
								$('#detail_input_barang_edit').html(data).show();
							 }
						  });
					  });
				     </script>";
				
		} else {
			$html .= '<tr> <td colspan="15" class="text-center"> Tidak ada item barang. </td></tr>';
		}
		  
		return $html;
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "hapus-bom-edit" )
	{
		$id = $_POST['idhapus'];
		$id_form = $_POST['id_form'];
		$itemdelete = "DELETE FROM bom_tmp WHERE kode_barang_dtl = '".$id."' and id_form = '".$id_form."'";
		mysql_query($itemdelete);
		unset($_SESSION['data_barang_edit'][$id]);
		echo view_item_bom_edit($_SESSION['data_barang_edit']);
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "hapus-bom-edit-link" )
	{
		$id 	 = $_POST['id'];
		$id_form = $_POST['id_form'];
		$itemdelete = "DELETE FROM bom_tmp WHERE kode_barang_dtl = '".$id."' and id_form = '".$id_form."'";
		mysql_query($itemdelete);
		unset($_SESSION['data_barang_edit'][$id]);
		echo view_item_bom_edit($_SESSION['data_barang_edit']);
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save" )
	{

		mysqli_autocommit($con,FALSE);

		if(isset($_POST['jenis_stok'])){
			$jenis_stok_stat='1';	
		}else{
			$jenis_stok_stat='0';
		}

		$kode_inventori = $_POST['kode_inventori'];
		$nama 			= $_POST['nama'];
		$kategori 		= $_POST['kategori'];
		$satuan_beli 	= $_POST['satuan_beli'];
		$satuan_jual 	= $_POST['satuan_jual'];
		$isi 			= $_POST['jumlah_isi'];
		$jenis_stok 	= $jenis_stok_stat;
		$keterangan 	= $_POST['keterangan'];

		$qty_bom 		= $_POST['qty_hdr'];
		$satuan_bom 	= $_POST['satuan_hdr'];
		$keterangan_bom = $_POST['ket_hdr'];
		
		$tb_debet 		= $_POST['tb_debet'];
		$tb_kredit 		= $_POST['tb_kredit'];
		$sj_debet 		= $_POST['sj_debet'];
		$sj_kredit 		= $_POST['sj_kredit'];
		$fj_debet 		= $_POST['fj_debet'];
		$fj_kredit 		= $_POST['fj_kredit'];
		$fjl_debet 		= $_POST['fjl_debet'];
		$fjl_kredit 	= $_POST['fjl_kredit'];
		$rb_debet 		= $_POST['rb_debet'];
		$rb_kredit 		= $_POST['rb_kredit'];
		$rj_debet 		= $_POST['rj_debet'];
		$rj_kredit 		= $_POST['rj_kredit'];
		
		$tgl_input 		= date("Y-m-d H:i:s");
		
		
		$sql = "INSERT INTO inventori SET 
					kode_inventori		='".$kode_inventori."',  
					nama				='".$nama."', 
					kategori			='".$kategori."', 
					satuan_beli			='".$satuan_beli."', 
					satuan_jual			='".$satuan_jual."', 
					isi					='".$isi."', 
					jenis_stok			='".$jenis_stok."', 
					keterangan			='".$keterangan."', 
					qty_bom 			='".$qty_bom."',
					satuan_bom 			='".$satuan_bom."',
					keterangan_bom 		='".$keterangan_bom."',
					tb_debet			='".$tb_debet."', 
					tb_kredit			='".$tb_kredit."', 
					sj_debet			='".$sj_debet."', 
					sj_kredit			='".$sj_kredit."', 
					fj_debet			='".$fj_debet."', 
					fj_kredit			='".$fj_kredit."', 
					fjl_debet			='".$fjl_debet."', 
					fjl_kredit			='".$fjl_kredit."', 
					rb_debet			='".$rb_debet."', 
					rb_kredit			='".$rb_kredit."', 
					rj_debet			='".$rj_debet."', 
					rj_kredit			='".$rj_kredit."', 
					
					tgl_input			='".$tgl_input."' ";
		
		$query = mysqli_query($con,$sql) ;

		//DETAIL BOM
		$mySql1 = "INSERT INTO bom (kode_inventori, kode_barang_dtl, satuan_dtl, qty_dtl, keterangan_dtl, id_form) VALUES ";
		
		$array = $_SESSION['data_barang'];
			foreach($array as $key=>$item)
			{
				$no_inventori 	 = $kode_inventori;
				$kode_barang_dtl = $item['kode_barang_dtl'];
				$satuan_dtl 	 = $item['satuan_dtl'];
				$qty_dtl 		 = $item['qty_satuan_dtl'];
				$ket_dtl 		 = $item['keterangan_dtl'];
				$id_form 		 = $item['id_form'];

				$mySql1 .= "('{$no_inventori}','{$kode_barang_dtl}','{$satuan_dtl}','{$qty_dtl}','{$ket_dtl}','{$id_form}')";
				$mySql1 .= ",";
			}
				
				$mySql1 = rtrim($mySql1,",");
		$query1 = mysqli_query ($con,$mySql1) ;

		//DETAIL HARGA DISKON
		$harga 	= $_POST['harga'];
		$diskon = $_POST['diskon'];
		$kode_kategori_pelanggan = $_POST['kode_kategori_pelanggan'];
		$jumlah2 = count($kode_kategori_pelanggan);
		for($x=0;$x<$jumlah2;$x++){
			
			$mySql2= "INSERT INTO harga_inventori SET
						kode_inventori			='".$kode_inventori."', 
						harga					='".$harga[$x]."',
						diskon					='".$diskon[$x]."',
						kode_kategori_pelanggan	='".$kode_kategori_pelanggan[$x]."'";	
						   
			$query2 = mysqli_query ($con,$mySql2) ;				   
						   
		}		

		if ($query AND $query1 AND $query2) {
				
				// Commit transaction
				mysqli_commit($con);
				
				// Close connection
				mysqli_close($con);
				
				echo "00||".$kode_inventori;
				unset($_SESSION['data_barang']);
				
		} else { 
				
				echo "Gagal query: ".mysql_error();
		}	


	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "update" )
	{
		mysqli_autocommit($con,FALSE);

		if(isset($_POST['jenis_stok'])){
			$jenis_stok_stat='1';	
		}else{
			$jenis_stok_stat='0';
		}

		$kode_inventori = $_POST['kode_inventori'];
		$nama 			= $_POST['nama'];
		$kategori 		= $_POST['kategori'];
		$satuan_beli 	= $_POST['satuan_beli'];
		$satuan_jual 	= $_POST['satuan_jual'];
		$isi 			= $_POST['jumlah_isi'];
		$jenis_stok 	= $jenis_stok_stat;
		$keterangan 	= $_POST['keterangan'];

		$qty_bom 		= $_POST['qty_hdr'];
		$satuan_bom 	= $_POST['satuan_hdr'];
		$keterangan_bom = $_POST['ket_hdr'];
		
		$tb_debet 		= $_POST['tb_debet'];
		$tb_kredit 		= $_POST['tb_kredit'];
		$sj_debet 		= $_POST['sj_debet'];
		$sj_kredit 		= $_POST['sj_kredit'];
		$fj_debet 		= $_POST['fj_debet'];
		$fj_kredit 		= $_POST['fj_kredit'];
		$fjl_debet 		= $_POST['fjl_debet'];
		$fjl_kredit 	= $_POST['fjl_kredit'];
		$rb_debet 		= $_POST['rb_debet'];
		$rb_kredit 		= $_POST['rb_kredit'];
		$rj_debet 		= $_POST['rj_debet'];
		$rj_kredit 		= $_POST['rj_kredit'];
		
		$tgl_input 		= date("Y-m-d H:i:s");
		
		//HEADER	
		$sql = "UPDATE inventori SET 
				kode_inventori		 ='".$kode_inventori."',  
				nama				 ='".$nama."', 
				kategori			 ='".$kategori."', 
				satuan_beli			 ='".$satuan_beli."', 
				satuan_jual			 ='".$satuan_jual."', 
				isi					 ='".$isi."', 
				jenis_stok			 ='".$jenis_stok."', 
				keterangan			 ='".$keterangan."', 
				qty_bom 			 ='".$qty_bom."',
				satuan_bom 			 ='".$satuan_bom."',
				keterangan_bom 		 ='".$keterangan_bom."',
				tb_debet			 ='".$tb_debet."', 
				tb_kredit			 ='".$tb_kredit."', 
				sj_debet			 ='".$sj_debet."', 
				sj_kredit			 ='".$sj_kredit."', 
				fj_debet			 ='".$fj_debet."', 
				fj_kredit			 ='".$fj_kredit."', 
				fjl_debet			 ='".$fjl_debet."', 
				fjl_kredit			 ='".$fjl_kredit."', 
				rb_debet			 ='".$rb_debet."', 
				rb_kredit			 ='".$rb_kredit."', 
				rj_debet			 ='".$rj_debet."', 
				rj_kredit			 ='".$rj_kredit."',  
				
				tgl_input			 ='".$tgl_input."'
				WHERE kode_inventori = '".$kode_inventori."' ";
		
		$query = mysqli_query($con,$sql) ;
		
		//DETAIL BOM INVENTORI
		$array = $_SESSION['data_barang_edit'];
			foreach($array as $key=>$item){
				$id_form_dtl 		= $item['id_form'];
				$kode_bom_dtl 		= $item['kode_barang_dtl'];
				$satuan_bom_dtl 	= $item['satuan_dtl'];
				$qty_bom_dtl 		= $item['qty_satuan_dtl'];
				$keterangan_bom_dtl = $item['keterangan_dtl'];

				$hapusbomlama = mysql_query("DELETE FROM bom WHERE kode_barang_dtl = '".$kode_bom_dtl."' ");
				die($hapusbomlama);
				$mySql1 = "INSERT INTO bom SET 
							kode_inventori 		='".$kode_inventori."',
							kode_barang_dtl		='".$kode_bom_dtl."',
							satuan_dtl 			='".$satuan_bom_dtl."',
							qty_dtl 			='".$qty_bom_dtl."',
							keterangan_dtl		='".$keterangan_bom_dtl."',
							id_form 			='".$id_form_dtl."' ";	
				$query1 = mysqli_query ($con,$mySql1) ;

				$hapusbomtmp = mysql_query("DELETE FROM bom_tmp WHERE kode_barang_dtl = '".$kode_bom_dtl."' and id_form = '".$id_form_dtl."'");
			}
		

		//DETAIL HARGA DISKON
		$harga 	= $_POST['harga'];
		$diskon = $_POST['diskon'];
		$kode_kategori_pelanggan = $_POST['kode_kategori_pelanggan'];
		$jumlah2 = count($kode_kategori_pelanggan);
		for($x=0;$x<$jumlah2;$x++){
			
			$mySql2= "UPDATE INTO harga_inventori SET
						kode_inventori			='".$kode_inventori."', 
						harga					='".$harga[$x]."',
						diskon					='".$diskon[$x]."',
						kode_kategori_pelanggan	='".$kode_kategori_pelanggan[$x]."'";	
						   
			$query2 = mysqli_query ($con,$mySql2) ;				   
						   
		}		

		if ($query AND $query1 AND $query2) {
				mysql_query("DELETE FROM bom_tmp");
				// Commit transaction
				mysqli_commit($con);
				
				// Close connection
				mysqli_close($con);
				
				echo "00||".$kode_inventori;
				unset($_SESSION['data_barang_edit']);
				
		} else { 
				
				echo "Gagal query: ".mysql_error();
		}	


	}

?>