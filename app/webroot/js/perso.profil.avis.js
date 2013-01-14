	$(document).ready(function(){
		$("#avisshows").easySlider({
			prevId: 'showprev',
			prevText: 'Pr\351c\351dents',
			nextText: 'Suivants',
			nextId: 'shownext'
		});
		$("#avisseasons").easySlider({
			prevId: 'seasonprev',
			prevText: 'Pr\351c\351dents',
			nextText: 'Suivants',
			nextId: 'seasonnext'
		});
		$(".avis-sort-shows a").click(function(){
			$("#shownext").remove();
			$("#showprev").remove();
		});
		$(".avis-sort-seasons a").click(function(){
			$("#seasonnext").remove();
			$("#seasonprev").remove();
		});
		$("a.avis-show-link").hover(
			function(){
				$(this).children("div").fadeIn();
			}, function() {
			$(this).children("div").fadeOut();
			}
		);
		
		$("a.avis-season-link").hover(
			function(){
				$(this).children("div").fadeIn();
			}, function() {
			$(this).children("div").fadeOut();
			}
		);
	});