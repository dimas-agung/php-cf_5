<?php 	
  include "pages/data/script/pm.php"; 
	include "library/form_akses.php";	
?>
<?php
			// HEADER
			$res_hdr = mysql_fetch_array($q_pm_hdr); 
			$kode_pm = $res_hdr['kode_pm'];
			$status_hdr = $res_hdr['status_hdr'];
			
			$btn_cls = '';
			$btn_tg = '<a href="'.base_url().'?page=logistik/tg&action=pm_to_tg&kode_pm='.$kode_pm.'&halaman= TRANSFER GUDANG" class="btn btn-primary pull-right">Trans. Gudang</a>';
			
			$tg = '';
			$cls = '';
			
			if($status_hdr <> 'open'){
				$tg='';
				$cls='';
			}else{
				$tg=$btn_tg;
				$cls=$btn_cls;
			}
				
				
				if ($status_hdr == 'open'){
                    $status = 'OPEN';
                }elseif($status_hdr == 'cancel'){
                    $status = 'CANCELED';
                }else{
                    $status = 'CLOSE';
                }
	

		?>	
<style>
  .pembatalan {
      background-color: #9c0303;
    }
</style>

<section class="content-header">
    <ol class="breadcrumb">
      <li><i class="fa fa-folder-open"></i> Logistik</a></li>
      <li>Permintaan Material</a></li>
      <li>Track Permintaan Material</a></li>
    </ol>
</section>
        
<section class="content">
  <div class="col-md-4">
    <?php
        $prev = mysql_fetch_array($q_pm_prev); {
        if (isset($prev['id_pm_hdr'])){
      ?>
          <a class="btn btn-warning" href="<?=base_url()?>?page=logistik/pm_track&action=track&halaman= TRACK PERMINTAAN MATERIAL&kode_pm=<?=$prev['kode_pm']?>">
            <i class="fa fa-chevron-left" aria-hidden="true"></i>
          </a>
      <?php
        } 
        } 

        $next = mysql_fetch_array($q_pm_next); {
        if (isset($next['id_pm_hdr'])){
      ?>
          &nbsp;<a class="btn btn-warning" href="<?=base_url()?>?page=logistik/pm_track&action=track&halaman= TRACK PERMINTAAN MATERIAL&kode_pm=<?=$next['kode_pm']?>">
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
  <?php echo $tg; echo '&nbsp';	echo $cls; ?>
    <a href="<?=base_url()?>?page=logistik/pm&halaman= PERMINTAAN MATERIAL" class="btn btn-danger pull-right"><i class="fa fa-reply"></i> BACK</a><br/>
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
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode PM</label>
                                             <div class="col-lg-4">
                                                 <input type="text" class="form-control" name="kode_pm" id="kode_pm" placeholder="Auto..." readonly value="<?=$res_hdr['kode_pm']?>">
                                             </div>
											 
											 <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode SPK</label>
                                             <div class="col-lg-4">
                                                 <input type="text" class="form-control" name="kode_spk" id="kode_spk" placeholder="Auto..." readonly value="<?=$res_hdr['kode_spk']?>">
                                             </div>
                                             
                                             
                                        </div>  
                            
										                    <div class="form-group">
                                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
                                            <div class="col-lg-4">
                                                <input type="text" class="form-control" name="ref" id="ref" placeholder="ref..." readonly value="<?=$res_hdr['ref']?>">
                                            </div>
                                             
                                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal PM</label>
                                             <div class="col-lg-4">
                                                <input type="text" name="tgl_buat" id="tgl_buat" class="form-control" autocomplete="off" readonly value="<?php echo strftime("%A, %d %B %Y", strtotime($res_hdr['tgl_buat']))?>"/>
                                             </div>
				                                </div>
                                        
                                        <div class="form-group">
                                             
											 <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
                                             <div class="col-lg-4">
                                             	<input type="text" required class="form-control" name="cabang" id="cabang" placeholder="Cabang" value="<?=$res_hdr['nama_cabang']?>" readonly>
                                             </div>   
											 
											 <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Gudang Asal</label>
                                             <div class="col-lg-4">
                                                <input type="text" name="kode_gudang_a" id="kode_gudang_a" class="form-control" autocomplete="off" readonly value="<?php echo $res_hdr['nama_gudang_asal'];?>"/>
                                             </div>
                                        </div>   
                                        
                                        <div class="form-group">
                                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Gudang Tujuan</label>
                                             <div class="col-lg-4">
                                                <input type="text" name="kode_gudang_b" id="kode_gudang_b" class="form-control" autocomplete="off" readonly value="<?php echo $res_hdr['nama_gudang_tujuan'];?>"/>
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
                                                        <th >Barang</th>
                                                        <th >QTY</th>
                                                        <th >Keterangan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      <?php
                            														$no = 1;
                            														while($res_dtl = mysql_fetch_array($q_pm_dtl)) { 
  													                          ?>
                                                      	<tr>
                                                          	<td style="text-align: center"><?=$no++?></td>
                                                              <td><?=$res_dtl['kode_inventori'] . ' - ' . $res_dtl['nama_barang']?></td>
                                                              <td style="text-align: right;"><?= number_format($res_dtl['qty'], 2)?> <?=$res_dtl['kode_satuan']?></td>
                                                              <td><?=$res_dtl['keterangan_dtl']?></td>
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