<?php 	include "pages/data/script/m_kat_inv.php"; 
?>
<section class="content-header">
       
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-cog"></i> Setting</a></li>
          <li>
          	<a href="#">Kategori Barang</a>

          </li>
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
													<a data-toggle="tab" href="#menuFormPp">Form Kategori Barang</a>
												</li>
                                                <li <?=$class_tab?>>
													<a data-toggle="tab" href="#menuListPp">List Kategori Barang</a>
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
									$row = mysql_fetch_array($q_edit_ki);
								}
								?>             
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode <br /><font color="#FF0000">*) harus 2 karakter</font></label>
                         <div class="col-lg-5">
                             <input type="text" required class="form-control" name="kode_kategori_inv" id="kode_kategori_inv" placeholder="Kode kategori Barang..." <?=(isset($row['id_kategori_inventori']) ? "readonly": "")?> value="<?=(isset($row['id_kategori_inventori']) ? $row['kode_kategori_inventori'] : "")?>" maxlength="2">
                         </div>
						 <span id="pesan" class="span" style="color:#F00; font-weight:bold"></span>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kategori Inventori <b style="color: red;">*</b></label>
                         <div class="col-lg-10">
                             <input type="text" required class="form-control" name="nama" id="nama" placeholder="Kategori Barang..." value="<?=(isset($row['id_kategori_inventori']) ? $row['nama'] : "")?>">
                         </div>
                     </div>
                    
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Jenis <b style="color: red;">*</b></label>
                         <div class="col-lg-10">
<!--                             <input type="text" class="form-control" name="kode_pusat" id="kode_pusat" placeholder="Pusat..."> -->
						<select id="pilihan_stok" name="pilihan_stok" class="select2">
                        <option value="0">-- Pilih --</option>
                           <?php 
					 //CEK JIKA KODE kategori inventori ADA MAKA SELECTED	   
					 (isset($row['id_kategori_inventori']) ? $pilihan_stok=$row['pilihan_stok'] : $pilihan_stok='');	   					 //UNTUK AMBIL CABANGNYA 	
                     while($rowpilstok = mysql_fetch_array($q_pilihan_stok)) { ;?>
                     
                                    <option value="<?php echo $rowpilstok['id_pilihan_stok'];?>" <?php if($rowpilstok['id_pilihan_stok']==$pilihan_stok){echo 'selected';} ?>><?php echo $rowpilstok['nama'];?> </option>
                           <?php } ?>
                        </select>
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                         <div class="col-lg-10">
                             <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan..." value="<?=(isset($row['id_kategori_inventori']) ? $row['keterangan'] : "")?>" >
                         </div>
                     </div>
                     
                     <label><b style="color: red;">* &nbsp;Wajib Diisi</b></label>
                     
                     
                 <div align="center" class="form-group">
                     <button class="btn btn-success <?=(isset($row['id_kategori_inventori']) ? "update" : "simpan")?>" type="submit" name="<?=(isset($row['id_kategori_inventori']) ? "update" : "simpan")?>"><i class="fa fa-pencil"></i> Simpan&nbsp;</button>
                     <a href="?page=setting/kat_inv&halaman= KATEGORI BARANG" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>
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
                      <th style="text-align: center">Kode Kategori Barang</th>
                      <th style="text-align: center">Kategori Barang</th>
                      <th style="text-align: center">Keterangan</th>
                      <th style="text-align: center">Aktif</th>
                      <th style="text-align: center">Action</th>
                    </tr>
                </thead>
                
                <tbody>	
                <?php $no=1; while($res = mysql_fetch_array($q_ki)) { ;?>	
    				<tr>
        				<td style="text-align: center"><?=$no++?></td>
        				<td><a href="<?=base_url()?>?page=setting/kat_inv_track&action=track&halaman= TRACK KATEGORI BARANG&id_kategori_inventori=<?=$res['id_kategori_inventori']?>"><?=$res['kode_kategori_inventori']?></a></td>
                        <td><?=$res['nama']?></td>
						<td><?=$res['keterangan']?></td>
                        <td style="text-align: center"><?=($res['aktif']=='1' ? '<span class="btn-sm btn-success fa fa-check"></span>' : '<span class="btn-sm btn-danger fa fa-remove"></span>')?></td>
                        <td style="text-align: center"><a class="btn-sm btn-info" href="<?=base_url()?>?page=setting/kat_inv&action=edit&halaman= EDIT KATEGORI BARANG&id_kategori_inventori=<?=$res['id_kategori_inventori']?>" style="font-style:italic;"><i class="fa fa-edit"></i></a> 
                        <?php if ($res['aktif']=='1'){?>
            			<a class="btn-sm btn-danger" href="<?=base_url()?>?page=setting/kat_inv&action=nonaktif&id_kategori_inventori=<?=$res['id_kategori_inventori']?>" onclick="return confirm('Anda yakin menonaktifkan data ini?')"><i class="fa fa-remove"></i></a> 
                        <?php }else{ ?>
                        <a class="btn-sm btn-success" href="<?=base_url()?>?page=setting/kat_inv&action=aktif&id_kategori_inventori=<?=$res['id_kategori_inventori']?>"><i class="fa fa-check"></i></a>
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

<script type="text/javascript">
$(document).ready(function(){
    $('.pb-save').click(function(){
       
        
    });
});
</script> 
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
	$('#kode_kategori_inv').change(function(){
		$('#pesan').html('<img style="margin-left:1px; width:20px"  src="<?=base_url()?>images/loading.gif">');
		var kode_kategori_inv = $(this).val();

		$.ajax({
			type	: 'POST',
			url 	: '<?=base_url()?>ajax/j_validasi.php?func=loadkodekat_inv',
			data 	: 'kode_kategori_inv='+kode_kategori_inv,
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
		
			if ($('#kode_kategori_inv').val()=='')
			{
				alert("Kode tidak Boleh Kosong");
				$('#kode_kategori_inv').focus();
				return false;
			}
			
			if ($('#pilihan_stok').val()=='0'){
				alert("Jenis belum dipilih");
				return false;
			}
			
			if($span.text() != ""){
				$('#kode_kategori_inv').focus();
				return false;
			}
			
		});	
	});			
</script>