	<?php 
	
	if ($category == 'critique') {
		// Formulaire AJAX pour critique : charger les épisodes
		echo $ajax->form('Article', 'post', array('model' => 'Article', 'url' => array('controller' => 'articles', 'action' => 'loadEpisodes'), 'update' => 'episode-ajax'));
		
		echo $form->input('category', array('type' => 'hidden', 'value' => $category));
		echo $form->input('show_id', array('type' => 'hidden', 'value' => $show_id));
		
		echo $form->input('season_id', array('label' => 'Saison :'));
		echo $form->end('Suivant');
	} else {
		// Formulaire normal pour bilan : direct à add() avec le season_id
		echo $form->create('Article'); 
		
		echo $form->input('season_id', array('label' => 'Saison :'));
		echo $form->input('category', array('type' => 'hidden', 'value' => $category));
		echo $form->end('Suivant');
		
	}

	?>
	