<?php

	session_start();
	include "library/conn.php";
	include "library/helper.php";
	date_default_timezone_set("Asia/Jakarta");

  $kode_btb = @$_GET['kode_btb'];

  $btb_hdr = mysql_query("SELECT bh.kode_btb, bh.kode_supplier, s.nama AS nama_supplier, bh.ref, bh.kode_op, bh.tgl_buat, bh.kode_cabang, c.nama AS nama_cabang, bh.kode_gudang, g.nama AS nama_gudang, bh.keterangan_hdr, bh.status FROM btb_hdr bh
                LEFT JOIN op_hdr oh ON oh.kode_op = bh.kode_op
                LEFT JOIN cabang c ON c.kode_cabang = bh.kode_cabang
                LEFT JOIN supplier s ON s.kode_supplier = bh.kode_supplier
                LEFT JOIN gudang g ON g.kode_gudang = bh.kode_gudang
                WHERE bh.kode_btb = '".$kode_btb."' ");

	$btb_dtl = mysql_query("SELECT SUBSTRING_INDEX(bd.kode_barang, ':', 1) AS kode_barang, i.nama nama_barang, SUBSTRING_INDEX(bd.satuan2, ' : ', 1) AS kode_satuan, s.nama nama_satuan, qty_op, qty, keterangan_dtl, qty_i
                FROM btb_dtl bd
                LEFT JOIN satuan s ON s.kode_satuan = SUBSTRING_INDEX(bd.satuan2, ' : ', 1)
                LEFT JOIN inventori i ON i.kode_inventori = SUBSTRING_INDEX(bd.kode_barang, ':', 1)
                WHERE bd.kode_btb = '".$kode_btb."'
                GROUP BY bd.kode_barang
                ORDER BY bd.kode_barang ASC");
	  
?>    

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Bukti Terima Barang</title>
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
          $res_hdr = mysql_fetch_array($btb_hdr); 
    ?>  

    <header class="clearfix">
       
      <h1>Bukti Terima Barang</h1>
        <div id="company" class="clearfix">
          <table class="table1">
              <tr><td>CABANG</td><td> : </td><td><?=@$res_hdr['nama_cabang']?></td></tr>
              <tr><td>SUPPLIER</td><td> : </td><td><?=@$res_hdr['nama_supplier']?></td></tr>
              <tr><td>GUDANG</td><td> : </td><td><?=$res_hdr['nama_gudang']?></td></tr>
          </table>
        </div> 
        <div id="project">
          <table class="table1">
              <tr><td>KODE BTB</td><td> : </td><td><?=@$res_hdr['kode_btb']?></td></tr>
              <tr><td>KODE OP</td><td> : </td><td><?=@$res_hdr['kode_op']?></td></tr>
              <tr><td>TANGGAL BTB</td><td> : </td><td><?=tgl_indo(@$res_hdr['tgl_buat'])?></td></tr>
          </table>
      </div>
      </header>
      <main>
      
      <?php if(isset($btb_dtl)){ ?>
				<div>
					<table class="gridtable" width="100%">
						<thead>
                <tr>
                  <th>No</th>
                  <th>Kode</th>
                  <th>Deskripsi Barang</th>
                  <th>Satuan</th>
                  <th>Sisa Q OP</th>
                  <th>Q Diterima</th>
                  <th>Keterangan</th>
                </tr>
						</thead>
						<tbody>
						  <?php 
                $no=1; 
                $ppn=1; 
                $grand_tot=1; 
                  while($res_dtl = mysql_fetch_array($btb_dtl)) {  

                    $qty = $res_dtl['qty_i'];
                    // $qty_isian = $qty*$res_dtl['qty'];
                    // $qty_op = $res_dtl['qty_op']/$qty_isian;
                    
                    $qty_op = $res_dtl['qty_op'];
                    $qty_op = ($qty_op/$res_dtl['qty']) * $qty;
				              

                          ?>
                                                      <tr>
                                                          <td style="text-align: center"><?=$no++?></td>
                                                              <td><?=$res_dtl['kode_barang']?></td>
                                                              <td><?=$res_dtl['nama_barang']?></td>
                                                              <td><?=$res_dtl['nama_satuan']?></td>
                                                              <td style="text-align: right;"><?= number_format($qty_op)?></td>
                                                              <td style="text-align: right;"><?= number_format($qty)?></td>
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


