<table class="toolbar">
	<tr>
    	<td><h1>Ajouter plusieurs saisons</h1></td>
    	<td width="40" class="center">
		<?php echo $html->link($html->image('icons/cancel.png') . '<br />Annuler', array('controller' => 'seasons', 'action' => 'index', 'prefix' => 'admin'), array('escape' => false)); ?>
        </td>
    </tr>
</table>

	<?php 
	
	echo $ajax->form('Season', 'post', array('model' => 'Season', 'url' => array('controller' => 'seasons', 'action' => 'adds'), 'update' => 'tableau'));
	echo '<fieldset><legend>Informations à remplir </legend>';
	
	echo $form->input('nb', array('label' => 'Nombre de saisons :'));
	echo $form->input('show_id', array( 'type' => 'select', 'label' => 'Série :'));
	
	echo '<span class="notes">A utiliser uniquement si aucune saison de la série n\'a déjà été créé.</span>';
    echo $form->end('Suivant');
	echo '</fieldset>';

	?>
	
    <div id="tableau">
    
    </div>