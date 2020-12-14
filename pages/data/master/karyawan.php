<?php 	
    include "pages/data/script/m_karyawan.php"; 
?>
<section class="content-header">
       
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-cog"></i> Master</a></li>
          <li>
          	<a href="#">Karyawan</a>

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
													<a data-toggle="tab" href="#menuFormPp">Form Data Karyawan</a>
												</li>
                                                <li <?=$class_tab1?>>
													<a data-toggle="tab" href="#akunting">Detail</a>
												</li>
                                                <li <?=$class_tab?>>
													<a data-toggle="tab" href="#menuListPp">List Karyawan</a>
												</li>
                                                
											</ul>
		

			<div class="row">
			<div class="tab-content">
				<div id="menuFormPp" <?=$class_pane_form?> >
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-body">
                                	<div class="form-horizontal">
                                  	
									<form action="" enctype="multipart/form-data" method="post">

                                <?php
    								if(isset($_GET['action']) and $_GET['action'] == "edit") {
    									$row = mysql_fetch_array($q_edit_kry);
    								}
								?>   
                                
                     <div class="form-group">
                     	<label class="col-lg-8 col-sm-2 control-label" style="text-align:left"></label>
                        <div class="col-lg-2">
                        		
                        	<div> <img src="<?=(isset($row['id_karyawan']) ? "".base_url()."pages/data/upload_foto_karyawan/".$row['foto_karyawan'] : "".base_url()."images/user.png")?>"  id="foto_kary" width="150" height="150"><p> </div>	
                            
                            
                        
                             <input type="file" name="foto_karyawan" id="foto_karyawan" accept="image/*" onchange="loadFilekaryawan(event)">
                             
                             <input type="hidden" name="foto_karyawan1" id="foto_karyawan1" value="<?=$row['foto_karyawan']?>" />
                        </div>
                     </div>
                                          
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode <b style="color: red;">*</b></label>
                         <div class="col-lg-4">
                             <input type="text" class="form-control" name="kode_karyawan" id="kode_karyawan" placeholder="Kode karyawan..." <?=(isset($row['id_karyawan']) ? "readonly": "")?> value="<?=(isset($row['id_karyawan']) ? $row['kode_karyawan'] : "")?>">
                         </div>
                         <span id="pesan" class="span" style="color:#F00; font-weight:bold"></span>
                         
                     </div>
					 
					 <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Nama <b style="color: red;">*</b></label>
                         <div class="col-lg-4">
                             <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama karyawan..." value="<?=(isset($row['id_karyawan']) ? $row['nama'] : "")?>">
                         </div>
                     </div>
                     
                     <div class="form-group">
                     	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Alamat</label>
                         <div class="col-lg-4">
                         	 <textarea type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat..." ><?=(isset($row['id_karyawan']) ? $row['alamat'] : "")?></textarea>	
                         </div>
                         
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kelurahan</label>
                         <div class="col-lg-4">
                             <input type="text" class="form-control" name="kelurahan" id="kelurahan" placeholder="Kelurahan..." value="<?=(isset($row['id_karyawan']) ? $row['kelurahan'] : "")?>">
                         </div>	
                     </div>
                     
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kecamatan</label>
                         <div class="col-lg-4">
                             <input type="text" class="form-control" name="kecamatan" id="kecamatan" placeholder="Kecamatan..." value="<?=(isset($row['id_karyawan']) ? $row['kecamatan'] : "")?>">
                         </div>
                         
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kota</label>
                         <div class="col-lg-4">
                             <input type="text" class="form-control" name="kota" id="kota" placeholder="Kota..." value="<?=(isset($row['id_karyawan']) ? $row['kota'] : "")?>">
                         </div>
                     </div>
                     
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">KTP/SIM</label>
                         <div class="col-lg-4">
                         	<select class="select2" name="tanda_pengenal">
                                <option value="KTP" <?php if(isset($row['id_karyawan'])) {if($row['tanda_pengenal']=='KTP'){ echo 'selected';}} ?>>KTP</option>
                                <option value="SIM" <?php if(isset($row['id_karyawan'])) {if($row['tanda_pengenal']=='SIM'){ echo 'selected';}} ?>>SIM</option>
                             </select>
                             
                         </div>
                         
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">No. KTP/SIM</label>
                         <div class="col-lg-4">
                             <input type="text" class="form-control" name="no_tanda_pengenal" id="no_tanda_pengenal" placeholder="No Tanda Pengenal..." value="<?=(isset($row['id_karyawan']) ? $row['no_tanda_pengenal'] : "")?>">
                         </div>
                         
                     </div>
                     
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">No. KK</label>
                         <div class="col-lg-4">
                             <input type="text" class="form-control" name="no_kk" id="no_kk" placeholder="No KK..." value="<?=(isset($row['id_karyawan']) ? $row['no_kk'] : "")?>">
                         </div>
                         
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">NPWP</label>
                         <div class="col-lg-4">
                             <input type="text" class="form-control" name="no_npwp" id="no_npwp" placeholder="NPWP..." value="<?=(isset($row['id_karyawan']) ? $row['no_npwp'] : "")?>">
                         </div>
                     </div>
                     
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">BPJS Kesehatan</label>
                         <div class="col-lg-4">
                             <input type="text" class="form-control" name="bpjs_kesehatan" id="bpjs_kesehatan" placeholder="BPJS Kes..." value="<?=(isset($row['id_karyawan']) ? $row['bpjs_kesehatan'] : "")?>">
                         </div>
                         
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">BPJS TK</label>
                         <div class="col-lg-4">
                             <input type="text" class="form-control" name="bpjs_tk" id="bpjs_tk" placeholder="BPJS TK..." value="<?=(isset($row['id_karyawan']) ? $row['bpjs_tk'] : "")?>">
                         </div>    
                     </div>
                     
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">PTKP</label>
                         <div class="col-lg-10">
                         	<select class="select2" name="ptkp">
                                <option value="K/0" <?php if(isset($row['id_karyawan'])) {if($row['ptkp']=='K/0'){ echo 'selected';}} ?>>K/0</option>
                                <option value="K/1" <?php if(isset($row['id_karyawan'])) {if($row['ptkp']=='K/1'){ echo 'selected';}} ?>>K/1</option>
                                <option value="K/2" <?php if(isset($row['id_karyawan'])) {if($row['ptkp']=='K/2'){ echo 'selected';}} ?>>K/2</option>
                                <option value="K/3" <?php if(isset($row['id_karyawan'])) {if($row['ptkp']=='K/3'){ echo 'selected';}} ?>>K/3</option>
                             </select>
                             
                         </div>
                     </div>

                     <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal Masuk</label>
						<div class="col-lg-4">
												<input type="text" name="tanggal" id="tanggal" class="form-control date-picker"  value="<?=(isset($row['id_karyawan']) && !empty($row['tgl_masuk']) && $row['tgl_masuk'] !== '0000-00-00' ?  date("d-m-Y",strtotime($row['tgl_masuk'])) : '')?>"/>
						</div> 
                        
                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal Resign</label>
						<div class="col-lg-4">
												<input type="text" name="tanggal1" id="tanggal1" class="form-control date-picker"  value="<?=(isset($row['id_karyawan']) && !empty($row['tgl_resign']) && $row['tgl_resign'] !== '0000-00-00' ?  date("d-m-Y",strtotime($row['tgl_resign'])) : '')?>"/>
						</div> 
                     </div>
                     
                     <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left; font-size:12px">Upload Tanda Pengenal</label> 
						<div class="col-lg-4">
                        	<div> <img src="<?=(isset($row['id_karyawan']) ? "".base_url()."pages/data/upload_foto_karyawan/".$row['foto_tanda_pengenal'] : "".base_url()."images/folder.jpg")?>" id="foto_tp" width="150" height="150"><p> </div>	
                        
                             <input type="file" name="foto_tanda_pengenal" id="foto_tanda_pengenal" accept="image/*" onchange="loadFiletp(event)">
                             <input type="hidden" name="foto_tanda_pengenal1" id="foto_tanda_pengenal1" value="<?=$row['foto_tanda_pengenal']?>" />
                        </div>
                        
                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left; font-size:12px">Upload KK</label>
						<div class="col-lg-4">
                        	<div> <img src="<?=(isset($row['id_karyawan']) ? "".base_url()."pages/data/upload_foto_karyawan/".$row['foto_kk'] : "".base_url()."images/folder.jpg")?>" id="foto_k" width="150" height="150"><p> </div>	
                        
                             <input type="file" name="foto_kk" id="foto_kk" accept="image/*" onchange="loadFilekk(event)">
                             <input type="hidden" name="foto_kk1" id="foto_kk1" value="<?=$row['foto_kk']?>" />
                        </div>
								
                     </div>
         
                     <label><b style="color: red;">* &nbsp;Wajib Diisi</b></label>
                     
                     <div align="center" class="form-group">
						<a id="next-btn" class="btn btn-primary"><i class=" fa fa-mail-forward"></i> Next</a>
					 </div>

									</div>	
                                </div>
								<!-- /.panel-body -->
							</div>                       
							<!-- /.panel-default -->
						</div>
						<!-- /.col-lg-12 -->					
				</div>
                
