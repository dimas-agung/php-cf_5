<?php 	
  include "pages/data/script/spk.php"; 
	include "library/form_akses.php";	
?>
<?php
			// HEADER
			$res_hdr = mysql_fetch_array($q_spk_hdr); 
			$kode_spk = $res_hdr['kode_spk'];
			$to_pm = $res_hdr['to_pm'];
			$to_fg = $res_hdr['to_fg'];
			$to_retur = $res_hdr['to_retur'];
			$to_bs = $res_hdr['to_bs'];
			$status_hdr = $res_hdr['status_hdr'];

                if ($status_hdr == 'open'){
                    $status = 'OPEN';
                }elseif($status_hdr == 'cancel'){
                    $status = 'CANCELED';
                }else{
                    $status = 'CLOSE';
                }
				
				$btn_cls = '';
	
	$btn_pm = '<a href="' . base_url() . '?page=logistik/pm&action=spk_to_pm&kode_spk=' . $kode_spk . '&halaman= PERMINTAAN MATERIAL" class="btn btn-primary pull-right">P. Material</a>';

	$btn_tm = '<a href="' . base_url() . '?page=logistik/pm&action=spk_to_pm&kode_spk=' . $kode_spk . '&halaman= TAMBAHAN MATERIAL" class="btn btn-primary pull-right">T. Material</a>';
	
	$btn_bj = '<a href="' . base_url() . '?page=produksi/bj&action=spk_to_bj&kode_spk=' . $kode_spk . '&halaman= BARANG JADI" class="btn btn-primary pull-right">Brg Jadi</a>';
	
	$btn_dn = '<button type="button" id="done" class="btn btn-success pull-right">Finish</button>';
	
	$btn_r_bu = '<button type="button" id="rbaku" class="btn btn-danger pull-right">Retur Material</button>';
	
	$btn_r_bs = '<button type="button" id="rbs" class="btn btn-primary pull-right">Retur BS Material</button>';
	
	$cls = '';
	$pm = '';
	$tm = '';
	$bj = '';
	$dn = '';
	$r_bu = '';
	$r_bs = '';
	
	if($status_hdr <> "open" ){

		if($to_retur <> "yes"){
			$r_bu=$btn_r_bu;
		}
		if($to_bs <> "yes"){
			$r_bs=$btn_r_bs;
		}


	}else{

		if($to_pm <> "yes"){
			$pm=$btn_pm;
		}elseif($to_fg == "yes"){
			$dn=$btn_dn;
			$tm=$btn_tm;
			$bj=$btn_bj;
		}else{
			$tm=$btn_tm;
			$bj=$btn_bj;
		}
		$cls=$btn_cls;
		
	}

		?>	
<style>
  .pembatalan {
      background-color: #9c0303;
    }
</style>

<section class="content-header">
    <ol class="breadcrumb">
      <li><i class="fa fa-folder-open"></i> Produksi</a></li>
      <li>Surat Perintah Kerja</a></li>
      <li>Track Surat Perintah Kerja</a></li>
    </ol>
</section>
        
<section class="content">
  <div class="col-md-4">
    <?php
        $prev = mysql_fetch_array($q_spk_prev); {
        if (isset($prev['id_spk_hdr'])){
      ?>
          <a class="btn btn-warning" href="<?=base_url()?>?page=produksi/spk_track&action=track&halaman= TRACK SURAT PERINTAH KERJA&kode_spk=<?=$prev['kode_spk']?>">
            <i class="fa fa-chevron-left" aria-hidden="true"></i>
          </a>
      <?php
        } 
        } 

        $next = mysql_fetch_array($q_spk_next); {
        if (isset($next['id_spk_hdr'])){
      ?>
          &nbsp;<a class="btn btn-warning" href="<?=base_url()?>?page=produksi/spk_track&action=track&halaman= TRACK SURAT PERINTAH KERJA&kode_spk=<?=$next['kode_spk']?>">
            <i class="fa fa-chevron-right" aria-hidden="true"></i>
          </a>
    <?php
        } 
        }
    ?>

      &nbsp;
       <?php
          if($status_hdr != '1'){
            $statusd= 'hidden';
          }
       ?>
        <a href="#modalPembatalan" class="btn pembatalan <?= $statusd;?>" style="color: white" data-toggle="modal"><i class=" fa fa-close"></i> PEMBATALAN</a>
  </div>

  <div class="col-md-8">
  <?php echo $pm; echo '&nbsp'; echo $tm; echo '&nbsp'; echo $bj; echo '&nbsp'; echo $r_bu; echo '&nbsp'; echo $r_bs; echo '&nbsp';	echo $dn; echo '&nbsp'; echo $cls; ?>
    <a href="<?=base_url()?>?page=produksi/spk&halaman= SURAT PERINTAH KERJA" class="btn btn-danger pull-right"><i class="fa fa-reply"></i> BACK</a><br/>
  </div>
