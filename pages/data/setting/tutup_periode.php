<?php 	
include "pages/data/script/m_tutup_periode.php"; 
?>
<section class="content-header">
       
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-cog"></i> Setting</a></li>
          <li><a href="#">Tutup Periode</a></li>
        </ol>
</section>

            <!-- /.row -->
            <div class="box box-info">
            <div class="box-body">
            
            <!-- INFO BANNER FORM SAAT INPUT DAN UPDATE -->
            <?php
          	if (isset($_GET['inputsukses'])){
        		echo '<div class="alert alert-success"><i class="icon fa fa-check"></i> INPUT DATA BERHASIL</div>';
            }else if (isset($_GET['deletesukses'])){
				echo '<div class="alert alert-warning"><i class="icon fa fa-check"></i> BUKA DATA BERHASIL</div>';
			}
			?>
            <div class="row">
            
            <div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
                       	<div class="form-horizontal">
                        		<div class="form-group">
                                <form method="post" action="">
                                  <label class="col-lg-1 control-label" style="text-align:left">Bulan :</label>
                                    <div class="col-lg-2">
                                          <select class="select2" name="bulan" style="width: 100%;">
                                          <option value="0">-- PILIH BULAN --</option>
                                          <option value="01">JANUARI</option>
                                          <option value="02">FEBRUARI</option>
                                          <option value="03">MARET</option>
                                          <option value="04">APRIL</option>
                                          <option value="05">MEI</option>
                                          <option value="06">JUNI</option>
                                          <option value="07">JULI</option>
                                          <option value="08">AGUSTUS</option>
                                          <option value="09">SEPTEMBER</option>
                                          <option value="10">OKTOBER</option>
                                          <option value="11">NOVEMBER</option>
                                          <option value="12">DESEMBER</option>
                                          </select>
                                    </div>
                                    <label class="col-lg-1 control-label" style="text-align:left">Tahun :</label>
                                    <div class="col-lg-2">
                                            <input class="form-control" type="number" id="tahun" name="tahun" required>
                                    </div>
                                    <div class="col-lg-3">
                                	<button class="btn btn-danger" type="submit" name="simpan"><i class="fa fa-close" aria-hidden="true" style="margin-right:10px;"></i>Tutup</button>
                                    </div>
                                
                                </form>
                                </div>
                                
                                
                                
                                <div class="panel panel-default">
								<div class="panel-body">
                                <div class="box-body">
                                <div class="form-group">
                                <label class="col-lg-12 control-label" style="text-align:left; color:#F00"><b> PERIODE YANG SUDAH DITUTUP</b></label>
                                </div>
                                  <table id="example1" class="table table-bordered table-striped" width="100%">
                                    <thead>
                                        <tr>
                                          <th width="5%">No</th>
                                          <th width="19%">Periode</th>
                                          <th width="76%">Action</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>	
                                    <?php $no=1; while($res = mysql_fetch_array($q_tp)) { ;
									$bulantanggal = $res['bulan'];
									$pisah=explode("-",$bulantanggal);
									$bulan=$pisah[0];
									$tahun=$pisah[1];	
									$bulan_indo = bulan_indo($bulan)." ".$tahun;
									?>	
                                    
                                        <tr>
                                            <td><?=$no++?></td>
                                            <td style="font-weight:bold"><?=$bulan_indo;?></td>
                                            <td><a class="btn-sm btn-success" href="<?=base_url()?>?page=setting/tutup_periode&action=hapus&id=<?=$res['id']?>" onclick="return confirm('Anda yakin buka periode ini?')" style="font-style:italic;"><i class="fa fa-check"></i> Buka</a> 
                                            </td>
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

<script src="<?=base_url()?>assets/select2/select2.js"></script>
<script>
  $(".select2").select2({
        width: '100%'
    });
</script>
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>