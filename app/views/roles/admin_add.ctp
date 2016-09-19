<table class="toolbar">
	<tr>
    	<td><h1>Ajouter un rôle</h1></td>
    	<td width="40" class="center">
		<?php echo $html->link($html->image('icons/cancel.png') . '<br />Annuler', array('controller' => 'roles', 'action' => 'index', 'prefix' => 'admin'), array('escape' => false)); ?>
        </td>
    </tr>
</table>

	<?php 
	
	echo $form->create('Role');
	echo '<fieldset><legend>Informations à remplir </legend>';
	
	echo $form->input('name', array('label' => 'Prénom &amp; nom :', 'size' => '23'));
	echo $form->input('show_id', array('label' => 'Série :', 'size' => '7'));
	echo $form->input('actor_id', array('label' => 'Acteur :'));
	
    echo $form->end('Ajouter');
	echo '</fieldset>';
	
	?>