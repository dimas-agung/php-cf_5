$(document).ready(function(){
	var timer = null;
	var urlBarang = "";
	$('#kd_proyek').keyup(function(e){
		
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
				$('#kd_proyek').val(value);
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
		var value3	=	$(this).attr('data3'); 
		var value4	=	$(this).attr('data4');
		var value5	=	$(this).attr('data5'); 
	
		
		
		$('#kd_proyek').val(value); $('#nama_proyek').val(value2); 
		$('#alamat').val(value3); $('#up').val(value4); 
		$('#jabatan').val(value5);
		$('#search_suggestion_holder').hide();
	});
	
	
	
	
});
