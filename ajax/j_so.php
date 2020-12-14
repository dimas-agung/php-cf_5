<?php
session_start();
require('../library/conn.php');
require('../library/helper.php');
require('../pages/data/script/so.php');
date_default_timezone_set("Asia/Jakarta");

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "loadhistory") {
    $kd_barang = '';
    $nm_barang = '';

    $kode_inventori = mres($_POST['kode_inventori']);
    if (!empty($kode_inventori)) {
        $pisah = explode(":", $kode_inventori);
        $kd_barang = $pisah[0];
        $nm_barang = $pisah[1];
    }

    $q_his = mysql_query("SELECT `sod`.`kode_barang`, `sod`.`kode_so`, `sod`.`qty`, `sod`.`konversi`, `sod`.`konversi1`, IF(`sod`.`konversi1` > 0, `sod`.`satuan`, `sod`.`satuan_jual`) AS `satuan`, `sod`.`satuan_simpan`, `sod`.`ppn`, `sod`.`harga`, `sod`.`diskon1`, `sod`.`diskon2`, `sod`.`diskon3` FROM `so_dtl` AS `sod` LEFT JOIN `inventori` AS `inv` ON `inv`.`kode_inventori` = `sod`.`kode_barang` WHERE `sod`.`kode_barang` = '" . $kd_barang . "' GROUP BY `sod`.`kode_so` ORDER BY `sod`.`id_so_dtl` DESC LIMIT 0, 100");
	
    $num_rows = mysql_num_rows($q_his);
    if ($num_rows > 0) {
		$diskon1x = 0;
		$diskon2x = 0;
		$diskon3x = 0;
		$subtotal = 0;
        echo '<a><center>' . $nm_barang . '</center></a>';
        echo '<center><a href="#" class="btn-export-csv fa fa-download">Download CSV</a></center>';
		echo '<div style="overflow-x:auto">';
        echo '<table class="table table-striped table-bordered table-hover table-export-csv" width="100%" >
								<thead>
									<tr>
                                        <th>QTY</th>
                                        <th>Konversi</th>
                                        <th>Harga Jual</th>
										<th>Disc 1(%)</th>
										<th>Disc 2(%)</th>
										<th>Disc 3(%)</th>
										<th>PPn</th>
										<th>Harga Setelah Disc</th>
									</tr>
								</thead>
								<tbody>';

        $no = 1;
        while ($rowhis = mysql_fetch_array($q_his)) {
			$diskon1x = ($rowhis['harga'] - ($rowhis['harga'] * ($rowhis['diskon1'] / 100)));
			$diskon2x = ($diskon1x - ($diskon1x * ($rowhis['diskon2'] / 100)));
			$diskon3x = ($diskon2x - ($diskon2x * ($rowhis['diskon3'] / 100)));
			$subtotal = $diskon3x;
			if ($rowhis['ppn'] === '1' || $rowhis['ppn'] === 1) {
				$ppn = '<span class="glyphicon glyphicon-check"> </span>';
			} else {
				$ppn = '<span class="glyphicon glyphicon-unchecked"> </span>';
			}
			
			if (strtolower($rowhis['satuan']) === 'ball') {
				$qtyx = $rowhis['qty'] * ($rowhis['konversi'] * $rowhis['konversi1']);
			} else {
				$qtyx = $rowhis['qty'] * $rowhis['konversi'];
			}
            echo '<tr>
						<td style="text-align:right">' . number_format($rowhis['qty'], 2) . ' ' . $rowhis['satuan'] .  '</td>
						<td style="text-align:right">' . number_format($qtyx, 2) . ' ' . $rowhis['satuan_simpan'] . '</td>
						<td style="text-align:right">' . number_format($rowhis['harga'], 2) . '</td>
						<td style="text-align:right">' . number_format($rowhis['diskon1'], 2) . '</td>
						<td style="text-align:right">' . number_format($rowhis['diskon2'], 2) . '</td>
						<td style="text-align:right">' . number_format($rowhis['diskon3'], 2) . '</td>
						<td style="text-align:right">' . $ppn . '</td>
						<td style="text-align:right">' . number_format($subtotal, 2) . '</td>
				</tr>';
        }

        echo '</tbody></table></div>';
    } else {
        echo '<b style="color:#F00">Belum ada history harga</b>';
    }
}

