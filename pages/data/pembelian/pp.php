<?php
    include "pages/data/script/pp.php";
	include "library/form_akses.php";
?>

<section class="content-header">
        <ol class="breadcrumb">
          <li><i class="fa fa-shopping-cart"></i> Pembelian</a></li>
          <li>Order Pembelian</a></li>
        </ol>
</section>

<!-- /.row -->
<div class="box box-info">
<div class="box-body">

            <?php if (isset($_GET['pesan'])){ ?>
				<div class="form-group" id="form_report">
				  <div class="alert alert-success alert-dismissable">
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					  <a><?=$_GET['pesan'] ?></a>
				  </div>
				</div>
			<?php  } else if (isset($_GET['pembatalan'])){ ?>
                <div class="form-group" id="form_report">
                  <div class="alert alert-dismissable" style="background-color: #9c0303cc; color: #f9e6c3">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color: #f9e6c3">&times;</button>
                      Pembatalan Kode OP :  <a style="color: white" href="<?=base_url()?>?page=pembelian/pp&halaman=PERMINTAAN PEMBELIAN" target="_blank"><?=$_GET['kode_op'] ?></a>  <?=$_GET['pembatalan']?>
                  </div>
                </div>
            <?php } ?>

    <div class="tabbable">
		<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
            <li class="active">
				<a data-toggle="tab" href="#menuListPp">List Order Pembelian</a>
			</li>
        </ul>


	<div class="row">
		<div class="tab-content">
			<div id="menuListPp">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<table id="example1" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
                                        <th style="width: 5%">No</th>
                                        <th>Kode OP</th>
                                        <th>Supplier</th>
                                        <th>Tanggal</th>
                                        <th>User</th>
									</tr>
								</thead>
								<tbody>
									<?php
									    $n=1;

                                        if(mysql_num_rows($q_app_op) > 0) {
										while($data = mysql_fetch_array($q_app_op)) {
									?>

									<tr>
                                        <td style="text-align: center"> <?php echo $n++ ?></td>
										<td>
                                            <a href="<?=base_url()?>?page=approval/pp_form&halaman= PERMINTAAN PEMBELIAN&action=approval&kode_op=<?=$data['kode_op']?>"> <?php echo $data['kode_op'];?>
                                        </td>
										<td><?= $data['kode_supplier'].'&nbsp;&nbsp; || &nbsp;&nbsp;'.$data['nama_supplier'] ?></td>
                                        <td><?= date("d-m-Y",strtotime($data['tgl_buat']));?></td>
										<td style="text-align: center;"><?= $data['nm_user'] ?></td>
                                    </tr>

									<?php }

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
	</div>

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
    $(".select2").select2({
        width: '100%'
    });
</script>
