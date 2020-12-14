<?php
	include "pages/data/script/spk.php";
	include "library/form_akses.php";
?>
<section class="content-header">
    <ol class="breadcrumb">
        <li><i class="fa fa-folder-open"></i> Produksi</a></li>
        <li>Surat Perintah Kerja</a></li>
    </ol>
</section>

<div class="box box-info">
    <div class="box-body">

    		<?php if (isset($_GET['pesan'])){ ?>
				<div class="form-group" id="form_report">
				  <div class="alert alert-success alert-dismissable">
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					  Kode SPK :  <a href="<?=base_url()?>?page=produksi/spk_track&action=track&halaman= TRACK SURAT PERINTAH KERJA&kode_spk=<?=$_GET['pesan']?>" target="_blank"><?=$_GET['pesan'] ?></a>  Berhasil Di posting
				  </div>
				</div>
			<?php  }  else if (isset($_GET['pembatalan'])){ ?>
                <div class="form-group" id="form_report">
                  <div class="alert alert-dismissable" style="background-color: #9c0303cc; color: #f9e6c3">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color: #f9e6c3">&times;</button>
                      Pembatalan Kode SPK :  <a style="color: white" href="<?=base_url()?>?page=produksi/spk_track&halaman= TRACK SURAT PERINTAH KERJA&action=track&kode_spk=<?=$_GET['pembatalan']?>" target="_blank"><?=$_GET['pembatalan'] ?></a>  Berhasil Di batalkan
                  </div>
                </div>
            <?php } ?>

		<div class="tabbable">
			<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
				<li <?=$class_form?>>
					<a data-toggle="tab" href="#menuFormBtb">Form Surat Perintah Kerja</a></li>
                <li <?=$class_tab?>>
					<a data-toggle="tab" href="#menuListBtb">List Surat Perintah Kerja</a>
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
			                         	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode SPK</label>
			                         	<div class="col-lg-4">
			                             	<input type="text" class="form-control" name="kode_spk" id="kode_spk" placeholder="Auto..." readonly value="">
			                         	</div>

                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
				                         <div class="col-lg-4">
				                             <select id="kode_cabang" name="kode_cabang" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Cabang --</option>
                                                <?php
                                                //CEK JIKA cabang ADA MAKA SELECTED
                                                (isset($row['id_spk']) ? $cabang=$row['kode_cabang'] : $cabang='');
                                                //UNTUK AMBIL coanya
                                                while($row_cabang = mysql_fetch_array($q_cabang)) { ;?>

                                                <option value="<?php echo $row_cabang['kode_cabang'];?>" <?php if($row_cabang['kode_cabang']==$cabang){echo 'selected';} ?>><?php echo $row_cabang['nama_cabang'];?> </option>
                                                <?php } ?>
                                                </select>
				                         </div>
                         			 </div>

				                     <div class="form-group">
				                     	 <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
				                         <div class="col-lg-4">
				                             <input type="text" class="form-control" name="ref" id="ref" placeholder="Ref..." value="" autocomplete="off">
				                         </div>

                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Barang</label>
				                         <div class="col-lg-4">
				                             <select id="kode_barang" name="kode_barang" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Barang --</option>
                                                <?php
                                                //CEK JIKA inventori ADA MAKA SELECTED
                                                (isset($row['id_spk']) ? $inventori=$row['kode_inventori'] : $inventori='');
                                                //UNTUK AMBIL coanya
                                                while($row_inventori = mysql_fetch_array($q_inventori)) { ;?>

                                                <option value="<?php echo $row_inventori['kode_inventori'];?>" <?php if($row_inventori['kode_inventori']==$inventori){echo 'selected';} ?>><?php echo $row_inventori['nama_inventori'];?> </option>
                                                <?php } ?>
                                                </select>
				                         </div>
				                     </div>

				                     <div class="form-group">
				                     	 <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal SPK</label>
				                         <div class="col-lg-4">
				                         	<div class="input-group">
				                             <input type="text" name="tanggal" id="tanggal" class="form-control date-picker-close" placeholder="Tanggal Buat ..." value="<?=date("m/d/Y")?>" autocomplete="off" readonly/>
				                             <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
				                             <input type="hidden" name="tgl_sekarang" id="tgl_sekarang" class="form-control" value="<?=date("m/d/Y")?>"/>
				                            </div>
				                         </div>

                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal Selesai</label>
				                         <div class="col-lg-4">
				                         	<div class="input-group">
				                             <input type="text" name="tanggal_s" id="tanggal_s" class="form-control date-picker-close" placeholder="Tanggal Selesai ..." value="<?=date("m/d/Y")?>" autocomplete="off" readonly/>
				                             <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
				                             <input type="hidden" name="tgl_selesai" id="tgl_selesai" class="form-control" value="<?=date("m/d/Y")?>"/>
				                            </div>
				                         </div>
				                     </div>

				                     <div class="form-group">
				                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Jumlah</label>
				                         <div class="col-lg-4">
				                            <div class="input-group">
																	<input type="hidden" name="satuan" id="satuan" value="" />
																	<input class="form-control" type="text" name="jumlah" id="jumlah"  autocomplete="off" value="0" />
																	<span class="input-group-addon" id="text-satuanstok"></span>
																</div>
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
                                                        <th style="width: 150px">Standar QTY</th>
                                                        <th style="width: 150px">Kebutuhan QTY</th>
                                                        <th style="width: 200px">Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="detail_input_spk">
                                                    <tr>
                                                        <td colspan="5" class="text-center">Belum ada item.</td>
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

      $("[name='q_std[]']").number( true, 2 );
      $("[name='q_use[]']").number( true, 2 );
	  $("[name='jumlah']").number( true, 2 );
      
  });
