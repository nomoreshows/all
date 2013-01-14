
<table class="toolbar">
	<tr>
    	<td><h1 class="green">Les épisodes</h1></td>
    	<td width="40" class="center">
		
        </td>
    </tr>
</table>

    <?php
    echo $form->create('Episode', array('action' => 'temp')); 
	echo $form->input('show_id', array( 'type' => 'select', 'label' => 'Choisissez une série :'));
	
    echo $form->end('OK');

	?>
