<?php 	
  include "pages/data/script/pg.php"; 
	include "library/form_akses.php";	
?>

<style>
  .pm-min, .pm-min-s{padding:3px 1px; }
  .animated{display:none;}

  table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    border: 1px solid #3c4f5f;
  }

  th {
      background: #87CEFA;
      text-align: center;
      color: #000000;
      padding: 8px;
      font-size: 13px;
  }

  td {
      text-align: left;
      padding: 8px;
      font-size: 13px;
  }

  tr:nth-child(even){background-color: #f2f2f2}

  p {
    font-size: 8px;
  }

   .pembatalan {
      background-color: #9c0303;
    }

   .pengembalian {
      background-color: #20b158;
    } 
</style>

<section class="content-header">
    <ol class="breadcrumb">
        <li><i class="fa fa-money"></i> Keuangan</li>
        <li>Pelunasan Giro</li>
        <li>Track Pelunasan Giro</li>
    </ol>
</section>
        
<section class="content">
    <div class="col-md-10">
      <?php
        $prev = mysql_fetch_array($q_pg_prev); {
        if (isset($prev['id_pg_hdr'])){
      ?>
          <a class="btn btn-warning" href="<?=base_url()?>?page=keuangan/pg_track&action=track&halaman= TRACK PELUNASAN GIRO&kode_pg=<?=$prev['kode_pg']?>">
            <i class="fa fa-chevron-left" aria-hidden="true"></i>
          </a>
      <?php
        } 
        } 

        $next = mysql_fetch_array($q_pg_next); {
        if (isset($next['id_pg_hdr'])){
      ?>
          &nbsp;<a class="btn btn-warning" href="<?=base_url()?>?page=keuangan/pg_track&action=track&halaman= TRACK PELUNASAN GIRO&kode_pg=<?=$next['kode_pg']?>">
            <i class="fa fa-chevron-right" aria-hidden="true"></i>
          </a>
      <?php
        } 
        }
      ?>
      	&nbsp;

      	<?php
			    $stat = mysql_fetch_array($status); 
          if($stat['status'] == '3'){
            $status1 = '';
            $status2 = 'hidden';
          }elseif($stat['status'] == '2'){
            $status1 = 'hidden';
            $status2 = '';
          }else{
            $status1 = 'hidden';
            $status2 = 'hidden';
          }
		?>
      	<!-- <a href="#modalPembatalan" class="btn pembatalan <?php echo $status1?>" style="color: white" data-toggle="modal"><i class=" fa fa-close"></i> PEMBATALAN</a>
        <a href="<?=base_url()?>?page=keuangan/pg_back&action=pengembalian&halaman= PENGEMBALIAN PELUNASAN GIRO&kode_pg=<?=$stat['kode_pg']?>" class="btn pengembalian <?php echo $status2?>" style="color: white"><i class=" fa fa-retweet"></i> PENGEMBALIAN</a> -->
      </div>
      <div class="col-md-2">
        <a href="#modalAddItem" class="btn btn-info" data-toggle="modal"><i class=" fa fa-book"></i> JURNAL</a> 
        &nbsp;
        <a href="<?=base_url()?>?page=keuangan/pg&halaman= PELUNASAN GIRO" class="btn btn-danger pull-right" ><i class=" fa fa-reply"></i> BACK</a>
      </div>
</section>

<div class="box box-info">
    <div class="box-body">
     	&nbsp;
		<?php
			$res_hdr = mysql_fetch_array($q_pg_hdr); 

			if($res_hdr['status'] == '1'){
				$status = 'MENUNGGU PELUNASAN';
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
			                         	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode PG</label>
			                         	<div class="col-lg-4">
			                             	<input type="text" class="form-control" name="kode_pg" id="kode_pg" placeholder="Auto..." readonly value="<?=$res_hdr['kode_pg']?>">
			                         	</div>

			                         	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">COA</label>
                                        <div class="col-lg-4">
                                            <select id="bank_coa" name="bank_coa" class="select2" style="width: 100%;" disabled>
                                                <option><?php echo $res_hdr['bank_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$res_hdr['nama_bank_coa'];?></option>
                                            </select>
                                        </div>
                         			 </div>

                         			 <div class="form-group">
				                     	 <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal Buat</label>
				                         <div class="col-lg-4">
				                         	<div class="input-group">
				                             <input type="text" name="tgl_buat" id="tgl_buat" class="form-control" placeholder="Tanggal Pelunasan Giro ..." value="<?=strftime("%A, %d %B %Y", strtotime($res_hdr['tgl_buat']))?>" autocomplete="off" disabled/>
				                             <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
				                            </div>
				                         </div>

				                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
				                         <div class="col-lg-4">
				                             <select id="kode_cabang" name="kode_cabang" class="select2" style="width: 100%;" disabled>
                                                <option><?php echo $res_hdr['nama_cabang'];?></option>
                                             </select>
				                         </div>
				                     </div>

				                     <div class="form-group">
				                     	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
					                        <div class="col-lg-4">
					                            <input type="text" autocomplete="off" class="form-control" name="ref" id="ref" placeholder="Ref..." value="<?=$res_hdr['ref']?>" readonly>
					                        </div>

					                    <?php
					                    	$nama = '';
					                    	$kode_giro = substr(strtolower($res_hdr['kode_giro']), -6, 2);

					                    	if($kode_giro === 'gm'){
					                    		$nama = 'Pelanggan';
					                    	}else{
					                    		$nama = 'Supplier';
					                    	}
					                    ?>

					                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left"><?php echo $nama ?></label>
			                                <div class="col-lg-4">
			                                    <select id="kode_user" name="kode_user" class="select2" disabled>
			                                        <option><?php echo $res_hdr['nama_user'];?></option>
			                                    </select>
			                                </div>   
				                     </div>
										<div class="form-group">
				                     	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode Giro</label>
					                        <div class="col-lg-4">
					                            <input type="text" autocomplete="off" class="form-control" name="kode_giro" id="kode_giro" placeholder="Kode Giro..." value="<?=$res_hdr['kode_giro']?>" readonly>
					                        </div>


				                     </div>
                     
				                     <div class="form-group">
				                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
				                         <div class="col-lg-10">
				                             <textarea type="text" class="form-control" name="keterangan_hdr" id="keterangan_hdr" placeholder="Keterangan..." readonly><?php echo $res_hdr['keterangan_hdr'];?></textarea>
				                         </div>
				                     </div> 

                                        
                                        <div class="form-group">
                     	                    <div class="col-lg-12">
                                              <table id="simple-table" class="table  table-bordered table-hover">
                                                <thead>
                                                    <?php
                                                        $n=1;
                                                    ?>
                                                    <tr>
                                                        <th style="width: 25px">No</th>
                                                        <th style="width:130px">Bank Giro</th>
                                                        <th style="width:130px">No Giro</th>
                                                        <th style="width:130px">Tgl Jatuh Giro</th>
                                                        <th style="width:100px">Nominal</th>
                                                        <th style="width:100px">Nominal Ditolak</th>
                                                        <th style="width:100px">Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
														$no = 1;                
                                                        while($res_dtl = mysql_fetch_array($q_pg_dtl)) {
													 ?>
                                                    	<tr <?=($res_dtl['status_dtl'] == '2' ? 'style="background-color: #f2dede"' : '');?>>
                                                          <td style="text-align: center"><?=$no++?></td>
                                                          <td><?=$res_dtl['bank_giro']?></td>
                                                          <td><?=$res_dtl['no_giro']?></td>
                                                          <td><?=strftime("%A, %d %B %Y", strtotime($res_dtl['tgl_jth_giro']))?></td>
                                                          <td style="text-align: right"><?= ($res_dtl['status_dtl'] == '2' ? 0 : number_format($res_dtl['nominal'], 2))?></td>
                                                          <td style="text-align: right"><?= ($res_dtl['status_dtl'] == '2' ? number_format($res_dtl['nominal'], 2) : 0)?></td>
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
                 <h4 class="modal-title">Kode PG : <?=$res_hdr['kode_pg']?></h4>
            </div>

            <form id="frm" name="frm"  method="post" action="">             
                <div class="modal-body" style="min-height: 150px">
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
                                          <td style="text-align:right; font-weight:bold"><?=number_format($row['debet'], 2)?></td>
                                          <td style="text-align:right; font-weight:bold"><?=number_format($row['kredit'], 2)?></td>
                                      </tr>
                                      <?php 
                                        }
                                          }else{
                                      ?>
                                      <tr>
                                        <td colspan="4" style="text-align:center">Jurnal dengan Kode PG ini telah dibatalkan !!</td>
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

                <!-- <h5 style="text-align: center">JURNAL MENYUSUL ^^</h5> -->
                  
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
                 <h4 class="modal-title" style="color: white">Pembatalan Kode PG : <?=$res_hdr['kode_pg']?></h4>
            </div>

            <form id="formPembatalan" method="post" enctype="multipart/form-data">             
                <div class="modal-body" style="min-height: 50px;">
                    <div class="control-group">
                        <div class="form-group">
			                <h4 style="color: black;">Alasan Batal :</h4>
			                <input type="hidden" class="form-control" name="kode_pg_batal" id="kode_pg_batal" value="<?=$res_hdr['kode_pg']?>">
			                <textarea type="text" class="form-control" name="alasan_batal" id="alasan_batal" placeholder="Alasan Batal..."></textarea>
			            </div>
                    </div>
                </div>

                <div class="modal-footer" style="background-color: #9a24241a; border-top: 1px solid #ab5d5d;">
                	<button type="submit" name="batal" id="batal" class="btn btn-default" onclick="return confirm('Anda yakin akan membatalkan Pelunasan Giro ini ?')">
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
                url: "<?=base_url()?>ajax/j_pg.php?func=pembatalan",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(html)
                {
                    var msg = html.split("||");
                    if(msg[0] == "00") {
                        window.location = '<?=base_url()?>?page=keuangan/pg&halaman= PELUNASAN GIRO&pembatalan='+msg[1];
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