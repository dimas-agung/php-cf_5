<?php
	include "pages/data/script/bts.php";
	include "library/form_akses.php";
?>
<section class="content-header">

        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-folder-open"></i> Logistik</a></li>
          <li>
          	<a href="#">Bukti Terima Aset</a>

          </li>
        </ol>
</section>


<div class="box box-info">
    <div class="box-body">

    		<?php if (isset($_GET['pesan'])){ ?>
				<div class="form-group" id="form_report">
				  <div class="alert alert-success alert-dismissable">
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					  Kode bts :  <a href="<?=base_url()?>?page=logistik/bts_track&action=track&halaman= TRACK BUKTI TERIMA ASET&kode_bts=<?=$_GET['pesan']?>&halaman=BUKTI TERIMA ASET" target="_blank"><?=$_GET['pesan'] ?></a>  Berhasil Di posting
				  </div>
				</div>
			<?php  }  ?>

		<div class="tabbable">
			<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
				<li <?=$class_form?>>
					<a data-toggle="tab" href="#menuFormbts">Form Bukti Terima Aset</a>
				</li>
                <li <?=$class_tab?>>
					<a data-toggle="tab" href="#menuListbts">List Bukti Terima Aset</a>
				</li>
            </ul>

            <div class="row">
			<div class="tab-content">
				<div id="menuFormbts"
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
			                         	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode bts</label>
			                         	<div class="col-lg-4">
			                             	<input type="text" class="form-control" name="kode_bts" id="kode_bts" placeholder="Auto..." readonly value="">
			                         	</div>

			                         	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
				                         <div class="col-lg-4">
				                             <select id="kode_cabang" name="kode_cabang" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Cabang --</option>
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
				                     	 <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
				                         <div class="col-lg-4">
				                             <input type="text" class="form-control" name="ref" id="ref" placeholder="Ref..." value="" autocomplete="off">
				                         </div>

				                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">DOC OPS</label>
				                         <div class="col-lg-4" id="load_ops">
				                            <select id="no_ops" name="no_ops" class="select2" style="width: 100%;" disabled>
					                        <option value="0">-- Pilih CABANG DULU --</option>
					                        <?php
											//CEK JIKA KODE_OP ADA MAKA SELECTED
											(isset($row['id_bts']) ? $kode_ops=$row['kode_ops'] : $kode_ops='');
											//UNTUK AMBIL kode_ops nya
						                    while($row_doc_ops = mysql_fetch_array($q_doc_ops)) { ;?>

						                    	<opstion
						                    		data-kode-supplier="<?php echo $row_doc_ops['kode_supplier'];?>"
						                    		data-supplier="<?php echo $row_doc_ops['kode_supplier'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$row_doc_ops['nama_supplier'];?>"
						                    		value="<?php echo $row_doc_ops['kode_ops'];?>" <?php if($row_doc_ops['kode_ops']==$kode_ops){echo 'selected';} ?>><?php echo $row_doc_ops['kode_ops'];?>
						                    	</option>

						                    <?php } ?>
				                        	</select>
				                         </div>
				                     </div>

				                     <div class="form-group">
				                     	 <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal BTS</label>
				                         <div class="col-lg-4">
				                         	<div class="input-group">
				                             <input type="text" name="tanggal" id="tanggal" class="form-control date-picker-close" placeholder="Tanggal Bukti Terima Barang ..." value="<?=date("m/d/Y")?>" autocomplete="off"/>
				                             <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
				                             <input type="hidden" name="tgl_sekarang" id="tgl_sekarang" class="form-control" value="<?=date("d-m-Y")?>"/>
				                            </div>
				                         </div>

				                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Supplier</label>
			                         	<div class="col-lg-4">
			                             	<input type="text" class="form-control" name="supplier" id="supplier" placeholder="Pilih DOC OPS dahulu ..." value="" readonly>
			                             	<input type="hidden" class="form-control" name="kode_supplier" id="kode_supplier" placeholder="Pilih DOC OP dahulu ..." value="" readonly>
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
                                            <table id="" class="table table-bordered table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10px">No</th>
                                                        <th style="width: 150px">Kode</th>
                                                        <th style="width: 300px">Deskripsi Aset</th>
                                                        <th style="width: 150px">Q OPS</th>
                                                        <th style="width: 150px">Q Diterima</th>
                                                        <th style="width: 150px">Divisi</th>
                                                        <th style="width: 200px">Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="detail_input_bts">
                                                    <tr>
                                                        <td colspan="7" class="text-center">Belum ada item</td>
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

											<button type="submit" name="simpan" id="simpan" class="btn btn-primary pb-save" tabindex="10"><i class="fa fa-check-square-o"></i> Simpan</button>
                                            <?php } } } ?>

                                            <a href="<?=base_url()?>?page=logistik/bts&halaman=BUKTI TERIMA ASET" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>
               						 </div>

					 					</form>

									</div>
                            	</div>
							</div>
						</div>
				</div>

				<div id="menuListbts" <?=$class_pane_tab?>>
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-body">

									<form action="" method="post" >

			                         	<div class="col-xs-12 col-md-6" style="margin-bottom:3mm">
                                      		<div class="input-group">
	                                      		<span class="input-group-addon point">Kode</span>
				                             	<input type="text" autocomplete="off" class="form-control" name="kode_bts" id="kode_bts" placeholder="Kode bts ..." value="<?php

													if(empty($_POST['kode_bts'])){
														echo "";

													}else{
														echo $_POST['kode_bts'];
													}

													?>">
				                            </div>
			                         	</div>

			                         	<div class="col-xs-12 col-md-6" style="margin-bottom:3mm">
                                      		<div class="input-group">
	                                      		<span class="input-group-addon point">Ref</span>
					                             <input type="text" autocomplete="off" class="form-control" name="ref" id="ref" placeholder="Ref..."
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
	                                      		<span class="input-group-addon point">Aset</span>
				                            		<select id="aset" name="aset" class="select2" style="width: 100%;">
	                                                <option value="" selected>-- Pilih aset --</option>

	                                                <?php
	                                                (isset($_POST['aset']) ? $aset=$_POST['aset'] : $aset='');

	                                                //UNTUK AMBIL coanya
	                                                while($row_aset = mysql_fetch_array($q_aset)) { ;?>

	                                                <option style="font-size: 8px;" value="<?php echo $row_aset['kode_aset'];?>" <?php if($row_aset['kode_aset']==$aset){echo 'selected';} ?>><?php echo $row_aset['kode_aset'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$row_aset['nama_aset'];?> </option>
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

                                                <option value="<?php echo $row_cabang['kode_cabang'];?>" <?php if($row_cabang['kode_cabang']==$cabang){echo 'selected';} ?>><?php echo $row_cabang['kode_cabang'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$row_cabang['nama_cabang'];?> </option>
                                                <?php } ?>
                                                </select>
				                         	</div>
				                        </div>

				                     	<div class="col-xs-12 col-md-4" style="margin-bottom:3mm">
                                      		<div class="input-group">
	                                      		<span class="input-group-addon point">Supplier</span>
				                             	<select id="supplier" name="supplier" class="select2" style="width: 100%;">
                                                <option value="" selected>-- Pilih supplier --</option>
                                                <?php
                                                //CEK JIKA supplier ADA MAKA SELECTED
                                                (isset($_POST['supplier']) ? $supplier=$_POST['supplier'] : $supplier='');
                                                //UNTUK AMBIL coanya
                                                while($row_supplier = mysql_fetch_array($q_supplier)) { ;?>

                                                <option value="<?php echo $row_supplier['kode_supplier'];?>" <?php if($row_supplier['kode_supplier']==$supplier){echo 'selected';} ?>><?php echo $row_supplier['kode_supplier'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$row_supplier['nama_supplier'];?> </option>
                                                <?php } ?>
                                                </select>
				                         	</div>
				                    	</div>


				                     	<div class="col-xs-12 col-md-6" style="margin-bottom:3mm">
	                                        <div class="input-group">
	                                            <span class="input-group-addon">Tanggal Awal</i></span>
	                                            <input type="text" name="tanggal_awal" id="tanggal_awal" class="form-control date-picker" autocomplete="off" value="<?=date("m/d/Y")?>">
	                                            <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
	                                        </div>
	                                    </div>
	                                    <div class="col-xs-12 col-md-6" style="margin-bottom:3mm">
	                                        <div class="input-group">
	                                         	<span class="input-group-addon">Tanggal Akhir</span>
	                                         	<input type="text" name="tanggal_akhir" id="tanggal_akhir" class="form-control date-picker" autocomplete="off" value="<?=date("m/d/Y")?>">
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

									<div class="box-body">
									<table id="example1" class="table table-striped table-bordered table-hover" width="100%" >
										<thead>
											<tr>
                                                <th>No</th>
												<th>Kode BTS</th>
												<th>Kode OPS</th>
												<th>Deskripsi Aset</th>
												<th>Tanggal</th>
												<th>Supplier</th>
												<th>Cabang</th>
                                                <th>Q Diterima</th>
                                                <th>Status</th>
                                                <th></th>
											</tr>
										</thead>
										<tbody>

											<?php
												$n=1; if(mysql_num_rows($q_bts) > 0) {
												while($data = mysql_fetch_array($q_bts)) {
											?>

											<tr>
												<td style="text-align: center; width:5px"> <?php echo $n++ ?></td>
												<td><a href="<?=base_url()?>?page=logistik/bts_track&action=track&kode_bts=<?=$data['kode_bts']?>&halaman= TRACK BUKTI TERIMA ASET">
													<?php echo $data['kode_bts'];?></a></td>
												<td><a href="<?=base_url()?>?page=pembelian/ops_track&action=track&kode_ops=<?=$data['kode_ops']?>&halaman= TRACK ORDER PEMBELIAN ASET">
													<?php echo $data['kode_ops'];?></a></td>
												<td> <?php echo $data['nama_aset'];?></td>
												<td> <?php echo date("d-m-Y",strtotime($data['tgl_buat']));?></td>
                                                <td> <?php echo $data['nama_supplier'];?></td>
												<td> <?php echo $data['nama_cabang'];?></td>
                                                <td style="text-align:right"> <?php echo number_format($data['qty']);?></td>
                                                <td style="text-align:center"> <?php echo $data['aktif']=='1' ?
                                                	'<p>
                                                		<span width="30px"class="btn-sm btn-success fa fa-check"></span>&nbsp;
                                                		Ready
                                                	 </p>'
                                                	 :
                                                	 '<p>
                                                	 	<span class="btn-sm btn-danger fa fa-remove"></span>&nbsp;
                                                	 	Close
                                                	 </p>'
                                                	 ?>
                                                </td>
                                                <td style="text-align: center">
                                                	<a href="<?=base_url()?>r_cetak_bts.php?kode=<?=$data['kode_bts']?>&halaman= CETAK BUKTI TERIMA ASET" title="cetak" target="_blank">
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

<?php unset($_SESSION['data_bts']); ?>
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
      font-size: 14px;
  }

  td {
      text-align: left;
      padding: 8px;
      font-size: 13px;
  }

  tr:nth-child(even){background-color: #f2f2f2}
  </style>
<!-- <script type="text/javascript">
  $(document).ready(function(){
    $('.pb-save').click(function(){

        if ($('[name="q_diterima[]"]').val() > $('[name="qty_ops[]"]').val()){
            alert("Q Diterima melebihi Q OPS");
            return false;
        }

    });
  });
</script> -->

  <script>
  $(document).ready(function (e) {
	 $("#saveForm").on('submit',(function(e) {
		var grand_total = 0;
				$('[name="q_diterima[]"]').each(function() {
					grand_total += +this.value || 0;
				});

		//console.log(grand_total);

		if(grand_total == "" || isNaN(grand_total)) {grand_total = 0;}
		e.preventDefault();
	  	if(grand_total != 0 && grand_total > 0) {
			$(".animated").show();
			$.ajax({
				url: "<?=base_url()?>ajax/j_bts.php?func=save",
				type: "POST",
				data:  new FormData(this),
				contentType: false,
				cache: false,
				processData:false,
				success: function(html)
				{
					var msg = html.split("||");
					if(msg[0] == "00") {
						window.location = '<?=base_url()?>?page=logistik/bts&halaman=BUKTI TERIMA ASET&pesan='+msg[1];
					} else {
						notifError(msg[1]);
					}
					$(".animated").hide();
				}

		   });
	  	} else {notifError("<p>Item  masih kosong.</p>");}
	 }));
  });

  $('#kode_cabang').change(function(){
        var kode_cabang = $("#kode_cabang").val();

        $.ajax({
            type: "POST",
            url: "<?=base_url()?>ajax/j_bts.php?func=loadops",
            data: "kode_cabang="+kode_cabang,
            cache:false,
            success: function(data) {
                $('#load_ops').html(data);
				BindSelect2();

            }
		});

		function BindSelect2() {
			$("[name='no_ops']").select2({
          		width: '100%'
         	});
		}

  });


	$('body').delegate("#no_ops","change", function() {
		var supplier 		= $("#no_ops").find(':selected').attr('data-supplier');
		var kode_supplier 	= $("#no_ops").find(':selected').attr('data-kode-supplier');
		var kode_ops 		= $("#no_ops").val();
			$.ajax({
					type: "POST",
					url: "<?=base_url()?>ajax/j_bts.php?func=loaditem",
					data: "kode_ops="+kode_ops,
					cache:false,
					success: function(data) {
						$('#supplier').val(supplier);
						$('#kode_supplier').val(kode_supplier);
						$('#detail_input_bts').html(data);
					}
				});
	});

</script>

<script src="<?=base_url()?>assets/select2/select2.js"></script>
<script>

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