<!-- AKUNTING -->
				<div id="akunting" <?=$class_pane_tab1?> >
					<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-body">
                                	<div class="form-horizontal">
                                    		<div class="form-group">
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Divisi</label>
                                             <div class="col-lg-4">
                                                 <input type="text" class="form-control" name="divisi" id="divisi" placeholder="Divisi..." value="<?=(isset($row['id_karyawan']) ? $row['divisi'] : "")?>">
                                             </div>
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Jabatan</label>
                                             <div class="col-lg-4">
                                                 <input type="text" class="form-control" name="jabatan" id="jabatan" placeholder="Jabatan..." value="<?=(isset($row['id_karyawan']) ? $row['jabatan'] : "")?>"> 
                                             </div>
                                             
                                         </div>
                                         <div class="form-group">
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kategori</label>
                                             <div class="col-lg-10">
                                                 <select id="kategori" name="kategori" class="select2" style="width: 100%;">
                                            <option value="0">-- Pilih Kategori --</option>
                                               <?php 
                                         //CEK JIKA KODE coa_debet ADA MAKA SELECTED	   
                                         (isset($row['id_karyawan']) ? $kategori=$row['kategori'] : $kategori='');	   					 					 //UNTUK AMBIL coanya 	
                                         while($rowkatkary = mysql_fetch_array($q_ddl_kat_kary)) { ;?>
                                         
                                            <option value="<?php echo $rowkatkary['nama'];?>" <?php if($rowkatkary['nama']==$kategori){echo 'selected';} ?>><?php echo $rowkatkary['nama'];?> </option>
                                               <?php } ?>
                                            </select>
                                             </div>
                                             
                                         </div>                               
                                         <div class="form-group">
                                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left"><h3>Bank :</h3></label>
                                         </div>                               
                                         <div class="form-group">
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Bank</label>
                                             <div class="col-lg-4">
                                                 <input type="text" class="form-control" name="nama_bank" id="nama_bank" placeholder="Bank..." value="<?=(isset($row['id_karyawan']) ? $row['nama_bank'] : "")?>">
                                             </div>
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
                                             <div class="col-lg-4">
                                                 <input type="text" class="form-control" name="cabang" id="cabang" placeholder="Cabang..." value="<?=(isset($row['id_karyawan']) ? $row['cabang'] : "")?>">
                                             </div>
                                         </div>
                                         <div class="form-group">
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Atas Nama</label>
                                             <div class="col-lg-4">
                                                 <input type="text" class="form-control" name="atas_nama" id="atas_nama" placeholder="Atas nama..." value="<?=(isset($row['id_karyawan']) ? $row['atas_nama'] : "")?>">
                                             </div>
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">No Rek Bank</label>
                                             <div class="col-lg-4">
                                                 <input type="text" class="form-control" name="no_rekening" id="no_rekening" placeholder="No Rek Bank..." value="<?=(isset($row['id_karyawan']) ? $row['no_rekening'] : "")?>">
                                             </div>
                                         </div>      
                                             
                                             <div align="center" class="form-group">
                                             <button class="btn btn-success <?=(isset($row['id_karyawan']) ? "update" : "simpan")?>" type="submit" name="<?=(isset($row['id_karyawan']) ? "update" : "simpan")?>"><i class="fa fa-pencil"></i> Simpan&nbsp;</button>
                                             <a href="?page=master/karyawan" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>
                                         </div>
                                         </form> 	
                                    </div>
                                </div>
                            </div>
                    </div>                
				</div>

