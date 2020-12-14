<?php 	
    include "pages/data/script/bts.php"; 
	include "library/form_akses.php";	
?>

<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-shopping-cart"></i> Logistik</a></li>
        <li><a href="#">Track Bukti Terima Aset</a></li>
    </ol>
        
    <section class="content">
        <a href="<?=base_url()?>?page=logistik/bts&halaman=BUKTI TERIMA ASET" class="btn btn-md btn-danger pull-right" ><i class=" fa fa-reply"></i> BACK </a><br/>
   </section>
</section>

<div class="box box-info">
    <div class="box-body">
     	&nbsp;
		<?php
			// HEADER
			$res_hdr = mysql_fetch_array($q_bts_hdr); 
		?>	

				<div class="row">
					<div class="tab-content">
						<div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                	<div class="form-horizontal">

                                 	    <div class="form-group">
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode BTS</label>
                                             <div class="col-lg-4">
                                                 <input type="text" class="form-control" name="kode_bts" id="kode_bts" placeholder="Auto..." readonly value="<?=$res_hdr['kode_bts']?>">
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
                                                 <input type="text" class="form-control" name="ref" id="ref" placeholder="ref..." readonly value="<?=$res_hdr['ref']?>">
                                             </div>

                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">DOC OPS</label>
                                            <div class="col-lg-4">
                                                <select id="kode_ops" name="kode_ops" class="select2" style="width: 100%;" disabled>
                                                    <option value="<?php echo $res_hdr['kode_ops'];?>">
                                                        <?php echo $res_hdr['kode_ops'];?> 
                                                    </option>
                                                </select>
                                            </div>
				                                </div>
                                        
                                        <div class="form-group">
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal bts</label>
                                             <div class="col-lg-4">
                                                <input type="text" name="tgl_buat" id="tgl_buat" class="form-control" autocomplete="off" readonly value="<?php echo date("d-m-Y",strtotime($res_hdr['tgl_buat']))?>"/>
                                             </div>

                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Supplier</label>
                                             <div class="col-lg-4">
                                              <input type="text" required class="form-control" name="supplier" id="supplier" placeholder="Pilih DOC OPS dahulu ..." value="<?=$res_hdr['kode_supplier'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$res_hdr['nama_supplier']?>" readonly>
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
                                            <table id="" class="table table-bordered table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Kode</th>
                                                            <th>Deskripsi Aset</th>
                                                            <th>Q OPS</th>
                                                            <th>Q Diterima</th>
                                                            <th>Keterangan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                          														$no = 1;
                          														while($res_dtl = mysql_fetch_array($q_bts_dtl)) { 
                          													?>
                                                    	<tr>
                                                        	<td style="text-align: center"><?=$no++?></td>
                                                            <td><?=$res_dtl['kode_kat_aset']?></td>
                                                            <td><?=$res_dtl['nama_aset']?></td>
                                                            <td style="text-align: right;"><?= number_format($res_dtl['qty_ops'])?></td>
                                                            <td style="text-align: right;"><?= number_format($res_dtl['qty'])?></td>
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