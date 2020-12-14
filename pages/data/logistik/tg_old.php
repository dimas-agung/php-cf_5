<?php
	include "pages/data/script/tg.php";
	include "library/form_akses.php";
?>

<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-cubes"></i> Logistik</a></li>
        <li><a href="#">Form Transfer Gudang</a></li>
    </ol>
</section>

<div class="box box-info">
    <div class="box-body">

    	<?php if (isset($_GET['pesan'])){ ?>
			<div class="form-group" id="form_report">
				<div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					  Kode TG :  <a href="<?=base_url()?>?page=logistik/tg_track&action=track&kode_tg=<?=$_GET['pesan']?>" target="_blank"><?=$_GET['pesan'] ?></a>  Berhasil Di posting
				</div>
			</div>
			<?php  }  ?>

<div class="tabbable">
	<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
		<li <?=$class_form?>>
			<a data-toggle="tab" href="#menuFormTg">Form Transfer Gudang</a>
		</li>
        <li <?=$class_tab?>>
			<a data-toggle="tab" href="#menuListTg">List Transfer Gudang</a>
		</li>
    </ul>

<div class="row">
    <div class="tab-content">
        <div id="menuFormTg" <?=$class_pane_form?>>
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
	                              	<label style="text-align:left" class="col-lg-2 col-sm-2 control-label">Kode TG</label>
	                              	<div class="col-lg-4">
	                                 	<input type="text" class="form-control" name="kode_tg" id="kode_tg" placeholder="Auto..." readonly value="">
	                              	</div>

	                              	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
	                                <div class="col-lg-4">
	                                        <input type="text" class="form-control" name="ref" id="ref" placeholder="ref..." value="" autocomplete="off" />
	                                </div>
	                            </div>

	                            <div class="form-group">
	                                <label style="text-align:left" class="col-lg-2 col-sm-2 control-label">Tanggal</label>
	                                <div class="col-lg-4">
	                                    <div class="input-group">
	                                        <input class="form-control date-picker-close" value="<?=date("m/d/Y")?>" id="tgl_buat" name="tgl_buat" type="text" autocomplete="off" placeholder="Tanggal SPK ..." />
	                                        <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
	                                    </div>
	                                </div>

	                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
	                                <div class="col-lg-4">
	                                    <select id="kode_cabang" name="kode_cabang" class="select2">
	                                        <option value="0">-- Pilih Cabang --</option>
	                                            <?php while($rowcabang = mysql_fetch_array($q_cab_aktif)) { ;?>
	                                                <option value="<?php echo $rowcabang['kode_cabang'];?>"><?php echo $rowcabang['kode_cabang'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowcabang['nama_cabang'];?> </option>
	                                            <?php } ?>
	                                    </select>
	                                </div>
	                            </div>

	                            <div class="form-group">
	                              	<label style="text-align:left" class="col-lg-2 col-sm-2 control-label">Gudang Asal</label>
	                              	<div class="col-lg-4" id="load-gudang">
	                                 	<input type="text" class="form-control" name="gudang_asal" id="gudang_asal" placeholder="Pilih Cabang Terlebih Dahulu..." readonly>
	                              	</div>

	                              	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Gudang Tujuan</label>
				                <div class="col-lg-4">
				                    <select id="gudang_tujuan" name="gudang_tujuan" class="select2" style="width: 100%;">
                                        <option value="WH02" selected>WH02 || PRODUKSI</option>
                                    </select>
				                </div>
	                            </div>

	                            <div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                                    <div class="col-lg-10">
                                        <textarea  class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan..."></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
		                                <div class="col-lg-12">
		                                    <div class="pull-left">
		                                        <a class="btn btn-success" id="tambah_tg"><i class="fa fa-plus"></i> Add</a>
		                                    </div>
		                                </div>
		                             </div>

				                <div class="form-group">
                     	            <div style="overflow-x:auto;">
                                        <table id="" class="" rules="all">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Kode</th>
                                                    <th>Item</th>
                                                    <th>Stok Gudang</th>
                                                    <th>Jumlah Transfer</th>
                                                    <th>Harga Rata-Rata</th>
                                                    <th>Total</th>
                                                    <th>Keterangan</th>
                                                    <th></th>
                                                </tr>

                                                <tr id="show_input_tg" style="display:none">
                                                    <td><h5><b>#</b></h5></td>
                                                    <td>
                                                        <select id="kode_barang" name="kode_barang" class="select2">
                                                            <option value="0">-- Pilih Kode Barang --</option>
                                                            <?php
                                                                while($rowinv = mysql_fetch_array($q_inv_aktif)) { ;?>
                                                                <option value="<?php echo $rowinv['kode_barang'];?>" ><?php echo $rowinv['kode_barang'];?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                    <td id="load_nama_barang">
                                                        <input class="form-control" type="text" name="nama_barang" id="nama_barang" value="" readonly/>
                                                    </td>
                                                    <td id="load_saldo_qty">
                                                        <input class="form-control" type="number" name="saldo_qty" id="saldo_qty" value="0" readonly />
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="number" name="qty" id="qty" autocomplete="off" value="0"/>
                                                    </td>
                                                    <td id="load_hpp">
                                                        <input class="form-control" type="number" name="hpp" id="hpp" autocomplete="off" value="0" readonly/>
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="number" name="total_harga" id="total_harga" value="0" readonly/>
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" name="ket_dtl" id="ket_dtl" autocomplete="off" value=""/>
                                                    </td>
                                                    <td>
                                                        <button id="ok_input" class="btn btn-sm btn-info ace-icon fa fa-check" title="ok"></button>
                                                        <a href="" id="batal_input" class="btn btn-sm btn-danger ace-icon fa fa-remove" title="batal"></a>
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tbody id="detail_input_tg">
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
                                        <?php } } } ?>

                                        <a href="<?=base_url()?>?page=logistik/tg" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>
               					</div>

					 		</form>
						</div>
                    </div>
				</div>
			</div>
		</div>

		<div id="menuListTg" <?=$class_pane_tab?>>
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="box-body">
							<table id="example1" class="table table-striped table-bordered table-hover" width="100%" >
								<thead>
									<tr>
                                        <th>No</th>
										<th>Kode TG</th>
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
										if(mysql_num_rows($q_tg) > 0) {
											while($data = mysql_fetch_array($q_tg)) {
									?>

									<tr>
										<td style="text-align: center; width:5px"> <?php echo $n++ ?></td>
										<td style="width: 40px">
											<a href="<?=base_url()?>?page=logistik/tg_track&action=track&kode_tg=<?=$data['kode_tg']?>">
												<?php echo $data['kode_tg'];?>
											</a>
										</td>
										<td> <?php echo $data['ref'];?></td>
										<td> <?php echo date("d-m-Y",strtotime($data['tgl_buat']));?></td>
										<td> <?php echo $data['nama_cabang'];?></td>
										<td> <?php echo $data['gudang_asal'];?></td>
										<td> <?php echo $data['gudang_tujuan'];?></td>
                                        <td style="text-align: center">
                                            <a href="<?=base_url()?>r_cetak_tg.php?kode_tg=<?=$data['kode_tg']?>" title="cetak" target="_blank">
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

<?php unset($_SESSION['data_tg']); ?>
<style>
  .pm-min, .pm-min-s{padding:3px 1px; }
  .animated{display:none;}

  table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 1200px;
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
      	var grand_total = parseFloat($("#qty").val());
      	if(grand_total == "" || isNaN(grand_total)) {grand_total = 0;}
      	e.preventDefault();
      	if(grand_total != 0 && grand_total > 0) {
         	$(".animated").show();
         	$.ajax({
	            url: "<?=base_url()?>ajax/j_tg.php?func=save",
	            type: "POST",
	            data:  new FormData(this),
	            contentType: false,
	            cache: false,
	            processData:false,
	            success: function(html)
	            {
	               var msg = html.split("||");
	               if(msg[0] == "00") {
	                  window.location = '<?=base_url()?>?page=logistik/tg&pesan='+msg[1];
	               } else {
	                  notifError(msg[1]);
	               }
	               $(".animated").hide();
	            }
         	});
      	} else {
      		notifError("<p>Item  masih kosong.</p>");
      	}
    }));
    });

	$('#kode_cabang').change(function(){
        var kode_cabang = $("#kode_cabang").val();

        $.ajax({
            type: "POST",
            url: "<?=base_url()?>ajax/j_tg.php?func=loadgudang",
            data: "kode_cabang="+kode_cabang,
            cache:false,
            success: function(data) {
                $('#load-gudang').html(data);
				BindSelect2();

            }
		});

		function BindSelect2() {
			$("[name='gudang_asal']").select2({
          		width: '100%'
         	});
		}

  	});

  	$("#tambah_tg").click(function(event) {
		event.preventDefault();
		document.getElementById('show_input_tg').style.display = "table-row";

		$('#kode_barang').val('0').trigger('change');
		$('#nama_barang').val('');
		$('#saldo_qty').val('0');
		$('#qty').val('0');
		$('#hpp').val('0');
		$('#total_harga').val('0');
		$('#ket_dtl').val('');

	});

	$('#kode_barang').change(function(){
        var kode_barang = $("#kode_barang").val();

        $.ajax({
            type: "POST",
            url: "<?=base_url()?>ajax/j_tg.php?func=loadnamabarang",
            data: "kode_barang="+kode_barang,
            cache:false,
            success: function(data) {
                $('#load_nama_barang').html(data);
            }
		});
	});

	$('#kode_barang').change(function(){
        var kode_barang = $("#kode_barang").val();
        var kode_cabang = $("#kode_cabang").val();
        var kode_gudang = $("#gudang_asal").val();

        $.ajax({
            type: "POST",
            url: "<?=base_url()?>ajax/j_tg.php?func=loadsaldoqty",
            data: "kode_barang="+kode_barang+"&kode_cabang="+kode_cabang+"&kode_gudang="+kode_gudang,
            cache:false,
            success: function(data) {
                $('#load_saldo_qty').html(data);
            }
		});
	});

	$('#kode_barang').change(function(){
        var kode_barang = $("#kode_barang").val();
        var kode_cabang = $("#kode_cabang").val();
        var kode_gudang = $("#gudang_asal").val();

        $.ajax({
            type: "POST",
            url: "<?=base_url()?>ajax/j_tg.php?func=loadhpp",
            data: "kode_barang="+kode_barang+"&kode_cabang="+kode_cabang+"&kode_gudang="+kode_gudang,
            cache:false,
            success: function(data) {
                $('#load_hpp').html(data);
            }
		});
	});

	$(document).on("change paste keyup", "input[name='qty']", function(){
        var qty     = $(this).val() || 0;
        var harga   = $("#hpp").val();
        var total   = parseInt(harga*qty);

        $('[name="total_harga"]').val(total);
        //console.log(nominal);
  	});

  	$("#ok_input").click(function(event) {
		event.preventDefault();
		var id_form			= $("#id_form").val();
		var kode_barang		= $("#kode_barang").val();
		var nama_barang		= $("#nama_barang").val();
		var saldo_qty		= $("#saldo_qty").val();
		var qty				= $("#qty").val();
		var hpp				= $("#hpp").val();
		var total_harga		= $("#total_harga").val();
		var ket_dtl  		= $("#ket_dtl").val();

		$.ajax({
			type: "POST",
			url: "<?=base_url()?>ajax/j_tg.php?func=add",
			data: "kode_barang="+kode_barang+"&nama_barang="+nama_barang+"&saldo_qty="+saldo_qty+"&qty="+qty+"&hpp="+hpp+"&total_harga="+total_harga+"&ket_dtl="+ket_dtl+"&id_form="+id_form,
            cache:false,
			success: function(data) {

				$('#detail_input_tg').html(data);
				document.getElementById('show_input_tg').style.display = "none";
			}
		  });
	    return false;
	});

	$("#batal_input").click(function(event) {
		event.preventDefault();
		document.getElementById('show_input_tg').style.display = "none";
	});

</script>

<script src="<?=base_url()?>assets/select2/select2.js"></script>
<script>

    $('#gudang_tujuan').css('pointer-events','none');

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
