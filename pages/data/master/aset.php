<?php include "pages/data/script/m_aset.php";
?>
<section class="content-header">
    <ol class="breadcrumb">
        <li><i class="fa fa-database"></i>Master</li>
        <li>Aset</li>
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
                    <a data-toggle="tab" href="#menuFormPp">Form Master Aset</a>
                </li>
                <li <?= $class_tab ?>>
                    <a data-toggle="tab" href="#menuListPp">List Master Aset</a>
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
                                                $row = mysql_fetch_array($q_edit_mst_aset);
                                            }
                                            ?>
                                            <div class="form-group">
                                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode <b style="color: red;">*</b></label>
                                                <div class="col-lg-5">
                                                    <input type="text" required class="form-control" name="kode_mst_aset" id="kode_mst_aset" placeholder="Kode Master Aset" <?= (isset($row['id_mst_aset']) ? "readonly" : "") ?> value="<?= (isset($row['id_mst_aset']) ? $row['kode_mst_aset'] : "") ?>">
                                                </div>
                                                <span id="pesan" class="span" style="color:#F00; font-weight:bold"></span>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Nama <b style="color: red;">*</b></label>
                                                <div class="col-lg-5">
                                                    <input type="text" required class="form-control" name="nama_mst_aset" id="nama_mst_aset" placeholder="Nama Master Aset" value="<?= (isset($row['id_mst_aset']) ? $row['nama_mst_aset'] : "") ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Supplier <b style="color: red;">*</b></label>
                                                <div class="col-lg-5">

                                                    <select id="supplier_mst_aset" name="supplier_mst_aset" class="select2">
                                                        <option value="0">-- Supplier --</option>
                                                        <?php
                                                        //CEK JIKA id_mst_aset ADA MAKA SELECTED
                                                        (isset($row['id_mst_aset']) ? $supplier = $row['supplier_mst_aset'] : $supplier = '');                                                 //UNTUK AMBIL supplier
                                                        while ($rowsupplier = mysql_fetch_array($q_supplier)) {; ?>

                                                            <option value="<?php echo $rowsupplier['id_supplier']; ?>" <?php if ($rowsupplier['id_supplier'] == $supplier) {
                                                                                                                                echo 'selected';
                                                                                                                            } ?>><?php echo $rowsupplier['kode_supplier']; ?> </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kategori <b style="color: red;">*</b></label>
                                                <div class="col-lg-5">

                                                    <select id="kat_mst_aset" name="kat_mst_aset" class="select2">
                                                        <option value="0">-- Kategori --</option>
                                                        <?php
                                                        //CEK JIKA id_mst_aset ADA MAKA SELECTED
                                                        (isset($row['id_mst_aset']) ? $kat_aset = $row['kat_mst_aset'] : $kat_aset = '');                                                 //UNTUK AMBIL supplier
                                                        while ($rowkataset = mysql_fetch_array($q_kat_aset)) {; ?>

                                                            <option value="<?php echo $rowkataset['id_kat_aset']; ?>" <?php if ($rowkataset['id_kat_aset'] == $kat_aset) {
                                                                                                                                echo 'selected';
                                                                                                                            } ?>><?php echo $rowkataset['kode_kat_aset']; ?> </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Lokasi <b style="color: red;">*</b></label>
                                                <div class="col-lg-5">
                                                    <input type="text" required class="form-control" name="lokasi_mst_aset" id="lokasi_mst_aset" placeholder="Lokasi Master Aset" value="<?= (isset($row['id_mst_aset']) ? $row['lokasi_mst_aset'] : "") ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Tipe Pembayaran <b style="color: red;">*</b></label>
                                                <div class="col-lg-5">

                                                    <select id="pembayaran_mst_aset" name="pembayaran_mst_aset" class="select2">
                                                        <option value="0">-- Tipe Pembayaran --</option>
                                                        <option value="cash" <?= isset($row['pembayaran_mst_aset']) && strtolower($row['pembayaran_mst_aset']) === 'cash' ? 'selected' : '' ?>>Cash</option>
                                                        <option value="kredit" <?= isset($row['pembayaran_mst_aset']) &&  strtolower($row['pembayaran_mst_aset']) === 'kredit' ? 'selected' : '' ?>>Kredit</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group leasing">
                                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Nama Leasing <b style="color: red;">*</b></label>
                                                <div class="col-lg-5">
                                                    <input type="text" class="form-control" name="leasing_mst_aset" id="leasing_mst_aset" placeholder="Nama Leasing Master Aset" value="<?= (isset($row['id_mst_aset']) ? $row['leasing_mst_aset'] : "") ?>">
                                                </div>
                                            </div>

                                            <div class="form-group leasing">
                                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Masa Leasing <b style="color: red;">*</b></label>
                                                <div class="col-lg-2">
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" name="masa_mst_aset" id="masa_mst_aset" placeholder="Masa Leasing Master Aset" value="<?= (isset($row['id_mst_aset']) ? $row['masa_mst_aset'] : "") ?>" pattern="^[0-9]" min="0">
                                                        <span class="input-group-addon">BULAN</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group leasing">
                                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Bunga Leasing <b style="color: red;">*</b></label>
                                                <div class="col-lg-2">
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" name="bunga_mst_aset" id="bunga_mst_aset" placeholder="Bunga Leasing Master Aset" value="<?= (isset($row['id_mst_aset']) ? $row['bunga_mst_aset'] : "") ?>" pattern="^\d{1,3}$" min="0" max="100" maxlength="3">
                                                        <span class="input-group-addon">%</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <label><b style="color: red;">* &nbsp;Wajib Diisi</b></label>

                                            <div align="center" class="form-group">
                                                <button class="btn btn-success <?= (isset($row['id_mst_aset']) ? "update" : "simpan") ?>" type="submit" name="<?= (isset($row['id_mst_aset']) ? "update" : "simpan") ?>"><i class="fa fa-pencil"></i> Simpan&nbsp;</button>
                                                <a href="?page=master/aset" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>
                                            </div>

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
                                    <div class="box-body">


                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center">No</th>
                                                    <th style="text-align: center">Kode</th>
                                                    <th style="text-align: center">Nama</th>
                                                    <th style="text-align: center">Supplier</th>
                                                    <th style="text-align: center">Kategori</th>
                                                    <th style="text-align: center">Lokasi</th>
                                                    <th style="text-align: center">Tipe</th>
                                                    <th style="text-align: center">Nama Leasing</th>
                                                    <th style="text-align: center">Masa Leasing</th>
                                                    <th style="text-align: center">Bunga Leasing</th>
                                                    <th style="text-align: center">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php $no = 1;
                                                while ($res = mysql_fetch_array($q_mst_aset)) {; ?>
                                                    <tr>
                                                        <td style="text-align: center"><?= $no++ ?></td>
                                                        <td><a href="<?= base_url() ?>?page=master/aset_track&action=track&halaman= TRACK MASTER ASET&id_mst_aset=<?= $res['id_mst_aset'] ?>"><?= $res['kode_mst_aset'] ?></a></td>
                                                        <td><?= $res['nama_mst_aset'] ?></td>
                                                        <td><?= $res['kode_supplier'] ?></td>
                                                        <td><?= $res['kode_kat_aset'] ?></td>
                                                        <td><?= $res['lokasi_mst_aset'] ?></td>
                                                        <td><?= $res['pembayaran_mst_aset'] ?></td>
                                                        <td><?= $res['leasing_mst_aset'] ?></td>
                                                        <td><?= $res['masa_mst_aset'] ?></td>
                                                        <td><?= $res['bunga_mst_aset'] ?></td>
                                                        <td style="text-align: center"><a class="btn-sm btn-info" href="<?= base_url() ?>?page=master/aset&action=edit&halaman= EDIT MASTER ASET&id_mst_aset=<?= $res['id_mst_aset'] ?>" style="font-style:italic;"><i class="fa fa-edit"></i></a>

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
                var
                    $leasing = $('.leasing');
                <?php
                if (isset($_GET['action']) and $_GET['action'] == "edit") {
                    ?>
                    var
                        $pembayaran = ($('#pembayaran_mst_aset') || '');
                    if ($pembayaran.val().toLowerCase() === 'cash') {
                        if (!$leasing.hasClass('hide')) {
                            $leasing.addClass('hide');
                        }
                    }
                <?php
                } else {
                    ?>
                    if (!$leasing.hasClass('hide')) {
                        $leasing.addClass('hide');
                    }
                <?php
                }
                ?>
                $(".select2").select2({
                    width: '100%'
                });
                $('#pembayaran_mst_aset').on('change', function() {
                    var
                        $this = $(this),
                        $val = $this.val();

                    <?php
                    if (isset($_GET['action']) and $_GET['action'] == "edit") {
                        ?>

                    <?php
                    } else {
                        ?>
                        $leasing.find('input').val(null);
                    <?php
                    }
                    ?>
                    if ($val !== '0' || $val !== 0) {
                        $val = $val.toLowerCase();
                        if ($val === 'kredit') {
                            $leasing.removeClass('hide');
                            $leasing.find('input').attr('required', 'required');
                        } else {
                            $leasing.addClass('hide');
                            $leasing.find('input').removeAttr('required');
                        }
                    }
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
                    $('#kode_mst_aset').change(function() {
                        $('#pesan').html('<img style="margin-left:1px; width:20px"  src="<?= base_url() ?>images/loading.gif">');
                        var kode_mst_aset = $(this).val();

                        $.ajax({
                            type: 'POST',
                            url: '<?= base_url() ?>ajax/j_validasi.php?func=loadkodemst_aset',
                            data: 'kode_mst_aset=' + kode_mst_aset,
                            success: function(data) {
                                $('#pesan').html(data);
                            }
                        })

                    });
                });
            </script>
            <script type="text/javascript">
                $(document).ready(function() {

                    $('.simpan, .update').click(function() {

                        $span = $(".span");

                        $pembayaran = ($('#pembayaran_mst_aset') || '');

                        if ($('#kode_mst_aset').val() === '') {
                            alert("Kode tidak Boleh Kosong");
                            $('#kode_mst_aset').focus();
                            return false;
                        }

                        if ($('#nama_mst_aset').val() === '') {
                            alert("Nama tidak Boleh Kosong");
                            $('#nama_mst_aset').focus();
                            return false;
                        }

                        if ($('#supplier_mst_aset').val() === '0' || $('#supplier_mst_aset').val() === 0) {
                            alert("Supplier tidak Boleh Kosong");
                            $('#supplier_mst_aset').focus();
                            return false;
                        }

                        if ($('#kat_mst_aset').val() === '0' || $('#kat_mst_aset').val() === 0) {
                            alert("Kategori tidak Boleh Kosong");
                            $('#kat_mst_aset').focus();
                            return false;
                        }

                        if ($('#lokasi_mst_aset').val() === '') {
                            alert("Lokasi tidak Boleh Kosong");
                            $('#lokasi_mst_aset').focus();
                            return false;
                        }

                        if ($pembayaran.val().toLowerCase() === '0' || $pembayaran.val().toLowerCase() === 0) {
                            alert("Pembayaran tidak Boleh Kosong");
                            $pembayaran.focus();
                            return false;
                        } else if ($pembayaran.val().toLowerCase() === 'kredit') {
                            if ($('#leasing_mst_aset').val() === '') {
                                alert("Nama Leasing tidak Boleh Kosong");
                                $('#leasing_mst_aset').focus();
                                return false;
                            }

                            if ($('#masa_mst_aset').val() === '' || $('#masa_mst_aset').val() === '0' || $('#masa_mst_aset').val() === 0) {
                                alert("Masa Leasing tidak Boleh Kosong");
                                $('#masa_mst_aset').focus();
                                return false;
                            }

                            if ($('#bunga_mst_aset').val() === '' || $('#bunga_mst_aset').val() === '0' || $('#bunga_mst_aset').val() === 0) {
                                alert("Bunga Leasing tidak Boleh Kosong");
                                $('#bunga_mst_aset').focus();
                                return false;
                            }
                        }

                        if ($span.text() !== '') {
                            $('#kode_kat_aset').focus();
                            alert("KODE ASET SUDAH ADA");
                            return false;
                        }

                    });
                });
            </script>
