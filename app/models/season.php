<?php
class Season extends AppModel {
	
	var $name = "Season";
	
	var $belongsTo = 'Show';
	var $hasMany = array('Episode','Rate', 'Comment', 'Article');
	
	var $order = "Season.name ASC";
	
	

}
?>
