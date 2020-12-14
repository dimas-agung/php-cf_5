<?php
   include "pages/data/script/so.php";
   include "library/form_akses.php";
?>

<style>
  .pm-min, .pm-min-s{padding:3px 1px; }
  .animated{display:none;}

  table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    border: 1px solid #3c4f5f;
  }

  th {
      background: #87CEFA;
      text-align: center;
      color: #000000;
      padding: 8px;
      font-size: 13px;
  }

  td {
      text-align: left;
      padding: 8px;
      font-size: 13px;
  }

  tr:nth-child(even){background-color: #f2f2f2}

  p {
    font-size: 8px;
  }
</style>

<section class="content-header">
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-money"></i>Penjualan</a></li>
          <li>
            <a href="#">Sales Order</a>
          </li>
        </ol>
</section>


<div class="box box-info">
    <div class="box-body">

         <?php if (isset($_GET['pesan'])){ ?>
            <div class="form-group" id="form_report">
              <div class="alert alert-success alert-dismissable">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 Kode SO :  <a href="<?=base_url()?>?page=penjualan/so_track&halaman= TRACK SALES ORDER&action=track&kode_so=<?=$_GET['pesan']?>" target="_blank"><?=$_GET['pesan'] ?></a>  Berhasil Di posting
              </div>
            </div>
        <?php  }  else if (isset($_GET['clsman'])){ ?>
                <div class="form-group" id="form_report">
                  <div class="alert alert-dismissable" style="background-color: #9c0303cc; color: #f9e6c3">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color: #f9e6c3">&times;</button>
                      Tutup Manual Kode SO :  <a style="color: white" href="<?=base_url()?>?page=penjualan/so_track&halaman= TRACK SALES ORDER&action=track&kode_so=<?=$_GET['clsman']?>" target="_blank"><?=$_GET['clsman'] ?></a>  Berhasil Di tutup
                  </div>
                </div>
         <?php  }  else if (isset($_GET['pembatalan'])){ ?>
                <div class="form-group" id="form_report">
                  <div class="alert alert-dismissable" style="background-color: #9c0303cc; color: #f9e6c3">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color: #f9e6c3">&times;</button>
                      Pembatalan Kode SO :  <a style="color: white" href="<?=base_url()?>?page=penjualan/so_track&halaman= TRACK SALES ORDER&action=track&kode_so=<?=$_GET['pembatalan']?>" target="_blank"><?=$_GET['pembatalan'] ?></a>  Berhasil Di batalkan
                  </div>
                </div>
            <?php } ?>

      <div class="tabbable">
         <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
            <li <?=$class_form?>>
               <a data-toggle="tab" href="#menuFormSo">Form Sales Order</a>
            </li>
                <li <?=$class_tab?>>
               <a data-toggle="tab" href="#menuListSo">List Sales Order</a>
            </li>
            </ul>

      <div class="row">
         <div class="tab-content">
            <div id="menuFormSo"
               <?=$class_pane_form?> >
                  <div class="col-lg-12">
                     <div class="panel panel-default">
                        <div class="panel-body">
                                 <div class="form-horizontal">

                                    <?php $id_form = buatkodeform("kode_form"); ?>

                                       <form action="" method="post" enctype="multipart/form-data" id="saveForm">

                                       <?php   $idtem = "INSERT INTO form_id SET kode_form ='".$id_form."' ";
                              mysql_query($idtem); ?>
                              <input type="hidden" name="id_form" id="id_form" value="<?php echo $id_form; ?>"/>

                              <?php
                                 if(isset($_GET['action']) and $_GET['action'] == "edit") {
                                    $row = mysql_fetch_array($q_edit_inv);
                                 }
                              ?>

                                  <div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode SO</label>
                                    <div class="col-lg-4">
                                       <input type="text" class="form-control" name="kode_so" id="kode_so" placeholder="Auto..." readonly value="">
                                    </div>

                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Pelanggan</label>
                                    <div class="col-lg-4">
                                       <select id="kode_pelanggan" name="kode_pelanggan" class="select2" style="width: 100%;">
                                          <option data-alamat="" data-salesman="" data-nama-kategori="" data-top="0" value="0">-- Pilih Pelanggan --</option>
                                          <?php
                                            (isset($rowpel['id_so']) ? $kode_pelanggan=$rowpel['kode_pelanggan'] : $kode_pelanggan='');
                                            while($rowpel = mysql_fetch_array($q_pel)) { ;?>
                                            <option data-alamat="<?php echo $rowpel['alamat'];?>" data-salesman="<?php echo $rowpel['salesman'];?>" data-top="<?php echo $rowpel['top'];?>" data-nama-kategori="<?php echo $rowpel['nama_kategori'];?>" value="<?php echo $rowpel['kode_pelanggan'].' : '.$rowpel['nama_pelanggan'];?>"
                                                <?php if($rowpel['kode_pelanggan']==$kode_pelanggan){echo 'selected';} ?> >
                                                <?php echo $rowpel['kode_pelanggan'] . ' - ' . $rowpel['nama_pelanggan'];?>
                                            </option>
                                          <?php } ?>
                                        </select>
                                    </div>
                                  </div>

                                 <div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal SO</label>
                                      <div class="col-lg-4">
                                        <div class="input-group">
                                               <input type="text" name="tgl_so" id="tgl_so" class="form-control date-picker-close" autocomplete="off" value="<?=date("m/d/Y")?>" readonly>
                                               <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                          </div>
                                      </div>

                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Alamat</label>
                                      <div class="col-lg-4">
                                         <input type="text" autocomplete="off" class="form-control" name="alamat" id="alamat" placeholder="Alamat..." value="" readonly>
                                      </div>
                                 </div>

                                 <div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
                                      <div class="col-lg-4">
                                         <input type="text" autocomplete="off" class="form-control" name="ref" id="ref" placeholder="Ref..." value="">
                                      </div>

                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Alamat Kirim</label>
                                      <div class="col-lg-4">
                                         <input type="text" autocomplete="off" class="form-control" name="alamat_kirim" id="alamat_kirim" placeholder="Alamat Kirim..." value="">
                                      </div>
                                 </div>

                                 <div class="form-group">
                                     <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
                                     <div class="col-lg-4">
                                        <select id="kode_cabang" name="kode_cabang" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Cabang --</option>
                                                <?php
                                                //CEK JIKA cabang ADA MAKA SELECTED
                                                (isset($row['id_so']) ? $cabang=$row['kode_cabang'] : $cabang='');
                                                //UNTUK AMBIL coanya
                                                while($row_cabang = mysql_fetch_array($q_cabang)) { ;?>

                                                <option value="<?php echo $row_cabang['kode_cabang'];?>" <?php if($row_cabang['kode_cabang']==$cabang){echo 'selected';} ?>><?php echo $row_cabang['nama_cabang'];?> </option>
                                                <?php } ?>
                                                <input type="hidden" name="kode_cabang1" id="kode_cabang1" class="form-control" value="<?php echo $row_cabang['kode_cabang'];?>"/>
                                        </select>
                                     </div>

                                     <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal Kirim</label>
                                       <div class="col-lg-4">
                                         <div class="input-group">
                                           <input type="text" name="tgl_kirim" id="tgl_kirim" class="form-control date-picker-close" placeholder="Tanggal Kirim ..." value="<?=date("m/d/Y")?>" autocomplete="off" readonly/>
                                           <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                          </div>
                                       </div>
                                 </div>

                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Gudang</label>
                                    <div class="col-lg-4">
                                        <select id="kode_gudang" name="kode_gudang" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Gudang --</option>
                                                <?php
                                                //CEK JIKA gudang ADA MAKA SELECTED
                                                (isset($row['id_so']) ? $gudang=$row['kode_gudang'] : $gudang='');
                                                //UNTUK AMBIL coanya
                                                while($row_gudang = mysql_fetch_array($q_gudang)) { ;?>

                                                <option value="<?php echo $row_gudang['kode_gudang'];?>" <?php if($row_gudang['kode_gudang']==$gudang){echo 'selected';} ?>><?php echo $row_gudang['nama_gudang'];?> </option>
                                                <?php } ?>
                                                <input type="hidden" name="kode_gudang1" id="kode_gudang1" class="form-control" value="<?php echo $row_gudang['kode_gudang'];?>"/>
                                        </select>
                                    </div>

                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">TOP</label>
                                      <div class="col-lg-4">
                                        <div class="input-group">
                                          <input type="text" autocomplete="off" class="form-control" name="top" id="top" placeholder="TOP..." value="" readonly />
                                          <span class="input-group-addon"><b>Hari</b></span>
                                        </div>
                                      </div>
                                </div>

                                <div class="form-group">
                                     <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Salesman</label>
                                     <div class="col-lg-4">
                                         <input type="text" class="form-control" name="salesmanx" id="salesman" placeholder="Salesman..." value="" readonly />
                                         <input type="hidden" name="salesman" value="" />
                                     </div>
									 
									 <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kategori</label>
                                     <div class="col-lg-4">
                                         <input type="text" class="form-control" name="kategorix" id="kategori" placeholder="Kategori Pelanggan..." value="" readonly />
                                         <input type="hidden" name="kategori" value="" />
                                     </div>
                                </div>

                                <div class="form-group">
                                     <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                                     <div class="col-lg-10">
                                         <textarea type="text" class="form-control" name="keterangan_hdr" id="keterangan_hdr" placeholder="Keterangan..." value=""></textarea>
                                         <input type="hidden" name="id_um" id="id_um" value="1"/>
                                     </div>
                                </div>

                                <!-- <div class="form-group">
                                        <label class="col-lg-2 control-label" style="text-align:left">Uang Muka (%)</label>

										<div class="row after-add-more">
											<div class="container">
												<div class="col-lg-3 col-md-3 col-xs-4">
													<input type="text" name="um" id="um" class="form-control" placeholder="Uang Muka %">
												</div>

												<div class="col-lg-3 col-md-3 col-xs-4">
													<input type="text" value="0" readonly name="nominal" id="nominal" class="form-control" placeholder="0">
												</div>

												<button class="btn btn-success add-more col-lg-2 col-md-2 col-xs-3" type="button"><i class="glyphicon glyphicon-plus"></i> Tambah</button>
											</div>
										</div>

                                    </div> -->

                                <div class="form-group">
                                  <div class="col-lg-12">
                                      <div class="pull-left">
                                        <a class="btn btn-success" id="tambah_so"><i class="fa fa-plus"></i> Add</a>
                                      </div>
                                   </div>
                                </div>

                                 <div class="form-group">
                                        <div style="overflow-x:auto;">
                                            <table id="" class="" rules="all">
                                                <thead>
                                                    <?php
                                                        $n=1;
                                                    ?>
                                                    <tr>
                                                        <th style="width:10px">No</th>
                                                        <th style="width:300px" colspan="2">Barang</th>
                                                        <th style="width:20px">FOC</th>
                                                        <th style="width:100px">Satuan Ikat</th>
                                                        <th style="width:100px">QTY</th>
                                                        <th style="width:100px">Konversi</th>
                                                        <th style="width:100px">Harga Jual</th>
                                                        <th style="width:100px">Disc 1(%)</th>
                                                        <th style="width:100px">Disc 2(%)</th>
                                                        <th style="width:100px">Disc 3(%)</th>
                                                        <th style="width:20px">PPn</th>
                                                        <th style="width:100px">Subtotal</th>
                                                        <th style="width:150px">Ket</th>
														<th></th>
                                                    </tr>

                                                    <tr id="show_input_so" style="display:none">
                                                            <td style="text-align: center ; width: 10px"><h5><b>#</b></h5></td>
                                                            <td style="width: 200px">
                                                                <select id="kode_barang" name="kode_barang" class="select2" style="width: 200px">
                                                                      <option value="0">-- Pilih Kode --</option>
                                                                      <?php
                                                                        while($rowpel = mysql_fetch_array($q_barang)) {

                                                                        $satuan_jual = $rowpel['satuan_jual'];
                                                                        $jual = explode(" : ",$satuan_jual);
                                                                        $satuan_jual = $jual[1];

                                                                        $satuan_simpan = $rowpel['satuan_beli'];
                                                                        $simpan = explode(" : ",$satuan_simpan);
                                                                        $satuan_simpan = $simpan[1];
                                                                      ?>
                                                                        <option data-konversi="<?php echo $rowpel['isi'];?>" data-satuan-besar="<?php echo $satuan_jual;?>" data-satuan-kecil="<?php echo $satuan_simpan;?>" value="<?php echo $rowpel['kode_barang'].':'. $rowpel['nama_barang'];?>">
                                                                            <?php echo $rowpel['kode_barang'].' - '.$rowpel['nama_barang'];?>
                                                                        </option>
                                                                      <?php } ?>
                                                                </select>
                                                            </td>
                                                            <td style="width: 20px">
                                                                <a id="btn_his" class="btn btn-xs btn-warning" onclick="openNav()"><i class="fa fa-cubes" title="history"></i></a>
                                                            </td>
                                                            <td style="width: 20px">
                                                                <input class="form-control" type="checkbox" name="foc" id="foc">
                                                                <input class="form-control" type="hidden" name="stat_foc" id="stat_foc" value="0">
                                                            </td>
                                                            <td style="width: 80px">
																<select id="konversi1" name="konversi1" class="select2" style="width: 80px">
																	<option value="0" selected>-- Pilih Satuan Ikat --</option>
																	<option value="2">BALL</option>
																</select>
																<input type="hidden" id="satuan" name="satuan" value="BALL" />
                                                            </td>
															<td style="width: 80px">
																<div class="input-group">
																	<input class="form-control" type="text" name="qty" id="qty"  autocomplete="off" value="0" style="width:80px;text-align:right" />
																	<span class="input-group-addon" id="text-satuan_jual">-</span>
																	<input type="hidden" name="satuan_jual" id="satuan_jual" />
																</div>
                                                            </td>
                                                            <td style="width: 80px">
																<div class="input-group">
																	<input class="form-control" type="text" name="konversi2" id="konversi2"  autocomplete="off" value="0" style="width:80px;text-align:right" readonly />
																	<span class="input-group-addon" id="text-satuan_simpan">-</span>
																	<input type="hidden" name="konversi" id="konversi" />
																	<input type="hidden" name="satuan_simpan" id="satuan_simpan" />
																</div>
                                                            </td>
                                                            <td style="width: 80px">
                                                                <input class="form-control" type="text" name="harga" id="harga"  autocomplete="off" style="text-align:right; width:80px" value="0" />
                                                            </td>
															<td style="width: 80px">
																<div class="input-group">
																	<input class="form-control" type="text" name="diskon1" id="diskon1"  autocomplete="off" style="text-align:right; width:80px" value="0" />
																	<span class="input-group-addon">%</span>
																</div>
                                                            </td>
															<td style="width: 80px">
																<div class="input-group">
																	<input class="form-control" type="text" name="diskon2" id="diskon2"  autocomplete="off" style="text-align:right; width:80px" value="0" />
																	<span class="input-group-addon">%</span>
																</div>
                                                            </td>
															<td style="width: 80px">
																<div class="input-group">
																	<input class="form-control" type="text" name="diskon3" id="diskon3"  autocomplete="off" style="text-align:right; width:80px" value="0" />
																	<span class="input-group-addon">%</span>
																</div>
                                                            </td>															
                                                            <td id="load_ppn">
                                                                <input class="form-control" type="checkbox" name="ppn" id="ppn" />
                                                                <input class="form-control" type="hidden" name="stat_ppn" id="stat_ppn" value="0">
                                                            </td>
                                                            <td style="width: 80px">
                                                                <input class="form-control" type="text" name="subtot" id="subtot"  autocomplete="off" style="text-align:right; width: 80px" value="0" readonly />
                                                                <input type="hidden" name="ppn_n" id="ppn_n"  value="0" />
                                                            </td>
                                                            <td style="width: 150px">
                                                                <input class="form-control" type="text" name="keterangan" id="keterangan" style="width: 150px" autocomplete="off" />
                                                            </td>
                                                            <td style="text-align: center">
																<button id="ok_input" class="btn btn-xs btn-info ace-icon fa fa-check" title="ok"></button>
                                                                <a href="" id="batal_input" class="btn btn-xs btn-danger ace-icon fa fa-remove" title="batal" ></a>
                                                            </td>
                                                        </tr>
                                                </thead>
                                                <tbody id="detail_input_so">
                                                   <tr>
                                                         <td colspan="15" class="text-center"> Tidak ada item barang. </td>
                                                    </tr>
													<tr>
														<td style="text-align:right" colspan="12"><b>DPP :</b></td>
														<td style="text-align:right"><b>0</b> <input type="hidden" name="total_harga" id="total_harga" value="0" /></td>
														<td style="text-align:right" colspan="2"></td>
													</tr>
													<tr>
														<td style="text-align:right" colspan="12"><b>PPn :</b></td>
														<td style="text-align:right"><b>0</b> <input type="hidden" name="total_ppn" id="total_ppn" value="0" /></td>
														<td style="text-align:right" colspan="2"></td>
													</tr>
													<tr>
														<td style="text-align:right"" colspan="12"><b>Total :</b></td>
														<td style="text-align:right"><b>0</b><input type="hidden" name="grand_total" id="grand_total" value="0" /></td>
														<td style="text-align:right" colspan="2"></td>
													</tr>
                                                </tbody>
                                            </table>
                                      </div>
                                    </div>

                            <div class="form-group col-md-6">

                                    <?php
                                    $list_survey_write = 'n';
                                    while($res = mysql_fetch_array($q_akses)) {; ?>
                                      <?php
                                      //FORM SURVEY
                                      if($res['form']=='survey'){
                                        if($res['w']=='1'){
                                             $list_survey_write = 'y';
                                      ?>

                                          <!-- <button type="submit" name="simpan" id="simpan" class="btn btn-primary" tabindex="10"><i class="fa fa-check-square-o"></i> Simpan</button> -->
                                      <?php } } } ?>
                                          <button type="submit" name="simpan" id="simpan" class="btn btn-primary" tabindex="10"><i class="fa fa-check-square-o"></i> Simpan</button>

                                          <a href="<?=base_url()?>?page=penjualan/so&halaman= SALES ORDER" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>
                            </div>

                              </form>

                                <div class="copy">

                                </div>

                           </div>
                        </div>
                     </div>
                  </div>
            </div>

            <div id="menuListSo" <?=$class_pane_tab?>>
                  <div class="col-lg-12">
                     <div class="panel panel-default">
                        <div class="panel-body">

                           <form action="" method="post" >

                                    <div class="col-xs-12 col-md-4" style="margin-bottom:3mm">
                                          <div class="input-group">
                                             <span class="input-group-addon point">Kode</span>
                                          <input type="text" autocomplete="off" class="form-control" name="kode_so" id="kode_so" placeholder="Kode ..." value="<?php

                                       if(empty($_POST['kode_so'])){
                                          echo "";

                                       }else{
                                          echo $_POST['kode_so'];
                                       }

                                       ?>">
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-md-4" style="margin-bottom:3mm">
                                          <div class="input-group">
                                             <span class="input-group-addon point">Ref</span>
                                          <input type="text" autocomplete="off" class="form-control" name="ref" id="ref" placeholder="Ref ..." value="<?php

                                               if(empty($_POST['ref'])){
                                                  echo "";

                                               }else{
                                                  echo $_POST['ref'];
                                               }

                                               ?>">
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-md-4" style="margin-bottom:3mm">
                                          <div class="input-group">
                                            <span class="input-group-addon point">Status</span>
                                              <select id="status" name="status" class="select2" style="width: 100%;">
                                                <option value="" selected>-- Pilih Status --</option>
                                                <option value="1">READY</option>
                                                <option value="0">BATAL</option>
                                              </select>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-md-6" style="margin-bottom:3mm">
                                           <div class="input-group">
                                               <span class="input-group-addon">Tanggal Awal</i></span>
                                               <input type="text" name="tanggal_awal" id="tanggal_awal" class="form-control date-picker" autocomplete="off" value="<?=date("m/d/Y", strtotime('-1 month'))?>">
                                               <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                           </div>
                                       </div>

                                    <div class="col-xs-12 col-md-6" style="margin-bottom:3mm">
                                          <div class="input-group">
                                             <span class="input-group-addon">Tanggal Akhir</span>
                                             <input type="text" name="tanggal_akhir" id="tanggal_akhir" class="form-control date-picker" autocomplete="off"value="<?=date("m/d/Y")?>">
                                             <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                          </div>
                                    </div>

                                    <div class="col-xs-12 col-md-6" style="margin-bottom:3mm">
                                          <div class="input-group">
                                             <span class="input-group-addon point">Cabang</span>
                                          <select id="cabang" name="cabang" class="select2" style="width: 100%;">
                                                <option value="" selected>-- Pilih Cabang --</option>
                                                <?php
                                                //CEK JIKA cabang ADA MAKA SELECTED
                                                (isset($_POST['cabang']) ? $cabang=$_POST['cabang'] : $cabang='');
                                                //UNTUK AMBIL coanya
                                                while($row_cabang = mysql_fetch_array($q_cabang_list)) { ;?>

                                                <option value="<?php echo $row_cabang['kode_cabang'];?>" <?php if($row_cabang['kode_cabang']==$cabang){echo 'selected';} ?>><?php echo $row_cabang['kode_cabang'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$row_cabang['nama_cabang'];?> </option>
                                                <?php } ?>
                                                </select>
                                       </div>
                                    </div>

                                    <div class="col-xs-12 col-md-6" style="margin-bottom:3mm">
                                          <div class="input-group">
                                             <span class="input-group-addon point">Pelanggan</span>
                                          <select id="pelanggan" name="pelanggan" class="select2" style="width: 100%;">
                                                <option value="" selected>-- Pilih Pelanggan --</option>
                                                <?php
                                                //CEK JIKA pelanggan ADA MAKA SELECTED
                                                (isset($_POST['pelanggan']) ? $pelanggan=$_POST['pelanggan'] : $pelanggan='');
                                                //UNTUK AMBIL coanya
                                                while($row_pelanggan = mysql_fetch_array($q_pelanggan_list)) { ;?>

                                                <option value="<?php echo $row_pelanggan['kode_pelanggan'];?>" <?php if($row_pelanggan['kode_pelanggan']==$pelanggan){echo 'selected';} ?>><?php echo $row_pelanggan['kode_pelanggan'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$row_pelanggan['nama_pelanggan'];?> </option>
                                                <?php } ?>
                                                </select>
                                          </div>
                                    </div>



                                      <div class="pull-right" style="margin-bottom:3mm">
                                             <button type="submit" name="refresh" id="refresh" class="btn btn-info btn-sm" value="refresh"><i class="fa fa-refresh"></i>Refresh</button>
                                    </div>

                                  <div class="col-md-1 pull-right" style="margin-bottom:3mm">
                                    <button type="submit" name="cari" id="cari" class="btn btn-primary btn-sm" value="cari"><i class="fa fa-search"></i>cari</button>
                                    </div>
                                 </form>

                           <div class="form-group">
                           <table id="example1" class="table table-striped table-bordered" width="100%" >
                              <thead>
                                 <tr>
                                                <th>No</th>
                                                <th>Kode</th>
                                                <th>Tanggal</th>
                                                <th>Ref</th>
                                                <th>Cabang</th>
                                                <th>Gudang</th>
                                                <th>Pelanggan</th>
                                                <th>Nominal</th>
                                                <th>Keterangan</th>
                                                <th>Status</th>
                                                <th></th>
                                 </tr>
                              </thead>
                              <tbody>

                                 <?php
                                    $n=1; if(mysql_num_rows($q_so) > 0) {
                                    while($data = mysql_fetch_array($q_so)) {

                                        if ($data['status']=='0'){
                                            $status =  'Menunggu Approval';
                                            $warna = 'style="background-color: #7eb2ccba"';
                                            $print = 'hidden';
                                        }elseif ($data['status']=='1'){
                                            $status =  'Open';
                                            $warna = 'style="background-color: #39b13940"';
                                            $print = '';
                                        }elseif ($data['status']=='2'){
                                            $status =  'Batal';
                                            $warna = 'style="background-color: #de4b4b63;"';
                                            $print = 'hidden';
                                        }else{
                                            $status =  'Close';
                                            $warna = 'style="background-color: #ffd10045;"';
                                            $print = 'hidden';
                                        }
                                 ?>

                                 <tr <?= $warna?>>
                                    <td style="text-align: center"> <?php echo $n++ ;?></td>
                                    <td><a href="<?=base_url()?>?page=penjualan/so_track&action=track&halaman= TRACK SALES ORDER&kode_so=<?=$data['kode_so']?>" target="_blank"><?php echo $data['kode_so'];?></a></td>
                                    <td> <?php echo strftime("%A, %d %B %Y", strtotime($data['tgl_buat']));?></td>
                                    <td> <?php echo $data['ref'];?></td>
                                    <td> <?php echo $data['nama_cabang'];?></td>
                                    <td> <?php echo $data['nama_gudang'];?></td>
                                    <td> <?php echo $data['nama_pelanggan'];?></td>
                                    <td style="text-align:right"> <?php echo number_format($data['subtotal'], 2);?></td>
                                    <td> <?php echo $data['keterangan_hdr'];?></td>
                                    <td style="text-align:center"> <?php echo $status; ?></td>
                                    <td style="font-size: 12px; text-align: center">
                                        <a href="<?=base_url()?>r_cetak_so.php?kode_so=<?=$data['kode_so']?>" title="cetak" target="_blank">
                                          <button type="button" class="btn btn-warning btn-sm <?= $print?>">
                                            <span class="glyphicon glyphicon-print"></span>
                                          </button>
                                        </a>
                                    </td>

                                 </tr>
                                 <?php
                                    }
                                 }else{
                                    echo "";
                                 }
                                 ?>
                              </tbody>
                           </table>
                           </div>
                        </div>
                     </div>
                  </div>
            </div>

            </div>
         </div>

 <!-- DAFTAR BARANG --->
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a><center><b>DAFTAR SO BERDASARKAN KODE BARANG</b></center></a>
        <a id="list_his_harga"></a>

    </div>
    <!-- /.DAFTAR BARANG --->

<div class="modal fade" id="edit_so" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Update Sales Order</h4>
            </div>
            <div class="modal-body" id="show-item-edit">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<?php unset($_SESSION['data_so']); ?>

<script type="text/javascript">
	$(document).ready(function () {
		$("[name='um']").number( true, 2 );
		$("[name='um1']").number( true, 2 );
		$("[name='nominal']").number( true, 2 );
		$("[name='nominal[]']").number( true, 2 );
		$("[name='konversi2']").number( true, 2 );
		$("[name='qty']").number( true, 2 );
		$("[name='harga']").number( true, 2 );
		$("[name='diskon1']").number( true, 2 );
		$("[name='diskon2']").number( true, 2 );
		$("[name='diskon3']").number( true, 2 );
		$("[name='subtot']").number( true, 2 );
	});
</script>

<script>
    function openNav() {
      document.getElementById("mySidenav").style.width = "350px";
      document.getElementById("main").style.width = "1400px";
      document.getElementById("main").style.marginLeft = "350px";
      document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
    }

    function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
      document.getElementById("main").style.marginLeft= "0";
      document.body.style.backgroundColor = "white";
    }
</script>

<script>
   $("#btn_his").click(function(event) {
        var kode_inventori = $("#kode_barang").val();
        $.ajax({
            type: "POST",
            url: "<?=base_url()?>ajax/j_so.php?func=loadhistory",
            data: "kode_inventori="+kode_inventori,
            cache:false,
            success: function(data) {
                $('#list_his_harga').html(data);
            }
        });
    });
</script>

<script>
   harga = 0;
   subtotal = 0;
   ppn = 0;

  $(document).ready(function (e) {
    $("#saveForm").on('submit',(function(e) {
      var grand_total = parseFloat($("#grand_total").val());
      if(grand_total == "" || isNaN(grand_total)) {grand_total = 0;}

      var kode_cabang = $("#kode_cabang").val();
        if(kode_cabang == 0 ) {
            $("#kode_cabang").focus();
            notifError("<p>Cabang tidak boleh kosong!!!</p>");
            return false;
        }

      var kode_gudang = $("#kode_gudang").val();
        if(kode_gudang == 0 ) {
            $("#kode_gudang").focus();
            notifError("<p>Gudang tidak boleh kosong!!!</p>");
            return false;
        }

      e.preventDefault();
      if(grand_total != 0 && grand_total > 0) {
         $(".animated").show();
         $.ajax({
            url: "<?=base_url()?>ajax/j_so.php?func=save",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(html)
            {
               var msg = html.split("||");
               if(msg[0] == "00") {
                  window.location = '<?=base_url()?>?page=penjualan/so&halaman= SALES ORDER&pesan='+msg[1];
               } else {
                  notifError(msg[1]);
               }
               $(".animated").hide();
            }

         });
      } else {notifError("<p>Item  masih kosong.</p>");}
    }));
  });

$("#batal_input").click(function(event) {
    event.preventDefault();
    document.getElementById('show_input_so').style.display = "none";
  });

$('#kode_cabang').change(function(){
        var kode_cabang = $("#kode_cabang").val();

        $.ajax({
            type: "POST",
            url: "<?=base_url()?>ajax/j_so.php?func=loadgud",
            data: "kode_cabang="+kode_cabang,
            cache:false,
            success: function(data) {
                $('#load_gudang').html(data);
                BindSelect2();
                $('#kode_gudang').val('0').trigger('change');
            }
        });

    function BindSelect2() {
      $("[name='kode_gudang']").select2({
              width: '100%'
      });
    }
});

$('#kode_pelanggan').change(function(event){
   event.preventDefault();
   var kode_pelanggan = $("#kode_pelanggan").val();
   var alamat = $("#kode_pelanggan").find(':selected').attr('data-alamat');
   var salesman = $("#kode_pelanggan").find(':selected').attr('data-salesman');
   var nama_kategori = $("#kode_pelanggan").find(':selected').attr('data-nama-kategori');
   var top = $("#kode_pelanggan").find(':selected').attr('data-top');
   if (salesman.length && salesman.indexOf(':') !== -1) {
       var
        sales = salesman.split(':');
        if (sales.length) {
            $('input[name="salesman"]').val(sales[0] || null);
            $('#salesman').val(sales[1] || null);
        }
   }
   if (nama_kategori.length && nama_kategori.indexOf(':') !== -1) {
       var
        nam_kat = nama_kategori.split(':');
        if (nam_kat.length) {
            $('input[name="kategori"]').val(nam_kat[0] || null);
            $('#kategori').val(nam_kat[1] || null);
        }
   }
   $('#alamat').val(alamat);
   $('#top').val(top);	
		$.ajax({
			type: "POST",
			url: "<?=base_url()?>ajax/j_so.php?func=loadppn",
			data: "kode_pelanggan="+kode_pelanggan,
			cache:false,
			success: function(data) {
				$('#load_ppn').html(data);
			}
		});
	});

$('#kode_barang').change(function(event){
   event.preventDefault();
   var satuan_besar        = $(this).find(':selected').attr('data-satuan-besar');
   var satuan_kecil      = $(this).find(':selected').attr('data-satuan-kecil');
   var harga              = $(this).find(':selected').attr('data-harga');
   var konversi           = $(this).find(':selected').attr('data-konversi');
   var satuan           = $('#satuan').val();
   var konversi1           = $('#konversi1').val();
   var kode_pelanggan     = $("#kode_pelanggan").val();
   var kode_inventori     = $(this).val();
   
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "<?=base_url()?>ajax/j_so.php?func=loadhargadiskon",
            data: "kode_pelanggan="+kode_pelanggan+"&kode_inventori="+kode_inventori,
            cache:false,
            success: function(response) {
                $('#harga').val(response.harga);
                $('#diskon1').val(response.diskon);
                $('#konversi').val(konversi);
                $('#qty').val('0');
                $('#konversi1').val('0').trigger('change');
                $('#konversi2').val('0');
                $('#text-satuan_simpan').html(satuan_kecil);
                $('#satuan_simpan').val(satuan_kecil);
				$('#satuan_jual').val(satuan_besar);
				hitungtable();
                numberjs();
            }
        });
        
        function numberjs(){
            $("[name='konversi2']").number( true, 2 );
            $("[name='qty']").number( true, 2 );
            $("[name='harga']").number( true, 2 );
            $("[name='diskon1']").number( true, 2 );
            $("[name='diskon2']").number( true, 2 );
            $("[name='diskon3']").number( true, 2 );
            $("[name='subtot']").number( true, 2 );
            
        }
});

