<?php

session_start();
include "library/conn.php";
include "library/helper.php";
date_default_timezone_set("Asia/Jakarta");

$kode_sj = @$_GET['kode_sj'];

$sj_hdr = mysql_query("SELECT sh.kode_sj, sh.kode_pelanggan, p.nama AS nama_pelanggan, sh.tgl_buat, sh.alamat, sh.ref, sh.kode_cabang, c.nama AS nama_cabang, sh.kode_gudang, g.nama AS nama_gudang, sh.keterangan_hdr, sh.status FROM sj_hdr sh LEFT JOIN cabang c ON c.kode_cabang = sh.kode_cabang LEFT JOIN gudang g ON g.kode_gudang = sh.kode_gudang LEFT JOIN pelanggan p ON p.kode_pelanggan = sh.kode_pelanggan WHERE sh.kode_sj = '".$kode_sj."' ");

$sj_dtl = mysql_query("SELECT * FROM sj_dtl a LEFT JOIN inventori b ON b.kode_inventori = a.kode_inventori WHERE kode_sj ='".$kode_sj."' and b.kategori <> 'BS' order by kode_sj ASC");

$res_hdr = mysql_fetch_array($sj_hdr); 

require_once __DIR__ . '/composer/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
]);

$tableContent = '';
if (isset($sj_dtl)) {
	$no = 1; 
	while($res_dtl = mysql_fetch_array($sj_dtl)) {
		$satuan_beli = explode(':', trim($res_dtl['satuan_beli']));
		$satuan_beli = count($satuan_beli) > 0 ? $satuan_beli[1] : '';
		$tableContent .= '<tr>
				<td width="6%" style="text-align: right;">' . $no++ . '.</td>
				<td width="16%" style="text-align: left;">' . $res_dtl['nama_inventori'] . '</td>
				<td width="2%" style="text-align: center;">@</td>
				<td width="2%" style="text-align: right;">' . print_ndec($res_dtl['isi']) . ' ' . $satuan_beli . '</td>
				<td width="2%" style="text-align: right;">' . print_ndec($res_dtl['qty_dikirim']) . ' ' . $res_dtl['satuan_dikirim'] . '</td>
				<td width="2%" style="text-align: right;">' . print_ndec($res_dtl['qty_so3']) . ' ' . $res_dtl['satuan_qty_so3'] . '</td>
				<td width="2%" style="text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td width="2%" style="text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td width="3%" style="text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			</tr>';
	}
	
}

$html = '
<html>
<head>
<style>
    @page {
        size: auto;
		odd-header-name: html_SJHeader;
        even-header-name: html_SJHeader;
        odd-footer-name: html_SJFooter;
        even-footer-name: html_SJFooter;
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
    <htmlpageheader name="SJHeader" style="display: none;">
        <table width="100%" border="0">			
			<tr>
				<td width="30%" style="text-align: right;">
					
				</td>
				<td width="20%" style="text-align: left;">
					' . @$res_hdr['kode_sj'] . '
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
					&nbsp;
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
					&nbsp;
				</td>
				<td style="text-align: left;">
					
				</td>
				<td style="text-align: left;">
					' . @$res_hdr['kota'] . '
				</td>
			</tr>
		</table>
    </htmlpageheader>

    <htmlpagefooter name="SJFooter" style="display: none;">
		<table width="100%">
			<tr>
				<td width="20%" style="text-align: center; color: #fff;">
					Tanda Terima
				</td>
				<td width="60%" style="text-align: left; color: #fff;">
					Ket.
				</td>
				<td width="20%" style="text-align: right; color: #fff;">
					Hormat Kami
				</td>
			</tr>
			<tr>
				<td width="20%" style="text-align: center;">
				
				</td>
				<td width="60%" style="text-align: left;">
					' . $res_hdr['keterangan_hdr'] . '
				</td>
				<td width="20%" style="text-align: right;">
				
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