<?php

session_start();
include "library/conn.php";
include "library/helper.php";
date_default_timezone_set("Asia/Jakarta");

$kode_fj = @$_GET['kode_fj'];

$fj_hdr = mysql_query("SELECT fh.*, p.nama AS nama_pelanggan, p.alamat AS alamat, p.kota AS kota, c.nama AS nama_cabang, g.nama AS nama_gudang FROM fj_hdr fh
		  LEFT JOIN cabang c ON c.kode_cabang = fh.kode_cabang
		  LEFT JOIN gudang g ON g.kode_gudang = fh.kode_gudang
		  LEFT JOIN pelanggan p ON p.kode_pelanggan = fh.kode_pelanggan
		  WHERE fh.kode_fj = '".$kode_fj."' ");

$fj_dtl = mysql_query("SELECT * FROM fj_dtl a LEFT JOIN fj_hdr b ON b.kode_fj = a.kode_fj LEFT JOIN sj_dtl c ON c.kode_sj = b.kode_sj and c.kode_inventori = a.kode_barang LEFT JOIN inventori d ON d.kode_inventori = a.kode_barang LEFT JOIN sj_hdr e ON e.kode_sj = c.kode_sj  WHERE a.kode_fj = '".$kode_fj."' and d.kategori <> 'BS' order by a.kode_fj ASC");

$res_hdr = mysql_fetch_array($fj_hdr); 

require_once __DIR__ . '/composer/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
]);

$tableContent = '';
if (mysql_num_rows($fj_dtl) > 0) {
	$no = 1; 
	$grandtotal = [];
	$subtotal = 0;
	$diskon1x = 0;
	$diskon2x = 0;
	$diskon3x = 0;
	$alamat = null;
	$total = array();
	while($res_dtl = mysql_fetch_array($fj_dtl)) {
		$satuan_beli = explode(':', trim($res_dtl['satuan_beli']));
		$satuan_beli = count($satuan_beli) > 0 ? $satuan_beli[1] : '';
		$diskon1 = $res_dtl['diskon1'];
		$diskon2 = $res_dtl['diskon2'];
		$diskon3 = $res_dtl['diskon3'];
		$diskon1x = $res_dtl['harga_jual'] - ($res_dtl['harga_jual'] * ($diskon1 / 100));
		$diskon2x = $diskon1x - ($diskon1x * ($diskon2 / 100));
		$diskon3x = $diskon2x - ($diskon2x * ($diskon3 / 100));
		$subtotal = $diskon3x * $res_dtl['qty_so3'];
		$alamat = $res_dtl['alamat'];
		$grandtotal[] = $subtotal;
		$tableContent .= '<tr>
				<td width="6%" style="text-align: right;">' . $no++ . '.&nbsp;</td>
				<td width="16%" style="text-align: left;">' . $res_dtl['nama_barang'] . '</td>
				<td width="2%" style="text-align: center;">@</td>
				<td width="2%" style="text-align: right;">' . print_ndec($res_dtl['isi']) . ' ' . $satuan_beli . '</td>
				<td width="2%" style="text-align: right;">' . print_ndec($res_dtl['qty_dikirim']) . ' ' . $res_dtl['satuan_dikirim'] . '</td>
				<td width="2%" style="text-align: right;">' . print_ndec($res_dtl['qty_so3']) . ' ' . $res_dtl['satuan_qty_so3'] . '</td>
				<td width="2%" style="text-align: right;">' . print_ndec($res_dtl['harga_jual']) . '&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td width="2%" style="text-align: right;">' . print_ndec($diskon1) . ' %</td>
				<td width="3%" style="text-align: right;">' . print_ndec($subtotal) . '</td>
			</tr>';
	}
	
}

