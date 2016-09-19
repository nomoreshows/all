<?php

class Actor extends AppModel {
	
    var $name = 'Actor';   
    var $hasMany = 'Role';
	
	var $actsAs = array(
    'MeioUpload' => array (
        'picture' => array (
            'dir' => 'img/{model}/{field}',
            'create_directory' => true,
            'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'),
            'allowed_ext' => array('.jpg', '.jpeg', '.png', '.gif'),
        )
    )
	);
	
	var $validate = array(
		'picture' => array(
			'Empty' => array(
				'check' => false
			),
			'InvalidExt' => array(
				'message' => 'Extension non valide.'
			)
		)
	);

	var $order = "Actor.name ASC";
}
?>