<?php 	
include "pages/data/script/m_pelanggan.php"; 
?>
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-database"></i> Master</a></li>
        <li><a href="#">Pelanggan</a></li>
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
				<li <?=$class_form?>> <a data-toggle="tab" href="#menuFormPp">Data Pelanggan</a></li>
                <li <?=$class_tab2?>> <a data-toggle="tab" href="#detail">Detail</a></li>
                <li <?=$class_tab1?>> <a data-toggle="tab" href="#akunting">Accounting</a> </li>
                <li <?=$class_tab?>> <a data-toggle="tab" href="#menuListPp">List Pelanggan</a></li>
            </ul>
		
<div class="row">
<div class="tab-content">
	<div id="menuFormPp" <?=$class_pane_form?> >
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
                    <div class="form-horizontal">
                        <form action="" method="post" id="saveForm">

                         <div class="form-group">
                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode <b style="color: red;">*</b></label>
                             <div class="col-lg-4">
                                 <input type="text" class="form-control" name="kode_pelanggan" id="kode_pelanggan" placeholder="Kode Pelanggan..." value="">
                             </div>
							 <span id="pesan" class="span" style="color:#F00; font-weight:bold"></span>
                         </div>

						 <div class="form-group">
                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Nama <b style="color: red;">*</b></label>
                             <div class="col-lg-4">
                                 <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama..." value="">
                             </div>

                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Salesman <b style="color: red;">*</b></label>
                             <div class="col-lg-4">
                                <select id="salesman" name="salesman" class="select2" style="width: 100%;">
                                    <option value="0">-- Pilih Salesman --</option>
                                    <?php while($rowsales = mysql_fetch_array($q_ddl_salesman)) { ;?>
                                        <option value="<?php echo $rowsales['kode_karyawan'];?>"><?php echo $rowsales['nama'];?> </option>
                                    <?php } ?>
                                </select>    
                             </div>
                         </div>

                         <div class="form-group">
                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kategori Pelanggan <b style="color: red;">*</b></label>
                                <div class="col-lg-10">
                                    <select id="kategori_pelanggan" name="kategori_pelanggan" class="select2" style="width: 100%;">
                                    <option value="0">-- Pilih Kategori Pelanggan --</option>
                                        <?php  
                                        while($rowkat_pel = mysql_fetch_array($q_ddl_kat_pel)) { ;?>
                                 
                                        <option value="<?php echo $rowkat_pel['kode_kategori_pelanggan'];?>"><?php echo $rowkat_pel['nama'];?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                         </div>

                         <div class="form-group">
                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Alamat</label>
                             <div class="col-lg-4">
                                 <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat..." value="">
                             </div>

                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kecamatan</label>
                             <div class="col-lg-4">
                                 <input type="text" class="form-control" name="kecamatan" id="kecamatan" placeholder="Kecamatan..." value="">
                             </div>
                         </div>

                         <div class="form-group">
                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kota</label>
                             <div class="col-lg-4">
                                 <input type="text" class="form-control" name="kota" id="kota" placeholder="Kota..." value="">
                             </div>

                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Provinsi</label>
                             <div class="col-lg-4">
                                 <input type="text" class="form-control" name="propinsi" id="propinsi" placeholder="Provinsi..." value="">
                             </div>
                         </div>

                         <div class="form-group">
                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Negara</label>
                             <div class="col-lg-4">
                                 <input type="text" class="form-control" name="negara" id="negara" placeholder="Negara..." value="">
                             </div>

                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">No Telpon</label>
                             <div class="col-lg-4">
                                 <input type="text" class="form-control" name="telpon" id="telpon" placeholder="No Telpon..." value="">
                             </div>
                         </div>

                         <div class="form-group">
                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kontak Person</label>
                             <div class="col-lg-4">
                                 <input type="text" class="form-control" name="kontak" id="kontak" placeholder="Kontak Person..." value="">
                             </div>

                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">No Handphone</label>
                             <div class="col-lg-4">
                                 <input type="text" class="form-control" name="hp" id="hp" placeholder="No HP..." value="">
                             </div>
                         </div>

                         <div class="form-group">
                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Email</label>
                            <div class="col-lg-4">
                                 <input type="text" class="form-control" name="email" id="email" placeholder="Email..." value="">
                            </div>

                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ppn</label>
                            <div class="col-lg-4">
                                 <div class="checkbox">
                                <label>
                                    <input name="ppn" type="checkbox" class="ace" <?=(isset($row['id_pelanggan']) ? $ppn=$row['ppn'] : $ppn='2')?> 
                                    <?php if($ppn==1){
                                    echo 'checked="checked"';	
                                    }else{
                                    echo '';	}?> /><span class="lbl"></span>
                                 </label>
                                </div>   
                             </div>
                         </div>

                         <div class="form-group">
                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">No NPWP</label>
                             <div class="col-lg-4">
                                 <input type="text" class="form-control" name="npwp" id="npwp" placeholder="No NPWP..." value="">
                             </div>

                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">No KTP</label>
                             <div class="col-lg-4">
                                 <input type="text" class="form-control" name="ktp" id="ktp" placeholder="No KTP..." value="">
                             </div>
                         </div>

                         <div class="form-group">
                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                             <div class="col-lg-10">
                                 <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan..." value="">
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
				<div id="detail" <?=$class_pane_tab2?> >
					<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-body">
                                	<div class="form-horizontal"> 
                                    	<div class="form-group">
                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Plafon (Rp)</label>
                                         <div class="col-lg-4">
                                             <input type="text" class="form-control" name="plafon_kredit" id="plafon_kredit" placeholder="Plafon..." value="">
                                         </div>
                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Term om payment</label>
                                         <div class="col-lg-3">
                                             <input type="text" class="form-control" name="jatuh_tempo" id="jatuh_tempo" placeholder="TOP..." value=""> 
                                         </div>
                                         <label class="col-lg-1 col-sm-2 control-label" style="text-align:left">hari</label>
                                     </div>
                                                                  
                                     <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left"><h3>Bank : </h3></label>
                                     </div>                               
                                     <div class="form-group">
                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Bank</label>
                                         <div class="col-lg-10">
                                             <input type="text" class="form-control" name="bank" id="bank" placeholder="Bank..." value="">
                                         </div>
                                         
                                     </div>
                                     <div class="form-group">
                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Atas Nama</label>
                                         <div class="col-lg-4">
                                             <input type="text" class="form-control" name="bank_an" id="bank_an" placeholder="Atas nama..." value="">
                                         </div>
                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">No Rek Bank</label>
                                         <div class="col-lg-4">
                                             <input type="text" class="form-control" name="bank_no_rek" id="bank_no_rek" placeholder="No Rek Bank..." value="">
                                         </div>
                                     </div>   
                                     
                                     <div class="form-group">
                                        <label class="col-lg-12 col-sm-2 control-label" style="text-align:left"><h3>Alamat Penagihan :</h3></label>
                                     </div>                               
                                     <div class="form-group">
                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Nama</label>
                                         <div class="col-lg-10">
                                             <input type="text" class="form-control" name="nama_penagihan" id="nama_penagihan" placeholder="Nama Penagihan..." value="">
                                         </div>
                                         
                                     </div>
                                     <div class="form-group">
                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Alamat</label>
                                         <div class="col-lg-10">
                                             <textarea class="form-control" name="alamat_penagihan" id="alamat_penagihan" placeholder="Alamat Penagihan..."></textarea>
                                         </div>
                                     </div>
                                     <div class="form-group">    
                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kota</label>
                                         <div class="col-lg-10">
                                             <input type="text" class="form-control" name="kota_penagihan" id="kota_penagihan" placeholder="Kota Penagihan..." value="">
                                         </div>
                                     </div>                           
                                                                        
                                         <div align="center" class="form-group">
                                            <a id="next-btn2" class="btn btn-primary"><i class=" fa fa-mail-forward"></i> Next</a>
                                         </div>
                                    </div>
                                </div>
                            </div>
                     </div>
                 </div>                 
                                                  
<!-- AKUNTING -->
				<div id="akunting" <?=$class_pane_tab1?> >
					<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-body">
                                	<div class="form-horizontal">

                                    	    <div class="form-group">
                                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Coa Debet <b style="color: red;">*</b></label>
                                                 <div class="col-lg-10">
                                                     <select id="coa_debet" name="coa_debet" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Debet --</option>
                                                   <?php 	
                                             while($rowcoadeb = mysql_fetch_array($q_ddl_coa)) { ;?>
                                             
                                                <option value="<?php echo $rowcoadeb['kode_coa'];?>"><?php echo $rowcoadeb['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowcoadeb['nama'];?> </option>
                                                   <?php } ?>
                                                </select>
                                                 </div>
                                             </div>     
                                             <div class="form-group">
                                                 <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Coa Kredit <b style="color: red;">*</b></label>
                                                 <div class="col-lg-10">
                                                     <select id="coa_kredit" name="coa_kredit" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Kredit --</option>
                                                   <?php  	
                                             while($rowcoakred = mysql_fetch_array($q_ddl_coa2)) { ;?>
                                             
                                                <option value="<?php echo $rowcoakred['kode_coa'];?>"><?php echo $rowcoakred['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowcoakred['nama'];?> </option>
                                                   <?php } ?>
                                                </select>
                                                 </div>
                                             </div>  

                                             <label><b style="color: red;">* &nbsp;Wajib Diisi</b></label>    
                                             
                                             <div align="center" class="form-group">
                                             <button class="btn btn-success <?=(isset($row['id_pelanggan']) ? "update" : "simpan")?>" type="submit" name="<?=(isset($row['id_pelanggan']) ? "update" : "simpan")?>"><i class="fa fa-pencil"></i> Simpan&nbsp;</button>
                                             <a href="?page=master/pelanggan" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>
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
                      <th style="text-align: center">Alamat</th>
                      <th style="text-align: center">Kota</th>
                      <th style="text-align: center">Ppn</th>
                      <th style="text-align: center">Aktif</th>
                      <th style="text-align: center">Action</th>
                    </tr>
                </thead>
                
                <tbody>	
                <?php $no=1; while($res = mysql_fetch_array($q_pel)) { ;?>	
    				<tr>
        				<td style="text-align: center"><?=$no++?></td>
        				<td><a href="<?=base_url()?>?page=master/pelanggan_track&action=track&halaman= TRACK PELANGGAN&id_pelanggan=<?=$res['id_pelanggan']?>&kode_kategori_pelanggan=<?=$res['kategori_pelanggan']?>"><?=$res['kode_pelanggan']?></a></td>
                        <td><?=$res['nama']?></td>
                        <td><?=$res['alamat']?></td>
                        <td><?=$res['kota']?></td>
                        <td style="text-align: center"><i class="fa fa-<?php echo ($res['PPn']==1)?"check-square-o":"square-o" ; ?>"></i></td>
                        <td style="text-align: center"><?=($res['aktif']=='1' ? '<span class="btn-sm btn-success fa fa-check"></span>' : '<span class="btn-sm btn-danger fa fa-remove"></span>')?></td>
                        <td style="text-align: center"><a class="btn-sm btn-info" href="<?=base_url()?>?page=master/pelanggan_edit&action=edit&halaman= EDIT PELANGGAN&id_pelanggan=<?=$res['id_pelanggan']?>&kode_kategori_pelanggan=<?=$res['kategori_pelanggan']?>" style="font-style:italic;"><i class="fa fa-edit"></i></a> 
                        <?php if ($res['aktif']=='1'){?>
            			<a class="btn-sm btn-danger" href="<?=base_url()?>?page=master/pelanggan&action=nonaktif&id_pelanggan=<?=$res['id_pelanggan']?>" onclick="return confirm('Anda yakin menonaktifkan data ini?')"><i class="fa fa-remove"></i></a> 
                        <?php }else{ ?>
                        <a class="btn-sm btn-success" href="<?=base_url()?>?page=master/pelanggan&action=aktif&id_pelanggan=<?=$res['id_pelanggan']?>"><i class="fa fa-check"></i></a>
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
      font-size: 14px;
  }

  td {
      text-align: left;
      padding: 8px;
      font-size: 12px;
  }

  tr:nth-child(even){background-color: #f2f2f2}
</style> 

<script>
    $(document).ready(function (e) {
    	$("#saveForm").on('submit',(function(e) {
    		var grand_total = $("#kode_pelanggan").val();
        		e.preventDefault();
        	  	if(grand_total != null) {	
        			$.ajax({
        				url         : "<?=base_url()?>ajax/r_pelanggan.php?func=save",
        				type        : "POST",
        				data        : new FormData(this),
        				contentType : false,
        				cache       : false,
        				processData : false,
        				success     : function(html)
        				{
        				    window.location = '<?=base_url()?>?page=master/pelanggan&inputsukses&halaman= PELANGGAN';
        				}   
        		    });
        	  	}else{
                    notifError("<p>Item masih kosong.</p>");
                }
    	}));
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
	$('#kode_pelanggan').change(function(){
		$('#pesan').html('<img style="margin-left:1px; width:20px"  src="<?=base_url()?>images/loading.gif">');
		var kode_pelanggan = $(this).val();

		$.ajax({
			type	: 'POST',
			url 	: '<?=base_url()?>ajax/j_validasi.php?func=loadkode_pelanggan',
			data 	: 'kode_pelanggan='+kode_pelanggan,
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
		
			if ($('#kode_pelanggan').val()=='')
			{
			    alert("Kode tidak Boleh Kosong");
				$('#kode_pelanggan').focus();
				return false;
			}
			
			if($('#kode_pelanggan').val() == '' ) {
				alert("Pelanggan => Kode, belum diisi");
				return false;
			}

			if($('#nama').val() == '' ) {
				alert(" Pelanggan => Nama, belum diisi");
				return false;
			}

            if($('#salesman').val() == '0' ) {
                alert(" Pelanggan => Salesman, belum dipilih");
                return false;
            }

			if($('#kategori_pelanggan').val() == '0' ) {
				alert(" Pelanggan => Kategori Pelanggan, belum dipilih");
				return false;
			}

            if($span.text() != ""){
                alert("Kode Sudah Terpakai");
                $('#kode_pelanggan').focus();
                return false;
            }

            if($('#coa_debet').val() == '0' ) {
                alert("Accounting => COA Debet, belum dipilih");
                return false;
            }

            if($('#coa_kredit').val() == '0' ) {
                alert("Accounting => COA Kredit, belum dipilih");
                return false;
            }
		});	
	});	
</script>