<?php 
    include "pages/data/script/m_barang_aset.php"; 
?>

<script>
  $(document).ready(function (e) {
    $(".select2").select2({
        width: '100%'
    });
  });
</script>

<section class="content-header">
    <ol class="breadcrumb">
        <li><i class="fa fa-database"></i>Master</li>
        <li>Barang Aset</li>
    </ol>
</section>

<!-- /.row -->
<div class="box box-info">
    <div class="box-body">

        <?php if (isset($_GET['pesan'])){ ?>      
            <div class="form-group" id="form_report">
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      Kode Barang :  <a href="<?=base_url()?>?page=master/barang_aset_track&halaman= TRACK BARANG ASET&action=track&kode_inventori=<?=$_GET['pesan']?>" target="_blank"><?=$_GET['pesan'] ?></a>  Berhasil Di Posting
                </div>
            </div>    
        <?php  }  ?>

        <?php if (isset($_GET['pesan1'])){ ?>      
            <div class="form-group" id="form_report">
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      Kode Barang :  <a href="<?=base_url()?>?page=master/barang_aset_track&halaman= TRACK BARANG ASET&action=track&kode_inventori=<?=$_GET['pesan1']?>" target="_blank"><?=$_GET['pesan1'] ?></a>  Berhasil Di Update
                </div>
            </div>    
        <?php  }  ?>
            
        <div class="tabbable">
            <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
                <li <?=$class_form?>>
                    <a data-toggle="tab" href="#menuFormPp">Data Barang</a>
                </li>
                <li <?=$class_tab1?>>
                    <a data-toggle="tab" href="#akunting">Accounting</a>
                </li>
                <li <?=$class_tab?>>
                    <a data-toggle="tab" href="#menuListPp">List barang</a>
                </li>
            </ul>
        

