 			
       $(document).ready(function() {
            $("a.classement-show-link").hover(
				function(){
					$(this).children("div").fadeIn();
				}, function() {
				$(this).children("div").fadeOut();
				}
			);
           
        });