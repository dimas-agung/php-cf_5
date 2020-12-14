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
    </ul>

<?php
    if(isset($_GET['action']) and $_GET['action'] == "transfer") {

	$kode_pm 		= ($_GET['kode_pm']);
	$kode_cabang 	= ($_GET['kode_cabang']);
	$kode_gudang 	= ($_GET['kode_gudang']);

	// die($kode_cabang);
	
	$q_pm_hdr = mysql_query("SELECT ph.kode_cabang, c.nama nama_cabang, kode_gudang_asal, ga.nama gudang_asal, kode_gudang_tujuan, gt.nama gudang_tujuan FROM pm_hdr ph
								LEFT JOIN cabang c ON c.kode_cabang = ph.kode_cabang
								LEFT JOIN gudang ga ON ga.kode_gudang = ph.kode_gudang_asal
								LEFT JOIN gudang gt ON gt.kode_gudang = ph.kode_gudang_tujuan
								WHERE kode_pm = '".$kode_pm."' ");
	$res_hdr = mysql_fetch_array($q_pm_hdr); 
	
	$q_pm_dtl = mysql_query("SELECT pd.kode_barang, pd.nama_barang, cs.kode_cabang, cs.kode_gudang, IFNULL(cs.saldo_qty,0) saldo_qty, IFNULL(cs.saldo_last_hpp,0) saldo_last_hpp FROM pm_dtl pd 
								LEFT JOIN crd_stok cs ON cs.kode_barang = pd.kode_barang 
								LEFT JOIN pm_hdr ph ON ph.kode_pm = pd.kode_pm AND ph.kode_cabang = cs.kode_cabang AND ph.kode_gudang_asal = cs.kode_gudang
								WHERE ph.kode_pm = '".$kode_pm."' AND ph.kode_cabang = '".$kode_cabang."' AND ph.kode_gudang_asal = '".$kode_gudang."' 
								ORDER BY id_pm_dtl ASC");
	
	}
?>

<div class="row">
    <div class="tab-content">	
        <div id="menuFormOp" <?=$class_pane_form?>>
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
	                                        <input class="form-control date-picker" value="<?=date("d-m-Y")?>" id="tgl_buat" name="tgl_buat" type="text" autocomplete="off" placeholder="Tanggal SPK ..." />
	                                        <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
	                                        <input type="hidden" name="tgl_sekarang" id="tgl_sekarang" class="form-control" value="<?=date("d-m-Y")?>"/>
	                                    </div>
	                                </div>

	                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
	                                <div class="col-lg-4">
	                                	<input type="hidden" class="form-control" name="kode_cabang" id="kode_cabang" placeholder="Kode Cabang..." readonly value="<?= $res_hdr['kode_cabang']?>">

	                                    <input type="text" class="form-control" name="nama_cabang" id="nama_cabang" placeholder="Kode Cabang..." readonly value="<?= $res_hdr['kode_cabang'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$res_hdr['nama_cabang']?>">
	                                </div>
	                            </div>  

	                            <div class="form-group">
	                              	<label style="text-align:left" class="col-lg-2 col-sm-2 control-label">Gudang Asal</label>
	                              	<div class="col-lg-4">
	                              		<input type="hidden" class="form-control" name="kode_gudang_asal" id="kode_gudang_asal" placeholder="Pilih Cabang Terlebih Dahulu..." readonly value="<?= $res_hdr['kode_gudang_asal']?>">

	                                 	<input type="text" class="form-control" name="nama_gudang_asal" id="nama_gudang_asal" placeholder="Pilih Cabang Terlebih Dahulu..." readonly value="<?= $res_hdr['kode_gudang_asal'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$res_hdr['gudang_asal']?>">
	                              	</div>

	                              	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Gudang tujuan</label>
	                                <div class="col-lg-4">
	                                    <input type="hidden" class="form-control" name="kode_gudang_tujuan" id="kode_gudang_tujuan" placeholder="Pilih Cabang Terlebih Dahulu..." readonly value="<?= $res_hdr['kode_gudang_tujuan']?>">

	                                 	<input type="text" class="form-control" name="nama_gudang_tujuan" id="nama_gudang_tujuan" placeholder="Pilih Cabang Terlebih Dahulu..." readonly value="<?= $res_hdr['kode_gudang_tujuan'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$res_hdr['gudang_tujuan']?>">
	                                </div>
	                            </div>

	                            <div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                                    <div class="col-lg-10">
                                        <textarea  class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan..."></textarea>
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
                                                </tr>
                                            </thead>
                                            <tbody>
                                            	<?php $no=1; while($res_dtl = mysql_fetch_array($q_pm_dtl)) { ;?>	
                                                	<tr>
                                                		<td style="text-align: center;"><?= $no++ ?></td>
					                                    <td><?php echo $res_dtl['kode_barang']; ?>
					                                    	<input type="hidden" class="form-control" name="kode_barang[]" id="kode_barang[]" value="<?php echo $res_dtl['kode_barang']; ?>" >
					                                    </td>
					                                    <td><?php echo $res_dtl['nama_barang']; ?>
					                                    	<input type="hidden" class="form-control" name="nama_barang[]" id="nama_barang[]" value="<?php echo $res_dtl['nama_barang']; ?>" >
					                                    </td>
					                                    <td>
					                                    	<input type="text" style="text-align: right;" class="form-control" name="saldo_qty[]" id="saldo_qty[]" value="<?php echo $res_dtl['saldo_qty']; ?>" readonly>
					                                	</td>
					                                    <td>
					                                    	<input type="number" style="text-align: right;" onkeyup="hitungdetail();" class="form-control b" name="qty[]" id="qty[]" value="0">
					                                    </td>
					                                    <td>
					                                    	<input type="text" style="text-align: right;" class="form-control a" name="hpp[]" id="hpp[]" value="<?= $res_dtl['saldo_last_hpp']?>" readonly>
					                                    </td>
					                                    <td style="text-align: right;">
					                                    	<input type="text" style="text-align: right;" class="form-control c" name="total_harga[]" id="total_harga[]" value="0" readonly>
					                                    </td>
					                                    <td>
					                                    	<input type="text" class="form-control" id="keterangan_dtl[]" name="keterangan_dtl[]" value="" autocomplete="off">
					                                    </td>
					                                </tr>
					                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
								</div>

								<div class="form-group col-md-6">
		                    		<?php 
										$list_survey_write = 'n';
										while($res = mysql_fetch_array($q_akses)) {; 
									?>    
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
	</div>
</div>	

<?php unset($_SESSION['data_tg']); ?>
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
            if(grand_total >= 0) {          
                $(".animated").show();
                $.ajax({
                    
                    url: "<?=base_url()?>ajax/j_tg.php?func=save-link",
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
            } else {notifError("<p>Item  masih kosong.</p>");}
        }));
    });

	function hitungdetail() {
        var total 	= 0;
        var qty 	= document.getElementsByClassName('b');
        var hpp 	= document.getElementsByClassName('a');
        var hasil 	= document.getElementsByClassName('c');
        for (var i = 0; i < hpp.length; ++i) {
            if (!isNaN(parseInt(hpp[i].value)) )
            total = parseInt(hpp[i].value*qty[i].value); 
            document.getElementsByClassName("c")[i].value = total;
        }
    }
</script>

<script src="<?=base_url()?>assets/select2/select2.js"></script>
<script>

  $(function () {
  	$( "#tgl_buat" ).datepicker();
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
  })
  
  $(document).ready(function (e) {

    $(".select2").select2({
       	width: '100%'
    });

  });
</script>