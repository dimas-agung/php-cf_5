<?php 	
    include "pages/data/script/pm.php"; 
	include "library/form_akses.php";	
?>

<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-shopping-cart"></i> Logistik</a></li>
        <li><a href="#">Track Permintaan Material</a></li>
    </ol>
        
    <section class="content">
        <a href="<?=base_url()?>?page=logistik/pm_list" class="btn btn-md btn-danger pull-right" ><i class=" fa fa-reply"></i> BACK </a><br/>
   </section>
</section>
<br><br>
<div class="box box-info">
    <div class="box-body">
        <?php
		    if(isset($_GET['action']) and $_GET['action'] == "track") {

                $kode_pm = ($_GET['kode_pm']);
                
                $q_pm_hdr = mysql_query("SELECT ph.*, c.nama nama_cabang, ga.nama gudang_asal, gt.nama gudang_tujuan FROM pm_hdr ph
                                            LEFT JOIN cabang c ON c.kode_cabang = ph.kode_cabang
                                            LEFT JOIN gudang ga ON ga.kode_gudang = ph.kode_gudang_asal 
                                            LEFT JOIN gudang gt ON gt.kode_gudang = ph.kode_gudang_tujuan 
                                            WHERE kode_pm = '".$kode_pm."' ");
                $res_hdr = mysql_fetch_array($q_pm_hdr); 
                
                $q_pm_dtl = mysql_query("SELECT pd.*, s.nama nama_satuan FROM pm_dtl pd 
                                            LEFT JOIN satuan s ON s.kode_satuan = pd.satuan 
                                            WHERE kode_pm = '".$kode_pm."' ORDER BY id_pm_dtl ASC");
            }
        ?>

<div class="row">
    <div class="tab-content">
		<div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-horizontal">

                        <div class="form-group">
                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode PM</label>
                            <div class="col-lg-4">
                                <input type="text" required class="form-control" name="kode_pm" id="kode_pm" placeholder="Auto..." readonly value="<?php echo $res_hdr['kode_pm'];?>">
                            </div>

                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
                            <div class="col-lg-4">
                                <input type="text" required class="form-control" name="ref" id="ref" placeholder="Ref..." value="<?php echo $res_hdr['ref'];?>" autocomplete="off" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode SPK</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="kode_spk" id="kode_spk" placeholder="Kode SPK..." value="<?php echo $res_hdr['kode_spk'];?>" readonly>
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
                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal PM</label>
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <input type="text" name="tgl_buat" id="tgl_buat" class="form-control" placeholder="Tanggal Permintaan Barang ..." value="<?php echo $res_hdr['tgl_buat'];?>" autocomplete="off" required readonly/>
                                        <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                </div>
                            </div>

                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Gudang Asal</label>
                            <div class="col-lg-4" id="load_gudang">
                                <select id="kode_gudang_asal" name="kode_gudang_asal" class="select2" style="width: 100%;" disabled>
                                    <option value="<?php echo $res_hdr['kode_gudang_asal'];?>">
                                        <?php echo $res_hdr['kode_gudang_asal'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$res_hdr['gudang_asal'];?> 
                                    </option>
                                </select>
                            </div> 
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Gudang Tujuan</label>
                            <div class="col-lg-4" id="load_gudang">
                                <select id="kode_gudang_tujuan" name="kode_gudang_tujuan" class="select2" style="width: 100%;" disabled>
                                    <option value="WH06">WH06 || PRODUKSI</option>
                                 </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                            <div class="col-lg-10">
                                <textarea type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan..." value="" readonly><?=$res_hdr['keterangan']?></textarea>
                            </div>
                        </div>
                                        
                        <div class="form-group">
                     	    <div class="col-lg-12">
                                <table id="" class="" rules="all">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Inventori</th>
                                            <th>Satuan</th>
                                            <th>QTY</th>
                                            <th>QTY Ditransfer</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; while($res_dtl = mysql_fetch_array($q_pm_dtl)) { ;?>  
                                            <tr>
                                                <td><?php echo $res_dtl['kode_barang']; ?></td>
                                                <td><?php echo $res_dtl['nama_barang']; ?></td>
                                                <td><?php echo $res_dtl['nama_satuan']; ?></td>
                                                <td style="text-align: right;"><?php echo $res_dtl['qty']; ?></td>
                                                <td style="text-align: right;"><?php echo $res_dtl['qty_ditransfer']; ?></td>
                                                <td><?php echo $res_dtl['keterangan']; ?></td>
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