<?php 
    include "pages/data/script/barangbaru.php"; 
?>

<script>
  $(document).ready(function (e) {
    $(".select2").select2({
        width: '100%'
    });
  });
</script>

<section class="content-header">
    <ol class="breadcrumb">
        <li><i class="fa fa-database"></i> Master</li>
        <li>Barang</a></li>
    </ol>
</section>

<div class="box box-info">
    <div class="box-body">

        <?php if (isset($_GET['pesan'])){ ?>      
            <div class="form-group" id="form_report">
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      Kode Barang :  <a href="<?=base_url()?>?page=master/barang_track&halaman= TRACK BARANG&action=track&kode_inventori=<?=$_GET['pesan']?>" target="_blank"><?=$_GET['pesan'] ?></a>  Berhasil Di Posting
                </div>
            </div>    
        <?php  }  ?>

        <?php if (isset($_GET['pesan1'])){ ?>      
            <div class="form-group" id="form_report">
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      Kode Barang :  <a href="<?=base_url()?>?page=master/barang_track&halaman= TRACK BARANG&action=track&kode_inventori=<?=$_GET['pesan1']?>" target="_blank"><?=$_GET['pesan1'] ?></a>  Berhasil Di Update
                </div>
            </div>    
        <?php  }  ?>
            
        <div class="tabbable">
            <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
                <li <?=$class_form?>>
                    <a data-toggle="tab" href="#menuFormPp">Data Barang</a>
                </li>
                <li <?=$class_tab2?>>
                    <a data-toggle="tab" href="#bom">BOM</a>
                </li> 
                <li <?=$class_tab1?>>
                    <a data-toggle="tab" href="#akunting">Accounting</a>
                </li>
                <li <?=$class_tab?>>
                    <a data-toggle="tab" href="#menuListPp">List barang</a>
                </li>
            </ul>

