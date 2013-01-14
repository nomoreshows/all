<?php
class Artist extends AppModel {
	
	var $name = 'Artist';
	var $hasAndBelongsToMany = array('Genre', 'Festival', 'Day');
	var $belongsTo = array('Country');
	
	var $actsAs = array(
		'Translate' => array(
			'bio' => 'Biographies'
		), 'ExtendAssociations'
	);

}