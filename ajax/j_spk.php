<?php

	session_start();

	require('../library/conn.php');

	require('../library/helper.php');

	require('../pages/data/script/spk.php'); 

	date_default_timezone_set("Asia/Jakarta");
	

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loadsatuan" )
	{
		$kd_barang = ''; //VARIABEL AWAL
		$kode_barang = mres($_POST['kode_barang']);
		$sat_beli = '- : -';
		$sat_jual = '- : -';
		$konversi = 0;
		if(!empty($kode_barang))
		{
			$pisah=explode(":",$kode_barang);
			$kd_barang=$pisah[0];
			$nm_barang=$pisah[1];
		}
		$q_sat = mysql_query("SELECT `kode_inventori`, CONCAT(`satuan_bom`, ':', `satuan_bom`) AS `satuan_dtl` FROM `inventori` WHERE `kode_inventori` = '".$kd_barang."'");	
		$num_rows = mysql_num_rows($q_sat);
		if($num_rows>0)
		{		
			$rowsat = mysql_fetch_array($q_sat);
			$satuan_dtl= $rowsat['satuan_dtl'];
		}
		
		$response = array(
            'satuan_dtl'=>$satuan_dtl,
        );  
		echo json_encode($response);
	}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "get_bom" )
{
    $kode_produk    = $_POST['kode_barang'];
    $id_form        = $_POST['id_form'];

	$item_dtl = mysql_query("SELECT `inventori`.`kode_inventori`, `inventori`.`nama` AS `nama_inventori`, SUBSTRING_INDEX(`bom`.`kode_barang_dtl`, ':', 1) AS `kode_item_bom`, SUBSTRING_INDEX(`bom`.`satuan_dtl`, ':', 1) AS `kode_satuan_bom`, `bom`.`qty_dtl` FROM `bom` LEFT JOIN `inventori` ON `inventori`.`kode_inventori` = SUBSTRING_INDEX(`bom`.`kode_barang_dtl`, ':', 1) WHERE `inventori`.`aktif` = '1' AND `bom`.`kode_inventori` = '".$kode_produk."'");	
    
    echo view_item_spk($item_dtl);    

}   

function view_item_spk($data) {
    $i = 0;
    $n = 1;
    $html = "";
    
    if(mysql_num_rows($data) > 0) {
        
        while ($item = mysql_fetch_array($data)) {
            
            $html .= '
            <tr>
                <td>'.$n.'</td>
                <td>'.$item['kode_item_bom']. ' - ' .$item['nama_inventori'].'<input type="hidden" name="kode_item_bom[]" value="'.$item['kode_item_bom'].'"><input type="hidden" name="kode_satuan_bom[]" value="'.$item['kode_satuan_bom'].'"></td>
                <td class="text-right"><div class="input-group"><input type="text" class="form-control" name="q_std[]" id="q_std_'.$i.'" value="'.$item['qty_dtl'].'" readonly><span class="input-group-addon">'.$item['kode_satuan_bom'].'</span></div></td>
                <td class="text-right"><div class="input-group"><input type="text" class="form-control" name="q_use[]" id="q_use_'.$i.'" value="0" readonly><span class="input-group-addon">'.$item['kode_satuan_bom'].'</span></div></td>
                <td><input type="text" class="form-control" name="note[]" id="note[]"></td>
            </tr>';

            $i++;
            $n++;
        }

    } else {
        $html .= '<tr> <td colspan="5" class="text-center no-item">Belum ada item.</td></tr>';
    }
     
    return $html;
}

if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "save" )
	{

		$form 			= 'PK';
		$thnblntgl 		= date("ymd",strtotime(mres($_POST['tanggal'])));
		$id_form			= mres($_POST['id_form']);
		$kode_cabang	= mres($_POST['kode_cabang']);
		$ref			= mres($_POST['ref']);
		$kode_barang	= mres($_POST['kode_barang']);
		$kode_satuan	= mres($_POST['satuan']);
		$tgl_buat 		= date("Y-m-d",strtotime(mres($_POST['tanggal'])));
		$tgl_selesai 		= date("Y-m-d",strtotime(mres($_POST['tanggal_s'])));
		$qty	= mres($_POST['jumlah']);
		$keterangan_hdr	= mres($_POST['keterangan']);
		$user_pencipta  	= $_SESSION['app_id'];
		$tgl_input 			= date("Y-m-d H:i:s");	
		$kode_gudang 			= 'WHPR';	
		$kode_item_bom = $_POST['kode_item_bom'];
		$kode_satuan_bom = $_POST['kode_satuan_bom'];
		$q_std = $_POST['q_std'];
		$q_use = $_POST['q_use'];
		$note = $_POST['note'];

		$kode_spk = buat_kode_spk($thnblntgl,$form,$kode_cabang);	

		$mySql	= "INSERT INTO `spk_hdr` SET 
						`kode_spk`					='".mres($kode_spk)."',
						`ref`						='".($ref)."',
						`kode_cabang`				='".($kode_cabang)."',
						`kode_gudang`				='".($kode_gudang)."',
						`kode_barang`				='".($kode_barang)."',
						`kode_satuan`				='".($kode_satuan)."',
						`qty`				='".($qty)."',
						`tgl_buat`				='".($tgl_buat)."',
						`tgl_selesai`				='".($tgl_selesai)."',
						`keterangan_hdr`				='".($keterangan_hdr)."',
						`user_id`				='".($user_pencipta)."',
						`tgl_input`				='".($tgl_input)."'";
		$query = mysql_query ($mySql) ;		
		
		if (count($kode_item_bom) > 0) {
			for ($i = 0; $i < count($kode_item_bom); $i++) {
				$mySql1	= "INSERT INTO `spk_dtl` SET 
						`kode_spk`					='".mres($kode_spk)."',
						`kode_item_bom`						='".mres($kode_item_bom[$i])."',
						`kode_satuan`						='".mres($kode_satuan_bom[$i])."',
						`base_qty`						='".mres($q_std[$i])."',
						`kebutuhan`						='".mres($q_use[$i])."',
						`keterangan_dtl`						='".mres($note[$i])."'";
				$query1 = mysql_query ($mySql1) ;	
			}
		} else {
			$query1 = false;
		}
		

		if ($query AND $query1) {

			echo "00||".$kode_spk;

		} else { 
			echo "99||Gagal query: ".mysql_error();
		}		 	
	}
	
?>