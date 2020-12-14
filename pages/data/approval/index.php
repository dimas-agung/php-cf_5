<div class="box-body">
  <div class="row">
    <div class="tab-content">
      <div id="menuListPp">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <tr align="center">
                    <th>No</th>
                    <th>No PP</th>
                    <th>Opsi</th>
                    <th>No Penawaran</th>
                    <th>Kepada</th>
                    <th>Tanggal</th>
                    <th>Up</th>
                    <th>Status</th>
                    <th>Status Approve</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $penawaran_cmd = "SELECT * FROM penawaran_hdr WHERE status_app='0' AND aktif='1' ORDER BY kode_penawaran,versi ASC";
                    $go = mysql_query($penawaran_cmd);
                    $n=1; if(mysql_num_rows($go) > 0) { 
                    while($data = mysql_fetch_array($go)) { 
					
					$kode = $data['kode_penawaran'];
					$opsi = $data['versi'];
					$ref = $data['ref'];
					
					if($ref>0){
						$no_penawaran = $kode.'_ref_'.$ref.' opsi '.$opsi;
					}else{
						$no_penawaran = $kode.' opsi '.$opsi;	
					}
                       ?>
                  <tr>
                    <td> <?php echo $n++ ?></td>
                    <td><a href="<?=base_url()?>?page=approval/detail&kode=<?=$data['id_penawaran']?>"><?php echo $data['kode_pp'];?></a></td>
                    <td> <?php echo $data['versi'];?></td>
                    <td> <?php echo $no_penawaran;?></td>
                    
                    <td> <?php echo $data['kepada'];?></td>
                    <td> <?php echo date("d-m-Y",strtotime($data['tanggal']));?></td>
                    <td> <?php echo $data['Up'];?></td>
                    <td align="center"><?php if ($data['status']=='0'){echo '<button type="button" class="btn btn-success">OPEN</button>';}elseif($data['status']=='2'){echo '<span class="btn btn-mini fa fa-remove">CLOSE</span>';}else {echo '<button type="button" class="btn btn-danger">BATAL</button>';} ?></td>
                    <td> 
                    	<?php 
                    		$status_app = "-";
                    		switch( $data['status_app'] ) {
                    			case 0 :
                    				$status_app = 'Belum approve';
                    			break;

                    			case 1 :
                    				$status_app = 'Approved';
                    			break;

                    			case 2 :
                    				$status_app = 'Batal';
                    			break;
                    		}

                    		echo $status_app;
                    	?>
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
</div>

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