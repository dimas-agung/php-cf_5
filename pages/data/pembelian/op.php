<?php
    include "pages/data/script/op.php";
	include "library/form_akses.php";
?>

<style>
  .pm-min, .pm-min-s{padding:3px 1px; }
  .animated{display:none;}

  table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
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
          <li><a href="#"><i class="fa fa-shopping-cart"></i> Pembelian</a></li>
          <li><a href="#">Form Order Pembelian</a></li>
        </ol>
</section>

<!-- /.row -->
<div class="box box-info">
<div class="box-body">

            <?php if (isset($_GET['pesan'])){ ?>
				<div class="form-group" id="form_report">
				  <div class="alert alert-success alert-dismissable">
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					  Kode OP :  <a href="<?=base_url()?>?page=pembelian/op_track&halaman= TRACK ORDER PEMBELIAN&action=track&kode_op=<?=$_GET['pesan']?>" target="_blank"><?=$_GET['pesan'] ?></a>  Berhasil Di posting
				  </div>
				</div>
			<?php } else if (isset($_GET['clsman'])){ ?>
				<div class="form-group" id="form_report">
                  <div class="alert alert-dismissable" style="background-color: #9c0303cc; color: #f9e6c3">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color: #f9e6c3">&times;</button>
                      Tutup Manual Kode OP :  <a style="color: white" href="<?=base_url()?>?page=pembelian/op_track&halaman= TRACK ORDER PEMBELIAN&action=track&kode_op=<?=$_GET['clsman']?>" target="_blank"><?=$_GET['clsman'] ?></a>  Berhasil Di tutup
                  </div>
                </div>
			<?php } else if (isset($_GET['pembatalan'])){ ?>
                <div class="form-group" id="form_report">
                  <div class="alert alert-dismissable" style="background-color: #9c0303cc; color: #f9e6c3">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color: #f9e6c3">&times;</button>
                      Pembatalan Kode OP :  <a style="color: white" href="<?=base_url()?>?page=pembelian/op_track&halaman= TRACK ORDER PEMBELIAN&action=track&kode_op=<?=$_GET['pembatalan']?>" target="_blank"><?=$_GET['pembatalan'] ?></a>  Berhasil Di batalkan
                  </div>
                </div>
            <?php } ?>

    <div class="tabbable">
		<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
			<li class="active">
		        <a data-toggle="tab" href="#menuFormOp">Form Order Pembelian</a>
			</li>
            <li>
				<a data-toggle="tab" href="#menuListOp">List Order Pembelian</a>
			</li>
        </ul>


	<div class="row">
		<div class="tab-content">

            <div id="menuFormOp" class="tab-pane fade in active">
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
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode OP</label>
                                             <div class="col-lg-4">
                                                 <input type="text" class="form-control" name="kode_op" id="kode_op" placeholder="Auto..." readonly value="">
                                             </div>

                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
                                             <div class="col-lg-4">
                                                <select id="kode_cabang" name="kode_cabang" class="select2">
                                                    <option value="0">-- Pilih Cabang --</option>
                                                        <?php
                                                        //CEK JIKA KODE CABANG ADA MAKA SELECTED
                                                        (isset($row['id_op']) ? $kode_cabang=$row['kode_cabang'] : $kode_cabang='');                                                    //UNTUK AMBIL CABANGNYA
                                                        while($rowcabang = mysql_fetch_array($q_cab_aktif)) { ;?>

                                                    <option value="<?php echo $rowcabang['kode_cabang'];?>"<?php if($rowcabang['kode_cabang']==$kode_cabang){echo 'selected';} ?>><p><?php echo $rowcabang['nama'];?> </p></option>
                                                        <?php } ?>
                                                </select>
                                             </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="ref" id="ref" placeholder="ref..." value="" autocomplete="off" />
                                        </div>

                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Supplier</label>
                                             <div class="col-lg-4">
                                                <select id="kode_supplier" name="kode_supplier" class="select2">
                                                    <option value="0">-- Pilih Supplier --</option>
                                                        <?php
                                                        //CEK JIKA KODE supplier ADA MAKA SELECTED
                                                        (isset($row['id_op']) ? $kode_supplier=$row['kode_supplier'] : $kode_supplier='');
                                                        //UNTUK AMBIL suppliernya
                                                        while($rowsupplier = mysql_fetch_array($q_sup_aktif)) { ;?>

                                                    <option
                                                        data-top="<?php echo $rowsupplier['top'];?>"
                                                        value="<?php echo $rowsupplier['kode_supplier'];?>"
                                                            <?php if($rowsupplier['kode_supplier']==$kode_supplier){echo 'selected';} ?>><?php echo $rowsupplier['kode_supplier'] . ' - ' . $rowsupplier['nama'];?>
                                                    </option>
                                                        <?php } ?>
                                                </select>
                                            </div>
                                    </div>

                                    <?php $tgl_hariini = date('m/d/Y'); ?>
                                    <div class="form-group">
                                        <label style="text-align:left" class="col-lg-2 col-sm-2 control-label">Tanggal PO</label>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                <input class="form-control date-picker-close" value="<?php echo $tgl_hariini; ?>" id="tanggal" name="tanggal" type="text" autocomplete="off" readonly/>
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar bigger-110"></i>
                                                </span>
                                                <input type="hidden" name="tgl_sekarang" id="tgl_sekarang" class="form-control" value="<?=$tgl_hariini?>"/>
                                            </div>
                                        </div>

                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">TOP</label>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                              <input type="text" autocomplete="off" class="form-control" name="top" id="top" placeholder="TOP..." value="" readonly />
                                              <span class="input-group-addon"><b>Hari</b></span>
                                            </div>
                                        </div>
                                      </div>

                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                                        <div class="col-lg-10">
                                            <textarea  class="form-control" rows="2" name="keterangan_hdr" id="keterangan_hdr" placeholder="Keterangan..."></textarea>
                                        <input type="hidden" name="id_um" id="id_um" value="1"/></div>
                                    </div>

                                    <!-- <div class="form-group">
                                        <label class="col-lg-2 control-label" style="text-align:left">Uang Muka (%)</label>

										<div class="row after-add-more">
											<div class="container">
												<div class="col-lg-3 col-md-3 col-xs-4">
													<input type="text" name="um" id="um" class="form-control" placeholder="Uang Muka %">
												</div>

												<div class="col-lg-3 col-md-3 col-xs-4">
													<input type="text" value="0" readonly name="nominal" id="nominal" class="form-control" placeholder="0">
												</div>

												<button class="btn btn-success add-more col-lg-2 col-md-2 col-xs-3" type="button"><i class="glyphicon glyphicon-plus"></i> Tambah</button>
											</div>
										</div>

                                    </div> -->

                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <div class="pull-left">
                                                <a class="btn btn-success" id="tambah_op"><i class="fa fa-plus"></i> Add</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                     	                <div style="overflow-x:auto;">
                                            <table id="" class="" rules="all">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10px">No</th>
                                                        <th style="width: 100px">Gudang</th>
                                                        <th style="width: 300px" colspan="2">Barang</th>
                                                        <th style="width: 100px">Tgl Kirim</th>
														<th style="width: 100px">QTY</th>
                                                        <th style="width: 100px">Konversi</th>
                                                        <th style="width: 100px">Stok</th>
                                                        <th style="width: 100px">Harga Beli</th>
                                                        <th style="width: 100px">Disc 1(%)</th>
                                                        <th style="width: 100px">Disc 2(%)</th>
                                                        <th style="width: 100px">Disc 3(%)</th>
                                                        <th style="width: 100px">PPn</th>
                                                        <th style="width: 100px">Subtotal</th>
                                                        <th style="width: 100px">Divisi</th>
                                                        <th style="width: 150px">Ket</th>
                                                        <th></th>
                                                    </tr>

                                                    <tr id="show_input_op" style="display:none">
                                                            <td style="text-align: center ; width: 10px">
																<h5><b>#</b></h5>
															</td>
															<td style="width: 50px">
                                                                <select id="kode_gudang" name="kode_gudang" class="select2" style="width: 50px">
                                                                    <option value="0">-- Pilih Gudang --</option>
                                                                        <?php

                                                                        while($rowgudang = mysql_fetch_array($q_gud_aktif)) { ;?>

                                                                    <option value="<?php echo $rowgudang['kode_gudang'].':'.$rowgudang['nama'];?>" ><?php echo $rowgudang['nama'];?> </option>
                                                                        <?php } ?>
                                                                </select>
                                                            </td>
                                                            <td style="width: 200px">
                                                                <select id="kode_barang" name="kode_barang" class="select2" style="width: 200px">
                                                                    <option value="0">-- Pilih Barang --</option>
                                                                    <?php
                                                                        while($rowinv = mysql_fetch_array($q_inv_aktif)) { ;?>
                                                                            <option value="<?php echo $rowinv['kode_inventori'].':'.$rowinv['nama'];?>" ><?php echo $rowinv['kode_inventori'].' - '.$rowinv['nama'];?> </option>
                                                                    <?php } ?>
                                                                 </select>
                                                            </td>
                                                            <td style="width: 20px">
                                                                <a id="btn_his" class="btn btn-xs btn-warning" onclick="openNav()"><i class="fa fa-cubes" title="history"></i></a>
                                                            </td>
                                                            <td style="width: 100px">
																<div class="input-group">
																	<input class="form-control date-picker" value="<?php echo $tgl_hariini; ?>" id="tanggal1" name="tanggal1" type="text" autocomplete="off" style="width:100px;" readonly/>
																	<span class="input-group-addon">
																		<i class="fa fa-calendar bigger-110"></i>
																	</span>
																</div>
                                                            </td>
                                                            <td style="width: 80px">
																<div class="input-group">
																	<input class="form-control" type="text" name="qty_i" id="qty_i"  autocomplete="off" value="0" style="width:80px;text-align:right" />
																	<span class="input-group-addon" id="text-satuan2"></span>
																	<input type="hidden" name="satuan2" id="satuan2" />
																</div>
                                                            </td>
															<td style="width: 80px">
																<div class="input-group">
																	<input class="form-control" type="text" name="qty" id="qty"  autocomplete="off" value="0" style="width:80px;text-align:right" readonly />
																	<span class="input-group-addon" id="text-satuan"></span>
																	<input type="hidden" name="satuan" id="satuan" />
																	<input type="hidden" name="konversi" id="konversi" value="0" />
																</div>
                                                            </td>                                                            
                                                            <td style="width: 60px">
                                                                <div class="input-group">
																	<input class="form-control" type="text" name="stok" id="stok"  autocomplete="off" value="0" style="width:60px;text-align:right" readonly />
																	<span class="input-group-addon" id="text-satuanstok"></span>
																</div>
                                                            </td>
                                                            <td style="width: 80px">
                                                                <input class="form-control" type="text" name="harga" id="harga"  autocomplete="off" style="width: 80px; text-align: right;" value=""/>
                                                            </td>
                                                            <td style="width: 60px">
																<div class="input-group">
																	<input class="form-control" type="text" name="diskon" id="diskon"  autocomplete="off" style="width: 60px; text-align: right;" value=""/>
																	<span class="input-group-addon">%</span>
																</div>
                                                            </td>
															<td style="width: 60px">
																<div class="input-group">
																	<input class="form-control" type="text" name="diskon2" id="diskon2"  autocomplete="off" style="width: 60px; text-align: right;" value=""/>
																	<span class="input-group-addon">%</span>
																</div>
                                                            </td>
															<td style="width: 60px">
																<div class="input-group">
																	<input class="form-control" type="text" name="diskon3" id="diskon3"  autocomplete="off" style="width: 60px; text-align: right;" value=""/>
																	<span class="input-group-addon">%</span>
																</div>
                                                            </td>
                                                            <td id="load_ppn">
																<input class="form-control" type="checkbox" name="ppn" id="ppn" />
                                                                <input class="form-control" type="hidden" name="stat_ppn" id="stat_ppn" value="0">
															</td>
                                                            <td style="width: 100px">
                                                                <input class="form-control" type="text" name="subtot" id="subtot"  autocomplete="off" style="width: 100px; text-align: right;" value="" readonly/>
																<input type="hidden" name="ppn_n" id="ppn_n" value="0" />
															</td>
                                                            <td style="width: 100px">
                                                            	<select id="divisi" name="divisi" class="select2">
                                                                    <option value="0">-- Pilih Divisi --</option>
                                                                    <?php
                                                                        while($rowdivisi = mysql_fetch_array($q_ddl_divisi)) { ;?>
                                                                            <option value="<?php echo $rowdivisi['kode_cc'].':'.$rowdivisi['nama'];?>" >
                                                                                <?php echo $rowdivisi['nama'];?>
                                                                            </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </td>
                                                            <td style="width: 150px">
                                                                <input class="form-control" type="text" name="ket_dtl" id="ket_dtl"  autocomplete="off" style="width: 150px" value=""/>
                                                            </td>
                                                            <td style="text-align: center">
                                                                <button id="ok_input" class="btn btn-xs btn-info ace-icon fa fa-check" title="ok"></button>
                                                                <a href="" id="batal_input" class="btn btn-xs btn-danger ace-icon fa fa-remove" title="batal" ></a>
                                                            </td>
                                                    </tr>

                                                </thead>
                                                <tbody id="detail_input_op">
                                                    <tr>
                                                         <td colspan="17" class="text-center"> Tidak ada item barang. </td>
                                                    </tr>
                                                    <tr id="total2">
                                                        <td style="text-align:right" colspan="13" ><b>DPP :</b></td>
                                                        <td style="text-align:right"><b>0</b> <input type="hidden" name="total_harga" id="total_harga" autocomplete="off" value="0" /></td>
                                                        <td colspan="3"></td>
                                                    </tr>
                                                    <tr id="ppn">
                                                        <td style="text-align:right" colspan="13"><b>PPN :</b></td>
                                                        <td style="text-align:right"><b>0</b> <input type="hidden" name="total_ppn" id="total_ppn" autocomplete="off" value="0" /></td>
                                                        <td style="text-align:right" colspan="3"></td>
                                                    </tr>
                                                    <tr id="grand_total">
                                                        <td style="text-align:right" colspan="13"><b>Grand Total :</b></td>
                                                        <td style="text-align:right"><b>0</b> <input type="hidden" name="grandtotal" id="grandtotal" autocomplete="off" value="0" /></td>
                                                        <td style="text-align:right" colspan="3"></td>
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
                                             	<?php } } ?>
                     					<?php } ?>
											<button type="submit" name="simpan" id="simpan" class="btn btn-primary" tabindex="10"><i class="fa fa-check-square-o"></i> Simpan</button>

                                             <a href="<?=base_url()?>?page=pembelian/op&halaman= ORDER PEMBELIAN" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>&nbsp; <img src="<?=base_url()?>assets/images/loading.gif" class="animated"/>

									</div>


            					</form>

                                <!-- Copy Fields -->
                                <div class="copy">

                                </div>

    					    </div>
	                    </div>
                    <!-- /.panel-body -->
                    </div>
                <!-- /.panel-default -->
                </div>
			</div>

			<div id="menuListOp" class="tab-pane fade">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<table id="example1" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
                                        <th>No</th>
										<th>Kode OP</th>
										<th>Supplier</th>
                                        <th>Ref</th>
                                        <th>Keterangan</th>
										<th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									    $n=1;
                                        $status='';
                                        $warna = '';

                                        if(mysql_num_rows($q_op) > 0) {
										while($data = mysql_fetch_array($q_op)) {

                                        if ($data['status']=='0'){
                                            $status =  'Menunggu Approval';
                                            $warna = 'style="background-color: #7eb2ccba"';
                                            $print = 'hidden';
                                        }elseif ($data['status']=='1'){
                                            $status =  'Open';
                                            $warna = 'style="background-color: #39b13940"';
                                            $print = '';
                                        }elseif ($data['status']=='2'){
                                            $status =  'Reject';
                                            $warna = 'style="background-color: #de4b4b63;"';
                                            $print = 'hidden';
                                        }else{
                                            $status =  'Close';
                                            $warna = 'style="background-color: #ffd10045;"';
                                            $print = 'hidden';
                                        }

									?>

									<tr <?= $warna?>>
                                        <td style="text-align: center"> <?php echo $n++ ?></td>
										<td>
                                            <a href="<?=base_url()?>?page=pembelian/op_track&halaman= TRACK ORDER PEMBELIAN&action=track&kode_op=<?=$data['kode_op']?>"> <?php echo $data['kode_op'];?>
                                            </a>
                                        </td>
										<td> <?php echo $data['kode_supplier'] . ' - ' . $data['nama'];?></td>
										<td> <?php echo $data['ref'];?></td>
                                        <td> <?php echo $data['keterangan_hdr'];?></td>
                                        <td> <?php echo date("d-m-Y",strtotime($data['tgl_buat']));?></td>
										<td style="text-align:center"><?php echo $status ?></td>
                                        <td style="text-align: center">
                                            <a href="<?=base_url()?>r_cetak_op.php?kode_op=<?=$data['kode_op']?>" title="cetak" target="_blank"><button type="button" class="btn btn-success btn-sm <?= $print?>"><span class="glyphicon glyphicon-print"></span></button>
                                            </a>
                                        </td>
                                    </tr>

									<?php }

                                    }
									?>

								</tbody>
							</table>
					    </div>
						<!-- /.panel-body -->
					</div>
					<!-- /.panel-default -->
				</div>
				<!-- /.col-lg-12 -->
			</div>

		</div>
	</div>

	<!-- /.row -->

    <!-- DAFTAR BARANG --->
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a><center><b>DAFTAR OP BERDASARKAN KODE BARANG</b></center></a>
        <a id="list_his_harga"></a>
    </div>
    <!-- /.DAFTAR BARANG --->


