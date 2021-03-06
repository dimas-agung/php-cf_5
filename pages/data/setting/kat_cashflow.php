<?php 	
  include "pages/data/script/m_kat_cashflow.php"; 
?>

<section class="content-header">
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cog"></i> Setting</a></li>
    <li><a href="#">Kategori Cashflow</a></li>
  </ol>
</section>

            <!-- /.row -->
            <div class="box box-info">
            <div class="box-body">
            
            <!-- INFO BANNER FORM SAAT INPUT DAN UPDATE -->
            <?php
          	if (isset($_GET['inputsukses'])){
        		echo '<div class="alert alert-success"><i class="icon fa fa-check"></i> INPUT DATA BERHASIL</div>';
            }else if (isset($_GET['updatesukses'])){
				echo '<div class="alert alert-info"><i class="icon fa fa-check"></i> UPDATE DATA BERHASIL</div>';
			}
			?>
            
                             <div class="tabbable">
											<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
												<li <?=$class_form?>>
													<a data-toggle="tab" href="#menuFormPp">Form Kategori Cashflow</a>
												</li>
                                                <li <?=$class_tab?>>
													<a data-toggle="tab" href="#menuListPp">List Kategori Cashflow</a>
												</li>
                                                
											</ul>
		

			<div class="row">
			<div class="tab-content">
				<div id="menuFormPp" <?=$class_pane_form?> >
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-body">
                                	<div class="form-horizontal">
                                  	
									<form action="" method="post">
<?php
								if(isset($_GET['action']) and $_GET['action'] == "edit") {
									$row = mysql_fetch_array($q_edit_cf);
								}
								?>             
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode <b style="color: red;">*</b></label>
                         <div class="col-lg-5">
                             <input type="text" required class="form-control" name="kode_kat_cashflow" id="kode_kat_cashflow" placeholder="Kode kategori cashflow..." <?=(isset($row['id_kat_cashflow']) ? "readonly": "")?> value="<?=(isset($row['id_kat_cashflow']) ? $row['kode_kat_cashflow'] : "")?>">
                         </div>
						 <span id="pesan" class="span" style="color:#F00; font-weight:bold"></span>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Nama <b style="color: red;">*</b></label>
                         <div class="col-lg-10">
                             <input type="text" required class="form-control" name="nama" id="nama" placeholder="Nama..." value="<?=(isset($row['id_kat_cashflow']) ? $row['nama'] : "")?>">
                         </div>
                     </div>
                     
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Header <b style="color: red;">*</b></label>
                         <div class="col-lg-10">

						<select id="header" name="header" class="select2">
                        <option value="0">-- Pilih Header --</option>
                           <?php 
					 //CEK JIKA KODE kat_aset ADA MAKA SELECTED	   
					 (isset($row['id_kat_cashflow']) ? $header=$row['header'] : $header='');	   					 					 //UNTUK AMBIL metodenya 	
                     while($rowheader = mysql_fetch_array($q_header)) { ;?>
                     
                        <option value="<?php echo $rowheader['kode_header'];?>" <?php if($rowheader['kode_header']==$header){echo 'selected';} ?>><?php echo $rowheader['keterangan'];?> </option>
                           <?php } ?>
                        </select>
                         </div>
                     </div>
                     
                     <label><b style="color: red;">* &nbsp;Wajib Diisi</b></label>
                     
                     
                 <div align="center" class="form-group">
                     <button class="btn btn-success <?=(isset($row['id_kat_cashflow']) ? "update" : "simpan")?>" type="submit" name="<?=(isset($row['id_kat_cashflow']) ? "update" : "simpan")?>"><i class="fa fa-pencil"></i> Simpan&nbsp;</button>
                     <a href="?page=setting/kat_cashflow&halaman= KATEGORI CHASHFLOW" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>
                 </div>
                 					</form>

