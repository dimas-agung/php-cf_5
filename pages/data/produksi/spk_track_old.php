<?php 	
    include "pages/data/script/spk.php"; 
	include "library/form_akses.php";	
?>

<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-cubes"></i> Produksi</a></li>
        <li><a href="#">Track Form Surat Perintah Kerja</a></li>
    </ol>
        
	<section class="content">
    	<a href="<?=base_url()?>?page=produksi/spk" class="btn btn-md btn-danger pull-right" ><i class=" fa fa-reply"></i> BACK </a><br/>
   	</section>
</section>

<div class="box box-info">
    <div class="box-body">&nbsp;
		<?php
			$res_hdr = mysql_fetch_array($q_spk_hdr); 
		?>	
		<div class="row">
			<div class="tab-content">
				<div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-horizontal">

                                <div class="form-group">
                                	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode SPK</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" name="kode_spk" id="kode_spk" placeholder="Auto..." readonly value="<?=$res_hdr['kode_spk']?>">
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
                                        <input type="text" class="form-control" name="ref" id="ref" placeholder="Ref..." readonly value="<?=$res_hdr['ref']?>">
                                    </div>
                                             
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Barang Jadi</label>
                                    <div class="col-lg-4">
                                        <select id="kode_barang-jadi" name="kode_barang-jadi" class="select2" style="width: 100%;" disabled>
		                                    <option value="<?php echo $res_hdr['kode_barang_jadi'];?>">
		                                        <?php echo $res_hdr['kode_barang'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$res_hdr['nama_barang_jadi'];?> 
		                                    </option>
		                                </select>
                                    </div>
				                </div>
                                        
                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal SPK</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="tgl_buat" id="tgl_buat" class="form-control" autocomplete="off" readonly value="<?php echo date("d-m-Y",strtotime($res_hdr['tgl_buat']))?>"/>
                                    </div>

                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal Selesai</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="tgl_buat" id="tgl_buat" class="form-control" autocomplete="off" readonly value="<?php echo date("d-m-Y",strtotime($res_hdr['tgl_buat']))?>"/>
                                    </div>
                                </div>   
                                        
                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Jumlah</label>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control" name="qty" id="qty" placeholder="QTY..." readonly value="<?=$res_hdr['qty']?>">
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control" name="satuan" id="satuan" placeholder="Satuan..." readonly value="<?=$res_hdr['satuan']?>">
                                    </div>
                                </div> 
                                        
                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                                    <div class="col-lg-10">
                                        <textarea  class="form-control" rows="2" name="keterangan_hdr" id="keterangan_hdr" readonly placeholder="Keterangan..."><?=$res_hdr['keterangan']?></textarea>
                                    </div>
                                </div> 
                                        
                                <div class="form-group">
                     	            <div class="col-lg-12">
                                        <table id="" class="" rules="all">
                                            <thead>
                                                <tr>
                                                    <th>Kode</th>
                                                    <th>Nama</th>
                                                    <th>Satuan</th>
                                                    <th>Base QTY</th>
                                                    <th>Kebutuhan</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
												while($res_dtl = mysql_fetch_array($q_spk_dtl)) { 
											?>
                                                <tr>
                                                    <td><?=$res_dtl['kode_barang']?></td>
                                                    <td><?=$res_dtl['nama_barang']?></td>
                                                    <td><?=$res_dtl['nama_satuan']?></td>
                                                    <td style="text-align: right;"><?= $res_dtl['qty']?></td>
                                                    <td style="text-align: right;"><?= $res_dtl['total_qty']?></td>
                                                    <td><?=$res_dtl['keterangan']?></td>
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

<style>
  .pm-min, .pm-min-s{padding:3px 1px; }
  .animated{display:none;}

  table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 1110px;
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
