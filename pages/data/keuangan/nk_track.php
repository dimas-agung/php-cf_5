<?php 	
  include "pages/data/script/nk.php"; 
	include "library/form_akses.php";	
?>

<style>
  .pembatalan {
      background-color: #9c0303;
    }
</style>

<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-shopping-cart"></i>Keuangan</a></li>
        <li><a href="#">Track Nota Kredit</a></li>
    </ol>
        
    <section class="content">
		<a href="#modalPembatalan" class="btn pembatalan" style="color: white" data-toggle="modal"><i class=" fa fa-close"></i> PEMBATALAN</a>
        <a href="<?=base_url()?>?page=keuangan/nk" class="btn btn-md btn-danger pull-right" ><i class=" fa fa-reply"></i> BACK </a><br/>
   </section>
</section>

<div class="box box-info">
  <div class="box-body">
     	&nksp;
  		<?php
  			// HEADER
  			$res_hdr = mysql_fetch_array($q_nk_hdr); 
  		?>	

		<div class="row">
			<div class="tab-content">
				<div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-body">
              <div class="form-horizontal">

                <div class="form-group">
                  <label style="text-align:left" class="col-lg-2 col-sm-2 control-label">Kode NK</label>
                  <div class="col-lg-4">
                    <input type="text" class="form-control" name="kode_nk" id="kode_nk" placeholder="Kode nk..." readonly value="<?=$res_hdr['kode_nk']?>" readonly>
                  </div>

                  <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
                  <div class="col-lg-4">
                    <input type="text" class="form-control" name="ref" id="ref" placeholder="ref..." value="<?=$res_hdr['ref']?>" readonly/>
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

                  <label style="text-align:left" class="col-lg-2 col-sm-2 control-label">Tanggal</label>
                  <div class="col-lg-4">
                    <div class="input-group">
                      <input class="form-control date-picker" value="<?=$res_hdr['tgl_buat']?>" id="tgl_buat" name="tgl_buat" type="text" disabled/>
                      <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                    </div>
                  </div>
                </div>  

                <div class="form-group">
                  <label style="text-align:left" class="col-lg-2 col-sm-2 control-label">Jatuh Tempo</label>
                  <div class="col-lg-4">
                    <div class="input-group">
                      <input class="form-control date-picker" value="<?=$res_hdr['tgl_jth_tempo']?>" id="tgl_jth_tempo" name="tgl_jth_tempo" type="text" disabled />
                      <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                    </div>
                  </div>

                  <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Pelanggan / Supplier</label>
                  <div class="col-lg-4">
                    <select id="kode_user" name="kode_user" class="select2" style="width: 100%;" disabled>
                      <option value="<?php echo $res_hdr['kode_user'];?>">
                        <?php echo $res_hdr['kode_user'].' - '.$res_hdr['nama_user'];?> 
                      </option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                  <div class="col-lg-10">
                    <textarea  class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan..." disabled><?php echo $res_hdr['keterangan'];?></textarea>
                  </div>
                </div>  
                
                                            <div class="form-group">
                                              <div class="col-lg-12">
                                                <table id="" class="" rules="all">
                                                  <thead>
                                                    <?php
                                                      $n=1;
                                                    ?>
                                                    <tr>
                                                        <th width="10px">No</th>
                                                        <th>COA</th>
                                                        <th>Harga</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
														                          $no = 1;
														                          while($res_dtl = mysql_fetch_array($q_nk_dtl)) { 
                                                       
													                          ?>
                                                    	<tr>
                                                        <td style="text-align: center;"><?=$no++?></td>
                                                        <td><?= $res_dtl['kode_coa'].'&nksp;&nksp;||&nksp;&nksp;'.$res_dtl['nama_coa']?></td>
                                                        <td style="text-align: right;"><?= number_format($res_dtl['harga'], 2)?></td>
                                                        <td><?=$res_dtl['keterangan']?></td>
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
          </div>                       
        </div>
			</div>
		</div>

<!-- ============ MODAL PEMBATALAN =============== -->
<div id="modalPembatalan" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #9c0303">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                 <h4 class="modal-title" style="color: white">Pembatalan Kode NK : <?=$res_hdr['kode_nk']?></h4>
            </div>

            <form id="formPembatalan" method="post" enctype="multipart/form-data">             
                <div class="modal-body" style="min-height: 50px;">
                    <div class="control-group">
                        <div class="form-group">
                      <h4 style="color: black;">Alasan Batal :</h4>
                      <input type="hidden" class="form-control" name="kode_nk_batal" id="kode_nk_batal" value="<?=$res_hdr['kode_nk']?>">
                      <textarea type="text" class="form-control" name="alasan_batal" id="alasan_batal" placeholder="Alasan Batal..."></textarea>
                  </div>
                    </div>
                </div>

                <div class="modal-footer" style="background-color: #9a24241a; border-top: 1px solid #ab5d5d;">
                  <button type="submit" name="batal" id="batal" class="btn btn-default" onclick="return confirm('Anda yakin akan membatalkan Nota Kredit ini ?')">
                    <i class="fa fa-check" style="color: green"></i> Yes
                  </button>
                  &nksp;
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
                url: "<?=base_url()?>ajax/j_nk.php?func=pembatalan",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(html)
                {
                    var msg = html.split("||");
                    if(msg[0] == "00") {
                        window.location = '<?=base_url()?>?page=keuangan/nk&halaman= NOTA KREDIT&pembatalan='+msg[1];
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

<style>
  .pm-min, .pm-min-s{padding:3px 1px; }
  .animated{display:none;}

  table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 1100px;
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