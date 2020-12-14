<?php 	
    include "pages/data/script/op.php"; 
	include "library/form_akses.php";	
?>

<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-shopping-cart"></i> Pembelian</a></li>
        <li><a href="#">Form Order Pembelian</a></li>
    </ol>
</section>

<!-- /.row -->
<div class="box box-info">
<div class="box-body">
            
            <?php if (isset($_GET['pesan'])){ ?>      
				<div class="form-group" id="form_report">
				  <div class="alert alert-success alert-dismissable">
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					  Kode OP :  <a href="<?=base_url()?>?page=pembelian/op_track&action=track&kode_op=<?=$_GET['pesan']?>" target="_blank"><?=$_GET['pesan'] ?></a>  Berhasil Di posting
				  </div>
				</div>    
			<?php  }  ?>
            
    <div class="tabbable">
		<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
			<li class="active">
		        <a data-toggle="tab" href="#menuFormOp">Form Purchase Order</a>
			</li>
        </ul>
		

	<div class="row">
		<div class="tab-content">
				
            <div id="menuFormOp" class="tab-pane fade in active">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-horizontal">
                                 <?php $id_form = buatkodeform("kode_form"); ?>
                                	
								<form role="form" method="post" action="" id="saveForm">

                                    <?php
                                        if(isset($_GET['action']) and $_GET['action'] == "copy") {
                                            $row = mysql_fetch_array($q_copy_op_hdr);
                                        }
                                    ?>  
                                          
                                    <?php   $idtem = "INSERT INTO form_id SET kode_form ='".$id_form."' ";
									mysql_query($idtem); ?>
									<input type="hidden" name="id_form" id="id_form" value="<?php echo $id_form; ?>"/>  
                            
									
                                    <div class="form-group">
                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode OP</label>
                                             <div class="col-lg-4">
                                                 <input type="text" class="form-control" name="kode_op" id="kode_op" placeholder="Auto..." readonly value="">
                                             </div>

                                             <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
                                             <div class="col-lg-4">
                                                <select id="kode_cabang" name="kode_cabang" class="select2">
                                                    <option value="0">-- Pilih Cabang --</option>
                                                        <?php 
                                                        //CEK JIKA KODE CABANG ADA MAKA SELECTED      
                                                        (isset($row['kode_op']) ? $kode_cabang=$row['kode_cabang'] : $kode_cabang='');                                                    //UNTUK AMBIL CABANGNYA    
                                                        while($rowcabang = mysql_fetch_array($q_cab_aktif)) { ;?>
                                                         
                                                    <option value="<?php echo $rowcabang['kode_cabang'];?>"<?php if($rowcabang['kode_cabang']==$kode_cabang){echo 'selected';} ?>><p><?php echo $rowcabang['kode_cabang'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowcabang['nama'];?> </p></option>
                                                        <?php } ?>
                                                </select>
                                             </div>
                                    </div>
                                             
                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ref</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="ref" id="ref" placeholder="ref..." value="<?=(isset($row['kode_op']) ? $row['ref'] : "")?>" autocomplete="off" />
                                        </div> 

                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Supplier</label>
                                             <div class="col-lg-4">
                                                <select id="kode_supplier" name="kode_supplier" class="select2">
                                                    <option value="0">-- Pilih Supplier --</option>
                                                        <?php 
                                                        //CEK JIKA KODE supplier ADA MAKA SELECTED      
                                                        (isset($row['kode_op']) ? $kode_supplier=$row['kode_supplier'] : $kode_supplier='');                        
                                                        //UNTUK AMBIL suppliernya   
                                                        while($rowsupplier = mysql_fetch_array($q_sup_aktif)) { ;?>
                                                         
                                                    <option 
                                                        data-top="<?php echo $rowsupplier['top'];?>"
                                                        value="<?php echo $rowsupplier['kode_supplier'];?>" 
                                                            <?php if($rowsupplier['kode_supplier']==$kode_supplier){echo 'selected';} ?>><?php echo $rowsupplier['kode_supplier'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowsupplier['nama'];?> 
                                                    </option>
                                                        <?php } ?>
                                                </select>
                                            </div>
                                    </div>
                                    
                                    <?php $tgl_hariini = date('d-m-Y'); ?>                                       
                                    <div class="form-group">
                                        <label style="text-align:left" class="col-lg-2 col-sm-2 control-label">Tanggal PO</label>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                                <input class="form-control date-picker" value="<?=(isset($row['kode_op']) ? $row['tgl_buat'] : "")?>" id="tanggal" name="tanggal" type="text" autocomplete="off"/>
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar bigger-110"></i>
                                                </span>
                                                <input type="hidden" name="tgl_sekarang" id="tgl_sekarang" class="form-control" value="<?=date("d-m-Y")?>"/>
                                            </div>
                                        </div>
                                        
                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">TOP</label>
                                        <div class="col-lg-4">
                                            <div class="input-group">
                                              <input type="text" autocomplete="off" class="form-control" name="top" id="top" placeholder="TOP..." value="<?=(isset($row['kode_op']) ? $row['top'] : "")?>" readonly />
                                              <span class="input-group-addon"><b>Hari</b></span>
                                            </div>
                                        </div>
                                      </div>  
                                        
                                    <div class="form-group">
                                        <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                                        <div class="col-lg-10">
                                            <textarea  class="form-control" rows="2" name="keterangan_hdr" id="keterangan_hdr" placeholder="Keterangan..."><?=(isset($row['kode_op']) ? $row['keterangan_hdr'] : "")?></textarea>
                                        <input type="hidden" name="id_um" id="id_um" value="1"/></div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label" style="text-align:left">Uang Muka (%)</label> 
                                            <div class="col-lg-4">
                                                <div class="input-group control-group after-add-more">
                                                    <input type="text" style="width: 12em" name="um" id="um" class="form-control" placeholder="Uang Muka %">
                                                        <div class="input-group-btn"> 
                                                        	<input type="text" style="width: 17em" value="0" readonly name="nominal" id="nominal" class="form-control" placeholder="0">
                                                            <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Tambah</button>
                                                        </div>	
                                                </div>
                                            </div>    
                                    </div>
                                        
                                    <div class="form-group">
                                        <div class="col-lg-12">                                   	
                                            <div class="pull-left">  
                                                <a class="btn btn-success" id="tambah_op"><i class="fa fa-plus"></i> Add</a>                 		
                                            </div>   
                                        </div>
                                    </div>        
                                        
                                    <div class="form-group">
                     	                <div style="overflow-x:auto;">
                                            <table id="" class="" rules="all">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10px">No</th>
                                                        <th style="width: 81px" colspan="2">Barang</th>
                                                        <th style="width: 150px">Tgl kirim</th>
                                                        <th style="width: 88px">Satuan</th>
                                                        <th style="width: 110px">Q</th>
                                                        <th>Gudang</th>
                                                        <th>Stok</th>
                                                        <th style="width: 140px">Harga Beli</th>
                                                        <th style="width: 140px">Diskon(%)</th>
                                                        <th>Ppn</th>
                                                        <th>Subtotal</th>
                                                        <th style="width: 200px">Divisi</th>
                                                        <th style="width: 150px">Ket</th>
                                                        <th></th>
                                                    </tr>

                                                    <tr id="show_input_op" style="display:none">
                                                            <td style="text-align: center ; width: 10px"><h5><b>#</b></h5></td>
                                                            <td style="width: 200px">
                                                                <select id="kode_barang" name="kode_barang" class="select2" style="width: 200px">
                                                                    <option value="0">-- Pilih Barang --</option>
                                                                    <?php                        
                                                                        while($rowinv = mysql_fetch_array($q_inv_aktif)) { ;?>
                                                                            <option value="<?php echo $rowinv['kode_inventori'].':'.$rowinv['nama'];?>" ><?php echo $rowinv['kode_inventori'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowinv['nama'];?> </option>
                                                                    <?php } ?>
                                                                 </select>
                                                            </td>
                                                            <td id="h_harga_op" style="width: 20px">
                                                            	<a href="" id="btn_his" data-toggle="modal" data-target="#his_harga" class="btn btn-sm btn-info ace-icon fa fa-info" title="history"></a>
                                                            </td>
                                                            <td style="width: 150px">
                                                                <input class="form-control date-picker" value="<?php echo $tgl_hariini; ?>" id="tanggal1" name="tanggal1" type="text" autocomplete="off" style="font-size:14px"/>
                                                            </td>
                                                            <td id="load_satuan" style="width: 30px">
                                                                <input class="form-control" type="text" name="satuan" id="satuan"  autocomplete="off" style="width: 30px ; text-align: center" value="" readonly/>                
                                                            </td>
                                                            <td style="width: 100px">
                                                                <input class="form-control" type="number" name="qty" id="qty"  autocomplete="off" style="width: 100px; text-align: right;" value=""/>
                                                            </td>
                                                            <td style="width: 200px">
                                                                <select id="kode_gudang" name="kode_gudang" class="select2" style="font-size:14px">
                                                                    <option value="0">-- Pilih Gudang --</option>
                                                                        <?php 
                                                                            
                                                                        while($rowgudang = mysql_fetch_array($q_gud_aktif)) { ;?>
                                                                         
                                                                    <option value="<?php echo $rowgudang['kode_gudang'].':'.$rowgudang['nama'];?>" ><?php echo $rowgudang['kode_gudang'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowgudang['nama'];?> </option>
                                                                        <?php } ?>
                                                                </select>
                                                            </td>
                                                            <td id="load_stok" style="text-align: center;">
                                                                <input class="form-control" type="text" name="stok" id="stok"  autocomplete="off" style="text-align: right;" value="" readonly/>
                                                            </td>
                                                            <td style="width: 150px">
                                                                <input class="form-control" type="number" name="harga" id="harga"  autocomplete="off" style="width: 150px; text-align: right;" value=""/>
                                                            </td>
                                                            <td style="width: 150px">
                                                                <input class="form-control" type="number" name="diskon" id="diskon"  autocomplete="off" style="width: 150px; text-align: right;" value=""/>
                                                            </td>
                                                            <td id="load_ppn"></td>
                                                            <td style="width: 150px">
                                                                <input class="form-control" type="text" name="subtot" id="subtot"  autocomplete="off" style="width: 150px; text-align: right;" value="" readonly/></td>
                                                            <td style="width: 200px">
                                                            	<select id="divisi" name="divisi" class="select2" style="width: 200px ; font-size:14px">
                                                                    <option value="0">-- Pilih Divisi --</option>
                                                                        <?php 
                                                                            
                                                                        while($rowdivisi = mysql_fetch_array($q_ddl_divisi)) { ;?>
                                                                         
                                                                    <option value="<?php echo $rowdivisi['kode_cc'].':'.$rowdivisi['nama'];?>" ><?php echo $rowdivisi['nama'];?> </option>
                                                                        <?php } ?>
                                                                </select>
                                                            </td>
                                                            <td style="width: 190px">
                                                                <input class="form-control" type="text" name="ket_dtl" id="ket_dtl"  autocomplete="off" style="width: 190px" value=""/>
                                                            </td>
                                                            <td style="text-align: center">
                                                                <button id="ok_input" class="btn btn-sm btn-info ace-icon fa fa-check" title="ok"></button>
                                                                <a href="" id="batal_input" class="btn btn-sm btn-danger ace-icon fa fa-remove" title="batal" ></a>
                                                            </td> 
                                                        </tr>

                                                </thead>
                                                <tbody id="detail_input_op">
                                                        <?php 
                                                            $no=1; 
                                                            while($row_dtl = mysql_fetch_array($q_copy_op_dtl)) { ;

                                                            $kd_barang   = '';
                                                            $nm_barang   = '';
                                                            $kode_barang = $row_dtl['kode_barang'];
                                                                if(!empty($kode_barang)) {
                                                                    $pisah      =explode(":",$kode_barang);
                                                                    $kd_barang  =$pisah[0];
                                                                    $nm_barang  =$pisah[1];
                                                                }

                                                            if($row_dtl['ppn']=='1'){
                                                                $stat_ppn = '<span class="glyphicon glyphicon-check"> </span>'; 
                                                            }else{
                                                                $stat_ppn = '<span class="glyphicon glyphicon-unchecked"> </span>'; 
                                                            }

                                                        ?>
                                                        <tr>
                                                            <td style="text-align: center ; width: 10px"><?php echo $no++ ?></td>
                                                            <td><?php echo $kd_barang .'&nbsp;&nbsp;||&nbsp;&nbsp;'. $nm_barang ?></td>
                                                            <td style="text-align: center"><a class="btn btn-sm btn-info ace-icon fa fa-info" title="history"></a></td>
                                                            <td><?php echo $row_dtl['tgl_kirim']; ?></td>
                                                            <td><?php echo $row_dtl['satuan']; ?></td>
                                                            <td style="text-align: right"><?php echo $row_dtl['qty']; ?></td>
                                                            <td><?php echo $row_dtl['kode_gudang']; ?></td>
                                                            <td style="text-align: right"><?php echo $row_dtl['stok']; ?></td>
                                                            <td style="text-align: right"><?php echo $row_dtl['harga']; ?></td>
                                                            <td style="text-align: right"><?php echo $row_dtl['diskon']; ?></td>
                                                            <td style="text-align: center"><?php echo $stat_ppn; ?></td>
                                                            <td style="text-align: right"><?php echo $row_dtl['subtot']; ?></td>
                                                            <td><?php echo $row_dtl['divisi']; ?></td>
                                                            <td><?php echo $row_dtl['keterangan_dtl']; ?></td>
                                                        </tr>
                                                    <!-- <tr> 
                                                         <td colspan="15" class="text-center"> Tidak ada item barang. </td>
                                                    </tr>
                                                    <tr id="total2" >
                                                        <td style="text-align:right" colspan="11" ><b>Total :</b></td>
                                                        <td style="text-align:right"><b></b></td>
                                                        <td colspan="3"></td>
                                                    </tr>
                                                    <tr id="ppn">
                                                        <td style="text-align:right" colspan="11"><b>PPn :</b></td>
                                                        <td style="text-align:right"><b></b></td>
                                                        <td style="text-align:right" colspan="3"></td>
                                                    </tr>
                                                    <tr id="grand_total">
                                                        <td style="text-align:right" colspan="11"><b>Grand Total :</b></td>
                                                        <td style="text-align:right"><b></b></td>
                                                        <td style="text-align:right" colspan="3"></td>
                                                    </tr> -->
                                                <?php  } ?>
                                                </tbody>
                                            </table>
                                    	</div>
									</div>
                           	
                                    <div class="form-group col-md-6">
                    
                    					<?php 
											$list_survey_write = 'n';
											while($res = mysql_fetch_array($q_akses)) {; ?>    
												<?php 
                                                //FORM SURVEY
                                                if($res['form']=='survey'){ 
                                                    if($res['w']=='1'){
														$list_survey_write = 'y';	
                                                ?> 	
											<button type="submit" name="simpan" id="simpan" class="btn btn-primary" tabindex="10"><i class="fa fa-check-square-o"></i> Simpan</button> 
                                             	<?php } } ?>
                     					<?php } ?>
                                            
                                             <a href="<?=base_url()?>?page=pembelian/op&halaman=ORDER PEMBELIAN" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>&nbsp; <img src="<?=base_url()?>assets/images/loading.gif" class="animated"/>
               
									</div>
                 
            
            					</form>
                                
                                <!-- Copy Fields -->
                                <div class="copy">
                                   	
                                </div>
            
    					    </div>		
	                    </div>
                    <!-- /.panel-body -->
                    </div>                       
                <!-- /.panel-default -->
                </div>
			</div>
		</div>			
	</div>
	<!-- /.row -->
    <!-- Tambah Item Infrastructure       --->


	<!-- MODAL -->
     <div class="modal fade" id="his_harga" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">3 List Harga OP Terakhir</h4>
                </div>
                <div class="modal-body" id="list_his_harga">
                    
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
                </div>
                
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>	
                
                
                
<?php unset($_SESSION['data_um']); ?>
<?php unset($_SESSION['data_op']); ?>
  <style>
  .pm-min, .pm-min-s{padding:3px 1px; }
  .animated{display:none;}

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
  }

  td {
      text-align: left;
      padding: 8px;
      font-size: 12px;
  }

  tr:nth-child(even){background-color: #f2f2f2}

  p {
    font-size: 8px;
  }
  </style>
  <script>
      $(document).ready(function (e) {
    	 $("#saveForm").on('submit',(function(e) {
    		var grand_total = parseFloat($("#grandtotal").val());
    		if(grand_total == "" || isNaN(grand_total)) {grand_total = 0;}
    		e.preventDefault();
    	  	if(grand_total != 0) {			
    			$(".animated").show();
    			$.ajax({
    				
    				url: "<?=base_url()?>ajax/j_op.php?func=save",
    				type: "POST",
    				data:  new FormData(this),
    				contentType: false,
    				cache: false,
    				processData:false,
    				success: function(html)
    				{
    					var msg = html.split("||");
    					if(msg[0] == "00") {
    						//window.open('r_penjualan_cetak.php?noNota=' + msg[1], width=330,height=330,left=100, top=25);
    						
    						window.location = '<?=base_url()?>?page=pembelian/op&pesan='+msg[1];
    					} else {
    						notifError(msg[1]);
    					}
    					$(".animated").hide();
    				} 
    				  
    		   });
    	  	} else {notifError("<p>Item  masih kosong.</p>");}
    	 }));
      });

	
	$('#kode_supplier').change(function(){
        var kode_supplier = $("#kode_supplier").val();   
        var top  = $("#kode_supplier").find(':selected').attr('data-top');
        $.ajax({
            type: "POST",
            url: "<?=base_url()?>ajax/j_op.php?func=loadppn",
            data: "kode_supplier="+kode_supplier,
            cache:false,
            success: function(data) {
                $('#load_ppn').html(data);
                $('#top').val(top);
            }
		});		
	});
	
	$('#kode_barang').change(function(){
        var kode_barang = $("#kode_barang").val();   
        
        $.ajax({
            type: "POST",
            url: "<?=base_url()?>ajax/j_op.php?func=loadsatuan",
            data: "kode_barang="+kode_barang,
            cache:false,
            success: function(data) {
                $('#load_satuan').html(data);
            }
		});		
	});

    $('body').delegate("#kode_gudang","change", function() {
        var kode_cabang     = $("#kode_cabang").val();
        var kode_barang     = $("#kode_barang").val();   
        var kode_gudang     = $("#kode_gudang").val(); 
            $.ajax({
                    type: "POST",
                    url: "<?=base_url()?>ajax/j_op.php?func=loadstok",
                    data: "kode_cabang="+kode_cabang+"&kode_barang="+kode_barang+"&kode_gudang="+kode_gudang,
                    cache:false,
                    success: function(data) {
                        $('#load_stok').html(data);
                        //alert('tes');
                    }
                });
        
    });


	$("#tambah_op").click(function(event) {
		event.preventDefault();

        var kode_supplier     = $("#kode_supplier").val();
        if(kode_supplier != 0 ) {  
    		var tgl_sekarang = $("#tgl_sekarang").val();
    		document.getElementById('show_input_op').style.display = "table-row";
    		
    		$('#kode_gudang').val('0').trigger('change');
    		$('#kode_barang').val('0').trigger('change');
    		$('#divisi').val('0').trigger('change');
    		$('#tanggal1').val(tgl_sekarang);
    		$('#qty').val('0');
    		$('#harga').val('0');
    		$('#diskon').val('0');
    		$('#subtot').val('0');
    		$('#stok').val('100');
    		$('#satuan').val('');
    		$('#ket_dtl').val('');
        }else{
            alert("Pilih Supplier Terlebih Dahulu !!");
        }
	});
    	
	
	$("#batal_input").click(function(event) { 
		event.preventDefault(); 
		document.getElementById('show_input_op').style.display = "none";
	});

 // saat mengetik qty
  $(document).on("change paste keyup", "input[name='qty']", function(){
                var qty     = $(this).val() || 0;
                var harga   = $("#harga").val();
                var diskon1 = $("#diskon").val();
                var diskon  = parseInt(harga*(diskon1/100));
                var total   = parseInt((harga-diskon)*qty);
                
                var stat_ppn  = $("#stat_ppn").val();
                if (stat_ppn == 1){
                    nilai_ppn = 0.1*total;  
                }else{
                    nilai_ppn = 0;
                }
                
                var subtot = parseInt(total+nilai_ppn);
                
                $('[name="subtot"]').val(subtot);
                //console.log(nominal);
  });

 //saat mengetik harga
  $(document).on("change paste keyup", "input[name='harga']", function(){
                var harga   = $(this).val() || 0;
                var qty     = $("#qty").val();
                var diskon1 = $("#diskon").val();
                var diskon  = parseInt(harga*(diskon1/100));
                var total   = parseInt((harga-diskon)*qty);
                
                var stat_ppn  = $("#stat_ppn").val();
				if (stat_ppn == 1){
					nilai_ppn = 0.1*total;	
				}else{
					nilai_ppn = 0;
				}
				
				var subtot = parseInt(total+nilai_ppn);
                
                $('[name="subtot"]').val(subtot);
                //console.log(stat_ppn);
  });

  //saat mengetik diskon
  $(document).on("change paste keyup", "input[name='diskon']", function(){
                var diskon1 = $(this).val() || 0;
                var qty     = $("#qty").val();
				var harga   = $("#harga").val();
                var diskon  = parseInt(harga*(diskon1/100));
                var total   = parseInt((harga-diskon)*qty);
				
				var stat_ppn  = $("#stat_ppn").val();
				if (stat_ppn == 1){
					nilai_ppn = 0.1*total;	
				}else{
					nilai_ppn = 0;
				}
				
				var subtot = parseInt(total+nilai_ppn);
                
                $('[name="subtot"]').val(subtot);
                //console.log(nominal);
  });
  
  $(document).on("change paste keyup", "input[name='ppn']", function(){
				if (this.checked){
					var group = $(this).data('group');
					var stat  = 1;
					$('[name="stat_ppn"]').val(stat);
				} else {
					var group = $(this).data('group');
					var stat  = 0;
					$('[name="stat_ppn"]').val(stat);	
				}
				
				var qty     = $("#qty").val();
				var harga   = $("#harga").val();
                var diskon1 = $("#diskon").val();
                var diskon  = parseInt(harga*(diskon1/100));
                var total   = parseInt((harga-diskon)*qty);
				
				if (stat == 1){
					nilai_ppn = 0.1*total;	
				}else{
					nilai_ppn = 0;
				}
				
				var subtot = parseInt(total+nilai_ppn);
                
                $('[name="subtot"]').val(subtot);
  });				
	
	$("#ok_input").click(function(event) { 
		event.preventDefault();
		var id_form			= $("#id_form").val();
		var kode_barang		= $("#kode_barang").val();
		var tgl_kirim		= $("#tanggal1").val();
		var satuan			= $("#satuan").val();
		var nama_satuan		= $("#nama_satuan").val();
		var qty				= $("#qty").val();
		var kode_gudang		= $("#kode_gudang").val();
		var stok			= $("#stok").val();
		var harga			= $("#harga").val();
		var diskon			= $("#diskon").val();
		var ppn				= $("#stat_ppn").val();
		var subtot			= $("#subtot").val();
		var divisi			= $("#divisi").val();
		var keterangan_dtl  = $("#ket_dtl").val();
        
		$.ajax({
			type: "POST",
			url: "<?=base_url()?>ajax/j_op.php?func=add",
			data: "kode_barang="+kode_barang+"&tgl_kirim="+tgl_kirim+"&satuan="+satuan+"&nama_satuan="+nama_satuan+"&qty="+qty+"&kode_gudang="+kode_gudang+"&stok="+stok+"&harga="+harga+"&diskon="+diskon+"&ppn="+ppn+"&subtot="+subtot+"&divisi="+divisi+"&keterangan_dtl="+keterangan_dtl+"&id_form="+id_form,
            cache:false,
			success: function(data) {
                
				$('#detail_input_op').html(data);
				document.getElementById('show_input_op').style.display = "none";
			  //display message back to user here
			}
		  });
	  return false;
	});
	
	$("#btn_his").click(function(event) { 
		event.preventDefault();
		var kode_inventori = $("#kode_barang").val();
		//console.log(kode_inventori);
		$.ajax({
			type: "POST",
			url: "<?=base_url()?>ajax/j_op.php?func=loadhistory",
			data: "kode_inventori="+kode_inventori,
            cache:false,
			success: function(data) {
				$('#list_his_harga').html(data);
			}
		  });
	  
		//console.log('tes');
	});
	
	$(document).ready(function() {
      $(".add-more").click(function(){ 
	  	  var id_um = $("#id_um").val();
		  var id_um_new = parseInt(id_um)+1;
		  
		  var um = $("#um").val();
		  var nominal = $("#nominal").val();	 
		
			$.ajax({
				type: "POST",
				url: "<?=base_url()?>ajax/j_op.php?func=addum",
				data: "id_um="+id_um+"&um="+um+"&nominal="+nominal,
				cache:false,
				success: function(data) {
					//console.log(data);
					var html = $(".copy").html(data);
          			$(".after-add-more").after(html);
					
					$("body").on("click",".remove",function(){ 
					  $(this).parents(".control-group").remove();
				  	});
				}
			});
			
		  $('#um').val('');
		  $('#nominal').val('0');	
		  $('#id_um').val(id_um_new);
		  $('#um').focus();
      });
  });
  
  
  //SAAT KLIK UM
  $(document).on("change paste keyup", "input[name='um']", function(){
				var um = $(this).val() || 0;
				var g_total = $("#grandtotal").val();
				var nominal = parseInt((um/100)*g_total);
				
				$('[name="nominal"]').val(nominal);
				
				//console.log(nominal);
  });	
	
</script>
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