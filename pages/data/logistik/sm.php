<?php
include "pages/data/script/sm_script.php";
include "library/form_akses.php";
?>

<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-folder-open"></i> Logistik</a></li>
        <li><a href="#">Stok Masuk</a></li>
    </ol>
</section>

<!-- /.row -->
<div class="box box-info">
    <div class="box-body">

        <?php if (isset($_GET['pesan'])) { ?>
            <div class="form-group" id="form_report">
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Kode SM : <a href="<?= base_url() ?>?page=logistik/sm_track&action=track&kode_sm=<?= $_GET['pesan'] ?>&halaman= TRACK STOK MASUK" target="_blank"><?= $_GET['pesan'] ?></a> Berhasil Di posting
                </div>
            </div>
        <?php  }  ?>

        <div class="tabbable">
            <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
                <li <?= $class_form ?>>
                    <a data-toggle="tab" href="#menuFormSm">Form Stok Masuk</a>
                </li>
                <li <?= $class_tab ?>>
                    <a data-toggle="tab" href="#menuListSm">List Stok Masuk</a>
                </li>
            </ul>

            <div class="row">
                <div class="tab-content">

                    <div id="menuFormSm" <?= $class_pane_form ?>>
                        <div class="col-lg-12">
                            <div id="form_detail" class="panel panel-default">
                                <div class="panel-body">
                                    <div class="form-horizontal">
                                        <?php $id_form = buatkodeform("kode_form"); ?>

                                        <form role="form" method="post" action="" id="saveForm">

                                            <?php $idtem = "INSERT INTO form_id SET kode_form ='" . $id_form . "' ";
                                            mysql_query($idtem); ?>
                                            <input type="hidden" name="id_form" id="id_form" value="<?php echo $id_form; ?>" />

                                            <div class="form-group">
                                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode SM</label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control" name="kode_sm" id="kode_sm" placeholder="Auto..." readonly value="">
                                                </div>

                                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control" name="ref" id="ref" placeholder="ref..." value="" autocomplete="off" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="text-align:left" class="col-lg-2 col-sm-2 control-label">Tanggal SM</label>
                                                <div class="col-lg-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control date-picker-close" value="<?= date("m/d/Y") ?>" id="tgl_buat" name="tgl_buat" autocomplete="off" readonly />
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar bigger-110"></i>
                                                        </span>
                                                    </div>
                                                </div>

                                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
                                                <div class="col-lg-4">
                                                    <select id="kode_cabang" name="kode_cabang" class="select2">
                                                        <option value="0">-- Pilih Cabang --</option>
                                                        <?php
                                                        //CEK JIKA KODE CABANG ADA MAKA SELECTED
                                                        (isset($row['id_op']) ? $kode_cabang = $row['kode_cabang'] : $kode_cabang = '');
                                                        //UNTUK AMBIL CABANGNYA
                                                        while ($rowcabang = mysql_fetch_array($q_cab_aktif)) {; ?>

                                                            <option value="<?php echo $rowcabang['kode_cabang']; ?>" <?php if ($rowcabang['kode_cabang'] == $kode_cabang) {
                                                                                                                            echo 'selected';
                                                                                                                        } ?>><?php echo $rowcabang['nama_cabang']; ?> </option>
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
                                                        //CEK JIKA KODE gudang ADA MAKA SELECTED
                                                        (isset($row['id_op']) ? $kode_gudang = $row['kode_gudang'] : $kode_gudang = '');                                                    //UNTUK AMBIL gudangNYA
                                                        while ($rowgudang = mysql_fetch_array($q_gud_aktif)) {; ?>

                                                            <option value="<?php echo $rowgudang['kode_gudang']; ?>" <?php if ($rowgudang['kode_gudang'] == $kode_gudang) {
                                                                                                                            echo 'selected';
                                                                                                                        } ?>><?php echo $rowgudang['nama_gudang']; ?> </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                                                <div class="col-lg-10">
                                                    <textarea class="form-control" rows="2" name="keterangan_hdr" id="keterangan_hdr" placeholder="Keterangan..."></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-lg-12">
                                                    <div class="pull-left">
                                                        <a class="btn btn-success" id="tambah_sm"><i class="fa fa-plus"></i> Add</a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div style="overflow-x:auto;">
                                                    <table id="" class="" rules="all">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th style="width: 15%">Item</th>
                                                                <th style="width: 8%">Satuan</th>
                                                                <th>Harga rata-rata</th>
                                                                <th style="width: 10%">Qty</th>
                                                                <th>Total Harga</th>
                                                                <th style="width: 15%">COA Debet</th>
                                                                <th style="width: 15%">COA Kredit</th>
                                                                <th>Keterangan</th>
                                                                <th></th>
                                                            </tr>

                                                            <tr id="show_input_sm" style="display:none">
                                                                <td style="text-align: center;">
                                                                    <h5><b>#</b></h5>
                                                                </td>
                                                                <td>
                                                                    <select id="kode_barang" name="kode_barang" class="select2">
                                                                        <option value="0">-- Pilih Barang --</option>
                                                                        <?php
                                                                        while ($rowinv = mysql_fetch_array($q_inv_aktif)) {; ?>
                                                                            <option value="<?php echo $rowinv['kode_inventori'] . ':' . $rowinv['nama_inv']; ?>"><?php echo $rowinv['kode_inventori'] . ' - ' . $rowinv['nama_inv']; ?> </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </td>
                                                                <td id="load_satuan">
                                                                    <input class="form-control" type="text" name="satuan" id="satuan" value="" readonly />
                                                                    <input class="form-control" type="hidden" name="kode_satuan" id="kode_satuan" value="" readonly />
                                                                </td>
                                                                <td id="load_harga">
                                                                    <input style="text-align: right" class="form-control" type="text" name="harga" id="harga" value="" readonly />
                                                                </td>
                                                                <td>
                                                                    <input class="form-control" type="text" name="qty" id="qty" autocomplete="off" value="" />
                                                                </td>
                                                                <td>
                                                                    <input class="form-control" type="text" name="subtot" id="subtot" autocomplete="off" style="text-align: right;" value="" readonly />
                                                                </td>
                                                                <td>
                                                                    <select id="coa_debet" name="coa_debet" class="select2">
                                                                        <option value="0">-- Coa Debet --</option>
                                                                        <?php
                                                                        while ($rowcoadbt = mysql_fetch_array($q_coa_debet)) {; ?>
                                                                            <option value="<?php echo $rowcoadbt['kode_coa'] . ':' . $rowcoadbt['nama_coa']; ?>"><?php echo $rowcoadbt['kode_coa'] . '&nbsp;&nbsp;||&nbsp;&nbsp;' . $rowcoadbt['nama_coa']; ?> </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <!-- <select id="coa_kredit" name="coa_kredit" class="select2">
                                                                        <option value="0">-- Coa Kredit --</option>
                                                                        <?php
                                                                        //while ($rowcoakrdt = mysql_fetch_array($q_coa_kredit)) {; ?>
                                                                            <option value="<?php echo $rowcoakrdt['kode_coa'] . ':' . $rowcoakrdt['nama_coa']; ?>"><?php echo $rowcoakrdt['kode_coa'] . '&nbsp;&nbsp;||&nbsp;&nbsp;' . $rowcoakrdt['nama_coa']; ?> </option>
                                                                        <?php //} ?>
                                                                    </select> -->
                                                                    <select id="coa_kredit" name="coa_kredit" class="select2">
                                                                        <option value="0">-- Coa Kredit --</option>
                                                                        <?php
                                                                        while ($rowcoadbt = mysql_fetch_array($q_coa_kredit)) {; ?>
                                                                            <option value="<?php echo $rowcoadbt['kode_coa'] . ':' . $rowcoadbt['nama_coa']; ?>"><?php echo $rowcoadbt['kode_coa'] . '&nbsp;&nbsp;||&nbsp;&nbsp;' . $rowcoadbt['nama_coa']; ?> </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input class="form-control" type="text" name="ket_dtl" id="ket_dtl" autocomplete="off" value="" />
                                                                </td>
                                                                <td>
                                                                    <button id="ok_input" class="btn btn-xs btn-info ace-icon fa fa-check" title="ok"></button>
                                                                    <a href="" id="batal_input" class="btn btn-xs btn-danger ace-icon fa fa-remove" title="batal"></a>
                                                                </td>
                                                            </tr>

                                                        </thead>
                                                        <tbody id="detail_input_sm">
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
                                                while ($res = mysql_fetch_array($q_akses)) {; ?>
                                                    <?php
                                                    //FORM SURVEY
                                                    if ($res['form'] == 'survey') {
                                                        if ($res['w'] == '1') {
                                                            $list_survey_write = 'y';
                                                    ?>

                                                            <button type="submit" name="simpan" id="simpan" class="btn btn-primary" tabindex="10"><i class="fa fa-check-square-o"></i> Simpan</button>
                                                <?php }
                                                    }
                                                } ?>
                                                            <!-- <button type="submit" name="simpan" id="simpan" class="btn btn-primary" tabindex="10"><i class="fa fa-check-square-o"></i> Simpan</button> -->

                                                <a href="<?= base_url() ?>?page=logistik/sm&halaman= STOK MASUK" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel-default -->
                        </div>
                    </div>

                    <div id="menuListSm" <?= $class_pane_tab ?>>
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <table id="example1" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode SM</th>
                                                <th>Tanggal SM</th>
                                                <th>REF</th>
                                                <th>CABANG</th>
                                                <th>GUDANG</th>
                                                <th>KETERANGAN</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $n = 1;
                                            if (mysql_num_rows($q_sm) > 0) {
                                                while ($data = mysql_fetch_array($q_sm)) {
                                            ?>

                                                    <tr>
                                                        <td style="text-align: center"> <?php echo $n++ ?></td>
                                                        <td>
                                                            <a href="<?= base_url() ?>?page=logistik/sm_track&action=track&kode_sm=<?= $data['kode_sm'] ?>&halaman= TRACK STOK MASUK"> <?php echo $data['kode_sm']; ?>
                                                            </a>
                                                        </td>
                                                        <td> <?php echo date("d-m-Y", strtotime($data['tgl_buat'])); ?></td>
                                                        <td> <?php echo $data['ref']; ?></td>
                                                        <td> <?php echo $data['nama_cabang']; ?></td>
                                                        <td> <?php echo $data['nama_gudang']; ?></td>
                                                        <td> <?php echo $data['keterangan_hdr']; ?></td>
                                                        <td style="text-align: center">
                                                            <a href="<?= base_url() ?>r_cetak_sm.php?kode_sm=<?= $data['kode_sm'] ?>" title="cetak" target="_blank">
                                                                <button type="button" class="btn btn-success btn-xs">
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

                <?php unset($_SESSION['data_sm']); ?>
                <style>
                    .pm-min,
                    .pm-min-s {
                        padding: 3px 1px;
                    }

                    .animated {
                        display: none;
                    }

                    table {
                        border-collapse: collapse;
                        border-spacing: 0;
                        width: 2000px;
                        border: 1px solid #DCDCDC;
                    }

                    th {
                        background: #87CEFA;
                        text-align: center;
                        color: #000000;
                        padding: 8px;
                        font-size: 14px;
                    }

                    td {
                        text-align: left;
                        padding: 8px;
                        font-size: 12px;
                    }

                    tr:nth-child(even) {
                        background-color: #f2f2f2
                    }
                </style>

                <script>
                    $(document).ready(function () {
                        $("[name='harga']").number( true, 2 );
                        $("[name='qty']").number( true, 2 );
                        $("[name='subtot']").number( true, 2 );
                        
                    });
                
                    $(document).ready(function(e) {
                        $("#saveForm").on('submit', (function(e) {
                            var grand_total = parseFloat($("#subtot").val());
                            // console.log(grand_total);
                            if (grand_total == "" || isNaN(grand_total)) {
                                grand_total = 0;
                            }
                            e.preventDefault();
                            if (grand_total != 0) {
                                $(".animated").show();
                                $.ajax({

                                    url: "<?= base_url() ?>ajax/j_sm.php?func=save",
                                    type: "POST",
                                    data: new FormData(this),
                                    contentType: false,
                                    cache: false,
                                    processData: false,
                                    success: function(html) {
                                        var msg = html.split("||");
                                        if (msg[0] == "00") {
                                            window.location = '<?= base_url() ?>?page=logistik/sm&halaman= STOK MASUK&pesan=' + msg[1];
                                        } else {
                                            notifError(msg[1]);
                                        }
                                        $(".animated").hide();
                                    }

                                });
                            } else {
                                notifError("<p>Item  masih kosong.</p>");
                            }
                        }));
                    });

                    $("#tambah_sm").click(function(event) {
                        event.preventDefault();

                        var kode_gudang = $("#kode_gudang").val();
                        var kode_cabang = $("#kode_cabang").val();

                        if (kode_gudang != 0 && kode_cabang != 0) {
                            var status = 'true';
                        } else {
                            var status = 'false';
                        }

                        if (status == 'true') {
                            var tgl_sekarang = $("#tgl_sekarang").val();
                            document.getElementById('show_input_sm').style.display = "table-row";

                            $('#kode_barang').val('0').trigger('change');
                            $('#coa_debet').val('0').trigger('change');
                            $('#coa_kredit').val('0').trigger('change');
                            $('#qty').val('0');
                            $('#satuan').val('');
                            $('#harga').val('0');
                            $('#subtot').val('0');
                            $('#ket_dtl').val('');
                        } else {
                            alert("Peringatan : Harap Pilih Cabang dan Gudang Terlebih Dahulu !!");
                        }
                    });

                    $('#kode_barang').change(function() {
                        var kode_barang = $("#kode_barang").val();

                        $.ajax({
                            type: "POST",
                            url: "<?= base_url() ?>ajax/j_sm.php?func=loadsatuan",
                            data: "kode_barang=" + kode_barang,
                            cache: false,
                            success: function(data) {
                                $('#load_satuan').html(data);
                            }
                        });
                    });

                    $('#kode_barang').change(function() {
                        var kode_barang = $("#kode_barang").val();
                        var kode_cabang = $("#kode_cabang").val();
                        var kode_gudang = $("#kode_gudang").val();

                        $.ajax({
                            type: "POST",
                            url: "<?= base_url() ?>ajax/j_sm.php?func=loadharga",
                            data: "kode_barang=" + kode_barang + "&kode_cabang=" + kode_cabang + "&kode_gudang=" + kode_gudang,
                            cache: false,
                            success: function(data) {
                                $('#load_harga').html(data);
                                numberjs();
                            }
                        });
                        
                        function numberjs(){
                            $("[name='harga']").number( true, 2 );                            
                          }
                    });

                    // saat mengetik qty
                    $(document).on("change paste keyup", "input[name='qty']", function() {
                        var qty = $(this).val() || 0;
                        var harga = $("#harga").val();

                        var total = parseInt(harga * qty);
                        var subtot = parseInt(total);

                        $('[name="subtot"]').val(subtot);
                    });

                    $("#batal_input").click(function(event) {
                        event.preventDefault();
                        document.getElementById('show_input_sm').style.display = "none";
                    });

                    $("#ok_input").click(function(event) {
                        event.preventDefault();
                        var id_form = $("#id_form").val();
                        var kode_barang = $("#kode_barang").val();
                        var kode_satuan = $("#kode_satuan").val();
                        var satuan = $("#satuan").val();
                        var harga = $("#harga").val();
                        var qty = $("#qty").val();
                        var subtot = $("#subtot").val();
                        var coa_debet = $("#coa_debet").val();
                        var coa_kredit = $("#coa_kredit").val();
                        var keterangan_dtl = $("#ket_dtl").val();

                        if (coa_debet != 0 && coa_kredit != 0 && qty != 0) {
                            var status = 'true';
                        } else {
                            var status = 'false';
                        }

                        if (status == 'true') {
                            $.ajax({
                                type: "POST",
                                url: "<?= base_url() ?>ajax/j_sm.php?func=add",
                                data: "kode_barang=" + kode_barang + "&kode_satuan=" + kode_satuan + "&satuan=" + satuan + "&harga=" + harga + "&qty=" + qty + "&subtot=" + subtot + "&coa_debet=" + coa_debet + "&coa_kredit=" + coa_kredit + "&keterangan_dtl=" + keterangan_dtl + "&id_form=" + id_form,
                                cache: false,
                                success: function(data) {
                                    $('#detail_input_sm').html(data);
                                    document.getElementById('show_input_sm').style.display = "none";
                                }
                            });
                        } else {
                            alert("Peringatan : Harap Isi Qty, Coa Debet ,dan Coa Kredit Terlebih Dahulu !!");
                        }
                        return false;
                    });
                </script>

                <script src="<?= base_url() ?>assets/select2/select2.js"></script>
                <script>
                    $(function() {
                        $('#example1').DataTable()
                        $('#example2').DataTable({
                            'paging': true,
                            'lengthChange': false,
                            'searching': false,
                            'ordering': true,
                            'info': true,
                            'autoWidth': false
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
