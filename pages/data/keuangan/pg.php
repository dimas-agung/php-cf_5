<?php
	include "pages/data/script/pg.php";
	include "library/form_akses.php";
?>
<section class="content-header">
    <ol class="breadcrumb">
        <li><i class="fa fa-money"></i>Keuangan</a></li>
        <li>Pelunasan Giro</a>
        </li>
    </ol>
</section>


<div class="box box-info">
    <div class="box-body">

    		<?php if (isset($_GET['pesan'])){ ?>
				<div class="form-group" id="form_report">
				  <div class="alert alert-success alert-dismissable">
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					  Kode PG :  <a href="<?=base_url()?>?page=keuangan/pg_track&halaman= TRACK PELUNASAN GIRO&action=track&kode_pg=<?=$_GET['pesan']?>" target="_blank"><?=$_GET['pesan'] ?></a>  Berhasil Di posting
				  </div>
				</div>

			<?php }else if (isset($_GET['pembatalan'])){ ?>
				<div class="form-group" id="form_report">
				  <div class="alert alert-dismissable" style="background-color: #9c0303cc; color: #f9e6c3">
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color: #f9e6c3">&times;</button>
					  Pembatalan Kode PG :  <a style="color: white" href="<?=base_url()?>?page=keuangan/pg_track&halaman= TRACK PELUNASAN GIRO&action=track&kode_pg=<?=$_GET['pembatalan']?>" target="_blank"><?=$_GET['pembatalan'] ?></a>  Berhasil Di batalkan
				  </div>
				</div>
			<?php }else if (isset($_GET['pengembalian'])){ ?>
				<div class="form-group" id="form_report">
				  <div class="alert alert-dismissable" style="background-color: #efb25ade; font-family: Trebuchet MS;">
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					  <b>Pengembalian Kode PG :  <a href="<?=base_url()?>?page=keuangan/pg_track&halaman= TRACK PELUNASAN GIRO&action=track&kode_pg=<?=$_GET['pengembalian']?>" target="_blank"><?=$_GET['pengembalian'] ?></a>  Berhasil Di posting</b>
				  </div>
				</div>
			<?php } ?>

		<div class="tabbable">
			<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
				<li <?=$class_form?>>
					<a data-toggle="tab" href="#menuFormPg">Form Pelunasan Giro</a>
				</li>
                <li <?=$class_tab?>>
					<a data-toggle="tab" href="#menuListPg">List Pelunasan Giro</a>
				</li>
            </ul>

            <div class="row">
			<div class="tab-content">
				<div id="menuFormPg"
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

			                         <div class="form-group">
			                         	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode PG</label>
			                         	<div class="col-lg-4">
			                             	<input type="text" class="form-control" name="kode_pg" id="kode_pg" placeholder="Auto..." readonly value="">
			                         	</div>

			                         	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">COA</label>
                                        <div class="col-lg-4">
                                            <select id="bank_coa" name="bank_coa" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih COA --</option>
                                                <?php
                                                    while($row_pembayaran = mysql_fetch_array($q_pembayaran)) { ;?>
                                                    <option
                                                    	data-nama="<?php echo $row_pembayaran['singkatan'];?>"
                                                    	value="<?php echo $row_pembayaran['kode_coa'];?>" class="<?=($row_pembayaran['group_coa'] === '0' || $row_pembayaran['group_coa'] === 0 ? 'hidden' : ''); ?>" data-group-coa="<?=$row_pembayaran['group_coa'];?>">
                                                        <?php echo $row_pembayaran['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$row_pembayaran['nama_coa'];?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                            <input type="hidden" name="kode_coa_save" id="kode_coa_save" class="form-control" value=""/>
                                        </div>
                         			 </div>

                         			 <div class="form-group">
				                     	 <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal Buat</label>
				                         <div class="col-lg-4">
				                         	<div class="input-group">
				                             <input type="text" name="tgl_buat" id="tgl_buat" class="form-control date-picker-close" placeholder="Tanggal Bukti Kas Keluar ..." value="<?=date("m/d/Y")?>" autocomplete="off" readonly/>
				                             <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
				                            </div>
				                         </div>

				                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
				                         <div class="col-lg-4">
				                             <select id="kode_cabang" name="kode_cabang" class="select2" style="width: 100%;">
                                                <option value="">-- Pilih Cabang --</option>
                                                <?php
                                                    while($row_cabang = mysql_fetch_array($q_cabang)) { ;?>
                                                    <option value="<?php echo $row_cabang['kode_cabang'];?>">
                                                        <?php echo $row_cabang['nama_cabang'];?>
                                                    </option>
                                                <?php } ?>
                                             </select>
				                         </div>
				                     </div>

								<div class="form-group">
	                            	<label style="text-align:left" class="col-lg-2 col-sm-2 control-label">Ref</label>
	                                <div class="col-lg-4">
	                                    <div class="input-group">
	                                        <input type="text" autocomplete="off" class="form-control" name="ref" id="ref" placeholder="Ref..." value="">
	                                    </div>
	                                </div>

	                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Pelanggan / Supplier</label>
	                                <div class="col-lg-4">
	                                	<input type="hidden" class="form-control" name="user" id="user" value="" readonly/>
	                                	<input type="hidden" class="form-control" name="kode_user" id="kode_user" value="" readonly/>
	                                	<input type="hidden" class="form-control" name="nama_user" id="nama_user" value="" readonly/>
		                                <div class="radio">
		                                    <label for="rad1"><input type="radio" name="rad" id="rad1" value="1" class="rad"/> Pelanggan</label>
		                                </div>
	                                	<div class="radio">
      										<label for="rad2"><input type="radio" name="rad" id="rad2" value="2" class="rad"/> Supplier</label>
      									</div>
	                                </div>
	                            </div>

	                            <div class="form-group">
	                            	<label class="col-lg-8 col-sm-2 control-label" style="text-align:left"></label>
	                                <div id="form3" class="col-lg-4">
	                                    <select class="select2" disabled>
	                                        <option name="tidak_ada_kode" id="tidak_ada_kode" value="0">-- Pilih --</option>
	                                    </select>
	                                </div>
	                                <div id="pelanggan" style="display:none" class="col-lg-4">
								        <select id="kode_pelanggan" name="kode_pelanggan" class="select2">
	                                        <option value="0">-- Pilih Pelanggan --</option>
	                                            <?php while($rowpelanggan = mysql_fetch_array($q_pel_aktif)) { ;?>
	                                                <option
	                                                	data-nama-pelanggan = "<?php echo $rowpelanggan['nama_pelanggan'];?>"
	                                                	value="<?php echo $rowpelanggan['kode_pelanggan'];?>">
	                                                	<?php echo $rowpelanggan['kode_pelanggan'] . ' - ' . $rowpelanggan['nama_pelanggan'];?>
	                                                </option>
	                                            <?php } ?>
	                                    </select>
								    </div>
								    <div id="supplier" style="display:none" class="col-lg-4">
								        <select id="kode_supplier" name="kode_supplier" class="select2">
	                                        <option value="0">-- Pilih Supplier --</option>
	                                            <?php while($rowsupplier = mysql_fetch_array($q_sup_aktif)) { ;?>
	                                                <option
	                                                	data-nama-supplier = "<?php echo $rowsupplier['nama_supplier'];?>"
	                                                	value="<?php echo $rowsupplier['kode_supplier'];?>">
	                                                	<?php echo $rowsupplier['kode_supplier'] . ' - ' . $rowsupplier['nama_supplier'];?>
	                                                </option>
	                                            <?php } ?>
	                                    </select>
								    </div>
	                            </div>
								<div class="form-group">
	                            	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode Giro</label>
	                                <div class="col-lg-4">
								        <select id="kode_giro" name="kode_giro" class="select2" disabled>
	                                        <option value="0">-- Pilih Pelanggan / Supplier Dahulu --</option>
	                                    </select>
								    </div>
	                            </div>
																		
				                     <div class="form-group">
				                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
				                         <div class="col-lg-10">
				                             <textarea type="text" class="form-control" name="keterangan_hdr" id="keterangan_hdr" placeholder="Keterangan..." value=""></textarea>
				                         </div>
				                     </div>

				                     <div class="form-group">
                     	                <div class="col-md-12">
                                            <table id="" class="" rules="all">
                                                <thead>
                                                    <tr>
                                                    	<th></th>
                                                    	<th>Bank Giro</th>
                                                        <th>No Giro</th>
                                                        <th>Tgl Jatuh Giro</th>
                                                        <th>Tolak Giro</th>
                                                        <th>Nominal</th>
                                                        <th>Nominal Ditolak</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="detail_input_pg">
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

                                            <a href="<?=base_url()?>?page=keuangan/pg&halaman= PELUNASAN GIRO" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>
               						 </div>

					 					</form>
								<div class="copy">

                                </div>
									</div>
                            	</div>
							</div>
						</div>
				</div>

				<div id="menuListPg" <?=$class_pane_tab?>>
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-body">

									<!-- <form action="" method="post" >

			                         	<div class="col-xs-12 col-md-4" style="margin-bottom:3mm">
                                      		<div class="input-group">
	                                      		<span class="input-group-addon point">Kode</span>
				                             	<input type="text" autocomplete="off" class="form-control" name="kode_pg" id="kode_pg" placeholder="Kode pg ..." value="<?php

													if(empty($_POST['kode_pg'])){
														echo "";

													}else{
														echo $_POST['kode_pg'];
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
	                                            <span class="input-group-addon point">Status</span>
	                                              	<select id="status" name="status" class="select2" style="width: 100%;">
	                                                	<option value="" selected>-- Pilih Status --</option>
	                                                	<option value="1">READY</option>
	                                                	<option value="0">BATAL</option>
	                                              	</select>
	                                        </div>
	                                    </div>

				                        <div class="col-xs-12 col-md-4" style="margin-bottom:3mm">
                                      		<div class="input-group">
	                                      	  <span class="input-group-addon point">Metode Rekening</span>
				                             	<select id="kode_coa" name="kode_coa" class="select2" style="width: 100%;">
	                                                <option value="" selected>-- Pilih Metode Rekening --</option>
	                                                <?php
		                                                while($row_coa = mysql_fetch_array($q_pembayaran_list)) { ;?>

		                                                <option value="<?php echo $row_coa['kode_coa'];?>"><?php echo $row_coa['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$row_coa['nama_coa'];?> </option>
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

                                                <option value="<?php echo $row_cabang['kode_cabang'];?>"><?php echo $row_cabang['kode_cabang'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$row_cabang['nama_cabang'];?> </option>
                                                <?php } ?>
                                                </select>
				                         	</div>
				                        </div>

				                     	<div class="col-xs-12 col-md-4" style="margin-bottom:3mm">
                                      		<div class="input-group">
	                                      		<span class="input-group-addon point">Pelanggan</span>
				                             	<select id="kode_user" name="kode_user" class="select2" style="width: 100%;">
                                                <option value="" selected>-- Pilih User --</option>
                                                <?php
                                                while($row_user = mysql_fetch_array($q_user_list)) { ;?>

                                                <option
                                                	value="<?php echo $row_user['kode_user'];?>"><?php echo $row_user['kode_user'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$row_user['nama_user'];?> </option>
                                                <?php } ?>
                                                </select>
				                         	</div>
				                    	</div>

			                         	<div class="col-xs-12 col-md-6" style="margin-bottom:3mm">
	                                        <div class="input-group">
	                                            <span class="input-group-addon">Tanggal Awal</i></span>
	                                            <input type="text" name="tanggal_awal" id="tanggal_awal" class="form-control date-picker" autocomplete="off" value="<?=date("m/d/Y", strtotime('-1 month'))?>">
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
                                	</form> -->

									<div class="box-body">
									<table id="example1" class="table table-striped table-bordered table-hover" width="100%" >
										<thead>
											<tr>
												<th>No</th>
                                                <th>Kode PG</th>
                                                <th>User</th>
												<th>Tanggal Pelunasan</th>
												<th>Bank</th>
												<th>Nominal</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>

											<?php
												$n=1;
                                                if(mysql_num_rows($q_pg) > 0) {
												    while($data = mysql_fetch_array($q_pg)) {

												    if($data['status_dtl'] == '3'){
	        											$status = 'Lunas';
	        											$warna = 'style="background-color: #39b13940"';
	        										}else{
	        											$status = 'Tolak';
	        											$warna = 'style="background-color: #de4b4b63;"';
	        										}
											?>
    											    <tr <?= $warna?>>
        												<td style="text-align: center"> <?php echo $n++ ?></td>
        												<td> <a href="<?=base_url()?>?page=keuangan/pg_track&action=track&halaman= TRACK PELUNASAN GIRO&kode_pg=<?=$data['kode_pg']?>">
        													 <?php echo $data['kode_pg'];?></a>
                                                        </td>
                                                        <td> <?php echo $data['nama_user'];?></td>
        												<td> <?php echo strftime("%A, %d %B %Y", strtotime($data['tgl_buat']));?></td>
        												<td> <?php echo $data['bank_coa'].'&nbsp;&nbsp; || &nbsp;&nbsp;'.$data['nama_bank_coa'];?></td>
        												<td style="text-align: right"> <?php echo number_format($data['nominal'], 2);?></td>
        												<td style="text-align: center;"><?php echo $status;?></td>
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


<?php unset($_SESSION['load_pg']); ?>

<script>
$(document).ready(function (e) {
    $("#saveForm").on('submit',(function(e) {
        var grand_total = parseFloat($("#kode_coa_save").val());
        if(grand_total == "" || isNaN(grand_total)) {
            grand_total = 0;
        }

        var bank_coa = $("#bank_coa").val();
            if(bank_coa == "" ) {
                $("#bank_coa").focus();
                notifError("<p>Bank Coa tidak boleh kosong!!!</p>");
                return false;
        	}

        e.preventDefault();
        if(grand_total != 0 && grand_total > 0) {
            $(".animated").show();
            $.ajax({
                url: "<?=base_url()?>ajax/j_pg.php?func=save",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(html)
                {
                    var msg = html.split("||");
                    if(msg[0] == "00") {
                        window.location = '<?=base_url()?>?page=keuangan/pg&halaman= PELUNASAN GIRO&pesan='+msg[1];
                    } else {
                        notifError(msg[1]);
                    }
                    $(".animated").hide();
                }

           });
        } else {notifError("<p>Periksa COA.</p>");}
     }));
  });

$("#batal_input").click(function(event) {
    event.preventDefault();
    document.getElementById('show_input_pg').style.display = "none";
  });

//-------------------------- LOAD HIDDEN KODE SAVE FORM -------------------------------------//
$('#bank_coa').change(function(event){
    event.preventDefault();
        var kode = $("#bank_coa").find(':selected').attr('data-nama');
        $('#kode_coa_save').val(kode);
});
//-------------------------- END LOAD HIDDEN KODE SAVE FORM -------------------------------------//

//-------------------------- LOAD PELANGGAN / SUPPLIER -------------------------------------//
	$(function(){
        $(":radio.rad").click(function(){
          $("#pelanggan, #supplier").hide()
          if($(this).val() == "1"){
          	$("#form3").hide();
            $("#pelanggan").show();
            $("#kode_pelanggan").val('0').trigger('change');

            $('#user').val('pelanggan');
            $('#kode_user').val();
            $('#nama_user').val();
          }else{
          	$("#form3").hide();
            $("#supplier").show();
            $("#kode_supplier").val('0').trigger('change');

            $("#user").val('supplier');
            $('#kode_user').val();
            $('#nama_user').val();
          }
        });
	});


	$('#kode_supplier').change(function(){
        var kode_supplier = $("#kode_supplier").val();
        var nama_supplier = $("#kode_supplier").find(':selected').attr('data-nama-supplier');

        $('#kode_user').val(kode_supplier);
        $('#nama_user').val(nama_supplier);

	});

	$('#kode_pelanggan').change(function(){
        var kode_pelanggan = $("#kode_pelanggan").val();
        var nama_pelanggan = $("#kode_pelanggan").find(':selected').attr('data-nama-pelanggan');


        $('#kode_user').val(kode_pelanggan);
        $('#nama_user').val(nama_pelanggan);

	});
//-------------------------- END LOAD PELANGGAN / SUPPLIER -------------------------------------//

//--------------------------LOAD TABEL DETAIL -------------------------------------//
$(document).on('change', '#kode_cabang, #kode_pelanggan, #kode_supplier', function() {
    var id_form        = $("#id_form").val();
    var kode_user 	   = $("#kode_user").val();
    var kode_cabang    = $("#kode_cabang").val();
	var rad = $("[name='rad']:checked").val();
	$('#detail_input_pg').html('<tr><td colspan="8" class="text-center"> Tidak ada item barang. </td></tr>');
    $.ajax({
        type: "POST",
        url: "<?=base_url()?>ajax/j_pg.php?func=loaditemgiro",
        data: "kode_user="+kode_user+"&kode_cabang="+kode_cabang+"&id_form="+id_form+"&rad="+rad,
        cache:false,
        success: function(data) {
            $('#kode_giro').html(data);
			BindSelect2();
         }
     });
	 
	 function BindSelect2() {
		 $('[name="kode_giro"]').prop('disabled', false);
		 $('[name="kode_giro"]').select2({
			 'width': '100%'
		 });
	 }
});

$(document).on('change', '#kode_giro', function() {
    var id_form        = $("#id_form").val();
    var kode_user 	   = $("#kode_user").val();
    var kode_cabang    = $("#kode_cabang").val();
    var kode_giro   = $("#kode_giro").val();
    var kode_giro_s   = kode_giro.split(':');
    var metode_dtl   = kode_giro_s[1];
	var rad = $("[name='rad']:checked").val();
	
	$('#bank_coa').val(0).trigger('change');
	if (metode_dtl === '2' || metode_dtl === 2) {
		metode_dtl = 1;
	}
    $.ajax({
        type: "POST",
        url: "<?=base_url()?>ajax/j_pg.php?func=loaditemuser",
        data: "kode_user="+kode_user+"&kode_cabang="+kode_cabang+"&id_form="+id_form+"&rad="+rad+"&kode_giro="+kode_giro,
        cache:false,
        success: function(data) {
			$('#bank_coa option[data-group-coa="' + metode_dtl + '"]').removeClass('hidden');
			$('#bank_coa option:not([data-group-coa="' + metode_dtl + '"])').addClass('hidden');
			$('#detail_input_pg').html(data.table);
         }
     });
});
//----------------------------END LOAD TABEL DETAIL--------------------------------//


$(document).on('change', '[name*="input_giro"], [name*="tolak_giro"]', function () {
	checkgiro($(this));
});

function checkgiro($this) {
	var
		$id = $this.attr('data-id'),
		$input_giro = $('#input_giro_' + $id),
		$tolak_giro = $('#tolak_giro_' + $id),
		$nominal_save = $('#nominal_asli_' + $id).val() || 0,
		$nominal = $nominal_save,
		$nominal_tolakan = $nominal_save;
	if ($input_giro.is(':checked')) {
		$tolak_giro.prop('disabled', false);
		$('#input_cb_' + $id).val(1);
		$('#nominal_' + $id).val($nominal_save);
		$('#nominal_tolakan_' + $id).val(0);
		$('#tolak_giro_cb_' + $id).val(0);
		$('#text-nominal_' + $id).html($nominal_save);
		$('#text-nominal_tolakan_' + $id).html(0);
	} else {
		$('#input_cb_' + $id).val(0);
		$('#nominal_' + $id).val($nominal_save);
		$('#nominal_tolakan_' + $id).val(0);
		$('#tolak_giro_cb_' + $id).val(0);
		$('#text-nominal_' + $id).html($nominal_save);
		$('#text-nominal_tolakan_' + $id).html(0);
		$tolak_giro.prop('disabled', true);
		if ($tolak_giro.is(':checked')) {
			$tolak_giro.prop('checked', false);
			$('#tolak_giro_cb_' + $id).val(0);
		}
	}
	if ($tolak_giro.is(':checked')) {
		if (!$input_giro.is(':checked')) {
			$input_giro.prop('checked', true);
			$('#input_cb_' + $id).val(1);
		}
		$('#nominal_tolakan_' + $id).val($nominal);
		$('#nominal_' + $id).val(0);
		$('#tolak_giro_cb_' + $id).val(1);
		$('#text-nominal_tolakan_' + $id).html($nominal);
		$('#text-nominal_' + $id).html(0);		
	} else {
		$('#nominal_' + $id).val($nominal_tolakan);
		$('#nominal_tolakan_' + $id).val(0);
		$('#tolak_giro_cb_' + $id).val(0);
		$('#text-nominal_' + $id).html($nominal_tolakan);
		$('#text-nominal_tolakan_' + $id).html(0);
	}
	$('#text-nominal_' + $id).number(true, 2);
	$('#text-nominal_tolakan_' + $id).number(true, 2);
}

</script>

<!-- <script src="<?=base_url()?>assets/select2/select2.js"></script> -->
<script>
    $("input[data-id='kode_coa']").css('pointer-events','none');

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
