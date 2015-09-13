
<table class="toolbar">
	<tr>
    	<td><h1>Modifier un commentaire</h1></td>

    	<td width="50" class="center">
		<?php echo $html->link($html->image('icons/cancel.png') . '<br />Annuler', array('controller' => 'comments', 'action' => 'index', 'prefix' => 'admin'), array('escape' => false)); ?>
        </td>
    </tr>
</table>

	<?php 
	echo $form->create('Reaction', array('action' => 'edit')); 
	echo '<fieldset><legend>Informations à remplir</legend>';
	
	echo $form->input('id', array('type'=>'hidden'));
	
	echo $form->input('User.login', array('label' => 'Nom d\'utilisateur', 'readonly' => true));

	echo $form->input('text', array('label' => 'Texte réaction', 'rows'=>5, 'cols'=>50));

    echo $form->input('comment_id', array('label' => 'identifiant commentaire'));
	
    echo $form->end('Modifier');
	echo '</fieldset>';
	?>
