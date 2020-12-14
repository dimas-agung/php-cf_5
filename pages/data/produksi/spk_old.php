<?php
	include "pages/data/script/spk.php";
	include "library/form_akses.php";
?>

<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-cubes"></i> Produksi</a></li>
        <li><a href="#">Form Surat Perintah Kerja</a></li>
    </ol>
</section>

<!-- /.row -->
<div class="box box-info">
<div class="box-body">

            <?php if (isset($_GET['pesan'])){ ?>
				<div class="form-group" id="form_report">
				  <div class="alert alert-success alert-dismissable">
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					  Kode SPK :  <a href="<?=base_url()?>?page=produksi/spk_track&action=track&kode_spk=<?=$_GET['pesan']?>" target="_blank"><?=$_GET['pesan'] ?></a>  Berhasil Di posting
				  </div>
				</div>
			<?php  }  ?>

<div class="tabbable">
	<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
		<li <?=$class_form?>>
		    <a data-toggle="tab" href="#menuFormSpk">Form Surat Perintah Kerja</a>
		</li>
        <li <?=$class_tab?>>
			<a data-toggle="tab" href="#menuListSpk">List Surat Perintah Kerja</a>
		</li>
    </ul>

<div class="row">
    <div class="tab-content">
        <div id="menuFormSpk" <?=$class_pane_form?>>
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
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode SPK</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" name="kode_spk" id="kode_spk" placeholder="Auto..." readonly value="">
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
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" name="ref" id="ref" placeholder="ref..." value="" autocomplete="off" />
                                    </div>

                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Barang Jadi</label>
                                    <div class="col-lg-4">
                                        <select id="kode_barang_jadi" name="kode_barang_jadi" class="select2">
                                            <option value="0">-- Pilih Barang Jadi --</option>
                                                <?php while($rowbarang = mysql_fetch_array($q_barang)) { ;?>
                                                    <option
                                                    	data-qty="<?php echo $rowbarang['qty'];?>"
    						                    		data-satuan-besar="<?php echo $rowbarang['satuan_bom'];?>"
                                                    	value="<?php echo $rowbarang['kode_barang'];?>"><?php echo $rowbarang['kode_barang'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowbarang['nama_barang'];?>
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

                                    <label style="text-align:left" class="col-lg-2 col-sm-2 control-label">Target Selesai</label>
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <input class="form-control date-picker-close" value="<?=date("m/d/Y")?>" id="tgl_jatuh_tempo" name="tgl_jatuh_tempo" type="text" autocomplete="off" placeholder="Target elesai ..." />
                                            <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                            <input type="hidden" name="tgl_sekarang" id="tgl_sekarang" class="form-control" value="<?=date("m/d/Y")?>"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Jumlah</label>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control b" onkeyup="hitungdetail();" name="jumlah" id="jumlah" placeholder="Jumlah..." value="" autocomplete="off" />
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control" name="satuan" id="satuan" placeholder="satuan..." value="" readonly/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                                    <div class="col-lg-10">
                                        <textarea  class="form-control" name="keterangan_hdr" id="keterangan_hdr" placeholder="Keterangan..."></textarea>
                                    </div>
                                </div>

                                <hr>

                                <div align="center">
                                	<h4><b>BAHAN BAKU</b></h4>
                                </div>

                                <hr>

                                <div class="form-group">
                         	        <div class="col-md-12">
                                        <table id="tabel_detail" class="" rules="all">
                                            <thead>
                                                <tr>
                                                    <th>Kode</th>
                                                    <th>Nama</th>
                                                    <th>Satuan</th>
                                                    <th>Base Qty</th>
                                                    <th>Kebutuhan</th>
                                                    <th>Keterangan</th>
                                                </tr>
    										</thead>
                                            <tbody id="detail_input_spk">
                                                <tr>
                                                    <td colspan="6" class="text-center">Belum ada item</td>
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
                                                 if($res['form']=='survey'){
                                                    if($res['w']=='1'){
    													$list_survey_write = 'y';
                                            ?>
    											<button type="submit" name="simpan" id="simpan" class="btn btn-primary" tabindex="10"><i class="fa fa-check-square-o"></i> Simpan</button>
                                            <?php } } ?>
                         			<?php } ?>

                                        <a href="<?=base_url()?>?page=produksi/spk" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>&nbsp; <img src="<?=base_url()?>assets/images/loading.gif" class="animated"/>

    							</div>
                     		</form>
        				</div>
    	            </div>
                    <!-- /.panel-body -->
                </div>
            <!-- /.panel-default -->
            </div>
        </div>

        <div id="menuListSpk" <?=$class_pane_tab?>>
        	<div class="col-lg-12">
        		<div class="panel panel-default">
        			<div class="panel-body">
        				<table id="example1" class="table table-striped table-bordered table-hover">
        					<thead>
        						<tr>
                                    <th>No</th>
        							<th>Kode SPK</th>
                                    <th>Ref</th>
                                    <th>Cabang</th>
        							<th>Tanggal</th>
                                    <th>Action</th>
        						</tr>
        					</thead>
        					<tbody>
        						<?php
        							$n=1;
        							if(mysql_num_rows($q_spk) > 0) {
        								while($data = mysql_fetch_array($q_spk)) {
        						?>

        						<tr>
                                    <td style="text-align: center"> <?php echo $n++ ?></td>
        							<td>
                                        <a href="<?=base_url()?>?page=produksi/spk_track&action=track&kode_spk=<?=$data['kode_spk']?>">
                                        	<?php echo $data['kode_spk'];?>
                                        </a>
                                    </td>
        							<td> <?php echo $data['ref'];?></td>
                                    <td> <?php echo $data['nama_cabang'];?></td>
                                    <td> <?php echo date("d-m-Y",strtotime($data['tgl_buat']));?></td>
        							<td style="text-align: center">
                                        <a href="<?=base_url()?>r_cetak_spk.php?kode_spk=<?=$data['kode_spk']?>" title="cetak" target="_blank">
        	                                <button type="button" class="btn btn-success btn-sm">
        	                                    <span class="glyphicon glyphicon-print"></span>
        	                                </button>
                                        </a>
                                        <a href="<?=base_url()?>?page=logistik/pm&action=permintaan&kode_spk=<?=$data['kode_spk']?>" title="Permintaan Material" >
                                            <button type="button" class="btn btn-primary btn-sm">
                                                <span class="fa fa-truck"></span>
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

<?php unset($_SESSION['data_spk']); ?>
<script>
    $(document).ready(function (e) {
         $("#saveForm").on('submit',(function(e) {
            var grand_total = parseFloat($("#jumlah").val());
            if(grand_total == "" || isNaN(grand_total)) {grand_total = 0;}
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
                            //window.open('r_penjualan_cetak.php?noNota=' + msg[1], width=330,height=330,left=100, top=25);

                            window.location = '<?=base_url()?>?page=produksi/spk&pesan='+msg[1];
                        } else {
                            notifError(msg[1]);
                        }
                        $(".animated").hide();
                    }

               });
            } else {notifError("<p>Item  masih kosong.</p>");}
        }));
    });

	$('body').delegate("#kode_barang_jadi","change", function() {
		var qty 			 = $("#kode_barang_jadi").find(':selected').attr('data-qty');
		var satuan_besar 	 = $("#kode_barang_jadi").find(':selected').attr('data-satuan-besar');
		var kode_barang_jadi = $("#kode_barang_jadi").val();
		$.ajax({
			type: "POST",
			url: "<?=base_url()?>ajax/j_spk.php?func=loaditem",
			data: "kode_barang_jadi="+kode_barang_jadi,
			cache:false,
			success: function(data) {
				$('#jumlah').val(qty);
				$('#satuan').val(satuan_besar);
				$('#detail_input_spk').html(data);
			}
		});
	});

	function hitungdetail() {
        var total = 0;
        var jumlah = $("#jumlah").val();
        var base_qty = document.getElementsByClassName('a');
        var hasil = document.getElementsByClassName('c');
        for (var i = 0; i < base_qty.length; ++i) {
            if (!isNaN(parseInt(base_qty[i].value)) )
            total = parseInt(base_qty[i].value*jumlah);
            document.getElementsByClassName("c")[i].value = total;
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
