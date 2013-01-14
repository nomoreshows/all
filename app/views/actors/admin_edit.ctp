<table class="toolbar">
	<tr>
    	<td><h1>Modifier un acteur</h1></td>
    	<td width="40" class="center">
		<?php echo $html->link($html->image('icons/cancel.png') . '<br />Annuler', array('controller' => 'actors', 'action' => 'index', 'prefix' => 'admin'), array('escape' => false)); ?>
        </td>
    </tr>
</table>

	<?php 
	
	echo $form->create('Actor', array('type' => 'file'));
	echo '<fieldset><legend>Informations à remplir </legend>';
	echo $form->input('id', array('type'=>'hidden'));
	
	echo $form->input('name', array('label' => 'Nom &amp; Prénom :', 'size' => '23'));
	echo $form->input('datenaiss', array('label' => 'Date de naissance :', 'dateFormat' => 'DMY', 'minYear' => date('Y') - 90, 'maxYear' => date('Y')));
	echo $form->input('lieunaiss', array('label' => 'Lieu de naissance :', 'size' => '23'));
	
	if ($data['Actor']['picture'] != '') {
		// AFFICHAGE DE L'IMAGE ET SUPPRESSION
		echo '
		<div class="input file">
		<label for="currentpicture"></label>
		';
		echo $html->image('actor/picture/' . $data['Actor']['picture'], array('height' => '100', 'id' => 'currentpicture'));
		echo '
		</div>
		';
		echo $form->input('Actor.picture.remove', array('type' => 'checkbox', 'value' => 'false', 'label' => 'Supprimer la photo :'));
	}
	
	echo $form->input('picture', array('type' => 'file', 'label' => 'Photo :<br /><span class="notes">(JPG ou PNG, format carré, 100px)</span>'));
    echo $form->end('Modifier');
	echo '</fieldset>';
	
	?>