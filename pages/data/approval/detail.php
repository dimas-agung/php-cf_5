<?php 
	if(isset($_GET['kode'])) {
		$id = $_GET['kode'];
		$qp = "SELECT * FROM penawaran_hdr WHERE id_penawaran = $id";
		$go = mysql_query($qp);
		$resp = mysql_fetch_array($go); 
	}
		$tgl = date('d-m-Y', strtotime($resp['tanggal'])); 
		$kode = $resp['kode_penawaran'];
		$opsi = $resp['versi'];
		$ref = $resp['ref'];
					
		if($ref>0){
			$no_penawaran = $kode.'_ref_'.$ref.' opsi '.$opsi;
		}else{
			$no_penawaran = $kode.' opsi '.$opsi;	
		}
?>
<div class="box-body">
	<div class="row">
	    <div class="col-md-12">
	      <div class="invoice-title">
          	
	        <h2>
	        	Detail Penawaran
	        </h2>
	        <h3 class="pull-right"></h3>
	      </div>
	      <hr>
	      <div class="row">
	        <div class="col-xs-6">
	          <address>
	            <strong>Kode Penawaran:</strong><br>
	            <?php echo $no_penawaran; ?>
	          </address>
	        </div>
	        <div class="col-xs-6 text-right">
	          <address>
	            <strong>Kepada:</strong><br>
	            <?php echo $resp['kepada']; ?>
	          </address>
	        </div>
	      </div>
	      <div class="row">
	        <div class="col-xs-6">
	          <address>
	            <strong>Kode PP:</strong><br>
	            <?php echo $resp['kode_pp']; ?>
	          </address>
	        </div>
	        <div class="col-xs-6 text-right">
	          <address>
	            <strong>Tanggal:</strong><br>
	            <?php echo $tgl; ?>
	          </address>
	        </div>
	      </div>
	    </div>
	  </div>
	<!-- Menampilkan detail penawaran -->
	<?php 
			// Melihat semua jenis barang di detail penawaran
			$q_dtl_jenis = "SELECT DISTINCT jenis_barang FROM penawaran_dtl dtl INNER JOIN penawaran_hdr hdr ON dtl.token=hdr.token  WHERE hdr.id_penawaran  = '".$id."' ";

			$cmd_dtl_jenis = mysql_query($q_dtl_jenis);

			$jenis_barang = array();
			if($cmd_dtl_jenis) {
				while($r = mysql_fetch_array($cmd_dtl_jenis)) 
					array_push($jenis_barang, $r['jenis_barang']);
			}
			// Menampilkan detail penawaran 
			if(count($jenis_barang) > 0) {
				foreach ($jenis_barang as $key => $val) {
					
	 ?>
		
	  <div class="row">
	    <div class="col-md-12">
	      <div class="panel panel-default">
	        <div class="panel-heading">
	          <h3 class="panel-title">
	          	<strong>
	          		<?php echo $val; ?>
	          	</strong>
	          </h3>
	        </div>
	        <div class="panel-body">
	          <div class="table-responsive">
	            <table class="table table-condensed" width="100%">
	              <thead>
	                <tr>
	                  <td width="15%"><strong>Model</strong></td>
                      <td width="38%"><strong>Description</strong></td>
	                  <td width="7%" class="text-center"><strong>Price</strong></td>
	                  <td width="10%" class="text-center"><strong>QTY</strong></td>
                      <td width="15%" class="text-center"><strong>Satuan</strong></td>
	                  <td width="15%" class="text-right"><strong>Totals</strong></td>
	                </tr>
	              </thead>
	              <tbody>
	                <!-- foreach ($order->lineItems as $line) or some such thing here -->
	                <?php 
	                	$q_detail = "SELECT dtl.* FROM penawaran_dtl dtl INNER JOIN penawaran_hdr hdr ON dtl.token=hdr.token WHERE hdr.id_penawaran='" . $id . "' AND jenis_barang = '" . $val . "'";
	                	$run_detail = mysql_query($q_detail);
	                	if($run_detail AND mysql_num_rows($run_detail) > 0) {
	                		$subtotal = 0;
	                		while($resp_dtl = mysql_fetch_array($run_detail)) {
	                			$subtotal += ($resp_dtl['qty'] * $resp_dtl['harga']);
	                ?>
	                	<tr>
	                		<td>
	                			<?php echo $resp_dtl['model_item']; ?>
	                		</td>
                            <td>
	                			<?php echo $resp_dtl['description_item']; ?>
	                		</td>
	                		<td class="text-center">
	                			<?php echo number_format($resp_dtl['harga']); ?>
	                		</td>
	                		<td class="text-center">
	                			<?php echo number_format($resp_dtl['qty']); ?>
	                		</td>
                            <td class="text-center">
	                			<?php echo ($resp_dtl['satuan']); ?>
	                		</td>
	                		<td  class="text-right">
	                			<?php echo number_format($resp_dtl['qty'] * $resp_dtl['harga']); ?>
	                		</td>
	                	</tr>
	                <?php
	                		}
	                ?>
	                	<tr>
	                  <td class="thick-line"></td>
	                  <td class="thick-line"></td>
                      <td class="thick-line"></td>
                      <td class="thick-line"></td>
	                  <td class="thick-line text-center"><strong>Total Nett</strong></td>
	                  <td class="thick-line text-right"><b><?=number_format($subtotal)?></b></td>
	                </tr>
	                
	                <?php
	                	}
	                	else {
	                ?>
	                		<tr>
	                			<td colspan="6">Tidak ada data</td>
	                		</tr>
	                	<?php	
	                	}
	                 ?>
                     
                   
	              
	                
	              </tbody>
	            </table>
	          </div>
	        </div>
	      </div>
	    </div>
	  </div>
	 <?php	
	 			}			
			}
	 ?>
     
     <table class="table table-condensed" width="100%">
     				<tr>
                   		<td colspan="4" width="70%">&nbsp;</td>
                        <td class="text-right" width="15%"><b>Subtotal</b></td>
                        <td class="text-right" width="15%"><b><?php echo number_format($resp['sub_total']); ?></b></td>
                   </tr>  
                   <tr>
                   		<td colspan="4">&nbsp;</td>
                        <td class="text-right"><b>Diskon</b></td>
                        <td class="text-right"><b><?php echo number_format($resp['diskon_hdr']); ?></b></td>
                   </tr>  
                   <tr>
                   		<td colspan="4">&nbsp;</td>
                        <td class="text-right"><b>PPn</b></td>
                        <td class="text-right"><b><?php echo number_format($resp['ppn']); ?></b></td>
                   </tr>  
                   <tr>
                   		<td colspan="4">&nbsp;</td>
                        <td class="text-right"><b>Grandtotal</b></td>
                        <td class="text-right"><b><?php echo number_format($resp['grand_total']); ?></b></td>
                   </tr>  
     </table>
  
	<!-- ---------------------------- -->
  <div class="row" style="margin-bottom:5mm">
  	<div class="col-md-12" style="display: flex;">
  		<form method='post' action="<?php echo base_url(); ?>pages/data/script/approval/approve.php" style='margin-right:2mm'> 
	  		<input type="hidden" name="id" value="<?php echo $resp['id_penawaran']; ?>">
	  		<input type="hidden" name="kode_pp" value="<?php echo $resp['kode_pp']; ?>">
	  		<input type="hidden" name="kode_penawaran" value="<?php echo $resp['kode_penawaran']; ?>">
	  		<input type="hidden" name="status" value="<?php echo $resp['status']; ?>">
	  		<input type="hidden" name="kepada" value="<?php echo $resp['kepada']; ?>">
	  		<input type="hidden" name="up" value="<?php echo $resp['Up']; ?>">
	  		<input type="hidden" name="tanggal" value="<?php echo $resp['tanggal']; ?>">
	  		<button class="btn btn-primary">
	  			Approve
	  		</button>
	  	</form>	
	  		
	  	
	  		<button class="btn btn-danger" data-toggle="modal" data-target="#alasan-batal">
	  				Batal
	  		</button>
	  		<!-- Modal -->
				<div id="alasan-batal" class="modal fade" role="dialog">
					<form method='post' action="<?php echo base_url(); ?>pages/data/script/approval/batal.php"> 
	  			<input type="hidden" name="id" value="<?php echo $resp['id_penawaran']; ?>">
					  <div class="modal-dialog">

					    <!-- Modal content-->
					    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal">&times;</button>
					        <h4 class="modal-title">Konfirmasi</h4>
					      </div>
					      <div class="modal-body">
					        <div class="form-group">
								    <label for="email">Alasan batal:</label>
								    <textarea name="alasan_batal" class="form-control" id="alasan-batal-text"></textarea>
								  </div>
					      </div>
					      <div class="modal-footer">

					      	<button type="submit" class="btn btn-primary" >Submit</button>

					        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					      </div>
					    </div>

					  </div>
			
				</div>	
	  		

	  	</form> 
  	</div>
  </div>
</div>