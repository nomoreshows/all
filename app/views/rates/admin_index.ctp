
<?php
    echo $form->create('Rate', array('action' => 'searchresult')); 
	echo '<fieldset><legend>Rechercher une note d\'un utilisateur </legend>';
	echo $form->input('user_id', array( 'type' => 'select', 'label' => 'Choisissez un utilisateur : '));
	
    echo $form->end('OK');

?>
