<table class="toolbar">
	<tr>
    	<td><h1>Ajouter plusieurs rôles</h1></td>
    	<td width="40" class="center">
		<?php echo $html->link($html->image('icons/cancel.png') . '<br />Annuler', array('controller' => 'roles', 'action' => 'index', 'prefix' => 'admin'), array('escape' => false)); ?>
        </td>
    </tr>
</table>

	<?php 
	
	echo $ajax->form('Role', 'post', array('model' => 'Role', 'url' => array('controller' => 'roles', 'action' => 'adds'), 'update' => 'tableau'));
	echo '<fieldset><legend>Informations à remplir </legend>';
	
	echo $form->input('nb', array('label' => 'Nombre de rôles :', 'size' => '5'));
	echo $form->input('show_id', array('label' => 'Série :', 'size' => '7'));
	
    echo $form->end('Suivant');
	echo '</fieldset>';

	?>
	
    <div id="tableau">
    
    </div>