</section>

<div class="box box-info">
    <div class="box-body">
     	&nbsp;
		

				<div class="row">
					<div class="tab-content">
						<div class="col-lg-12">
              <div class="panel panel-default">
                <div class="panel-body">
                  <div class="form-horizontal">
                                        <h3 style="text-align: center"><?php echo $status ?></h3> <hr style="border-top: 2px solid #5615157d;">

                                 	      <div class="form-group">
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode SPK</label>
                                             <div class="col-lg-4">
                                                 <input type="text" class="form-control" name="kode_spk" id="kode_spk" placeholder="Auto..." readonly value="<?=$res_hdr['kode_spk']?>">
                                             </div>
                                             
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
                                             <div class="col-lg-4">
                                             	<input type="text" required class="form-control" name="cabang" id="cabang" placeholder="Cabang" value="<?=$res_hdr['nama_cabang']?>" readonly>
                                             </div>   
                                        </div>  
                            
										                    <div class="form-group">
                                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
                                            <div class="col-lg-4">
                                                <input type="text" class="form-control" name="ref" id="ref" placeholder="ref..." readonly value="<?=$res_hdr['ref']?>">
                                            </div>
                                             
                                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Barang</label>
                                            <div class="col-lg-4">
                                                <input type="text" class="form-control" name="kode_barang" id="kode_barang" placeholder="Barang..." readonly value="<?=$res_hdr['kode_inventori'] . ' - ' . $res_hdr['nama_barang']?>">
                                            </div>
				                                </div>
                                        
                                        <div class="form-group">
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal SPK</label>
                                             <div class="col-lg-4">
                                                <input type="text" name="tgl_buat" id="tgl_buat" class="form-control" autocomplete="off" readonly value="<?php echo strftime("%A, %d %B %Y", strtotime($res_hdr['tgl_buat']))?>"/>
                                             </div>
											 
											 <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal Selesai</label>
                                             <div class="col-lg-4">
                                                <input type="text" name="tgl_buat" id="tgl_buat" class="form-control" autocomplete="off" readonly value="<?php echo strftime("%A, %d %B %Y", strtotime($res_hdr['tgl_selesai']))?>"/>
                                             </div>
                                        </div>   
                                        
                                        <div class="form-group">
                                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Jumlah</label>
                                             <div class="col-lg-4">
												
												<div class="input-group">
                                                <input type="text" name="tgl_buat" id="tgl_buat" class="form-control" autocomplete="off" readonly value="<?php echo number_format($res_hdr['qty'], 2)?>"/>
																	<span class="input-group-addon"><?=$res_hdr['kode_satuan']?></span>
																</div>
                                             </div>
                                        </div> 
                                        
                                        <div class="form-group">
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                                             <div class="col-lg-10">
                                               <textarea  class="form-control" rows="2" name="keterangan_hdr" id="keterangan_hdr" readonly placeholder="Keterangan..."><?=$res_hdr['keterangan_hdr']?></textarea>
                                             </div>
                                        </div> 
                                        
                                        <div class="form-group">
                     	                    <div class="col-lg-12">
                                                <table id="" class="" rules="all">
                                                    <thead>
                                                        <tr>
                                                            <th >No</th>
                                                        <th>Barang</th>
                                                        <th>Standar QTY</th>
                                                        <th>Kebutuhan QTY</th>
                                                        <th>Keterangan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      <?php
                            														$no = 1;
                            														while($res_dtl = mysql_fetch_array($q_spk_dtl)) { 
  													                          ?>
                                                      	<tr>
                                                          	<td style="text-align: center"><?=$no++?></td>
                                                              <td><?=$res_dtl['kode_inventori'] . ' - ' . $res_dtl['nama_barang']?></td>
                                                              <td style="text-align: right;"><?= number_format($res_dtl['q_std'], 2)?> <?=$res_dtl['kode_satuan']?></td>
                                                              <td style="text-align: right;"><?= number_format($res_dtl['q_use'], 2)?> <?=$res_dtl['kode_satuan']?></td>
                                                              <td><?=$res_dtl['keterangan_dtl']?></td>
                                                          </tr>
                                                      <?php } ?>
                                                    </tbody>
                                                </table>
                                    		  </div>
										                    </div>
															
										
										<div class="form-group">
                     	                    <div class="col-lg-12">
												<h3 style="text-align: center">Konsumsi</h3> <hr style="border-top: 2px solid #5615157d;">
                                                <table id="" class="" rules="all">
                                                    <thead>
                                                        <tr>
                                                            <th >No</th>
                                                            <th >Kode Transaksi</th>
                                                            <th >Tanggal</th>
                                                        <th>Barang</th>
                                                        <th>QTY</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      <?php
														if (mysql_num_rows($q_konsumsi) > 0) {
                            														$no = 1;
                            														while($res_dtl = mysql_fetch_array($q_konsumsi)) { 
  													                          ?>
                                                      	<tr>
                                                          	<td style="text-align: center"><?=$no++?></td>
                                                              <td><a  href="<?=base_url()?>?page=logistik/tg_track&action=track&halaman=%20TRACK%20TRANSFER%20GUDANG&kode_tg=<?=$res_dtl['kode_tg']?>" target="_blank"><?=$res_dtl['kode_tg']?></a></td>
                                                              <td><?=strftime("%d/%m/%Y", strtotime($res_hdr['tgl_buat']))?></td>
                                                              <td><?=$res_dtl['kode_inventori'] . ' - ' . $res_dtl['nama_barang']?></td>
                                                              <td style="text-align: right;"><?= number_format($res_dtl['qty_tg_app'], 2)?> <?=$res_dtl['kode_satuan']?></td>
                                                          </tr>
														<?php }} ?>
                                                    </tbody>
                                                </table>
                                    		  </div>
										                    </div>
															
										<div class="form-group">
                     	                    <div class="col-lg-12">
												<h3 style="text-align: center">Hasil Produksi</h3> <hr style="border-top: 2px solid #5615157d;">
                                                <table id="" class="" rules="all">
                                                    <thead>
                                                        <tr>
                                                            <th >No</th>
                                                            <th >Kode Transaksi</th>
                                                            <th >Tanggal</th>
                                                        <th>Barang</th>
                                                        <th>QTY</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      <?php
                            														$no = 1;
                            														while($res_dtl = mysql_fetch_array($q_produksi)) { 
  													                          ?>
                                                      	<tr>
                                                          	<td style="text-align: center"><?=$no++?></td>
                                                              <td><?=$res_dtl['kode_tg']?></td>
                                                              <td><?=strftime("%d/%m/%Y", strtotime($res_hdr['tgl_buat']))?></td>
                                                              <td><?=$res_dtl['kode_inventori'] . ' - ' . $res_dtl['nama_barang']?></td>
                                                              <td style="text-align: right;"><?= number_format($res_dtl['qty_tg_app'], 2)?> <?=$res_dtl['kode_satuan']?></td>
                                                          </tr>
                                                      <?php } ?>
                                                    </tbody>
                                                </table>
                                    		  </div>
										                    </div>
															
										<div class="form-group">
                     	                    <div class="col-lg-12">
												<h3 style="text-align: center">Varian</h3> <hr style="border-top: 2px solid #5615157d;">
                                                <table id="" class="" rules="all">
                                                    <thead>
                                                        <tr>
                                                            <th >No</th>
                                                            <th >Kode Transaksi</th>
                                                            <th >Tanggal</th>
                                                        <th>Barang</th>
                                                        <th>QTY</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      <?php
                            														$no = 1;
                            														while($res_dtl = mysql_fetch_array($q_varian)) { 
  													                          ?>
                                                      	<tr>
                                                          	<td style="text-align: center"><?=$no++?></td>
                                                              <td><?=$res_dtl['kode_tg']?></td>
                                                              <td><?=strftime("%d/%m/%Y", strtotime($res_hdr['tgl_buat']))?></td>
                                                              <td><?=$res_dtl['kode_inventori'] . ' - ' . $res_dtl['nama_barang']?></td>
                                                              <td style="text-align: right;"><?= number_format($res_dtl['qty_tg_app'], 2)?> <?=$res_dtl['kode_satuan']?></td>
                                                          </tr>
                                                      <?php } ?>
                                                    </tbody>
                                                </table>
                                    		  </div>
										                    </div>
                  </div>		
	              </div>
                <!-- /.panel-body -->
              </div>                       
              <!-- /.panel-default -->
            </div>
			    </div>
		    </div>

