<?php

	// Formulaire Ajax -> passage à loadSeasons() pour rechercher les saisons
	echo $form->create('Comment', array('action' => 'searcharticle')); 
	echo '<fieldset><legend>Saisissez l\'identifiant de l\'article : </legend> <br/>';
	
	echo $form->input('article_id', array('label' => 'Article :','type'=>'text'));
	
	echo $form->end('Rechercher');
	echo '</fieldset>';
	
?>
