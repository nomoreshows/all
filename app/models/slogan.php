<?php
class Slogan extends AppModel {
	
	var $name = 'Slogan';
	


	var $validate = array(
		'name' => array(
			'rule' => array('minLength', 3),
			'required' => true,
			'allowEmpty' => false,
			'message' => 'Doit être renseigné.'
		)
	);

	
}