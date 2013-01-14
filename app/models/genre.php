<?php
class Genre extends AppModel {
	
	var $name = "Genre";
	
	var $hasAndBelongsToMany = 'Show';
	
	var $order = 'Genre.name ASC';

}
?>
