<?php	

	$class_form 		='class="active"';
	$class_pane_form 	='class="tab-pane in active"';
	$class_tab 			="";
	$class_pane_tab 	='class="tab-pane"';


$q_cabang 			= mysql_query("SELECT kode_cabang, nama nama_cabang FROM cabang WHERE aktif = '1' ORDER BY nama ASC");
$q_gudang_asal 		= mysql_query("SELECT kode_gudang, nama nama_gudang FROM gudang WHERE aktif = '1' ORDER BY nama ASC");
$q_gudang_tujuan 	= mysql_query("SELECT kode_gudang, nama nama_gudang FROM gudang WHERE aktif = '1' ORDER BY nama ASC");

$q_pm 				= mysql_query("SELECT kode_pm, ref, tgl_buat, ph.kode_cabang, c.nama nama_cabang, kode_gudang_asal, ga.nama gudang_asal, kode_gudang_tujuan, gt.nama gudang_tujuan FROM pm_hdr ph
									LEFT JOIN cabang c ON c.kode_cabang = ph.kode_cabang
									LEFT JOIN gudang ga ON ga.kode_gudang = ph.kode_gudang_asal 
									LEFT JOIN gudang gt ON gt.kode_gudang = ph.kode_gudang_tujuan 
									GROUP BY kode_pm
									ORDER BY id_pm_hdr");
	

?>