$("#tambah_so").click(function(event) {
    event.preventDefault();

    var kode_pelanggan     = $("#kode_pelanggan").val(),
    fso = localStorage.getItem('form_so');
    if(kode_pelanggan !== '0' ) {
      document.getElementById('show_input_so').style.display = "table-row";
        $('#kode_barang').val('0').trigger('change');
        $('#konversi1').val('0').trigger('change');
        $('#foc').prop('checked', false);
        $('#stat_foc').val('0');
        $('#satuan_jual').val('');
        $('#text-satuan_jual').html('-');
        $('#konversi').val('0');
        $('#konversi2').val('0');
        $('#satuan_simpan').val('');
        $('#text-satuan_simpan').html('-');
        $('#qty').val('0');
        $('#harga').val('0');
        $('#diskon1').val('0');
        $('#diskon2').val('0');
        $('#diskon3').val('0');
        $('#subtot').val('0');
        $('#keterangan').val('');
        if (fso !== null) {
            localStorage.removeItem('form_so');
        }
     }else{
        alert("Pilih Pelanggan Terlebih Dahulu !!");
     }
  });

//SAAT INI
$(document).on("change paste keyup", "[name='konversi1'], [name='qty'], [name='harga'], [name='diskon1'], [name='diskon2'], [name='diskon3'], [name='ppn']", function(){
	hitungtable();
});

