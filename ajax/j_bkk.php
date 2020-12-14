<?php
session_start();
require('../library/conn.php');
require('../library/helper.php');
require('../pages/data/script/bkk.php');
date_default_timezone_set("Asia/Jakarta");

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "loaditem") {
    $kode_supplier    = $_POST['kode_supplier'];
    $kode_cabang    = $_POST['kode_cabang'];
    $id_form         = $_POST['id_form'];

    $query        = "SELECT kh.kode_transaksi, kh.kode_cabang,fh.kode_supplier, s.nama nama_supplier,DATE_FORMAT(kh.tgl_jth_tempo, '%d-%m-%Y') AS jatuh_tempo,
							kh.kode_pelunasan,kh.lunas,SUM(debet) totdebet, SUM(kredit) totkredit, (SUM(kredit)-SUM(debet)) saldo, 0 jumlah_bayar, 0 jumlah_lunas,
							'' ket_dtl, s.coa_debet FROM kartu_hutang kh
							LEFT JOIN fb_hdr fh ON kh.kode_transaksi=fh.kode_fb
							INNER JOIN supplier s ON s.kode_supplier=kh.kode_supplier
							WHERE kh.kode_cabang='" . $kode_cabang . "' AND kh.kode_supplier='" . $kode_supplier . "'
								AND kh.kode_transaksi NOT IN (SELECT kode_transaksi FROM kartu_hutang WHERE (status_batal='1' OR lunas='1') ) GROUP BY kh.kode_transaksi";
    $result        = mysql_query($query);

    $query_coa        = "SELECT kode_coa, nama FROM coa where level_coa = '4'";
    $resultcoa        = mysql_query($query_coa);

    $array = array();
    if (mysql_num_rows($result) > 0) {
        while ($res = mysql_fetch_array($result)) {
            $array[] = array("deskripsi" => $res['kode_transaksi'], "jatuh_tempo" => $res['jatuh_tempo'], "saldo_transaksi" => $res['saldo'], "nominal_bayar" => $res['jumlah_bayar'], "nominal_pelunasan" => $res['jumlah_lunas'], "coa" => $res['coa_debet'], "selisih" => '0', "keterangan_dtl" => $res['ket_dtl'], "id_form" => $id_form);
        }
    }

    $arraycoa = array();
    if (mysql_num_rows($resultcoa) > 0) {
        while ($res1 = mysql_fetch_array($resultcoa)) {
            $arraycoa[] = array("kode_coa" => $res1['kode_coa'], "nama_coa" => $res1['nama']);
        }
    }


    $_SESSION['load_bkk' . $id_form . ''] = $array;
    $_SESSION['load_coa' . $id_form . ''] = $arraycoa;

    echo view_item_bkk($array, $arraycoa);
}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "add") {
    if (isset($_POST['kode_coa']) and @$_POST['kode_coa'] != "") {

        $coa       = $_POST['kode_coa'];
        $kd_coa      = explode(":", $coa);
        $kode_coa = $kd_coa[0];
        $nama_coa = $kd_coa[1];
        $id_form  = $_POST['id_form'];

        $array = array();
        if (!isset($_SESSION['load_bkk' . $id_form . ''])) {
            $array[] = array("deskripsi" => $_POST['deskripsi'], "jatuh_tempo" => '0', "saldo_transaksi" => $_POST['saldo_transaksi'], "nominal_bayar" => $_POST['nominal_bayar'], "nominal_pelunasan" => $_POST['nominal_pelunasan'], "coa" => '0', "selisih" => $_POST['selisih'], "kode_coa1" => $kode_coa, "nama_coa1" => $nama_coa, "keterangan_dtl" => $_POST['keterangan_dtl'], "id_form" => $_POST['id_form']);
        } else {
            $array = $_SESSION['load_bkk' . $id_form . ''];
            $array[] = array("deskripsi" => $_POST['deskripsi'], "jatuh_tempo" => '0', "saldo_transaksi" => $_POST['saldo_transaksi'], "nominal_bayar" => $_POST['nominal_bayar'], "nominal_pelunasan" => $_POST['nominal_pelunasan'], "coa" => '0', "selisih" => $_POST['selisih'], "kode_coa1" => $kode_coa, "nama_coa1" => $nama_coa, "keterangan_dtl" => $_POST['keterangan_dtl'], "id_form" => $_POST['id_form']);
        }

        $arraycoa = array();
        if (!isset($_SESSION['load_coa' . $id_form . ''])) {
            $arraycoa[] = array("kode_coa" => '1', "nama_coa" => '1');
        } else {
            $arraycoa = $_SESSION['load_coa' . $id_form . ''];
            $arraycoa[] = array("kode_coa" => '1', "nama_coa" => '1');
        }

        $_SESSION['load_bkk' . $id_form . ''] = $array;
        $_SESSION['load_coa' . $id_form . ''] = $arraycoa;
        echo view_item_bkk($array, $arraycoa);
    }
}


