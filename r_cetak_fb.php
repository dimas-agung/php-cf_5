<?php

	session_start();
	include "library/conn.php";
	include "library/helper.php";
	date_default_timezone_set("Asia/Jakarta");

  $kode_fb = @$_GET['kode_fb'];

  $fb_hdr = mysql_query("SELECT fh.kode_fb, fh.kode_supplier, s.nama AS nama_supplier, fh.ref, fh.tgl_jth_tempo, fh.tgl_buat, fh.kode_cabang, c.nama AS nama_cabang, fh.keterangan_hdr, fh.status FROM fb_hdr fh
                LEFT JOIN cabang c ON c.kode_cabang = fh.kode_cabang
                LEFT JOIN supplier s ON s.kode_supplier = fh.kode_supplier
                WHERE fh.kode_fb = '".$kode_fb."'");

	$fb_dtl = mysql_query("SELECT * FROM fb_dtl WHERE kode_fb='".$kode_fb."' order by kode_btb ASC");

  $fb_dtl1 = mysql_query("SELECT SUM(harga) AS total_harga, SUM(nilai_ppn) AS total_ppn, SUM(subtot) AS grand_total FROM fb_dtl fb WHERE kode_fb='".$kode_fb."'");
	  
?>    

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Faktur Pembelian</title>
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
          // HEADER
          $res_hdr = mysql_fetch_array($fb_hdr); 
    ?>  

    <header class="clearfix">
       
      <h1>Faktur Pembelian</h1>
        <div id="company" class="clearfix">
          <table class="table1">
              <tr><td>CABANG</td><td> : </td><td><?=@$res_hdr['nama_cabang']?></td></tr>
              <tr><td>SUPPLIER</td><td> : </td><td><?=@$res_hdr['nama_supplier']?></td></tr>
          </table>
        </div> 
        <div id="project">
          <table class="table1">
              <tr><td>Kode FB</td><td> : </td><td><?=@$res_hdr['kode_fb']?></td></tr>
              <tr><td>Tgl FB</td><td> : </td><td><?=tgl_indo(@$res_hdr['tgl_buat'])?></td></tr>
              <tr><td>Tgl Jatuh Tempo</td><td> : </td><td><?=tgl_indo(@$res_hdr['tgl_jth_tempo'])?></td></tr>
          </table>
      </div>
      </header>
      <main>
      
      <?php if(isset($fb_dtl)){ ?>
				<div>
					<table class="gridtable" width="100%">
						<thead>
                <tr>
                  <th style="width: 10px">No</th>
                                                            <th style="width: 250px">Barang</th>
                                                            <th style="width: 160px">Doc PO</th>
                                                            <th style="width: 160px">Doc BTB</th>
                                                            <th style="width: 150px">Deskripsi</th>
                                                            <th style="width: 150px">Harga</th>
                                                            <th style="width: 150px">Ppn</th>
                                                            <th style="width: 150px">Subtotal</th>
                                                            <th>Keterangan</th>
                </tr>
						</thead>
						<tbody>
						  <?php 
                $no=1; 
                $ppn=1; 
                $grand_tot=1; 
                  while($res_dtl = mysql_fetch_array($fb_dtl)) {  
				              

                          ?>
                                                      <tr>
                                                          <td style="text-align: center"> <?= $no++ ?></td>
                                                            <td><?=$res_dtl['kode_barang']?></td>
                                                            <td><?=$res_dtl['kode_op']?></td>
                                                            <td><?=$res_dtl['kode_btb']?></td>
                                                            <td><?=$res_dtl['deskripsi']?></td>
                                                            <td id="harga" style="text-align: right;"><?= number_format($res_dtl['harga'])?></td>
                                                            <td id="nilai_ppn" style="text-align: right;"><?= number_format($res_dtl['nilai_ppn'])?></td>
                                                            <td id="subtot" style="text-align: right;"><?= number_format($res_dtl['subtot'])?></td>
                                                            <td><?=$res_dtl['keterangan_dtl']?></td>
                                                        </tr>

                                                        <?php } ?>

                                                        <?php
                                                        $no = 1;
                                                        while($res_dtl1 = mysql_fetch_array($fb_dtl1)) { 
                                                    ?>
                                                        <tr>
                                                            <td colspan="7" style="text-align:right"><b>Subtotal</b></td>
                                                            <td style="text-align:right; font-weight:bold"><?=number_format($res_dtl1['total_harga'])?></td>
                                                            <td></td>
                                                        </tr>
                    
                                                        <tr>
                                                            <td colspan="7" style="text-align:right"><b>Ppn</b></td>
                                                            <td style="text-align:right; font-weight:bold"><?=number_format($res_dtl1['total_ppn'])?></td>
                                                            <td></td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td colspan="7" style="text-align:right; font-weight:bold">Total</td>
                                                            <td style="text-align:right; font-weight:bold"><?=number_format($res_dtl1['grand_total'])?></td>
                                                            <td></td>
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