<div class="row">
<div class="tab-content">
<div id="menuFormPp" <?=$class_pane_form?> >
    <div class="col-lg-12">
        <div id="" class="panel panel-default">
            <div class="panel-body">
                <div class="form-horizontal">
                    <?php $id_form = buatkodeform("kode_form"); ?>

                    <form role="form" method="post" action="" id="saveForm"> 

                    <?php   $idtem = "INSERT INTO form_id SET kode_form ='".$id_form."' ";
                    mysql_query($idtem); ?>
                        <input type="hidden" name="id_form" id="id_form" value="<?php echo $id_form; ?>"/>  
                                           
                        <div class="form-group">
                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode <b style="color: red;">*</b></label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="kode_inventori" id="kode_inventori" placeholder="Kode Barang ..." value="">
                            </div>
							<span id="pesan" class="span" style="color:#F00; font-weight:bold"></span>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Nama <b style="color: red;">*</b></label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama..." value="" autocomplete="off">
                            </div>   
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kategori Barang Aset <b style="color: red;">*</b></label>
                            <div class="col-lg-4">
                                <select id="kategori" name="kategori" class="select2" style="width: 100%;">
                                <option value="0">-- Pilih Kategori --</option>
                                <?php 
                                    while($rowkategori = mysql_fetch_array($q_ddl_kat_inv)) { ;?>
                                        <option value="<?php echo $rowkategori['kode_kat_aset'];?>">
                                            <?php echo $rowkategori['keterangan'];?>   
                                        </option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
           
                        <div class="form-group">
                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan..." value="">
                            </div>
                        </div>
                        

                        <label><b style="color: red;">* &nbsp;Wajib Diisi</b></label>

                        <br><br>
                                         
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
                <div id="akunting" <?=$class_pane_tab1?> >
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-horizontal">

                                    <div class="form-group">
                                        <label class="col-lg-3 col-sm-2 control-label" style="text-align:left">Terima Barang</label>
                                        <div class="col-lg-9">
                                            <select id="tb_debet" name="tb_debet" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Debet --</option>
                                                <?php 
                                                    while($rowtbdeb = mysql_fetch_array($q_ddl_coa)) { ;?>
                                                    <option value="<?php echo $rowtbdeb['kode_coa'] ;?>">
                                                        <?php echo $rowtbdeb['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowtbdeb['nama'];?> 
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>     

                                    <div class="form-group">
                                        <label class="col-lg-3 col-sm-2 control-label" style="text-align:left"></label>
                                        <div class="col-lg-9">
                                            <select id="tb_kredit" name="tb_kredit" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Kredit --</option>
                                                <?php 
                                                    while($rowtbkred = mysql_fetch_array($q_ddl_coa2)) { ;?>
                                                    <option value="<?php echo $rowtbkred['kode_coa'];?>">
                                                        <?php echo $rowtbkred['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowtbkred['nama'];?>   
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>  

                                    <hr>

                                    <div class="form-group">
                                        <label class="col-lg-3 col-sm-2 control-label" style="text-align:left">Faktur Penjualan</label>
                                        <div class="col-lg-9">
                                            <select id="fj_debet" name="fj_debet" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Debet --</option>
                                                <?php            
                                                    while($rowfjdeb = mysql_fetch_array($q_ddl_coa5)) { ;?>
                                                    <option value="<?php echo $rowfjdeb['kode_coa'];?>">
                                                        <?php echo $rowfjdeb['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowfjdeb['nama'];?> 
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>     

                                    <div class="form-group">
                                        <label class="col-lg-3 col-sm-2 control-label" style="text-align:left"></label>
                                        <div class="col-lg-9">
                                            <select id="fj_kredit" name="fj_kredit" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Kredit --</option>
                                                <?php     
                                                    while($rowfjkred = mysql_fetch_array($q_ddl_coa6)) { ;?>
                                                    <option value="<?php echo $rowfjkred['kode_coa'];?>">
                                                        <?php echo $rowfjkred['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowfjkred['nama'];?> 
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="form-group">
                                        <label class="col-lg-3 col-sm-2 control-label" style="text-align:left">Faktur Pembelian</label>
                                        <div class="col-lg-9">
                                            <select id="fb_debet" name="fb_debet" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Debet --</option>
                                                <?php    
                                                    while($rowfbdeb = mysql_fetch_array($q_ddl_coa7)) { ;?>
                                                    <option value="<?php echo $rowfbdeb['kode_coa'];?>">
                                                        <?php echo $rowfbdeb['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowfbdeb['nama'];?> 
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>     

                                    <div class="form-group">
                                        <label class="col-lg-3 col-sm-2 control-label" style="text-align:left"></label>
                                        <div class="col-lg-9">
                                            <select id="fb_kredit" name="fb_kredit" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Kredit --</option>
                                                <?php 
                                                    while($rowfbkred = mysql_fetch_array($q_ddl_coa8)) { ;?>
                                                    <option value="<?php echo $rowfbkred['kode_coa'];?>">
                                                        <?php echo $rowfbkred['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowfbkred['nama'];?> 
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="form-group">
                                        <label class="col-lg-3 col-sm-2 control-label" style="text-align:left">Retur Beli</label>
                                        <div class="col-lg-9">
                                            <select id="rb_debet" name="rb_debet" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Debet --</option>
                                                <?php     
                                                    while($rowrbdeb = mysql_fetch_array($q_ddl_coa9)) { ;?>
                                                    <option value="<?php echo $rowrbdeb['kode_coa'];?>">
                                                        <?php echo $rowrbdeb['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowrbdeb['nama'];?> 
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>     

                                    <div class="form-group">
                                        <label class="col-lg-3 col-sm-2 control-label" style="text-align:left"></label>
                                        <div class="col-lg-9">
                                            <select id="rb_kredit" name="rb_kredit" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Kredit --</option>
                                                <?php  
                                                    while($rowrbkred = mysql_fetch_array($q_ddl_coa10)) { ;?>
                                                    <option value="<?php echo $rowrbkred['kode_coa'];?>">
                                                        <?php echo $rowrbkred['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowrbkred['nama'];?> </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div> 

                                    <hr>

                                    <div class="form-group">
                                        <label class="col-lg-3 col-sm-2 control-label" style="text-align:left">Retur Jual</label>
                                        <div class="col-lg-9">
                                            <select id="rj_debet" name="rj_debet" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Debet --</option>
                                                <?php 
                                                    while($rowrjdeb = mysql_fetch_array($q_ddl_coa11)) { ;?>
                                                    <option value="<?php echo $rowrjdeb['kode_coa'];?>">
                                                        <?php echo $rowrjdeb['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowrjdeb['nama'];?> 
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>    

                                    <div class="form-group">
                                        <label class="col-lg-3 col-sm-2 control-label" style="text-align:left"></label>
                                        <div class="col-lg-9">
                                            <select id="rj_kredit" name="rj_kredit" class="select2" style="width: 100%;">
                                                <option value="0">-- Pilih Coa Kredit --</option>
                                                <?php 
                                                    while($rowrjkred = mysql_fetch_array($q_ddl_coa12)) { ;?>
                                                    <option value="<?php echo $rowrjkred['kode_coa'];?>">
                                                        <?php echo $rowrjkred['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowrjkred['nama'];?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div> 

                                    <br><br>

                                    <div class="form-group col-md-12" style="text-align: center;">
                                        <?php 
                                            $list_survey_write = 'n';
                                            while($res = mysql_fetch_array($q_akses)) {; ?>    
                                                <?php 
                                                //FORM SURVEY
                                                if($res['form']=='survey'){ 
                                                    if($res['w']=='1'){
                                                        $list_survey_write = 'y';   
                                                ?>  
                                            <button type="submit" name="simpan" id="simpan" class="btn btn-primary pb-save" tabindex="10">
                                                <i class="fa fa-check-square-o"></i> Simpan
                                            </button> 
                                        <?php } } } ?>
                                            
                                             <a href="<?=base_url()?>?page=master/barang&halaman= BARANG" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>&nbsp; <img src="<?=base_url()?>assets/images/loading.gif" class="animated"/>
               
                                    </div>
                                 </form>  
                                </div>
                            </div>
                        </div>
                    </div>                
                </div>

<!-- END AKUNTING -->                
                
                <div id="menuListPp" <?=$class_pane_tab?> >                 
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">  
                            <div class="box-body">  
								<table class="table table-bordered" id="table-barang" width="100%">
										<thead>
											<tr>
												<th>ID</th>
												<th>Kode Barang</th>
												<th>Nama</th>
												<th>Kategori</th>
												<th>Keterangan</th>
                                                <th>Status</th>
												<th>Aksi</th>
											</tr>
										</thead>
										<tbody></tbody>
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

<?php unset($_SESSION['data_barang']); ?>

<script>
    $(document).ready(function () {
          $("[name='jumlah_isi']").number( true, 2 );
          $("[name='harga[]']").number( true, 0 );
          $("[name='diskon[]']").number( true, 0 );
    });
</script>    

<script>
		var tabel = null;

		$(document).ready(function() {
		    tabel = $('#table-barang').DataTable({
		        "processing": true,
		        "serverSide": true,
		        "ordering": true, // Set true agar bisa di sorting
		        "order": [[ 1, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
		        "ajax":
		        {
		            "url": '<?=base_url()?>ajax/list_barang.php', // URL file untuk proses select datanya
		            "type": "POST"
		        },
				"deferRender": true,
		        "aLengthMenu": [[10, 20, 50, 100],[10, 20, 50, 100]], // Combobox Limit
		        "columns": [
		            { "data": "id_inventori" }, // Tampilkan nis
		            { "render": function ( data, type, row ) { // Tampilkan kolom aksi
                        var kode  = "<a href='<?=base_url()?>?page=master/barang_aset_track&halaman= TRACK BARANG&action=track&kode_inventori="+row.kode_inventori+"'>"+row.kode_inventori+"</a>"

                        return kode;
                       }
                    },
					{ "data": "nama" },  
		            { "data": "kategori" }, 
		            { "data": "keterangan" }, 
		            { "render": function ( data, type, row ) {  
                            var status = ""

                            if(row.aktif == 1){
                                status = '<span class="btn-sm btn-success fa fa-check"></span>' 
                            }else{ // Jika bukan 1
                                status = '<span class="btn-sm btn-danger fa fa-remove"></span>'
                            }

                            return status; 
                        }
                    },
                    { "render": function ( data, type, row ) { 
                            var html  = "<a href='<?=base_url()?>?page=master/barang_edit&action=edit&kode_inventori="+row.kode_inventori+"'>EDIT</a> | "

                            // html += '<a href="<?=base_url()?>?page=master/barang_aset_track&halaman= TRACK BARANG&action=track&kode_inventori='+row.kode_inventori+'"></a>'
                            
                            if(row.aktif == 1){
                                html += '<a href="<?=base_url()?>?page=master/barang&action=nonaktif&kode_inventori='+row.kode_inventori+'">NON-AKTIF</a>' 
                            }else{ // Jika bukan 1
                                html += '<a href="<?=base_url()?>?page=master/barang&action=aktif&kode_inventori='+row.kode_inventori+'">AKTIF</a>'
                            }

                            return html;
                        }
                    },
		        ],
		    });
		});
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('.pb-save').click(function(){
			
		$span = $(".span");
			
            if($('#kode_inventori').val() == '' ) {
                alert("Data Barang => Kode, belum diisi");
                return false;
            }

            if($('#nama').val() == '' ) {
                alert(" Data Barang => Nama, belum diisi");
                return false;
            }

            if($('#kategori').val() == '0' ) {
                alert(" Data Barang => Kategori Barang, belum dipilih");
                return false;
            }

            if($('#satuan_beli').val() == '0' ) {
                alert(" Data Barang => Satuan Beli, belum dipilih");
                return false;
            }

            if($('#satuan_jual').val() == '0' ) {
                alert(" Data Barang => Satuan Jual, belum dipilih");
                return false;
            }

            if($('#jumlah_isi').val() == '0' ) {
                alert(" Data Barang => Jumlah Isi, belum dipilih");
                return false;
            }
			
			if($span.text() != ""){
				alert("Kode Sudah Terpakai");
				$('#kode_inventori').focus();
				return false;
			}
			
        });
    });
</script>

<script>
    $(document).ready(function (e) {
        $("#saveForm").on('submit',(function(e) {
            var grand_total = $("#id_form").val();
            if(grand_total == "" || isNaN(grand_total)) {grand_total = 0;}
            e.preventDefault();
            if(grand_total != 0) {          
                $(".animated").show();
                $.ajax({
                    
                    url: "<?=base_url()?>ajax/j_barang.php?func=save",
                    type: "POST",
                    data:  new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(html)
                    {
                        var msg = html.split("||");
                        if(msg[0] == "00") {
                            window.location = '<?=base_url()?>?page=master/barang&halaman= BARANG&pesan='+msg[1];
                        } else {
                            notifError(msg[1]);
                        }
                        $(".animated").hide();
                    }  
               });
            } else {notifError("<p>Item masih kosong.</p>");}
         }));
      });

    $('#nama').change(function(){
        title = $(this).val();
        if(title == '') {
            if(!$('#judul_inventori_bom_el').hasClass('hidden')) {
                $('#judul_inventori_bom_el').addClass('hidden')
            }
        }else {
            if($('#judul_inventori_bom_el').hasClass('hidden')) {
                $('#judul_inventori_bom_el').removeClass('hidden')
            }
        }
        $('#judul_inventori_bom').text(title);
    });
    
    $("#tambah_barang").click(function(event) {
        event.preventDefault();
        document.getElementById('show_input_barang').style.display = "table-row";

        $('#kode_barang_dtl').val('0').trigger('change');
        $('#satuan_dtl').val('0').trigger('change');
        $('#qty_dtl').val('0');
        $('#ket_dtl').val('');
       
    }); 

    $("#batal_input").click(function(event) { 
        event.preventDefault(); 
        document.getElementById('show_input_barang').style.display = "none";
    });
    
    $("#ok_input").click(function(event) { 

        if($('#kode_barang_dtl').val() == '0' ) {
                alert("Barang belum dipilih");
                return false;
        }

        if($('#satuan_dtl').val() == '0' ) {
                alert("Satuan belum dipilih");
                return false;
        }

        if($('#qty_dtl').val() == '0' ) {
                alert("Jumlah belum diisi");
                return false;
        }

        event.preventDefault();
        var id_form         = $("#id_form").val();
        var kode_barang_dtl = $("#kode_barang_dtl").val();
        var satuan_dtl      = $("#satuan_dtl").val();
        var qty_dtl         = $("#qty_dtl").val();
        var ket_dtl         = $("#ket_dtl").val();
        
        $.ajax({
            type: "POST",
            url: "<?=base_url()?>ajax/j_barang.php?func=add",
            data: "kode_barang_dtl="+kode_barang_dtl+"&satuan_dtl="+satuan_dtl+"&qty_dtl="+qty_dtl+"&ket_dtl="+ket_dtl+"&id_form="+id_form,
            cache:false,
            success: function(data) {
                var msg = data.split("||");
                    if(msg[0] == "33") {
                        notifError(msg[1]);
                    } else {
                         $('#detail_input_barang').html(data);
                        document.getElementById('show_input_barang').style.display = "none";
                    }
                    $(".animated").hide();
            }
          });
      return false;
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
    });
});
</script>

<script>
$(document).ready(function(){
	$('#kode_inventori').change(function(){
		$('#pesan').html('<img style="margin-left:1px; width:20px"  src="<?=base_url()?>images/loading.gif">');
		var kode_inventori = $(this).val();

		$.ajax({
			type	: 'POST',
			url 	: '<?=base_url()?>ajax/j_validasi.php?func=loadkode_inventori',
			data 	: 'kode_inventori='+kode_inventori,
			success	: function(data){
				$('#pesan').html(data);
			}
		})
	});
});
</script>