<?php unset($_SESSION['data_um']); ?>
<?php unset($_SESSION['data_op']); ?>

<script>
$(document).ready(function () {
      $("[name='um']").number( true, 2 );
      $("[name='um1']").number( true, 2 );
      $("[name='nominal']").number( true, 2 );
      $("[name='nominal[]']").number( true, 2 );
      $("[name='qty_i']").number( true, 2 );
      $("[name='qty']").number( true, 2 );
      $("[name='stok']").number( true, 2 );
      $("[name='harga']").number( true, 2 );
      $("[name='diskon']").number( true, 2 );
      $("[name='diskon2']").number( true, 2 );
      $("[name='diskon3']").number( true, 2 );
      $("[name='subtot']").number( true, 2 );
  });
</script>

<script>
    function openNav() {
      document.getElementById("mySidenav").style.width = "350px";
      document.getElementById("main").style.width = "100%";
      document.getElementById("main").style.marginLeft = "350px";
      document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
    }

    function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
      document.getElementById("main").style.marginLeft= "0";
      document.body.style.backgroundColor = "white";
    }
</script>

<script>
   $("#btn_his").click(function(event) {
        var kode_inventori = $("#kode_barang").val();		
		$.ajax({
			type: "POST",
			url: "<?=base_url()?>ajax/j_op.php?func=loadhistory",
			data: "kode_inventori="+kode_inventori,
			cache:false,
			success: function(data) {
				$('#list_his_harga').html(data);
			}
		});
    });
