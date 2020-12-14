<?php
	include "pages/data/script/nb.php";
	include "library/form_akses.php";
?>

<section class="content-header">
    <ol class="breadcrumb">
        <li><i class="fa fa-money"></i> Keuangan</a></li>
        <li>Nota Debit</a></li>
    </ol>
</section>

<div class="box box-info">
    <div class="box-body">

    	<?php if (isset($_GET['pesan'])){ ?>
			<div class="form-group" id="form_report">
				<div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					  Kode NB :  <a href="<?=base_url()?>?page=keuangan/nb_track&action=track&halaman= TRACK NOTA DEBET&kode_nb=<?=$_GET['pesan']?>" target="_blank"><?=$_GET['pesan'] ?></a>  Berhasil Di posting
				</div>
			</div>
			<?php  }  ?>

<div class="tabbable">
	<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
		<li <?=$class_form?>>
			<a data-toggle="tab" href="#menuFormNb">Form Nota Debit</a>
		</li>
        <li <?=$class_tab?>>
			<a data-toggle="tab" href="#menuListNb">List Nota Debit</a>
		</li>
    </ul>

<div class="row">
    <div class="tab-content">
        <div id="menuFormNb" <?=$class_pane_form?>>
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
	                              	<label style="text-align:left" class="col-lg-2 col-sm-2 control-label">Kode NB</label>
	                              	<div class="col-lg-4">
	                                 	<input type="text" class="form-control" name="kode_nb" id="kode_nb" placeholder="Auto..." readonly value="">
	                              	</div>

	                              	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
	                                <div class="col-lg-4">
	                                        <input type="text" class="form-control" name="ref" id="ref" placeholder="ref..." value="" autocomplete="off" />
	                                </div>
	                            </div>

	                            <div class="form-group">
	                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
	                                <div class="col-lg-4">
	                                    <select id="kode_cabang" name="kode_cabang" class="select2">
	                                        <option value="0">-- Pilih Cabang --</option>
	                                            <?php while($rowcabang = mysql_fetch_array($q_cab_aktif)) { ;?>
	                                                <option value="<?php echo $rowcabang['kode_cabang'];?>"><?php echo $rowcabang['nama_cabang'];?> </option>
	                                            <?php } ?>
	                                    </select>
	                                </div>	                            	

	                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Pelanggan / Supplier</label>
	                                <div class="col-lg-4">
	                                	<input type="hidden" class="form-control" name="user" id="user" value="" readonly/>
	                                	<input type="hidden" class="form-control" name="kode_user" id="kode_user" value="" readonly/>
	                                	<input type="hidden" class="form-control" name="nama_user" id="nama_user" value="" readonly/>
		                                <div class="radio">
		                                    <input type="radio" name="rad" id="rad1" value="1" class="rad"/> Pelanggan <br>
		                                </div>
	                                	<div class="radio">
      										<input type="radio" name="rad" id="rad2" value="2" class="rad"/> Supplier
      									</div>
	                                </div>
									
									<label class="col-lg-8 col-sm-2 control-label" style="text-align:left"></label>
	                                <div id="form3" class="col-lg-4">
	                                    <select class="select2" disabled>
	                                        <option name="tidak_ada_kode" id="tidak_ada_kode" value="0">-- Pilih --</option>
	                                    </select>
	                                </div>
	                                <div id="pelanggan" style="display:none" class="col-lg-4">
								        <select id="kode_pelanggan" name="kode_pelanggan" class="select2">
	                                        <option value="0">-- Pilih Pelanggan --</option>
	                                            <?php while($rowpelanggan = mysql_fetch_array($q_pel_aktif)) { ;?>
	                                                <option
	                                                	data-nama-pelanggan = "<?php echo $rowpelanggan['nama_pelanggan'];?>"
	                                                	value="<?php echo $rowpelanggan['kode_pelanggan'];?>">
	                                                	<?php echo $rowpelanggan['kode_pelanggan'].' - '.$rowpelanggan['nama_pelanggan'];?>
	                                                </option>
	                                            <?php } ?>
	                                    </select>
								    </div>
								    <div id="supplier" style="display:none" class="col-lg-4">
								        <select id="kode_supplier" name="kode_supplier" class="select2">
	                                        <option value="0">-- Pilih Supplier --</option>
	                                            <?php while($rowsupplier = mysql_fetch_array($q_sup_aktif)) { ;?>
	                                                <option
	                                                	data-nama-supplier = "<?php echo $rowsupplier['nama_supplier'];?>"
	                                                	value="<?php echo $rowsupplier['kode_supplier'];?>">
	                                                	<?php echo $rowsupplier['kode_supplier'].' - '.$rowsupplier['nama_supplier'];?>
	                                                </option>
	                                            <?php } ?>
	                                    </select>
								    </div>
	                            </div>

	                            <div class="form-group">
	                            	<label style="text-align:left" class="col-lg-2 col-sm-2 control-label">Tanggal</label>
	                                <div class="col-lg-4">
	                                    <div class="input-group">
	                                        <input class="form-control date-picker-close" value="<?=date("m/d/Y")?>" id="tgl_buat" name="tgl_buat" type="text" autocomplete="off" readonly />
	                                        <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
	                                    </div>
	                                </div>
									
									<label style="text-align:left" class="col-lg-2 col-sm-2 control-label">Jatuh Tempo</label>
	                                <div class="col-lg-4">
	                                    <div class="input-group">
	                                        <input class="form-control date-picker-close" value="<?=date("m/d/Y")?>" id="tgl_jth_tempo" name="tgl_jth_tempo" type="text" autocomplete="off" readonly />
	                                        <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
	                                    </div>
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
		                                        <a class="btn btn-success" id="tambah_nb"><i class="fa fa-plus"></i> Add</a>
		                                    </div>
		                                </div>
		                             </div>

				                <div class="form-group">
                                        <div class="col-lg-12">
                                            <table id="" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <?php
                                                        $n=1;
                                                    ?>
                                                    <tr>
                                                        <th width="10px">No</th>
                                                        <th>COA</th>
                                                        <th>Nominal</th>
                                                        <th>Keterangan</th>
                                                        <th></th>
                                                    </tr>

                                                    <tr id="show_input_nb" style="display:none">
                                                            <td style="text-align: center; "><h5><b>#</b></h5></td>
                                                            <td style="width: 350px">
                                                                <select id="kode_coa" name="kode_coa" class="select2" style="width: 260px">
                                                                  <option value="">-- Pilih DOC --</option>
                                                                    <?php
                                                                      (isset($_POST['kode_coa']) ? $coa=$_POST['kode_coa'] : $coa='');
                                                                      while($row_coa = mysql_fetch_array($q_coa)) { ;?>

                                                                      <option value="<?php echo $row_coa['kode_coa'].':'.$row_coa['nama_coa'];?>"
                                                                      	<?php if($row_coa['kode_coa']==$coa){echo 'selected';} ?> >
                                                                        <?php echo $row_coa['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$row_coa['nama_coa'];?>
                                                                      </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="text" name="harga" id="harga"  autocomplete="off" style="text-align:right;" value="0"/>
                                                            </td>
                                                            <td>
                                                                 <input class="form-control" type="text" name="ket_dtl" id="ket_dtl" autocomplete="off" />
                                                            </td>
                                                            <td>
                                                                <button id="ok_input" class="btn btn-sm btn-info ace-icon fa fa-check" title="ok"></button>
                                                                <a href="" id="batal_input" class="btn btn-sm btn-danger ace-icon fa fa-remove" title="batal" ></a>
                                                            </td>
                                                        </tr>
                                                </thead>
                                                <tbody id="detail_input_nb">
                                                   <tr>
                                                         <td colspan="5" class="text-center"> Tidak ada item barang. </td>
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

                                        <a href="<?=base_url()?>?page=keuangan/nb&halaman=NOTA%20DEBET" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>
               					</div>

					 		</form>
						</div>
                    </div>
				</div>
			</div>
		</div>

		<div id="menuListNb" <?=$class_pane_tab?>>
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="box-body">
							<table id="example1" class="table table-striped table-bordered table-hover" width="100%" >
								<thead>
									<tr>
                                        <th>No</th>
										<th>Kode NB</th>
										<th>Ref</th>
										<th>Tanggal</th>
										<th>Cabang</th>
                                        <th>User</th>
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$n=1;
										if(mysql_num_rows($q_nb) > 0) {
											while($data = mysql_fetch_array($q_nb)) {
									?>
									<tr>
										<td style="text-align: center; width:5px"> <?php echo $n++ ?></td>
										<td>
											<a href="<?=base_url()?>?page=keuangan/nb_track&action=track&kode_nb=<?=$data['kode_nb']?>">
												<?php echo $data['kode_nb'];?>
											</a>
										</td>
										<td> <?php echo $data['ref'];?></td>
										<td> <?php echo date("d-m-Y",strtotime($data['tgl_buat']));?></td>
										<td> <?php echo $data['nama_cabang'];?></td>
										<td> <?php echo $data['nama_user'];?></td>
                                        <td style="text-align: center">
                                            <a href="<?=base_url()?>r_cetak_nb.php?kode_nb=<?=$data['kode_nb']?>" title="cetak" target="_blank">
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

<?php unset($_SESSION['data_nb']); ?>
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

	$(document).ready(function () {
		
	$('#harga').number(true, 2);
	
    $("#saveForm").on('submit',(function(e) {
      	e.preventDefault();
         	$(".animated").show();
         	$.ajax({
	            url: "<?=base_url()?>ajax/j_nb.php?func=save",
	            type: "POST",
	            data:  new FormData(this),
	            contentType: false,
	            cache: false,
	            processData:false,
	            success: function(html)
	            {
	               var msg = html.split("||");
	               if(msg[0] == "00") {
	                  window.location = '<?=base_url()?>?page=keuangan/nb&pesan='+msg[1];
	               } else {
	                  notifError(msg[1]);
	               }
	               $(".animated").hide();
	            }
         	});
    }));
    });

    $(function(){
        $(":radio.rad").click(function(){
          $("#pelanggan, #supplier").hide()
          if($(this).val() == "1"){
          	$("#form3").hide();
            $("#pelanggan").show();
            $("#user").val('pelanggan');
			$("#kode_supplier").val(0).trigger('change');
          }else{
          	$("#form3").hide();
            $("#supplier").show();
            $("#user").val('supplier');
			$("#kode_pelanggan").val(0).trigger('change');
          }
        });
    });

    $('#kode_supplier').change(function(){
        var kode_supplier = $("#kode_supplier").val();
        var nama_supplier = $("#kode_supplier").find(':selected').attr('data-nama-supplier');
        $.ajax({
            type: "POST",
            url: "<?=base_url()?>ajax/j_nk.php?func=loadppnsup",
            data: "kode_supplier="+kode_supplier,
            cache:false,
            success: function(data) {
                $('#kode_user').val(kode_supplier);
                $('#nama_user').val(nama_supplier);
            }
		});
	});

	$('#kode_pelanggan').change(function(){
        var kode_pelanggan = $("#kode_pelanggan").val();
        var nama_pelanggan = $("#kode_pelanggan").find(':selected').attr('data-nama-pelanggan');
        $.ajax({
            type: "POST",
            url: "<?=base_url()?>ajax/j_nk.php?func=loadppnpel",
            data: "kode_pelanggan="+kode_pelanggan,
            cache:false,
            success: function(data) {
                $('#kode_user').val(kode_pelanggan);
                $('#nama_user').val(nama_pelanggan);
            }
		});
	});

  	$("#tambah_nb").click(function(event) {
		event.preventDefault();
		document.getElementById('show_input_nb').style.display = "table-row";

		$('#kode_coa').val('0').trigger('change');
	    $('#harga').val('0');
	    $('#ket_dtl').val('');

	});

  	$("#ok_input").click(function(event) {
		event.preventDefault();
		var id_form			= $("#id_form").val();
		var kode_coa		= $("#kode_coa").val();
		var harga			= $("#harga").val();
		var ket_dtl  		= $("#ket_dtl").val();
		var harga2 = harga.replace(',', '');
		if (harga2.indexOf('-') !== -1) {
			alert('Nominal tidak boleh minus');
			return false;
		}
		if (kode_coa == null) {
			alert('COA tidak boleh kosong');
			return false;			
		}
		$.ajax({
			type: "POST",
			url: "<?=base_url()?>ajax/j_nb.php?func=add",
			data: "kode_coa="+kode_coa+"&harga="+harga2+"&ket_dtl="+ket_dtl+"&id_form="+id_form,
            cache:false,
			success: function(data) {

				$('#detail_input_nb').html(data);
				document.getElementById('show_input_nb').style.display = "none";
			}
		  });
	    return false;
	});

	$("#batal_input").click(function(event) {
		event.preventDefault();
		document.getElementById('show_input_nb').style.display = "none";
	});

</script>

<!-- <script src="<?=base_url()?>assets/select2/select2.js"></script> -->
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