function view_item_bkk($array, $arraycoa)
{
    $n = 1;
    $total = 0;
    $html = "";
    if (count($array) > 0) {
        foreach ($array as $key => $item) {

            if ($item['jatuh_tempo'] == '0') {

                $cheked      = 'checked';
                $stat_cb  = '1';
                $nominal_bayar1 = 'readonly';
                $nominal_bayar = $item['nominal_bayar'];
                $nominal_pelunasan = 'readonly';
                $kode_coa = '';
                $pilih_coa = '';
                $keterangan_dtl = 'readonly';
                $edit = 'label label-info edit_bkk';
                $id = '';

                $html .= '<tr>
										<td width="30px">
											<div class="checkbox" style="text-align:right">
												<input type="checkbox" name="cb[]" id="cb[]" data-id="cb" data-group="' . $n . '" value="' . $n . '" ' . $cheked . '>
											</div>
											<input type="hidden" class="form-control" name="stat_cb[]" id="stat_cb[]" data-id="stat_cb" data-group="' . $n . '" value="' . $stat_cb . '" >
											<input type="hidden" class="form-control" name="stat_manual[]" id="stat_manual[]" data-id="stat_manual" data-group="'.$n.'" value="y" >
										</td>
										<td style="text-align:left">
											<input class="form-control" type="text" name="deskripsi[]" id="deskripsi[]" data-id="deskripsi" data-group="' . $n . '" value="' . $item['deskripsi'] . '" style="width: 13em" readonly/>
											<input type="hidden" class="form-control" name="jatuh_tempo[]" id="jatuh_tempo[]" data-id="jatuh_tempo" data-group="' . $n . '" value="' . $item['jatuh_tempo'] . '" >
											<input type="hidden" class="form-control" name="key[]" id="key[]" data-id="key" data-group="' . $n . '" value="' . $key . '" >
										</td>
										<td style="text-align:right">
											<input class="form-control" type="text" name="saldo_transaksi[]" id="saldo_transaksi[]" data-id="saldo_transaksi" data-group="' . $n . '" value="' . $item['saldo_transaksi'] . '" style="text-align: right" readonly/>
										</td>
										<td style="text-align:right">
											<input class="form-control" type="text" name="nominal_bayar[]" id="nominal_bayar[]" data-id="nominal_bayar" data-group="' . $n . '" value="' . $nominal_bayar . '" style="text-align: right" ' . $nominal_bayar1 . '/>
										</td>
										<td style="text-align:right">
											<input class="form-control" type="text" name="nominal_pelunasan[]" id="nominal_pelunasan[]" data-id="nominal_pelunasan" data-group="' . $n . '" value="' . $item['nominal_pelunasan'] . '" style="text-align: right" ' . $nominal_pelunasan . '/>
										</td>
										<td style="text-align:right">
											<input class="form-control" type="text" name="selisih[]" id="selisih[]" data-id="selisih" data-group="' . $n . '" value="' . $item['selisih'] . '" style="text-align: right" readonly/>
										</td>
										<td style="width:400px">
											<select id="kode_coa[]" name="kode_coa[]" data-id="kode_coa" data-group="' . $n . '" class="select2" ' . $kode_coa . ' style="width: 400px">
												' . $pilih_coa . '
									';

                $html .= '
										<option value="' . $item['kode_coa1'] . '">' . $item['kode_coa1'] . '&nbsp;&nbsp;||&nbsp;&nbsp;' . $item['nama_coa1'] . '</option>
									';

                $html .= '
											</select>
											<input type="hidden" name="coa_kredit[]" value="' . $item['coa'] . '" id="coa_kredit[]">
										</td>
										<td>
											<input type="text" class="form-control" name="keterangan_dtl[]" id="keterangan_dtl[]" data-id="keterangan_dtl" data-group="' . $n . '" placeholder="Keterangan ..." value="' . $item['keterangan_dtl'] . '" ' . $keterangan_dtl . '>
										</td>
										<td style="text-align:center">
											<!-- <a href="javascript:;" class="' . $edit . '" data-toggle="modal" data-target="#edit_bkk" data-id="' . $id . '"><i class="fa fa-pencil"></i></a> -->
											<a href="javascript:;" class="label label-danger hapus-bkk" title="hapus data" data-id="' . $key . '"><i class="fa fa-times"></i></a>
										</td>
									</tr>';
                $total += $item['nominal_bayar'];
                $n++;
            } else {

                $cheked   = '';
                $stat_cb  = '1';
                $nominal_bayar1 = '';
                $nominal_bayar = $item['saldo_transaksi'];
                $nominal_pelunasan = '';
                $kode_coa = '';
                $pilih_coa = '<option value="null">-- Pilih COA --</option>';
                $keterangan_dtl = '';
                $edit = 'hidden';
                $id = '';

                $html .= '<tr>
									<td width="30px">
										<div class="checkbox" style="text-align:right">
											<input type="checkbox" name="cb[]" id="cb[]" data-id="cb" data-group="' . $n . '" value="' . $n . '" ' . $cheked . '>
										</div>
										<input type="hidden" class="form-control" name="stat_cb[]" id="stat_cb[]" data-id="stat_cb" data-group="' . $n . '" value="' . $stat_cb . '" >
										<input type="hidden" class="form-control" name="stat_manual[]" id="stat_manual[]" data-id="stat_manual" data-group="'.$n.'" value="n" >
									</td>
									<td width="200px" style="text-align:left">
										<input class="form-control" type="text" name="deskripsi[]" id="deskripsi[]" data-id="deskripsi" data-group="' . $n . '" value="' . $item['deskripsi'] . '" readonly/>
										<input type="hidden" class="form-control" name="jatuh_tempo[]" id="jatuh_tempo[]" data-id="jatuh_tempo" data-group="' . $n . '" value="' . $item['jatuh_tempo'] . '" >
										<input type="hidden" class="form-control" name="key[]" id="key[]" data-id="key" data-group="' . $n . '" value="' . $key . '" >
									</td>
									<td width="150px" >
										<input class="form-control" type="text" name="saldo_transaksi[]" id="saldo_transaksi[]" data-id="saldo_transaksi" data-group="' . $n . '" value="' . $item['saldo_transaksi'] . '" style="text-align:right" readonly/>
									</td>
									<td width="135px" style="text-align:right">
										<input class="form-control" type="text" name="nominal_bayar[]" id="nominal_bayar[]" data-id="nominal_bayar" data-group="' . $n . '" value="' . $nominal_bayar . '" style="text-align:right" ' . $nominal_bayar1 . '/>
									</td>
									<td width="135px" style="text-align:right">
										<input class="form-control" type="text" name="nominal_pelunasan[]" id="nominal_pelunasan[]" data-id="nominal_pelunasan" data-group="' . $n . '" value="' . $item['nominal_pelunasan'] . '" style="text-align:right" ' . $nominal_pelunasan . '/>
									</td>
									<td width="130px" style="text-align:right">
										<input class="form-control" type="text" name="selisih[]" id="selisih[]" data-id="selisih" data-group="' . $n . '" value="' . $item['selisih'] . '" style="text-align:right" readonly/>
									</td>
									<td style="width:400px">
										<select id="kode_coa[]" name="kode_coa[]" data-id="kode_coa" data-group="' . $n . '" class="select2" ' . $kode_coa . ' style="width: 400px">
											' . $pilih_coa . '
								';

                if (count($arraycoa) > 0) {
                    foreach ($arraycoa as $key1 => $item2) {

                        $html .= '
										<option value="' . $item2['kode_coa'] . '">' . $item2['kode_coa'] . '&nbsp;&nbsp;||&nbsp;&nbsp;' . $item2['nama_coa'] . '</option>
									';
                    }
                }

                $html .= '
										</select>
										<input type="hidden" name="coa_kredit[]" value="' . $item['coa'] . '" id="coa_kredit[]">
									</td>
									<td>
										<input type="text" class="form-control" name="keterangan_dtl[]" id="keterangan_dtl[]" data-id="keterangan_dtl" data-group="' . $n . '" placeholder="Keterangan ..." value="' . $item['keterangan_dtl'] . '" ' . $keterangan_dtl . '>
									</td>
									<td style="text-align:center">
										<a href="javascript:;" class="label label-danger hapus-bkk" title="hapus data" data-id="' . $key . '"><i class="fa fa-times"></i></a>
									</td>
								</tr>';
                $total += $item['nominal_bayar'];
                $n++;
            }
        }

        $html .= '<tr>
								<td colspan="3" style="text-align:right"><b>Subtotal :</b></td>
								<td style="text-align:right; font-weight: bold;">
									<input class="form-control" type="text" name="subtotal" id="subtotal" autocomplete="off" value="' . $total . '" readonly style="text-align: right"  />
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
						  </tr>
					  ';

        /*$html .= "<script>$('.hapus-bkk').click(function(){
						var id =	$(this).attr('data-id');
						var id_form = $('#id_form').val();
						$.ajax({
							type: 'POST',
							url: '" . base_url() . "ajax/j_bkk.php?func=hapus-bkk',
							data: 'idhapus=' + id + '&id_form=' +id_form,
							cache: false,
							success:function(data){
								$('#detail_input_bkk').html(data).show();
							 }
						  });
					  });
				     </script>";*/
    } else {
        $html .= '<tr> <td colspan="15" class="text-center"> Tidak ada item barang. </td></tr>';
    }

    return $html;
}