//SAAT CENTANG FOC
$(document).on("change", "input[id='foc']", function(){
        var
            harga = $('#harga').val(),
            diskon1 = $('#diskon1').val(),
            diskon2 = $('#diskon2').val(),
            diskon3 = $('#diskon3').val(),
            subtot = $('#subtot').val(),
            fso = localStorage.getItem('form_so'),
            json = [];

        if (this.checked){

            if (fso === null) {
                json = {
                    harga: harga,
                    diskon1: diskon1,
                    diskon2: diskon2,
                    diskon3: diskon3,
                    subtot: subtot,
                };
                localStorage.setItem('form_so', JSON.stringify(json));
            }
          $('#harga').val(0);
          $('#diskon1').val(0);
          $('#diskon2').val(0);
          $('#diskon3').val(0);
          $('#subtot').val(0);
		  $('#stat_foc').val(1);
        }
        else {
            if (fso !== null) {
                fso = JSON.parse(fso);
                harga = fso.harga || 0;
                diskon1 = fso.diskon1 || 0;
                diskon2 = fso.diskon2 || 0;
                diskon3 = fso.diskon3 || 0;
                subtot = fso.subtot || 0;
                localStorage.removeItem('form_so');
            }
            $('#harga').val(parseFloat(harga));
            $('#diskon1').val(parseFloat(diskon1));
            $('#diskon2').val(parseFloat(diskon2));
            $('#diskon3').val(parseFloat(diskon3));
            $('#subtot').val(parseFloat(subtot));
            $('#stat_foc').val(0);
        }

});

