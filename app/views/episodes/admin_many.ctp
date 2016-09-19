<table class="toolbar">
	<tr>
    	<td><h1>Ajouter plusieurs saisons à <?php echo $show['Show']['name']; ?></h1></td>
    	<td width="40" class="center">
		<?php echo $html->link($html->image('icons/cancel.png') . '<br />Annuler', array('controller' => 'episodes', 'action' => 'liste', 'prefix' => 'admin', $show['Show']['id']), array('escape' => false)); ?>
        </td>
    </tr>
</table>

	<?php 
	
	echo $ajax->form('Episode', 'post', array('model' => 'Episode', 'url' => array('controller' => 'episodes', 'action' => 'adds'), 'update' => 'tableau'));
	echo '<fieldset><legend>Informations à remplir </legend>';
	
	echo $form->input('nb', array('label' => 'Nombre d\'épisodes :'));
	echo $form->input('season_id', array( 'type' => 'select', 'label' => 'Saison :'));
	
	echo $form->input('show_id', array('type'=>'hidden', 'value' => $show['Show']['id'])); 
	
	echo '<span class="notes">A utiliser uniquement si aucun épisode de la saison n\'a déjà été créé.</span>';
    echo $form->end('Suivant');
	echo '</fieldset>';

	?>
	
    <div id="tableau">
    
    </div>