<!-- ============ MODAL ADD ITEM =============== -->
  <div id="modalAddItem" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><?=$res_hdr['kode_spk']?></h4>
               </div>
               <form id="frm" name="frm"  method="post" action="">
                  <!-- body modal -->                
                  <div class="modal-body" style="min-height: 150px">
                     <div id="pelsup">
                        <input type="hidden" name="tipepelsup" id="tipepelsup" />
                     </div>
                     <div class="control-group">
                        <div class="form-group">
                           <div class="box-body">
                              <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                                 <thead>
                                    <tr>
                                       <th>Kode</th>
                                       <th>Coa</th>
                                       <th style="text-align:right">Debet</th>
                                       <th style="text-align:right">Kredit</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                       $no=1;
                                       $subtot=0;
                                       if(mysql_num_rows($jurnal) > 0) { 
                                       while($row_jurnal = mysql_fetch_array($jurnal)){
                                       ?>     
                                    <tr>
                                       <td><?=$row_jurnal['kode_coa']?></td>
                                       <td><?=$row_jurnal['nama_coa']?></td>
                                       <td style="text-align:right; font-weight:bold"><?=number_format($row_jurnal['debet'], 2)?></td>
                                       <td style="text-align:right; font-weight:bold"><?=number_format($row_jurnal['kredit'], 2)?></td>
                                    </tr>
                                    <?php }
                                            }else{
                                      ?>
                                      <tr>
                                        <td colspan="4" style="text-align:center">Jurnal dengan Kode SPK ini telah dibatalkan !!</td>
                                      </tr>
                                      <?php 
                                        }
                                      ?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- footer modal -->
                  <div class="modal-footer">
                     <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <!---------------------------------------END-------------------------------------------->   

