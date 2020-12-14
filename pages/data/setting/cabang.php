<?php
include "pages/data/script/m_cabang.php";
?>

<section class="content-header">
    <ol class="breadcrumb">
        <li><i class="fa fa-cog"></i> Setting</a></li>
        <li>Cabang</a></li>
    </ol>
</section>
<!-- /.row -->
<div class="box box-info">
    <div class="box-body">

        <!-- INFO BANNER FORM SAAT INPUT DAN UPDATE -->
        <?php
        if (isset($_GET['inputsukses'])) {
            echo '<div class="alert alert-success"><i class="icon fa fa-check"></i> INPUT DATA BERHASIL</div>';
        } else if (isset($_GET['updatesukses'])) {
            echo '<div class="alert alert-info"><i class="icon fa fa-check"></i> UPDATE DATA BERHASIL</div>';
        }
        ?>

        <div class="tabbable">
            <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
                <li <?= $class_form ?>>
                    <a data-toggle="tab" href="#menuFormPp">Form Cabang</a>
                </li>
                <li <?= $class_tab ?>>
                    <a data-toggle="tab" href="#menuListPp">List Cabang</a>
                </li>

            </ul>


            <div class="row">
                <div class="tab-content">
                    <div id="menuFormPp" <?= $class_pane_form ?>>
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="form-horizontal">

                                        <form action="" method="post">
                                            <?php
                                            if (isset($_GET['action']) and $_GET['action'] == "edit") {
                                                $row = mysql_fetch_array($q_edit_cab);
                                            }
                                            ?>
                                            <div class="form-group">
                                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode <b style="color: red;">*</b></label>
                                                <div class="col-lg-5">
                                                    <input type="text" required class="form-control" name="kode_cabang" id="kode_cabang" placeholder="Kode cabang..." <?= (isset($row['id_cabang']) ? "readonly" : "") ?> value="<?= (isset($row['id_cabang']) ? $row['kode_cabang'] : "") ?>">
                                                </div>
                                                <span id="pesan" class="span" style="color:#F00; font-weight:bold"></span>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang <b style="color: red;">*</b></label>
                                                <div class="col-lg-10">
                                                    <input type="text" required class="form-control" name="nama" id="nama" placeholder="Cabang..." value="<?= (isset($row['id_cabang']) ? $row['nama'] : "") ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Alamat <b style="color: red;">*</b></label>
                                                <div class="col-lg-10">
                                                    <textarea class="form-control" required name="alamat" id="alamat" placeholder="alamat..."><?= (isset($row['id_cabang']) ? $row['alamat'] : "") ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                                                <div class="col-lg-10">
                                                    <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan..." value="<?= (isset($row['id_cabang']) ? $row['keterangan'] : "") ?>">
                                                </div>
                                            </div>

                                            <label><b style="color: red;">* &nbsp;Wajib Diisi</b></label>


                                            <div align="center" class="form-group">
                                                <button class="btn btn-success <?= (isset($row['id_cabang']) ? "update" : "simpan") ?>" type="submit" name="<?= (isset($row['id_cabang']) ? "update" : "simpan") ?>"><i class="fa fa-pencil"></i> Simpan&nbsp;</button>
                                                <a href="?page=setting/cabang&halaman= CABANG" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>
                                            </div>
                                        </form>

                                        <!-- Tambah Item Proyek       --->

                                    </div>
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel-default -->
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>

                    <div id="menuListPp" <?= $class_pane_tab ?>>
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <form method="post" action="">
                                        <div align="right" class="form-group">
                                            <label class="col-md-4 control-label" style="text-align:right">Status</label>
                                            <div style="text-align: left" class="col-md-3 form-group">
                                                <select class="select2" name="status">
                                                    <option value="semua" <?php if (isset($_POST['cari'])) {
                                                                                if ($_POST['status'] == 'semua') {
                                                                                    echo 'selected';
                                                                                }
                                                                            } ?>>semua</option>
                                                    <option value="y" <?php if (isset($_POST['cari'])) {
                                                                            if ($_POST['status'] == 'y') {
                                                                                echo 'selected';
                                                                            }
                                                                        } ?>>aktif</option>
                                                    <option value="n" <?php if (isset($_POST['cari'])) {
                                                                            if ($_POST['status'] == 'n') {
                                                                                echo 'selected';
                                                                            }
                                                                        } ?>>nonaktif</option>
                                                </select>
                                            </div>

                                            <div align="left" class="form-group">
                                                <input type="submit" class="btn btn-primary btn-sm" name="cari" value="Cari">
                                            </div>
                                        </div>
                                    </form>

                                    <div class="box-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center">No</th>
                                                    <th style="text-align: center">Kode Cabang</th>
                                                    <th style="text-align: center">Cabang</th>
                                                    <th style="text-align: center">Alamat</th>
                                                    <th style="text-align: center">Keterangan</th>
                                                    <th style="text-align: center">Aktif</th>
                                                    <th style="text-align: center">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php $no = 1;
                                                while ($res = mysql_fetch_array($q_cab)) {; ?>
                                                    <tr>
                                                        <td style="text-align: center"><?= $no++ ?></td>
                                                        <td><a href="<?= base_url() ?>?page=setting/cabang_track&action=track&halaman= TRACK CABANG&id_cabang=<?= $res['id_cabang'] ?>"><?= $res['kode_cabang'] ?></a></td>
                                                        <td><?= $res['nama'] ?></td>
                                                        <td><?= $res['alamat'] ?></td>
                                                        <td><?= $res['keterangan'] ?></td>
                                                        <td style="text-align:center"><?= ($res['aktif'] == '1' ? '<span class="btn-sm btn-success fa fa-check"></span>' : '<span class="btn-sm btn-danger fa fa-remove"></span>') ?></td>
                                                        <td style="text-align:center">
                                                            <a class="btn-sm btn-info" href="<?= base_url() ?>?page=setting/cabang&halaman= EDIT CABANG&action=edit&id_cabang=<?= $res['id_cabang'] ?>" style="font-style:italic;"><i class="fa fa-edit"></i></a>

                                                            <?php if ($res['aktif'] == '1') { ?>
                                                                <a class="btn-sm btn-danger" href="<?= base_url() ?>?page=setting/cabang&action=nonaktif&id_cabang=<?= $res['id_cabang'] ?>" onclick="return confirm('Anda yakin menonaktifkan data ini?')"><i class="fa fa-remove"></i></a>
                                                            <?php } else { ?>
                                                                <a class="btn-sm btn-success" href="<?= base_url() ?>?page=setting/cabang&action=aktif&id_cabang=<?= $res['id_cabang'] ?>"><i class="fa fa-check"></i></a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel-default -->
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                </div>
            </div>
            <!-- /.row -->

            <script src="<?= base_url() ?>assets/select2/select2.js"></script>
            <script>
                $(".select2").select2({
                    width: '100%'
                });
            </script>
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
                $(document).ready(function() {
                    $('#kode_cabang').on('keypress', function($e) {
                        var kode_cabang = $(this).val();
                        $(this).val(kode_cabang.toUpperCase());
                        if (kode_cabang.length >= 3) {
                            $e.preventDefault();
                        }
                    }).change(function($e) {
                        $('#pesan').html('<img style="margin-left:1px; width:20px"  src="<?= base_url() ?>images/loading.gif">');
                        var kode_cabang = $(this).val();

                        $.ajax({
                            type: 'POST',
                            url: '<?= base_url() ?>ajax/j_validasi.php?func=loadkodecabang',
                            data: 'kode_cabang=' + kode_cabang,
                            success: function(data) {
                                $('#pesan').html(data);
                            }
                        })

                    });
                });
            </script>

            <script type="text/javascript">
                $(document).ready(function() {
                    $('.simpan').click(function() {

                        $span = $(".span");

                        if ($('#kode_cabang').val() == '') {
                            alert("Kode Cabang tidak Boleh Kosong");
                            $('#kode_cabang').focus();
                            return false;
                        }

                        if ($('#kode_cabang').val().length < 3) {
                            alert("Kode Cabang harus tiga karakter");
                            $('#kode_cabang').focus();
                            return false;
                        }

                        if ($span.text() != "") {
                            $('#kode_cabang').focus();
                            return false;
                        }

                    });
                });
            </script>