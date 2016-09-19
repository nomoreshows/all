<table class="toolbar">
	<tr>
    	<td><h1>Ajouter une saison</h1></td>
    	<td width="40" class="center">
		<?php echo $html->link($html->image('icons/cancel.png') . '<br />Annuler', array('controller' => 'seasons', 'action' => 'index', 'prefix' => 'admin'), array('escape' => false)); ?>
        </td>
    </tr>
</table>

	<?php 
	
	echo $form->create('Season'); 
	echo '<fieldset><legend>Informations à remplir </legend>';
	
	echo $form->input('name', array('label' => 'Saison numéro :'));
	echo $form->input('show_id', array( 'type' => 'select', 'label' => 'Série :'));
	
	echo $form->input('ba', array('label' => 'Bande annonce :<br /><span class="notes">(copier le code &lt;embed&gt; d\'une vidéo Youtube)</span>', 'cols' => '65',));
	echo $form->input('bo', array('label' => 'BO :<br /><span class="notes">(copier le code &lt;embed&gt; d\'une playlist Deezer)', 'cols' => '65',));
	
    echo $form->end('Ajouter');
	echo '</fieldset>';
	
	?>