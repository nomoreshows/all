<?php

class Option extends AppModel {
	
    var $name = 'Option';   
	
	var $actsAs = array(
    'MeioUpload' => array (
        'img1' => array (
            'dir' => 'img/header',
            'create_directory' => true,
            'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'),
            'allowed_ext' => array('.jpg', '.jpeg', '.png', '.gif', '.pdf', '.JPG', '.PNG', '.GIF', '.JPEG'),
        ),
		'img2' => array (
            'dir' => 'img/header',
            'create_directory' => true,
            'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'),
            'allowed_ext' => array('.jpg', '.jpeg', '.png', '.gif', '.pdf', '.JPG', '.PNG', '.GIF', '.JPEG'),
        ),
		'img3' => array (
            'dir' => 'img/header',
            'create_directory' => true,
            'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'),
            'allowed_ext' => array('.jpg', '.jpeg', '.png', '.gif', '.pdf', '.JPG', '.PNG', '.GIF', '.JPEG'),
        )
    )
	);
	
	var $validate = array(
		'img1' => array(
			'Empty' => array(
				'check' => false
			),
			'InvalidExt' => array(
				'message' => 'Extension non valide.'
			)
		),
		'img2' => array(
			'Empty' => array(
				'check' => false
			),
			'InvalidExt' => array(
				'message' => 'Extension non valide.'
			)
		),
		'im31' => array(
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