function hitungtable () {
		var
			kode_barang = $('#kode_barang').val(),
			satuan_jual = $('#satuan_jual').val(),
			satuan_simpan = $('#satuan_simpan').val(),
			satuan = $('#satuan').val(),
			ppn = $('#ppn'),
			ppn_vn = $('#ppn_n'),
			stat_ppn = $('#stat_ppn').val() || 0,
			qty = $('#qty').val() || 0,
			konversi = $('#konversi').val() || 0,
			konversi1 = $('#konversi1').val() || 0,
			konversi2 = $('#konversi2'),
			harga = $('#harga').val() || 0,
			diskon1 = $('#diskon1').val() || 0,
			diskon2 = $('#diskon2').val() || 0,
			diskon3 = $('#diskon3').val() || 0,
			subtot = $('#subtot'),
			ppn_n = 0,
			qtytot = 0,
			subtotal = 0,
			diskon1x = 0,
			diskon2x = 0,
			diskon3x = 0;
			
			diskon1x = (harga - (harga * (diskon1 / 100)));
			diskon2x = (diskon1x - (diskon1x * (diskon2 / 100)));
			diskon3x = (diskon2x - (diskon2x * (diskon3 / 100)));
			
			if (parseInt(konversi1) > 0) {
				qtytot = (qty * (konversi * konversi1));
				$('#text-satuan_jual').html(satuan);
			} else {
				qtytot = (qty * konversi);
				if (satuan_jual !== '') {
					$('#text-satuan_jual').html(satuan_jual);
				} else {
					$('#text-satuan_jual').html('-');
				}
			}
			
			if (kode_barang !== '0') {
				$('#text-satuan_simpan').html(satuan_simpan);
			} else {
				$('#text-satuan_simpan').html('-');
			}
			konversi2.val(qtytot);
			subtotal = (diskon3x * qtytot);
			
			if (ppn.is(':checked')) {
				stat_ppn = 1;
				ppn_n = subtotal - (subtotal / 1.1);
			} else {
				stat_ppn = 0;
				ppn_n = 0;
			}
			$('#ppn_n').val(Math.ceil(ppn_n));
			$('#stat_ppn').val(stat_ppn);
			subtot.val(subtotal);
	}

