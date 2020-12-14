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

    		<?php if (isset($_GET['pesan'])){ ?>
				<div class="form-group" id="form_report">
				  <div class="alert alert-success alert-dismissable">
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					  Kode gk :  <a href="<?=base_url()?>?page=keuangan/gk_track&action=track&halaman= TRACK GIRO KELUAR&kode_gk=<?=$_GET['pesan']?>" target="_blank"><?=$_GET['pesan'] ?></a>  Berhasil Di posting
				  </div>
				</div>
			<?php  }else if (isset($_GET['pembatalan'])){ ?>
				<div class="form-group" id="form_report">
				  <div class="alert alert-dismissable" style="background-color: #9c0303cc; color: #f9e6c3">
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color: #f9e6c3">&times;</button>
					  Pembatalan Kode GK :  <a style="color: white" href="<?=base_url()?>?page=keuangan/gk_track&halaman= TRACK GIRO KELUAR&action=track&kode_gk=<?=$_GET['pembatalan']?>" target="_blank"><?=$_GET['pembatalan'] ?></a>  Berhasil Di batalkan
				  </div>
				</div>
			<?php }else if (isset($_GET['pengembalian'])){ ?>
				<div class="form-group" id="form_report">
				  <div class="alert alert-dismissable" style="background-color: #efb25ade; font-family: Trebuchet MS;">
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					  <b>Pengembalian Kode GK :  <a href="<?=base_url()?>?page=keuangan/gk_track&halaman= TRACK GIRO KELUAR&action=track&kode_gk=<?=$_GET['pengembalian']?>" target="_blank"><?=$_GET['pengembalian'] ?></a>  Berhasil Di posting</b>
				  </div>
				</div>
			<?php } ?>

		<div class="tabbable">
			<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
				<li <?=$class_form?>>
					<a data-toggle="tab" href="#menuFormGk">Form Giro Keluar</a>
				</li>
                <li <?=$class_tab?>>
					<a data-toggle="tab" href="#menuListGk">List Giro Keluar</a>
				</li>
            </ul>

