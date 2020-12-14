<?php
function base_url(){
	return '//'.$_SERVER['HTTP_HOST'].'/cf_5/';
}

function redirect($url){
	echo "<meta http-equiv='refresh' content='0; url=".$url."' />";
}

function mres($data){
	return mysql_real_escape_string($data);
}

# Fungsi untuk membuat kode automatis #bulan dan tahun
function set_id($id, $tabel, $kddepan, $date = "")
{
	if($date == "") { $date = date('Y-m-d');}
	$q = mysql_query("select $id as id from $tabel where left($id, 6) like '".$kddepan.date('ym', strtotime($date))."' order by $id desc limit 1");
	$id = "";
	if(mysql_num_rows($q) > 0) {
		$k = mysql_fetch_array($q);
		$str = substr($k['id'],2,4);
		$count = (substr($k['id'],6,4))  + 1;
		if(strlen($count) == 1) {$jmlnol = "000";}
		else if(strlen($count) == 2) {$jmlnol = "00";}
		else if(strlen($count) == 3) {$jmlnol = "0";}
		else {$jmlnol = "";}
		if($str == date('ym', strtotime($date))) {
			$kd	= $kddepan.$str.$jmlnol.($count);
		} else {
			$kd	= $kddepan.(date('ym', strtotime($date)))."0001";
		}
	} else {
		$kd	= $kddepan.(date('ym', strtotime($date)))."0001";
	}
	return $kd;
}

# Fungsi untuk membuat kode automatis
function buatKode($tabel, $inisial){
	$struktur	= mysql_query("SELECT * FROM $tabel");
	$field		= mysql_field_name($struktur,0);
	$panjang	= mysql_field_len($struktur,0);

 	$qry	= mysql_query("SELECT MAX(".$field.") FROM ".$tabel);
 	$row	= mysql_fetch_array($qry);
 	if ($row[0]=="") {
 		$angka=0;
	}
 	else {
 		$angka		= substr($row[0], strlen($inisial));
 	}

 	$angka++;
 	$angka	=strval($angka);
 	$tmp	="";
 	for($i=1; $i<=($panjang-strlen($inisial)-strlen($angka)); $i++) {
		$tmp=$tmp."0";
	}
 	return $inisial.$tmp.$angka;
}

function buatkodeform($id){

	$qry	= mysql_query("SELECT MAX(".$id.") FROM form_id");
 	$row	= mysql_fetch_array($qry);
 	if ($row[0]=="") {
 		$angka=1;
	}
 	else {
 		$angka=$row[0]+1;
 	}

 	return $angka;

}

function buatOpsi($id){

	$qry	= mysql_query("SELECT IFNULL(MAX(versi),0) AS versi FROM fs_hdr fsh LEFT JOIN penawaran_hdr p ON p.kode_pp=fsh.kd_proyek WHERE fsh.kd_proyek='".$id."' ");
 	$row	= mysql_fetch_array($qry);
 	if ($row[0]=="") {
 		$opsi=1;
	}
 	else {
 		$opsi=$row[0]+1;
 	}

 	return $opsi;

}


# Fungsi untuk membuat format rupiah pada angka (uang)
function format_angka($angka) {
	$hasil =  number_format($angka,0, ",",".");
	return $hasil;
}
function RandomString()
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < 50; $i++) {
        $randstring .= $characters[rand(0, strlen($characters)-1)];
    }
    $hasil = $randstring;
    return $hasil;
}

function comp_name(){
	/*$query 	= mysql_query("SELECT value FROM variabel WHERE id = 'company_name'");
	$row	= mysql_fetch_array($query);
 	return base64_decode($row['value']);*/
	return "PT. PUTERAKO INTIBUANA";
}
function comp_address(){
	/*$query 	= mysql_query("SELECT value FROM variabel WHERE id = 'company_address'");
	$row	= mysql_fetch_array($query);
 	return base64_decode($row['value']);*/
	return "Jl. Gembong 30H Surabaya";
}
function comp_contact(){
	/*$query 	= mysql_query("SELECT value FROM variabel WHERE id = 'company_contact'");
	$row	= mysql_fetch_array($query);
 	return base64_decode($row['value']);*/
	return "";
}
function tgl_indo($data) {
	$src	= array("01","02","03","04","05","06","07","08","09","10","11","12");
	$rpl	= array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	$ex		= str_replace($src,$rpl,date('m', strtotime($data)));
	return date('j', strtotime($data))." ".$ex." ".date('Y', strtotime($data));
}
function bulan($data) {
	$src	= array("01","02","03","04","05","06","07","08","09","10","11","12");
	$rpl	= array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	$ex		= str_replace($src,$rpl,date('m', strtotime($data)));
	return $ex;
}
function bulan_tahun($data) {
	$src	= array("01","02","03","04","05","06","07","08","09","10","11","12");
	$rpl	= array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	$ex		= str_replace($src,$rpl,date('m', strtotime($data)));
	return $ex.'-'.date('Y', strtotime($data));
}