</script>

<script>
      $(document).ready(function (e) {
    	 $("#saveForm").on('submit',(function(e) {
    		var grand_total = parseFloat($("#grandtotal").val());
    		if(grand_total == "" || isNaN(grand_total)) {grand_total = 0;}

            var kode_cabang = $("#kode_cabang").val();
            if(kode_cabang == 0 ) {
                $("#kode_cabang").focus();
                notifError("<p>Cabang tidak boleh kosong!!!</p>");
                return false;
            }

    		e.preventDefault();
    	  	if(grand_total != 0) {
    			$(".animated").show();
    			$.ajax({

    				url: "<?=base_url()?>ajax/j_op.php?func=save",
    				type: "POST",
    				data:  new FormData(this),
    				contentType: false,
    				cache: false,
    				processData:false,
    				success: function(html)
    				{
    					var msg = html.split("||");
    					if(msg[0] == "00") {
    						window.location = '<?=base_url()?>?page=pembelian/op&halaman= ORDER PEMBELIAN&pesan='+msg[1];
    					} else {
    						notifError(msg[1]);
    					}
    					$(".animated").hide();
    				}

    		   });
    	  	} else {notifError("<p>Item  masih kosong</p>");}
    	 }));
      });

	$('#kode_supplier').change(function(){
        var kode_supplier = $("#kode_supplier").val();
        var top  = $("#kode_supplier").find(':selected').attr('data-top');		
		$.ajax({
			type: "POST",
			url: "<?=base_url()?>ajax/j_op.php?func=loadppn",
			data: "kode_supplier="+kode_supplier,
			cache:false,
			success: function(data) {
				$('#load_ppn').html(data);
				$('#top').val(top);
			}
		});
	});

	$('#kode_barang').change(function(){
        var kode_barang = $("#kode_barang").val();
		$.ajax({
			type: "POST",
			dataType: "JSON",
			url: "<?=base_url()?>ajax/j_op.php?func=loadsatuan",
			data: "kode_barang="+kode_barang,
			cache:false,
			success: function(response) {
				var
					sat_beli = response.sat_beli,
					sat_jual = response.sat_jual,
					konversi = response.konversi;
				
				sat_beli = sat_beli !== '' && sat_beli.indexOf(':') ? sat_beli.split(':') : '';
				sat_jual = sat_jual !== '' && sat_jual.indexOf(':') ? sat_jual.split(':') : '';
				
				if (sat_beli !== '') {
					$('#satuan').val(response.sat_beli); // satuan
					$('#text-satuan').html(sat_beli[1].replace(/\s+/g, ''));
					$('#text-satuanstok').html(sat_beli[1].replace(/\s+/g, ''));
				}
				
				if (sat_jual !== '') {
					$('#satuan2').val(response.sat_jual); // satuan2
					$('#text-satuan2').html(sat_jual[1].replace(/\s+/g, ''));
				}
				
				$('#konversi').val(konversi);
			}
		});
	});

    $('body').delegate("#kode_gudang, #kode_barang, #kode_cabang", "change", function() {
        var kode_cabang     = $("#kode_cabang").val();
        var kode_barang     = $("#kode_barang").val();
        var kode_gudang     = $("#kode_gudang").val();
		$.ajax({
			type: "POST",
			url: "<?=base_url()?>ajax/j_op.php?func=loadstok",
			data: "kode_cabang="+kode_cabang+"&kode_barang="+kode_barang+"&kode_gudang="+kode_gudang,
			cache:false,
			success: function(data) {
				$('#stok').val(data);
			}
		});
    });

	$("#tambah_op").click(function(event) {
		event.preventDefault();
    	var 
			tgl_sekarang = $("#tgl_sekarang").val();
		$('#kode_supplier').trigger('change');
		$('#kode_gudang').val('0').trigger('change');
		$('#kode_barang').val('0').trigger('change');
		$('#divisi').val('0').trigger('change');
		$('#tanggal1').val(tgl_sekarang);
		$('#qty, #qty_i').val('0');
		$('#harga').val('0');
		$('#diskon').val('0');
		$('#diskon2').val('0');
		$('#diskon3').val('0');
		$('#subtot').val('0');
		$('#stok').val('0');
		$('#ppn').prop('checked', false);
		$('#stat_ppn').val('0');
		$('#ppn_n').val('0');
		$('#satuan, #nama_satuan').val('');
		$('#ket_dtl').val('');
		$('#text-satuan, #text-satuanstok, #text-satuan2').html('');
        var kode_supplier = $("#kode_supplier").val();
        var kode_cabang = $("#kode_cabang").val();
        if (kode_supplier !== '0' && kode_cabang !== '0') {
    		document.getElementById('show_input_op').style.display = "table-row";
        } else {
			if (kode_cabang === '0') {
				alert("Pilih Cabang terlebih dahulu !!");
			} else if (kode_supplier === '0') {
				alert("Pilih Supplier terlebih dahulu !!");
			}
        }
	});


	$("#batal_input").click(function(event) {
		event.preventDefault();
		document.getElementById('show_input_op').style.display = "none";
	});

	$(document).on("change paste keyup", "input[name='qty_i'], input[name='harga'], input[name='diskon'], input[name='diskon2'], input[name='diskon3'], input[name='ppn']", function(){
		hitungtable();
	});
  
	function hitungtable () {
		var
			ppn = $('#ppn'),
			ppn_vn = $('#ppn_n'),
			stat_ppn = $('#stat_ppn').val() || 0,
			qty_i = $('#qty_i').val() || 0,
			konversi = $('#konversi').val() || 0,
			harga = $('#harga').val() || 0,
			diskon1 = $('#diskon').val() || 0,
			diskon2 = $('#diskon2').val() || 0,
			diskon3 = $('#diskon3').val() || 0,
			subtot = $('#subtot'),
			ppn_n = 0,
			qtytot = 0,
			subtotal = 0,
			diskon1x = 0,
			diskon2x = 0,
			diskon3x = 0;
			
			diskon1x = (harga - (harga * (diskon1 / 100)));
			diskon2x = (diskon1x - (diskon1x * (diskon2 / 100)));
			diskon3x = (diskon2x - (diskon2x * (diskon3 / 100)));
			
			qtytot = (qty_i * konversi);
			subtotal = (diskon3x * qtytot);
			
			if (ppn.is(':checked')) {
				stat_ppn = 1;
				ppn_n = subtotal - (subtotal / 1.1);
			} else {
				stat_ppn = 0;
				ppn_n = 0;
			}
			$('#ppn_n').val(Math.ceil(ppn_n));
			$('#stat_ppn').val(stat_ppn);			
			$('#qty').val(qtytot);
			subtot.val(subtotal);
			
	}

	$("#ok_input").click(function(event) {
		event.preventDefault();
		var id_form			= $("#id_form").val();
		var kode_barang		= $("#kode_barang").val();
		var tgl_kirim		= $("#tanggal1").val();
		var satuan			= $("#satuan").val();
		var nama_satuan		= $("#nama_satuan").val();
		var satuan2			= $("#satuan2").val();
		var nama_satuan2	= $("#nama_satuan2").val();
		var qty_i			= $("#qty_i").val();
		var qty				= $("#qty").val();
		var kode_gudang		= $("#kode_gudang").val();
		var stok			= $("#stok").val();
		var harga			= $("#harga").val();
		var diskon			= $("#diskon").val();
		var diskon2			= $("#diskon2").val();
		var diskon3			= $("#diskon3").val();
		var ppn				= $("#stat_ppn").val();
		var ppn_n			= $("#ppn_n").val();
		var subtot			= $("#subtot").val();
		var divisi			= $("#divisi").val();
		var keterangan_dtl  = $("#ket_dtl").val();

        if(kode_barang != 0 && qty != 0 && kode_gudang != 0) {
          var status = 'true';
        }else{
          var status = 'false';
        }

        if(status == 'true') {
    		$.ajax({
    			type: "POST",
    			url: "<?=base_url()?>ajax/j_op.php?func=add",
    			data: "kode_barang="+kode_barang+"&tgl_kirim="+tgl_kirim+"&satuan="+satuan+"&satuan2="+satuan2+"&qty_i="+qty_i+"&qty="+qty+"&kode_gudang="+kode_gudang+"&stok="+stok+"&harga="+harga+"&diskon="+diskon+"&diskon2="+diskon2+"&diskon3="+diskon3+"&ppn="+ppn+"&ppn_n="+ppn_n+"&subtot="+subtot+"&divisi="+divisi+"&keterangan_dtl="+keterangan_dtl+"&id_form="+id_form,
                cache:false,
    			success: function(data) {
    				$('#detail_input_op').html(data);
    				document.getElementById('show_input_op').style.display = "none";
    			}
    		});
        }else{
            alert("Peringatan : Harap Isi Barang, QTY, dan Gudang Terlebih Dahulu !!");
        }
	  return false;
	});

	$(document).ready(function() {
      $(".add-more").click(function(){
	  	  var id_um     = $("#id_um").val();
		  var id_um_new = parseInt(id_um)+1;

		  var um         = $("#um").val();
		  var nominal    = $("#nominal").val();
			$.ajax({
				type: "POST",
				url: "<?=base_url()?>ajax/j_op.php?func=addum",
				data: "id_um="+id_um+"&um="+um+"&nominal="+nominal,
				cache:false,
				success: function(data) {
					//console.log(data);
					var html = $(".copy").html(data);
          			$(".after-add-more").after(html);

					$("body").on("click",".remove",function(){
					  $(this).parents(".control-group").remove();
				  	});
				}
			});

		  $('#um').val('');
		  $('#nominal').val('0');
		  $('#id_um').val(id_um_new);
		  $('#um').focus();
      });
  });


  //SAAT KLIK UM
  $(document).on("change paste keyup", "input[name='um']", function(){
	var um = ($(this).val() || 0).replace(/,/g, '');
	var g_total = ($("#grandtotal").val() || 0).replace(/,/g, '');
	var nominal = parseFloat(g_total * (um / 100));

	$('[name="nominal"]').val(nominal);
  });

