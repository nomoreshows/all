<table class="toolbar">
	<tr>
    	<td><h1>Modifier un épisode</h1></td>
    	<td width="40" class="center">
		<?php echo $html->link($html->image('icons/cancel.png') . '<br />Annuler', array('controller' => 'seasons', 'action' => 'index', 'prefix' => 'admin'), array('escape' => false)); ?>
        </td>
    </tr>
</table>

	<?php 
	
	echo $form->create('Episode'); 
	echo '<fieldset><legend>Informations à remplir </legend>';
	
	echo $form->input('name', array('label' => 'Titre (VO):', 'size' => '30'));
	echo $form->input('titrefr', array('label' => 'Titre (VF):', 'size' => '30'));
	echo $form->input('season_id', array( 'type' => 'select', 'label' => 'Saison :', 'empty' => '-- Choisir --'));
	echo $form->input('numero', array('label' => 'Numéro épisode :', 'size' => '2'));
	
	echo $form->input('diffusionus', array('label' => 'Diffusion US :' , 'dateFormat' => 'DMY', 'minYear' => date('Y') - 70, 'maxYear' => date('Y') + 2 ));
	echo $form->input('diffusionfr', array('label' => 'Diffusion FR :', 'dateFormat' => 'DMY', 'minYear' => date('Y') - 70, 'maxYear' => date('Y') + 2 ));
	echo $form->input('guests', array('label' => 'Guests<br /><span class="notes">(séparés par virgule)</span>:', 'size' => '50'));
	echo $form->input('ba', array('label' => ' :BO <br /><span class="notes">(copier le code &lt;embed&gt; d\'une playlist Deezer)', 'cols' => '65'));
	echo $form->input('bo', array('label' => 'Trailer :<br /><span class="notes">(copier le code &lt;embed&gt; d\'une video Youtube)', 'cols' => '65'));
	
	echo $form->input('resume', array('label' => 'Résumé :<br /><span class="notes">environ 3 lignes. pas de gros spoilers</span>', 'cols' => '65'));
	echo $form->input('particularite', array('label' => 'Particularité :<br /><span class="notes">spécifique à l\'épisode</span>', 'cols' => '65'));
	echo $form->input('id', array('type'=>'hidden'));

    echo $form->end('Ajouter');
	echo '</fieldset>';
	
	//debug($shows);
	?>