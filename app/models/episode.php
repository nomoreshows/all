<?php
class Episode extends AppModel {
	
	var $name = "Episode";
	
	var $hasMany = array('Rate', 'Comment', 'Article', 'Quote');
	var $belongsTo = 'Season';
	
	var $order = array("Season.id" => "asc", "Episode.numero" => "ASC");
	var $actsAs = array('Containable');

}
?>
