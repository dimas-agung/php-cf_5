<?php
	include ('pages/data/script/m_kat_pel.php'); 
?>

<section class="content-header">
	<ol class="breadcrumb">
        <li><i class="fa fa-cog"></i> Setting</li>
        <li>Kategori Pelanggan</li>
        <li>Track Kategori Pelanggan</li>
    </ol>
</section>

<section class="content">
    <?php
		//TOMBOL PREV
        $prev = mysql_fetch_array($q_kp_prev); {
        if (isset($prev['id_kategori_pelanggan'])){
            ?>
            <a class="btn btn-md btn-warning" href="<?=base_url()?>?page=setting/kat_pel_track&action=track&halaman= TRACK KATEGORI PELANGGAN&id_kategori_pelanggan=<?=$prev['id_kategori_pelanggan']?>">
                <i class="fa fa-chevron-left" aria-hidden="true"></i>
            </a>
        <?php
		//TOMBOL NEXT	
		} } $next = mysql_fetch_array($q_kp_next); {
        if (isset($next['id_kategori_pelanggan'])){
            ?>
            &nbsp;<a class="btn btn-md btn-warning" href="<?=base_url()?>?page=setting/kat_pel_track&halaman= TRACK KATEGORI PELANGGAN&action=track&id_kategori_pelanggan=<?=$next['id_kategori_pelanggan']?>">
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </a>
            <?php
        } }
    
    ?>

    &nbsp;<a href="<?=base_url()?>?page=setting/kat_pel&halaman= KATEGORI PELANGGAN" class="btn btn-md btn-danger pull-right" ><i class=" fa fa-reply"></i> BACK</a>
    <br>
    <br />
</section>



<section class="content">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="form-horizontal">
            <?php $res = mysql_fetch_array($q_kp); {?>
            		 <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode</label>
                         <div class="col-lg-10">
                             <input type="text" required class="form-control" name="kode_cabang" id="kode_cabang" placeholder="Kode cabang..." readonly value="<?=$res['kode_kategori_pelanggan']?>">
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
                         <div class="col-lg-10">
                             <input type="text" class="form-control" name="nama" id="nama" placeholder="Cabang..." readonly value="<?=$res['nama']?>">
                         </div>
                     </div>
                    
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                         <div class="col-lg-10">
                             <input type="text" class="form-control" name="keterangan" readonly id="keterangan" placeholder="Keterangan..." value="<?=$res['keterangan']?>" >
                         </div>
                     </div>
                    
             <?php }; ?>  
            </div>
		</div>
	</div>
</section>