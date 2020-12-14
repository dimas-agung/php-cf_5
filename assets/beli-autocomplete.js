$(document).ready(function(){
	var timer = null;
	var urlBarang = "";
	$('#b_kodebarang').keyup(function(e){
		
		if( e.keyCode ==38 ){
			if( $('#search_suggestion_holder').is(':visible') ){
				if( ! $('.selected').is(':visible') ){
					$('#search_suggestion_holder li').last().addClass('selected');
				}else{
					var i =  $('#search_suggestion_holder li').index($('#search_suggestion_holder li.selected')) ;
					$('#search_suggestion_holder li.selected').removeClass('selected');
					i--;
					$('#search_suggestion_holder li:eq('+i+')').addClass('selected');
					
				}
			}
		}else if(e.keyCode ==40){
			if( $('#search_suggestion_holder').is(':visible') ){
				if( ! $('.selected').is(':visible') ){
					$('#search_suggestion_holder li').first().addClass('selected');
				}else{
					var i =  $('#search_suggestion_holder li').index($('#search_suggestion_holder li.selected')) ;
					$('#search_suggestion_holder li.selected').removeClass('selected');
					i++;
					$('#search_suggestion_holder li:eq('+i+')').addClass('selected');
				}
			}					
		}else if(e.keyCode ==13){
			if( $('.selected').is(':visible') ){
				var value	=	$('.selected').attr('data');
				$('#b_kodebarang').val(value);
				$('#search_suggestion_holder').hide();
			}
		}else{
			var keyword		=		$(this).val();
			var urlG		=		$(this).attr('url');
			urlBarang = urlG;
			$('#loader').show();
			setTimeout( function(){
				$.ajax({
					url: urlG,
					data:'keyword='+keyword,
					success:function(data){
						$('#search_suggestion_holder').html(data);
						$('#search_suggestion_holder').show();
						$('#loader').hide();
					}
				});
			},10);
		}
	});
	
	$('#search_suggestion_holder').on('click','li',function(){
		var value	=	$(this).attr('data'); 
		var value2	=	$(this).attr('data2');
		var value3  =   $(this).attr('data3');
		
		$('#b_kodebarang').val(value); $('#b_namabarang').val(value2);
		$('#search_suggestion_holder').hide();
	});
	
	
	$('#kode_retur').keyup(function(e){
		
		if( e.keyCode ==38 ){
			if( $('#search_suggestion_holder').is(':visible') ){
				if( ! $('.selected').is(':visible') ){
					$('#search_suggestion_holder li').last().addClass('selected');
				}else{
					var i =  $('#search_suggestion_holder li').index($('#search_suggestion_holder li.selected')) ;
					$('#search_suggestion_holder li.selected').removeClass('selected');
					i--;
					$('#search_suggestion_holder li:eq('+i+')').addClass('selected');
					
				}
			}
		}else if(e.keyCode ==40){
			if( $('#search_suggestion_holder').is(':visible') ){
				if( ! $('.selected').is(':visible') ){
					$('#search_suggestion_holder li').first().addClass('selected');
				}else{
					var i =  $('#search_suggestion_holder li').index($('#search_suggestion_holder li.selected')) ;
					$('#search_suggestion_holder li.selected').removeClass('selected');
					i++;
					$('#search_suggestion_holder li:eq('+i+')').addClass('selected');
				}
			}					
		}else if(e.keyCode ==13){
			if( $('.selected').is(':visible') ){
				var value	=	$('.selected').attr('data');
				$('#kode_retur').val(value);
				$('##search_suggestion_holder').hide();
			}
		}else{
			var keyword		=		$(this).val();
			var urlG		=		$(this).attr('url');
			var idnota		=		document.getElementById('txtNota').value;
			$('#loader').show();
			setTimeout( function(){
				$.ajax({
					url: urlG,
					data:'keyword='+keyword + '&id='+idnota,
					success:function(data){
						$('#search_suggestion_holder').html(data);
						$('#search_suggestion_holder').show();
						$('#loader').hide();
					}
				});
			},10);
		}
	});
	
	$('#search_suggestion_holder').on('click','li',function(){
		var value	=	$(this).attr('data'); 
		var value2	=	$(this).attr('data2');
		var value3  =   $(this).attr('data3');
		var value4  =   $(this).attr('data4');
		
		$('#kode_retur').val(value); $('#nama').val(value2); $('#satuanbrg').val(value3);
		$('#jumlahbrg').val(value4);
		$('#search_suggestion_holder').hide();
	});
	
});
