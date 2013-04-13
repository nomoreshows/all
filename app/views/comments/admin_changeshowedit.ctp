	<?php 
	echo $form->input('Comment.season_id', array('label' => 'Saison :', 'type'=>'select', 'options'=>$seasons, 'empty' => '(Aucune saison)'));
	$options = array('url' => array('controller' => 'comments', 'action' => 'changeseasonedit', 'prefix' => 'admin'), 
			'update' => 'episodeId');
    echo $ajax->observeField('CommentSeasonId', $options);
	
	echo '<div id="episodeId">'.$form->input('Comment.episode_id', 
			array('label' => 'Episode :','type'=>'select', 'options'=>$episodes, 'empty' => '(Aucun épisode)')).'</div>';
	?>
	
