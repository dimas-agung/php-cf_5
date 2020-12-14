<?php 	
  include "pages/data/script/btb.php"; 
	include "library/form_akses.php";	
?>

<style>
  .pembatalan {
      background-color: #9c0303;
    }
</style>

<section class="content-header">
    <ol class="breadcrumb">
      <li><i class="fa fa-folder-open"></i> Logistik</a></li>
      <li>Bukti Terima Barang</a></li>
      <li>Track Bukti Terima Barang</a></li>
    </ol>
</section>
        
<section class="content">
  <div class="col-md-10">
    <?php
        $prev = mysql_fetch_array($q_btb_prev); {
        if (isset($prev['id_btb_hdr'])){
      ?>
          <a class="btn btn-warning" href="<?=base_url()?>?page=logistik/btb_track&action=track&halaman= TRACK BUKTI TERIMA BARANG&kode_btb=<?=$prev['kode_btb']?>">
            <i class="fa fa-chevron-left" aria-hidden="true"></i>
          </a>
      <?php
        } 
        } 

        $next = mysql_fetch_array($q_btb_next); {
        if (isset($next['id_btb_hdr'])){
      ?>
          &nbsp;<a class="btn btn-warning" href="<?=base_url()?>?page=logistik/btb_track&action=track&halaman= TRACK BUKTI TERIMA BARANG&kode_btb=<?=$next['kode_btb']?>">
            <i class="fa fa-chevron-right" aria-hidden="true"></i>
          </a>
    <?php
        } 
        }
    ?>

      &nbsp;
       <?php
          $stat = mysql_fetch_array($status); 
          if($stat['status'] != '1'){
            $status= 'hidden';
          }
       ?>
        <a href="#modalPembatalan" class="btn pembatalan <?= $status;?>" style="color: white" data-toggle="modal"><i class=" fa fa-close"></i> PEMBATALAN</a>
        <a href="#tutupmanual" class="btn clsman <?= $status;?>" style="color: white" data-toggle="modal"><i class=" fa fa-close"></i> TUTUP MANUAL</a>
  </div>

  <div class="col-md-2">
    <a href="#modalAddItem" class="btn btn-info"  data-toggle="modal"><i class=" fa fa-book"></i> JURNAL</a>
    <a href="<?=base_url()?>?page=logistik/btb&halaman= BUKTI TERIMA BARANG" class="btn btn-danger pull-right"><i class="fa fa-reply"></i> BACK</a><br/>
  </div>
</section>

