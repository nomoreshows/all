<table class="toolbar">
	<tr>
    	<td><h1>Ajouter plusieurs acteurs</h1></td>
    	<td width="40" class="center">
		<?php echo $html->link($html->image('icons/cancel.png') . '<br />Annuler', array('controller' => 'actors', 'action' => 'index', 'prefix' => 'admin'), array('escape' => false)); ?>
        </td>
    </tr>
</table>

	<?php 
	
	echo $ajax->form('Actor', 'post', array('model' => 'Actor', 'url' => array('controller' => 'actors', 'action' => 'adds'), 'update' => 'tableau'));
	echo '<fieldset><legend>Informations à remplir </legend>';
	
	echo $form->input('nb', array('label' => 'Nombre d\'acteurs :', 'size' => '5'));
	
    echo $form->end('Suivant');
	echo '</fieldset>';

	?>
	
    <div id="tableau">
    
    </div>