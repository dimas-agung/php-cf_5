<?php
	include ('pages/data/script/m_coa.php'); 
?>

<section class="content-header">
  <ol class="breadcrumb">
    <li><i class="fa fa-database"></i> Master</li>
    <li>COA</li>
    <li>Track COA</li>
  </ol>
</section>

<section class="content">
        <?php
		//TOMBOL PREV
    	$prev = mysql_fetch_array($q_coa_prev); {
        if (isset($prev['id_coa'])){
            ?>
            <a class="btn btn-md btn-warning" href="<?=base_url()?>?page=master/coa_track&halaman=TRACK COA&action=track&id_coa=<?=$prev['id_coa']?>">
                <i class="fa fa-chevron-left" aria-hidden="true"></i>
            </a>
        <?php
		//TOMBOL next	
		} } $next = mysql_fetch_array($q_coa_next); {
        if (isset($next['id_coa'])){
            ?>
            &nbsp;<a class="btn btn-md btn-warning" href="<?=base_url()?>?page=master/coa_track&halaman=TRACK COA&action=track&id_coa=<?=$next['id_coa']?>">
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </a>
            <?php
        } }
    
    ?>

    &nbsp;<a href="<?=base_url()?>?page=master/coa&halaman= COA" class="btn btn-md btn-danger pull-right" ><i class=" fa fa-reply"></i> BACK</a>
    <br>
    <br />
</section>


<section class="content">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="form-horizontal">
            <?php $res = mysql_fetch_array($q_coa); {?>
            		 <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode</label>
                         <div class="col-lg-10">
                             <input type="text" required class="form-control" name="kode_cabang" id="kode_cabang" placeholder="Kode cabang..." readonly value="<?=$res['kode_coa']?>">
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Coa</label>
                         <div class="col-lg-10">
                             <input type="text" class="form-control" name="nama" id="nama" placeholder="Cabang..." readonly value="<?=$res['nama']?>">
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kategori</label>
                         <div class="col-lg-10">
                             <input type="text" class="form-control" name="keterangan" readonly id="keterangan" placeholder="Kategori COA..." value="<?=$res['kategori_coa']?>" >
                         </div>
                     </div>
                     
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Level Coa</label>
                         <div class="col-lg-10">
                             <input type="text" class="form-control" name="nama" id="nama" placeholder="Level..." readonly value="<?=$res['level_coa']?>">
                         </div>
                     </div>
                     
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Mata Uang</label>
                         <div class="col-lg-10">
                             <input type="text" class="form-control" name="keterangan" readonly id="keterangan" placeholder="Mata Uang..." value="<?=$res['nama_mata_uang']?>" >
                         </div>
                     </div>
                     
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kategori Cashflow</label>
                         <div class="col-lg-10">
                             <input type="text" class="form-control" name="keterangan" readonly id="keterangan" placeholder="Kategori CF..." value="<?=$res['cashflow']?>" >
                         </div>
                     </div>
                     
                     <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">D / K</label>
                         <div class="col-lg-10">
                             <input type="text" class="form-control" name="keterangan" readonly id="keterangan" placeholder="Debet / Kredit..." value="<?=$res['dk']?>" >
                         </div>
                     </div>
                    
             <?php }; ?>  
            </div>
		</div>
	</div>
</section>