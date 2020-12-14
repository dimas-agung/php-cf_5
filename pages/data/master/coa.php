<?php 
  include "pages/data/script/m_coa.php"; 
?>

<section class="content-header">
  <ol class="breadcrumb">
    <li><i class="fa fa-database"></i> Master</li>
    <li>COA</li>
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
					<a data-toggle="tab" href="#menuFormPp">Form Coa</a>
				</li>
        <li <?=$class_tab?>>
					<a data-toggle="tab" href="#menuListPp">List Coa</a>
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
									  $row = mysql_fetch_array($q_edit_coa);
								  }
								?>   

                <div class="form-group">
                  <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode <b style="color: red;">*</b></label>
                  <div class="col-lg-5">
                    <input type="text" required class="form-control" name="kode_coa" id="kode_coa" placeholder="Kode coa..." <?=(isset($row['id_coa']) ? "readonly": "")?> value="<?=(isset($row['id_coa']) ? $row['kode_coa'] : "")?>">
                  </div>
				  <span id="pesan" class="span" style="color:#F00; font-weight:bold"></span>
                </div>

                <div class="form-group">
                  <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">COA <b style="color: red;">*</b></label>
                  <div class="col-lg-10">
                    <input type="text" required class="form-control" name="nama" id="nama" placeholder="Coa..." value="<?=(isset($row['id_coa']) ? $row['nama'] : "")?>">
                  </div>
                </div>
                     
                <div class="form-group">
                  <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kategori <b style="color: red;">*</b></label>
                  <div class="col-lg-10">
                    <select id="kategori" name="kategori" class="select2" style="width: 100%;">
                      <option value="0">-- Pilih Kategori --</option>
                        <?php 
					                //CEK JIKA kategori ADA MAKA SELECTED	   
					                (isset($row['id_coa']) ? $kategori=$row['kategori'] : $kategori='');	   					 					 

                          //UNTUK AMBIL coanya 	
                          while($rowkat = mysql_fetch_array($q_ddl_katcoa)) { ;?>
                     
                          <option value="<?php echo $rowkat['kode_kat_coa'];?>" <?php if($rowkat['kode_kat_coa']==$kategori){echo 'selected';} ?>>
                            <?php echo $rowkat['nama'];?> 
                          </option>
                        <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tipe COA <b style="color: red;">*</b></label>
                  <div class="col-lg-10">
        					  <?php 
        					    //CEK JIKA LEVEL COA ADA MAKA SELECTED	   
        					    (isset($row['id_coa']) ? $level_coa=$row['level_coa'] : $level_coa="");
        					  ?>

        					  <select id="level_coa" name="level_coa" class="select2">
                      <option value="0">-- Pilih Level --</option>
                      <option <?php if( $level_coa=='1'){echo "selected"; } ?> value="1">1</option>
                      <option <?php if( $level_coa=='2'){echo "selected"; } ?> value="2">2</option>
                      <option <?php if( $level_coa=='3'){echo "selected"; } ?> value="3">3</option>
                      <option <?php if( $level_coa=='4'){echo "selected"; } ?> value="4">4</option>               
                    </select>
                  </div>
                </div>
                     
                <div class="form-group">
                  <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Mata uang <b style="color: red;">*</b></label>
                  <div class="col-lg-10">
                    <select id="mata_uang" name="mata_uang" class="select2" style="width: 100%;">
                      <option value="0">-- Pilih Mata Uang --</option>
                        <?php 
              					  //CEK JIKA matauang ADA MAKA SELECTED	   
              					  (isset($row['id_coa']) ? $mata_uang=$row['mata_uang'] : $mata_uang='');	   					 					 

                          //UNTUK AMBIL coanya 	
                          while($rowmat = mysql_fetch_array($q_ddl_valas)) { ;?>
                     
                          <option value="<?php echo $rowmat['kode_valas'];?>" <?php if($rowmat['kode_valas']==$mata_uang){echo 'selected';} ?>>
                            <?php echo $rowmat['keterangan'];?> 
                          </option>
                        <?php } ?>
                    </select>
                  </div>
                </div>
                     
                <div class="form-group">
                  <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kategori Cashflow <b style="color: red;">*</b></label>
                  <div class="col-lg-10">
                    <select id="kategori_cf" name="kategori_cf" class="select2" style="width: 100%;">
                      <option value="0">-- Pilih ChasFlow --</option>
                        <?php 
              					  //CEK JIKA matauang ADA MAKA SELECTED	   
              					  (isset($row['id_coa']) ? $kat_cf=$row['kategori_cf'] : $kat_cf='');	   					 					 

                          //UNTUK AMBIL coanya 	
                          while($rowcf = mysql_fetch_array($q_ddl_cf)) { ;?>
                     
                          <option value="<?php echo $rowcf['kode_kat_cashflow'];?>" <?php if($rowcf['kode_kat_cashflow']==$kat_cf){echo 'selected';} ?>>
                            <?php echo $rowcf['nama'];?> 
                          </option>
                        <?php } ?>
                    </select>
                  </div>
                </div>
                     
                <div class="form-group">
                  <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">D / K <b style="color: red;">*</b></label>
                  <div class="col-lg-10">
        					<?php 
        					  //CEK JIKA d/k ADA MAKA SELECTED	   
        					  (isset($row['id_coa']) ? $dk=$row['dk'] : $dk="");
        					?>
                     
					          <select id="dk" name="dk" class="select2">
                      <option value="0">-- Debet / Kredit --</option>
                       <option <?php if( $dk=='DEBET'){echo "selected"; } ?> value="debet">Debet</option>
                      <option <?php if( $dk=='KREDIT'){echo "selected"; } ?> value="kredit">Kredit</option>     
                    </select>
                  </div>
                </div>

                <label><b style="color: red;">* &nbsp;Wajib Diisi</b></label>
                     
                <div align="center" class="form-group">
                  <button class="btn btn-success <?=(isset($row['id_coa']) ? "update" : "simpan")?>" type="submit" name="<?=(isset($row['id_coa']) ? "update" : "simpan")?>"><i class="fa fa-pencil"></i> Simpan&nbsp;</button>
                  <a href="?page=master/coa&halaman= COA" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>
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
                      <th style="text-align: center">Kode Coa</th>
                      <th style="text-align: center">Keterangan</th>
                      <th style="text-align: center">Kelompok</th>
                      <th style="text-align: center">D / K</th>
                      <th style="text-align: center">Mata Uang</th>
                      <th style="text-align: center">Cashflow</th>
                      <th style="text-align: center">Aktif</th>
                      <th style="text-align: center">Action</th>
                    </tr>
                </thead>
                
                <tbody>	
                  <?php $no=1; while($res = mysql_fetch_array($q_coa)) { ;?>	
          				<tr>
              			<td style="text-align: center"><?=$no++?></td>
              			<td><a href="<?=base_url()?>?page=master/coa_track&action=track&halaman=TRACK COA&id_coa=<?=$res['id_coa']?>" target="_blank"><?=$res['kode_coa']?></a></td>
                    <td><?=$res['nama']?></td>
                    <td><?=$res['kategori_coa']?></td>
                    <td><?=$res['dk']?></td>
                    <td><?=$res['nama_mata_uang']?></td>
                    <td><?=$res['cashflow']?></td>
                    <td style="text-align: center"><?=($res['aktif']=='1' ? '<span class="btn-sm btn-success fa fa-check"></span>' : '<span class="btn-sm btn-danger fa fa-remove"></span>')?></td>
                    <td style="text-align: center"><a class="btn-sm btn-info" href="<?=base_url()?>?page=master/coa&action=edit&halaman= EDIT COA&id_coa=<?=$res['id_coa']?>" style="font-style:italic;"><i class="fa fa-edit"></i></a> 
                      <?php if ($res['aktif']=='1'){?>
                  		  <a class="btn-sm btn-danger" href="<?=base_url()?>?page=master/coa&action=nonaktif&halaman=COA&id_coa=<?=$res['id_coa']?>" onclick="return confirm('Anda yakin menonaktifkan data ini?')"><i class="fa fa-remove"></i></a> 
                      <?php }else{ ?>
                        <a class="btn-sm btn-success" href="<?=base_url()?>?page=master/coa&action=aktif&halaman=COA&id_coa=<?=$res['id_coa']?>"><i class="fa fa-check"></i></a>
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
	$('#kode_coa').change(function(){
		$('#pesan').html('<img style="margin-left:1px; width:20px"  src="<?=base_url()?>images/loading.gif">');
		var kode_coa = $(this).val();

		$.ajax({
			type	: 'POST',
			url 	: '<?=base_url()?>ajax/j_validasi.php?func=loadkode_coa',
			data 	: 'kode_coa='+kode_coa,
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
		
			if ($('#kode_coa').val()=='')
			{
				alert("Kode tidak Boleh Kosong");
				$('#kode_coa').focus();
				return false;
			}
			
			if ($('#kategori').val()=='0'){
				alert("Kategori belum dipilih");
				return false;
			}

			if ($('#level_coa').val()=='0'){
				alert("Tipe COA belum dipilih");
				return false;
			}

			if ($('#mata_uang').val()=='0'){
				alert("Mata Uang belum dipilih");
				return false;
			}

			if ($('#kategori_cf').val()=='0'){
				alert("Kategori ChasFlow belum dipilih");
				return false;
			}

			if ($('#dk').val()=='0'){
				alert("D/K belum dipilih");
				return false;
			}
			
			if($span.text() != ""){
				alert("Kode Sudah Terpakai");
				$('#kode_coa').focus();
				return false;
			}
			
		});	
	});	
</script>