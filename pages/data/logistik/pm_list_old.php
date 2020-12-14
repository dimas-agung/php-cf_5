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
				                    <input type="text" class="form-control" name="ref" id="ref" placeholder="Ref..." value="" autocomplete="off" readonly>
				                </div>
			                </div>

				            <div class="form-group">
				            	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode SPK</label>
			                    <div class="col-lg-4">
			                        <input type="text" class="form-control" name="kode_spk" id="kode_spk" placeholder="Kode SPK..." value="" readonly>
			                    </div>

				                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
				                <div class="col-lg-4">
				                    <select id="kode_cabang" name="kode_cabang" class="select2" style="width: 100%;" disabled>
                                        <option value="">-- Pilih Cabang --</option>
                                    </select>
				                </div>
				            </div>

				            <div class="form-group">
				                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal PM</label>
				                <div class="col-lg-4">
				                    <div class="input-group">
				                        <input type="text" name="tgl_buat" id="tgl_buat" class="form-control" placeholder="Tanggal Permintaan Barang ..." value="<?=date("d-m-Y")?>" autocomplete="off" readonly/>
				                            <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
				                    </div>
				                </div>

								<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Gudang Asal</label>
				                <div class="col-lg-4">
				                    <select id="kode_gudang_asal" name="kode_gudang_asal" class="select2" style="width: 100%;" disabled>
                                        <option value="">-- Pilih Gudang Asal --</option>
                                    </select>
				                </div> 
				            </div>

				            <div class="form-group">
				                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Gudang Tujuan</label>
				                <div class="col-lg-4">
				                    <select id="kode_gudang_tujuan" name="kode_gudang_tujuan" class="select2" style="width: 100%;" disabled>
                                        <option value="">-- Pilih Gudang Tujuan --</option>
                                    </select>
				                </div>
				            </div>

				            <div class="form-group">
				                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
				                <div class="col-lg-10">
				                   	<textarea type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan..." value="" readonly></textarea>
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
			                                <tr>
			                                    <td colspan="6" style="text-align:center;">Tidak Ada Data</td>
			                                </tr>
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
	                                            
	                                <a href="<?=base_url()?>?page=logistik/pm_list" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>
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
                                        <th>Gudang Asal</th>
                                        <th>Gudang Tujuan</th>
                                        <th>Action</th>
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
										<td>
											<a href="<?=base_url()?>?page=logistik/pm_track&action=track&kode_pm=<?=$data['kode_pm']?>"> 
												<?php echo $data['kode_pm'];?>
											</a>
										</td>
										<td> <?php echo $data['ref'];?></td>
										<td> <?php echo date("d-m-Y",strtotime($data['tgl_buat']));?></td>
										<td> <?php echo $data['nama_cabang'];?></td>
										<td> <?php echo $data['gudang_asal'];?></td>
										<td> <?php echo $data['gudang_tujuan'];?></td>
                                        <td style="text-align: center">
                                            <a href="<?=base_url()?>r_cetak_pm.php?kode=<?=$data['kode_pm']?>" title="cetak" target="_blank"> 
                                                <button type="button" class="btn btn-warning btn-xs">
                                                	<span class="glyphicon glyphicon-print"></span>
                                                </button>
                                            </a> 
                                            <a href="<?=base_url()?>?page=logistik/tg_link&action=transfer&kode_pm=<?=$data['kode_pm']?>&kode_cabang=<?=$data['kode_cabang']?>&kode_gudang=<?=$data['kode_gudang_asal']?>" title="Transfer Gudang" >
	                                            <button type="button" class="btn btn-primary btn-xs">
	                                                <span class="fa fa-truck"></span>
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

<script src="<?=base_url()?>assets/select2/select2.js"></script>
<script>

  $(function () {
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
	$( ".date-picker" ).datepicker();
    
	$(".select2").select2({
          width: '100%'
         });
</script>