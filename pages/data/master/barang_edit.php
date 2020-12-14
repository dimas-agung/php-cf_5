<?php
include "pages/data/script/m_barang.php";
?>

<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-database"></i> Master</a></li>
        <li>
            <a href="#">Barang</a>
        </li>
    </ol>
</section>

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

                            <?php $id_form = buatkodeform("kode_form"); ?>

                            <form novalidate role="form" method="post" action="" id="saveFormEdit">
                                <?php
                                    $idtem = "INSERT INTO form_id SET kode_form ='".$id_form."' ";
                                    mysql_query($idtem);
                                ?>
                                    <input type="hidden" name="id_form" id="id_form" value="<?php echo $id_form; ?>"/>

                                <?php
                                    if(isset($_GET['action']) and $_GET['action'] == "edit") {
                                        $row = mysql_fetch_array($q_edit_inv);

                                        $satuan_beli1 = $row['satuan_beli'];
                                        $beli = explode(" : ",$satuan_beli1);
                                        $kode_satuan_beli = $beli[0];
                                        $satuan_beli = $beli[1];

                                        $satuan_jual1 = $row['satuan_jual'];
                                        $jual = explode(" : ",$satuan_jual1);
                                        $kode_satuan_jual = $jual[0];
                                        $satuan_jual = $jual[1];
                                    }
                                ?>

                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode</label>
                                    <div class="col-lg-4">
                                        <input type="text" required class="form-control" name="kode_inventori" id="kode_inventori" placeholder="Auto..." readonly <?=(isset($row['kode_inventori']) ? "readonly": "")?> value="<?=(isset($row['kode_inventori']) ? $row['kode_inventori'] : "")?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Nama</label>
                                    <div class="col-lg-4">
                                        <input type="text" required class="form-control" name="nama" id="nama" placeholder="Nama..." value="<?=(isset($row['kode_inventori']) ? $row['nama'] : "")?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kategori Barang</label>
                                    <div class="col-lg-4">
                                        <select id="kategori" name="kategori" class="select2" style="width: 100%;">
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
                                        <select id="satuan_beli" name="satuan_beli" class="select2" style="width: 100%;">
                                        <option value="0">-- Pilih Satuan Kecil --</option>
                                        <?php
                                            (isset($row['kode_inventori']) ? $satuan=$kode_satuan_beli : $satuan='');
                                            while($rowsat = mysql_fetch_array($q_ddl_satuan_beli)) { ;?>

                                            <option value="<?php echo $rowsat['kode_satuan'].' : '.$rowsat['nama'];?>"
                                                <?php if($rowsat['kode_satuan']==$satuan){echo 'selected';} ?>>
                                                <?php echo $rowsat['nama'] ;?>
                                            </option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Satuan Besar</label>
                                    <div class="col-lg-4">
                                        <select id="satuan_jual" name="satuan_jual" class="select2" style="width: 100%;">
                                        <option value="0" selected>-- Pilih Satuan Besar --</option>
                                        <?php
                                            (isset($row['kode_inventori']) ? $satuan1=$kode_satuan_jual : $satuan='');
                                            while($rowsat1 = mysql_fetch_array($q_ddl_satuan_jual)) { ;?>

                                            <option value="<?php echo $rowsat1['kode_satuan'].' : '.$rowsat1['nama'];?>"
                                                <?php if($rowsat1['kode_satuan']==$satuan1){echo 'selected';} ?>>
                                                <?php echo $rowsat1['nama'];?>
                                            </option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Jumlah Isi</label>
                                    <div class="col-lg-4">
                                        <input type="text" required class="form-control" name="jumlah_isi" id="jumlah_isi" placeholder="Jumlah Isi ..." value="<?=(isset($row['kode_inventori']) ? $row['isi'] : "")?>" autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Stok</label>
                                    <div class="col-lg-4">
                                        <div class="checkbox">
                                        <label>
                                        <?php $jenis_stok='baru'; ?>
                                            <input name="jenis_stok" type="checkbox" class="ace"
                                                <?php
                                                    if(isset($row['kode_inventori'])) {
                                                        if($row['jenis_stok']=='1') {
                                                            echo 'checked="checked"';
                                                        }else{
                                                            echo '';
                                                        }

                                                    }else{
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
                                        <input type="text" required class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan..." value="<?=(isset($row['kode_inventori']) ? $row['keterangan'] : "")?>">
                                    </div>
                                </div>

                                <input type="hidden" value="0"  id="b_grand_total" name="b_grand_total" class="form-control" >

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
                                                    <?php
                                                        $no=1;
                                                        while($row2 = mysql_fetch_array($q_inv_hrg_diskon)) { ;
                                                    ?>
                                                        <tr>
                                                            <td style="text-align: center"><?php echo $no++; ?></td>
                                                            <td><?php echo $row2['kode_kategori_pelanggan']; ?>
                                                                <input type="hidden" name="kode_kategori_pelanggan[]" id="kode_kategori_pelanggan[]" value="<?php echo $row2['kode_kategori_pelanggan']; ?>">
                                                            </td>
                                                            <td><?php echo $row2['pelanggan']; ?>
                                                                <input type="hidden" name="asli[]" id="asli[]" value="<?php echo $row2['asli']; ?>">
                                                            </td>
                                                            <td style="text-align: center">
                                                                <input type="text" class="form-control" style="text-align: right" name="harga[]" id="harga[]" value="<?=$row2['harga']?>">
                                                            </td>
                                                            <td style="text-align: center">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" name="diskon[]" id="diskon[]" value="<?=$row2['diskon']?>" aria-describedby="basic-addon2" style="font-size: 13px; text-align: right">
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

                                <div align="center" class="form-group">
                                    <a id="next-btn" class="btn btn-primary"><i class=" fa fa-mail-forward"></i> Next</a>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!-- BOM -->
        <div id="bom" <?=$class_pane_tab2?> >
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-horizontal">

                                <div class="row">
                                    <div class="col-md-12">
                                       <h2 style="font-weight:bold; text-align: center;"><?= $row['nama'];?></h2>
                                       <hr>
                                        <input type="hidden" id="kode_inventori_dtl" name="kode_inventori_dtl" value="<?= $row['kode_inventori'];?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Jumlah</label>
                                        <div class="col-lg-4">
                                            <input type="text"  class="form-control" name="qty_hdr" id="qty_hdr" placeholder="Jumlah ..." value="<?=(isset($row['kode_inventori']) ? $row['qty_bom'] : "")?>">
                                        </div>

                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Satuan</label>
                                        <div class="col-lg-4">
                                            <select id="satuan_hdr" name="satuan_hdr" class="select2" style="width: 100%;">
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
                                        <textarea  class="form-control" name="ket_hdr" id="ket_hdr" placeholder="Keterangan..." value=""><?=(isset($row['kode_inventori']) ? $row['keterangan_bom'] : "")?></textarea>
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

                                            <tr id="show_input_barang_edit" style="display:none">
                                                <td style="text-align: center"><h5><b>#</b></h5>
                                                    <input class="form-control" type="hidden" name="id_form_edit" id="id_form_edit" value=""/>
                                                </td>
                                                <td>
                                                    <select id="kode_barang_dtl" name="kode_barang_dtl" class="select2">
                                                        <option value="0">-- Pilih Barang --</option>
                                                        <?php
                                                            while($rowinv = mysql_fetch_array($q_barang_dtl)) { ;?>
                                                            <option value="<?php echo $rowinv['kode_inventori'].':'.$rowinv['nama'];?>" ><?php echo $rowinv['nama'];?> </option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <td>
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
                                                <td style="text-align: center">
                                                    <button id="ok_input" class="btn btn-sm btn-info ace-icon fa fa-check" title="ok"></button>
                                                    <a href="" id="batal_input" class="btn btn-sm btn-danger ace-icon fa fa-remove" title="batal" ></a>
                                                </td>
                                            </tr>
                                        </thead>

                                        <tbody id="detail_input_barang_edit">
                                            <?php
                                                $no=1;
                                                while($rowbom = mysql_fetch_array($q_bom_edit1)) {
                                                    $_SESSION['data_barang_edit'][$rowbom['kode_barang_dtl']] = $rowbom['kode_barang_dtl'];
                                            ?>
                                                <tr>
                                                    <td style="text-align:center;"><?= $no++ ?>
                                                        <input class="form-control" type="hidden" name="id_bom_dtl" id="id_bom_dtl" value="<?=$rowbom['id']?>"/>
                                                        <input class="form-control" type="hidden" name="id_form_edit1" id="id_form_edit1" value="<?=$rowbom['id_form']?>"/>
                                                        <input class="form-control" type="hidden" name="barang_atas[]" id="barang_atas[]" value="<?=$rowbom['kode_barang_dtl']?>"/>
                                                    </td>
                                                    <td><?=$rowbom['kode_barang_dtl']?></td>
                                                    <td><?=$rowbom['satuan_dtl']?></td>
                                                    <td style="text-align:right;"><?=number_format($rowbom['qty_satuan_dtl'])?></td>
                                                    <td><?=$rowbom['keterangan_dtl']?></td>
                                                    <td style="text-align:center">
                                                        <a href="javascript:;" class="label label-danger hapus-bom" title="hapus data" id="hapus_bom" data-kd-barang="<?=$rowbom['kode_barang_dtl']?>" data-id="<?=$key?>">
                                                            <i class="fa fa-times"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php
                                                                                                    }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                </div>
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
                                                        //CEK JIKA KODE coa_debet ADA MAKA SELECTED
                                                        (isset($row['kode_inventori']) ? $tb_debet=$row['tb_debet'] : $tb_debet='');
                                                        //UNTUK AMBIL coanya
                                                        while($rowtbdeb = mysql_fetch_array($q_ddl_coa)) { ;?>

                                                        <option value="<?php echo $rowtbdeb['kode_coa'];?>" <?php if($rowtbdeb['kode_coa']==$tb_debet){echo 'selected';} ?>><?php echo $rowtbdeb['kode_coa'].'&nbsp;&nbsp; || &nbsp;&nbsp;'.$rowtbdeb['nama'];?> </option>
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
                                                    //CEK JIKA KODE coa_kredit ADA MAKA SELECTED
                                                    (isset($row['kode_inventori']) ? $tb_kredit=$row['tb_kredit'] : $tb_kredit='');
                                                    //UNTUK AMBIL coanya
                                                    while($rowtbkred = mysql_fetch_array($q_ddl_coa2)) { ;?>

                                                    <option value="<?php echo $rowtbkred['kode_coa'];?>" <?php if($rowtbkred['kode_coa']==$tb_kredit){echo 'selected';} ?>><?php echo $rowtbkred['kode_coa'].'&nbsp;&nbsp; || &nbsp;&nbsp;'.$rowtbkred['nama'];?> </option>
                                                    <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-3 col-sm-2 control-label" style="text-align:left">Surat Jalan</label>
                                                <div class="col-lg-9">
                                                    <select id="sj_debet" name="sj_debet" class="select2" style="width: 100%;">
                                                    <option value="0">-- Pilih Coa Debet --</option>
                                                    <?php
                                                    //CEK JIKA KODE coa_debet ADA MAKA SELECTED
                                                    (isset($row['kode_inventori']) ? $sj_debet=$row['sj_debet'] : $sj_debet='');
                                                    //UNTUK AMBIL coanya
                                                    while($rowsjdeb = mysql_fetch_array($q_ddl_coa3)) { ;?>

                                                    <option value="<?php echo $rowsjdeb['kode_coa'];?>" <?php if($rowsjdeb['kode_coa']==$sj_debet){echo 'selected';} ?>><?php echo $rowsjdeb['kode_coa'].'&nbsp;&nbsp; || &nbsp;&nbsp;'.$rowsjdeb['nama'];?> </option>
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
                                                    //CEK JIKA KODE coa_kredit ADA MAKA SELECTED
                                                    (isset($row['kode_inventori']) ? $sj_kredit=$row['sj_kredit'] : $sj_kredit='');
                                                    //UNTUK AMBIL coanya
                                                    while($rowsjkred = mysql_fetch_array($q_ddl_coa4)) { ;?>

                                                    <option value="<?php echo $rowsjkred['kode_coa'];?>" <?php if($rowsjkred['kode_coa']==$sj_kredit){echo 'selected';} ?>><?php echo $rowsjkred['kode_coa'].'&nbsp;&nbsp; || &nbsp;&nbsp;'.$rowsjkred['nama'];?> </option>
                                                    <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-3 col-sm-2 control-label" style="text-align:left">Faktur Penjualan</label>
                                                <div class="col-lg-9">
                                                    <select id="fj_debet" name="fj_debet" class="select2" style="width: 100%;">
                                                    <option value="0">-- Pilih Coa Debet --</option>
                                                    <?php
                                                    //CEK JIKA KODE coa_debet ADA MAKA SELECTED
                                                    (isset($row['kode_inventori']) ? $fj_debet=$row['fj_debet'] : $fj_debet='');
                                                    //UNTUK AMBIL coanya
                                                    while($rowfjdeb = mysql_fetch_array($q_ddl_coa5)) { ;?>

                                                    <option value="<?php echo $rowfjdeb['kode_coa'];?>" <?php if($rowfjdeb['kode_coa']==$fj_debet){echo 'selected';} ?>><?php echo $rowfjdeb['kode_coa'].'&nbsp;&nbsp; || &nbsp;&nbsp;'.$rowfjdeb['nama'];?> </option>
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
                                                    //CEK JIKA KODE coa_kredit ADA MAKA SELECTED
                                                    (isset($row['kode_inventori']) ? $fj_kredit=$row['fj_kredit'] : $fj_kredit='');             //UNTUK AMBIL coanya
                                                    while($rowfjkred = mysql_fetch_array($q_ddl_coa6)) { ;?>

                                                    <option value="<?php echo $rowfjkred['kode_coa'];?>" <?php if($rowfjkred['kode_coa']==$fj_kredit){echo 'selected';} ?>><?php echo $rowfjkred['kode_coa'].'&nbsp;&nbsp; || &nbsp;&nbsp;'.$rowfjkred['nama'];?> </option>
                                                    <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-3 col-sm-2 control-label" style="text-align:left">Faktur Pembelian</label>
                                                <div class="col-lg-9">
                                                    <select id="fb_debet" name="fb_debet" class="select2" style="width: 100%;">
                                                    <option value="0">-- Pilih Coa Debet --</option>
                                                    <?php
                                                    //CEK JIKA KODE coa_debet ADA MAKA SELECTED
                                                    (isset($row['kode_inventori']) ? $fb_debet=$row['fb_debet'] : $fb_debet='');
                                                    //UNTUK AMBIL coanya
                                                    while($rowfbdeb = mysql_fetch_array($q_ddl_coa7)) { ;?>

                                                    <option value="<?php echo $rowfbdeb['kode_coa'];?>" <?php if($rowfbdeb['kode_coa']==$fb_debet){echo 'selected';} ?>><?php echo $rowfbdeb['kode_coa'].'&nbsp;&nbsp; || &nbsp;&nbsp;'.$rowfbdeb['nama'];?> </option>
                                                    <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-3 col-sm-2 control-label" style="text-align:left"></label>
                                                <div class="col-lg-9">
                                                    <select id="fb_kredit" name="fb_kredit" class="select2" style="width: 100%;">
                                                    <option value="0">-- Pilih Coa Kredit --</option>
                                                    <?php
                                                    //CEK JIKA KODE coa_kredit ADA MAKA SELECTED
                                                    (isset($row['kode_inventori']) ? $fb_kredit=$row['fb_kredit'] : $fb_kredit='');             //UNTUK AMBIL coanya
                                                    while($rowfbkred = mysql_fetch_array($q_ddl_coa8)) { ;?>

                                                    <option value="<?php echo $rowfbkred['kode_coa'];?>" <?php if($rowfbkred['kode_coa']==$fb_kredit){echo 'selected';} ?>><?php echo $rowfbkred['kode_coa'].'&nbsp;&nbsp; || &nbsp;&nbsp;'.$rowfbkred['nama'];?> </option>
                                                    <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-3 col-sm-2 control-label" style="text-align:left">Retur Beli</label>
                                                <div class="col-lg-9">
                                                    <select id="rb_debet" name="rb_debet" class="select2" style="width: 100%;">
                                                    <option value="0">-- Pilih Coa Debet --</option>
                                                    <?php
                                                    //CEK JIKA KODE coa_debet ADA MAKA SELECTED
                                                    (isset($row['kode_inventori']) ? $rb_debet=$row['rb_debet'] : $rb_debet='');
                                                    //UNTUK AMBIL coanya
                                                    while($rowrbdeb = mysql_fetch_array($q_ddl_coa9)) { ;?>

                                                    <option value="<?php echo $rowrbdeb['kode_coa'];?>" <?php if($rowrbdeb['kode_coa']==$rb_debet){echo 'selected';} ?>><?php echo $rowrbdeb['kode_coa'].'&nbsp;&nbsp; || &nbsp;&nbsp;'.$rowrbdeb['nama'];?> </option>
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
                                                    //CEK JIKA KODE coa_kredit ADA MAKA SELECTED
                                                    (isset($row['kode_inventori']) ? $rb_kredit=$row['rb_kredit'] : $rb_kredit='');                //UNTUK AMBIL coanya
                                                    while($rowrbkred = mysql_fetch_array($q_ddl_coa10)) { ;?>

                                                    <option value="<?php echo $rowrbkred['kode_coa'];?>" <?php if($rowrbkred['kode_coa']==$rb_kredit){echo 'selected';} ?>><?php echo $rowrbkred['kode_coa'].'&nbsp;&nbsp; || &nbsp;&nbsp;'.$rowrbkred['nama'];?> </option>
                                                    <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-3 col-sm-2 control-label" style="text-align:left">Retur Jual</label>
                                                <div class="col-lg-9">
                                                    <select id="rj_debet" name="rj_debet" class="select2" style="width: 100%;">
                                                    <option value="0">-- Pilih Coa Debet --</option>
                                                    <?php
                                                    //CEK JIKA KODE coa_debet ADA MAKA SELECTED
                                                    (isset($row['kode_inventori']) ? $rj_debet=$row['rj_debet'] : $rj_debet='');
                                                    //UNTUK AMBIL coanya
                                                    while($rowrjdeb = mysql_fetch_array($q_ddl_coa11)) { ;?>

                                                    <option value="<?php echo $rowrjdeb['kode_coa'];?>" <?php if($rowrjdeb['kode_coa']==$rj_debet){echo 'selected';} ?>><?php echo $rowrjdeb['kode_coa'].'&nbsp;&nbsp; || &nbsp;&nbsp;'.$rowrjdeb['nama'];?> </option>
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
                                                    //CEK JIKA KODE coa_kredit ADA MAKA SELECTED
                                                    (isset($row['kode_inventori']) ? $rj_kredit=$row['rj_kredit'] : $rj_kredit='');
                                                    //UNTUK AMBIL coanya
                                                    while($rowrjkred = mysql_fetch_array($q_ddl_coa12)) { ;?>

                                                    <option value="<?php echo $rowrjkred['kode_coa'];?>" <?php if($rowrjkred['kode_coa']==$rj_kredit){echo 'selected';} ?>><?php echo $rowrjkred['kode_coa'].'&nbsp;&nbsp; || &nbsp;&nbsp;'.$rowrjkred['nama'];?> </option>
                                                    <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div align="center" class="form-group">
                                                <button class="btn btn-success" type="submit" name="update"><i class="fa fa-pencil"></i> Update&nbsp;</button>
                                                <a href="?page=master/barang&halaman= BARANG" class="btn btn-danger" id="batal_update"><i class=" fa fa-reply"></i> Batal</a>
                                            </div>
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
<?php unset($_SESSION['data_barang_edit']); ?>

<script>
    $(document).ready(function () {
          $("[name='jumlah_isi']").number( true, 2 );
          $("[name='harga[]']").number( true, 0 );
          $("[name='diskon[]']").number( true, 0 );
    });
</script>  

<script>
    $(document).ready(function (e) {
        $("#saveFormEdit").on('submit',(function(e) {
            // alert('update');
            var grand_total = $("#id_form").val();
            if(grand_total == "" || isNaN(grand_total)) {grand_total = 0;}
            e.preventDefault();
            if(grand_total != 0) {
                $(".animated").show();
                $.ajax({
                    url: "<?=base_url()?>ajax/j_barang.php?func=update",
                    type: "POST",
                    data:  new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(html)
                    {
                        var msg = html.split("||");
                        if(msg[0] == "00") {
                            window.location = '<?=base_url()?>?page=master/barang&halaman= BARANG&pesan1='+msg[1];
                        } else {
                            notifError(msg[1]);
                        }
                        $(".animated").hide();
                    }
               });
            } else {notifError("<p>Item masih kosong.</p>");}
         }));
      });

    $("#tambah_barang").click(function(event) {
        event.preventDefault();
        document.getElementById('show_input_barang_edit').style.display = "table-row";

        $('#kode_barang_dtl').val('0').trigger('change');
        $('#satuan_dtl').val('0').trigger('change');
        $('#qty_dtl').val('0');
        $('#ket_dtl').val('');

    });

    $("#batal_input").click(function(event) {
        event.preventDefault();
        document.getElementById('show_input_barang_edit').style.display = "none";
    });

    $("#ok_input").click(function(event) {
        event.preventDefault();
        var id_form            = $("#id_form_edit").val();
        var kode_inventori_dtl = $("#kode_inventori_dtl").val();
        var kode_barang_dtl    = $("#kode_barang_dtl").val();
        var satuan_dtl         = $("#satuan_dtl").val();
        var qty_dtl            = $("#qty_dtl").val();
        var ket_dtl            = $("#ket_dtl").val();

        $.ajax({
            type: "POST",
            url: "<?=base_url()?>ajax/j_barang.php?func=add-edit",
            data: "kode_inventori_dtl="+kode_inventori_dtl+"&kode_barang_dtl="+kode_barang_dtl+"&satuan_dtl="+satuan_dtl+"&qty_dtl="+qty_dtl+"&ket_dtl="+ket_dtl+"&id_form="+id_form,
            cache:false,
            success: function(data) {
                $('#detail_input_barang_edit').html(data);
                document.getElementById('show_input_barang_edit').style.display = "none";
            }
          });
      return false;
    });

    $("#tambah_barang").click(function(event) {
        event.preventDefault();
        var id_form = $("#id_form_edit1").val();
        $('[name="id_form_edit"]').val(id_form);
        // console.log(id_form);
    });

    $('.hapus-bom').click(function(){
        var id       = $(this).attr('data-kd-barang');
        var id_form         = $('#id_form_edit1').val();

        // console.log(kd_barang);
        $.ajax({
            type: 'POST',
            url : '<?=base_url()?>ajax/j_barang.php?func=hapus-bom-edit-link',
            data: 'id_form='+ id_form+'&idhapus='+id,
            cache: false,
            success:function(data){
                $('#detail_input_barang_edit').html(data).show();
            }
        });
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

<script src="<?=base_url()?>assets/select2/select2.js"></script>

<script>
  $(".select2").select2({
          width: '100%'
         });
</script>