function bulan_indo($bulan)
{
	Switch ($bulan){
		case 1 : $bulan="Januari";
			Break;
		case 2 : $bulan="Februari";
			Break;
		case 3 : $bulan="Maret";
			Break;
		case 4 : $bulan="April";
			Break;
		case 5 : $bulan="Mei";
			Break;
		case 6 : $bulan="Juni";
			Break;
		case 7 : $bulan="Juli";
			Break;
		case 8 : $bulan="Agustus";
			Break;
		case 9 : $bulan="September";
			Break;
		case 10 : $bulan="Oktober";
			Break;
		case 11 : $bulan="November";
			Break;
		case 12 : $bulan="Desember";
			Break;
		}
	return $bulan;
}

// Function untuk mengubah angka desimal menjadi angka romawi
function romanNumerals($num) {
    $n = intval($num);
    $res = '';

    /*** roman_numerals array  ***/
    $roman_numerals = array(
                'M'  => 1000,
                'CM' => 900,
                'D'  => 500,
                'CD' => 400,
                'C'  => 100,
                'XC' => 90,
                'L'  => 50,
                'XL' => 40,
                'X'  => 10,
                'IX' => 9,
                'V'  => 5,
                'IV' => 4,
                'I'  => 1);

    foreach ($roman_numerals as $roman => $number)
    {
        /*** divide to get  matches ***/
        $matches = intval($n / $number);

        /*** assign the roman char * $matches ***/
        $res .= str_repeat($roman, $matches);

        /*** substract from the number ***/
        $n = $n % $number;
    }

    /*** return the res ***/
    return $res;
}

// Membuat no permintaan penawaran secara otomatis
function buat_no_permintaan($kategori, $tanggal_mentah) {
	if($kategori && $tanggal_mentah) {
		$tanggal = date_create($tanggal_mentah);
		$baca_tanggal = date_format($tanggal, 'Y-m-d');
		$tahun = date_format($tanggal, 'y');
		$bulan = date_format($tanggal, 'n');
		$bulan_romawi = romanNumerals($bulan);
		// Query untuk menampilkan nomer urut
		$command = "SELECT COUNT(tanggal) + 1 AS jumlah FROM permintaan_penawaran WHERE YEAR(tanggal) = " . date_format($tanggal, 'Y') . " AND MONTH(tanggal) = $bulan";

		$do_command = mysql_query($command);
		$res = mysql_fetch_array($do_command);
		$no_urut = $res['jumlah'];

		$output = "";
		if($kategori == 'service') $output = "PIB/JK/$no_urut/SV/$bulan_romawi/$tahun";
		else if($kategori == 'sales') $output = "PIB/SD/$no_urut/SS/$bulan_romawi/$tahun";

		return $output;
	}
	else
		die("Parameter is required");
}

function buat_no_survey($no_permintaan, $tanggal_mentah) {
	if($no_permintaan !== '') {
		$parts = explode("/", $no_permintaan);
		$tanggal = date_create($tanggal_mentah);
		$baca_tanggal = date_format($tanggal, 'Y-m-d');
		$tahun = date_format($tanggal, 'y');
		$bulan = date_format($tanggal, 'n');
		$bulan_romawi = romanNumerals($bulan);
		// Query untuk menampilkan nomer urut
		$command = "SELECT COUNT(tanggal) + 1 AS jumlah FROM fs_hdr WHERE YEAR(tanggal) = " . date_format($tanggal, 'Y') . " AND MONTH(tanggal) = $bulan";

		$do_command = mysql_query($command);
		$res = mysql_fetch_array($do_command);
		$no_urut = $res['jumlah'];

		$hasil = 'SR/' . $parts[0] . '/' . $parts[1] . '/' . $no_urut . '/' . $parts[3] . '/' . $bulan_romawi . '/' . $tahun;

		return $hasil;

	}
	else
		return false;

}

function buat_no_penawaran($no_permintaan, $tanggal_mentah) {
	if($no_permintaan !== '') {
		$parts = explode("/", $no_permintaan);
		$tanggal = date_create($tanggal_mentah);
		$baca_tanggal = date_format($tanggal, 'Y-m-d');
		$tahun = date_format($tanggal, 'y');
		$bulan = date_format($tanggal, 'n');
		$bulan_romawi = romanNumerals($bulan);
		// Query untuk menampilkan nomer urut
		$command = "SELECT COUNT(tanggal) + 1 AS jumlah FROM penawaran_hdr WHERE YEAR(tanggal) = " . date_format($tanggal, 'Y') . " AND MONTH(tanggal) = $bulan";

		$do_command = mysql_query($command);
		$res = mysql_fetch_array($do_command);
		$no_urut = $res['jumlah'];

		$hasil = 'P/' . $parts[0] . '/' . $parts[1] . '/' . $no_urut . '/' . $parts[3] . '/' . $bulan_romawi . '/' . $tahun;

		return $hasil;

	}
	else
		return false;

}

