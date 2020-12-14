<?php 
    include "library/form_akses.php"; 
?>

<section class="content-header">
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-shopping-cart"></i> Pembelian</a></li>
          <li><a href="#">Laporan Pembelian</a></li>
        </ol>
</section>

<style>
    .pm-min, .pm-min-s{
        padding:3px 1px; 
    }

    .animated{
        display:none;
    }

    table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #DCDCDC;
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
        font-size: 12px;
    }

    tr:nth-child(even){
        background-color: #f2f2f2
    }
</style>
 
<div class="row">
    <div class="tab-content">
        <div id="menuFormLpb"> 
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-horizontal">
                            <form action="" method="post" enctype="multipart/form-data" id="form-lpb">   
                                          
                                <div class="form-group">
                                    <label class="col-sm-1 control-label" style="text-align:left">Supplier</label>
                                    <div class="col-sm-5">
                                        <select id="supplier" name="supplier" class="select2" style="width: 100%;">
                                            <option value="0">-- Pilih Supplier --</option>
                                            <?php 
                                            $q_supplier = mysql_query(" SELECT kode_supplier,nama AS nama_supplier FROM supplier WHERE aktif='1' ORDER BY kode_supplier ASC");
                                            while($row_supplier = mysql_fetch_array($q_supplier)) { ;?>
                                                 
                                                <option 
                                                    data-kode="<?php echo $row_supplier['kode_supplier'];?>"
                                                    value="<?php echo $row_supplier['kode_supplier'];?>" 
                                                    <?php if($row_supplier['kode_supplier']==$row_supplier){echo 'selected';} ?>><?php echo $row_supplier['nama_supplier'];?> </option>
                                                <?php } ?>
                                                <input type="hidden" name="kode_supplier" id="kode_supplier" class="form-control" value=""/>
                                        </select>
                                    </div>

                                    <label class="col-sm-1 control-label" style="text-align:left">Barang</label>
                                    <div class="col-sm-5">
                                        <select id="barang" name="barang" class="select2" style="width: 100%;">
                                            <option value="0">-- Pilih Barang --</option>
                                            <?php 
                                                $q_barang = mysql_query("SELECT kode_inventori AS kode_barang,nama AS nama_barang FROM inventori WHERE aktif='1'  ORDER BY kode_barang ASC");
                                                while($row_barang = mysql_fetch_array($q_barang)) { 
                                            ;?>
                                                 
                                                <option 
                                                    data-kode="<?php echo $row_barang['kode_barang'];?>"
                                                    value="<?php echo $row_barang['kode_barang'];?>" 
                                                    <?php if($row_barang['kode_barang']==$row_barang){echo 'selected';} ?>><?php echo $row_barang['nama_barang'];?> 
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>  

                                <div class="form-group">
                                    <label class="col-sm-1 control-label" style="text-align:left">Cabang</label>
                                    <div class="col-sm-5">
                                        <select id="cabang" name="cabang" class="select2" style="width: 100%;">
                                            <option value="0">-- Pilih Cabang --</option>
                                            <?php 
                                            $q_cabang = mysql_query(" SELECT kode_cabang,nama AS nama_cabang FROM cabang WHERE aktif='1' ORDER BY kode_cabang ASC");
                                            while($row_cabang = mysql_fetch_array($q_cabang)) { ;?>
                                                 
                                                <option
                                                    data-kode="<?php echo $row_cabang['kode_cabang'];?>"
                                                    value="<?php echo $row_cabang['kode_cabang'];?>" 
                                                    <?php if($row_cabang['kode_cabang']==$row_cabang){echo 'selected';} ?>><?php echo $row_cabang['nama_cabang'];?> </option>
                                                <?php } ?>
                                        </select>
                                    </div>

                                    <label class="col-sm-1 control-label" style="text-align:left">Gudang</label>
                                    <div class="col-sm-5">
                                        <select id="gudang" name="gudang" class="select2" style="width: 100%;">
                                            <option value="0">-- Pilih Gudang --</option>
                                            <?php 
                                            $q_gudang = mysql_query(" SELECT kode_gudang,nama AS nama_gudang FROM gudang WHERE aktif='1' ORDER BY kode_gudang ASC");
                                            while($row_gudang = mysql_fetch_array($q_gudang)) { ;?>
                                                 
                                                <option 
                                                    data-kode="<?php echo $row_gudang['kode_gudang'];?>"
                                                    value="<?php echo $row_gudang['kode_gudang'];?>" 
                                                    <?php if($row_gudang['kode_gudang']==$row_gudang){echo 'selected';} ?>><?php echo $row_gudang['nama_gudang'];?> </option>
                                                <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-1 control-label" style="text-align:left">Tanggal Awal</label>
                                    <div class="col-sm-5">
                                        <div class="input-group">
                                            <input type="text" name="tgl_awal" id="tgl_awal" class="form-control" autocomplete="off" value="<?=date("m/d/Y", strtotime('-30 day'))?>" readonly>
                                            <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                        </div>
                                    </div>

                                    <label class="col-sm-1 control-label" style="text-align:left">Tanggal Akhir</label>
                                    <div class="col-sm-5">
                                        <div class="input-group">
                                            <input type="text" name="tgl_akhir" id="tgl_akhir" class="form-control" autocomplete="off" value="<?=date("m/d/Y")?>" readonly>
                                            <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <br>
                                 
                            <div class="form-group col-md-12" style="text-align: center">
                    
                                    <?php 
                                    $list_survey_write = 'n';
                                    while($res = mysql_fetch_array($q_akses)) {; ?>    
                                      <?php 
                                      //FORM SURVEY
                                      if($res['form']=='survey'){ 
                                        if($res['w']=='1'){
                                             $list_survey_write = 'y';  
                                      ?>  

                                          <button type="button" name="submit" class="btn btn-primary lpb-load" tabindex="10"><i class="fa fa-search" ></i> Cari </button> 
                                    <?php } } } ?>
                            </div>

                            <body>
                                <hr style="width:100%;">
                            </body>

                            <div id="showData">
                              <table  class="table table-bordered table-striped " width="600px">
                                <thead>
                                    <tr>
                                        <th>Supplier</th>
                                        <th colspan="2">Barang</th>
                                        <th>Tgl OP</th>
                                        <th>Kode OP</th>
                                        <th>Tgl BTB</th>
                                        <th>Kode BTB</th>
                                        <th>Tgl FB</th>
                                        <th>Kode FB</th>
                                        <th>Sat</th>
                                        <th>Jumlah</th>
                                        <th>Harga Sat</th>
                                        <th>Diskon</th>
                                        <th>Nominal</th>
                                    </tr>
                                </thead>
                                <tbody id="show-item-barang"></tbody>
                            </table>
                        </div>  

                        </div>                    
                    </div>
                </div>   
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

$(document).ready(function(){
    $('.lpb-load').click(function(){

        if ($('#supplier').val()=='0')
        {
        alert("Supplier belum dipilih");
        return false;
        }

        if ($('#barang').val()=='0')
        {
        alert("Barang belum dipilih");
        return false;
        }

        if ($('#cabang').val()=='0')
        {
        alert("Cabang belum dipilih");
        return false;
        }

        if ($('#gudang').val()=='0')
        {
        alert("Gudang belum dipilih");
        return false;
        }

		var value	= $(this).attr('data'); 
		data        = $("#form-lpb").serialize();
		$(".animated").show();
		$.ajax({
			type: "POST",
			url: '<?php echo base_url();?>ajax/j_lpb.php?func=lpb-load',
			data: data,
			cache: false,
			success:function(data){
				$('#showData').html(data).show();
				$(".animated").hide();
			}
		});
	});
	
});
</script>

<script src="<?=base_url()?>assets/select2/select2.js"></script>
<script>
$(document).ready(function(){
  $(function () {
    $('#example1').DataTable({
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
</script>

<script>
    $("#tgl_awal").datepicker();
    $("#tgl_akhir").datepicker();
</script>

<script>
  $(".select2").select2()({
      width: '100%'
  });
</script>

