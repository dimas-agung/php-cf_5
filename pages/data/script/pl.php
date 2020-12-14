<?php

	//CLASS FORM AWAL
$class_form 		='class="active"';
$class_pane_form 	='class="tab-pane in active"';
$class_tab 			="";
$class_pane_tab 	='class="tab-pane"';

	// if(isset($_POST['cari'])){

	// 	$class_tab 		='class="active"';
	// 	$class_pane_tab ='class="tab-pane in active"';
	// 	$class_form 	="";
	// 	$class_pane_form='class="tab-pane"';

	// 		$kode_pl		= $_POST['kode_pl_list'];
	// 		$plat_truck		= $_POST['plat_truck_list'];

	// 		$sql = "SELECT pl.kode_so, sh.kode_pelanggan, sh.tgl_buat, pl.nama_barang, pl.qty, pl.satuan FROM packing_list pl
	// 				LEFT JOIN so_hdr sh ON sh.kode_so = pl.kode_so
	// 				WHERE pl.kode_pl  LIKE '%".$kode_pl."%' AND pl.plat_truck LIKE '%".$plat_truck."%'
	// 				ORDER BY sh.kode_pelanggan, nama_barang ASC	";

	// 		$q_pl = mysql_query($sql)	;

	// }
?>
