<?php
	include ('pages/data/script/m_satuan.php'); 
?>

<section class="content-header">
  <ol class="breadcrumb">
    <li><i class="fa fa-database"></i> Master</li>
    <li>Satuan</li>
    <li>Track Satuan</li>
  </ol>
</section>

<section class="content">

    	
        <?php
		//TOMBOL PREV
    	$prev = mysql_fetch_array($q_sat_prev); {
        if (isset($prev['id_satuan'])){
            ?>
            <a class="btn btn-md btn-warning" href="<?=base_url()?>?page=master/satuan_track&action=track&halaman= TRACK SATUAN&id_satuan=<?=$prev['id_satuan']?>">
                <i class="fa fa-chevron-left" aria-hidden="true"></i>
            </a>
        <?php
		//TOMBOL next	
		} } $next = mysql_fetch_array($q_sat_next); {
        if (isset($next['id_satuan'])){
            ?>
            &nbsp;<a class="btn btn-md btn-warning" href="<?=base_url()?>?page=master/satuan_track&action=track&halaman= TRACK SATUAN&id_satuan=<?=$next['id_satuan']?>">
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </a>
            <?php
        } }
    
    ?>

    &nbsp;<a href="<?=base_url()?>?page=master/satuan&halaman= SATUAN" class="btn btn-md btn-danger pull-right" ><i class=" fa fa-reply"></i> BACK</a>
    <br>
    <br />
</section>


<section class="content">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="form-horizontal">
            <?php $res = mysql_fetch_array($q_sat); {?>
            		 <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode</label>
                         <div class="col-lg-10">
                             <input type="text" required class="form-control" name="kode_cabang" id="kode_cabang" placeholder="Kode cabang..." readonly value="<?=$res['kode_satuan']?>">
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Satuan</label>
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