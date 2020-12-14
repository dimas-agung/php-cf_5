<?php 	
    include "pages/data/script/m_supplier.php"; 
?>
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-database"></i> Master</a></li>
        <li><a href="#">Supplier</a></li>
    </ol>
</section>

<!-- /.row -->
<div class="box box-info">
    <div class="box-body">
        <!-- INFO BANNER FORM SAAT INPUT DAN UPDATE -->
        <?php
          	if (isset($_GET['inputsukses'])){
        		echo '<div class="alert alert-success"><i class="icon fa fa-check"></i> INPUT DATA BERHASIL</div>';
            }else if (isset($_GET['updatesukses'])){
				echo '<div class="alert alert-info"><i class="icon fa fa-check"></i> UPDATE DATA BERHASIL</div>';
			}
		?>
            
<div class="tabbable">
	<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
        <li <?=$class_form?>>
            <a data-toggle="tab" href="#menuFormPp">Data Supplier</a>
        </li>
        <li <?=$class_tab2?>>
            <a data-toggle="tab" href="#detail">Detail</a>
        </li>
        <li <?=$class_tab1?>>
            <a data-toggle="tab" href="#akunting">Accounting</a>
        </li>
        <li <?=$class_tab?>>
            <a data-toggle="tab" href="#menuListPp">List Supplier</a>
        </li>                                         
	</ul>
		
