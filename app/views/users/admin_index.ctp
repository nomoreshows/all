
<table class="toolbar">
	<tr>
    	<td><h1 class="green">Les utilisateurs</h1></td>
    	<td width="50" class="center">
		<?php echo $html->link($html->image('icons/add.png') . '<br />Ajouter', array('controller' => 'users', 'action' => 'add', 'prefix' => 'admin'), array('escape' => false)); ?>
        </td>
        <!-- <td width="40" class="center">
		<?php // echo $html->link($html->image('icons/categories.png') . 'Metiers', array('controller' => 'users', 'action' => 'ajoutmetier', 'prefix' => 'admin'), array('escape' => false)); ?> 
        </td> -->
    </tr>
</table>
<br />

<?php
    echo $form->create('User', array('action' => 'temp')); 
	echo $form->input('user_id', array( 'type' => 'select', 'label' => 'Choisissez un utilisateur : '));
	
    echo $form->end('OK');

?>