if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "hapus-bkk") {
    $id = $_POST['idhapus'];
    $id_form = $_POST['id_form'];
    unset($_SESSION['load_bkk' . $id_form . ''][$id]);
    unset($_SESSION['load_coa' . $id_form . ''][$id]);
    echo view_item_bkk($_SESSION['load_bkk' . $id_form . ''], $_SESSION['load_coa' . $id_form . '']);
}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "edit-bkk") {

    $id                = $_POST['id'];
    $query            = "SELECT * FROM bkk_dtl_tmp
							WHERE id_bkk_dtl = '$id' ";
    $result            = mysql_query($query);

    while ($res = mysql_fetch_array($result)) {

        $q_coa_edit = mysql_query("SELECT kode_coa, nama nama_coa FROM coa order by nama_coa ASC");
        echo ' <div class="col-md-12 pm-min">
                    <form role="form" method="post" action="" id="form-edit-bkk">
                        <div class="col-md-12 pm-min-s">

                            <div class="col-md-6 pm-min-s">
                                <label class="control-label">Deskripsi</label>
                                <input type="text" name="deskripsi_edit" value="' . $res['deskripsi'] . '" id="deskripsi_edit" class="form-control" placeholder="Deskripsi ..."/>
                                <input type="hidden" name="id_edit" value=' . $res['id_bkk_dtl'] . ' id="id_edit" class="form-control" placeholder="ID ..."/>
                                <input type="hidden" name="id_form_edit" id="id_form_edit" value=' . $res['id_form'] . ' class="form-control" placeholder="Description..."/>
                            </div>

                            <div class="col-md-6 pm-min-s">
                            	<label class="control-label">Saldo Transaksi</label>
                           		<input type="number" name="saldo_transaksi_edit" id="saldo_transaksi_edit" value="' . $res['saldo_transaksi'] . '" class="form-control" />
                            </div>

                            <div class="col-md-4 pm-min-s">
                            	<label class="control-label">Nominal Bayar</label>
                            	<input type="number" name="nominal_bayar_edit" id="nominal_bayar_edit" value="' . $res['nominal_bayar'] . '" class="form-control" value="0"/>
                            </div>

                            <div class="col-md-4 pm-min-s">
                            	<label class="control-label">Nominal Pelunasan</label>
                            	<input type="number" name="nominal_pelunasan_edit" id="nominal_pelunasan_edit" value="' . $res['nominal_pelunasan'] . '" class="form-control" />
                            </div>

                            <div class="col-md-4 pm-min-s">
                            	<label class="control-label">Selisih</label>
                            	<input type="number" name="selisih_edit" id="selisih_edit" value="' . $res['selisih'] . '" class="form-control" />
                            </div>

                            <div class="col-md-4 pm-min-s">
                            	<label class="control-label">DOC</label>
                            		<select id="kode_coa_edit" name="kode_coa_edit" class="select2" style="width: 100%;">
                            			<option value="">--PILIH COA--</option>';
        $row_coa = $res['kode_coa'];
        while ($rowcoa = mysql_fetch_array($q_coa_edit)) {
            echo '		         						<option
														data-nama="' . $rowcoa['nama_coa'] . '"
														value=' . $rowcoa['kode_coa'] . '
														' . (($rowcoa['kode_coa'] == $row_coa) ? 'selected="selected"' : "") . ' >
														' . $rowcoa['nama_coa'] . '
													</option>';
        }
        echo '		    				<input type="hidden" name="nama_coa_edit" id="nama_coa_edit" value="" class="form-control" />
									</select>
									</select>
                            </div>

                            <div class="col-md-4 pm-min-s">
                            	<label class="control-label">Keterangan</label>
                            	<input type="text" name="keterangan_edit" id="keterangan_edit" value="' . $res['keterangan_dtl'] . '" class="form-control"/>
                            </div>
                        </div>
                    </form>
                </div>
				<div class="modal-footer">
                    <button type="button" name="submit" class="btn btn-success edit-to-bkk" data-dismiss="modal"><i class="fa fa-plus"></i> Update</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>';

        echo "<script>$('.edit-to-bkk').click(function(){
						var id =	$(this).attr('data-id');
						$.ajax({
							type: 'POST',
							url: '" . base_url() . "ajax/j_bkk.php?func=update-bkk',
							data: $('#form-edit-bkk').serialize(),
							cache: false,
							success:function(data){
								$('#detail_input_bkk').html(data).show();
							}
						});
					});
				  </script>";
    }
}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "update-bkk") {
    if (isset($_POST['kode_coa_edit']) and @$_POST['kode_coa_edit'] != "") {

        $id_form = $_POST['id_form_edit'];
        $itemeditbkk = "UPDATE bkk_dtl_tmp SET
											deskripsi			='" . $_POST['deskripsi_edit'] . "',
											saldo_transaksi		='" . $_POST['saldo_transaksi_edit'] . "',
											nominal_bayar		='" . $_POST['nominal_bayar_edit'] . "',
											nominal_pelunasan	='" . $_POST['nominal_pelunasan_edit'] . "',
											selisih				='" . $_POST['selisih_edit'] . "',
											kode_coa			='" . $_POST['kode_coa_edit'] . "',
											nama_coa			='" . $_POST['nama_coa_edit'] . "',
											keterangan_dtl		='" . $_POST['keterangan_edit'] . "'
										 	WHERE id_bkk_dtl 	='" . $_POST['id_edit'] . "' ";
        mysql_query($itemeditbkk);

        $query            = "SELECT * FROM bkk_dtl_tmp
								WHERE id_form='" . $_POST['id_form_edit'] . "'";
        $result            = mysql_query($query);

        $array = array();
        if (mysql_num_rows($result) > 0) {
            while ($res = mysql_fetch_array($result)) {

                $array[$res['id_bkk_dtl']] = array("id" => $res['id_bkk_dtl'], "deskripsi" => $res['deskripsi'], "saldo_transaksi" => $res['saldo_transaksi'], "nominal_bayar" => $res['nominal_bayar'], "nominal_pelunasan" => $res['nominal_pelunasan'], "selisih" => $res['selisih'], "kode_coa" => $res['kode_coa'], "nama_coa" => $res['nama_coa'], "keterangan_dtl" => $res['keterangan_dtl'], "id_form" => $res['id_form']);
            }
        }

        $_SESSION['data_bkk'] = $array;
        echo view_item_bkk($array);
    }
}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "save") {
    mysqli_autocommit($con, FALSE);

    $kas = strtolower($_POST['nama_pembayaran']);

    if ($kas == 'kas' || $kas == 'bon') {
        $form = 'BKK';
    } else {
        $form = 'BKB';
    }

    $kode_supplier    = ($_POST['kode_supplier']);
    $ref            = ($_POST['ref']);
    $tgl_buat         = date("Y-m-d", strtotime($_POST['tgl_buat']));
    $metode            = ($_POST['kode_pembayaran']);
    $kode_cabang    = ($_POST['kode_cabang']);
    $keterangan_hdr    = ($_POST['keterangan_hdr']);

    $user_pencipta  = $_SESSION['app_id'];
    $tgl_input         = date("Y-m-d H:i:s");

    $thnblntgl         = date("ymd", strtotime($_POST['tgl_buat']));
    $kode_bkk         = buat_kode_bkk($thnblntgl, $form, $kode_cabang);
    $id_form         = $_POST['id_form'];

    //VARIABEL AWAL
    $subtotal = 0;
    $grand = 0;

    $mySql    = "INSERT INTO bkk_hdr SET
							kode_bkk				='" . $kode_bkk . "',
							kode_supplier			='" . $kode_supplier . "',
							ref						='" . $ref . "',
							tgl_buat				='" . $tgl_buat . "',
							rekening				='" . $metode . "',
							kode_cabang 			='" . $kode_cabang . "',
							keterangan_hdr			='" . $keterangan_hdr . "',
							user_pencipta			='" . $user_pencipta . "',
							tgl_input				='" . $tgl_input . "'
					  ";

    $query = mysqli_query($con, $mySql);

    if (isset($_SESSION['load_bkk' . $id_form . '']) and count($_SESSION['load_bkk' . $id_form . '']) > 0) {
        //DETAIL BKK
        $array = $_SESSION['load_bkk' . $id_form . ''];
        foreach ($array as $key => $item) {

            $no_bkk             = $kode_bkk;
            $stat_cb             = $_POST['stat_cb'][$key];
            $deskripsi             = $item['deskripsi'];
            $saldo_transaksi     = $item['saldo_transaksi'];
            $nominal_bayar        = $_POST['nominal_bayar'][$key];
            $nominal_pelunasan    = $_POST['nominal_pelunasan'][$key];
            $selisih            = $_POST['selisih'][$key];
            $keterangan_dtl        = $_POST['keterangan_dtl'][$key];
            $kodecoadebet       = $item['coa'];
            $tgl_jatuh_tempo     = $item['jatuh_tempo'];

            $nilai_total        = str_replace(',', null, $nominal_bayar) + str_replace(',', null, $selisih);

            $subtotal += $item['saldo_transaksi'];

            if ($tgl_jatuh_tempo == '0') {
                $tanggal_jatuh_tempo =  '0000-00-00';
                $kode_coa             = $item['kode_coa1'];
            } else {
                $tanggal_jatuh_tempo =  date("Y-m-d", strtotime($item['jatuh_tempo']));
                $kode_coa              = $_POST['kode_coa'][$key];
            }

            //JIKA JUMLAH BAYAR >= SALDO
            if (str_replace(',', null, $nominal_bayar) >= str_replace(',', null, $saldo_transaksi)) {
                $stat_lunas = '1';
            } else {
                $stat_lunas = '0';
            }

            if ($stat_cb == '1') {
                $mySql1 = "INSERT INTO bkk_dtl SET
													kode_bkk 			='" . $no_bkk . "',
													deskripsi 			='" . $deskripsi . "',
													saldo_transaksi 	='" . str_replace(',', null, $saldo_transaksi) . "',
													nominal_bayar		='" . str_replace(',', null, $nominal_bayar) . "',
													nominal_pelunasan	='" . str_replace(',', null, $nominal_pelunasan) . "',
													selisih				='" . str_replace(',', null, $selisih) . "',
													kode_coa			='" . $kode_coa . "',
													tgl_input			='" . $tgl_input . "',
													tgl_jatuh_tempo 	='" . $tanggal_jatuh_tempo . "',
													keterangan_dtl		='" . $keterangan_dtl . "' ";

                $query1 = mysqli_query($con, $mySql1);

                //CREATE KARTU HUTANG
                $mySql2 = "INSERT INTO kartu_hutang SET
													kode_transaksi 	='" . $deskripsi . "',
													kode_pelunasan 	='" . $no_bkk . "',
													debet 			='" . str_replace(',', null, $nominal_bayar) . "',
													lunas 			='" . $stat_lunas . "',
													kode_supplier 	='" . $kode_supplier . "',
													kode_cabang 	='" . $kode_cabang . "',
													tgl_buat 		='" . $tgl_buat . "',
													tgl_jth_tempo 	='" . $tanggal_jatuh_tempo . "',
													user_pencipta 	='" . $_SESSION['app_id'] . "',
													tgl_input		='" . date('Y-m-d H:i:s') . "' ";

                $query2 = mysqli_query($con, $mySql2);

                $fb = mysql_query("SELECT SUBSTRING(kode_transaksi,11,2) kode_fb FROM kartu_hutang WHERE kode_transaksi= '" . $deskripsi . "'");
                $num_rows_fb = mysql_num_rows($fb);
                if ($num_rows_fb > 0) {
                    $row_fb = mysql_fetch_array($fb);

                    if ($row_fb['kode_fb'] == 'FB') {
                        $mySql3 = "UPDATE fb_dtl SET status_dtl ='3' WHERE kode_fb = '" . $deskripsi . "'";
                        $query3 = mysqli_query($con, $mySql3);
                    } elseif ($row_fb['kode_nk'] == 'NK') {
                        $mySql3 = "UPDATE nk_dtl SET status_dtl ='3' WHERE kode_nk = '" . $deskripsi . "'";
                        $query3 = mysqli_query($con, $mySql3);
                    } else {
                        $mySql3 = "UPDATE nb_dtl SET status_dtl ='3' WHERE kode_nb = '" . $deskripsi . "'";
                        $query3 = mysqli_query($con, $mySql3);
                    }
                }

                //JIKA TAMBAH MANUAL
                if ($tgl_jatuh_tempo == '0') {

                    $mySql4 = "INSERT INTO jurnal SET
												kode_transaksi 	='" . $no_bkk . "',
												tgl_input 		='" . date('Y-m-d H:i:s') . "',
												tgl_buat 		='" . $tgl_buat . "',
												kode_supplier 	='" . $kode_supplier . "',
												kode_cabang 	='" . $kode_cabang . "',
												keterangan_hdr 	='" . $keterangan_hdr . "',
												keterangan_dtl 	='" . $keterangan_dtl . "',
												ref 			='" . $ref . "',
												kode_coa 		='" . $kode_coa . "',
												debet 			='" . str_replace(',', null, $nominal_bayar) . "',
												lawan_dari_coa  ='" . $metode . "',
												coa_kredit_lawan ='" . str_replace(',', null, $nominal_bayar) . "',
												user_pencipta   ='" . $_SESSION['app_id'] . "'";

                    $query4 = mysqli_query($con, $mySql4);
                } else {

                    $mySql4 = "INSERT INTO jurnal SET
												kode_transaksi 	='" . $no_bkk . "',
												tgl_input 		='" . date('Y-m-d H:i:s') . "',
												tgl_buat 		='" . $tgl_buat . "',
												kode_supplier 	='" . $kode_supplier . "',
												kode_cabang 	='" . $kode_cabang . "',
												keterangan_hdr  ='" . $keterangan_hdr . "',
												keterangan_dtl  ='" . $keterangan_dtl . "',
												ref 		 	='" . $ref . "',
												kode_coa 		='" . $kodecoadebet . "',
												debet 			='" . str_replace(',', null, $nominal_pelunasan) . "',
												lawan_dari_coa 	='" . $metode . "',
												coa_kredit_lawan ='" . str_replace(',', null, $nominal_pelunasan) . "',
												user_pencipta 	='" . $_SESSION['app_id'] . "'";

                    $query4 = mysqli_query($con, $mySql4);
                }

                $grand += str_replace(',', null, $nominal_bayar);

                //JURNAL JIKA ADA SELISIH
                if ($selisih > 0) {
                    $mySql6 = "INSERT INTO jurnal SET
											kode_transaksi 	='" . $no_bkk . "',
											tgl_input 		='" . date('Y-m-d H:i:s') . "',
											tgl_buat 		='" . $tgl_buat . "',
											kode_supplier 	='" . $kode_supplier . "',
											kode_cabang 	='" . $kode_cabang . "',
											keterangan_hdr 	='" . $keterangan_hdr . "',
											ref 			='" . $ref . "',
											kode_coa 		='" . $kode_coa . "',
											debet 			='" . (str_replace(',', null, $selisih)) . "',
											user_pencipta 	='" . $_SESSION['app_id'] . "'";

                    $query6 = mysqli_query($con, $mySql6);
                } elseif ($selisih < 0) {
                    $mySql6 = "INSERT INTO jurnal SET
											kode_transaksi 	='" . $no_bkk . "',
											tgl_input 		='" . date('Y-m-d H:i:s') . "',
											tgl_buat 		='" . $tgl_buat . "',
											kode_supplier 	='" . $kode_supplier . "',
											kode_cabang 	='" . $kode_cabang . "',
											keterangan_hdr	='" . $keterangan_hdr . "',
											ref 			='" . $ref . "',
											kode_coa 		='" . $kode_coa . "',
											kredit 			='" . abs(str_replace(',', null, $selisih)) . "',
											user_pencipta 	='" . $_SESSION['app_id'] . "'";

                    $query6 = mysqli_query($con, $mySql6);
                } else {
                    $mySql6 = "UPDATE jurnal SET user_pencipta ='" . $_SESSION['app_id'] . "' WHERE kode_transaksi='" . $no_bkk . "'";

                    $query6 = mysqli_query($con, $mySql6);
                }
            }
        }

        //INSERT JURNAL DEBET
        $mySql5 = "INSERT INTO jurnal SET
											kode_transaksi 	='" . $no_bkk . "',
											tgl_input 		='" . date('Y-m-d H:i:s') . "',
							                tgl_buat 		='" . $tgl_buat . "',
											kode_supplier 	='" . $kode_supplier . "',
											kode_cabang 	='" . $kode_cabang . "',
											keterangan_hdr 	='" . $keterangan_hdr . "',
							                ref 			='" . $ref . "',
											kode_coa 		='" . $metode . "',
							                kredit 			='" . ($grand) . "',
							                user_pencipta 	='" . $_SESSION['app_id'] . "'";

        $query5 = mysqli_query($con, $mySql5);

        if ($query and $query1 and $query2  and $query4 and $query5 and $query6) {

            // Commit transaction
            mysqli_commit($con);

            // Close connection
            mysqli_close($con);

            unset($_SESSION['load_bkk' . $id_form . '']);
            echo "00||$kode_bkk";
        } else {
            echo "99||Gagal Input";
        }
    } else {
        echo "99|| Item BKK masih kosong";
    }
}

