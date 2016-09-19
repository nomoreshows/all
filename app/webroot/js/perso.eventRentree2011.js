	$(document).ready(function() {

		  $('p.synopsis').expander({
			slicePoint:       200,  // default is 100
			expandText:         '&raquo; Lire la suite', // default is 'read more...'
			expandPrefix:		'... ',
			collapseTimer:    0, // re-collapses after 5 seconds; default is 0, so no re-collapsing
			userCollapseText: '&laquo; Fermer'  // default is '[collapse expanded text]'
		  });
		  
		});
