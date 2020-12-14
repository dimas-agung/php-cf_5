<?php 	
  include "pages/data/script/gm.php"; 
	include "library/form_akses.php";	
?>

<style>
  .pm-min, .pm-min-s{padding:3px 1px; }
  .animated{display:none;}

  table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    border: 1px solid #3c4f5f;
  }

  th {
      background: #87CEFA;
      text-align: center;
      color: #000000;
      padding: 8px;
      font-size: 13px;
  }

  td {
      text-align: left;
      padding: 8px;
      font-size: 13px;
  }

  tr:nth-child(even){background-color: #f2f2f2}

  p {
    font-size: 8px;
  }

  .pembatalan {
      background-color: #9c0303;
    }
  .pengembalian {
      background-color: #20b158;
    }
</style>

<section class="content-header">
    <ol class="breadcrumb">
        <li><i class="fa fa-money"></i> Keuangan</li>
        <li>Giro Masuk</li>
        <li>Track Giro Masuk</li>
    </ol>
</section>
        
<section class="content">
    <div class="col-md-10">
      <?php
        $prev = mysql_fetch_array($q_gm_prev); {
        if (isset($prev['id_gm_hdr'])){
      ?>
          <a class="btn btn-warning" href="<?=base_url()?>?page=keuangan/gm_track&action=track&halaman= TRACK GIRO MASUK&kode_gm=<?=$prev['kode_gm']?>">
            <i class="fa fa-chevron-left" aria-hidden="true"></i>
          </a>
      <?php
        } 
        } 

        $next = mysql_fetch_array($q_gm_next); {
        if (isset($next['id_gm_hdr'])){
      ?>
          &nbsp;<a class="btn btn-warning" href="<?=base_url()?>?page=keuangan/gm_track&action=track&halaman= TRACK GIRO MASUK&kode_gm=<?=$next['kode_gm']?>">
            <i class="fa fa-chevron-right" aria-hidden="true"></i>
          </a>
      <?php
        } 
        }
      ?>
        &nbsp;
        <?php
          $stat = mysql_fetch_array($status); 
          if($stat['status'] == '1'){
            $status1 = '';
            $status2 = 'hidden';
          }elseif($stat['status'] == '2'){
            $status1 = 'hidden';
            $status2 = '';
          }else{
            $status1 = 'hidden';
            $status2 = 'hidden';
          }
        ?>
          <!-- <a href="#modalPembatalan" class="btn pembatalan <?php echo $status1?>" style="color: white" data-toggle="modal"><i class=" fa fa-close"></i> PEMBATALAN</a> -->
          <a href="<?=base_url()?>?page=keuangan/gm_back&action=pengembalian&halaman= PENGEMBALIAN GIRO MASUK&kode_gm=<?=$stat['kode_gm']?>" class="btn pengembalian <?php echo $status2?>" style="color: white"><i class=" fa fa-retweet"></i> PENGEMBALIAN</a>
      </div>
      <div class="col-md-2">
        <a href="#modalAddItem" class="btn btn-info" data-toggle="modal"><i class=" fa fa-book"></i> JURNAL</a> 
        &nbsp;
        <a href="<?=base_url()?>?page=keuangan/gm&halaman= GIRO MASUK" class="btn btn-danger pull-right" ><i class=" fa fa-reply"></i> BACK</a>
      </div>
</section>

<div class="box box-info">
    <div class="box-body">
     	&nbsp;
		<?php
			// HEADER
			$res_hdr = mysql_fetch_array($q_gm_hdr); 

      if($res_hdr['status'] == '1'){
        $status = 'OPEN / MENUNGGU PELUNASAN';
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
                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode GM</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="kode_gm" id="kode_gm" placeholder="Kode GM ..." readonly value="<?=$res_hdr['kode_gm']?>">
                                </div>

                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
                                <div class="col-lg-4">
                                    <select id="kode_cabang" name="kode_cabang" class="select2" style="width: 100%;" disabled>
                                      <option value="<?php echo $res_hdr['kode_cabang'];?>">
                                        <?php echo $res_hdr['kode_cabang'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$res_hdr['nama_cabang'];?> 
                                      </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                              <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
                              <div class="col-lg-4">
                                  <input type="text" autocomplete="off" class="form-control" name="ref" id="ref" placeholder="Ref..." value="<?=$res_hdr['ref']?>" readonly>
                              </div>

                              <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Pelanggan</label>
                              <div class="col-lg-4">
                                <select id="kode_pelanggan" name="kode_pelanggan" class="select2" style="width: 100%;" disabled>
                                  <option value="<?php echo $res_hdr['kode_pelanggan'];?>">
                                                  <?php echo $res_hdr['kode_pelanggan'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$res_hdr['nama_pelanggan'];?> 
                                  </option>
                                </select>
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal Buat</label>
                                <div class="col-lg-4">
                                  <div class="input-group">
                                      <input type="text" name="tgl_buat" id="tgl_buat" class="form-control" placeholder="Tanggal Bukti Kas Keluar ..." value="<?=$res_hdr['tgl_buat']?>" autocomplete="off" readonly/>
                                      <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                    </div>
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
                                                        <th>Deskripsi</th>
                                                        <th>Saldo Transaksi</th>
                                                        <th>Nominal Bayar</th>
                                                        <th>Nominal Pelunasan</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
														                            $no = 1;
                                                        $total = '';
                                                        $subtotal1 = '';
                                                        $subtotal2 = '';
														                            
                                                        while($res_dtl = mysql_fetch_array($q_gm_dtl)) { 
                                                        $total1 = $res_dtl['nominal_bayar'];
                                                        $total2 = $res_dtl['nominal_pelunasan'];

                                                        $subtotal1 += $total1;
                                                        $subtotal2 += $total2;
													                          ?>
                                                    	<tr>
                                                          <td style="text-align: center"><?=$no++?></td>
                                                          <td><?=$res_dtl['deskripsi']?></td>
                                                          <td style="text-align: right"><?= number_format($res_dtl['saldo_transaksi'], 2)?></td>
                                                          <td style="text-align: right"><?= number_format($res_dtl['nominal_bayar'], 2)?></td>
                                                          <td style="text-align: right"><?= number_format($res_dtl['nominal_pelunasan'], 2)?></td>
                                                          <td><?=$res_dtl['keterangan_dtl']?></td>
                                                      </tr>
                                                    <?php } ?>   
                                                      <tr>
                                                          <td colspan="3" style="text-align:right"><b>Subtotal</b></td>
                                                          <td style="text-align:right; font-weight: bold;"><?= number_format($subtotal1, 2)?></td>
                                                          <td style="text-align:right; font-weight: bold;"><?= number_format($subtotal2, 2)?></td>
                                                          <td></td>
                                                      </tr>
                                                </tbody>
                                              </table>
                                      		</div>
  										                  </div>

                                        <div class="form-group">
                                        <div class="col-lg-5"></div>
                                        <div class="col-lg-1">
                                          <label style="margin-top: 6px;" class="pull-right">Selisih : </label>
                                        </div>
                                        <div class="col-lg-2">                                    
                                            <input class="form-control" type="text" name="selisih" id="selisih" value="<?= number_format($res_hdr['selisih'], 2)?>" style="text-align:right" readonly/>
                                        </div>  
                                        <div class="col-lg-4"> 
                                            <select id="kode_coa_selisih" name="kode_coa_selisih" class="select2" disabled>
                                                <option value=""> 
                                                  <?php 
                                                    if($res_hdr['selisih'] != 0){
                                                      echo $res_hdr['kode_coa_selisih'];
                                                    }else{
                                                      echo "Tidak ada Kode Coa Selisih";
                                                    } 
                                                  ?>
                                                </option>
                                            </select>
                                        </div>
                                    </div>  

                                    <div class="form-group">
                                      <div class="col-lg-12">
                                          <table id="tabel_giro" class="table table-striped table-bordered table-hover" width="100%">
                                              <thead>
                                                  <tr>
                                                      <th>Bank Giro</th>
                                                      <th>No Giro</th>
                                                      <th>Tanggal Giro</th>
                                                      <th>Nominal</th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                                 <?php
                                                        $no = 1;
                                                        $total = '';
                                                        $subtotal = '';
                                                        
                                                        while($res_giro = mysql_fetch_array($q_giro)) { 
                                                        $total = $res_giro['nominal'];
                                                        $subtotal += $total;
                                                    ?>
                                                      <tr>
                                                          <td><?=$res_giro['bank_giro']?></td>
                                                          <td><?=$res_giro['no_giro']?></td>
                                                          <td><?=$res_giro['tgl_giro']?></td>
                                                          <td style="text-align: right"><?= number_format($res_giro['nominal'], 2)?></td>
                                                      </tr>
                                                    <?php } ?>   
                                                      <tr>
                                                          <td colspan="3" style="text-align:right"><b>Subtotal</b></td>
                                                          <td style="text-align:right; font-weight: bold;"><?= number_format($subtotal, 2)?></td>
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
                 <h4 class="modal-title">Kode GM : <?=$res_hdr['kode_gm']?></h4>
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
                                        <td colspan="4" style="text-align:center">Jurnal dengan Kode GM ini telah dibatalkan !!</td>
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

                <!-- <h5 style="text-align: center">JURNAL MENYUSUL ^^</h5> -->
                  
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
                 <h4 class="modal-title" style="color: white">Pembatalan Kode GM : <?=$res_hdr['kode_gm']?></h4>
            </div>

            <form id="formPembatalan" method="post" enctype="multipart/form-data">             
                <div class="modal-body" style="min-height: 50px;">
                    <div class="control-group">
                        <div class="form-group">
                      <h4 style="color: black;">Alasan Batal :</h4>
                      <input type="hidden" class="form-control" name="kode_gm_batal" id="kode_gm_batal" value="<?=$res_hdr['kode_gm']?>">
                      <input type="hidden" class="form-control" name="kode_cabang_batal" id="kode_cabang_batal" value="<?=$res_hdr['kode_cabang']?>">
                      <input type="hidden" class="form-control" name="kode_pelanggan_batal" id="kode_pelanggan_batal" value="<?=$res_hdr['kode_pelanggan']?>">
                      <textarea type="text" class="form-control" name="alasan_batal" id="alasan_batal" placeholder="Alasan Batal..."></textarea>
                  </div>
                    </div>
                </div>

                <div class="modal-footer" style="background-color: #9a24241a; border-top: 1px solid #ab5d5d;">
                  <button type="submit" name="batal" id="batal" class="btn btn-default" onclick="return confirm('Anda yakin akan membatalkan Giro Masuk ini ?')">
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
                url: "<?=base_url()?>ajax/j_gm.php?func=pembatalan",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(html)
                {
                    var msg = html.split("||");
                    if(msg[0] == "00") {
                        window.location = '<?=base_url()?>?page=keuangan/gm&halaman= GIRO MASUK&pembatalan='+msg[1];
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