if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "loadppn" )

	{
		$kode_pelanggan = mres(preg_replace('/\s+/', '', $_POST['kode_pelanggan']));
		$q_ppn = mysql_query("SELECT `Ppn` FROM `pelanggan` WHERE SUBSTRING_INDEX(`kode_pelanggan`, ':', 1) = SUBSTRING_INDEX('" . $kode_pelanggan . "', ':', 1)");	
		$num_rows = mysql_num_rows($q_ppn);
		if($num_rows>0)
		{		
			$rowppn = mysql_fetch_array($q_ppn);
			if ($rowppn['Ppn'] === '1' || $rowppn['Ppn'] === 1) {
				echo '<input class="form-control" type="checkbox" name="ppn" id="ppn" checked><input class="form-control" type="hidden" name="stat_ppn" id="stat_ppn" value="1">';
			} else {
				echo '<input class="form-control" type="checkbox" name="ppn" id="ppn"><input class="form-control" type="hidden" name="stat_ppn" id="stat_ppn" value="0">';
			}
		}
		else {
			echo '<input class="form-control" type="checkbox" name="ppn" id="ppn"><input class="form-control" type="hidden" name="stat_ppn" id="stat_ppn" value="0">';			
		}
	}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "loadhargadiskon") {
	
    $pelanggan = mres($_POST['kode_pelanggan']);
    $inventori = mres($_POST['kode_inventori']);

    $pisah    = explode(":", preg_replace('/\s+/', '', $pelanggan));
    $kode_pelanggan = $pisah[0];
	
	$pisah2    = explode(":", preg_replace('/\s+/', '', $inventori));
    $kode_inventori = $pisah2[0];

    $q_harga = mysql_query("SELECT `p`.`kode_pelanggan`, `p`.`nama` AS `nama_pelanggan`, `kategori_pelanggan`, `i`.`kode_inventori` AS `kode_barang`, `i`.`nama` AS `nama_barang`, `h`.`diskon` AS `diskon1`, `h`.`harga` AS `harga` FROM `inventori` AS `i` LEFT JOIN `harga_inventori` AS `h` ON `h`.`kode_inventori` = `i`.`kode_inventori` LEFT JOIN `pelanggan` AS `p` ON `p`.`kategori_pelanggan` = `h`.`kode_kategori_pelanggan`	WHERE `i`.`aktif` = '1' AND `kategori` = 'ID' AND `kode_pelanggan` = '" . $kode_pelanggan . "' AND `i`.`kode_inventori` = '" . $kode_inventori . "'	GROUP BY `i`.`kode_inventori`, `p`.`kode_pelanggan`");

	$harga = 0;
	$diskon = 0;
    $num_rows = mysql_num_rows($q_harga);
    if ($num_rows > 0) {
        while ($rowdis = mysql_fetch_array($q_harga)) {
			
			$harga = $rowdis['harga'];
			$diskon = $rowdis['diskon1'];
        }
    }
	
	$response = array(
		'harga'=>$harga,
		'diskon'=>$diskon,
    );
	
	echo json_encode($response);
	
}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "addum") {
    if (isset($_POST['um']) and (@$_POST['um'] != "")) {
        $um         = $_POST['um'];
        $nominal     = $_POST['nominal'];
        $id_um         = $_POST['id_um'];

        $array = array();
        if (!isset($_SESSION['data_um'])) {
            $array[$id_um] = array("id_um" => $id_um, "um" => $um, "nominal" => $nominal);
        } else {
            $array = $_SESSION['data_um'];
            $array[$id_um] = array("id_um" => $id_um, "um" => $um, "nominal" => $nominal);
        }

        $_SESSION['data_um'] = $array;
        echo view_item_um($array);
    }
}

function view_item_um($data)
{
    $n = 1;
    $html = "";
    $grandtotal = 0;
    $total = 0;
    if (count($data) > 0) {
        foreach ($data as $key => $item) {

            $total += ($item['um']);
            $html .= '<div class="row">';
            $html .= '<div class="container">';
            $html .= '&nbsp;';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '<div class="row">';
            $html .= '<div class="container">';
            $html .= '<label class="col-lg-2 control-label" style="text-align:left"></label>';

            $html .= '<div class="col-lg-3 col-md-3 col-xs-4">
						<input type="text" readonly name="um1[]" data-id="um1" data-group="' . $item['id_um'] . '" class="form-control" placeholder="Uang Muka %" value="' . $item['um'] . '%">
					</div>

					<div class="col-lg-3 col-md-3 col-xs-4">
						 <input type="text" readonly name="nominal[]" data-id="nominal1" data-group="' . $item['id_um'] . '" class="form-control" placeholder="0" value="' . $item['nominal'] . '" >
					</div>

					<button class="btn btn-danger remove hapus-um col-lg-2 col-md-2 col-xs-" type="button" data-id="' . $key . '"><i class="glyphicon glyphicon-remove"></i> Hapus.</button>';
            $html .= '</div>';
            $html .= '</div>';
        }
        $html .= "<script>$('.hapus-um').click(function(){
						var id =	$(this).attr('data-id');
						$.ajax({
							type: 'POST',
							url: '" . base_url() . "ajax/j_so.php?func=hapus-um',
							data: 'idhapus='+id ,
							cache: false,
							success:function(data){
								var html = $('.copy').html(data);
									$('.after-add-more').after(html);

									$('body').on('click','.remove',function(){
									  $(this).parents('.control-group').remove();
									});

									$('#um').focus();
							 }
						  });
					  });
				     </script>";
    }
    return $html;
}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "hapus-um") {
    $id = $_POST['idhapus'];
    unset($_SESSION['data_um'][$id]);
    echo view_item_um($_SESSION['data_um']);
}


