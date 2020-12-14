<?php 	
    include "pages/data/script/m_barang.php"; 
?>

<section class="content-header">
    <ol class="breadcrumb">
        <li><i class="fa fa-money"></i> Master</li>
        <li>Master Barang</li>
        <li>Track Master Barang</li>
    </ol>
</section>

<section class="content">
    <div class="col-md-10">
      <?php
        $prev = mysql_fetch_array($q_inv_prev); {
        if (isset($prev['id_inventori'])){
      ?>
          <a class="btn btn-warning" href="<?=base_url()?>?page=master/barang_track&action=track&halaman= TRACK MASTER BARANG&kode_inventori=<?=$prev['kode_inventori']?>">
            <i class="fa fa-chevron-left" aria-hidden="true"></i>
          </a>
      <?php
        } 
        } 

        $next = mysql_fetch_array($q_inv_next); {
        if (isset($next['id_inventori'])){
      ?>
          &nbsp;<a class="btn btn-warning" href="<?=base_url()?>?page=master/barang_track&action=track&halaman= TRACK MASTER BARANG&kode_inventori=<?=$next['kode_inventori']?>">
            <i class="fa fa-chevron-right" aria-hidden="true"></i>
          </a>
      <?php
        } 
        }
      ?>
      </div>

      <div class="col-md-2">
        &nbsp;
        <a href="<?=base_url()?>?page=master/barang&halaman= MASTER BARANG" class="btn btn-danger pull-right" ><i class=" fa fa-reply"></i> BACK</a>
      </div>
</section>

</br></br></br>

<!-- /.row -->
<div class="box box-info">
<div class="box-body">
            
    <div class="tabbable">
		<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
			<li <?=$class_form?>>
				<a data-toggle="tab" href="#menuFormPp">Data Barang</a>
			</li>
            <li <?=$class_tab2?>>
                <a data-toggle="tab" href="#bom">BOM</a>
            </li>
            <li <?=$class_tab?>>
				<a data-toggle="tab" href="#detail">Harga & diskon</a>
			</li> 
            <li <?=$class_tab1?>>
				<a data-toggle="tab" href="#akunting">Accounting</a>
			</li>
        </ul>
		

<div class="row">
<div class="tab-content">
	<div id="menuFormPp" <?=$class_pane_form?> >
	    <div class="col-lg-12">
	        <div class="panel panel-default">
	            <div class="panel-body">
                    <div class="form-horizontal">  	
                	<form action="" method="post" enctype="multipart/form-data">
                    <?php
                		if(isset($_GET['action']) and $_GET['action'] == "track") {
                			$row = mysql_fetch_array($q_inv);

                            $satuan_beli1 = $row['satuan_beli'];
                            $beli = explode(" : ",$satuan_beli1);
                            $satuan_beli = $beli[1];

                            $satuan_jual1 = $row['satuan_jual'];
                            $jual = explode(" : ",$satuan_jual1);
                            $satuan_jual = $jual[1];
                		}
                	?>     
                                           
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="kode_inventori" id="kode_inventori" placeholder="Kode Inventori..." readonly value="<?=(isset($row['kode_inventori']) ? $row['kode_inventori'] : "")?>">
                        </div>
                    </div>

                    <div class="form-group">
                     	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Nama</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Barang..." readonly value="<?=$row['nama']?>">
                        </div> 
                    </div>

                    <div class="form-group"> 
                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kategori Barang</label>
                        <div class="col-lg-4">
                            <select id="kategori" name="kategori" class="select2" disabled style="width: 100%;">
                            <option value="0">-- Pilih Kategori --</option>
                            <?php       
                                (isset($row['kode_inventori']) ? $kategori=$row['kategori'] : $kategori='');     
                                while($rowkategori = mysql_fetch_array($q_ddl_kat_inv)) { ;?>
                             
                                <option value="<?php echo $rowkategori['kode_kategori_inventori'];?>" 
                                    <?php if($rowkategori['kode_kategori_inventori']==$kategori){echo 'selected';} ?>>
                                    <?php echo $rowkategori['nama'];?> 
                                </option>
                            <?php } ?>
                            </select>
                        </div>  
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Satuan Kecil</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="satuan_beli" id="satuan_beli" placeholder="Satuan Beli..." readonly value="<?= $satuan_beli ?>">
                        </div> 
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Satuan Besar</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="satuan_jual" id="satuan_jual" placeholder="Satuan Jual..." readonly value="<?= $satuan_jual ?>">
                        </div> 
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Jumlah Isi</label>
                        <div class="col-lg-4">
                          <input type="text" class="form-control" name="jumlah_isi" id="jumlah_isi" placeholder="Jumlah Isi ..." value="<?=(isset($row['kode_inventori']) ? $row['isi'] : "")?>" readonly>
                        </div>   
                    </div>

                    <div class="form-group">
                     	<label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Stok</label>
                        <div class="col-lg-4">
                        <div class="checkbox">
                			<label>
                            <?php $jenis_stok='baru'; ?>	
                				<input name="jenis_stok" type="checkbox" class="ace" readonly       
                                        <?php if(isset($row['kode_inventori'])) { 	
                        				//JIKA ADA ISIAN JENIS STOK DI DB
                        					if($row['jenis_stok']=='1') {
                        						echo 'checked="checked"';
                        					}else{
                        						echo '';	
                        					}
                        				}else{
                        				//JIKA BARU
                        					echo 'checked="checked"';	
                        				} 
                				        ?> 
                                    />
                                <span class="lbl"></span>
                            </label>
                		</div>   
                        </div>
                    </div>
                     
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                        <div class="col-lg-4">
                            <input type="text" required class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan..." readonly value="<?= $row['keterangan'] ?>">
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
                
