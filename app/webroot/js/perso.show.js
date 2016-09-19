	$(document).ready(function(){
		
		$('textarea').keyup(function() {
			var charLength = $(this).val().length;
			$('span#charCount').html(charLength + ' caractères.');
			if($(this).val().length > 99)
				$('span#charCount').addClass('green');
				
			if($(this).val().length < 99)
				$('span#charCount').removeClass('green');
		});
		
		$(".tabs").tabs();
		
		$('#btnAllAvis').click(function() {
			$(".tabs").tabs("select", "#avis-serie");
			return false;
		});
		
		$('#btnCasting').click(function() {
			$(".tabs").tabs("select", "#casting");
			return false;
		});

	});