<div class="row">
<div class="tab-content">

	<div id="menuFormPp" <?=$class_pane_form?> >
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
                    <div class="form-horizontal">
                        <form action="" method="post">

                            <?php
								if(isset($_GET['action']) and $_GET['action'] == "edit") {
									$row = mysql_fetch_array($q_edit_supp);
								}
							?>             
                            <div class="form-group">
                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kode <b style="color: red;">*</b></label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="kode_supplier" id="kode_supplier" placeholder="Kode supplier..." <?=(isset($row['id_supplier']) ? "readonly": "")?> value="<?=(isset($row['id_supplier']) ? $row['kode_supplier'] : "")?>">
                                </div>
								<span id="pesan" class="span" style="color:#F00; font-weight:bold"></span>
                            </div>
							
							<div class="form-group">
                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Nama <b style="color: red;">*</b></label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama..." value="<?=(isset($row['id_supplier']) ? $row['nama'] : "")?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Alamat</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat..." value="<?=(isset($row['id_supplier']) ? $row['alamat'] : "")?>">
                                </div>

                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kecamatan</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="kecamatan" id="kecamatan" placeholder="Kecamatan..." value="<?=(isset($row['id_supplier']) ? $row['kecamatan'] : "")?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kota</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="kota" id="kota" placeholder="Kota..." value="<?=(isset($row['id_supplier']) ? $row['kota'] : "")?>">
                                </div>

                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Provinsi</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="provinsi" id="provinsi" placeholder="Provinsi..." value="<?=(isset($row['id_supplier']) ? $row['propinsi'] : "")?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Negara</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="negara" id="negara" placeholder="Negara..." value="<?=(isset($row['id_supplier']) ? $row['negara'] : "")?>">
                                </div>

                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">No Telpon</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="telpon" id="telpon" placeholder="No Telpon..." value="<?=(isset($row['id_supplier']) ? $row['telpon'] : "")?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Kontak Person</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="kontak_person" id="kontak_person" placeholder="Kontak Person..." value="<?=(isset($row['id_supplier']) ? $row['kontak_person'] : "")?>">
                                </div>

                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">No Handphone</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="hp" id="hp" placeholder="No HP..." value="<?=(isset($row['id_supplier']) ? $row['HP'] : "")?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Email</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="email" id="email" placeholder="Email..." value="<?=(isset($row['id_supplier']) ? $row['email'] : "")?>">
                                </div>

                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">No NPWP</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="npwp" id="npwp" placeholder="No NPWP..." value="<?=(isset($row['id_supplier']) ? $row['NPWP'] : "")?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Ppn</label>
                                <div class="col-lg-4">
                                    <div class="checkbox">
                                    <label>
                                        <input name="ppn" type="checkbox" class="ace" <?=(isset($row['id_supplier']) ? $ppn=$row['PPn'] : $ppn='2')?> 
                                        <?php 
                                            if($ppn==1){
                                                echo 'checked="checked"';   
                                            }else{
                                            echo '';    
                                            }
                                        ?> /><span class="lbl"></span>
                                     </label>
                                    </div>   
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Keterangan</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan..." value="<?=(isset($row['id_supplier']) ? $row['keterangan'] : "")?>">
                                </div> 
                            </div>

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
	<div id="detail" <?=$class_pane_tab2?> >
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
                    <div class="form-horizontal"> 

                        <div class="form-group">
                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Plafon (Rp)</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="plafon" id="plafon" placeholder="Plafon..." value="<?=(isset($row['id_supplier']) ? $row['plafon_kredit'] : "")?>">
                            </div>

                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Term om payment</label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" name="top" id="top" placeholder="TOP..." value="<?=(isset($row['id_supplier']) ? $row['jatuh_tempo'] : "")?>"> 
                            </div>

                            <label class="col-lg-1 col-sm-2 control-label" style="text-align:left">hari</label>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Mata Uang</label>
                            <div class="col-lg-10">
                                <select id="mata_uang" name="mata_uang" class="select2" style="width: 100%;">
                                    <option value="0">-- Pilih Mata Uang --</option>
                                        <?php 
                                            //CEK JIKA KODE coa_debet ADA MAKA SELECTED	   
                                            (isset($row['id_supplier']) ? $mata_uang=$row['mata_uang'] : $mata_uang='');	   					 					 //UNTUK AMBIL coanya 	
                                            while($rowvalas = mysql_fetch_array($q_ddl_valas)) { ;?>
                                             
                                            <option value="<?php echo $rowvalas['kode_valas'];?>" <?php if($rowvalas['kode_valas']==$mata_uang){echo 'selected';} ?>><?php echo $rowvalas['keterangan'];?> 
                                    </option>
                                        <?php } ?>
                                </select>
                            </div>
                        </div>          

                        <div class="form-group">
                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left"><h3>Bank :</h3></label>
                        </div>    

                        <div class="form-group">
                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Bank</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="nama_bank" id="nama_bank" placeholder="Bank..." value="<?=(isset($row['id_supplier']) ? $row['nama_bank'] : "")?>">
                            </div>

                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Cabang</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="cabang" id="cabang" placeholder="Cabang..." value="<?=(isset($row['id_supplier']) ? $row['cabang'] : "")?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">Atas Nama</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="atas_nama" id="atas_nama" placeholder="Atas nama..." value="<?=(isset($row['id_supplier']) ? $row['atas_nama'] : "")?>">
                            </div>

                            <label class="col-lg-2 col-sm-2 control-label" style="text-align:left">No Rek Bank</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="no_rekening" id="no_rekening" placeholder="No Rek Bank..." value="<?=(isset($row['id_supplier']) ? $row['no_rekening'] : "")?>">
                            </div>
                        </div>                       
                                                                        
                        <div align="center" class="form-group">
                            <a id="next-btn1" class="btn btn-primary"><i class=" fa fa-mail-forward"></i> Next</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>                                  
                
