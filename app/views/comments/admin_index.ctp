<?php

	// Formulaire Ajax -> passage à loadSeasons() pour rechercher les saisons
	echo $form->create('Comment', array('action' => 'searchresult')); 
	echo '<fieldset><legend>Rechercher un avis sur un épisode de série </legend>';
	
	echo $form->input('show_id', array('label' => 'Série :','type'=>'select'));
	$options = array('url' => array('controller' => 'comments', 'action' => 'changeshowedit', 'prefix' => 'admin'), 
			'update' => 'showDataChange');
    echo $ajax->observeField('CommentShowId', $options);
	
	echo '<div id="showDataChange">';
	echo $form->input('season_id', array('label' => 'Saison :','type'=>'select', 'empty' => '(Aucune saison)'));
	$options = array('url' => array('controller' => 'comments', 'action' => 'changeseasonedit', 'prefix' => 'admin'), 
			'update' => 'episodeId');
    echo $ajax->observeField('CommentSeasonId', $options);
    
	echo '<div id="episodeId">'.$form->input('episode_id', array('label' => 'Episode :', 'type'=>'select', 'empty' => '(Aucun épisode)')).'</div>';
	echo '</div>';
	
	echo $form->end('Rechercher');
	echo '</fieldset>';
	
?>
