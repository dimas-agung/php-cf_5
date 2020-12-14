<?php
	include ('pages/data/script/m_karyawan.php'); 
?>

<section class="content-header">
	<h3>Track Master Karyawan</h3>
    
    <section class="content">

    	
        <?php
		//TOMBOL PREV
    	$prev = mysql_fetch_array($q_kry_prev); {
        if (isset($prev['id_karyawan'])){
            ?>
            <a class="btn btn-md btn-warning" href="<?=base_url()?>?page=master/karyawan_track&action=track&id_karyawan=<?=$prev['id_karyawan']?>">
                <i class="fa fa-chevron-left" aria-hidden="true"></i>
            </a>
        <?php
		//TOMBOL next	
		} } $next = mysql_fetch_array($q_kry_next); {
        if (isset($next['id_karyawan'])){
            ?>
            &nbsp;<a class="btn btn-md btn-warning" href="<?=base_url()?>?page=master/karyawan_track&action=track&id_karyawan=<?=$next['id_karyawan']?>">
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </a>
            <?php
        } }
    
    ?>

    &nbsp;<a href="<?=base_url()?>?page=master/karyawan" class="btn btn-md btn-danger pull-right" ><i class=" fa fa-reply"></i> BACK</a>
    <br>
    <br />

    </section>
</section>


