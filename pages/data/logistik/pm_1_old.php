<?php 	
	include "pages/data/script/pm.php"; 
	include "library/form_akses.php";	
?>

<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-cubes"></i> Logistik</a></li>
        <li><a href="#">Form Permintaan Material</a></li>
    </ol>
</section>

<div class="box box-info">
    <div class="box-body">

    	<?php if (isset($_GET['pesan'])){ ?>      
			<div class="form-group" id="form_report">
			    <div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					  Kode PM :  <a href="<?=base_url()?>?page=logistik/pm_track&action=track&kode_pm=<?=$_GET['pesan']?>" target="_blank"><?=$_GET['pesan'] ?></a>  Berhasil Di posting
				 </div>
			</div>    
		<?php  }  ?>

<div class="tabbable">
	<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
		<li <?=$class_form?>>
			<a data-toggle="tab" href="#menuFormPm">Form Permintaan Material</a>
		</li>
        <li <?=$class_tab?>>
			<a data-toggle="tab" href="#menuListPm">List Permintaan Material</a>
		</li>
    </ul>

<?php
    if(isset($_GET['action']) and $_GET['action'] == "permintaan") {

	$kode_spk = ($_GET['kode_spk']);
	
	$q_spk_hdr = mysql_query("SELECT sh.kode_spk, sh.ref, sh.kode_cabang, c.nama nama_cabang, sh.keterangan FROM spk_hdr sh
								LEFT JOIN cabang c ON c.kode_cabang = sh.kode_cabang
								WHERE kode_spk = '".$kode_spk."' ");
	$res_hdr = mysql_fetch_array($q_spk_hdr); 
	
	$q_spk_dtl = mysql_query("SELECT sd.*, s.nama nama_satuan FROM spk_dtl sd LEFT JOIN satuan s ON s.kode_satuan = sd.satuan WHERE kode_spk = '".$kode_spk."' ORDER BY id_spk_dtl ASC");
	
}
?>

<div class="row">
	<div class="tab-content">
		<div id="menuFormPm" <?=$class_pane_form?>>
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
                        <div class="form-horizontal">
							<?php $id_form = buatkodeform("kode_form"); ?>

                            <form action="" method="post" enctype="multipart/form-data" id="saveForm">

                            <?php   
                            	$idtem = "INSERT INTO form_id SET kode_form ='".$id_form."' ";
								mysql_query($idtem); 
							?>
							<input type="hidden" name="id_form" id="id_form" value="<?php echo $id_form; ?>"/>  	 
                                         
			                <div class="form-group">
			                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode PM</label>
			                    <div class="col-lg-4">
			                        <input type="text" class="form-control" name="kode_pm" id="kode_pm" placeholder="Auto..." readonly value="">
			                    </div>

			                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
				                <div class="col-lg-4">
				                    <input type="text" class="form-control" name="ref" id="ref" placeholder="Ref..." value="" autocomplete="off">
				                </div>
			                </div>

				            <div class="form-group">
				            	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode SPK</label>
			                    <div class="col-lg-4">
			                        <input type="text" class="form-control" name="kode_spk" id="kode_spk" placeholder="Kode SPK..." value="<?php echo $res_hdr['kode_spk'];?>" readonly>
			                    </div>

				                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
				                <div class="col-lg-4">
				                    <select id="kode_cabang" name="kode_cabang" class="select2" style="width: 100%;">
                                        <option value="<?php echo $res_hdr['kode_cabang'];?>" selected>
                                        	<?php echo $res_hdr['nama_cabang'];?> 
                                        </option>
                                    </select>
				                </div>
				            </div>

				            <div class="form-group">
				                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal PM</label>
				                <div class="col-lg-4">
				                    <div class="input-group">
				                        <input type="text" name="tgl_buat" id="tgl_buat" class="form-control" placeholder="Tanggal Permintaan Barang ..." value="<?=date("d-m-Y")?>" autocomplete="off"/>
				                            <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
				                    </div>
				                </div>

								<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Gudang Asal</label>
				                <div class="col-lg-4" id="load_gudang">
				                    <select id="kode_gudang_asal" name="kode_gudang_asal" class="select2" style="width: 100%;">
                                        <option value="">-- Pilih Gudang Asal --</option>
                                        	<?php 
                                                //CEK JIKA gudang ADA MAKA SELECTED    
                                                (isset($row['id_spk_hdr']) ? $gudang=$row['gudang'] : $gudang='');                                    
                                                //UNTUK AMBIL coanya    
                                                while($row_gudang = mysql_fetch_array($q_gudang_asal)) { ;?>
                                                 
                                                <option value="<?php echo $row_gudang['kode_gudang'];?>" <?php if($row_gudang['kode_gudang']==$gudang){echo 'selected';} ?>><?php echo $row_gudang['nama_gudang'];?> </option>
                                            <?php } ?>
                                    </select>
				                </div> 
				            </div>

				            <div class="form-group">
				                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Gudang Tujuan</label>
				                <div class="col-lg-4" id="load_gudang">
				                    <select id="kode_gudang_tujuan" name="kode_gudang_tujuan" class="select2" style="width: 100%;">
                                        <option value="WH02" selected>PRODUKSI</option>
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
                                            <th colspan="2">Inventori</th>
                                            <th>Satuan</th>
                                            <th>QTY</th>
                                            <th>QTY Ditransfer</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; while($res_dtl = mysql_fetch_array($q_spk_dtl)) { ;?>	
			                                <tr>
			                                    <td><?php echo $res_dtl['kode_barang']; ?>
			                                    	<input type="hidden" class="form-control" name="kode_barang[]" id="kode_barang[]" value="<?php echo $res_dtl['kode_barang']; ?>" >
			                                    </td>
			                                    <td><?php echo $res_dtl['nama_barang']; ?>
			                                    	<input type="hidden" class="form-control" name="nama_barang[]" id="nama_barang[]" value="<?php echo $res_dtl['nama_barang']; ?>" >
			                                    </td>
			                                    <td><?php echo $res_dtl['nama_satuan']; ?> 
			                                    	<input type="hidden" class="form-control" name="satuan[]" id="satuan[]" value="<?php echo $res_dtl['satuan']; ?>">
			                                	</td>
			                                    <td style="text-align: right;"><?php echo $res_dtl['total_qty']; ?>
			                                    	<input type="hidden" class="form-control" name="qty[]" id="qty[]" value="<?php echo $res_dtl['total_qty']; ?>" >
			                                    </td>
			                                    <td>
			                                    	<input type="text" style="text-align: right;" class="form-control" name="qty_dikirim[]" id="qty_dikirim[]" value="" autocomplete="off">
			                                    </td>
			                                    <td>
			                                    	<input type="text" class="form-control" id="keterangan_dtl[]" name="keterangan_dtl[]" value="<?php echo $res_dtl['keterangan']; ?>">
			                                    </td>
			                                </tr>
			                            <?php } ?>
                                    </tbody>
                                </table>
                            </div>
							</div>

							<div class="form-group col-md-6">
	                    		<?php 
									$list_survey_write = 'n';
									while($res = mysql_fetch_array($q_akses)) {; 
								?>    
								<?php 
		                            //FORM SURVEY
		                            if($res['form']=='survey'){ 
		                                if($res['w']=='1'){
											$list_survey_write = 'y';	
	                            ?> 	
									<button type="submit" name="simpan" id="simpan" class="btn btn-primary" tabindex="10"><i class="fa fa-check-square-o"></i> Simpan</button> 
	                            <?php } } } ?>
	                                            
	                                <a href="<?=base_url()?>?page=logistik/pm" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>
               				</div>

						 	</form>				
						</div>	
	                </div>
				</div>
			</div>
		</div>

		<div id="menuListPm" <?=$class_pane_tab?>> 				
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="box-body">
							<table id="example1" class="table table-striped table-bordered table-hover" width="100%" >
								<thead>
									<tr>
                                        <th>No</th>
										<th>Kode PM</th>
										<th>Ref</th>
										<th>Tanggal</th>
										<th>Cabang</th>
                                        <th>Gudang</th>
                                        <th></th>
									</tr>
								</thead>
								<tbody>
									<?php
										$n=1; 
										if(mysql_num_rows($q_pm) > 0) { 
											while($data = mysql_fetch_array($q_pm)) { 
									?>

									<tr>
										<td style="text-align: center; width:5px"> <?php echo $n++ ?></td>
										<td style="width: 40px">
											<a href="<?=base_url()?>?page=logistik/pm_track&action=track&kode_pm=<?=$data['kode_pm']?>"> 
												<?php echo $data['kode_pm'];?>
											</a>
										</td>
										<td> <?php echo $data['ref'];?></td>
										<td> <?php echo date("d-m-Y",strtotime($data['tgl_buat']));?></td>
										<td> <?php echo $data['nama_cabang'];?></td>
										<td> <?php echo $data['nama_gudang'];?></td>
                                        <td>
                                            <a href="<?=base_url()?>r_cetak_pm.php?kode=<?=$data['kode_pm']?>" title="cetak" target="_blank"> 
                                                <button type="button" class="btn btn-warning btn-sm">
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

<?php unset($_SESSION['data_pm']); ?>
  <style>
  .pm-min, .pm-min-s{padding:3px 1px; }
  .animated{display:none;}

  table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    border: 1px solid #DCDCDC;
  }

  th {
      background: #87CEFA;
      text-align: center;
      color: #000000;
      padding: 8px;
  }

  td {
      text-align: left;
      padding: 8px;
      font-size: 13px;
  }

  tr:nth-child(even){background-color: #f2f2f2}
</style>

<script>
    $(document).ready(function (e) {
         $("#saveForm").on('submit',(function(e) {
            var grand_total = parseFloat($("#qty_dikirim").val());
            if(grand_total == "" || isNaN(grand_total)) {grand_total = 0;}
            e.preventDefault();
            if(grand_total >= 0) {          
                $(".animated").show();
                $.ajax({
                    
                    url: "<?=base_url()?>ajax/j_pm.php?func=save",
                    type: "POST",
                    data:  new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(html)
                    {
                        var msg = html.split("||");
                        if(msg[0] == "00") {
                            //window.open('r_penjualan_cetak.php?noNota=' + msg[1], width=330,height=330,left=100, top=25);
                            
                            window.location = '<?=base_url()?>?page=logistik/pm&pesan='+msg[1];
                        } else {
                            notifError(msg[1]);
                        }
                        $(".animated").hide();
                    } 
                      
               });
            } else {notifError("<p>Item  masih kosong.</p>");}
        }));
    });

    $('#kode_cabang').css('pointer-events','none');
    $('#kode_gudang_tujuan').css('pointer-events','none');

</script>

<script src="<?=base_url()?>assets/select2/select2.js"></script>
<script>

  $(function () {
  	$( "#tgl_buat" ).datepicker();
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
  
  $(document).ready(function (e) {
        
        $(".select2").select2({
          width: '100%'
         });
  });
</script>