<?php 	
    include "pages/data/script/cls_spk.php"; 
	include "library/form_akses.php";	
?>

<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-cubes"></i>Produksi</a></li>
        <li><a href="#">Track Form Close Surat Perintah Kerja</a></li>
    </ol>
        
	<section class="content">
    	<a href="<?=base_url()?>?page=produksi/cls_spk" class="btn btn-md btn-danger pull-right" ><i class=" fa fa-reply"></i> BACK </a><br/>
   	</section>
</section>

<div class="box box-info">
  <div class="box-body">&nbsp;
		<?php
			$res_hdr = mysql_fetch_array($q_cspk_hdr); 
		?>	
		<div class="row">
			<div class="tab-content">
				<div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-body">
              <div class="form-horizontal">
                                             
                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode Closing</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" name="kode_cspk" id="kode_cspk" placeholder="Kode CSPK..." readonly value="<?=$res_hdr['kode_cspk']?>">
                                    </div>

                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
                                    <div class="col-lg-4">
                                        <select id="kode_cabang" name="kode_cabang" class="select2" disabled>
                                            <option value="<?=$res_hdr['kode_cabang']?>"><?=$res_hdr['kode_cabang'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$res_hdr['nama_cabang']?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" name="ref" id="ref" placeholder="ref..." value="<?=$res_hdr['ref']?>" readonly autocomplete="off" />
                                    </div>

                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">DOC SPK</label>
                                    <div class="col-lg-4" id="load_spk">
                                        <select id="doc_spk" name="doc_spk" class="select2" style="width: 100%;" disabled>
                                            <option value="<?=$res_hdr['kode_spk']?>"><?=$res_hdr['kode_spk']?></option>
                                        </select>
                                    </div> 
                                </div>

                                <div class="form-group">
                                    <label style="text-align:left" class="col-lg-2 col-sm-2 control-label">Tanggal SPK</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="tgl_buat" id="tgl_buat" class="form-control" autocomplete="off" readonly value="<?php echo date("d-m-Y",strtotime($res_hdr['tgl_buat']))?>"/>
                                    </div>
                                </div>
                                        
                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                                    <div class="col-lg-10">
                                        <textarea  class="form-control" name="keterangan_hdr" id="keterangan_hdr" readonly placeholder="Keterangan..."><?=$res_hdr['keterangan_hdr']?></textarea>
                                    </div>
                                </div> 
                                <div class="form-group">
                                  <div class="col-md-12">
                                        <table id="tabel_detail" class="table table-striped table-bordered table-hover" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Doc SPK</th>
                                                    <th colspan="2">Barang</th>
                                                    <th>Satuan</th>
                                                    <th>Rencana Produksi</th>
                                                    <th>Realisasi Produksi</th>
                                                    <th>%</th>
                                                </tr>
                                            </thead>
                                            <tbody id="detail_input_spk">  
                                                  <tr>
                                                      <td><?=$res_hdr['kode_spk']?></td>
                                                      <td><?=$res_hdr['kode_barang']?></td>
                                                      <td><?=$res_hdr['nama_barang']?></td>
                                                      <td style="text-align: center;"><?= $res_hdr['satuan']?></td>
                                                      <td style="text-align: right;"><?= $res_hdr['rencana_produksi']?></td>
                                                      <td style="text-align: right;"><?= $res_hdr['realisasi_produksi']?></td>
                                                      <td style="text-align: right;"><?=$res_hdr['persen_produksi']?>%</td>
                                                  </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <hr>
                                    <div align="center">
                                        <h4><b>MATERIAL</b></h4>
                                    </div> 
                                <hr>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <table id="tabel_material" class="table table-striped table-bordered table-hover" width="100%">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">Standart Material</th>
                                                    <th>Standart Pemakaian</th>
                                                    <th>Transfer Material</th>
                                                    <th>Sisa Material</th>
                                                </tr>
                                            </thead>
                                            <tbody id="detail_input_material">
                                              <?php
                                                while($res_dtl = mysql_fetch_array($q_cspk_material)) { 
                                              ?>  
                                                <tr>
                                                    <td><?=$res_dtl['kode_barang']?></td>
                                                    <td><?=$res_dtl['nama_barang']?></td>
                                                    <td style="text-align: right;"><?= $res_dtl['standart_pemakaian']?></td>
                                                    <td style="text-align: right;"><?= $res_dtl['transfer_material']?></td>
                                                    <td style="text-align: right;"><?= $res_dtl['sisa_material']?></td>
                                                </tr>
                                              <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <hr>
                                    <div align="center">
                                        <h4><b>PERHITUNGAN VARIANCE PRODUKSI</b></h4>
                                    </div>  
                                <hr>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <table id="tabel_produksi" class="table table-striped table-bordered table-hover" width="100%">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">Barang</th>
                                                    <th>Standart</th>
                                                    <th>Pemakaian Material</th>
                                                    <th>Variance</th>
                                                    <th>MAP</th>
                                                    <th>Var Nominal</th>
                                                    <th>Var %</th>
                                                </tr>
                                            </thead>
                                            <tbody id="detail_input_produksi">
                                              <?php
                                                while($res_dtl = mysql_fetch_array($q_cspk_produksi)) { 
                                              ?>
                                                <tr>
                                                    <td><?=$res_dtl['kode_barang']?></td>
                                                    <td><?=$res_dtl['nama_barang']?></td>
                                                    <td style="text-align: right;"><?= $res_dtl['standart_pemakaian']?></td>
                                                    <td style="text-align: right;"><?= $res_dtl['pemakaian_material']?></td>
                                                    <td style="text-align: right;"><?= $res_dtl['var']?></td>
                                                    <td style="text-align: right;"><?=$res_dtl['map']?></td>
                                                    <td style="text-align: right;"><?=$res_dtl['var_nominal']?></td>
                                                    <td style="text-align: right;"><?=$res_dtl['var_persen']?>%</td>
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
