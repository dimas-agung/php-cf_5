<?php
	session_start();
	require('../library/conn.php');
	require('../library/helper.php');
	require ('../third_party/php-mailer/PHPMailerAutoload.php');
	date_default_timezone_set("Asia/Jakarta");
	
	 
	
	if( isset( $_REQUEST['keyword'] ) and $_REQUEST['keyword'] != "" )
	{

		$keyword		=		$_REQUEST['keyword'];
		$query			=		"SELECT * from permintaan_penawaran WHERE status = '0' and (nama_perusahaan LIKE '%$keyword%' or kode_pp LIKE '%$keyword%') limit 10";
		$result			=		mysql_query($query);
		$html			=		"";
		if(mysql_num_rows($result) > 0) {
			while ( $row	=		mysql_fetch_array($result) ) 
			{
				$html	.='<li data="'.$row['kode_pp'].'" data2="'.$row['nama_perusahaan'].'" data3="'.$row['up'].'">
							<span  class="left">'.$row['kode_pp'].' </span> 
							<span  class="right">'.$row['nama_perusahaan'].' | '.$row['up'].'</span> 
							</li>';
			}
		} 
		
		echo $html;
	}
	
	
//-------------------------Infrastrukture------------------------------------------////
	
		if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "addinfrastructure" )
	{
		if(isset($_POST['model']) and @$_POST['model'] != ""){
			$id_form=$_POST['id_form'];
			$qty = (is_numeric($_POST['jumlah']) ? $_POST['jumlah'] : "0");
			$qty = ($qty > 0 ? $qty : "0");
			$profit = ceil( $_POST['harga'] / ((100-$_POST['profit'])/100) );
			//$diskon = (($_POST['diskon']/100)*$profit);
			$diskon = ceil( $profit * ((100-$_POST['diskon'])/100) );
			$harga = ceil($diskon);
			
			if($_POST['profit']<$_POST['diskon']){
				echo '<script language="javascript">';
				echo 'alert("Profit lebih kecil atau sama dengan Diskon!!!")';
				echo '</script>';
				return false;
			
			}else{
			$itempn = "INSERT INTO infrastructure_dtl_tmp SET 
											model_item			='".$_POST['model']."',
											description_item    ='".$_POST['description']."',
											qty		    		='".$_POST['jumlah']."',
											satuan				='".$_POST['satuan']."',
											harga				='".$harga."',
											harga_hpp			='".$_POST['harga']."',
											profit				='".$profit."',
											diskon				='".$diskon."',
											id_profit			='".$_POST['profit']."',
											id_diskon			='".$_POST['diskon']."',
											note				='".$_POST['note']."',
											id_form				='".$id_form."' ";
			mysql_query($itempn);
			}
			
			$query			= "SELECT * FROM infrastructure_dtl_tmp WHERE id_form='".$id_form."'";
			$result			= mysql_query($query);
			$array = array();
			if(mysql_num_rows($result) > 0) {
				while ($res = mysql_fetch_array($result)) {
	
				if(!isset($_SESSION['data_infrastructure'.$id_form.''])) {
					$array[$res['id_penawaran_dtl']] = array('id' => $res['id_penawaran_dtl'],'model' => $res['model_item'], 'description' => $res['description_item'], 
							'jumlah' => $res['qty'], 'satuan' => $res['satuan'], 
							'harga' => $res['harga'],'profit' => $res['profit'], 
							'diskon' => $res['diskon'],'note' => $res['note'],'id_form' => $res['id_form'], 'id_diskon' => $res['id_diskon'],'id_profit' => $res['id_profit'],'harga_hpp' => $res['harga_hpp']);
				} else {
					$array = $_SESSION['data_infrastructure'.$id_form.''];
					
						$array[$res['id_penawaran_dtl']] = array('id' => $res['id_penawaran_dtl'],'model' => $res['model_item'], 'description' => $res['description_item'], 
							'jumlah' => $res['qty'], 'satuan' => $res['satuan'], 
							'harga' => $res['harga'],'profit' => $res['profit'], 
							'diskon' => $res['diskon'],'note' => $res['note'],'id_form' => $res['id_form'], 'id_diskon' => $res['id_diskon'],'id_profit' => $res['id_profit'],'harga_hpp' => $res['harga_hpp']);
					}
				}
				
			  
			}
				$_SESSION['data_infrastructure'.$id_form.''] = $array;
				echo view_item_infrastructure($array);
			 
		}
		
	}
		if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "editinfrastructure" )
	{
	if(isset($_POST['model']) and @$_POST['model'] != ""){
			$id_form=$_POST['id_form'];
		    $qty = (is_numeric($_POST['jumlah']) ? $_POST['jumlah'] : "0");
			$qty = ($qty > 0 ? $qty : "0");
			$profit = ceil( $_POST['harga'] / ((100-$_POST['profit'])/100) );
			//$diskon = (($_POST['diskon']/100)*$profit);
			$diskon = ceil( $profit * ((100-$_POST['diskon'])/100) );
			$harga = ceil($diskon);
			
			if($_POST['profit']<$_POST['diskon']){
				echo '<script language="javascript">';
				echo 'alert("Profit lebih kecil atau sama dengan Diskon!!!")';
				echo '</script>';
				return false;
			
			}else{
	
			$itempn2 = "UPDATE infrastructure_dtl_tmp SET 
											description_item      ='".$_POST['description']."',
											qty		    ='".$_POST['jumlah']."',
											satuan		='".$_POST['satuan']."',
											harga		='".$harga."',
											harga_hpp	='".$_POST['harga']."',
											profit		='".$profit."',
											diskon		='".$diskon."',
											id_profit	='".$_POST['profit']."',
											id_diskon	='".$_POST['diskon']."',
											note		='".$_POST['note']."'  WHERE id_penawaran_dtl ='".$_POST['id']."' AND id_form='".$id_form."' ";
			mysql_query($itempn2);
			}
			
			$query			= "SELECT * FROM infrastructure_dtl_tmp WHERE id_form='".$id_form."'";
			$result			= mysql_query($query);
			
			$array = array();
			if(mysql_num_rows($result) > 0) {
				while ($res = mysql_fetch_array($result)) {
					
						$array[$res['id_penawaran_dtl']] = array('id' => $res['id_penawaran_dtl'],'model' => $res['model_item'], 'description' => $res['description_item'], 
							'jumlah' => $res['qty'], 'satuan' => $res['satuan'], 
							'harga' => $res['harga'],'profit' => $res['profit'], 
							'diskon' => $res['diskon'],'note' => $res['note'],'id_form' => $res['id_form'], 'id_diskon' => $res['id_diskon'],'id_profit' => $res['id_profit'],'harga_hpp' => $res['harga_hpp']);
					}
				   
				
			}
			
			
				$_SESSION['data_infrastructure'.$id_form.''] = $array;
				echo view_item_infrastructure($array);
			 
		}
		
	}
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "hapus-infrastructure" )
	{
		$id = $_POST['idhapus'];
		$id_form=$_POST['id_form'];
		$itemdelete = "DELETE FROM infrastructure_dtl_tmp WHERE id_penawaran_dtl = '".$id."' ";
		mysql_query($itemdelete);
		unset($_SESSION['data_infrastructure'.$id_form.''][$id]);
		echo view_item_infrastructure($_SESSION['data_infrastructure'.$id_form.'']);
	}
	
	function view_item_infrastructure($data) {
		$n = 1;
		$html = "";
		$grandtotal = 0;
		if(count($data) > 0) {
			foreach($data as $key=>$item){
				$total = ($item['jumlah']*$item['harga']);
				$html .= '<tr><td>'.$n++.'</td>
					<td>'.$item['model'].'<input type="hidden" data-id="id_form" value='.$item['id_form'].' class="form-control" placeholder="id_form..."/></td>
					<td>'.$item['description'].'</td>
					<td class="jumlah_barang">'.$item['jumlah'].'</td>
					<td>'.$item['satuan'].'</td>
					<td>'.$item['note'].'</td>
					<td style="text-align:right">'.number_format($item['harga']).'</td>
					<td style="text-align:right">'.number_format($total).'</td>
					<td>
<!--					<a href="" class="label label-primary" data-toggle="modal"  data-target="#infrastructure"><i class="fa fa-plus-circle"></i></a> -->
					<a href="javascript:;" class="label label-info edit_infrastructure" data-toggle="modal" data-target="#edit_infrastructure" data-id="'.$item['id'].'"><i class="fa fa-pencil"></i></a>
					<a href="javascript:;" class="label label-danger hapus-cart-infrastructure" data-id="'.$key.'"><i class="fa fa-times"></i></a></td>
				</tr>';
				
				$grandtotal += ($total);
			}
			$html .= '<tr><td colspan="7" class="text-right"> <b> Total Nett Rp 
</b></td> <td style="text-align:right"><b>'.number_format($grandtotal, 0, ",", ".").'</b> <input type="hidden" value="'.$grandtotal.'" id="b_grand_total"></td></tr>';
			$html .= "<script>$('.hapus-cart-infrastructure').click(function(){
						var id =	$(this).attr('data-id'); 
						var id_form = $('#id_form').val();
						$.ajax({
							type: 'POST',
							url: '".base_url()."ajax/r_penawaran.php?func=hapus-infrastructure',
							data: 'idhapus=' + id + '&id_form=' +id_form,
							cache: false,
							success:function(data){
								$('#show-item-infrastructure').html(data).show();
							}
						});
					});
				  </script>";
		} else {
			$html .= '<tr> <td colspan="10" class="text-center"> Tidak ada item barang. </td></tr>';
		}
		
		$html  .= "<script>$('.edit_infrastructure').click(function(){
						var id =	$(this).attr('data-id'); 
						var id_form = $('#id_form').val();
						$.ajax({
							type: 'POST',
							url: '".base_url()."ajax/r_penawaran.php?func=edit_infrastructure',
							data: 'id=' + id + '&id_form=' +id_form,
							cache: false,
							success:function(data){
								$('#show-infrastructure-edit').html(data).show();
							}
						});
					});
				  </script>";
				  
		return $html;
	}
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "edit_infrastructure" ){
		
		$id				= $_POST['id'];
		$query			= "SELECT * from infrastructure_dtl_tmp WHERE id_penawaran_dtl = '".$id."' ";
		$result			= mysql_query($query);
		
		while ($res = mysql_fetch_array($result)) {
		echo ' <div class="col-md-12 pm-min">
                    <form role="form" method="post" action="" id="form-edit-infrastructure">
                        <div class="col-md-12 pm-min-s">
                            <div class="col-md-6 pm-min-s">
                        
                                <label class="control-label">Model</label>
                              
                                <input type="text" name="model" id="model" value='.$res['model_item'].'  placeholder="Model...." tabindex="1" class="form-control"/>
                                <input type="hidden" name="id" value='.$res['id_penawaran_dtl'].' id="id" class="form-control" placeholder="Input id"/> <input type="hidden" name="id_form" id="id_form" value='.$res['id_form'].' class="form-control" placeholder="Description..."/>
                           
                            </div>
                             
                            
                            <div class="col-md-6 pm-min-s">
                                <label class="control-label">Description</label>
                                <input type="text" name="description" value='.$res['description_item'].' id="description" class="form-control"/>
                                
                
                            </div>
                            
                            <div class="col-md-6 pm-min-s">
                            <label class="control-label">Jml</label>
                            <input type="number" name="jumlah" id="jumlah" value='.$res['qty'].' class="form-control" value="0" tabindex="3"/>
                             </div>
                              <div class="col-md-6 pm-min-s">
                            <label class="control-label">Satuan</label>
                            <input type="text" name="satuan" id="satuan" class="form-control" value='.$res['satuan'].'  tabindex="3"/>
                             </div>
                              <div class="col-md-6 pm-min-s">
                            <label class="control-label">Harga Hpp</label>
                            <input type="number" name="harga" id="harga" value='.$res['harga_hpp'].' class="form-control" value="0" tabindex="3"/>
                             </div>
                             <div class="col-md-6 pm-min-s">
                            <label class="control-label">Profit (%)</label>
                            <input type="number" name="profit" id="profit" value='.$res['id_profit'].' class="form-control" value="0" tabindex="3"/>
                             </div>
                             <div class="col-md-6 pm-min-s">
                            <label class="control-label">Diskon (%)</label>
                            <input type="number" name="diskon" id="diskon" value='.$res['id_diskon'].' class="form-control" value="0" tabindex="3"/>    
                             </div>
                            <div class="col-md-12 pm-min-s">
                            <label class="control-label">Note</label>
                             <textarea rows="5" class="form-control" name="note" value='.$res['note'].' id="note" placeholder="Note..."></textarea>
                             </div>
                             
                        </div>
                   
                    </form>
                    </div>
                               
															
												
												<div class="modal-footer">
                                               
                                                <button type="button" name="submit" class="btn btn-success edit-to-infrastructure" tabindex="4" data-dismiss="modal"><i class="fa fa-plus"></i> Tambah</button>
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												</div>';
	echo "<script>$('.edit-to-infrastructure').click(function(){
						var id =	$(this).attr('data-id'); 
						$.ajax({
							type: 'POST',
							url: '".base_url()."ajax/r_penawaran.php?func=editinfrastructure',
							data: $('#form-edit-infrastructure').serialize(),
							cache: false,
							success:function(data){
								$('#show-item-infrastructure').html(data).show();
								$('#model').val(''); $('#description').val('');
								$('#jumlah').val('0'); $('#harga').val('0');$('#satuan').val('');
								$('#profit').val(''); $('#diskon').val('');$('#note').val('');
							}
						});
					});
				  </script>";
		}
		
	
		
	}
	



