<?php

session_start();
require('../library/conn.php');
require('../library/helper.php');
date_default_timezone_set("Asia/Jakarta");

$search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
$limit = $_POST['length']; // Ambil data limit per page
$start = $_POST['start']; // Ambil data start

$sql = mysqli_query($con, "SELECT id_inventori FROM inventori"); // Query untuk menghitung seluruh data siswa
$sql_count = mysqli_num_rows($sql); // Hitung data yg ada pada query $sql

$query = "SELECT * FROM inventori WHERE (id_inventori LIKE '%".$search."%' OR nama LIKE '%".$search."%' OR kategori LIKE '%".$search."%' OR keterangan LIKE '%".$search."%')";
$order_field = $_POST['order'][0]['column']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
$order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"
$order = " ORDER BY ".$_POST['columns'][$order_field]['data']." ".$order_ascdesc;

$sql_data = mysqli_query($con, $query.$order." LIMIT ".$limit." OFFSET ".$start); // Query untuk data yang akan di tampilkan
$sql_filter = mysqli_query($con, $query); // Query untuk count jumlah data sesuai dengan filter pada textbox pencarian
$sql_filter_count = mysqli_num_rows($sql_filter); // Hitung data yg ada pada query $sql_filter

$data = mysqli_fetch_all($sql_data, MYSQLI_ASSOC); // Untuk mengambil data hasil query menjadi array

/*$data=array();

while($row=mysqli_fetch_array($sql_data)){
	$subdata = array();
	$subdata[] = $row[0];
	$subdata[] = $row[1];
	$subdata[] = $row[2];
	$subdata[] = $row[3];
	$data[]=$subdata;
}*/

$callback = array(
    'draw'=>$_POST['draw'], // Ini dari datatablenya
    'recordsTotal'=>$sql_count,
    'recordsFiltered'=>$sql_filter_count,
    'data'=>$data
);

header('Content-Type: application/json');
echo json_encode($callback); // Convert array $callback ke json
?>