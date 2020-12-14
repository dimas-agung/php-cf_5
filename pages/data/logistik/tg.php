<?php
	include "pages/data/script/tg.php";
	include "library/form_akses.php";
	$action = $_GET['action'];
	$kode_pm = $_GET['kode_pm'];
?>
<section class="content-header">
    <ol class="breadcrumb">
        <li><i class="fa fa-folder-open"></i> Logistik</a></li>
        <li>Transfer Gudang</a></li>
    </ol>
</section>

<div class="box box-info">
    <div class="box-body">

    		<?php if (isset($_GET['pesan'])){ ?>
				<div class="form-group" id="form_report">
				  <div class="alert alert-success alert-dismissable">
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					  Kode TG :  <a href="<?=base_url()?>?page=logistik/tg_track&action=track&halaman= TRACK TRANSFER GUDANG&kode_tg=<?=$_GET['pesan']?>" target="_blank"><?=$_GET['pesan'] ?></a>  Berhasil Di posting
				  </div>
				</div>
			<?php  }  else if (isset($_GET['pembatalan'])){ ?>
                <div class="form-group" id="form_report">
                  <div class="alert alert-dismissable" style="background-color: #9c0303cc; color: #f9e6c3">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color: #f9e6c3">&times;</button>
                      Pembatalan Kode TG :  <a style="color: white" href="<?=base_url()?>?page=logistik/tg_track&halaman= TRACK TRANSFER GUDANG&action=track&kode_tg=<?=$_GET['pembatalan']?>" target="_blank"><?=$_GET['pembatalan'] ?></a>  Berhasil Di batalkan
                  </div>
                </div>
            <?php } ?>

		<div class="tabbable">
			<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
				<li <?=$class_form?>>
					<a data-toggle="tab" href="#menuFormBtb">Form Transfer Gudang</a></li>
                <li <?=$class_tab?>>
					<a data-toggle="tab" href="#menuListBtb">List Transfer Gudang</a>
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
			                         	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode TG</label>
			                         	<div class="col-lg-4">
			                             	<input type="text" class="form-control" name="kode_tg" id="kode_tg" placeholder="Auto..." readonly value="">
			                         	</div>
										
										<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode PM</label>
			                         	<div class="col-lg-4">
			                             	<input type="text" class="form-control" name="kode_pm" id="kode_pm" placeholder="Auto..." readonly value="<?=$kode_pm?>">
											<input type="hidden" name="kode_spk" id="kode_spk" class="form-control" value="<?=(count($pm_hdr_f) > 0 ? $pm_hdr_f['kode_spk'] : null);?>"/>
			                         	</div>
                                        
                         			 </div>

				                     <div class="form-group">
				                     	 <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
				                         <div class="col-lg-4">
				                             <input type="text" class="form-control" name="ref" id="ref" placeholder="Ref..." value="<?=(count($pm_hdr_f) > 0 ? $pm_hdr_f['ref'] : null);?>" autocomplete="off">
				                         </div>

                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal PM</label>
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
												if ($action == 'pm_to_tg') {
                                                //CEK JIKA cabang ADA MAKA SELECTED
                                                (isset($row['id_pm']) ? $cabang=$row['kode_cabang'] : $cabang=(count($pm_hdr_f) > 0 ? $pm_hdr_f['kode_cabang'] : null));
                                                //UNTUK AMBIL coanya
                                                while($row_cabang = mysql_fetch_array($q_cabang)) { ;?>

                                                <option value="<?php echo $row_cabang['kode_cabang'];?>" <?php if($row_cabang['kode_cabang']==$cabang){echo 'selected';} ?>><?php echo $row_cabang['nama_cabang'];?> </option>
                                                <?php }} ?>
                                                </select>
				                         </div>
										 
				                     	 

                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Gudang Asal</label>
				                         <div class="col-lg-4">
				                             <select id="kode_gudang_a" name="kode_gudang_a" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Gudang Asal --</option>
                                                <?php
												if ($action == 'pm_to_tg') {
                                                //CEK JIKA gudang_a ADA MAKA SELECTED
                                                (isset($row['id_pm']) ? $gudang_a=$row['kode_gudang'] : $gudang_a=(count($pm_hdr_f) > 0 ? $pm_hdr_f['kode_gudang_asal'] : null));
                                                //UNTUK AMBIL coanya
                                                while($row_gudang_a = mysql_fetch_array($q_gudang_a)) { ;?>

                                                <option value="<?php echo $row_gudang_a['kode_gudang'];?>" <?php if($row_gudang_a['kode_gudang']==$gudang_a){echo 'selected';} ?>><?php echo $row_gudang_a['nama_gudang'];?> </option>
                                                <?php }} ?>
                                                </select>
				                         </div>
				                     </div>

				                     <div class="form-group">
				                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Gudang Tujuan</label>
				                         <div class="col-lg-4">
				                             <select id="kode_gudang_b" name="kode_gudang_b" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Gudang Tujuan --</option>
                                                <?php
												if ($action == 'pm_to_tg') {
                                                //CEK JIKA gudang_b ADA MAKA SELECTED
                                                (isset($row['id_pm']) ? $gudang_b=$row['kode_gudang'] : $gudang_b=(count($pm_hdr_f) > 0 ? $pm_hdr_f['kode_gudang_tujuan'] : null));
                                                //UNTUK AMBIL coanya
                                                while($row_gudang_b = mysql_fetch_array($q_gudang_b)) { ;?>

                                                <option value="<?php echo $row_gudang_b['kode_gudang'];?>" <?php if($row_gudang_b['kode_gudang']==$gudang_b){echo 'selected';} ?>><?php echo $row_gudang_b['nama_gudang'];?> </option>
                                                <?php }} ?>
                                                </select>
				                         </div>
				                     </div>

				                     <div class="form-group">
				                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
				                         <div class="col-lg-10">
				                             <textarea type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan..." value=""><?=(count($pm_hdr_f) > 0 ? $pm_hdr_f['keterangan_hdr'] : null);?></textarea>
				                         </div>
				                     </div>

				                     <div class="form-group">
                     	                <div class="col-lg-12">
                                            <table id="" class="" rules="all">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10px">No</th>
                                                        <th style="width: 150px">Barang</th>
                                                        <th style="width: 150px">QTY</th>
                                                        <th style="width: 150px">Stok</th>
                                                        <th style="width: 150px">Rata-rata</th>
                                                        <th style="width: 150px">Total</th>
                                                        <th style="width: 200px">Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="detail_input_pm">
													<?php 
													if (mysql_num_rows($pm_dtl)) {
														$i = 0;
														$n = 1;
														while ($row_pm_dtl = mysql_fetch_array($pm_dtl)) {
													?>
													<tr>
                                                        <td class="text-center"><?=$n++; ?></td>
                                                        <td class="text-left"><?=$row_pm_dtl['kode_inventori'] . ' - ' . $row_pm_dtl['nama_barang']; ?><input type="hidden" name="kd_produk[]" id="kd_produk_<?=$i;?>" value="<?=$row_pm_dtl['kode_inventori'];?>"></td>
                                                        <td class="text-left"><div class="input-group"><input class="form-control text-right" type="text" name="qty[]" id="qty_<?=$i;?>" value="<?=$row_pm_dtl['qty'];?>"><input type="hidden" name="qty_i[]" id="qty_i_<?=$i;?>" value="<?=$row_pm_dtl['qty'];?>"><span class="input-group-addon"><?=$row_pm_dtl['kode_satuan'];?><input type="hidden" name="kd_satuan[]" id="kd_satuan_<?=$i;?>" value="<?=$row_pm_dtl['kode_satuan'];?>"></span></div></td>
                                                        <td class="text-right"><?=number_format($row_pm_dtl['stok'], 2) . ' ' . $row_pm_dtl['kode_satuan'];?><input type="hidden" name="stok[]" id="stok_<?=$i;?>" value="<?=$row_pm_dtl['stok'];?>"></td>
                                                        <td class="text-right"><?=number_format($row_pm_dtl['rata'], 2);?><input type="hidden" name="rata[]" id="rata_<?=$i;?>" value="<?=$row_pm_dtl['rata'];?>"></td>
                                                        <td class="text-right"><span id="text-total_<?=$i;?>"><?=number_format(($row_pm_dtl['qty']*$row_pm_dtl['rata']), 2);?></span><input type="hidden" name="total[]" id="total_<?=$i;?>" value="<?=number_format(($row_pm_dtl['qty']*$row_pm_dtl['rata']), 4, '.', '');?>"></td>
                                                        <td class="text-left"><input class="form-control" type="text" name="keterangan_dtl[]" id="keterangan_dtl_<?=$i;?>" value="<?=$row_pm_dtl['keterangan_dtl'];?>"></td>
                                                    </tr>
													<?php $i++; }} else { ?>
                                                    <tr>
                                                        <td colspan="7" class="text-center">Belum ada item.</td>
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

											<!-- <button type="submit" name="simpan" id="simpan" class="btn btn-primary" tabindex="10"><i class="fa fa-check-square-o"></i> Simpan</button> -->
                                            <?php } } } ?>
											<button type="submit" name="simpan" id="simpan" class="btn btn-primary" tabindex="10"><i class="fa fa-check-square-o"></i> Simpan</button>

                                            <a href="<?=base_url()?>?page=logistik/pm&halaman= TRANSFER GUDANG" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>
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
												<th style="font-size: 14px">Kode TG</th>
												<th style="font-size: 14px">Tgl TG</th>
												<th style="font-size: 14px">Ref</th>
												<th style="font-size: 14px">Cabang</th>
												<th style="font-size: 14px">Gudang Asal</th>
												<th style="font-size: 14px">Gudang Tujuan</th>
												<th style="font-size: 14px">Status</th>
                                                <th style="font-size: 14px"></th>
											</tr>
										</thead>
										<tbody>

											<?php
												$n=1; if(mysql_num_rows($q_tg) > 0) {
												while($data = mysql_fetch_array($q_tg)) {

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
												<td style="font-size: 12px"><a href="<?=base_url()?>?page=logistik/tg_track&action=track&halaman= TRACK TRANSFER GUDANG&kode_tg=<?=$data['kode_tg']?>" target="_blank">
													<?php echo $data['kode_tg'];?></a></td>
												<td style="font-size: 12px"> <?php echo date("d-m-Y",strtotime($data['tgl_buat']));?></td>
                                                <td style="font-size: 12px"> <?php echo $data['ref'];?></td>
												<td style="font-size: 12px"> <?php echo $data['nama_cabang'];?></td>
												<td style="font-size: 12px"> <?php echo $data['nama_gudang_asal'];?></td>
												<td style="font-size: 12px"> <?php echo $data['nama_gudang_tujuan'];?></td>
												<td style="text-align:center;"> <?php echo $status; ?></td>
                                                <td style="font-size: 12px; text-align: center">
                                                	<!-- <a href="<?=base_url()?>r_cetak_tg.php?kode_tg=<?=$data['kode_tg']?>" title="cetak" target="_blank">
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

<?php unset($_SESSION['data_pm']); ?>
	
<script type="text/javascript">
	$(document).ready(function () {

      // $("[name='bayari']").number( true, 2 );

      // $(".select2item").select2({
      //   width : '100%'
      // });

      $("[name='qty[]']").number( true, 2 );
	  $("[name='stok[]']").number(true, 2);
	  $("[name='rata[]']").number(true, 2);
	  $("[name='total[]']").number(true, 2);
	  $("[id*='text-total_']").number(true, 2);
      
  });
</script>
	
  <script>
  $(document).ready(function (e) {
	  
		function calculate() {

            var sumTotal = 0;

            $('table tbody tr').each(function ($i) {

                var $tr = $(this);

                var qty = parseFloat($tr.find('input[name="qty[]"]').val()) || 0;
                var rata = parseFloat($tr.find('input[name="rata[]"]').val()) || 0;

                var total = parseFloat((rata) * qty);
				var xTotal = total;

                $tr.find('input[name="total[]"]').val(xTotal);
				$tr.find('span#text-total_' + $i).html(parseFloat($tr.find('input[name="total[]"]').val()) || 0);

                sumTotal += total;

            });
numberjs();
            // console.log(sumTotal);

        }
		
		$(document).on('keyup change', 'input[name="qty[]"]', function (e) {
			e.preventDefault();
			calculate();
			
		});
		
		function numberjs() {
			$("[name='qty[]']").number( true, 2 );
			  $("[name='stok[]']").number(true, 2);
			  $("[name='rata[]']").number(true, 2);
			  $("[name='total[]']").number(true, 2);
			  $("[id*='text-total_']").number(true, 2);
		}
		
	 $("#saveForm").on('submit',(function(e) {
    		var grand_total = 0.0;
    		grand_total += parseFloat($("[name='qty[]']").val());
    		if(grand_total == "" || isNaN(grand_total)) {grand_total = 0;}
			
			
			var kode_pm = $("#kode_pm").val();
            if(kode_pm == 0 ) {
                $("#kode_pm").focus();
                notifError("<p>Kode PM tidak boleh kosong!!!</p>");
                return false;
            }

            var kode_cabang = $("#kode_cabang").val();
            if(kode_cabang == 0 ) {
                $("#kode_cabang").focus();
                notifError("<p>Cabang tidak boleh kosong!!!</p>");
                return false;
            }
			
			var kode_gudang_a = $("#kode_gudang_a").val();
            if(kode_gudang_a == 0 ) {
                $("#kode_gudang_a").focus();
                notifError("<p>Gudang Asal tidak boleh kosong!!!</p>");
                return false;
            }
			
			var kode_gudang_b = $("#kode_gudang_b").val();
            if(kode_gudang_b == 0 ) {
                $("#kode_gudang_b").focus();
                notifError("<p>Gudang Tujuan tidak boleh kosong!!!</p>");
                return false;
            }

    		e.preventDefault();
    	  	if(grand_total != 0) {
    			$(".animated").show();
    			$.ajax({

    				url: "<?=base_url()?>ajax/j_tg.php?func=save_pm",
    				type: "POST",
    				data:  new FormData(this),
    				contentType: false,
    				cache: false,
    				processData:false,
    				success: function(html)
    				{
    					var msg = html.split("||");
    					if(msg[0] == "00") {
    						window.location = '<?=base_url()?>?page=logistik/tg&action=pm_to_tg&kode_pm=<?=$kode_pm;?>&halaman= TRANSFER GUDANG&pesan='+msg[1];
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
