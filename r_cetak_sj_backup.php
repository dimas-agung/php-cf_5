<?php

	session_start();
	include "library/conn.php";
	include "library/helper.php";
	date_default_timezone_set("Asia/Jakarta");

  $kode_sj = @$_GET['kode_sj'];

  $sj_hdr = mysql_query("SELECT sh.kode_sj, sh.kode_pelanggan, p.nama AS nama_pelanggan, sh.tgl_buat, sh.alamat, sh.ref , sh.kode_cabang, c.nama AS nama_cabang, sh.kode_gudang, g.nama AS nama_gudang, sh.keterangan_hdr, sh.status FROM sj_hdr sh
              LEFT JOIN cabang c ON c.kode_cabang = sh.kode_cabang
              LEFT JOIN gudang g ON g.kode_gudang = sh.kode_gudang
              LEFT JOIN pelanggan p ON p.kode_pelanggan = sh.kode_pelanggan
              WHERE sh.kode_sj = '".$kode_sj."' ");

	$sj_dtl = mysql_query("SELECT * FROM sj_dtl WHERE kode_sj ='".$kode_sj."' order by kode_sj ASC");
	  
?>    

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Surat Jalan</title>
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
       $res_hdr = mysql_fetch_array($sj_hdr); 
    ?>  

    <header class="clearfix">
       
      <h1>Surat Jalan</h1>
        <div id="company" class="clearfix">
          <table class="table1">
              <tr><td>CABANG</td><td> : </td><td><?=@$res_hdr['nama_cabang']?></td></tr>
              <tr><td>PELANGGAN</td><td> : </td><td><?=@$res_hdr['nama_pelanggan']?></td></tr>
              <tr><td>GUDANG</td><td> : </td><td><?=$res_hdr['nama_gudang']?></td></tr>
          </table>
        </div> 
        <div id="project">
          <table class="table1">
              <tr><td>KODE SJ</td><td> : </td><td><?=@$res_hdr['kode_sj']?></td></tr>
              <tr><td>TANGGAL SJ</td><td> : </td><td><?=tgl_indo(@$res_hdr['tgl_buat'])?></td></tr>
          </table>
      </div>
      </header>
      <main>
      
      <?php if(isset($sj_dtl)){ ?>
				<div>
					<table class="gridtable" width="100%">
						<thead>
                <tr>
                  <th>No</th>
                  <th>Kode SO</th>
                  <th>Kode Barang</th>
                  <th>Deskripsi Barang</th>
                  <th>QTY SO</th>
                  <th>QTY DIKIRIM</th>
                  <th>Keterangan</th>
                </tr>
						</thead>
						<tbody>
						  <?php 
                $no=1; 
                $ppn=1; 
                $satuan_so = '';
                $grand_tot=1; 
                  while($res_dtl = mysql_fetch_array($sj_dtl)) {  
				              
                      if($res_dtl['satuan_qty_so1'] == '-'){
                        $satuan_so = $res_dtl['qty_so2'].'&nbsp;&nbsp;'.$res_dtl['satuan_qty_so2'];
                      }else{
                        $satuan_so = $res_dtl['qty_so1'].'&nbsp;&nbsp;'.$res_dtl['satuan_qty_so1'];
                      }
              ?>
                                                      <tr>
                                                          <td style="text-align: center"><?=$no++?></td>
                                                          <td><?=$res_dtl['kode_so']?></td>
                                                          <td><?=$res_dtl['kode_inventori']?></td>
                                                              <td><?=$res_dtl['nama_inventori']?></td>
                                                              <td style="text-align: right;"><?=$satuan_so?></td>
                                                         <td style="text-align: right;"><?= $res_dtl['qty_dikirim'].'&nbsp;&nbsp;'.$res_dtl['satuan_dikirim'];?></td>
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