if (isset($_REQUEST['func']) and @$_REQUEST['func'] == "pembatalan") {
	mysqli_autocommit($con,FALSE);
	$kode_bkk		= $_POST['kode_bkk_batal'];
	$alasan_batal	= $_POST['alasan_batal'];
	$tgl_batal 		= date("Y-m-d");
	$tgl_input		= date("Y-m-d H:i:s");
	
	$selectBkk = "SELECT * FROM bkk_hdr	WHERE kode_bkk = '".$kode_bkk."' AND status = '0'";
	$queryBkk = mysqli_query($con, $selectBkk);
	
	if (mysqli_num_rows($queryBkk) > 0) {
		$dataBkk = mysqli_fetch_array($queryBkk);
		$selectBkkDtl = "SELECT * FROM bkk_dtl WHERE kode_bkk = '".$dataBkk['kode_bkk']."' AND status_dtl = '0'";
		$queryBkkDtl = mysqli_query($con, $selectBkkDtl);
		$checker = array();
		$dataBkkDtl = array();
		if (mysqli_num_rows($queryBkkDtl) > 0) {
			$dataBkkDtl = mysqli_fetch_array($queryBkkDtl);
			$selectKH = "SELECT * FROM kartu_hutang WHERE kode_pelunasan = '".$dataBkkDtl['kode_bkk']."' AND status_batal = '0'";
			$queryKH = mysqli_query($con, $selectKH);
			if (mysqli_num_rows($queryKH) > 0) {
				while ($rowKH = mysqli_fetch_array($queryKH)) {
					$insertKHReverse = "INSERT INTO kartu_hutang SET kode_transaksi = '" . $dataBkkDtl['kode_bkk'] . "', kode_pelunasan 	= 'Pembatalan " . $rowKH['kode_pelunasan'] . "', debet = '" . $rowKH['kredit'] . "', kredit = '" . $rowKH['debet'] . "', lunas = '0', status_batal = '1', kode_supplier = '" . $rowKH['kode_supplier'] . "', kode_cabang = '" . $rowKH['kode_cabang'] . "', tgl_buat = '" . $rowKH['tgl_buat'] . "', tgl_jth_tempo	= '" . $rowKH['tgl_jth_tempo'] . "', user_pencipta 	= '" . $_SESSION['app_id'] . "', tgl_input = '" . $tgl_input . "'";
					$queryInsertKHReverse = mysqli_query($con, $insertKHReverse);
					if ($queryInsertKHReverse) {
						$checker[] = true;
						$updateKHReverse = "UPDATE kartu_hutang SET lunas = '0' WHERE kode_pelunasan = '" . $dataBkkDtl['kode_bkk'] . "' AND tgl_input < '" . $tgl_input . "' AND status_batal = '0'";
						$queryUpdateKHReverse = mysqli_query($con, $updateKHReverse);
						if ($queryUpdateKHReverse) {
							$checker[] = true;
						} else {
							$checker[] = mysqli_error($con);
						}
					} else {
						$checker[] = mysqli_error($con);
					}
				}
			}
			
			$selectJurnal = "SELECT * FROM jurnal WHERE kode_transaksi = '" . $dataBkkDtl['kode_bkk'] . "'";
			$queryJurnal = mysqli_query($con, $selectJurnal);
			if (mysqli_num_rows($queryJurnal) > 0) {
				while ($rowJN = mysqli_fetch_array($queryJurnal)) {					
					$insertJNReverse = "INSERT INTO jurnal SET kode_transaksi = '" . $dataBkkDtl['kode_bkk'] . "', ref = '" . $rowJN['ref'] . "', tgl_buat = '" . $rowJN['tgl_buat'] . "', kode_cabang = '" . $rowJN['kode_cabang'] . "', kode_supplier = '" . $rowJN['kode_supplier'] . "', kode_pelanggan = '" . $rowJN['kode_pelanggan'] . "', kode_coa = '" . $rowJN['kode_coa'] . "', debet = '" . $rowJN['kredit'] . "', kredit = '" . $rowJN['debet'] . "', tgl_input = '" . $tgl_input . "', keterangan_hdr = '" . $rowJN['keterangan_hdr'] . "', user_pencipta = '" . $_SESSION['app_id'] . "', keterangan_dtl = '" . $rowJN['keterangan_dtl'] . "', lawan_dari_coa = '" . $rowJN['lawan_dari_coa'] . "', coa_debet_lawan = '" . $rowJN['coa_kredit_lawan'] . "', coa_kredit_lawan = '" . $rowJN['coa_debet_lawan'] . "'";
					$queryInsertJNReverse = mysqli_query($con, $insertJNReverse);
					if ($queryInsertJNReverse) {
						$checker[] = true;
						$updateJNReverse = "UPDATE jurnal SET status_jurnal = '1' WHERE kode_transaksi = '" . $dataBkkDtl['kode_bkk'] . "' AND tgl_input < '" . $tgl_input . "'";
						$queryUpdateJNReverse = mysqli_query($con, $updateJNReverse);
						if ($queryUpdateJNReverse) {
							$checker[] = true;
						} else {
							$checker[] = mysqli_error($con);
						}
					} else {
						$checker[] = mysqli_error($con);
					}
				}
			}
			
			$checkerUnique = array_unique($checker);
			if (count($checkerUnique) === 1 && $checkerUnique[0]) {
				mysqli_query($con, "UPDATE bkk_hdr SET status = '1', alasan_batal = '" . $alasan_batal . "', user_batal = '" . $_SESSION['app_id'] . "', tgl_batal = '" . $tgl_batal . "' WHERE kode_bkk = '" . $kode_bkk . "'");
				mysqli_query($con, "UPDATE bkk_dtl SET status_dtl = '1' WHERE kode_bkk = '" . $kode_bkk . "'");
				mysqli_commit($con);
				mysqli_close($con);
				echo "00||" . $kode_bkk;
			} else {
				mysqli_rollback($con);
				mysqli_close($con);
				echo "99||Gagal query : " . json_encode($checker);
			}
		} else {
			echo "99||Data Detail tidak ditemukan";
		}		
	} else {
		echo "99||Kode sudah di batalkan";
	}
}
