<table class="toolbar">
	<tr>
    	<td><h1>Ajouter un genre</h1></td>
    	<td width="40" class="center">
		<?php echo $html->link($html->image('icons/cancel.png') . '<br />Annuler', array('controller' => 'genre', 'action' => 'index', 'prefix' => 'admin'), array('escape' => false)); ?>
        </td>
    </tr>
</table>

	<?php 
	
	echo $form->create('Genre'); 
	echo '<fieldset><legend>Informations à remplir </legend>';
	
	echo $form->input('name', array('label' => 'Intitulé :<br /><span class="notes">(ex : science-fiction)</span>'));
	
    echo $form->end('Ajouter');
	echo '</fieldset>';
	?>