$("#ok_input").click(function(event) {
    event.preventDefault();
    var id_form         = $("#id_form").val();
    var kode_barang     = $("#kode_barang").val();
    var nama_barang     = $("#nama_barang").val();
    var foc             = $("#stat_foc").val();
    var satuan          = $("#satuan").val();
    var satuan_jual     = $("#satuan_jual").val();
    var satuan_simpan   = $("#satuan_simpan").val();
    var konversi        = $("#konversi").val();
    var konversi1       = $("#konversi1").val();
    var qty             = $("#qty").val();
    var harga           = $("#harga").val();
    var diskon1         = $("#diskon1").val();
    var diskon2         = $("#diskon2").val();
    var diskon3         = $("#diskon3").val();
    var ppn             = $("#stat_ppn").val();
    var ppn_n            = $("#ppn_n").val();
    var subtot          = $("#subtot").val();
    var keterangan      = $("#keterangan").val();
    var fso = localStorage.getItem('form_so');

    if (fso !== null) {
        localStorage.removeItem('form_so');
    }

    if(kode_barang != 0 && qty != 0) {
      var status = 'true';
    }else{
      var status = 'false';
    }

    if(status == 'true') {
      $.ajax({
        type: "POST",
        url: "<?=base_url()?>ajax/j_so.php?func=add",
        data: "kode_barang="+kode_barang+"&foc="+foc+"&satuan="+satuan+"&satuan_jual="+satuan_jual+"&satuan_simpan="+satuan_simpan+"&konversi="+konversi+"&konversi1="+konversi1+"&qty="+qty+"&harga="+harga+"&diskon1="+diskon1+"&diskon2="+diskon2+"&diskon3="+diskon3+"&ppn="+ppn+"&ppn_n="+ppn_n+"&subtot="+subtot+"&keterangan="+keterangan+"&id_form="+id_form,
              cache:false,
        success: function(data) {

          $('#detail_input_so').html(data);
          document.getElementById('show_input_so').style.display = "none";
        }
      });
    }else{
      alert("Peringatan : Harap Isi Kode Barang dan QTY Terlebih Dahulu !!");
    }
    return false;
  });

