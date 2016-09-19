<table class="toolbar">
	<tr>
    	<td><h1>Modifier un sondage</h1></td>
    	<td width="40" class="center">
		<?php echo $html->link($html->image('icons/cancel.png') . '<br />Annuler', array('controller' => 'polls', 'action' => 'index', 'prefix' => 'admin'), array('escape' => false)); ?>
        </td>
    </tr>
</table>

	<?php 
	
	echo $form->create('Poll'); 
	echo '<fieldset><legend>Informations à remplir </legend>';
	echo $form->input('id', array('type'=>'hidden'));
	
	echo $form->input('name', array('label' => 'Titre :<br /><span class="notes">(ex : Meilleur drama)</span>'));
			
    echo $form->end('Modifier');
	echo '</fieldset>';
	?>