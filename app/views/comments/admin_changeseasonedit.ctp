	<?php 
	echo '<div id="episodeId">'.$form->input('Comment.episode_id', 
			array('label' => 'Episode :','type'=>'select', 'options'=>$episodes, 'empty' => '(Aucun épisode)')).'</div>';
	?>
	
