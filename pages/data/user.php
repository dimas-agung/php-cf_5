<?php include 'script/user.php'; ?>

<section class="content-header">
       
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Setting</a></li>
          <li>
          	<a href="#">Data User</a>

          </li>
        </ol>
        
        		<!-- ALERT -->
    <?php
												
												if(!empty($info))
												{
												echo '<div style="text-align:center" class="alert alert-success"><i class="icon fa fa-check"></i>';
												echo $info;	
												echo '</div>';
												}
												
												if(!empty($warning))
												{
												echo '<div style="text-align:center" class="alert alert-danger"><i class="icon fa fa-remove"></i>';
												echo $warning;	
												echo '</div>';
												}
												?>
												
                                                <!-- END ALERT -->
</section>

            <!-- /.row -->
            <div class="box box-info">
            <div class="box-body">

                             <div class="tabbable">
											<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
												<li class="active">
													<a data-toggle="tab" href="#menuFormPp">Form User</a>
												</li>
                                                <li>
													<a data-toggle="tab" href="#menuListPp">List User</a>
												</li>
                                                
											</ul>
		

			<div class="row">
			<div class="tab-content">
				<div id="menuFormPp" class="tab-pane fade in active">
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-body">
                                 <div class="form-horizontal"> 	
								<?php
									$isEdit = false;
									if(isset($_GET['action']) and $_GET['action'] == "edit") {
										$row = mysql_fetch_array($q_edit);
										$isEdit = true;
									}
								?>
                         
									<form role="form" method="post" action="" id="saveForm">								
										<?php 
											if($isEdit) {
												echo "<input type='hidden' name='kd_user' value='{$row['kd_user']}'>";
											}
										 ?>
                            
							
										<div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Nama <b style="color: red;">*</b></label>
                                            <div class="col-lg-10">
											<input required type="text" name="nama" id="nama" class="form-control" value="<?=($isEdit ? $row['nm_user'] : '')?>" placeholder="Nama..." required>
                                            </div>
										</div>

                                        <div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Hak Akses <b style="color: red;">*</b></label>
                                            <div class="col-lg-10">
											<select id="jabatan" name="jabatan"  class="select2">
                                               <option value="0">-- Pilih Hak Akses --</option>
                                               <?php 
												 //CEK JIKA KODE USER	   
												 ($isEdit ? $level=$row['level'] : $level='');	   					 					 												  	
												 while($rowlevel = mysql_fetch_array($q_ddl_level)) { ;?>
												 
													<option value="<?php echo $rowlevel['kode_role'];?>" <?php if($rowlevel['kode_role']==$level){echo 'selected';} ?>><?php echo $rowlevel['nama'];?> </option>
											   <?php } ?>
                                            </select>
                                            </div>
										</div>

                                        <div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Username <b style="color: red;">*</b></label>
                                            <div class="col-lg-10">
											
                                        	<input required type="text" name="username" id="username" value="<?=($isEdit ? $row['username'] : '')?>" class="form-control" placeholder="Username..." required>    </div>
										</div>

                                         <div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Password <b style="color: red;">*</b></label>
                                            <div class="col-lg-10">
											<input required type="password" name="password" id="password" value="<?=($isEdit ? $row['password'] : '')?>" class="form-control" placeholder="Password..." required>
                                            </div>
										</div>
                                        
                                        <?php if($isEdit=='false'){ ?>
                                        <div class="form-group">
											<label class="col-lg-2 col-sm-2 control-label">Status</label>
                                            <div class="col-lg-10">
                                                <select class="form-control" name="aktif" id="aktif">
                                                
                                                  <option value="1" <?php if($isEdit) {if($row['aktif']=='1'){ echo 'selected';}} ?>>Aktif</option>
                                                  <option value="0" <?php if($isEdit) {if($row['aktif']=='0'){ echo 'selected';}} ?>>Non aktif</option>
                                                </select> 
                                        	</div>
                          				</div>
                                        <?php } ?>
                                        
                                        <label><b style="color: red;">* &nbsp;Wajib Diisi</b></label>

                                  
									 <div align="center" class="form-group">
                     <button class="btn btn-success pb-save" type="submit"  name="<?=($isEdit ? "update" : "simpan")?>"><i class="fa fa-pencil"></i> Simpan&nbsp;</button>
                     <a href="<?=base_url()?>?page=user" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>
                 </div>
										
									</form>

<!-- Tambah Item Proyek       --->

								</div>	
                                </div>
								<!-- /.panel-body -->
							</div>                       
							<!-- /.panel-default -->
						</div>
						<!-- /.col-lg-12 -->					
				</div>
				
				<div id="menuListPp" class="tab-pane fade">					
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-body">								
									<table id="example1" class="table table-striped table-bordered table-hover" >
										<thead>
											<tr align="center">
											  <th style="text-align: center">No</th>
                                              <th style="text-align: center">Nama</th>
                                              <th style="text-align: center">User</th>
                                              <th style="text-align: center">Jabatan</th>
                                              <th style="text-align: center">Aktif</th>
                                              <th style="text-align: center">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$n=1; if(mysql_num_rows($q_user) > 0) { 
												while($data = mysql_fetch_array($q_user)) { 
												$kd_user = $data['kd_user'];
											?>
										        
											<tr>
                                                <td style="text-align: center"> <?php echo $n++ ?></td>
												<td> <?php echo $data['nm_user'];?></td>
												<td> <?php echo $data['username'];?></td>
                                                <td> <?php echo $data['jabatan'];?></td>
                                                <td style="text-align: center">
												<?php if ($data['aktif']=='1'){echo '<span class="btn-sm btn-success"><i class="fa fa-check"></i></span>';}else{echo '<span class="btn-sm btn-danger"><i class="fa fa-remove"></i></span>';} ?>
                                                </td>
												<td style="text-align: center">
                                             	<a class="btn-sm btn-info" href="<?=base_url()?>?page=user&action=edit&kode=<?=$data['kd_user']?>" ><i class="fa fa-edit"></i></a>
                                                <?php if ($data['aktif']=='1'){?>
                                                <a class="btn-sm btn-danger" href="<?=base_url()?>?page=user&action=nonaktif&kode=<?=$data['kd_user']?>" onclick="return confirm('Anda yakin menonaktifkan data ini?')"><i class="fa fa-remove"></i></a> 
                                                <?php }else{ ?>
                                                <a class="btn-sm btn-success" href="<?=base_url()?>?page=user&action=aktif&kode=<?=$data['kd_user']?>"><i class="fa fa-check"></i></a>
                                                <?php } ?>
											 
												</td>
											</tr>
											<?php
												} }
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
			<!-- /.row -->

<script type="text/javascript">
$(document).ready(function(){
    $('.pb-save').click(function(){
       
        if ($('#jabatan').val()=='0'){
            alert("Hak Akses belum dipilih");
            return false;
        }
    });
});
</script>   
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