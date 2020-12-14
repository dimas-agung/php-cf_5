<?php
   include "pages/data/script/jm.php";
   include "library/form_akses.php";
?>
<section class="content-header">
    <ol class="breadcrumb">
      <li><i class="fa fa-money"></i>Keuangan</a></li>
      <li>Jurnal Memorial</a></li>
    </ol>
</section>


<div class="box box-info">
    <div class="box-body">

         <?php if (isset($_GET['pesan'])){ ?>
            <div class="form-group" id="form_report">
              <div class="alert alert-success alert-dismissable">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 Kode JM :  <a href="<?=base_url()?>?page=keuangan/jm_track&action=track&halaman= TRACK JURNAL MEMORIAL&kode_jm=<?=$_GET['pesan']?>" target="_blank"><?=$_GET['pesan'] ?></a>  Berhasil Di posting
              </div>
            </div>
         <?php  }  ?>

      <div class="tabbable">
         <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
            <li <?=$class_form?>>
               <a data-toggle="tab" href="#menuFormJm">Form Jurnal Memorial</a>
            </li>
                <li <?=$class_tab?>>
               <a data-toggle="tab" href="#menuListJm">List Jurnal Memorial</a>
            </li>
            </ul>

      <div class="row">
         <div class="tab-content">
            <div id="menuFormJm"
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
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode JM</label>
                                    <div class="col-lg-10">
                                       <input type="text" class="form-control" name="kode_jm" id="kode_jm" placeholder="Auto..." readonly value="">
                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
                                      <div class="col-lg-10">
                                         <input type="text" autocomplete="off" class="form-control" name="ref" id="ref" placeholder="Ref..." value="">
                                      </div>
                                 </div>

                                 <div class="form-group">
                                    <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tanggal JM</label>
                                      <div class="col-lg-10">
                                        <div class="input-group">
                                               <input type="text" name="tgl_buat" id="tgl_buat" class="form-control date-picker-close" autocomplete="off" value="<?=date("m/d/Y")?>" readonly>
                                               <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                          </div>
                                      </div>
                                 </div>

                                 <div class="form-group">
                                     <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
                                     <div class="col-lg-10">
                                        <select id="kode_cabang" name="kode_cabang" class="select2" style="width: 100%;">
                                                <option value="">-- Pilih Cabang --</option>
                                                <?php
                                                //CEK JIKA cabang ADA MAKA SELECTED
                                                (isset($row['id_jm']) ? $cabang=$row['kode_cabang'] : $cabang='');
                                                //UNTUK AMBIL coanya
                                                while($row_cabang = mysql_fetch_array($q_cabang)) { ;?>

                                                <option value="<?php echo $row_cabang['kode_cabang'];?>" <?php if($row_cabang['kode_cabang']==$cabang){echo 'selected';} ?>><?php echo $row_cabang['nama_cabang'];?> </option>
                                                <?php } ?>
                                                <input type="hidden" name="kode_cabang1" id="kode_cabang1" class="form-control" value="<?php echo $row_cabang['kode_cabang'];?>"/>
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
                                      <div class="pull-left">
                                        <a class="btn btn-success" id="tambah_jm"><i class="fa fa-plus"></i> Add</a>
                                      </div>
                                   </div>
                                </div>

                                 <div class="form-group">
                                        <div class="col-lg-12">
                                            <table id="" class="" rules="all">
                                                <thead>
                                                    <?php
                                                        $n=1;
                                                    ?>
                                                    <tr>
                                                        <th>No</th>
                                                        <th style="width: 30%">COA</th>
                                                        <th>Debet</th>
                                                        <th>Kredit</th>
                                                        <th>Keterangan</th>
                                                        <th></th>
                                                    </tr>

                                                    <tr id="show_input_jm" style="display:none">
                                                            <td style="text-align: center">#</td>
                                                            <td>
                                                                <select id="kode_coa" name="kode_coa" class="select2" style="width: 500px">
                                                                  <option value="">-- Pilih DOC --</option>
                                                                    <?php

                                                                      (isset($_POST['kode_coa']) ? $coa=$_POST['kode_coa'] : $coa='');

                                                                      while($row_coa = mysql_fetch_array($q_coa)) { ;?>

                                                                      <option value="<?php echo $row_coa['kode_coa'].':'.$row_coa['nama_coa'];?>"
                                                                        <?php if($row_coa['kode_coa']==$coa){echo 'selected';} ?> >
                                                                        <?php echo $row_coa['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$row_coa['nama_coa'];?>
                                                                      </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="text" name="debet" id="debet" value="0" autocomplete="off"/>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="text" name="kredit" id="kredit"  autocomplete="off" value="0"/>
                                                            </td>
                                                            <td>
                                                                 <input class="form-control" type="text" name="keterangan" id="keterangan" autocomplete="off" />
                                                            </td>
                                                            <td>
                                                                <button id="ok_input" class="btn btn-sm btn-info ace-icon fa fa-check" title="ok"></button>
                                                                <a href="" id="batal_input" class="btn btn-sm btn-danger ace-icon fa fa-remove" title="batal" ></a>
                                                            </td>
                                                        </tr>
                                                </thead>
                                                <tbody id="detail_input_jm">
                                                   <tr>
                                                         <td colspan="15" class="text-center"> Tidak ada item barang. </td>
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

                                          <a href="<?=base_url()?>?page=keuangan/jm" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>
                            </div>

                              </form>

                                <div class="copy">

                                </div>

                           </div>
                        </div>
                     </div>
                  </div>
            </div>

            <div id="menuListJm" <?=$class_pane_tab?>>
                  <div class="col-lg-12">
                     <div class="panel panel-default">
                        <div class="panel-body">

                           <form action="" method="post" >

                                    <div class="col-xs-12 col-md-3" style="margin-bottom:3mm">
                                          <div class="input-group">
                                             <span class="input-group-addon point">Kode</span>
                                          <input type="text" autocomplete="off" class="form-control" name="kode_jm" id="kode_jm" placeholder="Kode ..." value="<?php

                                       if(empty($_POST['kode_jm'])){
                                          echo "";

                                       }else{
                                          echo $_POST['kode_jm'];
                                       }

                                       ?>">
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-md-3" style="margin-bottom:3mm">
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

                                     <div class="col-xs-12 col-md-3" style="margin-bottom:3mm">
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

                                    <div class="col-xs-12 col-md-3" style="margin-bottom:3mm">
                                          <div class="input-group">
                                            <span class="input-group-addon point">Status</span>
                                              <select id="status" name="status" class="select2" style="width: 100%;">
                                                <option value="" selected>-- Pilih Status --</option>
                                                <option value="1">READY</option>
                                                <option value="0">CLOSE</option>
                                              </select>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-md-6" style="margin-bottom:3mm">
                                           <div class="input-group">
                                               <span class="input-group-addon">Tanggal Awal</i></span>
                                               <input type="text" name="tanggal_awal" id="tanggal_awal" class="form-control date-picker" autocomplete="off" value="<?=date("m/d/Y")?>">
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

                                    <div class="pull-right" style="margin-bottom:3mm">
                                             <button type="submit" name="refresh" id="refresh" class="btn btn-info btn-sm" value="refresh"><i class="fa fa-refresh"></i>Refresh</button>
                                    </div>

                                  <div class="col-md-1 pull-right" style="margin-bottom:3mm">
                                    <button type="submit" name="cari" id="cari" class="btn btn-primary btn-sm" value="cari"><i class="fa fa-search"></i>cari</button>
                                    </div>
                                 </form>

                           <div class="box-body">
                           <table id="example1" class="table table-striped table-bordered table-hover" width="100%" >
                              <thead>
                                 <tr>
                                                <th>No</th>
                                                <th>Kode JM</th>
                                                <th>Tanggal</th>
                                                <th>Ref</th>
                                                <th>Cabang</th>
                                                <th>Keterangan</th>
                                                <th>Status</th>
                                 </tr>
                              </thead>
                              <tbody>

                                 <?php
                                    $n=1; if(mysql_num_rows($q_jm) > 0) {
                                    while($data = mysql_fetch_array($q_jm)) {
                                 ?>

                                 <tr>
                                    <td style="text-align: center"> <?php echo $n++ ?></td>
                                    <td><a href="<?=base_url()?>?page=keuangan/jm_track&action=track&kode_jm=<?=$data['kode_jm']?>"><?php echo $data['kode_jm'];?></a></td>
                                    <td> <?php echo strftime("%A, %d %B %Y", strtotime($data['tgl_buat']));?></td>
                                    <td> <?php echo $data['ref'];?></td>
                                    <td> <?php echo $data['nama_cabang'];?></td>
                                    <td> <?php echo $data['keterangan_hdr'];?></td>
                                    <td> <?php echo $data['status']=='1' ?
                                        '<p>
                                            <span class="btn-sm btn-success fa fa-check"></span>&nbsp;
                                            Ready
                                         </p>'
                                        :
                                        '<p>
                                            <span class="btn-sm btn-danger fa fa-remove"></span>&nbsp;
                                            Close
                                        </p>'
                                          ?>
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

<div class="modal fade" id="edit_jm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

<?php unset($_SESSION['data_jm']); ?>

  <script>

   harga = 0;
   subtotal = 0;
   ppn = 0;
   
  $(document).ready(function () {
      $("[name='debet']").number( true, 2 );
      $("[name='kredit']").number( true, 2 );
  }); 

  $(document).ready(function (e) {
    $("#saveForm").on('submit',(function(e) {

      if ($('#subtotal_debet').val() != $('#subtotal_kredit').val())
      {
        alert("Nilai Debet Harus Sama Dengan Nilai Kredit !!!");
        return false;
      }

      var grand_total = parseFloat($("#subtotal_debet").val());
      if(grand_total == "" || isNaN(grand_total)) {grand_total = 0;}
      e.preventDefault();
      if(grand_total != 0 && grand_total > 0) {
         $(".animated").show();
         $.ajax({
            url: "<?=base_url()?>ajax/j_jm.php?func=save",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(html)
            {
               var msg = html.split("||");
               if(msg[0] == "00") {
                  //window.open('r_keuangan_cetak.php?noNota=' + msg[1], width=330,height=330,left=100, top=25);

                  window.location = '<?=base_url()?>?page=keuangan/jm&pesan='+msg[1];
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
    document.getElementById('show_input_jm').style.display = "none";
  });

$("#tambah_jm").click(function(event) {
    event.preventDefault();
    document.getElementById('show_input_jm').style.display = "table-row";

    $('#kode_coa').val('').trigger('change');
    $('#debet').val('0');
    $('#kredit').val('0');
    $('#keterangan').val('');
  });

$("#ok_input").click(function(event) {
    event.preventDefault();
    var id_form         = $("#id_form").val();
    var kode_coa        = $("#kode_coa").val();
    var debet           = $("#debet").val();
    var kredit          = $("#kredit").val();
    var keterangan      = $("#keterangan").val();

    $.ajax({
      type: "POST",
      url: "<?=base_url()?>ajax/j_jm.php?func=add",
      data: "kode_coa="+kode_coa+"&debet="+debet+"&kredit="+kredit+"&satuan="+"&keterangan="+keterangan+"&id_form="+id_form,
            cache:false,
      success: function(data) {

        $('#detail_input_jm').html(data);
        document.getElementById('show_input_jm').style.display = "none";
        //display message back to user here
      }
      });
    return false;
  });

$('body').delegate(".edit_jm","click", function() {
    var id =  $(this).attr('data-id');
    var id_form = $('#id_form').val();
    $.ajax({
      type: 'POST',
      url: '<?=base_url()?>ajax/j_jm.php?func=edit-jm',
      data: 'id=' +id + '&id_form=' +id_form,
      cache: false,
      success:function(data){
        $('#show-item-edit').html(data).show();
        BindSelect2();
        kode_coa();
      }
    });

    function BindSelect2() {
      $("[name='kode_coa_edit']").select2({
              width: '100%'
      });
    }

    function kode_coa() {
      $('#kode_coa_edit').change(function(event){
      event.preventDefault();
         var nama = $("#kode_coa_edit").find(':selected').attr('data-nama');
         $('#nama_coa_edit').val(nama);
    });
  }
});



</script>

<script src="<?=base_url()?>assets/select2/select2.js"></script>
<script>

  $(function () {
    $( '#example1' ).DataTable({
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
  $(".select2").select2()({
      width: '100%'
  });
</script>


