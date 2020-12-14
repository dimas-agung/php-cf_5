<?php 	include "pages/data/script/fj.php"; 
		include "library/form_akses.php";	
?>

<style>
  .pembatalan {
      background-color: #9c0303;
    }
</style>

<section class="content-header">
    <ol class="breadcrumb">
        <li><i class="fa fa-shopping-cart"></i>Penjualan</a></li>
        <li>Faktur Penjualan</a></li>
        <li>Track Faktur Penjualan</a></li>
    </ol>
</section>   

<section class="content">
    <div class="col-md-10">
      <?php
        $prev = mysql_fetch_array($q_fj_prev); {
        if (isset($prev['id_fj_hdr'])){
      ?>
          <a class="btn btn-warning" href="<?=base_url()?>?page=penjualan/fj_track&action=track&halaman= TRACK FAKTUR JUAL&kode_fj=<?=$prev['kode_fj']?>">
            <i class="fa fa-chevron-left" aria-hidden="true"></i>
          </a>
      <?php
        } 
        } 

        $next = mysql_fetch_array($q_fj_next); {
        if (isset($next['id_fj_hdr'])){
      ?>
          &nbsp;<a class="btn btn-warning" href="<?=base_url()?>?page=penjualan/fj_track&action=track&halaman= TRACK FAKTUR JUAL&kode_fj=<?=$next['kode_fj']?>">
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
        <a href="#modalAddItem" class="btn btn-info"  data-toggle="modal"><i class=" fa fa-book"></i> JURNAL</a> 
        &nbsp;
        <a href="<?=base_url()?>?page=penjualan/fj&halaman= FAKTUR PENJUALAN" class="btn btn-md btn-danger pull-right" ><i class=" fa fa-reply"></i> BACK </a><br/>
      </div>
</section>


<div class="box box-info">
    <div class="box-body">
     	&nbsp;
		<?php
			// HEADER
			$res_hdr = mysql_fetch_array($q_fj_hdr); 

            if($res_hdr['status'] == '1'){
                $status = 'OPEN';
              }elseif($res_hdr['status'] == '2'){
                $status = 'DIBATALKAN';
              }else{
                $status = 'LUNAS';
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
                <!-- Kode FJ -->        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode FJ</label>
                                        <div class="col-lg-4">
                                            <input type="text" required class="form-control" name="kode_fj" id="kode_fj" placeholder="Kode FJ..." readonly value="<?=$res_hdr['kode_fj']?>">
                                        </div>
                                     
                <!-- Pelanggan -->      <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Pelanggan</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" id="pelanggan" name="pelanggan" style="width: 100%;" value="<?=$res_hdr['kode_pelanggan'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$res_hdr['nama_pelanggan']?>" placeholder="Pelanggan ..." readonly>
                                        </div>
                                     </div>

                                     <div class="form-group">
                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal FJ</label>
                                         <div class="col-lg-4">
                                            <div class="input-group">
                                             <input type="text" name="tgl_fj" id="tgl_fj" class="form-control" placeholder="Tanggal Faktur Penjualan ..." value="<?=$res_hdr['tgl_buat']?>" autocomplete="off" required disabled/>
                                             <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                            </div>
                                         </div>

                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal JT</label>
                                         <div class="col-lg-4">
                                            <div class="input-group" id="tgl_jt">
                                             <input type="text" name="tgl_jt_tempo" id="tgl_jt_tempo" class="form-control" placeholder="Tanggal Jatuh Tempo ..." value="<?=$res_hdr['tgl_jth_tempo']?>" readonly disabled/>
                                             <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                            </div>
                                         </div> 
                                     </div>

                                     <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
                                         <div class="col-lg-4">
                                             <input type="text" autocomplete="off" required class="form-control" name="ref" id="ref" placeholder="Ref..." value="<?=$res_hdr['ref']?>" readonly>
                                         </div>

                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Salesman</label>
                                         <div class="col-lg-4">
                                             <input class="form-control" id="salesman" name="salesman" style="width: 100%;" value="<?=$res_hdr['salesman']?>" placeholder="Salesman ..." readonly>
                                         </div>
                                     </div>

                                     <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Dokumen SJ</label>
                                         <div class="col-lg-4">
                                            <select id="kode_sj" name="kode_sj" class="select2" style="width: 100%;" disabled>
                                            <option value="<?php echo $res_hdr['kode_sj'];?>">
                                                <?php echo $res_hdr['kode_sj'];?> 
                                            </option>
                                        </select>
                                         </div>
                                     </div>
                                     
                                     <div class="form-group">
                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
                                         <div class="col-lg-4">
                                             <input type="text" class="form-control" id="cabang" name="cabang" style="width: 100%;" value="<?=$res_hdr['kode_cabang'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$res_hdr['nama_cabang']?>" placeholder="Cabang ..." readonly>
                                         </div>
                                     </div>

                                     <div class="form-group">
                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Gudang</label>
                                         <div class="col-lg-4">
                                             <input type="text" class="form-control" id="gudang" name="gudang"  style="width: 100%;" value="<?=$res_hdr['kode_gudang'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$res_hdr['nama_gudang']?>" placeholder="Gudang ..." readonly>
                                         </div>
                                     </div>
                     
                                     <div class="form-group">
                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                                         <div class="col-lg-10">
                                             <textarea type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan..." readonly=""><?=$res_hdr['keterangan_hdr']?></textarea>
                                         </div>
                                     </div>
                                        
                                        <div class="form-group">
                     	                    <div class="col-lg-12">
                                                <table id="" class="" rules="all">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
															<th>Kode</th>
															<th>Deskripsi Barang</th>
															<th>Keterangan</th>
															<th>FOC</th>
															<th>Q Satuan</th>
															<th>Harga Jual</th>
															<th>Disc1(%)</th>
															<th>Disc2(%)</th>
															<th>Disc3(%)</th>
															<th>PPN</th>
															<th>Nominal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
														$no = 1;
                                                        $subtotal_all = 0;
                                                        $diskon_all   = 0;
                                                        $ppn_all      = 0;
                                                        $grand_total  = 0;
														while($res_dtl = mysql_fetch_array($q_fj_dtl)) { 
														$satuan = explode('|', $res_dtl['satuan']);
														$satuan = array_map(function($n) {
															$a = explode(':', $n);
															$n = $a[0];
															$o = $a[1];
															if ($n !== 0 && $o !== '-') {
																return number_format($n, 2) . ' ' . $o;
															}
														}, $satuan);
														$satuan = implode(' | ', array_filter($satuan));
													?>
                                                    	<tr>
                                                            <td style="text-align: center"> <?= $no++ ?></td>
                                                            <td><?=$res_dtl['kode_barang']?></td>
                                                            <td><?=$res_dtl['nama_barang']?></td>
															<td><?=$res_dtl['keterangan_dtl']?></td>
                                                            <td style="text-align: center;">
                                                                <?= $res_dtl['foc']=='1' ? 
                                                                    '<p>
                                                                        <span class="glyphicon glyphicon-check"></span>
                                                                     </p>' 
                                                                     :
                                                                     '<p> 
                                                                        <span class="glyphicon glyphicon-unchecked"></span>
                                                                     </p>'
                                                                 ?> 
                                                            </td>
                                                            <td><?= $satuan?></td>
                                                            <td style="text-align: right;"><?= number_format($res_dtl['harga_jual'], 2)?></td>
                                                            <td style="text-align: right;"><?= number_format($res_dtl['diskon1'], 2)?></td>
                                                            <td style="text-align: right;"><?= number_format($res_dtl['diskon2'], 2)?></td>
                                                            <td style="text-align: right;"><?= number_format($res_dtl['diskon3'], 2)?></td>
                                                            <td style="text-align: center;">
                                                                <?= $res_dtl['ppn']=='1' ? 
                                                                    '<p>
                                                                        <span class="glyphicon glyphicon-check"></span>
                                                                     </p>' 
                                                                     :
                                                                     '<p> 
                                                                        <span class="glyphicon glyphicon-unchecked"></span>
                                                                     </p>'
                                                                 ?> 
                                                            </td>
                                                            <td style="text-align: right;"><?= number_format($res_dtl['total_harga'], 2)?></td>
                                                        </tr>

                                                    <?php 
                                                        $subtotal_all = $res_dtl['grand_total']-$res_dtl['diskon_all']-$res_dtl['ppn_all'];
                                                        $ppn_all      = $res_dtl['ppn_all'];
                                                        $grand_total  = $res_dtl['grand_total'];
                                                      } 
                                                    ?>  

                                                        <tr>
                                                            <td colspan="11" style="text-align:right; font-weight:bold">Subtotal</td>
                                                            <td style="text-align:right ; font-weight:bold"><?= number_format($subtotal_all, 2)?></td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td colspan="11" style="text-align:right; font-weight:bold">PPN</td>
                                                            <td style="text-align:right ; font-weight:bold"><?= number_format($ppn_all, 2)?></td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="11" style="text-align:right; font-weight:bold">Total</td>
                                                            <td style="text-align:right ; font-weight:bold"><?= number_format($grand_total, 2)?></td>
                                                        </tr>
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
                 <h4 class="modal-title">Kode FJ : <?=$res_hdr['kode_fj']?></h4>
            </div>

            <form id="frm" name="frm"  method="post" action="">             
                <div class="modal-body" style="min-height: 150px">
                    <div id="pelsup">
                        <input type="hidden" name="tipepelsup" id="tipepelsup" />
                    </div>
                    <div class="control-group">
                        <div class="form-group">
                            <div class="box-body">
                                <table class="" rules="all">
                                  <thead>
                                      <tr>
                                          <th>KODE</th>
                                          <th>COA</th>
                                          <th style="text-align:right">DEBET</th>
                                          <th style="text-align:right">KREDIT</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php
                                          $no=1;
                                          $subtot=0;
                                          
                                          if(mysql_num_rows($jurnal) > 0) { 
                                          while($row = mysql_fetch_array($jurnal)){
                                        ?>    
                                      <tr>
                                          <td><?=$row['kode_coa']?></td>
                                          <td><?=$row['nama_coa']?></td>
                                          <td style="text-align:right; font-weight:bold"><?=number_format($row['debet'], 2)?></td>
                                          <td style="text-align:right; font-weight:bold"><?=number_format($row['kredit'], 2)?></td>
                                      </tr>
                                      <?php 
                                        }
                                          } else{
                                      ?>
                                      <tr>
                                        <td colspan="4" style="text-align:center">Jurnal dengan Kode FJ ini telah dibatalkan !!</td>
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
                 <h4 class="modal-title" style="color: white">Pembatalan Kode FJ : <?=$res_hdr['kode_fj']?></h4>
            </div>

            <form id="formPembatalan" method="post" enctype="multipart/form-data">             
                <div class="modal-body" style="min-height: 50px;">
                    <div class="control-group">
                        <div class="form-group">
                      <h4 style="color: black;">Alasan Batal :</h4>
                      <input type="hidden" class="form-control" name="kode_fj_batal" id="kode_fj_batal" value="<?=$res_hdr['kode_fj']?>">
                      <!-- <input type="hidden" class="form-control" name="kode_cabang_batal" id="kode_cabang_batal" value="<?=$res_hdr['kode_cabang']?>">
                      <input type="hidden" class="form-control" name="kode_gudang_batal" id="kode_gudang_batal" value="<?=$res_hdr['kode_gudang']?>"> -->
                      <textarea type="text" class="form-control" name="alasan_batal" id="alasan_batal" placeholder="Alasan Batal..."></textarea>
                  </div>
                    </div>
                </div>

                <div class="modal-footer" style="background-color: #9a24241a; border-top: 1px solid #ab5d5d;">
                  <button type="submit" name="batal" id="batal" class="btn btn-default" onclick="return confirm('Anda yakin akan membatalkan Faktur Penjualan ini ?')">
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
                url: "<?=base_url()?>ajax/j_fj.php?func=pembatalan",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(html)
                {
                    var msg = html.split("||");
                    if(msg[0] == "00") {
                        window.location = '<?=base_url()?>?page=penjualan/fj&halaman= FAKTUR PENJUALAN&pembatalan='+msg[1];
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