<!-- AKUNTING -->
				<div id="akunting" <?=$class_pane_tab1?> >
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
                                             (isset($row['id_supplier']) ? $coa_debet=$row['coa_debet'] : $coa_debet='');	   					 					 //UNTUK AMBIL coanya 	
                                             while($rowcoadeb = mysql_fetch_array($q_ddl_coa)) { ;?>
                                             
                                                <option value="<?php echo $rowcoadeb['kode_coa'];?>" <?php if($rowcoadeb['kode_coa']==$coa_debet){echo 'selected';} ?>><?php echo $rowcoadeb['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowcoadeb['nama'];?> </option>
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
                                             (isset($row['id_supplier']) ? $coa_kredit=$row['coa_kredit'] : $coa_kredit='');	   					 					 //UNTUK AMBIL coanya 	
                                             while($rowcoakred = mysql_fetch_array($q_ddl_coa2)) { ;?>
                                             
                                                <option value="<?php echo $rowcoakred['kode_coa'];?>" <?php if($rowcoakred['kode_coa']==$coa_kredit){echo 'selected';} ?>><?php echo $rowcoakred['kode_coa'].'&nbsp;&nbsp;||&nbsp;&nbsp;'.$rowcoakred['nama'];?> </option>
                                                   <?php } ?>
                                                </select>
                                                 </div>
                                             </div>         
                                             
                                             <label><b style="color: red;">* &nbsp;Wajib Diisi</b></label>
                                             
                                             <div align="center" class="form-group">
                                             <button class="btn btn-success <?=(isset($row['id_supplier']) ? "update" : "simpan")?>" type="submit" name="<?=(isset($row['id_supplier']) ? "update" : "simpan")?>"><i class="fa fa-pencil"></i> Simpan&nbsp;</button>
                                             <a href="?page=master/supplier" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>
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
                                	
                                    <form method="post" action="">
                                	<div align="right" class="form-group">
                      <label class="col-md-4 control-label" style="text-align:right">Status</label>
                      <div style="text-align: left" class="col-md-3 form-group">
                        <select class="select2" name="status">
                          <option value="semua" <?php if(isset($_POST['cari'])) {if($_POST['status']=='semua'){ echo 'selected';}} ?>>semua</option>
                          <option value="y" <?php if(isset($_POST['cari'])) {if($_POST['status']=='y'){ echo 'selected';}} ?>>aktif</option>
                          <option value="n" <?php if(isset($_POST['cari'])) {if($_POST['status']=='n'){ echo 'selected';}} ?>>nonaktif</option>
                        </select>
                      </div>
                      
                      <div align="left" class="form-group" >
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
                      <th style="text-align: center">Nama</th>
                      <th style="text-align: center">Alamat</th>
                      <th style="text-align: center">Kota</th>
                      <th style="text-align: center">Ppn</th>
                      <th style="text-align: center">Aktif</th>
                      <th style="text-align: center">Action</th>
                    </tr>
                </thead>
                
                <tbody>	
                <?php $no=1; while($res = mysql_fetch_array($q_supp)) { ;?>	
    				<tr>
        				<td style="text-align: center"><?=$no++?></td>
        				<td><a href="<?=base_url()?>?page=master/supplier_track&action=track&id_supplier=<?=$res['id_supplier']?>"><?=$res['kode_supplier']?></a></td>
                        <td><?=$res['nama']?></td>
                        <td><?=$res['alamat']?></td>
                        <td><?=$res['kota']?></td>
                        <td style="text-align: center"><i class="fa fa-<?php echo ($res['PPn']==1)?"check-square-o":"square-o" ; ?>"></i></td>
                        <td style="text-align: center"><?=($res['aktif']=='1' ? '<span class="btn-sm btn-success fa fa-check"></span>' : '<span class="btn-sm btn-danger fa fa-remove"></span>')?></td>
                        <td style="text-align: center"><a class="btn-sm btn-info" href="<?=base_url()?>?page=master/supplier&action=edit&id_supplier=<?=$res['id_supplier']?>" style="font-style:italic;"><i class="fa fa-edit"></i></a> 
                        <?php if ($res['aktif']=='1'){?>
            			<a class="btn-sm btn-danger" href="<?=base_url()?>?page=master/supplier&action=nonaktif&id_supplier=<?=$res['id_supplier']?>" onclick="return confirm('Anda yakin menonaktifkan data ini?')"><i class="fa fa-remove"></i></a> 
                        <?php }else{ ?>
                        <a class="btn-sm btn-success" href="<?=base_url()?>?page=master/supplier&action=aktif&id_supplier=<?=$res['id_supplier']?>"><i class="fa fa-check"></i></a>
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

<script src="<?=base_url()?>assets/select2/select2.js"></script>

<script>
  $(".select2").select2({
        width: '100%'
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
    })
  })
</script>
<script>
	$(document).ready(function(){
	$('#kode_supplier').change(function(){
		$('#pesan').html('<img style="margin-left:1px; width:20px"  src="<?=base_url()?>images/loading.gif">');
		var kode_supplier = $(this).val();

		$.ajax({
			type	: 'POST',
			url 	: '<?=base_url()?>ajax/j_validasi.php?func=loadkode_supplier',
			data 	: 'kode_supplier='+kode_supplier,
			success	: function(data){
				$('#pesan').html(data);
			}
		})

	});
});
</script>
<script type="text/javascript">

	$(document).ready(function(){
		$('.simpan').click(function(){
			
		$span = $(".span");

			if ($('#kode_supplier').val()==''){
				alert("Data Supplier => Kode, belum diisi");
				return false;
			}

			if ($('#nama').val()==''){
				alert("Data Supplier => Nama, belum diisi");
				return false;
			}

            if ($('#coa_debet').val()=='0'){
                alert("Accounting => COA Debet, belum dipilih");
                return false;
            }

            if ($('#coa_kredit').val()=='0'){
                alert("Accounting => COA Kredit, belum dipilih");
                return false;
            }
            
            if($span.text() != ""){
                alert("Kode Sudah Terpakai");
                $('#kode_supplier').focus();
                return false;
            }

            // if ($('#kode_supplier').val()=='')
            // {
            //  alert("Kode tidak Boleh Kosong");
            //  $('#kode_supplier').focus();
            //  return false;
            // }

			// if ($('#alamat').val()==''){
			// 	alert("Data Supplier => Alamat, belum diisi");
			// 	return false;
			// }

			// if ($('#kecamatan').val()==''){
			// 	alert("Data Supplier => Kecamatan, belum diisi");
			// 	return false;
			// }

			// if ($('#kota').val()==''){
			// 	alert("Data Supplier => Kota, belum diisi");
			// 	return false;
			// }

			// if ($('#provinsi').val()==''){
			// 	alert("Data Supplier => Provinsi, belum diisi");
			// 	return false;
			// }

			// if ($('#negara').val()==''){
			// 	alert("Data Supplier => Negara, belum diisi");
			// 	return false;
			// }

			// if ($('#kontak_person').val()==''){
			// 	alert("Data Supplier => Kontak Person, belum diisi");
			// 	return false;
			// }

			// if ($('#telpon').val()==''){
			// 	alert("Data Supplier => No.Telpon, belum diisi");
			// 	return false;
			// }

			// if ($('#hp').val()==''){
			// 	alert("Data Supplier => No.Handphone, belum diisi");
			// 	return false;
			// }

			// if ($('#email').val()==''){
			// 	alert("Data Supplier => Email, belum diisi");
			// 	return false;
			// }

			// if ($('#npwp').val()==''){
			// 	alert("Data Supplier => No.NPWP, belum diisi");
			// 	return false;
			// }

			// if ($('#plafon').val()==''){
			// 	alert("Detail => Plafon(Rp), belum diisi");
			// 	return false;
			// }

			// if ($('#top').val()==''){
			// 	alert("Detail => Term Of Payment, belum diisi");
			// 	return false;
			// }

			// if ($('#mata_uang').val()=='0'){
			// 	alert("Detail => Mata Uang, belum dipilih");
			// 	return false;
			// }

			// if ($('#nama_bank').val()==''){
			// 	alert("Detail => Bank, belum diisi");
			// 	return false;
			// }

			// if ($('#cabang').val()==''){
			// 	alert("Detail => Cabang, belum diisi");
			// 	return false;
			// }

			// if ($('#atas_nama').val()==''){
			// 	alert("Detail => Atas Nama, belum diisi");
			// 	return false;
			// }

			// if ($('#no_rekening').val()==''){
			// 	alert("Detail => No Rek Bank, belum diisi");
			// 	return false;
			// }
			
		});	
	});	

    $(document).ready(function(){
        $('.update').click(function(){
            
        $span = $(".span");

            if ($('#kode_supplier').val()==''){
                alert("Data Supplier => Kode, belum diisi");
                return false;
            }

            if ($('#nama').val()==''){
                alert("Data Supplier => Nama, belum diisi");
                return false;
            }

            if ($('#coa_debet').val()=='0'){
                alert("Accounting => COA Debet, belum dipilih");
                return false;
            }

            if ($('#coa_kredit').val()=='0'){
                alert("Accounting => COA Kredit, belum dipilih");
                return false;
            }
            
            if($span.text() != ""){
                alert("Kode Sudah Terpakai");
                $('#kode_supplier').focus();
                return false;
            }
            
        }); 
    });
</script>