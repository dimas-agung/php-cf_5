<?php
	include "pages/data/script/fj.php";
	include "library/form_akses.php";
?>
<section class="content-header">
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-money"></i>Keuangan</a></li>
          <li>
          	<a href="#">Faktur Penjualan</a>
          </li>
        </ol>
</section>


<div class="box box-info">
    <div class="box-body">

    		<?php if (isset($_GET['pesan'])){ ?>
				<div class="form-group" id="form_report">
				  <div class="alert alert-success alert-dismissable">
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					  Kode FJ :  <a href="<?=base_url()?>?page=penjualan/fj_track&action=track&halaman= TRACK FAKTUR PENJUALAN&kode_fj=<?=$_GET['pesan']?>" target="_blank"><?=$_GET['pesan'] ?></a>  Berhasil Di posting
				  </div>
				</div>
			<?php  }else if (isset($_GET['pembatalan'])){ ?>
		        <div class="form-group" id="form_report">
		          <div class="alert alert-dismissable" style="background-color: #9c0303cc; color: #f9e6c3">
		            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color: #f9e6c3">&times;</button>
		            Pembatalan Kode FJ :  <a style="color: white" href="<?=base_url()?>?page=penjualan/fj_track&halaman= TRACK FAKTUR PENJUALAN&action=track&kode_fj=<?=$_GET['pembatalan']?>" target="_blank"><?=$_GET['pembatalan'] ?></a>  Berhasil Di batalkan
		          </div>
		        </div>
		    <?php } ?>

		<div class="tabbable">
			<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
				<li <?=$class_form?>>
					<a data-toggle="tab" href="#menuFormFj">Form Faktur Penjualan</a>
				</li>
                <li <?=$class_tab?>>
					<a data-toggle="tab" href="#menuListFj">List Faktur Penjualan</a>
				</li>
            </ul>

            <div class="row">
			<div class="tab-content">
				<div id="menuFormFj"
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
			    <!-- Kode FJ -->		<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode FJ</label>
			                         	<div class="col-lg-4">
			                             	<input type="text" class="form-control" name="kode_fj" id="kode_fj" placeholder="Auto..." readonly value="">
			                         	</div>

			    <!-- Pelanggan -->      <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Pelanggan</label>
			                         	<div class="col-lg-4">
			                             	<input type="text" class="form-control" id="pelanggan" name="pelanggan" style="width: 100%;" value="" placeholder="Pilih Kode SJ Dahulu ..." readonly>
			                             	<input type="hidden" class="form-control" id="kode_pelanggan" name="kode_pelanggan" style="width: 100%;" value="" placeholder="Pilih Kode SJ Dahulu ..." readonly>
			                         	</div>
                         			 </div>

				                     <div class="form-group">
				                     	 <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal FJ</label>
				                         <div class="col-lg-4">
				                         	<div class="input-group">
				                             <input type="text" name="tgl_fj" id="tgl_fj" class="form-control date-picker-close" placeholder="Tanggal Faktur Penjualan ..." value="<?=date("m/d/Y")?>" autocomplete="off"/>
				                             <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
				                            </div>
				                         </div>

				                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal JT</label>
				                         <div class="col-lg-4">
				                         	<div class="input-group" id="load_jt">
				                             <input type="text" name="tgl_jt_tempo" id="tgl_jt_tempo" class="form-control" placeholder="Pilih Kode SJ Dahulu ..." value="" readonly />
				                             <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
				                            </div>
				                         </div>
				                     </div>

				                     <div class="form-group">
				                     	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
				                         <div class="col-lg-4">
				                             <input type="text" autocomplete="off" class="form-control" name="ref" id="ref" placeholder="Ref..." value="">
				                         </div>

				                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Salesman</label>
				                         <div class="col-lg-4">
                                             <input class="form-control" id="salesman" name="salesmanx" style="width: 100%;" value="" placeholder="Pilih Kode SJ Dahulu ..." readonly>
                                             <input type="hidden" name="salesman" />
				                         </div>
				                     </div>

				                     <div class="form-group">
				                     	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Dokumen SJ</label>
				                         <div class="col-lg-4">
				                             <select id="kode_sj" name="kode_sj" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Dokumen SJ --</option>
                                                <?php
                                                (isset($row['id_fj']) ? $sj=$row['kode_sj'] : $sj='');
                                                while($rowsj = mysql_fetch_array($q_doc_sj)) { ;?>
                                                <option
                                                	data-kode-cabang="<?php echo $rowsj['kode_cabang'];?>"
                                                	data-nama-cabang="<?php echo $rowsj['kode_cabang'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowsj['nama_cabang'];?>"
                                                	data-kode-gudang="<?php echo $rowsj['kode_gudang'];?>"
                                                	data-nama-gudang="<?php echo $rowsj['kode_gudang'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowsj['nama_gudang'];?>"
                                                	data-kode-pelanggan="<?php echo $rowsj['kode_pelanggan'];?>"
                                                	data-nama-pelanggan="<?php echo $rowsj['kode_pelanggan'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowsj['nama_pelanggan'];?>"
                                                	data-salesman="<?php echo $rowsj['salesman'];?>"
	                                                value="<?php echo $rowsj['kode_sj'];?>"
	                                                <?php if($rowsj['kode_sj']==$sj){echo 'selected';} ?> >
	                                                <?php echo $rowsj['kode_sj'];?>
                                            	</option>
                                                <?php } ?>
                                             </select>
				                         </div>
				                     </div>

				                     <div class="form-group">
				                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
				                         <div class="col-lg-4">
				                             <input type="text" class="form-control" id="cabang" name="cabang" style="width: 100%;" value="" placeholder="Pilih Kode SJ Dahulu ..." readonly>
				                             <input type="hidden" class="form-control" id="kode_cabang" name="kode_cabang" style="width: 100%;" value="" placeholder="Pilih Kode SJ Dahulu ..." readonly>
				                         </div>
				                     </div>

				                     <div class="form-group">
				                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Gudang</label>
				                         <div class="col-lg-4">
				                             <input type="text" class="form-control" id="gudang" name="gudang"  style="width: 100%;" value="" placeholder="Pilih Kode SJ Dahulu ..." readonly>
				                             <input type="hidden" class="form-control" id="kode_gudang" name="kode_gudang" style="width: 100%;" value="" placeholder="Pilih Kode SJ Dahulu ..." readonly>
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
                                                    	<th></th>
                                                        <th>Kode</th>
                                                        <th>Diskripsi Barang</th>
                                                        <th>FOC</th>
                                                        <th>Satuan</th>
                                                        <th>Jumlah</th>
                                                        <th>Harga Jual</th>
                                                        <th>Disc1(%)</th>
                                                        <th>Disc2(%)</th>
                                                        <th>PPN</th>
                                                        <th>Nominal</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="detail_input_fj">
                                                	<tr>
                                                         <td colspan="15" class="text-center"> Tidak ada item barang. </td>
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

											<button type="submit" name="simpan" id="simpan" class="btn btn-primary" tabindex="10"><i class="fa fa-check-square-o"></i> Simpan</button>
                                            <?php } } } ?>

                                            <a href="<?=base_url()?>?page=penjualan/fj&halaman= FAKTUR PENJUALAN" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>
               						 </div>

					 					</form>

									</div>
                            	</div>
							</div>
						</div>
				</div>

				<div id="menuListFj" <?=$class_pane_tab?>>
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-body">

									<form action="" method="post" >

			                         	<!-- <div class="col-xs-12 col-md-4" style="margin-bottom:3mm">
                                      		<div class="input-group">
	                                      		<span class="input-group-addon point">Kode</span>
				                             	<input type="text" autocomplete="off" class="form-control" name="kode_fj" id="kode_fj" placeholder="Kode FJ ..." value="<?php

													if(empty($_POST['kode_fj'])){
														echo "";

													}else{
														echo $_POST['kode_fj'];
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

                                                <option value="<?php echo $row_cabang['kode_cabang'];?>" <?php if($row_cabang['kode_cabang']==$cabang){echo 'selected';} ?>><?php echo $row_cabang['nama_cabang'];?> </option>
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

                                                <option value="<?php echo $row_supplier['kode_supplier'];?>" <?php if($row_supplier['kode_supplier']==$supplier){echo 'selected';} ?>><?php echo $row_supplier['nama_supplier'];?> </option>
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
 -->
									<div class="box-body">
									<table id="example1" class="table table-striped table-bordered table-hover" style="width:100%" >
										<thead>
											<tr>
												<th style="width: 5px">No</th>
												<th>Kode FJ</th>
												<th>Ref</th>
												<th>Tanggal FJ</th>
												<th>Tanggal JT</th>
												<th>Cabang</th>
                                                <th>Gudang</th>
                                                <th>Pelanggan</th>
                                                <th>PPN</th>
                                                <th>Total FJ</th>
                                                <th>Status</th>
                                                <th></th>
											</tr>
										</thead>
										<tbody>

											<?php
												$n=1;
												if(mysql_num_rows($q_fj) > 0) {
													while($data = mysql_fetch_array($q_fj)) {

													if($data['status'] == '1'){
	        											$status = 'Open';
	        											$warna = 'style="background-color: #39b13940"';
	        										}elseif($data['status'] == '2'){
	        											$status = 'Batal';
	        											$warna = 'style="background-color: #de4b4b63;"';
	        										}else{
	        											$status = 'Close';
	        											$warna = 'style="background-color: #ffd10045;"';
	        										}
											?>

											<tr <?= $warna?>>
												<td style="text-align: center; width: 10px"> <?php echo $n++ ?></td>
												<td> <a href="<?=base_url()?>?page=penjualan/fj_track&action=track&halaman= TRACK FAKTUR PENJUALAN&kode_fj=<?=$data['kode_fj']?>">
													 <?php echo $data['kode_fj'];?></a></td>
												<td> <?php echo $data['ref'];?></td>
												<td> <?php echo date("d-m-Y",strtotime($data['tgl_buat']));?></td>
												<td> <?php echo date("d-m-Y",strtotime($data['tgl_jth_tempo']));?></td>
                                                <td> <?php echo $data['nama_cabang'];?></td>
												<td> <?php echo $data['nama_gudang'];?></td>
												<td> <?php echo $data['nama_pelanggan'];?></td>
												<td style="text-align: right"> <?php echo number_format($data['ppn_all']);?></td>
                                                <td style="text-align: right"> <?php echo number_format($data['grand_total']);?></td>
                                                <td style="text-align: center;"> <?php echo $status ?></td>
                                                <td style="text-align: center">
		                                            <a href="<?=base_url()?>r_cetak_fj.php?kode_fj=<?=$data['kode_fj']?>" title="cetak" target="_blank">
		                                                <button type="button" class="btn btn-success btn-sm">
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

<?php unset($_SESSION['data_fj']); ?>

<script>

  	harga = 0;
  	subtotal = 0;
	ppn = 0;

  $(document).ready(function (e) {
	 $("#saveForm").on('submit',(function(e) {
		var grand_total = parseFloat($("#grand_total").val());
		if(grand_total == "" || isNaN(grand_total)) {grand_total = 0;}
		e.preventDefault();
	  	if(grand_total != 0 && grand_total > 0) {
			$(".animated").show();
			$.ajax({
				url: "<?=base_url()?>ajax/j_fj.php?func=save",
				type: "POST",
				data:  new FormData(this),
				contentType: false,
				cache: false,
				processData:false,
				success: function(html)
				{
					var msg = html.split("||");
					if(msg[0] == "00") {
						window.location = '<?=base_url()?>?page=penjualan/fj&halaman= FAKTUR PENJUALAN&pesan='+msg[1];
					} else {
						notifError(msg[1]);
					}
					$(".animated").hide();
				}

		   });
	  	} else {notifError("<p>Item  masih kosong.</p>");}
	 }));
  });

$('#kode_sj').change(function(event){
   event.preventDefault();
   var kode_cabang 	  = $("#kode_sj").find(':selected').attr('data-kode-cabang');
   var nama_cabang 	  = $("#kode_sj").find(':selected').attr('data-nama-cabang');
   var kode_gudang 	  = $("#kode_sj").find(':selected').attr('data-kode-gudang');
   var nama_gudang 	  = $("#kode_sj").find(':selected').attr('data-nama-gudang');
   var kode_pelanggan = $("#kode_sj").find(':selected').attr('data-kode-pelanggan');
   var nama_pelanggan = $("#kode_sj").find(':selected').attr('data-nama-pelanggan');
   var salesman   	  = $("#kode_sj").find(':selected').attr('data-salesman');

   if (salesman.length && salesman.indexOf(':') !== -1) {
       var
        sales = salesman.split(':');
        if (sales.length) {
            $('input[name="salesman"]').val(sales[0]);
            $('#salesman').val(sales[1]);
        }
   }
   $('#kode_cabang').val(kode_cabang);
   $('#cabang').val(nama_cabang);
   $('#kode_gudang').val(kode_gudang);
   $('#gudang').val(nama_gudang);
   $('#kode_pelanggan').val(kode_pelanggan);
   $('#pelanggan').val(nama_pelanggan);

});

$('#kode_sj,#tgl_fj').change(function(){
    var kode_sj = $("#kode_sj").val();
    var tgl_fj = $("#tgl_fj").val();

        $.ajax({
            type: "POST",
            url: "<?=base_url()?>ajax/j_fj.php?func=loadjt",
            data: "kode_sj="+kode_sj+"&tgl_fj="+tgl_fj,
            cache:false,
            success: function(data) {
                $('#load_jt').html(data);
            }
		});
});

$('#kode_sj').change(function(){
	var kode_sj = $("#kode_sj").val();
		$.ajax({
				type: "POST",
				url: "<?=base_url()?>ajax/j_fj.php?func=loaditem",
				data: "kode_sj="+kode_sj,
				cache:false,
				success: function(data) {
					$('#detail_input_fj').html(data);
					Hitungdaricb();

				}
			});

function Hitungdaricb(){

		$("[name='cb[]']").click(function(){

		var subtotal	=0;
		var stat_cb		=0;
		var harga		=0;
		var qty			=0;
		var diskon_all	=0;
		var ppn_all		=0;
		var nominal_all =0;
		var grandtotal_all	=0;

			$('table tbody tr').each(function() {

				var $tr = $(this);

				if ($tr.find('input[data-id="cb"]').is(':checked')) {

					var stat_cb	= 1;

					var qty			= parseInt($tr.find('input[data-id="qty"]').val());
					var harga		= parseInt($tr.find('input[data-id="harga"]').val());
					var diskon1 	= parseInt($tr.find('input[data-id="diskon1"]').val()) || 0;
					var diskon2 	= parseInt($tr.find('input[data-id="diskon2"]').val()) || 0;

			 		var diskon 		= parseInt(((diskon1+diskon2)/100)*harga);
			 		var diskon_dtl	= parseInt(diskon*qty);

					//var nominal	= parseInt($tr.find('input[data-id="nominal"]').val());

					if ($tr.find('input[data-id="ppn"]').is(':checked')){
						var nilai_ppn 	= parseInt((harga-diskon)*0.1);
						var stat_ppn 	= 1;
					}else{
						var nilai_ppn 	= 0;
						var stat_ppn 	= 0;
					}

					var stat_ppn	= parseInt($tr.find('input[data-id="stat_ppn"]').val(stat_ppn));

					//HITUNG SUBTOTAL
					var subtot = parseInt(qty*harga);
					subtotal += subtot;

					//HITUNG DISKON DETAIL
					var diskon_dtl = parseInt(diskon_dtl);
					diskon_all += diskon_dtl;

					//HITUNG PPN DETAIL
					var nilai_ppn_dtl = parseInt(nilai_ppn*qty);
					ppn_all += nilai_ppn_dtl;
					// console.log(ppn_all);

					//HITUNG NOMINAL
					var nominal = parseInt((subtot-diskon_dtl)+nilai_ppn_dtl);
					nominal_all += nominal;
					var nominal 	= parseInt($tr.find('input[data-id="nominal"]').val(nominal_all));

					//HITUNG GRAND TOTAL
					var grandtotal = parseInt((subtotal-diskon_all)+ppn_all);
					grandtotal_all += grandtotal;

				}
			});


			$('#subtotal_all').val(subtotal);
			$('#diskon_all').val(diskon_all);
			$('#ppn_all').val(ppn_all);
			$('#grand_total').val(grandtotal_all);

		});

	}

	$(document).on("change paste keyup", "input[data-id='diskon2']", function(){

		var stat_cb		=0;
		var stat_ppn	=0;
		var harga		=0;
		var qty			=0;
		var diskon_all	=0;
		var ppn_all		=0;
		var subtotal	=0;
		var nominal_all =0;
		var grandtotal_all	=0;

			$('table tbody tr').each(function() {

				var $tr = $(this);

				if ($tr.find('input[data-id="cb"]').is(':checked')) {

					var stat_cb	= 1;

					var qty			= $tr.find('input[data-id="qty"]').val();
					var harga		= $tr.find('input[data-id="harga"]').val();
					var diskon1 	= parseInt($tr.find('input[data-id="diskon1"]').val());
					var diskon2 	= parseInt($tr.find('input[data-id="diskon2"]').val()) || 0;

			 		var diskon 		= parseInt(((diskon1+diskon2)/100)*harga);
			 		var diskon_dtl	= parseInt(diskon*qty);

					if ($tr.find('input[data-id="ppn"]').is(':checked')){
						var nilai_ppn 	= parseInt((harga-diskon)*0.1);
						var stat_ppn 	= 1;
					}else{
						var nilai_ppn 	= 0;
						var stat_ppn 	= 0;
					}

					var stat_ppn	= parseInt($tr.find('input[data-id="stat_ppn"]').val(stat_ppn));

					//HITUNG SUBTOTAL
					var subtot = parseInt(qty*harga);
					subtotal += subtot;

					//HITUNG DISKON DETAIL
					var diskon_dtl = parseInt(diskon_dtl);
					diskon_all += diskon_dtl;

					//HITUNG PPN DETAIL
					var nilai_ppn_dtl = parseInt(nilai_ppn*qty);
					ppn_all += nilai_ppn_dtl;
					// console.log(ppn_all);

					//HITUNG NOMINAL
					var nominal = parseInt((subtot-diskon_dtl)+nilai_ppn_dtl);
					nominal_all += nominal;
					var nominal 	= parseInt($tr.find('input[data-id="nominal"]').val(nominal_all));

					//HITUNG GRAND TOTAL
					var grandtotal = parseInt((subtotal-diskon_all)+ppn_all);
					grandtotal_all += grandtotal;


				}
			});

			$('#subtotal_all').val(subtotal);
			$('#diskon_all').val(diskon_all);
			$('#ppn_all').val(ppn_all);
			$('#grand_total').val(grandtotal_all);


		//alert('diskon2');
		//Hitungdaricb();
	});

	$(document).on("change paste keyup", "input[data-id='ppn']", function(){
		var subtotal	=0;
		var stat_cb		=0;
		var stat_ppn	=0;
		var harga		=0;
		var qty			=0;
		var diskon_all	=0;
		var ppn_all		=0;
		var nominal_all =0;
		var grandtotal_all	=0;
			$('table tbody tr').each(function() {

				var $tr = $(this);

				if ($tr.find('input[data-id="cb"]').is(':checked')) {

					var stat_cb	= 1;

					var qty			= parseInt($tr.find('input[data-id="qty"]').val());
					var harga		= parseInt($tr.find('input[data-id="harga"]').val());
					var diskon1 	= parseInt($tr.find('input[data-id="diskon1"]').val());
					var diskon2 	= parseInt($tr.find('input[data-id="diskon2"]').val()) || 0;

			 		var diskon 		= parseInt(((diskon1+diskon2)/100)*harga);
			 		var diskon_dtl	= parseInt(diskon*qty);

					//var nominal	= parseInt($tr.find('input[data-id="nominal"]').val());

					if ($tr.find('input[data-id="ppn"]').is(':checked')){
						var nilai_ppn 	= parseInt((harga-diskon)*0.1);
						var stat_ppn 	= 1;
					}else{
						var nilai_ppn 	= 0;
						var stat_ppn 	= 0;
					}

					var stat_ppn	= parseInt($tr.find('input[data-id="stat_ppn"]').val(stat_ppn));

					//HITUNG SUBTOTAL
					var subtot = parseInt(qty*harga);
					subtotal += subtot;

					//HITUNG DISKON DETAIL
					var diskon_dtl = parseInt(diskon_dtl);
					diskon_all += diskon_dtl;

					//HITUNG PPN DETAIL
					var nilai_ppn_dtl = parseInt(nilai_ppn*qty);
					ppn_all += nilai_ppn_dtl;
					// console.log(ppn_all);

					//HITUNG NOMINAL
					var nominal = parseInt((subtot-diskon_dtl)+nilai_ppn_dtl);
					nominal_all += nominal;
					var nominal 	= parseInt($tr.find('input[data-id="nominal"]').val(nominal_all));

					//HITUNG GRAND TOTAL
					var grandtotal = parseInt((subtotal-diskon_all)+ppn_all);
					grandtotal_all += grandtotal;

				}
			});

			$('#subtotal_all').val(subtotal);
			$('#diskon_all').val(diskon_all);
			$('#ppn_all').val(ppn_all);
			$('#grand_total').val(grandtotal_all);



		//alert('ppn');
		//Hitungdaricb();
	});

});

</script>

<script src="<?=base_url()?>assets/select2/select2.js"></script>
<script>

  $(function () {
    $( "#tgl_fj" ).datepicker();
    $( "#tanggal_awal" ).datepicker();
    $( "#tanggal_akhir" ).datepicker();
    $('#example1').DataTable({
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
