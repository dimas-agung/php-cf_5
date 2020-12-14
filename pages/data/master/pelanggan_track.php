<?php 	
    include "pages/data/script/m_pelanggan.php"; 
?>

<section class="content-header">
    <ol class="breadcrumb">
        <li><i class="fa fa-database"></i> Master</li>
        <li>Pelanggan</li>
        <li>Track Pelanggan</li>
    </ol>
</section>  

<section class="content">
    &nbsp;<a href="<?=base_url()?>?page=master/pelanggan&halaman= PELANGGAN" class="btn btn-md btn-danger pull-right" ><i class=" fa fa-reply"></i> BACK</a>
    <br><br/>
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
<!--                                                <li <?=$class_tab?>>
													<a data-toggle="tab" href="#menuListPp">List Pelanggan</a>
												</li> -->
                                                
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
								if(isset($_GET['action']) and $_GET['action'] == "track") {
									$row = mysql_fetch_array($q_pel);
								}
							?>             
                         <div class="form-group">
                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode</label>
                             <div class="col-lg-4">
                                 <input type="text" required class="form-control" name="kode_pelanggan" id="kode_pelanggan" placeholder="Kode Pelanggan..." value="<?=$row['kode_pelanggan']?>" readonly>
                             </div>
                         </div>

                         <div class="form-group">    
                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Nama</label>
                             <div class="col-lg-4">
                                 <input type="text" required class="form-control" name="nama" id="nama" readonly  placeholder="Nama..." value="<?=$row['nama']?>">
                             </div>

                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Salesman</label>
                             <div class="col-lg-4">
                                <select disabled id="salesman" name="salesman" class="select2" style="width: 100%;">
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
                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kategori Pelanggan</label>
                             <div class="col-lg-10">
                                <select id="kategori_pelanggan" disabled name="kategori_pelanggan" class="select2" style="width: 100%;">
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
                                 <input type="text" required class="form-control" name="alamat" id="alamat" readonly placeholder="Alamat..." value="<?=$row['alamat']?>">
                             </div>

                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kecamatan</label>
                             <div class="col-lg-4">
                                 <input type="text" required class="form-control" name="kecamatan" id="kecamatan" placeholder="Kecamatan..." readonly value="<?=$row['kecamatan']?>">
                             </div>
                         </div>

                         <div class="form-group">
                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kota</label>
                             <div class="col-lg-4">
                                 <input type="text" required class="form-control" name="kota" id="kota" placeholder="Kota..." readonly value="<?=$row['kota']?>">
                             </div>

                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Provinsi</label>
                             <div class="col-lg-4">
                                 <input type="text" required class="form-control" name="propinsi" id="propinsi" placeholder="Provinsi..." readonly value="<?=$row['propinsi']?>">
                             </div>
                         </div>

                         <div class="form-group">
                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Negara</label>
                             <div class="col-lg-4">
                                 <input type="text" required class="form-control" name="negara" id="negara" readonly placeholder="Negara..." value="<?=$row['negara']?>">
                             </div>

                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">No Telpon</label>
                             <div class="col-lg-4">
                                 <input type="text" required class="form-control" name="telpon" id="telpon" readonly placeholder="No Telpon..." value="<?=$row['telpon']?>">
                             </div>
                         </div>

                         <div class="form-group">
                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kontak Person</label>
                             <div class="col-lg-4">
                                 <input type="text" required class="form-control" name="kontak" id="kontak" readonly placeholder="Kontak Person..." value="<?=$row['kontak']?>">
                             </div>

                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">No Handphone</label>
                             <div class="col-lg-4">
                                 <input type="text" required class="form-control" name="hp" id="hp" readonly placeholder="No HP..." value="<?=$row['hp']?>">
                             </div>
                         </div>

                         <div class="form-group">
                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Email</label>
                             <div class="col-lg-4">
                                 <input type="text" required class="form-control" name="email" id="email" readonly placeholder="Email..." value="<?=$row['email']?>">
                             </div>
                             
                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ppn</label>
                             <div class="col-lg-4">
                                 <div class="checkbox">
                                <label>
                                    <input name="ppn" disabled type="checkbox" class="ace" <?=(isset($row['id_pelanggan']) ? $ppn=$row['PPn'] : $ppn='2')?> 
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
                                 <input type="text" required class="form-control" name="npwp" id="npwp" readonly placeholder="No NPWP..." value="<?=$row['npwp']?>">
                             </div>
                             
                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">No KTP</label>
                             <div class="col-lg-4">
                                 <input type="text" required class="form-control" name="ktp" id="ktp" readonly placeholder="No KTP..." value="<?=$row['ktp']?>">
                             </div>
                         </div>

                         <div class="form-group">
                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                             <div class="col-lg-10">
                                 <input type="text" required class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan..." readonly value="<?=$row['keterangan']?>">
                             </div>
                         </div>
                     
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
                                             <input type="text" required class="form-control" name="plafon_kredit" id="plafon_kredit" placeholder="Plafon..." readonly value="<?=$row['plafon_kredit']?>">
                                         </div>
                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Term om payment</label>
                                         <div class="col-lg-3">
                                             <input type="text" required class="form-control" name="jatuh_tempo" id="jatuh_tempo" placeholder="TOP..." readonly value="<?=$row['jatuh_tempo']?>"> 
                                         </div>
                                         <label class="col-lg-1 col-sm-2 control-label" style="text-align:left">hari</label>
                                     </div>
                                                                  
                                     <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left"><h3>Bank :</h3></label>
                                     </div>                               
                                     <div class="form-group">
                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Bank</label>
                                         <div class="col-lg-10">
                                             <input type="text" required class="form-control" name="bank" id="bank" placeholder="Bank..." readonly value="<?=$row['bank']?>">
                                         </div>
                                         
                                     </div>
                                     <div class="form-group">
                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Atas Nama</label>
                                         <div class="col-lg-4">
                                             <input type="text" required class="form-control" name="bank_an" id="bank_an" placeholder="Atas nama..." readonly value="<?=$row['bank_an']?>">
                                         </div>
                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">No Rek Bank</label>
                                         <div class="col-lg-4">
                                             <input type="text" required class="form-control" name="bank_no_rek" id="bank_no_rek" placeholder="No Rek Bank..." readonly value="<?=$row['bank_no_rek']?>">
                                         </div>
                                     </div>   
                                     
                                     <div class="form-group">
                                        <label class="col-lg-12 col-sm-2 control-label" style="text-align:left"><h3>Alamat Penagihan :</h3></label>
                                     </div>                               
                                     <div class="form-group">
                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Nama</label>
                                         <div class="col-lg-10">
                                             <input type="text" required class="form-control" name="nama_penagihan" id="nama_penagihan" placeholder="Nama Penagihan..." readonly value="<?=$row['nama_penagihan']?>">
                                         </div>
                                         
                                     </div>
                                     <div class="form-group">
                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Alamat</label>
                                         <div class="col-lg-10">
                                             <textarea class="form-control" name="alamat_penagihan" id="alamat_penagihan" placeholder="Alamat Penagihan..." readonly><?=$row['alamat_penagihan']?></textarea>
                                         </div>
                                     </div>
                                     <div class="form-group">    
                                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kota</label>
                                         <div class="col-lg-10">
                                             <input type="text" required class="form-control" name="kota_penagihan" id="kota_penagihan" placeholder="Kota Penagihan..." readonly value="<?=$row['kota_penagihan']?>">
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
                                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Coa Debet</label>
                                                <div class="col-lg-10">
                                                    <select id="coa_debet" name="coa_debet" disabled class="select2" style="width: 100%;">
                                                    <option value="0">-- Pilih Coa Debet --</option>
                                                    <?php 
                                                        //CEK JIKA KODE coa_debet ADA MAKA SELECTED	   
                                                        (isset($row['id_pelanggan']) ? $coa_debet=$row['coa_debet'] : $coa_debet='');	   					 		
                                                        //UNTUK AMBIL coanya 	
                                                        while($rowcoadeb = mysql_fetch_array($q_ddl_coa)) { ;?>
                                                 
                                                        <option value="<?php echo $rowcoadeb['kode_coa'];?>" <?php if($rowcoadeb['kode_coa']==$coa_debet){echo 'selected';} ?>><?php echo $rowcoadeb['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowcoadeb['nama'];?> </option>
                                                    <?php } ?>
                                                    </select>
                                                </div>
                                             </div>  

                                             <div class="form-group">
                                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Coa Kredit</label>
                                                <div class="col-lg-10">
                                                    <select id="coa_kredit" name="coa_kredit" disabled class="select2" style="width: 100%;">
                                                    <option value="0">-- Pilih Coa Kredit --</option>
                                                    <?php 
                                                        //CEK JIKA KODE coa_kredit ADA MAKA SELECTED	   
                                                        (isset($row['id_pelanggan']) ? $coa_kredit=$row['coa_kredit'] : $coa_kredit='');	   					 
                                                        //UNTUK AMBIL coanya 	
                                                        while($rowcoakred = mysql_fetch_array($q_ddl_coa2)) { ;?>
                                             
                                                        <option value="<?php echo $rowcoakred['kode_coa'];?>" <?php if($rowcoakred['kode_coa']==$coa_kredit){echo 'selected';} ?>><?php echo $rowcoakred['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowcoakred['nama'];?> </option>
                                                    <?php } ?>
                                                    </select>
                                                 </div>
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
