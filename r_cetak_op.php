<?php

session_start();
include "library/conn.php";
include "library/helper.php";
date_default_timezone_set("Asia/Jakarta");

$kode_op = @$_GET['kode_op'];

$op_hdr = mysql_query("SELECT oh.kode_op, oh.kode_supplier, s.nama as nama_supplier, oh.ref, oh.tgl_buat, oh.kode_cabang, c.nama as nama_cabang, oh.keterangan_hdr, jatuh_tempo top, oh.status FROM op_hdr oh LEFT JOIN cabang c ON c.kode_cabang = oh.kode_cabang LEFT JOIN supplier s ON s.kode_supplier = oh.kode_supplier WHERE oh.kode_op = '".$kode_op."' ");

$op_dtl = mysql_query("SELECT * FROM op_dtl WHERE kode_op = '".$kode_op."'");

$res_hdr = mysql_fetch_array($op_hdr);

require_once __DIR__ . '/composer/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => [
		215,
		165,
	],
    'orientation' => 'P'
]);

$mpdf->shrink_tables_to_fit = 1;

$tableContent = '';
if (isset($op_dtl)) {
	$no = 1;
	$ppn = 0;
	$total = 0;
	$grandTotal = 1;
	/* while($res_dtl = mysql_fetch_array($op_dtl)) {
		$totalAtas = $res_dtl['subtot'];

		if (!empty($res_dtl['ppn'])) {
			$ppn     += $totalAtas * 0.1;
		}
		else {
			$ppn     += 0;
		}

		$grandTotal  += $totalAtas;
		$total       = $grandTotal-$ppn;

		$barangKode = null;
		$barangNama = null;
		$kodeBarang = $res_dtl['kode_barang'];
		if (!empty($kodeBarang)) {
			$kodeBarang = explode(':', $kodeBarang);
			$barangKode = is_array($kodeBarang) && count($kodeBarang) > 0 ? $kodeBarang[0] : null;
			$barangNama = is_array($kodeBarang) && count($kodeBarang) > 0 ? $kodeBarang[1] : null;
		}

		$gudangKode = null;
		$gudangNama = null;
		$kodeGudang = $res_dtl['kode_gudang'];
		if (!empty($kodeGudang)) {
			$kodeGudang = explode(':', $kodeGudang);
			$gudangKode = is_array($kodeGudang) && count($kodeGudang) > 0 ? $kodeGudang[0] : null;
			$gudangNama = is_array($kodeGudang) && count($kodeGudang) > 0 ? $kodeGudang[1] : null;
		}

		$divisiKode = null;
		$divisiNama = null;
		$divisi = $res_dtl['divisi'];
		if (!empty($divisi)) {
			$divisi = explode(':', $divisi);
			$divisiKode = is_array($divisi) && count($divisi) > 0 ? $divisi[0] : null;
			$divisiNama = is_array($divisi) && count($divisi) > 0 ? $divisi[1] : null;
		}

		$satuanKode = null;
		$satuanNama = null;
		$satuan = $res_dtl['satuan'];
		if (!empty($satuan)) {
			$satuan = explode(':', $satuan);
			$satuanKode = is_array($satuan) && count($satuan) > 0 ? $satuan[0] : null;
			$satuanNama = is_array($satuan) && count($satuan) > 0 ? $satuan[1] : null;
		}

		$tableContent .= '
			<tr>
				<td style="text-align: center;" width="5%">
					' . $no++ . '
				</td>
				<td style="text-align: left;" width="8%">
					' . $barangKode . '
				</td>
				<td style="text-align: left;" width="20%">
					' . $barangNama . '
				</td>
				<td style="text-align: left;" width="8%">
					' . $satuanNama . '
				</td>
				<td style="text-align: right;" width="5%">
					' . (int) $res_dtl['qty'] . '
				</td>
				<td style="text-align: left;" width="25%">
					' . $gudangNama . '
				</td>
				<td style="text-align: right;" width="15%">
					' . number_format($res_dtl['harga'], null, null, ',') . '
				</td>
				<td style="text-align: right;" width="8%">
					' . number_format($res_dtl['diskon'], null, null, ',') . '%
				</td>
				<td style="text-align: center;" width="5%">
					' . number_format($ppn, null, null, ',') . '
				</td>
				<td style="text-align: right;" width="15%">
					' . number_format($totalAtas, null, null, ',') . '
				</td>
				<td style="text-align: left;" width="15%">
					' . $res_dtl['keterangan_dtl'] . '
				</td>
			</tr>';
	} */
	for($i = 0; $i < 100; $i++) {
		$tableContent .= '
			<tr>
				<td width="5%" style="text-align:center;font-size:10pt;color:#000;">
					' . $no++ . '
				</td>
				<td width="20%" style="text-align:left;font-size:10pt;color:#000;">
					A | Nama
				</td>
				<td width="8%" style="text-align:left;font-size:10pt;color:#000;">
					Satuan
				</td>
				<td width="5%" style="text-align:right;font-size:10pt;color:#000;">
					1.000.000.000
				</td>
				<td width="25%" style="text-align:left;font-size:10pt;color:#000;">
					' . str_repeat('Gudang ', 3) . '
				</td>
				<td width="15%" style="text-align:right;font-size:10pt;color:#000;">
					1.000.000.000
				</td>
				<td width="8%" style="text-align:right;font-size:10pt;color:#000;">
					100%
				</td>
				<td width="5%" style="text-align:center;font-size:10pt;color:#000;">
					100%
				</td>
				<td width="15%" style="text-align:right;font-size:10pt;color:#000;">
					1.000.000.000
				</td>
				<td width="15%" style="text-align:left;font-size:10pt;color:#000;">
					Keterangan
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
		odd-header-name: html_PrintHeader;
        even-header-name: html_PrintHeader;
        odd-footer-name: html_PrintFooter;
        even-footer-name: html_PrintFooter;
		margin-header: 5pt;
		margin-footer: 100pt;
		margin-top: 85pt;
		margin-bottom: 100pt;
		margin-left: 20pt;
		margin-right: 20pt;
		page-break-before: right;
    }

	body {
		font-family: \'Courier New\', Courier, monospace;
    }

    table {page-break-inside: avoid}
    table tfoot{display:table-row-group;}
</style>
</head>

<body>
    <htmlpageheader name="PrintHeader" style="display:none;">
        <table width="100%" border="0">
            <thead>
                <tr>
                    <td colspan="4" style="text-align:center;font-weight:bold;font-size:16pt;color:#000;">
                        Order Pembelian
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td rowspan="5" width="20%" style="text-align:center;font-size:8pt;color:#fff;">
                        LOGO
                    </td>
                </tr>
                <tr>
                    <td width="25%" style="text-align:right;font-size:8pt;color:#000;">
                        Kode Print
                    </td>
                    <td width="2%" style="text-align:center;font-size:8pt;color:#000;">
                        :
                    </td>
                    <td style="text-align:left;font-size:8pt;color:#000;">
                        ' . @$res_hdr['kode_op'] . '
                    </td>
                </tr>
                <tr>
                    <td width="25%" style="text-align:right;font-size:8pt;color:#000;">
                        Tanggal
                    </td>
                    <td width="2%" style="text-align:center;font-size:8pt;color:#000;">
                        :
                    </td>
                    <td style="text-align:left;font-size:8pt;color:#000;">
                        ' . tgl_indo(@$res_hdr['tgl_buat']) . '
                    </td>
                </tr>
                <tr>
                    <td width="25%" style="text-align:right;font-size:8pt;color:#000;">
                        Cabang
                    </td>
                    <td width="2%" style="text-align:center;font-size:8pt;color:#000;">
                        :
                    </td>
                    <td style="text-align:left;font-size:8pt;color:#000;">
                        ' . $res_hdr['nama_cabang'] . '
                    </td>
                </tr>
                <tr>
                    <td width="25%" style="text-align:right;font-size:8pt;color:#000;">
                        Supplier
                    </td>
                    <td width="2%" style="text-align:center;font-size:8pt;color:#000;">
                        :
                    </td>
                    <td style="text-align:left;font-size:8pt;color:#000;">
                        ' . $res_hdr['nama_supplier'] . '
                    </td>
                </tr>
            </tbody>
		</table>
    </htmlpageheader>

    <table width="100%" border="1" autosize="1">
        <thead>
            <tr>
                <th style="text-align:center;font-size:10pt;color:#000;">
                    No
                </th>
                <th style="text-align:center;font-size:10pt;color:#000;">
                    Barang
                </th>
                <th style="text-align:center;font-size:10pt;color:#000;">
                    Satuan
                </th>
                <th style="text-align:center;font-size:10pt;color:#000;">
                    QTY
                </th>
                <th style="text-align:center;font-size:10pt;color:#000;">
                    Gudang
                </th>
                <th style="text-align:center;font-size:10pt;color:#000;">
                    Harga
                </th>
                <th style="text-align:center;font-size:10pt;color:#000;">
                    Diskon
                </th>
                <th style="text-align:center;font-size:10pt;color:#000;">
                    PPN
                </th>
                <th style="text-align:center;font-size:10pt;color:#000;">
                    Subtotal
                </th>
                <th style="text-align:center;font-size:10pt;color:#000;">
                    Note
                </th>
            </tr>
        </thead>
        <tbody style="page-break-inside:avoid;">
		    ' . $tableContent . '
        </tbody>
        <tfoot>
            <tr>
                <th style="text-align:center;font-size:10pt;color:#000;">
                    No
                </th>
                <th style="text-align:center;font-size:10pt;color:#000;">
                    Barang
                </th>
                <th style="text-align:center;font-size:10pt;color:#000;">
                    Satuan
                </th>
                <th style="text-align:center;font-size:10pt;color:#000;">
                    QTY
                </th>
                <th style="text-align:center;font-size:10pt;color:#000;">
                    Gudang
                </th>
                <th style="text-align:center;font-size:10pt;color:#000;">
                    Harga
                </th>
                <th style="text-align:center;font-size:10pt;color:#000;">
                    Diskon
                </th>
                <th style="text-align:center;font-size:10pt;color:#000;">
                    PPN
                </th>
                <th style="text-align:center;font-size:10pt;color:#000;">
                    Subtotal
                </th>
                <th style="text-align:center;font-size:10pt;color:#000;">
                    Note
                </th>
            </tr>
        </tfoot>
	</table>

    <htmlpagefooter name="PrintFooter" style="display:none;">
        <table width="100%">
            <thead>
                <tr>
                    <th colspan="3" width="60%" style="text-align: left;">
                        Keterangan
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="3" width="60%" style="text-align: left;">
                        ' . $res_hdr['keterangan_hdr'] . '
                    </td>
                </tr>
            </tbody>
		</table>
    </htmlpagefooter>
</body>
</html>';

$mpdf->WriteHTML($html);

$mpdf->Output();
