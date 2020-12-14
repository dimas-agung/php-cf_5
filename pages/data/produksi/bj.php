<?php
	include "pages/data/script/bj.php";
	include "library/form_akses.php";
	$action = $_GET['action'];
	$kode_spk = isset($_GET['kode_spk']) ? $_GET['kode_spk'] : null;
?>
<section class="content-header">
    <ol class="breadcrumb">
        <li><i class="fa fa-folder-open"></i> Produksi</a></li>
        <li>Barang Jadi</a></li>
    </ol>
</section>

<div class="box box-info">
    <div class="box-body">

    		<?php if (isset($_GET['pesan'])){ ?>
				<div class="form-group" id="form_report">
				  <div class="alert alert-success alert-dismissable">
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					  Kode BJ :  <a href="<?=base_url()?>?page=produksi/spk_track&action=track&halaman= TRACK SURAT PERINTAH KERJA&kode_spk=<?=$_GET['pesan']?>" target="_blank"><?=$_GET['pesan'] ?></a>  Berhasil Di posting
				  </div>
				</div>
			<?php  }  else if (isset($_GET['pembatalan'])){ ?>
                <div class="form-group" id="form_report">
                  <div class="alert alert-dismissable" style="background-color: #9c0303cc; color: #f9e6c3">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color: #f9e6c3">&times;</button>
                      Pembatalan Kode BJ :  <a style="color: white" href="<?=base_url()?>?page=produksi/spk_track&halaman= TRACK SURAT PERINTAH KERJA&action=track&kode_spk=<?=$_GET['pembatalan']?>" target="_blank"><?=$_GET['pembatalan'] ?></a>  Berhasil Di batalkan
                  </div>
                </div>
            <?php } ?>

		<div class="tabbable">
			<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
				<li <?=$class_form?>>
					<a data-toggle="tab" href="#menuFormBtb">Form Barang Jadi</a></li>
                <li <?=$class_tab?>>
					<a data-toggle="tab" href="#menuListBtb">List Barang Jadi</a>
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
										<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode BJ</label>
			                         	<div class="col-lg-4">
			                             	<input type="text" class="form-control" name="kode_bj" id="kode_bj" placeholder="Auto..." readonly value="">
			                         	</div>
										
			                         	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode SPK</label>
			                         	<div class="col-lg-4">
			                             	<input type="text" class="form-control" name="kode_spk" id="kode_spk" placeholder="Kode SPK" readonly value="<?=$kode_spk;?>">
			                         	</div>
                         			 </div>
									 
									 <div class="form-group">
				                     	 <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
				                         <div class="col-lg-4">
				                             <input type="text" class="form-control" name="ref" id="ref" placeholder="Ref..." value="" autocomplete="off">
				                         </div>

                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal BJ</label>
				                         <div class="col-lg-4">
				                         	<div class="input-group">
				                             <input type="text" name="tanggal" id="tanggal" class="form-control date-picker-close" placeholder="Tanggal Buat ..." value="<?=date("m/d/Y")?>" autocomplete="off" readonly/>
				                             <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
				                             <input type="hidden" name="tgl_sekarang" id="tgl_sekarang" class="form-control" value="<?=date("m/d/Y")?>"/>
				                            </div>
				                         </div>
				                     </div>


			                         <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
				                         <div class="col-lg-4">
				                             <select id="kode_cabang" name="kode_cabang" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Cabang --</option>
                                                <?php
												if ($action == 'spk_to_bj') {
                                                //CEK JIKA cabang ADA MAKA SELECTED
                                                (isset($row['id_bj']) ? $cabang=$row['kode_cabang'] : $cabang=(count($spk_hdr_f) > 0 ? $spk_hdr_f['kode_cabang'] : null));
                                                //UNTUK AMBIL coanya
                                                while($row_cabang = mysql_fetch_array($q_cabang)) { ;?>

                                                <option value="<?php echo $row_cabang['kode_cabang'];?>" <?php if($row_cabang['kode_cabang']==$cabang){echo 'selected';} ?>><?php echo $row_cabang['nama_cabang'];?> </option>
                                                <?php }} ?>
                                                </select>
				                         </div>
										 
										 <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Gudang</label>
				                         <div class="col-lg-4">
				                             <select id="kode_gudang" name="kode_gudang" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Gudang --</option>
                                                <?php
                                                //CEK JIKA gudang ADA MAKA SELECTED
                                                (isset($row['id_bj']) ? $gudang=$row['kode_gudang'] : $gudang='');
                                                //UNTUK AMBIL coanya
                                                while($row_gudang = mysql_fetch_array($q_gudang)) { ;?>

                                                <option value="<?php echo $row_gudang['kode_gudang'];?>" <?php if($row_gudang['kode_gudang']==$gudang){echo 'selected';} ?>><?php echo $row_gudang['nama_gudang'] . ' - ' . $row_gudang['keterangan'];?> </option>
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
                                                        <th style="width: 10px">No</th>
                                                        <th style="width: 150px">Barang</th>
                                                        <th style="width: 150px">QTY BJ</th>
                                                        <th style="width: 150px">QTY SPK</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="detail_input_spk">
                                                    <tr>
                                                        <td>1.</td>
                                                        <td><input type="hidden" name="kode_barang[]" id="kode_barang_0" value="<?=$spk_hdr_f['kode_barang'];?>"><?=$spk_hdr_f['kode_barang'] . ' - ' . $spk_hdr_f['nama_barang']; ?></td>
														<td class="text-left"><div class="input-group"><input class="form-control text-right" type="text" name="qty[]" id="qty_0" value="<?=number_format($spk_hdr_f['qty'], 2);?>"><span class="input-group-addon"><?=$spk_hdr_f['kode_satuan'];?><input type="hidden" name="kode_satuan[]" id="kode_satuan_0" value="<?=$spk_hdr_f['kode_satuan'];?>"></span></div></td>
                                                        <td style="text-align: right"><?=number_format($spk_hdr_f['qty'], 2) . ' ' . $spk_hdr_f['kode_satuan']; ?><input type="hidden" name="qty_spk[]" id="qty_spk_0" value="<?=$spk_hdr_f['qty'];?>"></td>
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

                                            <a href="<?=base_url()?>?page=produksi/spk&halaman= SURAT PERINTAH KERJA" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>
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

									<div class="box-body">
									<table id="example1" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
                                                <th style="font-size: 14px">No</th>
												<th style="font-size: 14px">Kode SPK</th>
												<th style="font-size: 14px">Barang</th>
												<th style="font-size: 14px">Tgl Buat</th>
												<th style="font-size: 14px">Tgl Selesai</th>
												<th style="font-size: 14px">Ref</th>
												<th style="font-size: 14px">Cabang</th>
												<th style="font-size: 14px">Status</th>
                                                <th style="font-size: 14px"></th>
											</tr>
										</thead>
										<tbody>

											<?php
												$n=1; if(mysql_num_rows($q_spk) > 0) {
												while($data = mysql_fetch_array($q_spk)) {

												if($data['status_hdr'] == 'open'){
	        										$status = 'Open';
	        										$warna = 'style="background-color: #39b13940"';
	        										$print = '';
	        									}elseif($data['status_dtl'] == 'cancel'){
	        										$status = 'Cancel';
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
												<td style="font-size: 12px"><a href="<?=base_url()?>?page=produksi/spk_track&action=track&halaman= TRACK SURAT PERINTAH KERJA&kode_spk=<?=$data['kode_spk']?>" target="_blank">
													<?php echo $data['kode_spk'];?></a></td>
												<td style="font-size: 12px"> <?php echo $data['kode_inventori'] . ' - ' . $data['nama_barang']; ?></td>
												<td style="font-size: 12px"> <?php echo date("d-m-Y",strtotime($data['tgl_buat']));?></td>
												<td style="font-size: 12px"> <?php echo date("d-m-Y",strtotime($data['tgl_selesai']));?></td>
                                                <td style="font-size: 12px"> <?php echo $data['ref'];?></td>
												<td style="font-size: 12px"> <?php echo $data['nama_cabang'];?></td>
                                                <td style="text-align:center;"> <?php echo $status; ?></td>
                                                <td style="font-size: 12px; text-align: center">
                                                	<!-- <a href="<?=base_url()?>r_cetak_spk.php?kode_spk=<?=$data['kode_spk']?>" title="cetak" target="_blank">
                                                		<button type="button" class="btn btn-warning btn-sm <?= $print?>">
                                                			<span class="glyphicon glyphicon-print"></span>
                                                		</button>
                                                	</a> -->
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

<?php unset($_SESSION['data_spk']); ?>
	
<script type="text/javascript">
	$(document).ready(function () {

      // $("[name='bayari']").number( true, 2 );

      // $(".select2item").select2({
      //   width : '100%'
      // });

      $("[name='qty[]']").number( true, 2 );
      
  });
</script>
	
  <script>
  $(document).ready(function (e) {
	   
	
	 $("#saveForm").on('submit',(function(e) {
    		var grand_total = parseFloat($("#qty_0").val());
    		if(grand_total == "" || isNaN(grand_total)) {grand_total = 0;}

            var kode_cabang = $("#kode_cabang").val();
            if(kode_cabang == 0 ) {
                $("#kode_cabang").focus();
                notifError("<p>Cabang tidak boleh kosong!!!</p>");
                return false;
            }
			
			var kode_gudang = $("#kode_gudang").val();
            if(kode_gudang == 0 ) {
                $("#kode_gudang").focus();
                notifError("<p>Gudang tidak boleh kosong!!!</p>");
                return false;
            }

    		e.preventDefault();
    	  	if(grand_total != 0) {
    			$(".animated").show();
    			$.ajax({

    				url: "<?=base_url()?>ajax/j_bj.php?func=save",
    				type: "POST",
    				data:  new FormData(this),
    				contentType: false,
    				cache: false,
    				processData:false,
    				success: function(html)
    				{
    					var msg = html.split("||");
    					if(msg[0] == "00") {
    						window.location = '<?=base_url()?>?page=produksi/bj&halaman= BARANG JADI&pesan='+msg[1];
    					} else {
    						notifError(msg[1]);
    					}
    					$(".animated").hide();
    				}

    		   });
    	  	} else {notifError("<p>Item  masih kosong</p>");}
    	 }));
		 
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
