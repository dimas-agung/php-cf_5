<?php
	include ('pages/data/script/m_kat_cashflow.php'); 
?>

<section class="content-header">
	<h3>Track Setting Kategori Cashflow</h3>
    <br />
    <section class="content">

    	
        <?php
		//TOMBOL PREV
    	$prev = mysql_fetch_array($q_cf_prev); {
        if (isset($prev['id_kat_cashflow'])){
            ?>
            <a class="btn btn-md btn-warning" href="<?=base_url()?>?page=setting/kat_cashflow_track&action=track&halaman= TRACK KATEGORI CHASHFLOW&id_kat_cashflow=<?=$prev['id_kat_cashflow']?>">
                <i class="fa fa-chevron-left" aria-hidden="true"></i>
            </a>
        <?php
		//TOMBOL next	
		} } $next = mysql_fetch_array($q_cf_next); {
        if (isset($next['id_kat_cashflow'])){
            ?>
            &nbsp;<a class="btn btn-md btn-warning" href="<?=base_url()?>?page=setting/kat_cashflow_track&action=track&halaman= TRACK KATEGORI CHASHFLOW&id_kat_cashflow=<?=$next['id_kat_cashflow']?>">
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </a>
            <?php
        } }
    
    ?>

    &nbsp;<a href="<?=base_url()?>?page=setting/kat_cashflow&halaman= KATEGORI CHASHFLOW" class="btn btn-md btn-danger pull-right" ><i class=" fa fa-reply"></i> BACK</a>
    <br>
    <br />

    </section>
</section>


<section class="content">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="form-horizontal">
            <?php $res = mysql_fetch_array($q_cf); {?>
            		 <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode</label>
                         <div class="col-lg-10">
                             <input type="text" required class="form-control" name="kode_cabang" id="kode_cabang" placeholder="Kode Kategori CF..." readonly value="<?=$res['kode_kat_cashflow']?>">
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                         <div class="col-lg-10">
                             <input type="text" class="form-control" name="nama" id="nama" placeholder="Keterangan..." readonly value="<?=$res['nama']?>">
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Header</label>
                         <div class="col-lg-10">
                             <input type="text" class="form-control" name="ket_header" id="ket_header" placeholder="Keterangan..." readonly value="<?=$res['ket_header']?>">
                         </div>
                     </div>
                    
             <?php }; ?>  
            </div>
		</div>
	</div>
</section>