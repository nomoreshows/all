<?php
class Paragraph extends AppModel {
	
	var $name = "Paragraph";
	
	var $belongsTo = 'Article';
	
	var $order = "Paragraph.numero ASC";
	
	var $actsAs = array(
    'MeioUpload' => array (
        'picture' => array (
            'dir' => 'img/article',
            'create_directory' => true,
            'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'),
            'allowed_ext' => array('.jpg', '.jpeg', '.png', '.gif'),
			'default' => 'default.jpg'
        ),
		'video' => array (
            'dir' => 'video/article',
			'allowed_mime' => array('video/x-flv'),
            'create_directory' => true,
            'allowed_ext' => array('.flv')
        )
    )
	);


}
?>
