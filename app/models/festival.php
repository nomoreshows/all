<?php
class Festival extends AppModel {
	
	var $name = 'Festival';
	var $belongsTo = array('Country', 'Region');
	var $hasAndBelongsToMany = array('Genre', 'Artist');
	var $hasMany = array('Day');
	
	
	var $actsAs = array(
    'MeioUpload' => array (
        'photo_c' => array (
            'dir' => 'img/festival',
            'create_directory' => true,
            'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'),
            'allowed_ext' => array('.jpg', '.jpeg', '.png', '.gif'),
			'max_size' => '4 Mb',
			'thumbsizes' => array(
                'festival' => array('width'=> 100, 'height' => 100),
            )
        ),
		'photo_r' => array (
            'dir' => 'img/festival',
            'create_directory' => true,
            'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'),
            'allowed_ext' => array('.jpg', '.jpeg', '.png', '.gif'),
			'max_size' => '4 Mb',
			'thumbsizes' => array(
                'festival' => array('width'=> 555, 'height' => 500),
            )
        ),
		'affiche' => array (
            'dir' => 'img/affiche',
            'create_directory' => true,
            'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'),
            'allowed_ext' => array('.jpg', '.jpeg', '.png', '.gif'),
			'max_size' => '4 Mb',
			'thumbsizes' => array(
                'festival' => array('width'=> 250, 'height' => 250),
            )
        )
    ), 
	'Containable',
	'Translate' => array(
		'bio' => 'Biographies'
	), 
	'ExtendAssociations'
	);

}