</script>
	
  <script>
  $(document).ready(function (e) {
	  $('body').on('change', '#kode_barang', function(){
        var kode_barang = $("#kode_barang").val();
		$('#jumlah').val(0);
		$('#satuan').val("");
		$('#text-satuanstok').html("");
		$('#detail_input_spk').html('<tr><td colspan="5" class="text-center">Belum ada item.</td></tr>');
		if (kode_barang != 0) {
			$.ajax({
				type: "POST",
				dataType: "JSON",
				url: "<?=base_url()?>ajax/j_spk.php?func=loadsatuan",
				data: "kode_barang="+kode_barang,
				cache:false,
				success: function(response) {
					var
						satuan_dtl = response.satuan_dtl;
					
					satuan_dtl = satuan_dtl !== '' && satuan_dtl.indexOf(':') ? satuan_dtl.split(':') : '';
					
					if (satuan_dtl !== '') {
						$('#text-satuanstok').html(satuan_dtl[1].replace(/\s+/g, ''));
						$('#satuan').val(satuan_dtl[1].replace(/\s+/g, ''));
					}
					
				}
			});
			
			$.ajax({
				type: "POST",
				url: "<?=base_url()?>ajax/j_spk.php?func=get_bom",
				data: "kode_barang="+kode_barang,
				cache:false,
				success: function(response) {
					
					$('#detail_input_spk').html(response);
					numberjs();
				}
			});
			
			function numberjs(){
				$("[name='q_std[]']").number( true, 2 );
				$("[name='q_use[]']").number( true, 2 );
			}
		}
	});
	
	function calculate(){

    var jumlah = parseFloat($('#jumlah').val() || 0);

    var sumTotal=0;

    // var arr =[];

    $('table tbody tr').each(function() {
        
        var $tr = $(this);
        var base_qty =parseFloat($tr.find('input[name="q_std[]"]').val()) || 0;
        var nilai  = jumlah*base_qty; 

        var kebutuhan =parseFloat($tr.find('input[name="q_use[]"]').val(nilai)) || 0;
        // arr.push(kebutuhan);
        // console.log(kebutuhan);
    });

} 

$("#jumlah").keyup(function(event) {
    
    event.preventDefault();

    calculate();

    var kebutuhan = [];

    $("[name='q_use[]']").each(function(){
        kebutuhan.push(this.value);
    });


});
	
	 $("#saveForm").on('submit',(function(e) {
    		var grand_total = parseFloat($("#jumlah").val());
    		if(grand_total == "" || isNaN(grand_total)) {grand_total = 0;}

            var kode_cabang = $("#kode_cabang").val();
            if(kode_cabang == 0 ) {
                $("#kode_cabang").focus();
                notifError("<p>Cabang tidak boleh kosong!!!</p>");
                return false;
            }
			
			var kode_barang = $("#kode_barang").val();
            if(kode_barang == 0 ) {
                $("#kode_barang").focus();
                notifError("<p>Barang tidak boleh kosong!!!</p>");
                return false;
            }

    		e.preventDefault();
    	  	if(grand_total != 0) {
    			$(".animated").show();
    			$.ajax({

    				url: "<?=base_url()?>ajax/j_spk.php?func=save",
    				type: "POST",
    				data:  new FormData(this),
    				contentType: false,
    				cache: false,
    				processData:false,
    				success: function(html)
    				{
    					var msg = html.split("||");
    					if(msg[0] == "00") {
    						window.location = '<?=base_url()?>?page=produksi/spk&halaman= SURAT PERINTAH KERJA&pesan='+msg[1];
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
