<?php
	include "pages/data/script/fb.php";
	include "library/form_akses.php";
?>
<section class="content-header">
    <ol class="breadcrumb">
        <li><i class="fa fa-money"></i>Keuangan</a></li>
        <li>Faktur Pembelian</a></li>
    </ol>
</section>


<div class="box box-info">
    <div class="box-body">

    		<?php if (isset($_GET['pesan'])){ ?>
				<div class="form-group" id="form_report">
				  <div class="alert alert-success alert-dismissable">
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					  Kode FB :  <a href="<?=base_url()?>?page=keuangan/fb_track&action=track&halaman= TRACK FAKTUR PEMBELIAN&kode_fb=<?=$_GET['pesan']?>" target="_blank"><?=$_GET['pesan'] ?></a>  Berhasil Di posting
				  </div>
				</div>
			<?php  }  else if (isset($_GET['pembatalan'])){ ?>
                <div class="form-group" id="form_report">
                  <div class="alert alert-dismissable" style="background-color: #9c0303cc; color: #f9e6c3">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color: #f9e6c3">&times;</button>
                      Pembatalan Kode FB :  <a style="color: white" href="<?=base_url()?>?page=keuangan/fb_track&halaman= TRACK FAKTUR PEMBELIAN&action=track&kode_fb=<?=$_GET['pembatalan']?>" target="_blank"><?=$_GET['pembatalan'] ?></a>  Berhasil Di batalkan
                  </div>
                </div>
            <?php } ?>

		<div class="tabbable">
			<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
				<li <?=$class_form?>>
					<a data-toggle="tab" href="#menuFormFb">Form Faktur Pembelian</a>
				</li>
                <li <?=$class_tab?>>
					<a data-toggle="tab" href="#menuListFb">List Faktur Pembelian</a>
				</li>
            </ul>

            <div class="row">
			<div class="tab-content">
				<div id="menuFormFb"
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
			                         	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode FB</label>
			                         	<div class="col-lg-4">
			                             	<input type="text" class="form-control" name="kode_fb" id="kode_fb" placeholder="Auto..." readonly value="">
			                         	</div> 

			                         	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Supplier</label>
			                         	<div class="col-lg-4">
			                             	<select id="supplier" name="supplier" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Supplier --</option>
                                                <?php
                                                //CEK JIKA supplier ADA MAKA SELECTED
                                                (isset($row['id_fb']) ? $supplier=$row['kode_supplier'] : $supplier='');
                                                //UNTUK AMBIL coanya
                                                while($row_supplier = mysql_fetch_array($q_supplier)) { ;?>

                                                <option value="<?php echo $row_supplier['kode_supplier'];?>" <?php if($row_supplier['kode_supplier']==$supplier){echo 'selected';} ?>><?php echo $row_supplier['kode_supplier'] . ' - ' . $row_supplier['nama_supplier'];?> </option>
                                                <?php } ?>
                                                <input type="hidden" name="kode_supplier1" id="kode_supplier1" class="form-control" value="<?php echo $row_supplier['kode_supplier'];?>"/>
                                             </select>
			                         	</div>
                         			 </div>

				                     <div class="form-group">
				                     	 <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
				                         <div class="col-lg-4">
				                             <input type="text" autocomplete="off" class="form-control" name="ref" id="ref" placeholder="Ref..." value="">
				                         </div>

				                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal JT</label>
				                         <div class="col-lg-4">
				                         	<div class="input-group" id="tgl_jt">
				                             <input type="text" name="tgl_jt_tempo" id="tgl_jt_tempo" class="form-control" placeholder="Pilih supplier dahulu ..." value="" readonly/>
				                             <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
				                            </div>
				                         </div>
				                     </div>

				                     <div class="form-group">
				                     	 <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal FB</label>
				                         <div class="col-lg-4">
				                         	<div class="input-group">
				                             <input type="text" name="tgl_fb" id="tgl_fb" class="form-control date-picker-close" placeholder="Tanggal Bukti Terima Barang ..." value="<?=date("m/d/Y")?>" autocomplete="off" readonly/>
				                             <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
				                            </div>
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
                                                    	<th style="width: 5%"></th>
                                                    	<th>Barang</th>
                                                        <th>No Doc PO</th>
                                                        <th>No Doc BTB</th>
                                                        <th>Harga</th>
                                                        <th>PPn</th>
                                                        <th>Subtotal</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="detail_input_fb">
                                                	<tr>
                                                         <td colspan="8" class="text-center"> Tidak ada item barang. </td>
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

                                            <a href="<?=base_url()?>?page=keuangan/fb&halaman= FAKTUR PEMBELIAN" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>
               						 </div>

					 					</form>

									</div>
                            	</div>
							</div>
						</div>
				</div>

				<div id="menuListFb" <?=$class_pane_tab?>>
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-body">

									<form action="" method="post" >

			                         	<div class="col-xs-12 col-md-4" style="margin-bottom:3mm">
                                      		<div class="input-group">
	                                      		<span class="input-group-addon point">Kode</span>
				                             	<input type="text" autocomplete="off" class="form-control" name="kode_fb" id="kode_fb" placeholder="Kode FB ..." value="<?php

													if(empty($_POST['kode_fb'])){
														echo "";

													}else{
														echo $_POST['kode_fb'];
													}

													?>">
				                            </div>
			                         	</div>

			                         	<div class="col-xs-12 col-md-4" style="margin-bottom:3mm">
                                      		<div class="input-group">
	                                      		<span class="input-group-addon point">Ref</span>
					                             <input type="text"autocomplete="off" class="form-control" name="ref" id="ref" placeholder="Ref..."
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
	                                      		<span class="input-group-addon point">Nominal</span>
				                             	<input type="text" autocomplete="off" class="form-control" name="nominal" id="nominal" placeholder="Nominal ..." value="<?php

													if(empty($_POST['nominal'])){
														echo "";

													}else{
														echo $_POST['nominal'];
													}

													?>">
				                            </div>
			                         	</div>

			                         	<div class="col-xs-12 col-md-6" style="margin-bottom:3mm">
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

				                     	<div class="col-xs-12 col-md-6" style="margin-bottom:3mm">
                                      		<div class="input-group">
	                                      		<span class="input-group-addon point">Supplier</span>
				                             	<select id="supplier" name="supplier" class="select2" style="width: 100%;">
                                                <option value="" selected>-- Pilih supplier --</option>
                                                <?php
                                                //CEK JIKA supplier ADA MAKA SELECTED
                                                (isset($_POST['supplier']) ? $supplier=$_POST['supplier'] : $supplier='');
                                                //UNTUK AMBIL coanya
                                                while($row_supplier = mysql_fetch_array($q_supplier_list)) { ;?>

                                                <option value="<?php echo $row_supplier['kode_supplier'];?>" <?php if($row_supplier['kode_supplier']==$supplier){echo 'selected';} ?>><?php echo $row_supplier['kode_supplier'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$row_supplier['nama_supplier'];?> </option>
                                                <?php } ?>
                                                </select>
				                         	</div>
				                    	</div>

			                         	<div class="col-xs-12 col-md-6" style="margin-bottom:3mm">
	                                        <div class="input-group">
	                                            <span class="input-group-addon">Tanggal Awal</i></span>
	                                            <input type="text" name="tanggal_awal" id="tanggal_awal" class="form-control date-picker" autocomplete="off" value="<?=date("m/d/Y")?>">
	                                            <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
	                                        </div>
	                                    </div>

	                                    <div class="col-xs-12 col-md-6" style="margin-bottom:3mm">
	                                        <div class="input-group">
	                                         	<span class="input-group-addon">Tanggal Akhir</span>
	                                         	<input type="text" name="tanggal_akhir" id="tanggal_akhir" class="form-control date-picker" autocomplete="off"value="<?=date("m/d/Y")?>">
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
									<table id="example1" class="table table-striped table-bordered table-hover" width="100%" >
										<thead>
											<tr>
												<th>No</th>
												<th>Kode</th>
												<th>Tanggal</th>
												<th>Ref</th>
												<th>Supplier</th>
												<th>Cabang</th>
                                                <th>Nominal</th>
                                                <th>Keterangan</th>
                                                <th>Status</th>
                                                <th></th>
											</tr>
										</thead>
										<tbody>

											<?php
												$n=1; if(mysql_num_rows($q_fb) > 0) {
												while($data = mysql_fetch_array($q_fb)) {

													if($data['status'] == '1'){
	        											$status = 'Open';
	        											$warna = 'style="background-color: #39b13940"';
	        											$print = '';
	        										}elseif($data['status'] == '2'){
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
												<td style="text-align: center"> <?php echo $n++ ?></td>
												<td><a href="<?=base_url()?>?page=keuangan/fb_track&action=track&halaman= TRACK FAKTUR PEMBELIAN&kode_fb=<?=$data['kode_fb']?>">
													<?php echo $data['kode_fb'];?></a></td>
												<td> <?php echo date("d-m-Y",strtotime($data['tgl_buat']));?></td>
												<td> <?php echo $data['ref'];?></td>
                                                <td> <?php echo $data['nama_supplier'];?></td>
												<td> <?php echo $data['nama_cabang'];?></td>
                                                <td style="text-align: right"> <?php echo number_format($data['harga'], 2);?></td>
                                                <td> <?php echo $data['keterangan_hdr'];?></td>
                                                <td style="text-align: center;"> <?php echo $status ?></td>
                                                <td style="font-size: 12px; text-align: center">
                                                	<a href="<?=base_url()?>r_cetak_fb.php?kode_fb=<?=$data['kode_fb']?>" title="cetak" target="_blank">
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

<?php unset($_SESSION['data_fb']); ?>

  <script>

  $(document).ready(function (e) {
	 $("#saveForm").on('submit',(function(e) {
		var grand_total = parseFloat(($("#grand_total").val() || 0).replace(/,/g, ''));
		if(grand_total == "" || isNaN(grand_total)) {grand_total = 0;}
		e.preventDefault();
	  	if(grand_total != 0 && grand_total > 0) {
			$(".animated").show();
			$.ajax({
				url: "<?=base_url()?>ajax/j_fb.php?func=save",
				type: "POST",
				data:  new FormData(this),
				contentType: false,
				cache: false,
				processData:false,
				success: function(html)
				{
					// console.log(html);
					var msg = html.split("||");
					if(msg[0] == "00") {
						//window.open('r_penjualan_cetak.php?noNota=' + msg[1], width=330,height=330,left=100, top=25);

						window.location = '<?=base_url()?>?page=keuangan/fb&halaman= FAKTUR PEMBELIAN&pesan='+msg[1];
					} else {
						notifError(msg[1]);
					}
					$(".animated").hide();
				}

		   });
	  	} else {notifError("<p>Item  masih kosong.</p>");}
	 }));
  });

$('#kode_cabang').change(function(){
	var kode_supplier 		= $("#supplier").val();
	var kode_cabang			= $("#kode_cabang").val();
		$.ajax({
				type : "POST",
				url  : "<?=base_url()?>ajax/j_fb.php?func=loaditem",
				data : "kode_supplier="+kode_supplier+"&kode_cabang="+kode_cabang,
				cache:false,
				success: function(data) {
					$('#detail_input_fb').html(data);
					hitungdetailbawah();
				}
			});		

});


$('#supplier, #tgl_fb').change(function(){
	var kode_supplier 		= $("#supplier").val();
	var kode_cabang			= $("#kode_cabang").val();
	var tgl_buat			= $("#tgl_fb").val();
		$.ajax({
				type : "POST",
				url  : "<?=base_url()?>ajax/j_fb.php?func=loaditem",
				data : "kode_supplier="+kode_supplier+"&kode_cabang="+kode_cabang,
				cache:false,
				success: function(data) {
					$('#detail_input_fb').html(data);
					hitungdetailbawah();
				}
			});

        $.ajax({
            type: "POST",
            url: "<?=base_url()?>ajax/j_fb.php?func=loadjt",
            data: "kode_supplier="+kode_supplier+"&tgl_buat="+tgl_buat,
            cache:false,
            success: function(data) {
                $('#tgl_jt').html(data);
            }
		});
});

		function numberjs(){
			$("[name='subtotal_all']").number( true, 2 );
			$("[name='ppn_all']").number( true, 2 );
			$("[name='grand_total']").number( true, 2 );
		}

function hitungdetailbawah() {
	var
		harga = 0,
		ppn = 0,
		subtotal = 0;
	
	$("[name='cb[]']").click(function(){
		var 
			is_checked = $(this).prop('checked'), 
			tr = $(this).parents('tr'),
			in_subtotal = tr.find("[data-id='subtotal']").val(),
			in_ppn = tr.find("[data-id='ppn']").val(),
			in_harga = tr.find("[data-id='harga']").val();
			
		in_subtotal = parseFloat(in_subtotal);
		in_ppn = parseFloat(in_ppn);
		in_harga = parseFloat(in_harga);

		if(is_checked == true) {
			subtotal += in_subtotal;
			ppn += in_ppn;
			harga += in_harga;
		}
		else {
			subtotal -= in_subtotal;
			ppn -= in_ppn;
			harga -= in_harga;
		}

		numberjs();
		$('#grand_total').val(subtotal);
		$('#ppn_all').val(ppn);
		$('#subtotal_all').val(harga);
	});
}

</script>

<!-- <script src="<?=base_url()?>assets/select2/select2.js"></script> -->
<script>

  $(function () {
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
<script>
	$(".select2").select2({
          width: '100%'
         });
</script>

