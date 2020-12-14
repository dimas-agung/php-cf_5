<?php 	
	include "pages/data/script/pg.php"; 
	include "library/form_akses.php";
?>

<section class="content-header">
    <ol class="breadcrumb">
        <li><i class="fa fa-money"></i> Keuangan</li>
        <li>Pelunasan Giro</li>
    </ol>
</section>


<div class="box box-info">
    <div class="box-body">
		<div class="tabbable">
			<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
				<li <?=$class_form?>>
					<a data-toggle="tab" href="#menuFormPg">Form Pelunasan Giro</a>
				</li>
            </ul>

<div class="row">
	<div class="tab-content">
		<div id="menuFormPg" <?=$class_pane_form?> >
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
                        <div class="form-horizontal">
                            <form action="" method="post" enctype="multipart/form-data" id="saveForm">

                                <?php
									$res_hdr = mysql_fetch_array($pg_hdr_back); 
								?>		

			                        <div class="form-group">
			                         	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode PG</label>
			                         	<div class="col-lg-4">
			                             	<input type="text" class="form-control" name="kode_pg" id="kode_pg" placeholder="Auto..." readonly value="<?=$res_hdr['kode_pg']?>">
			                         	</div>

			                         	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Bank COA</label>
                                        <div class="col-lg-4">
                                            <select id="bank_coa" name="bank_coa" class="select2" style="width: 100%;">
                                                <?php    
				                                    (isset($res_hdr['kode_pg']) ? $coa=$res_hdr['bank_coa'] : $coa='');
													foreach($data_coa_back as $key=>$item){ ;?>
					                                    <option data-kode="<?php echo $item['kode_coa'] ?>" value="<?php echo $item['kode_coa'] ?>"
					                                        <?php if($item['kode_coa']==$coa){echo 'selected';} ?>> 
					                                        <?= $item['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$item['nama_coa'];?>
					                                    </option>
				                                <?php } ?>
                                            </select>
                                        </div>
                         			 </div>

                         			 <div class="form-group">
				                     	 <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal Buat</label>
				                         <div class="col-lg-4">
				                         	<div class="input-group">
				                             <input type="text" name="tgl_buat" id="tgl_buat" class="form-control" placeholder="Tanggal Pelunasan Giro ..." value="<?=$res_hdr['tgl_buat']?>" autocomplete="off"/>
				                             <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
				                            </div>
				                         </div>

				                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
				                         <div class="col-lg-4">
				                             <select id="kode_cabang" name="kode_cabang" class="select2" style="width: 100%;">
                                                <option value="<?php echo $res_hdr['kode_cabang'] ?>"> <?= $res_hdr['kode_cabang'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$res_hdr['nama_cabang'];?></option>=
                                             </select>
				                         </div>
				                     </div>

				                     <div class="form-group">
				                     	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
					                        <div class="col-lg-4">
					                            <input type="text" autocomplete="off" class="form-control" name="ref" id="ref" placeholder="Ref..." value="<?=$res_hdr['ref']?>" readonly>
					                        </div>

					                    <?php
					                    	$nama = '';
					                    	$kode_giro = SUBSTR($res_hdr['kode_giro'], -6, 2);

					                    	if($kode_giro == 'GM'){
					                    		$nama = 'Pelanggan';
					                    	}else{
					                    		$nama = 'Supplier';
					                    	}
					                    ?>

					                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left"><?php echo $nama ?></label>
			                                <div class="col-lg-4">
			                                    <select id="kode_user" name="kode_user" class="select2">
			                                        <option value="<?php echo $res_hdr['kode_user'] ?>"><?php echo $res_hdr['kode_user'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$res_hdr['nama_user'];?></option>
			                                    </select>
                                                <input type="hidden" class="form-control" name="nama_user" id="nama_user" value="<?=$res_hdr['nama_user']?>">
                                                <input type="hidden" class="form-control" name="user" id="user" value="<?=$nama?>">
			                                </div> 
				                     </div>
                     
				                     <div class="form-group">
				                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
				                         <div class="col-lg-10">
				                             <textarea type="text" class="form-control" name="keterangan_hdr" id="keterangan_hdr" placeholder="Keterangan..." readonly><?php echo $res_hdr['keterangan_hdr'];?></textarea>
				                         </div>
				                     </div> 

				                    <input type="hidden" autocomplete="off" class="form-control" name="nominal" id="nominal" value="1">

				                    <div class="form-group">
                     	                <div class="col-md-12">
                                            <table id="" class="" rules="all">
                                                <thead>
                                                    <tr>
                                                    	<th></th>
                                                        <th>Kode Giro</th>
                                                        <th>Bank Giro</th>
                                                        <th>No Giro</th>
                                                        <th>Tgl Jatuh Giro</th>
                                                        <th>Nominal</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="detail_input_pg">
                                                	<?php
														$n = 0;

                                                        $array_dtl_back = $_SESSION['data_dtl_back'];
                                                        foreach($array_dtl_back as $key=>$res_dtl){
													?>
                                                	<tr>
														<td style="width: 40px">
															<div class="checkbox" style="text-align:right">
																<input type="checkbox" name="cb[]" id="cb[]" data-id="cb" data-group="<?= $n ?>" value="<?= $n ?>" checked="true">
															</div> 
															<input type="hidden" class="form-control" name="stat_cb[]" id="stat_cb[]" data-id="stat_cb" data-group="<?= $n ?>" value="1">
														</td>
														<td><?=$res_dtl['kode_giro']?></td>
                                                        <td><?=$res_dtl['bank_giro']?></td>
                                                        <td><?=$res_dtl['no_giro']?></td>
                                                        <td><?=$res_dtl['tgl_jth_giro']?></td>
                                                        <td style="text-align: right"><?= number_format($res_dtl['nominal'])?></td>
                                                        <td><input type="text" class="form-control" name="keterangan_dtl[]" id="keterangan_dtl[]" data-id="keterangan_dtl" data-group="<?= $n++ ?>" placeholder="Keterangan ..." value="<?=$res_dtl['keterangan_dtl']?>"></td>
													</tr>
													<?php } ?> 	
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

											<button type="submit" name="simpan" id="simpan" class="btn btn-primary" onclick="return confirm('Anda yakin akan menyimpan data Pengembalian Pelunasan Giro ini ?')"><i class="fa fa-check-square-o"></i> Simpan</button> 

                                            <?php } } } ?>
                                            
                                            <a href="<?=base_url()?>?page=keuangan/pg&halaman= PELUNASAN GIRO" class="btn btn-danger" onclick="return confirm('Anda yakin akan keluar dari Form Pengembalian Pelunasan Giro ini ? Data tidak akan disimpan jika anda keluar dari Form ini.')"><i class=" fa fa-reply"></i> Batal</a>
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
        var grand_total = parseInt($("#bank_coa").val());
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
                url: "<?=base_url()?>ajax/j_pg.php?func=save_back",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(html)
                {
                    var msg = html.split("||");
                    if(msg[0] == "00") {
                        window.location = '<?=base_url()?>?page=keuangan/pg&halaman= PELUNASAN GIRO&pengembalian='+msg[1];
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
    document.getElementById('show_input_pg').style.display = "none";
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
  });	  
</script>

<script src="<?=base_url()?>assets/select2/select2.js"></script>
<script>
	$('#kode_cabang').css('pointer-events','none');
	$('#kode_user').css('pointer-events','none');

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