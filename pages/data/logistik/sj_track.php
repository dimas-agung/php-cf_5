<?php 	
  include "pages/data/script/sj.php"; 
	include "library/form_akses.php";	
?>

<style>
  .pembatalan {
      background-color: #9c0303;
    }
</style>

<section class="content-header">
    <ol class="breadcrumb">
        <li><i class="fa fa-shopping-cart"></i> Logistik</a></li>
        <li>Surat Jalan</a></li>
        <li>Track Surat Jalan</a></li>
    </ol>
</section>        
<section class="content">
      <div class="col-md-10">
      <?php
        $prev = mysql_fetch_array($q_sj_prev); {
        if (isset($prev['id_sj_hdr'])){
      ?>
          <a class="btn btn-warning" href="<?=base_url()?>?page=logistik/sj_track&action=track&halaman= TRACK SURAT JALAN&kode_sj=<?=$prev['kode_sj']?>">
            <i class="fa fa-chevron-left" aria-hidden="true"></i>
          </a>
      <?php
        } 
        } 

        $next = mysql_fetch_array($q_sj_next); {
        if (isset($next['id_sj_hdr'])){
      ?>
          &nbsp;<a class="btn btn-warning" href="<?=base_url()?>?page=logistik/sj_track&action=track&halaman= TRACK SURAT JALAN&kode_sj=<?=$next['kode_sj']?>">
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
        <a href="<?=base_url()?>?page=logistik/sj&halaman= SURAT JALAN" class="btn btn-md btn-danger pull-right" ><i class=" fa fa-reply"></i> BACK </a>
      </div>
</section>


<div class="box box-info">
    <div class="box-body">
     	&nbsp;
		<?php
			// HEADER
			$res_hdr = mysql_fetch_array($q_sj_hdr); 

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
                                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode SJ</label>
                                                <div class="col-lg-4">
                                                   <input type="text" class="form-control" name="kode_sj" id="kode_sj" placeholder="Kode SJ..." value="<?=$res_hdr['kode_sj']?>" autocomplete="off" readonly>
                                                </div>
                                             
                                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Pelanggan</label>
                                            <div class="col-lg-4">
                                                <select id="kode_pelanggan" name="kode_pelanggan" class="select2" style="width: 100%;" disabled>
                                                    <option value="<?php echo $res_hdr['kode_pelanggan'];?>">
                                                        <?php echo $res_hdr['nama_pelanggan'];?> 
                                                    </option>
                                                </select>
                                            </div>  
                                        </div>  

                                        <div class="form-group">
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal</label>
                                                 <div class="col-lg-4">
                                                    <input type="text" class="form-control" name="tgl_buat" id="tgl_buat" placeholder="Tanggal SJ ..." value="<?php echo strftime("%A, %d %B %Y", strtotime($res_hdr['tgl_buat']))?>" autocomplete="off" readonly/>
                                                 </div>

                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Alamat Kirim</label>
                                                 <div class="col-lg-4">
                                                   <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat Kirim..." value="<?=$res_hdr['alamat']?>" autocomplete="off" readonly>
                                                </div> 
                                        </div>   
                            
										                    <div class="form-group">
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
                                                 <div class="col-lg-4">
                                                     <input type="text" class="form-control" name="ref" id="ref" placeholder="ref..." value="<?=$res_hdr['ref']?>" autocomplete="off" readonly>
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
                                                            <th style="width: 150px">Kode SO</th>
                                                            <th style="width: 250px">Nama Barang</th>
                                                            <th style="width: 50px">FOC</th>
                                                            <th style="width: 30%"colspan="3">Quantity Konversi</th>
                                                            <th style="width: 150px">Q Terkirim</th>
                                                            <th style="width: 150px">Keterangan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                          														$no = 1;
                          														while($res_dtl = mysql_fetch_array($q_sj_dtl)) {   
                          													?>
                                                    	<tr>
                                                        	  <td style="text-align: center;"><?=$no++?></td>
                                                            <td><?=$res_dtl['kode_so']?></td>
                                                            <td><?=$res_dtl['kode_inventori'] . ' - ' . $res_dtl['nama_inventori']?></td>
                                                            <td style="text-align: center;"><?=$res_dtl['foc']=='1' ? 
                                                                    '<p>
                                                                        <span class="glyphicon glyphicon-check"></span>&nbsp;
                                                                     </p>' 
                                                                    :
                                                                    '<p> 
                                                                        <span class="glyphicon glyphicon-unchecked"></span>&nbsp;
                                                                    </p>'
                                                                ?> 
                                                            </td>
                                                            <td style="width: 10%">
                                                              <input type="text" class="form-control" placeholder=".. QTY .." style="font-size: 12px; text-align: center" value ="<?php echo number_format($res_dtl['qty_so1'], 2)?>" readonly>
                                                              <input type="text" class="form-control" placeholder=".. Satuan .." style="font-size: 12px; text-align: center" value="<?php echo $res_dtl['satuan_qty_so1']?>" readonly>
                                                            </td>
                                                            <td style="width: 10%"> 
                                                              <input type="text" class="form-control" placeholder=".. QTY .." style="font-size: 12px; text-align: center" value="<?php echo number_format($res_dtl['qty_so2'], 2)?>" readonly>
                                                              <input type="text" class="form-control" placeholder=".. Satuan .." style="font-size: 12px; text-align: center" value="<?php echo $res_dtl['satuan_qty_so2']?>" readonly>
                                                            </td>
                                                            <td style="width: 10%"> 
                                                              <input type="text" class="form-control" placeholder=".. QTY .." style="font-size: 12px; text-align: center" value="<?php echo number_format($res_dtl['qty_so3'], 2)?>" readonly>
                                                              <input type="text" class="form-control" placeholder=".. Satuan .." style="font-size: 12px; text-align: center" value="<?php echo $res_dtl['satuan_qty_so3']?>" readonly>
                                                            </td>
                                                            <td style="width: 10%">
                                                              <input type="text" class="form-control" placeholder=".. QTY .." style="font-size: 12px; text-align: center" value="<?php echo number_format($res_dtl['qty_dikirim'], 2)?>" readonly>
                                                              <input type="text" class="form-control" placeholder=".. Satuan .." style="font-size: 12px; text-align: center" value="<?php echo $res_dtl['satuan_dikirim']?>" readonly>
                                                            </td>
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
                 <h4 class="modal-title">Kode SJ : <?=$res_hdr['kode_sj']?></h4>
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
                                          }else{
                                      ?>
                                      <tr>
                                        <td colspan="4" style="text-align:center">Jurnal dengan Kode SJ ini telah dibatalkan !!</td>
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
                 <h4 class="modal-title" style="color: white">Pembatalan Kode SJ : <?=$res_hdr['kode_sj']?></h4>
            </div>

            <form id="formPembatalan" method="post" enctype="multipart/form-data">             
                <div class="modal-body" style="min-height: 50px;">
                    <div class="control-group">
                        <div class="form-group">
                      <h4 style="color: black;">Alasan Batal :</h4>
                      <input type="hidden" class="form-control" name="kode_sj_batal" id="kode_sj_batal" value="<?=$res_hdr['kode_sj']?>">
                      <input type="hidden" class="form-control" name="kode_cabang_batal" id="kode_cabang_batal" value="<?=$res_hdr['kode_cabang']?>">
                      <input type="hidden" class="form-control" name="kode_gudang_batal" id="kode_gudang_batal" value="<?=$res_hdr['kode_gudang']?>">
                      <textarea type="text" class="form-control" name="alasan_batal" id="alasan_batal" placeholder="Alasan Batal..."></textarea>
                  </div>
                    </div>
                </div>

                <div class="modal-footer" style="background-color: #9a24241a; border-top: 1px solid #ab5d5d;">
                  <button type="submit" name="batal" id="batal" class="btn btn-default" onclick="return confirm('Anda yakin akan membatalkan Surat Jalan ini ?')">
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
                url: "<?=base_url()?>ajax/j_sj.php?func=pembatalan",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(html)
                {
                    var msg = html.split("||");
                    if(msg[0] == "00") {
                        window.location = '<?=base_url()?>?page=logistik/sj&halaman= SURAT JALAN&pembatalan='+msg[1];
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
