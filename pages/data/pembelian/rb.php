<?php
    include "pages/data/script/rb.php";
    include "library/form_akses.php";
?>

<section class="content-header">
        <ol class="breadcrumb">
          <li><i class="fa fa-shopping-cart"></i> Pembelian</li>
          <li>Nota Retur Pembelian</li>
        </ol>
</section>

<!-- /.row -->
<div class="box box-info">
<div class="box-body">

            <?php if (isset($_GET['pesan'])){ ?>
                <div class="form-group" id="form_report">
                  <div class="alert alert-success alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      Kode RB :  <a href="<?=base_url()?>?page=pembelian/rb_track&action=track&halaman= TRACK NOTA RETUR PEMBELIAN&kode_rb=<?=$_GET['pesan']?>" target="_blank"><?=$_GET['pesan'] ?></a>  Berhasil Di posting
                  </div>
                </div>
            <?php  }else if (isset($_GET['pembatalan'])){ ?>
                <div class="form-group" id="form_report">
                  <div class="alert alert-dismissable" style="background-color: #9c0303cc; color: #f9e6c3">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color: #f9e6c3">&times;</button>
                    Pembatalan Kode RB :  <a style="color: white" href="<?=base_url()?>?page=pembelian/rb_track&halaman= TRACK NOTA RETUR PEMBELIAN&action=track&kode_rb=<?=$_GET['pembatalan']?>" target="_blank"><?=$_GET['pembatalan'] ?></a>  Berhasil Di batalkan
                  </div>
                </div>
            <?php } ?>

    <div class="tabbable">
        <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
            <li <?=$class_form?>>
                <a data-toggle="tab" href="#menuFormRb">Form Nota Retur Pembelian</a>
            </li>
            <li <?=$class_tab?>>
                <a data-toggle="tab" href="#menuListRb">List Nota Retur Pembelian</a>
            </li>
        </ul>

    <div class="row">
        <div class="tab-content">

            <div id="menuFormRb" <?=$class_pane_form?>>
                <div class="col-lg-12">
                    <div id="form_detail" class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-horizontal">
                                 <?php $id_form = buatkodeform("kode_form"); ?>

                                <form role="form" method="post" action="" id="saveForm">

                                    <?php   $idtem = "INSERT INTO form_id SET kode_form ='".$id_form."' ";
                                    mysql_query($idtem); ?>
                                    <input type="hidden" name="id_form" id="id_form" value="<?php echo $id_form; ?>"/>

                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode RB</label>
                                            <div class="col-lg-4">
                                                <input type="text" class="form-control" name="kode_rb" id="kode_rb" placeholder="Auto..." readonly value="">
                                            </div>

                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
                                            <div class="col-lg-4">
                                                <input type="text" class="form-control" name="ref" id="ref" placeholder="ref..." value="" autocomplete="off" />
                                            </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="text-align:left" class="col-lg-2 col-sm-2 control-label">Tanggal RB</label>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                <input type="text" class="form-control date-picker-close" value="<?=date("m/d/Y")?>" id="tgl_buat" name="tgl_buat"  autocomplete="off" readonly/>
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar bigger-110"></i>
                                                </span>
                                                <input type="hidden" name="tgl_sekarang" id="tgl_sekarang" class="form-control" value="<?=date("d/m/Y")?>"/>
                                            </div>
                                        </div>

                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
                                        <div class="col-lg-4">
                                            <select id="kode_cabang" name="kode_cabang" class="select2">
                                                <option value="0">-- Pilih Cabang --</option>
                                                   <?php
                                                    //CEK JIKA KODE CABANG ADA MAKA SELECTED
                                                    (isset($row['id_op']) ? $kode_cabang=$row['kode_cabang'] : $kode_cabang='');
                                                    //UNTUK AMBIL CABANGNYA
                                                    while($rowcabang = mysql_fetch_array($q_cab_aktif)) { ;?>

                                                <option value="<?php echo $rowcabang['kode_cabang'];?>" <?php if($rowcabang['kode_cabang']==$kode_cabang){echo 'selected';} ?>><?php echo $rowcabang['nama_cabang'];?> </option>
                                                    <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Gudang</label>
                                        <div class="col-lg-4">
                                            <select id="kode_gudang" name="kode_gudang" class="select2">
                                                <option value="0">-- Pilih Gudang --</option>
                                                    <?php
                                                    //CEK JIKA KODE GUDANG ADA MAKA SELECTED
                                                    (isset($row['id_op']) ? $kode_gudang=$row['kode_gudang'] : $kode_gudang='');                                                    //UNTUK AMBIL GUDANG
                                                    while($rowgudang = mysql_fetch_array($q_gud_aktif)) { ;?>

                                                <option value="<?php echo $rowgudang['kode_gudang'];?>" <?php if($rowgudang['kode_gudang']==$kode_gudang){echo 'selected';} ?>><?php echo $rowgudang['nama_gudang'];?> </option>
                                                    <?php } ?>
                                            </select>
                                        </div>

                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Supplier</label>
                                        <div class="col-lg-4">
                                            <select id="kode_supplier" name="kode_supplier" class="select2">
                                                <option value="0">-- Pilih Supplier --</option>
                                                    <?php
                                                    //CEK JIKA KODE supplier ADA MAKA SELECTED
                                                    (isset($row['id_op']) ? $kode_supplier=$row['kode_supplier'] : $kode_supplier='');                                                    //UNTUK AMBIL supplierNYA
                                                    while($rowsupplier = mysql_fetch_array($q_sup_aktif)) { ;?>

                                                <option
                                                    data-ppn = "<?php echo $rowsupplier['ppn'];?>"
                                                    value="<?php echo $rowsupplier['kode_supplier'];?>" <?php if($rowsupplier['kode_supplier']==$kode_supplier){echo 'selected';} ?>><?php echo $rowsupplier['kode_supplier'] . ' - '. $rowsupplier['nama_supplier'];?>
                                                </option>
                                                    <?php } ?>
                                            </select>
                                        </div>
                                    </div>
									
									<div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode Faktur Beli</label>
                                        <div class="col-lg-4" id="load_fb">
                                            <select id="kode_fb" name="kode_fb" class="select2" disabled>
                                                <option value="0">-- Pilih Kode FB --</option>
                                            </select>
                                        </div>

                                    </div>
									
									

                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                                        <div class="col-lg-10">
                                            <textarea  class="form-control" rows="2" name="keterangan_hdr" id="keterangan_hdr" placeholder="Keterangan..."></textarea>
                                        <input type="hidden" name="id_um" id="id_um" value="1"/></div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-12" >
                                            <table id="" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Item</th>
                                                        <th>Qty</th>
                                                        <th>@Harga</th>
                                                        <th>Total Harga</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="detail_input_rb">
                                                    <tr>
                                                         <td colspan="6" class="text-center"> Tidak ada item barang. </td>
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

                                              <button type="submit" name="simpan" id="simpan" class="btn btn-primary" tabindex="10"><i class="fa fa-check-square-o"></i> Simpan</button>
                                          <?php } } } ?>

                                              <a href="<?=base_url()?>?page=pembelian/rb&halaman= NOTA RETUR PEMBELIAN" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>
                                    </div>

                                </form>

                            </div>
                        </div>

                        <div id="price_detail" class="col-lg-2 col-sm-2">

                        </div>

                    <!-- /.panel-body -->
                    </div>
                <!-- /.panel-default -->
                </div>
            </div>

            <div id="menuListRb" <?=$class_pane_tab?>>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table id="" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode RB</th>
                                        <th>Tanggal RB</th>
                                        <th>Ref</th>
                                        <th>Cabang</th>
                                        <th>Gudang</th>
                                        <th>Pelanggan</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $n=1; if(mysql_num_rows($q_rb) > 0) {
                                        while($data = mysql_fetch_array($q_rb)) {

                                        if($data['status'] == '1'){
                                                        $status = 'Open';
                                                        $warna = 'style="background-color: #39b13940"';
                                                    }elseif($data['status'] == '2'){
                                                        $status = 'Batal';
                                                        $warna = 'style="background-color: #de4b4b63;"';
                                                    }else{
                                                        $status = 'Close';
                                                        $warna = 'style="background-color: #ffd10045;"';
                                                    }
                                    ?>

                                    <tr <?= $warna?>>
                                        <td style="text-align: center"> <?php echo $n++ ?></td>
                                        <td>
                                            <a href="<?=base_url()?>?page=pembelian/rb_track&action=track&halaman= TRACK NOTA RETUR PEMBELIAN&kode_rb=<?=$data['kode_rb']?>" target="_blank"> <?php echo $data['kode_rb'];?>
                                            </a>
                                        </td>
                                        <td> <?php echo date("d-m-Y",strtotime($data['tgl_buat']));?></td>
                                        <td> <?php echo $data['ref'];?></td>
                                        <td> <?php echo $data['nama_cabang'];?></td>
                                        <td> <?php echo $data['nama_gudang'];?></td>
                                        <td> <?php echo $data['nama_supplier'];?></td>
                                        <td> <?php echo $data['keterangan_hdr'];?></td>
                                        <td style="text-align: center;"> <?php echo $status ?></td>
                                        <td style="text-align: center">
                                            <a href="<?=base_url()?>r_cetak_rb.php?kode_rb=<?=$data['kode_rb']?>" title="cetak" target="_blank">
                                                <button type="button" class="btn btn-success btn-sm">
                                                    <span class="glyphicon glyphicon-print"></span>
                                                </button>
                                            </a>
                                        </td>
                                    </tr>

                                    <?php
                                            }
                                        }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel-default -->
                </div>
                <!-- /.col-lg-12 -->
            </div>

        </div>


    <!-- /.row -->
    <!-- Tambah Item Infrastructure       --->

    <!-- DAFTAR BARANG --->
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a><center><b>DAFTAR FB BERDASARKAN KODE BARANG</b></center></a>
        <a id="list_his_harga"></a>
		<div class="row">
			<div class="col-md-6 col-lg-6 col-xs-12 col-md-offset-2 col-lg-offset-2 ">
				<a href="#" id="notareturpembelian" class="btn btn-sm btn-success fa fa-download"> Download CSV</a>
			</div>
		</div>
    </div>
    <!-- /.DAFTAR BARANG --->

