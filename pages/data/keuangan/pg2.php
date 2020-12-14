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
					  Kode pg :  <a href="<?=base_url()?>?page=keuangan/pg_track&halaman= TRACK PELUNASAN GIRO&action=track&kode_pg=<?=$_GET['pesan']?>" target="_blank"><?=$_GET['pesan'] ?></a>  Berhasil Di posting
				  </div>
				</div>    
			<?php  }  ?>

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
                         			 </div>

                         			 <div class="form-group">
				                     	 <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal Buat</label>
				                         <div class="col-lg-4">
				                         	<div class="input-group">
				                             <input type="text" name="tgl_buat" id="tgl_buat" class="form-control" placeholder="Tanggal Bukti Kas Keluar ..." value="<?=date("d-m-Y")?>" autocomplete="off"/>
				                             <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
				                            </div>
				                         </div>
				                     </div>

				                     <div class="form-group">
				                     	 <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
					                        <div class="col-lg-4">
					                            <input type="text" autocomplete="off" class="form-control" name="ref" id="ref" placeholder="Ref..." value="">
					                        </div>
				                     </div>

				                     <div class="form-group">
				                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
				                         <div class="col-lg-4">
				                             <select id="kode_cabang" name="kode_cabang" class="select2" style="width: 100%;">
                                                <option value="">-- Pilih Cabang --</option>
                                                <?php    
                                                    while($row_cabang = mysql_fetch_array($q_cabang)) { ;?>
                                                    <option value="<?php echo $row_cabang['kode_cabang'];?>">
                                                        <?php echo $row_cabang['kode_cabang'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$row_cabang['nama_cabang'];?> 
                                                    </option>
                                                <?php } ?>
                                             </select>
				                         </div>
				                     </div>

                                     <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Pelanggan</label>
                                        <div class="col-lg-4">
                                            <select id="kode_pelanggan" name="kode_pelanggan" class="select2" style="width: 100%;">
                                                <option value="">-- Pilih Pelanggan --</option>
                                                <?php 
                                                    while($row_pelanggan = mysql_fetch_array($q_pelanggan)) { ;?>
                                                    <option value="<?php echo $row_pelanggan['kode_pelanggan'];?>">
                                                        <?php echo $row_pelanggan['kode_pelanggan'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$row_pelanggan['nama_pelanggan'];?> 
                                                    </option>
                                                <?php } ?>
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
                                                    	<th>Kode GM</th>
                                                        <th>Bank Giro</th>
                                                        <th>No Giro</th>
                                                        <th>Tgl Jatuh Giro</th>
                                                        <th>Nominal</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="detail_input_pg">
                                                	<tr> 
                                                         <td colspan="7" class="text-center"> Tidak ada item barang. </td>
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

									<form action="" method="post" >
                                         
			                         	<!-- <div class="col-xs-12 col-md-4" style="margin-bottom:3mm">
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
		                                                (isset($_POST['kode_coa']) ? $kode_coa=$_POST['kode_coa'] : $kode_coa='');

		                                                while($row_coa = mysql_fetch_array($q_coa_list)) { ;?>
		                                                 
		                                                <option value="<?php echo $row_coa['kode_coa'];?>" <?php if($row_coa['kode_coa']==$kode_coa){echo 'selected';} ?>><?php echo $row_coa['nama_coa'];?> </option>
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
                                                 
                                                <option value="<?php echo $row_cabang['kode_cabang'];?>" <?php if($row_cabang['kode_cabang']==$cabang){echo 'selected';} ?>><?php echo $row_cabang['nama_cabang'];?> </option>
                                                <?php } ?>
                                                </select>
				                         	</div>
				                        </div>

				                     	<div class="col-xs-12 col-md-4" style="margin-bottom:3mm">
                                      		<div class="input-group">
	                                      		<span class="input-group-addon point">Pelanggan</span>
				                             	<select id="pelanggan" name="pelanggan" class="select2" style="width: 100%;">
                                                <option value="" selected>-- Pilih pelanggan --</option>
                                                <?php 
                                                //CEK JIKA pelanggan ADA MAKA SELECTED    
                                                (isset($_POST['pelanggan']) ? $pelanggan=$_POST['pelanggan'] : $pelanggan='');                                    
                                                //UNTUK AMBIL coanya    
                                                while($row_pelanggan = mysql_fetch_array($q_pelanggan_list)) { ;?>
                                                 
                                                <option 
                                                	value="<?php echo $row_pelanggan['kode_pelanggan'];?>" 
                                                	<?php if($row_pelanggan['kode_pelanggan']==$pelanggan){echo 'selected';} ?>><?php echo $row_pelanggan['nama_pelanggan'];?> </option>
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
                                	</form> -->

									<div class="box-body">
									<table id="example1" class="table table-striped table-bordered table-hover" width="100%" >
										<thead>
											<tr>
												<th>No</th>
                                                <th>Kode PG</th>
                                                <th>Pelanggan</th>
												<th>Tanggal Giro</th>
												<th>Tanggal Jth Giro</th>
												<th>Bank</th>
												<th>Nominal</th>
											</tr>
										</thead>
										<tbody>

											<?php
												$n=1; 
                                                if(mysql_num_rows($q_pg) > 0) { 
												    while($data = mysql_fetch_array($q_pg)) { 
											?> 
    											    <tr>
        												<td style="text-align: center"> <?php echo $n++ ?></td>
        												<td> <a href="<?=base_url()?>?page=keuangan/pg_track&action=track&halaman= TRACK PELUNASAN GIRO&kode_pg=<?=$data['kode_pg']?>"> 
        													 <?php echo $data['kode_pg'];?></a>
                                                        </td>
                                                        <td> <?php echo $data['nama_pelanggan'];?></td>
        												<td> <?php echo date("d-m-Y",strtotime($data['tgl_buat']));?></td>
        												<td> <?php echo date("d-m-Y",strtotime($data['tgl_giro']));?></td>
        												<td> <?php echo $data['bank'];?></td>
        												<td> <?php echo $data['nominal'];?></td>
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
        var grand_total = parseFloat($("name=nominal").val());
        if(grand_total == "" || isNaN(grand_total)) {
            grand_total = 0;
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
        } else {notifError("<p>Item  masih kosong.</p>");}
     }));
  });