if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "add") {

    if (isset($_POST['kode_barang']) and @$_POST['kode_barang'] != "") {

        $id_form        = mres($_POST['id_form']);
		$kd_barang = '';
		$nm_barang = '';
		$kode_barang = mres($_POST['kode_barang']);
		if(!empty($kode_barang))
		{
			$pisah=explode(":",$kode_barang);
			$kd_barang=$pisah[0];
			$nm_barang=$pisah[1];
		}
		
		$foc = mres($_POST['stat_foc']);
		$satuan = (mres($_POST['konversi1']) > 0 ? mres($_POST['satuan']) : null);
		$satuan_jual = mres($_POST['satuan_jual']);
		$satuan_simpan = mres($_POST['satuan_simpan']);
		$konversi1 = mres($_POST['konversi1']);
		$konversi = mres(str_replace(',', null, $_POST['konversi']));
		$qty = mres(str_replace(',', null, $_POST['qty']));
		$harga = mres(str_replace(',', null, $_POST['harga']));
		$diskon1 = mres(str_replace(',', null, $_POST['diskon1']));
		$diskon2 = mres(str_replace(',', null, $_POST['diskon2']));
		$diskon3 = mres(str_replace(',', null, $_POST['diskon3']));
		$ppn = mres($_POST['ppn']);
		$ppn_n = mres(str_replace(',', null, $_POST['ppn_n']));
		$subtot = mres(str_replace(',', null, $_POST['subtot']));
		$keterangan_dtl = mres($_POST['keterangan']);
		
		$array = array();
		
		if (!isset($_SESSION['data_so_' . $id_form])) {
			$array[$kd_barang] = array(
				'id_form' => $id_form,
				'kode_barang' => $kd_barang,
				'nama_barang' => $nm_barang,
				'foc' => $foc,
				'satuan' => $satuan,
				'konversi1' => $konversi1,
				'konversi' => $konversi,
				'satuan_jual' => $satuan_jual,
				'satuan_simpan' => $satuan_simpan,
				'qty' => $qty,
				'harga' => $harga,
				'diskon1' => $diskon1,
				'diskon2' => $diskon2,
				'diskon3' => $diskon3,
				'ppn' => $ppn,
				'ppn_n' => $ppn_n,
				'subtot' => $subtot,
				'keterangan_dtl' => $keterangan_dtl,
			);
		} else {
			$array = $_SESSION['data_so_' . $id_form];
			$array[$kd_barang] = array(
				'id_form' => $id_form,
				'kode_barang' => $kd_barang,
				'nama_barang' => $nm_barang,
				'foc' => $foc,
				'satuan' => $satuan,
				'konversi1' => $konversi1,
				'konversi' => $konversi,
				'satuan_jual' => $satuan_jual,
				'satuan_simpan' => $satuan_simpan,
				'qty' => $qty,
				'harga' => $harga,
				'diskon1' => $diskon1,
				'diskon2' => $diskon2,
				'diskon3' => $diskon3,
				'ppn' => $ppn,
				'ppn_n' => $ppn_n,
				'subtot' => $subtot,
				'keterangan_dtl' => $keterangan_dtl,
			);
		}
		$_SESSION['data_so_' . $id_form] = $array;
        echo view_item_so($array);
    }
}


