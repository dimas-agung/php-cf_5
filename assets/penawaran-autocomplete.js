$(document).ready(function(){
	var timer = null;
	var urlBarang = "";
	$('#kode_penawaran').keyup(function(e){
		
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
				$('#kode_penawaran').val(value);
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
		
		$('#kode_penawaran').val(value); $('#nama_perusahaan').val(value2); $('#up').val(value3);
		$('#search_suggestion_holder').hide();
	});
	
	
	
	
});