function buat_no_lod($kategori, $tanggal_mentah) {
	if($kategori && $tanggal_mentah) {
		$tanggal = date_create($tanggal_mentah);
		$baca_tanggal = date_format($tanggal, 'Y-m-d');
		$tahun = date_format($tanggal, 'y');
		$bulan = date_format($tanggal, 'n');
		$bulan_romawi = romanNumerals($bulan);
		// Query untuk menampilkan nomer urut
		$command = "SELECT COUNT(tgl_buat) + 1 AS jumlah FROM lod_hdr WHERE YEAR(tgl_buat) = " . date_format($tanggal, 'Y') . " AND MONTH(tgl_buat) = $bulan";

		$do_command = mysql_query($command);
		$res = mysql_fetch_array($do_command);
		$no_urut = $res['jumlah'];

		$output = "";
		if($kategori == 'teknik') $output = "LOD/JK/$no_urut/SV/$bulan_romawi/$tahun";
		else if($kategori == 'sales') $output = "LOD/SD/$no_urut/SS/$bulan_romawi/$tahun";
		else if($kategori == 'sopir') $output = "LOD/JK/$no_urut/SP/$bulan_romawi/$tahun";

		return $output;
	}
	else
		die("Parameter is required");
}

function UploadCompress($new_name,$file,$dir,$quality){
  //direktori gambar
  $vdir_upload = $dir;
  $vfile_upload = $vdir_upload . $_FILES[''.$file.'']["name"];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES[''.$file.'']["tmp_name"], $dir.$_FILES[''.$file.'']["name"]);
  $source_url=$dir.$_FILES[''.$file.'']["name"];
  $info = getimagesize($source_url);

    if ($info['mime'] == 'image/jpeg'){
        $image = imagecreatefromjpeg($source_url);
        $ext='';
    }else if($info['mime'] == 'image/gif'){
        $image = imagecreatefromgif($source_url);
        $ext='';
    }else if($info['mime'] == 'image/png'){
        $image = imagecreatefrompng($source_url);
        $ext='';
    }

	//$extension = str_replace($ext, '', $ext);

    if(imagejpeg($image, $dir.$new_name.$ext, $quality)){
        unlink($source_url);
        return true;
    }else{
        unlink($source_url);
        return false;
    }

}

function selisih($jam_akhir, $jam_keluar) {

	list($h,$m,$s) = explode(":",$jam_akhir);
	$dtAwal = mktime($h,$m,$s,"1","1","1");
	list($h,$m,$s) = explode(":",$jam_keluar);
	$dtAkhir = mktime($h,$m,$s,"1","1","1");
	$dtSelisih = $dtAkhir-$dtAwal;

	$totalmenit = $dtSelisih/60;
	$jam=explode(".",$totalmenit/60);
	$sisamenit =($totalmenit/60)-$jam[0];
	$sisamenit2 = $sisamenit*60;

	$jumlah_karakter_jam=strlen($jam[0]);
	if($jumlah_karakter_jam<2){
		$konversi_jam = '0'.$jam[0];
	}else{
		$konversi_jam = $jam[0];
	}

	$jumlah_karakter_menit=strlen($sisamenit2);
	if($jumlah_karakter_menit<2){
		$konversi_menit = '0'.$sisamenit2;
	}else{
		$konversi_menit = $sisamenit2;
	}

	return "$konversi_jam:$konversi_menit:00";
}

function buat_kode_barang($kategori) {
	if($kategori) {

		//$year=date("ym");
		$date = date('Y-m-d');
        $q = mysql_query("SELECT MAX(RIGHT(kode_inventori,4)) AS kd_max FROM inventori WHERE SUBSTR(kode_inventori,4,4) = '".date('ym', strtotime($date))."'");

        $kd = "";
        if(mysql_num_rows($q)>0){
            while($res = mysql_fetch_array($q)){
                $tmp = ((int)$res['kd_max'])+1;
                $kd = sprintf("%04s", $tmp);
            }
        }else{
            $kd = "0001";
        }

		$output = $kategori."-".(date('ym', strtotime($date))).$kd;

        return $output;

		// Query untuk menampilkan nomer urut
		/*$command = "SELECT COUNT(kode_inventori) + 1 AS jumlah FROM inventori WHERE SUBSTRING(kode_inventori,1,2) = '".$kategori."'";

		$do_command = mysql_query($command);
		$res = mysql_fetch_array($do_command);
		$no_urut = $res['jumlah'];

		$output = "$kategori-$no_urut";

		return $output;*/
	}
	else
		die("Parameter is required");
}