<!-- ============ MODAL PEMBATALAN =============== -->
<div id="modalPembatalan" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #9c0303">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                 <h4 class="modal-title" style="color: white">Pembatalan Kode SPK : <?=$res_hdr['kode_spk']?></h4>
            </div>

            <form id="formPembatalan" method="post" enctype="multipart/form-data">             
                <div class="modal-body" style="min-height: 50px;">
                    <div class="control-group">
                        <div class="form-group">
                      <h4 style="color: black;">Alasan Batal :</h4>
                      <input type="hidden" class="form-control" name="kode_spk_batal" id="kode_spk_batal" value="<?=$res_hdr['kode_spk']?>">
                      <input type="hidden" class="form-control" name="kode_cabang_batal" id="kode_cabang_batal" value="<?=$res_hdr['kode_cabang']?>">
                      <input type="hidden" class="form-control" name="kode_gudang_batal" id="kode_gudang_batal" value="<?=$res_hdr['kode_gudang']?>">
                      <textarea type="text" class="form-control" name="alasan_batal" id="alasan_batal" placeholder="Alasan Batal..."></textarea>
                  </div>
                    </div>
                </div>

                <div class="modal-footer" style="background-color: #9a24241a; border-top: 1px solid #ab5d5d;">
                  <button type="submit" name="batal" id="batal" class="btn btn-default" onclick="return confirm('Anda yakin akan membatalkan Surat Perintah Kerja ini ?')">
                    <i class="fa fa-check" style="color: green"></i> Yes
                  </button>
                  &nbsp;
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close" style="color: red"></i> No</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!---------------------------------------END-------------------------------------------->

<script>
$(document).ready(function (e) {
    $("#formPembatalan").on('submit',(function(e) {
        var alasan_batal = $("#alasan_batal").val();

        e.preventDefault();
        if(alasan_batal != "") {           
            $(".animated").show();
            $.ajax({
                url: "<?=base_url()?>ajax/j_spk.php?func=pembatalan",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(html)
                {
                    var msg = html.split("||");
                    if(msg[0] == "00") {
                        window.location = '<?=base_url()?>?page=produksi/spk&halaman= SURAT PERINTAH KERJA&pembatalan='+msg[1];
                    } else {
                        notifError(msg[1]);
                    }
                    $(".animated").hide();
                } 
                  
           });
        }else{
          alert('Alasan Batal wajib diisi !!');
        }
    }));
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
      })
      
      $(document).ready(function (e) {     
            $(".select2").select2({
              width: '100%'
             });
      });
</script>