<!-- END AKUNTING -->                
				
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
                      <th style="text-align: center">Kode</th>
                      <th style="text-align: center">Nama</th>
                      <th style="text-align: center">Divisi</th>
                      <th style="text-align: center">Jabatan</th>
                      <th style="text-align: center">Kategori</th>
                      <th style="text-align: center">Aktif</th>
                      <th style="text-align: center">Action</th>
                    </tr>
                </thead>
                
                <tbody>	
                <?php $no=1; while($res = mysql_fetch_array($q_kry)) { ;?>	
    				<tr>
        				<td style="text-align: center"><?=$no++?></td>
        				<td><a href="<?=base_url()?>?page=master/karyawan_track&action=track&id_karyawan=<?=$res['id_karyawan']?>"><?=$res['kode_karyawan']?></a></td>
                        <td><?=$res['nama']?></td>
                        <td><?=$res['divisi']?></td>
                        <td><?=$res['jabatan']?></td>
                        <td><?=$res['kategori']?></td>
                        <td style="text-align: center"><?=($res['aktif']=='1' ? '<span class="btn-sm btn-success fa fa-check"></span>' : '<span class="btn-sm btn-danger fa fa-remove"></span>')?></td>
                        <td style="text-align: center"><a class="btn-sm btn-info" href="<?=base_url()?>?page=master/karyawan&action=edit&id_karyawan=<?=$res['id_karyawan']?>" style="font-style:italic;"><i class="fa fa-edit"></i></a> 
                        <?php if ($res['aktif']=='1'){?>
            			<a class="btn-sm btn-danger" href="<?=base_url()?>?page=master/karyawan&action=nonaktif&id_karyawan=<?=$res['id_karyawan']?>" onclick="return confirm('Anda yakin menonaktifkan data ini?')"><i class="fa fa-remove"></i></a> 
                        <?php }else{ ?>
                        <a class="btn-sm btn-success" href="<?=base_url()?>?page=master/karyawan&action=aktif&id_karyawan=<?=$res['id_karyawan']?>"><i class="fa fa-check"></i></a>
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
  var loadFilekaryawan = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('foto_kary');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  };
</script>

<script>
  var loadFilekk = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('foto_k');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  };
