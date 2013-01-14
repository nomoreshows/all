<?php
class Region extends AppModel {
	
	var $name = 'Region';
	var $hasMany = array('Festival');
	var $belongsTo = array('Country');

	var $order = 'Region.name ASC';
}