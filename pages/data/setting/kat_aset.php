<?php include "pages/data/script/m_kat_aset.php";
?>
<section class="content-header">

    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-cog"></i> Setting</a></li>
        <li>
            <a href="#">Kategori Aset</a>

        </li>
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
                    <a data-toggle="tab" href="#menuFormPp">Form Kategori Aset</a>
                </li>
                <li <?= $class_tab1 ?>>
                    <a data-toggle="tab" href="#akunting">Accounting</a>
                </li>
                <li <?= $class_tab ?>>
                    <a data-toggle="tab" href="#menuListPp">List Kategori Aset</a>
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
                                                $row = mysql_fetch_array($q_edit_aset);
                                            }
                                            ?>
                                            <div class="form-group">
                                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode <b style="color: red;">*</b></label>
                                                <div class="col-lg-5">
                                                    <input type="text" required class="form-control" name="kode_kat_aset" id="kode_kat_aset" placeholder="Kode kategori aset..." <?= (isset($row['id_kat_aset']) ? "readonly" : "") ?> value="<?= (isset($row['id_kat_aset']) ? $row['kode_kat_aset'] : "") ?>">
                                                </div>
                                                <span id="pesan" class="span" style="color:#F00; font-weight:bold"></span>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan <b style="color: red;">*</b></label>
                                                <div class="col-lg-5">
                                                    <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan..." value="<?= (isset($row['id_kat_aset']) ? $row['keterangan'] : "") ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Metode <b style="color: red;">*</b></label>
                                                <div class="col-lg-5">

                                                    <select id="metode_penyusutan" name="metode_penyusutan" class="select2">
                                                        <option value="0">-- Pilih Metode --</option>
                                                        <?php
                                                        //CEK JIKA KODE kat_aset ADA MAKA SELECTED
                                                        (isset($row['id_kat_aset']) ? $metode_penyusutan = $row['metode_penyusutan'] : $metode_penyusutan = '');                                                 //UNTUK AMBIL metodenya
                                                        while ($rowmetode = mysql_fetch_array($q_metode_penyusutan)) {; ?>

                                                            <option value="<?php echo $rowmetode['nama']; ?>" <?php if ($rowmetode['nama'] == $metode_penyusutan) {
                                                                                                                        echo 'selected';
                                                                                                                    } ?>><?php echo $rowmetode['nama']; ?> </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Masa Manfaat <b style="color: red;">*</b></label>
                                                <div class="col-lg-5">
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" name="masa_manfaat" id="masa_manfaat" placeholder="Masa Manfaat..." value="<?= (isset($row['id_kat_aset']) ? $masa_manfaat = $row['masa_manfaat'] : $masa_manfaat = '') ?>" pattern="^[0-9]" min="1">
                                                        <span class="input-group-addon">Bulan</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                            /* <div class="form-group">
                         <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Masa Manfaat <b style="color: red;">*</b></label>
                         <div class="col-lg-10">

						<select id="masa_manfaat" name="masa_manfaat" class="select2">
                        <option value="0">-- Pilih Masa --</option>
                           <?php
					 //CEK JIKA KODE kat_aset ADA MAKA SELECTED
					 (isset($row['id_kat_aset']) ? $masa_manfaat=$row['masa_manfaat'] : $masa_manfaat='');	   					 					 					//UNTUK AMBIL masa_manfaat ya
                     while($rowmasa = mysql_fetch_array($q_masa_manfaat)) { ;?>

                        <option value="<?php echo $rowmasa['nama'];?>" <?php if($rowmasa['nama']==$masa_manfaat){echo 'selected';} ?>><?php echo $rowmasa['nama'];?> </option>
                           <?php } ?>
                        </select>
                         </div>
                     </div> */
                                            ?>

                                            <label><b style="color: red;">* &nbsp;Wajib Diisi</b></label>

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

                    <!-- AKUNTING -->
                    <div id="akunting" <?= $class_pane_tab1 ?>>
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Coa Debet <b style="color: red;">*</b></label>
                                            <div class="col-lg-10">
                                                <select id="coa_debet" name="coa_debet" class="select2" style="width: 100%;">
                                                    <option value="0">-- Pilih Coa Debet --</option>
                                                    <?php
                                                    //CEK JIKA KODE coa_debet ADA MAKA SELECTED
                                                    (isset($row['id_kat_aset']) ? $coa_debet = $row['coa_debet'] : $coa_debet = '');                                                 //UNTUK AMBIL coanya
                                                    while ($rowcoadeb = mysql_fetch_array($q_ddl_coa)) {; ?>

                                                        <option value="<?php echo $rowcoadeb['kode_coa']; ?>" <?php if ($rowcoadeb['kode_coa'] == $coa_debet) {
                                                                                                                        echo 'selected';
                                                                                                                    } ?>><?php echo $rowcoadeb['kode_coa'] . '&nbsp;&nbsp||&nbsp;&nbsp;' . $rowcoadeb['nama']; ?> </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Coa Kredit <b style="color: red;">*</b></label>
                                            <div class="col-lg-10">
                                                <select id="coa_kredit" name="coa_kredit" class="select2" style="width: 100%;">
                                                    <option value="0">-- Pilih Coa Kredit --</option>
                                                    <?php
                                                    //CEK JIKA KODE coa_kredit ADA MAKA SELECTED
                                                    (isset($row['id_kat_aset']) ? $coa_kredit = $row['coa_kredit'] : $coa_kredit = '');                                                 //UNTUK AMBIL coanya
                                                    while ($rowcoakred = mysql_fetch_array($q_ddl_coa2)) {; ?>

                                                        <option value="<?php echo $rowcoakred['kode_coa']; ?>" <?php if ($rowcoakred['kode_coa'] == $coa_kredit) {
                                                                                                                        echo 'selected';
                                                                                                                    } ?>><?php echo $rowcoakred['kode_coa'] . '&nbsp;&nbsp||&nbsp;&nbsp;' . $rowcoakred['nama']; ?> </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <label><b style="color: red;">* &nbsp;Wajib Diisi</b></label>

                                        <div align="center" class="form-group">
                                            <button class="btn btn-success <?= (isset($row['id_kat_aset']) ? "update" : "simpan") ?>" type="submit" name="<?= (isset($row['id_kat_aset']) ? "update" : "simpan") ?>"><i class="fa fa-pencil"></i> Simpan&nbsp;</button>
                                            <a href="?page=setting/kat_aset&halaman= KATEGORI ASET" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- END AKUNTING -->

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
                                                    <th style="text-align: center">Kode</th>
                                                    <th style="text-align: center">Keterangan</th>
                                                    <th style="text-align: center">Metode</th>
                                                    <th style="text-align: center">Masa Manfaat</th>
                                                    <th style="text-align: center">Aktif</th>
                                                    <th style="text-align: center">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php $no = 1;
                                                while ($res = mysql_fetch_array($q_aset)) {; ?>
                                                    <tr>
                                                        <td style="text-align: center"><?= $no++ ?></td>
                                                        <td><a href="<?= base_url() ?>?page=setting/kat_aset_track&action=track&halaman= TRACK KATEGORI ASET&id_kat_aset=<?= $res['id_kat_aset'] ?>"><?= $res['kode_kat_aset'] ?></a></td>
                                                        <td><?= $res['keterangan'] ?></td>
                                                        <td><?= $res['metode_penyusutan'] ?></td>
                                                        <td><?= $res['masa_manfaat'] ?></td>
                                                        <td style="text-align: center"><?= ($res['aktif'] == '1' ? '<span class="btn-sm btn-success fa fa-check"></span>' : '<span class="btn-sm btn-danger fa fa-remove"></span>') ?></td>
                                                        <td style="text-align: center"><a class="btn-sm btn-info" href="<?= base_url() ?>?page=setting/kat_aset&action=edit&halaman= EDIT KATEGORI ASET&id_kat_aset=<?= $res['id_kat_aset'] ?>" style="font-style:italic;"><i class="fa fa-edit"></i></a>
                                                            <?php if ($res['aktif'] == '1') { ?>
                                                                <a class="btn-sm btn-danger" href="<?= base_url() ?>?page=setting/kat_aset&action=nonaktif&id_kat_aset=<?= $res['id_kat_aset'] ?>" onclick="return confirm('Anda yakin menonaktifkan data ini?')"><i class="fa fa-remove"></i></a>
                                                            <?php } else { ?>
                                                                <a class="btn-sm btn-success" href="<?= base_url() ?>?page=setting/kat_aset&action=aktif&id_kat_aset=<?= $res['id_kat_aset'] ?>"><i class="fa fa-check"></i></a>
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
                    $('#kode_kat_aset').change(function() {
                        $('#pesan').html('<img style="margin-left:1px; width:20px"  src="<?= base_url() ?>images/loading.gif">');
                        var kode_kat_aset = $(this).val();

                        $.ajax({
                            type: 'POST',
                            url: '<?= base_url() ?>ajax/j_validasi.php?func=loadkodekat_aset',
                            data: 'kode_kat_aset=' + kode_kat_aset,
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

                        if ($('#kode_kat_aset').val() == '') {
                            alert("Kode tidak Boleh Kosong");
                            $('#kode_kat_aset').focus();
                            return false;
                        }

                        if ($('#metode_penyusutan').val() == '0') {
                            alert("Kategori Aset => Metode, belum dipilih");
                            return false;
                        }

                        if ($('#masa_manfaat').val() == '0') {
                            alert("Kategori Aset => Masa Manfaat, belum dipilih");
                            return false;
                        }

                        if ($('#coa_debet').val() == '0') {
                            alert("Accounting => COA Debet, belum dipilih");
                            return false;
                        }

                        if ($('#coa_kredit').val() == '0') {
                            alert("Accounting => COA Kredit, belum dipilih");
                            return false;
                        }

                        if ($span.text() != "") {
                            $('#kode_kat_aset').focus();
                            alert("KODE ASET SUDAH ADA");
                            return false;
                        }

                    });
                });
            </script>