//SAAT KLIK UM
  $(document).on("change paste keyup", "input[name='um']", function(){
        var um = $(this).val() || 0;
        var g_total = $("#grand_total").val();
        var nominal = parseInt((um/100)*g_total);

        $('[name="nominal"]').val(nominal);

        //console.log(nominal);
  });

$(document).ready(function() {
  $(".add-more").click(function(){
      var id_um     = $("#id_um").val();
      var id_um_new = parseInt(id_um)+1;

      var um        = $("#um").val();
      var nominal   = $("#nominal").val();

      $.ajax({
        type: "POST",
        url: "<?=base_url()?>ajax/j_so.php?func=addum",
        data: "id_um="+id_um+"&um="+um+"&nominal="+nominal,
        cache:false,
        success: function(data) {
          var html = $(".copy").html(data);
                $(".after-add-more").after(html);

          $("body").on("click",".remove",function(){
            $(this).parents(".control-group").remove();
            });
        }
      });

      $('#um').val('');
      $('#nominal').val('0');
      $('#id_um').val(id_um_new);
      $('#um').focus();
      });
  });

$('body').delegate(".edit_so","click", function() {
    var id =  $(this).attr('data-id');
    var id_form = $('#id_form').val();
    $.ajax({
      type: 'POST',
      url: '<?=base_url()?>ajax/j_so.php?func=edit-so',
      data: 'id=' +id + '&id_form=' +id_form,
      cache: false,
      success:function(data){
        $('#show-item-edit').html(data).show();
        Hitungdariqty();
        BindSelect2();
      }
    });

    function BindSelect2() {
      $("[name='satuan_edit']").select2({
              width: '100%'
      });
    }

    function Hitungdariqty() {
      //SAAT KLIK KONVERSI1_EDIT
      $(document).on("change paste keyup", "input[id='konversi1_edit']", function(){
        var konversi1_edit     = $(this).val() || 0;

        var harga_edit         = $('#harga_edit').val();
        var konversi_edit      = $('#konversi_edit').val();
        var qty_edit           = $('#qty_edit').val();
        var diskon1_edit       = parseInt($('#diskon1_edit').val());

        if (qty_edit == 0){
          var qty_all_edit       = konversi1_edit*konversi_edit;
        }else{
          var qty_all_edit       = konversi1_edit*konversi_edit*qty_edit;
        }

        var diskon_edit        = diskon1_edit/100;
        var harga_qty_edit     = parseInt(harga_edit*qty_all_edit);
        var harga_diskon_edit  = parseInt(harga_qty_edit*diskon_edit);

        var subtot_edit        = parseInt(harga_qty_edit-harga_diskon_edit);

        $('#subtot_edit').val(subtot_edit);
      });

      //SAAT KLIK QTY_EDIT
      $(document).on("change paste keyup", "input[id='qty_edit']", function(){
        var qty_edit           = $(this).val() || 0;

        var harga_edit         = $('#harga_edit').val();
        var konversi_edit      = $('#konversi_edit').val();
        var konversi1_edit     = $('#konversi1_edit').val();
        var diskon1_edit       = parseInt($('#diskon1_edit').val());

        if (konversi1_edit == 0){
          var qty_all_edit       = qty_edit*konversi_edit;
        }else{
          var qty_all_edit       = konversi1_edit*konversi_edit*qty_edit;
        }

        var diskon_edit        = diskon1_edit/100;
        var harga_qty_edit     = parseInt(harga_edit*qty_all_edit);
        var harga_diskon_edit  = parseInt(harga_qty_edit*diskon_edit);

        var subtot_edit        = parseInt(harga_qty_edit-harga_diskon_edit);

        $('#subtot_edit').val(subtot_edit);
      });

      //SAAT KLIK DISKON_EDIT
      $(document).on("change paste keyup", "input[id='diskon1_edit']", function(){
        var diskon1_edit       = $(this).val() || 0;

        var harga_edit         = $('#harga_edit').val();
        var konversi_edit      = $('#konversi_edit').val();
        var konversi1_edit     = $('#konversi1_edit').val();
        var qty_edit           = $('#qty_edit').val();

        if (konversi1_edit == 0){
          var qty_all_edit       = qty_edit*konversi_edit;
        }else if (qty_edit == 0){
          var qty_all_edit       = konversi1_edit*konversi_edit;
        }else{
          var qty_all_edit       = konversi1_edit*konversi_edit*qty_edit;
        }
        var diskon_edit        = diskon1_edit/100;
        var harga_qty_edit     = parseInt(harga_edit*qty_all_edit);
        var harga_diskon_edit  = parseInt(harga_qty_edit*diskon_edit);

        var subtot_edit        = parseInt(harga_qty_edit-harga_diskon_edit);

        $('#subtot_edit').val(subtot_edit);
      });

      //SAAT CENTANG PPN
      $(document).on("change paste keyup", "input[id='ppn_edit']", function(){
        if (this.checked){
          var stat_edit = 1;
          $('#stat_ppn_edit').val(stat_edit);
        } else {
          var stat_edit = 0;
          $('#stat_ppn_edit').val(stat_edit);
        }
      });

      //SAAT CENTANG FOC
      $(document).on("change paste keyup", "input[id='foc_edit']", function(){
        if (this.checked){
          var stat_edit1 = 1;
          $('#stat_foc_edit').val(stat_edit1);
        } else {
          var stat_edit1 = 0;
          $('#stat_foc_edit').val(stat_edit1);
        }

        var stat_foc_edit = $('#stat_foc_edit').val();
        if (stat_foc_edit == 1){
          var harga_edit         = $('#harga_edit').val(0);
          var diskon1_edit       = parseInt($('#diskon1_edit').val(0));
          var subtot_edit        = parseInt($('#subtot_edit').val(0));
        }else{
          var harga_edit         = $('#harga_edit').val();
          var diskon1_edit       = parseInt($('#diskon1_edit').val());
          var subtot_edit        = parseInt($('#subtot_edit').val());
        }

        $('#harga_edit').val(harga_edit);
        $('#diskon1_edit').val(diskon1_edit);
        $('#subtot_edit').val(subtot_edit);
      });
    }
});

