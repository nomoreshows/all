<?php
class Article extends AppModel {
	
	var $name = "Article";
	
	var $belongsTo = array('User', 'Show', 'Season', 'Episode', 'Role', 'Actor');
	var $hasMany = array('Comment');
	
	var $order = "Article.id DESC";
	
	var $paginate = array(
        'limit' => 6,
        'order' => array(
            'Article.id' => 'desc'
        )
    );
	
	var $actsAs = array(
    'MeioUpload' => array (
        'photo' => array (
            'dir' => 'img/article',
            'create_directory' => true,
            'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'),
            'allowed_ext' => array('.jpg', '.jpeg', '.png', '.gif'),
			'max_size' => '4 Mb',
			'thumbsizes' => array(
                'news' => array('width'=> 78, 'height' => 78),
            )
        ),
    ), 'Containable',
	);
	
}	
?>
