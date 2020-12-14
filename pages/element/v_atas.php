<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>
        <?php
        if (isset($_GET['halaman'])) {
            echo $_GET['halaman'];
        } else {
            echo "CAHAYA FAJAR";
        }
        ?>
    </title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url(); ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>datatables/css/bootstrap.min.css" />

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url(); ?>vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url(); ?>dist/css/sb-admin-2.css" rel="stylesheet">
    
    <!-- Morris Charts CSS -->
    <link href="<?php echo base_url(); ?>vendor/morrisjs/morris.css" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>vendor/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>datatables/datatables/lib/css/dataTables.bootstrap.min.css" />

    <!-- Custom Fonts -->
    <link href="<?php echo base_url(); ?>vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- j QUERY -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/ajax-autocomplete.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/ajax2-autocomplete.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/gritter.css" />
    <link href="<?= base_url() ?>assets/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/timepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    

    <script src="<?= base_url() ?>assets/jquery.min.js"></script>

    <link href="<?= base_url() ?>assets/jquery-ui-1.11.4/smoothness/jquery-ui.css" rel="stylesheet" />
    <script src="<?= base_url() ?>assets/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="<?= base_url() ?>assets/jquery-ui-1.11.4/jquery-ui.theme.css">

    <!-- TAMBAHAN CSS SLIDER -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/style_slider_image.css" />

    <script src="<?= base_url() ?>assets/twd_slideshow.js"></script>

    <!-- Bootstrap number js Jquery-->
    <script src="<?=base_url()?>vendor/number_js/jquery.number.min.js"></script>

    <!-- SELECT2 LAWAS -->
    <link href="<?= base_url() ?>assets/select2/select2.css" rel="stylesheet">
    <script src="<?=base_url()?>assets/select2/select2.js"></script>

    <!-- SELECT2  4.0.3--> 
    <!-- <link  href="<?=base_url()?>select2_4.0.3/css/select2.min.css" rel="stylesheet">
    <script src="<?=base_url()?>select2_4.0.3/js/select2.min.js"></script>  -->

    <!-- CSS UNTUK ANIMATION TEXT HEADER -->
    <style type="text/css">
        .content-header {
            animation: tracking-in-expand-fwd 0.8s cubic-bezier(0.215, 0.610, 0.355, 1.000) both;
            color: #337ab7;
            font-size: 13px;
        }

        @keyframes tracking-in-expand-fwd {
            0% {
                letter-spacing: -0.5em;
                transform: translateZ(-700px);
                opacity: 0;
            }

            40% {
                opacity: 0.6;
            }

            100% {
                transform: translateZ(0);
                opacity: 1;
            }
        }
    </style>
    <!-- END CSS UNTUK ANIMATION TEXT HEADER -->

    <!-- CSS UNTUK TABEL DETAIL FORM -->
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

        tr:nth-child(even) {
            background-color: #f2f2f2
        }

        p {
            font-size: 8px;
        }
    </style>
    <!-- END CSS UNTUK TABEL DETAIL FORM -->

    <style>
        body {
            font-family: "Lato", sans-serif;
            transition: background-color .5s;
        }

        .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: white;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }

        .sidenav a {
            padding: 8px 8px 8px 8px;
            text-decoration: none;
            font-size: 14px;
            color: black;
            display: block;
            transition: 0.3s;
        }

        .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 15px;
            font-size: 30px;
            margin-left: 60px;
            color: gray;
        }

        #main {
            transition: margin-left .5s;
            padding: 10px;
            background-image: url("images/wallutama.jpg");
            position: relative;
            background-attachment: fixed;
        }

        @media screen and (max-height: 450px) {
            .sidenav {
                padding-top: 15px;
            }

            .sidenav a {
                font-size: 18px;
            }
        }
    </style>

    <style>
        @media screen and (max-width: 520px) {
            table.responsive {
                width: 100%;
            }

            thead {
                display: none;
            }

            td {
                display: block;
                text-align: right;
                border-right: 1px solid #e1edff;
                font-size: 8px;
            }

            td::before {
                float: left;
                text-transform: uppercase;
                font-weight: bold;
                content: attr(data-header);
                font-size: 8px;
            }
        }

        label {
            font-size: 13px;
        }
    </style>

    <style type="text/css">
        /*---------------------form detail pop animation----------------------------------------------------*/
        #form_detail {
            -webkit-transition: width 1s;
            /*For Safari 3.1 to 6.0 */
            transition: width 1s;
        }

        #form_detail.in {
            -webkit-transition: width 1s;
            /*For Safari 3.1 to 6.0 */
            transition: width 1s;
        }


        /*----------------------price detail pop animation--------------------------------------------------*/
        #price_detail {
            display: none;
            opacity: 0;
            overflow-wrap: break-word;
            width: 0px;
            height: 0px;
        }


        #price_detail.in {
            -webkit-animation: fadein 1s both 1s;
            animation: fadein 1s both 1s;
            position: fixed;
            background-color: #ffffff;
            right: 8%;
            top: 10%;
            height: 100%;
            width: 20%;
            z-index: 1;
            opacity: 1;
            display: block;
            border: 1px solid #ccc;
        }

        @-webkit-keyframes fadein {
            0% {
                opacity: 0;
            }

            100% {
                display: block;
            }
        }

        @keyframes fadein {
            0% {
                opacity: 0;
            }

            100% {
                display: block;
            }
        }

        @-webkit-keyframes fadeout {
            100% {
                opacity: 0;
            }
        }

        @keyframes fadeout {
            100% {
                opacity: 0;
            }
        }

        @-webkit-keyframes fadeinout {

            0%,
            100% {
                opacity: 0;
            }

            50% {
                opacity: 1;
            }
        }

        @keyframes fadeinout {

            0%,
            100% {
                opacity: 0;
            }

            50% {
                opacity: 1;
            }
        }
    </style>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<?php $appUser = isset($_SESSION['app_user']) && !empty($_SESSION['app_user']) ? strtolower($_SESSION['app_user']) : null; ?>
