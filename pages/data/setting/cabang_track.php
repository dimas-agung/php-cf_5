<?php
	include ('pages/data/script/m_cabang.php'); 
?>

<section class="content-header">
	<h3>Track Setting Cabang</h3>
    <br />
    <section class="content">

    	
        <?php
		//TOMBOL PREV
    	$prev = mysql_fetch_array($q_cab_prev); {
        if (isset($prev['id_cabang'])){
            ?>
            <a class="btn btn-md btn-warning" href="<?=base_url()?>?page=setting/cabang_track&halaman= TRACK CABANG&action=track&id_cabang=<?=$prev['id_cabang']?>">
                <i class="fa fa-chevron-left" aria-hidden="true"></i>
            </a>
        <?php
		//TOMBOL next	
		} } $next = mysql_fetch_array($q_cab_next); {
        if (isset($next['id_cabang'])){
            ?>
            &nbsp;<a class="btn btn-md btn-warning" href="<?=base_url()?>?page=setting/cabang_track&halaman= TRACK CABANG&action=track&id_cabang=<?=$next['id_cabang']?>">
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </a>
            <?php
        } }
    
    ?>

    &nbsp;<a href="<?=base_url()?>?page=setting/cabang&halaman= CABANG" class="btn btn-md btn-danger pull-right" ><i class=" fa fa-reply"></i> BACK</a>
    <br>
    <br />

    </section>
</section>


<section class="content">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="form-horizontal">
            <?php $res = mysql_fetch_array($q_cab); {?>
            		 <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode</label>
                         <div class="col-lg-10">
                             <input type="text" required class="form-control" name="kode_cabang" id="kode_cabang" placeholder="Kode cabang..." readonly value="<?=$res['kode_cabang']?>">
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
                         <div class="col-lg-10">
                             <input type="text" class="form-control" name="nama" id="nama" placeholder="Cabang..." readonly value="<?=$res['nama']?>">
                         </div>
                     </div>
                    
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Alamat</label>
                         <div class="col-lg-10">
                             <textarea class="form-control" name="alamat" id="alamat" readonly placeholder="alamat..."><?=$res['alamat']?></textarea>
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