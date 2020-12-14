<?php
	include ('pages/data/script/m_valas.php'); 
?>

<section class="content-header">
    <ol class="breadcrumb">
        <li><i class="fa fa-database"></i> Master</li>
        <li>Valas</li>
        <li>Track Valas</li>
    </ol>
</section>   

<section class="content">
        <?php
		//TOMBOL PREV
    	$prev = mysql_fetch_array($q_valas_prev); {
        if (isset($prev['id_valas'])){
            ?>
            <a class="btn btn-md btn-warning" href="<?=base_url()?>?page=master/valas_track&action=track&halaman= TRACK VALAS&id_valas=<?=$prev['id_valas']?>">
                <i class="fa fa-chevron-left" aria-hidden="true"></i>
            </a>
        <?php
		//TOMBOL next	
		} } $next = mysql_fetch_array($q_valas_next); {
        if (isset($next['id_valas'])){
            ?>
            &nbsp;<a class="btn btn-md btn-warning" href="<?=base_url()?>?page=master/valas_track&action=track&halaman= TRACK VALAS&id_valas=<?=$next['id_valas']?>">
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </a>
            <?php
        } }
    
    ?>

    &nbsp;<a href="<?=base_url()?>?page=master/valas&halaman= VALAS" class="btn btn-md btn-danger pull-right" ><i class=" fa fa-reply"></i> BACK</a>
    <br>
    <br />
</section>



<section class="content">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="form-horizontal">
            <?php $res = mysql_fetch_array($q_valas); {?>
            		 <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode</label>
                         <div class="col-lg-10">
                             <input type="text" required class="form-control" name="kode_cabang" id="kode_cabang" placeholder="Kode valas..." readonly value="<?=$res['kode_valas']?>">
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                         <div class="col-lg-10">
                             <input type="text" class="form-control" name="nama" id="nama" placeholder="Keterangan..." readonly value="<?=$res['keterangan']?>">
                         </div>
                     </div>
                    
             <?php }; ?>  
            </div>
		</div>
	</div>
</section>