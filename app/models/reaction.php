<?php
class Reaction extends AppModel {
	
	var $name = "Reaction";
	
	var $belongsTo = array('Comment', 'User');
	
	var $order = "Reaction.id ASC";
	
	var $paginate = array(
        'limit' => 10
    );

}
?>