<div class="row">
	<div class="tab-content">

		<div id="menuFormPp" <?=$class_pane_form?> >
		    <div class="col-lg-12">
		        <div id="" class="panel panel-default">
		            <div class="panel-body">
		                <div class="form-horizontal">
		                    <?php $id_form = buatkodeform("kode_form"); ?>

		                    <form role="form" method="post" action="" id="saveForm"> 

			                    <?php   $idtem = "INSERT INTO form_id SET kode_form ='".$id_form."' ";
			                    mysql_query($idtem); ?>
		                        <input type="hidden" name="id_form" id="id_form" value="<?php echo $id_form; ?>"/>  
		                                           
		                        <div class="form-group">
		                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode <b style="color: red;">*</b></label>
		                            <div class="col-lg-4">
		                                <input type="text" class="form-control" name="kode_inventori" id="kode_inventori" placeholder="Kode Barang ..." value="">
		                            </div>
									<span id="pesan" class="span" style="color:#F00; font-weight:bold"></span>
		                        </div>

		                        <div class="form-group">
		                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Nama <b style="color: red;">*</b></label>
		                            <div class="col-lg-4">
		                                <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama..." value="" autocomplete="off">
		                            </div>   
		                        </div>

		                        <div class="form-group">
		                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kategori Barang <b style="color: red;">*</b></label>
		                            <div class="col-lg-4">
		                                <select id="kategori" name="kategori" class="select2" style="width: 100%;">
		                                <option value="0">-- Pilih Kategori --</option>
		                                <?php 
		                                    while($rowkategori = mysql_fetch_array($q_ddl_kat_inv)) { ;?>
		                                        <option value="<?php echo $rowkategori['kode_kategori_inventori'];?>">
		                                            <?php echo $rowkategori['nama'];?>   
		                                        </option>
		                                <?php } ?>
		                                </select>
		                            </div>
		                        </div>

		                        <div class="form-group">
		                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Satuan Kecil <b style="color: red;">*</b></label>
		                            <div class="col-lg-4">
		                                <select id="satuan_beli" name="satuan_beli" class="select2" style="width: 100%;">
		                                <option value="0">-- Pilih Satuan Kecil --</option>
		                                <?php    
		                                    while($rowsat = mysql_fetch_array($q_ddl_satuan_beli)) { ;?>
		                                        <option value="<?php echo $rowsat['kode_satuan'].' : '.$rowsat['nama'];?>">
		                                            <?php echo $rowsat['nama'];?> 
		                                        </option>
		                                <?php } ?>
		                                </select>
		                            </div>   
		                        </div>

		                        <div class="form-group">
		                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Satuan Besar <b style="color: red;">*</b></label>
		                            <div class="col-lg-4">
		                                <select id="satuan_jual" name="satuan_jual" class="select2" style="width: 100%;">
		                                <option value="0" selected>-- Pilih Satuan Besar --</option>
		                                <?php 
		                                    while($rowsat1 = mysql_fetch_array($q_ddl_satuan_jual)) { ;?>
		                                        <option value="<?php echo $rowsat1['kode_satuan'].' : '.$rowsat1['nama'];?>">
		                                            <?php echo $rowsat1['nama'];?> 
		                                        </option>
		                                <?php } ?>
		                                </select>
		                            </div>   
		                        </div>

		                        <div class="form-group">
		                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Jumlah Isi <b style="color: red;">*</b></label>
		                            <div class="col-lg-4">
		                                <input type="text" class="form-control" name="jumlah_isi" id="jumlah_isi" placeholder="Jumlah Isi ..." value="" autocomplete="off">
		                            </div>   
		                        </div>

		                        <div class="form-group">
		                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Stok</label>
		                            <div class="col-lg-4">
		                            <div class="checkbox">
		                                <label>
		                                <?php $jenis_stok='baru'; ?>    
		                                    <input name="jenis_stok" type="checkbox" class="ace" 
		                                                    
		                                    <?php if(isset($row['id_inventori'])) {   
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
		                                    ?> />
		                                    <span class="lbl"></span>
		                                </label>
		                            </div>   
		                            </div>
		                        </div>
		                                         
		                        <div class="form-group">
		                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
		                            <div class="col-lg-4">
		                                <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan..." value="">
		                            </div>
		                        </div>
		                           
		                        <input type="hidden" value="0"  id="b_grand_total" name="b_grand_total" class="form-control" >

		                        <label><b style="color: red;">* &nbsp;Wajib Diisi</b></label>

		                        <hr>
		                            <div align="center" style="color:#006">
		                                <h4><b>HARGA & DISKON</b></h4>
		                            </div> 
		                        <hr>
		                        
		                        <div class="form-group">
		                            <div id="list_harga_diskon">
		                                <div class="col-lg-12">  
		                                    <table id="" class="" rules="all">
		                                        <thead>
		                                            <tr>
		                                                <th>No</th>
		                                                <th>Kode Kategori Pelanggan</th>
		                                                <th>Kategori Pelanggan</th>
		                                                <th>Harga Jual(IDR)</th>
		                                                <th>Diskon</th>
		                                            </tr>
		                                        </thead>                     
		                                        <tbody> 
		                                        <?php $no=1; while($row2 = mysql_fetch_array($q_inv_hrg_diskon)) { ;?>  
		                                            <tr>
		                                                <td style="text-align: center"><?php echo $no++; ?></td>
		                                                <td><?php echo $row2['kode_kategori_pelanggan']; ?>
		                                                    <input type="hidden" name="kode_kategori_pelanggan[]" id="kode_kategori_pelanggan[]" value="<?php echo $row2['kode_kategori_pelanggan']; ?>">  
		                                                </td>
		                                                <td><?php echo $row2['nama']; ?></td>
		                                                <td><input type="text" class="form-control" style="text-align: right" name="harga[]" value="0"></td>
		                                                <td>
		                                                    <div class="input-group">
		                                                        <input type="text" class="form-control" name="diskon[]" id="diskon[]" autocomplete="off" value="0" aria-describedby="basic-addon2" style="font-size: 13px; text-align: right">
		                                                        <span class="input-group-addon" id="basic-addon2"><b>%</b></span>
		                                                    </div>
		                                                </td>
		                                            </tr>
		                                        <?php } ?>
		                                        </tbody>
		                                    </table>
		                                </div>
		                            </div>
		                        </div>
		                        <br><br>
		                                         
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

	<!-- BOM -->
		<div id="bom" <?=$class_pane_tab2?> >
		    <div class="col-lg-12">
		        <div class="panel panel-default">
		            <div class="panel-body">
		                <div class="form-horizontal">

		                        <div class="row hidden" id="judul_inventori_bom_el" >
		                            <div class="col-md-12">
		                               <h2 id="judul_inventori_bom" style="font-weight:bold; text-align: center;"></h2>
		                               <hr>
		                            </div>
		                        </div>

		                        <div class="form-group" hidden>
		                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode Barang</label>
		                                <div class="col-lg-4">
		                                    <input type="text" class="form-control" name="kode_inventori_hdr" id="kode_inventori_hdr" placeholder="Kode Barang ..." value="">
		                                </div>

		                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Nama Barang</label>
		                                <div class="col-lg-4">
		                                    <input type="text" class="form-control" name="nama_hdr" id="nama_hdr" placeholder="Nama Barang..." value="" autocomplete="off">
		                                </div>   
		                        </div>

		                        <div class="form-group">
		                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Jumlah</label>
		                                <div class="col-lg-4">
		                                    <input type="text"  class="form-control" name="qty_hdr" id="qty_hdr" placeholder="Jumlah ..." value="">
		                                </div>

		                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Satuan</label>
		                                <div class="col-lg-4">
		                                    <select id="satuan_hdr" name="satuan_hdr" class="select2" style="width: 100%;">
		                                        <option value="0">-- Pilih Satuan --</option>
		                                        <?php           
		                                            while($rowsathdr = mysql_fetch_array($q_satuan_hdr)) { ;?>
		                                                <option value="<?php echo $rowsathdr['kode_satuan'];?>">
		                                                    <?php echo $rowsathdr['nama_satuan'];?> 
		                                                </option>
		                                        <?php } ?>
		                                    </select>
		                                </div>   
		                        </div>

		                        <div class="form-group">
		                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
		                            <div class="col-lg-10">
		                                <textarea  class="form-control" rows="2" name="ket_hdr" id="ket_hdr" placeholder="Keterangan..."></textarea>
		                            </div>
		                        </div>

		                        <div class="form-group">
		                            <div class="col-lg-12">                                     
		                                <div class="pull-left">  
		                                    <a class="btn btn-success" id="tambah_barang"><i class="fa fa-plus"></i> Add</a>                        
		                                </div>   
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
		                                        <th></th>
		                                    </tr>

		                                    <tr id="show_input_barang" style="display:none">
		                                        <td style="text-align: center ;"><h5><b>#</b></h5></td>
		                                        <td style="width: 40%;">
		                                            <select id="kode_barang_dtl" name="kode_barang_dtl" class="select2">
		                                                <option value="0">-- Pilih Barang --</option>
		                                                <?php                        
		                                                    while($rowinv = mysql_fetch_array($q_barang_dtl)) { ;?>
		                                                    <option value="<?php echo $rowinv['kode_inventori'].':'.$rowinv['nama'];?>" ><?php echo $rowinv['kode_inventori'].'&nbsp;&nbsp; || &nbsp;&nbsp;'.$rowinv['nama'];?> </option>
		                                                <?php } ?>
		                                            </select>
		                                        </td>
		                                        <td style="width: 15%;">
		                                            <select id="satuan_dtl" name="satuan_dtl" class="select2">
		                                                <option value="0">-- Pilih Satuan --</option>
		                                                <?php                        
		                                                    while($rowsatdtl = mysql_fetch_array($q_satuan_dtl)) { ;?>
		                                                    <option value="<?php echo $rowsatdtl['kode_satuan'].':'.$rowsatdtl['nama_satuan'];?>" ><?php echo $rowsatdtl['nama_satuan'];?> </option>
		                                                <?php } ?>
		                                            </select>
		                                        </td>
		                                        <td>
		                                            <input class="form-control" type="number" name="qty_dtl" id="qty_dtl" autocomplete="off" value=""/>
		                                        </td>
		                                        <td>
		                                            <input class="form-control" type="text" name="ket_dtl" id="ket_dtl"  autocomplete="off"  value=""/>
		                                        </td>
		                                        <td style="text-align: center; width: 8%;">
		                                            <button id="ok_input" class="btn btn-sm btn-info ace-icon fa fa-check pb-bom" title="ok"></button>
		                                            <a href="" id="batal_input" class="btn btn-sm btn-danger ace-icon fa fa-remove" title="batal" ></a>
		                                        </td> 
		                                    </tr>
		                                </thead>
		                                <tbody id="detail_input_barang">
		                                    <tr> 
		                                        <td colspan="6" class="text-center"> Tidak ada item barang. </td>
		                                    </tr>
		                                </tbody>
		                            </table>
		                        </div>
		                        </div>
								<br><br>
		                        <div align="center" class="form-group">
		                            <a id="next-btn1" class="btn btn-primary"><i class=" fa fa-mail-forward"></i>Next</a>
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
                                            <select id="tb_debet" name="tb_debet" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Debet --</option>
                                                <?php 
                                                    while($rowtbdeb = mysql_fetch_array($q_ddl_coa)) { ;?>
                                                    <option value="<?php echo $rowtbdeb['kode_coa'] ;?>">
                                                        <?php echo $rowtbdeb['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowtbdeb['nama'];?> 
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>     

                                    <div class="form-group">
                                        <label class="col-lg-3 col-sm-2 control-label" style="text-align:left"></label>
                                        <div class="col-lg-9">
                                            <select id="tb_kredit" name="tb_kredit" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Kredit --</option>
                                                <?php 
                                                    while($rowtbkred = mysql_fetch_array($q_ddl_coa2)) { ;?>
                                                    <option value="<?php echo $rowtbkred['kode_coa'];?>">
                                                        <?php echo $rowtbkred['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowtbkred['nama'];?>   
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>  

                                    <hr>

                                    <div class="form-group">
                                        <label class="col-lg-3 col-sm-2 control-label" style="text-align:left">Surat Jalan</label>
                                        <div class="col-lg-9">
                                            <select id="sj_debet" name="sj_debet" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Debet --</option>
                                                <?php     
                                                    while($rowsjdeb = mysql_fetch_array($q_ddl_coa3)) { ;?>
                                                    <option value="<?php echo $rowsjdeb['kode_coa'];?>">
                                                        <?php echo $rowsjdeb['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowsjdeb['nama'];?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>     

                                    <div class="form-group">
                                        <label class="col-lg-3 col-sm-2 control-label" style="text-align:left"></label>
                                        <div class="col-lg-9">
                                            <select id="sj_kredit" name="sj_kredit" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Kredit --</option>
                                                <?php 
                                                    while($rowsjkred = mysql_fetch_array($q_ddl_coa4)) { ;?>
                                                    <option value="<?php echo $rowsjkred['kode_coa'];?>">
                                                        <?php echo $rowsjkred['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowsjkred['nama'];?> 
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="form-group">
                                        <label class="col-lg-3 col-sm-2 control-label" style="text-align:left">Faktur Penjualan</label>
                                        <div class="col-lg-9">
                                            <select id="fj_debet" name="fj_debet" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Debet --</option>
                                                <?php            
                                                    while($rowfjdeb = mysql_fetch_array($q_ddl_coa5)) { ;?>
                                                    <option value="<?php echo $rowfjdeb['kode_coa'];?>">
                                                        <?php echo $rowfjdeb['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowfjdeb['nama'];?> 
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>     

                                    <div class="form-group">
                                        <label class="col-lg-3 col-sm-2 control-label" style="text-align:left"></label>
                                        <div class="col-lg-9">
                                            <select id="fj_kredit" name="fj_kredit" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Kredit --</option>
                                                <?php     
                                                    while($rowfjkred = mysql_fetch_array($q_ddl_coa6)) { ;?>
                                                    <option value="<?php echo $rowfjkred['kode_coa'];?>">
                                                        <?php echo $rowfjkred['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowfjkred['nama'];?> 
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="form-group">
                                        <label class="col-lg-3 col-sm-2 control-label" style="text-align:left">Retur Beli</label>
                                        <div class="col-lg-9">
                                            <select id="rb_debet" name="rb_debet" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Debet --</option>
                                                <?php     
                                                    while($rowrbdeb = mysql_fetch_array($q_ddl_coa9)) { ;?>
                                                    <option value="<?php echo $rowrbdeb['kode_coa'];?>">
                                                        <?php echo $rowrbdeb['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowrbdeb['nama'];?> 
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>     

                                    <div class="form-group">
                                        <label class="col-lg-3 col-sm-2 control-label" style="text-align:left"></label>
                                        <div class="col-lg-9">
                                            <select id="rb_kredit" name="rb_kredit" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Kredit --</option>
                                                <?php  
                                                    while($rowrbkred = mysql_fetch_array($q_ddl_coa10)) { ;?>
                                                    <option value="<?php echo $rowrbkred['kode_coa'];?>">
                                                        <?php echo $rowrbkred['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowrbkred['nama'];?> </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div> 

                                    <hr>

                                    <div class="form-group">
                                        <label class="col-lg-3 col-sm-2 control-label" style="text-align:left">Retur Jual</label>
                                        <div class="col-lg-9">
                                            <select id="rj_debet" name="rj_debet" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Debet --</option>
                                                <?php 
                                                    while($rowrjdeb = mysql_fetch_array($q_ddl_coa11)) { ;?>
                                                    <option value="<?php echo $rowrjdeb['kode_coa'];?>">
                                                        <?php echo $rowrjdeb['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowrjdeb['nama'];?> 
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>    

                                    <div class="form-group">
                                        <label class="col-lg-3 col-sm-2 control-label" style="text-align:left"></label>
                                        <div class="col-lg-9">
                                            <select id="rj_kredit" name="rj_kredit" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Kredit --</option>
                                                <?php 
                                                    while($rowrjkred = mysql_fetch_array($q_ddl_coa12)) { ;?>
                                                    <option value="<?php echo $rowrjkred['kode_coa'];?>">
                                                        <?php echo $rowrjkred['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowrjkred['nama'];?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div> 

                                    <br><br>

                                    <div class="form-group col-md-12" style="text-align: center;">
                                        <?php 
                                            $list_survey_write = 'n';
                                            while($res = mysql_fetch_array($q_akses)) {; ?>    
                                                <?php 
                                                //FORM SURVEY
                                                if($res['form']=='survey'){ 
                                                    if($res['w']=='1'){
                                                        $list_survey_write = 'y';   
                                                ?>  
                                            <button type="submit" name="simpan" id="simpan" class="btn btn-primary pb-save" tabindex="10">
                                                <i class="fa fa-check-square-o"></i> Simpan
                                            </button> 
                                        <?php } } } ?>
                                            
                                             <a href="<?=base_url()?>?page=master/barang&halaman= BARANG" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>&nbsp; <img src="<?=base_url()?>assets/images/loading.gif" class="animated"/>
               
                                    </div>
                                 </form>  
                                </div>
                            </div>
                        </div>
                    </div>                
                </div>

	<!-- END AKUNTING -->                
                
	<!-- LIST BARANG -->
                <div id="menuListPp" <?=$class_pane_tab?> >                 
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">  
                            <div class="box-body">  
								<table class="table table-bordered" id="table-barang" width="100%">
										<thead>
											<tr>
												<th>ID</th>
												<th>Kode Barang</th>
												<th>Nama</th>
												<th>Kategori</th>
												<th>Keterangan</th>
                                                <th>Status</th>
												<th>Aksi</th>
											</tr>
										</thead>
										<tbody></tbody>
								</table>	
                            </div>  
                            </div>
                            <!-- /.panel-body -->
                        </div>                       
                        <!-- /.panel-default -->
                    </div>
                    <!-- /.col-lg-12 -->    
                </div>        
	<!-- END LIST BARANG -->
                        
	</div>
</div>

<?php unset($_SESSION['data_barang']); ?>
<script>
		var tabel = null;

		$(document).ready(function() {
		    tabel = $('#table-barang').DataTable({
		        "processing": true,
		        "serverSide": true,
		        "ordering": true, // Set true agar bisa di sorting
		        "order": [[ 1, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
		        "ajax":
		        {
		            "url": '<?=base_url()?>ajax/list_barang.php', // URL file untuk proses select datanya
		            "type": "POST"
		        },
				"deferRender": true,
		        "aLengthMenu": [[10, 20, 50, 100],[10, 20, 50, 100]], // Combobox Limit
		        "columns": [
		            { "data": "id_inventori" }, // Tampilkan nis
		            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var kode  = "<a href='<?=base_url()?>?page=master/barang_track&halaman= TRACK BARANG&action=track&kode_inventori="+row.kode_inventori+"'>"+row.kode_inventori+"</a>"

                        return kode;
                       }
                    },
					{ "data": "nama" },  
		            { "data": "kategori" }, 
		            { "data": "keterangan" }, 
		            { "render": function ( data, type, row ) {  
                            var status = ""

                            if(row.aktif == 1){
                                status = '<span class="btn-sm btn-success fa fa-check"></span>' 
                            }else{ // Jika bukan 1
                                status = '<span class="btn-sm btn-danger fa fa-remove'
                            }

                            return status; 
                        }
                    },
                    { "render": function ( data, type, row ) { 
                            var html  = "<a href='<?=base_url()?>?page=master/barang_edit&action=edit&kode_inventori="+row.kode_inventori+"'>EDIT</a> | "

                            // html += '<a href="<?=base_url()?>?page=master/barang_track&halaman= TRACK BARANG&action=track&kode_inventori='+row.kode_inventori+'"></a>'
                            
                            if(row.aktif == 1){
                                html += '<a href="<?=base_url()?>?page=master/barang&action=nonaktif&kode_inventori='+row.kode_inventori+'">NON-AKTIF</a>' 
                            }else{ // Jika bukan 1
                                html += '<a href="<?=base_url()?>?page=master/barang&action=aktif&kode_inventori='+row.kode_inventori+'">AKTIF</a>'
                            }

                            return html;
                        }
                    },
		        ],
		    });
		});
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('.pb-save').click(function(){
			
		$span = $(".span");
			
            if($('#kode_inventori').val() == '' ) {
                alert("Data Barang => Kode, belum diisi");
                return false;
            }

            if($('#nama').val() == '' ) {
                alert(" Data Barang => Nama, belum diisi");
                return false;
            }

            if($('#kategori').val() == '0' ) {
                alert(" Data Barang => Kategori Barang, belum dipilih");
                return false;
            }

            if($('#satuan_beli').val() == '0' ) {
                alert(" Data Barang => Satuan Beli, belum dipilih");
                return false;
            }

            if($('#satuan_jual').val() == '0' ) {
                alert(" Data Barang => Satuan Jual, belum dipilih");
                return false;
            }

            if($('#jumlah_isi').val() == '0' ) {
                alert(" Data Barang => Jumlah Isi, belum dipilih");
                return false;
            }
			
			if($span.text() != ""){
				alert("Kode Sudah Terpakai");
				$('#kode_inventori').focus();
				return false;
			}
			
        });
    });
</script>

<script>
    $(document).ready(function (e) {
        $("#saveForm").on('submit',(function(e) {
            var grand_total = $("#id_form").val();
            if(grand_total == "" || isNaN(grand_total)) {grand_total = 0;}
            e.preventDefault();
            if(grand_total != 0) {          
                $(".animated").show();
                $.ajax({
                    
                    url: "<?=base_url()?>ajax/j_barang.php?func=save",
                    type: "POST",
                    data:  new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(html)
                    {
                        var msg = html.split("||");
                        if(msg[0] == "00") {
                            window.location = '<?=base_url()?>?page=master/barang&halaman= BARANG&pesan='+msg[1];
                        } else {
                            notifError(msg[1]);
                        }
                        $(".animated").hide();
                    }  
               });
            } else {notifError("<p>Item masih kosong.</p>");}
         }));
      });

    $('#nama').change(function(){
        title = $(this).val();
        if(title == '') {
            if(!$('#judul_inventori_bom_el').hasClass('hidden')) {
                $('#judul_inventori_bom_el').addClass('hidden')
            }
        }else {
            if($('#judul_inventori_bom_el').hasClass('hidden')) {
                $('#judul_inventori_bom_el').removeClass('hidden')
            }
        }
        $('#judul_inventori_bom').text(title);
    });
    
    $("#tambah_barang").click(function(event) {
        event.preventDefault();
        document.getElementById('show_input_barang').style.display = "table-row";

        $('#kode_barang_dtl').val('0').trigger('change');
        $('#satuan_dtl').val('0').trigger('change');
        $('#qty_dtl').val('0');
        $('#ket_dtl').val('');
       
    }); 

    $("#batal_input").click(function(event) { 
        event.preventDefault(); 
        document.getElementById('show_input_barang').style.display = "none";
    });
    
    $("#ok_input").click(function(event) { 

        if($('#kode_barang_dtl').val() == '0' ) {
                alert("Barang belum dipilih");
                return false;
        }

        if($('#satuan_dtl').val() == '0' ) {
                alert("Satuan belum dipilih");
                return false;
        }

        if($('#qty_dtl').val() == '0' ) {
                alert("Jumlah belum diisi");
                return false;
        }

        event.preventDefault();
        var id_form         = $("#id_form").val();
        var kode_barang_dtl = $("#kode_barang_dtl").val();
        var satuan_dtl      = $("#satuan_dtl").val();
        var qty_dtl         = $("#qty_dtl").val();
        var ket_dtl         = $("#ket_dtl").val();
        
        $.ajax({
            type: "POST",
            url: "<?=base_url()?>ajax/j_barang.php?func=add",
            data: "kode_barang_dtl="+kode_barang_dtl+"&satuan_dtl="+satuan_dtl+"&qty_dtl="+qty_dtl+"&ket_dtl="+ket_dtl+"&id_form="+id_form,
            cache:false,
            success: function(data) {
                var msg = data.split("||");
                    if(msg[0] == "33") {
                        notifError(msg[1]);
                    } else {
                         $('#detail_input_barang').html(data);
                        document.getElementById('show_input_barang').style.display = "none";
                    }
                    $(".animated").hide();
            }
          });
      return false;
    });   
</script>

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
    });
});
</script>

<script>
$(document).ready(function(){
	$('#kode_inventori').change(function(){
		$('#pesan').html('<img style="margin-left:1px; width:20px"  src="<?=base_url()?>images/loading.gif">');
		var kode_inventori = $(this).val();

		$.ajax({
			type	: 'POST',
			url 	: '<?=base_url()?>ajax/j_validasi.php?func=loadkode_inventori',
			data 	: 'kode_inventori='+kode_inventori,
			success	: function(data){
				$('#pesan').html(data);
			}
		})
	});
});
</script>