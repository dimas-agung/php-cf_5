<?php
$pp=0; $penawaran=0; $so=0; $lod=0; $app_p=0; $jmlpp=0;
$conn = mysqli_connect("localhost","root","","cf_baru");
$data = mysqli_query($conn, "SELECT * FROM op_hdr WHERE status='0' ");
$jml = mysqli_num_rows($data);
$total=$jml-11;
?>
<section class="content-header">
    <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> Home</li>
        <li> Dashboard</li>
    </ol>
</section>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Dashboard</h1>
    </div>
</div>

<div class="row">
    <?php
        if($_SESSION['app_level']<>4 AND $_SESSION['app_level']<>3 AND
           $_SESSION['app_level']<>10 AND $_SESSION['app_level']<>12 AND
           $_SESSION['app_level']<>13 AND $_SESSION['app_level']<>9 AND
           $_SESSION['app_level']<>8) {
    ?>

    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3"><i class="fa fa-reorder fa-5x"></i></div>

                    <div class="col-xs-9 text-right">
                        <div class="huge"><?=$total;?></div>
                        <div>Order Pembelian</div>
                    </div>
                </div>
            </div>

            <a href="#">
            <div class="panel-footer">
                <!-- href="<?=base_url()?>?page=pembelian/pp&halaman= PERMINTAAN PEMBELIAN" -->
                <span class="pull-left"><a href="<?=base_url()?>?page=pembelian/pp&halaman= PERMINTAAN PEMBELIAN">View Details</a></span>
                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <?php }; ?>
</div>
