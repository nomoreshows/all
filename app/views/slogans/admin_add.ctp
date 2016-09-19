<table class="toolbar">
	<tr>
    	<td><h1>Ajouter un slogan</h1></td>
    	<td width="40" class="center">
		<?php echo $html->link($html->image('icons/cancel.png') . '<br />Annuler', array('controller' => 'slogans', 'action' => 'index', 'prefix' => 'admin'), array('escape' => false)); ?>
        </td>
    </tr>
</table>

	<?php 
	
	echo $form->create('Slogan'); 
	echo '<fieldset><legend>Informations à remplir </legend>';
	
	echo $form->input('name', array('label' => 'Slogan :'));
	echo $form->input('source', array('label' => 'Source :<br /><span class="notes">(ex : South Park, Air France...)</span>'));
	echo $form->input('url', array('label' => 'URL :<br /><span class="notes">(ex : http://www.youtube.com/watch?v=0NCQQH8h3ms)</span>'));
	
    echo $form->end('Ajouter');
	echo '</fieldset>';
	?>