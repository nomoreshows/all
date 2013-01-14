<?php

class Upload extends AppModel {
	
    var $name = 'Upload';   
	
	var $actsAs = array(
    'MeioUpload' => array (
        'name' => array (
            'dir' => 'img/article',
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

}
?>