<?php unset($_SESSION['data_rb']); ?>

<script>
    function openNav() {
      document.getElementById("mySidenav").style.width = "350px";
      document.getElementById("main").style.width = "100%";
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
            url: "<?=base_url()?>ajax/j_rb.php?func=loadhistory",
            data: "kode_inventori="+kode_inventori,
            cache:false,
            success: function(data) {
                $('#list_his_harga').html(data);
            }
        });
    });
</script>

<script>
    $(document).ready(function (e) {
        $("#saveForm").on('submit',(function(e) {
            var grand_total = parseFloat($("#grandtotal").val());
            if(grand_total == "" || isNaN(grand_total)) {grand_total = 0;}

            var kode_gudang = $("#kode_gudang").val();
                if(kode_gudang == 0 ) {
                    $("#kode_gudang").focus();
                    notifError("<p>Gudang tidak boleh kosong!!!</p>");
                    return false;
                }

            e.preventDefault();
            if(grand_total != 0) {
                $(".animated").show();
                $.ajax({

                    url: "<?=base_url()?>ajax/j_rb.php?func=save",
                    type: "POST",
                    data:  new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(html)
                    {
                        var msg = html.split("||");
                        if(msg[0] == "00") {
                            window.location = '<?=base_url()?>?page=pembelian/rb&halaman= NOTA RETUR PEMBELIAN&pesan='+msg[1];
                        } else {
                            notifError(msg[1]);
                        }
                        $(".animated").hide();
                    }

               });
            } else {notifError("<p>Item masih kosong.</p>");}
        }));
    });

	$('body').delegate("#kode_cabang, #kode_supplier","change", function() {
		var kode_cabang 		= $("#kode_cabang").val();
		var kode_supplier 		= $("#kode_supplier").val();
        
			$.ajax({
					type: "POST",
					url: "<?=base_url()?>ajax/j_rb.php?func=loadfb",
					data: "kode_supplier="+kode_supplier+"&kode_cabang="+kode_cabang,
					cache:false,
					success: function(data) {
						$('#load_fb').html(data);
						$('#kode_fb').val('0').trigger('change');
						BindSelect2();
					}
				});

			function BindSelect2() {
				$("[name='kode_fb']").select2({
					width: '100%'
				});
			}
	});
	
	$('body').delegate("#kode_gudang, #kode_fb","change", function() {
		var kode_fb 		= $("#kode_fb").val();
		var kode_gudang		= $("#kode_gudang").val();
        
			$.ajax({
					type: "POST",
					url: "<?=base_url()?>ajax/j_rb.php?func=loaditem",
					data: "kode_fb="+kode_fb+"&kode_gudang="+kode_gudang,
					cache:false,
					success: function(data) {
						$('#detail_input_rb').html(data);
						numberjs();
					}
				});
			
			function numberjs() {
				$("[name='qty_retur[]']").number( true, 2 );
				$("[name='harga_retur[]']").number( true, 2 );
				$("[name='total_harga_retur[]']").number( true, 2 );
			}
	});
	
	$(document).on('change paste keyup', 'input[name="cb[]"], input[name="qty_retur[]"], input[name="harga_retur[]"], input[name="ket_retur[]"]', function(){
		checkedRetur();
	});
	
	function checkedRetur() {
		var
			$statCB = 0;
		
		$('table tbody tr').each(function ($i, $v) {
			var
				$tr = $(this),
				$dataId = $tr.attr('data-id'),
				$qty = 0,
				$harga = 0,
				$subtotal = 0;
			if ($tr.find('input[name="cb[]"][data-id="' + $dataId + '"]').is(':checked')) {
				$statCB = 1;
				$qty = $tr.find('input[name="qty_retur[]"][data-id="' + $dataId + '"]').val();
				$harga = $tr.find('input[name="harga_retur[]"][data-id="' + $dataId + '"]').val();
				$subtotal = $qty * $harga;
			} else {
				$tr.find('input[name="qty_retur[]"][data-id="' + $dataId + '"]').val(0);
				$statCB = 0;
				$qty = 0;
				$harga = $tr.find('input[name="harga_retur[]"][data-id="' + $dataId + '"]').val($tr.find('input[name="harga_retur[]"][data-id="' + $dataId + '"]').attr('data-value'));
				$subtotal = $qty * $harga;
				$tr.find('input[name="ket_retur[]"][data-id="' + $dataId + '"]').val('');
			}
			$tr.find('input[name="total_harga_retur[]"][data-id="' + $dataId + '"]').val($subtotal);
			$tr.find('input[name="stat_cb[]"][data-id="' + $dataId + '"]').val($statCB);
		})
	}

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

   $("#notareturpembelian").on('click', function (event) {

      exportTableToCSV.apply(this, [$('#notaReturPembelian'), 'notaReturPembelian.csv']);

      // IF CSV, don't do event.preventDefault() or return false
      // We actually need this to be a typical hyperlink
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
        })
    })
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
