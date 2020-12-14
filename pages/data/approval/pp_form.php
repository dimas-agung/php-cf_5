<?php    
  include "pages/data/script/pp.php"; 
   include "library/form_akses.php";   
?>

<style>
  .pm-min, .pm-min-s{padding:3px 1px; }
  .animated{display:none;}

  table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 2000px;
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

<section class="content-header">
    <ol class="breadcrumb">
        <li><i class="fa fa-shopping-cart"></i> Pembelian</li>
        <li>Permintaan Pembelian</li>
    </ol>
</section>
        
<section class="content">
  <a href="<?=base_url()?>?page=pembelian/pp&halaman= PERMINTAAN PEMBELIAN" class="btn btn-danger pull-right" ><i class=" fa fa-reply"></i> BACK</a><br>
</section>

<div class="box box-info">
    <div class="box-body">
      &nbsp;
      <?php
         // HEADER
         $res_hdr = mysql_fetch_array($q_op_hdr); 
      ?> 

<div class="row">
   <div class="tab-content">
      <div class="col-lg-12">
         <div class="panel panel-default">
            <div class="panel-body">
               <div class="form-horizontal">

                           <h3 style="text-align: center">Kode OP : <b><?php echo $res_hdr['kode_op'] ?></b></h3> <hr style="border-top: 2px solid #5615157d;">

                                          <div class="form-group">
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode</label>
                                             <div class="col-lg-4">
                                                <input type="text" class="form-control" name="kode_op" id="kode_op" placeholder="Kode ..." readonly value="<?=$res_hdr['kode_op'];?>">
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
                                            <input type="text" class="form-control" name="ref" id="ref" placeholder="Ref..." value="<?=$res_hdr['ref'];?>" readonly />
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
                                          <label style="text-align:left" class="col-lg-2 col-sm-2 control-label">Tanggal PO</label>
                                          <div class="col-lg-4">
                                             <div class="input-group">
                                                <input class="form-control date-picker" value="<?=$res_hdr['tgl_buat'];?>" type="text" placeholder="Tanggal ..." readonly/>
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar bigger-110"></i>
                                                </span>
                                             </div>
                                          </div>

                                          <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">TOP</label>
                                          <div class="col-lg-4">
                                             <div class="input-group">
                                                <input type="text" autocomplete="off" required class="form-control" name="top" id="top" placeholder="TOP..." value="<?=$res_hdr['top'];?>" readonly />
                                                <span class="input-group-addon"><b>Hari</b></span>
                                             </div>
                                          </div>
                                       </div>  
                                        
                                       <div class="form-group">
                                          <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                                          <div class="col-lg-10">
                                             <textarea  class="form-control" name="keterangan_hdr" id="keterangan_hdr" placeholder="Keterangan..."  readonly><?=$res_hdr['keterangan_hdr'];?></textarea>
                                          </div>
                                       </div>
                                    
                                       <div class="form-group">
                                          <label class="col-lg-2 control-label" style="text-align:left">Uang Muka (%)</label> 
                                             <div class="col-lg-4">
                                             <?php
                                             $num_rows   = mysql_num_rows($op_um);
                                                if($num_rows>0){
                                                    while($res_um = mysql_fetch_array($op_um)) { ?>
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
                                       </div>      
                                        
                                        <div class="form-group">
                     	                    <div style="overflow-x:auto;">
                                            <table id="" class="" rules="all">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 10px">No</th>
															<th style="width: 100px">Gudang</th>
															<th style="width: 180px">Barang</th>
															<th style="width: 100px">Tgl Kirim</th>
															<th style="width: 100px">QTY</th>
															<th style="width: 100px">Jumlah</th>
															<th style="width: 100px">Stok</th>
															<th style="width: 100px">Harga Beli</th>
															<th style="width: 100px">Disc 1(%)</th>
															<th style="width: 100px">Disc 2(%)</th>
															<th style="width: 100px">Disc 3(%)</th>
															<th style="width: 100px">PPn</th>
															<th style="width: 100px">Subtotal</th>
															<th style="width: 100px">Divisi</th>
															<th style="width: 150px">Ket</th>                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
														$no         = 1;
														$diskon1x 		= 0;
														$diskon2x 		= 0;
														$diskon3x 		= 0;
														$ppn_n	 		= 0;
														$ppn_vn	 		= 0;
														$subtot 		= 0;
														$subtotal 		= 0;
														$grandtotal 	= 0;

														while($res_dtl = mysql_fetch_array($q_op_dtl)) { 
														
														$qty = $res_dtl['qty'];
														$diskon1x = ($res_dtl['harga'] - ($res_dtl['harga'] * ($res_dtl['diskon'] / 100)));
														$diskon2x = ($diskon1x - ($diskon1x * ($res_dtl['diskon2'] / 100)));
														$diskon3x = ($diskon2x - ($diskon2x * ($res_dtl['diskon3'] / 100)));
														
														$subtot = ($diskon3x * $qty);
														
														if ($res_dtl['ppn'] === '1') {
															$ppn_n = ($subtot - ($subtot / 1.1));
														}
														else {
															$ppn_n = 0;
														}
														$subtotal += $subtot - $ppn_n;
														$ppn_vn += $ppn_n;
                                                        
                                                        $kd_barang   = '';
                                                        $nm_barang   = '';
                                                        $kode_barang = $res_dtl['kode_barang'];
														if(!empty($kode_barang)) {
															$pisah=explode(":",$kode_barang);
															$kd_barang=$pisah[0];
															$nm_barang=$pisah[1];
														}

                                                        $kd_gudang   = '';
                                                        $nm_gudang   = '';
                                                        $kode_gudang = $res_dtl['kode_gudang'];
														if(!empty($kode_gudang)) {
																$pisah=explode(":",$kode_gudang);
																$kd_gudang=$pisah[0];
																$nm_gudang=$pisah[1];
														}

                                                        $nm_divisi   = '';
                                                        $divisi = $res_dtl['divisi'];
														if(!empty($divisi)) {
                                                            $pisah=explode(":",$divisi);
                                                            $nm_divisi=$pisah[1];
														}                                                                                       $nm_satuan   = '';
														$satuan = $res_dtl['satuan'];
														if(!empty($satuan)) {                                                            	
															$pisah=explode(":",$satuan);
															$nm_satuan=$pisah[1];
														}    

                                                        $nm_satuan2   = '';
                                                        $satuan2 = $res_dtl['satuan2'];
														if(!empty($satuan2)) {
                                                            $pisah2=explode(":",$satuan2);
                                                            $nm_satuan2=$pisah2[1];
														}

													?>
                                                    	<tr>
                                                        	<td style="text-align: center;"><?=$no++?></td>
                                                            <td><?=$nm_gudang?></td>
                                                            <td><?=$nm_barang?></td>
                                                            <td><?=date("d-m-Y",strtotime($res_dtl['tgl_kirim']))?></td>
                                                            <td style="text-align: right;"><?=number_format($res_dtl['qty_i'], 2) . ' ' . $nm_satuan2?></td>
                                                            <td style="text-align: right;"><?=number_format($res_dtl['qty'], 2) . ' ' . $nm_satuan?></td>
                                                            <td style="text-align: right;"><?=number_format($res_dtl['stok'], 2) . ' ' . $nm_satuan?></td>
                                                            <td style="text-align: right;"><?=number_format($res_dtl['harga'], 2)?></td>
                                                            <td style="text-align: right;"><?=number_format($res_dtl['diskon'], 2)?></td>
                                                            <td style="text-align: right;"><?=number_format($res_dtl['diskon2'], 2)?></td>
                                                            <td style="text-align: right;"><?=number_format($res_dtl['diskon3'], 2)?></td>
                                                            <td style="text-align: center;"><?=$res_dtl['ppn']==='1' ? 
                                                                    '<p>
                                                                        <span class="glyphicon glyphicon-check"></span>&nbsp;
                                                                     </p>' 
                                                                    :
                                                                    '<p> 
                                                                        <span class="glyphicon glyphicon-unchecked"></span>&nbsp;
                                                                    </p>'
                                                                ?>  
                                                            </td>
                                                            <td style="text-align: right;"><?=number_format($res_dtl['subtot'], 2)?></td>
                                                            <td><?=$nm_divisi?></td>
                                                            <td><?=$res_dtl['keterangan_dtl']?></td>
                                                        </tr>

                                                        <?php } $grandtotal = $subtotal + $ppn_vn; ?>

                                                        <tr>
                                                            <td colspan="12" style="text-align:right"><b>DPP</b></td>
                                                            <td style="text-align:right; font-weight:bold;"><?=number_format($subtotal, 2)?></td>
                                                            <td colspan="2"></td>
                                                        </tr>
                    
                                                        <tr>
                                                            <td colspan="12" style="text-align:right"><b>PPN</b></td>
                                                            <td style="text-align:right; font-weight:bold;"><?=number_format($ppn_vn, 2)?></td>
                                                            <td colspan="2"></td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td colspan="12" style="text-align:right"><b>Grandtotal</b></td>
                                                            <td style="text-align:right; font-weight:bold;"><?=number_format($grandtotal, 2)?></td>
                                                            <td colspan="2"></td>
                                                        </tr>

                                                    
                                                    </tbody>
                                                </table>
                                    		</div>
										</div>
										<form action="<?=base_url()?>?page=script/pp&action=tolak&kode_op=<?=$res_hdr['kode_op']?>&user=<?=$res_hdr['user_pencipta']?>" method="post" enctype="application/x-www-urlencode">
                                       <div class="form-group">
                                          <label class="col-lg-1 col-sm-1 control-label" style="text-align:left">Alasan Batal</label>
                                          <div class="col-lg-11">
                                             <textarea class="form-control" name="alasan_batal" id="alasan_batal" placeholder="Alasan Batal..."></textarea>
                                          </div>
                                       </div>
                                       <br>

                                       <div class="form-group">
                                          <div class="col-md-10">
                                             <h4>Dibuat Oleh : <?= $res_hdr['nama_user']?></h4>
                                          </div>
                                          <div class="col-md-2">
                                          <?php 
                                             $list_survey_write = 'n';
                                             while($res = mysql_fetch_array($q_akses)) {; ?>    
                                             <?php 
                                             //FORM SURVEY
                                                if($res['form']=='survey'){ 
                                                   if($res['w']=='1'){
                                                      $list_survey_write = 'y';  
                                             ?>
                                              &nbsp;&nbsp;&nbsp;    
                                             <a href="<?=base_url()?>?page=script/pp&action=setuju&kode_op=<?=$res_hdr['kode_op']?>&user=<?=$res_hdr['user_pencipta']?>" class="btn btn-primary"><i class="fa fa-check"></i> Setuju</a>
                                             &nbsp;&nbsp;
                                             <?php } } ?>
                                          <?php } ?>    
                                             
                                             <button type="submit" name="action_tolak" onclick="return confirm('Apakah yakin ingin membatalkan Order Pembelian?');" class="btn btn-danger"><i class="fa fa-times"></i> Tolak</button>
											</div>

										</div> 
										</form>
         </div>
        <!-- /.panel-body -->
      </div>                       
      <!-- /.panel-default -->
    </div>
   </div>
</div>

<script>
  function cek_ket_op() 
  {
    if ($('#alasan_batal').val()=='')
      {
        alert("Alasan Tidak Boleh Kosong");
        return false;
      }
  }
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