<section class="content">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="form-horizontal">
            <?php $res = mysql_fetch_array($q_kry); {?>
            		<div class="row">
									<div class="col-lg-12">
                                   
										<div class="tabbable">
											<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
												<li <?=$class_form?>>
													<a data-toggle="tab" href="#profile4">Data Karyawan</a>
												</li>
                                                <li <?=$class_tab1?>>
													<a data-toggle="tab" href="#detail">Detail</a>
												</li>
											</ul>

											<div class="tab-content">
                                                
                                                <div id="profile4" <?=$class_pane_form?>>
													<p>

<form action="" method="post">
                     <div class="form-group">
                     	<label class="col-lg-10 col-sm-2 control-label" style="text-align:left"></label>
                        <div class="col-lg-2">
                        	<div> <img src="<?=base_url()?>pages/data/upload_foto_karyawan/<?=$res['foto_karyawan']?>" id="foto_kary" width="150" height="150"><p> </div>	
                        
                             
                        </div>
                     </div>
                                          
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode</label>
                         <div class="col-lg-4">
                             <input type="text" required class="form-control" name="kode_karyawan" id="kode_karyawan" placeholder="Kode karyawan..." readonly value="<?=$res['kode_karyawan']?>">
                         </div>
                         
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Nama</label>
                         <div class="col-lg-4">
                             <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama karyawan..." readonly value="<?=$res['nama']?>">
                         </div>
                     </div>
                     
                     <div class="form-group">
                     	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Alamat</label>
                         <div class="col-lg-4">
                         	 <textarea type="text" required class="form-control" name="alamat" id="alamat" placeholder="Alamat..." readonly ><?=$res['alamat']?></textarea>	
                         </div>
                         
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kelurahan</label>
                         <div class="col-lg-4">
                             <input type="text" class="form-control" name="kelurahan" id="kelurahan" placeholder="Kelurahan..." readonly value="<?=$res['kelurahan']?>">
                         </div>	
                     </div>
                     
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kecamatan</label>
                         <div class="col-lg-4">
                             <input type="text" required class="form-control" name="kecamatan" id="kecamatan" placeholder="Kecamatan..." readonly value="<?=$res['kecamatan']?>">
                         </div>
                         
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kota</label>
                         <div class="col-lg-4">
                             <input type="text" class="form-control" name="kota" id="kota" placeholder="Kota..." readonly value="<?=$res['kota']?>">
                         </div>
                     </div>
                     
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">KTP/SIM</label>
                         <div class="col-lg-4">
                         	<select disabled class="form-control" name="tanda_pengenal">
                                <option value="KTP" <?php if(isset($res['id_karyawan'])) {if($res['tanda_pengenal']=='KTP'){ echo 'selected';}} ?>>KTP</option>
                                <option value="SIM" <?php if(isset($res['id_karyawan'])) {if($res['tanda_pengenal']=='SIM'){ echo 'selected';}} ?>>SIM</option>
                             </select>
                             
                         </div>
                         
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">No. KTP/SIM</label>
                         <div class="col-lg-4">
                             <input type="text" class="form-control" name="no_tanda_pengenal" id="no_tanda_pengenal" placeholder="No Tanda Pengenal..." readonly value="<?=$res['no_tanda_pengenal']?>">
                         </div>
                         
                     </div>
                     
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">No. KK</label>
                         <div class="col-lg-4">
                             <input type="text" class="form-control" name="no_kk" id="no_kk" placeholder="No KK..." readonly value="<?=$res['no_kk']?>">
                         </div>
                         
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">NPWP</label>
                         <div class="col-lg-4">
                             <input type="text" class="form-control" name="no_npwp" id="no_npwp" placeholder="NPWP..." readonly value="<?=$res['no_npwp']?>">
                         </div>
                     </div>
                     
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">BPJS Kesehatan</label>
                         <div class="col-lg-4">
                             <input type="text" class="form-control" name="bpjs_kesehatan" id="bpjs_kesehatan" placeholder="BPJS Kes..." readonly value="<?=$res['bpjs_kesehatan']?>">
                         </div>
                         
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">BPJS TK</label>
                         <div class="col-lg-4">
                             <input type="text" class="form-control" name="bpjs_tk" id="bpjs_tk" placeholder="BPJS TK..." readonly value="<?=$res['bpjs_tk']?>">
                         </div>    
                     </div>
                     
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">PTKP</label>
                         <div class="col-lg-10">
                         	<select disabled class="form-control" name="ptkp">
                                <option value="K/0" <?php if(isset($res['id_karyawan'])) {if($res['ptkp']=='K/0'){ echo 'selected';}} ?>>K/0</option>
                                <option value="K/1" <?php if(isset($res['id_karyawan'])) {if($res['ptkp']=='K/1'){ echo 'selected';}} ?>>K/1</option>
                                <option value="K/2" <?php if(isset($res['id_karyawan'])) {if($res['ptkp']=='K/2'){ echo 'selected';}} ?>>K/2</option>
                                <option value="K/3" <?php if(isset($res['id_karyawan'])) {if($res['ptkp']=='K/3'){ echo 'selected';}} ?>>K/3</option>
                             </select>
                             
                         </div>
                     </div>

                     <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal Masuk</label>
						<div class="col-lg-4">
												<input type="text" name="tanggal" disabled id="tanggal" class="form-control" readonly value="<?=date("d-m-Y",strtotime($res['tgl_masuk']))?>" />
						</div> 
                        
                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal Resign</label>
						<div class="col-lg-4">
												<input type="text" disabled name="tanggal1" id="tanggal1" class="form-control"  readonly value="<?=date("d-m-Y",strtotime($res['tgl_resign']))?>"/>
						</div> 
                     </div>
                     
                     <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left; font-size:12px">Upload Tanda Pengenal</label> 
						<div class="col-lg-4">
                        	<div> <img src="<?=base_url()?>pages/data/upload_foto_karyawan/<?=$res['foto_tanda_pengenal']?>" id="foto_kary" width="250" height="250"><p> </div>	
                        
                        </div>
                        
                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left; font-size:12px">Upload KK</label>
						<div class="col-lg-4">
                        	<div> <img src="<?=base_url()?>pages/data/upload_foto_karyawan/<?=$res['foto_kk']?>" id="foto_kary" width="250" height="250"><p> </div>	
                        
                        </div>
								
                     </div>
                     
					 <?php //echo $sql; ?>
                     
                     <div align="center" class="form-group">
						<a id="next-btn" class="btn btn-primary"><i class=" fa fa-mail-forward"></i> Next</a>
					 </div>
                     
                     
                                                    
                                                    </p>
												</div>
<!-- TAB DETAIL -->								                                                	<div id="detail" <?=$class_pane_tab1?>>
													<p>
                     					 <div class="form-group">
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Divisi</label>
                                             <div class="col-lg-4">
                                                 <input type="text" required class="form-control" name="divisi" id="divisi" placeholder="Divisi..." readonly value="<?=$res['divisi']?>">
                                             </div>
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Jabatan</label>
                                             <div class="col-lg-4">
                                                 <input type="text" required class="form-control" name="jabatan" id="jabatan" placeholder="Jabatan..." readonly value="<?=$res['jabatan']?>"> 
                                             </div>
                                             
                                         </div>
                                         <div class="form-group">
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kategori</label>
                                             <div class="col-lg-10">
                                                 <select id="kategori" name="kategori" disabled class="form-control select2" style="width: 100%;">
                                            <option value="0">-- Pilih Kategori --</option>
                                               <?php 
                                         //CEK JIKA KODE coa_debet ADA MAKA SELECTED	   
                                         (isset($res['id_karyawan']) ? $kategori=$res['kategori'] : $kategori='');	   					 					 //UNTUK AMBIL coanya 	
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
                                                 <input type="text" required class="form-control" name="nama_bank" id="nama_bank" placeholder="Bank..." readonly value="<?=$res['nama_bank']?>">
                                             </div>
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
                                             <div class="col-lg-4">
                                                 <input type="text" required class="form-control" name="cabang" id="cabang" placeholder="Cabang..." readonly value="<?=$res['cabang']?>">
                                             </div>
                                         </div>
                                         <div class="form-group">
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Atas Nama</label>
                                             <div class="col-lg-4">
                                                 <input type="text" required class="form-control" name="atas_nama" id="atas_nama" placeholder="Atas nama..." readonly value="<?=$res['atas_nama']?>">
                                             </div>
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">No Rek Bank</label>
                                             <div class="col-lg-4">
                                                 <input type="text" required class="form-control" name="no_rekening" id="no_rekening" placeholder="No Rek Bank..." readonly value="<?=$res['no_rekening']?>">
                                             </div>
                                         </div>                               
                                                    
                                                	</p>
												</div>
<!-- TAB AKUNTING -->                                                
                                                                                                
 
 											</div>
										</div>
  
									</div><!-- /.col -->
</div>
             <?php }; ?>   
            </div>
		</div>
	</div>
</section>