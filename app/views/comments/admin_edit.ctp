
<table class="toolbar">
	<tr>
    	<td><h1>Modifier un commentaire</h1></td>

    	<td width="50" class="center">
		<?php echo $html->link($html->image('icons/cancel.png') . '<br />Annuler', array('controller' => 'comments', 'action' => 'index', 'prefix' => 'admin'), array('escape' => false)); ?>
        </td>
    </tr>
</table>

	<?php 
	echo $form->create('Comment', array('action' => 'edit')); 
	echo '<fieldset><legend>Informations à remplir</legend>';
	
	echo $form->input('id', array('type'=>'hidden'));
	
	echo $form->input('User.login', array('label' => 'Nom d\'utilisateur', 'readonly' => true));

	echo $form->input('thumb', array('label' => 'Avis', 'options' => array(
					'up' => 'Favorable',
					'neutral' => 'Neutre',
					'down' => 'Défavorable')));

	echo $form->input('text', array('label' => 'Texte avis', 'rows'=>5, 'cols'=>50));

    echo $form->input('article_id', array('label' => 'identifiant article'));
	
	echo $form->input('show_id', array('label' => 'Série :', 'type'=>'select'));
	$options = array('url' => array('controller' => 'comments', 'action' => 'changeshowedit', 'prefix' => 'admin'), 
			'update' => 'showDataChange');
    echo $ajax->observeField('CommentShowId', $options);
	
	echo '<div id="showDataChange">';
	echo $form->input('season_id', array('label' => 'Saison :','type'=>'select', 'empty' => '(Aucun épisode)'));
	$options = array('url' => array('controller' => 'comments', 'action' => 'changeseasonedit', 'prefix' => 'admin'), 
			'update' => 'episodeId');
    echo $ajax->observeField('CommentSeasonId', $options);
    
	echo '<div id="episodeId">'.$form->input('episode_id', array('label' => 'Episode :', 'type'=>'select', 'empty' => '(Aucun épisode)')).'</div>';
	echo '</div>';
	
	
    echo $form->end('Modifier');
	echo '</fieldset>';
	?>