function view_item_so($data)
{
    $n                 = 1;
    $konversi 		= 0;
    $diskon1x 		= 0;
	$diskon2x 		= 0;
	$diskon3x 		= 0;
	$ppn_n	 		= 0;
	$ppn_vn	 		= 0;
	$subtot 		= 0;
	$subtotal 		= 0;
	$grandtotal 	= 0;
    $html = "";
    if (count($data) > 0) {
        foreach ($data as $key => $item) {

            if ($item['ppn'] === '1' || $item['ppn'] === 1) {
                $stat_ppn = '<span class="glyphicon glyphicon-check"> </span>';
            } else {
                $stat_ppn = '<span class="glyphicon glyphicon-unchecked"> </span>';
            }

            if ($item['foc'] === '1' || $item['foc'] === 1) {
                $stat_foc = '<span class="glyphicon glyphicon-check"> </span>';
            } else {
                $stat_foc = '<span class="glyphicon glyphicon-unchecked"> </span>';
            }
			
			if ($item['konversi1'] > 0) {
				$konversi = ($item['qty'] * ($item['konversi'] * $item['konversi1']));
			} else {
				$konversi = ($item['qty'] * $item['konversi']);
			}

            $html .= '<tr>
							<td style=" text-align: center">' . $n++ . '</td>
							<td colspan="2">' . $item['nama_barang'] . '</td>
							<td style="text-align: center">' . $stat_foc . '</td>
							<td style="text-align:right">' . (!empty($item['satuan']) ? $item['satuan'] : '-') . '</td>
							<td style="text-align:right">' . number_format($item['qty'], 2) . ' ' . ($item['konversi1'] > 0 ? $item['satuan'] : $item['satuan_jual']) . '</td>
							<td style="text-align:right">' . number_format($konversi, 2) . ' ' . $item['satuan_simpan'] . '</td>
							<td style="text-align:right">' . number_format($item['harga'], 2) . '</td>
							<td style="text-align:right">' . number_format($item['diskon1'], 2) . '</td>
							<td style="text-align:right">' . number_format($item['diskon2'], 2) . '</td>
							<td style="text-align:right">' . number_format($item['diskon3'], 2) . '</td>
							<td style="text-align:center">' . $stat_ppn . '</td>
							<td style="text-align:right">' . number_format($item['subtot'], 2) . '</td>
							<td>' . $item['keterangan_dtl'] . '</td>
							<td style="text-align: center">
							<!-- <a href="javascript:;" class="label label-info edit_so" data-toggle="modal" data-target="#edit_so" data-id="' . $item['id'] . '"><i class="fa fa-pencil"></i></a> -->
							<a href="javascript:;" class="label label-danger hapus-so" title="hapus data" data-id="' . $key . '"><i class="fa fa-times"></i></a>
							</td>
						</tr>
						';

						$qty = $item['qty'];
						$konversi = $item['konversi'];
						$konversi1 = $item['konversi1'];
						$diskon1x = ($item['harga'] - ($item['harga'] * ($item['diskon1'] / 100)));
						$diskon2x = ($diskon1x - ($diskon1x * ($item['diskon2'] / 100)));
						$diskon3x = ($diskon2x - ($diskon2x * ($item['diskon3'] / 100)));
						
						if ($konversi1 > 0) {
							$subtot = ($diskon3x * ($qty * ($konversi * $konversi1)));
						} else {
							$subtot = ($diskon3x * ($qty * $konversi));
						}
						
						if ($item['ppn'] === '1') {
							$ppn_n = ($subtot - ($subtot / 1.1));
						}
						else {
							$ppn_n = 0;
						}
						$subtotal += $subtot - $ppn_n;
						$ppn_vn += $ppn_n;
        }
					$grandtotal = $subtotal + $ppn_vn;
        $html .= '<tr>
								<td style="text-align:right" colspan="12"><b>DPP :</b></td>
								<td style="text-align:right"><b>' . number_format($subtotal, 2) . '</b> <input type="hidden" name="total_harga" id="total_harga" value="' . $subtotal . '" /></td>
								<td style="text-align:right" colspan="2"></td>
							</tr>
							<tr>
								<td style="text-align:right" colspan="12"><b>PPn :</b></td>
								<td style="text-align:right"><b>' . number_format($ppn_vn, 2) . '</b> <input type="hidden" name="total_ppn" id="total_ppn" value="' . $ppn_vn . '" /></td>
								<td style="text-align:right" colspan="2"></td>
							</tr>
							<tr>
								<td style="text-align:right"" colspan="12"><b>Total :</b></td>
								<td style="text-align:right"><b>' . number_format($grandtotal, 2) . '</b><input type="hidden" name="grand_total" id="grand_total" value="' . $grandtotal . '" /></td>
								<td style="text-align:right" colspan="2"></td>
							</tr>
					  ';

        $html .= "<script>$('.hapus-so').click(function(){
						var id =	$(this).attr('data-id');
						var id_form = $('#id_form').val();
						$.ajax({
							type: 'POST',
							url: '" . base_url() . "ajax/j_so.php?func=hapus-so',
							data: 'idhapus=' + id + '&id_form=' +id_form,
							cache: false,
							success:function(data){
								$('#detail_input_so').html(data).show();
							 }
						  });
					  });
				     </script>";
    } else {
        $html .= '<tr> <td colspan="15" class="text-center"> Tidak ada item barang. </td></tr>
		<tr>
			<td style="text-align:right" colspan="12"><b>DPP :</b></td>
			<td style="text-align:right"><b>0</b> <input type="hidden" name="total_harga" id="total_harga" value="0" /></td>
			<td style="text-align:right" colspan="2"></td>
		</tr>
		<tr>
			<td style="text-align:right" colspan="12"><b>PPn :</b></td>
			<td style="text-align:right"><b>0</b> <input type="hidden" name="total_ppn" id="total_ppn" value="0" /></td>
			<td style="text-align:right" colspan="2"></td>
		</tr>
		<tr>
			<td style="text-align:right"" colspan="12"><b>Total :</b></td>
			<td style="text-align:right"><b>0</b><input type="hidden" name="grand_total" id="grand_total" value="0" /></td>
			<td style="text-align:right" colspan="2"></td>
		</tr>
		';
    }

    return $html;
}