function buat_kode_pr($thnblntgl,$form,$cabang) {
	if($form AND $cabang) {

		//$year=date("ym");
		//$date = date('Y-m-d');
        $q = mysql_query("SELECT MAX(SUBSTR(kode_pr,7,3)) AS kd_max FROM pr_hdr WHERE SUBSTR(kode_pr,1,6) = '".$thnblntgl."'");

        $kd = "";
        if(mysql_num_rows($q)>0){
            while($res = mysql_fetch_array($q)){
                $tmp = ((int)$res['kd_max'])+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }

		$output = $thnblntgl.$kd."-".$form."/".$cabang;

        return $output;

		// Query untuk menampilkan nomer urut
		/*$command = "SELECT COUNT(kode_inventori) + 1 AS jumlah FROM inventori WHERE SUBSTRING(kode_inventori,1,2) = '".$kategori."'";

		$do_command = mysql_query($command);
		$res = mysql_fetch_array($do_command);
		$no_urut = $res['jumlah'];

		$output = "$kategori-$no_urut";

		return $output;*/
	}
	else
		die("Parameter is required");
}

function buat_kode_ps($thnblntgl,$form,$cabang) {
	if($form AND $cabang) {

		//$year=date("ym");
		//$date = date('Y-m-d');
        $q = mysql_query("SELECT MAX(SUBSTR(kode_ps,7,3)) AS kd_max FROM ps_hdr WHERE SUBSTR(kode_ps,1,6) = '".$thnblntgl."'");

        $kd = "";
        if(mysql_num_rows($q)>0){
            while($res = mysql_fetch_array($q)){
                $tmp = ((int)$res['kd_max'])+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }

		$output = $thnblntgl.$kd."-".$form."/".$cabang;

        return $output;

		// Query untuk menampilkan nomer urut
		/*$command = "SELECT COUNT(kode_inventori) + 1 AS jumlah FROM inventori WHERE SUBSTRING(kode_inventori,1,2) = '".$kategori."'";

		$do_command = mysql_query($command);
		$res = mysql_fetch_array($do_command);
		$no_urut = $res['jumlah'];

		$output = "$kategori-$no_urut";

		return $output;*/
	}
	else
		die("Parameter is required");
}

function buat_kode_op($thnblntgl,$form,$cabang) {
	if($form AND $cabang) {

		//$year=date("ym");
		//$date = date('Y-m-d');
        $q = mysql_query("SELECT MAX(SUBSTR(kode_op,7,3)) AS kd_max FROM op_hdr WHERE SUBSTR(kode_op,1,6) = '".$thnblntgl."'");

        $kd = "";
        if(mysql_num_rows($q)>0){
            while($res = mysql_fetch_array($q)){
                $tmp = ((int)$res['kd_max'])+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }

		$output = $thnblntgl.$kd."-".$form."/".$cabang;

        return $output;

		// Query untuk menampilkan nomer urut
		/*$command = "SELECT COUNT(kode_inventori) + 1 AS jumlah FROM inventori WHERE SUBSTRING(kode_inventori,1,2) = '".$kategori."'";

		$do_command = mysql_query($command);
		$res = mysql_fetch_array($do_command);
		$no_urut = $res['jumlah'];

		$output = "$kategori-$no_urut";

		return $output;*/
	}
	else
		die("Parameter is required");
}

function buat_kode_btb($thnblntgl,$form,$cabang) {
	if($form AND $cabang) {

		//$year=date("ym");
		//$date = date('Y-m-d');
        $q = mysql_query("SELECT MAX(SUBSTR(kode_btb,7,3)) AS kd_max FROM btb_hdr WHERE SUBSTR(kode_btb,1,6) = '".$thnblntgl."'");

        $kd = "";
        if(mysql_num_rows($q)>0){
            while($res = mysql_fetch_array($q)){
                $tmp = ((int)$res['kd_max'])+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }

		$output = $thnblntgl.$kd."-".$form."/".$cabang;

        return $output;

		// Query untuk menampilkan nomer urut
		/*$command = "SELECT COUNT(kode_inventori) + 1 AS jumlah FROM inventori WHERE SUBSTRING(kode_inventori,1,2) = '".$kategori."'";

		$do_command = mysql_query($command);
		$res = mysql_fetch_array($do_command);
		$no_urut = $res['jumlah'];

		$output = "$kategori-$no_urut";

		return $output;*/
	}
	else
		die("Parameter is required");
}

function buat_kode_fb($thnblntgl,$form,$cabang) {
	if($form AND $cabang) {

		//$year=date("ym");
		//$date = date('Y-m-d');
        $q = mysql_query("SELECT MAX(SUBSTR(kode_fb,7,3)) AS kd_max FROM fb_hdr WHERE SUBSTR(kode_fb,1,6) = '".$thnblntgl."'");

        $kd = "";
        if(mysql_num_rows($q)>0){
            while($res = mysql_fetch_array($q)){
                $tmp = ((int)$res['kd_max'])+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }

		$output = $thnblntgl.$kd."-".$form."/".$cabang;

        return $output;

		// Query untuk menampilkan nomer urut
		/*$command = "SELECT COUNT(kode_inventori) + 1 AS jumlah FROM inventori WHERE SUBSTRING(kode_inventori,1,2) = '".$kategori."'";

		$do_command = mysql_query($command);
		$res = mysql_fetch_array($do_command);
		$no_urut = $res['jumlah'];

		$output = "$kategori-$no_urut";

		return $output;*/
	}
	else
		die("Parameter is required");
}

function buat_kode_so($thnblntgl,$form,$cabang) {
	if($form AND $cabang) {

		//$year=date("ym");
		//$date = date('Y-m-d');
        $q = mysql_query("SELECT MAX(SUBSTR(kode_so,7,3)) AS kd_max FROM so_hdr WHERE SUBSTR(kode_so,1,6) = '".$thnblntgl."'");

        $kd = "";
        if(mysql_num_rows($q)>0){
            while($res = mysql_fetch_array($q)){
                $tmp = ((int)$res['kd_max'])+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }

		$output = $thnblntgl.$kd."-".$form."/".$cabang;

        return $output;

		// Query untuk menampilkan nomer urut
		/*$command = "SELECT COUNT(kode_inventori) + 1 AS jumlah FROM inventori WHERE SUBSTRING(kode_inventori,1,2) = '".$kategori."'";

		$do_command = mysql_query($command);
		$res = mysql_fetch_array($do_command);
		$no_urut = $res['jumlah'];

		$output = "$kategori-$no_urut";

		return $output;*/
	}
	else
		die("Parameter is required");
}

function buat_kode_sj($thnblntgl,$form,$cabang) {
	if($form AND $cabang) {

		//$year=date("ym");
		//$date = date('Y-m-d');
        $q = mysql_query("SELECT MAX(SUBSTR(kode_sj,7,3)) AS kd_max FROM sj_hdr WHERE SUBSTR(kode_sj,1,6) = '".$thnblntgl."'");

        $kd = "";
        if(mysql_num_rows($q)>0){
            while($res = mysql_fetch_array($q)){
                $tmp = ((int)$res['kd_max'])+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }

		$output = $thnblntgl.$kd."-".$form."/".$cabang;

        return $output;

		// Query untuk menampilkan nomer urut
		/*$command = "SELECT COUNT(kode_inventori) + 1 AS jumlah FROM inventori WHERE SUBSTRING(kode_inventori,1,2) = '".$kategori."'";

		$do_command = mysql_query($command);
		$res = mysql_fetch_array($do_command);
		$no_urut = $res['jumlah'];

		$output = "$kategori-$no_urut";

		return $output;*/
	}
	else
		die("Parameter is required");
}

function buat_kode_bkk($thnblntgl,$form,$cabang) {
	if($form AND $cabang) {

		//$year=date("ym");
		//$date = date('Y-m-d');
        $q = mysql_query("SELECT MAX(SUBSTR(kode_bkk,7,3)) AS kd_max FROM bkk_hdr WHERE SUBSTR(kode_bkk,1,6) = '".$thnblntgl."'");

        $kd = "";
        if(mysql_num_rows($q)>0){
            while($res = mysql_fetch_array($q)){
                $tmp = ((int)$res['kd_max'])+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }

		$output = $thnblntgl.$kd."-".$form."/".$cabang;

        return $output;

		// Query untuk menampilkan nomer urut
		/*$command = "SELECT COUNT(kode_inventori) + 1 AS jumlah FROM inventori WHERE SUBSTRING(kode_inventori,1,2) = '".$kategori."'";

		$do_command = mysql_query($command);
		$res = mysql_fetch_array($do_command);
		$no_urut = $res['jumlah'];

		$output = "$kategori-$no_urut";

		return $output;*/
	}
	else
		die("Parameter is required");
}

function buat_kode_jm($thnblntgl,$form,$cabang) {
	if($form AND $cabang) {

		//$year=date("ym");
		//$date = date('Y-m-d');
        $q = mysql_query("SELECT MAX(SUBSTR(kode_jm,7,3)) AS kd_max FROM jm_hdr WHERE SUBSTR(kode_jm,1,6) = '".$thnblntgl."'");

        $kd = "";
        if(mysql_num_rows($q)>0){
            while($res = mysql_fetch_array($q)){
                $tmp = ((int)$res['kd_max'])+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }

		$output = $thnblntgl.$kd."-".$form."/".$cabang;

        return $output;

		// Query untuk menampilkan nomer urut
		/*$command = "SELECT COUNT(kode_inventori) + 1 AS jumlah FROM inventori WHERE SUBSTRING(kode_inventori,1,2) = '".$kategori."'";

		$do_command = mysql_query($command);
		$res = mysql_fetch_array($do_command);
		$no_urut = $res['jumlah'];

		$output = "$kategori-$no_urut";

		return $output;*/
	}
	else
		die("Parameter is required");
}

function buat_kode_fj($thnblntgl,$form,$cabang) {
	if($form AND $cabang) {

		//$year=date("ym");
		//$date = date('Y-m-d');
        $q = mysql_query("SELECT MAX(SUBSTR(kode_fj,7,3)) AS kd_max FROM fj_hdr WHERE SUBSTR(kode_fj,1,6) = '".$thnblntgl."'");

        $kd = "";
        if(mysql_num_rows($q)>0){
            while($res = mysql_fetch_array($q)){
                $tmp = ((int)$res['kd_max'])+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }

		$output = $thnblntgl.$kd."-".$form."/".$cabang;

        return $output;

		// Query untuk menampilkan nomer urut
		/*$command = "SELECT COUNT(kode_inventori) + 1 AS jumlah FROM inventori WHERE SUBSTRING(kode_inventori,1,2) = '".$kategori."'";

		$do_command = mysql_query($command);
		$res = mysql_fetch_array($do_command);
		$no_urut = $res['jumlah'];

		$output = "$kategori-$no_urut";

		return $output;*/
	}
	else
		die("Parameter is required");
}

function buat_kode_bkm($thnblntgl,$form,$cabang) {
	if($form AND $cabang) {

		//$year=date("ym");
		//$date = date('Y-m-d');
        $q = mysql_query("SELECT MAX(SUBSTR(kode_bkm,7,3)) AS kd_max FROM bkm_hdr WHERE SUBSTR(kode_bkm,1,6) = '".$thnblntgl."'");

        $kd = "";
        if(mysql_num_rows($q)>0){
            while($res = mysql_fetch_array($q)){
                $tmp = ((int)$res['kd_max'])+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }

		$output = $thnblntgl.$kd."-".$form."/".$cabang;

        return $output;

		// Query untuk menampilkan nomer urut
		/*$command = "SELECT COUNT(kode_inventori) + 1 AS jumlah FROM inventori WHERE SUBSTRING(kode_inventori,1,2) = '".$kategori."'";

		$do_command = mysql_query($command);
		$res = mysql_fetch_array($do_command);
		$no_urut = $res['jumlah'];

		$output = "$kategori-$no_urut";

		return $output;*/
	}
	else
		die("Parameter is required");
}

function buat_kode_rb($thnblntgl,$form,$cabang) {
	if($form AND $cabang) {

		//$year=date("ym");
		//$date = date('Y-m-d');
        $q = mysql_query("SELECT MAX(SUBSTR(kode_rb,7,3)) AS kd_max FROM rb_hdr WHERE SUBSTR(kode_rb,1,6) = '".$thnblntgl."'");

        $kd = "";
        if(mysql_num_rows($q)>0){
            while($res = mysql_fetch_array($q)){
                $tmp = ((int)$res['kd_max'])+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }

		$output = $thnblntgl.$kd."-".$form."/".$cabang;

        return $output;
	}
	else
		die("Parameter is required");
}

function buat_kode_rj($thnblntgl,$form,$cabang) {
	if($form AND $cabang) {

		//$year=date("ym");
		//$date = date('Y-m-d');
        $q = mysql_query("SELECT MAX(SUBSTR(kode_rj,7,3)) AS kd_max FROM rj_hdr WHERE SUBSTR(kode_rj,1,6) = '".$thnblntgl."'");

        $kd = "";
        if(mysql_num_rows($q)>0){
            while($res = mysql_fetch_array($q)){
                $tmp = ((int)$res['kd_max'])+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }

		$output = $thnblntgl.$kd."-".$form."/".$cabang;

        return $output;
	}
	else
		die("Parameter is required");
}

function buat_kode_spk($thnblntgl,$form,$cabang) {
	if($form AND $cabang) {

		//$year=date("ym");
		//$date = date('Y-m-d');
        $q = mysql_query("SELECT MAX(SUBSTR(kode_spk,7,3)) AS kd_max FROM spk_hdr WHERE SUBSTR(kode_spk,1,6) = '".$thnblntgl."'");

        $kd = "";
        if(mysql_num_rows($q)>0){
            while($res = mysql_fetch_array($q)){
                $tmp = ((int)$res['kd_max'])+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }

		$output = $thnblntgl.$kd."-".$form."/".$cabang;

        return $output;
	}
	else
		die("Parameter is required");
}

function buat_kode_pm($thnblntgl,$form,$cabang) {
	if($form AND $cabang) {

		//$year=date("ym");
		//$date = date('Y-m-d');
        $q = mysql_query("SELECT MAX(SUBSTR(kode_pm,7,3)) AS kd_max FROM pm_hdr WHERE SUBSTR(kode_pm,1,6) = '".$thnblntgl."'");

        $kd = "";
        if(mysql_num_rows($q)>0){
            while($res = mysql_fetch_array($q)){
                $tmp = ((int)$res['kd_max'])+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }

		$output = $thnblntgl.$kd."-".$form."/".$cabang;

        return $output;
	}
	else
		die("Parameter is required");
}

function buat_kode_tg($thnblntgl,$form,$cabang) {
	if($form AND $cabang) {

		//$year=date("ym");
		//$date = date('Y-m-d');
        $q = mysql_query("SELECT MAX(SUBSTR(kode_tg,7,3)) AS kd_max FROM tg_hdr WHERE SUBSTR(kode_tg,1,6) = '".$thnblntgl."'");

        $kd = "";
        if(mysql_num_rows($q)>0){
            while($res = mysql_fetch_array($q)){
                $tmp = ((int)$res['kd_max'])+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }

		$output = $thnblntgl.$kd."-".$form."/".$cabang;

        return $output;
	}
	else
		die("Parameter is required");
}

function buat_kode_nk($thnblntgl,$form,$cabang) {
	if($form AND $cabang) {

		//$year=date("ym");
		//$date = date('Y-m-d');
        $q = mysql_query("SELECT MAX(SUBSTR(kode_nk,7,3)) AS kd_max FROM nk_hdr WHERE SUBSTR(kode_nk,1,6) = '".$thnblntgl."'");

        $kd = "";
        if(mysql_num_rows($q)>0){
            while($res = mysql_fetch_array($q)){
                $tmp = ((int)$res['kd_max'])+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }

		$output = $thnblntgl.$kd."-".$form."/".$cabang;

        return $output;
	}
	else
		die("Parameter is required");
}

function buat_kode_nb($thnblntgl,$form,$cabang) {
	if($form AND $cabang) {

		//$year=date("ym");
		//$date = date('Y-m-d');
        $q = mysql_query("SELECT MAX(SUBSTR(kode_nb,7,3)) AS kd_max FROM nb_hdr WHERE SUBSTR(kode_nb,1,6) = '".$thnblntgl."'");

        $kd = "";
        if(mysql_num_rows($q)>0){
            while($res = mysql_fetch_array($q)){
                $tmp = ((int)$res['kd_max'])+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }

		$output = $thnblntgl.$kd."-".$form."/".$cabang;

        return $output;
	}
	else
		die("Parameter is required");
}

function buat_kode_cspk($thnblntgl,$form,$cabang) {
	if($form AND $cabang) {

		//$year=date("ym");
		//$date = date('Y-m-d');
        $q = mysql_query("SELECT MAX(SUBSTR(kode_cspk,7,3)) AS kd_max FROM cspk_hdr WHERE SUBSTR(kode_cspk,1,6) = '".$thnblntgl."'");

        $kd = "";
        if(mysql_num_rows($q)>0){
            while($res = mysql_fetch_array($q)){
                $tmp = ((int)$res['kd_max'])+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }

		$output = $thnblntgl.$kd."-".$form."/".$cabang;

        return $output;
	}
	else
		die("Parameter is required");
}

function buat_kode_ops($thnblntgl,$form,$cabang) {
	if($form AND $cabang) {

		//$year=date("ym");
		//$date = date('Y-m-d');
        $q = mysql_query("SELECT MAX(SUBSTR(kode_ops,7,3)) AS kd_max FROM ops_hdr WHERE SUBSTR(kode_ops,1,6) = '".$thnblntgl."'");

        $kd = "";
        if(mysql_num_rows($q)>0){
            while($res = mysql_fetch_array($q)){
                $tmp = ((int)$res['kd_max'])+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }

		$output = $thnblntgl.$kd."-".$form."/".$cabang;

        return $output;
	}
	else
		die("Parameter is required");
}

function buat_kode_bts($thnblntgl,$form,$cabang) {
	if($form AND $cabang) {

		//$year=date("ym");
		//$date = date('Y-m-d');
        $q = mysql_query("SELECT MAX(SUBSTR(kode_bts,7,3)) AS kd_max FROM bts_hdr WHERE SUBSTR(kode_bts,1,6) = '".$thnblntgl."'");

        $kd = "";
        if(mysql_num_rows($q)>0){
            while($res = mysql_fetch_array($q)){
                $tmp = ((int)$res['kd_max'])+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }

		$output = $thnblntgl.$kd."-".$form."/".$cabang;

        return $output;
	}
	else
		die("Parameter is required");
}

function buat_kode_sm($thnblntgl,$form,$cabang) {
	if($form AND $cabang) {

        $q = mysql_query("SELECT MAX(SUBSTR(kode_sm,7,3)) AS kd_max FROM sm_hdr WHERE SUBSTR(kode_sm,1,6) = '".$thnblntgl."'");

        $kd = "";
        if(mysql_num_rows($q)>0){
            while($res = mysql_fetch_array($q)){
                $tmp = ((int)$res['kd_max'])+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }

		$output = $thnblntgl.$kd."-".$form."/".$cabang;

        return $output;
	}
	else
		die("Parameter is required");
}

function buat_kode_sk($thnblntgl,$form,$cabang) {
	if($form AND $cabang) {

        $q = mysql_query("SELECT MAX(SUBSTR(kode_sk,7,3)) AS kd_max FROM sk_hdr WHERE SUBSTR(kode_sk,1,6) = '".$thnblntgl."'");

        $kd = "";
        if(mysql_num_rows($q)>0){
            while($res = mysql_fetch_array($q)){
                $tmp = ((int)$res['kd_max'])+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }

		$output = $thnblntgl.$kd."-".$form."/".$cabang;

        return $output;
	}
	else
		die("Parameter is required");
}

function buat_kode_gm($thnblntgl,$form,$cabang) {
	if($form AND $cabang) {

        $q = mysql_query("SELECT MAX(SUBSTR(kode_gm,7,3)) AS kd_max FROM gm_hdr WHERE SUBSTR(kode_gm,1,6) = '".$thnblntgl."'");

        $kd = "";
        if(mysql_num_rows($q)>0){
            while($res = mysql_fetch_array($q)){
                $tmp = ((int)$res['kd_max'])+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }

		$output = $thnblntgl.$kd."-".$form."/".$cabang;

        return $output;
	}
	else
		die("Parameter is required");
}

function buat_kode_gk($thnblntgl,$form,$cabang) {
	if($form AND $cabang) {

        $q = mysql_query("SELECT MAX(SUBSTR(kode_gk,7,3)) AS kd_max FROM gk_hdr WHERE SUBSTR(kode_gk,1,6) = '".$thnblntgl."'");

        $kd = "";
        if(mysql_num_rows($q)>0){
            while($res = mysql_fetch_array($q)){
                $tmp = ((int)$res['kd_max'])+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }

		$output = $thnblntgl.$kd."-".$form."/".$cabang;

        return $output;
	}
	else
		die("Parameter is required");
}

function buat_kode_pg($thnblntgl,$form,$cabang) {
	if($form AND $cabang) {

        $q = mysql_query("SELECT MAX(SUBSTR(kode_pg,7,3)) AS kd_max FROM pg_hdr WHERE SUBSTR(kode_pg,1,6) = '".$thnblntgl."'");

        $kd = "";
        if(mysql_num_rows($q)>0){
            while($res = mysql_fetch_array($q)){
                $tmp = ((int)$res['kd_max'])+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }

		$output = $thnblntgl.$kd."-".$form."/".$cabang;

        return $output;
	}
	else
		die("Parameter is required");
}

function buat_kode_gt($thnblntgl,$form,$cabang) {
	if($form AND $cabang) {

        $q = mysql_query("SELECT MAX(SUBSTR(kode_gt,7,3)) AS kd_max FROM gt_hdr WHERE SUBSTR(kode_gt,1,6) = '".$thnblntgl."'");

        $kd = "";
        if(mysql_num_rows($q)>0){
            while($res = mysql_fetch_array($q)){
                $tmp = ((int)$res['kd_max'])+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }

		$output = $thnblntgl.$kd."-".$form."/".$cabang;

        return $output;
	}
	else
		die("Parameter is required");
}

function buat_kode_gp($thnblntgl,$form,$cabang) {
	if($form AND $cabang) {

        $q = mysql_query("SELECT MAX(SUBSTR(kode_gp,7,3)) AS kd_max FROM gp_hdr WHERE SUBSTR(kode_gp,1,6) = '".$thnblntgl."'");

        $kd = "";
        if(mysql_num_rows($q)>0){
            while($res = mysql_fetch_array($q)){
                $tmp = ((int)$res['kd_max'])+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }

		$output = $thnblntgl.$kd."-".$form."/".$cabang;

        return $output;
	}
	else
		die("Parameter is required");
}

function buat_kode_fg($thnblntgl,$form,$cabang) {
	if($form AND $cabang) {

        $q = mysql_query("SELECT MAX(SUBSTR(kode_fg,7,3)) AS kd_max FROM fg_hdr WHERE SUBSTR(kode_fg,1,6) = '".$thnblntgl."'");

        $kd = "";
        if(mysql_num_rows($q)>0){
            while($res = mysql_fetch_array($q)){
                $tmp = ((int)$res['kd_max'])+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "001";
        }

		$output = $thnblntgl.$kd."-".$form."/".$cabang;

        return $output;
	}
	else
		die("Parameter is required");
}

#Fungsi Pembulatan
function pembulatan($uang)
{
 $ratusan = substr($uang, -3);
 if($ratusan<500)
 $akhir = $uang - $ratusan;
 else
 $akhir = $uang + (1000-$ratusan);
 return number_format($akhir);
}

#Fungsi Kalkulasi HPP
function calculateNewAverage(
    $currentAverage,
    $currentQuantity,
    $quantity,
    $costPerItem
  ) {
    return (($currentAverage * $currentQuantity) + ($quantity * $costPerItem)) / ($currentQuantity + $quantity);
  }
  
 
function searchKodeSales($alias = null) {
	if ( $_SESSION['app_level'] !== '3') {
		return '';
	}
	$kodeSales = 'SELECT `kode_karyawan` FROM `user` WHERE `kd_user` = \'' . $_SESSION['app_id'] . '\'';
	$querySales = mysql_query($kodeSales);
	$alias = (!empty($alias) ? $alias . '' : '');
	if (mysql_num_rows($querySales) > 0) {
		$kodeSales = mysql_fetch_array($querySales);
		$return = ' AND ' . $alias . '`salesman` = \'' . $kodeSales['kode_karyawan'] . '\'';
		return $return;
	} else {
		return '';
	}
}

function searchKodeSales2() {
	if ( $_SESSION['app_level'] !== '3') {
		return '';
	}
	$kodeSales = 'SELECT `kode_karyawan` FROM `user` WHERE `kd_user` = \'' . $_SESSION['app_id'] . '\'';
	$querySales = mysql_query($kodeSales);
	if (mysql_num_rows($querySales) > 0) {
		$row = mysql_fetch_array($querySales);
		$return = $row['kode_karyawan'];
		return $return;
	} else {
		return '';
	}
}
 
function is_decimal( $val )
{
    return is_numeric( $val ) && floor( $val ) != $val;
}

function print_ndec($val) {
	if (is_decimal($val)) {
		return number_format($val, 1);
	}
	return number_format($val, 0);
}
?>
