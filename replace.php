<?php
	session_start();
	include "library/conn.php";
	include "library/helper.php";

	if(!empty($_SESSION['app_id']) and !empty($_SESSION['app_user'])){
		redirect(base_url()); die();
	}
	
	$query1 = "SELECT * FROM (SELECT `kode_so`, `konversi`, LOWER(REGEXP_REPLACE(CONCAT(`kode_barang`, `nama_barang`), '[[:space:]]+', '')) AS `so_barang`, `kode_barang` AS `kode_so_barang`, `nama_barang` AS `nama_so_barang`, LOWER(REGEXP_REPLACE(CONCAT(`kode_inventori`, `nama`), '[[:space:]]+', '')) AS `inventori_barang`, `kode_inventori` AS `kode_inventori_barang`, `nama` AS `nama_inventori_barang` FROM `so_dtl` LEFT JOIN `inventori` ON `inventori`.`kode_inventori` = `so_dtl`.`kode_barang`) AS `tbl` WHERE `so_barang` <> `inventori_barang`";
	$result1 = mysqli_query($con, $query1);
	
	echo '<!doctype html>';
	echo '<html>';
	echo '<head>';
	echo '<title>';
	echo 'Replace X';
	echo '</title>';
	echo '</head>';
	echo '<body>';
	echo '<pre>';
	$n = 0;
	if (mysqli_num_rows($result1) > 0) {
		while ($row1 = mysqli_fetch_array($result1)) {
			//$n++;
			//echo $n . ' ' . $row1['kode_so'] . ' ' . $row1['so_barang'] . ' ' . $row1['konversi'] . ' ' . $row1['nama_so_barang'] . '<br />';
			
			$query2 = "SELECT `kode_inventori`, `nama`, `isi` FROM `inventori` WHERE TRIM(LOWER(REGEXP_REPLACE(`nama`, '[[:space:]]+', ''))) LIKE TRIM(LOWER(REGEXP_REPLACE('%" . $row1['nama_so_barang'] . "%', '[[:space:]]+', ''))) AND `isi` = '" . $row1['konversi'] . "' AND `kategori` = 'ID'";
			$result2 = mysqli_query($con, $query2);
			
			if (mysqli_num_rows($result2) > 0) {
				while ($row2 = mysqli_fetch_array($result2)) {
					$n++;
					echo $n . ' ' . $row1['kode_so'] . ' ' . $row1['kode_so_barang'] . ' ' . $row1['nama_so_barang'] . ' ' . $row2['kode_inventori'] . ' ' . $row2['nama'] . ' ' . $row1['konversi'] . '<br />';
					$query3 = "UPDATE `so_dtl` SET `kode_barang` = '" . $row2['kode_inventori'] . "' WHERE `kode_so` = '" . trim($row1['kode_so']) . "' AND `kode_barang` = '" . trim($row1['kode_so_barang']) . "' AND `konversi` = '" . $row2['isi'] . "'";
					mysqli_query($con, $query3);
				}
			}
		}
	}
	echo '</pre>';
	echo '</body>';
	echo '</html>';