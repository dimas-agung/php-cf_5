<?php    
   include "library/form_akses.php";
?>
<section class="content-header">
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-money"></i>Penjualan</a></li>
          <li>
            <a href="#">Kartu Piutang</a>
          </li>
        </ol>
</section>

<div class="row">
    <div class="tab-content">
        <div id="menuFormKs"> 
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-horizontal">
                            <form action="" method="post" enctype="multipart/form-data" id="form-kapu">   
                                          
                                <div class="form-group">
                                    <label class="col-sm-1 control-label" style="text-align:left">Pelanggan</label>
                                    <div class="col-sm-11">
                                        <select id="pelanggan" name="pelanggan" class="select2" style="width: 100%;">
                                            <option value="0">-- Pilih Pelanggan --</option>
                                            <?php 
                                                $q_sup = mysql_query("SELECT `kode_pelanggan`, `nama` FROM `pelanggan` WHERE `aktif` = '1' " . searchKodeSales() . " ORDER BY `kode_pelanggan`, `nama` ASC");
                                                while($row_sup = mysql_fetch_array($q_sup)) { 
                                            ;?>
                                                 
                                                <option 
                                                    data-kode="<?php echo $row_sup['kode_pelanggan'];?>"
                                                    value="<?php echo $row_sup['kode_pelanggan'];?>" ><?php echo $row_sup['kode_pelanggan'] . ' - ' . $row_sup['nama'];?> 
                                                </option>
                                            <?php } ?>
                                                <input type="hidden" name="kode_pelanggan" id="kode_pelanggan" class="form-control" value=""/>
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
                                                <input type="hidden" name="kode_cabang" id="kode_cabang" class="form-control" value=""/>
                                        </select>
                                    </div>

                                    <label class="col-sm-1 control-label" style="text-align:left">Status</label>
                                    <div class="col-sm-5">
                                        <select id="status" name="status" class="select2" style="width: 100%;">
                                            <option value="-1">Semua</option>
                                            <option value="0">Belum Lunas</option>
                                            <option value="1">Lunas</option>
                                        </select>
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

                                          <!-- <button type="button" name="submit" class="btn btn-primary kapu-load" tabindex="10"><i class="fa fa-search" ></i> Cari </button> -->
                                    <?php } } } ?>
                                          <button type="button" name="submit" class="btn btn-primary kapu-load" tabindex="10"><i class="fa fa-search" ></i> Cari </button> 
                            </div>

							<hr style="width:100%;">
                           

                            <div id="showData">
                              
                            </div>  

                        </div>                    
                    </div>
                </div>   
            </div>
        </div>
    </div>
</div>
<style>
  .pm-min, .pm-min-s{padding:3px 1px; }
  .animated{display:none;}

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
      padding: 6px;
  }

  td {
      text-align: left;
      font-size: 12px;
      padding: 6px;
  }

  tr:nth-child(even){background-color: #f2f2f2}
  </style>

<script>
$(document).ready(function(){          
$('.kapu-load').click(function(){
        var value = $(this).attr('data'); 
        data = $("#form-kapu").serialize();
        $(".animated").show();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>ajax/j_kapu.php?func=kapu-load',
            data: data,
            cache: false,
            success:function(data){
                $('#showData').html(data.table).show();
                $(".animated").hide();
            }
        });
    });
    
});

$('#pelanggan').change(function(event){
   event.preventDefault();
   var kode_pelanggan    = $("#pelanggan").find(':selected').attr('data-kode');
   $('#kode_pelanggan').val(kode_pelanggan);
});

$('#cabang').change(function(event){
   event.preventDefault();
   var kode_cabang    = $("#cabang").find(':selected').attr('data-kode');
   $('#kode_cabang').val(kode_cabang);
});

</script>

<!-- <script src="<?=base_url()?>assets/select2/select2.js"></script> -->
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


