<?php 	
    include "pages/data/script/tg.php"; 
	include "library/form_akses.php";	
?>

<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-shopping-cart"></i> Logistik</a></li>
        <li><a href="#">Track Transfer Gudang</a></li>
    </ol>
        
    <section class="content">
		<div class="col-md-10">
      <?php
        $prev = mysql_fetch_array($q_tg_prev); {
        if (isset($prev['id_tg_hdr'])){
      ?>
          <a class="btn btn-warning" href="<?=base_url()?>?page=logistik/tg_track&action=track&halaman=%20TRACK%20TRANSFER%20GUDANG&kode_tg=<?=$prev['kode_tg']?>">
            <i class="fa fa-chevron-left" aria-hidden="true"></i>
          </a>
      <?php
        } 
        } 

        $next = mysql_fetch_array($q_tg_next); {
        if (isset($next['id_tg_hdr'])){
      ?>
          &nbsp;<a class="btn btn-warning" href="<?=base_url()?>?page=logistik/tg_track&action=track&halaman=%20TRACK%20TRANSFER%20GUDANG&kode_tg=<?=$next['kode_tg']?>">
            <i class="fa fa-chevron-right" aria-hidden="true"></i>
          </a>
      <?php
        } 
        }
      ?>
  </div>
  
		<div class="col-md-2">
          <a href="#modalAddItem" class="btn btn-info" data-toggle="modal"><i class=" fa fa-book"></i>JURNAL</a>
          &nbsp;
          <a href="<?=base_url()?>?page=logistik/tg&halaman=%20TRANSFER%20GUDANG" class="btn btn-danger pull-right" ><i class=" fa fa-reply"></i> BACK </a><br/>
  </div>
   </section>
</section>
<br><br>
<div class="box box-info">
    <div class="box-body">
        <?php
		    if(isset($_GET['action']) and $_GET['action'] == "track") {

                $kode_tg = ($_GET['kode_tg']);
                
                $res_hdr = mysql_fetch_array($q_tg_hdr); 
            }
        ?>

<div class="row">
    <div class="tab-content">
		<div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-horizontal">

                        <div class="form-group">
                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode TG</label>
                            <div class="col-lg-4">
                                <input type="text" required class="form-control" name="kode_tg" id="kode_tg" placeholder="Auto..." readonly value="<?php echo $res_hdr['kode_tg'];?>">
                            </div>

                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
                            <div class="col-lg-4">
                                <input type="text" required class="form-control" name="ref" id="ref" placeholder="Ref..." value="<?php echo $res_hdr['ref'];?>" autocomplete="off" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal</label>
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <input type="text" name="tgl_buat" id="tgl_buat" class="form-control" placeholder="Tanggal Transfer Gudang ..." value="<?php echo strftime("%A, %d %B %Y", strtotime($res_hdr['tgl_buat']))?>" autocomplete="off" required readonly/>
                                        <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                </div>
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
                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Gudang Asal</label>
                            <div class="col-lg-4" id="load_gudang">
                                <select id="kode_gudang_asal" name="kode_gudang_asal" class="select2" style="width: 100%;" disabled>
                                    <option value="<?php echo $res_hdr['kode_gudang_from'];?>">
                                        <?php echo $res_hdr['nama_gudang_from'];?> 
                                    </option>
                                </select>
                            </div> 

                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Gudang Tujuan</label>
                            <div class="col-lg-4" id="load_gudang">
                                <select id="kode_gudang_tujuan" name="kode_gudang_tujuan" class="select2" style="width: 100%;" disabled>
                                    <option value="<?php echo $res_hdr['kode_gudang_to'];?>">
                                        <?php echo $res_hdr['nama_gudang_to'];?> 
                                    </option>
                                 </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                            <div class="col-lg-10">
                                <textarea type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan..." value="" readonly><?=$res_hdr['keterangan_hdr']?></textarea>
                            </div>
                        </div>
                                        
                        <div class="form-group">
                     	    <div class="col-lg-12">
                                <table id="" class="" rules="all">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px;">No</th>
                                            <th style="width: 250px;">Barang</th>
                                            <th style="width: 150px;">QTY</th>
                                            <th style="width: 150px;">QTY Transfer</th>
                                            <th style="width: 150px;">Harga Rata-Rata</th>
                                            <th style="width: 150px;">Total</th>
                                            <th style="width: 200px;">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; while($res_dtl = mysql_fetch_array($q_tg_dtl)) { ;?>  
                                            <tr>
                                                <td><?php echo $no++ ?></td>
                                                <td><?php echo $res_dtl['kode_inventori'] . ' - ' . $res_dtl['nama_barang']; ?></td>
                                                <td style="text-align: right;"><?php echo number_format($res_dtl['qty'], 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($res_dtl['qty_tg_app'], 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($res_dtl['hpp'], 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($res_dtl['total_app_qty'], 2); ?></td>
                                                <td><?php echo $res_dtl['keterangan_dtl']; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>    
                            </div>
						            </div>
                    </div>		
	             </div>
            </div>                       
        </div>
	 </div>
</div>

<!-- ============ MODAL ADD ITEM =============== -->
<div id="modalAddItem" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                 <h4 class="modal-title"><?=$res_hdr['kode_tg']?></h4>
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
									  if ($res_hdr['status_hdr'] != '1') {
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