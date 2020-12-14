<?php

$myHost	= "localhost";
$myUser	= "root";
$myPass	= "";
$myDbs	= "cf_baru";

# Konek ke Web Server Lokal
$koneksidb	= mysql_connect($myHost, $myUser, $myPass) or die ("Koneksi MySQL gagal !");
#koneksi mysqli
$con = mysqli_connect($myHost,$myUser,$myPass,$myDbs);
/* check connection mysqli */
if (!$con) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
#PDO
$pdo = new PDO('mysql:host='.$myHost.';dbname='.$myDbs, $myUser, $myPass);
# Memilih database pd MySQL Server
mysql_select_db($myDbs, $koneksidb) or die ("Database $myDbs tidak ditemukan !");

$request = isset($_REQUEST) ? (object) $_REQUEST : null;
setlocale(LC_TIME, 'id_ID.UTF-8');
error_reporting(E_ALL || ~E_NOTICE);
?>