<!-- HARGA DISKON -->
<div id="detail" <?=$class_pane_tab?> >
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
                <div class="form-horizontal"> 
					<div class="box-body">

                        <div align="center" style="color:#006">
                            <h4><b>HARGA & DISKON</b></h4>
                        </div> 
                    </br>
                        <table id="" class="" rules="all">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Kategori Pelanggan</th>
                                    <th>Kategori Pelanggan</th>
                                    <th>Harga</th>
                                    <th>Diskon</th>
                                </tr>
                            </thead>
                            <tbody>	
                            <?php $no=1; while($row2 = mysql_fetch_array($q_inv_hrg_diskon)) { ;?>	
                                <tr>
                                    <td style="text-align: center"><?php echo $no++; ?></td>
                                    <td><?php echo $row2['kode_kategori_pelanggan']; ?> </td>
                                    <td><?php echo $row2['kat_pelanggan']; ?></td>
                                    <td style="text-align: right"><?php echo number_format($row2['harga']); ?></td>
                                    <td style="text-align: right"><?php echo $row2['diskon']; ?>&nbsp;&nbsp;&nbsp;&nbsp;<b>%</b></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <br><br>                         
                    <div align="center" class="form-group">
                        <a id="next-btn1" class="btn btn-primary"><i class=" fa fa-mail-forward"></i> Next</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  
<!-- HARGA DISKON -->

<!-- BOM -->
<div id="bom" <?=$class_pane_tab2?> >
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-horizontal">

                <div class="row">
                    <div class="col-md-12">
                        <h2 style="font-weight:bold; text-align: center;"><?php echo $row['nama']; ?></h2>
                        <hr>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Jumlah</label>
                    <div class="col-lg-4">
                        <input type="text"  class="form-control" name="qty_hdr" id="qty_hdr" readonly placeholder="Jumlah ..." value="<?= $row['qty_bom'];?>">
                    </div>

                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Satuan</label>
                    <div class="col-lg-4">
                        <select id="satuan_hdr" name="satuan_hdr" class="select2" disabled style="width: 100%;">
                            <option value="0">-- Pilih Satuan --</option>
                                <?php 
                                    (isset($row['kode_inventori']) ? $satuan_hdr=$row['satuan_bom'] : $satuan_hdr='');          
                                                          
                                    while($rowsathdr = mysql_fetch_array($q_satuan_hdr)) { ;?>
                                                     
                                    <option value="<?php echo $rowsathdr['kode_satuan'];?>" <?php if($rowsathdr['kode_satuan']==$satuan_hdr){echo 'selected';} ?>><?php echo $rowsathdr['nama_satuan'];?> </option>
                                <?php } ?>
                        </select>
                    </div>   
                </div>

                <div class="form-group">
                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                    <div class="col-lg-10">
                        <textarea  class="form-control" readonly name="ket_hdr" id="ket_hdr" placeholder="Keterangan..."><?= $row['keterangan_bom'];?></textarea>
                    </div>
                 </div>       
                                        
                <div class="form-group">
                    <div class="col-lg-12">
                    <table id="" class="" rules="all">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Barang</th>
                                <th>Satuan</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody >
                            <?php
                                    $no = 1 ;
                                    while($rowbom = mysql_fetch_array($q_bom)) { 
                                    
                                    $nama_barang = '';
                                    $kode_barang_dtl = $rowbom['kode_barang_dtl'];
                                    if(!empty($kode_barang_dtl)) {
                                        $pisah=explode(":",$kode_barang_dtl);
                                        $nama_barang=$pisah[1];
                                    }

                                    $satuan = '';
                                    $satuan_dtl = $rowbom['satuan_dtl'];
                                    if(!empty($satuan_dtl)) {
                                        $pisah=explode(":",$satuan_dtl);
                                        $satuan=$pisah[1];
                                    }
                            ?>
                            <tr> 
                                <td style="text-align: center"><?= $no++ ?></td>
                                <td><?= $nama_barang?></td>
                                <td><?= $satuan?></td>
                                <td style="text-align: right"><?= $rowbom['qty_dtl']?></td>
                                <td><?= $rowbom['keterangan_dtl']?></td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                    </div>
                </div>

                <br><br>

                <div align="center" class="form-group">
                    <a id="next-btn2" class="btn btn-primary"><i class=" fa fa-mail-forward"></i>Next</a>
                </div> 
                </div>
            </div>
        </div>
    </div>                
</div>
<!-- END BOM -->    
                
<!-- AKUNTING -->
				<div id="akunting" <?=$class_pane_tab1?> >
					<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-body">
                                	<div class="form-horizontal">

                                    		 <div class="form-group">
                                                 <label class="col-lg-3 col-sm-2 control-label" style="text-align:left">Terima Barang</label>
                                                 <div class="col-lg-9">
                                                     <select id="tb_debet" name="tb_debet" disabled class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Debet --</option>
                                                   <?php 
                                             //CEK JIKA KODE coa_debet ADA MAKA SELECTED	   
                                             (isset($row['kode_inventori']) ? $tb_debet=$row['tb_debet'] : $tb_debet='');	   					 					 //UNTUK AMBIL coanya 	
                                             while($rowtbdeb = mysql_fetch_array($q_ddl_coa)) { ;?>
                                             
                                                <option value="<?php echo $rowtbdeb['kode_coa'];?>" <?php if($rowtbdeb['kode_coa']==$tb_debet){echo 'selected';} ?>><?php echo $rowtbdeb['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowtbdeb['nama'];?> </option>
                                                   <?php } ?>
                                                </select>
                                                 </div>
                                             </div>     

                                             <div class="form-group">
                                                 <label class="col-lg-3 col-sm-2 control-label" style="text-align:left"></label>
                                                 <div class="col-lg-9">
                                                     <select id="tb_kredit" name="tb_kredit" disabled class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Kredit --</option>
                                                   <?php 
                                             //CEK JIKA KODE coa_kredit ADA MAKA SELECTED	   
                                             (isset($row['kode_inventori']) ? $tb_kredit=$row['tb_kredit'] : $tb_kredit='');	   					 					 //UNTUK AMBIL coanya 	
                                             while($rowtbkred = mysql_fetch_array($q_ddl_coa2)) { ;?>
                                             
                                                <option value="<?php echo $rowtbkred['kode_coa'];?>" <?php if($rowtbkred['kode_coa']==$tb_kredit){echo 'selected';} ?>><?php echo $rowtbkred['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowtbkred['nama'];?> </option>
                                                   <?php } ?>
                                                </select>
                                                 </div>
                                             </div>  

                                             <div class="form-group">
                                                 <label class="col-lg-3 col-sm-2 control-label" style="text-align:left">Surat Jalan</label>
                                                 <div class="col-lg-9">
                                                     <select id="sj_debet" name="sj_debet" disabled class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Debet --</option>
                                                   <?php 
                                             //CEK JIKA KODE coa_debet ADA MAKA SELECTED	   
                                             (isset($row['kode_inventori']) ? $sj_debet=$row['sj_debet'] : $sj_debet='');	   					 					 //UNTUK AMBIL coanya 	
                                             while($rowsjdeb = mysql_fetch_array($q_ddl_coa3)) { ;?>
                                             
                                                <option value="<?php echo $rowsjdeb['kode_coa'];?>" <?php if($rowsjdeb['kode_coa']==$sj_debet){echo 'selected';} ?>><?php echo $rowsjdeb['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowsjdeb['nama'];?> </option>
                                                   <?php } ?>
                                                </select>
                                                 </div>
                                             </div>     

                                             <div class="form-group">
                                                 <label class="col-lg-3 col-sm-2 control-label" style="text-align:left"></label>
                                                 <div class="col-lg-9">
                                                     <select id="sj_kredit" name="sj_kredit" disabled class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Kredit --</option>
                                                   <?php 
                                             //CEK JIKA KODE coa_kredit ADA MAKA SELECTED	   
                                             (isset($row['kode_inventori']) ? $sj_kredit=$row['sj_kredit'] : $sj_kredit='');	   					 					 //UNTUK AMBIL coanya 	
                                             while($rowsjkred = mysql_fetch_array($q_ddl_coa4)) { ;?>
                                             
                                                <option value="<?php echo $rowsjkred['kode_coa'];?>" <?php if($rowsjkred['kode_coa']==$sj_kredit){echo 'selected';} ?>><?php echo $rowsjkred['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowsjkred['nama'];?> </option>
                                                   <?php } ?>
                                                </select>
                                                 </div>
                                             </div>

                                             <div class="form-group">
                                                 <label class="col-lg-3 col-sm-2 control-label" style="text-align:left">Faktur Penjualan</label>
                                                 <div class="col-lg-9">
                                                     <select id="fj_debet" name="fj_debet" disabled class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Debet --</option>
                                                   <?php 
                                             //CEK JIKA KODE coa_debet ADA MAKA SELECTED       
                                             (isset($row['kode_inventori']) ? $fj_debet=$row['fj_debet'] : $fj_debet='');                                           //UNTUK AMBIL coanya   
                                             while($rowfjdeb = mysql_fetch_array($q_ddl_coa5)) { ;?>
                                             
                                                <option value="<?php echo $rowfjdeb['kode_coa'];?>" <?php if($rowfjdeb['kode_coa']==$fj_debet){echo 'selected';} ?>><?php echo $rowfjdeb['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowfjdeb['nama'];?> </option>
                                                   <?php } ?>
                                                </select>
                                                 </div>
                                             </div>     

                                             <div class="form-group">
                                                 <label class="col-lg-3 col-sm-2 control-label" style="text-align:left"></label>
                                                 <div class="col-lg-9">
                                                     <select id="fj_kredit" name="fj_kredit" disabled class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Kredit --</option>
                                                   <?php 
                                             //CEK JIKA KODE coa_kredit ADA MAKA SELECTED      
                                             (isset($row['kode_inventori']) ? $fj_kredit=$row['fj_kredit'] : $fj_kredit='');                                            //UNTUK AMBIL coanya   
                                             while($rowfjkred = mysql_fetch_array($q_ddl_coa6)) { ;?>
                                             
                                                <option value="<?php echo $rowfjkred['kode_coa'];?>" <?php if($rowfjkred['kode_coa']==$fj_kredit){echo 'selected';} ?>><?php echo $rowfjkred['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowfjkred['nama'];?> </option>
                                                   <?php } ?>
                                                </select>
                                                 </div>
                                             </div>

                                             <div class="form-group">
                                                 <label class="col-lg-3 col-sm-2 control-label" style="text-align:left">Faktur Pembelian</label>
                                                 <div class="col-lg-9">
                                                     <select id="fb_debet" name="fb_debet" disabled class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Debet --</option>
                                                   <?php 
                                             //CEK JIKA KODE coa_debet ADA MAKA SELECTED	   
                                             (isset($row['kode_inventori']) ? $fb_debet=$row['fb_debet'] : $fb_debet='');	   					 					 //UNTUK AMBIL coanya 	
                                             while($rowfbdeb = mysql_fetch_array($q_ddl_coa7)) { ;?>
                                             
                                                <option value="<?php echo $rowfbdeb['kode_coa'];?>" <?php if($rowfbdeb['kode_coa']==$fb_debet){echo 'selected';} ?>><?php echo $rowfbdeb['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowfbdeb['nama'];?> </option>
                                                   <?php } ?>
                                                </select>
                                                 </div>
                                             </div>     

                                             <div class="form-group">
                                                 <label class="col-lg-3 col-sm-2 control-label" style="text-align:left"></label>
                                                 <div class="col-lg-9">
                                                     <select id="fb_kredit" name="fb_kredit" disabled class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Kredit --</option>
                                                   <?php 
                                             //CEK JIKA KODE coa_kredit ADA MAKA SELECTED	   
                                             (isset($row['kode_inventori']) ? $fb_kredit=$row['fb_kredit'] : $fb_kredit='');	   					 					 //UNTUK AMBIL coanya 	
                                             while($rowfbkred = mysql_fetch_array($q_ddl_coa8)) { ;?>
                                             
                                                <option value="<?php echo $rowfbkred['kode_coa'];?>" <?php if($rowfbkred['kode_coa']==$fb_kredit){echo 'selected';} ?>><?php echo $rowfbkred['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowfbkred['nama'];?> </option>
                                                   <?php } ?>
                                                </select>
                                                 </div>
                                             </div>

                                             <div class="form-group">
                                                 <label class="col-lg-3 col-sm-2 control-label" style="text-align:left">Retur Beli</label>
                                                 <div class="col-lg-9">
                                                     <select id="rb_debet" name="rb_debet" disabled class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Debet --</option>
                                                   <?php 
                                             //CEK JIKA KODE coa_debet ADA MAKA SELECTED	   
                                             (isset($row['kode_inventori']) ? $rb_debet=$row['rb_debet'] : $rb_debet='');	   					 					 //UNTUK AMBIL coanya 	
                                             while($rowrbdeb = mysql_fetch_array($q_ddl_coa9)) { ;?>
                                             
                                                <option value="<?php echo $rowrbdeb['kode_coa'];?>" <?php if($rowrbdeb['kode_coa']==$rb_debet){echo 'selected';} ?>><?php echo $rowrbdeb['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowrbdeb['nama'];?> </option>
                                                   <?php } ?>
                                                </select>
                                                 </div>
                                             </div>     

                                             <div class="form-group">
                                                 <label class="col-lg-3 col-sm-2 control-label" style="text-align:left"></label>
                                                 <div class="col-lg-9">
                                                     <select id="rb_kredit" name="rb_kredit" disabled class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Kredit --</option>
                                                   <?php 
                                             //CEK JIKA KODE coa_kredit ADA MAKA SELECTED	   
                                             (isset($row['kode_inventori']) ? $rb_kredit=$row['rb_kredit'] : $rb_kredit='');	   					 					 //UNTUK AMBIL coanya 	
                                             while($rowrbkred = mysql_fetch_array($q_ddl_coa10)) { ;?>
                                             
                                                <option value="<?php echo $rowrbkred['kode_coa'];?>" <?php if($rowrbkred['kode_coa']==$rb_kredit){echo 'selected';} ?>><?php echo $rowrbkred['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowrbkred['nama'];?> </option>
                                                   <?php } ?>
                                                </select>
                                                 </div>
                                             </div> 

                                             <div class="form-group">
                                                 <label class="col-lg-3 col-sm-2 control-label" style="text-align:left">Retur Jual</label>
                                                 <div class="col-lg-9">
                                                     <select id="rj_debet" name="rj_debet" disabled class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Debet --</option>
                                                   <?php 
                                             //CEK JIKA KODE coa_debet ADA MAKA SELECTED	   
                                             (isset($row['kode_inventori']) ? $rj_debet=$row['rj_debet'] : $rj_debet='');	   					 					 //UNTUK AMBIL coanya 	
                                             while($rowrjdeb = mysql_fetch_array($q_ddl_coa11)) { ;?>
                                             
                                                <option value="<?php echo $rowrjdeb['kode_coa'];?>" <?php if($rowrjdeb['kode_coa']==$rj_debet){echo 'selected';} ?>><?php echo $rowrjdeb['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowrjdeb['nama'];?> </option>
                                                   <?php } ?>
                                                </select>
                                                 </div>
                                             </div>    

                                             <div class="form-group">
                                                 <label class="col-lg-3 col-sm-2 control-label" style="text-align:left"></label>
                                                 <div class="col-lg-9">
                                                     <select id="rj_kredit" name="rj_kredit" disabled class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Kredit --</option>
                                                   <?php 
                                             //CEK JIKA KODE coa_kredit ADA MAKA SELECTED	   
                                             (isset($row['kode_inventori']) ? $rj_kredit=$row['rj_kredit'] : $rj_kredit='');	   					 					 //UNTUK AMBIL coanya 	
                                             while($rowrjkred = mysql_fetch_array($q_ddl_coa12)) { ;?>
                                             
                                                <option value="<?php echo $rowrjkred['kode_coa'];?>" <?php if($rowrjkred['kode_coa']==$rj_kredit){echo 'selected';} ?>><?php echo $rowrjkred['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowrjkred['nama'];?> </option>
                                                   <?php } ?>
                                                </select>
                                                 </div>
                                             </div>       
                                             
                                             <?php //echo $sql; ?>
                                             
                                             
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

<script src="<?=base_url()?>assets/select2/select2.js"></script>

<script>
  $(document).ready(function (e) {
        
        $(".select2").select2({
          width: '100%'
         });
  });

</script>