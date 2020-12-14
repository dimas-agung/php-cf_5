<?php
	include "pages/data/script/btb.php";
	include "library/form_akses.php";
?>
<section class="content-header">
    <ol class="breadcrumb">
        <li><i class="fa fa-folder-open"></i> Logistik</a></li>
        <li>Bukti Terima Barang</a></li>
    </ol>
</section>

<div class="box box-info">
    <div class="box-body">

    		<?php if (isset($_GET['pesan'])){ ?>
				<div class="form-group" id="form_report">
				  <div class="alert alert-success alert-dismissable">
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					  Kode BTB :  <a href="<?=base_url()?>?page=logistik/btb_track&action=track&halaman= TRACK BUKTI TERIMA BARANG&kode_btb=<?=$_GET['pesan']?>" target="_blank"><?=$_GET['pesan'] ?></a>  Berhasil Di posting
				  </div>
				</div>
			<?php } else if (isset($_GET['clsman'])){ ?>
				<div class="form-group" id="form_report">
                  <div class="alert alert-dismissable" style="background-color: #9c0303cc; color: #f9e6c3">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color: #f9e6c3">&times;</button>
                      Tutup Manual Kode OP :  <a style="color: white" href="<?=base_url()?>?page=pembelian/op_track&halaman= TRACK ORDER PEMBELIAN&action=track&kode_op=<?=$_GET['clsman']?>" target="_blank"><?=$_GET['clsman'] ?></a>  Berhasil Di tutup
                  </div>
                </div>
			<?php  }  else if (isset($_GET['pembatalan'])){ ?>
                <div class="form-group" id="form_report">
                  <div class="alert alert-dismissable" style="background-color: #9c0303cc; color: #f9e6c3">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color: #f9e6c3">&times;</button>
                      Pembatalan Kode BTB :  <a style="color: white" href="<?=base_url()?>?page=logistik/btb_track&halaman= TRACK BUKTI TERIMA BARANG&action=track&kode_btb=<?=$_GET['pembatalan']?>" target="_blank"><?=$_GET['pembatalan'] ?></a>  Berhasil Di batalkan
                  </div>
                </div>
            <?php } ?>

		<div class="tabbable">
			<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
				<li <?=$class_form?>>
					<a data-toggle="tab" href="#menuFormBtb">Form Bukti Terima Barang</a></li>
                <li <?=$class_tab?>>
					<a data-toggle="tab" href="#menuListBtb">List Bukti Terima Barang</a>
				</li>
            </ul>

            <div class="row">
			<div class="tab-content">
				<div id="menuFormBtb"
					<?=$class_pane_form?> >
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-body">
                                	<div class="form-horizontal">

                                		<?php $id_form = buatkodeform("kode_form"); ?>

                                  		<form action="" method="post" enctype="multipart/form-data" id="saveForm">

                                  		<?php   $idtem = "INSERT INTO form_id SET kode_form ='".$id_form."' ";
										mysql_query($idtem); ?>
										<input type="hidden" name="id_form" id="id_form" value="<?php echo $id_form; ?>"/>

										<?php
											if(isset($_GET['action']) and $_GET['action'] == "edit") {
												$row = mysql_fetch_array($q_edit_inv);
											}
										?>

			                         <div class="form-group">
			                         	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode BTB</label>
			                         	<div class="col-lg-4">
			                             	<input type="text" class="form-control" name="kode_btb" id="kode_btb" placeholder="Auto..." readonly value="">
			                         	</div>

                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Supplier</label>
				                         <div class="col-lg-4">
				                            <select id="kode_supplier" name="kode_supplier" class="select2" style="width: 100%;">
						                        <option value="0">-- Pilih Kode Supplier --</option>
						                        <?php
                                                //CEK JIKA supplier ADA MAKA SELECTED
                                                (isset($_POST['supplier']) ? $supplier=$_POST['supplier'] : $supplier='');
                                                //UNTUK AMBIL coanya
                                                while($row_supplier = mysql_fetch_array($q_supplier)) { ;?>

                                                <option value="<?php echo $row_supplier['kode_supplier'];?>" <?php if($row_supplier['kode_supplier']==$supplier){echo 'selected';} ?>><?php echo $row_supplier['kode_supplier'] . ' - ' . $row_supplier['nama_supplier'];?> </option>
                                                <?php } ?>
				                        	</select>
				                         </div>
                         			 </div>

				                     <div class="form-group">
				                     	 <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
				                         <div class="col-lg-4">
				                             <input type="text" class="form-control" name="ref" id="ref" placeholder="Ref..." value="" autocomplete="off">
				                         </div>

                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode OP</label>
				                         <div class="col-lg-4" id="load_op">
				                         	<select id="no_op" name="no_op" class="select2" style="width: 100%;" disabled>
                                                <option value="">-- Pilih Supplier dahulu --</option>
                                            </select>
				                         </div>
				                     </div>

				                     <div class="form-group">
				                     	 <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal BTB</label>
				                         <div class="col-lg-4">
				                         	<div class="input-group">
				                             <input type="text" name="tanggal" id="tanggal" class="form-control date-picker-close" placeholder="Tanggal Bukti Terima Barang ..." value="<?=date("m/d/Y")?>" autocomplete="off" readonly/>
				                             <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
				                             <input type="hidden" name="tgl_sekarang" id="tgl_sekarang" class="form-control" value="<?=date("m/d/Y")?>"/>
				                            </div>
				                         </div>

                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Gudang</label>
				                         <div class="col-lg-4" id="load_gudang">
				                         	<select id="kode_gudang" name="kode_gudang" class="select2" style="width: 100%;" disabled>
                                                <option value="">-- Pilih OP dahulu --</option>
                                            </select>
				                         </div>
				                     </div>

				                     <div class="form-group">
				                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
				                         <div class="col-lg-4">
				                             <select id="kode_cabang" name="kode_cabang" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Cabang --</option>
                                                <?php
                                                //CEK JIKA cabang ADA MAKA SELECTED
                                                (isset($row['id_btb']) ? $cabang=$row['cabang'] : $cabang='');
                                                //UNTUK AMBIL coanya
                                                while($row_cabang = mysql_fetch_array($q_cabang)) { ;?>

                                                <option value="<?php echo $row_cabang['kode_cabang'];?>" <?php if($row_cabang['kode_cabang']==$cabang){echo 'selected';} ?>><?php echo $row_cabang['nama_cabang'];?> </option>
                                                <?php } ?>
                                                </select>
				                         </div>
				                     </div>

				                     <div class="form-group">



				                     </div>

				                     <div class="form-group">
				                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
				                         <div class="col-lg-10">
				                             <textarea type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan..." value=""></textarea>
				                         </div>
				                     </div>

				                     <div class="form-group">
                     	                <div class="col-lg-12">
                                            <table id="" class="" rules="all">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10px">No</th>
                                                        <th style="width: 150px">Nama Barang</th>
                                                        <th style="width: 150px">QTY Order Pembelian</th>
                                                        <th style="width: 150px">QTY Belum Di Terima</th>
                                                        <th style="width: 150px">QTY Terima Barang</th>
                                                        <th style="width: 200px">Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="detail_input_btb">
                                                    <tr>
                                                        <td colspan="6" class="text-center">Belum ada item</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                    	</div>
									 </div>


									 <div class="form-group col-md-6">

                    						<?php
												$list_survey_write = 'n';
												while($res = mysql_fetch_array($q_akses)) {; ?>
													<?php
	                                                //FORM SURVEY
	                                                if($res['form']=='survey'){
	                                                    if($res['w']=='1'){
															$list_survey_write = 'y';
                                            ?>

											<!-- <button type="submit" name="simpan" id="simpan" class="btn btn-primary" tabindex="10"><i class="fa fa-check-square-o"></i> Simpan</button> -->
                                            <?php } } } ?>
											<button type="submit" name="simpan" id="simpan" class="btn btn-primary" tabindex="10"><i class="fa fa-check-square-o"></i> Simpan</button>

                                            <a href="<?=base_url()?>?page=logistik/btb&halaman= BUKTI TERIMA BARANG" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>
               						 </div>

					 					</form>

									</div>
                            	</div>
							</div>
						</div>
				</div>

				<div id="menuListBtb" <?=$class_pane_tab?>>
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-body">

									<form action="" method="post" >

			                         	<div class="col-xs-12 col-md-4" style="margin-bottom:3mm">
                                      		<div class="input-group">
	                                      		<span class="input-group-addon point">Kode</span>
				                             	<input type="text" autocomplete="off" class="form-control" name="kode_btb" id="kode_btb" placeholder="Kode BTB ..." value="<?php

													if(empty($_POST['kode_btb'])){
														echo "";

													}else{
														echo $_POST['kode_btb'];
													}

													?>">
				                            </div>
			                         	</div>

			                         	<div class="col-xs-12 col-md-4" style="margin-bottom:3mm">
                                      		<div class="input-group">
	                                      		<span class="input-group-addon point">Ref</span>
					                             <input type="text" autocomplete="off" class="form-control" name="ref" id="ref" placeholder="Ref..."
					                             value="<?php

													if(empty($_POST['ref'])){
														echo "";

													}else{
														echo $_POST['ref'];
													}

													?>">
					                        </div>
				                        </div>

				                        <div class="col-xs-12 col-md-4" style="margin-bottom:3mm">
                                      		<div class="input-group">
	                                      		<span class="input-group-addon point">Inventori</span>
				                            		<select id="inventori" name="inventori" class="select2" style="width: 100%;">
	                                                <option value="" selected>-- Pilih Inventori --</option>

	                                                <?php
	                                                (isset($_POST['inventori']) ? $inventori=$_POST['inventori'] : $inventori='');

	                                                //UNTUK AMBIL coanya
	                                                while($row_inventori = mysql_fetch_array($q_inventori)) { ;?>

	                                                <option style="font-size: 8px;" value="<?php echo $row_inventori['kode_inventori'];?>" <?php if($row_inventori['kode_inventori']==$inventori){echo 'selected';} ?>><?php echo $row_inventori['kode_inventori'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$row_inventori['nama_inventori'];?> </option>
	                                                <?php } ?>
	                                                </select>
					                        </div>
	                         			</div>

				                     	<div class="col-xs-12 col-md-4" style="margin-bottom:3mm">
                                      		<div class="input-group">
	                                      		<span class="input-group-addon point">Cabang</span>
				                            	<select id="cabang" name="cabang" class="select2" style="width: 100%;">
                                                <option value="" selected>-- Pilih Cabang --</option>
                                                <?php
                                                //CEK JIKA cabang ADA MAKA SELECTED
                                                (isset($_POST['cabang']) ? $cabang=$_POST['cabang'] : $cabang='');
                                                //UNTUK AMBIL coanya
                                                while($row_cabang = mysql_fetch_array($q_cabang_list)) { ;?>

                                                <option value="<?php echo $row_cabang['kode_cabang'];?>" <?php if($row_cabang['kode_cabang']==$cabang){echo 'selected';} ?>><?php echo $row_cabang['kode_cabang'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$row_cabang['nama_cabang'];?> </option>
                                                <?php } ?>
                                                </select>
				                         	</div>
				                        </div>

				                        <div class="col-xs-12 col-md-4" style="margin-bottom:3mm">
                                      		<div class="input-group">
	                                      		<span class="input-group-addon point">Gudang</span>
				                             	<select id="gudang" name="gudang" class="select2" style="width: 100%;">
                                                <option value="" selected>-- Pilih gudang --</option>
                                                <?php
                                                //CEK JIKA gudang ADA MAKA SELECTED
                                                (isset($_POST['gudang']) ? $gudang=$_POST['gudang'] : $gudang='');
                                                //UNTUK AMBIL coanya
                                                while($row_gudang = mysql_fetch_array($q_gudang)) { ;?>

                                                <option value="<?php echo $row_gudang['kode_gudang'];?>" <?php if($row_gudang['kode_gudang']==$gudang){echo 'selected';} ?>><?php echo $row_gudang['kode_gudang'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$row_gudang['nama_gudang'];?> </option>
                                                <?php } ?>
                                                </select>
				                         	</div>
				                        </div>

				                     	<div class="col-xs-12 col-md-4" style="margin-bottom:3mm">
                                      		<div class="input-group">
	                                      		<span class="input-group-addon point">Supplier</span>
				                             	<select id="supplier" name="supplier" class="select2" style="width: 100%;">
                                                <option value="" selected>-- Pilih supplier --</option>
                                                <?php
                                                //CEK JIKA supplier ADA MAKA SELECTED
                                                (isset($_POST['supplier']) ? $supplier=$_POST['supplier'] : $supplier='');
                                                //UNTUK AMBIL coanya
                                                while($row_supplier = mysql_fetch_array($q_supplier)) { ;?>

                                                <option value="<?php echo $row_supplier['kode_supplier'];?>" <?php if($row_supplier['kode_supplier']==$supplier){echo 'selected';} ?>><?php echo $row_supplier['kode_supplier'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$row_supplier['nama_supplier'];?> </option>
                                                <?php } ?>
                                                </select>
				                         	</div>
				                    	</div>


				                     	<div class="col-xs-12 col-md-6" style="margin-bottom:3mm">
	                                        <div class="input-group">
	                                            <span class="input-group-addon">Tanggal Awal</i></span>
	                                            <input type="text" name="tanggal_awal" id="tanggal_awal" class="form-control" autocomplete="off" value="<?=date("d-m-Y")?>">
	                                            <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
	                                        </div>
	                                    </div>
	                                    <div class="col-xs-12 col-md-6" style="margin-bottom:3mm">
	                                        <div class="input-group">
	                                         	<span class="input-group-addon">Tanggal Akhir</span>
	                                         	<input type="text" name="tanggal_akhir" id="tanggal_akhir" class="form-control" autocomplete="off"value="<?=date("d-m-Y")?>">
	                                         	<span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
	                                      	</div>
	                                   </div>

	                                   <div class="pull-right">
	                                   			<button type="submit" name="refresh" id="refresh" class="btn btn-info btn-sm" value="refresh"><i class="fa fa-refresh"></i>Refresh</button>
	               					   </div>

					                   <div class="col-md-1 pull-right">
												<button type="submit" name="cari" id="cari" class="btn btn-primary btn-sm" value="cari"><i class="fa fa-search"></i>cari</button>
	               						</div>
                                	</form>

									<div class="box-body">
									<table id="example1" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
                                                <th style="font-size: 14px">No</th>
												<th style="font-size: 14px">Kode</th>
												<th style="font-size: 14px">Deskripsi Barang</th>
												<th style="font-size: 14px">Tanggal</th>
												<th style="font-size: 14px">Supplier</th>
												<th style="font-size: 14px">Cabang</th>
                                                <th style="font-size: 14px">Gudang</th>
                                                <th style="font-size: 14px">Q Diterima</th>
                                                <th style="font-size: 14px">Status</th>
                                                <th style="font-size: 14px"></th>
											</tr>
										</thead>
										<tbody>

											<?php
												$n=1; if(mysql_num_rows($q_btb) > 0) {
												while($data = mysql_fetch_array($q_btb)) {

												if($data['status_dtl'] == '1'){
	        										$status = 'Open';
	        										$warna = 'style="background-color: #39b13940"';
	        										$print = '';
	        									}elseif($data['status_dtl'] == '2'){
	        										$status = 'Batal';
	        										$warna = 'style="background-color: #de4b4b63;"';
	        										$print = 'hidden';
	        									}else{
	        										$status = 'Close';
	        										$warna = 'style="background-color: #ffd10045;"';
	        										$print = 'hidden';
	        									}
											?>

											<tr <?= $warna?>>
												<td style="text-align: center; width:5px; font-size: 12px"> <?php echo $n++ ?></td>
												<td style="font-size: 12px"><a href="<?=base_url()?>?page=logistik/btb_track&action=track&halaman= TRACK BUKTI TERIMA BARANG&kode_btb=<?=$data['kode_btb']?>" target="_blank">
													<?php echo $data['kode_btb'];?></a></td>
												<td style="font-size: 12px" > <?php echo $data['kode_barang'];?></td>
												<td style="font-size: 12px"> <?php echo date("d-m-Y",strtotime($data['tgl_buat']));?></td>
                                                <td style="font-size: 12px"> <?php echo $data['nama_supplier'];?></td>
												<td style="font-size: 12px"> <?php echo $data['nama_cabang'];?></td>
												<td style="font-size: 12px"> <?php echo $data['nama_gudang'];?></td>
                                                <td style="text-align:right; font-size: 12px"> <?php echo number_format($data['qty'], 2);?></td>
                                                <td style="text-align:center;"> <?php echo $status; ?></td>
                                                <td style="font-size: 12px; text-align: center">
                                                	<a href="<?=base_url()?>r_cetak_btb.php?kode_btb=<?=$data['kode_btb']?>" title="cetak" target="_blank">
                                                		<button type="button" class="btn btn-warning btn-sm <?= $print?>">
                                                			<span class="glyphicon glyphicon-print"></span>
                                                		</button>
                                                	</a>
                                                </td>
											</tr>
											<?php
												}
											}else{
												echo "";
											}
											?>
										</tbody>
									</table>
									</div>
								</div>
							</div>
						</div>
				</div>

            </div>
        	</div>

<?php unset($_SESSION['data_btb']); ?>
	
<script type="text/javascript">
	$(document).ready(function () {

      // $("[name='bayari']").number( true, 2 );

      // $(".select2item").select2({
      //   width : '100%'
      // });

      $("[name='q_diterima[]']").number( true, 2 );
      
  });
</script>
	
  <script>
  $(document).ready(function (e) {
	 $("#saveForm").on('submit',(function(e) {
		var grand_total = 0;
				$('[name="q_diterima[]"]').each(function() {
					grand_total += parseFloat(($(this).val()).replace(/,/g, ''));

				});
		//console.log(grand_total);

		if(grand_total == "" || isNaN(grand_total)) {grand_total = 0;}
		e.preventDefault();
	  	if(grand_total != 0 && grand_total > 0) {
			$(".animated").show();
			$.ajax({
				url: "<?=base_url()?>ajax/j_btb.php?func=save",
				type: "POST",
				data:  new FormData(this),
				contentType: false,
				cache: false,
				processData:false,
				success: function(html)
				{
					var msg = html.split("||");
					if(msg[0] == "00") {
						window.location = '<?=base_url()?>?page=logistik/btb&halaman= BUKTI TERIMA BARANG&pesan='+msg[1];
					} else {
						notifError(msg[1]);
					}
					$(".animated").hide();
				}

		   });
	  	} else {notifError("<p>Item  masih kosong.</p>");}
	 }));
  });

  $('body').delegate("#kode_cabang, #kode_supplier","change", function() {
		var kode_supplier 		= $("#kode_supplier").val();
		var kode_cabang 		= $("#kode_cabang").val();
        
			$.ajax({
					type: "POST",
					url: "<?=base_url()?>ajax/j_btb.php?func=loadop",
					data: "kode_supplier="+kode_supplier+"&kode_cabang="+kode_cabang,
					cache:false,
					success: function(data) {
						$('#load_op').html(data);
						$('#kode_op').val('0').trigger('change');
						$('#kode_gudang').val('0').trigger('change');
						BindSelect2();
					}
				});

			function BindSelect2() {
				$("[name='no_op']").select2({
					width: '100%'
				});
			}
	});
	
	$(document).on("click", "button[class~='move_qty']", function ($event) {
		var
			$this = $(this),
			$id = $this.attr('data-id'),
			$qty = parseInt(($('span[id="text-qty_belum_' + $id + '"]').text() || '').replace(/,/g, '') || 0),
			$qty_i = $('input[id="q_diterima_' + $id + '"]');
		$event.preventDefault();
		
		if ($qty > 0) {
			$qty_i.val($qty);
		} else if (parseInt($qty_i.val()) > 0) {
			$('span[id="text-qty_belum_' + $id + '"]').html($qty_i.val());
			$qty_i.val(0);
		}
		$qty_i.trigger('change');
	});
	
	$(document).on("click", "button[class~='reset_qty']", function ($event) {
		var
			$this = $(this),
			$id = $this.attr('data-id'),
			$qty_i = $('input[id="q_diterima_' + $id + '"]');
		$event.preventDefault();
		
		$('span[id="text-qty_belum_' + $id + '"]').html($qty_i.val());
		$qty_i.val(0);
	
		$qty_i.trigger('change');
	});
	
	$(document).on("change keyup paste", "input[name='q_diterima[]']", function () {
		var
			$this = $(this),
			$id = $this.attr('data-id'),
			$qty = parseInt($('input[id="qty_' + $id + '"]').val() || 0),
			$qty_i = parseInt($('input[id="q_diterima_' + $id + '"]').val() || 0),
			$sisa = 0;
		
		if ($qty_i < 0) {
			$('input[id="q_diterima_' + $id + '"]').val(0);
		}
			
		if ($qty > 0 && $qty_i > 0) {
			if ($qty_i <= $qty) {
				$sisa = ($qty_i - $qty);
			} else {
				$sisa = $qty;
				$('input[id="q_diterima_' + $id + '"]').val(0);
				notifError('QTY Terima Barang tidak boleh lebih dari QTY Belum Diterima');
			}
			$('span[id="text-qty_belum_' + $id + '"]').html($sisa);
		} else {
			$('span[id="text-qty_belum_' + $id + '"]').html($qty);
		}			
		$('span[id="text-qty_belum_' + $id + '"]').number(true, 2);
	});

	$('body').delegate("#no_op","change", function() {
		var supplier 		= $("#no_op").find(':selected').attr('data-supplier');
		var kode_supplier 	= $("#no_op").find(':selected').attr('data-kode-supplier');
		var kode_op 		= $("#no_op").val();
			$.ajax({
					type: "POST",
					url: "<?=base_url()?>ajax/j_btb.php?func=loadgudang",
					data: "kode_op="+kode_op,
					cache:false,
					success: function(data) {
						$('#load_gudang').html(data);
						$('#supplier').val(supplier);
						$('#kode_supplier').val(kode_supplier);
						$('#kode_gudang').val('0').trigger('change');
						BindSelect2();
					}
				});

			function BindSelect2() {
				$("[name='kode_gudang']").select2({
					width: '100%'
				});
			}
	});

	$('body').delegate("#kode_gudang","change", function() {
		var kode_gudang 	= $("#kode_gudang").val();
		var kode_op 		= $("#no_op").val();
			$.ajax({
					type: "POST",
					url: "<?=base_url()?>ajax/j_btb.php?func=loaditem",
					data: "kode_op="+kode_op+"&kode_gudang="+kode_gudang,
					cache:false,
					success: function(data) {
						$('#detail_input_btb').html(data);
						numberjs();
					}
				});

			function numberjs(){
				$("[name='q_diterima[]']").number( true, 2 );
			}

	});

</script>

<!-- <script src="<?=base_url()?>assets/select2/select2.js"></script> -->
<script>

  $(function () {
  	$( "#tanggal_awal" ).datepicker();
    $( "#tanggal_akhir" ).datepicker();
    $('#example1').DataTable({
    	'searching'   : false,

    })

    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  });
</script>

<script>
	$(".select2").select2({
	  width: '100%'
	 });
</script>
<script>
    var
        $disabledMonth = [];
    <?php
        if (mysql_num_rows($q_close)) {
            $disabledMonth = [];
            while ($row = mysql_fetch_object($q_close)) {
                $disabledMonth[] = '\'' . $row->fulltext . '\'';
            }
            echo '$disabledMonth = [' . implode(',', $disabledMonth) . '];';
        }
    ?>
    $(".date-picker").datepicker();
    $(".date-picker-close").datepicker({
        beforeShowDay: function($date) {
            var
                $string = new Date($date);
            $string = $string.getFullYear() + '-' + (($string.getMonth()+1) < 10 ? '0' + ($string.getMonth()+1) : $string.getMonth()+1);
            return [$.inArray($string, $disabledMonth) === -1];
        }
    });
</script>