</script>

<!-- ============ PRINT KE CSV =============== -->
<script>


   $(document).ready(function () {
   function exportTableToCSV($table, filename) {

      var $rows = $table.find('tr:has(td),tr:has(th)'),

         // Temporary delimiter characters unlikely to be typed by keyboard
         // This is to avoid accidentally splitting the actual contents
         tmpColDelim = String.fromCharCode(11), // vertical tab character
         tmpRowDelim = String.fromCharCode(0), // null character

         // actual delimiter characters for CSV format
         colDelim = '","',
         rowDelim = '"\r\n"',

         // Grab text from table into CSV formatted string
         csv = '"' + $rows.map(function (i, row) {
            var $row = $(row), $cols = $row.find('td,th');

            return $cols.map(function (j, col) {
               var $col = $(col), text = $col.text();

               return text.replace(/"/g, '""'); // escape double quotes

            }).get().join(tmpColDelim);

         }).get().join(tmpRowDelim)
            .split(tmpRowDelim).join(rowDelim)
            .split(tmpColDelim).join(colDelim) + '"',



         // Data URI
         csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

         console.log(csv);

         if (window.navigator.msSaveBlob) { // IE 10+
            //alert('IE' + csv);
            window.navigator.msSaveOrOpenBlob(new Blob([csv], {type: "text/plain;charset=utf-8;"}), "csvname.csv")
         }
         else {
            $(this).attr({ 'download': filename, 'href': csvData, 'target': '_blank' });
         }
   }

	$(document).on('click', 'a[class~="btn-export-csv"]', function(){
		var
			$this = $(this),
			$nextTable = $this.parent().siblings('table');
		if ($nextTable.length) {
			if ($nextTable.hasClass('table-export-csv')) {
				exportTableToCSV.apply(this, [
					$($nextTable),
					($nextTable.attr('data-csv-name') || 'generated_' + new Date().toLocaleDateString()) + '.csv'
				]);
			}
		}
	});

   });

</script>

<!-- <script src="<?=base_url()?>assets/select2/select2.js"></script> -->
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
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
        width: 'resolve'
    });
</script>
