<?php
	include "pages/data/script/m_profil.php"; 
?>

<section class="content-header">
	<ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-cog"></i> Setting</a></li>
          <li>
          	<a href="#">Profil Perusahaan</a>
          </li>
   </ol>        
</section>

			<!-- INFO BANNER FORM SAAT INPUT DAN UPDATE -->
            <?php
          	if (isset($_GET['updatesukses'])){
				echo '<div class="alert alert-info"><i class="icon fa fa-check"></i> UPDATE DATA BERHASIL</div>';
			}
			?>

<section class="content">
	
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="form-horizontal">
             <form action="" method="post">
             <?php while($res = mysql_fetch_array($q_profil)) { ;?>
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2">Kode Perusahaan</label>
                         <div class="col-lg-10">
                             <input type="text" class="form-control" name="kode_pusat" id="kode_pusat" placeholder="Kode Pusat..." value="<?=$res['kode_pusat']?>" readonly>
                         </div>
                     </div>
                     
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2">Perusahaan</label>
                         <div class="col-lg-10">
                             <input type="text" class="form-control" name="nama" id="nama" placeholder="Perusahaan..." value="<?=$res['nama']?>">
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2">Telepon 
</label>

                         <div class="col-lg-10">
                             <input type="text" class="form-control" maxlength="13"  name="telpon" id="telpon" placeholder="Nomor telepon..." value="<?=$res['telpon']?>"> 
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2">Alamat</label>
                         <div class="col-lg-10">
                             <textarea class="form-control" rows="3" name="alamat" id="alamat" placeholder="Alamat..."><?=$res['alamat']?></textarea>
                         </div>
                     </div>
                       
                 <?php } ?>    
                 
                 <div class="form-group col-lg-12">
                 <p align="center">    <button class="btn btn-success" name="upd_profil" id="upd_profil" type="submit"><i class="fa fa-pencil"></i> Update&nbsp;</button>
<!--                     <button type="button" class="btn btn-danger" data-dismiss="modal"><i class=" fa fa-reply"></i> Batal</button> -->
                      <input type="hidden" name="id_pusat" value="" /> 
                 </div>
                 </form>
                 </div>
		</div>
	
    </div>
</section>