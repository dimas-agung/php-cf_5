<?php 	include "pages/data/script/bkm.php"; 
		include "library/form_akses.php";	
?>

<style>
  .pembatalan {
      background-color: #9c0303;
    }
</style>

<?php
			// HEADER
      $pelanggan = '-';
			$res_hdr = mysql_fetch_array($q_bkm_hdr); 

      if($res_hdr['kode_pelanggan'] != ''){
        $pelanggan = $res_hdr['nama_pelanggan'];
      }else{
        $pelanggan = '-';
      }
		?>	
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-shopping-cart"></i>Keuangan</a></li>
        <li><a href="#">Track Bukti Kas Masuk</a></li>
    </ol>
</section>  

<section class="content">
  <div class="col-md-10">
      <?php
        $prev = mysql_fetch_array($q_bkm_prev); {
        if (isset($prev['id_bkm_hdr'])){
      ?>
          <a class="btn btn-warning" href="<?=base_url()?>?page=keuangan/bkm_track&action=track&halaman= TRACK BUKTI KAS MASUK&kode_bkm=<?=$prev['kode_bkm']?>">
            <i class="fa fa-chevron-left" aria-hidden="true"></i>
          </a>
      <?php
        } 
        } 

        $next = mysql_fetch_array($q_bkm_next); {
        if (isset($next['id_bkm_hdr'])){
      ?>
          &nbsp;<a class="btn btn-warning" href="<?=base_url()?>?page=keuangan/bkm_track&action=track&halaman= TRACK BUKTI KAS MASUK&kode_bkm=<?=$next['kode_bkm']?>">
            <i class="fa fa-chevron-right" aria-hidden="true"></i>
          </a>
      <?php
        } 
        }
      ?>
	  <a href="#modalPembatalan" class="btn pembatalan" style="color: white" data-toggle="modal"><i class=" fa fa-close"></i> PEMBATALAN</a>
  </div>

  <div class="col-md-2">
          <a href="#modalAddItem" class="btn btn-info" data-toggle="modal"><i class=" fa fa-book"></i>JURNAL</a>
          &nbsp;
          <a href="<?=base_url()?>?page=keuangan/bkm&halaman= BUKTI KAS MASUK" class="btn btn-danger pull-right" ><i class=" fa fa-reply"></i> BACK </a><br/>
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

                                 	<div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode bkm</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="kode_bkm" id="kode_bkm" placeholder="Auto..." value="<?=$res_hdr['kode_bkm']?>" readonly>
                                        </div>
                                     
                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Pelanggan</label>
                                        <div class="col-lg-4">
                                            <select id="kode_pelanggan" name="kode_pelanggan" class="select2" style="width: 100%;" disabled>
                                                <option value="<?php echo $res_hdr['kode_pelanggan'];?>">
                                                    <?php echo $pelanggan;?> 
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
                                            <div class="col-lg-4">
                                                <input type="text" autocomplete="off" class="form-control" name="ref" id="ref" placeholder="Ref..." value="<?=$res_hdr['ref']?>" readonly>
                                            </div>

                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Metode Pembayaran</label>
                                         <div class="col-lg-4">
                                             <select id="kode_coa" name="kode_coa" class="select2" style="width: 100%;" disabled>
                                                <option value="<?php echo $res_hdr['kode_coa'];?>">
                                                    <?php echo $res_hdr['rekening'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$res_hdr['nama_coa'];?> 
                                                </option>
                                            </select>
                                         </div>
                                         
                                     </div>

                                     <div class="form-group">
                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal</label>
                                         <div class="col-lg-4">
                                            <div class="input-group">
                                             <input type="text" name="tgl_buat" id="tgl_buat" class="form-control" placeholder="Tanggal Bukti Kas Keluar ..." value="<?=strftime("%A, %d %B %Y", strtotime($res_hdr['tgl_buat']))?>" autocomplete="off" readonly/>
                                             <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                            </div>
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
                                             <textarea type="text" class="form-control" name="keterangan_hdr" id="keterangan_hdr" placeholder="Keterangan..." readonly><?=$res_hdr['keterangan_hdr']?></textarea>
                                         </div>
                                     </div>

                                        
                                        <div class="form-group">
                     	                    <div class="col-lg-12">
                                              <table id="simple-table" class="table  table-bordered table-hover">
                                                <thead>
                                                    <?php
                                                        $n=1;
                                                    ?>
                                                    <tr>
                                                        <th style="width: 25px">No</th>
                                                        <th style="width:180px">Deskripsi</th>
                                                        <th style="width:180px">Saldo Transaksi</th>
                                                        <th style="width:180px">Nominal Bayar</th>
                                                        <th style="width:180px">Nominal Pelunasan</th>
                                                        <th style="width:180px">Selisih</th>
                                                        <th style="width:250px">COA</th>
                                                        <th style="width:230px">Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
														                            $no = 1;
                                                        $total = '';
                                                        $subtotal = '';
														                            
                                                        while($res_dtl = mysql_fetch_array($q_bkm_dtl)) { 
                                                        $total = $res_dtl['nominal_bayar'];

                                                        $subtotal += $total;
													                          ?>
                                                    	<tr>
                                                          <td style="text-align: center"><?=$no++?></td>
                                                          <td><?=$res_dtl['deskripsi']?></td>
                                                          <td style="text-align: right"><?= number_format($res_dtl['saldo_transaksi'], 2)?></td>
                                                          <td style="text-align: right"><?= number_format($res_dtl['nominal_bayar'], 2)?></td>
                                                          <td style="text-align: right"><?= number_format($res_dtl['nominal_pelunasan'], 2)?></td>
                                                          <td style="text-align: right"><?= number_format($res_dtl['selisih'], 2)?></td>
                                                          <td><?=$res_dtl['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$res_dtl['nama_coa']?></td>
                                                          <td><?=$res_dtl['keterangan_dtl']?></td>
                                                      </tr>
                                                    <?php } ?>   
                                                      <tr>
                                                          <td colspan="3" style="text-align:right"><b>Subtotal</b></td>
                                                          <td style="text-align:right; font-weight: bold;"><?= number_format($subtotal, 2)?></td>
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                      </tr>
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
                 <h4 class="modal-title"><?=$res_hdr['kode_bkm']?></h4>
            </div>

            <form id="frm" name="frm"  method="post" action="">             
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
                                          <th>KODE</th>
                                          <th>COA</th>
                                          <th style="text-align:right">DEBET</th>
                                          <th style="text-align:right">KREDIT</th>
                                      </tr>
                                  </thead>
                                  <tbody>
								  
                                      <?php
									  if ($res_hdr['status'] != '1') {
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
                                          }
									  } else {										  
                                        ?>
									  <tr>
                                          <td colspan="4" style="text-align:center">Jurnal di batalkan</td>
                                      </tr>										
									  <?php } ?>
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
                 <h4 class="modal-title" style="color: white">Pembatalan Kode BKM : <?=$res_hdr['kode_bkm']?></h4>
            </div>

            <form id="formPembatalan" method="post" enctype="multipart/form-data">             
                <div class="modal-body" style="min-height: 50px;">
                    <div class="control-group">
                        <div class="form-group">
                      <h4 style="color: black;">Alasan Batal :</h4>
                      <input type="hidden" class="form-control" name="kode_bkm_batal" id="kode_bkm_batal" value="<?=$res_hdr['kode_bkm']?>">
                      <textarea type="text" class="form-control" name="alasan_batal" id="alasan_batal" placeholder="Alasan Batal..."></textarea>
                  </div>
                    </div>
                </div>

                <div class="modal-footer" style="background-color: #9a24241a; border-top: 1px solid #ab5d5d;">
                  <button type="submit" name="batal" id="batal" class="btn btn-default" onclick="return confirm('Anda yakin akan membatalkan Bukti Kas Masuk ini ?')">
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
                url: "<?=base_url()?>ajax/j_bkm.php?func=pembatalan",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(html)
                {
                    var msg = html.split("||");
                    if(msg[0] == "00") {
                        window.location = '<?=base_url()?>?page=keuangan/bkm&halaman= BUKTI KAS KELUAR&pembatalan='+msg[1];
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
    width: 1500px;
    border: 1px solid #DCDCDC;
  }

  th {
      background: #87CEFA;
      text-align: center;
      color: #000000;
      padding: 8px;
      font-size: 14px;   
  }

  td {
      text-align: left;
      padding: 8px;
      font-size: 12px;
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