</script>
<!-- ============ PRINT KE CSV =============== -->
<script>


   $(document).ready(function () {
   function exportTableToCSV($table, filename) {

      var $rows = $table.find('tr:has(td),tr:has(th)'),

         // Temporary delimiter characters unlikely to be typed by keyboard
         // This is to avoid accidentally splitting the actual contents
         tmpColDelim = String.fromCharCode(11), // vertical tab character
         tmpRowDelim = String.fromCharCode(0), // null character

         // actual delimiter characters for CSV format
         colDelim = '","',
         rowDelim = '"\r\n"',

         // Grab text from table into CSV formatted string
         csv = '"' + $rows.map(function (i, row) {
            var $row = $(row), $cols = $row.find('td,th');

            return $cols.map(function (j, col) {
               var $col = $(col), text = $col.text();

               return text.replace(/"/g, '""'); // escape double quotes

            }).get().join(tmpColDelim);

         }).get().join(tmpRowDelim)
            .split(tmpRowDelim).join(rowDelim)
            .split(tmpColDelim).join(colDelim) + '"',



         // Data URI
         csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

         console.log(csv);

         if (window.navigator.msSaveBlob) { // IE 10+
            //alert('IE' + csv);
            window.navigator.msSaveOrOpenBlob(new Blob([csv], {type: "text/plain;charset=utf-8;"}), "csvname.csv")
         }
         else {
            $(this).attr({ 'download': filename, 'href': csvData, 'target': '_blank' });
         }
   }

	$(document).on('click', 'a[class~="btn-export-csv"]', function(){
		var
			$this = $(this),
			$nextTable = $this.parent().siblings('table');
		if ($nextTable.length) {
			if ($nextTable.hasClass('table-export-csv')) {
				exportTableToCSV.apply(this, [
					$($nextTable),
					($nextTable.attr('data-csv-name') || 'generated_' + new Date().toLocaleDateString()) + '.csv'
				]);
			}
		}
	});

   });

</script>

<!-- <script src="<?=base_url()?>assets/select2/select2.js"></script> -->
<script>

  $(function () {
    $('#example1').DataTable({
      'searching'   : false,
    })

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
<script>
    var
        $disabledMonth = [];
    <?php
        if (mysql_num_rows($q_close)) {
            $disabledMonth = [];
            while ($row = mysql_fetch_object($q_close)) {
                $disabledMonth[] = '\'' . $row->fulltext . '\'';
            }
            echo '$disabledMonth = [' . implode(',', $disabledMonth) . '];';
        }
    ?>
    $(".date-picker").datepicker();
    $(".date-picker-close").datepicker({
        beforeShowDay: function($date) {
            var
                $string = new Date($date);
            $string = $string.getFullYear() + '-' + (($string.getMonth()+1) < 10 ? '0' + ($string.getMonth()+1) : $string.getMonth()+1);
            return [$.inArray($string, $disabledMonth) === -1];
        }
    });
</script>
<script>
  $(".select2").select2({
      width: 'resolve'
  });
</script>
