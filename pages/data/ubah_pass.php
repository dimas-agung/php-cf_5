<?php include 'script/ubahpass.php'; ?>

<section class="content-header">
       
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Setting</a></li>
          <li>
          	<a href="#">Ubah Password</a>

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
												
                                               
                                                
											</ul>
		

			<div class="row">
			<div class="tab-content">
				
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-body">
                                  	
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
												echo "<input type='hidden' name='kd_user' value='{$row['kd_user']}'> <input type='hidden' name='pass_lama_asli' value='{$row['password']}'>";
											}
										 ?>
                            
							
										<div class="form-group">
											<label class="control-label col-md-2 col-sm-2 col-xs-12">Username</label>
                                            <div class="col-md-10">
											<input type="text" disabled name="nama" id="nama" class="form-control" value="<?=($isEdit ? $row['username'] : '')?>" placeholder="username..." required>
                                            </div>
										</div>
                                        <div class="form-group">
											<label class="control-label col-md-2 col-sm-2 col-xs-12">Password Lama</label>
                                            <div class="col-md-10">
											<input type="password" name="pass_lama" id="pass_lama" autofocus autocomplete="off" class="form-control" placeholder="Password Lama..." required>
                                            </div>
										</div>
                                        <div class="form-group">
											<label class="control-label col-md-2 col-sm-2 col-xs-12">Password Baru</label>
                                            <div class="col-md-10">
											<input type="password" name="pass_baru" id="pass_baru" autocomplete="off" class="form-control" placeholder="Password Baru..." required>  
                                        	</div>
										</div>
                                         <div class="form-group">
											<label class="control-label col-md-2 col-sm-2 col-xs-12">Ulangi Password baru</label>
                                            <div class="col-md-10">
											<input type="password" name="pass_ulang" id="pass_ulang" autocomplete="off" class="form-control" placeholder="Ulangi Password Baru..." required> 
                                            </div>
										</div>
                                        <div><br>&nbsp;</div>
                                  
									 <div align="center" class="form-group">
                     <button class="btn btn-success" type="submit"  name="<?=($isEdit ? "update" : "simpan")?>"><i class="fa fa-pencil"></i> Simpan&nbsp;</button>
                     <a href="<?=base_url()?>?index.php" class="btn btn-danger"><i class=" fa fa-reply"></i> Batal</a>
                						
									</form>

<!-- Tambah Item Proyek       --->

									
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