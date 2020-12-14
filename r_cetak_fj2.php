<?php
	include "library/conn.php";
	include "library/helper.php";
	date_default_timezone_set("Asia/Jakarta");

	// $nama_dokumen='FORM FAKTUR JUAL - ' . date('d-m-Y') . ' - ' . date('h.i.s'); //Beri nama file PDF hasil.
	// define('_MPDF_PATH','MPDF60/');
	// include(_MPDF_PATH . "mpdf.php");
	// $mpdf=new mPDF('utf-8', 'A4-L','','','10','10','40','18'); // Create new mPDF Document kanan kiri atas bawah
?>



<div id="printSection">
    <div class="row">
        <div class="col-xs-12" >
        	<div>
    			<h2><!-- FAKTUR PENJUALAN --></h2>
    		</div>

    		<br>

    		<div class="row">
    			<div class="col-xs-2 text-right">
    				
                </div>  
    			<div class="col-xs-6 text-left" style="font-family: TimesNewRowman;">
    				<table width="1151">

    					<?php 
						    $kode_fj  = $_GET['kode_fj'];
						    $q_header = mysql_query("SELECT fjh.*, p.nama as nama_pelanggan, p.alamat, p.kota FROM fj_hdr fjh 
						                              LEFT JOIN pelanggan p ON p.kode_pelanggan = fjh.kode_pelanggan 
						                              WHERE kode_fj='".$kode_fj."' "); 
						    $data     = mysql_fetch_array($q_header);

						    $kode_fj     	= $data['kode_fj'];
						    $tgl         	= tgl_indo($data['tgl_buat']);
						    $pembayaran  	= "-";
						    $jatuh_tempo 	= tgl_indo($data['tgl_jth_tempo']);
						    $kpd         	= $data['nama_pelanggan'];
						    $nama_pelanggan = $data['nama_pelanggan'];
						    $alamat 		= $data['alamat'];
						    $kota 			= $data['kota'];
						?>

				          <tr>
				            <td width="410" align="right"><!-- No.Faktur --></td> 
				            <td width="296" align="left" style="font-weight:bold;"><?=$kode_fj?></td>
                            <td width="35"></td>
                            <td width="390"></td>
                            
				          </tr>
				          <tr>
				            <td align="right" ><!-- Tgl. --></td> 
				            <td align="left" style="font-weight:bold;"> <?=$tgl?></td>
                            <td></td>
                            <td align="left" style="font-weight:bold;"><?=$nama_pelanggan?></td>
                            
				          </tr>
				          <tr>
				            <td align="right" ><!-- Pembayaran --></td>
				            <td align="left" style="font-weight:bold;"> <?=$pembayaran?></td>
                            <td></td>
                            <td align="left" style="font-weight:bold;"><?=$alamat?></td>
				          </tr>
				          <tr>
				            <td align="right" ><!-- Jatuh Tempo --></td> 
				            <td align="left" style="font-weight:bold;"> <?=$jatuh_tempo?></td>
                            <td></td>
				          
				           	<td align="left" style="font-weight:bold;"><?=$kota?></td>
				          
				          	
				          
				          	
				          
				          	
				          </tr>
				      </table>
   			  </div>
    			
   		  </div>
    	</div>
    </div>

    <br>
    
		    <div class="row">
		    	<div class="col-md-12">
    					<table class="tengah" style="width:100%">
							<thead>
								<tr>
						            <th width="5%"><!-- No --></th>
						            <th colspan="2"><!-- NAMA BARANG --></th>
						            <th colspan="2"><!-- QUANTITY --></th>
						            <th width="9%"><!-- HARGA --></th>
									<th width="3%"><!-- DISC. --></th>
									<th width="14%"><!-- JUMLAH --></th>
								</tr>
							</thead>
							<br>
							<tbody>
					            <?php
									$n=1;
					              	$kode_fj = $_GET['kode_fj'];
					              	$q_dtl = mysql_query("SELECT sjd.nama_inventori AS nama_barang, sjd.satuan AS qty_awal, sjd.qty_so AS qty, sjd.satuan_qty_so AS satuan, sjd.tot_qty, fjd.harga_jual AS harga, (fjd.diskon1+fjd.diskon2) AS diskon, fjd.total_harga, fjh.subtotal, fjh.diskon_all, fjh.ppn_all, fjh.grand_total FROM fj_dtl fjd
					                                    LEFT JOIN fj_hdr fjh ON fjh.kode_fj = fjd.kode_fj
					                                    LEFT JOIN sj_dtl sjd ON sjd.kode_sj = fjh.kode_sj AND sjd.kode_inventori = fjd.kode_barang
					                                    WHERE fjd.kode_fj = '".$kode_fj."'
					                                    ORDER BY id_fj_dtl ASC"); 

					                if(mysql_num_rows($q_dtl) > 0) { 
								    while($data_dtl = mysql_fetch_array($q_dtl)) { 

					              	$qty = $data_dtl['qty'].$data_dtl['satuan'];
								?>
								<tr>
								    <td align="right" style="font-weight:bold" width="5%"><?=$n++?></td>
								    <td width="30%"><?=$data_dtl['nama_barang']?></td>
								    <td width="23%" align="left">@&nbsp;<?=$data_dtl['qty_awal']?>&nbsp;</td>
								    <td width="8%" align="right"><?= $qty ?>&nbsp;</td>
								    <td width="8%" align="right"><?=$data_dtl['tot_qty']?>&nbsp;</td>
								    <td align="center"><?=number_format($data_dtl['harga'])?>&nbsp;</td>
								    <td align="left" width="3%"><?=$data_dtl['diskon']?></td>
								    <td align="right"><?=number_format($data_dtl['total_harga'])?>&nbsp;</td>
								</tr>

								<?php 
			                        $subtotal_all = $data_dtl['subtotal'];
			                        } 
			                    ?>  

								<tr>
			                        <td colspan="7" style="text-align:right; font-weight:bold"><!-- TOTAL --> <br></td>
			                        <td style="text-align:right ; font-weight:bold"><?= number_format($subtotal_all)?>&nbsp;</td>
			                    </tr>
			                    <tr>
			                        <td colspan="7" style="text-align:right; font-weight:bold"><!-- NETTO --></td>
			                        <td style="text-align:right ; font-weight:bold"><?= number_format($subtotal_all)?>&nbsp;</td>
			                    </tr>
					          	<?php }?>    
							</tbody>
			    		</table>
		    	</div>
		    </div>

		    <div class="col-xs-12" style="font-family: TimesNewRowman;">
    			<table>
				    <tr>
				    	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				        <td align="left" style="font-size: 13px"><!-- Tanda Terima --></td>
				        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				        <td align="left" style="font-size: 13px;"><!-- Ket. --> </td>
				        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				        <td align="right" style="font-size: 13px;"><!-- Hormat Kami --></td>
				    </tr>
				</table>
    		</div>
</div>

<style type="text/css">
	@media screen {
	  #printSection {
		display: none;
	  }
	}

	@media print {
	  body * {
		visibility:hidden;
	  }
	  #printSection, #printSection * {
		visibility:visible;
	  }
	  #printSection {
		position:absolute;
		left:0;
		top:0;
		width:100%;
		height:100%;
		background: yellow;
	  }
	}
</style>

<script>
	window.print();
</script>