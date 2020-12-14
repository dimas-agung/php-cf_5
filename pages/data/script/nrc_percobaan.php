<?php
//CLASS FORM AWAL
$class_form='class="active"';
$class_pane_form='class="tab-pane in active"';
$class_tab="";
$class_tab1="";
$class_tab2="";
$class_pane_tab='class="tab-pane"';
$class_pane_tab1='class="tab-pane"';
$class_pane_tab2='class="tab-pane"';

//DDL
$q_cab =  mysql_query("SELECT kode_cabang,nama FROM cabang WHERE aktif='1' ORDER BY nama");

// UBAH PENCARIAN BERDASAR STATUS DI db
if(isset($_POST['status'])) {
	if($_POST['status']=='y'){
		$status='1';
	}else if($_POST['status']=='n'){
		$status='0';
	}
}

// Saat klik tombol cari
if(isset($_POST['cari'])) {
	//CLASS FORM SAAT KLIK TOMBOL CARI
	$class_tab 		='class="active"';
	$class_pane_tab ='class="tab-pane in active"';
	$class_form 	="";
	$class_pane_form='class="tab-pane"';
}
?>