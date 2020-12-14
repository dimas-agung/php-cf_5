<?php
   include "pages/data/script/pl.php";
   include "library/form_akses.php";
?>

<section class="content-header">
  <ol class="breadcrumb">
    <li><i class="fa fa-tag"></i> Penjualan</li>
    <li>Packing List</li>
  </ol>
</section>

<div class="box box-info">
    <div class="box-body">

         <?php if (isset($_GET['pesan'])){ ?>
            <div class="form-group" id="form_report">
              <div class="alert alert-success alert-dismissable">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 Kode PL : <?=$_GET['pesan'] ?> Berhasil Di posting
              </div>
            </div>
         <?php  }  ?>

      <div class="tabbable">
         <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
            <li class="active">
               <a data-toggle="tab" href="#menuFormPl"> Form</a>
            </li>
                <li>
               <a data-toggle="tab" href="#menuListPl"> List</a>
            </li>
            </ul>

      <div class="row">
         <div class="tab-content">
            <div id="menuFormPl" class="tab-pane in active" >
                  <div class="col-lg-12">
                     <div class="panel panel-default">
                        <div class="panel-body">
                          <div class="form-horizontal">
                            <div class="col-md-6">
                              <div class="col-md-12 pm-min">
                                <?php $id_form = buatkodeform("kode_form"); ?>

                                <form action="" method="post" enctype="multipart/form-data" id="Form1">

                                  <?php
                                    $idtem = "INSERT INTO form_id SET kode_form ='".$id_form."' ";
                                    mysql_query($idtem);
                                  ?>
                                    <input type="hidden" name="id_form" id="id_form" value="<?php echo $id_form; ?>"/>

                                       <div class="form-group">
                                         <label class="col-lg-2 control-label" style="text-align:left">Cabang</label>
                                         <div class="col-lg-10">
                                            <select id="kode_cabang" name="kode_cabang" class="select2" style="width: 100%;">
                                                    <option value="0">-- Pilih Cabang --</option>
                                                    <?php
                                                    $q_cabang = mysql_query("SELECT kode_cabang, nama nama_cabang FROM cabang WHERE aktif = '1' ORDER BY kode_cabang ASC");
                                                    while($row_cabang = mysql_fetch_array($q_cabang)) { ;?>
                                                    <option value="<?php echo $row_cabang['kode_cabang'];?>"><?php echo $row_cabang['nama_cabang'];?> </option>
                                                    <?php } ?>
                                            </select>
                                          </div>
                                       </div>

                                       <div class="form-group">
                                         <label class="col-lg-2 control-label" style="text-align:left">Gudang</label>
                                         <div class="col-lg-10">
                                             <select id="kode_gudang" name="kode_gudang" class="select2" style="width: 100%;">
                                                    <option value="0">-- Pilih Gudang --</option>
                                                    <?php
                                                    $q_gudang = mysql_query("SELECT kode_gudang, nama nama_gudang FROM gudang ORDER BY kode_gudang ASC");
                                                    while($row_gudang = mysql_fetch_array($q_gudang)) { ;?>
                                                    <option value="<?php echo $row_gudang['kode_gudang'];?>"><?php echo $row_gudang['nama_gudang'];?> </option>
                                                    <?php } ?>
                                            </select>
                                         </div>
                                       </div>

                                       <div class="form-group">
                                         <label class="col-lg-2 control-label" style="text-align:left">Pelanggan</label>
                                         <div class="col-lg-10">
                                           <select id="kode_pelanggan" name="kode_pelanggan" class="select2" style="width: 100%;">
                                              <option value="0">-- Pilih Pelanggan --</option>
                                              <?php
                                                    $q_pelanggan = mysql_query("SELECT kode_pelanggan, nama nama_pelanggan FROM pelanggan WHERE aktif = '1' " . searchKodeSales() . " ORDER BY kode_pelanggan ASC");
                                                    while($row_pelanggan = mysql_fetch_array($q_pelanggan)) { ;?>
                                                    <option value="<?php echo $row_pelanggan['kode_pelanggan'];?>" <?php if($row_pelanggan['kode_pelanggan']==$row_pelanggan){echo 'selected';} ?>><?php echo $row_pelanggan['kode_pelanggan'] . ' - ' . $row_pelanggan['nama_pelanggan'];?> </option>
                                                    <?php } ?>
                                            </select>
                                         </div>
                                       </div>



                                  </br>

                                  <div class="form-group">
                                    <div class="col-lg-8">
                                      <p style="font-family: sans-serif; text-decoration: underline; font-size: 20px;">Data Barang Per SJ</p>
                                    </div>

                                    <div class="col-lg-4" style="text-align: right">
                                      <button type="button" name="submit" class="btn" id="pickup" style="background-color: #295979; border-color: #295979; color: #fff;"><i class="fa fa-truck"></i>  Pick Up</button>
                                    </div>
                                  </div>

                                   <div class="form-group">
                                          <div class="col-lg-12">
                                              <table id="example1" class="table table-striped table-bordered table-hover" width="50%" >
                                                  <thead>
                                                      <tr>
                                                          <th style="width: 5%"></th>
                                                          <th style="width: 15%">Kode SO</th>
                                                          <th style="width: 15%">Kode SJ</th>
                                                          <th style="width: 15%">Kode Barang</th>
                                                          <th style="width: 15%">Nama Barang</th>
                                                          <th style="width: 20%">QTY</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody id="detail_input_pl">
                                                     <tr>
                                                           <td colspan="11" class="text-center"> Tidak ada item barang. </td>
                                                      </tr>
                                                  </tbody>
                                              </table>
                                          </div>
                                   </div>
                                </form>
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="col-md-12 pm-min">
                                <form action="" method="post" enctype="multipart/form-data" id="saveForm">

                                    <div class="form-group">
                                       <label class="col-lg-2 control-label" style="text-align:left">Kode PL</label>
                                        <div class="col-lg-6">
                                          <input type="text" class="form-control" name="kode_pl" id="kode_pl" placeholder="Kode Packing List..." value="">
                                        </div>
                                        <div class="col-lg-4">
                                          <span id="pesan" class="span" style="color:#F00; font-weight:bold"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                       <label class="col-lg-2 control-label" style="text-align:left">Plat Truck</label>
                                        <div class="col-lg-10">
                                          <input type="text" class="form-control" name="plat_truck" id="plat_truck" placeholder="Plat Truck..." value="">
                                        </div>
                                    </div>

                                    <h4 align="center"><u>BARANG YANG DI PICKUP</u></h4>

                                    <div class="form-group">
                                      <div class="col-lg-12">
                                                <table id="" class="" rules="all">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 50px">No</th>
                                                            <th style="width: 250px">Kode SO</th>
                                                            <th style="width: 250px">Kode SJ</th>
                                                            <th style="width: 150px">Kode Barang</th>
                                                            <th style="width: 450px">Nama Barang</th>
                                                            <th style="width: 150px">QTY</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="detail_pickup">
                                                      <tr>
                                                        <td colspan="6"></td>
                                                      </tr>
                                                    </tbody>
                                                </table>
                                      </div>
                                    </div>

                                    <div class="form-group" style="text-align: right; padding-right: 15px;">
                                      <?php
                                            $list_survey_write = 'n';
                                            while($res = mysql_fetch_array($q_akses)) {; ?>
                                              <?php
                                              //FORM SURVEY
                                              if($res['form']=='survey'){
                                                if($res['w']=='1'){
                                                     $list_survey_write = 'y';
                                       ?>

                                        <!-- <button type="submit" name="simpan" id="simpan" class="btn btn-md btn-primary"><i class="fa fa-check-square-o"></i> Simpan</button> -->
                                      <?php } } } ?>
                                        <button type="submit" name="simpan" id="simpan" class="btn btn-md btn-primary"><i class="fa fa-check-square-o"></i> Simpan</button>
                                        <a href="<?=base_url()?>?page=penjualan/pl&halaman= PACKING LIST" class="btn btn-md btn-danger"><i class=" fa fa-reply"></i> Batal</a>
                                    </div>
                                </form>
                              </div>
                            </div>

                          </div>
                        </div>
                     </div>
                  </div>
            </div>

            <div id="menuListPl" class="tab-pane">
                  <div class="col-lg-12">
                     <div class="panel panel-default">
                        <div class="panel-body">
                          <div class="box-body">
                            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" role="form" id="form-lap">
                                    <div class="form-group">
                                         <label class="col-lg-1 control-label" style="text-align:left">Kode PL</label>
                                         <div class="col-lg-4">
                                             <select id="kode_pl_list" name="kode_pl_list" class="select2" style="width: 100%;">
                                                    <option value="0">-- Pilih Kode PL --</option>
                                                    <?php
                                                    $q_kode_pl = mysql_query("SELECT `kode_pl_hdr` FROM `pl_hdr` ORDER BY `kode_pl_hdr` ASC");
                                                    while($row_kode_pl = mysql_fetch_array($q_kode_pl)) { ?>
                                                    <option value="<?php echo $row_kode_pl['kode_pl_hdr'];?>"><?php echo $row_kode_pl['kode_pl_hdr']?></option>
                                                    <?php } ?>
                                            </select>
                                         </div>

                                        <div class="col-md-2" style="margin-bottom:3mm; text-align: center">
                                          <button type="button" name="submit" class="btn btn-primary pb-load" tabindex="4"><i class="fa fa-list"></i> Tampilkan</button>
                                        </div>
                                  </div>

                            </form>

                          </br>

                              <a href="#" id="dlcsv" class="btn btn-success pull-right fa fa-download"> Download CSV</a>

                           </br> </br>

                                <table id="packing_list" class="table table-bordered table-striped " width="600px">
                                   <thead>
                                      <tr>
                                        <th style="text-align: center">Kode SO</th>
                                        <th style="text-align: center">Kode SJ</th>
                                        <th style="text-align: center">Barang</th>
                                        <th style="text-align: center">QTY</th>
                                      </tr>
                                   </thead>
                                   <tbody>
                                   <tbody id="show-item-barang">
                                   </tbody>
                                </table>

                          </div>
                        </div>
                     </div>
                  </div>
            </div>

          </div>
      </div>