$("#batal_input").click(function(event) { 
    event.preventDefault(); 
    document.getElementById('show_input_pg').style.display = "none";
  });

$('#kode_pelanggan').change(function(){
    var id_form        = $("#id_form").val();
    var kode_pelanggan = $("#kode_pelanggan").val();  
    var kode_cabang    = $("#kode_cabang").val();  
    $.ajax({
        type: "POST",
        url: "<?=base_url()?>ajax/j_pg.php?func=loaditem",
        data: "kode_pelanggan="+kode_pelanggan+"&kode_cabang="+kode_cabang+"&id_form="+id_form,
        cache:false,
        success: function(data) {
            $('#detail_input_pg').html(data);
         }
     });
}); 

$('#kode_cabang').change(function(){
    var id_form        = $("#id_form").val();
    var kode_pelanggan = $("#kode_pelanggan").val();  
    var kode_cabang    = $("#kode_cabang").val();  
    $.ajax({
        type: "POST",
        url: "<?=base_url()?>ajax/j_pg.php?func=loaditem",
        data: "kode_pelanggan="+kode_pelanggan+"&kode_cabang="+kode_cabang+"&id_form="+id_form,
        cache:false,
        success: function(data) {
            $('#detail_input_pg').html(data);
         }
     });
}); 

</script>

<script src="<?=base_url()?>assets/select2/select2.js"></script>
<script>
    $("input[data-id='kode_coa']").css('pointer-events','none');

    $(function () {
        $( "#tgl_buat" ).datepicker();
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