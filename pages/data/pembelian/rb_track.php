<?php 	
    include "pages/data/script/rb.php"; 
	include "library/form_akses.php";	
?>

<style type="text/css">
     .pembatalan {
      background-color: #9c0303;
    }
</style>

<section class="content-header">
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-shopping-cart"></i> Pembelian</a></li>
          <li><a href="#">Track Nota Retur Pembelian</a></li>
        </ol>
</section>        
<section class="content">
    <div class="col-md-10">
              <?php
                $prev = mysql_fetch_array($q_rb_prev); {
                if (isset($prev['id_rb_hdr'])){
              ?>
                  <a class="btn btn-warning" href="<?=base_url()?>?page=pembelian/rb_track&action=track&halaman= TRACK NOTA RETUR PEMBELIAN&kode_rb=<?=$prev['kode_rb']?>">
                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                  </a>
              <?php
                } 
                } 

                $next = mysql_fetch_array($q_rb_next); {
                if (isset($next['id_rb_hdr'])){
              ?>
                  &nbsp;<a class="btn btn-warning" href="<?=base_url()?>?page=pembelian/rb_track&action=track&halaman= TRACK NOTA RETUR PEMBELIAN&kode_rb=<?=$next['kode_rb']?>">
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
    <div class="col-md-2">
        <a href="#modalAddItem" class="btn btn-info"  data-toggle="modal"><i class=" fa fa-book"></i> JURNAL</a> 
        &nbsp;
        <a href="<?=base_url()?>?page=pembelian/rb&halaman= NOTA RETUR PEMBELIAN" class="btn btn-md btn-danger pull-right" ><i class=" fa fa-reply"></i> BACK</a>
    </div>    
        <br />
</section>


            <!-- /.row -->
            <div class="box box-info">
            <div class="box-body">
     		&nbsp;
			<?php
    			// HEADER
    			$res_hdr = mysql_fetch_array($q_rb_hdr); 

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
                                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode RB</label>
                                            <div class="col-lg-4">
                                                <input type="text" class="form-control" name="kode_rb" id="kode_rb" placeholder="Kode ..." readonly value="<?=$res_hdr['kode_rb'];?>">
                                            </div>

                                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
                                            <div class="col-lg-4">
                                                <input type="text" class="form-control" name="ref" id="ref" placeholder="Ref..." value="<?=$res_hdr['ref'];?>" readonly />
                                            </div>
                                    </div>
                                             
                                    <div class="form-group">
                                        <label style="text-align:left" class="col-lg-2 col-sm-2 control-label">Tanggal RB</label>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                <input class="form-control date-picker" value="<?=$res_hdr['tgl_buat'];?>" type="text" placeholder="Tanggal ..." readonly/>
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar bigger-110"></i>
                                                </span>
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
                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Gudang</label>
                                        <div class="col-lg-4">
                                            <select id="kode_gudang" name="kode_gudang" class="select2" style="width: 100%;" disabled>
                                                <option value="<?php echo $res_hdr['kode_gudang'];?>">
                                                    <?php echo $res_hdr['kode_gudang'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$res_hdr['nama_gudang'];?> 
                                                </option>
                                            </select>
                                        </div>

                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Supplier</label>
                                        <div class="col-lg-4">
                                            <select id="kode_supplier" name="kode_supplier" class="select2" style="width: 100%;" disabled>
                                                <option value="<?php echo $res_hdr['kode_supplier'];?>">
                                                    <?php echo $res_hdr['kode_supplier'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$res_hdr['nama_supplier'];?> 
                                                </option>
                                            </select>
                                        </div>
                                    </div>  
                                        
                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                                        <div class="col-lg-10">
                                            <textarea  class="form-control" name="keterangan_hdr" id="keterangan_hdr" placeholder="Keterangan..."  readonly><?=$res_hdr['keterangan_hdr'];?></textarea>
                                        </div>
                                    </div>    
                                        
                                    <div class="form-group">
                     	                <div class="col-lg-12">
                                            <table id="" class="" rules="all">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 10px">No</th>
                                                            <th>Item</th>
                                                            <th>Kode FB</th>
                                                            <th>QTY</th>
                                                            <th>Satuan</th>
                                                            <th>@Harga</th>
                                                            <th>Ppn</th>
                                                            <th>Total Harga</th>
                                                            <th>Keterangan</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
														$no         = 1;
                                                        $total      = '';
                                                        $total1     = '';
                                                        $total2     = '';
                                                        $ppn        = '';
                                                        $grand_tot  = '';

														while($res_dtl = mysql_fetch_array($q_rb_dtl)) { 

                                                        $tot_atas = $res_dtl['subtot'];  
                                                        $total1   = $res_dtl['jumlah_rb']*$res_dtl['harga'];

                                                        if ($res_dtl['ppn'] == 1){
                                                            $ppn     += $tot_atas*0.1;
                                                        }else{
                                                            $ppn     += 0;
                                                        }

                                                        $grand_tot  += $tot_atas;
                                                        $total       = $grand_tot-$ppn;

                                                        $kd_barang   = '';
                                                        $nm_barang   = '';
                                                        $kode_barang = $res_dtl['kode_barang'];
                                                            if(!empty($kode_barang)) {
                                                            $pisah=explode(":",$kode_barang);
                                                            $kd_barang=$pisah[0];
                                                            $nm_barang=$pisah[1];
                                                            }
													?>
                                                    	<tr>
                                                        	<td style="text-align: center;"><?=$no++?></td>
                                                            <td><?=$kd_barang.'&nbsp;&nbsp;||&nbsp;&nbsp;'.$nm_barang?></td>
                                                            <td><?=$res_dtl['kode_fb']?></td>
                                                            <td style="text-align: right;"><?=$res_dtl['jumlah_rb']?></td>
                                                            <td><?=$res_dtl['satuan']?></td>
                                                            <td style="text-align: right;"><?=number_format($res_dtl['harga'])?></td>
                                                            <td style="text-align: center;"><?=$res_dtl['ppn']=='1' ? 
                                                                    '<p>
                                                                        <span class="glyphicon glyphicon-check"></span>&nbsp;
                                                                     </p>' 
                                                                    :
                                                                    '<p> 
                                                                        <span class="glyphicon glyphicon-unchecked"></span>&nbsp;
                                                                    </p>'
                                                                ?>  
                                                            </td>
                                                            <td style="text-align: right;"><?=number_format($res_dtl['subtot'])?></td>
                                                            <td><?=$res_dtl['keterangan_dtl']?></td>
                                                        </tr>

                                                        <?php } ?>

                                                        <tr>
                                                            <td colspan="7" style="text-align:right"><b>Subtotal</b></td>
                                                            <td style="text-align:right; font-weight:bold;"><?=number_format($total)?></td>
                                                            <td colspan="2"></td>
                                                        </tr>
                    
                                                        <tr>
                                                            <td colspan="7" style="text-align:right"><b>Ppn</b></td>
                                                            <td style="text-align:right; font-weight:bold;"><?=number_format($ppn)?></td>
                                                            <td colspan="2"></td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td colspan="7" style="text-align:right"><b>Grandtotal</b></td>
                                                            <td style="text-align:right; font-weight:bold;"><?=number_format($grand_tot)?></td>
                                                            <td colspan="2"></td>
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
			</div>

<!-- ============ MODAL ADD ITEM =============== -->
<div id="modalAddItem" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                 <h4 class="modal-title">Kode RB : <?=$res_hdr['kode_rb']?></h4>
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
                                          <td style="text-align:right; font-weight:bold"><?=number_format($row['debet'])?></td>
                                          <td style="text-align:right; font-weight:bold"><?=number_format($row['kredit'])?></td>
                                      </tr>
                                      <?php 
                                        }
                                          } else{
                                      ?>
                                      <tr>
                                        <td colspan="4" style="text-align:center">Jurnal dengan Kode RB ini telah dibatalkan !!</td>
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
                 <h4 class="modal-title" style="color: white">Pembatalan Kode RB : <?=$res_hdr['kode_rb']?></h4>
            </div>

            <form id="formPembatalan" method="post" enctype="multipart/form-data">             
                <div class="modal-body" style="min-height: 50px;">
                    <div class="control-group">
                        <div class="form-group">
                      <h4 style="color: black;">Alasan Batal :</h4>
                      <input type="hidden" class="form-control" name="kode_rb_batal" id="kode_rb_batal" value="<?=$res_hdr['kode_rb']?>">
                      <!-- <input type="hidden" class="form-control" name="kode_cabang_batal" id="kode_cabang_batal" value="<?=$res_hdr['kode_cabang']?>">
                      <input type="hidden" class="form-control" name="kode_gudang_batal" id="kode_gudang_batal" value="<?=$res_hdr['kode_gudang']?>"> -->
                      <textarea type="text" class="form-control" name="alasan_batal" id="alasan_batal" placeholder="Alasan Batal..."></textarea>
                  </div>
                    </div>
                </div>

                <div class="modal-footer" style="background-color: #9a24241a; border-top: 1px solid #ab5d5d;">
                  <button type="submit" name="batal" id="batal" class="btn btn-default" onclick="return confirm('Anda yakin akan membatalkan Nota Retur Pembelian ini ?')">
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
                url: "<?=base_url()?>ajax/j_rb.php?func=pembatalan",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(html)
                {
                    var msg = html.split("||");
                    if(msg[0] == "00") {
                        window.location = '<?=base_url()?>?page=pembelian/rb&halaman= NOTA RETUR PEMBELIAN&pembatalan='+msg[1];
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
