<?php 	include "pages/data/script/ops.php"; 
		include "library/form_akses.php";	
?>

<section class="content-header">
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-shopping-cart"></i> Pembelian</a></li>
          <li><a href="#">Track Order Pembelian Aset</a></li>
        </ol>
        
        <section class="content">
        <a href="<?=base_url()?>?page=pembelian/ops&halaman=ORDER PEMBELIAN ASET" class="btn btn-md btn-danger pull-right" ><i class=" fa fa-reply"></i> BACK </a>
        
        <br />
    	</section>
</section>


            <!-- /.row -->
            <div class="box box-info">
            <div class="box-body">
     		&nbsp;
			<?php
			// HEADER
			$res_hdr = mysql_fetch_array($q_ops_hdr); 
			?>								
		

			<div class="row">
			<div class="tab-content">
				
                        <div class="col-lg-12">
                        	 
                            <div class="panel panel-default">
                                <div class="panel-body">
                                	<div class="form-horizontal">

                                 	<div class="form-group">
                                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode</label>
                                            <div class="col-lg-4">
                                                <input type="text" class="form-control" name="kode_ops" id="kode_ops" placeholder="Kode ..." readonly value="<?=$res_hdr['kode_ops'];?>">
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
                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="ref" id="ref" placeholder="Ref..." value="<?=$res_hdr['ref'];?>" readonly />
                                        </div>

                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">TOP</label>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                <input type="text" autocomplete="off" required class="form-control" name="top" id="top" placeholder="TOP..." value="<?=$res_hdr['top'];?>" readonly />
                                                <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                                                   
                                    <div class="form-group">
                                        <label style="text-align:left" class="col-lg-2 col-sm-2 control-label">Tanggal OPS</label>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                <input class="form-control date-picker" value="<?=$res_hdr['tgl_buat'];?>" type="text" placeholder="Tanggal ..." readonly/>
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar bigger-110"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>  

                                    <div class="form-group">
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
                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                                        <div class="col-lg-10">
                                            <textarea  class="form-control" name="keterangan_hdr" id="keterangan_hdr" placeholder="Keterangan..."  readonly><?=$res_hdr['keterangan_hdr'];?></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                             <label class="col-lg-2 control-label" style="text-align:left">Uang Muka (%)</label> 
                                             <div class="col-lg-4">
                                                <?php
                                                $num_rows   = mysql_num_rows($ops_um);
                                                    if($num_rows>0){
                                                        while($res_um = mysql_fetch_array($ops_um)) { ?>
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
                                                            <th style="width: 250px">Kategori Aset</th>
                                                            <th style="width: 150px">Tgl kirim</th>
                                                            <th style="width: 150px">Q</th>
                                                            <th style="width: 150px">Harga Beli</th>
                                                            <th style="width: 150px">Diskon</th>
                                                            <th style="width: 50px">Ppn</th>
                                                            <th style="width: 140px">Subtotal</th>
                                                            <th style="width: 175px">Divisi</th>
                                                            <th style="width: 175px">Ket</th>
                                                            
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

														while($res_dtl = mysql_fetch_array($q_ops_dtl)) { 

                                                        $tot_atas = $res_dtl['subtot'];  
                                                        $total1   = $res_dtl['qty']*($res_dtl['harga']-$res_dtl['diskon']);

                                                        if ($res_dtl['ppn'] == 1){
                                                            $ppn     += $tot_atas*0.1;
                                                        }else{
                                                            $ppn     += 0;
                                                        }

                                                        $grand_tot  += $tot_atas;
                                                        $total       = $grand_tot-$ppn;

                                                        $kd_kat_aset   = '';
                                                        $nm_kat_aset   = '';
                                                        $kode_kat_aset = $res_dtl['kode_kat_aset'];
                                                            if(!empty($kode_kat_aset)) {
                                                            $pisah=explode(":",$kode_kat_aset);
                                                            $kd_kat_aset=$pisah[0];
                                                            $nm_kat_aset=$pisah[1];
                                                            }

                                                        $nm_divisi   = '';
                                                        $divisi = $res_dtl['divisi'];
                                                            if(!empty($divisi)) {
                                                            $pisah=explode(":",$divisi);
                                                            $nm_divisi=$pisah[1];
                                                            }

													?>
                                                    	<tr>
                                                        	<td style="text-align: center;"><?=$no++?></td>
                                                            <td><?=$kd_kat_aset.'&nbsp;&nbsp;||&nbsp;&nbsp;'.$nm_kat_aset?></td>
                                                            <td><?=date("d-m-Y",strtotime($res_dtl['tgl_kirim']))?></td>
                                                            <td style="text-align: right;"><?=$res_dtl['qty']?></td>
                                                            <td style="text-align: right;"><?=number_format($res_dtl['harga'])?></td>
                                                            <td style="text-align: right;"><?=number_format($res_dtl['diskon'])?></td>
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
                                                            <td><?=$nm_divisi?></td>
                                                            <td><?=$res_dtl['keterangan_dtl']?></td>
                                                        </tr>

                                                        <?php } ?>

                                                        <tr>
                                                            <td colspan="7" style="text-align:right"><b>Total</b></td>
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

<style>
  .pm-min, .pm-min-s{padding:3px 1px; }
  .animated{display:none;}

  table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 1700px;
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
      font-size: 12px;
      padding: 4px;
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
