<?php 	
    include "pages/data/script/sm_script.php"; 
		include "library/form_akses.php";	
?>

<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-shopping-cart"></i> Logistik</a></li>
        <li><a href="#">Track Stok Masuk</a></li>
    </ol>
        
    <section class="content">
        <a href="#modalAddItem" class="btn btn-md btn-info"  data-toggle="modal"><i class=" fa fa-book"></i> JURNAL </a>
        <a href="<?=base_url()?>?page=logistik/sm&halaman= STOK MASUK" class="btn btn-md btn-danger pull-right" ><i class=" fa fa-reply"></i> BACK </a><br/>
   </section>
</section>

<div class="box box-info">
    <div class="box-body">
     	&nbsp;
		<?php
			// HEADER
			$res_hdr = mysql_fetch_array($q_sm_hdr); 
		?>	

				<div class="row">
					<div class="tab-content">
						<div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                	<div class="form-horizontal">
                                 	      <div class="form-group">
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode SM</label>
                                             <div class="col-lg-4">
                                                 <input type="text" class="form-control" name="kode_sm" id="kode_sm" placeholder="Auto..." readonly value="<?=$res_hdr['kode_sm']?>">
                                             </div>

                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
                                             <div class="col-lg-4">
                                                 <input type="text" class="form-control" name="ref" id="ref" placeholder="ref..." readonly value="<?=$res_hdr['ref']?>">
                                             </div>     
                                        </div>  
                            
										                    <div class="form-group">
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal SM</label>
                                             <div class="col-lg-4">
                                                <input type="text" name="tgl_buat" id="tgl_buat" class="form-control" autocomplete="off" readonly value="<?php echo date("d-m-Y",strtotime($res_hdr['tgl_buat']))?>"/>
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
                                        </div>  
                                        
                                        <div class="form-group">
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                                             <div class="col-lg-10">
                                               <textarea class="form-control" name="keterangan_hdr" id="keterangan_hdr" readonly placeholder="Keterangan..."><?=$res_hdr['keterangan_hdr']?></textarea>
                                             </div>
                                        </div> 
                                        
                                        <div class="form-group">
                     	                    <div style="overflow-x:auto;">
                                            <table id="" class="" rules="all">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th style="width: 15%">Item</th>
                                                        <th style="width: 8%">Satuan</th>
                                                        <th>Harga rata-rata</th>
                                                        <th style="width: 10%">Qty</th>
                                                        <th>Total Harga</th>
                                                        <th style="width: 15%">COA Debet</th>
                                                        <th style="width: 15%">COA Kredit</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                          														$no = 1;
                          														while($res_dtl = mysql_fetch_array($q_sm_dtl)) { 

                                                        $kd_barang  = '';
                                                        $nm_barang  = '';
                                                        $kode_barang = $res_dtl['kode_barang'];
                                                          if(!empty($kode_barang)) {
                                                            $pisah=explode(":",$kode_barang);
                                                            $kd_barang=$pisah[0];
                                                            $nm_barang=$pisah[1];
                                                          }

                                                        $kd_satuan  = '';
                                                        $nm_satuan  = '';
                                                        $satuan     = $res_dtl['satuan'];
                                                          if(!empty($satuan)) {
                                                            $pisah=explode(":",$satuan);
                                                            $kd_satuan=$pisah[0];
                                                            $nm_satuan=$pisah[1];
                                                          }

                                                        $kd_coa_debet    = '';
                                                        $nm_coa_debet    = '';
                                                        $coa_debet = $res_dtl['coa_debet'];
                                                          if(!empty($coa_debet)) {
                                                            $pisah=explode(":",$coa_debet);
                                                            $kd_coa_debet=$pisah[0];
                                                            $nm_coa_debet=$pisah[1];
                                                          }

                                                        $kd_coa_kredit   = '';
                                                        $nm_coa_kredit   = '';
                                                        $coa_kredit = $res_dtl['coa_kredit'];
                                                          if(!empty($coa_kredit)) {
                                                            $pisah=explode(":",$coa_kredit);
                                                            $kd_coa_kredit=$pisah[0];
                                                            $nm_coa_kredit=$pisah[1];
                                                          }
                          													?>
                                                    	<tr>
                                                            <td style="text-align: center"><?=$no++?></td>
                                                            <td><?=$kd_barang?>&nbsp;&nbsp;||&nbsp;&nbsp;<?=$nm_barang?></td>
                                                            <td style="text-align: center"><?=$nm_satuan?></td>
                                                            <td style="text-align: right"><?=number_format($res_dtl['harga'], 2)?></td>
                                                            <td style="text-align: right"><?=number_format($res_dtl['qty_sm'], 2)?></td>
                                                            <td style="text-align: right"><?=number_format($res_dtl['total_harga'], 2)?></td>
                                                            <td><?=$kd_coa_debet?>&nbsp;&nbsp;||&nbsp;&nbsp;<?=$nm_coa_debet?></td>
                                                            <td><?=$kd_coa_kredit?>&nbsp;&nbsp;||&nbsp;&nbsp;<?=$nm_coa_kredit?></td>
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
                  <h4 class="modal-title"><?=$res_hdr['kode_sm']?></h4>
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
                                       <th style="text-align:center">Debet</th>
                                       <th style="text-align:center">Kredit</th>
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
                                    <?php } } ?>
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
