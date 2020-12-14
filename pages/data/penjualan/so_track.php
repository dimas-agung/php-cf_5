<?php 	
    include "pages/data/script/so.php"; 
	include "library/form_akses.php";	
?>

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
      font-size: 12px;
  }

  td {
      text-align: left;
      padding: 8px;
      font-size: 12px;
  }

  tr:nth-child(even){background-color: #f2f2f2}

  .pembatalan, .clsman {
      background-color: #9c0303;
    }
</style>

<section class="content-header"> 
    <ol class="breadcrumb">
        <li><i class="fa fa-shopping-cart"></i> Penjualan</li>
        <li>Sales Order</li>
        <li>Track Sales Order</li>
    </ol>
</section> 

<section class="content">
    <div class="col-md-10">
      <?php
        $prev = mysql_fetch_array($q_so_prev); {
        if (isset($prev['id_so_hdr'])){
      ?>
          <a class="btn btn-warning" href="<?=base_url()?>?page=penjualan/so_track&action=track&halaman= TRACK SALES ORDER&kode_so=<?=$prev['kode_so']?>">
            <i class="fa fa-chevron-left" aria-hidden="true"></i>
          </a>
      <?php
        } 
        } 

        $next = mysql_fetch_array($q_so_next); {
        if (isset($next['id_so_hdr'])){
      ?>
          &nbsp;<a class="btn btn-warning" href="<?=base_url()?>?page=penjualan/so_track&action=track&halaman= TRACK SALES ORDER&kode_so=<?=$next['kode_so']?>">
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
        <a href="#tutupmanual" class="btn clsman <?= $status;?>" style="color: white"><i class=" fa fa-close"></i> TUTUP MANUAL</a>
      </div>
      <div clas="col-lg-2">
         <a href="<?=base_url()?>?page=penjualan/so&halaman= SALES ORDER" class="btn btn-danger pull-right" ><i class=" fa fa-reply"></i> BACK </a><br/>
      </div>
</section>

<div class="box box-info">
    <div class="box-body">
     	&nbsp;
		<?php
			// HEADER
			$res_hdr = mysql_fetch_array($q_so_hdr); 

            if ($res_hdr['status'] == '0'){
                $status = 'MENUNGGU APPROVAL';
            }elseif ($res_hdr['status'] == '1'){
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
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode SO</label>
                                    <div class="col-lg-4">
                                       <input type="text" class="form-control" name="kode_so" id="kode_so" placeholder="Auto..." readonly value="<?=$res_hdr['kode_so']?>">
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
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal SO</label>
                                      <div class="col-lg-4">
                                        <div class="input-group">
                                               <input type="text" class="form-control" value="<?=strftime("%A, %d %B %Y", strtotime($res_hdr['tgl_buat']));?>" readonly>
                                               <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                          </div>
                                      </div>

                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Alamat</label>
                                      <div class="col-lg-4">
                                         <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat..." value="<?=$res_hdr['alamat'];?>" readonly>
                                      </div>
                                 </div>

                                 <div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
                                      <div class="col-lg-4">
                                         <input type="text" class="form-control" name="ref" id="ref" placeholder="Ref..." value="<?=$res_hdr['ref'];?>" readonly> 
                                      </div>

                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Alamat Kirim</label>
                                      <div class="col-lg-4">
                                         <input type="text" class="form-control" name="alamat_kirim" id="alamat_kirim" placeholder="Alamat Kirim..." value="<?=$res_hdr['alamat_kirim'];?>" readonly>
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

                                     <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal Kirim</label>
                                       <div class="col-lg-4">
                                         <div class="input-group">
                                           <input type="text" class="form-control" placeholder="Tanggal Kirim ..." value="<?=strftime("%A, %d %B %Y", strtotime($res_hdr['tgl_kirim']))?>" readonly/>
                                           <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                          </div>
                                       </div>
                                 </div>

                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Gudang</label>
                                    <div class="col-lg-4" id="load_gudang">
                                        <select id="kode_gudang" name="kode_gudang" class="select2" style="width: 100%;" disabled>
                                            <option value="<?php echo $res_hdr['kode_gudang'];?>">
                                                <?php echo $res_hdr['nama_gudang'];?> 
                                            </option>
                                        </select>
                                    </div>

                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">TOP</label>
                                      <div class="col-lg-4">
                                        <div class="input-group">
                                          <input type="text" class="form-control" name="top" id="top" placeholder="TOP..." value="<?=$res_hdr['top']?>" readonly/>
                                          <span class="input-group-addon"><b>Hari</b></span>
                                        </div>
                                      </div>
                                </div>
                     
                                <div class="form-group">
                                     <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Salesman</label>
                                     <div class="col-lg-4">
                                         <input type="text" class="form-control" name="salesman" id="salesman" placeholder="Salesman..." value="<?=$res_hdr['kode_salesman'];?>" readonly />
                                     </div>
                                </div>

                                <div class="form-group">
                                     <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                                     <div class="col-lg-10">
                                         <textarea type="text" class="form-control" name="keterangan_hdr" id="keterangan_hdr" placeholder="Keterangan..." readonly><?=$res_hdr['keterangan_hdr'];?></textarea>
                                     </div>
                                </div>
                                        
                                <!-- <div class="form-group">
                                  <label class="col-lg-2 control-label" style="text-align:left">Uang Muka (%)</label> 
                                      <div class="col-lg-4">
                                        <?php
                                            $num_rows   = mysql_num_rows($so_um);
                                                if($num_rows>0){
                                                    while($res_um = mysql_fetch_array($so_um)) { ?>
                                                    <div class="input-group control-group after-add-more">
                                                        <input type="text" style="width: 12em" name="um" id="um" class="form-control" placeholder="Uang Muka %" value="<?=$res_um['persen'];?>" readonly>
                                                        <div class="input-group-btn"> 
                                                            <input type="text" style="width: 17em" value="<?=number_format($res_um['termin']);?>" readonly name="nominal" id="nominal" class="form-control" placeholder="0">
                                                        </div>
                                                    </div>
                                                    <br>
                                            <?php } }else{ ?> 
                                                    <div class="input-group control-group after-add-more">
                                                        <input type="text" style="width: 12em" name="um" id="um" class="form-control" placeholder="Uang Muka %" value="0" readonly>
                                                        <div class="input-group-btn"> 
                                                            <input type="text" style="width: 17em" value="0" readonly name="nominal" id="nominal" class="form-control" placeholder="0">
                                                        </div>
                                                    </div>
                                             <?php } ?> 
                                      </div>   
                                </div> -->

                                        
                                        <div class="form-group">
                     	                    <div style="overflow-x:auto;">
                                                <table id="" class="" rules="all">
                                                <thead>
                                                    <?php
                                                        $n=1;
                                                    ?>
                                                    <tr>
                                                        <th style="width:10px">No</th>
                                                        <th style="width:120px">Barang</th>
                                                        <th style="width:20px">FOC</th>
                                                        <th style="width:100px">QTY</th>
                                                        <th style="width:100px">Konversi</th>
                                                        <th style="width:100px">Harga Jual</th>
                                                        <th style="width:100px">Disc 1(%)</th>
                                                        <th style="width:100px">Disc 2(%)</th>
                                                        <th style="width:100px">Disc 3(%)</th>
                                                        <th style="width:20px">PPn</th>
                                                        <th style="width:100px">Subtotal</th>
                                                        <th style="width:150px">Ket</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
														$no = 1;
														$diskon1x 		= 0;
														$diskon2x 		= 0;
														$diskon3x 		= 0;
														$ppn_n	 		= 0;
														$ppn_vn	 		= 0;
														$subtot 		= 0;
														$subtotal 		= 0;
														$grandtotal 	= 0;
														while($res_dtl = mysql_fetch_array($q_so_dtl)) { 
														
														$qty = $res_dtl['qty'];
														$konversi = $res_dtl['konversi'];
														$konversi1 = $res_dtl['konversi1'];
														$diskon1x = ($res_dtl['harga'] - ($res_dtl['harga'] * ($res_dtl['diskon1'] / 100)));
														$diskon2x = ($diskon1x - ($diskon1x * ($res_dtl['diskon2'] / 100)));
														$diskon3x = ($diskon2x - ($diskon2x * ($res_dtl['diskon3'] / 100)));
														
														if ($konversi1 > 0) {
															$qtyx = ($qty * ($konversi * $konversi1));
														} else {
															$qtyx = ($qty * $konversi);
														}
														$subtot = ($diskon3x * $qtyx);
														
														if ($res_dtl['ppn'] === '1') {
															$ppn_n = ($subtot - ($subtot / 1.1));
														}
														else {
															$ppn_n = 0;
														}
														$subtotal += $subtot - $ppn_n;
														$ppn_vn += $ppn_n;
													
													?>
                                                    	<tr>
                                                            <td style="text-align: center"><?=$no++?></td>
                                                            <td><?=$res_dtl['nama_barang']?></td>
                                                            <td style="text-align: center"><?=$res_dtl['foc']=='1' ? 
                                                                    '<p>
                                                                        <span class="glyphicon glyphicon-check"></span>&nbsp;
                                                                     </p>' 
                                                                    :
                                                                    '<p> 
                                                                        <span class="glyphicon glyphicon-unchecked"></span>&nbsp;
                                                                    </p>'
                                                                ?> 
                                                            </td>
                                                            <td style="text-align: right;"><?=number_format($res_dtl['qty'], 2) . ' ' . $res_dtl['satuan']?></td>
                                                            <td style="text-align: right;"><?=number_format($qtyx, 2) . ' ' . $res_dtl['satuan_simpan']?></td>
                                                            <td style="text-align: right;"><?= number_format($res_dtl['harga'], 2)?></td>
                                                            <td style="text-align: right;"><?= number_format($res_dtl['diskon1'], 2)?></td>
                                                            <td style="text-align: right;"><?= number_format($res_dtl['diskon2'], 2)?></td>
                                                            <td style="text-align: right;"><?= number_format($res_dtl['diskon3'], 2)?></td>
                                                            <td style="text-align: center"><?=$res_dtl['ppn']=='1' ? 
                                                                    '<p>
                                                                        <span class="glyphicon glyphicon-check"></span>&nbsp;
                                                                     </p>' 
                                                                    :
                                                                    '<p> 
                                                                        <span class="glyphicon glyphicon-unchecked"></span>&nbsp;
                                                                    </p>'
                                                                ?>  
                                                            </td>
                                                            <td style="text-align: right;"><?= number_format($res_dtl['total_harga'], 2)?></td>
                                                            <td><?=$res_dtl['keterangan_dtl']?></td>
                                                        </tr>
                                                    <?php } $grandtotal = $subtotal + $ppn_vn; ?>   
                                                        <tr>
                                                            <td colspan="10" style="text-align:right; font-weight: bold">DPP :</td>
                                                            <td style="text-align:right; font-weight: bold"><?= number_format($subtotal, 2)?></td>
                                                            <td></td>
                                                        </tr>
                    
                                                        <tr>
                                                            <td colspan="10" style="text-align:right; font-weight: bold">PPn :</td>
                                                            <td style="text-align:right; font-weight: bold"><?= number_format($ppn_vn, 2)?></td>
                                                            <td></td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td colspan="10" style="text-align:right; font-weight:bold">Grand Total :</td>
                                                            <td style="text-align:right; font-weight:bold"><?= number_format($grandtotal, 2)?></td>
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

<!-- ============ MODAL PEMBATALAN =============== -->
<div id="modalPembatalan" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #9c0303">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                 <h4 class="modal-title" style="color: white">Pembatalan Kode SO : <?=$res_hdr['kode_so']?></h4>
            </div>

            <form id="formPembatalan" method="post" enctype="multipart/form-data">             
                <div class="modal-body" style="min-height: 50px;">
                    <div class="control-group">
                        <div class="form-group">
                      <h4 style="color: black;">Alasan Batal :</h4>
                      <input type="hidden" class="form-control" name="kode_so_batal" id="kode_so_batal" value="<?=$res_hdr['kode_so']?>">
                      <textarea type="text" class="form-control" name="alasan_batal" id="alasan_batal" placeholder="Alasan Batal..."></textarea>
                  </div>
                    </div>
                </div>

                <div class="modal-footer" style="background-color: #9a24241a; border-top: 1px solid #ab5d5d;">
                  <button type="submit" name="batal" id="batal" class="btn btn-default" onclick="return confirm('Anda yakin akan membatalkan Sales Order ini ?')">
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
                url: "<?=base_url()?>ajax/j_so.php?func=pembatalan",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(html)
                {
                    var msg = html.split("||");
                    if(msg[0] == "00") {
                        window.location = '<?=base_url()?>?page=penjualan/so&halaman= SALES ORDER&pembatalan='+msg[1];
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
    
    $(document).on('click', '.clsman', function ($e) {
        var
            $k = $('#kode_so').val() || '',
            $c = confirm("Apakah yakin di tutup manual Kode : " + $k + "?");
       $e.preventDefault();
       
       if (!$c) {
           return false;
       }
       
       $.ajax({
            url: "<?=base_url()?>ajax/j_so.php?func=clsman",
            type: "POST",
            data: "kode_so=" + $k,
            cache: false,
            success: function(html)
            {
                var msg = html.split("||");
                if(msg[0] == "00") {
                    window.location = '<?=base_url()?>?page=pembelian/so&halaman= SALES ORDER&clsman='+msg[1];
                } else {
                    notifError(msg[1]);
                }
                $(".animated").hide();
            } 
              
       });
    });
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