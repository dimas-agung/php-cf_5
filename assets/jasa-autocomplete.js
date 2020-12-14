$(document).ready(function(){
	var timer = null;
	var urlBarang = "";
	$('#kd_jasa').keyup(function(e){
		
		if( e.keyCode ==38 ){
			if( $('#search_suggestion_holder2').is(':visible') ){
				if( ! $('.selected').is(':visible') ){
					$('#search_suggestion_holder2 li').last().addClass('selected');
				}else{
					var i =  $('#search_suggestion_holder2 li').index($('#search_suggestion_holder2 li.selected')) ;
					$('#search_suggestion_holder2 li.selected').removeClass('selected');
					i--;
					$('#search_suggestion_holder2 li:eq('+i+')').addClass('selected');
					
				}
			}
		}else if(e.keyCode ==40){
			if( $('#search_suggestion_holder2').is(':visible') ){
				if( ! $('.selected').is(':visible') ){
					$('#search_suggestion_holder2 li').first().addClass('selected');
				}else{
					var i =  $('#search_suggestion_holder2 li').index($('#search_suggestion_holder2 li.selected')) ;
					$('#search_suggestion_holder2 li.selected').removeClass('selected');
					i++;
					$('#search_suggestion_holder2 li:eq('+i+')').addClass('selected');
				}
			}					
		}else if(e.keyCode ==13){
			if( $('.selected').is(':visible') ){
				var value	=	$('.selected').attr('data');
				var value2	=	$('.selected').attr('data2');
		        var value3	=	$('.selected').attr('data3');
				$('#kd_jasa').val(value);
				$('#description2').val(value2);
				$('#harga2').val(value3);
				$('#search_suggestion_holder2').hide();
				
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
						$('#search_suggestion_holder2').html(data);
						$('#search_suggestion_holder2').show();
						$('#loader').hide();
					}
				});
			},10);
		}
	});
	
	$('#search_suggestion_holder2').on('click','li',function(){
		var value	=	$(this).attr('data'); 
		var value2	=	$(this).attr('data2');
		var value3	=	$(this).attr('data3');
	
		
		$('#kd_jasa').val(value);$('#description2').val(value2);
		$('#harga2').val(value3);
		$('#search_suggestion_holder2').hide();
		
		
	
	});
	
	
	
	
	
});
// JavaScript Document