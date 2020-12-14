<?php 	
	include "pages/data/script/gk.php"; 
	include "library/form_akses.php";
?>

<style>
  .pm-min, .pm-min-s{padding:3px 1px; }
  .animated{display:none;}

  table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 1600px;
    border: 1px solid #3c4f5f;
  }

  th {
      background: #87CEFA;
      text-align: center;
      color: #000000;
      padding: 8px;
      font-size: 13px;
  }

  td {
      text-align: left;
      padding: 8px;
      font-size: 13px;
  }

  tr:nth-child(even){background-color: #f2f2f2}

  p {
    font-size: 8px;
  }
</style>

<section class="content-header">
    <ol class="breadcrumb">
        <li><i class="fa fa-money"></i> Keuangan</li>
        <li>Giro Keluar</li>
    </ol>
</section>


<div class="box box-info">
    <div class="box-body">

    		

		<div class="tabbable">
			<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
				<li <?=$class_form?>>
					<a data-toggle="tab" href="#menuFormGk">Form Giro Keluar</a>
				</li>
            </ul>

<div class="row">
	<div class="tab-content">
		<div id="menuFormGk" <?=$class_pane_form?> >
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
                        <div class="form-horizontal">
                            <form action="" method="post" enctype="multipart/form-data" id="saveForm">

                                <?php
									$res_hdr = mysql_fetch_array($gk_hdr_back); 
								?>		

			                        <div class="form-group">
			                         	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode gk</label>
			                         	<div class="col-lg-4">
			                             	<input type="text" class="form-control" name="kode_gk" id="kode_gk" placeholder="Auto..." readonly value="<?=$res_hdr['kode_gk']?>">
			                         	</div>

			                         	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
				                        <div class="col-lg-4">
				                            <select id="kode_cabang" name="kode_cabang" class="select2" style="width: 100%;">
				                            	<option value="C01">C01 || SURABAYA</option>

                                                <!-- <option value="<?php echo $res_hdr['kode_cabang'];?>"><?php echo $res_hdr['kode_cabang'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$res_hdr['nama_cabang'];?></option>
                                                <?php    
                                                    while($row_cabang = mysql_fetch_array($q_cabang)) { ;?>
                                                    <option value="<?php echo $row_cabang['kode_cabang'];?>">
                                                        <?php echo $row_cabang['kode_cabang'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$row_cabang['nama_cabang'];?> 
                                                    </option>
                                                <?php } ?> -->
                                            </select>
				                        </div>
                         			</div>

				                    <div class="form-group">
				                     	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
					                    <div class="col-lg-4">
					                        <input type="text" autocomplete="off" class="form-control" name="ref" id="ref" placeholder="Ref..." value="<?=$res_hdr['ref']?>">
					                    </div>

					                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Supplier</label>
                                        <div class="col-lg-4">
                                            <select id="kode_supplier" name="kode_supplier" class="select2" style="width: 100%;">
                                                <option value="<?php echo $res_hdr['kode_supplier'];?>"><?php echo $res_hdr['kode_supplier'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$res_hdr['nama_supplier'];?> </option>
                                                <?php 
                                                    while($row_supplier = mysql_fetch_array($q_supplier)) { ;?>
                                                    <option value="<?php echo $row_supplier['kode_supplier'];?>">
                                                        <?php echo $row_supplier['kode_supplier'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$row_supplier['nama_supplier'];?> 
                                                    </option>
                                                <?php } ?>
                                             </select>
                                        </div>
				                    </div>

				                    <div class="form-group">
				                     	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal Buat</label>
				                        <div class="col-lg-4">
				                         	<div class="input-group">
				                            	<input type="text" name="tgl_buat" id="tgl_buat" class="form-control" placeholder="Tanggal Bukti Kas Keluar ..." value="<?=$res_hdr['tgl_buat']?>" autocomplete="off"/>
				                             	<span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
				                            </div>
				                        </div>
				                    </div>
                     
				                    <div class="form-group">
				                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
				                        <div class="col-lg-10">
				                            <textarea type="text" class="form-control" name="keterangan_hdr" id="keterangan_hdr" placeholder="Keterangan..." value="<?=$res_hdr['keterangan_hdr']?>"><?=$res_hdr['keterangan_hdr']?></textarea>
				                        </div>
				                    </div> 

				                    <div class="form-group">
                     	                <div class="col-lg-12">
                                            <table id="" class="table table-striped table-bordered table-hover" width="100%">
                                                <thead>
                                                    <tr>
                                                    	<th style="width: 25px"></th>
                                                        <th>Deskripsi</th>
                                                        <th>Saldo Transaksi</th>
                                                        <th>Nominal Bayar</th>
                                                        <th>Nominal Pelunasan</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="detail_input_gk">
                                                	<?php
														$n = 0;
                                                        $total = '';
                                                        $subtotal = '';
                                                        $tot_nom_pel = '';

                                                        $array_dtl_back = $_SESSION['data_dtl_back'];
                                                        foreach($array_dtl_back as $key=>$res_dtl){
														                            
	                                                        $total = $res_dtl['nominal_bayar'];
	                                                        $nominal_pelunasan = $res_dtl['nominal_pelunasan'];

	                                                        $subtotal += $total;
	                                                        $tot_nom_pel += $nominal_pelunasan;
													?>
                                                	<tr>
														<td width="40px">
															<div class="checkbox" style="text-align:right">
																<input type="checkbox" name="cb[]" id="cb[]" data-id="cb" data-group="<?= $n ?>" value="<?= $n ?>" checked="true">
															</div> 
															<input type="hidden" class="form-control" name="stat_cb[]" id="stat_cb[]" data-id="stat_cb" data-group="<?= $n ?>" value="1" style="width:100px">
														</td>
														<td width="150px">
															<input class="form-control" type="text" name="deskripsi[]" id="deskripsi[]" data-id="deskripsi" data-group="<?= $n ?>" value="<?=$res_dtl['deskripsi']?>" style="width: 13em;" readonly/>
														</td>
														<td style="width:50px;">
															<input class="form-control" type="text" name="saldo_transaksi[]" id="saldo_transaksi[]" data-id="saldo_transaksi" data-group="<?= $n ?>" value="<?=$res_dtl['saldo_transaksi']?>" style="width: 13em;text-align:right" readonly/>
														</td>
														<td style="width:50px;">
															<input class="form-control" type="text" name="nominal_bayar[]" id="nominal_bayar[]" data-id="nominal_bayar" data-group="<?= $n ?>" value="<?=$res_dtl['nominal_bayar']?>" style="width: 13em;text-align:right" autocomplete="off"/>
														</td>
														<td style="width:50px;">
															<input class="form-control" type="text" name="nominal_pelunasan[]" id="nominal_pelunasan[]" data-id="nominal_pelunasan" data-group="<?= $n ?>" value="<?=$res_dtl['nominal_pelunasan']?>" style="width: 13em;text-align:right"/>
														</td>	
														<td>
															<input type="text" class="form-control" name="keterangan_dtl[]" id="keterangan_dtl[]" data-id="keterangan_dtl" data-group="<?= $n++ ?>" placeholder="Keterangan ..." value="<?=$res_dtl['keterangan_dtl']?>">

														</td>
													</tr>
													<?php } ?> 
													<tr>
														<td colspan="3" style="text-align:right"><b>Subtotal :</b></td>
														<td>
															<input class="form-control" type="text" name="subtotal" id="subtotal" autocomplete="off" value="<?= $subtotal ?>" readonly style="text-align:right; font-weight: bold;"/>
														</td>
														<td>
															<input class="form-control" type="text" name="tot_nom_pel" id="tot_nom_pel" autocomplete="off" value="<?= $tot_nom_pel ?>" readonly style="text-align:right; font-weight: bold;"/>
														</td>
														<td></td>
													</tr>	
                                                </tbody>
                                            </table>
                                    	</div>
									</div>

									<div class="form-group">
                                        <div class="col-lg-5">                                   	
                                            <div class="pull-left">  
                                                <a class="btn btn-success" id="tambah_giro"><i class="fa fa-plus"></i> Add</a>                		
                                            </div>  
                                        </div>
                                        <div class="col-lg-1">
                                        	<label style="margin-top: 6px;" class="pull-right">Selisih : </label>
                                        </div>
                                        <div class="col-lg-2">                                   	
                                            <input class="form-control" type="text" name="selisih" id="selisih" value="<?= $res_hdr['selisih']?>" style="text-align:right" readonly/>
                                        </div>  
                                        <div class="col-lg-4"> 
                                            <select id="kode_coa_selisih" name="kode_coa_selisih" class="select2">
                                            	<?php
                                            	if($res_hdr['kode_coa_selisih'] != 0){
                                                    		$kode_coa_selisih = $res_hdr['kode_coa_selisih'];
                                                    	}else{
                                                    		$kode_coa_selisih = '------------------------- [Pilih COA Jika Selisih > 0] --------------------------';
                                                    	}
                                                ?>
                                                <option value="<?php echo $res_hdr['kode_coa_selisih'];?>"><?php echo $kode_coa_selisih ?></option>
                                                <?php 
                                                	(isset($res_hdr['id_gk_hdr']) ? $kode_coa_selisih=$res_hdr['kode_coa_selisih'] : $kode_coa_selisih='');
                                                    while($row_kd_coa_slsh = mysql_fetch_array($q_coa)) { 
                                                ;?>
                                                    <option value="<?php echo $row_kd_coa_slsh['kode_coa_selisih'];?>"
                                                    	<?php if($row_kd_coa_slsh['kode_coa']==$kode_coa_selisih){echo 'selected';} ?>>
                                                        <?php echo $row_kd_coa_slsh['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$row_kd_coa_slsh['nama_coa'] ?> 
                                                    </option>
                                                <?php } ?>
                                             </select>
                                        </div>
                                    </div>  

									<div class="form-group">
	                                    <div class="col-lg-12">
	                                        <table id="tabel_giro" class="table table-striped table-bordered table-hover" width="100%">
	                                            <thead>
	                                                <tr>
	                                                    <th>Bank Giro</th>
	                                                    <th>No Giro</th>
	                                                    <th>Tanggal Giro</th>
	                                                    <th>Nominal</th>
	                                                    <th></th>
	                                                </tr>

	                                                <tr id="show_giro" style="display: none;">
	                                                	<td>
	                                                		<input type="text" autocomplete="off" class="form-control" name="bank_giro" id="bank_giro" placeholder="Bank Giro..." value="">
	                                                		<input type="hidden" name="id_giro" id="id_giro" value="1"/>
	                                                	</td>
	                                                	<td>
	                                                		<input type="text" autocomplete="off" class="form-control" name="no_giro" id="no_giro" placeholder="No Giro..." value="">
	                                                	</td>
	                                                	<td>
	                                                		<input type="text" name="tgl_giro" id="tgl_giro" class="form-control" placeholder="Tanggal Giro ..." value="<?=date("d-m-Y")?>" style="text-align: center" autocomplete="off"/>
	                                                	</td>
	                                                	<td>
	                                                		<input class="form-control" type="text" name="nominal" id="nominal" value="" style="text-align:right"/>
	                                                	</td>
	                                                	<td style="text-align: center">
	                                                		<button id="ok_input" class="btn btn-xs btn-info ace-icon fa fa-check" title="ok"></button>
	                                                		<a href="" id="batal_input_giro" class="btn btn-xs btn-danger ace-icon fa fa-remove" title="batal" ></a>
	                                                	</td>
	                                                </tr>
	                                            </thead>
	                                            <tbody id="detail_giro">
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

											<button type="submit" name="simpan" id="simpan" class="btn btn-primary" onclick="return confirm('Anda yakin akan menyimpan data Pengembalian Giro Keluar ini ?')"><i class="fa fa-check-square-o"></i> Simpan</button> 

                                            <?php } } } ?>
                                            
                                            <a href="<?=base_url()?>?page=keuangan/gk&halaman= GIRO KELUAR" class="btn btn-danger" onclick="return confirm('Anda yakin akan keluar dari Form Pengembalian Giro Keluar ini ?          Data tidak akan disimpan jika anda keluar dari Form ini.')"><i class=" fa fa-reply"></i> Batal</a>
               						</div>
					 				
					 		</form>

						</div>	
                    </div>
				</div>
			</div>
		</div>
    </div>
</div>

<script>
$(document).ready(function (e) {
    $("#saveForm").on('submit',(function(e) {
        var grand_total = parseInt($("#nominal").val());
        if(grand_total == "" || isNaN(grand_total)) {
            grand_total = 0;
        }

        var bank_giro = $("#bank_giro").val();
            if(bank_giro == "" ) {
                $("#bank_giro").focus();
                notifError("<p>Bank Giro tidak boleh kosong!!!</p>");
                return false;
        	}

        var no_giro = $("#no_giro").val();
            if(no_giro == "" ) {
                $("#no_giro").focus();
                notifError("<p>No Giro tidak boleh kosong!!!</p>");
                return false;
        	}

        e.preventDefault();
        if(grand_total != 0 && grand_total > 0) {           
            $(".animated").show();
            $.ajax({
                url: "<?=base_url()?>ajax/j_gk.php?func=save_back",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(html)
                {
                    var msg = html.split("||");
                    if(msg[0] == "00") {
                        window.location = '<?=base_url()?>?page=keuangan/gk&halaman= GIRO KELUAR&pengembalian='+msg[1];
                    } else {
                        notifError(msg[1]);
                    }
                    $(".animated").hide();
                } 
                  
           });
        } else {notifError("<p>Terdapat Data yg Belum diisi</p>");}
     }));
  });

$("#batal_input").click(function(event) { 
    event.preventDefault(); 
    document.getElementById('show_input_gk').style.display = "none";
});

$(function(){
	
	var id_form 	= $('#id_form').val();
    var bank_giro   = $("#bank_giro").val();
    var no_giro     = $("#no_giro").val();
    var tgl_giro    = $("#tgl_giro").val();
    var nominal     = $("#nominal").val();
    var tot_nom_pel	= $("#tot_nom_pel").val();
	var kode_gk 	= $('#kode_gk').val();
	
	$.ajax({
        type: "POST",
        url: "<?=base_url()?>ajax/j_gk.php?func=addgirotarik",
        data: "bank_giro="+bank_giro+"&no_giro="+no_giro+"&tgl_giro="+tgl_giro+"&nominal="+nominal+"&id_form="+id_form+"&kode_gk="+kode_gk,
        cache:false,
        success: function(data) {
          $('#detail_giro').html(data);
        }
     });
});

$("#tambah_giro").click(function(event) {
	event.preventDefault();
    	var tot_nom_pel  = parseInt($("#tot_nom_pel").val());

    	if(tot_nom_pel != 0){	
    		var tgl_giro  = $("#tgl_giro").val();
    		var selisih   = $("#selisih").val();
    		document.getElementById('show_giro').style.display = "table-row";
    		
    		$('#bank_giro').val('');
    		$('#no_giro').val('');
    		$('#tgl_giro').val(tgl_giro);
    		$('#nominal').val('0');
    		$('#selisih').val('0');
    		$('#kode_coa_selisih').val('0').trigger('change');
    		$('#selisih').val(selisih);
    	}else{
    		alert('Peringatan : Harap Pilih Transaksi yang Akan Dilunasi !!');
    	}
});

$("#batal_input_giro").click(function(event) { 
    event.preventDefault(); 
    document.getElementById('show_giro').style.display = "none";
  });

$("#ok_input").click(function(event) { 
    event.preventDefault();

    var id_form 	= $('#id_form').val();
    var bank_giro   = $("#bank_giro").val();
    var no_giro     = $("#no_giro").val();
    var tgl_giro    = $("#tgl_giro").val();
    var nominal     = $("#nominal").val();
    var tot_nom_pel	= $("#tot_nom_pel").val();

    if(bank_giro != 0 && no_giro != 0 && nominal != 0) { 
      var status = 'true';
    }else{
      var status = 'false';
    }

    if(status == 'true') {   
      $.ajax({
        type: "POST",
        url: "<?=base_url()?>ajax/j_gk.php?func=addgiro",
        data: "bank_giro="+bank_giro+"&no_giro="+no_giro+"&tgl_giro="+tgl_giro+"&nominal="+nominal+"&id_form="+id_form,
              cache:false,
        success: function(data) {
          $('#detail_giro').html(data);
          document.getElementById('show_giro').style.display = "none";
          var selisih = parseInt(tot_nom_pel - $("#subtotal_giro").val());
          $('#selisih').val(selisih);
        }
      });
    }else{
      alert("Peringatan : Bank Giro, No Giro, dan Nominal wajib diisi !!");
    }
    return false;
  });

$(document).on("change paste keyup", "input[data-id='cb']", function(){
 	var tr = $(this).parents('tr');

	if (this.checked){
		var stat  = 1;
    	tr.find("[data-id='stat_cb']").val(stat);
	} else {
		var stat  = 0;
		tr.find("[data-id='stat_cb']").val(stat);
	}
				
	var in_harga 	= parseInt(tr.find("[data-id='nominal_bayar']").val());
    var in_subtotal = parseInt($("#subtotal").val());
    var in_nominal_pelunasan 	= parseInt(tr.find("[data-id='nominal_pelunasan']").val());
    var in_tot_nom_pel = parseInt($("#tot_nom_pel").val());	

		if (stat == 0){
			var harga = parseInt(in_subtotal-in_harga);
			var tot_nom_pel = parseInt(in_tot_nom_pel-in_nominal_pelunasan);
			var nominal_pelunasan = parseInt(tr.find("[data-id='nominal_pelunasan']").val(0));
			tr.find("[data-id='selisih']").val(0);
		}else{
			var harga = parseInt(in_subtotal);
			var tot_nom_pel = parseInt(in_tot_nom_pel);
		}

		if (nominal_pelunasan > 0){
			var harga = parseInt(in_subtotal+in_harga);
			var tot_nom_pel = parseInt(in_tot_nom_pel+in_nominal_pelunasan);
		}
				
	$('#subtotal').val(harga);
	$('#tot_nom_pel').val(tot_nom_pel);

  });	  

$(document).on("change paste keyup", "input[data-id='nominal_pelunasan']", function(){
        
    var stat_cb     = 0;
    var subtotalll  = 0;
    var tot_nom_pel = 0;

    $('table tbody tr').each(function() {
                
        var $tr = $(this);
        
        if ($tr.find('input[data-id="cb"]').is(':checked')) {
                var stat_cb = 1;
                                            
                var nominal_bayar      =  parseInt($tr.find('input[data-id="nominal_bayar"]').val()) || 0; 
                var nominal_pelunasan  =  parseInt($tr.find('input[data-id="nominal_pelunasan"]').val()) || 0; 
                var subtotal           =  parseInt($tr.find('input[data-id="subtotal"]').val()) || 0;
                var tot_nam_pel        =  parseInt($tr.find('input[data-id="tot_nom_pel"]').val()) || 0;
                var stat_cb            =  $tr.find('input[data-id="stat_cb"]').val(stat_cb);

            
                var selisih = parseInt(nominal_pelunasan-nominal_bayar);
                parseInt($tr.find('input[data-id="selisih"]').val(selisih));
             
                var subtotall = parseInt(nominal_bayar+subtotal);
                subtotalll += subtotall;

                tot_nom_pel += parseInt(nominal_pelunasan);
           
        }
    });   
        $('#subtotal').val(subtotalll);
        $('#tot_nom_pel').val(tot_nom_pel);
});

</script>

<script src="<?=base_url()?>assets/select2/select2.js"></script>
<script>

    $(function () {
        $( "#tgl_buat" ).datepicker();
        $( "#tgl_giro" ).datepicker();
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
    })
  
    $(document).ready(function(e) {
        $(".select2").select2({
              width: '100%'
        });
    });
</script>