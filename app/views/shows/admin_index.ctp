
<table class="toolbar">
	<tr>
    	<td><h1 class="green">Les séries</h1></td>
    	<td width="40" class="center">
		<?php echo $html->link($html->image('icons/add.png') . '<br />Ajouter', array('controller' => 'shows', 'action' => 'add', 'prefix' => 'admin'), array('escape' => false)); ?>
        </td>
    </tr>
</table>


<?php
    echo $form->create('Show', array('action' => 'temp')); 
	echo $form->input('show_id', array( 'type' => 'select', 'label' => 'Choisissez une série à modifier :'));
	
    echo $form->end('OK');

	?>
