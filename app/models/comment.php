<?php
class Comment extends AppModel {
	
	var $name = "Comment";
	
	var $belongsTo = array('Article', 'User', 'Show', 'Season', 'Episode');
	var $hasMany = array('Reaction' => array('dependent'    => true));
		
	var $paginate = array(
        'limit' => 15,
        'order' => 'Comment.id DESC'
    );

}
?>
