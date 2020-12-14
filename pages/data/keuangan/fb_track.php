<?php 	include "pages/data/script/fb.php"; 
		include "library/form_akses.php";	
?>

<style>
  .pembatalan {
      background-color: #9c0303;
    }
</style>

<section class="content-header">
    <ol class="breadcrumb">
        <li><i class="fa fa-money"></i>Keuangan</a></li>
        <li>Faktur Pembelian</a></li>
        <li>Track Faktur Pembelian</a></li>
    </ol>
</section>
        
<section class="content">
    <div class="col-md-10">
      <?php
        $prev = mysql_fetch_array($q_fb_prev); {
        if (isset($prev['id_fb_hdr'])){
      ?>
          <a class="btn btn-warning" href="<?=base_url()?>?page=keuangan/fb_track&action=track&halaman= TRACK FAKTUR PEMBELIAN&kode_fb=<?=$prev['kode_fb']?>">
            <i class="fa fa-chevron-left" aria-hidden="true"></i>
          </a>
      <?php
        } 
        } 

        $next = mysql_fetch_array($q_fb_next); {
        if (isset($next['id_fb_hdr'])){
      ?>
          &nbsp;<a class="btn btn-warning" href="<?=base_url()?>?page=keuangan/fb_track&action=track&halaman= TRACK FAKTUR PEMBELIAN&kode_fb=<?=$next['kode_fb']?>">
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
      </div>

      <div class="col-lg-2">
        <a href="#modalAddItem" class="btn btn-info" data-toggle="modal"><i class=" fa fa-book"></i> JURNAL</a> 
        &nbsp;
        <a href="<?=base_url()?>?page=keuangan/fb&halaman= FAKTUR PEMBELIAN" class="btn btn-md btn-danger pull-right" ><i class=" fa fa-reply"></i> BACK </a><br/>
      </div>
</section>

<div class="box box-info">
    <div class="box-body">
     	&nbsp;
		<?php
			// HEADER
			$res_hdr = mysql_fetch_array($q_fb_hdr); 

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
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode FB</label>
                                             <div class="col-lg-4">
                                                 <input type="text" class="form-control" name="kode_fb" id="kode_fb" placeholder="Auto..." readonly value="<?=$res_hdr['kode_fb']?>">
                                             </div>
                                             
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Supplier</label>
                                             <div class="col-lg-4">
                                                <select id="kode_supplier" name="kode_supplier" class="select2" style="width: 100%;" disabled>
                                                    <option value="<?php echo $res_hdr['kode_supplier'];?>">
                                                        <?php echo $res_hdr['nama_supplier'];?> 
                                                    </option>
                                                </select>
                                             </div>   
                                        </div>  
                            
										<div class="form-group">
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
                                             <div class="col-lg-4">
                                                 <input type="text" class="form-control" name="ref" id="ref" placeholder="ref..." readonly value="<?=$res_hdr['ref']?>">
                                             </div>
                                             
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal JT</label>
                                             <div class="col-lg-4">
                                                <input type="text" name="tgl_jth_tempo" id="tgl_jth_tempo" class="form-control" readonly value="<?php echo strftime("%A, %d %B %Y", strtotime((!empty($res_hdr['tgl_jth_tempo']) && $res_hdr['tgl_jth_tempo'] !== '0000-00-00' ? $res_hdr['tgl_jth_tempo'] : $res_hdr['tgl_buat'])));?>"/>
                                             </div>
				                        </div>
                                        
                                        <div class="form-group">
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal FB</label>
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
                                                            <th style="width: 10px">No</th>
                                                            <th style="width: 250px">Barang</th>
                                                            <th style="width: 160px">Doc PO</th>
                                                            <th style="width: 160px">Doc BTB</th>
                                                            <th style="width: 150px">Deskripsi</th>
                                                            <th style="width: 150px">Harga</th>
                                                            <th style="width: 150px">PPn</th>
                                                            <th style="width: 150px">Subtotal</th>
                                                            <th>Keterangan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
														$no = 1;
														while($res_dtl = mysql_fetch_array($q_fb_dtl)) { 
													?>
                                                    	<tr>
                                                            <td style="text-align: center"> <?= $no++ ?></td>
                                                            <td><?=$res_dtl['nama_barang']?></td>
                                                            <td><?=$res_dtl['kode_op']?></td>
                                                            <td><?=$res_dtl['kode_btb']?></td>
                                                            <td><?=$res_dtl['deskripsi']?></td>
                                                            <td id="harga" style="text-align: right;"><?= number_format($res_dtl['harga'], 2)?></td>
                                                            <td id="nilai_ppn" style="text-align: right;"><?= number_format($res_dtl['nilai_ppn'], 2)?></td>
                                                            <td id="subtot" style="text-align: right;"><?= number_format($res_dtl['subtot'], 2)?></td>
                                                            <td><?=$res_dtl['keterangan_dtl']?></td>
                                                        </tr>
                                                        
                                                    <?php } ?>
                                                    </tbody>
                                                    <tfoot>
                                                    <?php
                                                        $no = 1;
                                                        while($res_dtl1 = mysql_fetch_array($q_fb_dtl1)) { 
                                                    ?>
                                                        <tr>
                                                            <td colspan="7" style="text-align:right"><b>Subtotal</b></td>
                                                            <td style="text-align:right; font-weight:bold"><?=number_format($res_dtl1['total_harga'], 2)?></td>
                                                            <td></td>
                                                        </tr>
                    
                                                        <tr>
                                                            <td colspan="7" style="text-align:right"><b>PPn</b></td>
                                                            <td style="text-align:right; font-weight:bold"><?=number_format($res_dtl1['total_ppn'], 2)?></td>
                                                            <td></td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td colspan="7" style="text-align:right; font-weight:bold">Total</td>
                                                            <td style="text-align:right; font-weight:bold"><?=number_format($res_dtl1['grand_total'], 2)?></td>
                                                            <td></td>
                                                        </tr>
                                                     <?php } ?>
                                                     
                                                    </tfoot>
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
                  <h4 class="modal-title"><?=$res_hdr['kode_fb']?></h4>
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
                                        <td colspan="4" style="text-align:center">Jurnal dengan Kode FB ini telah dibatalkan !!</td>
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
                 <h4 class="modal-title" style="color: white">Pembatalan Kode FB : <?=$res_hdr['kode_fb']?></h4>
            </div>

            <form id="formPembatalan" method="post" enctype="multipart/form-data">             
                <div class="modal-body" style="min-height: 50px;">
                    <div class="control-group">
                        <div class="form-group">
                      <h4 style="color: black;">Alasan Batal :</h4>
                      <input type="hidden" class="form-control" name="kode_fb_batal" id="kode_fb_batal" value="<?=$res_hdr['kode_fb']?>">
                      <textarea type="text" class="form-control" name="alasan_batal" id="alasan_batal" placeholder="Alasan Batal..."></textarea>
                  </div>
                    </div>
                </div>

                <div class="modal-footer" style="background-color: #9a24241a; border-top: 1px solid #ab5d5d;">
                  <button type="submit" name="batal" id="batal" class="btn btn-default" onclick="return confirm('Anda yakin akan membatalkan Faktur Pembelian ini ?')">
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
                url: "<?=base_url()?>ajax/j_fb.php?func=pembatalan",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(html)
                {
                    var msg = html.split("||");
                    if(msg[0] == "00") {
                        window.location = '<?=base_url()?>?page=keuangan/fb&halaman= FAKTUR PEMBELIAN&pembatalan='+msg[1];
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
