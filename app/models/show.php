<?php
class Show extends AppModel {
	
	var $name = "Show";
	
	var $hasMany = array('Season','Role','Rate', 'Comment', 'Article');
	var $belongsTo = array('User');
	/* var $hasAndBelongsToMany = array(
        'User' =>
            array(
                'className'              => 'User',
                'joinTable'              => 'shows_users',
                'foreignKey'             => 'user_id',
                'associationForeignKey'  => 'show_id'
            ),
		'User' =>
            array(
                'className'              => 'User',
                'joinTable'              => 'shows_liste',
                'foreignKey'             => 'user_id',
                'associationForeignKey'  => 'show_id'
            ),
		'Genre'
    ); */
	var $hasAndBelongsToMany = array('User' => array('with' => 'Followedshows'), 'Genre');
	
	var $order = "Show.name ASC";
	
	var $actsAs = array('ExtendAssociations', 'Containable'); 
	
	
	/*var $actsAs = array(
    'MeioUpload' => array (
        'picture1' => array (
            'dir' => 'img/show',
            'create_directory' => true,
            'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'),
            'allowed_ext' => array('.jpg', '.jpeg', '.png', '.gif'),
			'max_size' => '4 Mb',
			'thumbsizes' => array(
                'serie' => array('width'=> 139, 'height' => 67)
            )
        ),
		 'picture2' => array (
            'dir' => 'img/show',
            'create_directory' => true,
            'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'),
            'allowed_ext' => array('.jpg', '.jpeg', '.png', '.gif'),
			'max_size' => '4 Mb',
			'thumbsizes' => array(
                'news' => array('width'=> 78, 'height' => 78),
				'caption' => array('width'=> 38, 'height' => 38)
            )
        )
    )
	);*/
}
?>
