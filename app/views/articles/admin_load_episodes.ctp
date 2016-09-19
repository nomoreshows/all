	<?php 
	
	echo $form->create('Article'); 
	echo $form->input('episode_id', array('label' => 'Episode :'));
	echo $form->input('category', array('type' => 'hidden', 'value' => $category));
	
	echo $form->end('Suivant');
	
	?>
	