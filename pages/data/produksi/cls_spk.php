<?php
	include "pages/data/script/cls_spk.php";
	include "library/form_akses.php";
?>

<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-cubes"></i> Produksi</a></li>
        <li><a href="#">Form Close Surat Perintah Kerja</a></li>
    </ol>
</section>

<!-- /.row -->
<div class="box box-info">
<div class="box-body">

            <?php if (isset($_GET['pesan'])){ ?>
				<div class="form-group" id="form_report">
				  <div class="alert alert-success alert-dismissable">
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					  Kode Close :  <a href="<?=base_url()?>?page=produksi/cls_spk_track&action=track&kode_cspk=<?=$_GET['pesan']?>" target="_blank"><?=$_GET['pesan'] ?></a>  Berhasil Di posting
				  </div>
				</div>
			<?php  }  ?>

<div class="tabbable">
	<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
		<li <?=$class_form?>>
		    <a data-toggle="tab" href="#menuFormClsSpk">Form Close Surat Perintah Kerja</a>
		</li>
        <li <?=$class_tab?>>
			<a data-toggle="tab" href="#menuListClsSpk">List Close Surat Perintah Kerja</a>
		</li>
    </ul>

<div class="row">
    <div class="tab-content">
        <div id="menuFormClsSpk" <?=$class_pane_form?>>
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
                                <input type="hidden" name="grand_total" id="grand_total" value="1"/>
    							<div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode Closing</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" name="kode_cspk" id="kode_cspk" placeholder="Auto..." readonly value="">
                                	</div>

                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
                                    <div class="col-lg-4">
                                        <select id="kode_cabang" name="kode_cabang" class="select2">
                                            <option value="0">-- Pilih Tanggal Dahulu --</option>
                                                <?php while($rowcabang = mysql_fetch_array($q_cabang)) { ;?>
                                                    <option value="<?php echo $rowcabang['kode_cabang'];?>"><?php echo $rowcabang['kode_cabang'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowcabang['nama_cabang'];?> </option>
                                                <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" name="ref" id="ref" placeholder="ref..." value="" autocomplete="off" />
                                    </div>

                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">DOC SPK</label>
                                    <div class="col-lg-4" id="load_spk">
                                        <select id="doc_spk" name="doc_spk" class="select2" style="width: 100%;" disabled>
                                            <option value="0">-- Pilih Cabang Dahulu --</option>
                                                <?php while($rowspk = mysql_fetch_array($q_spk)) { ;?>
                                                    <option
                                                        data-qty="<?php echo $rowspk['qty'];?>"
                                                        data-satuan-besar="<?php echo $rowspk['satuan_bom'];?>"
                                                        value="<?php echo $rowspk['kode_spk'];?>"><?php echo $rowspk['nama_spk'];?>
                                                    </option>
                                                <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="text-align:left" class="col-lg-2 col-sm-2 control-label">Tanggal SPK</label>
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <input class="form-control date-picker-close" value="<?=date("m/d/Y")?>" id="tgl_buat" name="tgl_buat" type="text" autocomplete="off" placeholder="Tanggal SPK ..." />
                                            <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                            <input type="hidden" name="tgl_sekarang" id="tgl_sekarang" class="form-control" value="<?=date("m/d/Y")?>"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                                    <div class="col-lg-10">
                                        <textarea  class="form-control" name="keterangan_hdr" id="keterangan_hdr" placeholder="Keterangan..."></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                         	        <div class="col-md-12">
                                        <table id="tabel_detail" class="table table-striped table-bordered table-hover" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Doc SPK</th>
                                                    <th colspan="2">Barang</th>
                                                    <th>Satuan</th>
                                                    <th>Rencana Produksi</th>
                                                    <th>Realisasi Produksi</th>
                                                    <th>%</th>
                                                </tr>
    										</thead>
                                            <tbody id="detail_input_spk">
                                                <tr>
                                                    <td colspan="7" class="text-center">Belum ada item</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
    							</div>

                                <hr>
                                    <div align="center">
                                        <h4><b>MATERIAL</b></h4>
                                    </div>
                                <hr>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <table id="tabel_material" class="table table-striped table-bordered table-hover" width="100%">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">Standart Material</th>
                                                    <th>Standart Pemakaian</th>
                                                    <th>Transfer Material</th>
                                                    <th>Sisa Material</th>
                                                </tr>
                                            </thead>
                                            <tbody id="detail_input_material">
                                                <tr>
                                                    <td colspan="5" class="text-center">Belum ada item</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <hr>
                                    <div align="center">
                                        <h4><b>PERHITUNGAN VARIANCE PRODUKSI</b></h4>
                                    </div>
                                <hr>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <table id="tabel_produksi" class="table table-striped table-bordered table-hover" width="100%">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">Barang</th>
                                                    <th>Standart</th>
                                                    <th>Pemakaian Material</th>
                                                    <th>Variance</th>
                                                    <th>MAP</th>
                                                    <th>Var Nominal</th>
                                                    <th>Var %</th>
                                                </tr>
                                            </thead>
                                            <tbody id="detail_input_produksi">
                                                <tr>
                                                    <td colspan="8" class="text-center">Belum ada item</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="form-group col-md-12" style="text-align: center;">
                        			<?php
    									$list_survey_write = 'n';
    									while($res = mysql_fetch_array($q_akses)) {; ?>
    										<?php
                                                 if($res['form']=='survey'){
                                                    if($res['w']=='1'){
    													$list_survey_write = 'y';
                                            ?>
    											<button type="submit" name="simpan" id="simpan" class="btn btn-primary" tabindex="10"><i class="fa fa-check-square-o"></i>Simpan</button>
                                            <?php } } ?>
                         			<?php } ?>

                                        <a href="<?=base_url()?>?page=produksi/cls_spk" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>&nbsp; <img src="<?=base_url()?>assets/images/loading.gif" class="animated"/>

    							</div>
                     		</form>
        				</div>
    	            </div>
                    <!-- /.panel-body -->
                </div>
            <!-- /.panel-default -->
            </div>
        </div>

        <div id="menuListClsSpk" <?=$class_pane_tab?>>
        	<div class="col-lg-12">
        		<div class="panel panel-default">
        			<div class="panel-body">
        				<table id="example1" class="table table-striped table-bordered table-hover">
        					<thead>
        						<tr>
                                    <th>No</th>
        							<th>Kode CSPK</th>
                                    <th>Cabang</th>
        							<th>Kode SPK</th>
                                    <th>Ref</th>
                                    <th>Action</th>
        						</tr>
        					</thead>
        					<tbody>
        						<?php
        							$n=1;
        							if(mysql_num_rows($q_cspk) > 0) {
        								while($data = mysql_fetch_array($q_cspk)) {
        						?>

        						<tr>
                                    <td style="text-align: center"> <?php echo $n++ ?></td>
        							<td>
                                        <a href="<?=base_url()?>?page=produksi/cls_spk_track&action=track&kode_cspk=<?=$data['kode_cspk']?>">
                                        	<?php echo $data['kode_cspk'];?>
                                        </a>
                                    </td>
                                    <td> <?php echo $data['nama_cabang'];?></td>
                                    <td> <?php echo $data['kode_spk'];?></td>
                                    <td> <?php echo $data['ref'];?></td>
        							<td style="text-align: center">
                                        <a href="<?=base_url()?>r_cetak_cspk.php?kode_cspk=<?=$data['kode_cspk']?>" title="cetak" target="_blank">
        	                                <button type="button" class="btn btn-success btn-sm">
        	                                    <span class="glyphicon glyphicon-print"></span>
        	                                </button>
                                        </a>
                                    </td>
                                </tr>

        						<?php } } ?>
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
</div>

<?php unset($_SESSION['data_cspk']); ?>
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
  }

  td {
      text-align: left;
      padding: 8px;
  }

  tr:nth-child(even){background-color: #f2f2f2}
</style>

<script>
    $(document).ready(function (e) {
         $("#saveForm").on('submit',(function(e) {
                var grand_total = parseFloat($("#grand_total").val());
                if(grand_total == "" || isNaN(grand_total)) {grand_total = 0;}
                e.preventDefault();
                    if(grand_total != 0) {
                        $.ajax({
                            url: "<?=base_url()?>ajax/j_cls_spk.php?func=save",
                            type: "POST",
                            data:  new FormData(this),
                            contentType: false,
                            cache: false,
                            processData:false,
                            success: function(html)
                            {
                                var msg = html.split("||");
                                if(msg[0] == "00") {
                                    window.location = '<?=base_url()?>?page=produksi/cls_spk&pesan='+msg[1];
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
        var tgl_buat    = $("#tgl_buat").val();

        $.ajax({
            type: "POST",
            url: "<?=base_url()?>ajax/j_cls_spk.php?func=loadspk",
            data: "kode_cabang="+kode_cabang+"&tgl_buat="+tgl_buat,
            cache:false,
            success: function(data) {
                $('#load_spk').html(data);
                BindSelect2();
            }
        });

        function BindSelect2() {
            $("[name='doc_spk']").select2({
                width: '100%'
            });
        }
    });

    $('body').delegate("#doc_spk","change", function() {
        var kode_spk     = $("#doc_spk").val();

            $.ajax({
                    type: "POST",
                    url: "<?=base_url()?>ajax/j_cls_spk.php?func=loaddtl",
                    data: "kode_spk="+kode_spk,
                    cache:false,
                    success: function(data) {
                        $('#detail_input_spk').html(data);
                    }
                });
    });

    //SAAT MENGETIK REALISASI PRODUKSI
    $(document).on("change paste keyup", "input[name='realisasi_produksi']", function(){
        // alert("tes");
        var realisasi_produksi  = $(this).val() || 0;
        var rencana_produksi    = $("#rencana_produksi").val();

        var persen  = parseInt((realisasi_produksi/rencana_produksi)*100);

        $('[name="persen"]').val(persen);
    });

    $('body').delegate("#doc_spk","change", function() {
        var kode_spk     = $("#doc_spk").val();

            $.ajax({
                    type: "POST",
                    url: "<?=base_url()?>ajax/j_cls_spk.php?func=loadmaterial",
                    data: "kode_spk="+kode_spk,
                    cache:false,
                    success: function(data) {
                        $('#detail_input_material').html(data);
                    }
                });
    });

    $('body').delegate("#doc_spk","change", function() {
        var kode_spk     = $("#doc_spk").val();
        var kode_cabang  = $("#kode_cabang").val();

            $.ajax({
                type: "POST",
                url: "<?=base_url()?>ajax/j_cls_spk.php?func=loadproduksi",
                data: "kode_spk="+kode_spk+"&kode_cabang="+kode_cabang,
                cache:false,
                success: function(data) {
                    $('#detail_input_produksi').html(data);
                }
            });
    });

    function hitungdetail() {
        var qty_material = 0;
        var pemakaian_material1 = 0;
        var variance1 = 0;
        var var_nominal = 0;
        var var_persen = 0;

        var sisa_material = document.getElementsByClassName('a');
        var transfer_material_produksi = document.getElementsByClassName('c');
        var standart = document.getElementsByClassName('e');
        var map = document.getElementsByClassName('g');

        for (var i = 0; i < sisa_material.length; ++i) {
            if (!isNaN(parseInt(sisa_material[i].value)))
                qty_material = parseInt(sisa_material[i].value);
                document.getElementsByClassName('b')[i].value = qty_material;

                pemakaian_material1 = parseInt(transfer_material_produksi[i].value-sisa_material[i].value);
                document.getElementsByClassName('d')[i].value = pemakaian_material1;

                var pemakaian_material = document.getElementsByClassName('d');
                variance1 = parseInt(pemakaian_material[i].value-standart[i].value);
                document.getElementsByClassName('f')[i].value = variance1;

                var variance = document.getElementsByClassName('f');
                var_nominal = parseInt(variance[i].value*map[i].value);
                document.getElementsByClassName('h')[i].value = var_nominal;

                var_persen = parseFloat((pemakaian_material[i].value-standart[i].value)/standart[i].value);
                document.getElementsByClassName('i')[i].value = var_persen;
        }
    }

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