if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "hapus-so") {
    $id = $_POST['idhapus'];
    $id_form = $_POST['id_form'];
    $itemdelete = "DELETE FROM so_dtl_tmp WHERE id_so_dtl = '" . $id . "'";
    mysql_query($itemdelete);
    unset($_SESSION['data_so_' . $id_form][$id]);
    echo view_item_so($_SESSION['data_so_' . $id_form]);
}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "edit-so") {

    $id                = $_POST['id'];
    $query            = "SELECT * from so_dtl_tmp WHERE id_so_dtl = '$id' ";
    $result            = mysql_query($query);

    while ($res = mysql_fetch_array($result)) {

        if ($res['ppn'] == '1') {
            $stat_ppn_edit = 'checked';
        } else {
            $stat_ppn_edit = '';
        }

        if ($res['foc'] == '1') {
            $stat_foc_edit = 'checked';
        } else {
            $stat_foc_edit = '';
        }

        echo ' <div class="col-md-12 pm-min">
                    <form role="form" method="post" action="" id="form-edit-so">
                        <div class="col-md-12 pm-min-s">

                            <div class="col-md-6 pm-min-s">
                                <label class="control-label">Kode Barang</label>
                                <input type="text" name="kode_barang_edit" value=' . $res['kode_barang'] . ' id="kode_barang_edit" class="form-control" placeholder="Kode Barang ..." readonly/>
                                <input type="hidden" name="id_edit" value=' . $res['id_so_dtl'] . ' id="id_edit" class="form-control" placeholder="ID Barang ..."/>
                                <input type="hidden" name="id_form_edit" id="id_form_edit" value=' . $res['id_form'] . ' class="form-control" placeholder="Description..."/>
                            </div>

                            <div class="col-md-6 pm-min-s">
                            	<label class="control-label">Deskripsi Barang</label>
                           		<input type="text" name="nama_barang_edit" id="nama_barang_edit" value="' . $res['nama_barang'] . '" class="form-control"  readonly/>
                            </div>

                            <div class="col-md-6 pm-min-s">
                            	<label class="control-label">Satuan</label>
                            	<select id="satuan_edit" name="satuan_edit" class="select2" style="width: 100%;">
                            		<option value="0">-- SATUAN --</option>
             ';
        while ($rowitem = mysql_fetch_array($q_sat_dtl)) {
            echo '							<option value="' . $rowitem['kode_satuan'] . '"
						 						' . ($rowitem['kode_satuan'] == $res['satuan'] ? 'selected' : '') . '> ' . $rowitem['nama_satuan'] . '
						 					</option>
			 ';
        }
        echo '
                                </select>
                            </div>

                            <div class="col-md-6 pm-min-s">
                            	<label class="control-label">Konversi1</label>
                            	<input type="number" name="konversi1_edit" id="konversi1_edit" value="' . $res['konversi1'] . '" class="form-control"/>
                            </div>

                            <div class="col-md-6 pm-min-s">
                            	<label class="control-label">Satuan Jual</label>
                            	<input type="text" name="satuan_jual_edit" id="satuan_jual_edit" value=' . $res['satuan_jual'] . ' class="form-control" value="0" readonly/>
                            </div>

                            <div class="col-md-6 pm-min-s">
                            	<label class="control-label">Konversi</label>
                            	<input type="number" name="konversi_edit" id="konversi_edit" value="' . $res['konversi'] . '" class="form-control"  readonly/>
                            </div>

                            <div class="col-md-6 pm-min-s">
                            	<label class="control-label">Satuan Simpan</label>
                            	<input type="text" name="satuan_simpan_edit" id="satuan_simpan_edit" value=' . $res['satuan_simpan'] . ' class="form-control" value="0" readonly/>
                            </div>

                            <div class="col-md-6 pm-min-s">
                            	<label class="control-label">QTY</label>
                            	<input type="number" name="qty_edit" id="qty_edit" value=' . $res['qty'] . ' class="form-control" />
                            </div>

                            <div class="col-md-4 pm-min-s">
                            	<label class="control-label">Harga</label>
                            	<input type="number" name="harga_edit" id="harga_edit" value=' . $res['harga'] . ' class="form-control"  readonly/>
                            </div>

                            <div class="col-md-4 pm-min-s">
                            	<label class="control-label">Diskon</label>
                            	<input type="number" name="diskon1_edit" id="diskon1_edit" value=' . $res['diskon1'] . ' class="form-control"/>
                            </div>

                            <div class="col-md-4 pm-min-s">
                            	<label class="control-label">PPN</label>
                            	<input class="form-control" type="checkbox" name="ppn_edit" id="ppn_edit" ' . $stat_ppn_edit . ' >
                                <input class="form-control" type="hidden" name="stat_ppn_edit" id="stat_ppn_edit" value=' . $res['ppn'] . '>
                            </div>

                            <div class="col-md-4 pm-min-s">
                            	<label class="control-label">Subtotal</label>
                            	<input type="number" name="subtot_edit" id="subtot_edit" value=' . $res['subtotal'] . ' class="form-control" readonly/>
                            </div>

                            <div class="col-md-4 pm-min-s">
                            	<label class="control-label">Keterangan</label>
                            	<input type="text" name="keterangan_edit" id="keterangan_edit" value="' . $res['keterangan_dtl'] . '" class="form-control"/>
                            </div>

                            <div class="col-md-4 pm-min-s">
                            	<label class="control-label">FOC</label>
                            	<input class="form-control" type="checkbox" name="foc_edit" id="foc_edit" ' . $stat_foc_edit . ' >
                                <input class="form-control" type="hidden" name="stat_foc_edit" id="stat_foc_edit" value=' . $res['foc'] . '>
                            </div>
                        </div>
                    </form>
                </div>
				<div class="modal-footer">
                    <button type="button" name="submit" class="btn btn-success edit-to-so" data-dismiss="modal"><i class="fa fa-plus"></i> Update</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>';

        echo "<script>$('.edit-to-so').click(function(){
						var id =	$(this).attr('data-id');
						$.ajax({
							type: 'POST',
							url: '" . base_url() . "ajax/j_so.php?func=update-so',
							data: $('#form-edit-so').serialize(),
							cache: false,
							success:function(data){
								$('#detail_input_so').html(data).show();
							}
						});
					});
				  </script>";
    }
}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "update-so") {
    if (isset($_POST['kode_barang_edit']) and @$_POST['kode_barang_edit'] != "") {

        $id_form = $_POST['id_form_edit'];
        $itemeditso = "UPDATE so_dtl_tmp SET
											kode_barang		='" . $_POST['kode_barang_edit'] . "',
											nama_barang		='" . $_POST['nama_barang_edit'] . "',
											foc				='" . $_POST['stat_foc_edit'] . "',
											satuan_jual		='" . $_POST['satuan_jual_edit'] . "',
											satuan_simpan	='" . $_POST['satuan_simpan_edit'] . "',
											konversi		='" . $_POST['konversi_edit'] . "',
											satuan			='" . $_POST['satuan_edit'] . "',
											konversi1		='" . $_POST['konversi1_edit'] . "',
											qty				='" . $_POST['qty_edit'] . "',
											harga			='" . $_POST['harga_edit'] . "',
											diskon1			='" . $_POST['diskon1_edit'] . "',
											ppn				='" . $_POST['stat_ppn_edit'] . "',
											subtotal		='" . $_POST['subtot_edit'] . "',
											keterangan_dtl	='" . $_POST['keterangan_edit'] . "'
										 	WHERE id_so_dtl ='" . $_POST['id_edit'] . "' ";
        mysql_query($itemeditso);

        $query            = "SELECT a.*, b.nama satuan_ikat FROM so_dtl_tmp a LEFT JOIN satuan b ON b.kode_satuan = a.satuan WHERE id_form='" . $_POST['id_form_edit'] . "'";
        $result            = mysql_query($query);

        $array = array();
        if (mysql_num_rows($result) > 0) {
            while ($res = mysql_fetch_array($result)) {

                $array[$res['id_so_dtl']] = array("id" => $res['id_so_dtl'], "kode_barang" => $res['kode_barang'], "nama_barang" => $res['nama_barang'], "foc" => $res['foc'], "satuan_jual" => $res['satuan_jual'], "satuan_simpan" => $res['satuan_simpan'], "konversi" => $res['konversi'], "satuan" => $res['satuan_ikat'], "konversi1" => $res['konversi1'], "qty" => $res['qty'], "harga" => $res['harga'], "diskon1" => $res['diskon1'], "ppn" => $res['ppn'], "subtotal" => $res['subtotal'], "keterangan_dtl" => $res['keterangan_dtl'], "id_form" => $res['id_form']);
            }
        }

        $_SESSION['data_so'] = $array;
        echo view_item_so($array);
    }
}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "save") {

    // Set autocommit to off
    mysqli_autocommit($con, FALSE);

    $form             = 'SO';
    $thnblntgl         = date("ymd", strtotime(mres($_POST['tgl_so'])));

    $id_form    = mres($_POST['id_form']);
    $kode_pelanggan    = mres($_POST['kode_pelanggan']);
    $kode_gudang    = mres($_POST['kode_gudang']);
    $kode_cabang    = mres($_POST['kode_cabang']);
    $kode_salesman    = mres($_POST['salesman']);
    $tgl_buat         = date("Y-m-d", strtotime(mres($_POST['tgl_so'])));
    $tgl_kirim         = date("Y-m-d", strtotime(mres($_POST['tgl_kirim'])));
    $alamat         = mres($_POST['alamat']);
    $alamat_kirim     = mres($_POST['alamat_kirim']);
    $ref            = mres($_POST['ref']);
    $top             = mres($_POST['top']);
    $total_harga    = mres(str_replace(',', null, $_POST['total_harga']));
    $total_ppn        = mres(str_replace(',', null, $_POST['total_ppn']));
    $subtotal        = mres(str_replace(',', null, $_POST['grand_total']));
    $keterangan_hdr    = mres($_POST['keterangan_hdr']);

    $user_pencipta  = $_SESSION['app_id'];
    $tgl_input         = date("Y-m-d H:i:s");

    $kode_so = buat_kode_so($thnblntgl, $form, $kode_cabang);

    //HEADER SO
    $mySql    = "INSERT INTO `so_hdr` SET
						`kode_so`					='" . $kode_so . "',
						`kode_pelanggan`			='" . $kode_pelanggan . "',
						`kode_gudang`				='" . $kode_gudang . "',
						`kode_cabang`				='" . $kode_cabang . "',
						`kode_salesman` 			='" . $kode_salesman . "',
						`tgl_buat`				='" . $tgl_buat . "',
						`tgl_kirim`				='" . $tgl_kirim . "',
						`alamat`					='" . $alamat . "',
						`alamat_kirim`			='" . $alamat_kirim . "',
						`ref`						='" . $ref . "',
						`top` 					='" . $top . "',
						`total_harga`				='" . $total_harga . "',
						`total_ppn`				='" . $total_ppn . "',
						`subtotal`				='" . $subtotal . "',
						`keterangan_hdr`			='" . $keterangan_hdr . "',
						`user_pencipta`			='" . $user_pencipta . "',
						`tgl_input`				='" . $tgl_input . "'
				  ";

    $query = mysqli_query($con, $mySql);

    //DETAIL SO
    $array = $_SESSION['data_so_' . $id_form];
    foreach ($array as $key => $item) {
        $kode_barang    = mres($item['kode_barang']);
        $nama_barang     = mres($item['nama_barang']);
        $foc             = mres($item['foc']);
        $satuan_jual    = mres($item['satuan_jual']);
        $satuan_simpan    = mres($item['satuan_simpan']);
        $konversi        = mres($item['konversi']);
        $satuan            = mres($item['satuan']);
        $konversi1        = mres($item['konversi1']);
        $qty            = mres(str_replace(',', null, $item['qty']));
        $harga            = mres(str_replace(',', null, $item['harga']));
        $diskon1        = mres(str_replace(',', null, $item['diskon1']));
        $diskon2        = mres(str_replace(',', null, $item['diskon2']));
        $diskon3        = mres(str_replace(',', null, $item['diskon3']));
        $ppn            = mres($item['ppn']);
        $total_harga     = mres(str_replace(',', null, $item['subtot']));
        $keterangan_dtl    = mres($item['keterangan_dtl']);

        $mySql1 = "INSERT INTO `so_dtl` SET
											`kode_so`				='" . $kode_so . "',
											`kode_barang` 		='" . $kode_barang . "',
											`nama_barang` 		='" . $nama_barang . "',
											`foc` 				='" . $foc . "',
											`satuan_jual`			='" . $satuan_jual . "',
											`satuan_simpan`		='" . $satuan_simpan . "',
											`konversi`			='" . $konversi . "',
											`satuan`				='" . ($konversi1 > 0 ? $satuan : null) . "',
											`konversi1`			='" . $konversi1 . "',
											`qty`					='" . $qty . "',
											`harga`				='" . $harga . "',
											`diskon1`				='" . $diskon1 . "',
											`diskon2`				='" . $diskon2 . "',
											`diskon3`				='" . $diskon3 . "',
											`ppn`					='" . $ppn . "',
											`total_harga`			='" . $total_harga . "',
											`keterangan_dtl`		='" . $keterangan_dtl . "' ";
        $query1 = mysqli_query($con, $mySql1);
    }

    if ($query and $query1) {
        mysqli_query($con, "DELETE FROM so_dtl_tmp WHERE id_form ='" . $_POST['id_form'] . "' ");

        // Commit transaction
        mysqli_commit($con);

        // Close connection
        mysqli_close($con);

        echo "00||" . $kode_so;

        if (isset($_SESSION['data_um'])) {
            //DETAIL UM
            $array = $_SESSION['data_um'];
            foreach ($array as $key => $item) {
                $termin        = $item['nominal'];
                $persen        = $item['um'];
                //$termin 	=str_replace("%","",$nominal);

                $mySql2 = "INSERT INTO so_um SET
													kode_so		='" . $kode_so . "',
													termin		='" . $termin . "',
													persen 		='" . $persen . "' ";

                $query2 = mysql_query($mySql2);
            }

            unset($_SESSION['data_um']);
        }

        unset($_SESSION['data_so']);
    } else {

        echo "Gagal query: " . mysql_error();
    }
}

	if( isset( $_REQUEST['func'] ) and @$_REQUEST['func'] == "clsman" )
	{
		mysqli_autocommit($con,FALSE);
		$kode_so		= mres($_POST['kode_so']);
				
		//UPDATE SO_HDR 

		$mySql1 = "UPDATE `so_hdr` SET `status` = '3' WHERE `kode_so` = '".$kode_so."'";
		$query1 = mysqli_query ($con,$mySql1) ;
		
		$mySql2 = "UPDATE `so_dtl` SET `status_dtl` = '3' WHERE `kode_so` = '".$kode_so."'";
		$query2 = mysqli_query ($con,$mySql2) ;
		
		if ($query1 AND $query2 ) {
			mysqli_commit($con);
			mysqli_close($con);
			echo "00||".$kode_op;
		} else { 
			echo "Gagal query: ".mysql_error();
		}	
	}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "pembatalan") {
    mysqli_autocommit($con, FALSE);

    $kode_so        = $_POST['kode_so_batal'];
    $alasan_batal    = $_POST['alasan_batal'];
    $tgl_batal         = date("Y-m-d");
	
	$cekSj = "SELECT `kode_so` FROM `sj_hdr` WHERE `status` = '1' AND `kode_so` = '".$kode_so."'";
	$querySj = mysqli_query($con, $cekSj);
	
	if (mysqli_num_rows($querySj) > 0) {
		mysqli_commit($con);
		mysqli_close($con);
		echo "99||Kode SO " . $kode_so . " sudah SJ!";
		return false;
	}
	
    //UPDATE SO_HDR
    $mySql1 = "UPDATE so_hdr SET status ='2', alasan_batal = '" . $alasan_batal . "', user_batal = '" . $_SESSION['app_id'] . "', tgl_batal = '" . $tgl_batal . "' WHERE kode_so='" . $kode_so . "' ";
    $query1 = mysqli_query($con, $mySql1);

    //UPDATE SO_DTL
    $mySql2 = "UPDATE so_dtl SET status_dtl ='2' WHERE kode_so='" . $kode_so . "' ";
    $query2 = mysqli_query($con, $mySql2);

    if ($query1 and $query2) {

        mysqli_commit($con);
        mysqli_close($con);

        echo "00||" . $kode_so;
    } else {
        echo "99||Gagal query: " . mysql_error();
    }
}
