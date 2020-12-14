<?php 
   include 'pages/data/script/nrc_percobaan.php'; 
?>

<link href="<?=base_url()?>assets/select2/select2.css" rel="stylesheet">
<script src="<?=base_url()?>assets/brg-autocomplete.js"></script>
<script src="<?=base_url()?>assets/supplier-autocomplete.js"></script>

<section class="content-header">
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-money"></i>Keuangan</a></li>
      <li>
         <a href="#">Neraca Percobaan</a>
      </li>
   </ol>
</section>

<div class="row">
   <div class="tab-content">
      <div class="col-lg-12">
         <div class="panel panel-default">
            <div class="panel-body">
               <div class="form-horizontal">
                  <form action="" method="post" enctype="multipart/form-data" role="form" id="form-lap">

                      <div class="form-group">
                        <label class="col-sm-1 control-label">Cabang </label>
                        <div class="col-sm-3">
                           <select id="kode_cabang" name="kode_cabang" class="select2" >
                              <option value="">-- Pilih --</option>
                              <?php
                                 if(mysql_num_rows($q_cab) > 0){
                                     while($res = mysql_fetch_array($q_cab)){
                                        
                                 echo '<option value="'.$res['kode_cabang'].'" '.(isset($row['id_cabang']) ? ($row['kode_cabang'] == $res['kode_cabang'] ? "selected" : "") : "").'>'.$res['nama'].'</option>';
                                     }
                                 }
                              ?>
                           </select>
                        </div>

                        <?php $tgl_hariini = date('m/t/Y', strtotime("-1 month")); $tgl_lalu = date("m/01/Y", strtotime("-1 month"));?>  
                        <label class="col-sm-1 control-label">Tgl Awal </label>
                        <div class="col-sm-3">
                           <div class="input-group">
                              <input class="form-control date-picker" id="tgl_awal" name="tgl_awal" type="text" data-date-format="dd-mm-yyyy" autocomplete="off" value="<?php echo $tgl_lalu; ?>" required readonly/><span class="input-group-addon">
                              <i class="fa fa-calendar bigger-110"></i></span>
                           </div>
                        </div>

                        <label class="col-sm-1 control-label">Tgl Akhir </label>
                        <div class="col-sm-3">
                           <div class="input-group">
                              <input class="form-control date-picker" id="tgl_akhir" name="tgl_akhir" type="text" data-date-format="dd-mm-yyyy" autocomplete="off" value="<?php echo $tgl_hariini; ?>" required readonly/><span class="input-group-addon">
                              <i class="fa fa-calendar bigger-110"></i></span>
                           </div>
                        </div>
                      </div>

                      <div class="form-group" style="text-align:center">
                        <button type="button" name="submit" class="btn btn-primary pb-load" tabindex="4"><i class="fa fa-list"></i> Tampilkan</button>
                      </div>
                  </form>

             		      <a href="#" id="neracaprb" class="btn btn-success pull-right fa fa-download"> Download CSV</a>

                  </br>
                     
                     <div id="showData">
                        <table class="table table-bordered table-striped " width="600px">
                           <thead>
                              <tr>
                                 <th>Kode COA</th>
                                 <th>Nama COA</th>
                                 <th>Saldo Awal</th>
                                 <th>Debet</th>
                                 <th>Kredit</th>
                                 <th>Saldo Akhir</th>
                              </tr>
                           </thead>	
                           <tbody id="show-neraca-pecobaan">
                           </tbody>
                        </table>
                     </div>

               </div>   
            </div>
         </div>
      </div>
   </div>  
</div> 

<style>
  .pm-min, .pm-min-s{padding:3px 1px; }
  .animated{display:none;}

  table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 1110px;
    border: 1px solid #DCDCDC;
  }

  th {
      background: #87CEFA;
      text-align: center;
      color: #000000;
      padding: 6px;
  }

  td {
      text-align: left;
      font-size: 12px;
      padding: 6px;
  }

  tr:nth-child(even){background-color: #f2f2f2}
</style>

<script type="text/javascript">

  $(document).ready(function(){
    $('.pb-load').click(function(){
  	   
  		if ($('#kode_cabang').val()=='')
  		{
  		alert("Cabang belum dipilih");
  		return false;
  		}
		
   		var value	=	$(this).attr('data'); 
   		data = $("#form-lap").serialize();
   		$(".animated").show();
   		$.ajax({
   			type: "POST",
   			url: '<?php echo base_url();?>ajax/nrc_percobaan.php?func=nrc_prb',
   			data: data,
   			cache: false,
   			success:function(data){
   				$('#showData').html(data).show();
   				$(".animated").hide();
   			}
   		});
   	});
  });
</script>

<script src="<?=base_url()?>assets/select2/select2.js"></script>

<script>$(".select2").select2({
   width: '100%'
   });
</script>

<!-- ============ PRINT KE CSV =============== -->  
<script> 
   $(document).ready(function () {
   function exportTableToCSV($table, filename) {
   
   	var $rows = $table.find('tr:has(td),tr:has(th)'),
   
   		// Temporary delimiter characters unlikely to be typed by keyboard
   		// This is to avoid accidentally splitting the actual contents
   		tmpColDelim = String.fromCharCode(11), // vertical tab character
   		tmpRowDelim = String.fromCharCode(0), // null character
   
   		// actual delimiter characters for CSV format
   		colDelim = '","',
   		rowDelim = '"\r\n"',
   
   		// Grab text from table into CSV formatted string
   		csv = '"' + $rows.map(function (i, row) {
   			var $row = $(row), $cols = $row.find('td,th');
   
   			return $cols.map(function (j, col) {
   				var $col = $(col), text = $col.text();
   
   				return text.replace(/"/g, '""'); // escape double quotes
   
   			}).get().join(tmpColDelim);
   
   		}).get().join(tmpRowDelim)
   			.split(tmpRowDelim).join(rowDelim)
   			.split(tmpColDelim).join(colDelim) + '"',
   
   		
   
   		// Data URI
   		csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);
   		
   		console.log(csv);
   		
   		if (window.navigator.msSaveBlob) { // IE 10+
   			//alert('IE' + csv);
   			window.navigator.msSaveOrOpenBlob(new Blob([csv], {type: "text/plain;charset=utf-8;"}), "csvname.csv")
   		} 
   		else {
   			$(this).attr({ 'download': filename, 'href': csvData, 'target': '_blank' }); 
   		}
    }
   
     $("#neracaprb").on('click', function (event) {
     	
     	exportTableToCSV.apply(this, [$('#example1'), 'Neraca_Percobaan.csv']);
     	
     	// IF CSV, don't do event.preventDefault() or return false
     	// We actually need this to be a typical hyperlink
    });  
  });
</script>

<script>
    $(".date-picker").datepicker();
</script>
<!---------------------------------------END-------------------------------------------->