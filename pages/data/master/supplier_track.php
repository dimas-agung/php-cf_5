<?php
	include ('pages/data/script/m_supplier.php'); 
?>

<section class="content-header">
	<h3>Track Master Supplier</h3>
    
    <section class="content">

    	
        <?php
		//TOMBOL PREV
    	$prev = mysql_fetch_array($q_supp_prev); {
        if (isset($prev['id_supplier'])){
            ?>
            <a class="btn btn-md btn-warning" href="<?=base_url()?>?page=master/supplier_track&action=track&id_supplier=<?=$prev['id_supplier']?>">
                <i class="fa fa-chevron-left" aria-hidden="true"></i>
            </a>
        <?php
		//TOMBOL next	
		} } $next = mysql_fetch_array($q_supp_next); {
        if (isset($next['id_supplier'])){
            ?>
            &nbsp;<a class="btn btn-md btn-warning" href="<?=base_url()?>?page=master/supplier_track&action=track&id_supplier=<?=$next['id_supplier']?>">
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </a>
            <?php
        } }
    
    ?>

    &nbsp;<a href="<?=base_url()?>?page=master/supplier" class="btn btn-md btn-danger pull-right" ><i class=" fa fa-reply"></i> BACK</a>
    <br>
    <br />

    </section>
</section>


<section class="content">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="form-horizontal">
            <?php $res = mysql_fetch_array($q_supp); {?>
            		<div class="row">
									<div class="col-lg-12">
                                   
										<div class="tabbable">
											<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
												<li <?=$class_form?>>
													<a data-toggle="tab" href="#profile4">Data Supplier</a>
												</li>
                                                <li <?=$class_tab1?>>
													<a data-toggle="tab" href="#detail">Detail</a>
												</li>
                                                
                                                <li <?=$class_tab2?>>
													<a data-toggle="tab" href="#akunting">Accounting</a>
												</li>
                                                
                                                
											</ul>

											<div class="tab-content">
                                                
                                                <div id="profile4" <?=$class_pane_form?>>
													<p>

<form action="" method="post">
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode</label>
                         <div class="col-lg-4">
                             <input type="text" required class="form-control" name="kode_supplier" id="kode_supplier" placeholder="Kode supplier..." readonly value="<?=$res['kode_supplier']?>">
                         </div>
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Nama</label>
                         <div class="col-lg-4">
                             <input type="text" required class="form-control" name="nama" id="nama" placeholder="Nama..." readonly value="<?=$res['nama']?>">
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Alamat</label>
                         <div class="col-lg-4">
                             <input type="text" required class="form-control" name="alamat" id="alamat" placeholder="Alamat..." readonly value="<?=$res['alamat']?>">
                         </div>
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kecamatan</label>
                         <div class="col-lg-4">
                             <input type="text" required class="form-control" name="kecamatan" id="kecamatan" placeholder="Kecamatan..." readonly value="<?=$res['kecamatan']?>">
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kota</label>
                         <div class="col-lg-4">
                             <input type="text" required class="form-control" name="kota" id="kota" placeholder="Kota..." readonly value="<?=$res['kota']?>">
                         </div>
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Provinsi</label>
                         <div class="col-lg-4">
                             <input type="text" required class="form-control" name="provinsi" id="provinsi" placeholder="Provinsi..." readonly value="<?=$res['propinsi']?>">
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Negara</label>
                         <div class="col-lg-4">
                             <input type="text" required class="form-control" name="negara" id="negara" placeholder="Negara..." readonly value="<?=$res['negara']?>">
                         </div>
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kontak Person</label>
                         <div class="col-lg-4">
                             <input type="text" required class="form-control" name="kontak_person" id="kontak_person" placeholder="Kontak Person..." readonly value="<?=$res['kontak_person']?>">
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">No Telpon</label>
                         <div class="col-lg-4">
                             <input type="text" required class="form-control" name="telpon" id="telpon" placeholder="No Telpon..." readonly value="<?=$res['telpon']?>">
                         </div>
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">No Handphone</label>
                         <div class="col-lg-4">
                             <input type="text" required class="form-control" name="hp" id="hp" placeholder="No HP..." readonly value="<?=$res['HP']?>">
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Email</label>
                         <div class="col-lg-4">
                             <input type="text" required class="form-control" name="email" id="email" placeholder="Email..." readonly value="<?=$res['email']?>">
                         </div>
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ppn</label>
                         <div class="col-lg-4">
                             <div class="checkbox">
							
								<i class="fa fa-<?php echo ($res['PPn']==1)?"check-square-o":"square-o" ; ?>"></i>
                             
							</div>   
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">No NPWP</label>
                         <div class="col-lg-4">
                             <input type="text" required class="form-control" name="npwp" id="npwp" placeholder="No NPWP..." readonly value="<?=$res['NPWP']?>">
                         </div>
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">No KTP</label>
                         <div class="col-lg-4">
                             <input type="text" required class="form-control" name="ktp" id="ktp" placeholder="No KTP..." readonly value="<?=$res['no_ktp']?>">
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                         <div class="col-lg-10">
                             <input type="text" required class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan..." readonly value="<?=$res['keterangan']?>">
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
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Plafon (Rp)</label>
                         <div class="col-lg-4">
                             <input type="text" required class="form-control" name="plafon" id="plafon" placeholder="Plafon..." readonly value="<?=number_format($res['plafon_kredit'])?>">
                         </div>
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Term om payment</label>
                         <div class="col-lg-3">
                             <input type="text" required class="form-control" name="top" id="top" placeholder="TOP..." readonly value="<?=$res['jatuh_tempo']?>"> 
                         </div>
                         <label class="col-lg-1 col-sm-2 control-label" style="text-align:left">hari</label>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Mata Uang</label>
                         <div class="col-lg-10">
                             <input type="text" required class="form-control" name="top" id="top" placeholder="Mata Uang..." readonly value="<?=$res['mat_uang']?>">
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
                                                    
                     <div align="center" class="form-group">
						<a id="next-btn1" class="btn btn-primary"><i class=" fa fa-mail-forward"></i> Next</a>
					 </div>
                                                    
                                                	</p>
												</div>
<!-- TAB AKUNTING -->                                                
                                                <div id="akunting" <?=$class_pane_tab2?>>
													<p>
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Coa Debet</label>
                         <div class="col-lg-10">
                             <input type="text" required class="form-control" name="no_rekening" id="no_rekening" placeholder="Coa Debet..." readonly value="<?=$res['coa_debet'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$res['coa_deb']?>">
                         </div>
                     </div>     
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Coa Kredit</label>
                         <div class="col-lg-10">
                             <input type="text" required class="form-control" name="no_rekening" id="no_rekening" placeholder="Coa Kredit..." readonly value="<?=$res['coa_kredit'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$res['coa_kred']?>">
                         </div>
                     </div>      
                     
                 </form>                      
                                                    
                                                    </p>
                                                </div>  
<!-- END TAB AKUNTING -->                                                
 
 											</div>
										</div>
  
									</div><!-- /.col -->
</div>
             <?php }; ?>   
            </div>
		</div>
	</div>
</section>