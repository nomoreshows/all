<table class="toolbar">
	<tr>
    	<td><h1>Ajouter un acteur</h1></td>
    	<td width="40" class="center">
		<?php echo $html->link($html->image('icons/cancel.png') . '<br />Annuler', array('controller' => 'actors', 'action' => 'index', 'prefix' => 'admin'), array('escape' => false)); ?>
        </td>
    </tr>
</table>

	<?php 
	
	echo $form->create('Actor', array('type' => 'file'));
	echo '<fieldset><legend>Informations à remplir </legend>';
	
	echo $form->input('name', array('label' => 'Nom &amp; Prénom :', 'size' => '23'));
	echo $form->input('datenaiss', array('label' => 'Date de naissance :', 'selected' => '2000-01-01', 'dateFormat' => 'DMY', 'minYear' => date('Y') - 90, 'maxYear' => date('Y')));
	echo $form->input('lieunaiss', array('label' => 'Lieu de naissance :', 'size' => '23'));
	
	echo $form->input('picture', array('type' => 'file', 'label' => 'Photo :<br /><span class="notes">(JPG ou PNG, format carré, 100px)</span>'));
    echo $form->end('Ajouter');
	echo '</fieldset>';
	
	?>