<?php

	session_start();
	include "library/conn.php";
	include "library/helper.php";
	date_default_timezone_set("Asia/Jakarta");

  $kode_so = @$_GET['kode_so'];

  $so_hdr = mysql_query("SELECT sh.kode_so, SUBSTRING_INDEX(sh.kode_pelanggan, ':', 1) kode_pelanggan, p.nama AS nama_pelanggan, sh.tgl_buat, sh.alamat, sh.ref , sh.alamat_kirim, sh.kode_cabang, c.nama AS nama_cabang, sh.tgl_kirim, sh.kode_gudang, g.nama AS nama_gudang, sh.top, sh.kode_salesman, sh.keterangan_hdr, sh.status FROM so_hdr sh
              LEFT JOIN cabang c ON c.kode_cabang = sh.kode_cabang
              LEFT JOIN gudang g ON g.kode_gudang = sh.kode_gudang
              LEFT JOIN pelanggan p ON p.kode_pelanggan = SUBSTRING_INDEX(sh.kode_pelanggan, ':', 1)
              LEFT JOIN so_um u ON u.kode_so = sh.kode_so
              WHERE sh.kode_so = '".$kode_so."' ");

	$so_dtl = mysql_query("SELECT * FROM so_dtl WHERE kode_so ='".$kode_so."' order by kode_so ASC");
	  
?>    

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Sales Order</title>
    <style type="text/css">
      /* KELAS UNTUK PAGE BREAK */
      .break
      {
        page-break-before: always;
        /* page-break-inside: avoid; */
      }
    </style>
    <link rel="stylesheet" href="<?=base_url();?>datatables/css/style_laporan.css" media="all" />
  </head>
  <body style="font-family:'Courier New', Courier, monospace">

    <?php
       $res_hdr = mysql_fetch_array($so_hdr); 
    ?>  

    <header class="clearfix">
       
      <h1>Sales Order</h1>
        <div id="company" class="clearfix">
          <table class="table1">
              <tr><td>CABANG</td><td> : </td><td><?=@$res_hdr['nama_cabang']?></td></tr>
              <tr><td>PELANGGAN</td><td> : </td><td><?=@$res_hdr['nama_pelanggan']?></td></tr>
              <tr><td>GUDANG</td><td> : </td><td><?=$res_hdr['nama_gudang']?></td></tr>
          </table>
        </div> 
        <div id="project">
          <table class="table1">
              <tr><td>KODE SO</td><td> : </td><td><?=@$res_hdr['kode_so']?></td></tr>
              <tr><td>TANGGAL SO</td><td> : </td><td><?=tgl_indo(@$res_hdr['tgl_buat'])?></td></tr>
          </table>
      </div>
      </header>
      <main>
      
      <?php if(isset($so_dtl)){ ?>
				<div>
					<table class="gridtable" width="100%">
						<thead>
                <tr>
                  <th>No</th>
                  <th>Kode</th>
                  <th>Deskripsi Barang</th>
                  <th>Satuan</th>
                  <th>QTY</th>
                  <th>Keterangan</th>
                </tr>
						</thead>
						<tbody>
						  <?php 
                $no=1; 
                $ppn=1; 
                $satuan = '';
                $grand_tot=1; 
                  while($res_dtl = mysql_fetch_array($so_dtl)) {  
				              
                      if($res_dtl['satuan'] == ''){
                        $satuan = $res_dtl['satuan_jual'];
                      }else{
                        $satuan = $res_dtl['satuan'];
                      }
              ?>
                                                      <tr>
                                                          <td style="text-align: center"><?=$no++?></td>
                                                              <td><?=$res_dtl['kode_barang']?></td>
                                                              <td><?=$res_dtl['nama_barang']?></td>
                                                              <td><?=$satuan?></td>
                                                              <td style="text-align: right;"><?= number_format($res_dtl['qty'])?></td>
                                                              <td><?=$res_dtl['keterangan_dtl']?></td>
                                                        </tr>

                                                        <?php } ?>
				    </tbody>
					</table>
				</div>
			<?php } ?>	


      <div id="notices" style="font-size: 15px ; padding-top: 15px">
        <div>Keterangan: <?=@$res_hdr['keterangan_hdr']?></div>
      </div>

    </main>
    <!-- <footer>
      Invoice was created on a computer and is valid without the signature and seal.
    </footer> -->
  </body>
</html>

<script>
    // window.print();
</script>


