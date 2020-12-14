<?php
   include "pages/data/script/sj.php";
   include "library/form_akses.php";
?>

<section class="content-header">
  <ol class="breadcrumb">
    <li><i class="fa fa-money"></i>Logistik</li>
    <li>Surat Jalan</li>
  </ol>
</section>

<div class="box box-info">
    <div class="box-body">

         <?php if (isset($_GET['pesan'])){ ?>
            <div class="form-group" id="form_report">
              <div class="alert alert-success alert-dismissable">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 Kode SJ :  <a href="<?=base_url()?>?page=logistik/sj_track&action=track&halaman= TRACK SURAT JALAN&kode_sj=<?=$_GET['pesan']?>" target="_blank"><?=$_GET['pesan'] ?></a>  Berhasil Di posting
              </div>
            </div>
         <?php  }else if (isset($_GET['pembatalan'])){ ?>
        <div class="form-group" id="form_report">
          <div class="alert alert-dismissable" style="background-color: #9c0303cc; color: #f9e6c3">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color: #f9e6c3">&times;</button>
            Pembatalan Kode SJ :  <a style="color: white" href="<?=base_url()?>?page=logistik/sj_track&halaman= TRACK SURAT JALAN&action=track&kode_sj=<?=$_GET['pembatalan']?>" target="_blank"><?=$_GET['pembatalan'] ?></a>  Berhasil Di batalkan
          </div>
        </div>
      <?php } ?>

      <div class="tabbable">
         <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
            <li <?=$class_form?>>
               <a data-toggle="tab" href="#menuFormSj">Form Surat Jalan</a>
            </li>
                <li <?=$class_tab?>>
               <a data-toggle="tab" href="#menuListSj">List Surat Jalan</a>
            </li>
            </ul>

      <div class="row">
         <div class="tab-content">
            <div id="menuFormSj"
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

                                  <div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode SJ</label>
                                    <div class="col-lg-4">
                                       <input type="text" class="form-control" name="kode_sj" id="kode_sj" placeholder="Auto..." readonly value="">
                                    </div>

                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Pelanggan</label>
                                    <div class="col-lg-4">
                                       <select id="kode_pelanggan" name="kode_pelanggan" class="select2" style="width: 100%;">
                                          <option value="0">-- Pilih Pelanggan --</option>
                                          <?php
                                            while($row_pelanggan = mysql_fetch_array($q_pelanggan)) { ;?>

                                                <option value="<?php echo $row_pelanggan['kode_pelanggan'];?>" <?php if($row_pelanggan['kode_pelanggan']==$row_pelanggan){echo 'selected';} ?>><?php echo $row_pelanggan['kode_pelanggan'] . ' - ' . $row_pelanggan['nama_pelanggan'];?> </option>
                                                <?php } ?>
                                                <input type="hidden" name="kode_pelanggan1" id="kode_pelanggan1" class="form-control" value="<?php echo $row_pelanggan['kode_pelanggan'];?>"/>
                                        </select>
                                    </div>
                                  </div>

                                 <div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal</label>
                                      <div class="col-lg-4">
                                        <div class="input-group">
                                               <input type="text" name="tgl_buat" id="tgl_buat" class="form-control date-picker-close" autocomplete="off" value="<?=date("m/d/Y")?>" readonly>
                                               <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                          </div>
                                      </div>

                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Alamat Kirim</label>
                                      <div class="col-lg-4">
                                         <input type="text" autocomplete="off" class="form-control" name="alamat_kirim" id="alamat_kirim" placeholder="Alamat Kirim..." value="">
                                      </div>
                                 </div>

                                 <div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
                                      <div class="col-lg-4">
                                         <input type="text" autocomplete="off" class="form-control" name="ref" id="ref" placeholder="Ref..." value="">
                                      </div>
                                 </div>

                                 <div class="form-group">
                                     <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
                                     <div class="col-lg-4">
                                        <select id="kode_cabang" name="kode_cabang" class="select2" style="width: 100%;">
                                                <option value="" selected>-- Pilih Cabang --</option>
                                                <?php
                                                while($row_cabang = mysql_fetch_array($q_cabang)) { ;?>
                                                <option value="<?php echo $row_cabang['kode_cabang'];?>"><?php echo $row_cabang['nama_cabang'];?> </option>
                                                <?php } ?>
                                        </select>
                                     </div>
                                 </div>

                                <div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Gudang</label>
                                    <div class="col-lg-4">
                                         <select id="kode_gudang" name="kode_gudang" class="select2" style="width: 100%;">
                                                <option value="" selected>-- Pilih Gudang --</option>
                                                <?php
                                                while($row_gudang = mysql_fetch_array($q_gudang)) { ;?>
                                                <option value="<?php echo $row_gudang['kode_gudang'];?>"><?php echo $row_gudang['nama_gudang'];?> </option>
                                                <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                     <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                                     <div class="col-lg-10">
                                         <textarea type="text" class="form-control" name="keterangan_hdr" id="keterangan_hdr" placeholder="Keterangan..." value=""></textarea>
                                     </div>
                                </div>

                                 <div class="form-group">
                                        <div class="col-lg-12">
                                            <table id="example1" class="table table-striped table-bordered table-hover" width="100%" >
                                                <thead>
                                                    <tr>
                                                        <th style="width: 5%"></th>
                                                        <th style="width: 15%">Kode SO</th>
                                                        <th style="width: 15%">Nama Barang</th>
                                                        <th style="width: 5%">FOC</th>
                                                        <th style="width: 30%" colspan="3">Quantity Konversi</th>
                                                        <th style="width: 20%">Q Terkirim</th>
                                                        <th style="width: 20%">Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="detail_input_sj">
                                                   <tr>
                                                         <td colspan="10" class="text-center"> Tidak ada item barang. </td>
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

                                          <a href="<?=base_url()?>?page=penjualan/sj&halaman= SURAT JALAN" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>
                            </div>

                              </form>

                                <div class="copy">

                                </div>

                           </div>
                        </div>
                     </div>
                  </div>
            </div>

            <div id="menuListSj" <?=$class_pane_tab?>>
                  <div class="col-lg-12">
                     <div class="panel panel-default">
                        <div class="panel-body">

                           <form action="" method="post" >

                                    <div class="col-xs-12 col-md-4" style="margin-bottom:3mm">
                                          <div class="input-group">
                                             <span class="input-group-addon point">Kode</span>
                                          <input type="text" autocomplete="off" class="form-control" name="kode_sj" id="kode_sj" placeholder="Kode ..." value="<?php

                                       if(empty($_POST['kode_sj'])){
                                          echo "";

                                       }else{
                                          echo $_POST['kode_sj'];
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

                                    <div class="col-xs-12 col-md-6" style="margin-bottom:3mm">
                                           <div class="input-group">
                                               <span class="input-group-addon">Tanggal Awal</i></span>
                                               <input type="text" name="tanggal_awal" id="tanggal_awal" class="form-control date-picker" autocomplete="off" value="<?=date("d-m-Y")?>">
                                               <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                           </div>
                                       </div>

                                    <div class="col-xs-12 col-md-6" style="margin-bottom:3mm">
                                          <div class="input-group">
                                             <span class="input-group-addon">Tanggal Akhir</span>
                                             <input type="text" name="tanggal_akhir" id="tanggal_akhir" class="form-control date-picker" autocomplete="off"value="<?=date("d-m-Y")?>">
                                             <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                          </div>
                                    </div>

                                    <div class="pull-right" style="margin-bottom:3mm">
                                        <button type="submit" name="refresh" id="refresh" class="btn btn-info btn-sm" value="refresh"><i class="fa fa-refresh"></i>Refresh</button>
                                    </div>

                                  <div class="col-md-1 pull-right" style="margin-bottom:3mm">
                                    <button type="submit" name="cari" id="cari" class="btn btn-primary btn-sm" value="cari"><i class="fa fa-search"></i> Cari</button>
                                    </div>
                                 </form>

                           <div class="box-body">
                           <table id="example2" class="table table-striped table-bordered table-hover" width="100%" >
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
                                                <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>

                                 <?php
                                    $n=1; if(mysql_num_rows($q_sj) > 0) {
                                    while($data = mysql_fetch_array($q_sj)) {

                                      if($data['status'] == '1'){
                                        $status = 'Open';
                                        $warna = 'style="background-color: #39b13940"';
                                      }elseif($data['status'] == '2'){
                                        $status = 'Batal';
                                        $warna = 'style="background-color: #de4b4b63;"';
                                      }else{
                                        $status = 'Lunas';
                                        $warna = 'style="background-color: #ffd10045;"';
                                      }
                                 ?>

                                 <tr <?= $warna;?>>
                                    <td style="text-align: center"> <?php echo $n++ ?></td>
                                    <td><a href="<?=base_url()?>?page=logistik/sj_track&action=track&halaman= TRACK SURAT JALAN&kode_sj=<?=$data['kode_sj']?>" target="_blank"><?php echo $data['kode_sj'];?></a></td>
                                    <td style="text-align: center"> <?php echo date("d-m-Y",strtotime($data['tgl_buat']));?></td>
                                    <td> <?php echo $data['ref'];?></td>
                                    <td> <?php echo $data['nama_cabang'];?></td>
                                    <td> <?php echo $data['nama_gudang'];?></td>
                                    <td> <?php echo $data['nama_pelanggan'];?></td>
                                    <td style="text-align: right"> <?php echo number_format($data['subtotal'], 2);?></td>
                                    <td> <?php echo $data['keterangan_hdr'];?></td>
                                    <td style="text-align: center"> <?php echo $status; ?></td>
                                    <td style="text-align: center">
                                      <a href="<?=base_url()?>r_cetak_sj.php?kode_sj=<?=$data['kode_sj']?>" title="cetak" target="_blank">
                                        <button type="button" class="btn btn-warning btn-xs">
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


<?php unset($_SESSION['data_sj']); ?>


  <script>

  $(document).ready(function (e) {
    $("#saveForm").on('submit',(function(e) {
      var grand_total = 0;
        $('[name="qty_dikirim[]"]').each(function() {
          grand_total += +(this.value || 0).replace(/,/g, '');
        });
      if(grand_total == "" || isNaN(grand_total)) {grand_total = 0;}
      e.preventDefault();
      if(grand_total != 0 && grand_total > 0) {
         $(".animated").show();
         $.ajax({
            url: "<?=base_url()?>ajax/j_sj.php?func=save",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(html)
            {
               var msg = html.split("||");
               if(msg[0] == "00") {
                  window.location = '<?=base_url()?>?page=logistik/sj&halaman= SURAT JALAN&pesan='+msg[1];
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
    document.getElementById('show_input_sj').style.display = "none";
  });
  
  $(document).on("change paste keyup", "#kode_cabang, #kode_gudang, #kode_pelanggan", function() {
	  var
		kode_cabang = $("#kode_cabang").val(),
		kode_gudang = $("#kode_gudang").val(),
		kode_pelanggan = $("#kode_pelanggan").val();
	
		$.ajax({
          type: "POST",
          url: "<?=base_url()?>ajax/j_sj.php?func=loaditem",
          data:"kode_pelanggan="+kode_pelanggan+"&kode_cabang="+kode_cabang+"&kode_gudang="+kode_gudang,
          cache:false,
          success: function(data) {
            $('#detail_input_sj').html(data);
            hitungqtydikirimtotal();
            numberjs();
          }
        });
  });
  
  function numberjs() {
	$("[name='qty_so1[]']").number( true, 2 );
	$("[name='qty_so2[]']").number( true, 2 );
	$("[name='qty_so3[]']").number( true, 2 );
	$("[name='qty_dikirim[]']").number( true, 2 );
  }

  function hitungqtydikirimtotal() {

	$(document).on("change paste keyup", "input[data-id='qty_dikirim']", function(){
	  var qty_dikirim   = $(this).val() || 0;
	  var group         = $(this).data('group');

	  //QTY1
	  var qty1    = $("input[data-id='qty_so1'][data-group='"+group+"']").val();
	  if(qty1 > 0){
		$("input[data-id='qty_so1'][data-group='"+group+"']").val(qty_dikirim);
	  }else{
		$("input[data-id='qty_so1'][data-group='"+group+"']").val(qty1);
	  }

	  //QTY2
	  var konversi1 = $("input[data-id='konversi1'][data-group='"+group+"']").val();
	  if(qty1 > 0){
		var qty_so2 = qty_dikirim*konversi1;
	  }else{
		var qty_so2 = qty_dikirim;
	  }
	  $("input[data-id='qty_so2'][data-group='"+group+"']").val(qty_so2);

	  //QTY3
	  var konversi  = $("input[data-id='konversi'][data-group='"+group+"']").val();
	  var qty_so3   = (qty_so2*konversi);
	  $("input[data-id='qty_so3'][data-group='"+group+"']").val(qty_so3);
	  $("input[data-id='qty_dikirim_total'][data-group='"+group+"']").val(qty_so3);

	});
  }


</script>

<!-- <script src="<?=base_url()?>assets/select2/select2.js"></script> -->
<script>

  $(document).ready(function(){

  $(function () {
    $('#example1').DataTable({
      'searching'   : false,
    });

    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    });
    });
    });
</script>

<script>
  $(".select2").select2({
      width: '100%'
  });
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
