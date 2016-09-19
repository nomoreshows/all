	<?php 
	
		// Formulaire AJAX pour critique : charger les épisodes
		echo $ajax->form('Comment', 'post', array('model' => 'Comment', 'url' => array('controller' => 'comments', 'action' => 'loadEpisodes'), 'update' => 'episode-ajax'));
		
		echo $form->input('show_id', array('type' => 'hidden', 'value' => $show_id));
		
		echo $form->input('season_id', array('label' => 'Saison :'));
		echo $form->end('Suivant');

	?>
	