<!-- Tambah Item Proyek       --->

									</div>	
                                </div>
								<!-- /.panel-body -->
							</div>                       
							<!-- /.panel-default -->
						</div>
						<!-- /.col-lg-12 -->					
				</div>
				
				<div id="menuListPp" <?=$class_pane_tab?> >					
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-body">	
                                	
                                    <form method="post" action="">
                                	<div align="right" class="form-group">
                      <label class="col-md-4 control-label" style="text-align:right">Status</label>
                      <div style="text-align: left" class="col-md-3 form-group">
                        <select class="select2" name="status">
                          <option value="semua" <?php if(isset($_POST['cari'])) {if($_POST['status']=='semua'){ echo 'selected';}} ?>>semua</option>
                          <option value="y" <?php if(isset($_POST['cari'])) {if($_POST['status']=='y'){ echo 'selected';}} ?>>aktif</option>
                          <option value="n" <?php if(isset($_POST['cari'])) {if($_POST['status']=='n'){ echo 'selected';}} ?>>nonaktif</option>
                        </select>
                      </div>
                      
                      <div align="left" class="form-group" >
                        <input type="submit" class="btn btn-primary btn-sm" name="cari" value="Cari">   
                      </div>  
                    </div>
                                    </form>
                                        		
                                					
									
            
            <div class="box-body">        
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                	<tr>
                      <th style="text-align: center">No</th>
                      <th style="text-align: center">Kode Kategori CF</th>
                      <th style="text-align: center">Nama</th>
                      <th style="text-align: center">Header</th>
                      <th style="text-align: center">Aktif</th>
                      <th style="text-align: center">Action</th>
                    </tr>
                </thead>
                
                <tbody>	
                <?php $no=1; while($res = mysql_fetch_array($q_cf)) { ;?>	
          				<tr>
              				<td style="text-align: center"><?=$no++?></td>
              				<td><a href="<?=base_url()?>?page=setting/kat_cashflow_track&action=track&halaman= TRACK KATEGORI CHASHFLOW&id_kat_cashflow=<?=$res['id_kat_cashflow']?>"><?=$res['kode_kat_cashflow']?></a></td>
                      <td><?=$res['nama']?></td>
                      <td><?=$res['ket_header']?></td>
                      <td style="text-align: center"><?=($res['aktif']=='1' ? '<span class="btn-sm btn-success fa fa-check"></span>' : '<span class="btn-sm btn-danger fa fa-remove"></span>')?></td>
                      <td style="text-align: center">
                        <a class="btn-sm btn-info" href="<?=base_url()?>?page=setting/kat_cashflow&action=edit&halaman= EDIT KATEGORI CHASHFLOW&id_kat_cashflow=<?=$res['id_kat_cashflow']?>" style="font-style:italic;"><i class="fa fa-edit"></i></a> 
                        <?php if ($res['aktif']=='1'){?>
                  			<a class="btn-sm btn-danger" href="<?=base_url()?>?page=setting/kat_cashflow&action=nonaktif&id_kat_cashflow=<?=$res['id_kat_cashflow']?>" onclick="return confirm('Anda yakin menonaktifkan data ini?')"><i class="fa fa-remove"></i></a> 
                        <?php }else{ ?>
                        <a class="btn-sm btn-success" href="<?=base_url()?>?page=setting/kat_cashflow&action=aktif&id_kat_cashflow=<?=$res['id_kat_cashflow']?>"><i class="fa fa-check"></i></a>
                        <?php } ?>
                      </td>
          				</tr>
				        <?php } ?>  
                </tbody>
              </table>
            </div>			
            				
								</div>
								<!-- /.panel-body -->
							</div>                       
							<!-- /.panel-default -->
						</div>
						<!-- /.col-lg-12 -->	
                        

						
				</div>
			</div>			
			</div>
			<!-- /.row -->
        
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
<script>
	$(document).ready(function(){
	$('#kode_kat_cashflow').change(function(){
		$('#pesan').html('<img style="margin-left:1px; width:20px"  src="<?=base_url()?>images/loading.gif">');
		var kode_kat_cashflow = $(this).val();

		$.ajax({
			type	: 'POST',
			url 	: '<?=base_url()?>ajax/j_validasi.php?func=loadkodekat_cashflow',
			data 	: 'kode_kat_cashflow='+kode_kat_cashflow,
			success	: function(data){
				$('#pesan').html(data);
			}
		})

	});
});
</script>
<script type="text/javascript">

	$(document).ready(function(){
		$('.simpan').click(function(){
			
		$span = $(".span");
		
			if ($('#kode_kat_cashflow').val()=='')
			{
				alert("Kode tidak Boleh Kosong");
				$('#kode_kat_cashflow').focus();
				return false;
			}
			
			if ($('#header').val()=='0'){
				alert("Header belum dipilih");
				$('#header').focus();
				return false;
			}
			
			if($span.text() != ""){
				$('#kode_kat_cashflow').focus();
				return false;
			}
			
		});	
	});			
</script>