//-------------------------Material------------------------------------------////	
	
		if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "addmaterial" )
	{
		if(isset($_POST['description']) and @$_POST['description'] != ""){
			$id_form=$_POST['id_form'];
			$qty = (is_numeric($_POST['jumlah']) ? $_POST['jumlah'] : "0");
			$qty = ($qty > 0 ? $qty : "0");
			$profit = ceil( $_POST['harga'] / ((100-$_POST['profit'])/100) );
			//$diskon = (($_POST['diskon']/100)*$profit);
			$diskon = ceil( $profit * ((100-$_POST['diskon'])/100) );
			$harga = ceil($diskon);
			
			if($_POST['profit']<$_POST['diskon']){
				echo '<script language="javascript">';
				echo 'alert("Profit lebih kecil atau sama dengan Diskon!!!")';
				echo '</script>';
				return false;
			
			}else{
			
			$itempn = "INSERT INTO material_dtl_tmp SET 
											description_item      ='".$_POST['description']."',
											qty		    ='".$_POST['jumlah']."',
											satuan		='".$_POST['satuan']."',
											harga		='".$harga."',
											harga_hpp	='".$_POST['harga']."',
											profit		='".$profit."',
											diskon		='".$diskon."',
											id_profit	='".$_POST['profit']."',
											id_diskon	='".$_POST['diskon']."',
											note		='".$_POST['note']."',
											id_form		='".$id_form."' ";
			mysql_query($itempn);
			}
			
			$query			= "SELECT * FROM material_dtl_tmp WHERE id_form='".$id_form."'";
			$result			= mysql_query($query);
			
			$array = array();
			if(mysql_num_rows($result) > 0) {
				while ($res = mysql_fetch_array($result)) {
			
				if(!isset($_SESSION['data_material'.$id_form.''])) {
					$array[$res['id_penawaran_dtl']] = array('id' => $res['id_penawaran_dtl'],'description' => $res['description_item'], 
							'jumlah' => $res['qty'], 'satuan' => $res['satuan'], 
							'harga' => $res['harga'],'profit' => $res['profit'], 
							'diskon' => $res['diskon'],'note' => $res['note'],'id_form' => $res['id_form'], 'id_diskon' => $res['id_diskon'],'id_profit' => $res['id_profit'],'harga_hpp' => $res['harga_hpp']);
				} else {
					$array = $_SESSION['data_material'.$id_form.''];
					
						$array[$res['id_penawaran_dtl']] = array('id' => $res['id_penawaran_dtl'],'description' => $res['description_item'], 
							'jumlah' => $res['qty'], 'satuan' => $res['satuan'], 
							'harga' => $res['harga'],'profit' => $res['profit'], 
							'diskon' => $res['diskon'],'note' => $res['note'],'id_form' => $res['id_form'], 'id_diskon' => $res['id_diskon'],'id_profit' => $res['id_profit'],'harga_hpp' => $res['harga_hpp']);
					}
				}
				
				
			}
				$_SESSION['data_material'.$id_form.''] = $array;
				echo view_item_material($array);
			 
		}
		
	}
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "editmaterial" )
	{
	if(isset($_POST['description']) and @$_POST['description'] != ""){
		
		    $qty = (is_numeric($_POST['jumlah']) ? $_POST['jumlah'] : "0");
			$id_form=$_POST['id_form'];
			$qty = ($qty > 0 ? $qty : "0");
			$profit = ceil( $_POST['harga'] / ((100-$_POST['profit'])/100) );
			//$diskon = (($_POST['diskon']/100)*$profit);
			$diskon = ceil( $profit * ((100-$_POST['diskon'])/100) );
			$harga = ceil($diskon);
			
			if($_POST['profit']<$_POST['diskon']){
				echo '<script language="javascript">';
				echo 'alert("Profit lebih kecil atau sama dengan Diskon!!!")';
				echo '</script>';
				return false;
			
			}else{
	
			$itempn2 = "UPDATE material_dtl_tmp SET 
											qty		    ='".$_POST['jumlah']."',
											satuan		='".$_POST['satuan']."',
											harga		='".$harga."',
											harga_hpp	='".$_POST['harga']."',
											profit		='".$profit."',
											diskon		='".$diskon."',
											id_profit	='".$_POST['profit']."',
											id_diskon	='".$_POST['diskon']."',
											note		='".$_POST['note']."'  WHERE id_penawaran_dtl ='".$_POST['id']."' AND id_form='".$id_form."' ";
			mysql_query($itempn2);
			}
			
			$query			= "SELECT * FROM material_dtl_tmp WHERE id_form='".$id_form."'";
			$result			= mysql_query($query);
			
			$array = array();
			if(mysql_num_rows($result) > 0) {
				while ($res = mysql_fetch_array($result)) {
					
						$array[$res['id_penawaran_dtl']] = array('id' => $res['id_penawaran_dtl'],'description' => $res['description_item'], 
							'jumlah' => $res['qty'], 'satuan' => $res['satuan'], 
							'harga' => $res['harga'],'profit' => $res['profit'], 
							'diskon' => $res['diskon'],'note' => $res['note'],'id_form'=>$res['id_form'], 'id_diskon' => $res['id_diskon'],'id_profit' => $res['id_profit'],'harga_hpp' => $res['harga_hpp']);
					}
				   
				
			}
			
			
				$_SESSION['data_material'.$id_form.''] = $array;
				echo view_item_material($array);
			 
		}
		
	}
	
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "hapus-material" )
	{
		$id = $_POST['idhapus'];
		$id_form=$_POST['id_form'];
		$itemdelete = "delete from material_dtl_tmp where id_penawaran_dtl = '".$id."'";
		mysql_query($itemdelete);
		unset($_SESSION['data_material'.$id_form.''][$id]);
		echo view_item_material($_SESSION['data_material'.$id_form.'']);
	}
	
	function view_item_material($data) {
		$n = 1;
		$html = "";
		$grandtotal = 0;
		if(count($data) > 0) {
			foreach($data as $key=>$item){
				$total = ($item['jumlah']*$item['harga']);
				$html .= '<tr><td>'.$n++.'</td>
					<td>'.$item['description'].'<input type="hidden" data-id="id_form" value='.$item['id_form'].' class="form-control" placeholder="id_form..."/></td>
					<td class="jumlah_barang">'.$item['jumlah'].'</td>
					<td>'.$item['satuan'].'</td>
					<td>'.$item['note'].'</td>
					<td style="text-align:right">'.number_format($item['harga']).'</td>
					<td style="text-align:right">'.number_format($total).'</td>
					<td>
<!--					<a href="" class="label label-primary" data-toggle="modal"  data-target="#material"><i class="fa fa-plus-circle"></i></a> -->
					<a href="javascript:;" class="label label-info edit_material" data-toggle="modal" data-target="#edit_material" data-id="'.$item['id'].'"><i class="fa fa-pencil"></i></a>
					<a href="javascript:;" class="label label-danger hapus-cart-material" data-id="'.$key.'"><i class="fa fa-times"></i></a></td>
				</tr>';
				
				$grandtotal += ($total);
			}
			$html .= '<tr><td colspan="6" class="text-right"> <b> Total Nett Rp 
</b></td> <td style="text-align:right"><b>'.number_format($grandtotal, 0, ",", ".").'</b> <input type="hidden" value="'.$grandtotal.'" id="b_grand_total"></td></tr>';
			$html .= "<script>$('.hapus-cart-material').click(function(){
						var id =	$(this).attr('data-id'); 
						var id_form = $('#id_form').val();
						$.ajax({
							type: 'POST',
							url: '".base_url()."ajax/r_penawaran.php?func=hapus-material',
							data: 'idhapus=' + id + '&id_form=' +id_form,
							cache: false,
							success:function(data){
								$('#show-item-material').html(data).show();
							}
						});
					});
				  </script>";
		} else {
			$html .= '<tr> <td colspan="10" class="text-center"> Tidak ada item barang. </td></tr>';
		}
		$html  .= "<script>$('.edit_material').click(function(){
						var id =	$(this).attr('data-id'); 
						var id_form = $('#id_form').val();
						$.ajax({
							type: 'POST',
							url: '".base_url()."ajax/r_penawaran.php?func=edit_material',
							data: 'id=' + id + '&id_form=' +id_form,
							cache: false,
							success:function(data){
								$('#show-material-edit').html(data).show();
							}
						});
					});
				  </script>";
				  
		return $html;
	}
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "edit_material" ){
		
		$id				= $_POST['id'];
		$query			= "SELECT * from material_dtl_tmp WHERE id_penawaran_dtl like '".$id."' ";
		$result			= mysql_query($query);
		
		while ($res = mysql_fetch_array($result)) {
		echo ' <div class="col-md-12 pm-min">
                    <form role="form" method="post" action="" id="form-edit-material">
                        <div class="col-md-12 pm-min-s">
                            
                             
                            
                            <div class="col-md-6 pm-min-s">
                                <label class="control-label">Description</label>
                                <input type="text" name="description" value='.$res['description_item'].' id="description" class="form-control"/>
                                 <input type="hidden" name="id" value='.$res['id_penawaran_dtl'].' id="id" class="form-control" placeholder="Input id"/> <input type="hidden" name="id_form" id="id_form" value='.$res['id_form'].' class="form-control" placeholder="Description..."/>
                
                            </div>
                            
                            <div class="col-md-6 pm-min-s">
                            <label class="control-label">Jml</label>
                            <input type="number" name="jumlah" id="jumlah" value='.$res['qty'].' class="form-control" value="0" tabindex="3"/>
                             </div>
                              <div class="col-md-6 pm-min-s">
                            <label class="control-label">Satuan</label>
                            <input type="text" name="satuan" id="satuan" class="form-control" value='.$res['satuan'].'  tabindex="3"/>
                             </div>
                              <div class="col-md-6 pm-min-s">
                            <label class="control-label">Harga Hpp</label>
                            <input type="number" name="harga" id="harga" value='.$res['harga_hpp'].' class="form-control" value="0" tabindex="3"/>
                             </div>
							 
                             <div class="col-md-6 pm-min-s">
                            <label class="control-label">Profit (%)</label>
                            <input type="number" name="profit" id="profit" value='.$res['id_profit'].' class="form-control" value="0" tabindex="3"/>
                             </div>
							 
                             <div class="col-md-6 pm-min-s">
                            <label class="control-label">Diskon (%)</label>
                            <input type="number" name="diskon" id="diskon" value='.$res['id_diskon'].' class="form-control" value="0" tabindex="3"/>    
                             </div>
							 
                            <div class="col-md-12 pm-min-s">
                            <label class="control-label">Note</label>
                             <textarea rows="5" class="form-control" name="note" value='.$res['note'].' id="note" placeholder="Note..."></textarea>
                             </div>
                             
                        </div>
                   
                    </form>
                    </div>
                               
															
												
												<div class="modal-footer">
                                               
                                                <button type="button" name="submit" class="btn btn-success edit-to-material" tabindex="4" data-dismiss="modal"><i class="fa fa-plus"></i> Tambah</button>
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												</div>';
	echo "<script>$('.edit-to-material').click(function(){
						var id =	$(this).attr('data-id'); 
						$.ajax({
							type: 'POST',
							url: '".base_url()."ajax/r_penawaran.php?func=editmaterial',
							data: $('#form-edit-material').serialize(),
							cache: false,
							success:function(data){
								$('#show-item-material').html(data).show();
							    $('#description').val('');
								$('#jumlah').val('0'); $('#harga').val('0');$('#satuan').val('');
								$('#profit').val(''); $('#diskon').val('');$('#note').val('');
							}
						});
					});
				  </script>";
		}
		
	
		
	}
	
	//-------------------------Jasa------------------------------------------////	
	
		if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "addjasa" )
	{
		if(isset($_POST['description']) and @$_POST['description'] != ""){
			$id_form=$_POST['id_form'];
			$qty = (is_numeric($_POST['jumlah']) ? $_POST['jumlah'] : "0");
			$qty = ($qty > 0 ? $qty : "0");
			/*$profit = ( $_POST['harga'] * (($_POST['profit']+100)/100) );
			//$diskon = (($_POST['diskon']/100)*$profit);
			$diskon = ( $_POST['harga'] / (($_POST['diskon']+100)/100) );
			$harga = ($profit-$diskon);
			
			if($_POST['profit']<$_POST['diskon']){
				echo '<script language="javascript">';
				echo 'alert("Profit lebih kecil atau sama dengan Diskon!!!")';
				echo '</script>';
				return false;
			
			}else{ */
			
			$itempn = "INSERT INTO jasa_dtl_tmp SET 
											description_item    ='".$_POST['description']."',
											qty		    		='".$_POST['jumlah']."',
											satuan				='".$_POST['satuan']."',
											harga				='".$_POST['harga']."',
											kd_jasa				='".$_POST['kd_jasa']."',
											id_form				='".$id_form."'
											";
			mysql_query($itempn);
			
			
			$query			= "SELECT * FROM jasa_dtl_tmp WHERE id_form='".$id_form."'";
			$result			= mysql_query($query);
			
			$array = array();
			if(mysql_num_rows($result) > 0) {
				while ($res = mysql_fetch_array($result)) {
			
				if(!isset($_SESSION['data_jasa'.$id_form.''])) {
					$array[$res['id_penawaran_dtl']] = array('id' => $res['id_penawaran_dtl'],'description' => $res['description_item'], 
							'jumlah' => $res['qty'], 'satuan' => $res['satuan'], 'harga' => $res['harga'], 'kd_jasa' => $res['kd_jasa'], 'id_form' => $res['id_form'] );
				} else {
					$array = $_SESSION['data_jasa'.$id_form.''];
					
						$array[$res['id_penawaran_dtl']] = array('id' => $res['id_penawaran_dtl'],'description' => $res['description_item'], 
							'jumlah' => $res['qty'], 'satuan' => $res['satuan'], 'harga' => $res['harga'], 'kd_jasa' => $res['kd_jasa'], 'id_form' => $res['id_form']);
					}
				}
			  
				
			}
				$_SESSION['data_jasa'.$id_form.''] = $array;
				echo view_item_jasa($array);
			 
		}
		
	}
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "editjasa" )
	{
	if(isset($_POST['description']) and @$_POST['description'] != ""){
		
		    $qty = (is_numeric($_POST['jumlah']) ? $_POST['jumlah'] : "0");
			$qty = ($qty > 0 ? $qty : "0");
			$profit = ( $_POST['harga'] * (($_POST['profit']+100)/100) );
			//$diskon = (($_POST['diskon']/100)*$profit);
			$diskon = ( $_POST['harga'] / (($_POST['diskon']+100)/100) );
			$harga = ($profit-$diskon);
			
			if($_POST['profit']<$_POST['diskon']){
				echo '<script language="javascript">';
				echo 'alert("Profit lebih kecil atau sama dengan Diskon!!!")';
				echo '</script>';
				return false;
			
			}else{
	
			$itempn2 = "UPDATE jasa_dtl_tmp SET 
											qty		    ='".$_POST['jumlah']."',
											satuan		='".$_POST['satuan']."',
											harga		='".$harga."',
											harga_hpp	='".$_POST['harga']."',
											profit		='".$profit."',
											diskon		='".$diskon."',
											note		='".$_POST['note']."',
											kd_jasa		='".$_POST['kd_jasa']."'  WHERE id_penawaran_dtl ='".$_POST['id']."' ";
			mysql_query($itempn2);
			}
			
			$query			= "SELECT * from jasa_dtl_tmp";
			$result			= mysql_query($query);
			
			$array = array();
			if(mysql_num_rows($result) > 0) {
				while ($res = mysql_fetch_array($result)) {
					
						$array[$res['description_item']] = array('id' => $res['id_penawaran_dtl'], 'description' => $res['description_item'], 
							'jumlah' => $res['qty'], 'satuan' => $res['satuan'], 
							'harga' => $res['harga'],'profit' => $res['profit'], 
							'diskon' => $res['diskon'],'note' => $res['note']);
					}
				   
				
			}
			
			
				$_SESSION['data_jasa'] = $array;
				echo view_item_jasa($array);
			 
		}
		
	}
	
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "hapus-jasa" )
	{
		$id = $_POST['idhapus'];
		$id_form=$_POST['id_form'];
		$itemdelete = "DELETE FROM jasa_dtl_tmp WHERE id_penawaran_dtl = '".$id."'";
		mysql_query($itemdelete);
		unset($_SESSION['data_jasa'.$id_form.''][$id]);
		echo view_item_jasa($_SESSION['data_jasa'.$id_form.'']);
	}
	
	function view_item_jasa($data) {
		$n = 1;
		$html = "";
		$grandtotal = 0;
		if(count($data) > 0) {
			foreach($data as $key=>$item){
				$total = ($item['jumlah']*$item['harga']);
				$html .= '<tr><td>'.$n++.'</td>
					<td>'.$item['description'].'<input type="hidden" data-id="id_form" value='.$item['id_form'].' class="form-control" placeholder="id_form..."/></td>
					<td class="jumlah_barang">'.$item['jumlah'].'</td>
					<td>'.$item['satuan'].'</td>
					<td style="text-align:right">'.number_format($item['harga']).'</td>
					<td style="text-align:right">'.number_format($total).'</td>
					<td>
<!--					<a href="" class="label label-primary" data-toggle="modal"  data-target="#jasa"><i class="fa fa-plus-circle"></i></a>
					<a href="javascript:;" class="label label-info edit_jasa" data-toggle="modal" data-target="#edit_jasa" data-id="'.$item['id'].'"><i class="fa fa-pencil"></i></a> -->
					<a href="javascript:;" class="label label-danger hapus-cart-jasa" data-id="'.$key.'"><i class="fa fa-times"></i></a></td>
				</tr>';
				
				$grandtotal += ($total);
			}
			if(!empty($_SESSION['data_infrastructure'.$item['id_form'].''])){
			$array = $_SESSION['data_infrastructure'.$item['id_form'].''];
			}
			$grandtotal1 =0;
				if(isset($array)){
					foreach($array as $key=>$item){
						$total1 = ($item['jumlah']*$item['harga']);
						$grandtotal1 += ($total1);
					}
				}else{
					$total1 = 0;
					$grandtotal1 += ($total1);
				}
				
			if(!empty($_SESSION['data_infrastructure'.$item['id_form'].''])){	
			$array = $_SESSION['data_material'.$item['id_form'].''];
			}
			$grandtotal2 =0;
				if(isset($array)){
					foreach($array as $key=>$item){
						$total2 = ($item['jumlah']*$item['harga']);
						$grandtotal2 += ($total2);
					}
				}else{
					$total2 = 0;
					$grandtotal2 += ($total2);
				}
				
			$grandtotalutama = ($grandtotal+$grandtotal1+$grandtotal2);
			
			$html .= '<tr><td colspan="5" class="text-right"> <b> Total Nett Rp 
</b></td> <td style="text-align:right"><b>'.number_format($grandtotal, 0, ",", ".").'</b> <input type="hidden" value="'.$grandtotal.'" id="b_grand_total"></td></tr>';
			
			$html .= "<script>$('.hapus-cart-jasa').click(function(){
						var id =	$(this).attr('data-id'); 
						var id_form = $('#id_form').val();
						$.ajax({
							type: 'POST',
							url: '".base_url()."ajax/r_penawaran.php?func=hapus-jasa',
							data: 'idhapus=' + id + '&id_form=' +id_form,
							cache: false,
							success:function(data){
								$('#show-item-jasa').html(data).show();
							}
						});
					});
				  </script>";
		} else {
			$html .= '<tr> <td colspan="10" class="text-center"> Tidak ada item barang. </td></tr>';
		}
		$html  .= "<script>$('.edit_jasa').click(function(){
						var id =	$(this).attr('data-id'); 
						$.ajax({
							type: 'POST',
							url: '".base_url()."ajax/r_penawaran.php?func=edit_jasa',
							data: 'id=' + id,
							cache: false,
							success:function(data){
								$('#show-jasa-edit').html(data).show();
							}
						});
					});
				  </script>";
		return $html;
	}
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "edit_jasa" ){
		
		$id				= $_POST['id'];
		$query			= "SELECT * FROM jasa_dtl_tmp WHERE id_penawaran_dtl = '".$id."' ";
		$result			= mysql_query($query);
		
		while ($res = mysql_fetch_array($result)) {
		echo ' <div class="col-md-12 pm-min">
                    <form role="form" method="post" action="" id="form-edit-jasa">
                        <div class="col-md-12 pm-min-s">
                            
                            <div class="col-md-12 pm-min-s">
                                <label class="control-label">Kode Jasa</label>
                                
                                <input type="text" name="id_form" id="id_form" value="'.$res['id_form'].'"/> 
								<input type="text" name="id" id="id" value="'.$res['id_penawaran_dtl'].'"/> 
								<input type="text" name="kd_jasa" id="kd_jasa" value="'.$res['kd_jasa'].'" readonly class="form-control"/>
                                
                
                            </div>
                            
                            <div class="col-md-6 pm-min-s">
                                <label class="control-label">Description</label>
                                <input type="text" name="description" id="description2" value="'.$res['description_item'].'" readonly class="form-control"/>
                                
                
                            </div>
                            
                            <div class="col-md-6 pm-min-s">
                            <label class="control-label">Jml</label>
                            <input type="number" name="jumlah" id="jumlah2" class="form-control" value="'.$res['qty'].'" tabindex="3"/>
                             </div>
                              <div class="col-md-6 pm-min-s">
                            <label class="control-label">Satuan</label>
                            <input type="text" name="satuan" id="satuan2" class="form-control" value="'.$res['satuan'].'"  tabindex="3"/>
                             </div>
                              <div class="col-md-6 pm-min-s">
                            <label class="control-label">Harga</label>
                            <input type="number" name="harga" id="harga2" readonly class="form-control" value="'.$res['harga'].'" tabindex="3"/>
                             </div>
                            
                             
                        </div>
                   
                    </form>
                    </div>
                               
															
												
												<div class="modal-footer">
                                               
                                                <button type="button" name="submit" class="btn btn-success edit-to-jasa" tabindex="4" data-dismiss="modal"><i class="fa fa-plus"></i> Tambah</button>
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												</div>';
	echo "<script>$('.edit-to-jasa').click(function(){
						var id =	$(this).attr('data-id'); 
						$.ajax({
							type: 'POST',
							url: '".base_url()."ajax/r_penawaran.php?func=editjasa',
							data: $('#form-edit-jasa').serialize(),
							cache: false,
							success:function(data){
								$('#show-item-jasa').html(data).show();
							    $('#description').val('');
								$('#jumlah').val('0'); $('#harga').val('0');$('#satuan').val('');
								$('#profit').val(''); $('#diskon').val('');$('#note').val('');
							}
						});
					});
				  </script>";
		}
		
	
		
	}
	
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save" ){
		$mail = new PHPMailer;
		//From email address and name
		//$mail->SMTPDebug = 2;                                 // Enable verbose debug output
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'mail.lotusolusi.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'adminprogram@lotusolusi.com';          // SMTP username
		$mail->Password = 'dargombes123';                   // SMTP password
		$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 465;                                    // TCP port to connect to
		$mail->setFrom('adminprogram@lotusolusi.com', 'Lotus');
		$mail->isHTML(true);

		$id_form=$_POST['id_form'];
		if((isset($_SESSION['data_infrastructure'.$id_form.'']) and count($_SESSION['data_infrastructure'.$id_form.''] > 0)) or (isset($_SESSION['data_material'.$id_form.'']) and count($_SESSION['data_material'.$id_form.''] > 0)) or (isset($_SESSION['data_jasa'.$id_form.'']) and count($_SESSION['data_jasa'.$id_form.'']) > 0)) {
			$id_form=$_POST['id_form'];
			$id = $_POST['kode_penawaran'];
			$token = $_POST['token'];
			$tanggal	= date("Y-m-d",strtotime($_POST['tanggal']));
			$perilah1	= $_POST['perihal1'];
			$perilah2	= $_POST['perihal2'];
			$perilah3	= $_POST['perihal3'];
			$versi 		= buatOpsi($id);
			$kepada = $_POST['nama_perusahaan'];
			$up = $_POST['up'];
			// Membuat kode penawaran
          	$kd_penawaran = buat_no_penawaran($id, $tanggal);
			$mySql	= "INSERT INTO penawaran_hdr SET 
						kode_penawaran	='".$kd_penawaran."',
						kode_pp			='".$id."', 
						versi			='".$versi."',
						dengan_hormat	='".$_POST['dengan_hormat']."', 
						tanggal			='".$tanggal."',
						kepada			='".$_POST['nama_perusahaan']."',
						Up				='".$_POST['up']."',
						perihal			='".$_POST['perihal']."',
						note			='".$_POST['note']."',
						token			='".$token."',
						status 			= '0' ";	
						
	
		$mail->addAddress('ulumovic@gmail.com', 'Puterako');     // Add a recipient
    	$mail_body = <<<EOT
    	<div>
	
			<style type='text/css'>
				.form-data {
					margin-bottom:1mm;
				}
				* {
					font-family:sans-serif;
				}
				.form-head {
					padding:10mm;
					border:1px solid black
				}
			</style>

			<div class="form-head" style="border:1px solid black;padding:10mm">
				<html>
					<body>
						
						   <h1> PENAWARAN MENUNGGU DISETUJUI </h1>
						   
							<table style='border-style:none' width='100%'>
								<thead>
								<tr>
									<td width='17%'>Kode PP</td>
									<td width='2%'>:</td>
									<td>$id</td> 
								</tr>
								<tr>
									<td>Kode Penawaran</td>
									<td>:</td>
									<td>$kd_penawaran</td> 
								</tr>
								<tr>
									<td>Tanggal</td>
									<td>:</td>
									<td>$tanggal</td> 
								</tr>
								
								<tr>
									<td>Kepada</td>
									<td>:</td>
									<td>$kepada</td> 
								</tr>
								<tr>
									<td>Up</td>
									<td>:</td>
									<td>$up</td> 
								</tr>
								</thead>
								</table> 
								
								<h3><a href="http://lotusolusi.com/puterako/?page=approval/index"> Lihat Detail</a> </h3>
								
					</body>
				</html> 
			</div>
		</div>
EOT;
    $mail->Subject = "Approval Penawaran";
	$mail->Body = $mail_body;
	$mail->AltBody = "View in HTML Mode or visit " . base_url() . '?page=approval/index';
	
	  

			if(!$mail->send()) 
			{
				echo "Mailer Error: " . $mail->ErrorInfo;
			} 
			
				
			if(mysql_query($mySql)) {
				$array = $_SESSION['data_infrastructure'.$id_form.''];
				$total_in=0;
				$grand_totalin=0;
				foreach($array as $key=>$item){
					$totalin =($item['jumlah']*$item['harga']);
					$grand_totalin += $totalin;
					$itemSql1 = "INSERT INTO penawaran_dtl SET 
											kode_penawaran	='".$kd_penawaran."', 
											jenis_barang	='".$perilah1."', 
											urutan_jb	='1',
											model_item	='".$item['model']."',
											description_item ='".$item['description']."',
											qty		='".$item['jumlah']."',
											satuan		='".$item['satuan']."',
											harga		='".$item['harga']."',
											harga_hpp	='".$item['harga_hpp']."',
											profit		='".$item['profit']."',
											id_profit	='".$item['id_profit']."',
											diskon		='".$item['diskon']."',
											id_diskon	='".$item['id_diskon']."',
											note		='".$item['note']."',
											total		='".$totalin."',
											aktif		='0',
											token		='".$token."' ";
				 mysql_query($itemSql1);
				}
				
						$array = $_SESSION['data_material'.$id_form.''];
						$totalma = 0;
						$grand_totalma=0;	
				        foreach($array as $key=>$item){
					    $totalma =($item['jumlah']*$item['harga']);
						$grand_totalma += $totalma;
						$itemSql2 = "INSERT INTO penawaran_dtl SET 
												kode_penawaran	='".$kd_penawaran."', 
												jenis_barang	='".$perilah2."', 
												urutan_jb	='2',
												description_item ='".$item['description']."',
												qty		='".$item['jumlah']."',
												satuan		='".$item['satuan']."',
												harga		='".$item['harga']."',
												harga_hpp	='".$item['harga_hpp']."',
												profit		='".$item['profit']."',
												id_profit	='".$item['id_profit']."',
											    diskon		='".$item['diskon']."',
												id_diskon	='".$item['id_diskon']."',
												note		='".$item['note']."',
												total		='".$totalma."',
												aktif		='0',
												token		='".$token."' ";
				mysql_query($itemSql2);
						}
					    $array = $_SESSION['data_jasa'.$id_form.''];
						$totaljs = 0;
	        			$grand_totaljs = 0;	
						foreach($array as $key=>$item){
					    $totaljs =($item['jumlah']*$item['harga']);
						$grand_totaljs += $totaljs;
						$itemSql3 = "INSERT INTO penawaran_dtl SET 
												kode_penawaran	='".$kd_penawaran."', 
												jenis_barang	='".$perilah3."',
												urutan_jb	='3', 
												description_item ='".$item['description']."',
												qty		='".$item['jumlah']."',
												satuan		='".$item['satuan']."',
												harga		='".$item['harga']."',
												profit		='".$item['profit']."',
											    diskon		='".$item['diskon']."',
												note		='".$item['note']."',
												total		='".$totaljs."',
												aktif		='0',
												kd_jasa		='".$item['kd_jasa']."',
												token		='".$token."' ";
					
				mysql_query($itemSql3);
				
						$updkd_jasa = "UPDATE fjasa_hdr SET status='1' WHERE kd_jasa = '".$item['kd_jasa']."' ";
						mysql_query($updkd_jasa);
				      }
					  $grand_totalutama = ($grand_totalin+$grand_totalma+$grand_totaljs);
					  $diskonhdr =ceil(($_POST['diskon_utama']/100)*$grand_totalutama);
					  $grand_total = (($grand_totalutama)-($diskonhdr));
					  $grand_totalppn = ceil($grand_total*(10/100));
					  $grand_totalakhir = $grand_total+$grand_totalppn;
					  $ppn = (@$_POST['ppn'] == 1)? 1 : 0;
					  if ($ppn==1) {
				      $mySql1234	= "Update penawaran_hdr SET 
						sub_total	='".$grand_totalutama."', 
						diskon_hdr	='".$diskonhdr."',
						ppn	='".$grand_totalppn."',
						diskon_persen	='".$_POST['diskon_utama']."',
						grand_total	='".$grand_totalakhir."' WHERE kode_penawaran = '".$kd_penawaran."' ";	
					  mysql_query($mySql1234);
					  }else {
						  $mySql1234	= "Update penawaran_hdr SET 
						sub_total	='".$grand_totalutama."',
						diskon_hdr	='".$diskonhdr."', 
						ppn	='0',
						grand_total	='".$grand_total."' WHERE kode_penawaran = '".$kd_penawaran."' ";	
					  mysql_query($mySql1234);}
					  $statusupdatepp = "UPDATE permintaan_penawaran SET status = '1' WHERE kode_pp ='".$id."'";
					  mysql_query($statusupdatepp);
				
				}
				//echo "00||".$id;
								
				unset($_SESSION['data_infrastructure'.$id_form.'']);
				unset($_SESSION['data_material'.$id_form.'']);
				unset($_SESSION['data_jasa'.$id_form.'']);
				
			} else {echo "Gagal query: ".mysql_error();
			}
			
	}
		
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "edit" ){
		$mail = new PHPMailer;
		//From email address and name
		//$mail->SMTPDebug = 2;                                 // Enable verbose debug output
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'mail.lotusolusi.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'adminprogram@lotusolusi.com';          // SMTP username
		$mail->Password = 'dargombes123';                   // SMTP password
		$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 465;                                    // TCP port to connect to
		$mail->setFrom('adminprogram@lotusolusi.com', 'Lotus');
		$mail->isHTML(true);
		
		$id_form=$_POST['id_form'];
		if((isset($_SESSION['data_infrastructure'.$id_form.'']) and count($_SESSION['data_infrastructure'.$id_form.''] > 0)) or (isset($_SESSION['data_material'.$id_form.'']) and count($_SESSION['data_material'.$id_form.''] > 0)) or (isset($_SESSION['data_jasa'.$id_form.'']) and count($_SESSION['data_jasa'.$id_form.'']) > 0)) {
			$id_form=$_POST['id_form'];
			$id = $_POST['kode_penawaran'];
			$token = $_POST['token'];
			$tanggal	= date("Y-m-d",strtotime($_POST['tanggal']));
			$perilah1	= $_POST['perihal1'];
			$perilah2	= $_POST['perihal2'];
			$perilah3	= $_POST['perihal3'];
			$kd_penawaran	= $_POST['kd_penawaran'];
			$kepada = $_POST['nama_perusahaan'];
			$up = $_POST['up'];
			
			// membuat ref / kode referensi
			$cmd = "SELECT COUNT(id_penawaran) AS kode_ref FROM penawaran_hdr WHERE kode_penawaran='$kd_penawaran' AND versi='".$_POST['versi']."'";
			$go = mysql_query($cmd);
			$resp = mysql_fetch_array($go);
			$ref = $resp['kode_ref'];
			
			$mySql	= "INSERT INTO penawaran_hdr SET 
						kode_penawaran	='".$kd_penawaran."',
						kode_pp			='".$id."', 
						ref				='".$ref."',
						versi			='".$_POST['versi']."',
						dengan_hormat	='".$_POST['dengan_hormat']."', 
						tanggal			='".$tanggal."',
						kepada			='".$_POST['nama_perusahaan']."',
						Up				='".$_POST['up']."',
						perihal			='".$_POST['perihal']."',
						note			='".$_POST['note']."',
						token			='".$token."',
						status 			= '0' ";	
			
			//NON AKTIFKAN PENAWARAN LAMA YG DIEDIT			
			$upd_rev = "UPDATE penawaran_hdr SET aktif='0' WHERE kode_penawaran='".$kd_penawaran."' AND token='".$_POST['token_lawas']."'";		
			
		$mail->addAddress('ulumovic@gmail.com', 'Puterako');     // Add a recipient
    	$mail_body = <<<EOT
    	<div>
	
			<style type='text/css'>
				.form-data {
					margin-bottom:1mm;
				}
				* {
					font-family:sans-serif;
				}
				.form-head {
					padding:10mm;
					border:1px solid black
				}
			</style>

			<div class="form-head" style="border:1px solid black;padding:10mm">
				<html>
					<body>
						
						   <h1> PENAWARAN MENUNGGU DISETUJUI </h1>
						   
							<table style='border-style:none' width='100%'>
								<thead>
								<tr>
									<td width='17%'>Kode PP</td>
									<td width='2%'>:</td>
									<td>$id</td> 
								</tr>
								<tr>
									<td>Kode Penawaran</td>
									<td>:</td>
									<td>$kd_penawaran</td> 
								</tr>
								<tr>
									<td>Tanggal</td>
									<td>:</td>
									<td>$tanggal</td> 
								</tr>
								
								<tr>
									<td>Kepada</td>
									<td>:</td>
									<td>$kepada</td> 
								</tr>
								<tr>
									<td>Up</td>
									<td>:</td>
									<td>$up</td> 
								</tr>
								</thead>
								</table> 
								
								<h3><a href="http://lotusolusi.com/puterako/?page=approval/index"> Lihat Detail</a> </h3>
								
					</body>
				</html> 
			</div>
		</div>
EOT;
    $mail->Subject = "Approval Penawaran";
	$mail->Body = $mail_body;
	$mail->AltBody = "View in HTML Mode or visit " . base_url() . '?page=approval/index';
	
	  

			if(!$mail->send()) 
			{
				echo "Mailer Error: " . $mail->ErrorInfo;
			} 
						
			if(mysql_query($mySql)) {
				
				mysql_query($upd_rev);
				
				$array = $_SESSION['data_infrastructure'.$id_form.''];
				$total_in=0;
				$grand_totalin=0;
				foreach($array as $key=>$item){
					$totalin =($item['jumlah']*$item['harga']);
					$grand_totalin += $totalin;
					$itemSql1 = "INSERT INTO penawaran_dtl SET 
											kode_penawaran	='".$kd_penawaran."', 
											jenis_barang	='".$perilah1."', 
											urutan_jb	='1',
											model_item	='".$item['model']."',
											description_item ='".$item['description']."',
											qty		='".$item['jumlah']."',
											satuan		='".$item['satuan']."',
											harga		='".$item['harga']."',
											harga_hpp	='".$item['harga_hpp']."',
											profit		='".$item['profit']."',
											id_profit	='".$item['id_profit']."',
											diskon		='".$item['diskon']."',
											id_diskon	='".$item['id_diskon']."',
											note		='".$item['note']."',
											total		='".$totalin."',
											aktif		='0',
											token		='".$token."' ";
				 mysql_query($itemSql1);
				}
				
						$array = $_SESSION['data_material'.$id_form.''];
						$totalma = 0;
						$grand_totalma=0;	
				        foreach($array as $key=>$item){
					    $totalma =($item['jumlah']*$item['harga']);
						$grand_totalma += $totalma;
						$itemSql2 = "INSERT INTO penawaran_dtl SET 
												kode_penawaran	='".$kd_penawaran."', 
												jenis_barang	='".$perilah2."', 
												urutan_jb	='2',
												description_item ='".$item['description']."',
												qty		='".$item['jumlah']."',
												satuan		='".$item['satuan']."',
												harga		='".$item['harga']."',
												harga_hpp	='".$item['harga_hpp']."',
												profit		='".$item['profit']."',
												id_profit	='".$item['id_profit']."',
											    diskon		='".$item['diskon']."',
												id_diskon	='".$item['id_diskon']."',
												note		='".$item['note']."',
												total		='".$totalma."',
												aktif		='0',
												token		='".$token."' ";
				mysql_query($itemSql2);
						}
					    $array = $_SESSION['data_jasa'.$id_form.''];
						$totaljs = 0;
	        			$grand_totaljs = 0;	
						foreach($array as $key=>$item){
					    $totaljs =($item['jumlah']*$item['harga']);
						$grand_totaljs += $totaljs;
						$itemSql3 = "INSERT INTO penawaran_dtl SET 
												kode_penawaran	='".$kd_penawaran."', 
												jenis_barang	='".$perilah3."',
												urutan_jb	='3', 
												description_item ='".$item['description']."',
												qty		='".$item['jumlah']."',
												satuan		='".$item['satuan']."',
												harga		='".$item['harga']."',
												profit		='".$item['profit']."',
											    diskon		='".$item['diskon']."',
												note		='".$item['note']."',
												total		='".$totaljs."',
												aktif		='0',
												kd_jasa		='".$item['kd_jasa']."',
												token		='".$token."' ";
					
				mysql_query($itemSql3);
				
						$updkd_jasa = "UPDATE fjasa_hdr SET status='1' WHERE kd_jasa = '".$item['kd_jasa']."' ";
						mysql_query($updkd_jasa);
				      }
					  $grand_totalutama = ($grand_totalin+$grand_totalma+$grand_totaljs);
					  $diskonhdr =ceil(($_POST['diskon_utama']/100)*$grand_totalutama);
					  $grand_total = (($grand_totalutama)-($diskonhdr));
					  $grand_totalppn = ceil($grand_total*(10/100));
					  $grand_totalakhir = $grand_total+$grand_totalppn;
					  $ppn = (@$_POST['ppn'] == 1)? 1 : 0;
					  if ($ppn==1) {
				      $mySql1234	= "Update penawaran_hdr SET 
						sub_total	='".$grand_totalutama."', 
						diskon_hdr	='".$diskonhdr."',
						ppn	='".$grand_totalppn."',
						diskon_persen	='".$_POST['diskon_utama']."',
						grand_total	='".$grand_totalakhir."' WHERE kode_penawaran = '".$kd_penawaran."' AND token='".$token."' ";	
					  mysql_query($mySql1234);
					  }else {
						  $mySql1234	= "Update penawaran_hdr SET 
						sub_total	='".$grand_totalutama."',
						diskon_hdr	='".$diskonhdr."', 
						ppn	='0',
						grand_total	='".$grand_total."' WHERE kode_penawaran = '".$kd_penawaran."' AND token='".$token."' ";	
					  mysql_query($mySql1234);}
					  $statusupdatepp = "UPDATE permintaan_penawaran SET status = '1' WHERE kode_pp ='".$id."'";
					  mysql_query($statusupdatepp);
				
				}
				//echo "00||".$id;
								
				unset($_SESSION['data_infrastructure'.$id_form.'']);
				unset($_SESSION['data_material'.$id_form.'']);
				unset($_SESSION['data_jasa'.$id_form.'']);
				
			} else {echo "Gagal query: ".mysql_error();
			}
			
	}	
	
	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "opsi" ){
		$mail = new PHPMailer;
		//From email address and name
		//$mail->SMTPDebug = 2;                                 // Enable verbose debug output
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'mail.lotusolusi.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'adminprogram@lotusolusi.com';          // SMTP username
		$mail->Password = 'dargombes123';                   // SMTP password
		$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 465;                                    // TCP port to connect to
		$mail->setFrom('adminprogram@lotusolusi.com', 'Lotus');
		$mail->isHTML(true);
		
		$id_form=$_POST['id_form'];
		if((isset($_SESSION['data_infrastructure'.$id_form.'']) and count($_SESSION['data_infrastructure'.$id_form.''] > 0)) or (isset($_SESSION['data_material'.$id_form.'']) and count($_SESSION['data_material'.$id_form.''] > 0)) or (isset($_SESSION['data_jasa'.$id_form.'']) and count($_SESSION['data_jasa'.$id_form.'']) > 0)) {
			$id_form=$_POST['id_form'];
			$id = $_POST['kode_penawaran'];
			$token = $_POST['token'];
			$tanggal	= date("Y-m-d",strtotime($_POST['tanggal']));
			$perilah1	= $_POST['perihal1'];
			$perilah2	= $_POST['perihal2'];
			$perilah3	= $_POST['perihal3'];
			$kd_penawaran	= $_POST['kd_penawaran'];
			$kepada = $_POST['nama_perusahaan'];
			$up = $_POST['up'];
			$versi 		= buatOpsi($id);
			
			// membuat ref / kode referensi
			$cmd = "SELECT COUNT(id_penawaran) AS kode_ref FROM penawaran_hdr WHERE kode_penawaran='$kd_penawaran' AND versi='".$versi."'";
			$go = mysql_query($cmd);
			$resp = mysql_fetch_array($go);
			$ref = $resp['kode_ref'];
			
			$mySql	= "INSERT INTO penawaran_hdr SET 
						kode_penawaran	='".$kd_penawaran."',
						kode_pp			='".$id."', 
						ref				='".$ref."',
						versi			='".$versi."',
						dengan_hormat	='".$_POST['dengan_hormat']."', 
						tanggal			='".$tanggal."',
						kepada			='".$_POST['nama_perusahaan']."',
						Up				='".$_POST['up']."',
						perihal			='".$_POST['perihal']."',
						note			='".$_POST['note']."',
						token			='".$token."',
						status 			= '0' ";	
			
		
			
			$mail->addAddress('ulumovic@gmail.com', 'Puterako');     // Add a recipient
    	$mail_body = <<<EOT
    	<div>
	
			<style type='text/css'>
				.form-data {
					margin-bottom:1mm;
				}
				* {
					font-family:sans-serif;
				}
				.form-head {
					padding:10mm;
					border:1px solid black
				}
			</style>

			<div class="form-head" style="border:1px solid black;padding:10mm">
				<html>
					<body>
						
						   <h1> PENAWARAN MENUNGGU DISETUJUI </h1>
						   
							<table style='border-style:none' width='100%'>
								<thead>
								<tr>
									<td width='17%'>Kode PP</td>
									<td width='2%'>:</td>
									<td>$id</td> 
								</tr>
								<tr>
									<td>Kode Penawaran</td>
									<td>:</td>
									<td>$kd_penawaran</td> 
								</tr>
								<tr>
									<td>Tanggal</td>
									<td>:</td>
									<td>$tanggal</td> 
								</tr>
								
								<tr>
									<td>Kepada</td>
									<td>:</td>
									<td>$kepada</td> 
								</tr>
								<tr>
									<td>Up</td>
									<td>:</td>
									<td>$up</td> 
								</tr>
								</thead>
								</table> 
								
								<h3><a href="http://lotusolusi.com/puterako/?page=approval/index"> Lihat Detail</a> </h3>
								
					</body>
				</html> 
			</div>
		</div>
EOT;
    $mail->Subject = "Approval Penawaran";
	$mail->Body = $mail_body;
	$mail->AltBody = "View in HTML Mode or visit " . base_url() . '?page=approval/index';
	 
	  


			if(!$mail->send()) 
			{
				echo "Mailer Error: " . $mail->ErrorInfo;
			} 	
						
						
			if(mysql_query($mySql)) {
				$array = $_SESSION['data_infrastructure'.$id_form.''];
				$total_in=0;
				$grand_totalin=0;
				foreach($array as $key=>$item){
					$totalin =($item['jumlah']*$item['harga']);
					$grand_totalin += $totalin;
					$itemSql1 = "INSERT INTO penawaran_dtl SET 
											kode_penawaran	='".$kd_penawaran."', 
											jenis_barang	='".$perilah1."', 
											urutan_jb	='1',
											model_item	='".$item['model']."',
											description_item ='".$item['description']."',
											qty		='".$item['jumlah']."',
											satuan		='".$item['satuan']."',
											harga		='".$item['harga']."',
											harga_hpp	='".$item['harga_hpp']."',
											profit		='".$item['profit']."',
											id_profit	='".$item['id_profit']."',
											diskon		='".$item['diskon']."',
											id_diskon	='".$item['id_diskon']."',
											note		='".$item['note']."',
											total		='".$totalin."',
											aktif		='0',
											token		='".$token."' ";
				 mysql_query($itemSql1);
				}
				
						$array = $_SESSION['data_material'.$id_form.''];
						$totalma = 0;
						$grand_totalma=0;	
				        foreach($array as $key=>$item){
					    $totalma =($item['jumlah']*$item['harga']);
						$grand_totalma += $totalma;
						$itemSql2 = "INSERT INTO penawaran_dtl SET 
												kode_penawaran	='".$kd_penawaran."', 
												jenis_barang	='".$perilah2."', 
												urutan_jb	='2',
												description_item ='".$item['description']."',
												qty		='".$item['jumlah']."',
												satuan		='".$item['satuan']."',
												harga		='".$item['harga']."',
												harga_hpp	='".$item['harga_hpp']."',
												profit		='".$item['profit']."',
												id_profit	='".$item['id_profit']."',
											    diskon		='".$item['diskon']."',
												id_diskon	='".$item['id_diskon']."',
												note		='".$item['note']."',
												total		='".$totalma."',
												aktif		='0',
												token		='".$token."' ";
				mysql_query($itemSql2);
						}
					    $array = $_SESSION['data_jasa'.$id_form.''];
						$totaljs = 0;
	        			$grand_totaljs = 0;	
						foreach($array as $key=>$item){
					    $totaljs =($item['jumlah']*$item['harga']);
						$grand_totaljs += $totaljs;
						$itemSql3 = "INSERT INTO penawaran_dtl SET 
												kode_penawaran	='".$kd_penawaran."', 
												jenis_barang	='".$perilah3."',
												urutan_jb	='3', 
												description_item ='".$item['description']."',
												qty		='".$item['jumlah']."',
												satuan		='".$item['satuan']."',
												harga		='".$item['harga']."',
												profit		='".$item['profit']."',
											    diskon		='".$item['diskon']."',
												note		='".$item['note']."',
												total		='".$totaljs."',
												aktif		='0',
												kd_jasa		='".$item['kd_jasa']."',
												token		='".$token."' ";
					
				mysql_query($itemSql3);
				
						$updkd_jasa = "UPDATE fjasa_hdr SET status='1' WHERE kd_jasa = '".$item['kd_jasa']."' ";
						mysql_query($updkd_jasa);
				      }
					  $grand_totalutama = ($grand_totalin+$grand_totalma+$grand_totaljs);
					  $diskonhdr =ceil(($_POST['diskon_utama']/100)*$grand_totalutama);
					  $grand_total = (($grand_totalutama)-($diskonhdr));
					  $grand_totalppn = ceil($grand_total*(10/100));
					  $grand_totalakhir = $grand_total+$grand_totalppn;
					  $ppn = (@$_POST['ppn'] == 1)? 1 : 0;
					  if ($ppn==1) {
				      $mySql1234	= "Update penawaran_hdr SET 
						sub_total	='".$grand_totalutama."', 
						diskon_hdr	='".$diskonhdr."',
						ppn	='".$grand_totalppn."',
						diskon_persen	='".$_POST['diskon_utama']."',
						grand_total	='".$grand_totalakhir."' WHERE kode_penawaran = '".$kd_penawaran."' AND token='".$token."' ";	
					  mysql_query($mySql1234);
					  }else {
						  $mySql1234	= "Update penawaran_hdr SET 
						sub_total	='".$grand_totalutama."',
						diskon_hdr	='".$diskonhdr."', 
						ppn	='0',
						grand_total	='".$grand_total."' WHERE kode_penawaran = '".$kd_penawaran."' AND token='".$token."' ";	
					  mysql_query($mySql1234);}
					  $statusupdatepp = "UPDATE permintaan_penawaran SET status = '1' WHERE kode_pp ='".$id."'";
					  mysql_query($statusupdatepp);
				
				}
				//echo "00||".$id;
								
				unset($_SESSION['data_infrastructure'.$id_form.'']);
				unset($_SESSION['data_material'.$id_form.'']);
				unset($_SESSION['data_jasa'.$id_form.'']);
				
			} else {echo "Gagal query: ".mysql_error();
			}
			
	}	 
	
	
?>
