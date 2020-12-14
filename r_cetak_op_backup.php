<?php

	session_start();
	include "library/conn.php";
	include "library/helper.php";
	date_default_timezone_set("Asia/Jakarta");

  $kode_op = @$_GET['kode_op'];

  $op_hdr = mysql_query("SELECT oh.kode_op, oh.kode_supplier, s.nama as nama_supplier, oh.ref, oh.tgl_buat, oh.kode_cabang, c.nama as nama_cabang, oh.keterangan_hdr, jatuh_tempo top, oh.status FROM op_hdr oh
                LEFT JOIN cabang c ON c.kode_cabang = oh.kode_cabang
                LEFT JOIN supplier s ON s.kode_supplier = oh.kode_supplier 
                WHERE oh.kode_op = '".$kode_op."' ");

	$op_dtl = mysql_query("SELECT * FROM op_dtl WHERE kode_op = '".$kode_op."' ");
	  
?>    

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Order Pembelian</title>
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
          $res_hdr = mysql_fetch_array($op_hdr); 
    ?>  

    <header class="clearfix">
       
      <h1>Order Pembelian</h1>
        <div id="company" class="clearfix">
          <table class="table1">
              
          </table>
        </div> 
        <div id="project">
          <table class="table1">
              <tr><td>KODE OP</td><td> : </td><td><?=@$res_hdr['kode_op']?></td></tr>
              <tr><td>CABANG</td><td> : </td><td><?=$res_hdr['nama_cabang']?></td></tr>
              <tr><td>SUPPLIER</td><td> : </td><td><?=@$res_hdr['ref']?></td></tr>
              <tr><td>TANGGAL OP</td><td> : </td><td><?=tgl_indo(@$res_hdr['tgl_buat'])?></td></tr>
          </table>
      </div>
      </header>
      <main>
      
      <?php if(isset($op_dtl)){ ?>
				<div>
					<table class="gridtable" width="100%">
						<thead>
                <tr>
                  <th width="3%">No</th>
                  <th width="30%">Barang</th>
                  <th width="10%">Satuan</th>
                  <th width="10%">Qty</th>
                  <th width="30%">Gudang</th>
                  <th width="10%">Harga</th>
                  <th width="10%">Diskon</th>
                  <th width="10%">PPN</th>
                  <th width="10%">Subtotal</th>
                  <th width="20%">Note</th>
                </tr>
						</thead>
						<tbody>
						  <?php 
                $no=1; 
                $ppn=1; 
                $grand_tot=1; 
                  while($item = mysql_fetch_array($op_dtl)) {  
				              $tot_atas = $item['subtot'];  
                      $total1   = $item['qty']*($item['harga']-$item['diskon']);

                                                        if ($item['ppn'] == 1){
                                                            $ppn     += $tot_atas*0.1;
                                                        }else{
                                                            $ppn     += 0;
                                                        }

                                                        $grand_tot  += $tot_atas;
                                                        $total       = $grand_tot-$ppn;

                                                        $kd_barang   = '';
                                                        $nm_barang   = '';
                                                        $kode_barang = $item['kode_barang'];
                                                            if(!empty($kode_barang)) {
                                                            $pisah=explode(":",$kode_barang);
                                                            $kd_barang=$pisah[0];
                                                            $nm_barang=$pisah[1];
                                                            }

                                                        $kd_gudang   = '';
                                                        $nm_gudang   = '';
                                                        $kode_gudang = $item['kode_gudang'];
                                                            if(!empty($kode_gudang)) {
                                                            $pisah=explode(":",$kode_gudang);
                                                            $kd_gudang=$pisah[0];
                                                            $nm_gudang=$pisah[1];
                                                            }

                                                        $nm_divisi   = '';
                                                        $divisi = $item['divisi'];
                                                            if(!empty($divisi)) {
                                                            $pisah=explode(":",$divisi);
                                                            $nm_divisi=$pisah[1];
                                                            }

                                                        $nm_satuan   = '';
                                                        $satuan = $item['satuan'];
                                                            if(!empty($satuan)) {
                                                            $pisah=explode(":",$satuan);
                                                            $nm_satuan=$pisah[1];
                                                            }

                          ?>
                                                      <tr>
                                                          <td style="text-align: center;"><?=$no++?></td>
                                                            <td><?=$kd_barang.'||'.$nm_barang?></td>
                                                            <td><?=$nm_satuan?></td>
                                                            <td style="text-align: right;"><?=$item['qty']?></td>
                                                            <td><?=$nm_gudang?></td>
                                                            <td style="text-align: right;"><?=number_format($item['harga'])?></td>
                                                            <td style="text-align: right;"><?=number_format($item['diskon'])?></td>
                                                            <td style="text-align: center;"><?=$item['ppn']=='1' ? 
                                                                    '<p>
                                                                        v
                                                                     </p>' 
                                                                    :
                                                                    '<p> 
                                                                        -
                                                                    </p>'
                                                                ?>  
                                                            </td>
                                                            <td style="text-align: right;"><?=number_format($item['subtot'])?></td>
                                                            <td><?=$item['keterangan_dtl']?></td>
                                                        </tr>

                                                        <?php } ?>

                                                        <tr>
                                                            <td colspan="8" style="text-align:right"><b>Total</b></td>
                                                            <td style="text-align:right; font-weight:bold;"><?=number_format($total)?></td>
                                                            <td colspan="2"></td>
                                                        </tr>
                    
                                                        <tr>
                                                            <td colspan="8" style="text-align:right"><b>Ppn</b></td>
                                                            <td style="text-align:right; font-weight:bold;"><?=number_format($ppn)?></td>
                                                            <td colspan="2"></td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td colspan="8" style="text-align:right"><b>Grandtotal</b></td>
                                                            <td style="text-align:right; font-weight:bold;"><?=number_format($grand_tot)?></td>
                                                            <td colspan="2"></td>
                                                        </tr>
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


