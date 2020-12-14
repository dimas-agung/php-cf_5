<?php

	session_start();
	include "library/conn.php";
	include "library/helper.php";
	date_default_timezone_set("Asia/Jakarta");

  $kode_fj = @$_GET['kode_fj'];

  $fj_hdr = mysql_query("SELECT fh.*, p.nama AS nama_pelanggan, c.nama AS nama_cabang, g.nama AS nama_gudang FROM fj_hdr fh
              LEFT JOIN cabang c ON c.kode_cabang = fh.kode_cabang
              LEFT JOIN gudang g ON g.kode_gudang = fh.kode_gudang
              LEFT JOIN pelanggan p ON p.kode_pelanggan = fh.kode_pelanggan
              WHERE fh.kode_fj = '".$kode_fj."' ");

	$fj_dtl = mysql_query("SELECT * FROM fj_dtl a LEFT JOIN fj_hdr b ON b.kode_fj = a.kode_fj LEFT JOIN sj_dtl c ON c.kode_sj = b.kode_sj WHERE kode_fj = '".$kode_fj."' order by kode_fj ASC");
	  
?>    

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Faktur Penjualan</title>
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
       $res_hdr = mysql_fetch_array($fj_hdr); 
    ?>  

    <header class="clearfix">
       
      <h1>Surat Jalan</h1>
        <div id="company" class="clearfix">
          <table class="table1">
              <tr><td>CABANG</td><td> : </td><td><?=@$res_hdr['nama_cabang']?></td></tr>
              <tr><td>PELANGGAN</td><td> : </td><td><?=@$res_hdr['nama_pelanggan']?></td></tr>
              <tr><td>GUDANG</td><td> : </td><td><?=$res_hdr['nama_gudang']?></td></tr>
              <tr><td>SALESMAN</td><td> : </td><td><?=@$res_hdr['salesman']?></td></tr>
          </table>
        </div> 
        <div id="project">
          <table class="table1">
              <tr><td>KODE FJ</td><td> : </td><td><?=@$res_hdr['kode_fj']?></td></tr>
              <tr><td>KODE SJ</td><td> : </td><td><?=@$res_hdr['kode_sj']?></td></tr>
              <tr><td>TANGGAL FJ</td><td> : </td><td><?=tgl_indo(@$res_hdr['tgl_buat'])?></td></tr>
              
          </table>
      </div>
      </header>
      <main>
      
      <?php if(isset($fj_dtl)){ ?>
				<div>
					<table class="gridtable" width="100%">
						<thead>
                <tr>
                  <th>No</th>
                  <th>Nama Barang</th>
                  <th>QTY</th>
                  <th>Harga</th>
                  <th>Disc(%)</th>
                  <th>Jumlah</th>
                </tr>
						</thead>
						<tbody>
						  <?php 
                $no=1; 
                $ppn=1; 
                $grand_tot=1; 
                  while($res_dtl = mysql_fetch_array($fj_dtl)) {  

                  	$diskon =$res_dtl['diskon1']+$res_dtl['diskon2'];
              ?>
                                                      <tr>
                                                          <td style="text-align: center"><?=$no++?></td>
                                                          <td><?=$res_dtl['kode_barang'].'&nbsp;||&nbsp;'.$res_dtl['nama_barang']?></td>
                                                          <td style="text-align: right;"><?=$res_dtl['qty']?></td>
                                                          <td style="text-align: right;"><?=$res_dtl['total_harga']?></td>
                                                          <td style="text-align: right;"><?=$diskon?></td>
                                                          <td style="text-align: right;"><?= $res_dtl['total_harga'];?></td>
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


 