<?php unset($_SESSION['data_pl']); ?>
<?php unset($_SESSION['data_pickup']); ?>

  <script>

  $(document).ready(function (e) {
    $("#saveForm").on('submit',(function(e) {
      var kode_pl = $("#kode_pl").val();
            if(kode_pl == 0 ) {
                $("#kode_pl").focus();
                notifError("<p>Kode Packing List tidak boleh kosong!!!</p>");
                return false;
            }

      var plat_truck = $("#plat_truck").val();
            if(plat_truck == 0 ) {
                $("#plat_truck").focus();
                notifError("<p>Plat Truck tidak boleh kosong!!!</p>");
                return false;
            }
      $span = $(".span");
      if($span.text() != ""){
        $('#kode_pl').focus();
        alert('Kode PL tidak boleh sama');
        return false;
      }

      e.preventDefault();
           $.ajax({
              url: "<?=base_url()?>ajax/j_pl.php?func=save",
              type: "POST",
              data:  new FormData(this),
              contentType: false,
              cache: false,
              processData:false,
              success: function(html)
              {
                 var msg = html.split("||");
                 if(msg[0] == "00") {
                    window.location = '<?=base_url()?>?page=penjualan/pl&halaman= PACKING LIST&pesan='+msg[1];
                 } else {
                    notifError(msg[1]);
                 }
              }
           });
    }));
  });

  $('body').delegate("#kode_pelanggan","change", function() {
    var kode_pelanggan   = $("#kode_pelanggan").val();
    var kode_cabang      = $("#kode_cabang").val();
    var kode_gudang      = $("#kode_gudang").val();
      $.ajax({
          type: "POST",
          url: "<?=base_url()?>ajax/j_pl.php?func=loaditem",
          data:"kode_pelanggan="+kode_pelanggan+"&kode_cabang="+kode_cabang+"&kode_gudang="+kode_gudang,
          cache:false,
          success: function(data) {
            $('#detail_input_pl').html(data);
          }
        });
  });

  $('#pickup').on('click', function() {
      $('table tbody tr').each(function() {
        var $tr = $(this);

          if ($tr.find('input[data-id="cb"]').is(':checked')) {

            var kode_so     = ($tr.find("input[data-id='kode_so']").val());
            var kode_sj     = ($tr.find("input[data-id='kode_sj']").val());
            var kode_barang = ($tr.find("input[data-id='kode_barang']").val());
            var nama_barang = ($tr.find("input[data-id='nama_barang']").val());
            var qty_asli    = ($tr.find("input[data-id='qty_asli']").val());
            var qty         = ($tr.find("input[data-id='qty']").val());
            var satuan      = ($tr.find("input[data-id='satuan']").val());

                $.ajax({
                  type: "POST",
                  url: "<?=base_url()?>ajax/j_pl.php?func=loadpickup",
                  data:"kode_so="+kode_so+"&kode_sj="+kode_sj+"&kode_barang="+kode_barang+"&nama_barang="+nama_barang+"&qty="+qty+"&satuan="+satuan,
                  cache:false,
                  success: function(data) {
                    $('#detail_pickup').html(data);
                    $tr.find("input[data-id='cb']").prop('checked', false);
                    $tr.find("input[data-id='qty_asli']").val(qty_asli-qty);
                    $tr.find("input[data-id='qty']").val(qty_asli-qty);
                  }
                });

          }
      });
  });

 $(document).ready(function(){
    $('.pb-load').click(function(){
        var kode_pl     = $("#kode_pl_list").val();

        $.ajax({
               type: "POST",
               url: "<?=base_url()?>ajax/j_pl.php?func=loadlistpl",
               data: "kode_pl="+kode_pl,
               cache: false,
               success:function(data){
                  $('#show-item-barang').html(data);
                  $("#kode_pl_list").val(0).trigger('change');
               }
            });
         });

   });

</script>

<script>
  $(document).ready(function(){
  $('#kode_pl').change(function(){
    $('#pesan').html('<img style="margin-left:1px; width:20px"  src="<?=base_url()?>images/loading.gif">');
    var kode_pl = $(this).val();

    $.ajax({
      type  : 'POST',
      url   : '<?=base_url()?>ajax/j_validasi.php?func=loadkodepl',
      data  : 'kode_pl='+kode_pl,
      success : function(data){
        $('#pesan').html(data);
      }
    })

  });
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

   $("#dlcsv").on('click', function (event) {

      exportTableToCSV.apply(this, [$('#packing_list'), 'packingList.csv']);

      // IF CSV, don't do event.preventDefault() or return false
      // We actually need this to be a typical hyperlink
   });

   });

</script>
<!---------------------------------------END-------------------------------------------->

<script src="<?=base_url()?>assets/select2/select2.js"></script>
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

<script>
  $(".select2").select2()({
      width: '100%'
  });
</script>