<body class="hold-transition skin-blue layout-top-nav">

    <div id="main" style="min-height: 1000px;">

        <div class="wrapper">

            <header class="main-header">
                <nav class="navbar navbar-static-top" style="background: #c1e5f7; border-radius: 5px;">
                    <div class="container">
                        <div class="navbar-header"><img class="img img-responsive" src="<?php echo base_url(); ?>images/logo_atas.jpeg" width="150px">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                                <i class="fa fa-bars"></i>
                            </button>
                        </div>
                        <?php
                        //$row = mysql_fetch_array($q_akses);
                        ?>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse " id="navbar-collapse">
                            <ul class="nav navbar-nav">

                                <li>&nbsp;</li>

                                <?php
                                //HANYA UNTUK ADMIN DAN SUPER USER
                                if ($_SESSION['app_level'] == '1' or $_SESSION['app_level'] == '11') { ?>
                                    <li><a href="<?php echo base_url(); ?>index.php" style="font-size: 15px"><i class="fa fa-tachometer"></i> Dashboard</a></li>
                                <?php } ?>


                                <?php
                                //HANYA UNTUK ADMIN DAN SUPER USER
                                if ($_SESSION['app_level'] == '1' or $_SESSION['app_level'] == '11' or $_SESSION['app_level'] == '6') { ?>
									<?php if (
											$appUser === 'joni' 
										) { ?>
										<li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="font-size: 15px"><i class="fa fa-database"></i> Master <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="<?= base_url() ?>?page=master/barang&halaman=BARANG">Master Barang</a></li>

                                        </ul>
                                    </li>
										<?php } else { ?>
                                    <!-- ============= SETING ================ -->
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="font-size: 15px"><i class="fa fa-cog"></i> Setting <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="<?= base_url() ?>?page=setting/profil&halaman=PROFIL PERUSAHAAN">Profil Perusahaan</a></li>
                                            <li><a href="<?= base_url() ?>?page=setting/cabang&halaman=CABANG">Cabang</a></li>
                                            <li><a href="<?= base_url() ?>?page=setting/gudang&halaman=GUDANG">Gudang</a></li>
                                            <li class="divider"></li>
                                            <li><a href="<?= base_url() ?>?page=setting/kat_divisi&halaman=KATEGORI DIVISI">Kategori Divisi</a></li>
                                            <li><a href="<?= base_url() ?>?page=setting/kat_coa&halaman=KATEGORI COA">Kategori COA</a></li>
                                            <li><a href="<?= base_url() ?>?page=setting/kat_cashflow&halaman=KATEGORI CASHFLOW">Kategori Cashflow</a></li>
                                            <li><a href="<?= base_url() ?>?page=setting/kat_aset&halaman=KATEGORI ASET">Kategori Aset</a></li>
                                            <li><a href="<?= base_url() ?>?page=setting/kat_inv&halaman=KATEGORI BARANG">Kategori Barang</a></li>
                                            <li><a href="<?= base_url() ?>?page=setting/kat_pel&halaman=KATEGORI PELANGGAN">Kategori Pelanggan</a></li>
                                            <li class="divider"></li>
                                            <li><a href="<?= base_url() ?>?page=setting/tutup_periode&halaman=TUTUP PERIODE">Tutup Periode</a></li>
                                            <li><a href="<?= base_url() ?>?page=user&halaman=USER">Data User</a></li>
                                        </ul>
                                    </li>


                                    <?php //echo $query
                                    ?>

                                    <!-- ============= MASTER ================ -->
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="font-size: 15px"><i class="fa fa-database"></i> Master <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="<?= base_url() ?>?page=master/valas&halaman=VALAS">Master Valas</a></li>
                                            <li><a href="<?= base_url() ?>?page=master/satuan&halaman=SATUAN">Master Satuan</a></li>
                                            <li><a href="<?= base_url() ?>?page=master/barang&halaman=BARANG">Master Barang</a></li>
                                            <li><a href="<?= base_url() ?>?page=master/coa&halaman=COA">Master COA</a></li>
                                            <li class="divider"></li>
                                            <li><a href="<?= base_url() ?>?page=master/pelanggan&halaman=PELANGGAN">Master Pelanggan</a></li>
                                            <li><a href="<?= base_url() ?>?page=master/supplier&halaman=SUPPLIER">Master Supplier</a></li>
                                            <li><a href="<?= base_url() ?>?page=master/karyawan&halaman=KARYAWAN">Master Karyawan</a></li>
                                            <!-- <li class="divider"></li>
                                            <li><a href="<?= base_url() ?>?page=master/aset&halaman=ASET">Master Aset</a></li> -->

                                        </ul>
                                    </li>

                                <?php }} ?>
								<?php
                                //HANYA UNTUK SEMUA ADMIN DAN SUPER USER
                                if ($_SESSION['app_level'] != '3') { ?>
                                <!-- ============= PEMBELIAN ================ -->
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="font-size: 15px"><i class="fa fa-shopping-cart"></i> Pembelian <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
										<?php if (
											$appUser === 'anggi'  ||
											$appUser === 'tya'  ||
											$appUser === 'yuni' 
										) { ?>
                                        <li><a href="<?= base_url() ?>?page=pembelian/op&halaman=ORDER PEMBELIAN">Order Pembelian</a></li>
										<?php } elseif (
											$appUser === 'febri'
										) { ?>
                                        <li><a href="<?= base_url() ?>?page=pembelian/op&halaman=ORDER PEMBELIAN">Order Pembelian</a></li>
                                        <li><a href="<?= base_url() ?>?page=pembelian/kahu&halaman=KARTU HUTANG">Kartu Hutang</a></li>
                                        <li><a href="<?= base_url() ?>?page=pembelian/muhu&halaman=MUTASI HUTANG">Mutasi Hutang</a></li>
                                        <li><a href="<?= base_url() ?>?page=pembelian/umhu&halaman=UMUR HUTANG">Umur Hutang</a></li>
										<?php } else { ?>
                                        <li><a href="<?= base_url() ?>?page=pembelian/op&halaman=ORDER PEMBELIAN">Order Pembelian</a></li>
										<li><a href="<?= base_url() ?>?page=pembelian/kahu&halaman=KARTU HUTANG">Kartu Hutang</a></li>
                                        <li><a href="<?= base_url() ?>?page=pembelian/muhu&halaman=MUTASI HUTANG">Mutasi Hutang</a></li>
                                        <li><a href="<?= base_url() ?>?page=pembelian/umhu&halaman=UMUR HUTANG">Umur Hutang</a></li>
                                        <!-- <li><a href="<?= base_url() ?>?page=pembelian/ops&halaman=ORDER PEMBELIAN ASET">Order Pembelian Aset</a></li> -->
                                        <li><a href="<?= base_url() ?>?page=pembelian/rb&halaman=NOTA RETUR PEMBELIAN">Nota Retur Pembelian</a></li>
                                        <li><a href="<?= base_url() ?>?page=pembelian/lpb&halaman=LAPORAN PEMBELIAN">Laporan Pembelian</a></li>
										<?php } ?>
                                    </ul>
                                </li>
								<?php } ?>

                                <!-- ============= PENJUALAN ================ -->
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="font-size: 15px"><i class="fa fa-tag"></i> Penjualan <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
										<?php if (
											$appUser === 'anggi'  ||											
											$appUser === 'yuni'
										) { ?>
                                        <li><a href="<?= base_url() ?>?page=penjualan/so&halaman=SALES ORDER">Sales Order</a></li>
										<?php } elseif (
											$appUser === 'tya'
										) { ?>
                                        <li><a href="<?= base_url() ?>?page=penjualan/so&halaman=SALES ORDER">Sales Order</a></li>
										<li><a href="<?= base_url() ?>?page=penjualan/kapu&halaman=KARTU PIUTANG">Kartu Piutang</a></li>
                                        <li><a href="<?= base_url() ?>?page=penjualan/mupu&halaman=MUTASI PIUTANG">Mutasi Piutang</a></li>
                                        <li><a href="<?= base_url() ?>?page=penjualan/umpu&halaman=UMUR PIUTANG">Umur Piutang</a></li>
                                        <li><a href="<?= base_url() ?>?page=penjualan/fj&halaman=FAKTUR PENJUALAN">Faktur Penjualan</a></li>
										<?php } elseif (
											$appUser === 'febri'
										) { ?>
                                        <li><a href="<?= base_url() ?>?page=penjualan/so&halaman=SALES ORDER">Sales Order</a></li>
										<li><a href="<?= base_url() ?>?page=penjualan/kapu&halaman=KARTU PIUTANG">Kartu Piutang</a></li>
                                        <li><a href="<?= base_url() ?>?page=penjualan/mupu&halaman=MUTASI PIUTANG">Mutasi Piutang</a></li>
                                        <li><a href="<?= base_url() ?>?page=penjualan/umpu&halaman=UMUR PIUTANG">Umur Piutang</a></li>
                                        <li><a href="<?= base_url() ?>?page=penjualan/pl&halaman=PACKING LIST">Packing List</a></li>
                                        <li><a href="<?= base_url() ?>?page=penjualan/fj&halaman=FAKTUR PENJUALAN">Faktur Penjualan</a></li>
										<?php } elseif (
											$appUser === 'dani' ||
											$appUser === 'kevin' ||
											$appUser === 'ko ali' ||
											$appUser === 'ko de' ||
											$appUser === 'ko iwan' ||
											$appUser === 'nono' 
										) { ?>
                                        <li><a href="<?= base_url() ?>?page=penjualan/so&halaman=SALES ORDER">Sales Order</a></li>
										<li><a href="<?= base_url() ?>?page=penjualan/kapu&halaman=KARTU PIUTANG">Kartu Piutang</a></li>
                                        <li><a href="<?= base_url() ?>?page=penjualan/mupu&halaman=MUTASI PIUTANG">Mutasi Piutang</a></li>
                                        <li><a href="<?= base_url() ?>?page=penjualan/umpu&halaman=UMUR PIUTANG">Umur Piutang</a></li>
										<?php } else { ?>
                                        <li><a href="<?= base_url() ?>?page=penjualan/so&halaman=SALES ORDER">Sales Order</a></li>
										<li><a href="<?= base_url() ?>?page=penjualan/kapu&halaman=KARTU PIUTANG">Kartu Piutang</a></li>
                                        <li><a href="<?= base_url() ?>?page=penjualan/mupu&halaman=MUTASI PIUTANG">Mutasi Piutang</a></li>
                                        <li><a href="<?= base_url() ?>?page=penjualan/umpu&halaman=UMUR PIUTANG">Umur Piutang</a></li>
                                        <li><a href="<?= base_url() ?>?page=penjualan/pl&halaman=PACKING LIST">Packing List</a></li>
                                        <li><a href="<?= base_url() ?>?page=penjualan/fj&halaman=FAKTUR PENJUALAN">Faktur Penjualan</a></li>
                                        <li><a href="<?= base_url() ?>?page=penjualan/rj&halaman=NOTA RETUR PENJUALAN">Nota Retur Penjualan</a></li>
                                        <li><a href="<?= base_url() ?>?page=penjualan/lpj&halaman=LAPORAN PENJUALAN">Laporan Penjualan</a></li>
										<?php } ?>
                                    </ul>
                                </li>

                                <?php
                                //HANYA UNTUK SEMUA ADMIN DAN SUPER USER
                                if ($_SESSION['app_level'] == '3') { ?>
								<!-- ============= LOGISTIK ================ -->
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="font-size: 15px"><i class="fa fa-folder-open"></i> Logistik <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
											<?php if (
												$appUser === 'dani' ||
												$appUser === 'joni' ||
												$appUser === 'ko ali' ||
												$appUser === 'ko de' ||
												$appUser === 'ko iwan'
											) { ?>
                                            <li><a href="<?= base_url() ?>?page=logistik/ks&halaman=KARTU STOK">Kartu Stok</a></li>
											<?php } elseif (
												$appUser === 'lidya'
											) { ?>
                                            <li><a href="<?= base_url() ?>?page=logistik/btb&halaman=BUKTI TERIMA BARANG">Bukti Terima Barang</a></li>
                                            <li><a href="<?= base_url() ?>?page=logistik/sm&halaman=STOK MASUK">Stok Masuk</a></li>
                                            <li><a href="<?= base_url() ?>?page=logistik/sk&halaman=STOK KELUAR">Stok Keluar</a></li>
                                            <li><a href="<?= base_url() ?>?page=logistik/ks&halaman=KARTU STOK">Kartu Stok</a></li>
											<?php } elseif (
												$appUser === 'nono' || 
												$appUser === 'kevin' 
											) { ?>
                                            <li><a href="<?= base_url() ?>?page=logistik/btb&halaman=BUKTI TERIMA BARANG">Bukti Terima Barang</a></li>
											<?php } else {  ?>
                                            <!-- <li><a href="<?= base_url() ?>?page=logistik/bts&halaman=BUKTI TERIMA ASET">Bukti Terima Aset</a></li> -->
											<li><a href="<?= base_url() ?>?page=logistik/btb&halaman=BUKTI TERIMA BARANG">Bukti Terima Barang</a></li>
                                            <li><a href="<?= base_url() ?>?page=logistik/sm&halaman=STOK MASUK">Stok Masuk</a></li>
                                            <li><a href="<?= base_url() ?>?page=logistik/sk&halaman=STOK KELUAR">Stok Keluar</a></li>
                                            <li><a href="<?= base_url() ?>?page=logistik/sj&halaman=SURAT JALAN">Surat Jalan</a></li>
                                            <li class="divider"></li>
                                            <li><a href="<?= base_url() ?>?page=logistik/ks&halaman=KARTU STOK">Kartu Stok</a></li>
                                            <!--  <li class="divider"></li>
                                            <li><a href="<?= base_url() ?>?page=logistik/pm_list&halaman=PERMINTAAN MATERIAL">Permintaan Material</a></li>
                                            <li><a href="<?= base_url() ?>?page=logistik/tg&halaman=TRANSFER GUDANG">Transfer Gudang</a></li> -->
											<?php } ?>
                                        </ul>
                                    </li>
								<?php
								}
                                //HANYA UNTUK SEMUA ADMIN DAN SUPER USER
                                if ($_SESSION['app_level'] == '1' or $_SESSION['app_level'] == '2' or $_SESSION['app_level'] == '6' or $_SESSION['app_level'] == '7' or $_SESSION['app_level'] == '11') { ?>

                                    <!-- ============= LOGISTIK ================ -->
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="font-size: 15px"><i class="fa fa-folder-open"></i> Logistik <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
											<?php if (
												$appUser === 'anggi'  ||
												$appUser === 'febri'  ||
												$appUser === 'tya'  ||
												$appUser === 'yuni' ||
												$appUser === 'dani' ||
												$appUser === 'joni' ||
												$appUser === 'ko ali' ||
												$appUser === 'ko de' ||
												$appUser === 'ko iwan'
											) { ?>
                                            <li><a href="<?= base_url() ?>?page=logistik/ks&halaman=KARTU STOK">Kartu Stok</a></li>
											<?php } elseif (
												$appUser === 'lidya'
											) { ?>
                                            <li><a href="<?= base_url() ?>?page=logistik/btb&halaman=BUKTI TERIMA BARANG">Bukti Terima Barang</a></li>
                                            <li><a href="<?= base_url() ?>?page=logistik/sm&halaman=STOK MASUK">Stok Masuk</a></li>
                                            <li><a href="<?= base_url() ?>?page=logistik/sk&halaman=STOK KELUAR">Stok Keluar</a></li>
                                            <li><a href="<?= base_url() ?>?page=logistik/ks&halaman=KARTU STOK">Kartu Stok</a></li>
											<?php } elseif (
												$appUser === 'kevin' ||
												$appUser === 'nono'
											) { ?>
                                            <li><a href="<?= base_url() ?>?page=logistik/btb&halaman=BUKTI TERIMA BARANG">Bukti Terima Barang</a></li>
                                            <li><a href="<?= base_url() ?>?page=logistik/sm&halaman=STOK MASUK">Stok Masuk</a></li>
                                            <li><a href="<?= base_url() ?>?page=logistik/ks&halaman=KARTU STOK">Kartu Stok</a></li>
											<?php } else {  ?>
                                            <!-- <li><a href="<?= base_url() ?>?page=logistik/bts&halaman=BUKTI TERIMA ASET">Bukti Terima Aset</a></li> -->
											<li><a href="<?= base_url() ?>?page=logistik/btb&halaman=BUKTI TERIMA BARANG">Bukti Terima Barang</a></li>
                                            <li><a href="<?= base_url() ?>?page=logistik/sm&halaman=STOK MASUK">Stok Masuk</a></li>
                                            <li><a href="<?= base_url() ?>?page=logistik/sk&halaman=STOK KELUAR">Stok Keluar</a></li>
                                            <li><a href="<?= base_url() ?>?page=logistik/sj&halaman=SURAT JALAN">Surat Jalan</a></li>
                                            <li class="divider"></li>
                                            <li><a href="<?= base_url() ?>?page=logistik/ks&halaman=KARTU STOK">Kartu Stok</a></li>
                                            <!--  <li class="divider"></li>
                                            <li><a href="<?= base_url() ?>?page=logistik/pm_list&halaman=PERMINTAAN MATERIAL">Permintaan Material</a></li>
                                            <li><a href="<?= base_url() ?>?page=logistik/tg&halaman=TRANSFER GUDANG">Transfer Gudang</a></li> -->
											<?php } ?>
                                        </ul>
                                    </li>

                                    <!-- ============= KEUANGAN ================ -->
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="font-size: 15px"><i class="fa fa-money"></i> Keuangan <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="<?= base_url() ?>?page=keuangan/buku_besar&halaman=BUKU BESAR">Buku Besar</a></li>
                                            <li><a href="<?= base_url() ?>?page=keuangan/bkk&halaman=BUKTI KAS KELUAR">Bukti Kas Keluar</a></li>
                                            <li><a href="<?= base_url() ?>?page=keuangan/bkm&halaman=BUKTI KAS MASUK">Bukti Kas Masuk</a></li>
                                            <!-- <li><a href="<?= base_url() ?>?page=keuangan/daftar_tagihan&halaman=DAFTAR TAGIHAN">Daftar Tagihan</a></li> -->
                                            <li><a href="<?= base_url() ?>?page=keuangan/fb&halaman=FAKTUR PEMBELIAN">Faktur Pembelian</a></li>
                                            <li><a href="<?= base_url() ?>?page=keuangan/jm&halaman=JURNAL MEMORIAL">Jurnal Memorial</a></li>
                                            <li class="divider"></li>
                                            <li><a href="<?= base_url() ?>?page=keuangan/lr&halaman=LABA RUGI">Laba Rugi</a></li>
                                            <!-- <li><a href="<?= base_url() ?>?page=keuangan/lgp&halaman=LAPORAN GROSS PROFIT">Laporan Gross Profit</a></li> -->
                                            <li><a href="<?= base_url() ?>?page=keuangan/nrc&halaman=NERACA">Neraca</a></li>
                                            <li><a href="<?= base_url() ?>?page=keuangan/nrc_percobaan&halaman=NERACA PERCOBAAN">Neraca Percobaan</a></li>
                                            <li class="divider"></li>
                                            <li><a href="<?= base_url() ?>?page=keuangan/nb&halaman=NOTA DEBET">Nota Debet</a></li>
                                            <li><a href="<?= base_url() ?>?page=keuangan/nk&halaman=NOTA KREDIT">Nota Kredit</a></li> 
                                            <li class="divider"></li>
                                            <!-- <li><a href="<?= base_url() ?>?page=keuangan/hg&halaman=HISTORY GIRO">Laporan Pencairan Giro Masuk</a></li>
                                            <li><a href="<?= base_url() ?>?page=keuangan/hg&halaman=HISTORY GIRO">Laporan Giro Masuk (Belum Cair)</a></li> -->
                                            <li><a href="<?= base_url() ?>?page=keuangan/gm&halaman=GIRO MASUK">Giro Masuk</a></li>
                                            <li><a href="<?= base_url() ?>?page=keuangan/gk&halaman=GIRO KELUAR">Giro Keluar</a></li>
                                            <li><a href="<?= base_url() ?>?page=keuangan/pg&halaman=PELUNASAN GIRO">Pelunasan Giro</a></li>
                                            <li><a href="<?= base_url() ?>?page=keuangan/gt&halaman=TOLAKAN GIRO">Tolakan Giro</a></li>
                                            <li><a href="<?= base_url() ?>?page=keuangan/gp&halaman=PENGGANTI GIRO">Pengganti Giro</a></li>
                                        </ul>
                                    </li>

                                    <!-- ============= PRODUKSI ================ --> 
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="font-size: 15px"><i class="fa fa-cubes"></i> Produksi <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="<?= base_url() ?>?page=produksi/spk&halaman=SURAT PERINTAH KERJA">Surat Perintah Kerja</a></li>
                                        </ul>
                                    </li>

                                <?php } ?>

                                <li class="dropdown pull-right">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="font-size: 15px"><i class="fa fa-user"></i> <?= $_SESSION['app_user'] ?> <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?= base_url() ?>?page=ubah_pass&action=edit&kode=<?= $_SESSION['app_id'] ?>"><i class="ace-icon fa fa-user"></i> Ubah Password</a></li>
                                        <li class="divider"></li>
                                        <li><a href="<?= base_url() ?>logout.php"><i class="ace-icon fa fa-power-off"></i> Sign Out</a></li>
                                    </ul>
                                </li>
                            </ul>

                        </div>

                        <!-- /.navbar-collapse -->
                        <!-- /.navbar-custom-menu -->
                    </div>
                    <!-- /.container-fluid -->
                </nav>
            </header>

            <!-- Full Width Column -->
            <div class="content-wrapper">
                <div class="container">
                    <!-- Content Header (Page header) -->
                    <div class="pyro">
                        <div class="before"></div>
                        <div class="after"></div>
                    </div>