</script>

<script>
  var loadFiletp = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('foto_tp');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  };
</script>

<script>
	$(document).ready(function(){
	$('#kode_karyawan').change(function(){
		$('#pesan').html('<img style="margin-left:1px; width:20px"  src="<?=base_url()?>images/loading.gif">');
		var kode_karyawan = $(this).val();

		$.ajax({
			type	: 'POST',
			url 	: '<?=base_url()?>ajax/j_validasi.php?func=loadkode_karyawan',
			data 	: 'kode_karyawan='+kode_karyawan,
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
			if ($('#kode_karyawan').val()=='')
			{
				alert("Kode tidak Boleh Kosong");
				$('#kode_karyawan').focus();
				return false;
			}

            if($('#nama').val() == '' ) {
                alert("Nama tidak boleh kosong");
                return false;
            }
			
			if($span.text() != ""){
				alert("Kode Sudah Terpakai");
				$('#kode_karyawan').focus();
				return false;
			}
			
		});	
	});	

    $(document).ready(function(){
        $('.update').click(function(){
            
        $span = $(".span");
            if ($('#kode_karyawan').val()=='')
            {
                alert("Kode tidak Boleh Kosong");
                $('#kode_karyawan').focus();
                return false;
            }

            if($('#nama').val() == '' ) {
                alert("Nama tidak boleh kosong");
                return false;
            }
            
            if($span.text() != ""){
                alert("Kode Sudah Terpakai");
                $('#kode_karyawan').focus();
                return false;
            }
            
        }); 
    }); 
</script>
<script>
    $(".date-picker").datepicker();
</script>