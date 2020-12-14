<?php 	
    include "pages/data/script/m_pelanggan.php"; 
?>
<section class="content-header">
       
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-database"></i> Master</a></li>
          <li>
          	<a href="#">Pelanggan</a>

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
													<a data-toggle="tab" href="#menuFormPp">Data Pelanggan</a>
												</li>
                                                <!-- <li <?=$class_tab3?>>
                                                    <a data-toggle="tab" href="#hargadiskon">Harga & Diskon</a>
                                                </li>  -->
                                                <li <?=$class_tab2?>>
													<a data-toggle="tab" href="#detail">Detail</a>
												</li>
                                                <li <?=$class_tab1?>>
													<a data-toggle="tab" href="#akunting">Accounting</a>
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
									$row = mysql_fetch_array($q_edit_pel);
								}
								?>             
                         <div class="form-group">
                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode <b style="color: red;">*</b></label>
                             <div class="col-lg-4">
                                 <input type="text"  class="form-control" name="kode_pelanggan" id="kode_pelanggan" placeholder="Kode Pelanggan..." <?=(isset($row['id_pelanggan']) ? "readonly": "")?> value="<?=(isset($row['id_pelanggan']) ? $row['kode_pelanggan'] : "")?>">
                             </div>
                         </div>

                         <div class="form-group">
                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Nama <b style="color: red;">*</b></label>
                             <div class="col-lg-4">
                                 <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama..." value="<?=(isset($row['id_pelanggan']) ? $row['nama'] : "")?>">
                             </div>

                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Salesman <b style="color: red;">*</b></label>
                             <div class="col-lg-4">
                                <select id="salesman" name="salesman" class="select2" style="width: 100%;">
                            <option value="0">-- Pilih Salesman --</option>
                               <?php 
                         //CEK JIKA KODE coa_debet ADA MAKA SELECTED       
                         (isset($row['id_pelanggan']) ? $sales=$row['salesman'] : $sales='');                                            //UNTUK AMBIL coanya   
                         while($rowsales = mysql_fetch_array($q_ddl_salesman)) { ;?>
                         
                            <option value="<?php echo $rowsales['kode_karyawan'];?>" <?php if($rowsales['kode_karyawan']==$sales){echo 'selected';} ?>><?php echo $rowsales['nama'];?> </option>
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
                         //CEK JIKA KODE coa_debet ADA MAKA SELECTED       
                         (isset($row['id_pelanggan']) ? $kategori=$row['kategori_pelanggan'] : $kategori='');                                            //UNTUK AMBIL coanya   
                         while($rowkat_pel = mysql_fetch_array($q_ddl_kat_pel)) { ;?>
                         
                            <option value="<?php echo $rowkat_pel['kode_kategori_pelanggan'];?>" <?php if($rowkat_pel['kode_kategori_pelanggan']==$kategori){echo 'selected';} ?>><?php echo $rowkat_pel['nama'];?> </option>
                               <?php } ?>
                            </select>
                                 
                             </div>
                        </div>

                         <div class="form-group">
                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Alamat</label>
                             <div class="col-lg-4">
                                 <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat..." value="<?=(isset($row['id_pelanggan']) ? $row['alamat'] : "")?>">
                             </div>
                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kecamatan</label>
                             <div class="col-lg-4">
                                 <input type="text" class="form-control" name="kecamatan" id="kecamatan" placeholder="Kecamatan..." value="<?=(isset($row['id_pelanggan']) ? $row['kecamatan'] : "")?>">
                             </div>
                         </div>
                         <div class="form-group">
                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kota</label>
                             <div class="col-lg-4">
                                 <input type="text" class="form-control" name="kota" id="kota" placeholder="Kota..." value="<?=(isset($row['id_pelanggan']) ? $row['kota'] : "")?>">
                             </div>
                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Provinsi</label>
                             <div class="col-lg-4">
                                 <input type="text" class="form-control" name="propinsi" id="propinsi" placeholder="Provinsi..." value="<?=(isset($row['id_pelanggan']) ? $row['propinsi'] : "")?>">
                             </div>
                         </div>
                         <div class="form-group">
                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Negara</label>
                             <div class="col-lg-4">
                                 <input type="text" class="form-control" name="negara" id="negara" placeholder="Negara..." value="<?=(isset($row['id_pelanggan']) ? $row['negara'] : "")?>">
                             </div>
                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">No Telpon</label>
                             <div class="col-lg-4">
                                 <input type="text" class="form-control" name="telpon" id="telpon" placeholder="No Telpon..." value="<?=(isset($row['id_pelanggan']) ? $row['telpon'] : "")?>">
                             </div>
                         </div>
                         <div class="form-group">
                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kontak Person</label>
                             <div class="col-lg-4">
                                 <input type="text" class="form-control" name="kontak" id="kontak" placeholder="Kontak Person..." value="<?=(isset($row['id_pelanggan']) ? $row['kontak'] : "")?>">
                             </div>

                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">No Handphone</label>
                             <div class="col-lg-4">
                                 <input type="text" class="form-control" name="hp" id="hp" placeholder="No HP..." value="<?=(isset($row['id_pelanggan']) ? $row['hp'] : "")?>">
                             </div>
                         </div>
                         <div class="form-group">
                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Email</label>
                             <div class="col-lg-4">
                                 <input type="text" class="form-control" name="email" id="email" placeholder="Email..." value="<?=(isset($row['id_pelanggan']) ? $row['email'] : "")?>">
                             </div>

                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ppn</label>
                             <div class="col-lg-4">
                                 <div class="checkbox">
                                <label>
                                    <input name="ppn" type="checkbox" class="ace" <?=(isset($row['id_pelanggan']) ? $ppn=$row['PPn'] : $ppn='2')?> 
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
                                 <input type="text" class="form-control" name="npwp" id="npwp" placeholder="No NPWP..." value="<?=(isset($row['id_pelanggan']) ? $row['npwp'] : "")?>">
                             </div>
                             
                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">No KTP</label>
                             <div class="col-lg-4">
                                 <input type="text" class="form-control" name="ktp" id="ktp" placeholder="No KTP..." value="<?=(isset($row['id_pelanggan']) ? $row['ktp'] : "")?>">
                             </div>
                         </div>
                         <div class="form-group">
                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                             <div class="col-lg-10">
                                 <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan..." value="<?=(isset($row['id_pelanggan']) ? $row['keterangan'] : "")?>">
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
                                             <input type="text" class="form-control" name="plafon_kredit" id="plafon_kredit" placeholder="Plafon..." value="<?=(isset($row['id_pelanggan']) ? $row['plafon_kredit'] : "")?>">
                                         </div>
                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Term om payment</label>
                                         <div class="col-lg-3">
                                             <input type="text" class="form-control" name="jatuh_tempo" id="jatuh_tempo" placeholder="TOP..." value="<?=(isset($row['id_pelanggan']) ? $row['jatuh_tempo'] : "")?>"> 
                                         </div>
                                         <label class="col-lg-1 col-sm-2 control-label" style="text-align:left">hari</label>
                                     </div>
                                                                  
                                     <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left"><h3>Bank :</h3></label>
                                     </div>                               
                                     <div class="form-group">
                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Bank</label>
                                         <div class="col-lg-10">
                                             <input type="text" class="form-control" name="bank" id="bank" placeholder="Bank..." value="<?=(isset($row['id_pelanggan']) ? $row['bank'] : "")?>">
                                         </div>
                                         
                                     </div>
                                     <div class="form-group">
                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Atas Nama</label>
                                         <div class="col-lg-4">
                                             <input type="text" class="form-control" name="bank_an" id="bank_an" placeholder="Atas nama..." value="<?=(isset($row['id_pelanggan']) ? $row['bank_an'] : "")?>">
                                         </div>
                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">No Rek Bank</label>
                                         <div class="col-lg-4">
                                             <input type="text" class="form-control" name="bank_no_rek" id="bank_no_rek" placeholder="No Rek Bank..." value="<?=(isset($row['id_pelanggan']) ? $row['bank_no_rek'] : "")?>">
                                         </div>
                                     </div>   
                                     
                                     <div class="form-group">
                                        <label class="col-lg-12 col-sm-2 control-label" style="text-align:left"><h3>Alamat Penagihan :</h3></label>
                                     </div>                               
                                     <div class="form-group">
                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Nama</label>
                                         <div class="col-lg-10">
                                             <input type="text" class="form-control" name="nama_penagihan" id="nama_penagihan" placeholder="Nama Penagihan..." value="<?=(isset($row['id_pelanggan']) ? $row['nama_penagihan'] : "")?>">
                                         </div>
                                         
                                     </div>
                                     <div class="form-group">
                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Alamat</label>
                                         <div class="col-lg-10">
                                             <textarea class="form-control" name="alamat_penagihan" id="alamat_penagihan" placeholder="Alamat Penagihan..."><?=(isset($row['id_pelanggan']) ? $row['alamat_penagihan'] : "")?></textarea>
                                         </div>
                                     </div>
                                     <div class="form-group">    
                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kota</label>
                                         <div class="col-lg-10">
                                             <input type="text" class="form-control" name="kota_penagihan" id="kota_penagihan" placeholder="Kota Penagihan..." value="<?=(isset($row['id_pelanggan']) ? $row['kota_penagihan'] : "")?>">
                                         </div>
                                     </div>                             
                                                                        
                                         <div align="center" class="form-group">
                                            <a id="next-btn1" class="btn btn-primary"><i class=" fa fa-mail-forward"></i> Next</a>
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
                                             //CEK JIKA KODE coa_debet ADA MAKA SELECTED	   
                                             (isset($row['id_pelanggan']) ? $coa_debet=$row['coa_debet'] : $coa_debet='');	   					 					 //UNTUK AMBIL coanya 	
                                             while($rowcoadeb = mysql_fetch_array($q_ddl_coa)) { ;?>
                                             
                                                <option value="<?php echo $rowcoadeb['kode_coa'];?>" <?php if($rowcoadeb['kode_coa']==$coa_debet){echo 'selected';} ?>><?php echo $rowcoadeb['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowcoadeb['nama'];?> </option>
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
                                             //CEK JIKA KODE coa_kredit ADA MAKA SELECTED	   
                                             (isset($row['id_pelanggan']) ? $coa_kredit=$row['coa_kredit'] : $coa_kredit='');	   					 					 //UNTUK AMBIL coanya 	
                                             while($rowcoakred = mysql_fetch_array($q_ddl_coa2)) { ;?>
                                             
                                                <option value="<?php echo $rowcoakred['kode_coa'];?>" <?php if($rowcoakred['kode_coa']==$coa_kredit){echo 'selected';} ?>><?php echo $rowcoakred['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowcoakred['nama'];?> </option>
                                                   <?php } ?>
                                                </select>
                                                 </div>
                                             </div>      
                                             
                                             <label><b style="color: red;">* &nbsp;Wajib Diisi</b></label>
                                             
                                             <div align="center" class="form-group">
                                             <button class="btn btn-success pb-edit" type="submit" name="update"><i class="fa fa-pencil"></i> Update&nbsp;</button>
                                             <a href="?page=master/pelanggan&halaman= PELANGGAN" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>
                                         </div>
                                         </form>   	
                                    </div>
                                </div>
                            </div>
                    </div>                
				</div>

<!-- END AKUNTING -->                
				
				
			</div>			
			</div>
			<!-- /.row -->

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
  }

  td {
      text-align: left;
      padding: 8px;
  }

  tr:nth-child(even){background-color: #f2f2f2}
</style> 

<script type="text/javascript">
$(document).ready(function(){
    $('.pb-edit').click(function(){
       
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
<script>
    $("#kategori_pelanggan").change(function() {
            var kategori_pelanggan = {kategori_pelanggan:$("#kategori_pelanggan").val()};
            $.ajax({
            type: "POST",
            url : "<?php echo base_url();?>ajax/r_pelanggan.php?func=gethargadiskon",
            data: kategori_pelanggan,
            success: function(msg){
                $('#list_harga_diskon_pelanggan').html(msg);
            }
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