$html = '
<html>
<head>
<style>
    @page {
        size: auto;
		odd-header-name: html_FJHeader;
        even-header-name: html_FJHeader;
        odd-footer-name: html_FJFooter;
        even-footer-name: html_FJFooter;
		margin-footer: 580px;
		margin-top: 145px;
		margin-bottom: 500px;
		margin-left: 20px;
		margin-right: 25px;
		page-break-before: right;
    }
	
	body {
		font-family: \'Times New Roman\', Courier, monospace;
		white-space: pre-line;
		font-size: 9.5pt;
	}
</style>
</head>

<body>
    <htmlpageheader name="FJHeader" style="display: none;">
        <table width="100%" border="0">			
			<tr>
				<td width="30%" style="text-align: right;">
					
				</td>
				<td width="20%" style="text-align: left;">
					' . @$res_hdr['kode_fj'] . '
				</td>
				<td width="3%" style="text-align: right;">
					
				</td>
				<td style="text-align: right;">
					
				</td>
			</tr>
			<tr>
				<td style="text-align: right;">
					
				</td>
				<td style="text-align: left;">
					' . date('d-m-Y', strtotime(@$res_hdr['tgl_buat'])) . '
				</td>
				<td style="text-align: left;">
					
				</td>
				<td style="text-align: left;">
					' . @$res_hdr['nama_pelanggan'] . '
				</td>
			</tr>
			<tr>
				<td style="text-align: right;">
					
				</td>
				<td style="text-align: left;">
					' . ($res_hdr['pembayaran'] ? @$res_hdr['pembayaran'] : isset($res_hdr['tgl_jth_tempo']) && ($res_hdr['tgl_jth_tempo'] !== '0000-00-00' || $res_hdr['tgl_jth_tempo'] !== '') ? 'KREDIT' : 'CASH') . '
				</td>
				<td style="text-align: left;">
					
				</td>
				<td style="text-align: left;">
					' . @$res_hdr['alamat'] . '
				</td>
			</tr>
			<tr>
				<td style="text-align: right;">
					
				</td>
				<td style="text-align: left;">
					' . date('d-m-Y', strtotime(@$res_hdr['tgl_jth_tempo'])) . '
				</td>
				<td style="text-align: left;">
					
				</td>
				<td style="text-align: left;">
					' . @$res_hdr['kota'] . '
				</td>
			</tr>
		</table>
    </htmlpageheader>

    <htmlpagefooter name="FJFooter" style="display: none;">
		<table width="100%">
			<tr>
				<td width="85%" style="text-align: right; color: #fff;">
					Total<br />
					%
				</td>
				<td width="15%" style="text-align: right; color: #000;">
					' . print_ndec(array_sum($grandtotal)) . '<br />
				</td>
			</tr>
			<tr>
				<td width="85%" style="text-align: right; color: #fff;">
					&nbsp;
				</td>
				<td width="15%" style="text-align: right; color: #000;">
					&nbsp;
				</td>
			</tr>
			<tr>
				<td width="85%" style="text-align: right; color: #fff;">
					NETTO
				</td>
				<td width="15%" style="text-align: right; color: #000;">
					' . print_ndec(array_sum($grandtotal)) . '
				</td>
			</tr>
		</table>
		<table width="100%" border="0">
			<tr>
				<td width="30%" style="text-align: center; color: #fff;">
					Tanda Terima
				</td>
				<td width="60%" style="text-align: left; color: #fff;">
					Ket.
				</td>
				<td width="10%" style="text-align: right; color: #fff;">
					Hormat Kami
				</td>
			</tr>
			<tr>
				<td style="text-align: center;">
				
				</td>
				<td style="text-align: left;">
					<br /><br /><br />' . $res_hdr['keterangan_hdr'] . ' ' . (isset($alamat) && !empty($alamat) ? '<br /><br />Alamat Kirim : ' . $alamat : '') . '
				</td>
				<td style="text-align: right;">
					
				</td>
			</tr>
		</table>
    </htmlpagefooter>
	
	<table width="100%" border="0">
		' . $tableContent . '
	</table>
	
</body>
</html>';

$mpdf->WriteHTML($html);

$mpdf->Output();
