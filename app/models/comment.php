<?php
class Comment extends AppModel {
	
	var $name = "Comment";
	
	var $belongsTo = array('Article', 'User', 'Show', 'Season', 'Episode');
	var $hasMany = array('Reaction');
		
	var $paginate = array(
        'limit' => 15,
        'order' => 'Comment.id DESC'
    );

}
?>
