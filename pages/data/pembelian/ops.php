<?php
    include "pages/data/script/ops.php";
	include "library/form_akses.php";
?>

<section class="content-header">
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-shopping-cart"></i> Pembelian</a></li>
          <li><a href="#">Form Order Pembelian Aset</a></li>
        </ol>
</section>

<!-- /.row -->
<div class="box box-info">
<div class="box-body">

            <?php if (isset($_GET['pesan'])){ ?>
				<div class="form-group" id="form_report">
				  <div class="alert alert-success alert-dismissable">
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					  Kode OPS :  <a href="<?=base_url()?>?page=pembelian/ops_track&action=track&kode_ops=<?=$_GET['pesan']?>&halaman=ORDER PEMBELIAN ASET" target="_blank"><?=$_GET['pesan'] ?></a>  Berhasil Di posting
				  </div>
				</div>
			<?php  }  ?>

    <div class="tabbable">
		<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
			<li class="active">
		        <a data-toggle="tab" href="#menuFormOps">Form Order Pembelian Aset</a>
			</li>
            <li>
				<a data-toggle="tab" href="#menuListOps">List Order Pembelian Aset</a>
			</li>
        </ul>


	<div class="row">
		<div class="tab-content">

            <div id="menuFormOps" class="tab-pane fade in active">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-horizontal">
                                 <?php $id_form = buatkodeform("kode_form"); ?>

								<form role="form" method="post" action="" id="saveForm">

                                    <?php   $idtem = "INSERT INTO form_id SET kode_form ='".$id_form."' ";
									mysql_query($idtem); ?>
									<input type="hidden" name="id_form" id="id_form" value="<?php echo $id_form; ?>"/>


                                    <div class="form-group">
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode OPS</label>
                                             <div class="col-lg-4">
                                                 <input type="text" class="form-control" name="kode_ops" id="kode_ops" placeholder="Auto..." readonly value="">
                                             </div>

                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
                                             <div class="col-lg-4">
                                                <select id="kode_cabang" name="kode_cabang" class="select2">
                                                    <option value="0">-- Pilih Cabang --</option>
                                                        <?php
                                                        while($rowcabang = mysql_fetch_array($q_cab_aktif)) { ;?>

                                                    <option value="<?php echo $rowcabang['kode_cabang'];?>">
                                                        <p><?php echo $rowcabang['kode_cabang'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowcabang['nama'];?> </p>
                                                    </option>
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
                                                        value="<?php echo $rowsupplier['kode_supplier'];?>" <?php if($rowsupplier['kode_supplier']==$kode_supplier){echo 'selected';} ?>><?php echo $rowsupplier['kode_supplier'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowsupplier['nama'];?> </option>
                                                        <?php } ?>
                                                </select>
                                            </div>
                                    </div>

                                    <?php $tgl_hariini = date('m/d/Y'); ?>
                                    <div class="form-group">
                                        <label style="text-align:left" class="col-lg-2 col-sm-2 control-label">Tanggal OPS</label>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                <input class="form-control date-picker-close" value="<?php echo $tgl_hariini; ?>" id="tanggal" name="tanggal" type="text" autocomplete="off"/>
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
                                                <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                                        <div class="col-lg-10">
                                            <textarea  class="form-control" rows="2" name="keterangan_hdr" id="keterangan_hdr" placeholder="Keterangan..."></textarea>
                                        <input type="hidden" name="id_um" id="id_um" value="1"/></div>
                                    </div>

                                    <div class="form-group">
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
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <div class="pull-left">
                                                <a class="btn btn-success" id="tambah_ops"><i class="fa fa-plus"></i> Add</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                     	                <div style="overflow-x:auto;">
                                            <table id="" class="" rules="all">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th colspan="2">Kategori Asset</th>
                                                        <th>Tgl kirim</th>
                                                        <th>Q</th>
                                                        <th>Harga</th>
                                                        <th>Diskon(%)</th>
                                                        <th>Ppn</th>
                                                        <th>Subtotal</th>
                                                        <th>Divisi</th>
                                                        <th>Keterangan</th>
                                                        <th></th>
                                                    </tr>

                                                    <tr id="show_input_ops" style="display:none">
                                                            <td style="text-align: center;"><h5><b>#</b></h5></td>
                                                            <td style="width: 250px">
                                                                <select id="kode_kat_aset" name="kode_kat_aset" class="select2">
                                                                    <option value="0">-- Pilih Aset --</option>
                                                                    <?php
                                                                        while($rowaset = mysql_fetch_array($q_aset)) { ;?>
                                                                            <option value="<?php echo $rowaset['kode_kat_aset'].':'.$rowaset['nama'];?>" ><?php echo $rowaset['kode_kat_aset'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowaset['nama'];?> </option>
                                                                    <?php } ?>
                                                                 </select>
                                                            </td>
															<td style="width: 20px">
                                                                <a id="btn_his" class="btn btn-xs btn-warning" onclick="openNav()"><i class="fa fa-cubes" title="history"></i></a>
                                                            </td>
                                                            <td>
                                                                <input class="form-control date-picker" value="<?php echo $tgl_hariini; ?>" id="tanggal1" name="tanggal1" type="text" autocomplete="off"/>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" name="qty" id="qty"  autocomplete="off" value=""/>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" name="harga" id="harga"  autocomplete="off" value=""/>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="number" name="diskon" id="diskon"  autocomplete="off" value=""/>
                                                            </td>
                                                            <td id="load_ppn"></td>
                                                            <td>
                                                                <input class="form-control" type="text" name="subtot" id="subtot"  autocomplete="off" text-align: right;" value="" readonly/></td>
                                                            <td style="width: 150px">
                                                            	<select id="divisi" name="divisi" class="select2"; font-size:14px">
                                                                    <option value="0">-- Pilih Divisi --</option>
                                                                        <?php

                                                                        while($rowdivisi = mysql_fetch_array($q_ddl_divisi)) { ;?>

                                                                    <option value="<?php echo $rowdivisi['kode_cc'].':'.$rowdivisi['nama'];?>" ><?php echo $rowdivisi['kode_cc'].'&nbsp;&nbsp; || &nbsp;&nbsp;'.$rowdivisi['nama'];?> </option>
                                                                        <?php } ?>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="text" name="ket_dtl" id="ket_dtl"  autocomplete="off" value=""/>
                                                            </td>
                                                            <td styla="text-align: center;">
                                                                <button id="ok_input" class="btn btn-sm btn-info ace-icon fa fa-check" title="ok"></button>
                                                                <a href="" id="batal_input" class="btn btn-sm btn-danger ace-icon fa fa-remove" title="batal"></a>
                                                            </td>
                                                        </tr>

                                                </thead>
                                                <tbody id="detail_input_ops">
                                                    <tr>
                                                         <td colspan="11" class="text-center"> Tidak ada data. </td>
                                                    </tr>
                                                    <tr id="total2" >
                                                        <td style="text-align:right" colspan="7" ><b>Total :</b></td>
                                                        <td style="text-align:right"><b></b></td>
                                                        <td colspan="3"></td>
                                                    </tr>
                                                    <tr id="ppn">
                                                        <td style="text-align:right" colspan="7"><b>PPn :</b></td>
                                                        <td style="text-align:right"><b></b></td>
                                                        <td style="text-align:right" colspan="3"></td>
                                                    </tr>
                                                    <tr id="grand_total">
                                                        <td style="text-align:right" colspan="7"><b>Grand Total :</b></td>
                                                        <td style="text-align:right"><b></b></td>
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
											<button type="submit" name="simpan" id="simpan" class="btn btn-primary" tabindex="10"><i class="fa fa-check-square-o"></i> Simpan</button>
                                             	<?php } } ?>
                     					<?php } ?>

                                             <a href="<?=base_url()?>?page=pembelian/ops&halaman= ORDER PEMBELIAN ASET" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>&nbsp; <img src="<?=base_url()?>assets/images/loading.gif" class="animated"/>

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

			<div id="menuListOps" class="tab-pane fade">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<table id="example1" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
                                        <th>No</th>
										<th>Kode OPS</th>
                                        <th>Ref</th>
                                        <th>Keterangan</th>
										<th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									    $n=1; if(mysql_num_rows($q_ops) > 0) {
										while($data = mysql_fetch_array($q_ops)) {
									?>

									<tr>
                                        <td style="text-align: center"> <?php echo $n++ ?></td>
										<td>
                                            <a href="<?=base_url()?>?page=pembelian/ops_track&action=track&kode_ops=<?=$data['kode_ops']?>&halaman=ORDER PEMBELIAN ASET"> <?php echo $data['kode_ops'];?>
                                            </a>
                                        </td>
										<td> <?php echo $data['ref'];?></td>
                                        <td> <?php echo $data['keterangan_hdr'];?></td>
                                        <td> <?php echo date("d-m-Y",strtotime($data['tgl_buat']));?></td>
										<td style="text-align:center">
                                            <?php
                                            if ($data['status']=='3'){echo '<span class="badge badge-danger glyphicon glyphicon-remove"> </span> Stop ';
                                            }else{echo '<span class="badge badge-info glyphicon glyphicon-ok"> </span> Ready ';}
                                            ?>
                                        </td>
                                        <td style="text-align: center">
                                            <a href="<?=base_url()?>r_cetak_ops.php?kode_ops=<?=$data['kode_ops']?>&halaman=ORDER PEMBELIAN ASET" title="cetak" target="_blank">
                                                <button type="button" class="btn btn-success btn-sm">
                                                    <span class="glyphicon glyphicon-print"></span>
                                                </button>
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
    <!-- Tambah Item Infrastructure       --->

	 <!-- DAFTAR KATEGORI --->
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a><center><b>DAFTAR OPS BERDASARKAN KODE KATEGORI ASSET</b></center></a>
        <a id="list_his_harga"></a>
    </div>
    <!-- /.DAFTAR BARANG --->

<?php unset($_SESSION['data_um']); ?>
<?php unset($_SESSION['data_ops']); ?>

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

    				url: "<?=base_url()?>ajax/j_ops.php?func=save",
    				type: "POST",
    				data:  new FormData(this),
    				contentType: false,
    				cache: false,
    				processData:false,
    				success: function(html)
    				{
    					var msg = html.split("||");
    					if(msg[0] == "00") {
    						window.location = '<?=base_url()?>?page=pembelian/ops&halaman= ORDER PEMBELIAN ASET&pesan='+msg[1];
    					} else {
    						notifError(msg[1]);
    					}
    					$(".animated").hide();
    				}

    		   });
    	  	} else {notifError("<p>Item  masih kosong.</p>");}
    	 }));
      });

	$('#kode_supplier').change(function(){
        var kode_supplier = $("#kode_supplier").val();
        var top  = $("#kode_supplier").find(':selected').attr('data-top');
        $.ajax({
            type: "POST",
            url: "<?=base_url()?>ajax/j_ops.php?func=loadppn",
            data: "kode_supplier="+kode_supplier,
            cache:false,
            success: function(data) {
                $('#load_ppn').html(data);
                $('#top').val(top);
            }
		});
	});

	$("#tambah_ops").click(function(event) {
		event.preventDefault();

        var kode_supplier     = $("#kode_supplier").val();
        if(kode_supplier != 0 ) {
    		var tgl_sekarang = $("#tgl_sekarang").val();
    		document.getElementById('show_input_ops').style.display = "table-row";

    		$('#kode_kat_aset').val('0').trigger('change');
    		$('#divisi').val('0').trigger('change');
    		$('#tanggal1').val(tgl_sekarang);
    		$('#qty').val('0');
    		$('#harga').val('0');
    		$('#diskon').val('0');
    		$('#subtot').val('0');
    		$('#ket_dtl').val('');
        }else{
            alert("Pilih Supplier Terlebih Dahulu !!");
         }

	});


	$("#batal_input").click(function(event) {
		event.preventDefault();
		document.getElementById('show_input_ops').style.display = "none";
	});

 // saat mengetik qty
  $(document).on("change paste keyup", "input[name='qty']", function(){
                var qty     = $(this).val() || 0;
                var harga   = $("#harga").val();
                var diskon1 = $("#diskon").val();
                var diskon  = parseInt(harga*(diskon1/100));
                var total   = parseInt((harga-diskon)*qty);

                var stat_ppn  = $("#stat_ppn").val();
                if (stat_ppn == 1){
                    nilai_ppn = 0.1*total;
                }else{
                    nilai_ppn = 0;
                }

                var subtot = parseInt(total+nilai_ppn);

                $('[name="subtot"]').val(subtot);
                //console.log(nominal);
  });

 //saat mengetik harga
  $(document).on("change paste keyup", "input[name='harga']", function(){
                var harga  = $(this).val() || 0;
                var qty    = $("#qty").val();
				var diskon1 = $("#diskon").val();
                var diskon  = parseInt(harga*(diskon1/100));
                var total  = parseInt((harga-diskon)*qty);

                var stat_ppn  = $("#stat_ppn").val();
				if (stat_ppn == 1){
					nilai_ppn = 0.1*total;
				}else{
					nilai_ppn = 0;
				}

				var subtot = parseInt(total+nilai_ppn);

                $('[name="subtot"]').val(subtot);
  });

  //saat mengetik diskon
  $(document).on("change paste keyup", "input[name='diskon']", function(){
                var diskon1  = $(this).val() || 0;
                var qty     = $("#qty").val();
				var harga   = $("#harga").val();
                var diskon  = parseInt(harga*(diskon1/100));
                var total   = parseInt((harga-diskon)*qty);

				var stat_ppn  = $("#stat_ppn").val();
				if (stat_ppn == 1){
					nilai_ppn = 0.1*total;
				}else{
					nilai_ppn = 0;
				}

				var subtot = parseInt(total+nilai_ppn);

                $('[name="subtot"]').val(subtot);
  });

  $(document).on("change paste keyup", "input[name='ppn']", function(){
				if (this.checked){
					var group = $(this).data('group');
					var stat  = 1;
					$('[name="stat_ppn"]').val(stat);
				} else {
					var group = $(this).data('group');
					var stat  = 0;
					$('[name="stat_ppn"]').val(stat);
				}

				var qty     = $("#qty").val();
				var harga   = $("#harga").val();
				var diskon1 = $("#diskon").val();
                var diskon  = parseInt(harga*(diskon1/100));
                var total   = parseInt((harga-diskon)*qty);

				if (stat == 1){
					nilai_ppn = 0.1*total;
				}else{
					nilai_ppn = 0;
				}

				var subtot = parseInt(total+nilai_ppn);

                $('[name="subtot"]').val(subtot);
  });

	$("#ok_input").click(function(event) {
		event.preventDefault();
		var id_form			= $("#id_form").val();
		var kode_kat_aset	= $("#kode_kat_aset").val();
		var tgl_kirim		= $("#tanggal1").val();
		var qty				= $("#qty").val();
		var harga			= $("#harga").val();
		var diskon			= $("#diskon").val();
		var ppn				= $("#stat_ppn").val();
		var subtot			= $("#subtot").val();
		var divisi			= $("#divisi").val();
		var keterangan_dtl  = $("#ket_dtl").val();

        if(kode_kat_aset != 0 && qty != 0 && harga != 0) {
          var status = 'true';
        }else{
          var status = 'false';
        }

        if(status == 'true') {
    		$.ajax({
    			type: "POST",
    			url: "<?=base_url()?>ajax/j_ops.php?func=add",
    			data: "kode_kat_aset="+kode_kat_aset+"&tgl_kirim="+tgl_kirim+"&qty="+qty+"&harga="+harga+"&diskon="+diskon+"&ppn="+ppn+"&subtot="+subtot+"&divisi="+divisi+"&keterangan_dtl="+keterangan_dtl+"&id_form="+id_form,
                cache:false,
    			success: function(data) {

    				$('#detail_input_ops').html(data);
    				document.getElementById('show_input_ops').style.display = "none";
    			  //display message back to user here
    			}
    		});
        }else{
            alert("Peringatan : Harap isi Kategori Asset, QTY, dan Harga Terlebih Dahulu !!");
        }
	  return false;
	});

	$(document).ready(function() {
      $(".add-more").click(function(){
	  	  var id_um = $("#id_um").val();
		  var id_um_new = parseInt(id_um)+1;

		  var um = $("#um").val();
		  var nominal = $("#nominal").val();

			$.ajax({
				type: "POST",
				url: "<?=base_url()?>ajax/j_ops.php?func=addum",
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
				var um = $(this).val() || 0;
				var g_total = $("#grandtotal").val();
				var nominal = parseInt((um/100)*g_total);

				$('[name="nominal"]').val(nominal);

				//console.log(nominal);
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
        var kode_kat_aset = $("#kode_kat_aset").val();
        $.ajax({
            type: "POST",
            url: "<?=base_url()?>ajax/j_ops.php?func=loadhistory",
            data: "kode_kat_aset="+kode_kat_aset,
            cache:false,
            success: function(data) {
                $('#list_his_harga').html(data);
            }
        });
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
<script src="<?=base_url()?>assets/select2/select2.js"></script>
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
        width: '100%'
    });
</script>