<div class="box box-info">
    <div class="box-body">
     	&nbsp;
		<?php
			// HEADER
			$res_hdr = mysql_fetch_array($q_btb_hdr); 

                if ($res_hdr['status'] == '1'){
                    $status = 'OPEN';
                }elseif($res_hdr['status'] == '2'){
                    $status = 'DIBATALKAN';
                }else{
                    $status = 'CLOSE';
                }
		?>	

				<div class="row">
					<div class="tab-content">
						<div class="col-lg-12">
              <div class="panel panel-default">
                <div class="panel-body">
                  <div class="form-horizontal">
                                        <h3 style="text-align: center"><?php echo $status ?></h3> <hr style="border-top: 2px solid #5615157d;">

                                 	      <div class="form-group">
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode BTB</label>
                                             <div class="col-lg-4">
                                                 <input type="text" class="form-control" name="kode_btb" id="kode_btb" placeholder="Auto..." readonly value="<?=$res_hdr['kode_btb']?>">
                                             </div>
                                             
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Supplier</label>
                                             <div class="col-lg-4">
                                             	<input type="text" required class="form-control" name="supplier" id="supplier" placeholder="Pilih DOC OP dahulu ..." value="<?=$res_hdr['nama_supplier']?>" readonly>
                                             </div>   
                                        </div>  
                            
										                    <div class="form-group">
                                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
                                            <div class="col-lg-4">
                                                <input type="text" class="form-control" name="ref" id="ref" placeholder="ref..." readonly value="<?=$res_hdr['ref']?>">
                                            </div>
                                             
                                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Gudang</label>
                                            <div class="col-lg-4">
                                                <select id="kode_gudang" name="kode_gudang" class="select2" style="width: 100%;" disabled>
                                                    <option value="<?php echo $res_hdr['kode_gudang'];?>">
                                                        <?php echo $res_hdr['nama_gudang'];?> 
                                                    </option>
                                                </select>
                                            </div>
				                                </div>
                                        
                                        <div class="form-group">
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal BTB</label>
                                             <div class="col-lg-4">
                                                <input type="text" name="tgl_buat" id="tgl_buat" class="form-control" autocomplete="off" readonly value="<?php echo strftime("%A, %d %B %Y", strtotime($res_hdr['tgl_buat']))?>"/>
                                             </div>
                                        </div>   
                                        
                                        <div class="form-group">
                                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
                                            <div class="col-lg-4">
                                                <select id="kode_cabang" name="kode_cabang" class="select2" style="width: 100%;" disabled>
                                                    <option value="<?php echo $res_hdr['kode_cabang'];?>">
                                                        <?php echo $res_hdr['nama_cabang'];?> 
                                                    </option>
                                                </select>
                                            </div>
                                        </div> 

                                        <div class="form-group">
                                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">DOC OP</label>
                                            <div class="col-lg-4">
                                                <select id="kode_op" name="kode_op" class="select2" style="width: 100%;" disabled>
                                                    <option value="<?php echo $res_hdr['kode_op'];?>">
                                                        <?php echo $res_hdr['kode_op'];?> 
                                                    </option>
                                                </select>
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
                                                            <th>No</th>
                                                            <th>Nama Barang</th>
                                                            <th>QTY Belum Di Terima</th>
                                                            <th>QTY Terima Barang</th>
                                                            <th>Keterangan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      <?php
                            														$no = 1;
                            														while($res_dtl = mysql_fetch_array($q_btb_dtl)) { 
                                                          $qty = $res_dtl['qty_i'];
                                                          // $qty_isian = $qty*$res_dtl['qty'];
                                                          // $qty_op = $res_dtl['qty_op']/$qty_isian;

                                                          $qty_op = $res_dtl['qty_op'];
                                                          $qty_op = ($qty_op/$res_dtl['qty']) * $qty;
  													                          ?>
                                                      	<tr>
                                                          	<td style="text-align: center"><?=$no++?></td>
                                                              <td><?=$res_dtl['nama_barang']?></td>
                                                              <td style="text-align: right;"><?= number_format($qty_op, 2)?> <?=$res_dtl['nama_satuan']?></td>
                                                              <td style="text-align: right;"><?= number_format($qty, 2)?> <?=$res_dtl['nama_satuan']?></td>
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
                  <h4 class="modal-title"><?=$res_hdr['kode_btb']?></h4>
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
                                        <td colspan="4" style="text-align:center">Jurnal dengan Kode BTB ini telah dibatalkan !!</td>
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
                 <h4 class="modal-title" style="color: white">Pembatalan Kode BTB : <?=$res_hdr['kode_btb']?></h4>
            </div>

            <form id="formPembatalan" method="post" enctype="multipart/form-data">             
                <div class="modal-body" style="min-height: 50px;">
                    <div class="control-group">
                        <div class="form-group">
                      <h4 style="color: black;">Alasan Batal :</h4>
                      <input type="hidden" class="form-control" name="kode_btb_batal" id="kode_btb_batal" value="<?=$res_hdr['kode_btb']?>">
                      <input type="hidden" class="form-control" name="kode_cabang_batal" id="kode_cabang_batal" value="<?=$res_hdr['kode_cabang']?>">
                      <input type="hidden" class="form-control" name="kode_gudang_batal" id="kode_gudang_batal" value="<?=$res_hdr['kode_gudang']?>">
                      <textarea type="text" class="form-control" name="alasan_batal" id="alasan_batal" placeholder="Alasan Batal..."></textarea>
                  </div>
                    </div>
                </div>

                <div class="modal-footer" style="background-color: #9a24241a; border-top: 1px solid #ab5d5d;">
                  <button type="submit" name="batal" id="batal" class="btn btn-default" onclick="return confirm('Anda yakin akan membatalkan Bukti Terima Barang ini ?')">
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
                url: "<?=base_url()?>ajax/j_btb.php?func=pembatalan",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(html)
                {
                    var msg = html.split("||");
                    if(msg[0] == "00") {
                        window.location = '<?=base_url()?>?page=logistik/btb&halaman= BUKTI TERIMA BARANG&pembatalan='+msg[1];
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