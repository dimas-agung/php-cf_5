<?php

session_start();
include "library/conn.php";
include "library/helper.php";
date_default_timezone_set("Asia/Jakarta");

$kode_so = @$_GET['kode_so'];

$so_hdr = mysql_query("SELECT sh.kode_so, SUBSTRING_INDEX(sh.kode_pelanggan, ':', 1) kode_pelanggan, p.nama AS nama_pelanggan, sh.tgl_buat, sh.alamat, sh.ref , sh.alamat_kirim, sh.kode_cabang, c.nama AS nama_cabang, sh.tgl_kirim, sh.kode_gudang, g.nama AS nama_gudang, sh.top, sh.kode_salesman, sh.keterangan_hdr, sh.status FROM so_hdr sh LEFT JOIN cabang c ON c.kode_cabang = sh.kode_cabang LEFT JOIN gudang g ON g.kode_gudang = sh.kode_gudang LEFT JOIN pelanggan p ON p.kode_pelanggan = SUBSTRING_INDEX(sh.kode_pelanggan, ':', 1) LEFT JOIN so_um u ON u.kode_so = sh.kode_so WHERE sh.kode_so = '".$kode_so."' ");

$so_dtl = mysql_query("SELECT * FROM so_dtl WHERE kode_so ='".$kode_so."' order by kode_so ASC");

$res_hdr = mysql_fetch_array($so_hdr);

require_once __DIR__ . '/composer/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => [
		165, 
		215
	],
    'orientation' => 'L'
]);

$tableContent = '';
if (isset($so_dtl)) {
	$no = 1; 
	while($res_dtl = mysql_fetch_array($so_dtl)) {
		if(!empty($res_dtl['satuan'])) {
			$satuan = $res_dtl['satuan_jual'];
		}
		else{
			$satuan = $res_dtl['satuan'];
		}
		$tableContent .= '
			<tr>
				<td style="text-align: center;" width="5%">
					' . $no++ . '
				</td>
				<td style="text-align: left;" width="15%">
					' . $res_dtl['kode_barang'] . '
				</td>
				<td style="text-align: left;" width="30%">
					' . $res_dtl['nama_barang'] . '
				</td>
				<td style="text-align: left;" width="10%">
					' . $satuan . '
				</td>
				<td style="text-align: right;" width="10%">
					' . (int) $res_dtl['qty'] . '
				</td>
				<td width="25%">
					' . $res_dtl['keterangan_dtl'] . '
				</td>
			</tr>';
	}
	
}

$html = '
<html>
<head>
<style>
    @page {
        size: auto;
		odd-header-name: html_SOHeader;
        even-header-name: html_SOHeader;
        odd-footer-name: html_SOFooter;
        even-footer-name: html_SOFooter;
		margin-footer: 20px;
		margin-top: 180px;
		margin-bottom: 80px;
		margin-left: 20px;
		margin-right: 20px;
		page-break-before: right;
    }
	
	body {
		font-family: \'Courier New\', Courier, monospace;
	}
</style>
</head>

<body>
    <htmlpageheader name="SOHeader" style="display: none;">
        <table width="100%">
			<tr>
				<td colspan="7" style="text-align: center; font-weight: bold; font-size: 1.3em; color: #000;">
					Sales Order
				</td>
			</tr>			
			<tr>
				<td rowspan="5" width="18%" style="text-align: center; color: #000;">
					LOGO
				</td>				
			</tr>
			<tr>
				<td width="15%" style="text-align: right; color: #000;">
					Kode SO
				</td>
				<td width="2%" style="text-align: center; color: #000;">
					:
				</td>
				<td style="text-align: left;">
					' . @$res_hdr['kode_so'] . '
				</td>
				<td width="15%" style="text-align: right; color: #000;">
					Kepada YTH.
				</td>
				<td width="2%" style="text-align: center; color: #000;">
					:
				</td>
				<td style="text-align: left;">
					' . @$res_hdr['nama_pelanggan'] . '
				</td>
			</tr>
			<tr>
				<td width="15%" style="text-align: right; color: #000;">
					Tanggal
				</td>
				<td width="2%" style="text-align: center; color: #000;">
					:
				</td>
				<td colspan="4" style="text-align: left;">
					' . tgl_indo(@$res_hdr['tgl_buat']) . '
				</td>
			</tr>
			<tr>
				<td width="15%" style="text-align: right; color: #000;">
					Cabang
				</td>
				<td width="2%" style="text-align: center; color: #000;">
					:
				</td>
				<td colspan="4" style="text-align: left;">
					' . $res_hdr['nama_cabang'] . '
				</td>
			</tr>
			<tr>
				<td width="15%" style="text-align: right; color: #000;">
					Gudang
				</td>
				<td width="2%" style="text-align: center; color: #000;">
					:
				</td>
				<td colspan="4" style="text-align: left;">
					' . $res_hdr['nama_gudang'] . '
				</td>
			</tr>
		</table>
    </htmlpageheader>

    <htmlpagefooter name="SOFooter" style="display: none;">
		<table width="100%">
			<tr>
				<td width="60%" style="text-align: left;">
					Keterangan
				</td>
			</tr>
			<tr>
				<td width="60%" style="text-align: left;">
					' . $res_hdr['keterangan_hdr'] . '
				</td>
			</tr>
		</table>
    </htmlpagefooter>
	
	<table width="100%">
		<tr>
			<td style="text-align: center; color: #000;">
				NO
			</td>
			<td style="text-align: center; color: #000;">
				KODE BARANG
			</td>
			<td style="text-align: center; color: #000;">
				NAMA BARANG
			</td>
			<td style="text-align: center; color: #000;">
				SATUAN
			</td>
			<td style="text-align: center; color: #000;">
				QUANTITY
			</td>
			<td style="text-align: center; color: #000;">
				KETERANGAN
			</td>
		</tr>
		' . $tableContent . '
	</table>
	
</body>
</html>';

$mpdf->WriteHTML($html);

$mpdf->Output();