<div class="row">
	<div class="tab-content">
		<div id="menuFormGk" <?=$class_pane_form?> >
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
			                         	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode GK</label>
			                         	<div class="col-lg-4">
			                             	<input type="text" class="form-control" name="kode_gk" id="kode_gk" placeholder="Auto..." readonly value="">
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
				                     	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
					                    <div class="col-lg-4">
					                        <input type="text" autocomplete="off" class="form-control" name="ref" id="ref" placeholder="Ref..." value="">
					                    </div>

					                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Supplier</label>
                                        <div class="col-lg-4">
                                            <select id="kode_supplier" name="kode_supplier" class="select2" style="width: 100%;">
                                                <option value="">-- Pilih Supplier --</option>
                                                <?php
                                                    while($row_supplier = mysql_fetch_array($q_supplier)) { ;?>
                                                    <option value="<?php echo $row_supplier['kode_supplier'];?>">
                                                        <?php echo $row_supplier['kode_supplier'] . ' - ' . $row_supplier['nama_supplier'];?>
                                                    </option>
                                                <?php } ?>
                                             </select>
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
				                    </div>

				                    <div class="form-group">
				                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
				                        <div class="col-lg-10">
				                            <textarea type="text" class="form-control" name="keterangan_hdr" id="keterangan_hdr" placeholder="Keterangan..." value=""></textarea>
				                        </div>
				                    </div>

				                    <div class="form-group">
                     	                <div class ="col-lg-12">
                                            <table id="" class="table table-striped table-bordered table-hover" width="100%">
                                                <thead>
                                                    <tr>
                                                    	<th style="width: 25px"></th>
                                                        <th style="width:180px">Deskripsi</th>
                                                        <th style="width:180px">Saldo Transaksi</th>
                                                        <th style="width:180px">Nominal Bayar</th>
                                                        <th style="width:180px">Nominal Pelunasan</th>
                                                        <th style="width:230px">Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="detail_input_gk">
                                                	<tr>
                                                         <td colspan="6" class="text-center"> Tidak ada item barang. </td>
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
                                            <input class="form-control" type="text" name="selisih" id="selisih" value="0" style="text-align:right" readonly/>
                                        </div>
                                        <div class="col-lg-4">
                                            <select id="kode_coa_selisih" name="kode_coa_selisih" class="select2">
                                                <option value="0" style="text-align: center">
                                                	------------------------- [Pilih COA Jika Selisih > 0] --------------------------
                                                </option>
                                                <?php
                                                    while($rowcoa = mysql_fetch_array($q_coa)) { ;?>
                                                        <option value="<?php echo $rowcoa['kode_coa'];?>" ><?php echo $rowcoa['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowcoa['nama_coa'];?> </option>
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
	                                                		<input type="text" name="tgl_giro" id="tgl_giro" class="form-control date-picker" placeholder="Tanggal Giro ..." value="<?=date("m/d/Y")?>" style="text-align: center" autocomplete="off" readonly/>
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
	                                                <tr>
	                                                	<td colspan="3" style="text-align:right"><b>Subtotal :</b></td>
														<td>
															<input class="form-control" type="text" name="subtotal_giro" id="subtotal_giro" value="0" readonly style="text-align:right; font-weight: bold;"/>
														</td>
														<td></td>
	                                                </tr>
	                                                <tr>
	                                                	<td colspan="5" class="text-center">Pembayaran Giro</td>
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

                                            <a href="<?=base_url()?>?page=keuangan/gk&halaman= GIRO KELUAR" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>
               						</div>

					 		</form>

									<div class="copy">

		                            </div>
						</div>
                    </div>
				</div>
			</div>
		</div>

		<div id="menuListGk" <?=$class_pane_tab?>>
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<form action="" method="post" >

			                <div class="col-xs-12 col-md-4" style="margin-bottom:3mm">
                            <div class="input-group">
	                            <span class="input-group-addon point">Kode</span>
				                <input type="text" autocomplete="off" class="form-control" name="kode_gk" id="kode_gk" placeholder="Kode gk ..."
				                value="<?php
											if(empty($_POST['kode_gk'])){
												echo "";
											}else{
												echo $_POST['kode_gk'];
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
		                                <option value="<?php echo $row_coa['kode_coa'];?>" <?php if($row_coa['kode_coa']==$kode_coa){echo 'selected';} ?>><?php echo $row_coa['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$row_coa['nama_coa'];?> </option>
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
                                        (isset($_POST['cabang']) ? $cabang=$_POST['cabang'] : $cabang='');
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
                                    <option value="" selected>-- Pilih Supplier --</option>
                                    <?php
                                        (isset($_POST['supplier']) ? $supplier=$_POST['supplier'] : $supplier='');
                                        while($row_supplier = mysql_fetch_array($q_supplier_list)) { ;?>
                                        <option value="<?php echo $row_supplier['kode_supplier'];?>" <?php if($row_supplier['kode_supplier']==$supplier){echo 'selected';} ?>><?php echo $row_supplier['kode_supplier'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$row_supplier['nama_supplier'];?> </option>
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
	                            <input type="text" name="tanggal_akhir" id="tanggal_akhir" class="form-control date-picker" autocomplete="off" value="<?=date("m/d/Y")?>">
	                            <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
	                        </div>
	                        </div>

	                        <div class="pull-right">
	                        	<button type="submit" name="refresh" id="refresh" class="btn btn-info btn-sm" value="refresh"><i class="fa fa-refresh"></i>Refresh</button>
	                        </div>

					        <div class="col-md-1 pull-right">
								<button type="submit" name="cari" id="cari" class="btn btn-primary btn-sm" value="cari"><i class="fa fa-search"></i> cari</button>
	               			</div>
                        </form>

									<div class="box-body">
										<table id="example1" class="table table-striped table-bordered table-hover" width="100%" >
											<thead>
												<tr>
													<th>No</th>
	                                                <th>Kode GK</th>
	                                                <th>Supplier</th>
													<th>Tanggal Giro</th>
													<th>Tanggal Jth Giro</th>
													<th>Nominal</th>
													<th>Status</th>
												</tr>
											</thead>
											<tbody>

												<?php
													$n=1;
	                                                if(mysql_num_rows($q_gk) > 0) {
													    while($data = mysql_fetch_array($q_gk)) {

													    if($data['status'] == '1'){
	        												$status = 'Menunggu Pelunasan';
	        												$warna = 'style="background-color: #39b13940"';
	        											}elseif($data['status'] == '2'){
	        												$status = 'Batal';
	        												$warna = 'style="background-color: #de4b4b63;"';
	        											}else{
	        												$status = 'Lunas';
	        												$warna = 'style="background-color: #ffd10045;"';
	        											}
												?>
	    											    <tr <?= $warna?>>
	        												<td style="text-align: center"> <?php echo $n++ ?></td>
	        												<td> <a href="<?=base_url()?>?page=keuangan/gk_track&action=track&halaman= TRACK GIRO KELUAR&kode_gk=<?=$data['kode_gk']?>">
	        													 <?php echo $data['kode_gk'];?></a>
	                                                        </td>
	                                                        <td> <?php echo $data['nama_supplier'];?></td>
	        												<td> <?php echo date("d-m-Y",strtotime($data['tgl_buat']));?></td>
	        												<td> <?php echo date("d-m-Y",strtotime($data['tgl_jatuh_tempo']));?></td>
	        												<td style="text-align: right"> <?php echo number_format($data['nominal'], 2);?></td>
	        												<td style="text-align: center"> <?php echo $status;?></td>
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


<?php unset($_SESSION['load_gk']); ?>
<?php unset($_SESSION['data_giro']); ?>

<script>

$(document).ready(function (){
	$("[name='nominal']").number( true, 2 );
})

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
                url: "<?=base_url()?>ajax/j_gk.php?func=save",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(html)
                {
                    var msg = html.split("||");
                    if(msg[0] == "00") {
                        window.location = '<?=base_url()?>?page=keuangan/gk&halaman= GIRO KELUAR&pesan='+msg[1];
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
    document.getElementById('show_input_gk').style.display = "none";
  });

$('#bank_coa').change(function(event){
    event.preventDefault();
        var kode = $("#bank_coa").find(':selected').attr('data-nama');
        $('#kode_coa_save').val(kode);
});

$('#kode_cabang').change(function(){
    var id_form        = $("#id_form").val();
    var kode_supplier  = $("#kode_supplier").val();
    var kode_cabang    = $("#kode_cabang").val();
    $.ajax({
        type: "POST",
        url: "<?=base_url()?>ajax/j_gk.php?func=loaditem",
        data: "kode_supplier="+kode_supplier+"&kode_cabang="+kode_cabang+"&id_form="+id_form,
        cache:false,
        success: function(data) {
            $('#detail_input_gk').html(data);
            BindSelect2();
			numberjs();
         }
     });

    function BindSelect2() {
      $("[name='kode_coa[]']").select2({
              width: '100%'
      });
    }
	
	function numberjs(){
		$("[name='saldo_transaksi[]']").number( true, 2 );
		$("[name='nominal_bayar[]']").number( true, 2 );
		$("[name='nominal_pelunasan[]']").number( true, 2 );
		$("[name='subtotal']").number( true, 2 );
		$("[name='tot_nom_pel']").number( true, 2 );
		$("[name='selisih']").number( true, 2 );
		$("[name='nominal']").number( true, 2 );
	}

});

$('#kode_supplier').change(function(){
    var id_form        = $("#id_form").val();
    var kode_supplier  = $("#kode_supplier").val();
    var kode_cabang    = $("#kode_cabang").val();
    $.ajax({
        type: "POST",
        url: "<?=base_url()?>ajax/j_gk.php?func=loaditem",
        data: "kode_supplier="+kode_supplier+"&kode_cabang="+kode_cabang+"&id_form="+id_form,
        cache:false,
        success: function(data) {
            $('#detail_input_gk').html(data);
            BindSelect2();
			numberjs();
         }
     });

    function BindSelect2() {
      $("[name='kode_coa[]']").select2({
              width: '100%'
      });
    }
	
	function numberjs(){
		$("[name='saldo_transaksi[]']").number( true, 2 );
		$("[name='nominal_bayar[]']").number( true, 2 );
		$("[name='nominal_pelunasan[]']").number( true, 2 );
		$("[name='subtotal']").number( true, 2 );
		$("[name='tot_nom_pel']").number( true, 2 );
		$("[name='selisih']").number( true, 2 );
		$("[name='nominal']").number( true, 2 );
	}

});

$(document).on('change paste keyup', 'input[name="cb[]"], input[data-id="nominal_pelunasan"], input[data-id="nominal_bayar"]', function(){
  selisih();
});

function selisih() {
    var stat_cb     =0;
    var subtotalll  =0;
    var ok = true;

    $('table tbody tr').each(function() {

        var $tr = $(this);

        if ($tr.find('input[data-id="cb"]').is(':checked')) {

                var stat_cb = 1;

                var nominal_bayar      =  parseInt($tr.find('input[data-id="nominal_bayar"]').val()) || 0;
                var nominal_pelunasan  =  $tr.find('input[data-id="nominal_pelunasan"]').val(nominal_bayar);
                var subtotal           =  parseInt($tr.find('input[data-id="subtotal"]').val()) || 0;
                var stat_cb            =  $tr.find('input[data-id="stat_cb"]').val(stat_cb);

            if ($tr.find('input[data-id="jatuh_tempo"]').val() != 0) {
                var selisih = parseInt(nominal_bayar-nominal_pelunasan);
                parseInt($tr.find('input[data-id="selisih"]').val(selisih));
                ok = false;
             }

                var subtotall = parseInt(nominal_bayar+subtotal);
                subtotalll += subtotall;

        }else{

            var stat_cb = 0;
            
            $tr.find('input[data-id="stat_cb"]').val(stat_cb);
            parseInt($tr.find('input[data-id="nominal_pelunasan"]').val('0'));
            parseInt($tr.find('input[data-id="selisih"]').val('0'));
 
        }
    });

    $('#subtotal').val(subtotalll);
    $('#tot_nom_pel').val(subtotalll);
    
    return ok;
}

/* $("[name='cb[]']").click(function(){
    var is_checked = $(this).prop('checked');
    var tr = $(this).parents('tr');

    var in_harga = tr.find("[data-id='nominal_bayar']").val();
    in_harga = parseInt(in_harga);

    var in_subtotal = tr.find("[data-id='subtotal']").val();
    in_subtotal = parseInt(in_subtotal);

    if(is_checked == true) {
        harga = parseInt(in_harga+in_subtotal);
    }else{
        harga = parseInt(in_subtotal-in_harga);
    }

    $('#subtotal').val(harga);
});

$(document).on("change paste keyup", "input[data-id='nominal_pelunasan']", function(){

    var stat_cb     = 0;
    var subtotalll  = 0;
    var tot_nom_pel = 0;

    $('table tbody tr').each(function() {

        var $tr = $(this);

        if ($tr.find('input[data-id="cb"]').is(':checked')) {
                var stat_cb = 1;

                var nominal_bayar      =  parseInt($tr.find('input[data-id="nominal_bayar"]').val() || 0);
                var nominal_pelunasan  =  parseInt($tr.find('input[data-id="nominal_pelunasan"]').val() || 0);
                var subtotal           =  parseInt($tr.find('input[data-id="subtotal"]').val() || 0);
                var tot_nom_pel        =  parseInt($tr.find('input[data-id="tot_nom_pel"]').val() || 0);
                var stat_cb            =  $tr.find('input[data-id="stat_cb"]').val(stat_cb);


                var selisih = (nominal_pelunasan-nominal_bayar);
                ($tr.find('input[data-id="selisih"]').val(selisih));

                var subtotall = (nominal_bayar);
                subtotalll += subtotall;

                tot_nom_pel += (nominal_pelunasan);

        }
    });
        $('#subtotal').val(subtotalll);
        $('#tot_nom_pel').val(tot_nom_pel);
}); */

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
          var selisih = tot_nom_pel - $("#subtotal_giro").val();
          $('#selisih').val(selisih);
		  numberjs();
        }
      });
	  
	  function numberjs(){
		$("[name='subtotal_giro']").number( true, 2 );
		}
    }else{
      alert("Peringatan : Bank Giro, No Giro, dan Nominal wajib diisi !!");
    }
    return false;
  });
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
