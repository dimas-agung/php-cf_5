<?php
	include "pages/data/script/bkk.php";
	include "library/form_akses.php";
?>

<style>
  .pm-min, .pm-min-s{padding:3px 1px; }
  .animated{display:none;}

  table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 1750px;
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
</style>

<section class="content-header">
        <ol class="breadcrumb">
          <li><i class="fa fa-money"></i>Keuangan</li>
          <li>Bukti Kas Keluar</li>
        </ol>
</section>


<div class="box box-info">
    <div class="box-body">

    		<?php if (isset($_GET['pesan'])){ ?>
				<div class="form-group" id="form_report">
				  <div class="alert alert-success alert-dismissable">
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					  Kode BKK :  <a href="<?=base_url()?>?page=keuangan/bkk_track&action=track&halaman= TRACK BUKTI KAS KELUAR&kode_bkk=<?=$_GET['pesan']?>" target="_blank"><?=$_GET['pesan'] ?></a>  Berhasil Di posting
				  </div>
				</div>
			<?php  }  ?>

		<div class="tabbable">
			<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
				<li <?=$class_form?>>
					<a data-toggle="tab" href="#menuFormBkk">Form Bukti Kas Keluar</a>
				</li>
                <li <?=$class_tab?>>
					<a data-toggle="tab" href="#menuListBkk">List Bukti Kas Keluar</a>
				</li>
            </ul>

            <div class="row">
			<div class="tab-content">
				<div id="menuFormBkk"
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
			                         	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode BKK</label>
			                         	<div class="col-lg-4">
			                             	<input type="text" class="form-control" name="kode_bkk" id="kode_bkk" placeholder="Auto..." readonly value="">
			                         	</div>

			                         	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Supplier</label>
			                         	<div class="col-lg-4">
			                             	<select id="kode_supplier" name="kode_supplier" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Supplier --</option>
                                                <?php
                                                //CEK JIKA supplier ADA MAKA SELECTED
                                                (isset($row['id_bkk']) ? $supplier=$row['kode_supplier'] : $supplier='');
                                                //UNTUK AMBIL coanya
                                                while($row_supplier = mysql_fetch_array($q_supplier)) { ;?>

                                                <option value="<?php echo $row_supplier['kode_supplier'];?>" <?php if($row_supplier['kode_supplier']==$supplier){echo 'selected';} ?>><?php echo $row_supplier['kode_supplier'] . ' - ' . $row_supplier['nama_supplier'];?> </option>
                                                <?php } ?>
                                             </select>
			                         	</div>
                         			 </div>

				                     <div class="form-group">
				                     	 <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
					                        <div class="col-lg-4">
					                            <input type="text" autocomplete="off" class="form-control" name="ref" id="ref" placeholder="Ref..." value="">
					                        </div>

					                     <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Metode Pembayaran</label>
				                         <div class="col-lg-4">
				                            <select id="kode_pembayaran" name="kode_pembayaran" class="select2" style="width: 100%;">
                                                <option value="">-- Pilih Metode Pembayaran --</option>
                                                <?php
                                                while($row_pembayaran = mysql_fetch_array($q_pembayaran)) { ;?>
                                                <option
                                                	data-nama="<?php echo $row_pembayaran['singkatan'];?>"
                                                	value="<?php echo $row_pembayaran['kode_coa'];?>"
                                                	<?php if($row_pembayaran['kode_coa']==$row_pembayaran){echo 'selected';} ?>><?php echo $row_pembayaran['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$row_pembayaran['nama_coa'];?> </option>
                                                <?php } ?>

                                                <input type="hidden" name="nama_pembayaran" id="nama_pembayaran" class="form-control" value=""/>
                                            </select>
				                         </div>
				                     </div>

				                     <div class="form-group">
				                     	 <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal</label>
				                         <div class="col-lg-4">
				                         	<div class="input-group">
				                             <input type="text" name="tgl_buat" id="tgl_buat" class="form-control date-picker-close" placeholder="Tanggal Bukti Kas Keluar ..." value="<?=date("m/d/Y")?>" autocomplete="off" readonly/>
				                             <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
				                            </div>
				                         </div>
				                     </div>

				                     <div class="form-group">
				                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
				                         <div class="col-lg-4">
                                         <select id="kode_cabang" name="kode_cabang" class="select2" style="width: 100%;">
                                            <option value="" selected>-- Pilih Cabang --</option>
                                                <?php
                                                //CEK JIKA cabang ADA MAKA SELECTED
                                                (isset($row['id_btb']) ? $cabang=$row['kode_cabang'] : $cabang='');
                                                //UNTUK AMBIL coanya
                                                while($row_cabang = mysql_fetch_array($q_cabang)) { ;?>

                                                <option
                                                		value="<?php echo $row_cabang['kode_cabang'];?>"
                                                		<?php if($row_cabang['kode_cabang']==$cabang){echo 'selected';} ?>><?php echo $row_cabang['nama_cabang'];?> </option>
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
		                                <div class="col-lg-12">
		                                    <div class="col-lg-10 pull-left">
		                                        <a class="btn btn-success" id="tambah_bkk"><i class="fa fa-plus"></i> Add</a>
		                                    </div>
                                            <div class="col-lg-1">
                                                <marquee direction="right" width="100%" scrollamount="5"><b>disini --></b></marquee>
                                            </div>
                                            <div class="col-lg-1 pull-right">
                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-warning">
                                                    Rules !
                                                </button>
                                            </div>
		                                </div>
		                             </div>

				                     <div class="form-group">
                     	                <div style="overflow-x:auto;">
                                            <table id="" class="" rules="all">
                                                <thead>
                                                    <tr>
                                                    	 <th style="width: 50px"></th>
                                                        <th style="width:200px">Deskripsi</th>
                                                        <th style="width:200px">Saldo Transaksi</th>
                                                        <th style="width:200px">Nominal Bayar</th>
                                                        <th style="width:200px">Nominal Pelunasan</th>
                                                        <th style="width:200px">Selisih</th>
                                                        <th style="width:400px">COA</th>
                                                        <th style="width:200px">Keterangan</th>
                                                        <th style="width:100px"></th>
                                                    </tr>

                                                    <tr id="show_input_bkk" style="display:none">
                                                            <td>#</td>
                                                    		    <td>
                                                                <input class="form-control" type="text" name="deskripsi" id="deskripsi" style="width:200px" value=""/>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="text" name="saldo_transaksi" id="saldo_transaksi" style="width:200px; text-align: right;" value="0" autocomplete="off" readonly/>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="text" name="nominal_bayar" id="nominal_bayar" style="width:200px; text-align: right;" value="0" autocomplete="off"/>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="text" name="nominal_pelunasan" id="nominal_pelunasan" style="width:200px; text-align: right;" value="0" autocomplete="off" readonly />
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="text" name="selisih" id="selisih" style="width:200px; text-align: right;" value="0" autocomplete="off" readonly />
                                                            </td>
                                                            <td >
                                                              <select id="kode_coa" name="kode_coa" class="select2" style="width:400px">
                                                                <option value="">-- Pilih COA Manual --</option>
                                                                    <?php
                                                                        while($row_coa = mysql_fetch_array($q_coa)) { ;?>
                                                                        <option
                                                                            value="<?php echo $row_coa['kode_coa'].':'.$row_coa['nama_coa'];?>" >
                                                                            <?php echo $row_coa['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$row_coa['nama_coa'];?>
                                                                        </option>
                                                                    <?php } ?>
                                                              </select>
                                                          </td>
                                                            <td>
                                                                 <input class="form-control" type="text" name="keterangan_dtl" id="keterangan_dtl" style="width: 200px" value="" placeholder="Keterangan ..." autocomplete="off" />
                                                            </td>
                                                            <td style="text-align: center; width: 100px;">
                                                                <button id="ok_input" class="btn btn-xs btn-success ace-icon fa fa-check" title="ok"></button>
                                                                <a href="" id="batal_input" class="btn btn-xs btn-danger ace-icon fa fa-remove" title="batal" ></a>
                                                            </td>
                                                    </tr>
                                                </thead>
                                                <tbody id="detail_input_bkk">
                                                	  <tr>
                                                      <td colspan="9" class="text-center kata"> Tidak ada data. </td>
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

                                            <a href="<?=base_url()?>?page=keuangan/bkk&halaman= BUKTI KAS KELUAR" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>
               						 </div>

					 					</form>
								<div class="copy">

                                </div>
									</div>
                            	</div>
							</div>
						</div>
				</div>

				<div id="menuListBkk" <?=$class_pane_tab?>>
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-body">

									<form action="" method="post" >

			                         	<div class="col-xs-12 col-md-4" style="margin-bottom:3mm">
                                      		<div class="input-group">
	                                      		<span class="input-group-addon point">Kode</span>
				                             	<input type="text" autocomplete="off" class="form-control" name="kode_bkk" id="kode_bkk" placeholder="Kode bkk ..." value="<?php

													if(empty($_POST['kode_bkk'])){
														echo "";

													}else{
														echo $_POST['kode_bkk'];
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
	                                      		<span class="input-group-addon point">Supplier</span>
				                             	<select id="supplier" name="supplier" class="select2" style="width: 100%;">
                                                <option value="" selected>-- Pilih supplier --</option>
                                                <?php
                                                //CEK JIKA supplier ADA MAKA SELECTED
                                                (isset($_POST['supplier']) ? $supplier=$_POST['supplier'] : $supplier='');
                                                //UNTUK AMBIL coanya
                                                while($row_supplier = mysql_fetch_array($q_supplier_list)) { ;?>

                                                <option value="<?php echo $row_supplier['kode_supplier'];?>" <?php if($row_supplier['kode_supplier']==$supplier){echo 'selected';} ?>><?php echo $row_supplier['nama_supplier'];?> </option>
                                                <?php } ?>
                                                </select>
				                         	</div>
				                    	</div>

			                         	<div class="col-xs-12 col-md-6" style="margin-bottom:3mm">
	                                        <div class="input-group">
	                                            <span class="input-group-addon">Tanggal Awal</i></span>
	                                            <input type="text" name="tanggal_awal" id="tanggal_awal" class="form-control date-picker" autocomplete="off" value="<?=(isset($_REQUEST['tanggal_awal']) ? date("m/d/Y", strtotime($_REQUEST['tanggal_awal'])) : date("m/d/Y"))?>">
	                                            <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
	                                        </div>
	                                    </div>

	                                    <div class="col-xs-12 col-md-6" style="margin-bottom:3mm">
	                                        <div class="input-group">
	                                         	<span class="input-group-addon">Tanggal Akhir</span>
	                                         	<input type="text" name="tanggal_akhir" id="tanggal_akhir" class="form-control date-picker" autocomplete="off"value="<?=(isset($_REQUEST['tanggal_akhir']) ? date("m/d/Y", strtotime($_REQUEST['tanggal_akhir'])) : date("m/d/Y"))?>">
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
                                                <th>Kode</th>
												<th>Tanggal</th>
												<th>Ref</th>
												<th>Cabang</th>
												<th>Supplier</th>
                                                <th>Metode Rekening</th>
                                                <th>Keterangan</th>
                                                <th>Status</th>
											</tr>
										</thead>
										<tbody>

											<?php
												$n=1; if(mysql_num_rows($q_bkk) > 0) {
												while($data = mysql_fetch_array($q_bkk)) {

													if($data['status'] == '0'){
	        												$status = 'Lunas';
	        												$warna = 'style="background-color: #ffd10045"';
	        											}else{
	        												$status = 'Batal';
	        												$warna = 'style="background-color: #de4b4b63;"';
	        											}
											?>

											<tr <?= $warna?>>
												<td style="text-align: center"> <?php echo $n++ ?></td>
												<td><a href="<?=base_url()?>?page=keuangan/bkk_track&action=track&halaman= TRACK BUKTI KAS KELUAR&kode_bkk=<?=$data['kode_bkk']?>">
													<?php echo $data['kode_bkk'];?></a></td>
												<td> <?php echo date("d-m-Y",strtotime($data['tgl_buat']));?></td>
												<td> <?php echo $data['ref'];?></td>
												<td> <?php echo $data['nama_cabang'];?></td>
												<td> <?php echo $data['nama_supplier'];?></td>
												<td> <?php echo $data['rekening'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$data['nama_coa'];?></td>
                                                <td> <?php echo $data['keterangan_hdr'];?></td>
                                                <td style="text-align: center;"> <?php echo $status ?></td>
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

<div class="modal fade" id="edit_bkk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Update Buku Kas Keluar</h4>
            </div>
            <div class="modal-body" id="show-item-edit">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal modal-warning fade" id="modal-warning">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Rules Form BKM</h4>
            </div>
            <div class="modal-body">
                <p>........................................................................................</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php unset($_SESSION['load_bkk']); ?>
<script>
  var harga     = 0;
  var subtotal  = 0;
	var ppn       = 0;

  $(document).ready(function () {

      $("[name='saldo_transaksi']").number( true, 2 );
      $("[name='nominal_bayar']").number( true, 2 );
      $("[name='nominal_pelunasan']").number( true, 2 );
      $("[name='selisih']").number( true, 2 );
      $("[name='subtotal']").number( true, 2 );
  });

// SAVE FORM BKK
  $(document).ready(function (e) {
	  $("#saveForm").on('submit',(function(e) {
  		var grand_total = parseFloat(($("#subtotal").val() || 0).replace(/,/g, ''));
    		if(grand_total == "" || isNaN(grand_total)) {
    			grand_total = 0;
    		}

  		var kode_pembayaran = $("#kode_pembayaran").val();
          if(kode_pembayaran == "" ) {
              $("#kode_pembayaran").focus();
              notifError("<p>Rekening tidak boleh kosong!!!</p>");
              return false;
          }

  		e.preventDefault();
  	  	if(grand_total != 0 && grand_total > 0) {
    			$(".animated").show();
      			$.ajax({
      				url: "<?=base_url()?>ajax/j_bkk.php?func=save",
      				type: "POST",
      				data:  new FormData(this),
      				contentType: false,
      				cache: false,
      				processData:false,
      				success: function(html)
      				{
      					var msg = html.split("||");
      					if(msg[0] == "00") {
      						window.location = '<?=base_url()?>?page=keuangan/bkk&halaman= BUKTI KAS KELUAR&pesan='+msg[1];
      					}else{
      						notifError(msg[1]);
      					}
      					$(".animated").hide();
      				}
    		   });
  	  	}else{notifError("<p>Item  masih kosong.</p>");}
  	}));
  });

$('#kode_pembayaran').change(function(event){
  event.preventDefault();
  var nama = $("#kode_pembayaran").find(':selected').attr('data-nama');
  $('#nama_pembayaran').val(nama);
});

// TAMBAH MANUAL
$("#tambah_bkk").click(function(event) {
    event.preventDefault();
    document.getElementById('show_input_bkk').style.display = "table-row";

    $('#deskripsi').val('');
    $('#saldo_transaksi').val('0');
    $('#nominal_bayar').val('0');
    $('#nominal_pelunasan').val('0');
    $('#selisih').val('0');
    $('#kode_coa').val('').trigger('change');
    $('#keterangan_dtl').val('');
    $(".kata").hide();
});

// JIKA BATAL INPUT MANUAL
$("#batal_input").click(function(event) {
    event.preventDefault();
    document.getElementById('show_input_bkk').style.display = "none";
    $(".kata").show();
});

// INPUT MANUAL
$("#ok_input").click(function(event) {
    event.preventDefault();
    var id_form           = $("#id_form").val();
    var deskripsi         = $("#deskripsi").val();
    var saldo_transaksi   = $("#saldo_transaksi").val();
    var nominal_bayar     = $("#nominal_bayar").val();
    var nominal_pelunasan = $("#nominal_pelunasan").val();
    var selisih           = $("#selisih").val();
    var kode_coa          = $("#kode_coa").val();
    var keterangan_dtl    = $("#keterangan_dtl").val();

    if(deskripsi != '' && nominal_bayar != 0 && kode_coa != 0){
      $.ajax({
        type: "POST",
        url: "<?=base_url()?>ajax/j_bkk.php?func=add",
        data: "deskripsi="+deskripsi+"&saldo_transaksi="+saldo_transaksi+"&nominal_bayar="+nominal_bayar+"&nominal_pelunasan="+nominal_pelunasan+"&selisih="+selisih+"&kode_coa="+kode_coa+"&keterangan_dtl="+keterangan_dtl+"&id_form="+id_form,
        cache:false,
        success: function(data) {
          $('#detail_input_bkk').html(data);
          document.getElementById('show_input_bkk').style.display = "none";
          BindSelect2();
          number_format();
        }
      });

      function BindSelect2() {
          $("[data-id ='kode_coa']").select2({
                  width: '100%'
          });
      }

      function number_format(){
        $("[name='saldo_transaksi[]']").number( true, 2 );
        $("[name='nominal_bayar[]']").number( true, 2 );
        $("[name='nominal_pelunasan[]']").number( true, 2 );
        $("[name='selisih[]']").number( true, 2 );
        $("[name='subtotal']").number( true, 2 );
        
      }

    }else{
      alert("Harap isi Deskripsi, Nominal Bayar, dan Kode COA terlebih dahulu !");
    }
});

// LOAD DATA BERDASARKAN SUPPLIER
$("#kode_supplier, #kode_cabang").change(function(){
   	var id_form 		  = $("#id_form").val();
   	var kode_cabang 	= $("#kode_cabang").val();
   	var kode_supplier	= $("#kode_supplier").val();
   	$.ajax({
   		type: "POST",
   		url : '<?=base_url()?>ajax/j_bkk.php?func=loaditem',
   		data: "kode_supplier="+kode_supplier+"&kode_cabang="+kode_cabang+"&id_form="+id_form,
   		cache:false,
   		success: function(data){
   			$('#detail_input_bkk').html(data);
	   		BindSelect2_load();
        number_format();
	    }
	 });

  	function BindSelect2_load() {
  	     $("[name='kode_coa[]']").select2({
  	         width: '100%'
  	     });
         // $(".select2").select2();
  	}

    function number_format(){
        $("[name='saldo_transaksi[]']").number( true, 2 );
        $("[name='nominal_bayar[]']").number( true, 2 );
        $("[name='nominal_pelunasan[]']").number( true, 2 );
        $("[name='selisih[]']").number( true, 2 );
        $("[name='subtotal']").number( true, 2 );
        
    }

});

$(document).on('change paste keyup', 'input[name="cb[]"]', function(){
  selisih();
});

$(document).on("change paste keyup", "input[data-id='nominal_pelunasan']", function(){
  selisih();
});

$(document).on("change paste keyup", "input[data-id='nominal_bayar']", function(){
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
                var nominal_pelunasan  =  parseInt($tr.find('input[data-id="nominal_pelunasan"]').val()) || 0;
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
            // parseInt($tr.find('input[data-id="subtotal"]').val('0'));
 
        }
    });

    $('#subtotal').val(subtotalll);
    
    return ok;
}

$('#simpan').on('click', function($e) {
    $e.preventDefault();
    var
        $ok = selisih(),
        kode_coa = null,
        nominal_bayar  =  null,
        nominal_pelunasan  =  null,
        imanual  =  null,
        selisihx  =  0;
    //if (!$ok) {
        $('table tbody tr').each(function() {
            var $tr = $(this);

            if ($tr.find('input[data-id="cb"]').is(':checked')) {
                kode_coa = $tr.find('select[data-id="kode_coa"]').val();
                imanual            =  $tr.find('input[data-id="stat_manual"]').val();
                selisihx            =  parseInt($tr.find('input[data-id="selisih"]').val());
                nominal_bayar = parseInt($tr.find('input[data-id="nominal_bayar"]').val());
                nominal_pelunasan = parseInt($tr.find('input[data-id="nominal_pelunasan"]').val());
            }
        });
        if (nominal_pelunasan == 0 && imanual == 'n') {
            alert('Mohon isi nominal pelunasan');
            return false;
        }
        if (imanual == 'n' && selisihx > 0 && (kode_coa == '' || kode_coa == null || kode_coa == 'null')) {
            alert('Selisih ditemukan, mohon pilih coa');
            return false;
        }
        if (imanual == 'n' && nominal_pelunasan > nominal_bayar) {
            alert('Nominal pelunasan tidak boleh lebih dari nominal bayar');
            return false;
        }
    //}
    $('#saveForm').trigger('submit');
});

//SAAT MENGETIK NOMINAL BAYAR
$(document).on("change paste keyup", "input[name='nominal_bayar']", function(){
    var bayar  = $(this).val() || 0;
    $('[name="saldo_transaksi"]').val(bayar);
});

// function number_format() {
//   $("[data-id='nominal_bayar']").number( true, 2 );
//   $("[data-id='nominal_pelunasan']").number( true, 2 );
//   $("[data-id='selisih']").number( true, 2 );
//   $("[name='subtotal']").number( true, 2 );
// }

$('body').delegate(".hapus-bkk","click", function() {
    
    var id =  $(this).attr('data-id');
    var id_form = $('#id_form').val();
    
    $.ajax({
        type: 'POST',
        url: '<?=base_url()?>ajax/j_bkk.php?func=hapus-bkk',
        data: 'idhapus=' + id + '&id_form=' +id_form,
        cache: false,
        success:function(data){
            $('#detail_input_bkk').html(data).show();
            BindSelect2_load();
            number_format();
        }
    });  

    function BindSelect2_load() {
         $("[name='kode_coa[]']").select2({
             width: '100%'
         });
         // $(".select2").select2();
    }

    function number_format(){
        $("[name='saldo_transaksi[]']").number( true, 2 );
        $("[name='nominal_bayar[]']").number( true, 2 );
        $("[name='nominal_pelunasan[]']").number( true, 2 );
        $("[name='selisih[]']").number( true, 2 );
        $("[name='subtotal']").number( true, 2 );
        
    }

});

$('body').delegate(".edit_bkk","click", function() {
    var id =  $(this).attr('data-id');
    var id_form = $('#id_form').val();
    $.ajax({
      type: 'POST',
      url: '<?=base_url()?>ajax/j_bkk.php?func=edit-bkk',
      data: 'id=' +id + '&id_form=' +id_form,
      cache: false,
      success:function(data){
        $('#show-item-edit').html(data).show();
        BindSelect2();
        kode_coa();
      }
    });

    function BindSelect2() {
      $("[name='kode_coa_edit']").select2({
              width: '100%'
      });
    }

    function kode_coa() {
    	$('#kode_coa_edit').change(function(event){
			event.preventDefault();
			   var nama = $("#kode_coa_edit").find(':selected').attr('data-nama');
			   $('#nama_coa_edit').val(nama);
		});
	}

});

</script>

<!-- <script src="<?=base_url()?>assets/select2/select2.js"></script> -->
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
<script type="text/javascript">
	 $(".select2").select2({
        width: '100%'
   });
</script>

