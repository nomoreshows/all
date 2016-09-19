	<?php 
	
	echo $form->create('Comment', array('action' => 'searchresult')); 
	echo $form->input('episode_id', array('label' => 'Episode :'));
	echo $form->input('season_id', array('type' => 'hidden', 'value' => $season_id));
	echo $form->input('show_id', array('type' => 'hidden', 'value' => $show_id));
	
	echo $form->end('Suivant');
	
	?>
	
